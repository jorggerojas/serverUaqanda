<?php
include_once('conexion.php');
/**
 * Funcion verHistorial()
*/
function verHistorial($idUsuario){
  $db = new Conexion();
  $datos = $db->query("SELECT v.idViaje, v.fecha,v.Horario, r.PuntoInicial,r.PuntoFinal FROM viajes v, choferes c, rutas r WHERE c.idUsuario = {$idUsuario} AND v.idChofer= c.idChofer AND r.idRuta = v.idRuta AND v.status = 'finalizado' ORDER BY v.fecha DESC LIMIT 6 ");
  if($datos != false){
    for($i = 0; $i < count($datos); $i++){
      $horaV = $datos[$i]['Horario'];
      $originalDate = $datos[$i]['fecha'];
      $newDate = date("d-m-Y", strtotime($originalDate));
      $newHora = date("H:i", strtotime($horaV));
      $datos[$i]['Horario'] = $newHora;
      $datos[$i]['fecha'] = $newDate;
    }
    $bandera = $datos;
  }
  return $bandera;
  cls($db);
}
function buscarViaje($idViaje){
  $db = new Conexion();
  $datos = $db->query("SELECT r.PuntoInicial, r.PuntoFinal, v.duracion, v.kilometraje, v.fecha, v.horario FROM rutas r, viajes v
                       WHERE v.idViaje = {$idViaje} AND r.idRuta = v.idRuta");
  $promedio = $db->query("SELECT ROUND(avg(calificacion)) as promedio FROM calificaciones WHERE idViaje = {$idViaje}");
  $horaV = $datos[0]['horario'];
  $originalDate = $datos[0]['fecha'];
  $newDate = date("d-m-Y", strtotime($originalDate));
  $newHora = date("H:i", strtotime($horaV));
  $datos[0]['horario'] = $newHora;
  $datos[0]['fecha'] = $newDate;
  $datos[0]['promedio'] = $promedio[0]['promedio'];
  return $datos;
  cls($db);
}
function filtrarViaje($idChofer, $fecha){
  $db = new Conexion();
  $datos = $db->query("SELECT v.idViaje, v.fecha,v.Horario, r.PuntoInicial,r.PuntoFinal FROM viajes v, choferes c, rutas r
                       WHERE c.idUsuario = {$idChofer} AND v.idChofer= c.idChofer AND r.idRuta = v.idRuta AND v.status = 'finalizado'
                       AND v.fecha ='{$fecha}' ORDER BY v.fecha DESC");
  if($datos != false){
    for($i = 0; $i < count($datos); $i++){
      $horaV = $datos[$i]['Horario'];
      $originalDate = $datos[$i]['fecha'];
      $newDate = date("d-m-Y", strtotime($originalDate));
      $newHora = date("H:i", strtotime($horaV));
      $datos[$i]['Horario'] = $newHora;
      $datos[$i]['fecha'] = $newDate;
    }
  }
  return $datos;
  cls($db);
}
?>
