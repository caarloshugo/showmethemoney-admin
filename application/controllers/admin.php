<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->database();
		
		//Helpers
		$this->load->helper('url');
		$this->load->helper('date');

		$this->load->library('grocery_CRUD');
		
		ini_set("session.cookie_lifetime", "14400");
		ini_set("session.gc_maxlifetime",  "14400");
		session_start();
	}

	/*Salida de las vistas*/
	public function _example_output($output = null) {
		$this->load->view('admin.php', $output);
	}
	
	/*Users metodo para verificar si es usuario*/
	private function isUser($redirect = true, $admin = false) {
		if(isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			
			$this->load->model('showme_model');
			$user = $this->showme_model->getUser($_SESSION['user_id']);
			
			if($user) {
				
				return $user;
				
				if($redirect) {
					header('Location: ' . site_url('admin/facturas'));
				}
				
				return $user;
			} else {
				if($redirect) {
					header('Location: ' . site_url('admin/login'));
				}
				
				return false;
			}
		} else {
			if($redirect) {
				header('Location: ' . site_url('admin/login'));
			}
			
			return false;
		}
	}
	
	/*Metodo para hacer login*/
	public function login() {
		if($this->isUser(false)) {
			header('Location: ' . site_url('admin/facturas'));
		} else {
			$vars["error"] = false;
			
			if(isset($_POST["submit"])) {
				$this->load->model('showme_model');
				$user = $this->showme_model->isUser(trim(str_replace("'","",$_POST["email"])), md5($_POST["pwd"]));
				
				if($user) {
					$_SESSION['user_id'] = $user->id_user;
					$_SESSION['email']   = $user->email;
					
					header('Location: ' . site_url('admin/facturas'));
				}
				
				$vars["error"] = "datos incorrectos";
			}
			
			$this->load->view('login.php', $vars);
		}
	}
	
	/*Metodo para cerrar session*/
	public function logout() {
		session_unset(); 
		session_destroy();
		
		header('Location: ' . site_url('admin/login'));
	}
	
	
	/*Metodo de facturas*/
	public function facturas() {
		$user = $this->isUser();
		$crud = new grocery_CRUD();
		
		/*Tabla, Título y Orden*/
		$crud->set_theme('datatables');
		$crud->set_table('facturas');
		$crud->set_subject('Facturas');
		
		/*Relaciones n_n*/
		$crud->display_as('id_concepto', 'Concepto');
		$crud->set_relation('id_concepto', 'conceptos', 'descripcion');
		
		$crud->display_as('id_legislador', 'Legislador');
		$crud->set_relation('id_legislador', 'legisladores', 'nombre');
		
		$crud->display_as('file_url_factura', 'Documento de la factura');
		$crud->set_field_upload('file_url_factura', 'assets/uploads/files');
		
		$crud->display_as('rfc', 'RFC');
		
		$crud->display_as('id_solicitud', 'Solicitud de información');
		$crud->set_relation('id_solicitud', 'solicitudes', 'folio');
		
		/*Columnas(Vista), campos y campos obligatorios*/
		$crud->columns('id_factura', 'fecha_factura', 'folio', 'monto', 'id_concepto', 'detalle', 'rfc', 'razon_social');
		
		$crud->required_fields('folio', 'monto', 'rfc', 'id_solicitud');
		
		$output = $crud->render();
		$this->_example_output($output);
	}
	
	/*Autoridades*/
	public function conceptos() {
		$user = $this->isUser();
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('conceptos');
		$crud->set_subject('Conceptos');
		
		/*Columnas(Vista), campos y campos obligatorios*/
		$crud->columns('id_concepto', 'descripcion');
		$crud->required_fields('descripcion');
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Derechos*/
	public function solicitudes() {
		$user = $this->isUser();
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('solicitudes');
		$crud->set_subject('Solicitudes');
		
		$crud->display_as('file_url_solicitud', 'Documento de la Solicitud');
		$crud->set_field_upload('file_url_solicitud', 'assets/uploads/files');
		
		$crud->display_as('file_url_respuesta', 'Documento de la Respuesta');
		$crud->set_field_upload('file_url_respuesta', 'assets/uploads/files');
		
		/*Columnas(Vista), campos y campos obligatorios*/
		$crud->columns('id_solicitud', 'folio', 'fecha_solicitud', 'file_url_solicitud', 'file_url_respuesta');
		$crud->required_fields('folio', 'file_url_solicitud', 'fecha_solicitud');
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Legiladores*/
	public function legisladores() {
		$user = $this->isUser();
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('legisladores');
		$crud->set_subject('Legisladores');
		
		$crud->display_as('id_partido', 'Partido politico');
		$crud->set_relation('id_partido', 'partidos_politicos', 'nombre');
		
		/*Columnas(Vista), campos y campos obligatorios*/
		$crud->columns('id_legislador', 'id_partido', 'nombre');
		$crud->required_fields('nombre');
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*obtener nombre unico de un campo*/
	function unique_field_name($field_name) {
		return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }
	
	/*metodo index - redirect a denuncias*/
	public function index() {
		header('Location: ' . site_url('admin/facturas'));
		
		return false;
	}
}
