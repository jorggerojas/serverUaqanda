<?php

    /**
    * class Camiones_model
    * Esta clase hace uso de la librería Model(./libs/Model.php) y
    * hace una conexión con la base de datos (definida en ./config.php).
    * Los métodos creados en esta clase serviran de respuesta al Controller
    * que haga referencia a los mismos.
    */
  class Camiones_model  extends Model
  {

    /*---------------------------Inicio Caso de uso Registrar Ruta, Eliminar Ruta, Modficar Ruta-----------------------------------  */
	  	/**
		*	insertarRuta(String psalida, String pcamion, String pdestino)
		*		@param String $psalida - guarda el punto inicial de la ruta
		*		@param String $pcamion - guarda las paradas
		*		@param String $pdestino - guarda el punto final de la ruta
		*
		*	Esta función agraga una nueva ruta a la base de datos.
		* 		@return bool con el resultado de la ejecución de la consulta.
		*				String con el tipo de erro.
	  	*/
	  		public function insertarRuta($psalida, $pcamion, $pdestino){
	  		$data = array('PuntoInicial'=> $psalida, 'Adicional' => $pcamion, 'PuntoFinal' => $pdestino, 'status' => 2);
	  		return $this->db->insert($data, 'rutas');
	  		}

	  	/**
	  	*	selectRuta()
		*
	  	*	Esta función trae todos los  datos de la base de datos de la tabla rutas.
	  	*		@return respuesta del Query
		*
	  	*/
	  		public function selectRuta(){
	  		return $this->db->selectStrict('*', 'rutas', 'status = 2');
	  		/*return json_encode()*/
	  		}
      public function modificarRuta($id){
        return $this->db->select("*", "rutas", "idRuta = '$id'", 'status = 2');
        }
  /**
		*	deleteRuta(int id)
		*		@param int $id - guarda el id de ruta
		*	Esta función borra la fila que concuerde con el id de ruta proporcionada
		*		@return bool con el resultado de la ejecución de la consulta
	  	*/
	  		public function deleteRuta($id){
          $data = array('status' => 6);
	  			return $this->db->update($data, "rutas", "idRuta = '$id' ");
	  		}

	  	/**
		*	editarRuta(Int id, String psalida, String pcamion, String pdestino)
		*		@param Int $id - guarda el id de la ruta
		*		@param String $psalida - guarda el punto inicial de la ruta
		*		@param String $pcamion - guarda las paradas
		*		@param String $pdestino - guarda el punto final de la ruta
		*	Esta funcion editar los valores ya registrados anteriormente
		*		@return bool con el resultado de la ejecución de la consulta
	  	*/
	  		public function editarRuta($id, $psalida, $pcamion, $pdestino){
	  			$data = array('PuntoInicial'=> $psalida, 'Adicional' => $pcamion, 'PuntoFinal' => $pdestino);
	  			return $this->db->update($data, "rutas", "idRuta = '$id' ");
	  		}

	/*-------------------------Fin Caso de uso Registrar Ruta, Eliminar Ruta, Modficar Ruta--------------------------------*/


	/*-------------------------Inicio Aprobar solicitud de Unidad, Rechazar solicitud de unidad-------------------------*/

	  	/**
	  	*	selectSolicitudUnidad()
		*	Trae todos los datos de la base de datos de las solicitudes de unidad
		*		@return respuesta del Query
	  	*/
	  	public function selectSolicitudUnidad(){
	  		return $this->db->selectStrict("s.idSolicitud, s.Destino, s.Justificacion, r.PuntoInicial, r.PuntoFinal, u.Nombre, s.status", "solicitudunidades s, viajes v, rutas r, choferes c, usuarios u", "s.idViaje = v.idViaje AND v.idRuta = r.idRuta AND s.idChofer = c.idChofer AND c.idUsuario = u.idUsuario AND s.status = '1'");

	  		/*SELECT s.idSolicitud, s.Destino, s.Justificacion, r.PuntoInicial, r.PuntoFinal, u.Nombre, s.status from solicitudunidades s, viajes v, rutas r, choferes c, usuarios u where s.idViaje = v.idRuta AND v.idRuta = r.idRuta AND s.Chofer = c.idChofer AND c.idUsuario = u.idUsuario AND s.status = '0' agregar unidad la parte de PLACA */

	  	}

	  	/**
		*	aprobarSolicitudUnidad(Int id)
		*		@param int id - guarda el id de la solicitud de unidad
		*	Esta función acatualiza el status de 0 (por aprobar) a 1 (aprobado)
		*		@return bool con el resultado de la ejecución de la consulta
	  	*/
	  	public function aprobarSolicitudUnidad($id){
	  		return $this->db->deleteByStatus("solicitudunidades", "idSolicitud = '$id' ", "status", 2);
	  	}

	  	/**
		*	deleteSolicitudUnidad(Int idSolicitud)
		*		@param Int $id - guarda el id de solicitud de unidad
		*
		*	Esta función borra la fila que concuerde con el id de la solicitud
		*		@return bool con el resultado de la ejecución de la consulta
	  	*/
	  	public function deleteSolicitudUnidad($id){
	  		return $this->db->deleteByStatus("solicitudunidades", "idSolicitud = '$id' ","status", 4);

	  	}

  	/*-----------------------Fin Aprobar solicitud de Unidad, Rechazar solicitud de unidad-------------------------------- */

  	/*------------------------Inicio Registrar Viaje, Modificar Viaje, Eliminar Viajes-------------------------------------- */

  		/**
		*	inserViaje(String hr, Int idChofer, Int idUnidad, Int idRuta)
		*		@param String $hr - guarda la hora de inicio del viaje
		*		@param Int idChofer - guarda el id del chofer
		*		@param Int idUnidad - guarda el id de la unidad
		*		@param INT idRuta - guarda el id de la ruta
		*	Esta funcion inserta un nuevo viaje
		* 		@return bool con el resultado de la ejecución de la consulta.
		*				String con el tipo de erro.
  		*/
  		public function insertViaje($hr, $idChofer, $idUnidad, $idRuta){
  			$data = array('Horario'=> $hr, 'idChofer'=> $idChofer, 'idUnidad'=> $idUnidad, 'idRuta'=> $idRuta, 'fecha' => date("Y-m-d"), 'status' => 'En espera');
  			return $this->db->insert($data, 'viajes');
  		}

  			/**
  			*	selectChofer()
  			*	Esta función trae el id del chofer y su nombre.
  			*		@return respuesta del Query
  			*/
        public function selectChofer(){
          return $this->db->selectStrict("c.idChofer, us.Nombre, us.Apellido", "choferes c, usuarios us", "us.status = 5 AND c.idUsuario = us.idUsuario");
        }
  			/**
  			*	selectUnidadV()
  			* 	Esta función trae el id de la unidad y su placa.
  			*		@return respuesta del Query
  			*/
  			public function selectUnidadV(){
  				return $this->db->selectStrict('idUnidad, placa ', 'unidades');
  			}
  			/**
  			*	selectRutaV()
  			*	Esta función trae el id de la ruta, punto inicial y final de la ruta.
  			* 		@return respuesta del Query
  			*/
  			public function selectRutaV(){
  				return $this->db->selectStrict('idRuta, PuntoInicial, PuntoFinal, Adicional', 'rutas', 'status = 2');
  			}

  		/**
  		*	editarViaje(Int id, String hr, Int idChofer, Int idUnidad, Int idRuta)
  		*  		@param Int id - guarda el id de viaje
  		*		@param String $hr - guarda la hora de inicio del viaje
		*		@param Int idChofer - guarda el id del chofer
		*		@param Int idUnidad - guarda el id de la unidad
		*		@param INT idRuta - guarda el id de la ruta
		*
		*	Esta función edita los valores del viaje solicitado
		* 		@return bool con el resultado de la ejecución de la consulta
  		*/
  		public function editarViaje($id, $idChofer, $idUnidad, $idRuta){
  			$data = array('idChofer'=> $idChofer, 'idUnidad'=> $idUnidad, 'idRuta'=> $idRuta);
  			return $this->db->update($data, "viajes", "idViaje = '$id' ");

  		}

  		/**
  		*	deleteViaje( Int id)
  		*		@param Int id - guarda el id de viaje
  		*	Esta función borra el viaje seleccionado
  		*		@return bool con el resultado de la ejecución de la consulta
  		*/
  		public function deleteViaje($id){
        $data = array('status' => 'Eliminado');
        return $this->db->update($data, "viajes", "idViaje = '$id'");

  		}
      public function selectViajeid($id){
        return $this->db->selectStrict("horario ", "viajes", "idViaje = $id");

  		/**
  		*	selectViaje()
  		*	Esta función trae todos los registros de viajes
  		*		@return respuesta del Query
  		*/
    }
  		public function selectViaje(){
  			return $this->db->selectStrict("v.idViaje AS 'Viaje', v.Horario AS 'hr',v.status AS 'status', us.Nombre AS 'Chofer', u.Placa AS 'Unidad', r.PuntoInicial AS 'RutaI', r.PuntoFinal AS 'RutaF' ", "unidades u, rutas r, viajes v, usuarios us, choferes c", "(v.idUnidad = u.idUnidad AND v.idRuta = r.idRuta AND v.idChofer = c.idChofer AND c.idUsuario = us.idUsuario) AND (v.status = 'En espera' OR v.status = 'En curso' OR v.status = 'Finalizado')");
  			/*
				SELECT v.idViaje, us.Nombre, v.Horario, u.Placa, r.PuntoInicial, r.PuntoFinal from choferes c, unidades u, rutas r, viajes v, usuarios us where v.idUnidad = u.idUnidad AND v.idRuta = r.idRuta AND v.idChofer = c.idChofer AND c.idChofer = us.idUsuario
  			*/

  		}
      public function selectViajeStatus($status){
        return $this->db->selectStrict("v.idViaje AS 'Viaje', v.Horario AS 'hr',v.status AS 'status', us.Nombre AS 'Chofer', u.Placa AS 'Unidad', r.PuntoInicial AS 'RutaI', r.PuntoFinal AS 'RutaF' ", "unidades u, rutas r, viajes v, usuarios us, choferes c", "(v.idUnidad = u.idUnidad AND v.idRuta = r.idRuta AND v.idChofer = c.idChofer AND c.idUsuario = us.idUsuario) AND (v.status = '$status')");
        /*
        SELECT v.idViaje, us.Nombre, v.Horario, u.Placa, r.PuntoInicial, r.PuntoFinal from choferes c, unidades u, rutas r, viajes v, usuarios us where v.idUnidad = u.idUnidad AND v.idRuta = r.idRuta AND v.idChofer = c.idChofer AND c.idChofer = us.idUsuario
        */

      }
      public function ComprCf($day,$cf){
        return $this->db->selectStrict("Horario, status", "viajes", "fecha = '$day' AND idChofer = $cf");

      }
      public function ComprUn($day,$un){
        return $this->db->selectStrict("Horario, status", "viajes", "fecha = '$day' AND idUnidad = $un");
      }
      public function ComprV($id){
        return $this->db->select("Horario", "viajes", "idViaje = $id");
      }
  	/*------------------------Fin Registrar Viaje, Modificar Viaje, Eliminar Viajes-------------------------------------- */

  	/*-------------------------Inicio Registrar Unidad, Eliminar Unidad-------------------------------------------------- */
  		/*no hay modificar ruta
			en la vista no se muestra la ruta o se relaciona la db con punto inicial y punto final.

			No mostrar editar en la vista
  		*/

  		/**
  		*	insertUnidad(Int capacidad, String placa, String modelo, String campus)
  		*		@param Int capacidad - guarda la cantidad de pasajeros
  		*		@param String placa  - guarda el numero de placa de la unidad
  		*		@param String modelo - guarda el modelo de la unidad
  		*		@param String campus - guarda el campus donde inicia el viaje
  		*	Esta funcion inserta una nueva unidad
  		* 		@return bool con el resultado de la ejecución de la consulta.
		*				String con el tipo de erro.
  		*/
  		public function insertUnidad($capacidad, $placa, $modelo, $campus){
  			$data = array('Capacidad'=> $capacidad, 'Placa'=> $placa, 'Modelo'=> $modelo, 'Campus'=> $campus, 'status' => 2);
  			return $this->db->insert($data, 'unidades');
  		}

  		/**
  		*	selectUnidad()
  		*	Esta funcion trae los datos de la base de datos.
  		*	@return respuesta del Query
  		*/
  		public function selectUnidad(){
  			return $this->db->selectStrict('*', 'unidades','status = 2');
  		}

  		/**
  		*	deleteUnidad(Int id)
  		*		@param Int id -guarda el id de la unidad
  		*	Esta función borra la unidad seleccionada
  		*		@return bool con el resultado de la ejecución de la consulta
  		*/
  		public function deleteUnidad($id){
        $data = array('status' => 6);
        return $this->db->update($data, "unidades", "idUnidad = '$id'");
  		}

  }


?>
