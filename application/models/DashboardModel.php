<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model {
    public function get_total_asset_borrowed() {
        return $this->db->query("SELECT SUM(jumlah_peminjaman) AS total FROM dtl_peminjaman_barang dp JOIN barang b ON dp.id_barang = b.id_barang WHERE b.kategori_barang = 'Asset' AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')")->row();
    }
    public function get_total_asset_borrowed_pic_lab($npk) {
        return $this->db->query("SELECT SUM(jumlah_peminjaman) AS total FROM dtl_peminjaman_barang dp JOIN barang b ON dp.id_barang = b.id_barang JOIN dtl_ruangan_penyimpanan c on c.id_dtl_penyimpanan = b.id_dtl_penyimpanan JOIN ruangan d on d.id_ruangan = c.id_ruangan WHERE b.kategori_barang = 'Asset' AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return') AND d.pic_ruangan = $npk;")->row();
    }
    public function get_asset_borrowed_last_30_days() {
        return $this->db->query("
            SELECT SUM(dp.jumlah_peminjaman) AS total 
            FROM dtl_peminjaman_barang dp
            JOIN barang b ON dp.id_barang = b.id_barang
            JOIN peminjaman_barang pb ON dp.id_peminjaman_barang = pb.id_peminjaman_barang
            WHERE b.kategori_barang = 'Asset'
              AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ")->row();
    }
    public function get_asset_borrowed_last_30_days_pic_lab($npk) {
        return $this->db->query("
            SELECT SUM(dp.jumlah_peminjaman) AS total 
            FROM dtl_peminjaman_barang dp
            JOIN barang b ON dp.id_barang = b.id_barang
            JOIN peminjaman_barang pb ON dp.id_peminjaman_barang = pb.id_peminjaman_barang
            JOIN dtl_ruangan_penyimpanan c on c.id_dtl_penyimpanan = b.id_dtl_penyimpanan 
            JOIN ruangan d on d.id_ruangan = c.id_ruangan
            WHERE b.kategori_barang = 'Asset'
              AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
              AND d.pic_ruangan = $npk
        ")->row();
    }

    public function get_total_non_asset_borrowed() {
        return $this->db->query("SELECT SUM(jumlah_peminjaman) AS total FROM dtl_peminjaman_barang dp JOIN barang b ON dp.id_barang = b.id_barang WHERE b.kategori_barang = 'Non Asset' AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')")->row();
    }
    public function get_total_non_asset_borrowed_pic_lab($npk) {
        return $this->db->query("SELECT SUM(jumlah_peminjaman) AS total FROM dtl_peminjaman_barang dp JOIN barang b ON dp.id_barang = b.id_barang JOIN dtl_ruangan_penyimpanan c on c.id_dtl_penyimpanan = b.id_dtl_penyimpanan JOIN ruangan d on d.id_ruangan = c.id_ruangan WHERE b.kategori_barang = 'Non Asset' AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return') AND d.pic_ruangan = $npk;")->row();
    }
    
    public function get_non_asset_borrowed_last_30_days() {
        return $this->db->query("
            SELECT SUM(dp.jumlah_peminjaman) AS total 
            FROM dtl_peminjaman_barang dp
            JOIN barang b ON dp.id_barang = b.id_barang
            JOIN peminjaman_barang pb ON dp.id_peminjaman_barang = pb.id_peminjaman_barang
            WHERE b.kategori_barang = 'Non Asset'
              AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ")->row();
    }
    public function get_non_asset_borrowed_last_30_days_pic_lab($npk) {
        return $this->db->query("
            SELECT SUM(dp.jumlah_peminjaman) AS total 
            FROM dtl_peminjaman_barang dp
            JOIN barang b ON dp.id_barang = b.id_barang
            JOIN peminjaman_barang pb ON dp.id_peminjaman_barang = pb.id_peminjaman_barang
            JOIN dtl_ruangan_penyimpanan c on c.id_dtl_penyimpanan = b.id_dtl_penyimpanan 
            JOIN ruangan d on d.id_ruangan = c.id_ruangan
            WHERE b.kategori_barang = 'Non Asset'
              AND dp.status_barang IN ('Approved', 'Borrowed', 'Waiting for Return')
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
              AND d.pic_ruangan = $npk
        ")->row();
    }

    public function get_total_approval_pic_asset() {
        return $this->db->query("SELECT COUNT(*) AS total FROM peminjaman_barang pb JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang JOIN barang b ON dp.id_barang = b.id_barang
         WHERE b.kategori_barang = 'Asset' AND dp.status_barang = 'On Progress Approval PIC Asset'")->row();
    }
    public function get_total_approval_pic_asset_30hari() {
        return $this->db->query("
            SELECT COUNT(*) AS total
            FROM peminjaman_barang pb
            JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang
            JOIN barang b ON dp.id_barang = b.id_barang
            WHERE b.kategori_barang = 'Asset'
              AND dp.status_barang = 'On Progress Approval PIC Asset'
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ")->row();
    }


    public function get_total_approval_pic_non_asset() {
        return $this->db->query("SELECT COUNT(*) AS total FROM peminjaman_barang pb JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang JOIN barang b ON dp.id_barang = b.id_barang 
        WHERE b.kategori_barang = 'Non Asset' AND dp.status_barang = 'On Progress Approval PIC Non Asset'")->row();
    }
    public function get_total_approval_pic_non_asset_30hari() {
        return $this->db->query("
            SELECT COUNT(*) AS total
            FROM peminjaman_barang pb
            JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang
            JOIN barang b ON dp.id_barang = b.id_barang
            WHERE b.kategori_barang = 'Non Asset'
              AND dp.status_barang = 'On Progress Approval PIC Non Asset'
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ")->row();
    }

    public function get_total_approval_koor_upt() {
        return $this->db->query("SELECT COUNT(*) AS total FROM peminjaman_barang pb JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang JOIN barang b ON dp.id_barang = b.id_barang 
        WHERE b.kategori_barang = 'Asset' AND dp.status_barang = 'On Progress Approval Koordinator UPT'")->row();
    }
    public function get_total_approval_koor_upt_30hari() {
        return $this->db->query("
            SELECT COUNT(*) AS total
            FROM peminjaman_barang pb
            JOIN dtl_peminjaman_barang dp ON pb.id_peminjaman_barang = dp.id_peminjaman_barang
            JOIN barang b ON dp.id_barang = b.id_barang
            WHERE b.kategori_barang = 'Non Asset'
              AND dp.status_barang = 'On Progress Approval Koordinator UPT'
              AND pb.tanggal_peminjam >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ")->row();
    }

    public function get_status_stok_menipis() {
        return $this->db->query("
            SELECT 
                nama_barang,
                SUM(jumlah_barang) AS total_jumlah,
                MIN(jumlah_minimum) AS jumlah_minimum, 
                MIN(jumlah_optimum) AS jumlah_optimum,
                CASE 
                    WHEN SUM(jumlah_barang) < MIN(jumlah_minimum) THEN 'Need Addition'
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_minimum) AND SUM(jumlah_barang) < MIN(jumlah_optimum) THEN 'Suboptimal Amount'
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_optimum) THEN 'Very Good Quantity'
                END AS status_stok
            FROM barang
            WHERE kondisi_barang = 'Good'
            GROUP BY nama_barang
            ORDER BY 
                CASE 
                    WHEN SUM(jumlah_barang) < MIN(jumlah_minimum) THEN 1
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_minimum) AND SUM(jumlah_barang) < MIN(jumlah_optimum) THEN 2
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_optimum) THEN 3
                END;

        ")->result();
    }

    public function get_status_stok_menipis_pic_lab($npk) {
        return $this->db->query("
            SELECT 
                nama_barang,
                SUM(jumlah_barang) AS total_jumlah,
                MIN(jumlah_minimum) AS jumlah_minimum, 
                MIN(jumlah_optimum) AS jumlah_optimum,
                CASE 
                    WHEN SUM(jumlah_barang) < MIN(jumlah_minimum) THEN 'Need Addition'
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_minimum) AND SUM(jumlah_barang) < MIN(jumlah_optimum) THEN 'Suboptimal Amount'
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_optimum) THEN 'Very Good Quantity'
                END AS status_stok
            FROM barang
            JOIN dtl_ruangan_penyimpanan on dtl_ruangan_penyimpanan.id_dtl_penyimpanan = barang.id_dtl_penyimpanan
            JOIN ruangan on ruangan.id_ruangan = dtl_ruangan_penyimpanan.id_ruangan
            WHERE kondisi_barang = 'Good' AND ruangan.pic_ruangan = $npk
            GROUP BY nama_barang
            ORDER BY 
                CASE 
                    WHEN SUM(jumlah_barang) < MIN(jumlah_minimum) THEN 1
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_minimum) AND SUM(jumlah_barang) < MIN(jumlah_optimum) THEN 2
                    WHEN SUM(jumlah_barang) >= MIN(jumlah_optimum) THEN 3
                END;

        ")->result();
    }


    public function get_asset_sering_dipinjam($limit = 10) {
        return $this->db->query("
            SELECT 
                b.nama_barang,
                COUNT(*) AS total_dipinjam
            FROM dtl_peminjaman_barang dpb
            JOIN barang b ON dpb.id_barang = b.id_barang
            WHERE dpb.status_barang IN (
                'Approved',
                'Borrowed',
                'Waiting for Return',
                'Completed'
            ) AND b.kategori_barang = 'Asset'
            GROUP BY b.nama_barang
            ORDER BY total_dipinjam DESC LIMIT 10;
        ")->result();
    }
    public function get_non_asset_sering_dipinjam($limit = 10) {
        return $this->db->query("
            SELECT 
                b.nama_barang,
                COUNT(*) AS total_dipinjam
            FROM dtl_peminjaman_barang dpb
            JOIN barang b ON dpb.id_barang = b.id_barang
            WHERE dpb.status_barang IN (
                'Approved',
                'Borrowed',
                'Waiting for Return',
                'Completed'
            ) AND b.kategori_barang = 'Non Asset'
            GROUP BY b.nama_barang
            ORDER BY total_dipinjam DESC LIMIT 10;
        ")->result();
    }

    public function get_asset_sering_dipinjam_pic_lab($npk) {
        return $this->db->query("
            SELECT 
                b.nama_barang,
                COUNT(*) AS total_dipinjam
            FROM dtl_peminjaman_barang dpb
            JOIN barang b ON dpb.id_barang = b.id_barang
            JOIN dtl_ruangan_penyimpanan on dtl_ruangan_penyimpanan.id_dtl_penyimpanan = b.id_dtl_penyimpanan
            JOIN ruangan on ruangan.id_ruangan = dtl_ruangan_penyimpanan.id_ruangan
            WHERE dpb.status_barang IN (
                'Approved',
                'Borrowed',
                'Waiting for Return',
                'Completed'
            ) AND b.kategori_barang = 'Asset' AND ruangan.pic_ruangan = $npk
            GROUP BY b.nama_barang
            ORDER BY total_dipinjam DESC LIMIT 10;
        ")->result();
    }
    public function get_non_asset_sering_dipinjam_pic_lab($npk) {
        return $this->db->query("
            SELECT 
                b.nama_barang,
                COUNT(*) AS total_dipinjam
            FROM dtl_peminjaman_barang dpb
            JOIN barang b ON dpb.id_barang = b.id_barang
            JOIN dtl_ruangan_penyimpanan on dtl_ruangan_penyimpanan.id_dtl_penyimpanan = b.id_dtl_penyimpanan
            JOIN ruangan on ruangan.id_ruangan = dtl_ruangan_penyimpanan.id_ruangan
            WHERE dpb.status_barang IN (
                'Approved',
                'Borrowed',
                'Waiting for Return',
                'Completed'
            ) AND b.kategori_barang = 'Non Asset' AND ruangan.pic_ruangan = $npk
            GROUP BY b.nama_barang
            ORDER BY total_dipinjam DESC LIMIT 10;
        ")->result();
    }

    // Mutation Dashboard Functions
    public function get_total_mutation_pending_approval() {
        return $this->db->query("SELECT COUNT(*) AS total FROM siso_msmutasi WHERE status_mutasi = 'On Progress Approval Koordinator UPT'")->row();
    }
    
    public function get_total_mutation_approved() {
        return $this->db->query("SELECT COUNT(*) AS total FROM siso_msmutasi WHERE status_mutasi = 'Approved'")->row();
    }
    
    public function get_total_mutation_draft() {
        return $this->db->query("SELECT COUNT(*) AS total FROM siso_msmutasi WHERE status_mutasi = 'Draft'")->row();
    }
    
    public function get_total_mutation_last_30_days() {
        return $this->db->query("SELECT COUNT(*) AS total FROM siso_msmutasi WHERE tanggal_mutasi >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->row();
    }
}
