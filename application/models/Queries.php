<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queries extends CI_Model {

	public function query_est(){
		$establishment = $this->db->query("SELECT pe.* 
										   FROM pro_establishments pe
										   WHERE 1 > 0");
		if ($establishment->num_rows() != 0) {
			return $establishment->result_array();
		}else{
			return false;
		}									   
	}

	public function query_sup($n_UserKind=false){
		$supervisor = $this->db->query("SELECT pu.* 
										   FROM pro_users pu
										   WHERE 1 > 0".
										   ($n_UserKind!=false ? " AND pu.n_UserKind = ".$n_UserKind : ""));
		if ($supervisor->num_rows() != 0) {
			return $supervisor->result_array();
		}else{
			return false;
		}									   
	}

	public function query_service($dt_CheckIn=false,$n_IdService=false){
		$service = $this->db->query("SELECT rs.*, pe.t_NameEst
									 FROM rel_services rs
									 LEFT JOIN pro_establishments pe ON pe.n_IdEstablishment = rs.n_IdEstablishment
									 WHERE 1 > 0".
									 ($dt_CheckIn!=false ? " AND dt_CheckIn = '".$dt_CheckIn."'" : "").
									 ($n_IdService!=false ? " AND n_IdService = ".$n_IdService : ""));
		if ($service->num_rows() != 0) {
			return $service->result_array();
		}else{
			return false;
		}
	}
}