<?php
include_once('conexion.php');
$db = new Conexion();

$u =  $db->update("UPDATE viajes SET status='Confirmado'");
echo json_encode(1);


?>
