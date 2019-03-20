<?php
include_once('conexion.php');
$db = new Conexion();

$u =  $db->update("UPDATE reservaciones SET Status='Confirmado'");
echo json_encode(1);


?>
