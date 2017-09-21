<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('product_model');
	}
	
	public function index() {
		$this->get_latest_products();
	}
	
	public function get_latest_products() {
			
		
	}
	
	public function insert_product() {
		
		$data = array();
		$data['title'] = 'Добави продукт';

		if($this->input->post('productSubmit')) {
			
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
            $this->form_validation->set_rules('price_leva', 'Price', 'required|callback_price_check');
            $this->form_validation->set_rules('available', 'Available', 'integer');

            $productData = array(
				'category_id' => $this->input->post('category_id'),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price_leva' => $this->input->post('price_leva'),
                'available' => $this->input->post('available'),
            );
            
            $imageSuccess = TRUE;
            
            if (!empty($_FILES['image']['name'])) {
				
				if(!file_exists("./assets/imgs/{$_FILES['image']['name']}")) {
				
					$config['upload_path']          = './assets/imgs/';
					$config['allowed_types']        = 'gif|jpg|png|jpeg';
					$config['max_size']             = 5000;
					$config['max_width']            = 2048;
					$config['max_height']           = 2048;

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('image')) {
						$productData['image_error'] = array('error' => $this->upload->display_errors());
						$imageSuccess = FALSE;
					} 										
				}	
					
				$productData['image'] = $_FILES['image']['name'];

			}                      

            if(($this->form_validation->run() == true) && $imageSuccess) {
                $insert = $this->product_model->insert($productData);           
                if($insert) {					
                    $this->session->set_userdata('success_msg', 'Продуктът е успешно добавен. ');
                    redirect('/employees/dashboard/');                    
                } else {
                    $this->session->set_userdata('error_msg', 'Възникна проблем, моля свържете се с вашия администратор');
                }
            }  
            
           $data['product'] = $productData;             
			
		} 
		
		$data['categories'] = $this->product_model->getRows(array('table' => 'categories'));
		$categories = array();
		foreach ($data['categories'] as $key => $row) {
			$categories[$key] = $row['name'];
		}		
		array_multisort($categories, SORT_ASC, $data['categories']);	
		
		$this->load->view('add_product', $data);
		
	}
	
	public function update_product($product_id=null) {
		if($product_id !== null && is_numeric($product_id)) {
			$data = array();
			$data['title'] = 'Редактирай продукт';

			if($this->input->post('productSubmit')) {
				
				$this->form_validation->set_rules('name', 'Name', 'required');
				$this->form_validation->set_rules('category_id', 'Category', 'required|integer');
				$this->form_validation->set_rules('price_leva', 'Price', 'required|callback_price_check');
				$this->form_validation->set_rules('available', 'Available', 'integer');

				$productData = array(
					'category_id' => $this->input->post('category_id'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'price_leva' => $this->input->post('price_leva'),
					'available' => $this->input->post('available'),
				);
				
				$imageSuccess = TRUE;
						 
				
				if (!empty($_FILES['image']['name'])) {
					
					if(!file_exists("./assets/imgs/{$_FILES['image']['name']}")) {
					
						$config['upload_path']          = './assets/imgs/';
						$config['allowed_types']        = 'gif|jpg|png|jpeg';
						$config['max_size']             = 5000;
						$config['max_width']            = 2048;
						$config['max_height']           = 2048;

						$this->load->library('upload', $config);

						if (!$this->upload->do_upload('image')) {
							$productData['image_error'] = array('error' => $this->upload->display_errors());
							$imageSuccess = FALSE;
						} 
					} 		
					
					$productData['image'] = $_FILES['image']['name'];

				}                      

				if(($this->form_validation->run() == true) && $imageSuccess) {
					$update = $this->product_model->update(array('set' => $productData, 'conditions' => array('id' => $product_id)));           
					if($update) {					
						$this->session->set_userdata('success_msg', 'Продуктът е успешно редактиран. ');
						redirect('/employees/dashboard/');                    
					} else {
						$this->session->set_userdata('error_msg', 'Възникна проблем, моля свържете се с вашия администратор');
					}
				}  
				
			   $data['product'] = $productData;             
				
			} 
			
			$data['categories'] = $this->product_model->getRows(array('table' => 'categories'));
			$categories = array();
			foreach ($data['categories'] as $key => $row) {
				$categories[$key] = $row['name'];
			}		
			array_multisort($categories, SORT_ASC, $data['categories']);	
			
			$this->load->view('update_product', $data);
		} else {
			echo "Invalid arguments";
		}
	}
	
	public function delete_product($product_id) {
		if($product_id !== null && is_numeric($product_id)) {
			
			$delete = $this->product_model->delete(array('id' => $product_id));
			if($delete) {					
				$this->session->set_userdata('success_msg', 'Продуктът е успешно премахнат. ');
				redirect('/employees/dashboard/');                    
			} else {
				$this->session->set_userdata('error_msg', 'Възникна проблем, моля свържете се с вашия администратор');
			}
			
		} else {
			echo "Invalid arguments";
		}
		
	}
	
	
    public function price_check($val) {
		$val = floatval($val);
        if (!is_float($val) ) {
            $this->form_validation->set_message('price_check', 'Цената трябва да е цяло или десетично число');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}	
?>
