<?php
class showme_Model extends CI_Model  {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
		
	/*Get user by id*/
	public function getUser($id_user) {
		$query = $this->db->get_where('users', array('id_user' => $id_user));
		$row   = $query->row(0);
		
		if(isset($row->id_user)) {
			return $row;
		} else {
			return false;
		}
	}
	
	public function isUser($email = "", $password = "") {
		$query = $this->db->get_where('users', array('email' => $email, 'pwd' => $password));
		$row   = $query->row(0);
		
		if(isset($row->id_user)) {
			return $row;
		} else {
			return false;
		}
	}
	
	public function facturas() {
		$query = $this->db->query('
			select facturas.*, conceptos.descripcion as concepto, fecha_solicitud, file_url_solicitud, file_url_respuesta, 
			solicitudes.folio as folio_solicitud, legisladores.nombre as legislador, id_partido from facturas 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto
			left join solicitudes ON facturas.id_solicitud=solicitudes.id_solicitud 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
}
