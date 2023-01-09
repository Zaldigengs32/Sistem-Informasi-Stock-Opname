<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Functions extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("models");
    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
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

  public function Dashboard()
  {
    $getData["getData"] = $this->models->getruangBarangAktif();
    $getData["activePage"] = "Dashboard";
    $this->load->view('UI/Dashboard', $getData);
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
    $getData["getData"] = $this->models->getadmin();
    $getData["activePage"] = "Admin";
    $this->load->view('UI/Admin', $getData);
  }

  public function saveadmin()
  {
    $findAdmin = $this->models->findAdmin($this->input->post('usernameAdmin'));
    if ($findAdmin) {
      //validasi username tidak boleh sama
      $this->session->set_userdata('duplicate','duplicate');
    } else {
      $config['upload_path']          = FCPATH . 'assets\foto\admin';
      $config['allowed_types']        = 'jpg|jpeg|png|gif';
      $config['max_size']             = 0; //no limit, Usually 2 MB (2048 kb)
      $config['max_width']            = 0;
      $config['max_height']           = 0;
      $foto = $_FILES['foto']['name'];
      $add_filename = $this->input->post('usernameAdmin') . preg_replace('/\s+/', '_', $foto);
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
      $this->session->set_userdata('tambah','tambah');
    }
    redirect(base_url('./Functions/Admin'));
  }

  public function editadmin()
  {
    $this->models->editadmin();
    $this->session->set_userdata('ubah','ubah');
    redirect(base_url('./Functions/Admin'));
  }

  public function hapusAdmin($id)
  {
    $this->models->hapusadmin($id);
    $this->session->set_userdata('hapus','hapus');
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
    $data['barang'] = $this->models->getDataBarang();
    $data["activePage"] = "Barang";
    $this->load->view('UI/Barang', $data);
  }

  public function savebarang()
  {
    $config['upload_path']          = FCPATH . 'assets\foto\Barang';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width']            = 0;
    $config['max_height']           = 0;
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
    echo "<script>console.log('Debug Objects: " . $user . "' );</script>";
    $data = array(
      'nama_barang' => $this->input->post('namaBarang'),
      'nomor_aktiva' => $this->input->post('nomorAktiva'),
      'jumlah' => $this->input->post('totalBarang'),
      'satuan_barang' => $this->input->post('satuanBarang'),
      'kondisi_barang' => $this->input->post('kondisiBarang'),
      'lokasi_barang' => $this->input->post('lokasiBarang'),
      'baris_lokasi' => $this->input->post('barisLokasi'),
      'gambar_barang' => $foto,
      'status' => '1',
      'created_by' => $user,
      'created_date' => mdate($format),
      'modified_by' => $user,
      'modified_date' => mdate($format)
    );
    $insert = $this->models->savebarang($data);
    $this->session->set_userdata('tambah','tambah');
    redirect(base_url('./Functions/Barang'));
  }

  public function editbarang()
  {
    $this->models->editbarang();
    $this->session->set_userdata('ubah','ubah');  
    redirect(base_url('./Functions/Barang'));
  }

  public function deletebarang($idBarang)
  {
    $this->models->deletebarang($idBarang);
    $this->session->set_userdata('hapus','hapus');  
    redirect(base_url('./Functions/Barang'));
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////JENIS RUANGAN

  public function JenisRuangan()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambahh')) {
        $getDataJenisRuangan['tambah'] = $this->session->userdata('tambahh');
        $this->session->unset_userdata('tambahh');
    }
    if ($this->session->userdata('ubahh')) {
        $getDataJenisRuangan['ubah'] = $this->session->userdata('ubahh');
        $this->session->unset_userdata('ubahh');
    }
    if ($this->session->userdata('hapuss')) {
      $getDataJenisRuangan['hapus'] = $this->session->userdata('hapuss');
      $this->session->unset_userdata('hapuss');
    }
    $getDataJenisRuangan["getData"] = $this->models->getjenisruangan();
    $getDataJenisRuangan["activePage"] = "JenisRuangan";
    $this->load->view('UI/JenisRuangan', $getDataJenisRuangan);
  }

  public function savejenisruangan()
  {
    $user = $this->session->userdata('id');
    $data = array(
      'nama_jenis_ruangan' => $this->input->post('namaJenisRuangan'),
      'status' => 1,
      'created_by' => $user,
      'created_date' => date('Y/m/d'),
      'modified_by' => $user,
      'modified_date' => date('Y/m/d')
    );

    $insert = $this->models->savejenisruangan($data);
    $this->session->set_userdata('tambahh','tambah');  
    redirect(base_url('./Functions/JenisRuangan'));
  }

  public function editjenisruangan()
  {
    $this->models->editjenisruangan();
    $this->session->set_userdata('ubahh','ubah');  
    redirect(base_url('./Functions/JenisRuangan'));
  }
  public function deleteJenisRuangan($id)
  {
    $insert = $this->models->deleteRuangan($id);
    $this->session->set_userdata('hapuss','hapus');  
    redirect(base_url('./Functions/JenisRuangan'));
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
      $getRuangan["getData"] = $this->models->getruangan();
      $getRuangan['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
      $getRuangan['getDataFasilitas'] = $this->models->getDataFasilitas();
      $getRuangan["activePage"] = "Ruangan";
      $this->load->view('UI/Ruangan', $getRuangan);
  }

  public function saveruangan()
  {
    $new_name = "";

    $getdata["data"] = $this->models->idruangan();
    // foreach ($getdata as $data) {
    //   $new_name = $data[0]['id'];
    // };
    // if (file_exists("ruangan/" . $new_name . '_1.png')) {
    //   unlink("ruangan/" . $new_name . "_1.png");
    // }
    // if (file_exists("ruangan/" . $new_name . '_2.png')) {
    //   unlink("ruangan/" . $new_name . "_2.png");
    // }
    // if (file_exists("ruangan/" . $new_name . '_3.png')) {
    //   unlink("ruangan/" . $new_name . "_3.png");
    // }
    // //debug
    // var_dump($new_name);

    // Fasilitas dimasukkan ke dalam detail fasilitas, kolom di fasilitas dihilangkan
    $data = array(
      'id_ruangan' => $new_name,
      'nama_ruangan' => $this->input->post('namaRuangan'),
      'lokasi_ruangan' => $this->input->post('lokasiRuangan'),
      'kapasitas_ruangan' => $this->input->post('kapasitas'),
      'id_jenis_ruangan' => $this->input->post('jenisRuangan'),
      // 'id_sop' => $this->input->post('sop'),
      'koor_upt' => $this->input->post('koor'),
      'pic_lab' => $this->input->post('pic'),
      'admin_lab1' => $this->input->post('AdminLab1'),
      'admin_lab2' => $this->input->post('AdminLab2'),
      'created_date' => date('Y/m/d'),
      'created_by' => $this->session->userdata('id'),
      'status' => '1',
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d')
    );
    var_dump($data);
    $dataFasilitas = $this->input->post('fasilitas', TRUE);
    $insert = $this->models->saveruangan($data);
    $Ruanganid = $insert;
    $this->models->savedetailFasilitas($dataFasilitas);
    if (!empty($_FILES['fotoRuangan']['name'])) {
        $filesCount = count($_FILES['fotoRuangan']['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['file']['name']     = $_FILES['fotoRuangan']['name'][$i];
            $_FILES['file']['type']     = $_FILES['fotoRuangan']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['fotoRuangan']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['fotoRuangan']['error'][$i];
            $_FILES['file']['size']     = $_FILES['fotoRuangan']['size'][$i];

            // File upload configuration 
            $uploadPath = 'assets/foto/ruangan';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';

            // Load and initialize upload library 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server 
            if ($this->upload->do_upload('file')) {
                // Uploaded file data 
                $fileData = $this->upload->data();
                $uploadData[$i]['id_ruangan'] = $Ruanganid;
                $uploadData[$i]['foto'] = $fileData['file_name'];
            } else {
                $errorUpload .= $fileImages[$key] . '(' . $this->upload->display_errors('', '') . ') | ';
            }
        }

        // File upload error message 
        $errorUpload = !empty($errorUpload) ? ' Upload Error: ' . trim($errorUpload, ' | ') : '';

        if (!empty($uploadData)) {
            // Insert files info into the database 
            $insert = $this->models->insertImage($uploadData);
        }
    }
    $this->session->set_userdata('tambah','tambah');  
    redirect(base_url('./Functions/Ruangan'));
  }
  public function tambahGaleri(){
    $idRuangan = $this->input->post('idRuanganT');
    if (!empty($_FILES['fotoRuanganT']['name'])) {
        $filesCount = count($_FILES['fotoRuanganT']['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['file']['name']     = $_FILES['fotoRuanganT']['name'][$i];
            $_FILES['file']['type']     = $_FILES['fotoRuanganT']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['fotoRuanganT']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['fotoRuanganT']['error'][$i];
            $_FILES['file']['size']     = $_FILES['fotoRuanganT']['size'][$i];

            // File upload configuration 
            $uploadPath = 'assets/foto/ruangan';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';

            // Load and initialize upload library 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server 
            if ($this->upload->do_upload('file')) {
                // Uploaded file data 
                $fileData = $this->upload->data();
                $uploadData[$i]['id_ruangan'] = $idRuangan;
                $uploadData[$i]['foto'] = $fileData['file_name'];
            } else {
                $errorUpload .= $fileImages[$key] . '(' . $this->upload->display_errors('', '') . ') | ';
            }
        }

        // File upload error message 
        $errorUpload = !empty($errorUpload) ? ' Upload Error: ' . trim($errorUpload, ' | ') : '';

        if (!empty($uploadData)) {
            // Insert files info into the database 
            $insert = $this->models->insertImage($uploadData);
        }
    }
      $getData["getData"] = $this->models->getDetailRuangan($idRuangan);
      $getData['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
      $getData['getDataFasilitas'] = $this->models->getDataFasilitas();
      $getData['getDataDetilFasilitas'] = $this->models->getFasilitasDetail($idRuangan);
      $getData["getFoto"] = $this->models->getGaleri($idRuangan);
      $getData["tambah"] = true;
      $getData["activePage"] = "Ruangan";
      return $this->load->view('UI/DetailRuangan', $getData);
  }
  public function editGaleri()
  {
    if ($this->models->editGaleri()) {
      // not efective
      $id = $this->input->post('idRuanganEG');
      $getData["getData"] = $this->models->getDetailRuangan($id);
      $getData['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
      $getData['getDataFasilitas'] = $this->models->getDataFasilitas();
      $getData['getDataDetilFasilitas'] = $this->models->getFasilitasDetail($id);
      $getData["getFoto"] = $this->models->getGaleri($id);
      $getData["ubah"] = true;
      $getData["activePage"] = "Ruangan";
      return $this->load->view('UI/DetailRuangan', $getData);
    }
  }

  public function deleteGaleri($idR){ 
      //id Ruangan array 1, id Galeri array 2
      $id = explode("-",$idR);
      echo "<script>console.log('Debug Objects: " . $id[0] . "' );</script>";
      echo "<script>console.log('Debug Objects: " . $id[1] . "' );</script>";
      $this->models->deleteGaleri($id[1]);
      $getData["getData"] = $this->models->getDetailRuangan($id[0]);
      $getData['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
      $getData['getDataFasilitas'] = $this->models->getDataFasilitas();
      $getData['getDataDetilFasilitas'] = $this->models->getFasilitasDetail($id[0]);
      $getData["getFoto"] = $this->models->getGaleri($id[0]);
      $getData["hapus"] = true;
      $getData["activePage"] = "Ruangan";
      return $this->load->view('UI/DetailRuangan', $getData);
    
  }

  public function editruangan()
  {
    if ($this->models->editRuangan()) {
      $this->models->editdetailfasilitas();
      // not efective
      $id = $this->input->post('idRuanganE');
      $getData["getData"] = $this->models->getDetailRuangan($id);
      $getData['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
      $getData['getDataFasilitas'] = $this->models->getDataFasilitas();
      $getData['getDataDetilFasilitas'] = $this->models->getFasilitasDetail($id);
      $getData["getFoto"] = $this->models->getGaleri($id);
      $getData["ubah"] = true;
      $getData["activePage"] = "Ruangan";
      return $this->load->view('UI/DetailRuangan', $getData);
    }
  }

  public function deleteRuangan($idRuangan)
  {
    $insert = $this->models->deleteRuangan2($idRuangan);
    $this->session->set_userdata('hapus','hapus');  
    redirect(base_url('./Functions/Ruangan'));
  }

  public function detailRuangan($id)
  {
    $getData["getData"] = $this->models->getDetailRuangan($id);
    $getData['getDataJenisRuangan'] = $this->models->getDataJenisRuangan();
    $getData['getDataFasilitas'] = $this->models->getDataFasilitas();
    $getData['getDataDetilFasilitas'] = $this->models->getFasilitasDetail($id);
    $getData["getFoto"] = $this->models->getGaleri($id);
    $getData["activePage"] = "Ruangan";
    $this->load->view('UI/DetailRuangan', $getData);
  }
  ////////////////////////////////////////////////////////////////////////// FASILITAS

  public function Fasilitas()
  {
    // Get messages from the session 
    if ($this->session->userdata('tambah')) {
      $getFasilitas['tambah'] = $this->session->userdata('tambah');
      $this->session->unset_userdata('tambah');
    }
    if ($this->session->userdata('ubah')) {
        $getFasilitas['ubah'] = $this->session->userdata('ubah');
        $this->session->unset_userdata('ubah');
    }
    if ($this->session->userdata('hapus')) {
      $getFasilitas['hapus'] = $this->session->userdata('hapus');
      $this->session->unset_userdata('hapus');
    }
    $getFasilitas["getData"] = $this->models->getfasilitas();
    $getFasilitas["activePage"] = "Fasilitas";
    $this->load->view('UI/Fasilitas', $getFasilitas);
  }

  public function savefasilitas()
  {
    $config['upload_path']          = FCPATH . 'assets\foto\fasilitas';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 0; //no limit, Usually 2 MB (2048 kb)
    $config['max_width']            = 0;
    $config['max_height']           = 0;
    $foto = $_FILES['foto']['name'];
    $add_filename = $this->input->post('namaFasilitas') . $_FILES['foto']['name'];
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
      'nama_fasilitas' => $this->input->post('namaFasilitas'),
      'gambar_fasilitas' => $foto,
      'created_date' => date('Y/m/d'),
      'created_by' => $this->session->userdata('id'),
      'status' => '1',
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d')
    );

    $insert = $this->models->savefasilitas($data);
    $this->session->set_userdata('tambah','tambah');  
    redirect(base_url('./Functions/Fasilitas'));
  }

  public function editfasilitas()
  {
    if($this->models->editfasilitas()){
      $this->session->set_userdata('ubah','ubah');  
      redirect(base_url('./Functions/Fasilitas'));
    }
  }

  public function hapusFasilitas($id)
  {
    $this->models->hapusFasilitas($id);
    $this->session->set_userdata('hapus','hapus');  
    redirect(base_url('./Functions/Fasilitas'));
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////SOP

  public function sop()
  {
    $getData["getData"] = $this->models->getsop();
    $getData["activePage"] = "SOP";
    $this->load->view('UI/SOP', $getData);
  }

  public function savesop()
  {
    $config['upload_path']          = './upload/';
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 10000;
    $config['file_name'] = $_FILES['file']['name'];;
    $new_name = $_FILES['file']['name'];
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file')) {
      $message = "File must be in .pdf extension and less than 10mb";
      echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
      $data = array('upload_data' => $this->upload->data());
      $this->load->view('upload_success', $data);

      $data2 = array(
        'nama_sop' => $this->input->post('deskripsi'),
        'file_sop' => $new_name,
        'status' => '1',
        'created_date' => date('Y/m/d'),
        'created_by' => $this->input->post('nama')
      );

      $insert = $this->models->savesop($data2);
      redirect(base_url('./Functions/SOP'));
    }
  }

  public function deleteSOP($idSOP)
  {
    $insert = $this->models->deletesop($idSOP);
    $getData["getData"] = $this->models->getsop();
    $getData["activePage"] = "SOP";
    $getData["hapus"] = true;
    $this->load->view('UI/SOP', $getData);
  }

  public function editsop()
  {
    $new_name = $this->input->post('idsop') . '.pdf';
    $getData["getData"] = $this->models->idSOP();

    $config['upload_path']          = './upload/';
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 10000;
    $config['file_name'] = $this->input->post('idsop');
    $file = $this->input->post('idsop');
    unlink("upload/" . $new_name);

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file')) {
      $message = "File must be in .pdf extension and less than 10mb";
      echo "<script type='text/javascript'>alert('$message');</script>";
    } else {

      $data2 = array(
        'id_sop' => $this->input->post('idsop'),
        'nama_sop' => $this->input->post('deskripsi'),
        'file_sop' => $new_name . '.pdf',
        'modif_date' => date('Y/m/d'),
        'modif_by' => $this->input->post('nama')
      );

      $insert = $this->models->editsop($data2);
      redirect(base_url('./Functions/SOP'));
    }
  }
  public function viewpdf(){
    $fname = $this->uri->segment(3);
    $tofile= base_url().'upload/'.$fname;
    header('Content-Type: application/pdf');
    readfile($tofile);
  }
  public function resetPassword()
  {
    $this->models->UbahPassword();
    redirect(base_url('./Functions/Dashboard'));
  }

  // public function index()
  // {
  // 	$data = array(
  // 		'list_data'	=> $this->ImportModel->getData()
  // 	);
  // 	$this->load->view('import.php',$data);
  // }

  // public function import_excel(){
  // 	if (isset($_FILES["fileExcel"]["name"])) {
  // 		$path = $_FILES["fileExcel"]["tmp_name"];
  // 		$object = PHPExcel_IOFactory::load($path);
  // 		foreach($object->getWorksheetIterator() as $worksheet)
  // 		{
  // 			$highestRow = $worksheet->getHighestRow();
  // 			$highestColumn = $worksheet->getHighestColumn();	
  // 			for($row=2; $row<=$highestRow; $row++)
  // 			{
  // 				$nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
  // 				$temp_data[] = array(
  // 					'nama_barang'	=> $nama
  // 				); 	
  // 			}
  // 		}
  // 		$this->load->model('ImportModel');
  // 		$insert = $this->ImportModel->insert($temp_data);
  // 		if($insert){
  // 			$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
  // 			redirect($_SERVER['HTTP_REFERER']);
  // 		}else{
  // 			$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
  // 			redirect($_SERVER['HTTP_REFERER']);
  // 		}
  // 	}else{
  // 		echo "Tidak ada file yang masuk";
  // 	}
  // }



  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////RUANGAN

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////SOP



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////ADMIN
