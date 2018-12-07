<?php
include_once('conexion.php');

function token($token,$usuario){
  $db = new Conexion();
  $bandera = $db->update("UPDATE usuarios SET token ='{$token}' WHERE idUsuario = $usuario");
  return $bandera;
}
?>
