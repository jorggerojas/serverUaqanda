<?php
//Se incluye el archivo de conexión a la base de datos
include_once('conexion.php');

/**
* function token(string, int) : bool
* @author Azael Donovan Ávila Aldama
* La función token() registra un token a los usuarios que necesitan ser notificados de algún acontecimiento
* @param int $idUsuario : ID del chofer loggeado
*/
function token($token,$usuario){
  $db = new Conexion();
  $bandera = $db->update("UPDATE usuarios SET token ='{$token}' WHERE idUsuario = $usuario");
  return $bandera;
}
?>
