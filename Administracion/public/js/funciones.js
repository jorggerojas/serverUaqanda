function verModal(){
	document.querySelector('.fondo').classList.add('ver-fondo');
	document.querySelector('.mensaje').classList.add('ver-mensaje');
}

function cerrarModal(){
	document.querySelector('.fondo').classList.remove('ver-fondo');
	document.querySelector('.mensaje').classList.remove('ver-mensaje');
}

function Modal(){
	document.querySelector('.fondo2').classList.add('ver-fondo2');
	document.querySelector('.mensaje2').classList.add('ver-mensaje2');
}

function cModal(){
	document.querySelector('.fondo2').classList.remove('ver-fondo2');
	document.querySelector('.mensaje2').classList.remove('ver-mensaje2');
}

function mostrar(elemento){
	elemento.classList.remove('esconder');
	elemento.classList.add('mostrar');
}

function esconder(elemento){
	elemento.classList.remove('mostrar');
	elemento.classList.add('esconder');
}

function banderaMostrar(elemento){
	var bandera;
	for (var i = 0; i <= elemento.classList.length; i++) {

		if(elemento.classList[i] == 'esconder'){
			bandera = 1;
		}
		if(elemento.classList[i] == 'mostrar'){
			bandera = 0;
		}
	}
	if(bandera == 1){
			mostrar(elemento);
		}
	if(bandera == 0){
			esconder(elemento);
		}
}




function cancelar(){
	/*redirige a la vsita de choferes*/
	window.location = config['url']+"Administrador/modulo?vista=choferes";
}

function modificarChofer(id){
	/*redirige a la vista de modificar chofer*/
	 var editID = localStorage.setItem("key2", id);
	 window.location = config['url']+"Administrador/modulo?vista=modificar_chofer";
}

function infoChofer(){
	var editID = localStorage.getItem("key2");
	/** infoChofer() - trea de la db los datos del chofer y se colocan en su respectivo input
		@param Int editID - guarda en localStorage el id del chofer 
	*/

	var link = "id="+editID;
	varAjax = new XMLHttpRequest();
	varAjax.open('POST',config['url']+"Administrador/mostrarEdit");
	varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	varAjax.send(link);
	varAjax.onreadystatechange = function(){
		if(varAjax.readyState == 4 && varAjax.status == 200){
			var datos = JSON.parse(varAjax.responseText);
			/*Trae todos lo datos del chofer y se agregan en el respectivo input*/
			if(datos != "no"){
				for(var i = 0; i < datos.length; i++){

					document.getElementById('newNombre').value = datos[0].Nombre;
					document.getElementById('newApellido').value = datos[0].Apellido;
					document.getElementById('newCorreo').value = datos[0].Correo;
					document.getElementById('newTel').value = datos[0].Telefono;
					document.getElementById('newlic').value = datos[0].NumLicencia;
					document.getElementById('newTel2').value =datos[0].TelReferenciaFamiliar;
				}
			}else {
				alert("No se encontró ningún registro");
			}
		}
	}

}

function updateChofer(){
	/*	updateChofer() - se actualiza los datos del chofer que se ingresen en los inputs
		@param editID - optine de localStorage el id
		@param newNombre - optiene el nombre
		@param newCorreo - optiene el correo 
		@param newPass - optiene la contraseña 
		@param newTel - oprtiene el telefono
		@param newLic - optiene la licencia
		@param newTel2 - optiene el telefono de referencia
	*/
	var editID = localStorage.getItem("key2");
	var newNombre = document.getElementById("newNombre").value;
	var newApellido = document.getElementById("newApellido").value;
	var newCorreo = document.getElementById("newCorreo").value;
	var newPass = document.getElementById("newPass").value;
	var newTel = document.getElementById("newTel").value;
	var newlic = document.getElementById("newlic").value;
	var newTel2 = document.getElementById("newTel2").value;

		if(newPass == ""){
			newPass += "no";
		}
	if(newPass.length >= 8 || newPass == "no"){
		var link = "id="+editID+"&newNombre="+newNombre+"&newApellido="+newApellido+"&newCorreo="+newCorreo+"&newPass="+pre_hash(newPass)+"&newTel="+newTel+"&newlic="+newlic+"&newTel2="+newTel2;

			varAjax = new XMLHttpRequest();
			varAjax.open('POST',config['url']+"Administrador/update");
			varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			varAjax.send(link);
			varAjax.onreadystatechange = function(){
				if(varAjax.readyState == 4 && varAjax.status == 200){
					res = (varAjax.responseText);
					
						if(res = "1"){
							
							modalMenu("Se actualizo correctamente", "choferes");
							
						}else {
							alert("Error");
						}
				}
			}
	}else{
		verModal("Tu contraseña debe ser mayor a 7 caracteres.",1)
	}
}


function insertChofer(){
	/*insetChofer() - inserta los datos del chofer
		@param nombre - guarda el nombre del chofer
		@param apellido - guarda el apellido del chofer
		@param expediente - guarda el expediente del chofer
		@param correo - guarda el correo del chofer
		@param pass - guarda la contraseña del chofer
		@param tel - guarda el telefono del chofer
		@param numLicencia - guarda la licencia del chofer
		@param fecha - gaurda la fecha de contratacion del chofer
		@param telr - guarda el numero de referencia (opcinal)

	*/
	var nombre  = document.getElementById("nombre").value;
	var  apellido = document.getElementById('apellido').value;
	var  expediente = document.getElementById('expediente').value;
	var correo  = document.getElementById('correo').value;
	var  pass = document.getElementById('pass').value;
	var  tel = document.getElementById('tel').value;

	var  numLicencia = document.getElementById('numLicencia').value;
	var  fecha = document.getElementById('fecha').value;
	var  telr = document.getElementById('telr').value;

	if(expediente.length ==6){
	if(pass.length >= 8){

		var link = "nombre="+nombre+"&apellido="+apellido+"&expediente="+expediente+"&correo="+correo+"&pass="+pre_hash(pass)+"&numLicencia="+numLicencia+"&fecha="+fecha+"&tel="+tel+"&telr="+telr;

		if(nombre != "" && apellido != "" && correo != "" && pass != "" && numLicencia  != "" && fecha != "" && expediente != ""){
			varAjax = new XMLHttpRequest();
			varAjax.open('POST',config['url']+"Administrador/agregarChofer");
			varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			varAjax.send(link);
			varAjax.onreadystatechange = function(){
				if(varAjax.readyState == 4 && varAjax.status == 200){
					res = JSON.parse(varAjax.responseText);

						switch(res){
							case "1":

								modalMenu("Se agregó el chofer correctamente", "choferes");
								break;
							case "Expediente Existente":

								modalMenu("Expediente Existente","choferesX");
								break;
							case "Licencia Incorrecta":
								modalMenu("Licencia Incorrecta","choferesX");
								break;
							case "Correo ya registrado":
								modalMenu("Correo ya registrado","choferesX");
								break;
							case "Correo Existente":
								modalMenu("Correo Existente","choferesX");
								break;
							default:
								modalMenu("Error al agregar el chofer","choferesX");
								

						}
				}
			}

		}else {
			verModal("Complete todos los campos.",1);

		}
	}else{
		verModal("Tu contraseña debe ser mayor a 7 caracteres");
	}
	}else{
		verModal("Ingresa un expediente válido (6 digitos)");
	}

}

function mostrarChoferes(){
	/* mostrarChoferes() - muestra todos los choferes registrados en la db con el status 5
	*/
	varAjax = new XMLHttpRequest();
	varAjax.open('POST',config['url']+"Administrador/mostrarChofer");
	varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	varAjax.send();
	varAjax.onreadystatechange = function(){
		if(varAjax.readyState == 4 && varAjax.status == 200){
			var datos = JSON.parse(varAjax.responseText);
			document.getElementById('info').innerHTML = "";
			if(datos != "no"){
				for(var i = 0; i < datos.length; i++){
					var div = 	"<div class='caja'>"+
									"<div class='usuario'>"+
  										"<h4>"+datos[i].Nombre+ " "+datos[i].Apellido+"</h4>"+
  										"<p>"+datos[i].ClaveExpediente+", "+datos[i].Correo+"</p>"+
									"</div>"+
									"<div class='botones'>"+
 										"<button class='modificar' onclick='modificarChofer("+datos[i].idUsuario+")'>Modificar</button>"+
  										"<button class='cancel' onclick='eliminar("+datos[i].idUsuario+")'>Eliminar</button>"+
									"</div>"+
								"</div>";
					document.getElementById('info').innerHTML += div;
				}
			}else {
				document.getElementById('info').innerHTML = "<h2>No se encontró ningún registro</h2>";
			}
		}
	}
}

function eliminar(id){
	/*eliminar() - elimina los choferes
		@param id - optiene el id del chofer seleccionado para borrar
	*/
	var link = "id="+id;
	varAjax = new XMLHttpRequest();
	varAjax.open('POST', config['url']+"Administrador/eliminarChofer")
	varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	varAjax.send(link);
	varAjax.onreadystatechange = function(){
		if (varAjax.readyState == 4 && varAjax.status == 200){
			res = (varAjax.responseText);
			if(res = "1"){
						modalMenu("Se eliminó correctamente", "choferes");
					}else {
						alert("Error al eliminar el chofer");
						mostrarChoferes();
			}
		}
	}
}

function cali(){
	/*cali() - muestra los comentarios hechos por los usuarios dependiendo de la fecha seleccionada
		@param date - optiene la fecha insertada por el administrador
	 */
	var date  = document.getElementById("date").value;
	var link = "date="+date;

	varAjax = new XMLHttpRequest();
	varAjax.open('POST', config['url']+"Administrador/traer")
	varAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	varAjax.send(link);
	varAjax.onreadystatechange = function(){
		if (varAjax.readyState == 4 && varAjax.status == 200){
			var res = JSON.parse(varAjax.responseText);
			document.getElementById('infoC').innerHTML = "";
			if(res != "no"){
				for(var i = 0; i < res.length; i++){
					/*dependiendo de la calificación(1-5) otorgada por los usuarios se mostrar en pantalla*/
					switch (res[i].Calificacion) {
						case "1":
							var div = 	"<div class='caja'>"+
	      							"<div class='usuario'>"+
	        							"<h3>"+res[i].Nombre+"</h3>"+
	        							"<p>"+res[i].Retroalimentacion+"</p>"+
	      							"</div>"+
	      							"<div class='estrellas'>"+
								        "<img class='uno' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
	      							"</div>"+
   							 	"</div>";
   							document.getElementById('infoC').innerHTML += div;
						break;
						case "2":
							var div = 	"<div class='caja'>"+
	      							"<div class='usuario'>"+
	        							"<h3>"+res[i].Nombre+"</h3>"+
	        							"<p>"+res[i].Retroalimentacion+"</p>"+
	      							"</div>"+
	      							"<div class='estrellas'>"+
								        "<img class='uno' src='"+config['img']+"star.png'>"+
								        "<img class='dos' src='"+config['img']+"star.png'>"+
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
	      							"</div>"+
   							 	"</div>";
   							document.getElementById('infoC').innerHTML += div;
						break;
						case "3":
							var div = 	"<div class='caja'>"+
	      							"<div class='usuario'>"+
	        							"<h3>"+res[i].Nombre+"</h3>"+
	        							"<p>"+res[i].Retroalimentacion+"</p>"+
	      							"</div>"+
	      							"<div class='estrellas'>"+
								        "<img class='uno' src='"+config['img']+"star.png'>"+
								        "<img class='dos' src='"+config['img']+"star.png'>"+
								        "<img class='tres' src='"+config['img']+"star.png'>"+								        
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
	      							"</div>"+
   							 	"</div>";
   							document.getElementById('infoC').innerHTML += div;
						break;
						case "4":
							var div = 	"<div class='caja'>"+
	      							"<div class='usuario'>"+
	        							"<h3>"+res[i].Nombre+"</h3>"+
	        							"<p>"+res[i].Retroalimentacion+"</p>"+
	      							"</div>"+
	      							"<div class='estrellas'>"+
								        "<img class='uno' src='"+config['img']+"star.png'>"+
								        "<img class='dos' src='"+config['img']+"star.png'>"+
								        "<img class='tres' src='"+config['img']+"star.png'>"+
								        "<img class='cuatro' src='"+config['img']+"star.png'>"+
								        "<img class='cinco' src='"+config['img']+"star.png'>"+								       
	      							"</div>"+
   							 	"</div>";
   							document.getElementById('infoC').innerHTML += div;
						break;
						case "5":
							var div = 	"<div class='caja'>"+
	      							"<div class='usuario'>"+
	        							"<h3>"+res[i].Nombre+"</h3>"+
	        							"<p>"+res[i].Retroalimentacion+"</p>"+
	      							"</div>"+
	      							"<div class='estrellas'>"+
								        "<img class='uno' src='"+config['img']+"star.png'>"+
								        "<img class='dos' src='"+config['img']+"star.png'>"+
								        "<img class='tres' src='"+config['img']+"star.png'>"+
								        "<img class='cuatro' src='"+config['img']+"star.png'>"+
								        "<img class='cinco' style='filter: invert(0%)' src='"+config['img']+"star.png'>"+								       
	      							"</div>"+
   							 	"</div>";
   							document.getElementById('infoC').innerHTML += div;
						break;
					}


				}
			}else{
				document.getElementById('infoC').innerHTML = "<h2>No se encontró ningún registro</h2>";
			}
		}
	}
}
