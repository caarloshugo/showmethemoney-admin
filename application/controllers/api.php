<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->database();
		
		//Helpers
		$this->load->helper('url');
		$this->load->helper('date');
	}

	
	/*Metodo facturas*/
	public function facturas() {
		$this->load->model('showme_model');
		$data = $this->showme_model->facturas();
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*Metodo factura - parametro id factura*/
	public function factura($id_factura) {
		$this->load->model('showme_model');
		$data = $this->showme_model->factura($id_factura);
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*Metodo por conceptos*/
	public function conceptos() {
		$this->load->model('showme_model');
		$data = $this->showme_model->conceptos();
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*Metodo por legisladores*/
	public function legisladores() {
		$this->load->model('showme_model');
		$data = $this->showme_model->legisladores();
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*Metodo por Ranking legisladores*/
	public function ranking_legisladores() {
		$this->load->model('showme_model');
		$data = $this->showme_model->ranking_legisladores();
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*Metodo por Ranking conceptos*/
	public function ranking_conceptos() {
		$this->load->model('showme_model');
		$data = $this->showme_model->ranking_conceptos();
		
		header('Content-Type: application/json');
		echo json_encode($data, JSON_NUMERIC_CHECK);
	}
	
	/*metodo index - redirect a denuncias*/
	public function index() {
		header('Location: ' . site_url('admin/facturas'));
		
		return false;
	}
}
