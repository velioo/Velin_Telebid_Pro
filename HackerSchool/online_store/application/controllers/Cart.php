<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('cart_model');
	}
	
	public function index() {
		redirect('/users/cart/');
	}
	
	public function add() {
		if($this->session->userdata('isUserLoggedIn')) {
				
			$product = array();
			$product['product_id'] = $this->input->post('product_id');
			$product['user_id'] = $this->session->userdata('userId');
			$insert = $this->cart_model->insert($product);
			
			if($insert) echo true; else echo false;
		
		} else {
			echo 'login';
			//redirect('/users/login/');
		}
	}
	
		
	public function remove() {
		if($this->session->userdata('isUserLoggedIn')) {
			$delete = $this->cart_model->delete(array('conditions' => array('product_id' => $this->input->post('product_id'), 'user_id' => $this->session->userdata('userId'))));			
			if($delete) echo true; else echo false;	
		} else {
			redirect('/users/login/');
		}
	}
	
	public function cart_count_price() {
		if($this->session->userdata('isUserLoggedIn')) {
			$result = $this->cart_model->getRows(array('select' => array('COUNT(products.price_leva) as count', 'IFNULL(SUM(products.price_leva), 0) as price_leva'), 
													   'joins' => array('products' => 'products.id = cart.product_id'), 
													   'conditions' => array('cart.user_id' => $this->session->userdata('userId'))));
			header('Content-Type:application/json');										   
			echo json_encode($result);
		} else {
			echo false;
			//redirect('/users/login/');
		}
	}
	
}	
?>
