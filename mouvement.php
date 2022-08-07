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
	<title>Détection de mouvements</title>
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
	<h1>Détection de mouvements</h1>
            <p>Activité enregistrée par le capteur:</p>
		<div id="container_mouv_temp"></div>
		<br>
		<form id="form_mouv" action="#">
			<table align="center">
				<tr>
					<td colspan ="2">
					Fréquence de rafraichissement du graph :
					<select id="refresh">
						<option>5</option>
						<option>10</option>
						<option>15</option>
					</select> minutes.
					</td>
				</tr>
				<tr>
					<td style="text-align: right;">Declencher enregistrement vidéo:</td>
					<td class="middle_button">
					<div class="enr_switch">
						<input type="checkbox" name="enr_switch" class="enr_switch-checkbox" id="myenr_switch" >
						<label class="enr_switch-label" for="myenr_switch">
							<span class="enr_switch-inner"></span>
							<span class="enr_switch-switch"></span>
						</label>
					</div>
					</td>
				</tr>
				<tr>
					<td style="text-align: right;">Declencher alerte e-mail avec photo:</td>
					<td class="middle_button">
					<div class="alrt_switch">
						<input type="checkbox" name="alrt_switch" class="alrt_switch-checkbox" id="myalrt_switch" >
						<label class="alrt_switch-label" for="myalrt_switch">
							<span class="alrt_switch-inner"></span>
							<span class="alrt_switch-switch"></span>
						</label>
					</div>
					</td>
				</tr>
			</table>
		</form>
	</section>
		<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="js/highstock.js"></script>
		<script type="text/javascript" src="js/mouv.js"></script>
	</body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>