<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
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
        $this->load->model('peminjaman_model');
        $this->load->model('PeminjamanModel');
        $this->load->model('RuanganModels');
        $this->load->model('models');
        $this->load->helper('url', 'form');
    }


    public function index()
    {
        $this->load->view('UI/Mahasiswa/header');
        $this->load->view('UI/Mahasiswa/Form');
        $this->load->view('UI/Mahasiswa/footer');
    }
    public function tambahKeranjang() {
        $this->load->model('PeminjamanModel');
        $this->load->model('BarangModel');
        $id_barang = $this->input->post('id_barang');
        $nim = $this->input->post('nim');
        $jumlah = $this->input->post('jumlah');
        // Ambil stok dari tabel barang
        $stok = $this->BarangModel->get_stok_barang($id_barang);

        // Hitung jumlah total yang sudah ada di keranjang untuk barang ini
        $jumlah_di_keranjang = $this->PeminjamanModel->get_jumlah_barang($id_barang, $nim);

        $total_permintaan = $jumlah + $jumlah_di_keranjang;
        if ($total_permintaan > $stok) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Jumlah melebihi stok barang (' . $stok . ')'
            ]);
            return;
        }
        // Simpan ke database
        $this->PeminjamanModel->add_to_cart($id_barang, $nim, $jumlah);

        // Ambil total item dalam keranjang untuk badge
        $total = $this->PeminjamanModel->get_total_items($nim);

        echo json_encode(['total_items' => $total]);
    }
    public function getStatusLog() {
        $id_dtl_peminjaman = $this->input->post('id_dtl_peminjaman');
        $this->load->model('PeminjamanModel');
        $result = $this->PeminjamanModel->getStatusLogById($id_dtl_peminjaman);

        // Format waktu jika mau:
        foreach($result as &$row) {
            $row->waktu_approval = date('d M Y H:i', strtotime($row->waktu_approval));
        }

        echo json_encode($result);
    }

    public function get_summary() {
        header('Content-Type: application/json');
        if(isset($_COOKIE['nim'])){
            $nim = $_COOKIE['nim'];
            $this->load->model('PeminjamanModel');
            $summary = $this->PeminjamanModel->get_summary($nim);

            echo json_encode($summary);
        }
    }
    public function update_keranjang() {
      $id_cart = $this->input->post('id_cart');
      $jumlah = $this->input->post('jumlah');

      $cart = $this->db->get_where('keranjang', ['id_keranjang' => $id_cart])->row();
      $barang = $this->db->get_where('barang', ['id_barang' => $cart->barang])->row();

      if ($jumlah > $barang->jumlah_barang) {
        echo json_encode(['status' => 'error', 'message' => 'Stok tidak mencukupi']);
        return;
      }

      if ($jumlah < 1) {
        echo json_encode(['status' => 'error', 'message' => 'Jumlah minimal 1']);
        return;
      }

      $this->db->update('keranjang', ['jumlah' => $jumlah], ['id_keranjang' => $id_cart]);
      echo json_encode(['status' => 'success']);
    }
    public function hapus_keranjang() {
      $id_keranjang = $this->input->post('id_keranjang');
      echo $id_keranjang;
      $this->load->model('PeminjamanModel');
      $hapusData = $this->PeminjamanModel->hapus_keranjang($id_keranjang);
      echo json_encode(['status' => 'success']);
    }

    public function simpan()
    {
        $this->load->helper('date');
        $mulai = $this->input->post('mulai_peminjaman');
        $selesai = $this->input->post('selesai_peminjaman');
        $this->load->library('user_agent');
        // Validasi tanggal
        $today = date('Y-m-d');
        if ($mulai < $today) {
            $this->session->set_userdata('error', 'The loan start date cannot be less than today!');
            redirect($this->agent->referrer());
            return;
        }

        if ($selesai < $mulai) {
            $this->session->set_userdata('error', 'The finish date must be greater than the start date!');
            redirect($this->agent->referrer());
            return;
        }
        $status_peminjaman = 'On Progress Approval PIC';
        
        $data_peminjam = [
            'nama_peminjam'         => $this->input->post('nama_peminjam', TRUE),
            'nim_peminjam'          => $this->input->post('nim_peminjam', TRUE),
            'tanggal_peminjam'      => date('Y-m-d'),
            'keperluan_peminjaman'  => $this->input->post('keperluan_peminjaman', TRUE),
            'mulai_peminjaman'      => $this->input->post('mulai_peminjaman', TRUE),
            'selesai_peminjaman'    => $this->input->post('selesai_peminjaman', TRUE),
            'status_peminjaman'     => $status_peminjaman // default status
        ];

        // Data detail (array)
        $config['upload_path'] = FCPATH . 'assets\foto\Peminjaman';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        
        $id_barang          = $this->input->post('id_barang');
        $jumlah_peminjaman  = $this->input->post('jumlah_peminjaman');
        $satuan_barang      = $this->input->post('satuan_barang');
        $kondisi_barang     = $this->input->post('kondisi_barang');
        $gambar_sebelum     = $this->input->post('gambar_sebelum');
        $kategori_barang     = $this->input->post('kategori_barang');


        $data_detail = [];
        for ($i = 0; $i < count($id_barang); $i++) {
            $foto = NULL;

            // Cek apakah ada file yang diupload untuk index ke-i
            if (!empty($_FILES['gambar_sebelum']['name'][$i])) {
                $_FILES['file']['name']     = $_FILES['gambar_sebelum']['name'][$i];
                $_FILES['file']['type']     = $_FILES['gambar_sebelum']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['gambar_sebelum']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['gambar_sebelum']['error'][$i];
                $_FILES['file']['size']     = $_FILES['gambar_sebelum']['size'][$i];

                // Nama file yang rapi
                $file_ext     = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename     = preg_replace('/\s+/', '_', $this->input->post('nama_peminjam')) . '_' . $id_barang[$i] . '_' . date('Ymd') . '_Foto.' . $file_ext;
                $config['file_name'] = $filename;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                } else {
                    // Tampilkan error per file
                    echo '<pre>';
                    print_r(array('error' => $this->upload->display_errors()));
                    echo '</pre>';
                }
            }
            $status_barang = '';
            if(trim(strtolower($kategori_barang[$i])) == 'asset'){
                $status_barang = 'On Progress Approval PIC Asset';
            }else{
                $status_barang = 'On Progress Approval PIC Non Asset';
            }
            $data_detail[] = [
                'id_barang'           => $id_barang[$i],
                'jumlah_peminjaman'   => $jumlah_peminjaman[$i],
                'satuan_barang'       => $satuan_barang[$i],
                'kondisi_barang'      => $kondisi_barang[$i],
                'gambar_sebelum'      => $foto,
                'gambar_sesudah'      => NULL,
                'tanggal_pengembalian'=> NULL,
                'status_barang'       => $status_barang,
            ];
        }
        // Simpan ke database
        $this->PeminjamanModel->simpan_peminjaman($data_peminjam, $data_detail);

        // Hapus data dari keranjang berdasarkan nim dan id_barang yang sudah diproses
        $this->load->model('PeminjamanModel');
        foreach ($id_barang as $i => $id) {
            $this->PeminjamanModel->hapus_keranjang_by_nim_barang($data_peminjam['nim_peminjam'], $id);
        }

        //Selesai add kasih buat tanda selesai add
        $this->session->set_userdata('tambah', 'tambah');
        redirect(base_url('./Dashboard/index'));
    }


    public function peminjaman($idRuangan)
    {
        $nim = $this->input->post('nim');
        $nama = $this->input->post('peminjam');
        $tanggal = $this->input->post('tanggal');
        $mulaiPinjam = $this->input->post('mulaiPinjam');
        $selesaiPinjam = $this->input->post('selesaiPinjam');
        $jumlah_pengguna = $this->input->post('jumlahPengguna');
        $keperluan = $this->input->post('keperluan');
        $status = 1;
        $created_by = 1;
        $formatDate = "%Y-%m-%d %H:%i:%s";
        $created_date = date("Y-m-d H:i:s");

        if($mulaiPinjam >= $selesaiPinjam)
        {
            echo '<script>alert("Mulai Pinjam Lebih dari Selesai Pinjam!");</script>';
            $this->load->view('UI/Mahasiswa/Form');
        }
        else
        {
            if($this->checkAvailable($idRuangan, $tanggal, $mulaiPinjam, $selesaiPinjam))
            {
                $arrInsert = array(
                    'nama_peminjam' => $nama,
                    'nim_peminjam' => $nim,
                    'id_ruangan' => $idRuangan,
                    'tanggal' => $tanggal,
                    'mulai_pinjam' => $mulaiPinjam,
                    'selesai_pinjam' => $selesaiPinjam,
                    'jumlah_pengguna' => $jumlah_pengguna,
                    'keperluan' => $keperluan,
                    'status' => $status,
                    'created_by' => $created_by,
                    'created_date' => $created_date
                );
                // var_dump($arrInsert);
                // exit();
                $this->load->database();
                $this->peminjaman_model->insert($arrInsert);
                redirect(base_url('Dashboard/index'));
            }
            else
            {
                echo '<script>alert("Ruangan tidak tersedia!");</script>';
                
                $this->load->view('UI/Mahasiswa/Form');
            }
        }
    }

    public function checkAvailable($id, $tanggal, $mulaiPinjam, $selesaiPinjam)
    {
        $ruangan = $this->peminjaman_model->checkAvailable($id, $tanggal);
        $length = count($ruangan);
        if ($length != 0)
        {
            for ($i = 0;$i < $length;$i++)
            {
                if (($mulaiPinjam >= $ruangan[$i]->mulai_pinjam && $mulaiPinjam <= $ruangan[$i]->selesai_pinjam) || ($selesaiPinjam >= $ruangan[$i]->mulai_pinjam && $ruangan[$i]->selesai_pinjam))
                {
                    return false;
                } 
                else 
                {
                    return true;
                }
            }
        }
        else
        {
            return true;
        }
    }
    
    



    ////OLD
    public function UpdateBarangSebelum(){
        $id = $this->input->post('id_Peminjaman');
        $config['upload_path'] = FCPATH . '/assets/foto/riwayat_barang';
        $config['allowed_types'] = 'zip|jpeg|jpg|png';
        $config['max_size'] = 2000;
        $foto = explode(".",$_FILES['foto']['name']);
        $ext = end($foto);
        // check if file is zip exension
        print_r($ext);
        if($ext == 'zip'){
            $new_name = time() . '-' . $this->input->post('nim') . '-' . $this->input->post('id_Peminjaman') . '.zip';
        }else{
            $new_name = time() . '-' . $this->input->post('nim') . '-' . $this->input->post('id_Peminjaman') . '.png';
        }
        $config['file_name'] = $new_name;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('foto')){
            $error = array('error' => $this->upload->display_errors());
            $Data['error'] = $error;
            $Data['path'] = FCPATH . 'assets/foto/riwayat_barang';
            $Data['sukses'] = 2;
        }else{
            $data = array('image_metadata' => $this->upload->data());
            $uploaded_data = $this->upload->data();
            $foto = $uploaded_data['file_name'];
            $Data['sukses'] = $this->PeminjamanModel->updateBarangSebelum($id,$foto);
        }
        redirect(base_url('Dashboard/RiwayatPeminjamanBarang'));
    }
    public function UpdateBarangSetelah(){
        // Fungsi untuk input foto setelah dan update status peminjaman barang
        $id = $this->input->post('id_Peminjaman');  
        $config['upload_path'] = FCPATH . '/assets/foto/riwayat_barang';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 2000;
        $new_name = time() . '-' . $this->input->post('nim') . '-' . $this->input->post('id_Peminjaman') . '.png';
        $config['file_name'] = $new_name;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('foto_setelah')){
            $error = array('error' => $this->upload->display_errors());
            $Data['error'] = $error;
            $Data['path'] = FCPATH . 'assets/foto/riwayat_barang';
            $Data['sukses'] = 2;
        }else{
            $data = array('image_metadata' => $this->upload->data());
            $uploaded_data = $this->upload->data();
            $foto = $uploaded_data['file_name'];
            $Data['sukses'] = $this->PeminjamanModel->updateBarangSetelah($id,$foto);
        }
        redirect(base_url('Dashboard/RiwayatPeminjamanBarang'));
    }
    public function UpdateStok(){
        // Fungsi untuk menambah stok
        $id = $this->input->post('id_Peminjaman');
        // get detil barang lempar ke ajax trs jalanin function tambahstok
        $barang = $this->models->getdetilBarang($id);  
        echo json_encode($barang);
    }
}