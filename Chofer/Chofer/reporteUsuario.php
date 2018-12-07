<?php
include_once('conexion.php');


function reportar($exp,$desc,$usuario,$viaje){


    $db = new Conexion();
    $datos = $db->query("SELECT status FROM viajes WHERE idViaje = {$viaje} AND status = 'finalizado'");
    $datos1 = $db->query("SELECT * FROM usuarios WHERE ClaveExpediente ={$exp}");
    $datos2 = $db->query("SELECT * FROM choferes WHERE idUsuario = {$usuario}");
    if(sizeof($datos)>0 && sizeof($datos1)){
        $descripcion = $desc;
        $idUs = $datos2[0][idChofer];
        $idUsR = $datos1[0][idUsuario];
        $consulta = "INSERT INTO reportes(descripcion,idUsuario,idChofer) VALUES('{$descripcion}','{$idUsR}','{$idUs}')";
        $bandera = $db->insert($consulta);
    }
    return $bandera;
    cls($db);
}
?>
