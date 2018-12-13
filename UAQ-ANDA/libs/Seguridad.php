<?php

  /**
   * @version 0.1 (Beta)
   */
  class Seguridad
  {
    /**
    * chechSeg($data):boolean
    * Esta función verifica la posible amenaza de inyección de código
    * @author Jorge Luis Rojas Arcos
    * @version 1.0
    * @param $data
    *        Variable que se desee verificar
    * @return boolean
    *         True si encuentra una posible amenaza
    *         False si detecta que es seguro
    */
    static function checkSeg($data)
    {
      $arr = array("<", ">", "'", "/", ".", "*", "=", "!", "#", "{", "}", "+", "-", "%", "&", "(", ")", "$");
      for ($i = 0; $i < sizeof($arr); $i++) {
        if(strpos($data, $arr[$i])){
          return true;
        }else{
          return false;
        }
      }
    }
  static function checkdata($data)
  {
    $arr = array("<", ">", "'", "/", "*", "=", "!", "#", "{", "}", "+", "%", "&", "(", ")", "$");
    for ($i = 0; $i < sizeof($arr); $i++) {
        $data = str_replace($arr[$i]," ", $data);
    }
    return $data;
  }
}


 ?>
