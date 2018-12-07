<?php
include_once('conexion.php');


function infoViaje($idViaje){
  $db = new Conexion();
  $cuenta = $db->query("SELECT count(status) as ocupados FROM reservaciones WHERE idViaje = {$idViaje} AND status = 'confirmado'");
  $capacidad = $db->query("SELECT u.capacidad FROM unidades u, viajes v WHERE v.idViaje = {$idViaje} AND v.idUnidad = u.idUnidad");
  $datos = $db->query("SELECT r.PuntoInicial, r.Adicional,r.PuntoFinal,v.horario FROM rutas r, viajes v WHERE v.idViaje = {$idViaje} AND r.idRuta = v.idRuta");
  $ocupados = $cuenta[0][ocupados];
  $total = $capacidad[0][capacidad];
  $desocupados = $total - $ocupados;
  $horaV = $datos[0][horario];
  $newHora = date("H:i", strtotime($horaV));
  $datos[0][horario] = $newHora;
  $datos[0][ocupados] = $ocupados;
  $datos[0][desocupados] = $desocupados;
  return $datos;
  cls($db);
}
?>
