<?php
include_once('conexion.php');

function finalizar($idViaje,$inicio,$final){
  $db = new Conexion();
  $inicio = strtotime($inicio);
  $final = strtotime($final);
  $duracion = $final - $inicio;
  $duracion = Date('i',$duracion);
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  $bandera = $db->update("UPDATE reservaciones SET status = 'finalizado' WHERE idViaje = {$idViaje}");
  $bandera = $db->update("UPDATE viajes SET status = 'finalizado', duracion = {$duracion} WHERE idViaje = {$idViaje}");
  $url = "https://fcm.googleapis.com/fcm/send";
  $data = '"notification":{"title":"Viaje Finalizado", "body":"El viaje a finalizado con exito!"},"to":';
  $msg = array
  (
  	'title' => 'Viaje Finalizado',
    'body' => 'El viaje a finalizado con exito!'
  );

  $ch = curl_init();
  $server_key= 'AAAAt2XmO_E:APA91bEZ9Vn8TVbNIjAsYea9sWolBup8AHW9TkIgCkMvEoDagmrQashXRHU9ohPCD409UoHoPqsIGn2NizgA_BtJXzKRllFXGlFCbgCfVtl0yTBLNpAzgDChObkmYGWFIgp-akbG7pTy';
  $headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
  );
  for ($i=0; $i <count($datos); $i++) {
    $tok = $datos[$i][token];
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
