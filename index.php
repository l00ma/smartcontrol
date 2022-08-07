<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = ' id="connect" >Vous êtes <a href="welcome.php">déjà connecté</a>';
} else {
    $logged = ' id="deconnect" >Vous êtes déconnecté';
}?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Connexion</title>
		<link rel="stylesheet" href="css/site.css" />
	</head>
	<body>
	<?php
	if (isset($_GET['error'])) {
		echo '<p class="error">Erreur de connexion...</p>';
	}?>
		<div id="form_connexion">
			<form action="includes/process_login.php" method="post" name="login_form" >
				<table align="center" >
				<tr>
				<td><label for="user">Utilisateur: </label></td>
				<td><input type="text" class="glowing-border" name="user" /></td>
				</tr>
				<tr>
				<td><label for="password">Mot de passe: </label></td>
				<td><input type="password" class="glowing-border" name="password"/></td>
				</tr>
				</table>
			<p><button id="but_connexion" onclick="formhash(this.form, this.form.password);">Connexion</button></p>
			<p<?php echo $logged ?></p>
			</form>
		</div>		
	<script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
	<script language="javascript">
		document.getElementById('user').focus();
		document.onkeypress = function (e) {
			var enterpressed = e? e.which == 13: window.event.keyCode == 13;
			if (enterpressed){
				formhash(myform, myform.password);
				return false;
			}
		}
	</script>
	</body>
</html>
