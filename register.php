<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/register.inc.php';
include_once '/usr/lib/includes/functions.php';
 
sec_session_start();
?>
<?php if (login_check($mysqli) == true) : ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modifier mes données</title>
	<script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
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
		<h1>Modifier les données de <?php echo htmlentities($_SESSION['username']); ?>:</h1>
		<?php
		if (!empty($error_msg)) {
		    echo $error_msg;
		}
		?>
		<ul>
		    <li>Le nom d'utilisateur doit être composé de chiffres et/ou de lettres (MAJ/min) et/ou du caractère _.</li>
		    <li>L'E-mail doit être dans un format valide.</li>
		    <li>Le mot de passe doit contenir:
			<ul>
			    <li>Au minimum 6 caractères.</li>
			    <li>Au moins une lettre majuscule (A..Z).</li>
			    <li>Au moins une lettre minuscule (a..z).</li>
			    <li>Au moins un chiffre (0..9).</li>
			</ul>
		    </li>
		</ul>
		<div id= "form_modifier">
		<form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
				<table align="center" >
				<tr>
				<td>Nouveau nom d'utilisateur:</td>
				<td><input type='text' class="glowing-border"  name='username' value="<?php echo htmlentities($_SESSION['username']); ?>"/></td>
				</tr>
				<tr>
				<td>Nouvel e-mail:</td>
				<td><input type="text" class="glowing-border"  name="email" value="<?php echo htmlentities($_SESSION['email']); ?>"/></td>
				</tr>
				<tr>
				<td>Nouveau mot de passe:</td>
				<td><input type="password" class="glowing-border" name="password"/></td>
				</tr>
				<tr>
				<td>Confirmez le mot de passe:</td>
				<td><input type="password" class="glowing-border" name="confirmpwd"/></td>
				</tr>
				</table>
		    <p><button id="but_modifier" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);">Modifier</button></p>
		</form>	
		</div>
		<script>
		$(function(){
			$("#but_logout").click(function() {
				location.href='includes/logout.php';
			});
			$("#but_menu").click(function() {
				location.href='welcome.php';
			});
		});
		</script>
	</section>
    </body>
</html>
<?php else : 
header("Location: index.php");
endif; ?>