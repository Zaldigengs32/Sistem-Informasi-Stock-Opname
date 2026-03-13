<?php defined('BASEPATH') or exit('No direct script access allowed');

class MutasiModel extends CI_Model
{
    private $tableMutasi = "siso_msmutasi";
    private $tableDtlMutasi = "siso_ms_dtlmutasi";

    /**
     * Get all mutasi data
     */
    public function getDataMutasi()
    {
        $sql = "SELECT m.*, p.nama_pengguna 
                FROM siso_msmutasi m 
                LEFT JOIN pengguna p ON m.id_pengguna = p.id_pengguna 
                ORDER BY CASE m.status_mutasi
                    WHEN 'Draft' THEN 1
                    WHEN 'Pending' THEN 2
                    WHEN 'On Progress Approval Koordinator UPT' THEN 4
                    WHEN 'Approved' THEN 5
                    WHEN 'Rejected' THEN 6
                    ELSE 7
                END, m.id_mutasi DESC";
        return $this->db->query($sql)->result();
    }

    /**
     * Get mutasi data with filter (for PIC Asset - shows all including Draft)
     */
    public function getDataMutasiFiltered($start_date = null, $end_date = null, $status = null)
    {
        $where = "";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(m.tanggal_mutasi) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(m.tanggal_mutasi) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND m.status_mutasi = ? ";
            $params[] = $status;
        }

        $sql = "SELECT m.*, p.nama_pengguna 
                FROM siso_msmutasi m 
                LEFT JOIN pengguna p ON m.id_pengguna = p.id_pengguna 
                WHERE m.id_mutasi IS NOT NULL $where
                ORDER BY CASE m.status_mutasi
                    WHEN 'Draft' THEN 1
                    WHEN 'Pending' THEN 2
                    WHEN 'On Progress Approval PIC Asset' THEN 3
                    WHEN 'On Progress Approval Koordinator UPT' THEN 4
                    WHEN 'Approved' THEN 5
                    WHEN 'Rejected' THEN 6
                    ELSE 7
                END, m.id_mutasi DESC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Get mutasi data with filter (for Koordinator UPT - excludes Draft)
     */
    public function getDataMutasiFilteredKoorUPT($start_date = null, $end_date = null, $status = null)
    {
        $where = " AND m.status_mutasi != 'Draft' ";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(m.tanggal_mutasi) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(m.tanggal_mutasi) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND m.status_mutasi = ? ";
            $params[] = $status;
        }

        $sql = "SELECT m.*, p.nama_pengguna 
                FROM siso_msmutasi m 
                LEFT JOIN pengguna p ON m.id_pengguna = p.id_pengguna 
                WHERE m.id_mutasi IS NOT NULL $where
                ORDER BY CASE m.status_mutasi
                    WHEN 'On Progress Approval Koordinator UPT' THEN 1
                    WHEN 'Approved' THEN 2
                    WHEN 'Rejected' THEN 3
                    ELSE 4
                END, m.id_mutasi DESC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Get detail mutasi by id_mutasi
     */
    public function getDtlMutasiByIdMutasi($id_mutasi)
    {
        $sql = "SELECT dm.*, b.nama_barang, b.nomor_aktiva, b.gambar_barang, b.kategori_barang, b.tipe_barang
                FROM siso_ms_dtlmutasi dm
                JOIN barang b ON dm.id_barang = b.id_barang
                WHERE dm.id_mutasi = ?";
        return $this->db->query($sql, [$id_mutasi])->result();
    }

    /**
     * Get mutasi by ID
     */
    public function getMutasiById($id_mutasi)
    {
        $sql = "SELECT m.*, p.nama_pengguna 
                FROM siso_msmutasi m 
                LEFT JOIN pengguna p ON m.id_pengguna = p.id_pengguna 
                WHERE m.id_mutasi = ?";
        return $this->db->query($sql, [$id_mutasi])->row();
    }

    /**
     * Save new mutasi
     */
    public function saveMutasi($data)
    {
        $this->db->insert($this->tableMutasi, $data);
        return $this->db->insert_id();
    }

    /**
     * Save detail mutasi
     */
    public function saveDtlMutasi($data)
    {
        return $this->db->insert($this->tableDtlMutasi, $data);
    }

    /**
     * Update mutasi status
     */
    public function updateMutasiStatus($id_mutasi, $status, $disetujui_oleh = null)
    {
        $data = [
            'status_mutasi' => $status,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d')
        ];

        if ($disetujui_oleh) {
            $data['disetujui_oleh'] = $disetujui_oleh;
            $data['tanggal_persetujuan'] = date('Y-m-d');
        }

        $this->db->where('id_mutasi', $id_mutasi);
        return $this->db->update($this->tableMutasi, $data);
    }

    /**
     * Get ruangan list for dropdown
     */
    public function getRuanganList()
    {
        $sql = "SELECT id_ruangan, nama_ruangan FROM ruangan WHERE status_ruangan = 'Aktif' ORDER BY nama_ruangan";
        return $this->db->query($sql)->result();
    }

    /**
     * Get available barang for mutasi
     */
    public function getAvailableBarang()
    {
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, b.kategori_barang, 
                       r.nama_ruangan, p.nama_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                WHERE b.status_barang = 'Aktif' AND b.ketersediaan_barang = 'Available'
                ORDER BY b.nama_barang";
        return $this->db->query($sql)->result();
    }

    /**
     * Get available barang for mutasi filtered by origin location
     * If lokasi_asal is 'UPT-Informatika', return all available barang
     */
    public function getAvailableBarangByLocation($lokasi_asal)
    {
        // If origin is UPT-Informatika, get all available barang
        if ($lokasi_asal === 'UPT-Informatika') {
            $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, b.kategori_barang, 
                           r.nama_ruangan, p.nama_penyimpanan
                    FROM barang b
                    LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                    LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                    LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                    WHERE b.status_barang = 'Aktif' AND b.ketersediaan_barang = 'Available'
                    ORDER BY b.nomor_aktiva";
            return $this->db->query($sql)->result();
        }
        
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, b.kategori_barang, 
                       r.nama_ruangan, p.nama_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                WHERE b.status_barang = 'Aktif' AND b.ketersediaan_barang = 'Available'
                AND r.nama_ruangan = ?
                ORDER BY b.nomor_aktiva";
        return $this->db->query($sql, [$lokasi_asal])->result();
    }

    /**
     * Update mutasi data
     */
    public function updateMutasi($id_mutasi, $data)
    {
        $this->db->where('id_mutasi', $id_mutasi);
        return $this->db->update($this->tableMutasi, $data);
    }

    /**
     * Delete mutasi (only Draft status)
     */
    public function deleteMutasi($id_mutasi)
    {
        // First delete detail records
        $this->db->where('id_mutasi', $id_mutasi);
        $this->db->delete($this->tableDtlMutasi);
        
        // Then delete master record
        $this->db->where('id_mutasi', $id_mutasi);
        return $this->db->delete($this->tableMutasi);
    }

    /**
     * Update detail mutasi
     */
    public function updateDtlMutasi($id_dtl_mutasi, $data)
    {
        $this->db->where('id_dtl_mutasi', $id_dtl_mutasi);
        return $this->db->update($this->tableDtlMutasi, $data);
    }

    /**
     * Delete detail mutasi
     */
    public function deleteDtlMutasi($id_dtl_mutasi)
    {
        $this->db->where('id_dtl_mutasi', $id_dtl_mutasi);
        return $this->db->delete($this->tableDtlMutasi);
    }

    /**
     * Get ruangan ID by name
     */
    public function getRuanganIdByName($nama_ruangan)
    {
        $this->db->select('id_ruangan');
        $this->db->where('nama_ruangan', $nama_ruangan);
        $this->db->where('status_ruangan', 'Aktif');
        $result = $this->db->get('ruangan')->row();
        return $result ? $result->id_ruangan : null;
    }

    /**
     * Get default penyimpanan by ruangan (first available)
     */
    public function getDefaultPenyimpananByRuangan($id_ruangan)
    {
        $this->db->select('id_dtl_penyimpanan');
        $this->db->where('id_ruangan', $id_ruangan);
        $this->db->where('status_detail', 'Aktif');
        $this->db->limit(1);
        $result = $this->db->get('dtl_ruangan_penyimpanan')->row();
        return $result ? $result->id_dtl_penyimpanan : null;
    }

    /**
     * Update barang location (for internal mutation)
     */
    public function updateBarangLocation($id_barang, $id_dtl_penyimpanan)
    {
        $data = [
            'id_dtl_penyimpanan' => $id_dtl_penyimpanan,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d')
        ];
        $this->db->where('id_barang', $id_barang);
        return $this->db->update('barang', $data);
    }

    /**
     * Update barang status for external mutation (mark as moved out)
     */
    public function updateBarangStatusMutasiExternal($id_barang, $lokasi_tujuan)
    {
        $data = [
            'status_barang' => 'Mutasi Keluar',
            'ketersediaan_barang' => 'Not Available',
            'keterangan_penyimpanan' => 'Dimutasi ke: ' . $lokasi_tujuan,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d')
        ];
        $this->db->where('id_barang', $id_barang);
        return $this->db->update('barang', $data);
    }

    /**
     * Get institusi/lembaga list for dropdown
     */
    public function getInstitusiList()
    {
        $sql = "SELECT id, nama_lembaga FROM lembaga ORDER BY nama_lembaga";
        return $this->db->query($sql)->result();
    }

    /**
     * Get available barang for mutation page (excludes items already in this mutation, 
     * or in any active Dupat)
     * Stock Opname does NOT block items - it only updates barang data
     * Returns all items (Asset & Non Asset, Consumable & Non Consumable)
     * Only includes items with jumlah_barang > 0
     */
    public function getAvailableBarangForMutasiPage($id_mutasi)
    {
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, 
                       b.kategori_barang, b.tipe_barang, b.kondisi_barang, b.jumlah_barang,
                       r.nama_ruangan, p.nama_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                WHERE b.status_barang = 'Aktif' 
                AND b.jumlah_barang > 0
                AND b.id_barang NOT IN (
                    SELECT dm.id_barang FROM siso_ms_dtlmutasi dm WHERE dm.id_mutasi = ?
                )
                AND b.id_barang NOT IN (
                    SELECT dm2.id_barang FROM siso_ms_dtlmutasi dm2 
                    INNER JOIN siso_msmutasi m ON dm2.id_mutasi = m.id_mutasi 
                    WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT') AND dm2.id_mutasi != ?
                )
                AND b.id_barang NOT IN (
                    SELECT dd.id_barang FROM siso_msdtldupat dd 
                    INNER JOIN siso_msdupat d ON dd.id_dupat = d.id_dupat 
                    WHERE d.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                ORDER BY b.nomor_aktiva";
        return $this->db->query($sql, [$id_mutasi, $id_mutasi])->result();
    }

    /**
     * Check if item already exists in mutation
     */
    public function checkItemInMutasi($id_mutasi, $id_barang)
    {
        $this->db->where('id_mutasi', $id_mutasi);
        $this->db->where('id_barang', $id_barang);
        return $this->db->get($this->tableDtlMutasi)->row();
    }

    /**
     * Get penyimpanan list with id_ruangan for dropdown filter
     */
    public function getPenyimpananList()
    {
        $sql = "SELECT DISTINCT p.id_penyimpanan, p.nama_penyimpanan, drp.id_ruangan 
                FROM penyimpanan p
                JOIN dtl_ruangan_penyimpanan drp ON p.id_penyimpanan = drp.id_penyimpanan
                WHERE p.status_penyimpanan = 'Aktif' AND drp.status_detail = 'Aktif'
                ORDER BY p.nama_penyimpanan";
        return $this->db->query($sql)->result();
    }

    /**
     * Get mutasi pending approval for more than X days (for auto-approval)
     * Uses modified_date as the date when status was changed to pending approval
     * @param int $days Number of days threshold
     * @return array Mutasi records pending approval > X days
     */
    public function getPendingApprovalOverDays($days = 3)
    {
        $sql = "SELECT m.* 
                FROM siso_msmutasi m 
                WHERE m.status_mutasi = 'On Progress Approval Koordinator UPT' 
                AND DATEDIFF(CURDATE(), COALESCE(m.modified_date, m.tanggal_mutasi)) > ?
                ORDER BY m.id_mutasi ASC";
        return $this->db->query($sql, [$days])->result();
    }

    /**
     * Auto approve mutasi (for cron job)
     * @param int $id_mutasi Mutasi ID
     * @return bool Success status
     */
    public function autoApproveMutasi($id_mutasi)
    {
        $data = [
            'status_mutasi' => 'Approved',
            'disetujui_oleh' => 'SYSTEM_AUTO_APPROVE',
            'tanggal_persetujuan' => date('Y-m-d'),
            'modified_by' => 'SYSTEM_AUTO_APPROVE',
            'modified_date' => date('Y-m-d')
        ];
        
        $this->db->where('id_mutasi', $id_mutasi);
        return $this->db->update($this->tableMutasi, $data);
    }
}
