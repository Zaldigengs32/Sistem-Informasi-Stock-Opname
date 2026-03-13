<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cron Controller
 * 
 * Controller untuk menjalankan scheduled tasks / cron jobs
 * 
 * Cara menjalankan:
 * - Via CLI: php index.php cron autoApproval
 * - Via URL (dengan secret key): http://yoursite.com/cron/autoApproval/YOUR_SECRET_KEY
 * - Via Windows Task Scheduler atau Linux Cron
 * 
 * Contoh cron job (Linux):
 * 0 0 * * * /usr/bin/php /path/to/ManajemenAsset/index.php cron autoApproval >> /var/log/cron.log 2>&1
 * 
 * Contoh Task Scheduler (Windows):
 * php.exe C:\path\to\ManajemenAsset\index.php cron autoApproval
 */
class Cron extends CI_Controller
{
    // Secret key untuk akses via URL (ganti dengan key yang aman)
    private $secret_key = 'SISO_AuT0_4pPr0v3_X7k9mN2pQ8';
    
    // Jumlah hari threshold untuk auto-approval
    private $days_threshold = 3;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('StockOpnameModel');
        $this->load->model('MutasiModel');
        $this->load->model('DupatModel');
        $this->load->model('Models', 'models');
    }

    /**
     * Auto Approval untuk Stock Opname, Mutasi, Dupat, dan Peminjaman
     * yang sudah pending lebih dari 3 hari
     * 
     * @param string $key Secret key untuk validasi (jika diakses via URL)
     */
    public function autoApproval($key = null)
    {
        // Validasi akses - hanya boleh via CLI atau dengan secret key
        if (!$this->input->is_cli_request()) {
            if ($key !== $this->secret_key) {
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
                return;
            }
        }

        $results = [
            'timestamp' => date('Y-m-d H:i:s'),
            'stock_opname' => $this->autoApproveStockOpname(),
            'mutasi' => $this->autoApproveMutasi(),
            'dupat' => $this->autoApproveDupat(),
            'peminjaman' => $this->autoApprovePeminjaman()
        ];

        // Output hasil
        if ($this->input->is_cli_request()) {
            echo "=== Auto Approval Results ===\n";
            echo "Timestamp: " . $results['timestamp'] . "\n\n";
            
            echo "Stock Opname:\n";
            echo "  - Processed: " . $results['stock_opname']['processed'] . "\n";
            echo "  - Success: " . $results['stock_opname']['success'] . "\n";
            echo "  - Failed: " . $results['stock_opname']['failed'] . "\n\n";
            
            echo "Mutasi:\n";
            echo "  - Processed: " . $results['mutasi']['processed'] . "\n";
            echo "  - Success: " . $results['mutasi']['success'] . "\n";
            echo "  - Failed: " . $results['mutasi']['failed'] . "\n\n";
            
            echo "Dupat:\n";
            echo "  - Processed: " . $results['dupat']['processed'] . "\n";
            echo "  - Success: " . $results['dupat']['success'] . "\n";
            echo "  - Failed: " . $results['dupat']['failed'] . "\n\n";

            echo "Peminjaman:\n";
            echo "  - Processed: " . $results['peminjaman']['processed'] . "\n";
            echo "  - Success: " . $results['peminjaman']['success'] . "\n";
            echo "  - Failed: " . $results['peminjaman']['failed'] . "\n";
        } else {
            header('Content-Type: application/json');
            echo json_encode($results);
        }
    }

    /**
     * Auto approve Stock Opname yang pending > 3 hari
     */
    private function autoApproveStockOpname()
    {
        $result = ['processed' => 0, 'success' => 0, 'failed' => 0, 'ids' => []];
        
        $pending = $this->StockOpnameModel->getPendingApprovalOverDays($this->days_threshold);
        $result['processed'] = count($pending);
        
        foreach ($pending as $item) {
            $success = $this->StockOpnameModel->autoApproveStockOpname($item->so_id_opname);
            
            if ($success) {
                $result['success']++;
                $result['ids'][] = $item->so_id_opname;
            } else {
                $result['failed']++;
            }
        }
        
        return $result;
    }

    /**
     * Auto approve Mutasi yang pending > 3 hari
     * Termasuk logic untuk update lokasi barang
     */
    private function autoApproveMutasi()
    {
        $result = ['processed' => 0, 'success' => 0, 'failed' => 0, 'ids' => []];
        
        $pending = $this->MutasiModel->getPendingApprovalOverDays($this->days_threshold);
        $result['processed'] = count($pending);
        
        foreach ($pending as $mutasi) {
            // Get detail items
            $items = $this->MutasiModel->getDtlMutasiByIdMutasi($mutasi->id_mutasi);
            $lokasi_tujuan = $mutasi->lokasi_tujuan;
            
            // Check if destination is internal (existing room) or external
            $id_ruangan_tujuan = $this->MutasiModel->getRuanganIdByName($lokasi_tujuan);
            
            if ($id_ruangan_tujuan) {
                // Internal mutation - move items to new location
                foreach ($items as $item) {
                    $id_dtl_penyimpanan_tujuan = $this->MutasiModel->getDefaultPenyimpananByRuangan($id_ruangan_tujuan);
                    
                    if ($id_dtl_penyimpanan_tujuan) {
                        $this->MutasiModel->updateBarangLocation($item->id_barang, $id_dtl_penyimpanan_tujuan);
                    }
                }
            } else {
                // External mutation - mark items as moved out
                foreach ($items as $item) {
                    $this->MutasiModel->updateBarangStatusMutasiExternal($item->id_barang, $lokasi_tujuan);
                }
            }
            
            // Update status to Approved
            $success = $this->MutasiModel->autoApproveMutasi($mutasi->id_mutasi);
            
            if ($success) {
                $result['success']++;
                $result['ids'][] = $mutasi->id_mutasi;
            } else {
                $result['failed']++;
            }
        }
        
        return $result;
    }

    /**
     * Auto approve Dupat yang pending > 3 hari
     * Termasuk logic untuk update status barang menjadi Tidak Aktif
     */
    private function autoApproveDupat()
    {
        $result = ['processed' => 0, 'success' => 0, 'failed' => 0, 'ids' => []];
        
        $pending = $this->DupatModel->getPendingApprovalOverDays($this->days_threshold);
        $result['processed'] = count($pending);
        
        foreach ($pending as $dupat) {
            // Get detail items
            $items = $this->DupatModel->getDtlDupatByIdDupat($dupat->id_dupat);
            
            // Mark items as non-active (deleted/disposed)
            foreach ($items as $item) {
                $this->db->where('id_barang', $item->id_barang);
                $this->db->update('barang', [
                    'status_barang' => 'Tidak Aktif',
                    'modified_by' => 'SYSTEM_AUTO_APPROVE',
                    'modified_date' => date('Y-m-d')
                ]);
            }
            
            // Update status to Approved
            $success = $this->DupatModel->autoApproveDupat($dupat->id_dupat);
            
            if ($success) {
                $result['success']++;
                $result['ids'][] = $dupat->id_dupat;
            } else {
                $result['failed']++;
            }
        }
        
        return $result;
    }

    /**
     * Auto approve Peminjaman yang pending > 3 hari
     * Termasuk logic untuk update status barang dan parent peminjaman
     */
    private function autoApprovePeminjaman()
    {
        $result = ['processed' => 0, 'success' => 0, 'failed' => 0, 'ids' => []];
        
        $pending = $this->models->getPendingApprovalPeminjamanOverDays($this->days_threshold);
        $result['processed'] = count($pending);
        
        foreach ($pending as $item) {
            $success = $this->models->autoApprovePeminjamanItem($item->id_dtl_peminjaman, $item->status_barang);
            
            if ($success) {
                $result['success']++;
                $result['ids'][] = $item->id_dtl_peminjaman;
            } else {
                $result['failed']++;
            }
        }
        
        return $result;
    }

    /**
     * Test endpoint untuk cek status pending approval
     * 
     * @param string $key Secret key untuk validasi
     */
    public function checkPending($key = null)
    {
        if (!$this->input->is_cli_request()) {
            if ($key !== $this->secret_key) {
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
                return;
            }
        }

        $results = [
            'timestamp' => date('Y-m-d H:i:s'),
            'days_threshold' => $this->days_threshold,
            'stock_opname_pending' => count($this->StockOpnameModel->getPendingApprovalOverDays($this->days_threshold)),
            'mutasi_pending' => count($this->MutasiModel->getPendingApprovalOverDays($this->days_threshold)),
            'dupat_pending' => count($this->DupatModel->getPendingApprovalOverDays($this->days_threshold)),
            'peminjaman_pending' => count($this->models->getPendingApprovalPeminjamanOverDays($this->days_threshold))
        ];

        if ($this->input->is_cli_request()) {
            echo "=== Pending Approval Status ===\n";
            echo "Timestamp: " . $results['timestamp'] . "\n";
            echo "Days Threshold: " . $results['days_threshold'] . " days\n\n";
            echo "Stock Opname Pending: " . $results['stock_opname_pending'] . "\n";
            echo "Mutasi Pending: " . $results['mutasi_pending'] . "\n";
            echo "Dupat Pending: " . $results['dupat_pending'] . "\n";
            echo "Peminjaman Pending: " . $results['peminjaman_pending'] . "\n";
        } else {
            header('Content-Type: application/json');
            echo json_encode($results);
        }
    }
}
