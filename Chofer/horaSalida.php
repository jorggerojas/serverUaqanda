<?php
include_once('conexion.php');

function horaSalida($usuario){
  $db = new Conexion();
  $usuario = $_POST['idUsuario'];
  $datos = $db->query("SELECT v.idViaje as id, v.Horario as hora FROM viajes v, choferes c WHERE v.idChofer = c.idChofer AND c.idUsuario = {$usuario}
                       AND v.status = 'En espera' ORDER BY v.Horario ASC");
  date_default_timezone_set('America/Mexico_City');
  $hora = date("H:i");
  $bandera;
  if(is_array($datos)){
    for($i = 0; $i < count($datos); $i++){
      $horaV = $datos[$i]['hora'];
      $newHora = date("H:i", strtotime($horaV));
      if($newHora > $hora){
        $datos[$i][hora] = $newHora;
        $bandera = $datos[$i];
        break;
      }
    }
  }
  return $bandera;
}

function salir($idViaje){
  $db = new Conexion();
  $bandera = $db->update("UPDATE viajes SET status = 'curso' WHERE idViaje = {$idViaje}");
  $bandera = $db->delete("DELETE FROM reservaciones WHERE status = 'reservado' AND idViaje ={$idViaje}");
  $bandera = $db->delete("DELETE FROM filaespera WHERE StatusActual = 'reservado' AND idViaje ={$idViaje}");
  $datos = $db->query("SELECT u.token AS token FROM usuarios u, reservaciones r where u.idUsuario = r.idUsuario AND r.idViaje = {$idViaje}");
  $url = "https://fcm.googleapis.com/fcm/send";
  $data = '"notification":{"title":"Viaje inicializado", "body":"El viaje a iniciado con exito!"},"to":';
  $msg = array
  (
    'title' => 'Viaje inicializado',
    'body' => 'El viaje a iniciado con exito!'
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
