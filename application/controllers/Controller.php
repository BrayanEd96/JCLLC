<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Los_Angeles');

class Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Queries');
		$this->load->model('Insert');
	}

	public function index(){

		$this->load->view('Intranet/presentation');

	}

	public function work(){

		$this->load->view('Template/header');
		$this->load->view('Intranet/service');
		$this->load->view('Template/footer');

	}

	public function test(){
		$this->load->view('Intranet/test');
	}

	public function location(){

		$q_establishment = $this->Queries->query_est();

		if ($q_establishment) {
			echo json_encode($q_establishment);
		}else{
			echo json_encode(false);
		}
	}

	public function supervisor(){

		$q_supervisor = $this->Queries->query_sup(2);

		if ($q_supervisor) {
			echo json_encode($q_supervisor);
		}else{
			echo json_encode(false);
		}
	}

	public function checkIn(){

		$data = json_decode(file_get_contents("php://input"), true);

		$uName = $data['UName'];
		$nEstab = intval($data['NEst']);
		$nSup = intval($data['NSup']);
		$cDate = date('Y-m-d H:i:s');
		$latitude = floatval($data['Lati']);
		$longitude = floatval($data['Long']);

		$param['t_UserName'] = $uName;
		$param['n_IdSupervisor'] = $nSup;
		$param['n_IdEstablishment'] = $nEstab;
		$param['dt_CheckIn'] = $cDate;
		$param['de_LatitudeCheckIn'] = $latitude;
		$param['de_LongitudeCheckIn'] = $longitude;

		$i_service = $this->Insert->ins_service($param);

		if ($i_service) {
			$q_service = $this->Queries->query_service($cDate);
			echo json_encode($q_service[0]['n_IdService']);
		}else{
			echo json_encode(false);
		}
	}

	public function checkOut(){

		$data = json_decode(file_get_contents("php://input"), true);

		$nService = intval($data['NServ']);
		$time = explode(':',$data['NTotal']);
		$latitude = floatval($data['Lati']);
		$longitude = floatval($data['Long']);

		$param['dt_CheckOut'] = date('Y-m-d H:i:s');
		$param['ti_TotalHours'] = date('H:i:s',mktime($time[0],$time[1],$time[2]));
		$param['de_LatitudeCheckOut'] = $latitude;
		$param['de_LongitudeCheckOut'] = $longitude;

		$u_service = $this->Insert->upd_service($param,$nService);
		if ($u_service) {
			$q_service = $this->Queries->query_service(false,$nService);
			if ($q_service) {
				echo json_encode($q_service);
			}else{
				echo json_encode(false);
			}
		}else{
			echo json_encode(false);
		}
	}
}