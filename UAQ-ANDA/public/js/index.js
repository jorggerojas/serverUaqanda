//  Este archivo "index.js" actua en el archivo los archivos ubicados en:
//  ././views/Administrador


// _______________________________________________UNIDADES______________________________________________
/**
*   unidades():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/

function unidades(){
    window.location = config['url']+"Administrador/modulo?vista=unidades";
}

function cargarUnidades(){
  unidades = document.getElementById('inicio');
  divs = "";
  mensaje = "¿Seguro que desea eliminar esta unidad?";
  data = new XMLHttpRequest();
  datos = "unidades=UN";
  data.open('POST', config['url'] +"Camiones/datosUnidades");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
         res = data.responseText;
         try {
           res = JSON.parse(res);
           if(res != "1" && res != "2" && res != "3" ) {
             for(un in res){
               divs +=
               "<div class='caja'>"+
                 "<div class='usuario' >"+
                   "<h4>placa: "+res[un][2]+" Campus: "+res[un][4]+"</h4>"+
                   "<p>Capacidad: "+res[un][1]+"</p>"+
                   "<p>Modelo: "+res[un][3]+"</p>"+
                 "</div>"+
                 "<div class='botones'>"+
                   "<button class='cancel' onclick='modalEliminar("+res[un][0]+",1)'>Eliminar</button>"+
                 "</div>"+
               "</div>"
             }
             unidades.innerHTML = divs;
           }else{
             verifData(res,unidades,"unidades");
           }
         } catch (e) {
           modalMenu("Ocurrio un error inesperado", "menu")
         }
       }
     }
   }
   /**
   *   regUnidades():
   *           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
   *            y envia como parametro la vista que se desea ingresar
   *   @author Alejandra Estefania Morales Becerra
   *   @version 1.0
   *
   */
function regUnidades(){
    window.location = config['url']+"Administrador/modulo?vista=registrar_unidad";
}

function registrarUnidad(){
  ban = 0;
  datos = new FormData(document.getElementById('datos'));
  for (par of datos.entries())
  {
    if (par[1].trim() == "") {
      ban = 1;
    }
  }
    if (ban == 0){
       link = "cap="+datos.get('cap').trim()+"&pl="+datos.get('pl').trim()+"&mod="+datos.get('mod').trim()+"&cam="+datos.get('cam').trim();
       data =  new XMLHttpRequest();
       data.open('POST', config['url']+"Camiones/registrarUnidad");
       data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
       data.send(link);
       data.onreadystatechange = function(){
         if (data.readyState == 4 && data.status == 200) {
            res = (data.responseText);
            try {
              res = JSON.parse(res);
              if (res == true){
                modalMenu("Unidad insertada con exito","unidades")
              }else {
                verModal("Error al insertar los datos. Intente de nuevo mas tarde.",1)
              }
            } catch (e) {
               modalMenu("Ocurrio un error inesperado", "menu");
            }
          }
        }
   }else {
     verModal("Debes llenar todos los campos",0)
   }
 }

 /**
 *   solUnidades():
 *           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
 *            y envia como parametro la vista que se desea ingresar
 *   @author Alejandra Estefania Morales Becerra
 *   @version 1.0
 *
 */
function solUnidades(){
  window.location = config['url']+"Administrador/modulo?vista=solicitud_unidad"
}

function mostrarSolicitudes(){
  var  divs = "";
  var  count = 0;
  var solicitudes =  document.getElementById('solicitudes');
  var contador = document.getElementById('num');
  data =  new XMLHttpRequest();
  datos = "solicitudes=SU"
  data.open('POST', config['url'] +"Camiones/mostrarSolicitudes");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      
      try {
        res = JSON.parse(res);
        if (res != 1 && res != 2 && res != 3) {
        for(sol in res){
          count++;
          divs += "<div class='caja'>"+
                    "<div class='usuario2' id='"+res[sol][0]+"'>"+
                      "<p class='name'>Nombre: "+res[sol][1]+"</p>"+
                      "<p class='ruta'>Ruta: "+res[sol][2]+"-"+res[sol][3]+"</p>"+
                      "<p class='des'>Destino: "+res[sol][4]+"</p>"+
                      "<p class='jus'>Justifiacion: "+res[sol][5]+"</p>"+
                    "</div>"+
                    "<div class='botones2'>"+
                      "<button class='aceptar' id='"+res[sol][0]+"' onclick='aceptarSolUnidad(this.id)'><img src='"+config['img']+"checked.png'></button><br>"+
                      "<button class='rechazar' id='"+res[sol][0]+"' onclick='eliminarSolUnidad(this.id)'><img src='"+config['img']+"cancel.png'></button>"+
                    "</div>"+
                  "</div><br><br>";
        }
        solicitudes.innerHTML += divs;
    }else{
      verifData(res,solicitudes, "solicitudes");
    }
      } catch (e) {
           modalMenu("Ocurrio un error inesperado", "menu");
      }
      document.getElementById('num').innerHTML = count;
    }
  }
}
function aceptarSolUnidad(id){
  data =  new XMLHttpRequest();
  var solicitudes =  document.getElementById('solicitudes');
  datos = "id="+id;
  data.open('POST', config['url'] +"Camiones/aprobarSolicitudUnidad");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = (data.responseText);
      try {
        res = JSON.parse(res);
        if (res == true) {
          document.getElementById(id).style.display = "none";
          verModal("Solicitud aceptada",1);
        }else {
          verifData(res,datos,"solicitudes");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
function eliminarSolUnidad(id){
  data =  new XMLHttpRequest();
  datos = "id="+id;
  data.open('POST', config['url'] +"Camiones/eliminarSolicitudUnidad");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
       res = (data.responseText);
       try {
         res = JSON.parse(res);
         if (res == true) {
           document.getElementById(id).style.display = "none";
           verModal("Solicitud Rechazada",1);
         }else{
           verifData(res,datos,"solicitudes");
         }
       } catch (e) {
         modalMenu("Ocurrio un error inesperado", "menu");
       }
     }
  }
}
function eliminarU(id){
  datos = "id="+id;
  data = new XMLHttpRequest();
  data.open('POST', config['url'] +"Camiones/eliminarUnidad");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      try {
        res  = JSON.parse(res);
        if (res == true) {
          verModal("Unidad eliminada", 1);
        }else {
          verifData(res,datos,"unidades");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
// _______________________________________RUTAS_______________________________________________
/**
*   rutas():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function rutas(){
    window.location = config['url']+"Administrador/modulo?vista=rutas";
}

function cargarRutas(){
  rutas = document.getElementById('inicio');
  divs = "";
  mensaje = "¿Seguro que desea eliminar esta ruta?";
  data =  new XMLHttpRequest();
  datos = "rutas=RT";
  data.open('POST', config['url'] +"Camiones/datosRutas");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
        res = data.responseText;
        try {
          res = JSON.parse(res);
            if (res != 1 && res != 2 && res != 3) {
              for(rt in res){
                divs +=
                "<div class='caja'>"+
                  "<div class='usuario' >"+
                    "<h4>"+res[rt][1]+"-"+res[rt][2]+"</h4>"+
                    "<p>Paradas: "+res[rt][3]+"</p>"+
                  "</div>"+
                  "<div class='botones'>"+
                    "<button class='modificar' onclick='modRutas("+res[rt][0]+")'>Modificar</button>"+
                    "<button class='cancel' onclick='modalEliminar("+res[rt][0]+",2)'>Eliminar</button>"+
                  "</div>"+
                "</div>"
              }
              rutas.innerHTML = divs;
          }else{
            verifData(res,rutas,"rutas");
          }
        } catch (e) {
            modalMenu("Ocurrio un error inesperado", "menu");
        }
    }
  }
}
/**
*   regRutas():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function regRutas(){
  window.location = config['url']+"Administrador/modulo?vista=registrar_ruta";
}
function registrarRuta(){
  ban = 0;
  datos = new FormData(document.getElementById('datos'));
  for (par of datos.entries())
  {
    if (par[1].trim() == "") {
      ban = 1;
    }
  }
    if (ban == 0){
      pi = datos.get('pInterm').trim().replace(",","-");
       link = "Sd="+datos.get('pSal').trim()+"&Pi="+datos.get('pInterm').trim()+"&Dt="+datos.get('pDest').trim();
       data =  new XMLHttpRequest();
       data.open('POST', config['url']+"Camiones/registrarRutas");
       data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
       data.send(link);
       data.onreadystatechange = function(){
         if (data.readyState == 4 && data.status == 200) {
           res = (data.responseText);
           try {
             res = JSON.parse(res);
             if (res == true){
               modalMenu("Ruta insertada con exito","rutas")
             }else {
               verModal("Error al insertar los datos. Intente de nuevo mas tarde.",1);
             }
           } catch (e) {
             modalMenu("Ocurrio un error inesperado", "menu");
           }
         }
       }
  }else {
    verModal("Debes llenar todos los campos",0)
  }
}
/**
*   modRutas():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function modRutas(id){
    window.location = config['url']+"Administrador/editarRutas?rt="+id;

}
function cargarRuta(id){
  data =  new XMLHttpRequest();
  datos = "rt="+id;
  data.open('POST', config['url'] +"Camiones/modificarRuta");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
        res = data.responseText;
        try {
          res = JSON.parse(res);
          if (res != 1 && res != 2 && res != 3) {
            idR = res[0][0];
            pi = res[0][1];
            pf = res[0][2];
            ad = res[0][3];
            ps = document.getElementById('pi').value = pi;
            pll =  document.getElementById('pf').value = pf;
            as =  document.getElementById('ad').value = ad;
            bt =  document.getElementById('0').id = idR;
          }else {
            verifData(res,info,"rutas");
          }
        } catch (e) {
          modalMenu("Ocurrio un error inesperado", "menu");
        }
    }
  }
}
function guardarRuta(id){
  ban = 0;
  datos = new FormData(document.getElementById('datos'));
  for (par of datos.entries())
  {
    if (par[1].trim() == "") {
      ban = 1;
    }
  }
    if (ban == 0){
      pi = datos.get('pInterm').trim().replace(",","-");
       link = "id="+id+"&Sd="+datos.get('pSal').trim()+"&Pi="+datos.get('pInterm').trim()+"&Dt="+datos.get('pDest').trim();
       data =  new XMLHttpRequest();
       data.open('POST', config['url']+"Camiones/guardarCamRuta");
       data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
       data.send(link);
       data.onreadystatechange = function(){
         if (data.readyState == 4 && data.status == 200){
            res = data.responseText;
            try {
              res = JSON.parse(res);
              if (res == true) {
                 modalMenu("Datos guardados",'rutas');
              }else {
                 verifData(res,datos,"rutas")
              }
            } catch (e) {
              modalMenu("Ocurrio un error inesperado", "menu");
            }
         }
       }
   }else {
     verModal("Debes llenar todos los campos",0);
   }
}

function eliminarR(id){
  datos = "id="+id;
  data = new XMLHttpRequest();
  data.open('POST', config['url'] +"Camiones/eliminarRuta");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      try {
        res  = JSON.parse(res);
        if (res == true) {
          verModal("Ruta eliminada", 1);
        }else {
          verifData(res,info,"rutas");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
// _______________________________________VIAJES____________________________________________
/**
*   viajes():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function viajes(){
  window.location = config['url']+"Administrador/modulo?vista=viajes"
}
function cargarViajes(){
  ver = document.getElementById('ver').value;
  viajes = document.getElementById('inicio');
  divs = "";
  mensaje = "¿Seguro que deseas eliminar este viaje?";
  data =  new XMLHttpRequest();
  datos = "ver="+ver;
  data.open('POST', config['url'] +"Camiones/datosViajes");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      try {
        res = JSON.parse(res);

        if(res != 1 && res != 2 && res != 3){
          for(vj in res){
            divs +=
            "<div class='caja'>"+
              "<div class='usuario' >"+
                "<h4>"+res[vj][1]+" "+res[vj][4]+"</h4>"+
                "<p>Chofer: "+res[vj][2]+"<br> Unidad: "+res[vj][3]+"     Estado: "+res[vj][5]+"</p>"+
              "</div>";
              if (res[vj][5] == 'En espera') {
                divs += "<div class='botones'>"+
                  "<button class='modificar' onclick='modViajes("+res[vj][0]+")'>Modificar</button>"+
                  "<button class='cancel' onclick='modalEliminar("+res[vj][0]+",4)'>Eliminar</button>"+
                "</div></div>";
              }else if(res[vj][5] == 'Finalizado'){
                divs += "<div class='botones'>"+
                  "<button class='cancel' onclick='modalEliminar("+res[vj][0]+",3)'>Eliminar</button>"+
                "</div></div>";
              }
          }
          viajes.innerHTML = divs;
        }else {
          verifData(res,viajes,"viajes")
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
/**
*   regViajes():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function regViajes(){
  window.location = config['url']+"Administrador/modulo?vista=registrar_viaje";
}
function cargarDatos(){
  choferes = "";
  rutas = "";
  unidades = "";
  link = "DV=dv"
  data =  new XMLHttpRequest();
  data.open('POST', config['url']+"Camiones/datosViaje");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  data.send(link);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = (data.responseText);
      try {
        res = JSON.parse(res);
        if (res != 1 && res != 2 && res != 3){
          if (res[0][0] == 1) {
              choferes = "<option id='0'>No hay choferes disponibles</option>";
          }else {
            for(chof in res[0][0]){
              choferes += "<option value='"+res[0][0][chof][0]+"'>"+res[0][0][chof][1]+"</option>"
            }
          }
          if (res[0][1] == 1) {
            unidades = "<option id='0'>No hay unidades disponibles</option>";
          }else {
            for(uni in res[0][1]){
                unidades += "<option value='"+res[0][1][uni][0]+"'>"+res[0][1][uni][1]+"</option>";
              }
          }
          if (res[0][2] == 1) {
            rutas = "<option id='0'>No hay rutas disponibles</option>";
          }else {
            for(rut in res[0][2]){
              rutas += "<option value='"+res[0][2][rut][0]+"'>"+res[0][2][rut][1]+"-"+res[0][2][rut][2]+" con paradas:"+res[0][2][rut][3]+"</option>"
            }
          }
          document.getElementById('chofer').innerHTML = choferes;
          document.getElementById('unidad').innerHTML = unidades;
          document.getElementById('ruta').innerHTML = rutas;
        }else {
          verifData(res,info,"viajes");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}

function registrarViaje(){
  ban = 0;
  datos = new FormData(document.getElementById('datos'));
  for (par of datos.entries())
  {
    if (par[1].trim() == "") {
      ban = 1;
    }
  }
  if (ban == 0){
    cf = document.getElementById('chofer').value;
    un = document.getElementById('unidad').value;
    rt = document.getElementById('ruta').value;
    link = "hrs="+datos.get('horas')+"&min="+datos.get('min')+"&cf="+cf+"&un="+un+"&rt="+rt;
    // console.log(link);
    data = new XMLHttpRequest();
    data.open('POST',config['url']+"Camiones/registrarViajes");
    data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    data.send(link);
    data.onreadystatechange = function(){
      if (data.readyState == 4 && data.status == 200) {
        res = (data.responseText);
        try {
          res = JSON.parse(res);
          if (res == true){
            modalMenu("Viaje insertado con exito","viajes")
          }else if (res == "un") {
            verModal("La unidad se encuentra registrada en un viaje cercano a ese horario. Intenta con otra unidad",0);
          }else if (res == "cf") {
            verModal("El chofer se encuentra registrado en un viaje cercano a esa horario. Intenta con otro chofer",0);
          }else {
            verModal("Error al insertar los datos. Intente de nuevo mas tarde.",1)
          }
        } catch (e) {
          modalMenu("Ocurrio un error inesperado", "menu");
        }
      }
    }
  }
}
/**
*   modViajes():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function modViajes(id){
    window.location = config['url']+"Administrador/editarViajes?vj="+id;
}
function modificarViaje(id){
  ban = 0;
  datos = new FormData(document.getElementById('datos'));
  for (par of datos.entries())
  {
    if (par[1].trim() == "") {
      ban = 1;
    }
  }
  if (ban == 0){
    cf = document.getElementById('chofer').value;
    un = document.getElementById('unidad').value;
    rt = document.getElementById('ruta').value;
    link = "id="+id+"&cf="+cf+"&un="+un+"&rt="+rt;
    data =  new XMLHttpRequest();
    data.open('POST', config['url'] +"Camiones/modificarViaje");
    data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //Se envían los datos almacenados en "link"
    data.send(link);
    data.onreadystatechange = function(){
      if (data.readyState == 4 && data.status == 200) {
        res = data.responseText;
        try {
          res = JSON.parse(res);
          if (res == "md") {
            modalMenu("No se puede modificar un viaje con menos de 1hr para que comience.","viajes");
          }
          if (res == true){
            modalMenu("Datos guardados","viajes");
          }else {
            verifData(res,info,"viajes");
          }
        } catch (e) {
          modalMenu("Ocurrio un error inesperado", "menu");
        }
      }
    }
  }
}
function eliminarV(id){
  datos = "id="+id;
  data = new XMLHttpRequest();
  data.open('POST', config['url'] +"Camiones/eliminarViaje");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      try {
        res = JSON.parse(res);
        if (res == true) {
          verModal("Viaje eliminado", 1);
        }else {
          verifData(res,info,"rutas");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
function eliminarVespera(id){
  datos = "id="+id;
  data = new XMLHttpRequest();
  data.open('POST', config['url'] +"Camiones/eliminarVespera");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      // console.log(res);
      try {
        res = JSON.parse(res);
        if (res == true) {
          verModal("Viaje eliminado", 1);
        }else if (res == "el") {
          verModal("No se puede eliminar el viaje, queda menos de 1 hr para que comience",0);
        }else{
          verifData(res,info,"rutas");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
    }
  }
}
// ____________________________________________USUARIOS_____________________________________
/**
*   usuarios():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function usuarios(){
  window.location = config['url']+"Administrador/modulo?vista=usuarios"
}
function cargarUsuarios(){
  usuarios = document.getElementById('inicio');
  divs = "";
  count = 0;
  mensaje = "¿Seguro que desea eliminar este usuario?";
  data =  new XMLHttpRequest();
  datos = "usuarios=Us";
  data.open('POST', config['url'] +"Usuarios/solicitudesUsuarios");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = data.responseText;
      try {
        res = JSON.parse(res);
        if (res != 1 && res != 2 && res != 3) {
          for (us in res){
            count++;
            divs +=
            "<div class='caja' id='"+res[us][0]+"'>"+
              "<div class='usuario'>"+
                "<h4>"+res[us][1]+"</h4>"+
                "<p>"+res[us][2]+","+res[us][3]+"</p>"+
              "</div>"+
              "<div class='botones'>"+
                "<button onclick='aceptarUsuario("+res[us][0]+")'><img src='"+config['img']+"checked.png'></button>"+
                "<button onclick='eliminarSolicitud("+res[us][0]+")'><img src='"+config['img']+"cancel.png'></button>"+
              "</div>"+
            "</div>";
          }
          usuarios.innerHTML = divs;
        }else {
          verifData(res,usuarios, "usuarios");
        }
      } catch (e) {
        modalMenu("Ocurrio un error inesperado", "menu");
      }
      document.getElementById('num').innerHTML = count;
    }
  }
}
function aceptarUsuario(id){
  usuarios = document.getElementById('inicio');
  data =  new XMLHttpRequest();
  datos = "id="+id;
  data.open('POST', config['url'] +"Usuarios/aprobarSolicitudUsuario");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = (data.responseText);
      try {
        res = JSON.parse(res);
        if (res == true) {
          document.getElementById(id).style.display = "none";
          verModal("Usuario aceptado",1)
        }else {
          verifData(res,usuarios,"usuarios");
        }
      } catch (e) {
        modalMenu("Ocurrió un error inesperado", "menu");
      }
    }
  }
}
function eliminarSolicitud(id){
  usuarios = document.getElementById('inicio');
  data =  new XMLHttpRequest();
  datos = "id="+id;
  data.open('POST', config['url'] +"Usuarios/eliminarSolicitudUsuario");
  data.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  //Se envían los datos almacenados en "link"
  data.send(datos);
  data.onreadystatechange = function(){
    if (data.readyState == 4 && data.status == 200){
      res = (data.responseText);
      try {
        res = JSON.parse(res);
        if (res == true) {
          document.getElementById(id).style.display = "none";
          verModal("Solicitud Eliminada",1)
        }else {
          verifData(res,usuarios,"usuarios");
        }
      } catch (e) {
          modalMenu("Ocurrió un error inesperado", "menu");
      }
    }
  }
}
// -_______________________________________________________________________________________
/**
*   retroalimentaciones():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function retroalimentaciones(){
    window.location = config['url']+"Administrador/modulo?vista=retroalimentaciones";
}
/**
*   choferes():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function choferes(){
  window.location = config['url']+"Administrador/modulo?vista=choferes";
}
/**
*   choferesX():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function choferesX(){
  window.location = config['url']+"Administrador/modulo?vista=registrar_chofer";
}
/**
*   cerrarSesion():
*           Redirige por medio de window.location a la funcion del controlador Arministrador/modulo
*            y envia como parametro la vista que se desea ingresar
*   @author Alejandra Estefania Morales Becerra
*   @version 1.0
*
*/
function cerrarSesion(){
  window.location = config['url']+"Index/cerrarSesion";
}
// -------------------Modales-------------------------------


function verModal(mensaje, ind){
	document.querySelector('.fondo').classList.add('ver-fondo');
	document.querySelector('.mensaje').classList.add('ver-mensaje');
  if (ind == 1) {
      document.querySelector('.mensaje').innerHTML = "<p>"+mensaje+"</p><button class'uno' onclick='cerrarModal();'>Aceptar</button>"
  }else {
        document.querySelector('.mensaje').innerHTML = "<p>"+mensaje+"</p><button class'uno' onclick='cModal();'>Aceptar</button>"
  }
}
function modalMenu(mensaje,vista){

	document.querySelector('.fondo').classList.add('ver-fondo');
	document.querySelector('.mensaje').classList.add('ver-mensaje');
  document.querySelector('.mensaje').innerHTML = "<p>"+mensaje+"</p><button class'uno' onclick='"+vista+"();'>Aceptar</button>"
}
function modalSesion(){
	document.querySelector('.fondo').classList.add('ver-fondo');
	document.querySelector('.mensaje').classList.add('ver-mensaje');
  document.querySelector('.mensaje').innerHTML = "<p>¿Estas Seguro que deseas cerrar sesión?</p><button class='cancel' onclick='cerrarSesion();'>Aceptar</button><button class='save' onclick='cModal();'>Cancelar</button>"
}
function modalEliminar(id, ev){
	document.querySelector('.fondo').classList.add('ver-fondo');
	document.querySelector('.mensaje').classList.add('ver-mensaje');
  if(ev == 1){
      document.querySelector('.mensaje').innerHTML = ("<p>"+mensaje+"</p><button class='save' id='"+id+"'onclick='eliminarU(this.id);'>Aceptar</button><button class='cancel' onclick='cModal();'>Cancelar</button>")
  }else if (ev == 2) {
      document.querySelector('.mensaje').innerHTML = ("<p>"+mensaje+"</p><button class='save' id='"+id+"'onclick='eliminarR(this.id);'>Aceptar</button><button class='cancel' onclick='cModal();'>Cancelar</button>")
  }else if (ev == 3) {
      document.querySelector('.mensaje').innerHTML = ("<p>"+mensaje+"</p><button class='save' id='"+id+"'onclick='eliminarV(this.id);'>Aceptar</button><button class='cancel' onclick='cModal();'>Cancelar</button>")
  }else if (ev == 4) {
      document.querySelector('.mensaje').innerHTML = ("<p>"+mensaje+"</p><button class='save' id='"+id+"'onclick='eliminarVespera(this.id);'>Aceptar</button><button class='cancel' onclick='cModal();'>Cancelar</button>")
  }
}
function cerrarModal(){
	document.querySelector('.fondo').classList.remove('ver-fondo');
	document.querySelector('.mensaje').classList.remove('ver-mensaje');
  location.reload()
}

function cModal(){
	document.querySelector('.fondo').classList.remove('ver-fondo');
	document.querySelector('.mensaje').classList.remove('ver-mensaje');
}
function menu(){
	location.href= config['url']+"Administrador/index";
}
function verifData(res,div,dat){
  if (res == "1") {
    div.innerHTML = "<h2>No se encontraron "+dat+" disponibles</h2>";
  }else if (res == "2") {
    verModal("Error al intentar conectar con la pagina",1);
  }else if (res == "3") {
    verModal("Ocurrió un error desconocido", 1);
  }
}
