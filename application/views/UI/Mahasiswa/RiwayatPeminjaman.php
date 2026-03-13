<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/dist/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png" sizes="16x16">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.css">
    <link href="<?php echo base_url() ?>assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
      .card-order {
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        margin-bottom: 1rem;
      }
      .btn-status {
        font-size: 0.8rem;
      }
      .product-img {
        width: 70px;
        height: 70px;
        object-fit: contain;
      }
      .btn-action {
        min-width: 100px;
      }
    </style>
    <style>
        .text-sm {
            font-size: 0.875rem !important;
        }
        .fw-semibold {
            font-weight: 600 !important;
        }
        .px-20 {
            padding-inline: 1.25rem !important;
        }
        .py-9 {
            padding-block: 0.5625rem !important;
        }
        .text-white {
            --bs-text-opacity: 1;
            color: rgba(255,255,255,1) !important;
        }
        .text-primary-600{
          color:#487FFF;
        }
        .text-danger-600{
          color:#DC2626;
        }
        .rounded-pill {
            border-radius: 50rem !important;
        }
        .btn-outline-lilac-600 {
            /*background-color: transparent !important;*/
            --bs-btn-color: #8252E9 !important;
            --bs-btn-border-color: #8252E9 !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #8252E9;
            --bs-btn-hover-border-color: #8252E9;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #8252E9;
            --bs-btn-active-border-color: #8252E9;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #8252E9;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #8252E9;
            --bs-gradient: none;
        }
        .btn-outline-info-600 {
            /*background-color: transparent !important;*/
            --bs-btn-color: #BFDCFF !important;
            --bs-btn-border-color: #BFDCFF !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #BFDCFF;
            --bs-btn-hover-border-color: #BFDCFF;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #BFDCFF;
            --bs-btn-active-border-color: #BFDCFF;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #BFDCFF;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #BFDCFF;
            --bs-gradient: none;
        }
        .btn-outline-danger-600 {
            /*background-color: transparent !important;*/
            --bs-btn-color: #BFDCFF !important;
            --bs-btn-border-color: #BFDCFF !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #BFDCFF;
            --bs-btn-hover-border-color: #BFDCFF;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #BFDCFF;
            --bs-btn-active-border-color: #BFDCFF;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #BFDCFF;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #BFDCFF;
            --bs-gradient: none;
        }
        .btn-outline-secondary-600 {
            /*background-color: transparent !important;*/
            --bs-btn-color: #2563EB !important;
            --bs-btn-border-color: #2563EB !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #2563EB;
            --bs-btn-hover-border-color: #2563EB;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #2563EB;
            --bs-btn-active-border-color: #2563EB;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #2563EB;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #2563EB;
            --bs-gradient: none;
        }
        .btn-outline-primary-600 {
            /*background-color: transparent !important;*/
            --bs-btn-color: rgba(255, 196, 63, 1) !important;
            --bs-btn-border-color: rgba(255, 196, 63, 1) !important;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: rgba(255, 196, 63, 1) !important;
            --bs-btn-hover-border-color: rgba(255, 196, 63, 1) !important;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: rgba(255, 196, 63, 1) !important;
            --bs-btn-active-border-color: rgba(255, 196, 63, 1) !important;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: rgba(255, 196, 63, 1) !important;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: rgba(255, 196, 63, 1) !important;
            --bs-gradient: none;
        }
        .bg-primary-600 {
            --bs-text-opacity: 1;
            background-color: rgba(255, 196, 63, 1) !important;
        }
        .bg-danger-600 {
            /*--bs-text-opacity: 1;*/
            background-color: #FEE2E2 !important;
            border-color: #FEE2E2 !important;
        }
        .bg-secondary-600 {
            background-color: #2563EB;
            color: #fff;
            border-color: #2563EB;
        }
        .bg-success-600 {
            background-color: #16A34A !important;
        }
        .bg-lilac-600 {
            background-color: #8252E9 !important;
        }
        .bg-info-600 {
            background-color: #BFDCFF !important;
        }
        .bg-pink-600{
            background-color:#e952a9 !important
        }
        .category-item img {
          max-height: 80px;
          margin-bottom: 10px;
        }

        .category-carousel .category-item .category-title {
          margin-top: auto;
          font-size: 1rem;
          font-weight: 700;
        }

        .cart-icon-container {
          position: relative;
          display: inline-block;
        }

        .cart-badge {
          position: absolute;
          top: -8px;
          right: -8px;
          background-color: red;
          color: white;
          font-size: 10px;
          font-weight: bold;
          border-radius: 50%;
          padding: 2px 6px;
          line-height: 1;
        }


    </style>
</head>
<body>
    <div class="super_container">
        <!-- Header -->
        <header  class="header d-flex flex-row" style="top: 10px;height: 70px;">
            <?php include('navbarMenu.php'); ?>
        </header>
    </div>
    <!-- Home -->
    <div class="container py-4 pt-4" style="margin-top:100px">

      <h4 class="mb-4"><b>Loan History</b></h4>

      <!-- Filter -->
      <!-- Filter -->
      <div class="mb-4 d-flex gap-2 flex-wrap">
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang'); ?>" class="btn btn-outline-success <?= $this->input->get('status') == '' ? 'active' : ''; ?>">ALL</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=Pengajuan'); ?>" class="btn btn-outline-lilac-600 <?= $this->input->get('status') == 'Pengajuan' ? 'active' : ''; ?>">On Progress Approval</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=Disetujui'); ?>" class="btn btn-outline-info text-info-600 <?= $this->input->get('status') == 'Disetujui' ? 'active' : ''; ?>">Approved</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=Ditolak'); ?>" class="btn btn-outline-danger text-danger-600 <?= $this->input->get('status') == 'Ditolak' ? 'active' : ''; ?>">Rejected</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=Dipinjam'); ?>" class="btn btn-outline-secondary-600 <?= $this->input->get('status') == 'Dipinjam' ? 'active' : ''; ?>">Borrowed</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=MenungguPengembalian'); ?>" class="btn btn-outline-primary-600 <?= $this->input->get('status') == 'MenungguPengembalian' ? 'active' : ''; ?>">Waiting for Return</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang?status=Selesai'); ?>" class="btn btn-outline-success <?= $this->input->get('status') == 'Selesai' ? 'active' : ''; ?>">Completed</a>
        <a href="<?= base_url('Dashboard/riwayatPeminjamanBarang'); ?>" class="ms-auto btn btn-outline-danger">Reset Filter</a>
      </div>

      <?php if (!empty($RiwayatPeminjaman)): ?>
          <!-- Card Riwayat 1 -->
          <?php 
              foreach ($RiwayatPeminjaman  as $brg): 
          ?>
            <div class="card card-order p-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="text-muted small"><b><?= date('d M Y', strtotime($brg->tanggal_peminjam))?></b></div>
                <div>
                  <?php
                    // Tampilkan kategori dan tipe barang secara horizontal
                    // $brg->status_barang = 'Dipinjam';
                    switch ($brg->status_barang) {
                      case 'On Progress Approval PIC Asset':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'On Progress Approval PIC Non Asset':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'On Progress Approval Koordinator UPT':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'Approved':
                        echo '<span class="badge fw-semibold bg-info-600 text-primary-600 me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'Reject by PIC Asset & Non Asset':
                        echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$brg->status_barang.'</span>';
                        break;
                     case 'Reject by Koordinator UPT':
                        echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'Borrowed':
                        echo '<span class="badge fw-semibold bg-secondary-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'Waiting for Return':
                        echo '<span class="badge fw-semibold bg-primary-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                      case 'Completed':
                        echo '<span class="badge fw-semibold bg-success-600 text-white me-2">'.$brg->status_barang.'</span>';
                        break;
                    }
                  ?>
                </div>
              </div>
              <div class="d-flex align-items-center mb-3">
                <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>" alt="Produk" class="product-img me-3">
                <div>
                  <div class="fw-semibold">
                    <a href="#" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#detailModal<?= $brg->id_dtl_peminjaman ?>">
                      <?= $brg->nomor_aktiva.' | '.$brg->nama_barang; ?>
                    </a>

                  </div>

                  <div class="d-flex align-items-center mt-2">
                    <?php
                    // Tampilkan kategori dan tipe barang secara horizontal
                    switch ($brg->kategori_barang) {
                      case 'Asset':
                        echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white me-2">'.$brg->kategori_barang.'</span>';
                        break;
                      case 'Non Asset':
                        echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white me-2">'.$brg->kategori_barang.'</span>';
                        break;
                    }

                    switch ($brg->tipe_barang) {
                      case 'Consummable':
                        echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white">'.$brg->tipe_barang.'</span>';
                        break;
                      case 'Non Consummable':
                        echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white">'.$brg->tipe_barang.'</span>';
                        break;
                    }
                    ?>
                  </div>
                </div>
                <div class="ms-auto text-end">
                  <div class="text-muted small">Total</div>
                  <div class="fw-bold text-dark"><?= $brg->jumlah_peminjaman.' '.$brg->satuan_barang;?></div>
                </div>
              </div>
              <!-- Tombol Upload jika status Approved -->
              <?php if ($brg->status_barang === 'Approved'): ?>
                <div class="mt-3 text-end">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal<?= $brg->id_dtl_peminjaman ?>"><iconify-icon icon="heroicons-solid:arrow-up-tray"></iconify-icon> Upload Item Photos</button>

                  <!-- Modal Upload -->
                  <div class="modal fade" id="uploadModal<?= $brg->id_dtl_peminjaman ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <form action="<?= base_url('Dashboard/upload_gambar_sebelum') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Upload Image (Before)</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" name="id_dtl_peminjaman" value="<?= $brg->id_dtl_peminjaman ?>">
                            <div class="form-group">
                              <input type="file" name="foto" class="form-control" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
              <?php elseif ($brg->status_barang === 'Waiting for Return'||$brg->status_barang === 'Borrowed'): ?>
                <div class="mt-3 text-end">
                  <button class="btn btn-success" data-toggle="modal" data-target="#returnModal<?= $brg->id_dtl_peminjaman ?>"><iconify-icon icon="heroicons-solid:arrow-up-tray"></iconify-icon> Return Items</button>

                  <!-- Modal Upload (Setelah) -->
                  <div class="modal fade" id="returnModal<?= $brg->id_dtl_peminjaman ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <form action="<?= base_url('Dashboard/kembalikan_barang') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Upload Image (After)</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" name="id_dtl_peminjaman" value="<?= $brg->id_dtl_peminjaman ?>">
                            <div class="form-group">
                              <input type="file" name="foto_setelah" class="form-control" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

            </div>
            <!-- Modal Detail Peminjaman -->
            <div class="modal fade" id="detailModal<?= $brg->id_dtl_peminjaman ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Loan Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered">
                      <tr>
                        <th>Loan Date</th>
                        <td><?= date('d M Y', strtotime($brg->tanggal_peminjam)) ?></td>
                      </tr>
                      <tr>
                        <th>Item</th>
                        <td><?= $brg->nomor_aktiva ?> - <?= $brg->nama_barang ?></td>
                      </tr>
                      <tr>
                        <th>Category</th>
                        <td><?= $brg->kategori_barang ?></td>
                      </tr>
                      <tr>
                        <th>Type</th>
                        <td><?= $brg->tipe_barang ?></td>
                      </tr>
                      <tr>
                        <th>Quantity</th>
                        <td><?= $brg->jumlah_peminjaman . ' ' . $brg->satuan_barang ?></td>
                      </tr>
                      
                      <tr>
                        <th>Borrower</th>
                        <td><?= $brg->nama_peminjam ?? '-' ?></td>
                      </tr>
                      <tr>
                        <th>Purpose</th>
                        <td><?= $brg->keperluan_peminjaman ?? '-' ?></td>
                      </tr>
                      <tr>
                        <th>Loan Period</th>
                        <td><?= date('d M Y', strtotime($brg->mulai_peminjaman)) . ' - ' . date('d M Y', strtotime($brg->selesai_peminjaman)) ?></td>
                      </tr>
                      <tr>
                        <th>Initial Condition</th>
                        <td><?= $brg->gambar_sebelum==null? '-': '<img width="250px" src="'.base_url().'assets/foto/Peminjaman/before/'.$brg->gambar_sebelum.'" alt="Produk" class="me-3">' ?></td>
                      </tr>
                      <tr>
                        <th>Final Condition</th>
                        <td><?= $brg->gambar_sesudah==null? '-': '<img width="250px" src="'.base_url().'assets/foto/Peminjaman/after/'.$brg->gambar_sesudah.'" alt="Produk" class="me-3">' ?> </td>
                      </tr>
                      <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            // Tampilkan kategori dan tipe barang secara horizontal
                            // $brg->status_barang = 'Dipinjam';
                            switch ($brg->status_barang) {
                              case 'On Progress Approval PIC Asset':
                                echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'On Progress Approval PIC Non Asset':
                                echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'On Progress Approval Koor UPT':
                                echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Approved':
                                echo '<span class="badge fw-semibold bg-info-600 text-primary-600 me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Reject by PIC Asset':
                                echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Reject by PIC Non Asset':
                                echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$brg->status_barang.'</span>';
                                break;
                             case 'Reject by Koordinator UPT':
                                echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Borrowed':
                                echo '<span class="badge fw-semibold bg-secondary-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Waiting for Return':
                                echo '<span class="badge fw-semibold bg-primary-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                              case 'Completed':
                                echo '<span class="badge fw-semibold bg-success-600 text-white me-2">'.$brg->status_barang.'</span>';
                                break;
                            }
                          ?>
                        </td>
                      </tr>
                    </table>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Status</th>
                          <th>User</th>
                          <th>Time</th>
                        </tr>
                      </thead>
                      <tbody id="logStatus<?= $brg->id_dtl_peminjaman ?>">
                        <tr>
                          <td colspan="4" class="text-center">Loading...</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

        <?php 
              endforeach;
        ?>
        <?php else: ?>
          <div class="card card-order p-3 text-center">
            <div class="fw-semibold text-muted">No borrowing history found..</div>
          </div>
        <?php endif; ?>
         
    </div>   



    <!-- Footer -->
    <footer class="footer" style="padding-bottom: 0px;margin-top: 50px;">
        <div class="container">
            <div class="footer_bar d-flex flex-column flex-sm-row align-items-center">
                <div class="footer_copyright" style="color:white;">
                    <span>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Polteknik Astra</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                </div>
            </div>

        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/easing/easing.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/User/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>assets/User/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/User/js/script.js"></script>
    <script>
        // Simpan tab aktif saat diklik
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (e) {
                sessionStorage.setItem('activeTab', e.target.getAttribute('href'));
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
          const urlParams = new URLSearchParams(window.location.search);
          const tab = urlParams.get('tab') || 'all';

          const triggerEl = document.querySelector(`#nav-${tab}-tab`);
          if (triggerEl) {
            new bootstrap.Tab(triggerEl).show();
          }
        });
    </script>
    <script>
      $(document).ready(function(){
          
          $('.cart-icon-container .dropdown-toggle').on('click', function() {
            $.ajax({
              url: '<?= base_url("Peminjaman/get_summary") ?>',
              type: 'GET',
              dataType: 'json',
              success: function(data) {
                let html = '';
                if (data.length > 0) {
                  $('#cart-total-items').text('(' + data.length + ')');
                  data.forEach(item => {
                    html += `
                      <div class="d-flex p-2 border-bottom">
                        <img src="<?= base_url('assets/foto/barang/') ?>${item.gambar_barang}" alt="${item.nama_barang}" width="50" height="50" class="rounded me-2" style="object-fit:cover;">
                        <div class="flex-grow-1">
                          <div class="fw-semibold small text-truncate">${item.nama_barang}</div>
                        </div>
                        <div class="text-nowrap ms-2 small">
                          <strong>${item.jumlah}</strong> 
                        </div>
                      </div>`;
                  });
                } else {
                      html = '<p class="text-muted text-center my-3">Cart is empty!</p>';
                    }

                    $('#cart-items').html(html);
                  },
                  error: function() {
                    $('#cart-items').html('<p class="text-danger text-center my-3">Failed to load data!</p>');
                  }
            });
          });
          // Tangkap event show hanya untuk modal dengan ID yang diawali 'detailModal'
          $(document).on('shown.bs.modal', '[id^="detailModal"]', function () {
            var modalId = $(this).attr('id');
            var idDtl = modalId.replace('detailModal', '');
            loadStatusLog(idDtl);
          });

          function loadStatusLog(idDtlPeminjaman) {
            $.ajax({
              url: '<?= base_url('Peminjaman/getStatusLog') ?>',
              type: 'POST',
              data: { id_dtl_peminjaman: idDtlPeminjaman },
              dataType: 'json',
              success: function(response) {
                let html = '';
                if(response.length > 0) {
                  response.forEach(function(item, index) {
                    html += `
                      <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama_approval}</td>
                        <td>${item.user_approval}</td>
                        <td>${item.waktu_approval}</td>
                      </tr>
                    `;
                  });
                } else {
                  html = `<tr><td colspan="4" class="text-center">No history found.</td></tr>`;
                }
                $('#logStatus' + idDtlPeminjaman).html(html);
              },
              error: function() {
                $('#logStatus' + idDtlPeminjaman).html('<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>');
              }
            });
          }
      });
      function formatRupiah(angka) {
        return parseInt(angka).toLocaleString('id-ID');
      }

    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[type="file"]').forEach(function (input) {
          input.addEventListener('change', function () {
            const file = this.files[0];
            if (file && !['image/jpeg', 'image/png'].includes(file.type)) {
              Swal.fire("Error!", "Format must be png or jpg!", "error");
              this.value = '';
            }
          });
        });
      });
    </script>
    <?php
      if (isset($error)) {
      ?>
        <script>
          Swal.fire("Error!", "<?= $error ?>", "error");
        </script>

      <?php
      $this->session->unset_userdata('error');}else if (isset($tambah)) {
      ?>
      <script>
        swal.fire("Succeed!", "Data successfully added!", "success");
        window.location.href = "<?php echo base_url('Dashboard/RiwayatPeminjamanBarang') ?>"
      </script>
      <?php
    }  ?>
</body>
</html>