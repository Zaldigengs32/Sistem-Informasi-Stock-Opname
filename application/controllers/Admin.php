<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $this->load->model('AssetModels');
    }

    public function index()
    {
        $this->load->view('UI/Admin/Header');
        $this->load->view('UI/Admin/Dashboard');
        $this->load->view('UI/Admin/Footer');
    }

    public function ruangan()
    {
        $queryAllRuangan = $this->RuanganModels->getDataRuangan();
        $DATA = array('queryAllRuangan' => $queryAllRuangan);
        $this->load->view('UI/Admin/Header');
        $this->load->view('UI/Admin/Ruangan', $DATA);
        $this->load->view('UI/Admin/Footer');
    }

    public function asset()
    {
        $queryAllAsset = $this->AssetModels->getDataAsset();
        $DATA = array('queryAllAsset' => $queryAllAsset);
        $this->load->view('UI/Admin/Header');
        $this->load->view('UI/Admin/Asset', $DATA);
        $this->load->view('UI/Admin/Footer');
    }
}
