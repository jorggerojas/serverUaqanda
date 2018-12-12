<?php
//Se incluye el archivo de conexión con la base de datos
include_once('conexion.php');
//Se condiciona el servidor para hacer uso de la zona horaria de México
date_default_timezone_set('America/Mexico_City');

/**
* function horaSalida(int):array
* Esta funcion obtiene la hora actual y lo toma para mostrar en el cliente
* @param int $usuario : ID del usuario loggeado
* @return array $bandera: arreglo de datos enviados por la consulta hecha
*/
function horaSalida($usuario){
  $db = new Conexion();
  $usuario = $_POST['idUsuario'];
  $datos = $db->query("SELECT v.idViaje as id, v.Horario as hora FROM viajes v, choferes c WHERE v.idChofer = c.idChofer AND c.idUsuario = {$usuario}
                       AND v.status = 'En espera' ORDER BY v.Horario ASC");
  $hora = date("H:i");
  $bandera;
  if(is_array($datos)){
    for($i = 0; $i < count($datos); $i++){
      $horaV = $datos[$i]['hora'];
      $newHora = date("H:i", strtotime($horaV));
      if($newHora > $hora){
        $datos[$i]['hora'] = $newHora;
        $bandera = $datos[$i];
        break;
      }
    }
  }
  return $bandera;
}

/**
* function salir(int):bool
* @author Azael Donovan Ávila Aldama
* La función salir() elimina las reservaciones no confirmadas de los usuarios e inicia un viaje, notificando
* a los usuarios que han confirmado el viaje
* @param int $idViaje : ID del viaje que va a iniciar rumbo
* @return bool Éxito en la eliminación de reservaciones no confirmadas y la edición del campo status en la tabla reservaciones
*/
function salir($idViaje){
  $db = new Conexion();
  $bandera = $db->update("UPDATE viajes SET status = 'curso' WHERE idViaje = {$idViaje}");
  $bandera = $db->delete("DELETE FROM reservaciones WHERE status = 'reservado' AND idViaje ={$idViaje}");
  $bandera = $db->delete("DELETE FROM filaespera WHERE StatusActual = 'reservado' AND idViaje ={$idViaje}");
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  $url = "https://fcm.googleapis.com/fcm/send";
  $data = '"notification":{"title":"Tu viaje ha comenzado", "body":"¡El viaje a iniciado con exito!"},"to":';
  $msg = array
  (
    'title' => 'Tu viaje ha comenzado',
    'body' => '¡El viaje a iniciado con exito!'
  );

  $ch = curl_init();
  $server_key= 'AAAA38EOB9k:APA91bEjbHv0MKUUv45NhyAIxVmQwWm0vN8ScAetaMJhZhgQuHFZljdiZ8w02rn-73r0NEwK83EhWb-qqFpaHlEGNXcejyK7ovzJWjg-jep0YXFcNVVFrHvawKMLiPddwB6qsnmpThTP';
  $headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
  );
  for ($i=0; $i <count($datos); $i++) {
    $tok = $datos[$i]['token'];
    $fields = array
    (
      'to' 	=> $tok,
      'notification' => $msg
    );
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($fields));
  }
  $result = curl_exec($ch);
  curl_close( $ch );
  return $bandera;
}
?>
