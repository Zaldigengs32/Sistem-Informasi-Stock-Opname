<?php defined('BASEPATH') or exit('No direct script access allowed');

class StockOpnameModel extends CI_Model
{
    private $tableStockOpname = "siso_msstockopname";
    private $tableDtlStockOpname = "siso_msdtlstockopname";

    /**
     * Get all stock opname data
     */
    public function getDataStockOpname()
    {
        $sql = "SELECT so.*, p.nama_pengguna 
                FROM siso_msstockopname so 
                LEFT JOIN pengguna p ON so.so_pic = p.id_pengguna 
                ORDER BY CASE so.so_status
                    WHEN 'Draft' THEN 1
                    WHEN 'On Progress Approval Koor UPT' THEN 2
                    WHEN 'Approved' THEN 3
                    WHEN 'Rejected' THEN 4
                    ELSE 5
                END, so.so_id_opname DESC";
        return $this->db->query($sql)->result();
    }

    /**
     * Get stock opname data with filter
     */
    public function getDataStockOpnameFiltered($start_date = null, $end_date = null, $status = null)
    {
        $where = "";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(so.so_start_date) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(so.so_end_date) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND so.so_status = ? ";
            $params[] = $status;
        }

        $sql = "SELECT so.*, p.nama_pengguna 
                FROM siso_msstockopname so 
                LEFT JOIN pengguna p ON so.so_pic = p.id_pengguna 
                WHERE so.so_id_opname IS NOT NULL $where
                ORDER BY CASE so.so_status
                    WHEN 'Draft' THEN 1
                    WHEN 'On Progress Approval Koor UPT' THEN 2
                    WHEN 'Approved' THEN 3
                    WHEN 'Rejected' THEN 4
                    ELSE 5
                END, so.so_id_opname DESC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Get stock opname by ID
     */
    public function getStockOpnameById($id_opname)
    {
        $sql = "SELECT so.*, p.nama_pengguna 
                FROM siso_msstockopname so 
                LEFT JOIN pengguna p ON so.so_pic = p.id_pengguna 
                WHERE so.so_id_opname = ?";
        return $this->db->query($sql, [$id_opname])->row();
    }

    /**
     * Get detail stock opname by id_opname
     */
    public function getDtlStockOpnameByIdOpname($id_opname)
    {
        $sql = "SELECT d.*, b.nama_barang, b.nomor_aktiva, b.gambar_barang,
                       r.nama_ruangan, p.nama_penyimpanan
                FROM siso_msdtlstockopname d
                JOIN barang b ON d.id_barang = b.id_barang
                LEFT JOIN ruangan r ON d.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON d.id_penyimpanan = p.id_penyimpanan
                WHERE d.so_id_opname = ?
                ORDER BY d.id_detail DESC";
        return $this->db->query($sql, [$id_opname])->result();
    }

    /**
     * Save new stock opname session
     */
    public function saveStockOpname($data)
    {
        $this->db->insert($this->tableStockOpname, $data);
        return $this->db->insert_id();
    }

    /**
     * Generate document number for stock opname
     * Format: 01/UPTIF/AST/SO/IV/2025
     * 01 = auto increment per month
     * UPTIF = Unit
     * AST = Asset
     * SO = Stock Opname
     * IV = Roman numeral month
     * 2025 = Year
     */
    public function generateDocumentNumber($date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }
        
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-12
        
        // Convert month to Roman numeral
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $romanMonth = $romanMonths[$month - 1];
        
        // Get count of stock opname in this month
        $sql = "SELECT COUNT(*) as count 
                FROM {$this->tableStockOpname} 
                WHERE YEAR(so_start_date) = ? AND MONTH(so_start_date) = ?";
        $result = $this->db->query($sql, [$year, $month])->row();
        
        // Increment number (start from 01)
        $number = str_pad($result->count + 1, 2, '0', STR_PAD_LEFT);
        
        // Format: 01/UPTIF/AST/SO/IV/2025
        return "{$number}/UPTIF/AST/SO/{$romanMonth}/{$year}";
    }

    /**
     * Get document number for stock opname
     * If not exists, generate new one
     */
    public function getDocumentNumber($id_opname)
    {
        $sql = "SELECT so_document_number, so_start_date FROM {$this->tableStockOpname} WHERE so_id_opname = ?";
        $result = $this->db->query($sql, [$id_opname])->row();
        
        if ($result && !empty($result->so_document_number)) {
            return $result->so_document_number;
        }
        
        // Generate if not exists
        if ($result) {
            $docNumber = $this->generateDocumentNumber($result->so_start_date);
            
            // Update database
            $this->db->where('so_id_opname', $id_opname);
            $this->db->update($this->tableStockOpname, ['so_document_number' => $docNumber]);
            
            return $docNumber;
        }
        
        return null;
    }

    /**
     * Save detail stock opname
     */
    public function saveDtlStockOpname($data)
    {
        return $this->db->insert($this->tableDtlStockOpname, $data);
    }

    /**
     * Update stock opname
     */
    public function updateStockOpname($id_opname, $data)
    {
        $this->db->where('so_id_opname', $id_opname);
        return $this->db->update($this->tableStockOpname, $data);
    }

    /**
     * Update stock opname status
     */
    public function updateStockOpnameStatus($id_opname, $status, $reject_reason = null)
    {
        $data = [
            'so_status' => $status,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d H:i:s')
        ];

        // Update end_date when sending for approval or when approved
        if ($status == 'On Progress Approval Koor UPT' || $status == 'Approved') {
            $data['so_end_date'] = date('Y-m-d');
        }

        if ($reject_reason) {
            $data['so_reject_reason'] = $reject_reason;
        }

        $this->db->where('so_id_opname', $id_opname);
        return $this->db->update($this->tableStockOpname, $data);
    }


    /**
     * Delete stock opname (only Draft status)
     */
    public function deleteStockOpname($id_opname)
    {
        // First delete detail records
        $this->db->where('so_id_opname', $id_opname);
        $this->db->delete($this->tableDtlStockOpname);
        
        // Then delete master record
        $this->db->where('so_id_opname', $id_opname);
        return $this->db->delete($this->tableStockOpname);
    }

    /**
     * Update detail stock opname
     */
    public function updateDtlStockOpname($id_detail, $data)
    {
        $this->db->where('id_detail', $id_detail);
        return $this->db->update($this->tableDtlStockOpname, $data);
    }

    /**
     * Get detail stock opname by id_detail
     */
    public function getDetailById($id_detail)
    {
        $sql = "SELECT * FROM siso_msdtlstockopname WHERE id_detail = ?";
        return $this->db->query($sql, [$id_detail])->row();
    }

    /**
     * Delete detail stock opname
     */
    public function deleteDtlStockOpname($id_detail)
    {
        $this->db->where('id_detail', $id_detail);
        return $this->db->delete($this->tableDtlStockOpname);
    }

    /**
     * Delete all detail stock opname by so_id_opname
     * Used when rejecting stock opname to return all items to available list
     */
    public function deleteAllDtlStockOpname($so_id_opname)
    {
        $this->db->where('so_id_opname', $so_id_opname);
        return $this->db->delete($this->tableDtlStockOpname);
    }

    /**
     * Update total item count
     */
    public function updateTotalItem($id_opname)
    {
        $sql = "SELECT COUNT(*) as total FROM siso_msdtlstockopname WHERE so_id_opname = ?";
        $result = $this->db->query($sql, [$id_opname])->row();
        
        $this->db->where('so_id_opname', $id_opname);
        return $this->db->update($this->tableStockOpname, ['so_total_item' => $result->total]);
    }

    /**
     * Get item count for stock opname
     */
    public function getItemCount($id_opname)
    {
        $sql = "SELECT COUNT(*) as count FROM siso_msdtlstockopname WHERE so_id_opname = ?";
        return $this->db->query($sql, [$id_opname])->row()->count;
    }

    /**
     * Get barang list for dropdown
     */
    public function getBarangList()
    {
        $sql = "SELECT id_barang, nama_barang, nomor_aktiva FROM barang WHERE status_barang = 'Aktif' ORDER BY nama_barang";
        return $this->db->query($sql)->result();
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
     * Get ruangan list for dropdown - filtered by PIC
     */
    public function getRuanganListByPIC($npk)
    {
        $sql = "SELECT id_ruangan, nama_ruangan FROM ruangan WHERE status_ruangan = 'Aktif' AND pic_ruangan = ? ORDER BY nama_ruangan";
        return $this->db->query($sql, [$npk])->result();
    }

    /**
     * Get penyimpanan list for dropdown
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
     * Get penyimpanan list for dropdown - filtered by PIC's rooms
     */
    public function getPenyimpananListByPIC($npk)
    {
        $sql = "SELECT DISTINCT p.id_penyimpanan, p.nama_penyimpanan, drp.id_ruangan 
                FROM penyimpanan p
                JOIN dtl_ruangan_penyimpanan drp ON p.id_penyimpanan = drp.id_penyimpanan
                JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                WHERE p.status_penyimpanan = 'Aktif' AND drp.status_detail = 'Aktif' AND r.pic_ruangan = ?
                ORDER BY p.nama_penyimpanan";
        return $this->db->query($sql, [$npk])->result();
    }

    /**
     * Get available barang for stock opname (excludes items already in this session only)
     * Each stock opname session is independent - items from other sessions can be added
     * Only excludes items in active Mutasi/Dupat
     * Returns all items (Asset & Non Asset, Consumable & Non Consumable)
     */
    public function getAvailableBarangForOpname($id_opname)
    {
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, 
                       b.kategori_barang, b.tipe_barang, b.kondisi_barang, b.jumlah_barang,
                       r.nama_ruangan, p.nama_penyimpanan, r.id_ruangan, p.id_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                LEFT JOIN siso_msdtlstockopname dtl_current ON b.id_barang = dtl_current.id_barang AND dtl_current.so_id_opname = ?
                LEFT JOIN siso_msstockopname so_current ON dtl_current.so_id_opname = so_current.so_id_opname
                WHERE b.status_barang = 'Aktif' 
                AND (dtl_current.id_barang IS NULL OR so_current.so_status = 'Rejected')
                AND b.id_barang NOT IN (
                    SELECT dd.id_barang FROM siso_msdtldupat dd 
                    INNER JOIN siso_msdupat dupat ON dd.id_dupat = dupat.id_dupat 
                    WHERE dupat.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                AND b.id_barang NOT IN (
                    SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                    INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                    WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                ORDER BY b.nama_barang";
        return $this->db->query($sql, [$id_opname])->result();
    }

    /**
     * Get available barang for stock opname - PIC Non Asset
     * Only returns items with kategori_barang = 'Non Asset'
     * Each stock opname session is independent - items from other sessions can be added
     */
    public function getAvailableBarangForOpnamePICNonAsset($id_opname)
    {
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, 
                       b.kategori_barang, b.tipe_barang, b.kondisi_barang, b.jumlah_barang,
                       r.nama_ruangan, p.nama_penyimpanan, r.id_ruangan, p.id_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                LEFT JOIN siso_msdtlstockopname dtl_current ON b.id_barang = dtl_current.id_barang AND dtl_current.so_id_opname = ?
                LEFT JOIN siso_msstockopname so_current ON dtl_current.so_id_opname = so_current.so_id_opname
                WHERE b.status_barang = 'Aktif' 
                AND b.kategori_barang = 'Non Asset'
                AND (dtl_current.id_barang IS NULL OR so_current.so_status = 'Rejected')
                AND b.id_barang NOT IN (
                    SELECT dd.id_barang FROM siso_msdtldupat dd 
                    INNER JOIN siso_msdupat dupat ON dd.id_dupat = dupat.id_dupat 
                    WHERE dupat.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                AND b.id_barang NOT IN (
                    SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                    INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                    WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT')
                )
                ORDER BY b.nama_barang";
        return $this->db->query($sql, [$id_opname])->result();
    }

    /**
     * Get available barang for stock opname with pagination (server-side processing)
     * Each stock opname session is independent - only excludes items already in THIS session
     * Items from rejected sessions are available again
     */
    public function getAvailableBarangForOpnamePaginated($id_opname, $start, $length, $search = '', $ruangan = '', $kondisi = '')
    {
        // Subquery to exclude items in active Dupat
        $excludeDupat = "(SELECT dd.id_barang FROM siso_msdtldupat dd 
                          INNER JOIN siso_msdupat dupat ON dd.id_dupat = dupat.id_dupat 
                          WHERE dupat.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT'))";
        
        // Subquery to exclude items in active Mutasi
        $excludeMutasi = "(SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                           INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                           WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT'))";
        
        // Base WHERE clause - exclude items already in this stock opname (unless rejected)
        $where = "b.status_barang = 'Aktif' 
                  AND (dtl_so.id_barang IS NULL OR so_current.so_status = 'Rejected')
                  AND b.id_barang NOT IN {$excludeDupat}
                  AND b.id_barang NOT IN {$excludeMutasi}";
        $params = [$id_opname];
        
        // Search filter
        if (!empty($search)) {
            $where .= " AND (b.nama_barang LIKE ? OR b.nomor_aktiva LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        // Ruangan filter
        if (!empty($ruangan)) {
            $where .= " AND r.nama_ruangan = ?";
            $params[] = $ruangan;
        }
        
        // Kondisi filter
        if (!empty($kondisi)) {
            $where .= " AND b.kondisi_barang = ?";
            $params[] = $kondisi;
        }
        
        // Count total (without filters except so_id, dupat, mutasi)
        $sqlTotal = "SELECT COUNT(*) as cnt FROM barang b 
                     LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                     LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                     WHERE b.status_barang = 'Aktif' 
                     AND (dtl_so.id_barang IS NULL OR so_current.so_status = 'Rejected')
                     AND b.id_barang NOT IN {$excludeDupat}
                     AND b.id_barang NOT IN {$excludeMutasi}";
        $total = $this->db->query($sqlTotal, [$id_opname])->row()->cnt;
        
        // Count filtered
        $sqlFiltered = "SELECT COUNT(*) as cnt FROM barang b
                        LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                        LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                        LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                        LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                        WHERE {$where}";
        $paramsFiltered = array_merge([$id_opname], $params);
        $filtered = $this->db->query($sqlFiltered, $paramsFiltered)->row()->cnt;
        
        // Get data with pagination
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, 
                       b.kategori_barang, b.tipe_barang, b.kondisi_barang, b.jumlah_barang,
                       r.nama_ruangan, p.nama_penyimpanan, r.id_ruangan, p.id_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                WHERE {$where}
                ORDER BY b.nomor_aktiva
                LIMIT ?, ?";
        $paramsData = array_merge([$id_opname], $params, [$start, $length]);
        
        $data = $this->db->query($sql, $paramsData)->result();
        
        return [
            'total' => $total,
            'filtered' => $filtered,
            'data' => $data
        ];
    }

    /**
     * Get barang by ID with location info
     */
    public function getBarangById($id_barang)
    {
        $sql = "SELECT b.*, r.id_ruangan, p.id_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                WHERE b.id_barang = ?";
        return $this->db->query($sql, [$id_barang])->row();
    }

    /**
     * Check if item already exists in stock opname
     */
    public function getExistingItem($so_id_opname, $id_barang)
    {
        $sql = "SELECT * FROM siso_msdtlstockopname WHERE so_id_opname = ? AND id_barang = ?";
        return $this->db->query($sql, [$so_id_opname, $id_barang])->row();
    }

    /**
     * Update barang table from stock opname data
     * This syncs location, quantity, and condition from stock opname to main barang table
     */
    public function updateBarangFromStockOpname($id_barang, $id_ruangan, $id_penyimpanan, $quantity, $kondisi_barang)
    {
        // Get id_dtl_penyimpanan from ruangan and penyimpanan
        $sql = "SELECT id_dtl_penyimpanan FROM dtl_ruangan_penyimpanan 
                WHERE id_ruangan = ? AND id_penyimpanan = ? AND status_detail = 'Aktif' LIMIT 1";
        $dtl = $this->db->query($sql, [$id_ruangan, $id_penyimpanan])->row();
        
        $updateData = [
            'kondisi_barang' => $kondisi_barang,
            'jumlah_barang' => $quantity,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d H:i:s')
        ];
        
        // Only update location if we found valid dtl_penyimpanan
        if ($dtl) {
            $updateData['id_dtl_penyimpanan'] = $dtl->id_dtl_penyimpanan;
        }
        
        $this->db->where('id_barang', $id_barang);
        return $this->db->update('barang', $updateData);
    }

    /**
     * Reset barang condition to Good when removed from stock opname
     */
    public function resetBarangCondition($id_barang)
    {
        $updateData = [
            'kondisi_barang' => 'Good',
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id_barang', $id_barang);
        return $this->db->update('barang', $updateData);
    }

    /**
     * Restore barang to original state when removed from stock opname
     */
    public function restoreBarangToOriginal($detail)
    {
        // Get id_dtl_penyimpanan from original ruangan and penyimpanan
        $id_dtl_penyimpanan = null;
        if (!empty($detail->original_id_ruangan) && !empty($detail->original_id_penyimpanan)) {
            $sql = "SELECT id_dtl_penyimpanan FROM dtl_ruangan_penyimpanan 
                    WHERE id_ruangan = ? AND id_penyimpanan = ? AND status_detail = 'Aktif' LIMIT 1";
            $dtl = $this->db->query($sql, [$detail->original_id_ruangan, $detail->original_id_penyimpanan])->row();
            if ($dtl) {
                $id_dtl_penyimpanan = $dtl->id_dtl_penyimpanan;
            }
        }
        
        $updateData = [
            'kondisi_barang' => !empty($detail->original_kondisi_barang) ? $detail->original_kondisi_barang : 'Good',
            'jumlah_barang' => !empty($detail->original_jumlah_barang) ? $detail->original_jumlah_barang : 1,
            'modified_by' => $this->session->userdata('id'),
            'modified_date' => date('Y-m-d H:i:s')
        ];
        
        // Only update location if we have original data
        if ($id_dtl_penyimpanan) {
            $updateData['id_dtl_penyimpanan'] = $id_dtl_penyimpanan;
        }
        
        $this->db->where('id_barang', $detail->id_barang);
        return $this->db->update('barang', $updateData);
    }

    /**
     * Get stock opname data with filter for Koordinator UPT (excludes Draft status)
     */
    public function getDataStockOpnameFilteredKoorUPT($start_date = null, $end_date = null, $status = null)
    {
        $where = " AND so.so_status != 'Draft' ";
        $params = [];

        if (!empty($start_date)) {
            $where .= " AND DATE(so.so_start_date) >= ? ";
            $params[] = $start_date;
        }

        if (!empty($end_date)) {
            $where .= " AND DATE(so.so_end_date) <= ? ";
            $params[] = $end_date;
        }

        if (!empty($status)) {
            $where .= " AND so.so_status = ? ";
            $params[] = $status;
        }

        $sql = "SELECT so.*, p.nama_pengguna 
                FROM siso_msstockopname so 
                LEFT JOIN pengguna p ON so.so_pic = p.id_pengguna 
                WHERE so.so_id_opname IS NOT NULL $where
                ORDER BY CASE so.so_status
                    WHEN 'On Progress Approval Koor UPT' THEN 1
                    WHEN 'Approved' THEN 2
                    WHEN 'Rejected' THEN 3
                    ELSE 4
                END, so.so_id_opname DESC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Get anggota for stock opname (PIC Lab and PIC Non Asset)
     */
    public function getAnggotaStockOpname()
    {
        $sql = "SELECT nama_pengguna, role_pengguna 
                FROM pengguna 
                WHERE status_pengguna = 'Aktif' 
                AND role_pengguna IN ('PIC Lab', 'PIC Non Asset', 'PIC Asset & Non Asset', 'Koordinator UPT')
                ORDER BY role_pengguna, nama_pengguna";
        return $this->db->query($sql)->result();
    }

    /**
     * Get contributors (PICs who added items) for a stock opname session
     */
    public function getContributorsByOpname($id_opname)
    {
        $sql = "SELECT DISTINCT p.nama_pengguna, p.role_pengguna
                FROM siso_msdtlstockopname d
                JOIN pengguna p ON d.created_by = p.id_pengguna
                WHERE d.so_id_opname = ?
                AND p.role_pengguna IN ('PIC Lab', 'PIC Non Asset')
                ORDER BY p.nama_pengguna";
        return $this->db->query($sql, [$id_opname])->result();
    }

    /**
     * Get stock opname pending approval for more than X days (for auto-approval)
     * Uses so_end_date as the date when status was changed to pending approval
     * @param int $days Number of days threshold
     * @return array Stock opname records pending approval > X days
     */
    public function getPendingApprovalOverDays($days = 3)
    {
        $sql = "SELECT so.* 
                FROM siso_msstockopname so 
                WHERE so.so_status = 'On Progress Approval Koor UPT' 
                AND DATEDIFF(CURDATE(), COALESCE(DATE(so.modified_date), so.so_end_date)) > ?
                ORDER BY so.so_id_opname ASC";
        return $this->db->query($sql, [$days])->result();
    }

    /**
     * Auto approve stock opname (for cron job)
     * @param int $id_opname Stock opname ID
     * @return bool Success status
     */
    public function autoApproveStockOpname($id_opname)
    {
        $data = [
            'so_status' => 'Approved',
            'so_end_date' => date('Y-m-d'),
            'modified_by' => 'SYSTEM_AUTO_APPROVE',
            'modified_date' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('so_id_opname', $id_opname);
        return $this->db->update($this->tableStockOpname, $data);
    }

    /**
     * Get available barang for stock opname with pagination - filtered by PIC Lab's managed rooms
     * Only returns items in rooms where pic_ruangan matches the logged-in PIC Lab's NPK
     * Each stock opname session is independent - only excludes items already in THIS session
     * Items from rejected sessions are available again
     */
    public function getAvailableBarangForOpnamePaginatedPICLab($id_opname, $start, $length, $search = '', $ruangan = '', $kondisi = '', $npk = '')
    {
        // Subquery to exclude items in active Dupat
        $excludeDupat = "(SELECT dd.id_barang FROM siso_msdtldupat dd 
                          INNER JOIN siso_msdupat dupat ON dd.id_dupat = dupat.id_dupat 
                          WHERE dupat.status_dupat IN ('Draft', 'On Progress Approval Koordinator UPT'))";
        
        // Subquery to exclude items in active Mutasi
        $excludeMutasi = "(SELECT dm.id_barang FROM siso_ms_dtlmutasi dm 
                           INNER JOIN siso_msmutasi m ON dm.id_mutasi = m.id_mutasi 
                           WHERE m.status_mutasi IN ('Draft', 'On Progress Approval Koordinator UPT'))";
        
        // Base WHERE clause - filter by PIC Lab's managed rooms, exclude items in this session (unless rejected)
        $where = "b.status_barang = 'Aktif' 
                  AND (dtl_so.id_barang IS NULL OR so_current.so_status = 'Rejected')
                  AND b.id_barang NOT IN {$excludeDupat}
                  AND b.id_barang NOT IN {$excludeMutasi}
                  AND r.pic_ruangan = ?";
        $params = [$id_opname, $npk];
        
        // Search filter
        if (!empty($search)) {
            $where .= " AND (b.nama_barang LIKE ? OR b.nomor_aktiva LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        // Ruangan filter
        if (!empty($ruangan)) {
            $where .= " AND r.nama_ruangan = ?";
            $params[] = $ruangan;
        }
        
        // Kondisi filter
        if (!empty($kondisi)) {
            $where .= " AND b.kondisi_barang = ?";
            $params[] = $kondisi;
        }
        
        // Count total (items in PIC Lab's rooms, excluding already added items unless rejected)
        $sqlTotal = "SELECT COUNT(*) as cnt 
                     FROM barang b
                     LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                     LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                     LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                     LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                     WHERE b.status_barang = 'Aktif' 
                     AND (dtl_so.id_barang IS NULL OR so_current.so_status = 'Rejected')
                     AND b.id_barang NOT IN {$excludeDupat}
                     AND b.id_barang NOT IN {$excludeMutasi}
                     AND r.pic_ruangan = ?";
        $total = $this->db->query($sqlTotal, [$id_opname, $npk])->row()->cnt;
        
        // Count filtered
        $sqlFiltered = "SELECT COUNT(*) as cnt FROM barang b
                        LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                        LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                        LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                        LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                        LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                        WHERE {$where}";
        $paramsFiltered = array_merge([$id_opname], $params);
        $filtered = $this->db->query($sqlFiltered, $paramsFiltered)->row()->cnt;
        
        // Get data with pagination
        $sql = "SELECT b.id_barang, b.nama_barang, b.nomor_aktiva, b.gambar_barang, 
                       b.kategori_barang, b.tipe_barang, b.kondisi_barang, b.jumlah_barang,
                       r.nama_ruangan, p.nama_penyimpanan, r.id_ruangan, p.id_penyimpanan
                FROM barang b
                LEFT JOIN dtl_ruangan_penyimpanan drp ON b.id_dtl_penyimpanan = drp.id_dtl_penyimpanan
                LEFT JOIN ruangan r ON drp.id_ruangan = r.id_ruangan
                LEFT JOIN penyimpanan p ON drp.id_penyimpanan = p.id_penyimpanan
                LEFT JOIN siso_msdtlstockopname dtl_so ON b.id_barang = dtl_so.id_barang AND dtl_so.so_id_opname = ?
                LEFT JOIN siso_msstockopname so_current ON dtl_so.so_id_opname = so_current.so_id_opname
                WHERE {$where}
                ORDER BY b.nomor_aktiva
                LIMIT ?, ?";
        $paramsData = array_merge([$id_opname], $params, [(int)$start, (int)$length]);
        
        $data = $this->db->query($sql, $paramsData)->result();
        
        return [
            'total' => $total,
            'filtered' => $filtered,
            'data' => $data
        ];
    }
}
