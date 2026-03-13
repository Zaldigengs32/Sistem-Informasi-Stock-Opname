<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Functions extends CI_Controller
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
    $this->load->model("models");
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('upload');
    // Autentikasi
    if (!$this->session->userdata('role'))
      redirect('LoginUser', 'refresh');

    // Auto-approval check - jalankan sekali per hari
    $this->runAutoApprovalCheck();
  }

  /**
   * Run auto-approval check once per day
   * Checks and auto-approves pending items > 3 days
   */
  private function runAutoApprovalCheck()
  {
    // Cek apakah sudah dijalankan hari ini
    $last_run = $this->session->userdata('last_auto_approval_check');
    $today = date('Y-m-d');
    
    if ($last_run === $today) {
      return; // Sudah dijalankan hari ini
    }

    // Set flag bahwa sudah dijalankan hari ini
    $this->session->set_userdata('last_auto_approval_check', $today);

    // Load models yang diperlukan
    $this->load->model('StockOpnameModel');
    $this->load->model('MutasiModel');
    $this->load->model('DupatModel');

    $days_threshold = 3;

    // Auto-approve Stock Opname
    $pending_so = $this->StockOpnameModel->getPendingApprovalOverDays($days_threshold);
    foreach ($pending_so as $item) {
      $this->StockOpnameModel->autoApproveStockOpname($item->so_id_opname);
    }

    // Auto-approve Mutasi
    $pending_mutasi = $this->MutasiModel->getPendingApprovalOverDays($days_threshold);
    foreach ($pending_mutasi as $mutasi) {
      $items = $this->MutasiModel->getDtlMutasiByIdMutasi($mutasi->id_mutasi);
      $lokasi_tujuan = $mutasi->lokasi_tujuan;
      $id_ruangan_tujuan = $this->MutasiModel->getRuanganIdByName($lokasi_tujuan);
      
      if ($id_ruangan_tujuan) {
        foreach ($items as $item) {
          $id_dtl_penyimpanan_tujuan = $this->MutasiModel->getDefaultPenyimpananByRuangan($id_ruangan_tujuan);
          if ($id_dtl_penyimpanan_tujuan) {
            $this->MutasiModel->updateBarangLocation($item->id_barang, $id_dtl_penyimpanan_tujuan);
          }
        }
      } else {
        foreach ($items as $item) {
          $this->MutasiModel->updateBarangStatusMutasiExternal($item->id_barang, $lokasi_tujuan);
        }
      }
      $this->MutasiModel->autoApproveMutasi($mutasi->id_mutasi);
    }

    // Auto-approve Dupat
    $pending_dupat = $this->DupatModel->getPendingApprovalOverDays($days_threshold);
    foreach ($pending_dupat as $dupat) {
      $items = $this->DupatModel->getDtlDupatByIdDupat($dupat->id_dupat);
      foreach ($items as $item) {
        $this->db->where('id_barang', $item->id_barang);
        $this->db->update('barang', [
          'status_barang' => 'Tidak Aktif',
          'modified_by' => 'SYSTEM_AUTO_APPROVE',
          'modified_date' => date('Y-m-d')
        ]);
      }
      $this->DupatModel->autoApproveDupat($dupat->id_dupat);
    }

    // Auto-approve Peminjaman
    $pending_peminjaman = $this->models->getPendingApprovalPeminjamanOverDays($days_threshold);
    foreach ($pending_peminjaman as $item) {
      $this->models->autoApprovePeminjamanItem($item->id_dtl_peminjaman, $item->status_barang);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////LOGIN

  public function Login()
  {
    $this->load->view('UI/Login');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////DASHBOARDMAHASISWA

  public function DashboardMahasiswa()
  {
    $this->load->view('UI/Mahasiswa/Dashboard');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////PEMINJAMANRUANGAN

  public function PeminjamanRuangan()
  {
    $this->load->view('UI/Mahasiswa/Form');
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////PEMINJAMANRUANGAN

  // public function DetailRuangan()
  // {
  //   $this->load->view('UI/Mahasiswa/Detail');
  // }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////DASHBOARD

  public function DashboardKoorUPT()
  {
    $data["activePage"] = "Dashboard";
    $this->load->model('DashboardModel');
    $data['total_asset_borrowed'] = $this->DashboardModel->get_total_asset_borrowed();
    $data['total_asset_borrowed_last_30day'] = $this->DashboardModel->get_asset_borrowed_last_30_days();
    $data['total_non_asset_borrowed'] = $this->DashboardModel->get_total_non_asset_borrowed();
    $data['total_non_asset_borrowed_last_30day'] = $this->DashboardModel->get_non_asset_borrowed_last_30_days();
    $data['approval_pic_asset'] = $this->DashboardModel->get_total_approval_pic_asset();
    $data['approval_pic_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_asset_30hari();
    $data['approval_pic_non_asset'] = $this->DashboardModel->get_total_approval_pic_non_asset();
    $data['approval_pic_non_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_non_asset_30hari();
    $data['approval_koor_upt'] = $this->DashboardModel->get_total_approval_koor_upt();
    $data['approval_koor_upt_30hari'] = $this->DashboardModel->get_total_approval_koor_upt_30hari();
    $data['get_status_stok_menipis'] = $this->DashboardModel->get_status_stok_menipis();
    $data['get_asset_sering_dipinjam'] = $this->DashboardModel->get_asset_sering_dipinjam();
    $data['get_non_asset_sering_dipinjam'] = $this->DashboardModel->get_non_asset_sering_dipinjam();
    // Mutation data
    $data['mutation_pending_approval'] = $this->DashboardModel->get_total_mutation_pending_approval();
    $data['mutation_approved'] = $this->DashboardModel->get_total_mutation_approved();
    $data['mutation_last_30_days'] = $this->DashboardModel->get_total_mutation_last_30_days();
    $this->load->view('UI/KoordinatorUPT/Dashboard', $data);
  }

  public function DashboardPICLab()
  {
    $npk = $this->session->userdata('id');
    $data["activePage"] = "Dashboard";
    $this->load->model('DashboardModel');
    $data['total_asset_borrowed'] = $this->DashboardModel->get_total_asset_borrowed_pic_lab($npk);
    $data['total_asset_borrowed_last_30day'] = $this->DashboardModel->get_asset_borrowed_last_30_days_pic_lab($npk);
    $data['total_non_asset_borrowed'] = $this->DashboardModel->get_total_non_asset_borrowed_pic_lab($npk);
    $data['total_non_asset_borrowed_last_30day'] = $this->DashboardModel->get_non_asset_borrowed_last_30_days_pic_lab($npk);
    $data['approval_pic_asset'] = $this->DashboardModel->get_total_approval_pic_asset();
    $data['approval_pic_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_asset_30hari();
    $data['approval_pic_non_asset'] = $this->DashboardModel->get_total_approval_pic_non_asset();
    $data['approval_pic_non_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_non_asset_30hari();
    $data['approval_koor_upt'] = $this->DashboardModel->get_total_approval_koor_upt();
    $data['approval_koor_upt_30hari'] = $this->DashboardModel->get_total_approval_koor_upt_30hari();
    $data['get_status_stok_menipis'] = $this->DashboardModel->get_status_stok_menipis_pic_lab($npk);
    $data['get_asset_sering_dipinjam'] = $this->DashboardModel->get_asset_sering_dipinjam_pic_lab($npk);
    $data['get_non_asset_sering_dipinjam'] = $this->DashboardModel->get_non_asset_sering_dipinjam_pic_lab($npk);
    $this->load->view('UI/PICLab/Dashboard', $data);
  }

  public function DashboardPICAsset()
  {
    $data["activePage"] = "Dashboard";
    $this->load->model('DashboardModel');
    $data['total_asset_borrowed'] = $this->DashboardModel->get_total_asset_borrowed();
    $data['total_asset_borrowed_last_30day'] = $this->DashboardModel->get_asset_borrowed_last_30_days();
    $data['total_non_asset_borrowed'] = $this->DashboardModel->get_total_non_asset_borrowed();
    $data['total_non_asset_borrowed_last_30day'] = $this->DashboardModel->get_non_asset_borrowed_last_30_days();
    $data['approval_pic_asset'] = $this->DashboardModel->get_total_approval_pic_asset();
    $data['approval_pic_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_asset_30hari();
    $data['approval_pic_non_asset'] = $this->DashboardModel->get_total_approval_pic_non_asset();
    $data['approval_pic_non_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_non_asset_30hari();
    $data['approval_koor_upt'] = $this->DashboardModel->get_total_approval_koor_upt();
    $data['approval_koor_upt_30hari'] = $this->DashboardModel->get_total_approval_koor_upt_30hari();
    $data['get_status_stok_menipis'] = $this->DashboardModel->get_status_stok_menipis();
    $data['get_asset_sering_dipinjam'] = $this->DashboardModel->get_asset_sering_dipinjam();
    $data['get_non_asset_sering_dipinjam'] = $this->DashboardModel->get_non_asset_sering_dipinjam();
    // Mutation data
    $data['mutation_draft'] = $this->DashboardModel->get_total_mutation_draft();
    $data['mutation_approved'] = $this->DashboardModel->get_total_mutation_approved();
    $data['mutation_last_30_days'] = $this->DashboardModel->get_total_mutation_last_30_days();
    $this->load->view('UI/PICAsset/Dashboard', $data);
  }

  public function DashboardPICNonAsset()
  {
    $data["activePage"] = "Dashboard";
    $this->load->model('DashboardModel');
    $data['total_asset_borrowed'] = $this->DashboardModel->get_total_asset_borrowed();
    $data['total_asset_borrowed_last_30day'] = $this->DashboardModel->get_asset_borrowed_last_30_days();
    $data['total_non_asset_borrowed'] = $this->DashboardModel->get_total_non_asset_borrowed();
    $data['total_non_asset_borrowed_last_30day'] = $this->DashboardModel->get_non_asset_borrowed_last_30_days();
    $data['approval_pic_asset'] = $this->DashboardModel->get_total_approval_pic_asset();
    $data['approval_pic_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_asset_30hari();
    $data['approval_pic_non_asset'] = $this->DashboardModel->get_total_approval_pic_non_asset();
    $data['approval_pic_non_asset_30hari'] = $this->DashboardModel->get_total_approval_pic_non_asset_30hari();
    $data['approval_koor_upt'] = $this->DashboardModel->get_total_approval_koor_upt();
    $data['approval_koor_upt_30hari'] = $this->DashboardModel->get_total_approval_koor_upt_30hari();
    $data['get_status_stok_menipis'] = $this->DashboardModel->get_status_stok_menipis();
    $data['get_asset_sering_dipinjam'] = $this->DashboardModel->get_asset_sering_dipinjam();
    $data['get_non_asset_sering_dipinjam'] = $this->DashboardModel->get_non_asset_sering_dipinjam();
    $this->load->view('UI/PICNonAsset/Dashboard', $data);
  }

  
  public function filterBarang($filter)
  {
    $record = $this->models->FilterChartBarang($filter);
    $data = [];
    foreach ($record as $row) {
      $data['bulan'][] = $row->bulan;
      $data['barang'][] = $row->nama_barang;
      $data['jumlah'][] = (int) $row->Jumlah;
    }
    ;
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////ADMIN

  public function Admin()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getData['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getData['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getData['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('duplicate')) {
      $getData['duplicate'] = $this->session->userdata('duplicate');
      $this->session->unset_userdata('duplicate');
    }
    if ($this->session->userdata('role') != 'Super Admin') {
      redirect('LoginUser/logout', 'refresh');
    }
    $getData["getData"] = $this->models->getadmin();
    $getData["activePage"] = "Admin";
    $this->load->view('UI/Admin', $getData);
  }

  public function saveadmin()
  {
    $findAdmin = $this->models->findAdmin($this->input->post('usernameAdmin'));
    if ($findAdmin) {
      //validasi username tidak boleh sama
      $this->session->set_userdata('duplicate', 'duplicate');
    } else {
      $config['upload_path'] = FCPATH . 'assets\foto\admin';
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      $foto = $_FILES['foto']['name'];
      $file_ext = pathinfo($foto, PATHINFO_EXTENSION);
      $add_filename = preg_replace('/\s+/', '_', $this->input->post('namaAdmin')) . '_Foto.' . $file_ext;
      $config['file_name'] = $add_filename;

      $this->upload->initialize($config);

      if ($this->upload->do_upload('foto')) {
        $foto = $add_filename;
      } else {
        $error = array('error' => $this->upload->display_errors());
        print_r($error);
        echo $config['upload_path'];
      }

      $data = array(
        'username' => $this->input->post('usernameAdmin'),
        'password' => $this->input->post('passwordAdmin'),
        'nama' => $this->input->post('namaAdmin'),
        'nohp' => $this->input->post('noTelpAdmin'),
        'email' => $this->input->post('emailAdmin'),
        'role' => $this->input->post('roleAdmin'),
        'foto' => $foto,
        'status' => '1',
      );
      $insert = $this->models->saveadmin($data);
      $this->session->set_userdata('tambah', 'tambah');
    }
    redirect(base_url('./Functions/Admin'));
  }

  public function editadmin()
  {
    $this->models->editadmin();
    $this->session->set_userdata('ubah', 'ubah');
    redirect(base_url('./Functions/Admin'));
  }

  public function hapusAdmin()
  {
    $id = $this->input->post('id_admin');
    $this->models->hapusadmin($id);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/Admin'));
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////BARANG

  public function Barang()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $data['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/Barang', $data);
  }
  public function BarangPICLab()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $data['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/PICLab/Barang', $data);
  }
  public function BarangPICAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $data['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/PICAsset/Barang', $data);
  }
  public function BarangPICNonAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $data['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/PICNonAsset/Barang', $data);
  }
  public function BarangKoorUPT()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $data['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/KoordinatorUPT/Barang', $data);
  }

  public function getBarangByFilter()
  {
    $nama_ruangan = $this->input->post('nama_ruangan');
    $nama_penyimpanan = $this->input->post('nama_penyimpanan');
    $nama_kategori = $this->input->post('nama_kategori');
    $nama_tipe = $this->input->post('nama_tipe');
    $kondisi_barang = $this->input->post('kondisi_barang');
    $status_barang = $this->input->post('status_barang');
    $data['barang'] = $this->models->getDataBarangFilter($nama_ruangan, $nama_penyimpanan, $nama_kategori, $nama_tipe, $kondisi_barang, $status_barang);
    $data["activePage"] = "Barang";
    $this->load->view('UI/barang_table_rows', $data); // hanya baris <tr>
  }

  public function getBarangByFilterPICLAB()
  {
    $nama_ruangan = $this->input->post('nama_ruangan');
    $nama_penyimpanan = $this->input->post('nama_penyimpanan');
    $nama_kategori = $this->input->post('nama_kategori');
    $nama_tipe = $this->input->post('nama_tipe');
    $kondisi_barang = $this->input->post('kondisi_barang');
    $status_barang = $this->input->post('status_barang');
    $data['barang'] = $this->models->getDataBarangFilter($nama_ruangan, $nama_penyimpanan, $nama_kategori, $nama_tipe, $kondisi_barang, $status_barang);
    $data["activePage"] = "Barang";
    $this->load->view('UI/barang_table_rows_pic_lab', $data); // hanya baris <tr>
  }

  public function savebarangPICAsset()
  {
    $config['upload_path'] = FCPATH . 'assets/foto/Barang/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    
    // Ambil nomor aktiva dan bersihkan spasi
    $nomorAktiva = str_replace(' ', '_', $this->input->post('nomorAktiva'));

    // Ambil ekstensi file asli
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // Buat nama file berdasarkan nomor aktiva
    $cleanFileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $nomorAktiva); // buang karakter aneh
    $finalFileName = $cleanFileName . '.' . $ext;
    $config['file_name'] = $finalFileName;
    // $foto = $_FILES['foto']['name'];
    // $add_filename = $_FILES['foto']['name'];
    // $config['file_name'] = $add_filename;

    $this->upload->initialize($config);
    $format = "%Y-%m-%d";

    if ($this->upload->do_upload('foto')) {
      $foto = $add_filename;
    } else {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
      echo $config['upload_path'];
    }
    $user = $this->session->userdata('id');
    // Get Detail Ruangan Penyimpanan
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('lokasiBarang'), $this->input->post('penyimpananBarang'));

    $data = array(
      'nama_barang' => $this->input->post('namaBarang'),
      'nomor_aktiva' => $this->input->post('nomorAktiva'),
      'jumlah_barang' => $this->input->post('totalBarang'),
      'jumlah_optimum' => $this->input->post('totalBarangOptimum'),
      'jumlah_minimum' => $this->input->post('totalBarangMinimum'),
      'satuan_barang' => $this->input->post('satuanBarang'),
      'kondisi_barang' => $this->input->post('kondisiBarang'),
      'kategori_barang' => $this->input->post('kategoriBarang'),
      'tipe_barang' => $this->input->post('tipeBarang'),
      'id_dtl_penyimpanan' => $dtl_ruangan_penyimpanan,
      'keterangan_penyimpanan' => $this->input->post('barisLokasi'),
      'gambar_barang' => $finalFileName,
      'status_barang' => 'Aktif',
      'ketersediaan_barang' => 'Available',
      'created_by' => $user,
      'created_date' => mdate($format)
    );
    $insert = $this->models->savebarang($data);
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/BarangPICAsset'));
  }

  public function editbarangPICAsset()
  {
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('lokasiBarangE'), $this->input->post('penyimpananBarangE'));
    $this->models->editbarang($dtl_ruangan_penyimpanan);
    $this->session->set_userdata('ubah', 'ubah');
    redirect(base_url('./Functions/BarangPICAsset'));
  }

  public function deletebarangPICAsset()
  {
    $idBarang = $this->input->post('id_barang');
    $this->models->deletebarang($idBarang);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/BarangPICAsset'));
  }

  public function savebarangPICNonAsset()
  {
    $config['upload_path'] = FCPATH . 'assets\foto\Barang';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    // Ambil nomor aktiva dan bersihkan spasi
    $nomorAktiva = str_replace(' ', '_', $this->input->post('nomorAktiva'));

    // Ambil ekstensi file asli
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // Buat nama file berdasarkan nomor aktiva
    $cleanFileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $nomorAktiva); // buang karakter aneh
    $finalFileName = $cleanFileName . '.' . $ext;
    $config['file_name'] = $finalFileName;

    $this->upload->initialize($config);
    $format = "%Y-%m-%d";

    if ($this->upload->do_upload('foto')) {
      $foto = $add_filename;
    } else {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
      echo $config['upload_path'];
    }
    $user = $this->session->userdata('id');
    // Get Detail Ruangan Penyimpanan
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('lokasiBarang'), $this->input->post('penyimpananBarang'));

    $data = array(
      'nama_barang' => $this->input->post('namaBarang'),
      'nomor_aktiva' => $this->input->post('nomorAktiva'),
      'jumlah_barang' => $this->input->post('totalBarang'),
      'jumlah_optimum' => $this->input->post('totalBarangOptimum'),
      'jumlah_minimum' => $this->input->post('totalBarangMinimum'),
      'satuan_barang' => $this->input->post('satuanBarang'),
      'kondisi_barang' => $this->input->post('kondisiBarang'),
      'kategori_barang' => $this->input->post('kategoriBarang'),
      'tipe_barang' => $this->input->post('tipeBarang'),
      'id_dtl_penyimpanan' => $dtl_ruangan_penyimpanan,
      'keterangan_penyimpanan' => $this->input->post('barisLokasi'),
      'gambar_barang' => $finalFileName,
      'status_barang' => 'Aktif',
      'ketersediaan_barang' => 'Available',
      'created_by' => $user,
      'created_date' => mdate($format)
    );
    $insert = $this->models->savebarang($data);
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/BarangPICNonAsset'));
  }

  public function editbarangPICNonAsset()
  {
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('lokasiBarangE'), $this->input->post('penyimpananBarangE'));
    $this->models->editbarang($dtl_ruangan_penyimpanan);
    $this->session->set_userdata('ubah', 'ubah');
    redirect(base_url('./Functions/BarangPICNonAsset'));
  }

  public function deletebarangPICNonAsset()
  {
    $idBarang = $this->input->post('id_barang');
    $this->models->deletebarang($idBarang);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/BarangPICNonAsset'));
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////RUANGAN


  public function Ruangan()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getRuangan["getData"] = $this->models->getruangan();
    $getRuangan["pengguna"] = $this->models->getpengguna();
    $getRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/Ruangan', $getRuangan);
  }
  public function RuanganPICAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getRuangan["getData"] = $this->models->getruangan();
    $getRuangan["pengguna"] = $this->models->getpengguna();
    $getRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/PICAsset/Ruangan', $getRuangan);
  }

  public function saveruanganPICAsset()
  {
    $new_name = "";
    $id_ruangan = $this->models->getDataRuanganByNamaRuangan($this->input->post('namaRuangan'),0);
    if($id_ruangan==null){
      $data = array(
        'id_ruangan' => $new_name,
        'nama_ruangan' => $this->input->post('namaRuangan'),
        'pic_ruangan' => $this->input->post('picRuangan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_ruangan' => 'Aktif'    );
      $insert = $this->models->saveruangan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data room already exists!');
    }
    redirect(base_url('./Functions/RuanganPICAsset'));
  }
  
  
  public function editruanganPICAsset()
  {
    $id_ruangan = $this->models->getDataRuanganByNamaRuangan($this->input->post('namaRuanganE'),$this->input->post('idRuanganE'));
    if($id_ruangan==null){
      $update = $this->models->editRuangan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data room already exists!');
    }
    redirect(base_url('./Functions/RuanganPICAsset'));
  }

  public function deleteruanganPICAsset()
  {
    $idRuangan = $this->input->post('id_ruangan');
    $this->models->deleteruangan($idRuangan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/RuanganPICAsset'));
  }

  //Non Asset
  public function RuanganPICNonAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getRuangan["getData"] = $this->models->getruangan();
    $getRuangan["pengguna"] = $this->models->getpengguna();
    $getRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/PICNonAsset/Ruangan', $getRuangan);
  }

  public function saveruanganPICNonAsset()
  {
    $new_name = "";
    $id_ruangan = $this->models->getDataRuanganByNamaRuangan($this->input->post('namaRuangan'),0);
    if($id_ruangan==null){
      $data = array(
        'id_ruangan' => $new_name,
        'nama_ruangan' => $this->input->post('namaRuangan'),
        'pic_ruangan' => $this->input->post('picRuangan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_ruangan' => 'Aktif'    );
      $insert = $this->models->saveruangan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data room already exists!');
    }
    redirect(base_url('./Functions/RuanganPICNonAsset'));
  }
  
  
  public function editruanganPICNonAsset()
  {
    $id_ruangan = $this->models->getDataRuanganByNamaRuangan($this->input->post('namaRuanganE'),$this->input->post('idRuanganE'));
    if($id_ruangan==null){
      $update = $this->models->editRuangan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data room already exists!');
    }
    redirect(base_url('./Functions/RuanganPICNonAsset'));
  }

  public function deleteruanganPICNonAsset()
  {
    $idRuangan = $this->input->post('id_ruangan');
    $this->models->deleteruangan($idRuangan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/RuanganPICNonAsset'));
  }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////Detail Ruangan
  public function DetailRuangan($idRuangan)
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDetailRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDetailRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getDetailRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDetailRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDetailRuangan["namaRuangan"] = $this->models->getDataRuanganById($idRuangan);
    $getDetailRuangan["idRuangan"] = $idRuangan;
    $getDetailRuangan["penyimpanan"] = $this->models->getPenyimpananByIdRuangan($idRuangan);
    $getDetailRuangan["daftar_penyimpanan"] = $this->models->getDataPenyimpanan();
    $getDetailRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/DetailRuangan', $getDetailRuangan);
  }
  public function DetailRuanganPICAsset($idRuangan)
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDetailRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDetailRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getDetailRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDetailRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDetailRuangan["namaRuangan"] = $this->models->getDataRuanganById($idRuangan);
    $getDetailRuangan["idRuangan"] = $idRuangan;
    $getDetailRuangan["penyimpanan"] = $this->models->getPenyimpananByIdRuangan($idRuangan);
    $getDetailRuangan["daftar_penyimpanan"] = $this->models->getDataPenyimpanan();
    $getDetailRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/PICAsset/DetailRuangan', $getDetailRuangan);
  }
  public function savedetailruanganPICAsset()
  {
    $new_name = "";
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('id_ruangan'), $this->input->post('penyimpanan'));
    if($dtl_ruangan_penyimpanan==null){
      $data = array(
        'id_dtl_penyimpanan' => $new_name,
        'id_ruangan' => $this->input->post('id_ruangan'),
        'id_penyimpanan' => $this->input->post('penyimpanan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_detail' => 'Aktif'    );
      $insert = $this->models->savedetailruangan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }
    else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PICAsset/DetailRuangan/'.$this->input->post('id_ruangan')));
  }
  public function editdetailruanganPICAsset()
  {
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('id_ruanganE'), $this->input->post('penyimpananE'));
    if($dtl_ruangan_penyimpanan==null){
      $update = $this->models->editDetailRuangan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PICAsset/DetailRuangan/'.$this->input->post('id_ruanganE')));
  }
  public function deletedetailruanganPICAsset()
  {
    $dtl_ruangan_penyimpanan = $this->input->post('id_dtl_penyimpanan');
    $this->models->deletedetailruangan($dtl_ruangan_penyimpanan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PICAsset/DetailRuangan/'.$this->input->post('id_ruanganE')));
  }

  //Non Asset
  public function DetailRuanganPICNonAsset($idRuangan)
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDetailRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDetailRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getDetailRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDetailRuangan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDetailRuangan["namaRuangan"] = $this->models->getDataRuanganById($idRuangan);
    $getDetailRuangan["idRuangan"] = $idRuangan;
    $getDetailRuangan["penyimpanan"] = $this->models->getPenyimpananByIdRuangan($idRuangan);
    $getDetailRuangan["daftar_penyimpanan"] = $this->models->getDataPenyimpanan();
    $getDetailRuangan["activePage"] = "Ruangan";
    $this->load->view('UI/PICNonAsset/DetailRuangan', $getDetailRuangan);
  }
  public function savedetailruanganPICNonAsset()
  {
    $new_name = "";
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('id_ruangan'), $this->input->post('penyimpanan'));
    if($dtl_ruangan_penyimpanan==null){
      $data = array(
        'id_dtl_penyimpanan' => $new_name,
        'id_ruangan' => $this->input->post('id_ruangan'),
        'id_penyimpanan' => $this->input->post('penyimpanan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_detail' => 'Aktif'    );
      $insert = $this->models->savedetailruangan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }
    else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PICNonAsset/DetailRuangan/'.$this->input->post('id_ruangan')));
  }
  public function editdetailruanganPICNonAsset()
  {
    $dtl_ruangan_penyimpanan = $this->models->getDataDetailPenyimpanan($this->input->post('id_ruanganE'), $this->input->post('penyimpananE'));
    if($dtl_ruangan_penyimpanan==null){
      $update = $this->models->editDetailRuangan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PICAsset/DetailRuangan/'.$this->input->post('id_ruanganE')));
  }
  public function deletedetailruanganPICNonAsset()
  {
    $dtl_ruangan_penyimpanan = $this->input->post('id_dtl_penyimpanan');
    $this->models->deletedetailruangan($dtl_ruangan_penyimpanan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PICNonAsset/DetailRuangan/'.$this->input->post('id_ruanganE')));
  }
  
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////Penyimpanan

  public function Penyimpanan()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPenyimpanan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPenyimpanan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPenyimpanan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPenyimpanan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPenyimpanan["getData"] = $this->models->getDataPenyimpanan();
    $getDataPenyimpanan["activePage"] = "Penyimpanan";
    $this->load->view('UI/Penyimpanan', $getDataPenyimpanan);
  }

  public function PenyimpananPICAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPenyimpanan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPenyimpanan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPenyimpanan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPenyimpanan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPenyimpanan["getData"] = $this->models->getDataPenyimpanan();
    $getDataPenyimpanan["activePage"] = "Penyimpanan";
    $this->load->view('UI/PICAsset/Penyimpanan', $getDataPenyimpanan);
  }
  public function PenyimpananPICNonAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPenyimpanan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPenyimpanan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPenyimpanan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPenyimpanan['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPenyimpanan["getData"] = $this->models->getDataPenyimpanan();
    $getDataPenyimpanan["activePage"] = "Penyimpanan";
    $this->load->view('UI/PICNonAsset/Penyimpanan', $getDataPenyimpanan);
  }

  public function getPenyimpanan()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataJenisRuangan['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataJenisRuangan['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getDataJenisRuangan['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    $nama_ruangan = $this->input->post('nama_ruangan');
    $penyimpanans = $this->models->getPenyimpananByRuangan($nama_ruangan);
    echo json_encode($penyimpanans);
  }

  public function getPenyimpananByRuangan()
  {
    $nama_ruangan = $this->input->post('nama_ruangan');
    $data['penyimpanan'] = $this->models->getPenyimpananDetailByRuangan($nama_ruangan);
    $this->load->view('UI/penyimpanan_table_rows', $data); // hanya baris <tr>
  }

  public function savepenyimpananPICAsset()
  {
    $new_name = "";
    $id_penyimpanan = $this->models->getDataPenyimpananByNamaPenyimpanan($this->input->post('namaPenyimpanan'),$this->input->post('idPenyimpananE'));
    if($id_penyimpanan==null){
      $data = array(
        'id_penyimpanan' => $new_name,
        'nama_penyimpanan' => $this->input->post('namaPenyimpanan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_penyimpanan' => 'Aktif'    );
      $insert = $this->models->savepenyimpanan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    // Fasilitas dimasukkan ke dalam detail fasilitas, kolom di fasilitas dihilangkan
      
    redirect(base_url('./Functions/PenyimpananPICAsset'));
  }
  public function editpenyimpananPICAsset()
  {
    $id_penyimpanan = $this->models->getDataPenyimpananByNamaPenyimpanan($this->input->post('namaPenyimpananE'),$this->input->post('idPenyimpananE'));
    if($id_penyimpanan==null){
      $update = $this->models->editpenyimpanan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PenyimpananPICAsset'));
  }
  public function deletepenyimpananPICAsset()
  {
    $id_penyimpanan = $this->input->post('id_penyimpanan');
    $this->models->deletepenyimpanan($id_penyimpanan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PenyimpananPICAsset'));
  }
  public function savepenyimpananPICNonAsset()
  {
    $new_name = "";
    $id_penyimpanan = $this->models->getDataPenyimpananByNamaPenyimpanan($this->input->post('namaPenyimpanan'),$this->input->post('idPenyimpananE'));
    if($id_penyimpanan==null){
      $data = array(
        'id_penyimpanan' => $new_name,
        'nama_penyimpanan' => $this->input->post('namaPenyimpanan'),
        'created_date' => date('Y/m/d'),
        'created_by' => $this->session->userdata('id'),
        'status_penyimpanan' => 'Aktif'    );
      $insert = $this->models->savepenyimpanan($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    // Fasilitas dimasukkan ke dalam detail fasilitas, kolom di fasilitas dihilangkan
      
    redirect(base_url('./Functions/PenyimpananPICNonAsset'));
  }
  public function editpenyimpananPICNonAsset()
  {
    $id_penyimpanan = $this->models->getDataPenyimpananByNamaPenyimpanan($this->input->post('namaPenyimpananE'),$this->input->post('idPenyimpananE'));
    if($id_penyimpanan==null){
      $update = $this->models->editpenyimpanan();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data storage already exists in this room!');
    }
    redirect(base_url('./Functions/PenyimpananPICNonAsset'));
  }
  public function deletepenyimpananPICNonAsset()
  {
    $id_penyimpanan = $this->input->post('id_penyimpanan');
    $this->models->deletepenyimpanan($id_penyimpanan);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PenyimpananPICNonAsset'));
  }
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////Pengguna

  public function Pengguna()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPengguna['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPengguna['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPengguna['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPengguna['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPengguna["getData"] = $this->models->getpengguna();
    $getDataPengguna["activePage"] = "Pengguna";
    $this->load->view('UI/Pengguna', $getDataPengguna);
  }

  public function PenggunaPICAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPengguna['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPengguna['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPengguna['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPengguna['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPengguna["getData"] = $this->models->getpengguna();
    $getDataPengguna["activePage"] = "Pengguna";
    $this->load->view('UI/PICAsset/Pengguna', $getDataPengguna);
  }

  public function PenggunaPICNonAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getDataPengguna['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $getDataPengguna['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataPengguna['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    if ($this->session->userdata('error')) {
      $getDataPengguna['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    $getDataPengguna["getData"] = $this->models->getpengguna();
    $getDataPengguna["activePage"] = "Pengguna";
    $this->load->view('UI/PICNonAsset/Pengguna', $getDataPengguna);
  }

  public function savepenggunaPICAsset()
  {
    $config['upload_path'] = FCPATH . 'assets\foto\Tim';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $foto = $_FILES['foto']['name'];
    $add_filename = $_FILES['foto']['name'];
    $config['file_name'] = $add_filename;

    $this->upload->initialize($config);
    $format = "%Y-%m-%d";

    if ($this->upload->do_upload('foto')) {
      $foto = $add_filename;
    } else {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
      echo $config['upload_path'];
    }
    $user = $this->session->userdata('id');
    
    $data = array(
      'id_pengguna' => $this->input->post('npkPengguna'),
      'nama_pengguna' => $this->input->post('namaPengguna'),
      'email_pengguna' => $this->input->post('emailPengguna'),
      'username_pengguna' => $this->input->post('usernamePengguna'),
      'password_pengguna' => $this->input->post('passwordPengguna'),
      'role_pengguna' => $this->input->post('rolePengguna'),
      'main_job' => $this->input->post('mainJob'),
      'other_job' => $this->input->post('otherJob'),
      'foto' => $foto,
      'status_pengguna' => 'Aktif',
      'created_by' => $user,
      'created_date' => mdate($format)
    );
    $id_pengguna = $this->models->getPenggunaByNamaPengguna($this->input->post('namaPengguna'), $this->input->post('npkPengguna'));
    if($id_pengguna==null){
      $insert = $this->models->savepengguna($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data user already exists!');
    }
    redirect(base_url('./Functions/PenggunaPICAsset'));
  }
  public function editpenggunaPICAsset()
  {
    $id_pengguna = $this->models->getPenggunaByNamaPengguna($this->input->post('namaPenggunaE'), $this->input->post('idPenggunaE'));
    if($id_pengguna==null){
      $update = $this->models->editpengguna();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data user already exists!');
    }
    redirect(base_url('./Functions/PenggunaPICAsset'));
  }
  public function deletePenggunaPICAsset()
  {
    $id_pengguna = $this->input->post('id_pengguna');
    $this->models->hapuspengguna($id_pengguna);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PenggunaPICAsset'));
  }

  public function savepenggunaPICNonAsset()
  {
    $config['upload_path'] = FCPATH . 'assets\foto\Tim';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $foto = $_FILES['foto']['name'];
    $add_filename = $_FILES['foto']['name'];
    $config['file_name'] = $add_filename;

    $this->upload->initialize($config);
    $format = "%Y-%m-%d";

    if ($this->upload->do_upload('foto')) {
      $foto = $add_filename;
    } else {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
      echo $config['upload_path'];
    }
    $user = $this->session->userdata('id');
    
    $data = array(
      'id_pengguna' => $this->input->post('npkPengguna'),
      'nama_pengguna' => $this->input->post('namaPengguna'),
      'email_pengguna' => $this->input->post('emailPengguna'),
      'username_pengguna' => $this->input->post('usernamePengguna'),
      'password_pengguna' => $this->input->post('passwordPengguna'),
      'role_pengguna' => $this->input->post('rolePengguna'),
      'main_job' => $this->input->post('mainJob'),
      'other_job' => $this->input->post('otherJob'),
      'foto' => $foto,
      'status_pengguna' => 'Aktif',
      'created_by' => $user,
      'created_date' => mdate($format)
    );
    $id_pengguna = $this->models->getPenggunaByNamaPengguna($this->input->post('namaPengguna'), $this->input->post('npkPengguna'));
    if($id_pengguna==null){
      $insert = $this->models->savepengguna($data);
      $this->session->set_userdata('tambah', 'tambah');
    }else{
      $this->session->set_userdata('error', 'Data user already exists!');
    }
    redirect(base_url('./Functions/PenggunaPICNonAsset'));
  }
  public function editpenggunaPICNonAsset()
  {
    $id_pengguna = $this->models->getPenggunaByNamaPengguna($this->input->post('namaPenggunaE'), $this->input->post('idPenggunaE'));
    if($id_pengguna==null){
      $update = $this->models->editpengguna();
      $this->session->set_userdata('ubah', 'ubah');
    }else{
      $this->session->set_userdata('error', 'Data user already exists!');
    }
    redirect(base_url('./Functions/PenggunaPICNonAsset'));
  }
  public function deletePenggunaPICNonAsset()
  {
    $id_pengguna = $this->input->post('id_pengguna');
    $this->models->hapuspengguna($id_pengguna);
    $this->session->set_userdata('hapus', 'hapus');
    redirect(base_url('./Functions/PenggunaPICNonAsset'));
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////APPROVAL

  public function Approval()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $data['approval'] = $this->models->getDataApproval();
    $data["activePage"] = "Approval";
    $this->load->view('UI/Approval', $data);
  }
  public function ApprovalPICAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }

    // Cek dan update status_barang dan status_peminjaman
    $this->load->model('PeminjamanModel');
    $this->load->model('BarangModel');
    //mengubah status menjadi waiting for approval
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

    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;

    // Filter approval by tanggal
    $data['approval'] = $this->models->getDataApprovalPICAssetFiltered($start_date, $end_date);
    $data["activePage"] = "Approval";
    $this->load->view('UI/PICAsset/Approval', $data);
  }
  public function ApprovalPICNonAsset()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
     // Ambil filter dari input POST
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');

    // Cek dan update status_barang dan status_peminjaman
    $this->load->model('PeminjamanModel');
    $this->load->model('BarangModel');
      // Kirimkan juga nilai start_date dan end_date ke view agar input tetap terisi
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;

    // Filter approval by tanggal
    $data['approval'] = $this->models->getDataApprovalPICNonAssetFiltered($start_date, $end_date);
    // $data['approval'] = $this->models->getDataApprovalPICNonAsset();
    //mengubah status menjadi waiting for approval
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

    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
    
    $data["activePage"] = "Approval";
    $this->load->view('UI/PICNonAsset/Approval', $data);
  }

  public function ApprovalKoorUPT()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }

    // Cek dan update status_barang dan status_peminjaman
    $this->load->model('PeminjamanModel');
    $this->load->model('BarangModel');
    //mengubah status menjadi waiting for approval
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

    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->models->getDataPenyimpanan();
      // Kirimkan juga nilai start_date dan end_date ke view agar input tetap terisi
     // Ambil filter dari input POST
    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;

    // Filter approval by tanggal
    $data['approval'] = $this->models->getDataApprovalKoorUPTFiltered($start_date, $end_date);
    $data["activePage"] = "Approval";
    $this->load->view('UI/KoordinatorUPT/Approval', $data);
  }

  public function getDtlPeminjamanByIdPeminjamanPICAsset()
  {
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data['dtl_peminjaman'] = $this->models->getDtlPeminjamanByIdPeminjamanPICAsset($id_peminjaman);
    $this->load->view('UI/PICAsset/dtl_peminjaman_table_rows', $data); // hanya baris <tr>
  }
  public function getDtlPeminjamanByIdPeminjamanPICNonAsset()
  {
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data['dtl_peminjaman'] = $this->models->getDtlPeminjamanByIdPeminjamanPICNonAsset($id_peminjaman);
    $this->load->view('UI/PICNonAsset/dtl_peminjaman_table_rows', $data); // hanya baris <tr>
  }
  public function getDtlPeminjamanByIdPeminjamanKoorUPT()
  {
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data['dtl_peminjaman'] = $this->models->getDtlPeminjamanByIdPeminjamanKoorUPT($id_peminjaman);
    $this->load->view('UI/KoordinatorUPT/dtl_peminjaman_table_rows', $data); // hanya baris <tr>
  }
  public function getDtlPeminjamanByIdPeminjaman()
  {
    $id_peminjaman = $this->input->post('id_peminjaman');
    $data['dtl_peminjaman'] = $this->models->getDtlPeminjamanByIdPeminjaman($id_peminjaman);
    $this->load->view('UI/dtl_peminjaman_table_rows', $data); // hanya baris <tr>
  }
  public function accpeminjaman()
  {
    $update = $this->models->accpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/Approval'));
  }
  public function accpeminjamanPICAsset()
  {
    $update = $this->models->accpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalPICAsset'));
  }
  public function rejectpeminjamanPICAsset()
  {
    $update = $this->models->rejectpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalPICAsset'));
  }
  public function accpeminjamanPICNonAsset()
  {
    $update = $this->models->accpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalPICNonAsset'));
  }
  public function rejectpeminjamanPICNonAsset()
  {
    $update = $this->models->rejectpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalPICNonAsset'));
  }
  public function accpeminjamanKoorUPT()
  {
    $update = $this->models->accpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalKoorUPT'));
  }
  public function rejectpeminjamanKoorUPT()
  {
    $update = $this->models->rejectpeminjaman();
    $this->session->set_userdata('tambah', 'tambah');
    redirect(base_url('./Functions/ApprovalKoorUPT'));
  }
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Lain Lain
  
  
  public function viewpdf()
  {
    $fname = $this->uri->segment(3);
    $tofile = base_url() . 'upload/' . $fname;
    header('Content-Type: application/pdf');
    readfile($tofile);
  }
  public function resetPassword()
  {
    $this->models->UbahPassword();
    $this->session->set_userdata('resetpw', 'resetpw');
    //redirect(base_url('./Functions/Dashboard'));
  }

  public function RiwayatPeminjamanBarang()
  {
    $getData["getData"] = $this->models->getRiwayatBarang();
    $getData["activePage"] = "RiwayatPeminjamanBarang";
    $this->load->view('UI/RiwayatBarang', $getData);
  }
  public function RiwayatPeminjamanRuangan()
  {
    $getData["getData"] = $this->models->getRiwayatRuangan();
    $getData["activePage"] = "RiwayatPeminjamanRuangan";
    $this->load->view('UI/RiwayatRuangan', $getData);
  }

  public function detailRiwayatRuangan($id)
  {
    $getData["getData"] = $this->models->getRiwayatRuanganDetail($id);
    $getData["activePage"] = "RiwayatPeminjamanRuangan";
    $this->load->view('UI/detailRiwayatRuangan', $getData);
  }
  public function detailRiwayatBarang($id)
  {
    $getData["getDataSpan"] = $this->models->getRiwayatBarangSpan($id);
    $getData["getDataDetail"] = $this->models->getRiwayatBarangDetail($id);
    $getData["activePage"] = "RiwayatPeminjamanBarang";
    $this->load->view('UI/detailRiwayatBarang', $getData);
  }
  public function terimaPengajuanRuangan()
  {
    $id = $this->input->post('id_peminjaman');
    $this->models->accRuangan($id);

  }
  public function tolakpengajuanRuangan()
  {
    $id = $this->input->post('id_peminjaman');
    $this->models->rejectRuangan($id);
  }
  public function terimaPengajuanBarang()
  {
    $id = $this->input->post('id_peminjaman');
    // get data barang dari tb_detil_barang
    $barang = $this->models->getdetilBarang($id);    
    echo json_encode($barang);
  }
  public function updateStok(){
    $id_peminjaman = $this->input->post('id_peminjaman');
    $id = $this->input->post('id_barang');
    $jml = $this->input->post('jumlah');
    $this->models->accBarang($id_peminjaman);
    $this->models->minStok($id,$jml);
    // get jumlah barang
    $jumlah = $this->models->getJmlbarang($id);
    $jmldata = 0;
    foreach($jumlah as $jml){
      $jmldata = (int) $jml->jumlah;
    }
    if($jmldata <= 0){
      //update status menjadi tidak tersedia
      $this->models->updateStatusBrg($id);
    }
  }
  public function TambahStok(){
    $id = $this->input->post('id_barang');
    $jml = $this->input->post('jumlah');
    $this->models->plusStok($id,$jml);
    //update status menjadi tersedia
    $this->models->updateStatusBrgTersedia($id);

  }
  public function tolakpengajuanBarang()
  {
    $id = $this->input->post('id_peminjaman');
    $this->models->rejectBarang($id);
  }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////MUTASI

  /**
   * Mutasi page for PIC Asset
   */
  public function MutasiPICAsset()
  {
    $this->load->model('MutasiModel');
    
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');

    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('accept')) {
      $data['accept'] = $this->session->userdata('accept');
      $this->session->unset_userdata('accept');
    }
    if ($this->session->userdata('reject')) {
      $data['reject'] = $this->session->userdata('reject');
      $this->session->unset_userdata('reject');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }

    $data['mutasi'] = $this->MutasiModel->getDataMutasiFiltered($start_date, $end_date, $status_filter);
    $data['ruangans'] = $this->MutasiModel->getRuanganList();
    $data['institusi'] = $this->MutasiModel->getInstitusiList();
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['status_filter'] = $status_filter;
    $data['activePage'] = 'Mutasi';
    
    $this->load->view('UI/PICAsset/Mutasi', $data);
  }

  /**
   * Mutasi page for Koordinator UPT
   */
  public function MutasiKoorUPT()
  {
    $this->load->model('MutasiModel');
    
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');

    if ($this->session->userdata('accept')) {
      $data['accept'] = $this->session->userdata('accept');
      $this->session->unset_userdata('accept');
    }
    if ($this->session->userdata('reject')) {
      $data['reject'] = $this->session->userdata('reject');
      $this->session->unset_userdata('reject');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }

    // Use KoorUPT specific filter (excludes Draft status)
    $data['mutasi'] = $this->MutasiModel->getDataMutasiFilteredKoorUPT($start_date, $end_date, $status_filter);
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['status_filter'] = $status_filter;
    $data['activePage'] = 'Mutasi';
    
    $this->load->view('UI/KoordinatorUPT/Mutasi', $data);
  }

  /**
   * Get detail mutasi by ID for PIC Asset
   */
  public function getDtlMutasiByIdMutasiPICAsset()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    $detail = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    
    echo json_encode([
      'mutasi' => $mutasi,
      'detail' => $detail
    ]);
  }

  /**
   * Get detail mutasi by ID for Koordinator UPT
   */
  public function getDtlMutasiByIdMutasiKoorUPT()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    $detail = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    
    echo json_encode([
      'mutasi' => $mutasi,
      'detail' => $detail
    ]);
  }

  /**
   * Mutation Detail Page for PIC Asset
   */
  public function MutasiDetailPICAsset($id_mutasi)
  {
    $this->load->model('MutasiModel');
    
    $data['mutasi'] = $this->MutasiModel->getMutasiById($id_mutasi);
    $data['detail'] = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    $data['activePage'] = 'Mutasi';
    
    $this->load->view('UI/PICAsset/MutasiDetail', $data);
  }

  /**
   * Mutation Detail Page for Koordinator UPT
   */
  public function MutasiDetailKoorUPT($id_mutasi)
  {
    $this->load->model('MutasiModel');
    
    $data['mutasi'] = $this->MutasiModel->getMutasiById($id_mutasi);
    $data['detail'] = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    $data['activePage'] = 'Mutasi';
    
    $this->load->view('UI/KoordinatorUPT/MutasiDetail', $data);
  }

  /**
   * Approve mutasi by PIC Asset
   */
  public function accMutasiPICAsset()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    $disetujui_oleh = $this->session->userdata('nama');
    
    // Update status to On Progress Approval Koordinator UPT
    $this->MutasiModel->updateMutasiStatus($id_mutasi, 'On Progress Approval Koordinator UPT', $disetujui_oleh);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Reject mutasi by PIC Asset
   */
  public function rejectMutasiPICAsset()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    $alasan = $this->input->post('alasan');
    $disetujui_oleh = $this->session->userdata('nama') . ' - Rejected: ' . $alasan;
    
    $this->MutasiModel->updateMutasiStatus($id_mutasi, 'Rejected', $disetujui_oleh);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Approve mutasi by Koordinator UPT
   */
  public function accMutasiKoorUPT()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    $disetujui_oleh = $this->session->userdata('nama');
    
    // Get mutation data
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    $lokasi_tujuan = $mutasi->lokasi_tujuan;
    
    // Get detail items
    $items = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    
    // Check if destination is internal (existing room) or external
    $id_ruangan_tujuan = $this->MutasiModel->getRuanganIdByName($lokasi_tujuan);
    
    if ($id_ruangan_tujuan) {
      // Internal mutation - move items to new location
      foreach ($items as $item) {
        // Get default penyimpanan for destination room (first available)
        $id_dtl_penyimpanan_tujuan = $this->MutasiModel->getDefaultPenyimpananByRuangan($id_ruangan_tujuan);
        
        if ($id_dtl_penyimpanan_tujuan) {
          // Update barang location to destination
          $this->MutasiModel->updateBarangLocation($item->id_barang, $id_dtl_penyimpanan_tujuan);
        }
      }
    } else {
      // External mutation - mark items as moved out / non-active
      foreach ($items as $item) {
        $this->MutasiModel->updateBarangStatusMutasiExternal($item->id_barang, $lokasi_tujuan);
      }
    }
    
    // Update status to Approved
    $this->MutasiModel->updateMutasiStatus($id_mutasi, 'Approved', $disetujui_oleh);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Reject mutasi by Koordinator UPT
   */
  public function rejectMutasiKoorUPT()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    $alasan = $this->input->post('alasan');
    $disetujui_oleh = $this->session->userdata('nama') . ' - Rejected: ' . $alasan;
    
    $this->MutasiModel->updateMutasiStatus($id_mutasi, 'Rejected', $disetujui_oleh);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Save new mutation session
   */
  public function saveMutasiSession()
  {
    $this->load->model('MutasiModel');
    
    $data = array(
      'id_pengguna' => $this->input->post('id_pengguna'),
      'tanggal_mutasi' => $this->input->post('tanggal_mutasi'),
      'lokasi_asal' => $this->input->post('lokasi_asal'),
      'lokasi_tujuan' => $this->input->post('lokasi_tujuan'),
      'ruang_penyimpanan_tujuan' => $this->input->post('ruang_penyimpanan_tujuan'),
      'alasan_mutasi' => $this->input->post('alasan_mutasi'),
      'status_mutasi' => 'Draft'
    );
    
    $id_mutasi = $this->MutasiModel->saveMutasi($data);
    
    if ($id_mutasi) {
      $this->session->set_userdata('tambah', 'tambah');
    } else {
      $this->session->set_userdata('error', 'Failed to save mutation session');
    }
    
    redirect(base_url('./Functions/MutasiPICAsset'));
  }

  /**
   * Get mutation by ID (for edit)
   */
  public function getMutasiById()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    
    echo json_encode($mutasi);
  }

  /**
   * Update mutation session
   */
  public function updateMutasiSession()
  {
    $this->load->model('MutasiModel');
    
    $id_mutasi = $this->input->post('id_mutasi');
    
    $data = array(
      'tanggal_mutasi' => $this->input->post('tanggal_mutasi'),
      'lokasi_asal' => $this->input->post('lokasi_asal'),
      'lokasi_tujuan' => $this->input->post('lokasi_tujuan'),
      'ruang_penyimpanan_tujuan' => $this->input->post('ruang_penyimpanan_tujuan'),
      'alasan_mutasi' => $this->input->post('alasan_mutasi'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d')
    );
    
    $result = $this->MutasiModel->updateMutasi($id_mutasi, $data);
    
    if ($result) {
      $this->session->set_userdata('ubah', 'ubah');
    } else {
      $this->session->set_userdata('error', 'Failed to update mutation session');
    }
    
    redirect(base_url('./Functions/MutasiPICAsset'));
  }

  /**
   * Delete mutation session (only Draft status)
   */
  public function deleteMutasiSession()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    // Check if mutation is in Draft status
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    
    if ($mutasi && $mutasi->status_mutasi === 'Draft') {
      $result = $this->MutasiModel->deleteMutasi($id_mutasi);
      
      if ($result) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete mutation session']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Only Draft mutations can be deleted']);
    }
  }

  /**
   * Check if mutation has items
   */
  public function checkMutasiItems()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    $items = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
    $count = count($items);
    
    echo json_encode(['count' => $count]);
  }

  /**
   * Get available barang for mutation (filtered by origin location)
   */
  public function getAvailableBarangForMutasi()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    // Get mutation to find origin location
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    $lokasi_asal = $mutasi ? $mutasi->lokasi_asal : '';
    
    // Get barang filtered by origin location
    $barang = $this->MutasiModel->getAvailableBarangByLocation($lokasi_asal);
    echo json_encode($barang);
  }

  /**
   * Add Item to Mutation Page (like Inventory page)
   */
  public function AddItemMutasiPage($id_mutasi)
  {
    $this->load->model('MutasiModel');
    
    // Get mutation data
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    
    // Check if mutation exists and is in Draft status
    if (!$mutasi || $mutasi->status_mutasi !== 'Draft') {
      redirect(base_url('./Functions/MutasiPICAsset'));
      return;
    }
    
    // Get available barang (not already in this mutation)
    $data['barang'] = $this->MutasiModel->getAvailableBarangForMutasiPage($id_mutasi);
    $data['mutasi'] = $mutasi;
    $data['id_mutasi'] = $id_mutasi;
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->MutasiModel->getPenyimpananList();
    $data['activePage'] = 'Mutasi';
    
    if ($this->session->userdata('success')) {
      $data['success'] = $this->session->userdata('success');
      $this->session->unset_userdata('success');
    }
    
    $this->load->view('UI/PICAsset/AddItemMutasi', $data);
  }

  /**
   * Add item to mutation (AJAX)
   */
  public function addItemToMutasiAjax()
  {
    $this->load->model('MutasiModel');
    
    $id_mutasi = $this->input->post('id_mutasi');
    $id_barang = $this->input->post('id_barang');
    
    // Check if item already exists in this mutation
    $existing = $this->MutasiModel->checkItemInMutasi($id_mutasi, $id_barang);
    if ($existing) {
      echo json_encode(['status' => 'error', 'message' => 'Item already exists in this mutation']);
      return;
    }
    
    $data = array(
      'id_mutasi' => $id_mutasi,
      'id_barang' => $id_barang,
      'kuantitas' => $this->input->post('kuantitas') ?: 1,
      'kondisi_barang' => $this->input->post('kondisi_barang') ?: 'Good',
      'catatan' => $this->input->post('catatan') ?: ''
    );
    
    $result = $this->MutasiModel->saveDtlMutasi($data);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to add item']);
    }
  }

  /**
   * Batch add items to mutation (AJAX) - FAST
   */
  public function addItemsToMutasiBatch()
  {
    $this->load->model('MutasiModel');
    
    $id_mutasi = $this->input->post('id_mutasi');
    $items = $this->input->post('items'); // Array of id_barang
    
    if (empty($items) || !is_array($items)) {
      echo json_encode(['status' => 'error', 'message' => 'No items provided']);
      return;
    }
    
    $successCount = 0;
    $skipCount = 0;
    
    foreach ($items as $id_barang) {
      // Check if item already exists
      $existing = $this->MutasiModel->checkItemInMutasi($id_mutasi, $id_barang);
      if ($existing) {
        $skipCount++;
        continue;
      }
      
      $data = array(
        'id_mutasi' => $id_mutasi,
        'id_barang' => $id_barang,
        'kuantitas' => 1,
        'kondisi_barang' => 'Good',
        'catatan' => ''
      );
      
      if ($this->MutasiModel->saveDtlMutasi($data)) {
        $successCount++;
      }
    }
    
    echo json_encode([
      'status' => 'success',
      'added' => $successCount,
      'skipped' => $skipCount,
      'message' => $successCount . ' items added' . ($skipCount > 0 ? ', ' . $skipCount . ' skipped (already exists)' : '')
    ]);
  }

  /**
   * Add item to mutation (form submit - legacy)
   */
  public function addItemToMutasi()
  {
    $this->load->model('MutasiModel');
    
    $data = array(
      'id_mutasi' => $this->input->post('id_mutasi'),
      'id_barang' => $this->input->post('id_barang'),
      'kuantitas' => $this->input->post('kuantitas'),
      'kondisi_barang' => $this->input->post('kondisi_barang'),
      'catatan' => $this->input->post('catatan')
    );
    
    $result = $this->MutasiModel->saveDtlMutasi($data);
    
    if ($result) {
      $this->session->set_userdata('tambah', 'tambah');
    } else {
      $this->session->set_userdata('error', 'Failed to add item to mutation');
    }
    
    redirect(base_url('./Functions/MutasiPICAsset'));
  }

  /**
   * Send mutation for approval (change status from Draft to On Progress Approval Koordinator UPT)
   */
  public function sendMutasiForApproval()
  {
    $this->load->model('MutasiModel');
    $id_mutasi = $this->input->post('id_mutasi');
    
    // Check if mutation is in Draft status
    $mutasi = $this->MutasiModel->getMutasiById($id_mutasi);
    
    if ($mutasi && $mutasi->status_mutasi === 'Draft') {
      // Check if mutation has items
      $items = $this->MutasiModel->getDtlMutasiByIdMutasi($id_mutasi);
      
      if (count($items) > 0) {
        // Send directly to Koordinator UPT for approval (skip PIC Asset approval)
        $result = $this->MutasiModel->updateMutasiStatus($id_mutasi, 'On Progress Approval Koordinator UPT');
        
        if ($result) {
          echo json_encode(['status' => 'success']);
        } else {
          echo json_encode(['status' => 'error', 'message' => 'Failed to send mutation']);
        }
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Please add at least one item before sending']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Only Draft mutations can be sent']);
    }
  }

  /**
   * Update detail mutasi (only condition and notes)
   */
  public function updateDtlMutasi()
  {
    $this->load->model('MutasiModel');
    $id_dtl_mutasi = $this->input->post('id_dtl_mutasi');
    
    $data = array(
      'kondisi_barang' => $this->input->post('kondisi_barang'),
      'catatan' => $this->input->post('catatan')
    );
    
    $result = $this->MutasiModel->updateDtlMutasi($id_dtl_mutasi, $data);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update item']);
    }
  }

  /**
   * Delete detail mutasi
   */
  public function deleteDtlMutasi()
  {
    $this->load->model('MutasiModel');
    $id_dtl_mutasi = $this->input->post('id_dtl_mutasi');
    
    $result = $this->MutasiModel->deleteDtlMutasi($id_dtl_mutasi);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////DUPAT PIC ASSET

  /**
   * Dupat page for PIC Asset
   */
  public function DupatPICAsset()
  {
    $this->load->model('DupatModel');
    
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');

    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }

    $data['dupat'] = $this->DupatModel->getDataDupatFiltered($start_date, $end_date, $status_filter);
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['status_filter'] = $status_filter;
    $data['activePage'] = 'Dupat';
    
    $this->load->view('UI/PICAsset/Dupat', $data);
  }

  /**
   * Save new dupat session
   */
  public function saveDupatSession()
  {
    $this->load->model('DupatModel');
    
    $data = array(
      'id_pengguna' => $this->input->post('id_pengguna'),
      'tanggal_dupat' => $this->input->post('tanggal_dupat'),
      'keterangan_dupat' => $this->input->post('keterangan_dupat'),
      'status_dupat' => 'Draft'
    );
    
    $id_dupat = $this->DupatModel->saveDupat($data);
    
    if ($id_dupat) {
      $this->session->set_userdata('tambah', 'tambah');
    } else {
      $this->session->set_userdata('error', 'Failed to save dupat session');
    }
    
    redirect(base_url('./Functions/DupatPICAsset'));
  }

  /**
   * Get dupat by ID (for edit)
   */
  public function getDupatById()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    
    $dupat = $this->DupatModel->getDupatById($id_dupat);
    
    echo json_encode($dupat);
  }

  /**
   * Update dupat session
   */
  public function updateDupatSession()
  {
    $this->load->model('DupatModel');
    
    $id_dupat = $this->input->post('id_dupat');
    
    $data = array(
      'keterangan_dupat' => $this->input->post('keterangan_dupat'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    );
    
    $result = $this->DupatModel->updateDupat($id_dupat, $data);
    
    if ($result) {
      $this->session->set_userdata('ubah', 'ubah');
    } else {
      $this->session->set_userdata('error', 'Failed to update dupat session');
    }
    
    redirect(base_url('./Functions/DupatPICAsset'));
  }

  /**
   * Delete dupat session (only Draft status)
   */
  public function deleteDupatSession()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    
    $dupat = $this->DupatModel->getDupatById($id_dupat);
    
    if ($dupat && $dupat->status_dupat === 'Draft') {
      $result = $this->DupatModel->deleteDupat($id_dupat);
      
      if ($result) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete dupat session']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Only Draft dupat can be deleted']);
    }
  }

  /**
   * Check if dupat has items
   */
  public function checkDupatItems()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    
    $count = $this->DupatModel->countItemsInDupat($id_dupat);
    
    echo json_encode(['count' => $count]);
  }

  /**
   * Send dupat for approval
   */
  public function sendDupatForApproval()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    
    $dupat = $this->DupatModel->getDupatById($id_dupat);
    
    if ($dupat && $dupat->status_dupat === 'Draft') {
      $count = $this->DupatModel->countItemsInDupat($id_dupat);
      
      if ($count > 0) {
        $result = $this->DupatModel->updateDupatStatus($id_dupat, 'On Progress Approval Koordinator UPT');
        
        if ($result) {
          echo json_encode(['status' => 'success']);
        } else {
          echo json_encode(['status' => 'error', 'message' => 'Failed to send dupat']);
        }
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Please add at least one item before sending']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Only Draft dupat can be sent']);
    }
  }

  /**
   * Dupat Detail Page for PIC Asset
   */
  public function DupatDetailPICAsset($id_dupat)
  {
    $this->load->model('DupatModel');
    
    $data['dupat'] = $this->DupatModel->getDupatById($id_dupat);
    $data['detail'] = $this->DupatModel->getDtlDupatByIdDupat($id_dupat);
    $data['activePage'] = 'Dupat';
    
    $this->load->view('UI/PICAsset/DupatDetail', $data);
  }

  /**
   * Dupat page for Koordinator UPT
   */
  public function DupatKoorUPT()
  {
    $this->load->model('DupatModel');
    
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');

    if ($this->session->userdata('accept')) {
      $data['accept'] = $this->session->userdata('accept');
      $this->session->unset_userdata('accept');
    }
    if ($this->session->userdata('reject')) {
      $data['reject'] = $this->session->userdata('reject');
      $this->session->unset_userdata('reject');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }

    $data['dupat'] = $this->DupatModel->getDataDupatFilteredKoorUPT($start_date, $end_date, $status_filter);
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['status_filter'] = $status_filter;
    $data['activePage'] = 'Dupat';
    
    $this->load->view('UI/KoordinatorUPT/Dupat', $data);
  }

  /**
   * Dupat Detail Page for Koordinator UPT
   */
  public function DupatDetailKoorUPT($id_dupat)
  {
    $this->load->model('DupatModel');
    
    $data['dupat'] = $this->DupatModel->getDupatById($id_dupat);
    $data['detail'] = $this->DupatModel->getDtlDupatByIdDupat($id_dupat);
    $data['activePage'] = 'Dupat';
    
    $this->load->view('UI/KoordinatorUPT/DupatDetail', $data);
  }

  /**
   * Approve dupat by Koordinator UPT
   */
  public function accDupatKoorUPT()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    $disetujui_oleh = $this->session->userdata('nama');
    
    // Get detail items
    $items = $this->DupatModel->getDtlDupatByIdDupat($id_dupat);
    
    // Mark items as non-active (deleted/disposed)
    foreach ($items as $item) {
      $this->db->where('id_barang', $item->id_barang);
      $this->db->update('barang', [
        'status_barang' => 'Tidak Aktif',
        'modified_by' => $this->session->userdata('id'),
        'modified_date' => date('Y-m-d')
      ]);
    }
    
    // Update status to Approved
    $this->DupatModel->updateDupatStatus($id_dupat, 'Approved', $disetujui_oleh);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Reject dupat by Koordinator UPT
   */
  public function rejectDupatKoorUPT()
  {
    $this->load->model('DupatModel');
    $id_dupat = $this->input->post('id_dupat');
    $alasan = $this->input->post('alasan');
    $disetujui_oleh = $this->session->userdata('nama');
    
    $this->DupatModel->updateDupatStatus($id_dupat, 'Rejected', $disetujui_oleh, $alasan);
    
    echo json_encode(['status' => 'success']);
  }

  /**
   * Add Item to Dupat Page
   */
  public function AddItemDupatPage($id_dupat)
  {
    $this->load->model('DupatModel');
    
    $dupat = $this->DupatModel->getDupatById($id_dupat);
    
    if (!$dupat || $dupat->status_dupat !== 'Draft') {
      redirect(base_url('./Functions/DupatPICAsset'));
      return;
    }
    
    $data['barang'] = $this->DupatModel->getAvailableBarangForDupatPage($id_dupat);
    $data['dupat'] = $dupat;
    $data['id_dupat'] = $id_dupat;
    $data['ruangans'] = $this->models->getDataRuangan();
    $data['penyimpanans'] = $this->DupatModel->getPenyimpananList();
    $data['activePage'] = 'Dupat';
    
    if ($this->session->userdata('success')) {
      $data['success'] = $this->session->userdata('success');
      $this->session->unset_userdata('success');
    }
    
    $this->load->view('UI/PICAsset/AddItemDupat', $data);
  }

  /**
   * Batch add items to dupat
   */
  public function addItemsToDupatBatch()
  {
    $this->load->model('DupatModel');
    
    $id_dupat = $this->input->post('id_dupat');
    $items = $this->input->post('items');
    
    if (empty($items) || !is_array($items)) {
      echo json_encode(['status' => 'error', 'message' => 'No items provided']);
      return;
    }
    
    $successCount = 0;
    $skipCount = 0;
    $errorMsg = '';
    
    foreach ($items as $item) {
      // Support both old format (just id) and new format (object with id_barang and usulan_pengeluaran)
      if (is_array($item)) {
        $id_barang = $item['id_barang'];
        $usulan_pengeluaran = isset($item['usulan_pengeluaran']) ? $item['usulan_pengeluaran'] : 'Deleted';
      } else {
        $id_barang = $item;
        $usulan_pengeluaran = 'Deleted';
      }
      
      $existing = $this->DupatModel->checkItemInDupat($id_dupat, $id_barang);
      if ($existing) {
        $skipCount++;
        continue;
      }
      
      // Get barang info to get id_penyimpanan
      $barang = $this->db->get_where('barang', ['id_barang' => $id_barang])->row();
      
      // Get id_penyimpanan from dtl_ruangan_penyimpanan
      $id_penyimpanan = null;
      if ($barang && $barang->id_dtl_penyimpanan) {
        $dtl = $this->db->get_where('dtl_ruangan_penyimpanan', ['id_dtl_penyimpanan' => $barang->id_dtl_penyimpanan])->row();
        if ($dtl) {
          $id_penyimpanan = $dtl->id_penyimpanan;
        }
      }
      
      $data = array(
        'id_dupat' => $id_dupat,
        'id_barang' => $id_barang,
        'id_penyimpanan' => $id_penyimpanan,
        'kondisi_barang' => $barang ? $barang->kondisi_barang : 'Good',
        'usulan_pengeluaran' => $usulan_pengeluaran,
        'keterangan' => '',
        'foto_barang' => ''
      );
      
      if ($this->DupatModel->saveDtlDupat($data)) {
        $successCount++;
      } else {
        $errorMsg = $this->db->error()['message'];
      }
    }
    
    if ($successCount > 0 || $skipCount > 0) {
      echo json_encode([
        'status' => 'success',
        'added' => $successCount,
        'skipped' => $skipCount,
        'message' => $successCount . ' items added' . ($skipCount > 0 ? ', ' . $skipCount . ' skipped (already exists)' : '')
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Failed to add items. ' . $errorMsg
      ]);
    }
  }

  /**
   * Update detail dupat
   */
  public function updateDtlDupat()
  {
    $this->load->model('DupatModel');
    $id_dtl_dupat = $this->input->post('id_dtl_dupat');
    
    $data = array(
      'kondisi_barang' => $this->input->post('kondisi_barang'),
      'keterangan' => $this->input->post('keterangan')
    );
    
    // Handle file upload
    if (!empty($_FILES['foto_barang']['name'])) {
      $config['upload_path'] = FCPATH . 'assets/foto/dupat/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['max_size'] = 2048;
      $config['file_name'] = 'dupat_' . $id_dtl_dupat . '_' . time();
      
      // Create directory if not exists
      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0755, true);
      }
      
      $this->upload->initialize($config);
      
      if ($this->upload->do_upload('foto_barang')) {
        $uploadData = $this->upload->data();
        $data['foto_barang'] = $uploadData['file_name'];
      }
    }
    
    $result = $this->DupatModel->updateDtlDupat($id_dtl_dupat, $data);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update item']);
    }
  }

  /**
   * Delete detail dupat
   */
  public function deleteDtlDupat()
  {
    $this->load->model('DupatModel');
    $id_dtl_dupat = $this->input->post('id_dtl_dupat');
    
    $result = $this->DupatModel->deleteDtlDupat($id_dtl_dupat);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////RUANGAN

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////STOCK OPNAME

  /**
   * Stock Opname PIC Asset - Main Page
   */
  public function StockOpnamePICAsset()
  {
    $this->load->model('StockOpnameModel');
    
    // Get filter values
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');
    
    // Get messages from session
    if ($this->session->userdata('tambah')) {
      $data['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
      $data['ubah'] = $this->session->userdata('ubah');
      $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    
    // Get data with or without filter
    if ($start_date || $end_date || $status_filter) {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpnameFiltered($start_date, $end_date, $status_filter);
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['status_filter'] = $status_filter;
    } else {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpname();
    }
    
    $data['activePage'] = 'StockOpname';
    $this->load->view('UI/PICAsset/StockOpname', $data);
  }

  /**
   * Save new stock opname session
   */
  public function saveStockOpnameSession()
  {
    $this->load->model('StockOpnameModel');
    
    $start_date = $this->input->post('so_start_date');
    
    // Generate document number
    $doc_number = $this->StockOpnameModel->generateDocumentNumber($start_date);
    
    $data = [
      'so_start_date' => $start_date,
      'so_end_date' => $start_date, // Same as start initially
      'so_pic' => $this->input->post('id_pengguna'),
      'so_deskripsi' => $this->input->post('so_deskripsi'),
      'so_document_number' => $doc_number,
      'so_status' => 'Draft',
      'so_total_item' => 0,
      'created_by' => $this->session->userdata('id'),
      'created_date' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->StockOpnameModel->saveStockOpname($data);
    
    if ($result) {
      $this->session->set_userdata('tambah', 'tambah');
    } else {
      $this->session->set_userdata('error', 'Failed to create session');
    }
    
    redirect(base_url('Functions/StockOpnamePICAsset'));
  }

  /**
   * Get stock opname by ID (AJAX)
   */
  public function getStockOpnameById()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    $data = $this->StockOpnameModel->getStockOpnameById($id);
    echo json_encode($data);
  }

  /**
   * Update stock opname session
   */
  public function updateStockOpnameSession()
  {
    $this->load->model('StockOpnameModel');
    
    $id = $this->input->post('so_id_opname');
    $data = [
      'so_start_date' => $this->input->post('so_start_date'),
      'so_pic' => $this->input->post('id_pengguna'),
      'so_deskripsi' => $this->input->post('so_deskripsi'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->StockOpnameModel->updateStockOpname($id, $data);
    
    if ($result) {
      $this->session->set_userdata('ubah', 'ubah');
    } else {
      $this->session->set_userdata('error', 'Failed to update session');
    }
    
    redirect(base_url('Functions/StockOpnamePICAsset'));
  }

  /**
   * Delete stock opname session (AJAX)
   */
  public function deleteStockOpnameSession()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    
    // Check if status is Draft
    $session = $this->StockOpnameModel->getStockOpnameById($id);
    if ($session->so_status != 'Draft') {
      echo json_encode(['status' => 'error', 'message' => 'Only Draft sessions can be deleted']);
      return;
    }
    
    $result = $this->StockOpnameModel->deleteStockOpname($id);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete session']);
    }
  }

  /**
   * Check stock opname items count (AJAX)
   */
  public function checkStockOpnameItems()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    $count = $this->StockOpnameModel->getItemCount($id);
    echo json_encode(['count' => (int)$count]);
  }

  /**
   * Send stock opname for approval (AJAX)
   */
  public function sendStockOpnameForApproval()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    
    if (empty($id)) {
      echo json_encode(['status' => 'error', 'message' => 'ID is empty']);
      return;
    }
    
    $result = $this->StockOpnameModel->updateStockOpnameStatus($id, 'On Progress Approval Koor UPT');
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to send for approval. DB Error: ' . $this->db->error()['message']]);
    }
  }

  /**
   * Stock Opname Detail Page
   */
  public function StockOpnameDetailPICAsset($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    // Get messages from session
    if ($this->session->userdata('update_success')) {
      $data['update_success'] = $this->session->userdata('update_success');
      $this->session->unset_userdata('update_success');
    }
    if ($this->session->userdata('delete_success')) {
      $data['delete_success'] = $this->session->userdata('delete_success');
      $this->session->unset_userdata('delete_success');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['items'] = $this->StockOpnameModel->getDtlStockOpnameByIdOpname($id_opname);
    $data['barang_list'] = $this->StockOpnameModel->getBarangList();
    $data['ruangan_list'] = $this->StockOpnameModel->getRuanganList();
    $data['penyimpanan_list'] = $this->StockOpnameModel->getPenyimpananList();
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['contributors'] = $this->StockOpnameModel->getContributorsByOpname($id_opname);
    // Get Koordinator UPT name
    $koorUPT = $this->db->query("SELECT nama_pengguna FROM pengguna WHERE role_pengguna = 'Koordinator UPT' AND status_pengguna = 'Aktif' LIMIT 1")->row();
    $data['koor_upt_name'] = $koorUPT ? $koorUPT->nama_pengguna : '';
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICAsset/StockOpnameDetail', $data);
  }

  /**
   * Add Item Stock Opname Page
   */
  public function AddItemStockOpnamePage($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    $data['so_id'] = $id_opname;
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['assets'] = $this->StockOpnameModel->getAvailableBarangForOpname($id_opname);
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['storages'] = $this->StockOpnameModel->getPenyimpananList();
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICAsset/AddItemStockOpname', $data);
  }

  /**
   * Save stock opname item (AJAX)
   */
  public function saveStockOpnameItem()
  {
    $this->load->model('StockOpnameModel');
    
    $data = [
      'so_id_opname' => $this->input->post('so_id_opname'),
      'id_barang' => $this->input->post('id_barang'),
      'id_ruangan' => $this->input->post('id_ruangan'),
      'id_penyimpanan' => $this->input->post('id_penyimpanan'),
      'so_quantity' => $this->input->post('so_quantity'),
      'kondisi_barang' => $this->input->post('kondisi_barang'),
      'keterangan_tambahan' => $this->input->post('keterangan_tambahan'),
      'created_by' => $this->session->userdata('id'),
      'created_date' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->StockOpnameModel->saveDtlStockOpname($data);
    
    if ($result) {
      // Update total item count
      $this->StockOpnameModel->updateTotalItem($this->input->post('so_id_opname'));
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to add item']);
    }
  }

  /**
   * Batch add items to stock opname
   */
  public function addItemsToStockOpnameBatch()
  {
    $this->load->model('StockOpnameModel');
    
    $so_id_opname = $this->input->post('so_id_opname');
    $items = $this->input->post('items');
    
    if (empty($items) || !is_array($items)) {
      echo json_encode(['status' => 'error', 'message' => 'No items provided']);
      return;
    }
    
    $successCount = 0;
    $errorMsg = '';
    
    // Upload config for photos
    $uploadPath = FCPATH . 'assets/foto/stockopname/';
    if (!is_dir($uploadPath)) {
      mkdir($uploadPath, 0755, true);
    }
    
    foreach ($items as $item) {
      // Check if item is array (with details) or just id
      if (is_array($item)) {
        $id_barang = $item['id_barang'];
        $id_ruangan = isset($item['id_ruangan']) && !empty($item['id_ruangan']) ? $item['id_ruangan'] : null;
        $id_penyimpanan = isset($item['id_penyimpanan']) && !empty($item['id_penyimpanan']) ? $item['id_penyimpanan'] : null;
        $so_quantity = isset($item['so_quantity']) && $item['so_quantity'] !== '' ? intval($item['so_quantity']) : 1;
        $kondisi_barang = isset($item['kondisi_barang']) && !empty($item['kondisi_barang']) ? $item['kondisi_barang'] : 'Good';
        $keterangan = isset($item['keterangan']) ? $item['keterangan'] : '';
        
        // Get original barang data for backup
        $barang = $this->StockOpnameModel->getBarangById($id_barang);
        
        // If location not provided, get from barang
        if (empty($id_ruangan) || empty($id_penyimpanan)) {
          if ($barang) {
            $id_ruangan = $id_ruangan ?: $barang->id_ruangan;
            $id_penyimpanan = $id_penyimpanan ?: $barang->id_penyimpanan;
          }
        }
      } else {
        // Simple id_barang only
        $id_barang = $item;
        $barang = $this->StockOpnameModel->getBarangById($id_barang);
        $id_ruangan = $barang ? $barang->id_ruangan : null;
        $id_penyimpanan = $barang ? $barang->id_penyimpanan : null;
        $so_quantity = 1;
        $kondisi_barang = $barang ? $barang->kondisi_barang : 'Good';
        $keterangan = '';
      }
      
      // Store original data for restore on delete
      $original_id_ruangan = $barang ? $barang->id_ruangan : $id_ruangan;
      $original_id_penyimpanan = $barang ? $barang->id_penyimpanan : $id_penyimpanan;
      $original_kondisi_barang = $barang ? $barang->kondisi_barang : 'Good';
      $original_jumlah_barang = $barang ? $barang->jumlah_barang : $so_quantity;
      
      // Skip item if location is not available (required fields)
      if (empty($id_ruangan) || empty($id_penyimpanan)) {
        $errorMsg = 'Item ' . $id_barang . ' tidak memiliki lokasi yang valid';
        continue;
      }
      
      // Handle photo upload
      $foto_filename = null;
      $foto_field = 'foto_' . $id_barang;
      if (isset($_FILES[$foto_field]) && $_FILES[$foto_field]['error'] == 0) {
        $ext = pathinfo($_FILES[$foto_field]['name'], PATHINFO_EXTENSION);
        $foto_filename = 'SO_' . $so_id_opname . '_' . $id_barang . '_' . time() . '.' . $ext;
        move_uploaded_file($_FILES[$foto_field]['tmp_name'], $uploadPath . $foto_filename);
      }
      
      // Check if item already exists in this stock opname
      $existing = $this->StockOpnameModel->getExistingItem($so_id_opname, $id_barang);
      
      if ($existing) {
        // Update existing item - replace qty, not add (keep original data)
        $updateData = [
          'so_quantity' => $so_quantity,
          'kondisi_barang' => $kondisi_barang,
          'keterangan_tambahan' => $keterangan,
          'id_ruangan' => $id_ruangan,
          'id_penyimpanan' => $id_penyimpanan,
          'modified_by' => $this->session->userdata('id'),
          'modified_date' => date('Y-m-d H:i:s')
        ];
        
        // Only update foto if new one uploaded
        if ($foto_filename) {
          $updateData['foto_barang'] = $foto_filename;
        }
        
        if ($this->StockOpnameModel->updateDtlStockOpname($existing->id_detail, $updateData)) {
          // Update barang table with new location and condition
          $this->StockOpnameModel->updateBarangFromStockOpname($id_barang, $id_ruangan, $id_penyimpanan, $so_quantity, $kondisi_barang);
          $successCount++;
        } else {
          $errorMsg = $this->db->error()['message'];
        }
      } else {
        // Insert new item with original data backup
        $data = [
          'so_id_opname' => $so_id_opname,
          'id_barang' => $id_barang,
          'id_ruangan' => $id_ruangan,
          'id_penyimpanan' => $id_penyimpanan,
          'original_id_ruangan' => $original_id_ruangan,
          'original_id_penyimpanan' => $original_id_penyimpanan,
          'original_kondisi_barang' => $original_kondisi_barang,
          'original_jumlah_barang' => $original_jumlah_barang,
          'so_quantity' => $so_quantity,
          'kondisi_barang' => $kondisi_barang,
          'keterangan_tambahan' => $keterangan,
          'foto_barang' => $foto_filename,
          'created_by' => $this->session->userdata('id'),
          'created_date' => date('Y-m-d H:i:s')
        ];
        
        if ($this->StockOpnameModel->saveDtlStockOpname($data)) {
          // Update barang table with new location and condition
          $this->StockOpnameModel->updateBarangFromStockOpname($id_barang, $id_ruangan, $id_penyimpanan, $so_quantity, $kondisi_barang);
          $successCount++;
        } else {
          $errorMsg = $this->db->error()['message'];
        }
      }
    }
    
    // Update total item count
    $this->StockOpnameModel->updateTotalItem($so_id_opname);
    
    if ($successCount > 0) {
      echo json_encode([
        'status' => 'success',
        'added' => $successCount,
        'message' => $successCount . ' items processed successfully'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Failed to add items. ' . $errorMsg
      ]);
    }
  }

  /**
   * Update stock opname item
   */
  public function updateStockOpnameItem()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    $id_ruangan = $this->input->post('id_ruangan');
    $id_penyimpanan = $this->input->post('id_penyimpanan');
    $so_quantity = $this->input->post('so_quantity');
    $kondisi_barang = $this->input->post('kondisi_barang');
    
    $data = [
      'id_ruangan' => $id_ruangan,
      'id_penyimpanan' => $id_penyimpanan,
      'so_quantity' => $so_quantity,
      'kondisi_barang' => $kondisi_barang,
      'keterangan_tambahan' => $this->input->post('keterangan_tambahan'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    // Handle file upload
    if (!empty($_FILES['foto_barang']['name'])) {
      $config['upload_path'] = FCPATH . 'assets/foto/stockopname/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = 2048;
      $config['file_name'] = 'SO_' . $id_detail . '_' . time();
      
      // Re-initialize upload library with new config
      $this->upload->initialize($config);
      
      if ($this->upload->do_upload('foto_barang')) {
        $upload_data = $this->upload->data();
        $data['foto_barang'] = $upload_data['file_name'];
      } else {
        // Log upload error for debugging
        log_message('error', 'Upload error: ' . $this->upload->display_errors('', ''));
      }
    }
    
    $result = $this->StockOpnameModel->updateDtlStockOpname($id_detail, $data);
    
    if ($result) {
      // Get id_barang from detail to sync with barang table
      $detail = $this->StockOpnameModel->getDetailById($id_detail);
      if ($detail) {
        // Sync changes to barang table (location, quantity, condition)
        $this->StockOpnameModel->updateBarangFromStockOpname(
          $detail->id_barang, 
          $id_ruangan, 
          $id_penyimpanan, 
          $so_quantity, 
          $kondisi_barang
        );
      }
      $this->session->set_userdata('update_success', 'update_success');
    } else {
      $this->session->set_userdata('error', 'Failed to update item');
    }
    
    redirect(base_url('Functions/StockOpnameDetailPICAsset/' . $id_opname));
  }

  /**
   * Delete stock opname item (AJAX)
   */
  public function deleteStockOpnameItem()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    
    // Get detail before delete to restore barang to original state
    $detail = $this->StockOpnameModel->getDetailById($id_detail);
    
    $result = $this->StockOpnameModel->deleteDtlStockOpname($id_detail);
    
    if ($result) {
      // Restore barang to original state when removed from stock opname
      if ($detail) {
        $this->StockOpnameModel->restoreBarangToOriginal($detail);
      }
      
      // Update total item count
      $this->StockOpnameModel->updateTotalItem($id_opname);
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
  }

  /**
   * Stock Opname PIC Lab - Main Page
   */
  public function StockOpnamePICLab()
  {
    $this->load->model('StockOpnameModel');
    
    // Get filter values
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');
    
    // Get data with or without filter
    if ($start_date || $end_date || $status_filter) {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpnameFiltered($start_date, $end_date, $status_filter);
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['status_filter'] = $status_filter;
    } else {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpname();
    }
    
    $data['activePage'] = 'StockOpname';
    $this->load->view('UI/PICLab/StockOpname', $data);
  }

  /**
   * Stock Opname Detail Page - PIC Lab
   */
  public function StockOpnameDetailPICLab($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    // Get messages from session
    if ($this->session->userdata('update_success')) {
      $data['update_success'] = $this->session->userdata('update_success');
      $this->session->unset_userdata('update_success');
    }
    if ($this->session->userdata('delete_success')) {
      $data['delete_success'] = $this->session->userdata('delete_success');
      $this->session->unset_userdata('delete_success');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['items'] = $this->StockOpnameModel->getDtlStockOpnameByIdOpname($id_opname);
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['penyimpanan_list'] = $this->StockOpnameModel->getPenyimpananList();
    $data['contributors'] = $this->StockOpnameModel->getContributorsByOpname($id_opname);
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICLab/StockOpnameDetail', $data);
  }

  /**
   * Add Item Stock Opname Page - PIC Lab
   */
  public function AddItemStockOpnamePagePICLab($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    $data['so_id'] = $id_opname;
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['assets'] = $this->StockOpnameModel->getAvailableBarangForOpname($id_opname);
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['storages'] = $this->StockOpnameModel->getPenyimpananList();
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICLab/AddItemStockOpname', $data);
  }

  /**
   * Stock Opname PIC Non Asset - Main Page
   */
  public function StockOpnamePICNonAsset()
  {
    $this->load->model('StockOpnameModel');
    
    // Get filter values
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');
    
    // Get data with or without filter
    if ($start_date || $end_date || $status_filter) {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpnameFiltered($start_date, $end_date, $status_filter);
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['status_filter'] = $status_filter;
    } else {
      $data['stockopname'] = $this->StockOpnameModel->getDataStockOpname();
    }
    
    $data['activePage'] = 'StockOpname';
    $this->load->view('UI/PICNonAsset/StockOpname', $data);
  }

  /**
   * Stock Opname Detail Page - PIC Non Asset
   */
  public function StockOpnameDetailPICNonAsset($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    // Get messages from session
    if ($this->session->userdata('update_success')) {
      $data['update_success'] = $this->session->userdata('update_success');
      $this->session->unset_userdata('update_success');
    }
    if ($this->session->userdata('delete_success')) {
      $data['delete_success'] = $this->session->userdata('delete_success');
      $this->session->unset_userdata('delete_success');
    }
    if ($this->session->userdata('error')) {
      $data['error'] = $this->session->userdata('error');
      $this->session->unset_userdata('error');
    }
    
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['items'] = $this->StockOpnameModel->getDtlStockOpnameByIdOpname($id_opname);
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['penyimpanan_list'] = $this->StockOpnameModel->getPenyimpananList();
    $data['contributors'] = $this->StockOpnameModel->getContributorsByOpname($id_opname);
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICNonAsset/StockOpnameDetail', $data);
  }

  /**
   * Add Item Stock Opname Page - PIC Non Asset
   */
  public function AddItemStockOpnamePagePICNonAsset($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    $data['so_id'] = $id_opname;
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['assets'] = $this->StockOpnameModel->getAvailableBarangForOpname($id_opname);
    $data['rooms'] = $this->StockOpnameModel->getRuanganList();
    $data['storages'] = $this->StockOpnameModel->getPenyimpananList();
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/PICNonAsset/AddItemStockOpname', $data);
  }

  /**
   * Update stock opname item - PIC Lab
   */
  public function updateStockOpnameItemPICLab()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    $id_ruangan = $this->input->post('id_ruangan');
    $id_penyimpanan = $this->input->post('id_penyimpanan');
    $so_quantity = $this->input->post('so_quantity');
    $kondisi_barang = $this->input->post('kondisi_barang');
    
    $data = [
      'id_ruangan' => $id_ruangan,
      'id_penyimpanan' => $id_penyimpanan,
      'so_quantity' => $so_quantity,
      'kondisi_barang' => $kondisi_barang,
      'keterangan_tambahan' => $this->input->post('keterangan_tambahan'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    if (!empty($_FILES['foto_barang']['name'])) {
      $config['upload_path'] = FCPATH . 'assets/foto/stockopname/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = 2048;
      $config['file_name'] = 'SO_' . $id_detail . '_' . time();
      $this->upload->initialize($config);
      if ($this->upload->do_upload('foto_barang')) {
        $upload_data = $this->upload->data();
        $data['foto_barang'] = $upload_data['file_name'];
      }
    }
    
    $result = $this->StockOpnameModel->updateDtlStockOpname($id_detail, $data);
    
    if ($result) {
      $detail = $this->StockOpnameModel->getDetailById($id_detail);
      if ($detail) {
        $this->StockOpnameModel->updateBarangFromStockOpname($detail->id_barang, $id_ruangan, $id_penyimpanan, $so_quantity, $kondisi_barang);
      }
      $this->session->set_userdata('update_success', 'update_success');
    } else {
      $this->session->set_userdata('error', 'Failed to update item');
    }
    
    redirect(base_url('Functions/StockOpnameDetailPICLab/' . $id_opname));
  }

  /**
   * Delete stock opname item - PIC Lab (AJAX)
   */
  public function deleteStockOpnameItemPICLab()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    
    $detail = $this->StockOpnameModel->getDetailById($id_detail);
    $result = $this->StockOpnameModel->deleteDtlStockOpname($id_detail);
    
    if ($result) {
      if ($detail) {
        $this->StockOpnameModel->restoreBarangToOriginal($detail);
      }
      $this->StockOpnameModel->updateTotalItem($id_opname);
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
  }

  /**
   * Update stock opname item - PIC Non Asset
   */
  public function updateStockOpnameItemPICNonAsset()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    $id_ruangan = $this->input->post('id_ruangan');
    $id_penyimpanan = $this->input->post('id_penyimpanan');
    $so_quantity = $this->input->post('so_quantity');
    $kondisi_barang = $this->input->post('kondisi_barang');
    
    $data = [
      'id_ruangan' => $id_ruangan,
      'id_penyimpanan' => $id_penyimpanan,
      'so_quantity' => $so_quantity,
      'kondisi_barang' => $kondisi_barang,
      'keterangan_tambahan' => $this->input->post('keterangan_tambahan'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    if (!empty($_FILES['foto_barang']['name'])) {
      $config['upload_path'] = FCPATH . 'assets/foto/stockopname/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['max_size'] = 2048;
      $config['file_name'] = 'SO_' . $id_detail . '_' . time();
      $this->upload->initialize($config);
      if ($this->upload->do_upload('foto_barang')) {
        $upload_data = $this->upload->data();
        $data['foto_barang'] = $upload_data['file_name'];
      }
    }
    
    $result = $this->StockOpnameModel->updateDtlStockOpname($id_detail, $data);
    
    if ($result) {
      $detail = $this->StockOpnameModel->getDetailById($id_detail);
      if ($detail) {
        $this->StockOpnameModel->updateBarangFromStockOpname($detail->id_barang, $id_ruangan, $id_penyimpanan, $so_quantity, $kondisi_barang);
      }
      $this->session->set_userdata('update_success', 'update_success');
    } else {
      $this->session->set_userdata('error', 'Failed to update item');
    }
    
    redirect(base_url('Functions/StockOpnameDetailPICNonAsset/' . $id_opname));
  }

  /**
   * Delete stock opname item - PIC Non Asset (AJAX)
   */
  public function deleteStockOpnameItemPICNonAsset()
  {
    $this->load->model('StockOpnameModel');
    
    $id_detail = $this->input->post('id_detail');
    $id_opname = $this->input->post('so_id_opname');
    
    $detail = $this->StockOpnameModel->getDetailById($id_detail);
    $result = $this->StockOpnameModel->deleteDtlStockOpname($id_detail);
    
    if ($result) {
      if ($detail) {
        $this->StockOpnameModel->restoreBarangToOriginal($detail);
      }
      $this->StockOpnameModel->updateTotalItem($id_opname);
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
  }

  /**
   * Stock Opname Koor UPT - Main Page (excludes Draft status)
   */
  public function StockOpnameKoorUPT()
  {
    $this->load->model('StockOpnameModel');
    
    // Get filter values
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $status_filter = $this->input->post('status_filter');
    
    // Get data with or without filter (excludes Draft)
    $data['stockopname'] = $this->StockOpnameModel->getDataStockOpnameFilteredKoorUPT($start_date, $end_date, $status_filter);
    $data['start_date'] = $start_date;
    $data['end_date'] = $end_date;
    $data['status_filter'] = $status_filter;
    
    $data['activePage'] = 'StockOpname';
    $this->load->view('UI/KoordinatorUPT/StockOpname', $data);
  }

  /**
   * Stock Opname Detail Page - Koor UPT
   */
  public function StockOpnameDetailKoorUPT($id_opname)
  {
    $this->load->model('StockOpnameModel');
    
    $data['session'] = $this->StockOpnameModel->getStockOpnameById($id_opname);
    $data['items'] = $this->StockOpnameModel->getDtlStockOpnameByIdOpname($id_opname);
    // Get contributors (PICs who added items) for PDF
    $data['contributors'] = $this->StockOpnameModel->getContributorsByOpname($id_opname);
    // Get Koordinator UPT name
    $koorUPT = $this->db->query("SELECT nama_pengguna FROM pengguna WHERE role_pengguna = 'Koordinator UPT' AND status_pengguna = 'Aktif' LIMIT 1")->row();
    $data['koor_upt_name'] = $koorUPT ? $koorUPT->nama_pengguna : '';
    $data['activePage'] = 'StockOpname';
    
    $this->load->view('UI/KoordinatorUPT/StockOpnameDetail', $data);
  }

  /**
   * Approve Stock Opname - Koor UPT (AJAX)
   */
  public function approveStockOpnameKoorUPT()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    
    $data = [
      'so_status' => 'Approved',
      'so_end_date' => date('Y-m-d'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->StockOpnameModel->updateStockOpname($id, $data);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to approve stock opname']);
    }
  }

  /**
   * Reject Stock Opname - Koor UPT (AJAX)
   * When rejected, items return to available list but detail records are kept for history
   */
  public function rejectStockOpnameKoorUPT()
  {
    $this->load->model('StockOpnameModel');
    $id = $this->input->post('so_id_opname');
    $reject_reason = $this->input->post('reject_reason');
    
    // Get all detail items to restore barang to original state
    $details = $this->StockOpnameModel->getDtlStockOpnameByIdOpname($id);
    
    // Restore all barang to original state
    foreach ($details as $detail) {
      $this->StockOpnameModel->restoreBarangToOriginal($detail);
    }
    
    // DO NOT delete detail items - keep them for history/audit trail
    // Items will return to available list because query only checks current session
    
    // Update stock opname status to Rejected
    $data = [
      'so_status' => 'Rejected',
      'so_reject_reason' => $reject_reason,
      'so_end_date' => date('Y-m-d'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y-m-d H:i:s')
    ];
    
    $result = $this->StockOpnameModel->updateStockOpname($id, $data);
    
    if ($result) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to reject stock opname']);
    }
  }

  /**
   * Get Available Barang for Stock Opname - AJAX (Server-side DataTables)
   * Used by PIC Lab Add Item Stock Opname page
   */
  public function getAvailableBarangAjax()
  {
    $this->load->model('StockOpnameModel');
    
    // DataTables parameters
    $draw = intval($this->input->post('draw'));
    $start = intval($this->input->post('start'));
    $length = intval($this->input->post('length'));
    $search = $this->input->post('search')['value'] ?? '';
    
    // Custom filters
    $so_id_opname = $this->input->post('so_id_opname');
    $ruangan = $this->input->post('ruangan');
    $kondisi = $this->input->post('kondisi');
    
    // Get PIC Lab's NPK to filter by their managed rooms
    $npk = $this->session->userdata('id');
    
    // Get paginated data filtered by PIC Lab's rooms
    $result = $this->StockOpnameModel->getAvailableBarangForOpnamePaginatedPICLab($so_id_opname, $start, $length, $search, $ruangan, $kondisi, $npk);
    
    // Format data for DataTables
    $data = [];
    $no = $start + 1;
    foreach ($result['data'] as $row) {
      $data[] = [
        'no' => $no++,
        'id_barang' => $row->id_barang,
        'nama_barang' => $row->nama_barang,
        'nomor_aktiva' => $row->nomor_aktiva,
        'gambar_barang' => $row->gambar_barang,
        'kategori_barang' => $row->kategori_barang,
        'tipe_barang' => $row->tipe_barang,
        'kondisi_barang' => $row->kondisi_barang,
        'jumlah_barang' => $row->jumlah_barang,
        'nama_ruangan' => $row->nama_ruangan,
        'nama_penyimpanan' => $row->nama_penyimpanan,
        'id_ruangan' => $row->id_ruangan,
        'id_penyimpanan' => $row->id_penyimpanan
      ];
    }
    
    $response = [
      'draw' => $draw,
      'recordsTotal' => $result['total'],
      'recordsFiltered' => $result['filtered'],
      'data' => $data
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////SOP



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////ADMIN
