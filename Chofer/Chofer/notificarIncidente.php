<?php
include_once('conexion.php');


function incidente($hor,$lug,$desc,$usuario,$viaje){


    $db = new Conexion();
    $datos = $db->query("SELECT status FROM viajes WHERE idViaje = {$viaje} AND status = 'curso'");
    if(sizeof($datos)>0){
        $hora = $hor;
        $lugar = $lug;
        $descripcion = $desc;
        $idV = $viaje;
        $idUs = $usuario;
        $consulta = "INSERT INTO incidentes(hora,lugar,descripcion,idViaje,idUsuario) VALUES('{$hora}','{$lugar}','{$descripcion}','{$idV}','{$idUs}')";
        $bandera = $db->insert($consulta);
    }
    return $bandera;
    cls($db);
}
?>
