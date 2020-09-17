<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert extends CI_Model {

	public function upd_user($data, $n_IdUser){
		if ($this->db->update('pro_users', $data, 'n_IdUser = '.$n_IdUser.'')) {
			return true;
		}else{
			return false;
		}
	}

	public function ins_service($data){
		if($this->db->insert('rel_services', $data)) {
			return true;
		}else{
			return false;
		}
	}

	public function upd_service($data, $n_IdService){
		if($this->db->update('rel_services', $data, 'n_IdService = '.$n_IdService.'')) {
			return true;
		}else{
			return false;
		}
	}

	public function ins_vendor($data){
		if($this->db->insert('pro_vendors', $data)) {
			return true;
		}else{
			return false;
		}
	}

	public function upd_vendor($data, $n_IdVendor){
		if($this->db->update('pro_vendors', $data, 'n_IdVendor = '.$n_IdVendor.'')) {
			return true;
		}else{
			return false;
		}
	}
	
}