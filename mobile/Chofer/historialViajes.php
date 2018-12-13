<?php

//Se incluye el archivo de conexión a la base de datos
include_once('conexion.php');
/**
* Funcion verHistorial(int):array
* @author Azael Donovan Ávila Aldama
* @param int $idUsuario : ID del usuario dentro del sistema (Chofer)
*/
function verHistorial($idUsuario){
  //Se instancia el objeto de conexión a la base de datos
  $db = new Conexion();
  //Se hace una consulta a la base de datos sobre los viajes ya finalizados
  $datos = $db->query("SELECT v.idViaje, v.fecha,v.Horario, r.PuntoInicial,r.PuntoFinal FROM viajes v, choferes c, rutas r WHERE c.idUsuario = {$idUsuario} AND v.idChofer= c.idChofer AND r.idRuta = v.idRuta AND v.status = 'finalizado' v.status != 'eliminado' ORDER BY v.fecha DESC LIMIT 6 ");
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

/**
* function buscarViaje(int):array
* Esta funcion obtiene los viajes según la búsqueda realizada
* @author Azael Donovan Ávila Aldama
* @param int $idViaje : ID del viaje específico
*/
function buscarViaje($idViaje){
  //Se instancia el objeto de la conexión
  $db = new Conexion();
  //Se hace una consulta a la base de datos
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
  //Se retornan datos
  return $datos;
  cls($db);
}

/**
* function filtrarViaje(int, int):array
* Esta funcion obtiene un viaje por medio de filtración por fecha
* @param int $idChofer: ID del chofer que ha iniciado sesión
* @param string $fecha: La fecha exacta en la que se buscan viajes
*/
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
