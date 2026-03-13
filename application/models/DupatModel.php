<?php defined('BASEPATH') or exit('No direct script access allowed');

class DupatModel extends CI_Model
{
    private $tableDupat = "siso_msdupat";
    private $tableDtlDupat = "siso_msdtldupat";

    /**
     * Get all dupat data with filter
     */
    public function getDataDupatFiltered($start_date = null, $end_date = null, $status = null)
    {
        $where = "";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(d.tanggal_dupat) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(d.tanggal_dupat) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND d.status_dupat = ? ";
            $params[] = $status;
        }

        $sql = "SELECT d.*, p.nama_pengguna 
                FROM siso_msdupat d 
                LEFT JOIN pengguna p ON d.id_pengguna = p.id_pengguna 
                WHERE d.id_dupat IS NOT NULL $where
                ORDER BY CASE d.status_dupat
                    WHEN 'Draft' THEN 1
                    WHEN 'On Progress Approval Koordinator UPT' THEN 2
                    WHEN 'Approved' THEN 3
                    WHEN 'Rejected' THEN 4
                    ELSE 5
                END, d.tanggal_dupat DESC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Get dupat by ID
     */
    public function getDupatById($id_dupat)
    {
        $sql = "SELECT d.*, p.nama_pengguna 
                FROM siso_msdupat d 
                LEFT JOIN pengguna p ON d.id_pengguna = p.id_pengguna 
                WHERE d.id_dupat = ?";
        return $this->db->query($sql, [$id_dupat])->row();
    }

    /**
     * Get detail dupat by id_dupat
     */
    public function getDtlDupatByIdDupat($id_dupat)
    {
        $sql = "SELECT dd.*, b.nama_barang, b.nomor_aktiva, b.gambar_barang, b.kategori_barang, b.tipe_barang,
                       r.nama_ruangan, p.nama_penyimpanan
                FROM siso_msdtldupat dd
                JOIN barang b ON dd.id_barang = b.id_barang
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan ps ON drp.id_penyimpanan = ps.id_penyimpanan
                LEFT JOIN penyimpanan p ON dd.id_penyimpanan = p.id_penyimpanan
                WHERE dd.id_dupat = ?";
        return $this->db->query($sql, [$id_dupat])->result();
    }

    /**
     * Save new dupat session
     */
    public function saveDupat($data)
    {
        $this->db->insert($this->tableDupat, $data);
        return $this->db->insert_id();
    }

    /**
     * Update dupat session
     */
    public function updateDupat($id_dupat, $data)
    {
        $this->db->where('id_dupat', $id_dupat);
        return $this->db->update($this->tableDupat, $data);
    }

    /**
     * Update dupat status
     */
    public function updateDupatStatus($id_dupat, $status, $disetujui_oleh = null, $alasan_penolakan = null)
    {
        $data = [
            'status_dupat' => $status,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d H:i:s')
        ];

        if ($disetujui_oleh) {
            $data['disetujui_oleh'] = $disetujui_oleh;
            $data['tanggal_persetujuan'] = date('Y-m-d');
        }

        if ($alasan_penolakan) {
            $data['alasan_penolakan'] = $alasan_penolakan;
        }

        $this->db->where('id_dupat', $id_dupat);
        return $this->db->update($this->tableDupat, $data);
    }

    /**
     * Delete dupat (only Draft status)
     */
    public function deleteDupat($id_dupat)
    {
        // First delete detail records
        $this->db->where('id_dupat', $id_dupat);
        $this->db->delete($this->tableDtlDupat);
        
        // Then delete master record
        $this->db->where('id_dupat', $id_dupat);
        return $this->db->delete($this->tableDupat);
    }

    /**
     * Save detail dupat
     */
    public function saveDtlDupat($data)
    {
        return $this->db->insert($this->tableDtlDupat, $data);
    }

    /**
     * Update detail dupat
     */
    public function updateDtlDupat($id_dtl_dupat, $data)
    {
        $this->db->where('id_dtl_dupat', $id_dtl_dupat);
        return $this->db->update($this->tableDtlDupat, $data);
    }

    /**
     * Delete detail dupat
     */
    public function deleteDtlDupat($id_dtl_dupat)
    {
        $this->db->where('id_dtl_dupat', $id_dtl_dupat);
        return $this->db->delete($this->tableDtlDupat);
    }

    /**
     * Check if item already exists in dupat
     */
    public function checkItemInDupat($id_dupat, $id_barang)
    {
        $this->db->where('id_dupat', $id_dupat);
        $this->db->where('id_barang', $id_barang);
        return $this->db->get($this->tableDtlDupat)->row();
    }

    /**
     * Get available barang for dupat page (excludes items already in this dupat,
     * or in any active Mutasi)
     * Stock Opname does NOT block items - it only updates barang data
     * Returns all items (Asset & Non Asset, Consumable & Non Consumable)
     * Only includes items with jumlah_barang > 0
     */
    public function getAvailableBarangForDupatPage($id_dupat)
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
                    SELECT dd.id_barang FROM siso_msdtldupat dd WHERE dd.id_dupat = ?
                )
                AND b.id_barang NOT IN (
                    SELECT dd2.id_barang FROM siso_msdtldupat dd2 
                    INNER JOIN siso_msdupat d ON dd2.id_dupat = d.id_dupat 
                    WHERE d.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT') AND dd2.id_dupat != ?
                )
                AND b.id_barang NOT IN (
                    SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                    INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                    WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                ORDER BY b.nomor_aktiva";
        return $this->db->query($sql, [$id_dupat, $id_dupat])->result();
    }

    /**
     * Get count of items in dupat
     */
    public function countItemsInDupat($id_dupat)
    {
        $this->db->where('id_dupat', $id_dupat);
        return $this->db->count_all_results($this->tableDtlDupat);
    }

    /**
     * Get all dupat data with filter for Koordinator UPT (excludes Draft status)
     */
    public function getDataDupatFilteredKoorUPT($start_date = null, $end_date = null, $status = null)
    {
        $where = " AND d.status_dupat != 'Draft' ";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(d.tanggal_dupat) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(d.tanggal_dupat) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND d.status_dupat = ? ";
            $params[] = $status;
        }

        $sql = "SELECT d.*, p.nama_pengguna 
                FROM siso_msdupat d 
                LEFT JOIN pengguna p ON d.id_pengguna = p.id_pengguna 
                WHERE d.id_dupat IS NOT NULL $where
                ORDER BY CASE d.status_dupat
                    WHEN 'On Progress Approval Koordinator UPT' THEN 1
                    WHEN 'Approved' THEN 2
                    WHEN 'Rejected' THEN 3
                    ELSE 4
                END, d.tanggal_dupat DESC";

        return $this->db->query($sql, $params)->result();
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
     * Get dupat pending approval for more than X days (for auto-approval)
     * Uses modified_date as the date when status was changed to pending approval
     * @param int $days Number of days threshold
     * @return array Dupat records pending approval > X days
     */
    public function getPendingApprovalOverDays($days = 3)
    {
        $sql = "SELECT d.* 
                FROM siso_msdupat d 
                WHERE d.status_dupat = 'On Progress Approval Koordinator UPT' 
                AND DATEDIFF(CURDATE(), COALESCE(DATE(d.modified_date), d.tanggal_dupat)) > ?
                ORDER BY d.id_dupat ASC";
        return $this->db->query($sql, [$days])->result();
    }

    /**
     * Auto approve dupat (for cron job)
     * @param int $id_dupat Dupat ID
     * @return bool Success status
     */
    public function autoApproveDupat($id_dupat)
    {
        $data = [
            'status_dupat' => 'Approved',
            'disetujui_oleh' => 'SYSTEM_AUTO_APPROVE',
            'tanggal_persetujuan' => date('Y-m-d'),
            'modified_by' => 'SYSTEM_AUTO_APPROVE',
            'modified_date' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id_dupat', $id_dupat);
        return $this->db->update($this->tableDupat, $data);
    }
}
