<?php
include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';
 
sec_session_start();
?>
<?php if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.css">
		<link rel="stylesheet" type="text/css" href="css/jquery.ui.timepicker.css">
		<link rel="stylesheet" type="text/css" href="css/site.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Controle de l'éclairage</title>
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
			<h1>Controle éclairage</h1>
			<!-- checkbox on/off --> 
			<div class="onoffswitch">
				<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" >
				<label class="onoffswitch-label" for="myonoffswitch">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
			<br>
			
			<!-- Onglets --> 
			<div id="myTabs">
				<ul>
				<!-- titres des onglets -->
				<li><a href="#a">Leds couleur</a></li>
				<li><a href="#b">Leds effet</a></li>
				<li><a href="#c">Leds timer</a></li>
				</ul>
				<!-- 1er onglet -->
				<div id="a">
					<!-- sliders -->
					<div id="container_led1">
					  <label id="outputLabel">Changer la couleur:</label>
					  <br>
					  <table id="table_led1">
						<tr>
						  <td><label>R:</label></td>
						  <td><div id="rSlider"></div></td>
						<tr>
						</tr>
						  <td><label>G:</label></td>
						  <td><div id="gSlider"></div></td>
						<tr>
						</tr>
						  <td><label>B:</label></td>
						  <td><div id="bSlider"></td>
						</tr>
					  </table>
					  <div id="colorBox"></div>
					</div>
				</div>
				<!-- fin du 1er onglet -->
				<!-- 2eme onglet -->
				<div id="b">
					<div id="container_led2">
					<label id="outputLabel">Sélectionner un effet:</label>
					<br>
						<table id="table_led2">
						<tr>
							<td><input type="radio" name="effets" id="effet1" class="radio-box" /><label for="effet1" class="radio-label">Effet 1</label></td>
							<td><input type="radio" name="effets" id="effet2" class="radio-box"/><label for="effet2" class="radio-label">Effet 2</label></td>
							<td><input type="radio" name="effets" id="effet3" class="radio-box"/><label for="effet3" class="radio-label">Effet 3</label></td>
						</tr>
						<tr>
							<td><input type="radio" name="effets" id="effet4" class="radio-box" /><label for="effet4" class="radio-label">Effet 4</label></td>
							<td><input type="radio" name="effets" id="effet5" class="radio-box"/><label for="effet5" class="radio-label">Effet 5</label></td>
							<td><input type="radio" name="effets" id="effet6" class="radio-box"/><label for="effet6" class="radio-label">Effet 6</label></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="radio" name="effets" id="effetstop" class="radio-box"/><label for="effetstop" class="radio-label">Stop</label></td>
							<td></td>
						</table>
					</div>						
				</div>
				<!-- fin du 2eme onglet -->
				<!-- 3eme onglet -->
				<div id="c">
					<div id="container_led3">
						<label id="outputLabel">Placer un timer:</label>
						<br>
						<table id="table_led3">
						<tr>
							<td><label for="timepicker_deb">Début:</label></td>
							<td><input type="text" id="timepicker_deb" value=""/></td>
						</tr>
						<tr>
							<td><label for="timepicker_fin">Fin:</label></td>
							<td><input type="text" id="timepicker_fin" value=""/></td>
						</tr>
						</table>
						<button id="but_efface" >Effacer</button>
						<button id="but_enregistre" >Enregistrer</button>
					</div>
					<br>
					<div id="list-timer">
						<table id="table_led_list_timer">
						<tr>
							<th>Début</th>
							<th>Fin</th>
							<th>E-mail</th>
							<th>Suppr</th>
						</tr>
						<tr>
							<td><div id="heure_deb"></div></td>
							<td><div id="heure_fin"></div></td>
							<td><input type="checkbox" name="email" id="email" /></td>
							<td><button id="icon_eraser" ></button></td>
						</tr>
						</table>
					</div>
				</div>
				<!-- fin du 3eme onglet -->
			</div>
		</section>
		<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
		<script type="text/javascript" src="js/load_rgb.js"></script>
  </body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>