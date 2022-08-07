<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';


sec_session_start();
?>
<?php if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
	<head>	
		<link rel="stylesheet" href="css/site.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Suivi température</title>
	</head>
	<body>
	<header>
		<span id="logo"><img src="css/images/raspberry_petit.png" alt="L" height="26" width="29"> Smart Control</span>
		<span id="menu_haut">
			<button id="but_menu" title="Retour au menu" >Menu</button>
			<button id="but_logout" title="Se déconnecter" >Déconnexion</button>
		</span>
	</header>	
	<section>
		<br>
		<h1>Suivi des températures</h1>
		<p>Temperatures enregistrées par le capteur:</p>
		<div id="container_mouv_temp"></div>
	</section>
		<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="js/highstock.js"></script>
		<script type="text/javascript" src="js/temp.js"></script>	
	</body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>