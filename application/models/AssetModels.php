<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssetModels extends CI_Model
{
    function getDataAsset()
    {
        $this->db->select('*');
        $this->db->from('tb_ruangan a');
        $this->db->where('status', "Aktif");
        $query = $this->db->get();
        return $query->result();
    }
}