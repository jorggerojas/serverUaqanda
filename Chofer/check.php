<?php
include_once('conexion.php');

function check($idUsuario,$idViaje){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT r.PuntoFinal as Final  FROM viajes v, rutas r, choferes c WHERE c.idUsuario = {$idUsuario} AND v.idViaje = {$idViaje} AND v.idRuta = r.idRuta");
  if($r != false){
    $temp = $r;
  }else{
    $temp = false;
  }
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  $url = "https://fcm.googleapis.com/fcm/send";
  $data = '"notification":{"title":"Viaje inicializado", "body":"El viaje a iniciado con exito!"},"to":';
  $final = $temp[0]['Final'];
  $msg = array
  (
    'title' => 'Camion en parada!',
    'body' => 'El camion esta en una para de tu viaje'
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
  return $temp;
}
?>
