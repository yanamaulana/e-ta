<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	private $mst_jabatan     = 'tmst_jabatan';
	private $tbl_account     = 'tbl_account';
	private $tbl_employee    = 'tbl_employee';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_helper', 'help');
	}

	public function index()
	{
		if ($this->session->userdata("sys_username")) {
			return redirect("Dashboard");
		}
		$this->data['page_title'] = "Login";

		$this->load->view('Auth/index', $this->data);
	}


	public function post_login()
	{
		if (!$this->input->is_ajax_request()) {
			$response = [
				"code" => 404,
				"msg" => "Terjadi kesalahan teknis, Request denied!"
			];
			return $this->help->Fn_resulting_response($response);
		}
		$login = $this->input->post(null, true);
		$login = (object) $login;
		$login->username = $login->u;
		$login->password = md5($login->p);

		if (empty($login->username) && empty($login->password)) {
			$response = [
				"code" => 404,
				"msg" => "Username & Password is required!"
			];
			return $this->help->Fn_resulting_response($response);
		}

		$users = $this->db->get_where('tbl_account', [
			'UserName' => $login->username,
			'Password' => $login->password
		]);
		if ($users->num_rows() > 0) {
			$user = $users->row_array();
			if ($user['is_active'] == 0) {
				$response = [
					"code" => 404,
					"msg" => "User is not active !"
				];
				return $this->help->Fn_resulting_response($response);
			}
			$employee = $this->db->get_where('qview_employee_active', [
				'UserName' => $login->username,
			])->row_array();
			$session_data = array(
				'sys_nama'	 			=> $user['Nama'],
				'sys_ID'	 			=> $user['ID'],
				'sys_username'	 		=> $user['UserName'],
				'sys_role'	 			=> $user['Role'],
				'sys_jabatan'			=> $employee['Jabatan'],
				'sys_email'	 			=> $user['Email'],
				'sys_telp'	 			=> $user['Telpon']
			);
			$this->session->set_userdata($session_data);
			$response = [
				"code" => 200,
				"msg" => "Successfully sign-in to " . $this->config->item('app_name') . " !"
			];
			return $this->help->Fn_resulting_response($response);
		} else {
			$users = $this->db->get_where('tbl_account', [
				'UserName' => $login->username,
			]);
			if ($users->num_rows() == 0) {
				$response = [
					"code" => 404,
					"msg" => "User not found !"
				];
				return $this->help->Fn_resulting_response($response);
			}
			if ($users->num_rows() > 0) {
				$response = [
					"code" => 505,
					"msg" => "Password not match !"
				];
				return $this->help->Fn_resulting_response($response);
			} else {
				$response = [
					"code" => 505,
					"msg" => "Username & Password not registered!"
				];
				return $this->help->Fn_resulting_response($response);
			}
		}
	}

	public function Register()
	{
		$this->data['page_title'] = "Register";
		$this->data['jabatans'] = $this->db->get_where($this->mst_jabatan, ['is_active' => 1])->result();
		$this->load->view('Auth/register', $this->data);
	}

	public function Post_Register()
	{
		if ($this->input->post("password") != $this->input->post("confirm-password")) {
			return $this->help->Fn_resulting_response([
				'code' => 505,
				'msg'  => "Please type password correctly !",
			]);
		}

		$ValidateID = $this->db->get_where($this->tbl_account, ['ID' => $this->input->post('ID')]);
		if ($ValidateID->num_rows() > 0) {
			return $this->help->Fn_resulting_response([
				'code' => 505,
				'msg'  => "ID Access Control has been taken by other user !",
			]);
		}

		$ValidateUname = $this->db->get_where($this->tbl_account, ['UserName' => $this->input->post('UserName')]);
		if ($ValidateUname->num_rows() > 0) {
			return $this->help->Fn_resulting_response([
				'code' => 505,
				'msg'  => "Username has been taken by other user !",
			]);
		}

		$this->db->trans_start();
		$this->db->insert($this->tbl_employee, [
			'ID' => $this->input->post('ID'),
			'UserName' => strtoupper($this->input->post('UserName')),
			'Nama' => ucwords(strtolower($this->input->post('Nama'))),
			'Fk_Jabatan' => $this->input->post('Fk_Jabatan'),
			'KTP' => $this->input->post('KTP'),
			'Tanggal_Lahir' => $this->input->post('Tanggal_Lahir'),
			'Tempat_Lahir' => strtoupper($this->input->post('Tempat_Lahir')),
			'Gender' => $this->input->post('Gender'),
			'Telpon' => $this->input->post('Telpon'),
			'Email' => $this->input->post('Email'),
			'Status_Pernikahan' => $this->input->post('Status_Pernikahan'),
			'Tanggal_Join' => $this->input->post('Tanggal_Join'),
			'Full_address' => $this->input->post('Full_address'),
			'Created_at' => date('Y-m-d H:i:s'),
			'Created_by' => 'Form Register',
		]);

		$this->db->insert($this->tbl_account, [
			'ID' => $this->input->post('ID'),
			'Nama' =>  ucwords(strtolower($this->input->post('Nama'))),
			'UserName' => $this->input->post('UserName'),
			'Password' => md5($this->input->post('password')),
			'Role' => 'USER',
			'Telpon' => $this->input->post('Telpon'),
			'Email' => $this->input->post('Email'),
			'Created_at' => date('Y-m-d H:i:s'),
			'Created_by' => 'Form Register',
		]);


		$error_msg = $this->db->error()["message"];
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return $this->help->Fn_resulting_response([
				'code' => 505,
				'msg'  => $error_msg,
			]);
		} else {
			$this->db->trans_commit();
			return $this->help->Fn_resulting_response([
				'code' => 200,
				'msg' => 'Successfully register new account !',
			]);
		}
	}

	public function logout()
	{
		$this->output->delete_cache();
		$array_items = array('impsys_name', 'impsys_nik', 'impsys_initial', 'impsys_jabatan', 'impsys_telp', 'impsys_type_pembayaran');
		$this->session->unset_userdata($array_items);
		session_destroy();
		$this->session->set_flashdata('success', "Silahkan login kembali untuk mengakses" . $this->config->item('app_name'));
		return redirect('Auth');
	}
}
