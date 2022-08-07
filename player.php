<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start();
if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Lecteur vidéo</title>
		<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src='js/download.js'></script>
		<link rel="stylesheet" href="css/site.css" />
	</head>
	<body>
	<header>
		<span id="logo"><img src="css/images/raspberry_petit.png" alt="L" height="26" width="29"> Smart Control</span>
		<span id="menu_haut">
			<button id="but_download" title="Télécharger la vidéo" >Télécharger</button>
			<button id="but_supprime" title="Supprimer la vidéo" >Supprimer</button>
			<button id="but_gallery" title="Retour à la galerie des vidéos" >Galerie videos</button>
			<button id="but_menu" title="Retour au menu" >Menu</button>
			<button id="but_logout" title="Se déconnecter" >Déconnexion</button>
		</span>
	</header>
	<section>
		<br><br>
		<center>
			<video width="768" height="432" controls>
				<source src="data/image/<?php echo $_GET['event']; ?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
		</center>
		<script>
			$(function(){
				$('#but_menu').click(function() {
					location.href='welcome.php';
				});
				$("#but_logout").click(function() {
					location.href='includes/logout.php';
				});
				$("#but_gallery").click(function() {
					location.href='gallery.php';
				});
				$("#but_supprime").click(function() {
				
					if (confirm ('Voulez-vous supprimer <?php echo $_GET['event']; ?> ?')) {
						$.ajax({ 
							type:'get',
							async: false,
							url: 'cgi-bin/asuppr.cgi',
							data: {file_id: '<?php echo $_GET['id']; ?>', id_secure:'<?php echo $_SESSION["login_string"]; ?>'},
							success: function(result){
								if (result === 'done') {window.location.href = '../gallery.php'};
								if (result === 'error') {alert ('Impossible de supprimer <?php echo $_GET['event']; ?>')};
							}
							
						});
					}
					
				});
				$("#but_download").click(function() {
					if (confirm ('Voulez-vous télécharger <?php echo $_GET['event']; ?> ?')) {
						var x=new XMLHttpRequest();
						x.open('GET', 'data/image/<?php echo $_GET['event']; ?>', true);
						x.responseType = 'blob';
						x.onload=function(e){download(x.response, '<?php echo $_GET['event']; ?>', 'video/x-msvideo' ); }
						x.send();
					}
				});
			});
		</script>
	<section>
    </body>
</html>
<?php else : 
header('Location: index.php');
endif; ?>