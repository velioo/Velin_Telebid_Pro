<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model');
	}
	
	public function index() {
		if($this->session->userdata('isUserLoggedIn')) {
			redirect('/users/account/');
		} else {
			redirect('/users/login/');
		}
	}
	
	public function account() {
        $data = array();
        $data['title'] = "Account settings";
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user_model->getRows(array('id' => $this->session->userdata('userId')));
            $this->load->view('account', $data);
        } else {
            redirect('/users/login/');
        }
    }
    
    public function details() {
		$data = array();
		$data['countries'] = $this->user_model->getRows(array('table' => 'countries', 'select' => array('nicename', 'phonecode')));
        $data['title'] = "Account details";
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user_model->getRows(array('id' => $this->session->userdata('userId')));
            $this->load->view('details', $data);
        } else {
            redirect('/users/login/');
        }
	}
	
	public function orders() {
		$data = array();
        $data['title'] = "Orders details";
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user_model->getRows(array('id' => $this->session->userdata('userId')));
            $this->load->view('orders', $data);
        } else {
            redirect('/users/login/');
        }
	}
	
	public function cart() {
		$data = array();
        $data['title'] = "Количка";
        if($this->session->userdata('isUserLoggedIn')){
			$this->load->model('product_model');
            $data['products'] = $this->product_model->getRows(array('select' => array('products.name', 'products.price_leva', 'products.image'), 
																    'joins' => array('cart' => 'cart.product_id = products.id', 'users' => 'users.id = cart.user_id'),
																    'conditions' => array('users.id' => $this->session->userdata('userId'))));
            $this->load->view('cart', $data);
        } else {
            redirect('/users/login/');
        }
	}
    
    public function login() {
		
        $data = array();      
        $data['title'] = "Login";
        
        if($this->input->post('loginSubmit')) {
			
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            
            if ($this->form_validation->run() == true) {
                $params['returnType'] = 'single';
                $params['conditions'] = array(
                    'email' => $this->input->post('email'),
                    'password' => hash("sha256", $this->input->post('password'))                   
                );
                
                $checkLogin = $this->user_model->getRows($params);
                
                if($checkLogin){
					
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId', $checkLogin['id']);
                    redirect('/welcome/');
                    
                } else{
                    $this->session->set_userdata('error_msg', 'Грешен имейл или парола');
                }               
            }
            
            $this->load->view('login', $data);
            
        } elseif ($this->session->userdata('isUserLoggedIn')) {
			redirect('/users/account/');
		} else {
			$this->load->view('login', $data);
		}
    }
    
    public function registration() {
        $data = array();
        $data['title'] = "Registration";
        $userData = array();           

		$data['countries'] = $this->user_model->getRows(array('table' => 'countries', 'select' => array('nicename', 'phonecode')));

        if($this->input->post('registrSubmit')) {

            $this->form_validation->set_rules('name', 'Name', 'required|max_length[64]');
            $this->form_validation->set_rules('last_name', 'max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[64]|callback_email_check');
            $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[32]|callback_validate_phone');
            $this->form_validation->set_rules('country', 'Country', 'max_length[64]');
            $this->form_validation->set_rules('region', 'Region', 'max_length[64]');
            $this->form_validation->set_rules('street_address', 'Street Address', 'max_length[255]');
            $this->form_validation->set_rules('password', 'password', 'required|max_length[255]');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'name' => $this->input->post('name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => hash("sha256", $this->input->post('password')),
                'gender' => $this->input->post('gender'),
                'phone' => 	$this->input->post('phone'),
                'country' => $this->input->post('country'),
                'region' => $this->input->post('region'),
                'street_address' => $this->input->post('street_address')
            );

            if($this->form_validation->run() == true) {
				
				$userData['phone'] = preg_replace("/[^0-9]/","", $userData['phone']);
				
                $insert = $this->user_model->insert($userData);           
                if($insert) {					
                    $this->session->set_userdata('success_msg', 'Ти успешно се регистрира. Може да се логнете.');
                    redirect('/users/login/');                    
                } else {
                    $this->session->set_userdata('error_msg', 'Възникна проблем, моля опитайте по-късно.');
                }
            }  
            
           $data['user'] = $userData; 
           $this->load->view('registration', $data);   
                
        } elseif ($this->session->userdata('isUserLoggedIn')) {
			 redirect('/users/account/');
		} else {
			$this->load->view('registration', $data);
		}		
       
    }
    
    public function update_password() {
		$data = array();
		
		if($this->input->post('passwordSubmit')) {
			
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
            
            if($this->form_validation->run() == true) {
				
				$params = array(
					'set' => array('password' => hash("sha256", $this->input->post('password'))), 
					'conditions' => array('id' => $this->session->userdata('userId'))
				);
					
                $update = $this->user_model->update($params); 
                          
                if($update) {					
                    $this->session->set_userdata('success_msg', 'Ти успешно промени паролата си.');                  
                } else {
					$this->session->set_userdata('error_msg', 'Възникна проблем, моля опитайте по-късно.');                   
                }
                
                redirect('/users/account/');
                              
            } 
		} 
		
		$this->account();	

	}
	
	public function update_name_email() {
		$data = array();
		
		if($this->input->post('nameEmailSubmit')) {

            $this->form_validation->set_rules('name', 'Name', 'required|max_length[64]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[64]|callback_email_check_without_current');
            
            if($this->form_validation->run() == true) {
				
				$params = array(
					'set' => array('name' => $this->input->post('name'), 'last_name' => $this->input->post('last_name'), 'email' => $this->input->post('email')), 
					'conditions' => array('id' => $this->session->userdata('userId'))
				);
					
                $update = $this->user_model->update($params); 
                          
                if($update) {					
                    $this->session->set_userdata('success_msg', 'Успешна промяна на данни.');                 
                } else {
					$this->session->set_userdata('error_msg', 'Възникна проблем, моля опитайте по-късно.');
                }         
                
                redirect('/users/account/');
                    
            } 
		}
		
		$this->account();
	}
	
    public function update_info() {
		$data = array();
		
		if($this->input->post('infoSubmit')) {
			
            $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[32]|callback_validate_phone');
            $this->form_validation->set_rules('country', 'Country', 'max_length[64]');
            $this->form_validation->set_rules('region', 'Region', 'max_length[64]');
            $this->form_validation->set_rules('street_address', 'Street Address', 'max_length[255]');
            
            if($this->form_validation->run() == true) {
				
				$params = array(
					'set' => array('gender' => $this->input->post('gender'),
						'phone' => $this->input->post('phone'),
						'country' => $this->input->post('country'),
						'region' => $this->input->post('region'),
						'street_address' => $this->input->post('street_address')), 
					'conditions' => array('id' => $this->session->userdata('userId'))
				);
					
                $update = $this->user_model->update($params); 
                          
                if($update) {					
                    $this->session->set_userdata('success_msg', 'Успешна промяна на данни.');                  
                } else {
					$this->session->set_userdata('error_msg', 'Възникна проблем, моля опитайте по-късно.');                   
                }
                
                redirect('/users/details/');
                              
            }
		} 
		
		$this->details();	

	}
    
    public function logout() {
		if ($this->session->userdata('isUserLoggedIn')) {
			$this->load->model('cart_model');
			$this->cart_model->delete(array('conditions' => array('user_id' => $this->session->userdata('userId'))));
			$this->session->unset_userdata('isUserLoggedIn');
			$this->session->unset_userdata('userId');               
			//$this->session->sess_destroy();
			redirect('/users/login/');
		} else {
			redirect('users/account');
		}
    }
    
    public function email_check($str) {
		
        $params['returnType'] = 'count';
        $params['conditions'] = array('email' => $str);
        
        $checkEmail = $this->user_model->getRows($params);
        
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'Имейлът е зает.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function email_check_without_current($str) {
		
		$user_email = $this->user_model->getRows(array('id' => $this->session->userdata('userId')))['email'];
		
        $params['returnType'] = 'single';
        $params['conditions'] = array('email' => $str);
        
        $result = $this->user_model->getRows($params);
        
        if($result && $result['email'] != $user_email){
            $this->form_validation->set_message('email_check_without_current', 'Имейлът е зает.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function validate_phone($str) {
		
		if(preg_match("/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/", $str)) {
			return TRUE;				
		} elseif(preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i", $str)) {
			return TRUE;
		} elseif(preg_match("/^\d{10,14}$/", $str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_phone', 'Въведете валиден телефонен номер.');
			return FALSE;
		}
	}
	
}


?>
