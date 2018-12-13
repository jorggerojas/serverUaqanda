<?php
class Index extends Controller{
    function __construct() {
        parent::__construct();
    }

    /**
    *   index():void
    *   Función que hace uso de la clase View (./libs/View.php) para renderizar
    *   la vista ubicada en './views/Index/index.php'; se hace uso de la clase
    *   Session (./libs/Session.php) para destruir la sesión
    *   @author Jorge Luis Rojas Arcos
    *   @version 1.0
    */
    function Index()
    {
      //Se hace referencia a la clase View y
      //se hace uso de la función render(string Controller, string View [, bool])
      $this->view->render($this, 'index');
      //Se destruye las sesiones existentes
      Session::destroy();
    }

    /**
    * iniciarSesion():void
    *     Función que hace uso del model "Index"  y su respectiva función "log(string, string)" para consultar datos de usuario
    *     imprimiendo un JSON con los datos (en caso de ser correcta la consulta) o
    *     un string impreso de error.
    *     Se hace uso de la clase Seguridad (./libs/Seguridad.php) para evitar posibles amenazas
    * @author Jorge Luis Rojas Arcos
    * @version 1.0
    *
    */
    function iniciarSesion()
    {
      //Se verifica que existan datos enviados por POST
      if(!empty($_POST)){
        try {
          //Se verifica que lo enviado en POST no tenga posibles amenazas
          $segExp = Seguridad::checkSeg($_POST['exp']);
          $segPass = Seguridad::checkSeg($_POST['pass']);
          if(!$segExp && !$segPass){
            //Se asignan los datos en las variables $exp y $pw
            $pw = $_POST['pass'];
            $exp = $_POST['exp'];
            /*  La variable $log almacena datos del model "Index"
            *   haciendo uso de la función "log(string clave, string password)" que retorna un string[] con los
            *   datos del usuario.
            */
            $log = $this->model->lg($exp, $pw);
            if(isset($log['Nombre'])){
              if($log['status'] != 5 && $log['Nombre'] != null && $log['status'] != 3 &&
                  $log['status'] != 4 && $log['status'] != 2 && $log['status'] == 1){
                /*
                *   Se crean variables inicializadas con los datos del usuario:
                *   $st = Status del administrador en la base de datos
                *   $nm = Nombre del administrador en la base de datos
                *   $mail = Correo del administrador en la base de datos
                *   $tl = Teléfono del administrador en la base de datos
                */
                $st = $log['status'];
                $nm = $log['Nombre'];
                $mail = $log['Correo'];
                $tl = $log['Telefono'];

                /*
                *   Se crea un arreglo de tipo string que almacena las variables creadas
                */
                $data = array('Nombre' => $nm, 'Correo' => $mail,
                              'status' => $st, 'Telefono' => $tl);

                //Se crean variables de sesión con el uso de la clase Session (.libs/Session.php)
                //Se hace uso de la función setValue(string variable, string valor) para crear 3 variables
                //de sesión: 'idUsuario', 'Nombre', 'Correo'
                Session::setValue('idUsuario', $log['idUsuario']);
                Session::setValue('Nombre', $nm);
                Session::setValue('Correo', $mail);

                //Se crea un JSON con el arreglo creado y se imprime el resultado
                echo json_encode($data);
              }else{
                //En caso de el status del administrador no coincida con 'administrador' en la base de datos
                //se imprime un mensaje de error
                echo json_encode("1");
              }
            }else{
              echo json_encode("1");
            }
          }
        } catch (Exception $e) {
          //Catch del posible error en la conexión con el model "Index"
          echo json_encode("1");
        }
      }else{
        echo json_encode("1");
      }

    }
    function cerrarSesion()
    {
      try {
        $id = Controller::sessionExist('idUsuario');
        $nombre = Controller::sessionExist('Nombre');
        $mail = Controller::sessionExist('Correo');
          if($id != null && $nombre != null && $mail != null){
            $this->Index();
          }
      } catch (Exception $e) {

      }
    }

}
?>
