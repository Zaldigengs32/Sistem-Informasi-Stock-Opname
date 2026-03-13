<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
        public function __construct()
        {
                parent::__construct();
                $this->load->model('RuanganModels');
                $this->load->model('PeminjamanModel');
                $this->load->model('StrukturModels');
                $this->load->model('BarangModel');
                $this->load->model('PeminjamanModel');
                
        }

        // Dashboard
        public function index()
        {
                // Get messages from the session 
                if ($this->session->userdata('tambah')) {
                        $Data['tambah'] = $this->session->userdata('tambah');
                        $this->session->unset_userdata('tambah');
                }   
                $this->load->model('BarangModel');
                $Data['jumlahKeranjang'] = $this->BarangModel->getKeranjangbyAmount();

                $this->load->view('UI/Mahasiswa/index',$Data);
        }
        public function loginUser()
        {
                $username = $this->input->post('txtUsername');
                $password = $this->input->post('txtPassword');
                $data['user'] = $username;
                $this->load->view('UI/Mahasiswa/index', $data);
        }

        // Struktur Organisasi
        public function strukturOrganisasi()
        {
             $queryAllRuangan = $this->StrukturModels->getDataMember();
             $Data['jumlahKeranjang'] = $this->BarangModel->getKeranjangbyAmount();
             $Data['member'] = $queryAllRuangan;
             $this->load->view('UI/Mahasiswa/struktur_organisasi', $Data);
        }
        // Riwayat Peminjaman
        public function RiwayatPeminjamanBarang()
        {
            if (!$_COOKIE['nim']) {
                redirect('Dashboard');
                exit;
            }  
            // Cek session user, misal pakai session 'logged_in'
            // Cek session user, kecuali jika akses ke controller Dashboard dan fungsi index
            $current_controller = $this->router->fetch_class();
            $current_method = $this->router->fetch_method();

            // Jika bukan akses ke Dashboard/index dan belum login
            if (!($current_controller == 'Dashboard' && $current_method == 'index')) {
                if (!$this->session->userdata('nama')) {
                    redirect('Dashboard');
                    exit;
                }
            }
            if ($this->session->userdata('tambah')) {
                $Data['tambah'] = $this->session->userdata('tambah');
                $this->session->unset_userdata('tambah');
            }
            if ($this->session->userdata('error')) {
                $Data['error'] = $this->session->userdata('error');
                $this->session->unset_userdata('error');
            }    

            // Cek dan update status_barang dan status_peminjaman
            $this->load->model('PeminjamanModel');
            $this->load->model('BarangModel');

            $borrowedItems = $this->PeminjamanModel->get_borrowed_items_due_tomorrow(); // H+1

            foreach ($borrowedItems as $item) {
                // Update status_barang menjadi 'Waiting for Return'
                $this->PeminjamanModel->update_status_barang($item->id_dtl_peminjaman, 'Waiting for Return');

                // Cek apakah semua barang dalam peminjaman ini sudah 'Waiting for Return'
                $allStatus = $this->PeminjamanModel->get_all_status_barang($item->id_peminjaman_barang);
                $allWaiting = !in_array('Borrowed', $allStatus);

                if ($allWaiting) {
                    $this->PeminjamanModel->update_status_peminjaman($item->id_peminjaman_barang, 'Waiting for Return');
                }
            }

            // Filter berdasarkan status jika ada
            $status = $this->input->get('status');
            switch ($status) {
                case 'Pengajuan':
                    $status = 'On Progress Approval';
                    break;
                case 'Disetujui':
                    $status = 'Approved';
                    break;
                case 'Ditolak':
                    $status = 'Reject';
                    break;
                case 'Dipinjam':
                    $status = 'Borrowed';
                    break;
                case 'MenungguPengembalian':
                    $status = 'Waiting For Return';
                    break;
                case 'Selesai':
                    $status = 'Completed';
                    break;
            }

            if ($status) {
                $Data['RiwayatPeminjaman'] = $this->PeminjamanModel->get_data_riwayat_peminjaman_by_status($status);
            } else {
                $Data['RiwayatPeminjaman'] = $this->PeminjamanModel->get_data_riwayat_peminjaman();
            }

            $queryAllRuangan = $this->StrukturModels->getDataMember();
            $Data['jumlahKeranjang'] = $this->BarangModel->getKeranjangbyAmount();
            $Data['member'] = $queryAllRuangan;

            $this->load->view('UI/Mahasiswa/RiwayatPeminjaman', $Data);
        }
        public function kembalikan_barang() {
            if (!$_COOKIE['nim']) {
                redirect('Dashboard');
                exit;
            }
            echo "X";
            // Cek session user, misal pakai session 'logged_in'
            // Cek session user, kecuali jika akses ke controller Dashboard dan fungsi index
            $current_controller = $this->router->fetch_class();
            $current_method = $this->router->fetch_method();

            // Jika bukan akses ke Dashboard/index dan belum login
            if (!($current_controller == 'Dashboard' && $current_method == 'index')) {
                if (!$this->session->userdata('nama')) {
                    redirect('Dashboard');
                    exit;
                }
            }
            $this->load->model('PeminjamanModel'); // Pastikan model dimuat

            $id = $this->input->post('id_dtl_peminjaman');
            $config['upload_path']   = './assets/foto/Peminjaman/After/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = 'setelah' . $id . '_' . time();

            $this->load->library('upload');
            $this->upload->initialize($config); // <-- penting!

            if ($this->upload->do_upload('foto_setelah')) {
                $data_upload = $this->upload->data();
                $gambar_setelah = $data_upload['file_name'];
                echo "Y";
                $this->PeminjamanModel->update_pengembalian_barang($id, $gambar_setelah);

                $this->session->set_userdata('tambah', 'tambah');
            } else {
                $this->session->set_userdata('error', $this->upload->display_errors());
                echo $this->upload->display_errors();
            }

            redirect('Dashboard');
        }


        public function upload_gambar_sebelum() {
            if (!$_COOKIE['nim']) {
                redirect('Dashboard');
                exit;
            }
            // Cek session user, misal pakai session 'logged_in'
            // Cek session user, kecuali jika akses ke controller Dashboard dan fungsi index
            $current_controller = $this->router->fetch_class();
            $current_method = $this->router->fetch_method();

            // Jika bukan akses ke Dashboard/index dan belum login
            if (!($current_controller == 'Dashboard' && $current_method == 'index')) {
                if (!$this->session->userdata('nama')) {
                    redirect('Dashboard');
                    exit;
                }
            }
            $id_dtl_peminjaman = $this->input->post('id_dtl_peminjaman');

            $config['upload_path']   = './assets/foto/Peminjaman/Before/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = 'sebelum_' . $id_dtl_peminjaman . '_' . time();

            $this->load->library('upload');
            $this->upload->initialize($config); // <-- penting!

            if (!$this->upload->do_upload('foto')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                echo 'Upload Path: ' . $config['upload_path'] . '<br>';
                echo 'Current Dir: ' . getcwd();
            } else {
                $upload_data = $this->upload->data();
                $foto_path = $upload_data['file_name'];

                $this->PeminjamanModel->update_gambar_sebelum($id_dtl_peminjaman, $foto_path);
                $this->session->set_userdata('tambah', 'tambah');
            }

            redirect('Dashboard/RiwayatPeminjamanBarang');
        }


        //Asset dan Non Asset
        public function peminjamanBarang()
        {
            $this->load->library('pagination');
            $per_page = 15;

            $tab = $this->input->get('tab') ?? 'all';
            $page_all = $this->input->get('page_all') ?? 0;
            $page_asset = $this->input->get('page_asset') ?? 0;
            $page_non_asset = $this->input->get('page_non_asset') ?? 0;

            // ALL
            // Tangkap input filter dari tab "all"
            $search = $this->input->get('search_all');
            $kategori = $this->input->get('kategori_all');
            $tipe = $this->input->get('tipe_all');

            // ASSET FILTER
            $search_asset = $this->input->get('search_asset');
            $tipe_asset = $this->input->get('tipe_asset');

            // NON ASSET FILTER
            $search_non_asset = $this->input->get('search_non_asset');
            $tipe_non_asset = $this->input->get('tipe_non_asset');


            // Ambil data hasil filter
            // $data['barang_all'] = $this->Barang_model->get_filtered_barang($search, $kategori, $tipe);

            $config_all = [
                'base_url' => base_url("Dashboard/peminjamanBarang?tab=all"),
                'total_rows' => $this->BarangModel->count_all_barang($search, $kategori, $tipe),
                'per_page' => $per_page,
                'page_query_string' => TRUE,
                'query_string_segment' => 'page_all',
            ] + $this->paginationStyle();
            $this->pagination->initialize($config_all);
            $pagination_all = $this->pagination->create_links();
            $barang_all = $this->BarangModel->get_barang_paginated($search, $kategori, $tipe, $per_page, $page_all);

            // ASSET
            $config_asset = [
                'base_url' => base_url("Dashboard/peminjamanBarang?tab=asset&search_asset={$search_asset}&tipe_asset={$tipe_asset}"),
                'total_rows' => $this->BarangModel->count_filtered_barang('Asset', $search_asset, $tipe_asset),
                'per_page' => $per_page,
                'page_query_string' => TRUE,
                'query_string_segment' => 'page_asset',
            ] + $this->paginationStyle();
            $this->pagination->initialize($config_asset);
            $pagination_asset = $this->pagination->create_links();
            $barang_asset = $this->BarangModel->get_filtered_barang_paginated('Asset', $search_asset, $tipe_asset, $per_page, $page_asset);

            // NON-ASSET
            $config_non_asset = [
                'base_url' => base_url("Dashboard/peminjamanBarang?tab=non_asset&search_asset={$search_non_asset}&tipe_asset={$tipe_asset}"),
                'total_rows' => $this->BarangModel->count_filtered_barang('Non Asset', $search_non_asset, $tipe_non_asset),
                'per_page' => $per_page,
                'page_query_string' => TRUE,
                'query_string_segment' => 'page_non_asset',
            ] + $this->paginationStyle();
            $this->pagination->initialize($config_non_asset);
            $pagination_non_asset = $this->pagination->create_links();
            $barang_non_asset = $this->BarangModel->get_filtered_barang_paginated('Non Asset', $search_non_asset, $tipe_non_asset, $per_page, $page_non_asset);

            $data = [
                'active_tab' => $tab,
                'barang_all' => $barang_all,
                'barang_asset' => $barang_asset,
                'barang_non_asset' => $barang_non_asset,
                'pagination_all' => $pagination_all,
                'pagination_asset' => $pagination_asset,
                'pagination_non_asset' => $pagination_non_asset,
                'jumlahKeranjang' => $this->BarangModel->getKeranjangbyAmount(),
            ];

            $this->load->view('UI/Mahasiswa/peminjaman_barang', $data);
        }



        private function paginationStyle() {
            return [
                'full_tag_open' => '<nav aria-label="..."><ul class="pagination">',
                'full_tag_close' => '</ul></nav>',
                'attributes' => ['class' => 'page-link'],
                'first_tag_open' => '<li class="page-item">',
                'first_tag_close' => '</li>',
                'last_tag_open' => '<li class="page-item">',
                'last_tag_close' => '</li>',
                'next_tag_open' => '<li class="page-item">',
                'next_tag_close' => '</li>',
                'prev_tag_open' => '<li class="page-item">',
                'prev_tag_close' => '</li>',
                'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
                'cur_tag_close' => '</a></li>',
                'num_tag_open' => '<li class="page-item">',
                'num_tag_close' => '</li>',
            ];
        }

        public function keranjang()
        {
                if(isset($_COOKIE['nim'])){
                        $nim = $_COOKIE['nim'];
                        $this->load->model('PeminjamanModel');
                        $getDataKeranjang = $this->PeminjamanModel->get_detailed_cart($nim);
                        $Data['jumlahKeranjang'] = $this->BarangModel->getKeranjangbyAmount();
                        $Data['keranjang'] = $getDataKeranjang;
                        $this->load->view('UI/Mahasiswa/Keranjang', $Data);
                }
                
        }
        public function checkout()
        {
            if (!$_COOKIE['nim']) {
                redirect('Dashboard');
                exit;
            }
            // Cek session user, misal pakai session 'logged_in'
            // Cek session user, kecuali jika akses ke controller Dashboard dan fungsi index
            $current_controller = $this->router->fetch_class();
            $current_method = $this->router->fetch_method();

            // Jika bukan akses ke Dashboard/index dan belum login
            if (!($current_controller == 'Dashboard' && $current_method == 'index')) {
                if (!$this->session->userdata('nama')) {
                    redirect('Dashboard');
                    exit;
                }
            }
            $selectedItems = $this->input->post('cart_item'); // Ambil data id_keranjang yg dicentang

            if (!$selectedItems) {
                $this->session->set_flashdata('error', 'Tidak ada barang yang dipilih.');
                redirect('Dashboard/keranjang');
            }

            // Ambil data NIM dari cookie
            $nim = isset($_COOKIE['nim']) ? $_COOKIE['nim'] : null;

            // Load model
            $this->load->model('PeminjamanModel');
            $this->load->model('BarangModel');
            // Ambil data hanya untuk item yang dicentang
            $dataKeranjangTerpilih = $this->PeminjamanModel->get_selected_cart_items($selectedItems);
            if ($this->session->userdata('tambah')) {
              $Data['tambah'] = $this->session->userdata('tambah');
              $this->session->unset_userdata('tambah');
            }
            if ($this->session->userdata('error')) {
              $Data['error'] = $this->session->userdata('error');
              $this->session->unset_userdata('error');
            }
            if(isset($_COOKIE['nim'])){
                    $nim = $_COOKIE['nim'];
                    // $this->load->model('PeminjamanModel');
                    $getDataKeranjang = $this->PeminjamanModel->get_detailed_cart($nim);
                    $Data['jumlahKeranjang'] = $this->BarangModel->getKeranjangbyAmount();
                    $Data['keranjang'] = $dataKeranjangTerpilih;
                   $this->load->view('UI/Mahasiswa/form_peminjaman_barang', $Data);
             }
                
        }
        // Keluar
        public function logout()
        {
                unset($_COOKIE['nim']);
                unset($_COOKIE['nama']);
                echo "<script>
                        document.cookie = 'nim=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                        document.cookie = 'nama=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                </script>";
                $Data['keluar'] = 1;
                $this->load->view('UI/Mahasiswa/index', $Data);
        }
}