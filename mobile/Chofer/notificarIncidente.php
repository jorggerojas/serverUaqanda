<?php
//Se incluye el archivo de conexión
include_once('conexion.php');


/**
* function incidente(string, string, string, int, int) : bool
* La función incidente() registra un incidente en la base de datos
* @author Azael Donovan Ávila Aldama
* @param string $hor : La hora registrada del incidente
* @param string $lug : Lugar donde se registra el incidente
* @param string $desc : Descripción del incidente registrado
* @param int $usuario : ID del usuario que registra el incidente
* @param int $viaje : ID del viaje donde se registra el incidente
*/
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
