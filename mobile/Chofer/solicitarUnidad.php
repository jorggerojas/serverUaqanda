<?php
include_once('conexion.php');

function solicitar($destino,$motivo,$chofer,$viaje){
  $db = new Conexion();
  $datos = $db->query("SELECT * FROM viajes WHERE idViaje = {$viaje} AND status = 'curso' ");
  $chofer = $db->query("SELECT idChofer FROM choferes  WHERE idUsuario = {$chofer}");
  if(sizeof($datos) > 0){
    $cho = $chofer[0][idChofer];
    $bandera = $db->insert("INSERT INTO solicitudunidades (Destino,Justificacion,idViaje,idChofer,status)
                            VALUES('{$destino}','{$motivo}',{$viaje},{$cho},1)");
  }
  return $bandera;
  cls($db);
}

?>
