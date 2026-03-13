<?php defined('BASEPATH') or exit('No direct script access allowed');

class Models extends CI_Model
{
  ///////////////////////////////////////////////TABLE
  private $tableadmin = "pengguna";
  private $tablebarang = "barang";
  private $tableruangan = "ruangan";
  private $tablepenyimpanan = "penyimpanan";
  private $tabledetailruanganpenyimpanan = "dtl_ruangan_penyimpanan";
  private $tabledetailpeminjamanbarang = "dtl_peminjaman_barang";


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////DASHBOARD
  public function getCountAktif()
  {
    $query = $this->db->query("SELECT COUNT(id_barang) AS jumlahbarang ,
    (SELECT COUNT(id_ruangan) AS jumlahruangan FROM tb_ruangan WHERE status = 1) AS jumlahruangan, 
    (SELECT COUNT(id_peminjaman) FROM tb_peminjaman WHERE status = 'Pengajuan') AS pengajuan_ruangan, 
    (SELECT COUNT(id_peminjaman_barang) FROM tb_peminjaman_barang WHERE status = 'Pengajuan') AS pengajuan_barang 
    FROM tb_barang WHERE status = 1");
    return $query->result();
  }
  public function ChartRuangan()
  {
    $query = $this->db->query("SELECT a.id_ruangan,b.nama_ruangan,MONTHNAME(NOW()) AS bulan,count(a.id_peminjaman) AS Jumlah 
    FROM tb_peminjaman AS a INNER JOIN tb_ruangan AS b ON a.id_ruangan = b.id_ruangan WHERE MONTH(a.tanggal)=MONTH(NOW()) 
    AND a.status = 'Selesai' GROUP BY a.id_ruangan LIMIT 3");
    return $query->result();
  }
  public function ChartBarang()
  {
    $query = $this->db->query("SELECT a.id_barang,b.nama_barang,MONTHNAME(NOW()) AS bulan,count(a.id_peminjaman_barang) AS Jumlah 
    FROM detail_barang AS a INNER JOIN barang AS b ON a.id_barang = b.id_barang INNER JOIN peminjaman_barang AS c ON a.id_peminjaman_barang = c.id_peminjaman_barang WHERE MONTH(c.tanggal)=MONTH(NOW()) 
    AND c.status = 'Selesai' GROUP BY a.id_barang LIMIT 3");
    return $query->result();
  }
  public function PieChart()
  {
    $query = $this->db->query("SELECT (SELECT COUNT(*) FROM (SELECT a.selesai_pinjam FROM tb_peminjaman AS a WHERE a.selesai_pinjam 
    BETWEEN '18:00:00' AND '21:00:00' UNION ALL SELECT b.selesai_pinjam FROM tb_peminjaman_barang AS b WHERE b.selesai_pinjam BETWEEN '18:00:00' 
    AND '21:00:00') tbl2) AS `Malam`, COUNT(*) AS `Pagi` FROM (SELECT a.selesai_pinjam FROM tb_peminjaman AS a WHERE a.selesai_pinjam 
    BETWEEN '08:00:00' AND '18:00:00' UNION ALL SELECT b.selesai_pinjam FROM tb_peminjaman_barang AS b WHERE b.selesai_pinjam BETWEEN '08:00:00' 
    AND '18:00:00') tbl1;");
    return $query->result();
  }
  public function FilterChartRuangan($filter)
  {
    $query = $this->db->query("SELECT a.id_ruangan,b.nama_ruangan,MONTHNAME('$filter-01') AS bulan,count(a.id_peminjaman) AS Jumlah 
    FROM tb_peminjaman AS a INNER JOIN tb_ruangan AS b ON a.id_ruangan = b.id_ruangan WHERE DATE_FORMAT(a.tanggal,'%Y-%m')= '$filter' 
    AND a.status = 'Selesai' GROUP BY a.id_ruangan LIMIT 3");
    return $query->result();
  }
  public function FilterChartBarang($filter)
  {
    $query = $this->db->query("SELECT a.id_barang,b.nama_barang,MONTHNAME('$filter-01') AS bulan,count(a.id_peminjaman_barang) AS Jumlah 
    FROM tb_detail_barang AS a INNER JOIN tb_barang AS b ON a.id_barang = b.id_barang INNER JOIN tb_peminjaman_barang AS c ON a.id_peminjaman_barang = c.id_peminjaman_barang WHERE DATE_FORMAT(c.tanggal,'%Y-%m')='$filter' 
    AND c.status = 'Selesai' GROUP BY a.id_barang LIMIT 3");
    return $query->result();
  }
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////Pengguna

  public function getpengguna()
  {
    $query = $this->db->query("select * from pengguna where status_pengguna = 'Aktif'");

    return $query->result();
  }

  public function idAdmin()
  {
    $query = $this->db->query("select `AUTO_INCREMENT` as id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'peminjaman_ruangan1' AND TABLE_NAME = 'tb_admin';");
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
  public function getPenggunaByNamaPengguna($nama, $id){
    $query = $this->db->query("SELECT A.id_pengguna FROM pengguna as A where A.nama_pengguna = '".$nama."' AND A.status_pengguna ='Aktif' AND A.id_pengguna!='".$id."';");
    if ($query->num_rows() > 0) {
        return $query->row()->id_pengguna; // Mengembalikan satu nilai string
    } else {
        return null;
    }
  }
  public function savepengguna($data)
  {
    return $this->db->insert($this->tableadmin, $data);
  }
  public function hapuspengguna($id)
  {
    $this->db->where(array('id_pengguna' => $id));
    return $this->db->update($this->tableadmin, array('status_pengguna' => "Tidak Aktif"));
  }

  public function editpengguna()
  {
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoE']['name'];

    if ($new_image == TRUE) {
      $file_ext = pathinfo($new_image, PATHINFO_EXTENSION);
      $update_filename = preg_replace('/\s+/', '_', $this->input->post('namaPenggunaE')) . '_Foto.' . $file_ext;
      $config['upload_path'] = FCPATH . 'assets\foto\admin';
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['max_size'] = 0; //no limit, Usually 2 MB (2048 kb)
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      $config['file_name'] = $update_filename;
      $this->upload->initialize($config);
      if (file_exists("./assets/foto/Tim/" . $old_image)) {
        unlink("./assets/foto/Tim/" . $old_image);
        $this->upload->do_upload('fotoE');
      }
    } else {
      $update_filename = $old_image;
    }

    $data = array(
      'id_pengguna' => $this->input->post('idPenggunaE'),
      'nama_pengguna' => $this->input->post('namaPenggunaE'),
      'email_pengguna' => $this->input->post('emailPenggunaE'),
      'username_pengguna' => $this->input->post('usernamePenggunaE'),
      'password_pengguna' => $this->input->post('passwordPenggunaE'),
      'role_pengguna' => $this->input->post('rolePenggunaE'),
      'main_job' => $this->input->post('mainJobE'),
      'other_job' => $this->input->post('otherJobE'),
      'foto' => $update_filename,
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_pengguna' => $this->input->post('idPenggunaE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tableadmin, $data);
  }

  //////////////////////////////////////////////////////////////////////////////////////Detail Ruangan Penyimpanan
  public function getDataDetailPenyimpanan($ruangan, $penyimpanan){
    $query = $this->db->query("SELECT A.id_dtl_penyimpanan FROM dtl_ruangan_penyimpanan as A where A.id_ruangan = $ruangan AND A.id_penyimpanan = $penyimpanan AND A.status_detail ='Aktif';");
    if ($query->num_rows() > 0) {
        return $query->row()->id_dtl_penyimpanan; // Mengembalikan satu nilai string
    } else {
        return null;
    }
  }
  public function savedetailruangan($data)
  {
    return $this->db->insert($this->tabledetailruanganpenyimpanan, $data);
  }
  public function editdetailruangan()
  {
    $data = array(
      'id_ruangan' => $this->input->post('id_ruanganE'),
      'id_penyimpanan' => $this->input->post('penyimpananE'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );
    $id = $this->input->post('idDetailRuanganE');
    // echo "<script>console.log('Debug Objects: " . $id . "' );</script>";
    $where = array(
      'id_dtl_penyimpanan' => $id
    );

    $this->db->where($where);
    return $this->db->update($this->tabledetailruanganpenyimpanan, $data);
  }
  public function deletedetailruangan($dtl_ruangan_penyimpanan)
  {
    $data = array(
      'status_detail' => "Tidak Aktif",
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_dtl_penyimpanan' => $dtl_ruangan_penyimpanan,
    );

    $this->db->where($where);
    return $this->db->update($this->tabledetailruanganpenyimpanan, $data);
  }
  /////////////////////////////////////////////////////////////////////////////BARANG

  public function getDataBarang()
  {
    // Inventory shows all active items - Stock Opname updates barang data directly
    // Only exclude items in active Mutasi or Dupat (Draft/On Progress)
    $sql = "SELECT A.id_barang, A.nama_barang, A.nomor_aktiva, A.tipe_barang, A.jumlah_barang, A.jumlah_optimum, A.jumlah_minimum, A.satuan_barang, A.kondisi_barang, A.gambar_barang, A.kategori_barang, A.keterangan_penyimpanan, C.id_ruangan, C.nama_ruangan, D.nama_penyimpanan, D.id_penyimpanan, A.ketersediaan_barang 
            FROM barang as A 
            LEFT JOIN dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan 
            LEFT JOIN ruangan as C ON B.id_ruangan = C.id_ruangan 
            LEFT JOIN penyimpanan as D ON D.id_penyimpanan = B.id_penyimpanan 
            WHERE A.status_barang = 'Aktif'
            AND A.id_barang NOT IN (
                SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT')
            )
            AND A.id_barang NOT IN (
                SELECT dd.id_barang FROM siso_msdtldupat dd 
                INNER JOIN siso_msdupat d ON dd.id_dupat = d.id_dupat 
                WHERE d.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT')
            )";
    $query = $this->db->query($sql);
    return $query->result();
  }
  
  public function getDataBarangFilter($nama_ruangan='', $nama_penyimpanan='', $nama_kategori='', $nama_tipe='', $kondisi_barang='', $status_barang='' )
  {
    // Inventory filter shows all active items - Stock Opname updates barang data directly
    // Only exclude items in active Mutasi or Dupat (Draft/On Progress)
    $sql = "SELECT A.id_barang, A.nama_barang, A.nomor_aktiva, A.tipe_barang, A.jumlah_barang, A.jumlah_optimum, A.jumlah_minimum, A.satuan_barang, A.kondisi_barang, A.gambar_barang, A.kategori_barang, A.keterangan_penyimpanan, C.id_ruangan, C.nama_ruangan, D.nama_penyimpanan, D.id_penyimpanan, A.ketersediaan_barang 
            FROM barang as A 
            LEFT JOIN dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan 
            LEFT JOIN ruangan as C ON B.id_ruangan = C.id_ruangan 
            LEFT JOIN penyimpanan as D ON D.id_penyimpanan = B.id_penyimpanan 
            WHERE A.status_barang = 'Aktif'
            AND A.id_barang NOT IN (
                SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT')
            )
            AND A.id_barang NOT IN (
                SELECT dd.id_barang FROM siso_msdtldupat dd 
                INNER JOIN siso_msdupat d ON dd.id_dupat = d.id_dupat 
                WHERE d.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT')
            )";
    if($nama_ruangan!=''){
      $sql .= " AND C.nama_ruangan LIKE '%".$nama_ruangan."%' ";
    }
    if($nama_penyimpanan!=''){
      $sql .= " AND D.nama_penyimpanan LIKE '%".$nama_penyimpanan."%' ";
    }
    if($nama_kategori!=''){
      $sql .= " AND A.kategori_barang = '".$nama_kategori."' ";
    }
    if($nama_tipe!=''){
      $sql .= " AND A.tipe_barang = '".$nama_tipe."' ";
    }
    
    if($kondisi_barang!=''){
       $sql .= " AND A.kondisi_barang LIKE '%".$kondisi_barang."%' ";
    }
    if($status_barang!=''){
       $sql .= " AND A.ketersediaan_barang LIKE '%".$status_barang."%' ";
    }
    $query = $this->db->query($sql);
    return $query->result();
  }
  
  public function savebarang($data)
  {
    return $this->db->insert($this->tablebarang, $data);
  }

  public function editbarang($dtl_ruangan_penyimpanan)
  {
    $post = $this->input->post();
    $old_image = $this->input->post('fotoO');
    $new_image = $_FILES['fotoE']['name'];

    if ($new_image == TRUE) {
      $update_filename = preg_replace('/\s+/', '_', $new_image);
      $config['upload_path'] = './assets/foto/Barang/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['max_size'] = 0; //no limit, Usually 2 MB 2048 kb)
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      // Ambil nomor aktiva dan bersihkan spasi
    $nomorAktiva = str_replace(' ', '_', $this->input->post('nomorAktivaE'));

    // Ambil ekstensi file asli
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // Buat nama file berdasarkan nomor aktiva
    $cleanFileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $nomorAktiva); // buang karakter aneh
    $finalFileName = $cleanFileName . '.' . $ext;
    $config['file_name'] = $finalFileName;

      $this->upload->initialize($config);

      if ($this->upload->do_upload('fotoE')) {
        if (file_exists("./assets/foto/barang/" . $old_image)) {
          unlink("./assets/foto/barang" . $old_image);
        }
      }
    } else {
      $update_filename = $old_image;
    }
    $ketersediaan_barang = 'Available';
    if($this->input->post('totalBarangE') ==0){
      $ketersediaan_barang = 'Not Available';
    }

    $data= array();
    if($this->input->post('kategoriBarangE') == 'Non Asset'){
      $data = array(
        'nama_barang' => $this->input->post('namaBarangE'),
        'nomor_aktiva' => $this->input->post('nomorAktivaE'),
        'jumlah_barang' => $this->input->post('totalBarangE'),
        'jumlah_optimum' => $this->input->post('totalBarangOptimumE'),
        'jumlah_minimum' => $this->input->post('totalBarangMinimumE'),
        'satuan_barang' => $this->input->post('satuanBarangE'),
        'kondisi_barang' => $this->input->post('kondisiBarangE'),
        'kategori_barang' => $this->input->post('kategoriBarangE'),
        'tipe_barang' => $this->input->post('tipeBarangE'),
        'id_dtl_penyimpanan' => $dtl_ruangan_penyimpanan,
        'keterangan_penyimpanan' => $this->input->post('keteranganLokasiE'),
        'ketersediaan_barang' => $ketersediaan_barang,
        'gambar_barang' => $finalFileName,
        'modified_by' => $this->session->userdata('id'),
        'modified_date' => date('Y/m/d')
      );
    }else{
      $data = array(
        'nama_barang' => $this->input->post('namaBarangE'),
        'nomor_aktiva' => $this->input->post('nomorAktivaE'),
        'jumlah_barang' => $this->input->post('totalBarangE'),
        'jumlah_optimum' => $this->input->post('totalBarangOptimumE'),
        'jumlah_minimum' => $this->input->post('totalBarangMinimumE'),
        'satuan_barang' => $this->input->post('satuanBarangE'),
        'kondisi_barang' => $this->input->post('kondisiBarangE'),
        'kategori_barang' => $this->input->post('kategoriBarangE'),
        'tipe_barang' => $this->input->post('tipeBarangE'),
        'id_dtl_penyimpanan' => $dtl_ruangan_penyimpanan,
        'keterangan_penyimpanan' => $this->input->post('keteranganLokasiE'),
        'gambar_barang' => $finalFileName,
        'modified_by' => $this->session->userdata('id'),
        'modified_date' => date('Y/m/d')
      );
    }
      
    $where = array(
      'id_barang' => $this->input->post('idBarangE'),
    );

    $this->db->where($where);
    return $this->db->update($this->tablebarang, $data);
  }

  public function deletebarang($idBarang)
  {
    $data = array(
      'status_barang' => "Tidak Aktif",
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_barang' => $idBarang,
    );

    $this->db->where($where);
    return $this->db->update($this->tablebarang, $data);
  }
   /////////////////////////////////////////////////////////////////////////////APPROVAL

  function getDataApproval()
  {
      $sql = "SELECT A.id_peminjaman_barang,A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
        FROM peminjaman_barang AS A 
        ORDER BY  CASE A.status_peminjaman
                WHEN 'On Progress Approval PIC Asset' OR 'On Progress Approval PIC Non Asset' THEN 1
                WHEN 'On Progress Approval Koor UPT' THEN 2
                WHEN 'Approved' THEN 3
                WHEN 'Borrowed' THEN 4
                WHEN 'Waiting for Return' THEN 5
                WHEN 'Completed' THEN 6
                ELSE 7 -- untuk status lain yang tidak dikenal
            END;";
      $query = $this->db->query($sql);
      return $query->result();
  }
  function getDataApprovalPICAsset()
  {
      $sql = "SELECT A.id_peminjaman_barang,A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
        FROM peminjaman_barang AS A 
        ORDER BY  CASE A.status_peminjaman
                WHEN 'On Progress Approval PIC Asset' OR 'On Progress Approval PIC Non Asset' THEN 1
                WHEN 'On Progress Approval Koor UPT' THEN 2
                WHEN 'Approved' THEN 3
                WHEN 'Borrowed' THEN 4
                WHEN 'Waiting for Return' THEN 5
                WHEN 'Completed' THEN 6
                ELSE 7 -- untuk status lain yang tidak dikenal
            END;";
      $query = $this->db->query($sql);
      return $query->result();
  }
  // function getDataApprovalPICNonAsset()
  // {
  //     $sql = "SELECT A.id_peminjaman_barang,A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
  //       FROM peminjaman_barang AS A 
  //       ORDER BY  CASE A.status_peminjaman
  //               WHEN 'On Progress Approval PIC Asset' OR 'On Progress Approval PIC Non Asset' THEN 1
  //               WHEN 'On Progress Approval Koor UPT' THEN 2
  //               WHEN 'Approved' THEN 3
  //               WHEN 'Borrowed' THEN 4
  //               WHEN 'Waiting for Return' THEN 5
  //               WHEN 'Completed' THEN 6
  //               ELSE 7 -- untuk status lain yang tidak dikenal
  //           END;";
  //     $query = $this->db->query($sql);
  //     return $query->result();
  // }
  public function getDataApprovalPICAssetFiltered($start_date = null, $end_date = null)
  {
    $where = "";
    $params = [];

    if (!empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) >= ? ";
      $params[] = $start_date;
    }

    if (!empty($end_date) && !empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) <= ? ";
      $params[] = $end_date;
    }

    $sql = "SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
            FROM peminjaman_barang AS A
            WHERE  A.id_peminjaman_barang != '' $where
            ORDER BY CASE 
                WHEN A.status_peminjaman IN ('On Progress Approval PIC Asset', 'On Progress Approval PIC', 'On Progress Approval PIC Non Asset') THEN 1
                WHEN A.status_peminjaman = 'On Progress Approval Koordinator UPT' THEN 2
                WHEN A.status_peminjaman = 'Approved' THEN 3
                WHEN A.status_peminjaman = 'Borrowed' THEN 4
                WHEN A.status_peminjaman = 'Waiting for Return' THEN 5
                WHEN A.status_peminjaman = 'Completed' THEN 6
                ELSE 7
            END";

    return $this->db->query($sql, $params)->result();
  }

  public function getDataApprovalPICNonAssetFiltered($start_date = null, $end_date = null)
  {
    $where = "";
    $params = [];

    if (!empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) >= ? ";
      $params[] = $start_date;
    }

    if (!empty($end_date) && !empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) <= ? ";
      $params[] = $end_date;
    }

    $sql = "SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
            FROM peminjaman_barang AS A
            WHERE  A.id_peminjaman_barang != '' $where
            ORDER BY CASE 
                WHEN A.status_peminjaman IN ('On Progress Approval PIC Asset', 'On Progress Approval PIC', 'On Progress Approval PIC Non Asset') THEN 1
                WHEN A.status_peminjaman = 'On Progress Approval Koordinator UPT' THEN 2
                WHEN A.status_peminjaman = 'Approved' THEN 3
                WHEN A.status_peminjaman = 'Borrowed' THEN 4
                WHEN A.status_peminjaman = 'Waiting for Return' THEN 5
                WHEN A.status_peminjaman = 'Completed' THEN 6
                ELSE 7
            END ASC";

    return $this->db->query($sql, $params)->result();
  }
  public function getDataApprovalKoorUPTFiltered($start_date = null, $end_date = null)
  {
    $where = "";
    $params = [];

    if (!empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) >= ? ";
      $params[] = $start_date;
    }

    if (!empty($end_date) && !empty($start_date)) {
      $where .= " AND DATE(A.mulai_peminjaman) <= ? ";
      $params[] = $end_date;
    }

    $sql = "SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman
            FROM peminjaman_barang AS A
            WHERE  A.id_peminjaman_barang != '' $where
            ORDER BY CASE 
                WHEN A.status_peminjaman IN ('On Progress Approval PIC Asset', 'On Progress Approval PIC', 'On Progress Approval PIC Non Asset') THEN 2
                WHEN A.status_peminjaman = 'On Progress Approval Koordinator UPT' THEN 1
                WHEN A.status_peminjaman = 'Approved' THEN 3
                WHEN A.status_peminjaman = 'Borrowed' THEN 4
                WHEN A.status_peminjaman = 'Waiting for Return' THEN 5
                WHEN A.status_peminjaman = 'Completed' THEN 6
                ELSE 7
            END";

    return $this->db->query($sql, $params)->result();
  }

  function getDtlPeminjamanByIdPeminjamanPICAsset($id_peminjaman)
  {
    $query = $this->db->query("SELECT a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman,a.gambar_sebelum, a.gambar_sesudah 
    FROM dtl_peminjaman_barang as A JOIN barang as b on a.id_barang = b.id_barang WHERE a.id_peminjaman_barang = $id_peminjaman 
    GROUP BY a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman, a.gambar_sebelum, a.gambar_sesudah;");
    return $query->result();
  }
  function getDtlPeminjamanByIdPeminjamanPICNonAsset($id_peminjaman)
  {
    $query = $this->db->query("SELECT a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman,a.gambar_sebelum, a.gambar_sesudah 
    FROM dtl_peminjaman_barang as A JOIN barang as b on a.id_barang = b.id_barang WHERE a.id_peminjaman_barang = $id_peminjaman 
    GROUP BY a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman, a.gambar_sebelum, a.gambar_sesudah;");
    return $query->result();
  }
  function getDtlPeminjamanByIdPeminjamanKoorUPT($id_peminjaman)
  {
    $query = $this->db->query("SELECT a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman,a.gambar_sebelum, a.gambar_sesudah 
    FROM dtl_peminjaman_barang as A JOIN barang as b on a.id_barang = b.id_barang WHERE a.id_peminjaman_barang = $id_peminjaman 
    GROUP BY a.jumlah_peminjaman, a.satuan_barang, b.kondisi_barang, a.status_barang, b.nama_barang, b.nomor_aktiva, b.tipe_barang, b.kategori_barang, b.gambar_barang, A.id_dtl_peminjaman, a.gambar_sebelum, a.gambar_sesudah;");
    return $query->result();
  }

  function accpeminjaman(){

   // Ambil role user dan ID dari session
    $userRole = $this->session->userdata('role'); // misalnya: 'PIC', 'Koor UPT'
    $userId = $this->session->userdata('id');
    $idDtl = $this->input->post('id_dtl_peminjaman');

    // Default status jika tidak cocok
    $statusBarang = 'On Progress Approval Koordinator UPT';

    // Tentukan status berdasarkan role
    if ($userRole=='PIC Asset & Non Asset'){
        $statusBarang = 'On Progress Approval Koordinator UPT';
    } elseif ($userRole == 'Koordinator UPT') {
        $statusBarang = 'Approved';
    }elseif ($userRole == 'PIC Non Asset') {
        $statusBarang = 'Approved';
    }

    // Data yang akan diupdate
    $data = array(
        'status_barang' => $statusBarang
    );

    $where = array(
        'id_dtl_peminjaman' => $idDtl
    );

    // Eksekusi update ke database
    $this->db->where($where);
    $update=  $this->db->update($this->tabledetailpeminjamanbarang, $data);
    if (!$update) {
        return false; // Gagal update
    }

    //insert log
    date_default_timezone_set('Asia/Jakarta');
    $data_log = [
        'id_dtl_peminjaman'  => $idDtl,
        'user_approval'   => $userRole,
        'nama_approval'       => 'Approved',
        'waktu_approval'      => date('Y-m-d H:i:s')
    ];
    $this->db->insert('riwayat_approval', $data_log);

    // Jika role adalah Koordinator UPT, update status barang jadi 'Booked'
    if ($userRole == 'Koordinator UPT') {
        // Ambil id_barang dari id_dtl_peminjaman
        $this->db->select('id_barang');
        $this->db->from($this->tabledetailpeminjamanbarang);
        $this->db->where('id_dtl_peminjaman', $idDtl);
        $barangRow = $this->db->get()->row();

        if ($barangRow) {
            $this->db->where('id_barang', $barangRow->id_barang);
            $this->db->update('barang', ['ketersediaan_barang' => 'Booked']);
        }
    }

    // 2. Ambil id_peminjaman_barang dari id_dtl_peminjaman
    $this->db->select('id_peminjaman_barang');
    $this->db->from($this->tabledetailpeminjamanbarang);
    $this->db->where('id_dtl_peminjaman', $idDtl);
    $query  = $this->db->get();
    $result = $query->row();

    if (!$result) return false;

    $idPeminjaman = $result->id_peminjaman_barang;

    // 3. Ambil semua status_barang dengan id_peminjaman_barang tersebut
    $this->db->select('status_barang');
    $this->db->from($this->tabledetailpeminjamanbarang);
    $this->db->where('id_peminjaman_barang', $idPeminjaman);
    $statusList = $this->db->get()->result_array();

    $statusArray = array_column($statusList, 'status_barang');

    // 4. Jika ada status 'On Progress Approval PIC Asset' atau 'PIC Non Asset' → tidak ubah status peminjaman
    foreach ($statusArray as $status) {
        if ($status === 'On Progress Approval PIC Asset' || $status === 'On Progress Approval PIC Non Asset') {
            return true; // Tidak perlu update status_peminjaman
        }
    }

    // 5. Jika ada 'On Progress Approval Koordinator UPT' → update status_peminjaman
    if (in_array('On Progress Approval Koordinator UPT', $statusArray)) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'On Progress Approval Koordinator UPT']);
        return true;
    }

    // Cek jika semua status adalah 'Approved'
    $allApproved = true;
    foreach ($statusArray as $status) {
        if ($status !== 'Approved') {
            $allApproved = false;
            break;
        }
    }

    if ($allApproved) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Approved']);
        return true;
    }

    // 6. Jika semua status adalah 'Reject'
    $allReject = true;
    foreach ($statusArray as $status) {
        if (stripos($status, 'Reject') === false) {
            $allReject = false;
            break;
        }
    }

    if ($allReject) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Rejected']);
    }
    // Definisikan urutan hirarki status (dari yang paling rendah/prioritas awal)
    $statusHierarchy = [
        'On Progress Approval PIC',
        'On Progress Approval Koordinator UPT',
        'Approved',
        'Borrowed',
        'Waiting for Return',
        'Completed'
    ];

    // Temukan status dengan hirarki terendah dari array
    $lowestStatus = null;
    $lowestIndex = count($statusHierarchy); // nilai awal yang tinggi

    foreach ($statusArray as $status) {
        $index = array_search($status, $statusHierarchy);
        if ($index !== false && $index < $lowestIndex) {
            $lowestIndex = $index;
            $lowestStatus = $status;
        }
    }

    // Update status_peminjaman dengan status terendah
    if ($lowestStatus !== null) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => $lowestStatus]);
        return true;
    }



    return true;
  }
  function rejectpeminjaman(){

    // Ambil role user dan ID dari session
    $userRole = $this->input->cookie('role', true);
    $userId = $this->input->cookie('id', true);
    $role = $this->session->userdata('role');

    $idDtl = $this->input->post('id_dtl_peminjaman');
    $alasan = $this->input->post('alasan');

    // Default status jika tidak cocok
    $statusBarang = 'Reject';

    // Tentukan status berdasarkan role
    $statusBarang = 'Reject by '.$this->session->userdata('role');

    // Data yang akan diupdate
    $data = array(
        'status_barang' => $statusBarang,
        'alasan_barang' => $alasan
    );

    $where = array(
        'id_dtl_peminjaman' => $idDtl
    );

    // Eksekusi update ke database
    $this->db->where($where);
    $update=  $this->db->update($this->tabledetailpeminjamanbarang, $data);
    if (!$update) {
        return false; // Gagal update
    }

    //ambil id_barang dan set ketersediaan_barang = 'Available'
    $this->db->select('id_barang, jumlah_barang');
    $this->db->from($this->tabledetailpeminjamanbarang);
    $this->db->where('id_dtl_peminjaman', $idDtl);
    $barangRow = $this->db->get()->row();

    //insert log
    date_default_timezone_set('Asia/Jakarta');
    $data_log = [
        'id_dtl_peminjaman'  => $idDtl,
        'user_approval'   => $this->session->userdata('role'),
        'nama_approval'       => 'Rejected',
        'waktu_approval'      => date('Y-m-d H:i:s')
    ];
    $this->db->insert('riwayat_approval', $data_log);

    if ($barangRow) {
      $id_barang = $barangRow->id_barang;
      $jumlah_kembali = $barangRow->jumlah_barang;

      // Ambil info barang (kategori + stock)
      $barangInfo = $this->db->get_where('barang', ['id_barang' => $id_barang])->row();

      if ($barangInfo) {
          $data_update = ['ketersediaan_barang' => 'Available'];

          if ($barangInfo->kategori_barang === 'Non Asset') {
              $stock_baru = $barangInfo->jumlah_barang + $jumlah_kembali;
              $data_update['jumlah_barang'] = $stock_baru;
          }

          $this->db->where('id_barang', $id_barang);
          $this->db->update('barang', $data_update);
      }
  }

    // 2. Ambil id_peminjaman_barang dari id_dtl_peminjaman
    $this->db->select('id_peminjaman_barang');
    $this->db->from($this->tabledetailpeminjamanbarang);
    $this->db->where('id_dtl_peminjaman', $idDtl);
    $query  = $this->db->get();
    $result = $query->row();

    if (!$result) return false;

    $idPeminjaman = $result->id_peminjaman_barang;

    // 3. Ambil semua status_barang dengan id_peminjaman_barang tersebut
    $this->db->select('status_barang');
    $this->db->from($this->tabledetailpeminjamanbarang);
    $this->db->where('id_peminjaman_barang', $idPeminjaman);
    $statusList = $this->db->get()->result_array();

    $statusArray = array_column($statusList, 'status_barang');
    // 4. Jika ada status 'On Progress Approval PIC Asset' atau 'PIC Non Asset' → tidak ubah status peminjaman
    foreach ($statusArray as $status) {
        if ($status === 'On Progress Approval PIC Asset' || $status === 'On Progress Approval PIC Non Asset') {
            return true; // Tidak perlu update status_peminjaman
        }
    }

    // 5. Jika ada 'On Progress Approval Koordinator UPT' → update status_peminjaman
    if (in_array('On Progress Approval Koordinator UPT', $statusArray)) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'On Progress Approval Koordinator UPT']);
        return true;
    }

    // Cek jika semua status adalah 'Approved'
    $allApproved = true;
    foreach ($statusArray as $status) {
        if ($status !== 'Approved') {
            $allApproved = false;
            break;
        }
    }

    if ($allApproved) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Approved']);
        return true;
    }

    // 6. Jika semua status adalah 'Reject'
    $allReject = true;
    foreach ($statusArray as $status) {
        if (stripos($status, 'Reject') === false) {
            $allReject = false;
            break;
        }
    }

    if ($allReject) {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Rejected']);
    }

    return true;
  }
  ///////////////////////////////////////////////////////////////////////////// RUANGAN

  
  public function getDatausername()
  {
    $query = $this->db->query('SELECT username,nama  FROM admin where role = 1 ');
    return $query->result();
  }
  function getDataRuangan()
  {
      $sql = "SELECT a.id_ruangan, a.status_ruangan, a.nama_ruangan FROM ruangan AS a WHERE a.status_ruangan = 'Aktif' ORDER BY a.nama_ruangan;";
      $query = $this->db->query($sql);
      return $query->result();
  }
  function getDataRuanganByNamaRuangan($namaRuangan, $idRuangan){
    $sql = "SELECT a.id_ruangan FROM ruangan AS a WHERE a.status_ruangan = 'Aktif' AND a.nama_ruangan = '".$namaRuangan."' AND a.id_ruangan != $idRuangan;";
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
        return $query->row()->id_ruangan; // Mengembalikan satu nilai string
      } else {
          return null;
      }
  }
  function getDataRuanganById($idRuangan)
  {
      $sql = "SELECT a.nama_ruangan FROM ruangan AS a WHERE a.status_ruangan = 'Aktif' AND a.id_ruangan = $idRuangan;";
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
        return $query->row()->nama_ruangan; // Mengembalikan satu nilai string
      } else {
          return null;
      }
  }
  public function getruangan()
  {
    $query = $this->db->query("SELECT 
        a.id_ruangan, 
        a.status_ruangan, 
        a.nama_ruangan, 
        a.pic_ruangan, 
        b.nama_pengguna, 
        GROUP_CONCAT(d.nama_penyimpanan SEPARATOR ', ') AS daftar_penyimpanan
    FROM 
        ruangan AS a
        LEFT JOIN pengguna AS b ON a.pic_ruangan = b.id_pengguna
        LEFT JOIN dtl_ruangan_penyimpanan AS c ON a.id_ruangan = c.id_ruangan
        LEFT JOIN penyimpanan AS d ON c.id_penyimpanan = d.id_penyimpanan
    WHERE a.status_ruangan = 'Aktif'
    GROUP BY 
        a.id_ruangan, 
        a.status_ruangan, 
        a.nama_ruangan, 
        a.pic_ruangan, 
        b.nama_pengguna
    ;");

    return $query->result();
  }

  public function saveruangan($data)
  {
    return $this->db->insert($this->tableruangan, $data);
  }
  
  public function editruangan()
  {
    $data = array(
      'nama_ruangan' => $this->input->post('namaRuanganE'),
      'pic_ruangan' => $this->input->post('picRuanganE'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );
    $id = $this->input->post('idRuanganE');
    // echo "<script>console.log('Debug Objects: " . $id . "' );</script>";
    $where = array(
      'id_ruangan' => $id
    );

    $this->db->where($where);
    return $this->db->update($this->tableruangan, $data);
  }
  
  public function deleteruangan($idRuangan)
  {
    $data = array(
      'status_ruangan' => "Tidak Aktif",
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_ruangan' => $idRuangan,
    );

    $this->db->where($where);
    return $this->db->update($this->tableruangan, $data);
  }

  

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Penyimpanan
  public function getDataPenyimpanan()
  {
    $query = $this->db->query("SELECT a.id_penyimpanan as id_penyimpanan, a.status_penyimpanan, a.nama_penyimpanan FROM penyimpanan AS a WHERE a.status_penyimpanan = 'Aktif' ORDER BY a.nama_penyimpanan ASC;");
    return $query->result();
  }
  public function getPenyimpananByIdRuangan($id_ruangan)
  {
    $query = $this->db->query("SELECT a.id_dtl_penyimpanan, b.id_penyimpanan, b.status_penyimpanan, b.nama_penyimpanan FROM dtl_ruangan_penyimpanan as a JOIN penyimpanan as b on a.id_penyimpanan = b.id_penyimpanan JOIN ruangan as c on c.id_ruangan = a.id_ruangan WHERE a.status_detail = 'Aktif' AND b.status_penyimpanan = 'Aktif' AND c.id_ruangan = $id_ruangan ORDER BY b.nama_penyimpanan;");
    return $query->result();
  }
  public function getPenyimpananByRuangan($nama_ruangan)
  {
    $query = $this->db->query("SELECT b.id_penyimpanan, b.status_penyimpanan, b.nama_penyimpanan FROM dtl_ruangan_penyimpanan as a JOIN penyimpanan as b on a.id_penyimpanan = b.id_penyimpanan JOIN ruangan as c on c.id_ruangan = a.id_ruangan WHERE b.status_penyimpanan = 'Aktif' AND c.nama_ruangan LIKE '%".$nama_ruangan."%' GROUP BY b.id_penyimpanan, b.status_penyimpanan, b.nama_penyimpanan  ORDER BY b.nama_penyimpanan;");
    return $query->result();
  }
  public function getPenyimpananDetailByRuangan($nama_ruangan)
  {
    $query = $this->db->query("SELECT b.id_penyimpanan, b.status_penyimpanan, b.nama_penyimpanan, COUNT(d.jumlah_barang) as total_barang, d.nama_barang, d.satuan_barang FROM dtl_ruangan_penyimpanan as a JOIN penyimpanan as b on a.id_penyimpanan = b.id_penyimpanan JOIN ruangan as c on c.id_ruangan = a.id_ruangan LEFT JOIN barang as d on d.id_dtl_penyimpanan = a.id_dtl_penyimpanan WHERE b.status_penyimpanan = 'Aktif' AND c.nama_ruangan LIKE '%".$nama_ruangan."%' GROUP BY b.id_penyimpanan, b.status_penyimpanan, b.nama_penyimpanan, d.nama_barang, d.satuan_barang ORDER BY b.nama_penyimpanan;");
    return $query->result();
  }
  public function getDataPenyimpananByNamaPenyimpanan( $nama_penyimpanan, $id_penyimpanan){
    $query = $this->db->query("SELECT A.id_penyimpanan FROM penyimpanan as A where A.nama_penyimpanan = '".$nama_penyimpanan."' AND A.status_penyimpanan ='Aktif' AND A.id_penyimpanan!= '".$id_penyimpanan."';");
    if ($query->num_rows() > 0) {
        return $query->row()->id_penyimpanan; // Mengembalikan satu nilai string
    } else {
        return null;
    }
  }

  public function savepenyimpanan($data)
  {
    return $this->db->insert($this->tablepenyimpanan, $data);
  }
  
  public function editpenyimpanan()
  {
    $data = array(
      'nama_penyimpanan' => $this->input->post('namaPenyimpananE'),
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );
    $id = $this->input->post('idPenyimpananE');
    // echo "<script>console.log('Debug Objects: " . $id . "' );</script>";
    $where = array(
      'id_penyimpanan' => $id
    );

    $this->db->where($where);
    return $this->db->update($this->tablepenyimpanan, $data);
  }
  
  public function deletepenyimpanan($idPenyimpanan)
  {
    $data = array(
      'status_penyimpanan' => "Tidak Aktif",
      'modified_by' => $this->session->userdata('id'),
      'modified_date' => date('Y/m/d')
    );

    $where = array(
      'id_penyimpanan' => $idPenyimpanan,
    );

    $this->db->where($where);
    return $this->db->update($this->tablepenyimpanan, $data);
  }


  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Lain Lain
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
  public function getRiwayatBarang()
  {
    // $query = $this->db->query("SELECT * FROM tb_peminjaman_barang ORDER BY CASE WHEN status LIKE 'Pengajuan' THEN 0 ELSE 1 END");
    $query = $this->db->query("SELECT * FROM tb_peminjaman_barang ORDER BY no_pengajuan DESC");

    return $query->result();
  }
  public function getRiwayatRuangan()
  {
    $query = $this->db->query("SELECT a.id_peminjaman,a.no_pengajuan,a.nim_peminjam,a.nama_peminjam,b.nama_ruangan,a.tanggal,
    a.mulai_pinjam,a.selesai_pinjam,a.jumlah_pengguna,a.foto_sebelum, a.foto_setelah,a.status 
    FROM `tb_peminjaman` AS a INNER JOIN tb_ruangan AS b ON a.id_ruangan = b.id_ruangan ORDER BY no_pengajuan DESC");

    return $query->result();
  }
  public function getRiwayatRuanganDetail($id)
  {
    $query = $this->db->query("SELECT a.id_peminjaman,a.nim_peminjam,a.nama_peminjam,a.id_ruangan,b.nama_ruangan,a.tanggal,
    a.mulai_pinjam,a.selesai_pinjam,a.keperluan,a.jumlah_pengguna,a.foto_sebelum, a.foto_setelah,a.status, a.created_date
    FROM `tb_peminjaman` AS a INNER JOIN tb_ruangan AS b ON a.id_ruangan = b.id_ruangan WHERE a.id_peminjaman = $id");

    return $query->result();
  }
  public function getRiwayatBarangSpan($id)
  {
    $query = $this->db->query("SELECT * FROM tb_peminjaman_barang where id_peminjaman_barang = $id");

    return $query->result();
  }
  public function getRiwayatBarangDetail($id)
  {
    $query = $this->db->query("SELECT a.*,b.jumlah,c.nama_barang from tb_peminjaman_barang as a inner join tb_detail_barang as b on a.id_peminjaman_barang = b.id_peminjaman_barang INNER join tb_barang as c on b.id_barang = c.id_barang where a.id_peminjaman_barang = $id");

    return $query->result();
  }
  public function accRuangan($id)
  {
    $query = $this->db->query("UPDATE tb_peminjaman SET status = 'Disetujui' WHERE id_peminjaman = $id;");
    return $query->result();
  }

  public function rejectRuangan($id)
  {
    $query = $this->db->query("UPDATE tb_peminjaman SET status = 'Ditolak' WHERE id_peminjaman = $id;");
    return $query->result();
  }
  public function accBarang($id)
  {
    $this->db->query("UPDATE tb_peminjaman_barang SET status = 'Disetujui' WHERE id_peminjaman_barang = $id;");
  }

  public function rejectBarang($id)
  {
    $query = $this->db->query("UPDATE tb_peminjaman_barang SET status = 'Ditolak' WHERE id_peminjaman_barang = $id;");
    return $query->result();
  }
  public function getdetilBarang($id){
    $query = $this->db->query("SELECT a.id_peminjaman_barang,a.id_barang,a.jumlah,b.jumlah AS stok,b.nama_barang from tb_detail_barang AS a INNER JOIN tb_barang AS b  ON a.id_barang = b.id_barang WHERE a.id_peminjaman_barang = '$id'");
    return $query->result();
  }
  public function minStok($id,$jumlah){
    $this->db->query("UPDATE tb_barang SET jumlah = jumlah-$jumlah WHERE id_barang = $id");
  }
  public function getJmlbarang($id){
    $query = $this->db->query("SELECT jumlah FROM tb_barang WHERE id_barang = $id;");
    return $query->result();
  }
  public function updateStatusBrg($id){
    $this->db->query("UPDATE tb_barang SET status = 2 WHERE id_barang = $id");
  }
  public function plusStok($id,$jumlah){
    $this->db->query("UPDATE tb_barang SET jumlah = jumlah+$jumlah WHERE id_barang = $id");
  }
  public function updateStatusBrgTersedia($id){
    $this->db->query("UPDATE tb_barang SET status = 1 WHERE id_barang = $id");
  }

  /**
   * Get peminjaman pending approval for more than X days (for auto-approval)
   * Returns detail peminjaman items that are pending PIC Asset/Non Asset/Koor UPT approval
   * @param int $days Number of days threshold
   * @return array Detail peminjaman records pending approval > X days
   */
  public function getPendingApprovalPeminjamanOverDays($days = 3)
  {
    $sql = "SELECT d.id_dtl_peminjaman, d.id_peminjaman_barang, d.id_barang, d.status_barang,
                   p.tanggal_peminjam, p.status_peminjaman,
                   b.kategori_barang
            FROM dtl_peminjaman_barang d
            JOIN peminjaman_barang p ON d.id_peminjaman_barang = p.id_peminjaman_barang
            JOIN barang b ON d.id_barang = b.id_barang
            WHERE d.status_barang IN ('On Progress Approval PIC Asset', 'On Progress Approval PIC Non Asset', 'On Progress Approval Koordinator UPT')
            AND DATEDIFF(CURDATE(), p.tanggal_peminjam) > ?
            ORDER BY d.id_dtl_peminjaman ASC";
    return $this->db->query($sql, [$days])->result();
  }

  /**
   * Auto approve peminjaman item (for cron job)
   * @param int $id_dtl_peminjaman Detail peminjaman ID
   * @param string $current_status Current status of the item
   * @return bool Success status
   */
  public function autoApprovePeminjamanItem($id_dtl_peminjaman, $current_status)
  {
    // Determine next status based on current status
    $next_status = 'Approved';
    
    if ($current_status == 'On Progress Approval PIC Asset' || $current_status == 'On Progress Approval PIC Non Asset') {
      $next_status = 'On Progress Approval Koordinator UPT';
    } elseif ($current_status == 'On Progress Approval Koordinator UPT') {
      $next_status = 'Approved';
    }

    // Update detail peminjaman status
    $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
    $update = $this->db->update('dtl_peminjaman_barang', ['status_barang' => $next_status]);
    
    if (!$update) return false;

    // Insert log
    date_default_timezone_set('Asia/Jakarta');
    $data_log = [
      'id_dtl_peminjaman' => $id_dtl_peminjaman,
      'user_approval' => 'SYSTEM_AUTO_APPROVE',
      'nama_approval' => 'Auto Approved (>3 days)',
      'waktu_approval' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('riwayat_approval', $data_log);

    // If approved by Koor UPT level, update barang availability
    if ($next_status == 'Approved') {
      $this->db->select('id_barang');
      $this->db->from('dtl_peminjaman_barang');
      $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
      $barangRow = $this->db->get()->row();

      if ($barangRow) {
        $this->db->where('id_barang', $barangRow->id_barang);
        $this->db->update('barang', ['ketersediaan_barang' => 'Booked']);
      }
    }

    // Update parent peminjaman_barang status
    $this->updatePeminjamanStatusAfterAutoApprove($id_dtl_peminjaman);

    return true;
  }

  /**
   * Update peminjaman_barang status after auto-approve
   * @param int $id_dtl_peminjaman Detail peminjaman ID
   */
  private function updatePeminjamanStatusAfterAutoApprove($id_dtl_peminjaman)
  {
    // Get id_peminjaman_barang
    $this->db->select('id_peminjaman_barang');
    $this->db->from('dtl_peminjaman_barang');
    $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
    $result = $this->db->get()->row();

    if (!$result) return;

    $idPeminjaman = $result->id_peminjaman_barang;

    // Get all status_barang for this peminjaman
    $this->db->select('status_barang');
    $this->db->from('dtl_peminjaman_barang');
    $this->db->where('id_peminjaman_barang', $idPeminjaman);
    $statusList = $this->db->get()->result_array();
    $statusArray = array_column($statusList, 'status_barang');

    // Check if any still pending PIC approval
    foreach ($statusArray as $status) {
      if ($status === 'On Progress Approval PIC Asset' || $status === 'On Progress Approval PIC Non Asset') {
        return; // Don't update parent status yet
      }
    }

    // Check if any pending Koor UPT approval
    if (in_array('On Progress Approval Koordinator UPT', $statusArray)) {
      $this->db->where('id_peminjaman_barang', $idPeminjaman);
      $this->db->update('peminjaman_barang', ['status_peminjaman' => 'On Progress Approval Koordinator UPT']);
      return;
    }

    // Check if all approved
    $allApproved = true;
    foreach ($statusArray as $status) {
      if ($status !== 'Approved' && strpos($status, 'Reject') === false) {
        $allApproved = false;
        break;
      }
    }

    if ($allApproved) {
      // Check if any rejected
      $hasReject = false;
      foreach ($statusArray as $status) {
        if (strpos($status, 'Reject') !== false) {
          $hasReject = true;
          break;
        }
      }

      if ($hasReject) {
        // Some approved, some rejected - check if all non-rejected are approved
        $allNonRejectedApproved = true;
        foreach ($statusArray as $status) {
          if (strpos($status, 'Reject') === false && $status !== 'Approved') {
            $allNonRejectedApproved = false;
            break;
          }
        }
        if ($allNonRejectedApproved) {
          $this->db->where('id_peminjaman_barang', $idPeminjaman);
          $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Approved']);
        }
      } else {
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Approved']);
      }
    }
  }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////Login



///////////////////////////////////////////////////////////////////////////////////
