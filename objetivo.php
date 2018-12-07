<?php
require_once('funciones.php');
include_once('conexion.php');
// Lo que se hace este archivo, es que se recibe una bandera, dicha bandera tendra diferentes valores,
// segun lo que el cliente mande como bandera
// ya sea para registrar, iniciar sesion, obtener viajes, etc.

  if(!empty($_POST)){
    //Se registra un usuario
    if($_POST['bandera'] == 'registrar'){

        // Aqui se manda a llamar la funcion registro() que se encuentra en funciones.php, mandando los datos del cliente
        $reg = registro($_POST['exp'],$_POST['nom'],$_POST['ape'],$_POST['email'],$_POST['contra'],$_POST['tel']);
        if($reg){
            // Si el registro fue correcto, responde el servidor con un 1
            echo json_encode("1");
        }
        else{
            echo "2";
        }
    }

    //Si inicia sesión
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
    // Si desea consultar horarios
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

    if($_POST['bandera'] == 'capacidad'){
        $datos = getCapacidad($_POST['id']);
        if($datos){
            // Se envian los datos en un arreglo JSON
            echo json_encode($datos);
        }else{
            echo json_encode("2");
        }
    }

    //verificarReservacion
    if($_POST['bandera'] == 'verificarReservacion'){
      $viaje = $_POST['viaje'];
      $idUsuario = $_POST['id'];
      $r = reservar($viaje, $idUsuario);
      echo json_encode($r);
      // if($r == false){
      //   echo json_encode(2);
      // }else if($r == 1){
      //   echo json_encode(1);
      // }else{
      //   echo json_encode(3);
      // }
    }

    //Ingresar fila espera
    if($_POST['bandera'] == 'filaEspera'){
      $us = $_POST['us'];
      $viaje = $_POST['viaje'];
      $r = filaEspera($us, $viaje);
      if($r == false){echo json_encode(2);}else if($r==1){echo json_encode(1);}else{echo json_encode(3);}
    }

    if($_POST['bandera'] == 'preConfirm'){
      $us = $_POST['us'];
      $r = preConfirm($us);
      if($r != false){
        echo json_encode($r);
      }else{
        echo json_encode(2);
      }
    }

    if($_POST['bandera'] == 'confirmar'){
      $us = $_POST['us'];
      $r = confirmar($us);
      if($r){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    if($_POST['bandera'] == 'getDatosViaje'){
      $us = $_POST['us'];
      $viajeDatos = getDatosViaje($us);
      if($viajeDatos){
        echo json_encode($viajeDatos);
      }else{
        echo json_encode(2);
      }
    }

    if($_POST['bandera'] == 'getFila'){
      $us = $_POST['us'];
      $fila = getDatosFila($us);
      if($fila){
        echo json_encode($fila);
      }else{
        echo json_encode(3);
      }
    }

    if($_POST['bandera'] == 'cancelarViaje'){
      $us = $_POST['us'];
      $cancelar = cancelarViaje($us);
      if($cancelar != 0){
        echo json_encode($cancelar);
      }else{
        echo json_encode(0);
      }
    }

    if($_POST['bandera'] == 'cancelarFila'){
      $us = $_POST['us'];
      $cancelar = cancelarFila($us);
      if($cancelar){
        echo json_encode(1);
      }else{
        echo json_encode(2);
      }
    }

    if($_POST['bandera'] == 'historialViajes'){
      $us = $_POST['us'];
      $get = historialViajes($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

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

    if($_POST['bandera'] == 'getDatos'){
      $us = $_POST['us'];
      $get = getDatos($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

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

    if($_POST['bandera'] == 'preCal'){
      $us = $_POST['us'];
      $get = preCal($us);
      if($get != false){
        echo json_encode($get);
      }else{
        echo json_encode(2);
      }
    }

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
    echo json_encode(404);
  }

  if(!empty($_GET)){
    echo "<br>Pillo, no puedes ingresar de esta forma, andate de vuelta que necesitas la app para ingresar al sistema";
  }

?>
