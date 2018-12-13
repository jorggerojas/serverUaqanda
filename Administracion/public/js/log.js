//  Este archivo "log.js" actua en el archivo index.php ubicado en:
//  ././views/Index/index.php

/**
*   checkSeg(string data): boolean
*           Ejemplo: if(checkSeg(usuario)){return true;}
*   @author Jorge Luis Rojas Arcos
*   @version 1.0
*   @params string data
*           Cadena de texto que se desee revisar.
*   @return boolean
*           true/false
*   Esta función verifica la posible existencia de una inyección de código
*   dentro de un una cadena de texto, retorna un "true" en caso de que exista
*   una posible amenaza o un "false" en caso de no encontrar tal.
*/
function checkSeg(data) {
  var arr = ["<", ">", "'", "/", "*", "=", "!", "#", "{", "}", "+", "%", "&", "(", ")", "$"];
  for (var i = 0; i < arr.length; i++) {
    if(data.includes(arr[i])){
      return true;
    }else{
      return false;
    }
  }
}


/**
*   getValues():void
*   @author Jorge Luis Rojas Arcos
*   @version 1.0
*   La función getValues() es la encargada de tomar los valores de la
*   clave/expediente del Administrador de UAQ-ANDA y su contraseña.
*   La función envia los datos ingresados al Controller Index (a la función iniciarSesion()),
*   y recibe la respuesta que el servidor emite, dando acceso o negando el mismo.
*/
function getValues() {
  //Tomamos los valores en las variables "exp" y "pass"
  var exp = document.getElementById('exp').value;
  var pass = document.getElementById('pass').value;
  if(!checkSeg(exp)){
    if (pass != "" && pass != null) {
      pass = pre_hash(pass);
      //Creamos la variable "link" que almacena los datos de "exp" y "pass"
      var link = "exp="+exp+"&pass="+pass;
      //Se crea el objeto "data" para hacer la comunicación con el servidor
      data =  new XMLHttpRequest();
      data.open('POST', config['url'] +"Index/iniciarSesion");
      data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      //Se envían los datos almacenados en "link"
      data.send(link);
      data.onreadystatechange = function(){
        if (data.readyState == 4 && data.status == 200){
          //Se recibe la respuesta y se quita el formato JSON
          try {
            us = JSON.parse(data.responseText);
            if(us != 1){
              //Redirección a pantalla principal
              window.location=config['url']+"Administrador";
            }else{
              alert("Datos incorrectos, intente más tarde");
            }
          } catch (e) {
            Location.reload();
          }
        }
      }
    } else {
      alert("Campos vacíos, verifica tus datos");
    }
  }else{
    alert("Datos incorrectos, intente más tarde");
  }
}
