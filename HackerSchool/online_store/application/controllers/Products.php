<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('product_model');
	}
	
	public function index() {
		redirect();
	}
	
	public function search() {
		$this->load->library('pagination');
		$config = $this->configure_pagination();
		$config['base_url'] = site_url();
		$config['per_page'] = 28;
		
		if($this->input->get('page') != NULL and is_numeric($this->input->get('page')) and $this->input->get('page') > 0) {
			$start = $this->input->get('page') * $config['per_page'] - $config['per_page'];
		} else {
			$start = 0;
		}
		
		$searchWord = $this->input->get('search_input');
		
		$data['products'] = $this->product_model->getRows( array('select' => array('products.*', 'categories.name as category'),
																 'joins' => array('categories' => 'categories.id=products.category_id'),
																 'like' => array('products.name' => $searchWord),
																 'or_like' => array('products.description' => $searchWord),
																 'order_by' => array('created_at' => 'DESC'),
																 'start' => $start,
																 'limit' => $config['per_page']) );	
																																											
		$config['total_rows'] = $this->product_model->getRows(array('returnType' => 'count'));								
		$this->pagination->initialize($config);							
		$data['pagination'] = $this->pagination->create_links();
			 
		$data['title'] = "Search Results";
		$this->load->view('home', $data);
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
				echo 1;				                    
			} else {
				echo 0;
			}
			
		} else {
			echo 0;
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
    
    public function configure_pagination() {
		$config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config["next_link"] = "Next";
		$config["prev_link"] = "Prev";
	
		return $config;
	}
	
}	
?>
