<?php

  class Administrador extends Controller
  {

    function __construct() {
        parent::__construct();
    }
    /**
    * comprobarSesion(): void
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
      // sessionExist(string) para verificar que haya una sesión iniciada y
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
    * error(): void
    * Función que hace uso de la clase Controller (./libs/Controller.php)
    * para renderizar la pagina de error 404 en caso de que no se pueda renderizar alguna vista
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */
    function error()
    {
        // Se hace uso de la funcion de la clase Controller
        // pageNotFound() que nos permite renderizar una vista de error predeterminada
        // ubicada en './views/Default/error.php';
        Controller::pageNotFound();
    }
    /**
    *   Index():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/index.php';
    *   @author Jorge Luis Rojas Arcos
    *   @version 1.0
    */
    function Index()
    {
        //Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
        if ($this->comprobarSesion()) {
        //Se hace uso de la función render(string Controller, string View [, bool])
        $this->view->render($this, 'index');
      }else{
          //En caso de que la funcion nos devuelva false nos redirige a la pagina principal del sistema
        header('Location:'.URL);
      }
    }
    /**
    *   modulo():void
    *   Función que recibe datos por el metodo GET
    *   y que hace uso de la clase View (./libs/View.php) para renderizar
    *   las vistas ubicadas en './views/Administrador';
    *   @author Estefania Morales
    *   @version 1.0
    */
    function modulo()
    {
      try {
        //Se recibe el parámetro y se almacena en una variable
        $vista = $_GET['vista'];
        //Se verifica que la variable no se encuentre vacía
        if (!empty($vista)){
            //Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
          if ($this->comprobarSesion()) {
            //Se hace uso de la función render(string Controller, string View [, bool])
              $this->view->render($this,$vista);
          }else{
            //En caso de que la funcion nos devuelva false nos redirige a la pagina principal del sistema
            header('Location:'.URL);
          }
        }else {
          //En caso de que la variable se encuentre vacía se hace uso de la función error()
          $this->view->render($this,'error',true);
        }
      } catch (Exception $e) {
          //Si no es posible acceder a la vista, nos redirige a la pagina error 404
          $this->view->render($this,'error',true);
      }
    }
      /**
      *   editarRutas():void
      *   Función que recibe un parámetro que posteriormente por medio
      *   de la clase View (./libs/View.php) renderiza
      *   la vista ubicada en './views/Administrador/modificar_ruta.php'
      *   y pasa un parámetro por medio de view a la vista renderizada.
      *   @author Estefania Morales
      *   @version 1.0
      */
    function editarRutas()
    {
      try {
        //Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
        if ($this->comprobarSesion()) {
          //Se recibe el parámetro y se almacena en una variable
          $rt = $_GET['rt'];
          //Se verifica que la variable no se encuentre vacía
          if(!empty($rt)){
            //Se hace uso de la clase view para pasarle el parametro a la vista renderizada
            $this->view->ruta = $rt;
            //Se hace uso de la función render(string Controller, string View [, bool])
            $this->view->render($this,'modificar_ruta');
          }else{
            //En caso de que la funcion se encuentre vacía nos devolvera un 0 en forma de json
            echo json_encode("0",JSON_UNESCAPED_UNICODE);
          }
        }else{
          //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
          header('Location:'.URL);
        }
      } catch (Exception $e) {
        //Si no es posible acceder a la vista, nos redirige a la pagina error 404
        $this->error();
      }
    }
    /**
    *   editarViajes():void
    *   Función que recibe un parámetro que posteriormente por medio
    *   de la clase View (./libs/View.php) renderiza
    *   la vista ubicada en './views/Administrador/modificar_viaje.php'
    *   y pasa un parámetro por medio de view a la vista renderizada.
    *   @author Estefania Morales
    *   @version 1.0
    */
    function editarViajes()
    {
      try {
        //Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
        if ($this->comprobarSesion()) {
          //Se recibe el parámetro y se almacena en una variable
          $vj = $_GET['vj'];
          //Se verifica que la variable no se encuentre vacía
          if(!empty($vj)){
              //Se hace uso de la clase view para pasarle el parametro a la vista renderizada
            $this->view->viaje = $vj;
              //Se hace uso de la función render(string Controller, string View [, bool])
            $this->view->render($this,'modificar_viaje');
          }else {
              //En caso de que la funcion se encuentre vacía nos devolvera un 0 en forma de json
            echo json_encode("0",JSON_UNESCAPED_UNICODE);
          }
        }else{
          //En caso de que la funcion nos devuelva false nos redirige a la pagina principal del sistema
          header('Location:'.URL);
        }
      } catch (Exception $e) {
        //Si no es posible acceder a la vista, nos redirige a la pagina error 404
        $this->error();
      }
    }

    /*------------------------------------chofer--------------------------------------*/
     /**
    *   RegChofer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/registrar_chofer.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function RegChofer()
    {
      if ($this->comprobarSesion()) {
        $this->view->render($this,'registrar_chofer');
      }else{
        header('Location:'.URL);
      }
    }

    /**
    *   modChofer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/modificar_chofer.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function modChofer()
    {
      if ($this->comprobarSesion()) {
        $this->view->render($this,'modificar_chofer');
      }else{
        header('Location:'.URL);
      }
    }

    /**
    *   agregarChofer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/registrar_chofer.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function agregarChofer()
    {
      if(empty($_POST)){
        echo "no";
      }else {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $expediente = $_POST['expediente'];
        $correo = $_POST['correo'];
        $pass = $_POST['pass'];
        $tel = $_POST['tel'];
        $status = 5;

        $numLicencia = $_POST['numLicencia'];
        $fechaContra = $_POST['fecha'];
        $telFamilia = $_POST['telr'];

        /*carga un modelo distinto al controlador Administrador que es Chofer*/
          $this->loadOtherModel('Chofer');

        /*consulta msql que trae los expedientes LIKE el expediente que trae del $_POST*/
        $selectKey = $this->Chofer->selectExp($expediente);
        /*consulta msql que trae los correos LIKE el correo que trae del $_POST*/
        $selectKe = $this->Chofer->selectCor($correo);
        if(!is_array($selectKey)){
          if(!is_array($selectKe)){

            /**
            *  Se inserta el chofer con los parametros enviados por $POST
            *  @param Int expediente - guarda el expediente del chofer
            *  @param String nombre - guarda el nombre del chofer
            *  @param String apellido - guarda el apellido del chofer
            *  @param String correo - guarda el correo del chofer
            *  @param String pass - guarda la contraseña del chofer
            *  @param String tel - guarda el telefono del chofer
            *  @param Int status - se guarda con un status de 5
            */
            $insertarChoferU = $this->Chofer->insertChoferU($expediente, $nombre, $apellido, $correo, $pass, $tel, $status);

                if($insertarChoferU == '1'){
                /**
                * Trae el expediente y el numero de licencia registrados en la db para poder verificar si existen ya que no se puede duplicar el expediente y la licencia.
                */
                $selectChofer = $this->Chofer->selectExp($expediente);
                $exp = $selectChofer['idUsuario'];
                $selectLic = $this->Chofer->selectLic($numLicencia);

                  if(!is_array($selectLic)){
                    /**
                    * Se inserta las caracteristicas del chofer enviadas por $POST
                    * @param String numLicencia - guarda el numero de licencia del chofer
                    * @param Date fechaContra - guarda la fecha de contratacion del chofer
                    * @param String telFamilia - guarda el numero del familiar (opcional)
                    * @param Int exp - guarda el id del usuario
                    */
                    $insertarChofer = $this->Chofer->insertChofer($numLicencia, $fechaContra, $telFamilia, $exp);
                    
                    echo json_encode("1");
                  }else{
                   

                    echo json_encode("Licencia Incorrecta");
                    /**
                    * Si la licencia ya existe, se borra el chofer que anteriormente se agrego a la db y no se insertan las caracteristicas del chofer
                    */
                    $eliminarU = $this->Chofer->deleteChoferD($exp);
                    
                  }

                }else{
                 
                 echo json_encode("no1");
                }


          }else{
            echo json_encode("Correo Existente");
          }

        }else{
          echo json_encode("Expediente Existente");

        }


      }
    }

    /**
    *   mostrarChofer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/choferes.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function mostrarChofer(){

      /*carga un modelo distinto al controlador Administrador que es Chofer*/
      $this->loadOtherModel('Chofer');

      /**
      * Trae de la base de datos todos los choferes registrados en la db con el status 5(Chofer)
      */
      $mostrar = $this->Chofer->selectChofer();

       if($mostrar == "No se encontró ningún registro"){
        echo json_encode("no");
      }else {
        echo json_encode($mostrar, JSON_UNESCAPED_UNICODE );
      }

    }

    /**
    *   eliminarChofer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/choferes.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function eliminarChofer(){

      $id = $_POST['id'];
      /*carga un modelo distinto al controlador Administrador que es Chofer*/
      $this->loadOtherModel('Chofer');
      /**
      * Se hace un delete by status en el cual se actualiza el status a 6 que es eliminado
      */
      $eliminarU = $this->Chofer->deleteChoferU($id); /*user*/
      $eliminar = $this->Chofer->deleteChofer($id);  /*caracteristicas*/
       echo json_encode("1");
    }

    /**
    *   mostrarEdit():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/modificar_chofer.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function mostrarEdit(){
      $id = $_POST['id'];
      /**
      * Trae todos los datos del usuario que se selecciona para modificar
      * @param Int id - guarda el identificador del chofer seleccionado
      */
      /*carga un modelo distinto al controlador Administrador que es Chofer*/
      $this->loadOtherModel('Chofer');
      $mostrar = $this->Chofer->selectEditar($id);
      if($mostrar == "No se encontró ningún registro"){
        echo json_encode("no");
      }else {
        echo json_encode($mostrar);
      }

    }

    /**
    *   update():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/modificar_chofer.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function update(){

      $id = $_POST['id'];
      $newNombre = $_POST['newNombre'];
      $newApellido = $_POST['newApellido'];
      $newCorreo = $_POST['newCorreo'];
      $newPass = $_POST['newPass'];
      $newTel = $_POST['newTel'];
      $newlic = $_POST['newlic'];
      $newTel2 = $_POST['newTel2'];


      /*carga un modelo distinto al controlador Administrador que es Chofer*/
      $this->loadOtherModel('Chofer');

        if ($newPass == "5jwabb1uy61khwawhw103mh1") {
          /**
          * Se actuializa la informacion del chofer seleccionado con la informacion que recibe por $POST, si no se modifica la contraseña la contraseña seguira igual
          * @param Int id - guarda el id del chofer
          * @param String newNombre - guarda el nombre del chofer
          * @param String newApellido - guarda el apellido del chofer
          * @param String newCorreo - guarda el correo del chofer
          * @param String newTel - guara el telefono del chofer
          * @param String newLic - guarda la liciencia del chofer
          * @param String newTel2 - guarda el telefono de referencia del chofer
          */
          
          $updateUP = $this->Chofer->updateChoferUP($id, $newNombre, $newApellido, $newCorreo, $newTel);
          $updateP = $this->Chofer->updateChofer($id, $newlic, $newTel2);
        }else{
           /**
          * Se actuializa la informacion del chofer seleccionado con la informacion que recibe por $POST
          * @param Int id - guarda el id del chofer
          * @param String newNombre - guarda el nombre del chofer
          * @param String newApellido - guarda el apellido del chofer
          * @param String newCorreo - guarda el correo del chofer
          * @param String newPass - guarda la contraseña del chofer
          * @param String newTel - guara el telefono del chofer
          * @param String newLic - guarda la liciencia del chofer
          * @param String newTel2 - guarda el telefono de referencia del chofer
          */
          $updateU = $this->Chofer->updateChoferU($id, $newNombre, $newApellido, $newCorreo, $newPass, $newTel);
          $update = $this->Chofer->updateChofer($id, $newlic, $newTel2);
        }


    }

    /**
    *   traer():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Administrador/retroalimentacion.php';
    *   @author Jose David Lozano Ortiz
    *   @version 1.0
    */
    function traer(){

          $date = $_POST['date'];

          /*carga un modelo distinto al controlador Administrador que es Chofer*/
          $this->loadOtherModel('Chofer');
          /**
          * Trae las calificaciones guardadas en la base de datos con la fecha seleccionada
          * @param Date date - guarda la fecha seleccionda
          */
          $mostrar = $this->Chofer->traer($date);

            if($mostrar == "No se encontró ningún registro"){
              echo json_encode("no");
            }else {
              echo json_encode($mostrar);
            }

    }



}

 ?>
