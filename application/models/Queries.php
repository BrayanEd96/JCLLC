<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queries extends CI_Model {

	// public function query_est(){
	// 	$establishment = $this->db->query("SELECT pe.* 
	// 									   FROM pro_establishments pe
	// 									   WHERE 1 > 0");
	// 	if ($establishment->num_rows() != 0) {
	// 		return $establishment->result_array();
	// 	}else{
	// 		return false;
	// 	}									   
	// }

	public function query_user($n_IdUser=false, $n_UserKind=false){
		$supervisor = $this->db->query("SELECT pu.* 
										   FROM pro_users pu
										   WHERE 1 > 0".
										   ($n_IdUser!=false ? " AND pu.n_IdUser = ".$n_IdUser : "").
										   ($n_UserKind!=false ? " AND pu.n_UserKind = ".$n_UserKind : ""));
		if ($supervisor->num_rows() != 0) {
			return $supervisor->result_array();
		}else{
			return false;
		}									   
	}

	public function query_service($dt_CheckIn=false, $n_IdService=false, $n_IdSupervisor=false, $dt_CheckInDate=false){
		$service = $this->db->query("SELECT rs.*, pu.t_Name
									 FROM rel_services rs
									 LEFT JOIN pro_users pu ON rs.n_IdSupervisor = pu.n_IdUser
									 WHERE 1 > 0".
									 ($dt_CheckIn!=false ? " AND dt_CheckIn = '".$dt_CheckIn."'" : "").
									 ($n_IdSupervisor!=false ? " AND n_IdSupervisor = ".$n_IdSupervisor : "").
									 ($n_IdService!=false ? " AND n_IdService = ".$n_IdService : "").
									 ($dt_CheckInDate!=false ? " AND DATE(dt_CheckIn) = '".$dt_CheckInDate."'" : ""));
		if ($service->num_rows() != 0) {
			return $service->result_array();
		}else{
			return false;
		}
	}

	public function query_states($n_IdState=false){
		$states = $this->db->query("SELECT us.* 
										   FROM us_states us
										   WHERE 1 > 0".
										   ($n_IdState!=false ? " AND us.ID = ".$n_IdState : ""));
		if ($states->num_rows() != 0) {
			return $states->result_array();
		}else{
			return false;
		}									   
	}

	public function query_cities($n_IdCity=false, $n_IdState=false){
		$cities = $this->db->query("SELECT uc.* 
										   FROM us_cities uc
										   WHERE 1 > 0".
										   ($n_IdCity!=false ? " AND uc.ID = ".$n_IdCity : "").
										   ($n_IdState!=false ? " AND uc.ID_STATE = ".$n_IdState : ""));
		if ($cities->num_rows() != 0) {
			return $cities->result_array();
		}else{
			return false;
		}									   
	}

	public function query_vendors($n_Status=false,$n_IdVendor=false,$n_StatusIn=false){
		$vendor = $this->db->query("SELECT pv.*,
										   us.STATE_NAME t_StateName,
										   uc.CITY t_CityName,
										   cs.t_Status t_Status
										   FROM pro_vendors pv
										   LEFT JOIN us_states us ON us.ID = pv.n_IdState 
										   LEFT JOIN us_cities uc ON uc.ID = pv.n_IdCity 
										   LEFT JOIN cat_status cs ON cs.n_IdStatus = pv.n_Status 
										   WHERE 1 > 0".
										   ($n_Status!=false ? " AND pv.n_Status = ".$n_Status : "").
										   ($n_IdVendor!=false ? " AND pv.n_IdVendor = ".$n_IdVendor : "").
										   ($n_StatusIn!=false ? " AND pv.n_Status IN(".$n_StatusIn.")" : ""));
		if ($vendor->num_rows() != 0) {
			return $vendor->result_array();
		}else{
			return false;
		}									   
	}
}