<?php
  /**
   *
   */
  class usuarios extends Controller
  {

    function __construct()
    {
      parent::__construct();
    }
    //________________________________Usuarios__________________________________
    /**
    * comprobarSesion(): boolean
    * Función hace uso de la clase Controller (./libs/Controller.php)
    * para verificar que se tengan registradas las variables de sesion que se crean cuando
    * el usuario hace un inicio de sesion exitoso.
    * @return boolean
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */
    function comprobarSesion()
    {
      // Se hace uso de la función de la clase Controller
      //  sessionExist() para verificar que haya una sesión iniciada y
      // se busca dicha sesión para asignar valores a las variables $id, $nombre, $mail.
      $id = Controller::sessionExist('idUsuario');
      $nombre = Controller::sessionExist('Nombre');
      $mail = Controller::sessionExist('Correo');
      //Se verifica que los valores de las variables sean diferente de nulo.
      if($id != null && $nombre != null && $mail != null){
        //Si es asi la funcion devuelve un true.
        return true;
      }else{
        // En caso contrario la funcion devuelve un false y hace una redirecion por medio
        // del header hacia la raiz del proyecto.
        return false;
        header('Location:'.URL);
      }
    }
    /**
    * solicitudesUsuarios(): void
    * Función hace uso de la función selectUser() de la clase Usuarios_model
    * la cual nos devuelve el conjunto de datos de las solicitudes de los usuarios que
    * aun se encuentran pendientes, estos se almacenan en un arreglo y se devuelven
    * como un objeto de tipo JSON
    * obteniendo los valores por el metodo POST, modificando su status a 6: eliminado
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */
    function solicitudesUsuarios()
    {
      $this->loadOtherModel('Usuarios');
       // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
      if ($this->comprobarSesion()) {
        try {
          // Se verifica que los datos enviados por metodo POST no esten vacios
          if (!empty($_POST)){
            // Se obtienen los datos de la funcion selectUser() y se almacenan en la variable $solicitudes
            $solicitudes = $this->Usuarios->selectUser();
              // Se evalua que lo que se obtuvo en la base de datos no se encuentre vacio.
            if (is_array($solicitudes)) {
              // Se crea un arreglo donde se almacenaran los datos de la unidad
              $us = [];
              // Por medio del ciclo foreach se recorre el arreglo obtenido en unidades
              foreach ($solicitudes as $solicitud => $columna) {
                // Los datos se almacenan en variables
                $id = $columna['idUsuario'];
                $nb = $columna['Nombre'];
                $ap = $columna['Apellido'];
                $ex = $columna['ClaveExpediente'];
                $co = $columna['Correo'];
                // Los valores del $nb y $ap se almacenan en una sola variable
                $nombre = $nb." ".$ap;
                // Las variables se almacenan en el arreglo previamente creado
                $us[] = [$id,$nombre,$ex,$co];
              }
              // Se devuelve el arreglo por medio de un objeto de tipo JSON
              echo json_encode($us, JSON_UNESCAPED_UNICODE);
            }else{
              // Si el arreglo devuelto por la función selectUnidad() se encuentra vacio se devuelve un 1
              echo json_encode("1", JSON_UNESCAPED_UNICODE);
            }
          }else {
            // Si no se encuentran datos enviados por metodo POST se devuelve un 2
            echo json_encode("2", JSON_UNESCAPED_UNICODE);
          }
        } catch (Exception $e) {
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
        }
      }else {
        //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
        header('Location:'.URL);
      }
    }
    /**
    * aprobarSolicitudUsuario(): void
    * Función hace uso de la función aceptarStatusUser(int $id) de la clase Usuarios_model()
    * la cual nos permite editar un registro de la base de datos , modificando su status a 2: aceptado
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */
  function aprobarSolicitudUsuario()
    {
      $this->loadOtherModel('Usuarios');
      // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
      if ($this->comprobarSesion()) {
        try {
          // Se verifica que los datos enviados por metodo POST no esten vacios
          if (!empty($_POST)) {
            // Se recibe el id por medio del metodo POST y se almacena en la variable id
            $id = $_POST['id'];
            // Se llama a la funcion aceptarStatusUser(int $id)
            $op = $this->Usuarios->aceptarStatusUser($id);
            // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
            echo json_encode($op, JSON_UNESCAPED_UNICODE);
          }else {
            // Si no se encuentran datos enviados por metodo POST se devuelve un 2
            echo json_encode("2", JSON_UNESCAPED_UNICODE);
          }
        } catch (Exception $e) {
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
        }
      }else {
        //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
        header('Location:'.URL);
      }
    }
    /**
    * eliminarSolicitudUsuarios(): void
    * Función hace uso de la función deleteStatusUser(int $id) de la clase Usuarios_model()
    * la cual nos permite editar un registro de la base de datos , modificando su status a 4: Rechazado
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */

    function eliminarSolicitudUsuario()
    {
      $this->loadOtherModel('Usuarios');
      // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
      if ($this->comprobarSesion()) {
        try {
          // Se verifica que los datos enviados por metodo POST no esten vacios
          if (!empty($_POST)) {
            // Se recibe el id por medio del metodo POST y se almacena en la variable $id
            $id = $_POST['id'];
            // Se llama a la funcion deleteStatusUser(int $id) con la variable id como parámetro
            $op = $this->Usuarios->deleteStatusUser($id);
            // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
            echo json_encode($op, JSON_UNESCAPED_UNICODE);
          }else {
            // Si no se encuentran datos enviados por metodo POST se devuelve un 2
            echo json_encode("2", JSON_UNESCAPED_UNICODE);
          }
        } catch (Exception $e) {
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
        }
      }else {
        //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
        header('Location:'.URL);
      }
    }
  }

 ?>
