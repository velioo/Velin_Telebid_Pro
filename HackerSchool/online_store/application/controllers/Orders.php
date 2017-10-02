<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('order_model');
	}
	
	public function index() {
		if($this->session->userdata('isUserLoggedIn')) {
			redirect('/users/account/');
		} else {
			redirect('/users/login/');
		}
	}
	
	public function create_order() {
		
		if($this->session->userdata('isUserLoggedIn')) {
		
			$data = array();
			
			$this->load->model('cart_model');
			$cartData = $this->cart_model->getRows(array('select' => array('products.id', 'products.price_leva'), 
														   'joins' => array('products' => 'products.id = cart.product_id'), 
														   'conditions' => array('cart.user_id' => $this->session->userdata('userId')), 
														   'group_by' => array('products.id')));		
			if($cartData) {											   
			
				$amountLeva = 0.0;										   
				foreach($cartData as $c) {
					$c['price_leva'] = (float)$c['price_leva'];
					$amountLeva += $c['price_leva'];
				}

				$orderData = array(
					'user_id' => $this->session->userdata('userId'),
					'report' => '',
					'amount_leva' => $amountLeva,
				);
				
				$this->db->trans_begin();

				$orderId = $this->order_model->insert($orderData);		
				foreach($cartData as $c) {		
					$purchaseData = array(
						'product_id' => $c['id'],
						'order_id' => $orderId,
						'price_leva' => $c['price_leva']
					);			
					$insert = $this->order_model->insert($purchaseData, 'purchases');
				}
				
				$delete = $this->cart_model->delete(array('conditions' => array('user_id' => $this->session->userdata('userId'))));

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
				}

				$this->session->set_userdata('orderId', $orderId);

				redirect("/orders/payment_method/");
							
			} else {
				redirect('/welcome/');
			}	
		
		} else {
				redirect('/users/login/');
		} 
	}
	
	public function payment_method() {
		
		if($this->session->userdata('userId') && $this->session->userdata('orderId')) {	
							
			$data = array();
				
			$data['payment_methods'] = $this->order_model->getRows(array('table' => 'payment_methods'));
			$data['title'] = 'Payment Method';
			$this->load->view('payment_method.php', $data);

		} else {
			redirect('/users/login/');
		}
	}
	
	public function select_payment() {		
		
		if($this->session->userdata('userId') && $this->session->userdata('orderId')) {				
				
			$data = array();
			$data['title'] = 'Order Placed';
																					
			$update = $this->order_model->update(array('conditions' => array('orders.id' => $this->session->userdata('orderId')), 'set' => array('payment_method_id' => $this->input->post('payment_method'), 'status_id' => 4)));		
			if($update) {
				$this->session->unset_userdata('orderId');
				$this->load->view('order_created.php', $data);
			} else {
				"There was a server error please try agin later.";
			}											
			
		} else {
			redirect('/users/login/');
		}
		
	}
	
}


?>
