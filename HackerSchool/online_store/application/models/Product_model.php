<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    function __construct() {
        $this->tableName = 'products';
    }

    function getRows($params = array()) {
		
		if(array_key_exists("select", $params)) {
             $this->db->select($params['select']);          
        } else {
			 $this->db->select('*');
		}
       
        
        if(array_key_exists("table", $params)) {
            $this->db->from($params['table']);
        } else {
			$this->db->from($this->tableName);
		}             
        
        if(array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        if(array_key_exists("joins", $params)) {
            foreach ($params['joins'] as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        
        if(array_key_exists("id", $params)) {
            $this->db->where('id', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {

            if(array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif(!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }
            
            $query = $this->db->get();
            
            if(array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
                $result = $query->num_rows();
            } elseif(array_key_exists("returnType", $params) && $params['returnType'] == 'single') {
                $result = ($query->num_rows() > 0) ? $query->row_array() : FALSE;
            } else{
                $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            }
        }

        return $result;
    }
    
    public function insert($data = array()) {
        
        $insert = $this->db->insert($this->tableName, $data);
        
        if($insert) {
            return $this->db->insert_id();
        } else{
            return false;
        }
    }
    
    public function update($params = array()) {
		
		if(array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        if(array_key_exists("set", $params)) {
            $update = $this->db->update($this->tableName, $params['set']);
            return $update;
        } else {
			return FALSE;
		}       
		
	}
	
	public function delete($params = array()) {
		
		if(array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        if(array_key_exists("id", $params)) {
            $this->db->where('id', $params['id']);
            $delete = $this->db->delete($this->tableName);
            return $delete;
        } else {
			return FALSE;
		}  
	}


}


?>