<?php
//Se incluye el archivo de conexión a la base de datos
include_once('conexion.php');

/**
* function solicitar(int) : bool
* @author Azael Donovan Ávila Aldama
* La función solicitar() sirve para solicitar una unidad al administrador del sistema
* @param string $destino : El destino de la unidad a solicitar
* @param string $motivo : El motivo de la solicitud
* @param int $chofer : El ID del chofer que solicita la unidad
* @param int $motivo : El ID del viaje actual
*/
function solicitar($destino,$motivo,$chofer,$viaje){
  $db = new Conexion();
  $datos = $db->query("SELECT * FROM viajes WHERE idViaje = {$viaje} AND status = 'curso' ");
  $chofer = $db->query("SELECT idChofer FROM choferes  WHERE idUsuario = {$chofer}");
  if(sizeof($datos) > 0){
    $cho = $chofer[0]['idChofer'];
    $bandera = $db->insert("INSERT INTO solicitudunidades (Destino,Justificacion,idViaje,idChofer,status)
                            VALUES('{$destino}','{$motivo}',{$viaje},{$cho},1)");
  }
  return $bandera;
  cls($db);
}

?>
