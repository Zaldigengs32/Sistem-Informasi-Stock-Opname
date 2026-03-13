<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginUser extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Cek session user, misal pakai session 'logged_in'
        
		$this->load->model("loginUserModel");
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('UI\Login');
	}
	public function loginAdmin()
	{
		$this->load->view('UI\Login_Admin');
	}
	public function loginMhs()
	{
		$post = $this->input->post();
		if (isset($post["username"]) && isset($post["password"])) {
			//cek user
			$user = $this->loginUserModel;
			$data = $user->getMahasiswaByUsernamePassword();

			if ($data != null) {
				$username = $data->username;
				$nama = $data->nama;
				

				//adding data to session
				$newdata = array(
					'nama' => $nama,
					'username' => $username
				);
				$this->session->set_userdata($newdata);
				// Set cookie (nama, nilai, waktu dalam detik)
		        $cookie = array(
		            'name'   => 'nim',
		            'value'  => $username,
		            'expire' => 3600, // 1 jam
		            'secure' => FALSE // TRUE jika HTTPS
		        );
		        $this->input->set_cookie($cookie);
		        $cookie = array(
		            'name'   => 'nama',
		            'value'  => $nama,
		            'expire' => 3600, // 1 jam
		            'secure' => FALSE // TRUE jika HTTPS
		        );
		        $this->input->set_cookie($cookie);

		        // Redirect ke controller lain
		        redirect('Dashboard');
				
			} else {
				redirect('LoginUser/notfound');
			}
		} else {
			$this->load->view("UI/Mahasiswa/index");
		}
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
				$id = $data->id_pengguna;
				$password = $data->password_pengguna;
				$nama = $data->nama_pengguna;
				// $nohp = $data->nohp;
				$email = $data->email_pengguna;
				$username = $data->username_pengguna;
				$role = $data->role_pengguna;
				$status = $data->status_pengguna;
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
				switch ($role) {
					case 'Super Admin':
						redirect('Functions/DashboardSuperAdmin');
						break;
					case 'PIC LAB':
						redirect('Functions/DashboardPICLab');
						break;
					case 'PIC Non Asset':
						redirect('Functions/DashboardPICNonAsset');
						break;
					case 'PIC Asset & Non Asset':
						redirect('Functions/DashboardPICAsset');
						break;
					case 'Koordinator UPT':
						redirect('Functions/DashboardKoorUPT');
						break;
					default:
						redirect('Functions/Dashboard');
						break;
				}
				if ($role == "3") {
					redirect('Functions/DashboardMahasiswa');
				}else{
					redirect('LoginUser/notfound');
				}
			} else {
				redirect('LoginUser/notfound');
			}
		} else {
			$this->load->view("UI/Mahasiswa/index");
		}
	}
	function loginUserAdmin()
	{
		$npk = $_COOKIE['npk'];
		$user = $this->loginUserModel;
		$data = $user->getByNPK($npk);
		$id = $data->id_pengguna;
		$password = $data->password_pengguna;
		$nama = $data->nama_pengguna;
		// $nohp = $data->nohp;
		$email = $data->email_pengguna;
		$username = $data->username_pengguna;
		$role = $data->role_pengguna;
		$status = $data->status_pengguna;
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
		switch ($role) {
			case 'Super Admin':
				redirect('Functions/DashboardSuperAdmin');
				break;
			case 'PIC LAB':
				redirect('Functions/DashboardPICLab');
				break;
			case 'PIC Non Asset':
				redirect('Functions/DashboardPICNonAsset');
				break;
			case 'PIC Asset & Non Asset':
				redirect('Functions/DashboardPICAsset');
				break;
			case 'Koordinator UPT':
				redirect('Functions/DashboardKoorUPT');
				break;
			default:
				redirect('Functions/Dashboard');
				break;
		}
	}
	public function loginMhsAPI()
	{
		$nim = $_COOKIE['nim'];
		$nama = $_COOKIE['nama'];
		if (isset($_COOKIE['nim'])) {
			//adding data to session
			$newdata = array(
				'nama' => $nama,
				'username' => $nim
			);
			$this->session->set_userdata($newdata);
			// Set cookie (nama, nilai, waktu dalam detik)
	        $cookie = array(
	            'name'   => 'nim',
	            'value'  => $nim,
	            'expire' => 3600, // 1 jam
	            'secure' => FALSE // TRUE jika HTTPS
	        );
	        $this->input->set_cookie($cookie);
	        $cookie = array(
	            'name'   => 'nama',
	            'value'  => $nama,
	            'expire' => 3600, // 1 jam
	            'secure' => FALSE // TRUE jika HTTPS
	        );
	        $this->input->set_cookie($cookie);

	        // Redirect ke controller lain
	        redirect('Dashboard');
		} else {
			$this->load->view("UI/Mahasiswa/index");
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
