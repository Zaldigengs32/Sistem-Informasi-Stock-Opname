<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PeminjamanModel extends CI_Model
{
    public function add_to_cart($id_barang, $nim, $jumlah) {
        // Cek apakah barang sudah ada
        $this->db->where('barang', $id_barang);
        $this->db->where('nim', $nim);
        $query = $this->db->get('keranjang');

        if ($query->num_rows() > 0) {
            // Update jumlah
            $this->db->set('jumlah', 'jumlah + ' . (int)$jumlah, false);
            $this->db->where('barang', $id_barang);
            $this->db->where('nim', $nim);
            $this->db->update('keranjang');
        } else {
            // Insert baru
            $data = [
                'barang' => $id_barang,
                'nim' => $nim,
                'jumlah' => $jumlah
            ];
            $this->db->insert('keranjang', $data);
        }
    }

    public function get_total_items($nim) {
        $this->db->select_sum('jumlah');
        $this->db->where('nim', $nim);
        $query = $this->db->get('keranjang');
        return (int)$query->row()->jumlah;
    }
    public function get_jumlah_barang($id_barang, $nim) {
        $this->db->select('jumlah');
        $this->db->from('keranjang');
        $this->db->where('barang', $id_barang);
        $this->db->where('nim', $nim);
        $query = $this->db->get();

        $result = $query->row();
        return $result ? (int)$result->jumlah : 0;
    }
    public function get_summary($nim) {
        $this->db->select('barang.nama_barang, barang.gambar_barang, barang.nomor_aktiva, barang.tipe_barang, barang.kategori_barang, keranjang.jumlah');
        $this->db->from('keranjang');
        $this->db->join('barang', 'keranjang.barang = barang.id_barang');
        $this->db->where('keranjang.nim', $nim);
        $query = $this->db->get();

        return $query->result();
    }
    public function getStatusLogById($id_dtl_peminjaman) {
        $this->db->select('nama_approval, user_approval, waktu_approval');
        $this->db->from('riwayat_approval'); // Contoh nama tabel log
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
        $this->db->order_by('waktu_approval', 'DESC');
        return $this->db->get()->result();
    }

    public function get_detailed_cart($nim) {
        $this->db->select('k.nim,k.id_keranjang, b.id_barang,b.kategori_barang, b.nomor_aktiva, k.jumlah, b.nama_barang, b.gambar_barang, b.jumlah_barang, b.tipe_barang, b.satuan_barang, b.kondisi_barang, b.ketersediaan_barang');
        $this->db->from('keranjang k');
        $this->db->join('barang b', 'k.barang = b.id_barang');
        $this->db->where('k.nim', $nim);
        return $this->db->get()->result();
    }
    public function get_selected_cart_items($selected_ids)
    {
        if (empty($selected_ids)) return [];

        $this->db->select('k.nim, k.id_keranjang, b.id_barang, b.kategori_barang, b.nomor_aktiva, k.jumlah, b.nama_barang, b.gambar_barang, b.jumlah_barang, b.tipe_barang, b.satuan_barang, b.kondisi_barang, b.ketersediaan_barang');
        $this->db->from('keranjang k');
        $this->db->join('barang b', 'k.barang = b.id_barang');
        $this->db->where_in('k.id_keranjang', $selected_ids);  // filter hanya berdasarkan id_keranjang yang dichecklist
        return $this->db->get()->result();
    }

    public function hapus_keranjang($id_keranjang){
        return $this->db->delete('keranjang', array('id_keranjang' => $id_keranjang));
    }
    public function simpan_peminjaman($data_peminjam, $data_detail)
    {
        date_default_timezone_set('Asia/Jakarta');
        // Simpan ke tabel peminjam
        $this->db->insert('peminjaman_barang', $data_peminjam);
        $id_peminjaman = $this->db->insert_id(); // Ambil ID terakhir

        // Loop data detail dan simpan
        foreach ($data_detail as &$detail) {
            $detail['id_peminjaman_barang'] = $id_peminjaman;
            $this->db->insert('dtl_peminjaman_barang', $detail);


            $id_dtl_peminjaman = $this->db->insert_id();
            $data_log = [
                'id_dtl_peminjaman'           => $id_dtl_peminjaman,
                'user_approval'   => $data_peminjam['nama_peminjam'],
                'nama_approval'       => 'Request',
                'waktu_approval'      => date('Y-m-d H:i:s')
            ];
            $this->db->insert('riwayat_approval', $data_log);

            //Update Status jadi booked
            // $sql = "UPDATE barang SET ketersediaan_barang = 'Booked' WHERE id_barang = ".$detail['id_barang']."";
            // $this->db->query($sql);
            
            // Ambil data barang berdasarkan ID
            $barang = $this->db->get_where('barang', ['id_barang' => $detail['id_barang']])->row();

            if ($barang) {
                // Kondisi 1: kategori Asset → update jadi Booked
                if ($barang->kategori_barang === 'Asset') {
                    $this->db->where('id_barang', $detail['id_barang']);
                    $this->db->update('barang', ['ketersediaan_barang' => 'Booked']);
                }
                // Kondisi 2 & 3: Non Asset
                elseif ($barang->kategori_barang === 'Non Asset') {
                    $jumlah_pinjam = $detail['jumlah_peminjaman'];

                    $sisa_stok = $barang->jumlah_barang - $jumlah_pinjam;
                    $data_update = ['jumlah_barang' => $sisa_stok];

                    if ($sisa_stok <= 0) {
                        $data_update['ketersediaan_barang'] = 'Not Available';
                    }

                    $this->db->where('id_barang', $detail['id_barang']);
                    $this->db->update('barang', $data_update);
                }
            }
        }

        // $this->db->insert_batch('dtl_peminjaman_barang', $data_detail);

        return $id_peminjaman;
    }
    public function hapus_keranjang_by_nim_barang($nim, $id_barang)
    {
        $this->db->where('nim', $nim);
        $this->db->where('barang', $id_barang);
        $this->db->delete('keranjang');
    }
    public function get_data_riwayat_peminjaman()
    {
        $nim = $_COOKIE['nim'];
        $query = $this->db->query("SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman, B.id_dtl_peminjaman, B.id_barang, B.jumlah_peminjaman, B.gambar_sebelum, B.gambar_sesudah, B.status_barang, C.nama_barang, C.tipe_barang, C.kategori_barang, C.nomor_aktiva, C.gambar_barang, C.satuan_barang FROM peminjaman_barang AS A JOIN dtl_peminjaman_barang AS B on A.id_peminjaman_barang = B.id_peminjaman_barang JOIN barang AS C on C.id_barang = B.id_barang WHERE A.nim_peminjam = '".$nim."' ORDER by A.tanggal_peminjam, A.id_peminjaman_barang  DESC;");
        return $query->result();
    }
    public function update_pengembalian_barang($id_dtl_peminjaman, $gambar_setelah) {
        
        // Update gambar_setelah dan status_barang di tabel dtl_peminjaman_barang
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
        $this->db->update('dtl_peminjaman_barang', [
            'gambar_sesudah' => $gambar_setelah,
            'tanggal_pengembalian' => date('Y-m-d'),
            'status_barang' => 'Completed'
        ]);

        // Ambil id_peminjaman_barang dari detail
        $this->db->select('id_peminjaman_barang, id_barang, jumlah_peminjaman');
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
        $detail = $this->db->get('dtl_peminjaman_barang')->row();

        if ($detail) {
            $id_peminjaman = $detail->id_peminjaman_barang;
            $id_barang = $detail->id_barang;
            $jumlah_dikembalikan = $detail->jumlah_peminjaman;

            // Ambil data barang terkait
            $barang = $this->db->get_where('barang', ['id_barang' => $id_barang])->row();

            if ($barang) {
                // Kondisi 1: Asset
                if ($barang->kategori_barang === 'Asset') {
                    $this->db->where('id_barang', $id_barang);
                    $this->db->update('barang', ['ketersediaan_barang' => 'Available']);
                }
                // Kondisi 2: Non Asset & Non Consummable
                elseif ($barang->kategori_barang === 'Non Asset' && $barang->tipe_barang === 'Non Consummable') {
                    $stok_baru = $barang->jumlah_barang + $jumlah_dikembalikan;
                    $this->db->where('id_barang', $id_barang);
                    $this->db->update('barang', [
                        'jumlah_barang' => $stok_baru,
                        'ketersediaan_barang' => 'Available'
                    ]);
                }

                // Catatan: Consummable tidak dikembalikan, jadi tidak perlu diproses di sini
            }

            // Cek apakah semua barang dalam satu peminjaman sudah dikembalikan (atau direject)
            echo $id_peminjaman;
            $this->db->select('status_barang');
            $this->db->where('id_peminjaman_barang', $id_peminjaman);
            $statuses = $this->db->get('dtl_peminjaman_barang')->result();
            echo "AB";
            $all_done = true;
            foreach ($statuses as $s) {
                echo $s->status_barang ;
                if ($s->status_barang !== 'Completed' &&strpos($s->status_barang, 'Reject') === false) {
                    $all_done = false;
                    echo "A";
                    break;
                }
            }

            if ($all_done) {
                $this->db->where('id_peminjaman_barang', $id_peminjaman);
                $this->db->update('peminjaman_barang', ['status_peminjaman' => 'Completed']);
            }
        }
    }


    public function update_gambar_sebelum($id_dtl_peminjaman, $foto_path) {
        // 1. Update gambar_sebelum dan status_barang menjadi 'Borrowed'
        $data = [
            'gambar_sebelum' => $foto_path,
            'status_barang' => 'Borrowed'
        ];
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
        $this->db->update('dtl_peminjaman_barang', $data); // Gunakan variabel tabel detail

        // 2. Ambil id_peminjaman_barang dari id_dtl_peminjaman
        $this->db->select('id_peminjaman_barang');
        $this->db->from('dtl_peminjaman_barang');
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman);
        $query = $this->db->get();
        $result = $query->row();

        if (!$result) return false;

        $idPeminjaman = $result->id_peminjaman_barang;

        // 3. Ambil semua status_barang dari semua detail
        $this->db->select('status_barang');
        $this->db->from('dtl_peminjaman_barang');
        $this->db->where('id_peminjaman_barang', $idPeminjaman);
        $statusList = $this->db->get()->result_array();
        $statusArray = array_column($statusList, 'status_barang');

        // 4. Definisikan urutan prioritas status (dari terendah ke tertinggi)
        $statusPriority = [
            'On Progress Approval PIC Asset' => 1,
            'On Progress Approval Koordinator UPT' => 2,
            'Approved' => 3,
            'Borrowed' => 4,
            'Waiting for Return' => 5,
            'Completed' => 6,
        ];

        // 5. Cari status dengan prioritas terendah (tertinggi angkanya)
        $lowestPriority = PHP_INT_MAX;
        $lowestStatus = null;

        foreach ($statusArray as $status) {
            if (isset($statusPriority[$status]) && $statusPriority[$status] < $lowestPriority) {
                $lowestPriority = $statusPriority[$status];
                $lowestStatus = $status;
            }
        }

        // 6. Update status_peminjaman dengan status terendah
        if ($lowestStatus) {
            $this->db->where('id_peminjaman_barang', $idPeminjaman);
            $this->db->update('peminjaman_barang', ['status_peminjaman' => $lowestStatus]);
        }

        return true;
    }

    // Ambil semua detail barang yang statusnya Borrowed dan selesai_peminjaman = kemarin
    public function get_borrowed_items_due_tomorrow()
    {
        $yesterday = date('Y-m-d', strtotime('+1 day'));

        $this->db->select('dp.id_dtl_peminjaman, dp.id_peminjaman_barang');
        $this->db->from('dtl_peminjaman_barang dp');
        $this->db->join('peminjaman_barang pb', 'dp.id_peminjaman_barang = pb.id_peminjaman_barang');
        $this->db->where('dp.status_barang', 'Borrowed');
        $this->db->where('pb.selesai_peminjaman', $yesterday);

        return $this->db->get()->result();
    }

    public function update_status_barang($id_dtl_peminjaman, $status)
    {
        $this->db->where('id_dtl_peminjaman', $id_dtl_peminjaman)
                 ->update('dtl_peminjaman_barang', ['status_barang' => $status]);
    }

    public function get_all_status_barang($id_peminjaman_barang)
    {
        $this->db->select('status_barang');
        $this->db->from('dtl_peminjaman_barang');
        $this->db->where('id_peminjaman_barang', $id_peminjaman_barang);
        $result = $this->db->get()->result();

        return array_column($result, 'status_barang');
    }

    public function update_status_peminjaman($id_peminjaman_barang, $status)
    {
        $this->db->where('id_peminjaman_barang', $id_peminjaman_barang)
                 ->update('peminjaman_barang', ['status_peminjaman' => $status]);
    }


    public function get_data_detail_peminjaman($id_peminjaman_barang)
    {
        $nim = $_COOKIE['nim'];
        $query = $this->db->query("SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman, B.id_dtl_peminjaman, B.id_barang, B.jumlah_peminjaman, B.gambar_sebelum, B.gambar_sesudah, B.status_barang, C.nama_barang, C.tipe_barang, C.kategori_barang, C.nomor_aktiva, C.gambar_barang, C.satuan_barang FROM peminjaman_barang AS A JOIN dtl_peminjaman_barang AS B on A.id_peminjaman_barang = B.id_peminjaman_barang JOIN barang AS C on C.id_barang = B.id_barang WHERE A.nim_peminjam = '".$nim."' AND B.id_dtl_peminjaman = $id_peminjaman_barang;");
        return $query->result();
    }
    public function get_data_riwayat_peminjaman_by_status($status)
    {
        $nim = $_COOKIE['nim'];
        $query = $this->db->query("SELECT A.id_peminjaman_barang, A.nama_peminjam, A.tanggal_peminjam, A.nim_peminjam, A.keperluan_peminjaman, A.mulai_peminjaman, A.selesai_peminjaman, A.status_peminjaman, B.id_dtl_peminjaman, B.id_barang, B.jumlah_peminjaman, B.gambar_sebelum, B.gambar_sesudah, B.status_barang, C.nama_barang, C.tipe_barang, C.kategori_barang, C.nomor_aktiva, C.gambar_barang, C.satuan_barang 
        FROM peminjaman_barang AS A JOIN dtl_peminjaman_barang AS B on A.id_peminjaman_barang = B.id_peminjaman_barang JOIN barang AS C on C.id_barang = B.id_barang WHERE A.nim_peminjam = '".$nim."' AND B.status_barang LIKE '".$status."%' ORDER by A.tanggal_peminjam, A.id_peminjaman_barang DESC;");
        return $query->result();
    }


    function getDataPeminjaman()
    {
        $nim = $_COOKIE['nim'];
        $sql = "SELECT a.*, b.nama_ruangan as 'ruangan' FROM `tb_peminjaman` as a join tb_ruangan as b on a.id_ruangan = b.id_ruangan where a.nim_peminjam = '$nim' ORDER BY a.id_peminjaman DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function getDataPeminjamanBarang(){
        $nim = $_COOKIE['nim'];
        $sql = "SELECT a.* FROM tb_peminjaman_barang as a where a.nim_peminjam = '$nim' ORDER BY a.id_peminjaman_barang DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function updateBarangSebelum($id,$foto){
        $sql = "UPDATE tb_peminjaman_barang SET foto_sebelum = '$foto', status='Dipinjam' WHERE id_peminjaman_barang = '$id'";
        $query = $this->db->query($sql);
        $sukses = 1;
        return $sukses;
    }
    public function updateBarangSetelah($id,$foto)
    {
        $sql = "UPDATE tb_peminjaman_barang SET foto_setelah = '$foto', status = 'Selesai' WHERE id_peminjaman_barang = '$id'";
        $query = $this->db->query($sql);
        $sukses = 1;
        return $sukses;
    }
}
