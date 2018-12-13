<?php
  class Chofer_model  extends Model
  {
  	/*------------------------------------------Inicio Caso de uso Registrar Chofer, Modificar Chofer y Eliminar Chofer--------------------------*/

  		/**
		*	selectChofer
		*	Esta función trae toda la información del usuario chofer y sus caracteristicas de chofer
		*		@return respuesta del Query
		*/
		public function selectEditar($id){
			return $this->db->selectStrict(" us.idUsuario, us.Nombre, us.Apellido, us.Correo, us.Password, us.Telefono, c.idChofer, c.NumLicencia, c.TelReferenciaFamiliar", "choferes c, usuarios us", "us.status = 5 AND us.idUsuario = '$id' AND c.idUsuario = '$id' AND c.status = 2");
		}

		/**
		*	selectChofer
		*	Esta función trae toda la información del usuario chofer y sus caracteristicas de chofer
		*		@return respuesta del Query
		*/
		public function selectChofer(){
			return $this->db->selectStrict("idUsuario, Nombre, Apellido, ClaveExpediente, Correo", "usuarios", "status = 5 ");
		}

		/**
		*	selectExp()
		*		@param Int $expediente - guarda el expediente
		*	Esta funciona trae al chofer con el expediente buscado
		*		@return respuesta del Query
		*/
		public function selectExp($expediente){
			return $this->db->select("*", "usuarios", "ClaveExpediente = '$expediente' ");
		}

		/**
		*	selectCor()
		*		@param Int $expediente - guarda el expediente
		*	Esta funciona trae al chofer con el expediente buscado
		*		@return respuesta del Query
		*/
		public function selectCor($correo){
			return $this->db->select("*", "usuarios", "Correo = '$correo' ");
		}

		/**
		*	selectLic()
		*		@param Int $expediente - guarda el expediente
		*	Esta funciona trae al chofer con el expediente buscado
		*		@return respuesta del Query
		*/
		public function selectLic($expediente){
			return $this->db->select("*", "choferes", "NumLicencia = '$expediente' ");
		}

		/**
		*	selectChoferU(String nombre, String apellido, Int expediente, String correo, String pass, String Tel, Int status)
		*		@param String $nombre - guarda el nombre del chofer
		*		@param String $apellido - guarda el apellido del chofer
		*		@param Int $expediente - guarda el expediene del chofer
		*		@param String $correo - guarda el correo del chofer
		*		@param String $pass - guarda la contraseña del chofer
		*		@param String $Tel - guarda el número telefonico
		*		@param Int $status - guarda el status correspondiente al chofer
		*	Esta función agrega a un nuevo chofer
		* 		@return bool con el resultado de la ejecución de la consulta.
		*				String con el tipo de erro.
		*/
		public function insertChoferU($expediente, $nombre, $apellido, $correo, $pass, $Tel, $status){
			$data = array('ClaveExpediente'=>$expediente, 'Nombre'=> $nombre, 'Apellido'=> $apellido, 'Correo'=> $correo, 'Password'=> $pass, 'Telefono'=> $Tel, 'status'=> $status);
			return $this->db->insert($data, 'usuarios');
		}

		/**
		*	insertChofer(String numLicencia, String fechaContra, Strin telFamilia)
		*		@param String $numLicencia - guarda el numero de licencia
		*		@param String $fechaContra - guarda la fecha de contratación
		*		@param String $telFamilia - guarda el numero telefonico de un familiar
		*	Esta función agrega las caracteristicas de un nuevo usuario.
		* 		@return bool con el resultado de la ejecución de la consulta.
		*				String con el tipo de erro.
		*
		*/
		public function insertChofer($numLicencia, $fechaContra, $telFamilia, $idU){
			$data = array('NumLicencia'=> $numLicencia, 'FechaContratacion'=> $fechaContra, 'TelReferenciaFamiliar'=> $telFamilia, 'idUsuario'=> $idU, 'status' => 2);
			return $this->db->insert($data, 'choferes');
		}

		/**
		*	updateChoferU(Int idUsuario, String nombre, String apellido, Int expediente, String correo, String pass, String Tel)
		*		@param Int $id - guarda el id del usuario
		*		@param String $nombre - guarda el nombre del chofer
		*		@param String $apellido - guarda el apellido del chofer
		*		@param Int $expediente - guarda el expediene del chofer
		*		@param String $correo - guarda el correo del chofer
		*		@param String $pass - guarda la contraseña del chofer
		*		@param String $Tel - guarda el número telefonico
		*	Esta función actualiza los datos del chofer
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function updateChoferU($id, $nombre, $apellido, $correo, $pass, $Tel){
	  		$data = array('idUsuario'=> $id, 'Nombre'=> $nombre, 'Apellido'=> $apellido, 'Correo'=> $correo, 'Password'=> $pass, 'Telefono'=> $Tel);
	  		return $this->db->update($data, "usuarios", "idUsuario = '$id' ");
		}

		/**
		*	updateChoferUP(Int idUsuario, String nombre, String apellido, Int expediente, String correo, String Tel)
		*		@param Int $id - guarda el id del usuario
		*		@param String $nombre - guarda el nombre del chofer
		*		@param String $apellido - guarda el apellido del chofer
		*		@param Int $expediente - guarda el expediene del chofer
		*		@param String $correo - guarda el correo del chofer
		*		@param String $Tel - guarda el número telefonico
		*	Esta función actualiza los datos del chofer
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function updateChoferUP($id, $nombre, $apellido, $correo, $Tel){
	  		$data = array('idUsuario'=> $id, 'Nombre'=> $nombre, 'Apellido'=> $apellido, 'Correo'=> $correo, 'Telefono'=> $Tel);
	  		return $this->db->update($data, "usuarios", "idUsuario = '$id' ");
		}

		/**
		*	updateChofer(Int id, String numLicencia, String fechaContra, Strin telFamilia)
		*		@param String $numLicencia - guarda el numero de licencia
		*		@param String $fechaContra - guarda la fecha de contratación
		*		@param String $telFamilia - guarda el numero telefonico de un familiar
		*	Esta función actualiza las caracteristicas del chofer
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function updateChofer($id, $numLicencia, $telFamilia){
			$data = array('idChofer'=>$id, 'NumLicencia'=> $numLicencia, 'TelReferenciaFamiliar'=> $telFamilia);
			return $this->db->update($data, "choferes", "idUsuario = '$id' ");
		}

		/**
		*	select deleteChoferU(Int id)
	*		@param Int id - guarda el id del chofer
		*	Esta función borra las caracteristicas de chofer seleccionado.
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function deleteChoferU($id){
      $data = array('status' => 6);
      return $this->db->update($data, "choferes", "idChofer = '$id'");
			return $this->db->delete("choferes", " idUsuario = '$id' ");
		}

		/**
		*	select deleteCofer(Int id)
		*		@param Int id - guarda el id del chofer
		*	Esta función borra al chofer seleccionado.
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function deleteChofer($id){
      $data = array('status' => 6);
      return $this->db->update($data, "usuarios", "idUsuario = '$id'");
		}
		/**
		*	select deleteCofer(Int id)
		*		@param Int id - guarda el id del chofer
		*	Esta función borra al chofer seleccionado.
		*		@return bool con el resultado de la ejecución de la consulta
		*/
		public function deleteChoferD($id){
			return $this->db->delete("usuarios", " idUsuario = '$id' ");
		}

  	/*------------------------------------------Fin Caso de uso Registrar Chofer, Modificar Chofer y Eliminar Chofer--------------------------*/

  	/*-------------------------------------------Inicio de retroalimentacion---------------------------------------------------------------*/
  		/**
		*	traer()
		*		@param Int $fecha - guarda la fecha
		*	Esta funciona trae la calificación del viaje con la fecha ingresada
		*		@return respuesta del Query
		*/
		public function traer($fecha){
			return $this->db->selectStrict("u.Nombre, v.fecha, c.Calificacion, c.Retroalimentacion", "calificaciones c, viajes v, usuarios u", "c.idViaje = v.idViaje AND  c.idUsuario = u.idUsuario AND v.fecha = '$fecha'");
		}
  	/*-------------------------------------------Fin de retroalimentacion---------------------------------------------------------------------*/


  }


?>
