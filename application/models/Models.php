<?php defined('BASEPATH') or exit('No direct script access allowed');

class Models extends CI_Model
{
  ///////////////////////////////////////////////TABLE
  private $tableadmin = "tb_admin";
  private $tablebarang = "tb_barang";
  private $tablejenisruangan = "tb_jenis_ruangan";
  private $tableruangan = "tb_ruangan";
  private $tablesop = "tb_sop";
  private $tablegaleri = "tb_galeri";
  private $tablefasilitas = "tb_fasilitas";


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////DASHBOARD
  public function getruangBarangAktif()
  {
    $query = $this->db->query("SELECT COUNT(id_barang) AS jumlahbarang ,(SELECT COUNT(id_ruangan) AS jumlahruangan FROM tb_ruangan WHERE status = 1) AS jumlahruangan FROM tb_barang WHERE status = 1");

    return $query->result();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////ADMIN

  public function getadmin()
  {
    $query = $this->db->query("select username, password, nama, nohp,email,foto, role, status  from tb_admin where status != 0");

    return $query->result();
  }
  public function findAdmin($username)
  {
    $query = $this->db->query("select username, password, nama, nohp,email,foto, role, status  from tb_admin where username = '$username' AND status ='1'");
    if ($query->result()) {
      return true;
    } else {
      return false;
    }
  }

  public function saveadmin($data)
  {
    return $this->db->insert($this->tableadmin, $data);
  }
  public function hapusadmin($id)
  {
    $this->db->where(array('username' => $id));
    return $this->db->update($this->tableadmin, array('status' => "0"));
  }

  public function editadmin()
  {
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoE']['name'];

    if ($new_image == TRUE) {
      $update_filename = time() . "-" . str_replace(' ', '-', $_FILES['fotoE']['name']);
      $config['upload_path'] = './assets/foto/admin/';
      $config['allowed_types'] = 'jpg|png|gif|jpeg';
      $config['file_name'] = $update_filename;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('fotoE')) {
        if (file_exists("./assets/foto/admin/" . $old_image)) {
          unlink("./assets/foto/admin/" . $old_image);
        }
      }
    } else {
      $update_filename = $old_image;
    }

    $data = array(
      'password' => $this->input->post('passwordAdminE'),
      'nama' => $this->input->post('namaAdminE'),
      'nohp' => $this->input->post('noTelpAdminE'),
      'email' => $this->input->post('emailAdminE'),
      'foto' => $update_filename,
      'status' => $this->input->post('statusAdminE'),
      'role' => $this->input->post('roleAdminE')
    );

    $where = array(
      'username' => $this->input->post('usernameAdminE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tableadmin, $data);
  }

  //////////////////////////////////////////////////////////////////////////////////////Jenis Ruangan
  public function getjenisruangan()
  {
    $query = $this->db->query("select id_jenis_ruangan, nama_jenis_ruangan from tb_jenis_ruangan where status=1");

    return $query->result();
  }

  public function savejenisruangan($data)
  {
    return $this->db->insert($this->tablejenisruangan, $data);
  }

  public function editjenisruangan()
  {

    $post = $this->input->post();
    $data = array(
      'nama_jenis_ruangan' => $this->input->post('namaJenisRuanganE'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_jenis_ruangan' => $this->input->post('idJenisRuanganE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tablejenisruangan, $data);
  }
  public function deleteRuangan($id)
  {
    $post = $this->input->post();
    $data = array(
      'status' => 0,
    );

    $where = array(
      'id_jenis_ruangan' => $id,      
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $this->db->where($where);
    return $this->db->update($this->tablejenisruangan, $data);
  }

  public function deleteRuangan2($id)
  {
    $data = array(
      'status' => 0,
    );

    $where = array(
      'id_ruangan' => $id,
    );

    $this->db->where($where);
    return $this->db->update($this->tableruangan, $data);
  }

  public function getruangan()
  {
    $query = $this->db->query("SELECT a.id_ruangan, a.status, a.id_jenis_ruangan, a.nama_ruangan ,a.lokasi_ruangan,  a.pic_lab,b.nama_jenis_ruangan, a.kapasitas_ruangan FROM tb_ruangan as a join tb_jenis_ruangan as b on a.id_jenis_ruangan = b.id_jenis_ruangan
    where a.status='1'");

    return $query->result();
  }

  public function getDataJenisRuangan()
  {
    $query = $this->db->query('SELECT * FROM tb_jenis_ruangan where status = "1"');
    return $query->result();
  }

  ///////////////////////////////////////////////////////////////////////////// BARANG

  public function getDataBarang()
  {
    $query = $this->db->query("SELECT * FROM tb_barang where status != '0'");
    return $query->result();
  }

  public function savebarang($data)
  {
    return $this->db->insert($this->tablebarang, $data);
  }

  public function editbarang()
  {
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoE']['name'];

    if ($new_image == TRUE) {
      $update_filename = time() . "-" . str_replace('', '-', $_FILES['fotoE']['name']);
      $config['upload_path'] = './assets/foto/barang/';
      $config['allowed_types'] = 'jpg|png|gif|jpeg';
      $config['file_name'] = $update_filename;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('fotoE')) {
        if (file_exists("./assets/foto/barang/" . $old_image)) {
          unlink("./assets/foto/barang" . $old_image);
        }
      }
    } else {
      $update_filename = $old_image;
    }
    $format = "%Y-%m-%d";
    $user = $this->session->userdata('id');
    echo "<script>console.log('Debug Objects: " . $user . "' );</script>";
    $data = array(
      'nama_barang' => $this->input->post('namaBarangE'),
      'nomor_aktiva' => $this->input->post('nomorAktivaE'),
      'jumlah' => $this->input->post('totalBarangE'),
      'satuan_barang' => $this->input->post('satuanBarangE'),
      'kondisi_barang' => $this->input->post('kondisiBarangE'),
      'lokasi_barang' => $this->input->post('lokasiBarangE'),
      'baris_lokasi' => $this->input->post('barisLokasiE'),
      'gambar_barang' => $update_filename,
      'status' => $this->input->post('statusBarangE'),
      'modified_by' => $user,
      'modified_date' => mdate($format)
    );

    $where = array(
      'id_barang' => $this->input->post('idBarangE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tablebarang, $data);
  }

  public function deletebarang($idBarang)
  {
    $data = array(
      'status' => "0",
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_barang' => $idBarang,
    );

    $this->db->where($where);
    return $this->db->update($this->tablebarang, $data);
  }


  ///////////////////////////////////////////////////////////////////////////// RUANGAN

  public function getDetailRuangan($id)
  {
    $query = $this->db->query("SELECT a.*,b.nama_jenis_ruangan FROM tb_ruangan as a join tb_jenis_ruangan as b on a.id_jenis_ruangan = b.id_jenis_ruangan where a.id_ruangan = $id");
    return $query->result();
  }
  public function getGaleri($id)
  {
    $query = $this->db->query("SELECT b.* FROM tb_ruangan AS a INNER JOIN tb_galeri AS b ON a.id_ruangan = b.id_ruangan WHERE b.id_ruangan = $id");
    return $query->result();
  }
  public function getFasilitasDetail($id)
  {
    $query = $this->db->query("SELECT b.*,a.nama_fasilitas,a.gambar_fasilitas FROM tb_fasilitas AS a INNER JOIN tb_detil_fasilitas AS b ON a.id_fasilitas = b.id_fasilitas WHERE b.id_ruangan = $id");
    return $query->result();
  }
  public function getDatausername()
  {
    $query = $this->db->query('SELECT username,nama  FROM admin where role = 1 ');
    return $query->result();
  }

  public function idRuangan()
  {
    $query = $this->db->query("SELECT AUTO_INCREMENT AS id FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'peminjaman_ruangan1' AND TABLE_NAME = 'tb_ruangan'");
    return $query->result_array();
  }

  public function saveruangan($data)
  {
    $this->db->insert($this->tableruangan, $data);
    return $this->db->insert_id();
  }
  public function savedetailFasilitas($dataFasilitas){
    //GET ID PACKAGE
    $package_id = $this->db->insert_id();
    $result = array();
    foreach($dataFasilitas AS $key => $val){
      $result[] = array(
        'id_ruangan'     => $package_id,
        'id_fasilitas'   => $_POST['fasilitas'][$key]
          );
    }      
    //MULTIPLE INSERT TO DETAIL TABLE                  
    $this->db->insert_batch('tb_detil_fasilitas', $result);
  }
  public function insertImage($data = array())
  {
    if (!empty($data)) {
        // Insert gallery data 
        $insert = $this->db->insert_batch($this->tablegaleri, $data);

        // Return the status 
        return $insert ? $this->db->insert_id() : false;
      }
    return false;
  }

  public function editdetailfasilitas()
  {
    // hapus data by id ruangan
    $id = $this->input->post('idRuanganE');
    $where = array('id_ruangan' => $id);
    $this->db->where($where);
    $this->db->delete('tb_detil_fasilitas');
    // insert ulang
    $dataFasilitas = $this->input->post('fasilitas', TRUE);
    $result = array();
    foreach($dataFasilitas AS $key => $val){
      $result[] = array(
        'id_ruangan'     => $id,
        'id_fasilitas'   => $_POST['fasilitas'][$key]
          );
    }      
    //MULTIPLE INSERT TO DETAIL TABLE                  
    $this->db->insert_batch('tb_detil_fasilitas', $result);
  }
  public function editruangan()
  {
    // $post = $this->input->post();
    // $old_image = $this->input->post('fotoRuanganO');
    // $new_image = $_FILES['fotoRuanganE']['name'];

    // if ($new_image == TRUE) {
    //   $update_filename = time() . "-" . str_replace(' ', '-', $_FILES['fotoRuanganE']['name']);
    //   $config['upload_path'] = './assets/foto/ruangan/';
    //   $config['allowed_types'] = 'jpg|png|gif|jpeg';
    //   $config['file_name'] = $update_filename;

    //   $this->load->library('upload', $config);

    //   if ($this->upload->do_upload('fotoRuanganE')) {
    //     if (file_exists("./assets/foto/ruangan/" . $old_image)) {
    //       unlink("./assets/foto/ruangan/" . $old_image);
    //     }
    //   }
    // } else {
    //   $update_filename = $old_image;
    // }
    $data = array(
      'nama_ruangan' => $this->input->post('namaRuanganE'),
      'id_jenis_ruangan' => $this->input->post('jenisRuanganE'),
      'lokasi_ruangan' => $this->input->post('lokasiRuanganE'),
      'kapasitas_ruangan' => $this->input->post('kapasitasE'),
      'koor_upt' => $this->input->post('koorE'),
      'pic_lab' => $this->input->post('picRuanganE'),
      'admin_lab1' => $this->input->post('AdminLab1E'),
      'admin_lab2' => $this->input->post('AdminLab2E'),
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d')
    );
    $id = $this->input->post('idRuanganE');
    // echo "<script>console.log('Debug Objects: " . $id . "' );</script>";
    $where = array(
      'id_ruangan' => $id
    );

    $this->db->where($where);
    return $this->db->update($this->tableruangan, $data);
  }
  public function editGaleri(){
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoRuanganE']['name'];

    if ($new_image == TRUE) {
      $update_filename = $_FILES['fotoRuanganE']['name'];
      $config['upload_path'] = './assets/foto/ruangan/';
      $config['allowed_types'] = 'jpg|png|gif|jpeg';
      $config['file_name'] = $update_filename;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('fotoRuanganE')) {
        if (file_exists("./assets/foto/ruangan/" . $old_image)) {
          unlink("./assets/foto/ruangan/" . $old_image);
        }
      }
    } else {
      $update_filename = $old_image;
    }
    $data = array(
      'foto' => $update_filename
    );

    $where = array(
      'id_galeri' => $this->input->post('idGaleriEG')
    );

    $this->db->where($where);
    return $this->db->update($this->tablegaleri, $data);
  }

  public function deleteGaleri($idG){
    $where = array(
      'id_galeri' => $idG,
    );

    $this->db->where($where);
    $this->db->delete("tb_galeri");
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Fasilitas
  
  public function getfasilitas()
  {
    $query = $this->db->query("select id_fasilitas, nama_fasilitas, gambar_fasilitas, status from tb_fasilitas where status = 1");
    return $query->result();
  }
  public function findFasilitas($nama_fasilitas)
  {
    $query = $this->db->query("select nama_fasilitas, gambar_fasilitas , status  from tb_fasilitas where nama_fasilitas = '$nama_fasilitas'");
    if ($query->result()) {
      return true;
    } else {
      return false;
    }
  }

  public function savefasilitas($data)
  {
    return $this->db->insert($this->tablefasilitas, $data);
  }
  public function hapusfasilitas($id_fasilitas)
  {
    $data = array(
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d'),
      'status' => 0
    );
    $this->db->where(array('id_fasilitas' => $id_fasilitas));
    return $this->db->update($this->tablefasilitas, $data);
  }

  public function editfasilitas()
  {
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoE']['name'];

    if ($new_image == TRUE) {
      $update_filename = time() . "-" . str_replace(' ', '-', $_FILES['fotoE']['name']);
      $config['upload_path'] = './assets/foto/fasilitas/';
      $config['allowed_types'] = 'jpg|png|gif|jpeg';
      $config['file_name'] = $update_filename;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('fotoE')) {
        if (file_exists("./assets/foto/fasilitas/" . $old_image)) {
          unlink("./assets/foto/fasilitas/" . $old_image);
        }
      }
    } else {
      $update_filename = $old_image;
    }

    $data = array(
      'nama_fasilitas' => $this->input->post('namaFasilitasE'),
      'gambar_fasilitas' => $update_filename,
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d')
    );

    $where = array(
      'id_fasilitas' => $this->input->post('idFasilitasE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tablefasilitas, $data);
  }


  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// SOP
  public function idSOP()
  {
    $query = $this->db->query("select `AUTO_INCREMENT` as id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'peminjaman_ruangan' AND TABLE_NAME = 'tb_sop';");
    return $query->result();
  }

  public function getsop()
  {
    $query = $this->db->query("select id_sop, nama_sop, file_sop from tb_sop where status=1");

    return $query->result();
  }

  public function deletesop($id)
  {
    $data = array(
      'status' => 0,
      'modif_by' => $this->session->userdata('id'),
      'modif_date' => date('Y/m/d')
    );

    $where = array(
      'id_sop' => $id,
    );

    $this->db->where($where);
    return $this->db->update($this->tablesop, $data);
  }

  public function savesop($data)
  {
    return $this->db->insert($this->tablesop, $data);
  }

  public function editsop()
  {

    $post = $this->input->post();
    $data = array(
      'nama_sop' => $this->input->post('deskripsi'),
      'modif_date' => date('Y/m/d'),
      'modif_by' => $this->session->userdata('id'),
    );

    $where = array(
      'id_sop' => $this->input->post('idsop'),
    );

    $this->db->where($where);
    return $this->db->update($this->tablesop, $data);
  }

  public function savegaleri($data)
  {
    return $this->db->insert($this->tablegaleri, $data);
  }

  public function getDataFasilitas()
  {
    $query = $this->db->query("select * from tb_fasilitas where status =1");

    return $query->result();
  }
  public function UbahPassword()
  {
    $post = $this->input->post();
    $data = array(
      'password' => $this->input->post('password')
    );
    $where = array(
      'username' => $this->input->post('username')
    );
    $this->db->where($where);
    return $this->db->update($this->tableadmin, $data);
  }
}
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////Login



///////////////////////////////////////////////////////////////////////////////////
