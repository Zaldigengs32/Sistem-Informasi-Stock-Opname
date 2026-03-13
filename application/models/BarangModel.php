<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangModel extends CI_Model
{
    function getDataBarang()
    {
        $query = $this->db->query("SELECT A.id_barang, A.nama_barang, A.nomor_aktiva, A.tipe_barang, A.jumlah_barang, A.satuan_barang, A.kondisi_barang, A.gambar_barang, A.kategori_barang, A.keterangan_penyimpanan, C.id_ruangan,C.nama_ruangan, D.nama_penyimpanan, D.id_penyimpanan FROM barang as A left join dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan LEFT JOIN ruangan as C on B.id_ruangan = C.id_ruangan LEFT JOIN penyimpanan as D on D.id_penyimpanan = B.id_penyimpanan where status_barang = 'Aktif' and ketersediaan_barang = 'Available';");
        return $query->result();
    }
    public function get_barang_paginated($search, $kategori, $tipe, $limit, $start)
    {
        $query = "SELECT DISTINCT A.id_barang, A.nama_barang, A.nomor_aktiva, A.tipe_barang, A.jumlah_barang, A.satuan_barang, A.kondisi_barang, A.gambar_barang, A.kategori_barang, A.keterangan_penyimpanan, C.id_ruangan,C.nama_ruangan, D.nama_penyimpanan, D.id_penyimpanan 
        FROM barang as A left join dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan LEFT JOIN ruangan as C on B.id_ruangan = C.id_ruangan LEFT JOIN penyimpanan as D on D.id_penyimpanan = B.id_penyimpanan where status_barang = 'Aktif' and ketersediaan_barang = 'Available' and kondisi_barang = 'Good' AND (A.nama_barang LIKE '%".$search."%' OR A.nomor_aktiva LIKE '%".$search."%') ";
        if (!empty($kategori)) {
            $query .= " AND A.kategori_barang = '".$kategori."'";
        }

        if (!empty($tipe)) {
            $query .= " AND A.tipe_barang = '".$tipe."'";
        }
        $query .= " LIMIT $limit OFFSET $start;";
        $queryALL = $this->db->query($query);
        return $queryALL->result();
    }
    public function count_all_barang($search, $kategori, $tipe)
    {
        $query = "SELECT DISTINCT COUNT(*) as total 
        FROM barang as A 
        LEFT JOIN dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan 
        LEFT JOIN ruangan as C on B.id_ruangan = C.id_ruangan 
        LEFT JOIN penyimpanan as D on D.id_penyimpanan = B.id_penyimpanan 
        WHERE A.status_barang = 'Aktif' and ketersediaan_barang = 'Available' and kondisi_barang = 'Good'  
        AND (A.nama_barang LIKE '%" . $search . "%' OR A.nomor_aktiva LIKE '%" . $search . "%')";

        if (!empty($kategori)) {
            $query .= " AND A.kategori_barang = '" . $kategori . "'";
        }

        if (!empty($tipe)) {
            $query .= " AND A.tipe_barang = '" . $tipe . "'";
        }

        $result = $this->db->query($query)->row();
        return $result->total;
    }
    public function count_filtered_barang($kategori, $search, $tipe) {
        $this->db->from('barang');
        $this->db->where('kategori_barang', $kategori);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_barang', $search);
            $this->db->or_like('nomor_aktiva', $search);
            $this->db->or_like('tipe_barang', $search);
            $this->db->or_like('kategori_barang', $search);
            $this->db->group_end();
        }
        if (!empty($tipe)) {
            $this->db->where('tipe_barang', $tipe);
        }
        $this->db->where('status_barang', 'Aktif');
        $this->db->where('ketersediaan_barang', 'Available');
        $this->db->where('kondisi_barang', 'Good');
        return $this->db->count_all_results();
    }

    public function get_filtered_barang_paginated($kategori, $search, $tipe, $limit, $offset) {
        $this->db->from('barang');
        $this->db->where('kategori_barang', $kategori);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_barang', $search);
            $this->db->or_like('nomor_aktiva', $search);
            $this->db->or_like('tipe_barang', $search);
            $this->db->or_like('kategori_barang', $search);
            $this->db->group_end();
        }
        if (!empty($tipe)) {
            $this->db->where('tipe_barang', $tipe);
        }
        $this->db->where('status_barang', 'Aktif');
        $this->db->where('ketersediaan_barang', 'Available');
        $this->db->where('kondisi_barang', 'Good');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function get_barang_by_kategori_paginated($kategori, $limit, $start)
    {
        $query = $this->db->query("SELECT A.id_barang, A.nama_barang, A.nomor_aktiva, A.tipe_barang, A.jumlah_barang, A.satuan_barang, A.kondisi_barang, A.gambar_barang, A.kategori_barang, A.keterangan_penyimpanan, C.id_ruangan,C.nama_ruangan, D.nama_penyimpanan, D.id_penyimpanan FROM barang as A left join dtl_ruangan_penyimpanan as B ON A.id_dtl_penyimpanan = B.id_dtl_penyimpanan LEFT JOIN ruangan as C on B.id_ruangan = C.id_ruangan LEFT JOIN penyimpanan as D on D.id_penyimpanan = B.id_penyimpanan where status_barang = 'Aktif' and ketersediaan_barang = 'Available' AND A.kategori_barang = '".$kategori."' LIMIT $limit OFFSET $start;");
        return $query->result();
    }
    public function count_barang_by_kategori($kategori) {
        $this->db->where('kategori_barang', $kategori);
        $this->db->where('ketersediaan_barang', 'Available');
        return $this->db->count_all_results('barang');
    }
    
    function getKeranjangbyAmount(){
        if(isset($_COOKIE['nim'])){
            $nim = $_COOKIE['nim'];
            $sql="SELECT SUM(jumlah) as JumlahKeranjang from keranjang WHERE nim = '".$nim."'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->row()->JumlahKeranjang; // Mengembalikan satu nilai string
            } else {
                return null;
            }
        }
    }
    public function get_stok_barang($id_barang) {
        $this->db->select('jumlah_barang');
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get('barang')->row();
        return $query ? (int)$query->jumlah_barang : 0;
    }



    public function getnoPengajuan()
    {
        $sql = "SELECT no_pengajuan FROM tb_peminjaman_barang ORDER BY id_peminjaman_barang DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row();
    }
    function simpanBarang($no_pengajuan_new,$CartData)
    {
        $nim = $this->input->post('nim');
        $nama = $this->input->post('nama');
        // $ruangan = $this->input->post('idruangan');
        $tanggal = $this->input->post('tanggal');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $jumlah = $this->input->post('jumlah');
        $keperluan = $this->input->post('keperluan');
        $sukses =2;
        $created = date('Y-m-d');
        if (strtotime($jam_mulai) >= strtotime($jam_selesai)) { // validasi jam mulai jam akhir
            $sukses = 4;
        }else{
            //Insert ke table peminjaman_barang
            $sql="INSERT INTO tb_peminjaman_barang (no_pengajuan, nim_peminjam, nama_peminjam, tanggal, mulai_pinjam, selesai_pinjam, jumlah_pengguna, keperluan, status,  created_by, created_date) values ('$no_pengajuan_new','$nim', '$nama', '$tanggal', '$jam_mulai', '$jam_selesai', '$jumlah', '$keperluan', 'Pengajuan', '$nim', '$created')";
            $query = $this->db->query($sql);
            //Get ID peminjaman_barang
            $id_peminjaman_barang = $this->db->insert_id();

            // Get Data Keranjang
            $InsertCart = array();
            foreach ($CartData as $key) {
                $InsertCart[] = array(
                    //get id_peminjaman barang barusan
                        'id_peminjaman_barang' => $id_peminjaman_barang,
                        'id_barang' => $key->id_barang,
                        'jumlah' => $key->jumlah
                    );
            }
            $this->db->insert_batch('tb_detail_barang',$InsertCart);
            $sukses = 1;
        }
        return $sukses;
    }
    function deleteKeranjang(){
        $nim = $_COOKIE['nim'];
        $where = array(
            'nim' => $nim
            );
        $this->db->where($where);
        $this->db->delete("tb_keranjang");
    }
    function getRiwayat($id){
        $sql = "SELECT * FROM tb_peminjaman_barang where id_peminjaman_barang = $id";
        return $this->db->query($sql)->result(); 
    }
    function getDetilPeminjamanBarang($id){
        $sql = "SELECT c.nama_barang,b.jumlah FROM tb_peminjaman_barang AS a INNER JOIN tb_detail_barang AS b ON a.id_peminjaman_barang = b.id_peminjaman_barang INNER JOIN barang AS c ON b.id_barang = c.id_barang WHERE a.id_peminjaman_barang = $id";
        return $this->db->query($sql)->result();    
    }
    function add_jumlah(){
        $jumlah = $this->input->post('jumlah');
        $id = $this->input->post('id');
        $sql = "UPDATE tb_keranjang SET jumlah = $jumlah WHERE id = '$id'";
        $this->db->query($sql);
    }
    function min_jumlah(){
        $jumlah = $this->input->post('jumlah');
        $id = $this->input->post('id');
        $sql = "UPDATE tb_keranjang SET jumlah = $jumlah WHERE id = '$id'";
        $this->db->query($sql);
    }
    function delete_keranjang(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM tb_keranjang WHERE id = '$id';";
        $this->db->query($sql);
    }
    function getqty($idbrg){
        $sql = "SELECT jumlah FROM barang WHERE id_barang = '$idbrg'";
        return $this->db->query($sql)->result();
    }
}