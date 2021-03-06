<?php
/**
* Esta clase establece la conexion a una base de datos MYSQL y
* contiene funciones basicas para su funcionamiento
* @author Azael Donovan Avila Aldama<donovan.dark10@gmail.com>
* @version 1.0
*
*/
class Conexion
{
    /** Se declaran estas variables privadas que serviran para establecer la conexion a la base de datos */
    private $host,$user,$pass,$database;
    /** Variablae en la que se guarda la conexion */
    private $link;
    /** De vuelve el status de la base de datos, conectado o error */
    private $status = "<b style='color:green'>Connected</b>";


    /**
    * Esta funcion establece el constructor de la base de datos
    * @param $host - a que host se conectara
    * @param $user - usuario que se conectará a la base de datos
    * @param $pass - contraseña de la base de datos
    * @param $database - nombre de la base de datos a la que se conectara
    */
    public function __construct()
    {

      $this->host = "us-cdbr-iron-east-01.cleardb.net";
      $this->user = 'bbc44b817897f1';
      $this->pass = '27b80d4c';
      $this->database = 'heroku_dc4918426883fe6';

        /** Se crea una nueva conexion mysql con los parametros que recibe la funcion y se guarda en la variable link */
        @$this->link = new mysqli($this->host,$this->user,$this->pass,$this->database);
        /** Establecemos nuestra conexion en formato utf8 */
        $this->link->set_charset("utf8");
        if($this->link->connect_error)
        {
            $this->status = "<b style='color:red'>Database Error:</b> ".$this->link->connect_error;
        }
    }

    /**
    * Esta funcion revuelve el estatus de la base de datos
    * @return - puede devolver conectado o algun error con la conexion.
    */
    public function getStatus(){
        return $this->status;
    }

    /**
    * Esta funcion hace un select a la base de datos
    * @param $qry - recibe el qry que mandara a la BD
    * @return $response - regresa false si la BD no regreso columnas, si regreso columnas regresa un arreglo asociativo
    */
    public function query($qry)
    {
        $result = $this->link->query($qry);

        if($result->num_rows == 0){
            $response = false;
        }
        while($row = $result->fetch_assoc())
        {
            $response[] = $row;
        }
        return $response;
    }
    /**
    * Esta funcion se utiliza para realizar inserts en la BD.
    * @param $qry - recibe el query para hacerlo en la base de datos
    * @return $result - regresa la respuesta de la base de datos.
    */
    public function insert($qry)
    {
        $result = $this->link->query($qry);
        return $result;
    }

    /**
    * Esta función se utiliza para realizar ediciones en la base de datos.
    * @param $qry - recibe el query a realizar en la base de datos
    * @return $result - regresa la respuesta de la base de datos
    */
    public function update($qry){
        $result = $this->link->query($qry);
        return $result;
    }

    /**
    * Esta función se utiliza para realizar supresiones en la base de datos.
    * @param $qry - recibe el query a realizar en la base de datos
    * @return $result - regresa la respuesta de la base de datos
    */
    public function delete($qry){
      $result = $this->link->query($qry);
      return $result;
    }


    /**
    * function close():void
    * @author Jorge Luis Rojas Arcos
    * @version 1.0
    * La función 'close(conexion)' cierra la conexión establecida para
    * manejo de la base de datos.
    * @param $con
    *         Objeto tipo msqli que contiene la conexión a la base de datos
    *
    */
    public function cls($con){
      //Se usa la función 'mysqli_close()' para cerrar la conexión (que se manda de parámetro)
      $con = $this->link;
      mysqli_close($con);
    }


}


?>
