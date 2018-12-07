<?php
include_once('conexion.php');
date_default_timezone_set('America/Mexico_City');

/**
* Funcion registro()
* Esta funcion realiza el registro del usuario que hizo la solicitud
* @param $expediente - recibe el expediente del usuario
* @param $nombre - nombre(s) del usuario
* @param $apellido - apellido(s) del usuario
* @param $correo - algun correo proporcionado por el usuario
* @param $pass - contraseña a utilizar
* @param $telefono - telefono del usuario
* @return $bandera - si se hizo el insert correctamente regresa un true, si no se hizo bien, regresa un false
*/
function registro($expediente,$nombre,$apellido,$correo,$pass,$telefono){
    // Se crea un objeto nuevo de tipo conexion.
    $db = new Conexion();
    // Hace una consulta a la base de datos, que le devolvera los datos en un arreglo asociativo, si es diferente de falso significa que no viene vacio
    $validar = $db->query("SELECT * FROM usuarios");
    $aux1 = "";
    $aux2 = "";
    $bandera;
    if($validar != false){
        for($i = 0; $i < count($validar); $i++){

            if(($validar[$i]['ClaveExpediente'] == $expediente) || ($validar[$i]['Correo']  == $correo)){
                $bandera = false;
                $aux1 = "";
                $aux2 = "";
                break;

            }
            else{
                $aux1 = $expediente;
                $aux2 = $correo;
            }
        }
        if($aux1 != "" && $aux2 != ""){

            // Se crea una consulta con los parametros que recibio la funcion
            $consulta = "INSERT INTO usuarios(ClaveExpediente,Nombre,Apellido,Correo,Password,Telefono, Token, idStatus)
            VALUES('{$aux1}','{$nombre}','{$apellido}','{$aux2}','{$pass}','{$telefono}',null, 3)";
            // Manda la consulta a la base de datos
            $newUsuario = $db->insert($consulta);
            if($newUsuario){
              $bandera = true;
            }else{
              $bandera = false;
            }
        }
    }
    else{
        $consulta = "INSERT INTO usuarios(ClaveExpediente,Nombre,Apellido,Correo,Password,Telefono, Token, idStatus)
            VALUES('{$expediente}','{$nombre}','{$apellido}','{$correo}','{$pass}','{$telefono}', null,  3)";
        $newUsuario = $db->insert($consulta);
        if($newUsuario){
          $bandera = true;
        }else{
          $bandera = false;
        }
    }
    return $bandera;

    cls($db);
}

/**
* Funcion iniciarSesion
* Esta funcion realiza un select a la base de datos para obtener el expediente,
* la contraseña y el tipo de usuario, de todos los usuarios registrados
* @param $expediente - se recibe el expediente que ingreso el usuario
* @param $pass - recibe la contraseña ingresada por el usuario
* @return $bandera - regresa una bandera ya sea con los datos del usuario o sin datos.
*/
function iniciarSesion($expediente, $pass){

    $db = new Conexion();
    // Se hace el select a la base de datos.
    $validar = $db->query("SELECT * FROM usuarios WHERE ClaveExpediente ='$expediente' AND Password = '$pass'");
    $bandera;
    if(is_array($validar)){
      for($i = 0; $i < count($validar); $i++){
          if(($validar[$i]['ClaveExpediente'] == $expediente) && ($validar[$i]['Password']  == $pass)){
              // Se guarda en bandera los datos que coincidieron con el expediente y la contraseña recibidos
              $bandera = $validar;
              break;
          }
          else{
              $bandera = "";
              break;
          }
      }
    }else{
      $bandera ="";
    }
    return $bandera;
    cls($db);
}

/**
* Funcion obtenerViajes
* Esta funcion obtiene los viajes disponibles para el usuario
* @param $inicial - punto inicial del viaje
* @param $final - punto final del viaje
* @return $datos - regresa los datos si es que encontro uno, si no regresa un false
*/
function obtenerViajes($inicial, $final){
    $db = new Conexion();
    $hoy = date("Y-m-d");
    // Se hace un select a la base de datos pidiento punto inicial, el horario
    $datos = $db->query("SELECT v.idViaje AS idViaje, r.PuntoInicial, r.PuntoFinal, r.Adicional, v.Horario, u.Capacidad
                          FROM rutas r, viajes v, unidades u
                          WHERE u.idUnidad = v.idUnidad AND
                          v.idRuta = r.idRuta AND
                          r.PuntoInicial = '{$inicial}' AND r.PuntoFinal = '{$final}' AND fecha = '$hoy'
                          ORDER BY v.Horario ASC");
    if(is_array($datos)){
      return $datos;
    }else{
      return false;
    }
    cls($db);

}

function getCapacidad($id){
   $db = new Conexion();
   $datos = $db->query("SELECT COUNT(*) AS TOTAL FROM reservaciones WHERE idViaje = '$id';");
   if(sizeof($datos)>0){
     return $datos;
   }else{
     return false;
   }
   cls($db);
}

function reservar($viaje, $idUsuario) {
  $temp;
  $db = new Conexion();
  $h = $db->query("SELECT * FROM viajes WHERE idViaje = '$viaje'");
  $www = $h[0]['Horario'];
  $hora1 = new DateTime($www);
  $hora2 = new DateTime(date("H:i:s"));
  $resds = $hora1->diff($hora2);
  $hr = $resds->format('%H');
  $minn = $resds->format('%i');
    if(intval($hr) == 00 && intval($minn) <= 30){
      $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$idUsuario'");
      if(is_array($r)){
          for ($i=0; $i < count($r); $i++) {
            if($r[$i]['Status'] != "Reservado" && $r[$i]['Status'] != "Confirmado"){
              $f = $db->query("SELECT * FROM filaEspera WHERE idUsuario = '$idUsuario'");
              if(is_array($f)){
                for ($j=0; $j < count($f); $j++) {
                  if($f[$j]['StatusActual'] != "Fila de espera"){
                    $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                          VALUES ('0','Reservado', $idUsuario, $viaje)");
                    if($insert){
                      $temp = 1;
                      break;
                      break;
                    }else{
                      $temp = false;
                      break;
                      break;
                    }
                  }else{
                    $d = $db->delete("DELETE FROM filaespera WHERE idUsuario = '$idUsuario' AND StatusActual = 'Fila de espera'");
                    if($d){
                      $temp = 1;
                      break;
                      break;
                    }else{
                      $temp = false;
                      break;
                      break;
                    }
                  }
                }
              }else{
                $ax =$db->query("SELECT * FROM reservaciones WHERE idUsuario = '$idUsuario' AND Status != 'Confirmado'");
                if(is_array($ax)){
                  for ($o=0; $o < count($ax); $o++) {
                    if($ax[$o]['Status'] != "Confirmado" && $ax[$o]['Status'] != "Reservado"){
                      $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                            VALUES ('0','Reservado', $idUsuario, $viaje)");
                      if($insert){
                        $temp = 1;
                        break;
                        break;
                        break;
                      }else{
                        $temp = false;
                        break;
                        break;
                        break;
                      }
                    }else{
                      $temp = false;
                      break;
                      break;
                      break;
                    }
                  }
                }else{
                  $temp = false;
                  break; break;
                }
              }
            }else{
              $temp = false;
              break;
              break;
            }
          }
      }else{
        $f = $db->query("SELECT * FROM filaEspera WHERE idUsuario = '$idUsuario'");
        if(is_array($f)){
          for ($k=0; $k < count($f); $k++) {
            if($f[$k]['StatusActual'] != "Fila de espera"){
              $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                    VALUES ('0','Reservado', $idUsuario, $viaje)");
              if($insert){
                $temp = 1;
                break;
                break;
              }else{
                $temp = false;
                break;
                break;
              }
            }else{
              $d = $db->delete("DELETE FROM filaespera WHERE idUsuario = '$idUsuario' AND StatusActual = 'Fila de espera'");
              if($d){
                $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                      VALUES ('0','Reservado', $idUsuario, $viaje)");
                if($insert){
                  $temp = 1;
                  break;
                  break;
                }else{
                  $temp = false;
                  break;
                  break;
                }
              }else{
                $temp = false;
                break;
                break;
              }
            }
          }
        }else{
          $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                VALUES ('0','Reservado', $idUsuario, $viaje)");
          if($insert){
            $temp = 1;
          }else{
            $temp = false;
          }
        }
      }
    }else{
      $temp =3;
    }
  return $temp;
  cls($db);
}

function filaEspera($idUsuario, $viaje){
  $temp;
  $db = new Conexion();
  $h = $db->query("SELECT * FROM viajes WHERE idViaje = '$viaje'");
  $www = $h[0]['Horario'];
  $hora1 = new DateTime($www);
  $hora2 = new DateTime(date("H:i:s"));
  $resds = $hora1->diff($hora2);
  $hr = $resds->format('%H');
  $minn = $resds->format('%i');
  if($hr == 0 && $minn <= 05){
    $f = $db->query("SELECT * FROM filaespera WHERE idUsuario = '$idUsuario'");
    if(is_array($f)){
      for ($i=0; $i < count($f); $i++) {
        if($f[$i]['StatusActual'] != "Fila de espera"){
          $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$idUsuario'");
          if(is_array($r)){
            for ($j=0; $j < count($r); $j++) {
              if($r[$j]['Status'] != "Reservado" || $r[$j]['Status'] != "Confirmado"){
                $insert = $db->insert("INSERT INTO filaespera (StatusPrevio, StatusActual, StatusFinal, idUsuario, idViaje)
                                     VALUES('No', 'Fila de espera', 'No', $idUsuario, $viaje)");
                if($insert){
                  $temp = 1;
                  break;
                  break;
                }else{
                  $temp = false;
                  break;
                  break;
                }
              }else{
                $temp = false;
                break;
                break;
              }
            }
          }else{
            $insert = $db->insert("INSERT INTO filaespera (StatusPrevio, StatusActual, StatusFinal, idUsuario, idViaje)
                                 VALUES('No', 'Fila de espera', 'No', $idUsuario, $viaje)");
            if($insert){
              $temp = 1;
              break;
            }else{
              $temp = false;
              break;
            }
          }
        }else{
          $temp = false;
        }
      }
    }else{
      $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$idUsuario'");
      if(is_array($r)){
        for ($a=0; $a < count($r); $a++) {
          if($r[$a]['Status'] == "Reservado" || $r[$a]['Status'] == "Confirmado"){
            $temp = false;
            break;
          }else{
           $insert = $db->insert("INSERT INTO filaespera (StatusPrevio, StatusActual, StatusFinal, idUsuario, idViaje)
                                VALUES('No', 'Fila de espera', 'No', $idUsuario, $viaje)");
           if($insert){
             $temp = 1;
             break;
           }else{
             $temp = false;
             break;
           }
          }
        }
      }else{
        $insert = $db->insert("INSERT INTO filaespera (StatusPrevio, StatusActual, StatusFinal, idUsuario, idViaje)
                             VALUES('No', 'Fila de espera', 'No', $idUsuario, $viaje)");
        if($insert){
          $temp = 1;
        }else{
          $temp = false;
        }
      }
    }
  }else{
    $temp = 3;
  }
  return $temp;
  cls($db);
}

function getDatosViaje($us){
  $temp;
  $db = new Conexion();
  $datos = $db->query("SELECT r.PuntoInicial AS INICIO, r.PuntoFinal AS FINAL, r.Adicional AS ADICIONAL, v.Horario AS HORA,
                          v.fecha AS FECHA
                          FROM rutas r, viajes v, reservaciones res
                          WHERE v.idRuta = r.idRuta AND
                          res.idViaje = v.idViaje AND res.idUsuario = '$us' AND
                          res.Status = 'Reservado'");
  if(is_array($datos)){
    return $datos;
  }else{
    return false;
  }
  cls($db);
}

function getDatosFila($us){
  $db = new Conexion();
  $f = $db->query("SELECT * FROM filaespera WHERE idUsuario = '$us' AND StatusActual = 'Fila de espera'");
  if(is_array($f)){
    return $f;
  }else{
    return false;
  }
  cls($db);
}

function  cancelarViaje($us){
  $db = new Conexion();
  $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$us' AND Status = 'Reservado'");
  if(is_array($r)){
    for ($i=0; $i < count($r); $i++){
      if($r[$i]['Status'] == "Reservado"){
        $f = $db->query("SELECT * FROM filaEspera WHERE idViaje = ".$r[$i]['idViaje']." ORDER BY idUsuario ASC");
        if(is_array($f)){
          $user = $f[0]['idUsuario'];
          $vi = $r[0]['idViaje'];
          $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                VALUES ('0','Reservado','$user', '$vi')");
          if($insert){
            $fila = $db->delete("DELETE FROM reservaciones WHERE idUsuario = '$us' AND idViaje=".$r[$i]['idViaje']."
                                AND  STATUS = 'Reservado';");
            if($fila){
              $delete =$db->delete("DELETE FROM reservaciones WHERE idUsuario = '$us' AND idViaje=".$r[$i]['idViaje']."
                                  AND  STATUS = 'Reservado';");
              if($delete){
                $temp = 3;
                break;
              }else{
                $temp = 0;
                break;
              }
            }else{
              $delete =$db->delete("DELETE FROM reservaciones WHERE idUsuario = '$us' AND idViaje=".$r[$i]['idViaje']."
                                  AND  STATUS = 'Reservado';");
              if($delete){
                $temp = 1;
                break;
              }else{
                $temp = 0;
                break;
              }
            }
          }else{
            $delete =$db->delete("DELETE FROM reservaciones WHERE idUsuario = '$us' AND idViaje=".$r[$i]['idViaje']."
                                AND  STATUS = 'Reservado';");
            if($delete){
              $temp = 1;
              break;
            }else{
              $temp = 0;
              break;
            }
          }
        }else{
          $delete =$db->delete("DELETE FROM reservaciones WHERE idUsuario = '$us' AND idViaje=".$r[$i]['idViaje']."
                              AND  STATUS = 'Reservado';");
          if($delete){
            $temp = 1;
            break;
          }else{
            $temp = 0;
            break;
          }
        }
      }else{
        $temp = 0;
        break;
      }
    }
  }else{
    $temp = 0;
  }
  return $temp;
  cls($db);
}

function  cancelarFila($us){
  $db = new Conexion();
  $r = $db->query("SELECT * FROM filaespera WHERE idUsuario = '$us'");
  if(is_array($r)){
    for ($i=0; $i < count($r); $i++){
      if($r[$i]['StatusActual'] == "Fila de espera"){
        $delete =$db->delete("DELETE FROM filaespera WHERE idUsuario = '$us' AND StatusActual = 'Fila de espera'");
        $temp = true;
        break;
      }else{
        $temp = false;
      }
    }
  }
  return $temp;
  cls($db);
}

function preConfirm($us){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$us' AND Status = 'Reservado'");
  if(is_array($r)){
    $p = $db->query("SELECT ru.PuntoInicial AS 'Inicio', ru.PuntoFinal AS 'Final',
                      v.Horario AS 'Hora' FROM reservaciones r, viajes v, rutas ru
                      WHERE r.idViaje = v.idViaje AND v.idRuta = ru.idRuta AND r.idUsuario = '$us'");
    if(is_array($p)){
      $temp = $p;
    }else{
      $temp = false;
    }
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

function confirmar($us){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$us' AND Status = 'Reservado'");
  if(is_array($r)){
    $id = $r[0]['idViaje'];
    $v = $db->query("SELECT * FROM viajes WHERE idViaje = '$id'");
    if(is_array($v)){
      $horario = $v[0]['Horario'];
      $hrPHP = date("H:i:s");
      $invertaloHoras = intval(substr($horario, 0, 2)) - intval(substr($hrPHP, 0, 2));
      $intervaloMinutos = intval(substr($horario, 3, 2)) - intval(substr($hrPHP, 3, 2));
      if($invertaloHoras == 0 && $intervaloMinutos <= 5){
        $update = $db->update("UPDATE reservaciones SET Status = 'Confirmado' WHERE idUsuario = '$us' AND
                              idViaje = '$id'");
        if($update){
          $temp = true;
        }else{
          $temp = false;
        }
      }else{
        $temp = false;
      }

    }else{
      $temp = false;
    }
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

function historialViajes($user){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT res.idViaje as 'id', v.Fecha as 'Fecha', v.Horario as 'Hora', r.PuntoInicial as 'Inicio', r.PuntoFinal as 'Final'
                  FROM viajes v, rutas r, reservaciones res WHERE res.idUsuario ='$user' AND res.idViaje = v.idViaje AND
                  v.idRuta = r.idRuta AND res.Status = 'Finalizado' OR res.Status = 'Calificado' LIMIT 6");
  if(is_array($r)){
    $temp = $r;
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

function dropViaje($us, $id){
  $db = new Conexion();
  $delete = $db->delete("DELETE FROM reservaciones WHERE idUsuario = $us AND idViaje = '$id'");
  if($delete){
    return true;
  }else{
    return false;
  }
  cls($db);
}

function getDatos($us){
  $db = new Conexion();
  $datos = $db->query("SELECT * FROM usuarios WHERE idUsuario = $us");
  if(is_array($datos)){
    return $datos;
  }else{
    return false;
  }
  cls($db);
}

function upUs($us, $exp,$nom,$ape,$mail,$tel,$p1){
  $db = new Conexion();
  $u = $db->update("UPDATE usuarios SET Nombre='$nom',Apellido='$ape',Correo='$mail',Password='$p1',
                    Telefono='$tel' WHERE idUsuario = '$us' AND ClaveExpediente='$exp'");
  if($u){
    return true;
  }else{
    return false;
  }
  cls($db);
}

function preCal($user){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT res.idViaje as 'id', v.Fecha as 'Fecha', v.Horario as 'Hora', r.PuntoInicial as 'Inicio', r.PuntoFinal as 'Final'
                  FROM viajes v, rutas r, reservaciones res WHERE res.idUsuario ='$user' AND res.idViaje = v.idViaje AND
                  v.idRuta = r.idRuta AND res.Status = 'Finalizado' LIMIT 1 ");
  if(is_array($r)){
    $temp = $r;
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

function generarCalificacion($us, $id, $cal, $coment){
  $temp;
  $db = new Conexion();
  $i = $db->insert("INSERT INTO calificaciones (Calificacion, Retroalimentacion, idViaje, idUsuario)
                    VALUES('$cal', '$coment', '$id', '$us');");
  if($i){
    $update = $db->update("UPDATE reservaciones set Status ='Calificado' WHERE idUsuario = '$us' AND idViaje='$id'");
    if($update){
      $temp = true;
    }else{
      $temp = false;
    }
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

?>
