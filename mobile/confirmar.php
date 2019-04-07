<?php
include_once('conexion.php');
$db = new Conexion();

/*$u =  $db->update("UPDATE reservaciones SET Status='Confirmado'");
echo json_encode(1);*/
        $pass= $_POST['pass'];
        $exp = $_POST['exp']:
        $datos = $db->query("SELECT * FROM usuarios);
        if($datos != ""){
            //Se envían los datos en un arreglo JSON
            echo json_encode($datos);
        }
        else{
            echo json_encode("2");
        }


?>
