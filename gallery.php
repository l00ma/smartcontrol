<?php
include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';
sec_session_start();
if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Vidéos enregistrées</title>
		<link rel="stylesheet" href="css/site.css">
	</head>
	<body>
	<header>
		<span id="logo"><img src="css/images/raspberry_petit.png" alt="L" height="26" width="29"> Smart Control </span>
		<span id="bar"></span>
		<span id="menu_haut">
			<button id="but_all" title="Sélectionner toutes les vidéos" >Toutes</button>
			<button id="but_none" title="Désélectionner toutes les vidéos" >Aucune</button>
			<button id="but_download" title="Télécharger les vidéos sélectionnées" >Télécharger</button>
			<button id="but_supprime" title="Supprimer les vidéos sélectionnées" >Supprimer</button>
			<button id="but_menu" title="Retour au menu" >Menu</button>
			<button id="but_logout" title="Se déconnecter" >Déconnexion</button>
		</span>
	</header>
	<section>
		<div id='cadre_foreground'></div>
		<br><br>
		<table id="tableau">
		<?php
			$nbColonne = 4;
			$colonneSaut = 0;
			echo '<tr>';
			$stmt = $mysqli->query("SELECT id, filename FROM security WHERE file_type=8 ORDER BY id DESC");
			while($row = $stmt->fetch_array(MYSQLI_ASSOC)){
			    $chemin_video = substr($row['filename'], 22);
				$nom_video = substr($row['filename'], 33);
				$chemin_image = preg_replace("/.mp4$/", '.jpg', $chemin_video);
				$nom_image = preg_replace("/_event\d+.mp4$/", '', $nom_video);
				if ($colonneSaut != 0 && $colonneSaut % $nbColonne == 0) {
					echo '</tr><tr>';
				}
				echo '<td><a href="player.php?event='.$nom_video.'&id='.$row['id'].'"><img src='.$chemin_image.' / alt="Vidéo en cours de création..."></a><br><span class="nom">'.$nom_image.'</span><input type="checkbox" class="video_select" data-url="'.'../'.$chemin_video.'" data-id_nb="'.$row['id'].'"></td>';
				$colonneSaut++;			
			}
			echo '</tr>';
		?>
		</table>
	</section>
	<script type="text/javascript">
		var challenge = '<?php echo $_SESSION["login_string"]; ?>';
	</script>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/gallery.js"></script>
	<script type="text/javascript" src="js/jszip.min.js"></script>
	<script type="text/javascript" src="js/jszip-utils.js"></script>
	<script type="text/javascript" src="js/FileSaver.js"></script>
    </body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>