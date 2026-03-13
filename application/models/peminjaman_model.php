<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) 
    {
        
        $this->db->insert('tb_peminjaman', $data);
    }

    function checkAvailable($id_ruangan, $tanggal)
    {
        $multiClause = array('id_ruangan' => $id_ruangan, 'tanggal' => $tanggal);

        $this->db->where($multiClause);
        $query = $this->db->get('tb_peminjaman');
        return $query->result();
    }
}

?>