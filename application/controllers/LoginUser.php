<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginUser extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("loginUserModel");
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('UI\Login');
	}

	//autentikasi
	function aksi_login()
	{
		$post = $this->input->post();
		if (isset($post["email"]) && isset($post["password"])) {
			//cek user
			$user = $this->loginUserModel;
			$data = $user->getByUsernamePassword();

			if ($data != null) {
				$id = $data->id;
				$password = $data->password;
				$nama = $data->nama;
				$nohp = $data->nohp;
				$email = $data->email;
				$username = $data->username;
				$role = $data->role;
				$status = $data->status;
				$foto = $data->foto;

				//adding data to session
				$newdata = array(
					'id' => $id,
					'password' => $password,
					'nama' => $nama,
					'nohp' => $nohp,
					'email' => $email,
					'username' => $username,
					'role' => $role,
					'foto' => $foto,
					'status' => $status
				);
				$this->session->set_userdata($newdata);
				if ($role == '1' &&  $status == '1' || $role == '2') {
					redirect('Functions/Dashboard');
				} else if ($role == "3") {
					redirect('Functions/DashboardMahasiswa');
				}
			} else {
				redirect('LoginUser/notfound');
			}
		} else {
			$this->load->view("UI/Login");
		}
	}
	function notfound()
	{
		$getData["notfound"] = true;
		$this->load->view('UI\Login', $getData);
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('LoginUser'));
	}
}
