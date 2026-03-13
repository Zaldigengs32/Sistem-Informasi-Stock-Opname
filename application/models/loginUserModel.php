<?php
defined('BASEPATH') or exit('No direct script access allowed');

class loginUserModel extends CI_Model
{

	function cek_login($table, $where)
	{
		return $this->db->get_where($table, $where);
	}

	private $_table = "pengguna";
	private $tablemhs = "mahasiswa";

	public function getByUsername($email)
	{
		return $this->db->get_where($this->_table, ["email" => $email])->row();
	}

	public function getByUsernamePassword()
	{
		$post1 = $this->input->post();
		$username = $post1["email"];
		$password = $post1["password"];
		$array = array('username_pengguna' => $username, 'password_pengguna' => $password);
		$query = $this->db->get_where($this->_table, $array);
		return $query->row();
	}
	public function getByNPK($npk)
	{ 
		$array = array('id_pengguna' => $npk);
		$query = $this->db->get_where($this->_table, $array);
		return $query->row();
	}
	public function getMahasiswaByUsernamePassword()
	{
		$post1 = $this->input->post();
		$username = $post1["username"];
		$password = $post1["password"];
		$array = array('username' => $username);
		$query = $this->db->get_where($this->tablemhs, $array);
		return $query->row();
	}
}
