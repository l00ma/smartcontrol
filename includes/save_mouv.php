<?php
include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';
 
sec_session_start();
if (login_check($mysqli) == true){
	if (isset($_GET['save']) && !empty($_GET['save'])) {
		$tab_save = explode (",", $_GET['save']);
		for ( $i=0; $i<count($tab_save); $i++ ) {
			$graph_rafraich = $tab_save[0];
			$enreg = $tab_save[1];
			$alert = $tab_save[2];
		}
	}
	if ( $graph_rafraich < 5 || $graph_rafraich > 15) { $graph_rafraich = 5; }
	if ( $enreg < 0 || $enreg > 1) { $enreg = 0; }
	if ( $alert < 0 || $alert > 1) { $alert = 0; }
	
	$username = $_SESSION['username'];
	$stmt = $mysqli->prepare("UPDATE mouvement_pir SET graph_rafraich=?, enreg=?, alert=? WHERE owner='$username'");
	$stmt->bind_param('iii', $graph_rafraich, $enreg, $alert );
	$stmt->execute(); 
	$mysqli->close();
}
else {
header("Location: ../index.php");
}
?>
