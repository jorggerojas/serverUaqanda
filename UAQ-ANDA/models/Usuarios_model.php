<?php
  class Usuarios_model  extends Model
  {
  	/*-------------------------------Inicio Caso de uso Aceptar Solicitud, Rechazar solicitud-------------------------*/

  		/**
		*	selectUser()
		*	Esta función muestra todos los usuarios todavia no aceptados
		*		@return respuesta del Query
  		*/
  		public function  selectUser(){
  			return $this->db->selectStrict('*', 'Usuarios', " status = 3 ");
  		}

  		/**
		*	deleteStatusUser(Int id)
		*		@param Int id - guarda el id del usuario
		*	Esta función actualiza el status del usuario rechazado
		*		@return bool con el resultado de la ejecución de la consulta
  		*/
  		public function deleteStatusUser($id){
  			return $this->db->deleteByStatus("Usuarios", "idUsuario = '$id' ", "status", 4 );
  		}

  		/**
		*	aceptarStatusUser(Int id)
		*		@param Int id - guarda el id dekl usuario
		*	Esta función actualiza el status del usuario aceptado
		*		@return bool con el resultado de la ejecución de la consulta
  		*/
  		public function aceptarStatusUser($id){
  			return $this->db->deleteByStatus("Usuarios", "idUsuario = '$id' ", "status", 2 );
  		}

  		/**
  		*	retro(String inicialP, String finalP)
  		*		@param String $inicialP - guarda el punto inicial de la parada de camion
  		*		@param String $finalP - guarada el punto final de la parada de camion
  		*	Esta función trae las calificaciones de los viajes de la ruta seleccionada
  		*		@return bool con el resultado de la ejecución de la consulta.
  		*/
  		public function retro($inicialP, $finalP){
  			return $this->db->selectStrict("u.Nombre, c.Calificacion, c.Retroalimentacion, r.PuntoInicial, r.PuntoFinal", "Calificaciones c, Usuarios u, Viajes v, Rutas r", "c.idViaje = v.idViaje AND v.idRuta = r.idRuta AND c.idUsuario = u.idUsuario AND r.PuntoInicial LIKE '$inicialP' AND r.PuntoFinal LIKE 'finalP' ");
  		}
  		/*
			SELECT u.Nombre, c.Calificacion, c.Retroalimentacion, r.PuntoInicial, r.PuntoFinal FROM calificaciones c, usuarios u, viajes v, rutas r WHERE c.idViaje = v.idViaje AND v.idRuta = r.idRuta AND c.idUsuario = u.idUsuario AND r.PuntoInicial LIKE 'obrera' AND r.PuntoFinal LIKE 'cu'
  		*/

  	/*-------------------------------Fin Caso de uso Aceptar Solicitud, Rechazar solicitud-------------------------*/
  }


?>
