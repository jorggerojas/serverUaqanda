<?php

class Hash{

    public static function create($algoritmo,$data,$key){
        $context = hash_init($algoritmo,HASH_HMAC,$key);
        hash_update($context, $data);
        return hash_final($context);
    }

   	/**
     	*	rehash($dataHash)
     	*
     	*	Adquiere dos refuerzos de seguridad de datos
   	  *	con base64 y sha1
     	*
     	* @author Jorge Luis Rojas Arcos
     	* @version 1.0
     	* @return string $res:
   	  *         retorna una variable string ya con la doble seguridad implementada
     	*
     	*/
    public static function rehash($dataHash){
    	$res = sha1(base64_encode($dataHash));
    	return $res;
    }
}
