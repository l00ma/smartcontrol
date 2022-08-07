#!/usr/bin/perl

use strict;
use warnings;
use CGI;
use DBI;
use PHP::Session;
use AppConfig qw(:expand :argcount);

#Initialisation de la configuration
my $config = AppConfig->new(	
				"gpio_detection"    	=> {ARGCOUNT => ARGCOUNT_NONE},
				"gpio_red"    		=> {ARGCOUNT => ARGCOUNT_NONE},
				"gpio_green"    	=> {ARGCOUNT => ARGCOUNT_NONE},
				"gpio_blue"    		=> {ARGCOUNT => ARGCOUNT_NONE},
				"bdd_base"       	=> {ARGCOUNT => ARGCOUNT_ONE},
				"bdd_host"  		=> {ARGCOUNT => ARGCOUNT_ONE},
				"bdd_login"    		=> {ARGCOUNT => ARGCOUNT_ONE},
				"bdd_mdp"		=> {ARGCOUNT => ARGCOUNT_ONE},
				"bdd_table_member"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"bdd_table_leds"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"bdd_table_meteo"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"bdd_table_pir" 	=> {ARGCOUNT => ARGCOUNT_ONE},
				"bdd_table_security"	=> {ARGCOUNT => ARGCOUNT_ONE},
				"port" 			=> {ARGCOUNT => ARGCOUNT_ONE},
				"data_dir"		=> {ARGCOUNT => ARGCOUNT_ONE},
				"temp_pir_dir"		=> {ARGCOUNT => ARGCOUNT_NONE},
				"temp_capture_file"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"cgi_dir"		=> {ARGCOUNT => ARGCOUNT_NONE},
				"data_period"		=> {ARGCOUNT => ARGCOUNT_NONE},
				"histo_alerte_email"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"meteo_openweathermap_APPID"	=> {ARGCOUNT => ARGCOUNT_NONE},
				"meteo_openweathermap_CityID" => {ARGCOUNT => ARGCOUNT_NONE}
				);

#Lecture du fichier de configuration
$config->file('/etc/smartcontrol.conf');

#Initialisation des paramètres du daemon
my $base = $config->bdd_base();
my $host = $config->bdd_host();
my $login = $config->bdd_login();
my $mdp = $config->bdd_mdp();
my $table_pir = $config->bdd_table_pir();
my $table_securite = $config->bdd_table_security();
my $port = $config->port();

#on efface les videos
my $query = CGI->new;
my $file_id = $query->param('file_id');
my $challenge = $query->param('id_secure');
my $referer = $query->referer();
my $cookie = $query->cookie( -name => "sec_session_id" );
my $session = PHP::Session->new($cookie,{save_path => '/var/lib/php/sessions'});
my $login_string  = $session->get('login_string');

if ($referer =~/\/gallery.php$/ || $referer =~/\/player.php\?event=\d{2}-\d{2}-\d{4}_\d{2}h\d{2}m\d{2}s_event\d+\.mp4&id=\d+$/) {  
	if ($challenge eq $login_string) {
		my ($retour_erreur) = maj_bdd ($file_id);
		if ($retour_erreur == 0) { 
			print $query->header('text/plain;charset=UTF-8'); 
			print "done";
		}
		else { print $query->header('text/plain;charset=UTF-8'); print "error"; }
	}
	else { print $query->header('text/plain;charset=UTF-8'); print "error"; }
}
else { print $query->header('text/plain;charset=UTF-8'); print "error"; }

#on calucle l'espace dispo et on mets a jour la bdd
my $dispo;
my $total;

my @commande = `df /`;
foreach (@commande) {
	($total, $dispo) = $commande[1] =~/^\/dev\/root\s+(\d+)\s+\d+\s+(\d+)\s+\d+%/;
}
my $percent = sprintf ("%.1f",(100 - ($dispo * 100) / $total));
$dispo = sprintf ("%.3f", (($dispo)/1024**2));
$total = sprintf ("%.3f", (($total)/1024**2));
ask_space ($total, $dispo, $percent);

exit (1);

#demande de l'espace disque dispo
sub ask_space {
	my ($total_d, $dispo_d, $percent_d) = @_;
	my $dbd = DBI->connect("dbi:mysql:dbname=$base;host=$host;", $login, $mdp) or die ('maj_bdd : Impossible de se connecter à la base de données :'.DBI::errstr);
	my $requete = 'UPDATE '.$table_pir.' SET espace_total=\''.$total_d.'\', espace_dispo=\''.$dispo_d.'\', taux_utilisation=\''.$percent_d.'\' WHERE id=\'1\'';
	my $prep = $dbd->prepare($requete) or die('maj_bdd : Impossible de préparer la requête : '.$dbd->errstr);
	$prep->execute or die('maj_bdd : Impossible d\'exécuter la requête : '.$prep->errstr);
	$prep->finish;
	$dbd->disconnect;
}

#demande du nom de fichier à effacer + suppression dans la bdd
sub maj_bdd {
	my ($id) = @_;
	my $error = 0;
	my @tableau_ids = split (/,/ , $id);
	my $dbd = DBI->connect("dbi:mysql:dbname=$base;host=$host;", $login, $mdp) or die ('maj_bdd : Impossible de se connecter à la base de données :'.DBI::errstr);
	
	foreach my $valeur_id (@tableau_ids) {
		my $requete = 'SELECT filename FROM '.$table_securite.' WHERE id=\''.$valeur_id.'\' AND file_type = \'8\'';
		my $prep = $dbd->prepare($requete) or die('maj_bdd : Impossible de préparer la requête : '.$dbd->errstr);
		$prep->execute or logEntry('collecte_datas : Impossible d\'exécuter la requête : '.$prep->errstr);
		my @tableau_valeurs = $prep->fetchrow_array;
		$prep->finish;
		
		my $value = $tableau_valeurs[0];
		if ($value =~ /\d{2}-\d{2}-\d{4}_\d{2}h\d{2}m\d{2}s_event\d+\.mp4$/) {
			my $efface_mp4 = unlink $value;
			$value =~ s/\.mp4$/\.jpg/;
			my $efface_jpg = unlink $value;
			if (!$efface_mp4 || !$efface_jpg) {
				$error = 1; 
				$dbd->disconnect; 
				return ($error);
			}
		}
		
		$requete = 'DELETE FROM '.$table_securite.' WHERE id=\''.$valeur_id.'\'';
		$prep = $dbd->prepare($requete) or die('maj_bdd : Impossible de préparer la requête : '.$dbd->errstr);
		$prep->execute or die('maj_bdd : Impossible d\'exécuter la requête : '.$prep->errstr);
		$prep->finish;
	}
	$dbd->disconnect;

	return ($error);
}
