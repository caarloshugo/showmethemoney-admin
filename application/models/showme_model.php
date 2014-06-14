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
	
	/*Check if user exists*/
	public function isUser($email = "", $password = "") {
		$query = $this->db->get_where('users', array('email' => $email, 'pwd' => $password));
		$row   = $query->row(0);
		
		if(isset($row->id_user)) {
			return $row;
		} else {
			return false;
		}
	}
	
	/*Busca todas las facturas*/
	public function facturas() {
		$query = $this->db->query('
			select facturas.*, conceptos.descripcion as concepto, fecha_solicitud, file_url_solicitud, file_url_respuesta, 
			solicitudes.folio as folio_solicitud, legisladores.nombre as legislador, id_partido subvensiones.nombre as subvension from facturas 
			left join subvensiones ON facturas.id_subvension=subvensiones.id_subvension 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto
			left join solicitudes ON facturas.id_solicitud=solicitudes.id_solicitud 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Busca una factura en especifico*/
	public function factura($id_factura) {
		$query = $this->db->query('
			select facturas.*, conceptos.descripcion as concepto, fecha_solicitud, file_url_solicitud, file_url_respuesta, 
			solicitudes.folio as folio_solicitud, legisladores.nombre as legislador, id_partido subvensiones.nombre as subvension from facturas 
			left join subvensiones ON facturas.id_subvension=subvensiones.id_subvension 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto
			left join solicitudes ON facturas.id_solicitud=solicitudes.id_solicitud 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador where id_factura='. $id_factura
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Busca todos los conceptos, suma de montos*/
	public function conceptos() {
		$query = $this->db->query('
			select facturas.id_concepto, sum(monto) as monto, conceptos.descripcion as concepto from facturas 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto group by id_concepto'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Busca todos los legisladores, suma de montos*/
	public function legisladores() {
		$query = $this->db->query('
			select facturas.id_legislador, sum(monto) as monto, legisladores.nombre as legislador from facturas 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador 
			where facturas.id_legislador is not NULL and facturas.id_legislador != 0 group by id_legislador'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Top 5 de facturas por legiladores ordenados por monto*/
	public function ranking_legisladores() {
		$query = $this->db->query('
			select facturas.id_legislador, sum(monto) as monto, legisladores.nombre as legislador from facturas 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador 
			where facturas.id_legislador is not NULL and facturas.id_legislador != 0 group by id_legislador order by monto desc limit 5'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Top 5 de facturas por conceptos ordenados por monto*/
	public function ranking_conceptos() {
		$query = $this->db->query('
			select facturas.id_concepto, sum(monto) as monto, conceptos.descripcion as concepto from facturas 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto group by id_concepto order by monto desc limit 5'
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Busca todas las facturas de un concepto en especifico*/
	public function concepto($id_concepto) {
		$query = $this->db->query('
			select facturas.*, conceptos.descripcion as concepto, fecha_solicitud, file_url_solicitud, file_url_respuesta, 
			solicitudes.folio as folio_solicitud, legisladores.nombre as legislador, id_partido subvensiones.nombre as subvension from facturas 
			left join subvensiones ON facturas.id_subvension=subvensiones.id_subvension 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto
			left join solicitudes ON facturas.id_solicitud=solicitudes.id_solicitud 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador where facturas.id_concepto='. $id_concepto
		);
		
		$data = $query->result_array();
		
		return $data;
	}
	
	/*Busca todas las facturas de un legislador en especifico*/
	public function legislador($id_legislador) {
		$query = $this->db->query('
			select facturas.*, conceptos.descripcion as concepto, fecha_solicitud, file_url_solicitud, file_url_respuesta, 
			solicitudes.folio as folio_solicitud, legisladores.nombre as legislador, id_partido subvensiones.nombre as subvension from facturas 
			left join subvensiones ON facturas.id_subvension=subvensiones.id_subvension 
			left join conceptos ON facturas.id_concepto=conceptos.id_concepto
			left join solicitudes ON facturas.id_solicitud=solicitudes.id_solicitud 
			left join legisladores ON facturas.id_legislador=legisladores.id_legislador where facturas.id_legislador='. $id_legislador
		);
		
		$data = $query->result_array();
		
		return $data;
	}
}
