<?php
/**
* Se incluye el archivo "conexion.php" que es el encargado de hacer la conexión con
* la base de datos y aloja funciones básicas (select, insert, update y delete) DML
* para el tratamiento de datos
*
*/
include_once('conexion.php');

/**
* Se toma la zona horaria de la Ciudad de México para establecer un horario
* por defecto y poder manipular el tiempo (aunque suene raro)
*
*/
date_default_timezone_set('America/Mexico_City');

/**
* @author Azael Donovan Ávila Aldama
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
            $consulta = "INSERT INTO usuarios(ClaveExpediente,Nombre,Apellido,Correo,Password,Telefono, Token, status)
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
      //Se inserta el usuario a la base de datos y se queda esperando hasta que el administrador prosiga con alguna acción
        $consulta = "INSERT INTO usuarios(ClaveExpediente,Nombre,Apellido,Correo,Password,Telefono, Token, status)
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
* @author Azael Donovan Ávila Aldama
* Funcion iniciarSesion
* Esta funcion realiza un select a la base de datos para obtener el expediente,
* la contraseña y el tipo de usuario, de todos los usuarios registrados
* @param $expediente - se recibe el expediente que ingreso el usuario
* @param $pass - recibe la contraseña ingresada por el usuario
* @return $bandera - regresa una bandera ya sea con los datos del usuario o sin datos.
*/
function iniciarSesion($expediente, $pass){

    $db = new Conexion();
    // Se hace la consulta a la base de datos.
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
* @author Jorge Luis Rojas Arcos
* Funcion obtenerViajes(string, string):array/bool
* Esta funcion obtiene los viajes disponibles para el usuario
* @param $inicial - punto inicial del viaje
* @param $final - punto final del viaje
* @return $datos - regresa los datos de la consulta generada
*                   Retorna un bool (false)
*/
function obtenerViajes($inicial, $final){
    $db = new Conexion();
    //Se obtiene la fecha actual
    $hoy = date("Y-m-d");
    $time = date("H:i");
    // Se hace una consulta a la base de datos para obtener los viajes del día de hoy
    $datos = $db->query("SELECT v.idViaje AS idViaje, r.PuntoInicial, r.PuntoFinal, r.Adicional, v.Horario, u.Capacidad
                          FROM rutas r, viajes v, unidades u
                          WHERE u.idUnidad = v.idUnidad AND
                          v.idRuta = r.idRuta AND
                          r.PuntoInicial = '{$inicial}' AND r.PuntoFinal = '{$final}' AND fecha = '$hoy' AND
                          v.Horario >= '$time'
                          ORDER BY v.Horario ASC");
    if(is_array($datos)){
      return $datos;
    }else{
      return false;
    }
    cls($db);

}

/**
* @author Jorge Luis Rojas Arcos
* function getCapacidad(int):int/bool
* @param int $id: ID del viaje que requiere el sistema para verificar los lugares disponibles
* @return int Número de reservaciones hechas a un viaje en específico
* La función getCapacidad() realiza una consulta a la base de datos para hacer un
* conteo de los usuarios que han reservado un lugar en un viaje en específico y retorna
* el número de reservaciones hechas
*/
function getCapacidad($id){
   $db = new Conexion();
   //Conteo de reservaciones
   $datos = $db->query("SELECT COUNT(*) AS TOTAL FROM reservaciones WHERE idViaje = '$id';");
   if(sizeof($datos)>0){
     return $datos;
   }else{
     return false;
   }
   cls($db);
}

/**
* @author Jorge Luis Rojas Arcos
* function reservar(int, int): int/bool
* @param int $viaje: ID del viaje que requiere el sistema para reservar un lugar al usuario
* @param int $idUsuario: ID del usuario que quiere reservar un lugar para un viaje en específico
* @return int 1: Reservación realizada con éxito
*             3: Error, el tiempo (30 minutos) es mayor al debido para reaizar una reservación
*         bool false: No se realizó la reservación
* La función reservar() cumple con la acción que lleva por su mismo nombre: reservar un lugar
* para un viaje creado a cierta hora; el usuario podrá reservar un lugar dentro de un viaje siempre
* y cuando no tenga una reservación ya hecha (en curso) o un viaje en curso. También se verifica que
* el usuario no se encuentre esperando en Fila de espera (valga la redundancia). Si es el caso (que se encuentre
* en Fila de Espera), se elimina al usuario de esta y se ingresa en el sistema la reservación que necesite
* el usuario
*/
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
            if($r[$i]['Status'] != "Reservado" && $r[$i]['Status'] != "Confirmado" && $r[$i]['idViaje'] != $viaje){
              $f = $db->query("SELECT * FROM filaespera WHERE idUsuario = '$idUsuario'");
              if(is_array($f)){
                for ($j=0; $j < count($f); $j++) {
                  if($f[$j]['StatusActual'] != "Fila de espera"){
                    $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                          VALUES ('0','Reservado', '$idUsuario', '$viaje')");
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
                                            VALUES ('0','Reservado', '$idUsuario', '$viaje')");
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
        $f = $db->query("SELECT * FROM filaespera WHERE idUsuario = '$idUsuario'");
        if(is_array($f)){
          for ($k=0; $k < count($f); $k++) {
            if($f[$k]['StatusActual'] != "Fila de espera"){
              $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                    VALUES ('0','Reservado', '$idUsuario', '$viaje')");
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
                                      VALUES ('0','Reservado', '$idUsuario', '$viaje')");
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
            // return "JAJAJAJA";
          $insert = $db->insert("INSERT INTO reservaciones (NumLugar,Status, idUsuario, idViaje)
                                VALUES ('0','Reservado', '$idUsuario', '$viaje')");
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

/**
* @author Jorge Luis Rojas Arcos
* function filaEspera(int, int):int/bool
* @param int $idUsuario: ID del usuario que quiere ingresar a Fila de Espera, para un viaje en específico
* @param int $viaje: ID del viaje que requiere el sistema para sitio en la Fila de Espera un lugar al usuario
* @return int 1: Ingreso a Fila de Espera exitoso
*         bool false: Error al ingresar a la Fila de Espera
* La función filaEspera() cumple con el papel de ingresar al usuario a un espacio donde se le puede llegar a
* asignar un lugar dentro de un viaje; este espacio (Fila de Espera) no asegura el viaje para los usuarios dentro
* de esta, solo es un lugar temporal que, en caso de que algún usuario con una reservación hecha cancele, puede tomar
* una reservación futura.
* La función retorna un int en caso de un ingreso exitoso dentro de Fila de Espera; la función puede retornar
* un bool (false) en caso de que el ingreso falle porque el usuario se encuentra ya en otra Fila de Espera o porque
* tenga una reservación ya hecha.
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function getDatosViaje(int):array/bool
* @param int $us: ID del usuario que ha reservado un viaje en específico
* @return array: Datos del viaje reservado
*         bool false: No hay viajes reservados
* La función getDatosViaje() retorna un arreglo de datos sobre la información de un viaje reservado
* por el usuario que solicita la información.
* El servidor puede retornar un false referido a que no hay viaje alguno reservado por el usuario
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function getDatosFila(int):array/bool
* @param int $us: ID del usuario que ha ingresado a Fila de Espera en un viaje en específico
* @return array: Datos del viaje específico
*         bool false: No hay viajes donde el usuario se encuentre en Fila de Espera
* La función getDatosFila() retorna un arreglo de datos sobre la información de un viaje donde se
* aloja un lugar en la Fila de Espera  por el usuario que solicita la información.
* El servidor puede retornar un false referido a que no hay lugar en Fila de Espera por el usuario
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function cancelarViaje(int):int
* @param int $us: ID del usuario que desea cancelar su reservación de viaje en específico
* @return int 1: Reservación cancelada con éxito
*         int 0: Error al cancelar reservación
* La función cancelarViaje() retorna un int sobre si se canceló su reservación en curso (1)
* o si es que ocurrió un error al cancelar su reservación (0)
*/
function  cancelarViaje($us){
  $db = new Conexion();

  $r = $db->query("SELECT * FROM reservaciones WHERE idUsuario = '$us' AND Status = 'Reservado'");
  if(is_array($r)){

    for ($i=0; $i < count($r); $i++){
        if($r[$i]['Status'] == "Reservado"){

            $id = $r[$i]['idViaje'];
            $f = $db->query("SELECT * FROM filaespera WHERE idViaje = {$id}  ORDER BY idUsuario ASC");
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

/**
* @author Jorge Luis Rojas Arcos
* function cancelarFila(int):int/bool
* @param int $us: ID del usuario que desea cancelar su lugar en Fila de Espera de viaje en específico
* @return int 1: Lugar en Fila de Espera cancelada con éxito
*         bool false: Error al cancelar lugar en Fila de Espera
* La función cancelarFila() retorna un int sobre si se canceló su lugar en Fila de Espera (1)
* o un bool (false) si es que ocurrió un error al cancelar su lugar en Fila de Espera
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function preConfirm(int):array/bool
* @param int $us: ID del usuario que desea obtener información de viaje en específico
* @return array Datos del viaje solicitado
*         bool false: No hay información del viaje solicitado
* La función preConfirm() retorna un array con la información solicitada del viaje
* o ,si es que ocurrió un error o no hay información de ese viaje, el sistema retorna un bool (false)
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function confirmar(int): bool
* @param int $us: ID del usuario que desea obtener confirmar su asistencia a viaje en específico
* @return bool true: Confirmación exitosa
*              false: Error al confirmar el viaje
* La función confirmar() retorna un bool (true) si es que su confirmación ha sido exitosa o, de igual
* manera, arroja un bool (false) en caso de que su confirmación falle (por error en el servidor, porque
* no tiene un viaje en curso o porque no se encuentra dentro de la zona de conformación de viaje)
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function historialViajes(int):array/bool
* @param int $user: ID del usuario que desea obtener información de sus viajes realizados
* @return array Datos de los viajes solicitados
*         bool false: No hay información de los viajes solicitados
* La función historialViajes() retorna un array con la información solicitada de los viajes realizados
* por el usuario. Si es que ocurrió un error o no hay información de viajes realizados, el sistema retorna un bool (false).
*/
function historialViajes($user){
  $temp;
  $db = new Conexion();
  $r = $db->query("SELECT DISTINCT res.idViaje as 'id', v.Fecha as 'Fecha', v.Horario as 'Hora', r.PuntoInicial as 'Inicio', r.PuntoFinal as 'Final'
                  FROM viajes v, rutas r, reservaciones res WHERE res.idUsuario ='$user' AND res.idViaje = v.idViaje AND
                  v.idRuta = r.idRuta AND res.Status != 'En espera' OR res.idUsuario ='$user' AND res.idViaje = v.idViaje AND
                  v.idRuta = r.idRuta AND res.Status != 'En curso'  LIMIT 6");
  if(is_array($r)){
    $temp = $r;
  }else{
    $temp = false;
  }
  return $temp;
  cls($db);
}

/**
* @author Jorge Luis Rojas Arcos
* function dropViaje(int):bool
* @param int $us: ID del usuario que desea obtener información de sus viajes realizados
* @return bool true: Viaje eliminado exitosamente del historial
*              false: No se eliminó el viaje del historial
* La función dropViaje() retorna un bool (true) en caso de que el viaje que desee eliminar
* del historial sea correctamente removido, en caso contrario, se retorna un bool (false).
*/
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

//Función auxiliar para obtener los datos de un usuario (según el ID dentro del parámetro establecido)
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

/**
* @author Jorge Luis Rojas Arcos
* function upUs(int, string,string,string,string,string,string):bool
* @param int $us: ID del usuario que desea editar su información personal
* @param string $exp: Clave o expediente personal (del usuario)
* @param string $nom: Nombre(s) (del usuario)
* @param string $ape: Apellido(s) (del usuario)
* @param string $mail: Correo electrónico personal(del usuario)
* @param string $tel: Teléfono personal (del usuario)
* @param string $p1: Nueva constraseña (del usuario)
* @return bool true: Datos personales (del usuario) editados con éxito
*         bool false: Datos personales (del usuario) no editados
* La función upUs() retorna un bool (true) cuando se han editado sus datos personales con éxito.
* Si es que ocurrió un error al editar sus datos personales, el sistema retorna un bool (false).
* ESTA FUNCIÓN SE EJECUTA SI HAY UNA NUEVA CONTRASEÑA
*/
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

/**
* @author Jorge Luis Rojas Arcos
* function upUsSC(int, string,string,string,string,string,string):bool
* @param int $us: ID del usuario que desea editar su información personal
* @param string $exp: Clave o expediente personal (del usuario)
* @param string $nom: Nombre(s) (del usuario)
* @param string $ape: Apellido(s) (del usuario)
* @param string $mail: Correo electrónico personal(del usuario)
* @param string $tel: Teléfono personal (del usuario)
* @return bool true: Datos personales (del usuario) editados con éxito
*         bool false: Datos personales (del usuario) no editados
* La función upUsSC() retorna un bool (true) cuando se han editado sus datos personales con éxito.
* Si es que ocurrió un error al editar sus datos personales, el sistema retorna un bool (false).
* ESTA FUNCIÓN SE EJECUTA SI SE MANTIENE LA MISMA CONTRASEÑA PERO SE ACTUALIZAN LOS DATOS
*/
function upUsSC($us, $exp,$nom,$ape,$mail,$tel){
  $db = new Conexion();
    $u =  $db->update("UPDATE usuarios SET Nombre='$nom',Apellido='$ape',Correo='$mail',
                      Telefono='$tel' WHERE idUsuario = '$us' AND ClaveExpediente = '$exp'");
  if($u){
    return true;
  }else{
    return false;
  }
  cls($db);
}

//Función auxiliar que obtiene los datos de los viajes realizados por el usuario (aunque solo se tomará uno
//por consulta) para su futura calificación
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

/**
* @author Jorge Luis Rojas Arcos
* function generarCalificacion(int, int, int, string):bool
* @param int $us: ID del usuario que desea calificar un viaje realizado con anterioridad
* @param int $id: ID del viaje a calificar por el usuario
* @param int $cal: calificación (en número entero) en un rango del 1 al 5 que se le da a un viaje realizado
*                  por el usuario
* @param string $coment: Comentario que desee realizar el usuario sobre su viaje realizado
*/
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
