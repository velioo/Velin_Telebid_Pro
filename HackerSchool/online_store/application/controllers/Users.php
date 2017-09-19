<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('user');
	}
	
	public function account() {
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id' => $this->session->userdata('userId')));
            $this->load->view('users/account', $data);
        } else {
            redirect('users/login');
        }
    }
    
    public function login() {
		
        $data = array();      
        
        if($this->input->post('loginSubmit')) {
			
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            
            if ($this->form_validation->run() == true) {
                $conditions['returnType'] = 'single';
                $conditions['conditions'] = array(
                    'username' => $this->input->post('username'),
                    'password' => hash("sha256", $this->input->post('password'))                   
                );
                
                $checkLogin = $this->user->getRows($conditions);
                
                if($checkLogin){
					
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId', $checkLogin['id']);
                    redirect('users/account/');
                    
                } else{
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }
        $this->load->view('users/login', $data);
    }
    
    public function registration() {
        $data = array();
        $userData = array();
        if($this->input->post('registrSubmit')) {
			
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
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
                'street_address' => $this->input->post('street_address');
            );

            if($this->form_validation->run() == true) {
                $insert = $this->user->insert($userData);           
                if($insert) {					
                    $this->session->set_userdata('success_msg', 'Your registration was successfully. Please login to your account.');
                    redirect('users/login');                    
                } else {
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        $data['user'] = $userData;
        $this->load->view('users/registration', $data);
    }
    
    public function logout() {
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->sess_destroy();
        redirect('users/login/');
    }
    
    public function email_check($str) {
		
        $conditions['returnType'] = 'count';
        $conditions['conditions'] = array('email' => $str);
        
        $checkEmail = $this->user->getRows($conditions);
        
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}


?>
