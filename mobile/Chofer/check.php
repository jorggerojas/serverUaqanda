<?php
/**
* Archivo check.php creado para hacer parte del check-in (chofer), se encarga de mandar la notificación a los
* pasajeros que se encuentran en el viaje indicado.
* @author Azael Donovan Ávila Aldama
*/

//Se incluye el archivo de conexión a la base de datos
include_once('conexion.php');

/**
* function check(int, int):string
* @author Azael Donovan Ávila Aldama
* @param int $idUsuario: ID del chofer en turno del viaje
* @param int $idViaje: ID del viaje en curso
*/
function check($idUsuario,$idViaje){
  $temp;
  //Se crea la instancia de la conexión
  $db = new Conexion();
  //Se hace la consulta para saber el punto final del viaje
  $r = $db->query("SELECT r.PuntoFinal as Final  FROM viajes v, rutas r, choferes c WHERE c.idUsuario = {$idUsuario} AND v.idViaje = {$idViaje} AND v.idRuta = r.idRuta");
  if($r != false){
    $temp = $r;
  }else{
    $temp = false;
  }
  //Se hace una consulta del token de los usuarios
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  //Se inicia la creación de las notificaciones con Firebase Cloud Messaging
  $url = "https://fcm.googleapis.com/fcm/send";
  //Datos de la notificación
  $data = '"notification":{"title":"Tu viaje ha comenzado", "body":"¡El viaje a iniciado con exito!"},"to":';
  $final = $temp[0]['Final'];
  //Descripción de la notificación
  $msg = array
  (
    'title' => 'Camión en parada!',
    'body' => 'El camión esta en una parada del viaje'
  );
  //Se inicia el CURL y se instancia la llave del servidor, se colocan los haeaders
  
  $server_key= 'AAAA38EOB9k:APA91bEjbHv0MKUUv45NhyAIxVmQwWm0vN8ScAetaMJhZhgQuHFZljdiZ8w02rn-73r0NEwK83EhWb-qqFpaHlEGNXcejyK7ovzJWjg-jep0YXFcNVVFrHvawKMLiPddwB6qsnmpThTP';
  $headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
  );
  //Se envía la notificación a todos los usuarios del viaje
  for ($i=0; $i <count($datos); $i++) {
    $ch = curl_init();
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
    $result = curl_exec($ch);
    curl_close( $ch );
  }
  
  return $temp;
}
?>
