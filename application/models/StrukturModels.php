<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StrukturModels extends CI_Model
{
    function getDataMember()
    {
        $this->db->select('*');
        $this->db->from('pengguna');
        $this->db->where('status_pengguna', "Aktif");
        $query = $this->db->get();
        return $query->result();
    }
}
