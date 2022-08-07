<?php
include_once '/usr/lib/includes/functions.php';
sec_session_start();
// RAZ des variables de session
$_SESSION = array();
// get des parametres de session
$params = session_get_cookie_params();
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// Destruction de session
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Smart Control: Données modifiées</title>
        <link rel="stylesheet" href="css/site.css" />
    </head>
    <body>
    <header>
	<span id="logo"><img src="css/images/raspberry_petit.png" alt="L" height="26" width="29"> Smart Control</span>
    </header>	
    <section>
	<br>
        <h1>Données modifiées avec succès.</h1>
	<p>Vous êtes à présent déconnecté.</p>
	<p>Merci de vous reconnecter avec vos nouveaux identifiants.</p> 
        <p><?php
	header( "refresh:5;url=index.php" );
	echo 'Vous allez etre redirigé dans 5 secondes. Sinon, cliquez <a href="index.php">ici</a>.';
	?></p>
    <section>
    </body>
</html>
