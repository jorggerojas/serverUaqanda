<?php

  /**
   * class Index_model
   *  Esta clase hace uso de la librería Model(./libs/Model.php) y
   *  hace una conexión con la base de datos (definida en ./config.php).
   *  Los métodos creados en esta clase servirán de respuesta al Controller
   *  que haga referencia a los mismos.
   */
  class Index_model extends Model{

    /**
    * lg(String expediente, String pass):array
    * @param String $exp
    *               Expediente/Clave de empleado del Administrador
    * @param String $pass
    *               Contraseña de UAQ-ANDA del Administrador
    * Esta función hace una conexión con la base de datos (referenciada en
    * el constructor) y selecciona todos los datos de la tabla usuarios que
    * tengan ClaveExpediente y Password (atributos/columna de la base de datos)
    * iguales a $exp y $pass (variables PHP con datos enviados por el Administrador),
    * respectivamente.
    *
    * @return array
    *         Retorna un arreglo con los datos consultados
    * @return String
    *         Retorna "No se encontró ningún registro." en caso de que la consulta
    *         no arroje algún dato.
    */
    public function lg($exp, $pass)
    {
        /*
        * Se apunta a la clase creada con $this y hacemos referencia al atributo $db de la
        * clase padre (Model).
        * Se manda a llamar el método "select()" (ubicada en ./libs/Conexion.php) de la clase Conexion
        * para hacer uso de la función de mysqli "query()" y ejecutar la consulta.
        * Se regresa la respuesta de la consulta.
        */
        return $this->db->select("*", "usuarios", "ClaveExpediente='$exp' AND Password='$pass'");
    }
  }


 ?>
