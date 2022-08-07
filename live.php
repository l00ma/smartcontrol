<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start();
?>
<?php if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camera en direct</title>
		<link rel="stylesheet" href="css/site.css" />
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
		<h1>Caméra en direct</h1>
		<div id="container_live">
			<img src="/6WEaOl5igMQ0fzXTbMPM2IPrEqh6Fujz/1" alt="Smart Control liveCam">
		</div>
	</section>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/live.js"></script>
    </body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>