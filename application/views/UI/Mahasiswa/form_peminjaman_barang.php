<!DOCTYPE html>
<html lang="en">
<head>
    <title>Asset & Non Asset</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        .text-sm {
            font-size: 0.875rem !important;
        }
        .fw-semibold {
            font-weight: 600 !important;
        }
        .fw-medium {
            font-weight: 500 !important;
        }
        .px-20 {
            padding-inline: 1.25rem !important;
        }
        .px-24 {
            padding-inline: 1.5rem !important;
        }
        .py-9 {
            padding-block: 0.5625rem !important;
        }
        .py-4
        {
          padding-top: 0.5rem !important;
          padding-bottom: 0.5rem !important;
        }
        .text-white {
            --bs-text-opacity: 1;
            color: rgba(255,255,255,1) !important;
        }
        .rounded-pill {
            border-radius: 50rem !important;
        }
        .bg-success-600 {
            background-color: #16A34A !important;
        }
        .bg-lilac-600 {
            background-color: #8252E9 !important;
        }
        .bg-info-600 {
            background-color: #2563EB !important;
        }
        .bg-pink-600{
            background-color:#e952a9 !important
        }
        .bg-success-focus {
            background-color: rgba(69, 179, 105, 0.1490196078) !important;
        }
        .text-success-main {
            color: #45B369;
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
    <div class="container pt-4" style="margin-top:100px">
      <form action="<?= base_url('peminjaman/simpan') ?>" method="post" enctype="multipart/form-data">
        <h4 style="text-align:center; margin-bottom: 30px;">Loan Data</h4>

        <div class="form-group">
          <label class="fw-medium text-dark">Borrower Name <span style="color: red;">*</span></label></label>
          <input type="text" name="nama_peminjam" class="form-control" required value="<?= $_COOKIE['nama']?>" readonly 
            style="border: 2px solid #333; border-radius: 4px; padding: 8px;">
        </div>

        <div class="form-group">
          <label class="fw-medium text-dark">NIM <span style="color: red;">*</span></label></label>
          <input type="text" name="nim_peminjam" class="form-control" required value="<?= $_COOKIE['nim']?>" readonly
            style="border: 2px solid #333; border-radius: 4px; padding: 8px;">
        </div>

        <div class="form-group">
          <label class="fw-medium text-dark">Loan Needs <span style="color: red;">*</span></label></label>
          <textarea name="keperluan_peminjaman" class="form-control" required
            style="border: 2px solid #333; border-radius: 4px; padding: 8px;"></textarea>
        </div>

        <div class="form-group">
          <label class="fw-medium text-dark">Loan Started <span style="color: red;">*</span></label></label>
          <input type="date" name="mulai_peminjaman" class="form-control" required
            style="border: 2px solid #333; border-radius: 4px; padding: 8px;">
        </div>

        <div class="form-group">
          <label class="fw-medium text-dark">Loan Completed <span style="color: red;">*</span></label></label>
          <input type="date" name="selesai_peminjaman" class="form-control" required
            style="border: 2px solid #333; border-radius: 4px; padding: 8px;">
        </div>

        <hr>

        <h4 style="text-align:center; margin-bottom: 20px;">Details of Item Loan</h4>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th><center>Inventory Name</center></th>
                <th><center>Asset & Non Asset Number</center></th>
                <th><center>Amount</center></th>
                <th><center>Item Condition</center></th>
                <!-- <th><center>Gambar Sebelum</center></th> -->
              </tr>
            </thead>
            <tbody>
              <?php foreach ($keranjang as $i => $item): ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                      <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $item->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
                      </div>
                      <div>
                        <div class="fw-medium text-dark"><?= $item->nama_barang ?></div>
                        <div class="d-flex align-items-center" style="gap: 6px; white-space: nowrap;">
                          <?php switch ($item->kategori_barang) {
                            case 'Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white">'.$item->kategori_barang.'</span>';
                              break;
                            case 'Non Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white">'.$item->kategori_barang.'</span>';
                              break;
                          } ?>
                          <?php switch ($item->tipe_barang) {
                            case 'Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white">'.$item->tipe_barang.'</span>';
                              break;
                            case 'Non Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white">'.$item->tipe_barang.'</span>';
                              break;
                          } ?>
                        </div>
                      </div>
                    </div>
                  <input type="hidden" name="id_barang[]"  value="<?= $item->id_barang ?>">
                </td>
                <td><center><?= $item->nomor_aktiva; ?></center></td>
                <td>
                  <?= $item->jumlah.' '.$item->satuan_barang; ?>
                  <input type="hidden" name="jumlah_peminjaman[]"  value="<?= $item->jumlah ?>">
                  <input type="hidden" name="satuan_barang[]"  value="<?= $item->satuan_barang ?>">
                  <input type="hidden" name="kategori_barang[]"  value="<?= $item->kategori_barang ?>">
                </td>
                <td>
                <center>
                  <input type="hidden" name="kondisi_barang[]"  value="<?= $item->satuan_barang ?>">
                  <?php switch ($item->kondisi_barang) {
                    case 'Good':
                      echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">'.$item->kondisi_barang.'</span>';
                      break;
                    case 'Not Good':
                      echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">'.$item->kondisi_barang.'</span>';
                      break;
                    case 'Maintenance':
                      echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">'.$item->kondisi_barang.'</span>';
                      break;
                  } ?>
                </center>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <center>
          <button type="submit" class="btn btn-success">Save Loans</button>
          <a href="<?= base_url('Dashboard/keranjang') ?>" class="btn btn-secondary" style="margin-left: 20px;">Back to Cart</a>
        </center>
      </form>
    </div>
    <!-- Modal Zoom Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-0">
            <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
          </div>
        </div>
      </div>
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
      document.addEventListener('DOMContentLoaded', function () {
        // Ambil tanggal hari ini dan tambah 1 hari (besok)
        const today = new Date();
        today.setDate(today.getDate() + 1);

        // Format ke yyyy-mm-dd
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const minDate = `${yyyy}-${mm}-${dd}`;

        // Tetapkan atribut min untuk kedua input
        document.querySelector('input[name="mulai_peminjaman"]').setAttribute('min', minDate);
        document.querySelector('input[name="selesai_peminjaman"]').setAttribute('min', minDate);
      });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.querySelector('input[name="mulai_peminjaman"]');
        const endInput = document.querySelector('input[name="selesai_peminjaman"]');

        function validateDates() {
          const startDate = new Date(startInput.value);
          const endDate = new Date(endInput.value);

          if (startInput.value && endInput.value && startDate > endDate) {
            Swal.fire("Invalid Date", "Loan Started cannot be later than Loan Completed!", "error");
            startInput.value = "";
          }
        }

        startInput.addEventListener('change', validateDates);
        endInput.addEventListener('change', validateDates);
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
        window.location.href = "<?php echo base_url('Dashboard/peminjamanBarang') ?>"
      </script>
      <?php
    }  ?>
    <script>
      function showImageModal(imageSrc) {
        document.getElementById('zoomedImage').src = imageSrc;
        // Tampilkan modal
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
      }
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
          $('.add-to-cart-btn').click(function(e){
              e.preventDefault();

              var id_barang = $(this).data('id');
              var nim = $(this).data('nim');
              var jumlah = $(this).closest('.product-item').find('input[name="quantity"]').val();

              $.ajax({
                  url: "<?= site_url('Peminjaman/tambahKeranjang') ?>", // Controller/fungsi tujuan
                  method: "POST",
                  data: {
                      id_barang: id_barang,
                      nim: nim,
                      jumlah: jumlah
                  },
                  success: function(response){
                      if (typeof response === 'string') {
                        response = JSON.parse(response);
                      }
                      if (response.status === 'error') {
                        swal.fire("Error!", "Quantity exceeds stock of inventory!", "error");
                      } else {
                        $('#cart-count').text(response.total_items);
                        swal.fire("Succeed!", "Data successfully added!", "success");
                      }
                      // Notifikasi
                      
                  },
                  error: function(xhr){
                      alert('Terjadi kesalahan saat menambahkan ke keranjang.'+xhr.responseText);
                      console.log(xhr.responseText);
                  }
              });
          });
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

      });
      function formatRupiah(angka) {
        return parseInt(angka).toLocaleString('id-ID');
      }
    </script>
</body>
</html>