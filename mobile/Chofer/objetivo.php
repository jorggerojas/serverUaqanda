<?php
//Se instancian los archivos donde se realizan las funciones principales
require_once('horaSalida.php');
require_once('notificarIncidente.php');
require_once('infoViaje.php');
require_once('finalizarViaje.php');
require_once('reporteUsuario.php');
require_once('retroalimentaciones.php');
require_once('historialViajes.php');
require_once('solicitarUnidad.php');
require_once('check.php');
require_once('token.php');
include_once('conexion.php');

//En este archivo se realizan las redirecciones pertinentes a las diferentes funciones del sistema

//Notificar hora de salida
if($_POST['bandera'] == 'horaSalida'){

  $datos = horaSalida($_POST['idUsuario']);
  if($datos != ""){
    //Se envían los datos en un arreglo JSON
    echo json_encode($datos);
  }
  else{
    echo "2";
  }

}

//Función salir
if($_POST['bandera'] == 'salir'){
  if($_POST['idViaje'] != null){
    $bandera = salir($_POST['idViaje']);
    if($bandera){
      //Se envían los datos en un arreglo JSON
      echo "1";
    }

  }else{
    echo "2";
  }
}

//Notificar incidente
if($_POST['bandera'] == 'notificar'){

  $horaV = $_POST['hora'];
  $newHora = date("h:i a", strtotime($horaV));
  if(incidente($newHora,$_POST['lugar'],$_POST['descripcion'],$_POST['idUsuario'],$_POST['idViaje'])){
    echo "ok";
  }
  else{
    echo "no";
  }
}

//Obtener información del viaje
if($_POST['bandera'] == 'informacion'){
  $datos = infoViaje($_POST['idViaje'],$_POST['status']);
  if($datos != ""){
    echo json_encode($datos);
  }
  else {
    echo "nel";
  }
}

//Finalizar viaje
if($_POST['bandera'] == 'finalizar'){
  $resp= finalizar($_POST['idViaje'],$_POST['inicial'],$_POST['final']);
  if(finalizar($_POST['idViaje'],$_POST['inicial'],$_POST['final'])){
    echo "ok";
  }else{
    echo "nel";
  }
}

//Reportar usuario
if($_POST['bandera'] == 'reportar'){

  if(reportar($_POST['expediente'],$_POST['descripcion'],$_POST['idUsuario'],$_POST['idViaje'])){
    echo "ok";
  }
  else{
    echo "no";
  }
}

//Ver retroalimentación del viaje
if($_POST['bandera'] == 'verRetro'){
  $datos = verRetro($_POST['idUsuario']);
  if($datos != ""){
    echo json_encode($datos);
  }else{
    echo "nel";
  }
}

//Buscar retroalimentaciones por viaje
if($_POST['bandera'] == 'buscarRetro'){
  $datos = buscarRetro($_POST['idRetroalimentacion']);
  if($datos != ""){
    echo json_encode($datos);
  }else{
    echo "nel";
  }
}

//Ver historial de viajes
if($_POST['bandera'] == 'verHistorial'){
  $datos = verHistorial($_POST['chofer']);
  if($datos != ""){
    echo json_encode($datos);
  }else{
    echo "nel";
  }
}

//Buscar viajes
if($_POST['bandera'] == 'buscarViaje'){
  $datos = buscarViaje($_POST['idViaje']);
  if($datos != ""){
    echo json_encode($datos);
  }else{
    echo "nel";
  }
}

//Filtrar viajes
if($_POST['bandera'] == 'filtrar'){
  $datos = filtrarViaje($_POST['chofer'],$_POST['fecha']);
  if($datos != ""){
    echo json_encode($datos);
  }else{
    echo "nel";
  }
}

//Solicitar unidad
if($_POST['bandera'] == 'solicitarU'){
  if(solicitar($_POST['destino'],$_POST['motivo'],$_POST['chofer'],$_POST['viaje'])){
    echo "ok";
  }else{
    echo "nel";
  }
}

//Hacer check-in
if($_POST['bandera'] == 'check'){
  $us = $_POST['us'];
  $vi = $_POST['viaje'];
  $r = check($us,$vi);
  if($r != false){
    echo json_encode($r);
  }else{
    echo json_encode(2);
  }
}

//Se obtiene el token del usuario
if($_POST['bandera'] == 'token'){
  $token = $_POST['token'];
  $us = $_POST['usuario'];
  $resp = token($token,$us);
  echo $resp;
}
?>
