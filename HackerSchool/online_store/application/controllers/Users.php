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
                    redirect('/users/account/');
                    
                } else{
                    $this->session->set_userdata('error_msg', 'Wrong email or password, please try again.');
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
        if($this->input->post('registrSubmit')) {
			
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('phone', 'Phone', 'max_length[32]');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => hash("sha256", $this->input->post('password')),
                'gender' => $this->input->post('gender'),
                'phone' => $this->input->post('phone'),
                'country' => $this->input->post('country'),
                'region' => $this->input->post('region'),
                'street_address' => $this->input->post('street_address')
            );

            if($this->form_validation->run() == true) {
                $insert = $this->user_model->insert($userData);           
                if($insert) {					
                    $this->session->set_userdata('success_msg', 'Your registration was successfully. Please login to your account.');
                    redirect('/users/login/');                    
                } else {
                    $this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
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
                    $this->session->set_userdata('success_msg', 'You successfully changed your password.');                  
                } else {
					$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');                   
                }
                
                redirect('/users/account/');
                              
            } 
		} 
		
		$this->account();	

	}
	
	public function update_name_email() {
		$data = array();
		
		if($this->input->post('nameEmailSubmit')) {

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check_without_current');
            
            if($this->form_validation->run() == true) {
				
				$params = array(
					'set' => array('name' => $this->input->post('name'), 'email' => $this->input->post('email')), 
					'conditions' => array('id' => $this->session->userdata('userId'))
				);
					
                $update = $this->user_model->update($params); 
                          
                if($update) {					
                    $this->session->set_userdata('success_msg', 'You successfully updated your info.');                 
                } else {
					$this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
                }         
                
                redirect('/users/account/');
                    
            } 
		}
		
		$this->account();
	}
    
    public function logout() {
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        //$this->session->sess_destroy();
        redirect('/users/login/');
    }
    
    public function email_check($str) {
		
        $params['returnType'] = 'count';
        $params['conditions'] = array('email' => $str);
        
        $checkEmail = $this->user_model->getRows($params);
        
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
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
            $this->form_validation->set_message('email_check_without_current', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}


?>
