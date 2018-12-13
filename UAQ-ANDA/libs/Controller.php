<?php

class Controller {

    function __construct(){
        Session::init();
        $this->view = new View();
        $this->loadModel();
    }

    function loadModel() {
        $model = get_class($this) . '_model';
        $path = 'models/' . $model . '.php';

        if (file_exists($path)) {
            require_once($path);
            $this->model = new $model();
        }
    }

    function loadOtherModel($model) {
        $nameModel = $model;
        $model = $model. '_model';
        $path = 'models/' . $model . '.php';

        if (file_exists($path)) {
            require_once($path);
            $this->$nameModel = new $model;
        }
    }

    function pageNotFound(){
        $this->view->render('Default', 'error', true);
        //hola
    }

    function pageHistoryBack(){
        $this->view->render('Default','pageHistoryBack',true);
    }

    /**
    * function sessionExist($val = null)
    * Esta función verifica que haya una sesión iniciada; hace uso de
    * la clase Session con su función exist()
    * @author Enrique Aguilar Orozco
    * @version 1.1 por Jorge Luis Rojas Arcos
    * @since Noviembre 2018
    *         Se agrega parámetro de búsqueda por valor de sesión (null por defecto).
    * @example if(isset(sessionExist('Usuario'))){return true;}
    * @param $val
    *         Este parámetro permite realizar una búsqueda exacta de un valor de sesión
    *         Su valor por defecto es null;
    * @return boolean true | string $temp
    *         En caso de existir una sesión y no haya un valor de búsqueda retornará un "true"
    *         En caso de existir una sesión y  haya un valor de búsqueda retornará el valor
    *             de la sesión
    */

    static function sessionExist($val = null){
        if($val == null){
          if(Session::exist()){
            return true;
          }else{
            header('location:'.URL);
          }
        }else{
          $temp = Session::getValue($val);
          if($temp != null){
            return $temp;
          }else{
            return null;
          }
        }
    }

    /**
    * function getkey
    * funcion para generar la llave para la recuperacion de contraseña me diante correo
    * obtien la fecha actual mas la cuenta del usuario, para generar una llave unica para la recuperacion
    * llave genera en base64.
    * @author Enrique Aguilar
    * @param $cuenta
    *
    * @return String: $key(20) llave generada en base64
    */
    public function getKey($cuenta){
        $key = implode(getDate());
        $key.=$cuenta;
        $ran = rand(1,5);
        for ($i=0; $i < $ran; $i++) {
            $key = base64_encode($key);
        }
        return substr($key,0,25);
    }

    /**
    *
    * @var array data
    *   arreglo el cual contine los datos del correo, obligatorio $data['asunto'],$data['correo'],
    *    las demas posiones son opcionales, las cuales serán incrustadas en el correo
    * @var string correoDestino, correo de destino
    * @var string template, template de correo a enviar este es almacenado
    *       en las vistas ruta: Views/Default/correos/...
    * @since agosto 2017
    * @author Enrique Aguilar Orozco
    *
    */
    function sendEmail($data, $template){
        require_once './libs/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();
        ob_start();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        /*cambiar config correo*/
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "noreplysaluduaq@gmail.com";
        $mail->Password = "@saluduaq";
        $mail->Port = 587;
        $mail->FromName = "Revista Aqua-LAC";
        $mail->AddAddress($data['correo']);
        $mail->IsHTML(true);
        $mail->Subject = utf8_decode($data['asunto']);
        $email = include ("./views/Default/correo/{$template}.php");
        $email = ob_get_clean();
        $mail->Body = utf8_decode($email);

        return $mail->Send();
    }


}
?>
