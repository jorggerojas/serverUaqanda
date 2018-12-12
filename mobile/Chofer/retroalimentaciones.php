<?php
//Se incluye el archivo de conexión
include_once('conexion.php');

/**
* function verRetro(int) : array
* @author Azael Donovan Ávila Aldama
* La función verRetro sirve para visualizar las retroalimentaciones de un viaje
* @param int $idUsuario : ID del chofer loggeado
*/
function verRetro($idUsuario){
  $db = new Conexion();
  $datos = $db->query("SELECT cl.idCalificacion ,v.fecha,v.Horario, r.PuntoInicial,r.PuntoFinal,cl.Calificacion FROM viajes v, choferes c, calificaciones cl, rutas r WHERE c.idUsuario = {$idUsuario} AND v.idChofer= c.idChofer AND r.idRuta = v.idRuta AND v.idViaje = cl.idViaje");
  $bandera;
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
* function buscarRetro(int) : array
* @author Azael Donovan Ávila Aldama
* La función buscarRetro muestra una Retroalimentación de manera más específica
* @param int $idRetro : ID de la Retroalimentación
*/
function buscarRetro($idRetro){
  $db = new Conexion();
  $datos = $db->query("SELECT u.Nombre as 'Nombre',u.Apellido as 'Apellido' ,v.fecha as 'fecha',v.Horario as 'Horario', r.PuntoInicial as 'PuntoInicial',r.PuntoFinal as 'PuntoFinal',cl.Calificacion as 'Calificacion', cl.Retroalimentacion as 'Retroalimentacion'
    FROM usuarios u, viajes v, choferes c, calificaciones cl, rutas r
    WHERE cl.idUsuario = u.idUsuario AND cl.idCalificacion = {$idRetro} AND r.idRuta = v.idRuta AND v.idViaje = cl.idViaje");
  $horaV = $datos[0]['Horario'];
  $originalDate = $datos[0]['fecha'];
  $newDate = date("d-m-Y", strtotime($originalDate));
  $newHora = date("H:i", strtotime($horaV));
  $datos[0]['Horario'] = $newHora;
  $datos[0]['fecha'] = $newDate;
  return $datos;
  cls($db);
}
?>
