<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Los_Angeles');

class Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Queries');
		$this->load->model('Insert');
	}

	public function userValidation(){

		if ($this->session->userdata('n_IdUser') == null) {
			redirect(site_url('log'));
			return false;
		}
	}

	public function index(){

		$this->session->sess_destroy();
		$this->load->view('Intranet/presentation');

	}

	public function log(){

		$this->session->sess_destroy();
		$this->load->view('Template/header');
		$this->load->view('Intranet/log');
		$this->load->view('Template/footer');

	}

	public function work(){

		if ($this->session->userdata('n_IdUser') == null){
			$info['noLog'] = true;
		}else{
			$info['idUser'] = $this->session->userdata('n_IdUser');
			$info['userName'] = $this->session->userdata('t_Name');
			$info['lastName'] = $this->session->userdata('t_LastName');
			$info['lastName'] = $this->session->userdata('t_LastName');
			$info['userKind'] = $this->session->userdata('n_UserKind');
		}
		$this->load->view('Template/header');
		$this->load->view('Template/wrapper',$info);
		$this->load->view('Intranet/service');
		$this->load->view('Template/footer');

	}

	public function alta(){

		$this->load->view('Template/header');
		$this->load->view('Intranet/alta');
		$this->load->view('Template/footer');

	}

	public function supervision() {

		$this->userValidation();

		$info['idUser'] = $this->session->userdata('n_IdUser');
		$info['userName'] = $this->session->userdata('t_Name');
		$info['lastName'] = $this->session->userdata('t_LastName');
		$info['userKind'] = $this->session->userdata('n_UserKind');

		$this->load->view('Template/header');
		$this->load->view('Template/wrapper',$info);
		$this->load->view('Intranet/supervisors');
		$this->load->view('Template/footer');
	}

	public function vendors() {

		$this->userValidation();

		$info['idUser'] = $this->session->userdata('n_IdUser');
		$info['userName'] = $this->session->userdata('t_Name');
		$info['lastName'] = $this->session->userdata('t_LastName');
		$info['userKind'] = $this->session->userdata('n_UserKind');

		$this->load->view('Template/header');
		$this->load->view('Template/wrapper',$info);
		$this->load->view('Intranet/vendors');
		$this->load->view('Template/footer');
	}

	public function users(){

		$q_users = $this->Queries->query_user();

		if ($q_users) {

			echo json_encode($q_users);

		}else{

			echo json_encode(false);
		}
	}

	public function supervisor(){

		$q_supervisor = $this->Queries->query_user(false,2);

		if ($q_supervisor) {
			echo json_encode($q_supervisor);
		}else{
			echo json_encode(false);
		}
	}

	public function signUp(){

		$data = json_decode(file_get_contents("php://input"), true);

		$user = $data['User'];
		$param['t_Password'] = password_hash($data['PUser'], PASSWORD_DEFAULT);

		$u_user = $this->Insert->upd_user($param, $user);
		if ($u_user) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function logIn(){

		$data = json_decode(file_get_contents("php://input"), true);

		$user = $data['User'];
		$passwordUser = $data['PUser'];

		$q_users = $this->Queries->query_user($user);
		if ($q_users) {
			if (password_verify($passwordUser, $q_users[0]['t_Password'])) {
				foreach ($q_users as $user) {
					$user_session = array('n_IdUser' => $user['n_IdUser'] , 't_Name' => $user['t_Name'] , 't_LastName' => $user['t_LastName'] , 'n_UserKind' => $user['n_UserKind']);
				}
				$this->session->set_userdata($user_session);
				echo json_encode(true);
			}else{
				echo json_encode(false);
			}
		}else{
			echo json_encode(false);
		}
	}

	public function checkIn(){

		$data = json_decode(file_get_contents("php://input"), true);

		$uName = $data['UName'];
		$nEstab = $data['NEst'];
		$nSup = intval($data['NSup']);
		$cDate = date('Y-m-d H:i:s');
		$latitude = floatval($data['Lati']);
		$longitude = floatval($data['Long']);

		$param['t_UserName'] = $uName;
		$param['n_IdSupervisor'] = $nSup;
		$param['t_Establishment'] = $nEstab;
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

	public function checks(){

		$data = json_decode(file_get_contents("php://input"), true);

		$userKind = $this->session->userdata('n_UserKind');
		$user = false;
		$date = false;

		if ($userKind != 1) {
			$user = $this->session->userdata('n_IdUser');
		}

		if ($data != null) {
			$date = $data['Date'];
		}
		
		$q_checks = $this->Queries->query_service(false,false,$user,$date);
		
		if ($q_checks) {
			echo json_encode($q_checks);
		}else{
			echo json_encode(false);
		}
	}

	public function change(){

		$data = json_decode(file_get_contents("php://input"), true);

		$n_IdService = $data['Id'];
		$param['t_UserName'] = $data['Employee'];
		$param['n_IdSupervisor'] = $data['Sup'];
		$param['t_Establishment'] = $data['Estab'];
		$param['dt_CheckIn'] = $data['CheckIn'];
		$param['dt_CheckOut'] = $data['CheckOut'];
		$param['ti_TotalHours'] = $data['TotalHours'];

		$u_service = $this->Insert->upd_service($param,$n_IdService);
		if ($u_service) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function sendMail(){

		$data = json_decode(file_get_contents("php://input"), true);

		$to = "cs@janitorialcoronasllc.com";
		$subject = "Job apply";
		$message = "Candidate information.\n\n\nName: ".$data['Name']."\n\nSocialSecurity: ".$data['SocSec']."\n\nAddress: ".$data['Address']."\n\nPhone Number: ".$data['PNumber']."\n\nKind of Job: ".$data['KindJob']."\n\nJob: ".$data['Job'];
		$headers = "From: webmaster@janitorialcoronasllc.com";

		$mail = mail($to, $subject, $message, $headers);

		if ($mail) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function states(){

		$states = $this->Queries->query_states();

		if ($states) {
			echo json_encode($states);
		}else{
			echo json_encode(false);
		}

	}

	public function cities(){

		$data = json_decode(file_get_contents("php://input"), true);

		$IdState = $data['IdState'];

		$cities = $this->Queries->query_cities(false,$IdState);

		if ($cities) {
			
			echo json_encode($cities);
		}else{
			echo json_encode(false);
		}

	}

	public function registerVendor(){

		$data = json_decode(file_get_contents("php://input"), true);

		$param['t_VName'] = $data['vName'];
		$param['t_VAddress'] = $data['vAddress'];
		$param['n_VPhone'] = $data['vPhone'];
		$param['t_VContact'] = $data['vContact'];
		$param['t_VEmail'] = $data['vEmail'];
		$param['t_TaxId'] = $data['vTax'];
		$param['n_IdState'] = $data['vState'];
		$param['n_IdCity'] = $data['vCity'];
		$param['t_VServices'] = $data['vServices'];
		$param['t_VPlaces'] = $data['vPlaces'];

		if ($data['direct'] == true) {
			$param['n_Status'] = 1;
		}else{
			$param['n_Status'] = 2;
		}

		$i_vendor = $this->Insert->ins_vendor($param);
		if ($i_vendor) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function updateVendor(){

		$data = json_decode(file_get_contents("php://input"), true);

		$param['t_VName'] = $data['vName'];
		$param['t_VAddress'] = $data['vAddress'];
		$param['n_VPhone'] = $data['vPhone'];
		$param['t_VContact'] = $data['vContact'];
		$param['t_VEmail'] = $data['vEmail'];
		$param['t_TaxId'] = $data['vTax'];
		$param['n_IdState'] = $data['vState'];
		$param['n_IdCity'] = $data['vCity'];
		$param['t_VServices'] = $data['vServices'];
		$param['t_VPlaces'] = $data['vPlaces'];

		$idVendor = $data["idVendor"];

		$u_vendor = $this->Insert->upd_vendor($param,$idVendor);
		if ($u_vendor) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function vendorsQuery(){

		$data = json_decode(file_get_contents("php://input"), true);

		$q_vendors = false;

		switch ($data['param']) {
			case 'firstValidating':
				$q_vendors = $this->Queries->query_vendors(false,false,"1,2");
				break;

			case 'accepted':
				$q_vendors = $this->Queries->query_vendors(1);
				break;
			
			case 'canceled':
				$q_vendors = $this->Queries->query_vendors(3);
				break;
			
			default:
				$q_vendors = false;
				break;
		}

		

		if ($q_vendors) {
			echo json_encode($q_vendors);
		}else{
			echo json_encode(false);
		}
	}

	public function valVendor(){

		$data = json_decode(file_get_contents("php://input"), true);

		$idVendor = $data['Id'];

		switch ($data['Action']) {
			case 'accept':
				$param['n_Status'] = 1;
				break;
			
			case 'deny':
				$param['n_Status'] = 3;
				break;
			
			case 'restore':
				$param['n_Status'] = 2;
				break;
		}

		$u_vendor = $this->Insert->upd_vendor($param, $idVendor);
		if ($u_vendor) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function changePassword(){

		$data = json_decode(file_get_contents("php://input"), true);

		$id = $data['id'];
		$param['t_Password'] = password_hash($data['newPassword'], PASSWORD_DEFAULT);

		$u_user = $this->Insert->upd_user($param, $id);
		if($u_user){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

}