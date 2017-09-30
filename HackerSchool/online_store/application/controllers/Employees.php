<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('employee_model');
		$this->load->model('product_model');
	}
	
	public function index() {
		redirect('/employees/login/');
	}
	
	public function login() {			
		$data = array();      
        $data['title'] = 'Employee login';               
        
        if($this->input->post('loginSubmit')) {
			
			$checkLogin = $this->employee_model->getRows(array('select' => array('password', 'salt', 'id'), 'conditions' => array('username' => $this->input->post('username')), 'returnType' => 'single'));

			if($checkLogin && ((hash("sha256", $this->input->post('password') . $checkLogin['salt'])) === $checkLogin['password'])) {								
				
				$this->session->set_userdata('isEmployeeLoggedIn',TRUE);
				$this->session->set_userdata('employeeId', $checkLogin['id']);
				redirect('/employees/dashboard/');
				
			} else {
				$this->session->set_userdata('error_msg_timeless', 'Wrong email or password.');
			}                 
            
            $this->load->view('employee_login', $data);
            
        } elseif ($this->session->userdata('isEmployeeLoggedIn')) {
			redirect('/employees/dashboard/');
		} else {
			$this->load->view('employee_login', $data);
		}
	}
	
	public function logout() {
        $this->session->unset_userdata('isEmployeeLoggedIn');
        $this->session->unset_userdata('employeeId');
        //$this->session->sess_destroy();
        redirect('/employees/login/');
    }
	
	public function dashboard() {
		$data = array();
		$data['title'] = 'Dashboard';
		$data['products'] = $this->product_model->getRows(array('select' => array('products.*' , 'categories.name as category'), 'joins' => array('categories' => 'categories.id = products.category_id')));
		$this->load->view('dashboard', $data);
	}
	
	public function add_product() {
		$data = array();		
		$data['categories'] = $this->product_model->getRows(array('table' => 'categories'));
		$categories = array();
		foreach ($data['categories'] as $key => $row) {
			$categories[$key] = $row['name'];
		}		
		array_multisort($categories, SORT_ASC, $data['categories']);	
		$data['title'] = 'Добави продукт';
		$this->load->view('add_product', $data);
	}
	
	public function update_product($product_id=null) {
		if($product_id !== null && is_numeric($product_id)) {
			$data = array();
			$data['product'] = $this->product_model->getRows(array('id' => $product_id));	
			$data['categories'] = $this->product_model->getRows(array('table' => 'categories'));	
			$data['title'] = 'Редактирай продукт';
			$this->load->view('update_product', $data);
		} else {
			echo "Invalid arguments";
		}
	}
	
}	
?>
