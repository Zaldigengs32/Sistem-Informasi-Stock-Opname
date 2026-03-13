<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends CI_Controller
{
        public function __construct()
        {
                parent::__construct();
                // Cek session user, misal pakai session 'logged_in'
                $current_controller = $this->router->fetch_class();
                $current_method = $this->router->fetch_method();

                // Jika bukan akses ke Dashboard/index dan belum login
                if (!($current_controller == 'Dashboard' && $current_method == 'index')) {
                    if (!$this->session->userdata('nama')) {
                        redirect('Dashboard');
                        exit;
                    }
                }
                $this->load->model('RuanganModels');
                $this->load->model('BarangModel');
                $this->load->model('PeminjamanModels');
        } 
}