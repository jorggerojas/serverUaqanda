<?php

/**
* @author Azael Donovan Ávila Aldama
* @author Jorge Luis Rojas Arcos
* Documento realizado para obtener peticiones y procesarlas según la función requerida
*/
/**
* Se incluye el archivo "funciones.php" que es el encargado de brindar las funciones
* requeridas por cada "bandera" (opción de función que desea el usuario), hace uso del
* "conexión.php"
*
*/
require_once('funciones.php');
/**
* Se incluye el archivo "conexion.php" que es el encargado de hacer la conexión con
* la base de datos y aloja funciones básicas (select, insert, update y delete) DML
* para el tratamiento de datos
*
*/
include_once('conexion.php');
// Este archivo se encarga de recibir una bandera (petición de funcionalidad), dicha bandera tendra diferentes valores,
// segun lo que el cliente mande como parámetro
// ya sea para registrar, iniciar sesion, obtener viajes, etc.

  //Se verifica que el usuario haga una petición por el método HTTP POST
  if(!empty($_POST)){
    //Registrar un usuario nuevo
    if($_POST['bandera'] == 'registrar'){

        // Se manda a llamar la funcion registro() que se encuentra en funciones.php, mandando los datos del cliente
        $reg = registro($_POST['exp'],$_POST['nom'],$_POST['ape'],$_POST['email'],$_POST['contra'],$_POST['tel']);
        if($reg){
            // Si el registro fue correcto, responde el servidor con un 1
            echo json_encode("1");
        }
        else{
            echo "2";
        }
    }

    //Inciar de sesión
    if($_POST['bandera'] == 'iniciar'){
        //  Se envian los datos a la función iniciarSesion(String exp, String pass)
        //  para su verificación en la base de datos
        $datos = iniciarSesion($_POST['exp'], $_POST['pass']);

        if($datos != ""){
            //Se envían los datos en un arreglo JSON
            echo json_encode($datos);
        }
        else{
            echo json_encode("2");
        }
    }

    // Consultar horarios
    if($_POST['bandera'] == 'consultarHorarios'){
        //Se mandan los datos a la funcion obtenerViajes que necsita el punto inicial y final del viaje
        $datos = obtenerViajes($_POST['partida'],$_POST['llegada']);
        if($datos){
            // Se envian los datos en un arreglo JSON
            echo json_encode($datos);
        }else{
            echo json_encode(2);
        }
    }

    //Obtener capacidad actual de la unidad
    if($_POST['bandera'] == 'capacidad'){
        //Se usa la función getCapacidad(int)
        $datos = getCapacidad($_POST['id']);
        if($datos){
            // Se envian los datos en un arreglo JSON
            echo json_encode($datos);
        }else{
            echo json_encode("2");
        }
    }

    //verificar reservación (y reservar, en caso de éxito)
    if($_POST['bandera'] == 'verificarReservacion'){
      $viaje = $_POST['viaje'];
      $idUsuario = $_POST['id'];
      //Se usa la función reservar (int, int)
      $r = reservar($viaje, $idUsuario);
       if($r == false){
          echo json_encode(2);
       }else if($r == 1){
          echo json_encode(1);
       }else{
          echo json_encode(3);
       }
    }

    //Ingresar fila espera
    if($_POST['bandera'] == 'filaEspera'){
      $us = $_POST['us'];
      $viaje = $_POST['viaje'];
      $r = filaEspera($us, $viaje);
      if($r == false){echo json_encode(2);}else if($r==1){echo json_encode(1);}else{echo json_encode(3);}
    }

    //Obtener datos de un viaje donde el usuario ha reservado un lugar
    if($_POST['bandera'] == 'preConfirm'){
      $us = $_POST['us'];
      $r = preConfirm($us);
      if($r != false){
        echo json_encode($r);
      }else{
        echo json_encode(2);
      }
    }

    //Confirmar asistencia de un usuario a un cierto viaje
    if($_POST['bandera'] == 'confirmar'){
      $us = $_POST['us'];
      $r = confirmar($us);
      if($r){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    //Obtener datos de un viaje en específico
    if($_POST['bandera'] == 'getDatosViaje'){
      $us = $_POST['us'];
      $viajeDatos = getDatosViaje($us);
      if($viajeDatos){
        echo json_encode($viajeDatos);
      }else{
        echo json_encode(2);
      }
    }

    //Obtener datos de la fila de espera de un viaje (e ingresar, en caso de éxito)
    if($_POST['bandera'] == 'getFila'){
      $us = $_POST['us'];
      $fila = getDatosFila($us);
      if($fila){
        echo json_encode($fila);
      }else{
        echo json_encode(3);
      }
    }

    //Cancelar una reservación de un viaje
    if($_POST['bandera'] == 'cancelarViaje'){
      $us = $_POST['us'];
      $cancelar = cancelarViaje($us);
      if($cancelar != 0){
        echo json_encode($cancelar);
      }else{
        echo json_encode(0);
      }
    }

    //Cancelar el lugar dentro de Fila de Espera
    if($_POST['bandera'] == 'cancelarFila'){
      $us = $_POST['us'];
      $cancelar = cancelarFila($us);
      if($cancelar){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    //Obtener viajes realizados
    if($_POST['bandera'] == 'historialViajes'){
      $us = $_POST['us'];
      $get = historialViajes($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

    //Eliminar viajes del historial
    if($_POST['bandera'] == 'dropViaje'){
      $us = $_POST['us'];
      $id = $_POST['id'];
      $get = dropViaje($us, $id);
      if($get){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    //Obtener datos personales del usuario
    if($_POST['bandera'] == 'getDatos'){
      $us = $_POST['us'];
      $get = getDatos($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

    //Editar datos personales del usuario (con contraseña nueva incluída)
    if($_POST['bandera'] ==  'upUs'){
      $us = $_POST['us'];
      $exp = $_POST['exp'];
      $nom = $_POST['nom'];
      $ape = $_POST['ape'];
      $mail = $_POST['mail'];
      $tel = $_POST['tel'];
      $p1 = $_POST['p1'];
      $r = upUs($us, $exp,$nom,$ape,$mail,$tel,$p1);
      if($r != false){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    //Editar datos personales del usuario (sin contraseña)
    if($_POST['bandera'] == 'upUsSC'){
      $us = $_POST['us'];
      $exp = $_POST['exp'];
      $nom = $_POST['nom'];
      $ape = $_POST['ape'];
      $mail = $_POST['mail'];
      $tel = $_POST['tel'];
      $db = new Conexion();
      echo $db->query("UPDATE usuarios SET Nombre='$nom',Apellido='$ape',Correo='$mail',
                          Telefono='$tel' WHERE idUsuario = '$us' AND ClaveExpediente = '$exp'");
    }

    //Obtener datos de un viaje en específico
    if($_POST['bandera'] == 'preCal'){
      $us = $_POST['us'];
      $get = preCal($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

    //Generar y enviar una calificación para un viaje realizado
    if($_POST['bandera'] == 'generarCalificacion'){
      $us = $_POST['us'];
      $id = $_POST['id'];
      $cal = $_POST['cal'];
      $coment = $_POST['coment'];
      $c = generarCalificacion($us, $id, $cal, $coment);
      if($c){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

  }else{
    //Impresión de error en caso de que se ingrese al servidor sin una petición HTTP POST
    echo json_encode(404);
  }

  //Impresión de error (a modo de Easter Egg) si se desea ingresar al servidor desde una petición HTTP GET
  if(!empty($_GET)){
    echo "<br>Pillo, no puedes ingresar de esta forma, andate de vuelta que necesitas la app para ingresar al sistema";
  }

?>
