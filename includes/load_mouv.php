<?php
include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start();
if (login_check($mysqli) == true){
	$username = $_SESSION['username'];
	$stmt = $mysqli->query("SELECT graph_rafraich, enreg, alert FROM mouvement_pir WHERE owner='$username'");
	$arr = $stmt->fetch_array(MYSQLI_ASSOC);

	$mysqli->close();
	$fileContent = file_get_contents('/var/smartcontrol_sensor_data/pir_sensor.data');
	$fileContent = '{"data":'.$fileContent.'}';
	$row_data = array ( $arr['graph_rafraich'], $arr['enreg'], $arr['alert'], $fileContent );
	echo json_encode($row_data);
}
else {
header("Location: ../index.php");
}
?>

