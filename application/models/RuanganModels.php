<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RuanganModels extends CI_Model
{

    function getDataRuangan()
    {
        $sql = "SELECT a.id_ruangan, a.status_ruangan, a.nama_ruangan FROM ruangan AS a WHERE a.status_ruangan = 'Aktif' ORDER BY a.nama_ruangan;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getDataRuanganDetail($id)
    {
        $this->db->select('*');
        $this->db->from('tb_ruangan a');
        $this->db->where('a.id_ruangan', $id);
        $query = $this->db->get();
        return $query->result();

        // $this->db->where('id_ruangan',$id);
        // $query = $this->db->get('tb_ruangan');
        // return $query->row();

    }
    function getGaleriRuanganDetail($id)
    {
        $this->db->select('*');
        $this->db->from('tb_galeri a');
        $this->db->where('a.id_ruangan', $id);
        $query = $this->db->get();
        return $query->result();

        // $this->db->where('id_ruangan',$id);
        // $query = $this->db->get('tb_ruangan');
        // return $query->row();

    }
    function getFasilitasRuanganDetail($id)
    {
        $sql = "SELECT b.nama_fasilitas, b.gambar_fasilitas FROM tb_detil_fasilitas as a join tb_fasilitas as b on b.id_fasilitas = a.id_fasilitas WHERE b.status = '1' and a.id_ruangan = $id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function simpanRuangan($no_pengajuan_new)
    {
        $nim = $this->input->post('nim');
        $nama = $this->input->post('nama');
        $ruangan = $this->input->post('idruangan');
        $tanggal = $this->input->post('tanggal');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $jumlah = $this->input->post('jumlah');
        $keperluan = $this->input->post('keperluan');
        $nim = $this->input->post('nim');
        $sukses = 2;
        $created = date('Y-m-d');
        if (strtotime($jam_mulai) >= strtotime($jam_selesai)) { // validasi jam mulai jam akhir
            $sukses = 4; // alert
        } else {
            $sqlValidasi = "SELECT count(a.id_peminjaman) as 'total' FROM `tb_peminjaman` as a WHERE '$tanggal' = a.tanggal AND ( (a.mulai_pinjam BETWEEN '$jam_mulai' AND '$jam_selesai') OR (a.selesai_pinjam BETWEEN '$jam_mulai' AND '$jam_selesai') or ('$jam_mulai' BETWEEN a.mulai_pinjam AND a.selesai_pinjam) OR ('$jam_selesai' BETWEEN a.mulai_pinjam AND a.selesai_pinjam)) AND a.id_ruangan = '$ruangan'";
            $query = $this->db->query($sqlValidasi);
            $query->result();
            foreach ($query->result() as $row) {
                if ($row->total > 0) {
                    $sukses = 3;
                }
            }
            if ($sukses != 3) {
                $sql = "INSERT INTO tb_peminjaman (no_pengajuan, nim_peminjam, nama_peminjam, id_ruangan, tanggal, mulai_pinjam, selesai_pinjam, jumlah_pengguna, keperluan, status,  created_by, created_date) values ('$no_pengajuan_new','$nim', '$nama', '$ruangan', '$tanggal', '$jam_mulai', '$jam_selesai', '$jumlah', '$keperluan', 'Pengajuan', '$nim', '$created')";
                $Data['sukses'] = $sql;
                $query = $this->db->query($sql);
                $sukses = 0;
                if ($this->db->affected_rows()) {
                    $sukses = 1;
                }
            }
        }
        return $sukses;
    }
    public function getnoPengajuan()
    {
        $sql = "SELECT no_pengajuan FROM tb_peminjaman ORDER BY id_peminjaman DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function getRiwayat($id)
    {
        $sql = "SELECT a.*,b.* FROM tb_peminjaman AS a INNER JOIN tb_ruangan AS b ON a.id_ruangan = b.id_ruangan WHERE id_peminjaman = '$id'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function getSOPRuanganDetail($id){
        $sql = "SELECT b.nama_sop,b.file_sop FROM tb_detil_sop AS a INNER JOIN tb_sop AS b ON a.id_sop = b.id_sop WHERE a.id_ruangan = '$id' AND b.status = 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
}