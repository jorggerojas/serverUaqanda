<?php

/**
* Archivo finalizarViaje.php creado para hacer parte de la finalización del viaje (chofer), se encarga de mandar la notificación a los
* pasajeros que se encuentran en el viaje indicado.
* @author Azael Donovan Ávila Aldama
*/

//Se incluye el archivo de conexión a la base de datos
include_once('conexion.php');

/**
* function finalizar(int, string, string):bool
* @author Azael Donovan Ávila Aldama
* @param int $idViaje: ID del viaje a finalizar
* @param int $idUsuario: ID del chofer en turno del viaje
*/
function finalizar($idViaje,$inicio,$final){
  //Se instancia el objeto de la conexión
  $db = new Conexion();
  //Se convierten los strings a hora
  $inicio = strtotime($inicio);
  $final = strtotime($final);
  //Se crea la duración del viaje
  $duracion = $final - $inicio;
  $duracion = Date('i',$duracion);
  //Se obtienen los datos de los usuarios que estén dentro del viaje y se
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  $bandera = $db->update("UPDATE reservaciones SET status = 'finalizado' WHERE idViaje = {$idViaje}");
  $bandera = $db->update("UPDATE viajes SET status = 'finalizado', duracion = {$duracion} WHERE idViaje = {$idViaje}");
  $url = "https://fcm.googleapis.com/fcm/send";
  $data = '"notification":{"title":"Viaje Finalizado", "body":"¡El viaje ha finalizado con exito!"},"to":';
  $msg = array
  (
  	'title' => 'Viaje Finalizado',
    'body' => '¡El viaje a finalizado con exito!'
  );

  
  $server_key= 'AAAA38EOB9k:APA91bEjbHv0MKUUv45NhyAIxVmQwWm0vN8ScAetaMJhZhgQuHFZljdiZ8w02rn-73r0NEwK83EhWb-qqFpaHlEGNXcejyK7ovzJWjg-jep0YXFcNVVFrHvawKMLiPddwB6qsnmpThTP';
  $headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
  );
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

  return $bandera;
}
?>
