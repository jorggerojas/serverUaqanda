<?php
  class Camiones extends Controller
  {

    function __construct(){
      parent::__construct();
    }
//_________________________Unidad__________________________________
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
  * datosUnidades(): void
  * Funcion que hace uso de la clase Camiones_model (./models/Camiones_model.php)
  * para obtener información de los camiones registrados en la base de datos como
  * unidades devolverlos por medio de un objeto de tipo JSON.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function datosUnidades()
  {
     // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)){
          // Se obtienen los datos de la funcion selectUnidad() y se almacenan en la variable $unidades
          $unidades = $this->model->selectUnidad();
          // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
          if (is_array($unidades)) {
            // Se crea un arreglo donde se almacenaran los datos de la unidad
            $un = [];
            // Por medio del ciclo foreach se recorre el arreglo obtenido en unidades
            foreach ($unidades as $unidad => $columna) {
              // Los datos se almacenan en variables
              $id = $columna['idUnidad'];
              $cp = $columna['Capacidad'];
              $pl = $columna['Placa'];
              $md = $columna['Modelo'];
              $cm = $columna['Campus'];
              // Las variables se almacenan en el arreglo previamente creado
              $un[] = [$id,$cp,$pl,$md,$cm];
            }
            // Se devuelve el arreglo por medio de un objeto tipo JSON

            echo json_encode($un, JSON_UNESCAPED_UNICODE);
          }else {
            // Si el arreglo devuelto por la función selectUnidad() se encuentra vacio se devuelve un 1
            echo json_encode("1", JSON_UNESCAPED_UNICODE);
          }
        }else {
            // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (\Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * registrarUnidad(): void
  * Funcion que recibe datos del usuario por medio del metodo POST, que almacena
  * almacena en variables para posteriormente hacer uso de la de la fucion
  * insertUnidad(int capacidad, string placa, string modelo, string campus)
  * de la clase Camiones_model (./models/Camiones_model.php)
  * la cual inserta los datos en la base de datos y nos devuelve un 1
  * en caso de que se registre correctamente, devuelve el resultado por medio
  * de un objeto de tipo JSON.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
    function registrarUnidad()
    {
      // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
      if ($this->comprobarSesion()) {
        try{
          // Se verifica que los datos enviados por metodo POST no esten vacios
          if(!empty($_POST)){
          // Se obtienen los datos y se verifica que no tengan signos y en caso de tenerlos los remplaza por un espacio en blanco
          // y los almacena en variables
          $cap = Seguridad::checkdata($_POST['cap']);
          $pl = Seguridad::checkdata($_POST['pl']);
          $mod = Seguridad::checkdata($_POST['mod']);
          $cam = Seguridad::checkdata($_POST['cam']);
          // Se pasan como parametros en la funcion insertUnidad(int $cap, string $pl, string $mod, string $cam)
            $op = $this->model->insertUnidad($cap,$pl,$mod, $cam);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
            echo json_encode($op, JSON_UNESCAPED_UNICODE);
          }else{
            // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
            echo json_encode("2", JSON_UNESCAPED_UNICODE);
          }
        }catch (Exception $e) {
            // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
            // 3 por medio de un objeto tipo JSON
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
        }
      }else {
        //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
        header('Location:'.URL);
      }
    }
    /**
    * mostrarSolicitudes(): void
    * Función hace uso de la función selectSolicitudUnidad() de la clase Camiones_model,
    * para poder obtener los datos de la solicitud de unidad y devolverlos en forma de arreglo.
    *   @author Estefania Morales Becerra
    *   @version 1.0
    */
    function mostrarSolicitudes()
    {
      // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
      if ($this->comprobarSesion()) {
        try{
          // Se verifica que los datos enviados por metodo POST no esten vacios
          if (!empty($_POST)) {
            // Se llama a la funcion selectSolicitudUnidad() la cual nos devuelve las solicitudes pendientes
            // y las almacena en una variable
            $solicitudes = $this->model->selectSolicitudUnidad();
            // Se evalua que lo que se obtuvo en la base de datos no se encuentre vacio.
            if(is_array($solicitudes)){
              // Se crea un arreglo donde se almacenaran los datos de las soliciudes
              $datoSolicitud = [];
              // Por medio del ciclo foreach se recorre el arreglo obtenido en solicitudes
              foreach ($solicitudes as $solicitudes => $columna) {
                // Los datos se almacenan en variables
                $idSolicitud  = $columna['idSolicitud'];
                $nombre = $columna['Nombre'];
                $puntoIni = $columna['PuntoInicial'];
                $puntoFin = $columna['PuntoFinal'];
                $destino = $columna['Destino'];
                $justificacion = $columna['Justificacion'];
                // Las variables se almacenan en el arreglo previamente creado
                $datoSolicitud[] = [$idSolicitud, $nombre, $puntoIni, $puntoFin,
                                    $destino, $justificacion];
              }
              // Se devuelve el arreglo por medio de un objeto tipo JSON
              echo json_encode($datoSolicitud, JSON_UNESCAPED_UNICODE);
          }else{
              // Si el arreglo devuelto por la función selectUnidad() se encuentra vacio se devuelve un 1
            echo json_encode("1", JSON_UNESCAPED_UNICODE);
          }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * aprobarSolicitudUnidad(): void
  * Función hace uso de la funcion aprobarSolicitudUnidad(int $id) de la clase Camiones_model
  * para poder realizar cambios en la base de datos, aceptando una solicitud de unidad.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function aprobarSolicitudUnidad()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)) {
          // Se recibe el id por medio del metodo POST y se almacena en la variable id
          $id = $_POST['id'];
          // Se llama a la funcion aprobarSolicitudUnidad(int $id)
          $op = $this->model->aprobarSolicitudUnidad($id);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
        //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * eliminarSolicitudUnidad(): void
  * Función hace uso de la función deleteSolicitudUnidad(int $id) de la clase Camiones_model
  * para poder realizar cambios en la base de datos eliminando una solicitud de unidad.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function eliminarSolicitudUnidad()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)) {
          // Se recibe el id por medio del metodo POST y se almacena en la variable id
          $id = $_POST['id'];
          // Se llama a la funcion deleteSolicitudUnidad(int $id)
          $op = $this->model->deleteSolicitudUnidad($id);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * eliminarUnidad(): void
  * Función hace uso de la función deleteUnidad(int $id) de la clase Camiones_model
  * para realizar modificaciones en la base de datos cambiando el status de la unidad a 6: eliminado
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function eliminarUnidad()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST['id'])) {
          // Se recibe el id por medio del metodo POST y se almacena en la variable id
          $id = $_POST['id'];
          // Se llama a la funcion deleteUnidad(int $id)
          $op = $this->model->deleteUnidad($id);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else{
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  // ______________________________Rutas_____________________________
  /**
  * datosRutas(): void
  * Función hace uso de la función selectRuta() de la clase Camiones_model la cual
  * nos devuelve un conjunto de datos de las rutas existentes para poder almacenarlas en un
  * arreglo y retornarlas por medio de un objeto de tipo JSON.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function datosRutas()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)){
          // Se obtienen los datos de la funcion selectRuta() y se almacenan en la variable $rutas
          $rutas = $this->model->selectRuta();
          // Se evalua que lo que se obtuvo en la base de datos no se encuentre vacio.
          if (is_array($rutas)) {
            // Se crea un arreglo donde se almacenaran los datos de la ruta
            $rt = [];
            // Por medio del ciclo foreach se recorre el arreglo obtenido en rutas
            foreach ($rutas as $ruta => $columna) {
              // Los datos se almacenan en variables
              $id = $columna['idRuta'];
              $pi = $columna['PuntoInicial'];
              $pf = $columna['PuntoFinal'];
              $ad = $columna['Adicional'];
              // Las variables se almacenan en el arreglo previamente creado
              $rt[] = [$id,$pi,$pf,$ad];
            }
            // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
            echo json_encode($rt, JSON_UNESCAPED_UNICODE);
          }else {
            // Si el arreglo devuelto por la función selectUnidad() se encuentra vacio se devuelve un 1
            echo json_encode("1", JSON_UNESCAPED_UNICODE);
          }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * datosRutas(): void
  * Función recibe datos por el metodo POST y
  * hace uso de la función insertarRuta(String $Sd, String $Pi, String $Dt) de la clase Camiones_model
  * la cual nos permite insertar en la base de datos como un nuevo registro de Rutas.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function registrarRutas()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try{
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)) {
          // Se obtienen los datos y se verifica que no tengan signos y en caso de tenerlos los remplaza por un espacio en blanco
          // y los almacena en variables
          $Sd = Seguridad::checkdata($_POST['Sd']);
          $Pi = Seguridad::checkdata($_POST['Pi']);
          $Dt = Seguridad::checkdata($_POST['Dt']);
          // Se pasan como parametros en la funcion insertarRuta(String $Sd, String $Pi, String $Dt)
          $op = $this->model->insertarRuta($Sd,$Pi,$Dt);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * datosRutas(): void
  * Función hace uso de la función modificarRuta(int $rt) de la clase Camiones_model la cual
  * nos permite traer los datos de un registro de rutas en especifico usando el id para encontrarlo.
  * Y posteriormente retornarlos en un arreglo por medio de un objeto de tipo JSON
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function modificarRuta()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se crea un arreglo donde se almacenaran los datos de la ruta
        $datos = [];
        // Se reciben datos por medio del metodo POST y se revisa con la funcio checkData(String) y se almacena en la variable $rt
        $rt = Seguridad::checkdata($_POST['rt']);
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($rt)) {
          // Se llama a la funcion modificarRuta(int $rt)
          $ruta = $this->model->modificarRuta($rt);
          // Se evalua que lo que se obtuvo en la base de datos no se encuentre vacio.
          if (is_array($ruta)) {
            //Los datos de la ruta se almacenan en variables
            $id = $ruta['idRuta'];
            $pi = $ruta['PuntoInicial'];
            $pf = $ruta['PuntoFinal'];
            $ad = $ruta['Adicional'];
            // Las variables se almacenan en el arreglo previamente creado
            $datos[] = [$id,$pi,$pf,$ad];
            // Se devuelve el arreglo por medio de un objeto de tipo JSON
            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
          }else {
            // Si el arreglo devuelto por la función modificarRuta($int $rt) se encuentra vacio se devuelve un 1
            echo json_encode("1", JSON_UNESCAPED_UNICODE);
          }
        }else{
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * guardarCamRuta(): void
  * Función hace uso de la función editarRuta(int $idR, String $Sd, String $Pi, String $Dt)
  * de la clase Camiones_model() la cual nos permite editar un registro de la base de datos
  * obteniendo los valores por el metodo POST y pasandoselos a la funcion para asi guardarlos
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function guardarCamRuta()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try{
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)) {
          // Se obtienen los datos y se verifica que no tengan signos y en caso de tenerlos los remplaza por un espacio en blanco
          // y los almacena en variables
          $idR = Seguridad::checkdata($_POST['id']);
          $Sd = Seguridad::checkdata($_POST['Sd']);
          $Pi = Seguridad::checkdata($_POST['Pi']);
          $Dt = Seguridad::checkdata($_POST['Dt']);
          // Se pasan como parametros en la funcion editarRuta
          $op = $this->model->editarRuta($idR,$Sd,$Pi,$Dt);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * eliminarRuta(): void
  * Función hace uso de la función deleteRuta(int $id) de la clase Camiones_model()
  * la cual nos permite editar un registro de la base de datos
  * obteniendo los valores por el metodo POST, modificando su status a 6: eliminado
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function eliminarRuta()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST['id'])) {
          // Se recibe el id por medio del metodo POST y se almacena en la variable $id
          $id = $_POST['id'];
          // Se llama a la funcion deleteRuta(int $id)
          $op = $this->model->deleteRuta($id);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  // ______________________________Viajes_________________________________
  /**
  * datosViajes(): void
  * Función hace uso de la función selectViaje() de la clase Camiones_model()
  * la cual nos devuelve los datos de los viajes, en respuesta al identificador que recibe
  * por el metodo POST, y que almaacena en una variable para despues devolverlos como un objeto de tipo JSON
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function datosViajes()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)){
          // Se obtiene por medio del metodo POST un identificador que nos dira que datos buscar y se almacenan en la variable $ver
          $ver = $_POST['ver'];
          // Si el idetificador es igual a 1 traeremos los datos de todos los viajes sin importar su estatus
          // con la función selectViaje()
          if ($ver == 1) {
            $viajes = $this->model->selectViaje();
            // Si el identificador es igual a 2 traeremos los datos de los viajes que tienen status
            // 'En espera' con la funcion selectViajeStatus(String) y el parametro 'En espera'
          }elseif ($ver == 2) {
            $viajes = $this->model->selectViajeStatus('En espera');
            // Si el identificador es igual a 2 traeremos los datos de los viajes que tienen status
            // 'En curso' con la funcion selectViajeStatus(String) y el parametro 'En curso'
          }elseif ($ver == 3) {
            $viajes = $this->model->selectViajeStatus('En curso');
            // Si el identificador es igual a 2 traeremos los datos de los viajes que tienen status
            // 'Finalizado' con la funcion selectViajeStatus(String) y el parametro 'Finalizado'
          }elseif ($ver == 4) {
            $viajes = $this->model->selectViajeStatus('Finalizado');
          }
          // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
          if (is_array($viajes)) {
            // Se crea un arreglo donde se almacenaran los datos de los viajes
            $vj = [];
            // Por medio del ciclo foreach se recorre el arreglo obtenido en viajes
            foreach ($viajes as $viaje => $columna) {
              // Los datos se almacenan en variables
              $id = $columna['Viaje'];
              $hr = $columna['hr'];
              $cf = $columna['Chofer'];
              $un = $columna['Unidad'];
              $pi = $columna['RutaI'];
              $pf = $columna['RutaF'];
              $st = $columna['status'];
              // Los datos de la ruta se juntan en una sola variable
              $ruta = $pi."-".$pf;
              // Las variables se almacenan en el arreglo previamente creado
              $vj[] = [$id,$hr,$cf,$un,$ruta,$st];
            }
            // Se devuelve el arreglo por medio de un objeto de tipo JSON
            echo json_encode($vj, JSON_UNESCAPED_UNICODE);
          }else {
            // Si el arreglo devuelto por la función se encuentra vacio se devuelve un 1
            echo json_encode("1", JSON_UNESCAPED_UNICODE);
          }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * choferes(): array
  * Función hace uso de la función selectChofer()  de la clase Camiones_model()
  * la cual nos devuelve un conjunto de datos de los registros de choferes que se encuentran en la base de datos
  * los cuales almacena en un arreglo para posteriormente returnarlo.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function choferes()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se crea un arreglo donde se almacenaran los datos de los choferes
        $choferes = [];
        // Se obtienen los datos de los choferes por medio de la funcion selectChofer()
        $cf = $this->model->selectChofer();
        // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
        if(is_array($cf)){
          // Por medio de un ciclo foreach se recorre el arreglo obtenido en $cf
          foreach ($cf as $chofer => $columna) {
            // Los datos se almacenan en variables
            $id = $columna['idChofer'];
            $nombre = $columna['Nombre'];
            $apellido = $columna['Apellido'];
            // Las variables se almacenan en el arreglo previamente creado
            $choferes[] = [$id,$nombre." ".$apellido];
          }
          // Se returna el arreglo
          return $choferes;
        }else {
          // En caso de que no se encuentren datos en la base de datos se returna un 1
          return 1;
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        return 1;
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * unidades(): array
  * Función hace uso de la función selectUnidadV() de la clase Camiones_model()
  * la cual nos devuelve un conjunto de datos de los registros de unidades que se encuentran en la base de datos
  * los cuales almacena en un arreglo para posteriormente returnarlo.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function unidades()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se crea un arreglo donde se almacenaran los datos de las unidades
          $unidades = [];
          // Se obtienen los datos de las unidades por medio de la funcion selectUnidadV()
          $un = $this->model->selectUnidadV();
          // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
          if (is_array($un)) {
            // Por medio de un ciclo foreach se recorre el arreglo obtenido en un
            foreach ($un as $unidad => $columna) {
              // Los datos se almacenan en variables
              $id = $columna['idUnidad'];
              $placa = $columna['placa'];
              // Las variables se almacenan en el arreglo previamente creado
              $unidades[] = [$id,$placa];
            }
            // Se returna el arreglo
            return $unidades;
          }else {
            // En caso de que no se encuentren datos en la base de datos se returna un 1
            return 1;
          }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        return 1;
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * rutas(): array
  * Función hace uso de la función selectRutaV()  de la clase Camiones_model()
  * la cual nos devuelve un conjunto de datos de los registros de rutas que se encuentran en la base de datos
  * los cuales almacena en un arreglo para posteriormente returnarlo.
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function rutas()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se crea un arreglo donde se almacenaran los datos de las rutas
        $rutas = [];
        // Se obtienen los datos de las rutas por medio de la funcion selectRutaV()
        $rt = $this->model->selectRutaV();
        // Se evalua que lo que se obtuvo en la base de datos no se encuentre vacio.
        if(is_array($rt)){
          // Por medio de un ciclo foreach se recorre el arreglo obtenido en $rt
          foreach ($rt as $ruta => $columna) {
            // Los datos se almacenan en variables
            $id = $columna['idRuta'];
            $pi = $columna['PuntoInicial'];
            $pf = $columna['PuntoFinal'];
            $In = $columna['Adicional'];
            // Las variables se almacenan en el arreglo previamente creado
            $rutas[] = [$id,$pi,$pf,$In];
          }
          // Se returna el arreglo
          return $rutas;
        }else {
          // En caso de que no se encuentren datos en la base de datos se returna un 1
          return 1;
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        return 1;
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * datosViaje(): void
  * Función hace uso de las diferentes funciones choferes(), unidades() y rutas()
  * para poder asi obtener los datos activos que se pueden usar en un viaje, y comprobando
  * que todos sean diferentes de vacio y devolviendolos por medio de un arreglo, convertido en un
  * objeto de tipo JSON
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function datosViaje()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try{
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if(!empty($_POST)){
            // Se obtienen los datos de choferes de la funcion choferes() y se almacenan en una variable
            $choferes = $this->choferes();
            // Se obtienen los datos de unidades de la funcion unidades() y se almacenan en una variable
            $unidades = $this->unidades();
            // Se obtienen los datos de rutas de la funcion rutas() y se almacenan en una variable
            $rutas = $this->rutas();
            // Si todas las variables son diferentes de uno, estas se almacenan en un arreglo
            if($choferes != 1 && $unidades != 1 && $rutas != 1){
              $datos[] = [$choferes, $unidades, $rutas];
              // El arreglo se devuelve a la vista como un objeto de tipo JSON
              echo json_encode($datos, JSON_UNESCAPED_UNICODE);
          // En caso de que choferes sea igual a uno este se sustituye por un 1 en el arreglo.
          }elseif ($choferes == 1) {
            $datos[] = [1, $unidades, $rutas];
            // El arreglo se devuelve a la vista como un objeto de tipo JSON
            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
          // En caso de que unidades sea igual a uno este se sustituye por un 1 en el arreglo.
          }elseif ($unidades == 1) {
            $datos[] = [$choferes, 1, $rutas];
            // El arreglo se devuelve a la vista como un objeto de tipo JSON
            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
          // En caso de que rutas sea igual a uno este se sustituye por un 1 en el arreglo.
          }elseif ($rutas == 1) {
            $datos[] = [$choferes, $unidades, 1];
            // El arreglo se devuelve a la vista como un objeto de tipo JSON
            print_r($datos, JSON_UNESCAPED_UNICODE);
          }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * registrarViajes(): void
  * Función hace uso de las funciones ComprCf(time $date, int $cf), y la funcion ComprUn(time $date,()
  * para comprobar que se puedan realiar inserciones correctas en la base de datos
  * si estos resultan ser positivos se realiza la insercion de un nuevo registro en la base de datos
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function registrarViajes()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try{
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST)) {
          // Se declara dos variables que nos serviran como bandera
          $bandCf = 0;
          $bandUn = 0;
          // Se obtienen los datos y se verifica que no tengan signos y en caso de tenerlos los remplaza por un espacio en blanco
          // y los almacena en variables
          $hrs = Seguridad::checkdata($_POST['hrs']);
          $min = Seguridad::checkdata($_POST['min']);
          $cf = Seguridad::checkdata($_POST['cf']);
          $un = Seguridad::checkdata($_POST['un']);
          $rt = Seguridad::checkdata($_POST['rt']);
          // Los valores del tiempo se juntan en una sola variable
          $time = $hrs.":".$min.":00";
          // Se almacena la fecha en una variable, se hace uso de la funcion date
          $date = date("Y-m-d");
          //Se hace uso de la funcion ComprCf(time $date, int $cf), y la funcion ComprUn(time $date, int $un)
          // las cuales nos devuelven la hora del viaje y se almacenan en variables
          $comprcf = $this->model->ComprCf($date,$cf);
          $comprUn = $this->model->ComprUn($date,$un);
          // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
          if (is_array($comprcf)) {
            // Por medio del ciclo foreach se recorre el arreglo obtenido en $comprcf
            foreach ($comprcf as $times => $col) {
              // Haciendo uso de los horarios que nos devuelven le disminuimos una hora para hacer comparaciones
              // y lo almacenamos en una variable, se hace uso de la funcion date()
              $hrmenos = date('H:i:s',strtotime('-1 hours', strtotime($col['Horario'])));
              // Haciendo uso de los horarios que nos devuelven le aumentamos una hora para hacer comparaciones
              // y lo almacenamos en una variable, se hace uso de la función date()
              $hrmas = date('H:i:s',strtotime('+1 hours', strtotime($col['Horario'])));
              // Hacemos uso de la función date() para que nuestrio tiempo se convierta a tipo de dato date
              $time = date('H:i:s',strtotime($time));
              // Comprobamos que la hora del viaje que vamos a incertar no coincida con otro horario
              if ($hrmenos<$time && $time<$col['Horario']) {
                // Si es asi nuestra bandera $bandCf cambia a 1
                $bandCf = 1;
              }
            }
          }
          // Se evalua que lo que se obtuvo de la base de datos no se encuentre vacio.
          if (is_array($comprUn)) {
            // Por medio del ciclo foreach se recorre el arreglo obtenido en $comprUn
            foreach ($comprUn as $times => $col) {
              // Haciendo uso de los horarios que nos devuelven le disminuimos una hora para hacer comparaciones
              // y lo almacenamos en una variable, se hace uso de la funcion date()
              $hrmenos = date('H:i:s',strtotime('-1 hours', strtotime($col['Horario'])));
              // Haciendo uso de los horarios que nos devuelven le aumentamos una hora para hacer comparaciones
              // y lo almacenamos en una variable, se hace uso de la función date()
              $hrmas = date('H:i:s',strtotime('+1 hours', strtotime($col['Horario'])));
              // Hacemos uso de la función date() para que nuestrio tiempo se convierta a tipo de dato date
              $time = date('H:i:s',strtotime($time));
              // Comprobamos que la hora del viaje que vamos a incertar no coincida con otro horario
              if ($hrmenos<$time && $time<$col['Horario']) {
                // Si es asi nuestra bandera $bandCf cambia a 1
                $bandUn = 1;
              }
            }
          }
          // Se comprueba si la bandera de chofer esta en 0
          if ($bandCf == 0) {
            // Se compruba si la bandera de la unidad esta en 0
            if ($bandUn == 0) {
              // Se envian los datos a la funcion insertViaje
              $op = $this->model->insertViaje($time,$cf,$un,$rt);
                // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
              echo json_encode($op, JSON_UNESCAPED_UNICODE);
            }else {
              // En caso de que la bandera de unidad sea 1 se envia un dato por medio de un objeto tipo JSON
              //para indicar que el chofer ya esta en un viaje
              echo json_encode("un",JSON_UNESCAPED_UNICODE);
            }
          }else {
            // En caso de que la bandera de chofer sea 1 se envia un dato por medio de un objeto tipo JSON
            //para indicar que la unidad ya esta asignada en un viaje
            echo json_encode("cf",JSON_UNESCAPED_UNICODE);
          }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * modificarViaje(): void
  * Función hace uso de las funciones selectViajeid(int $id) para obtener el horario del viaje que se
  * desea modificar y en caso de que se pueda realiza el cambio, hace uso de la funcion editarViaje(int $id, int $cf, int $un, int $rt)
  * para poder asi modificar los datos con respecto a chofer, ruta, y unidad de un registro ya realizado
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function modificarViaje()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try{
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if(!empty($_POST)){
            $id = $_POST['id'];
            $viaje = $this->model->selectViajeid($id);
            // Haciendo uso de los horarios que nos devuelven le disminuimos una hora para hacer comparaciones
            // y lo almacenamos en una variable, se hace uso de la funcion date()
            $hrmenos = date('H:i:s',strtotime('-1 hours', strtotime($viaje['horario'])));
            // Se almacena la hora en la que se quiere eliminar el viaje por medio de la función date()
            $time = date('H:i:s');
            // Se comprueba que la hora en que se desea eliminar sea mayor que 1 hora antes del viaje
            if($hrmenos<$time){
              // Si es asi se devuelve un dato por medio de un objeto de tipo JSON que quiere decir que
              // se desea eliminar con menos de una hora de anticipacion el viaje
              echo json_encode("md", JSON_UNESCAPED_UNICODE);
            }else {
              // Si no existe inconveniente con el horario se reciben los datos a modificar y se almmacenan en variables
              $cf = $_POST['cf'];
              $un = $_POST['un'];
              $rt = $_POST['rt'];
              // Se llama la funcion editarViaje(int $id, int $cf, int $un, int $rt)
              $op = $this->model->editarViaje($id,$cf,$un,$rt);
              // Se returna lo que nos devuelve la funcion como un objeto de tipo JSON
              echo json_encode($op, JSON_UNESCAPED_UNICODE);
            }
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2",JSON_UNESCAPED_UNICODE);
        }
      }catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
        echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * eliminarViaje(): void
  * Función hace uso de la función deleteViaje(int $id) de la clase Camiones_model()
  * la cual nos permite editar un registro de la base de datos
  * obteniendo los valores por el metodo POST, modificando su status a 6: eliminado
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function eliminarViaje()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST['id'])) {
          // Se recibe el id por medio del metodo POST y se almacena en la variable id
          $id = $_POST['id'];
          // Se llama a la funcion deleteViaje() con la variable id como parámetro
          $op = $this->model->deleteViaje($id);
          // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
          echo json_encode($op, JSON_UNESCAPED_UNICODE);
        }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
  /**
  * eliminarVespera(): void
  * Función hace uso de la función comprV(int $id) de la clase Camiones_model()
  * la cual nos devuelve datos acerca del horario del registro que se desea eliminar
  * despues comparandolo con la hora actual, y si este resulta estar con mas de 1hr de anticipación
  * se permitira modificar el status del registro a 6: eliminado
  *   @author Estefania Morales Becerra
  *   @version 1.0
  */
  function eliminarVespera()
  {
    // Se verifica la existencias de las variables de sesion y que estas sean diferentes de nulo
    if ($this->comprobarSesion()) {
      try {
        // Se verifica que los datos enviados por metodo POST no esten vacios
        if (!empty($_POST['id'])) {
            // Se recibe el id por medio del metodo POST y se almacena en la variable id
            $id = $_POST['id'];
            // Se llama a la funcion ComprV(int $id) y se almacena en $horario
            $horario = $this->model->ComprV($id);
            // Haciendo uso de los horarios que nos devuelven le disminuimos una hora para hacer comparaciones
            // y lo almacenamos en una variable, se hace uso de la funcion date()
            $hrmenos = date('H:i:s',strtotime('-1 hours', strtotime($horario['Horario'])));
            // Se almacena la hora en la que se quiere eliminar el viaje por medio de la función date()
            $time = date('H:i:s');
            // Se comprueba que la hora en que se desea eliminar sea mayor que 1 hora antes del viaje
            if($hrmenos<$time){
              // Si es asi se devuelve un dato por medio de un objeto de tipo JSON que quiere decir que
              // se desea eliminar con menos de una hora de anticipacion el viaje
              echo json_encode("el", JSON_UNESCAPED_UNICODE);
            }else {
              // Si hace falta mas de una hora para que comience el viaje se manda llamar a la funcion deleteViaje(int $id)
              $op = $this->model->deleteViaje($id);
              // Se devuelve lo que nos regresa la funcion por medio de un objeto tipo JSON
              echo json_encode($op, JSON_UNESCAPED_UNICODE);
            }
          }else {
          // Si no se encuentran datos enviados por metodo POST se devuelve un 2 por medio de un objeto tipo JSON
          echo json_encode("2", JSON_UNESCAPED_UNICODE);
        }
      } catch (Exception $e) {
          // En caso de que alguna acción en esta funcion no se pueda realizar se devolvera un
          // 3 por medio de un objeto tipo JSON
          echo json_encode("3", JSON_UNESCAPED_UNICODE);
      }
    }else {
      //En caso de que no se tenga una sesion valida nos redirige a la pagina principal del sistema
      header('Location:'.URL);
    }
  }
}
?>
