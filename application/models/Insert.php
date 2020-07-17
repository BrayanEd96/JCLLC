<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert extends CI_Model {

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
	
}