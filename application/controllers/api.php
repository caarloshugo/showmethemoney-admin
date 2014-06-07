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
		$user = $this->showme_model->facturas();
	}
	
	/*metodo index - redirect a denuncias*/
	public function index() {
		header('Location: ' . site_url('admin/facturas'));
		
		return false;
	}
}
