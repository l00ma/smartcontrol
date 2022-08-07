<?php

include_once '/usr/lib/includes/db_connect.php';
include_once '/usr/lib/includes/functions.php';

sec_session_start();

$ds = disk_total_space("/");
$ds_formatted = getSymbolByQuantity($ds);
echo "$ds_formatted, $unit";

function getSymbolByQuantity($bytes) {
    $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
    $exp = floor(log($bytes)/log(1024));

    return sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
}

?>
