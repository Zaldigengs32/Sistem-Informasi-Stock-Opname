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

        .btn-outline-secondary {
        border-width: 2px;
        font-weight: 600;
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
    <!-- Tampilan Keranjang -->
    <div class="container pt-4" style="margin-top:100px">
      <h4>Inventory Cart</h4>
      <form action="<?= base_url('Dashboard/checkout') ?>" method="post" id="form-checkout">
        <div class="bg-light p-3 rounded">
          <div class="d-flex align-items-center mb-3">
            <input type="checkbox" id="check-all" class="me-2">
            <label for="check-all" id="select-all-label">Select All (<?= count($keranjang) ?>)</label>
          </div>

          <?php foreach ($keranjang as $barang): ?>
            <div class="cart-item d-flex mb-3 border-bottom pb-2 align-items-center">
              <input type="checkbox" class="check-item" name="cart_item[]" value="<?= $barang->id_keranjang  ?>">
              <!-- input hidden untuk qty -->
              <input type="hidden" name="qty[<?= $barang->id_keranjang ?>]" value="<?= $barang->jumlah ?>" class="qty-hidden" disabled>
              <img src="<?= base_url('assets/foto/barang/' . $barang->gambar_barang) ?>" class="me-3 rounded" width="60" height="60" style="object-fit:cover">
              <div class="flex-grow-1">
                <div class="fw-semibold"><?= $barang->nomor_aktiva.' | '.$barang->nama_barang ?></div>

                <div class="d-flex gap-1 flex-wrap mt-1">
                  <?php switch ($barang->kategori_barang) {
                    case 'Asset':
                      echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white ">'.$barang->kategori_barang.'</span>';
                      break;
                    case 'Non Asset':
                      echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white ">'.$barang->kategori_barang.'</span>';
                      break;
                  } ?>
                  <?php switch ($barang->tipe_barang) {
                    case 'Consummable':
                      echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white " >'.$barang->tipe_barang.'</span>';
                      break;
                    case 'Non Consummable':
                      echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white " >'.$barang->tipe_barang.'</span>';
                      break;
                  } ?>
                </div>

              </div>

              <div class="text-end me-3">
                <?php if ($barang->jumlah_barang <= 3): ?>
                  <div class="text-outline-secondary small fw-semibold">Remaining <?= $barang->jumlah_barang ?></div>
                <?php endif; ?>
              </div>

              <div class="quantity-control d-flex align-items-center">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-minus" data-id="<?= $barang->id_keranjang ?>" data-stok="<?= $barang->jumlah_barang ?>">−</button>
                <input type="text" class="form-control text-center mx-2 quantity-input" value="<?= $barang->jumlah ?>" data-id="<?= $barang->id_keranjang ?>" readonly style="width: 50px; font-weight: bold;">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-plus" data-id="<?= $barang->id_keranjang ?>" data-stok="<?= $barang->jumlah_barang ?>">+</button>
              </div>


              <button type="button" class="btn btn-danger ms-3 btn-delete" data-id="<?= $barang->id_keranjang ?>">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          <?php endforeach; ?>

          <div class="text-end mt-3">
            <!-- <a href="<?= base_url('Dashboard/checkout') ?>" id="btn-checkout" class="btn btn-primary text-white">Checkout</a> -->
            <button type="submit" class="btn btn-primary text-white">Checkout</button>
          </div>
        </div>
      </form>
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
      $(document).ready(function(){
        document.getElementById('form-checkout').addEventListener('submit', function(e) {
          const checkedItems = document.querySelectorAll('.check-item:checked');
          if (checkedItems.length === 0) {
            e.preventDefault(); // Cegah submit
            Swal.fire('Error', 'Please select at least 1 item to checkout!', 'warning');

          }
        });
        // Saat tombol "Select All" di-check
        $('#check-all').on('change', function () {
          $('.check-item').prop('checked', this.checked);
        });

        // Saat salah satu item di-check / uncheck
        $('.check-item').on('change', function () {
          const allChecked = $('.check-item').length === $('.check-item:checked').length;
          $('#check-all').prop('checked', allChecked);
            const id = $(this).val();
            const hiddenQty = $('input.qty-hidden[name="qty[' + id + ']"]');

            if ($(this).is(':checked')) {
              hiddenQty.prop('disabled', false);
            } else {
              hiddenQty.prop('disabled', true);
            }
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

        // Aksi Plus dan Minus
        $('.btn-minus, .btn-plus').click(function () {
          const isPlus = $(this).hasClass('btn-plus');
          const cartId = $(this).data('id');
          const maxStok = parseInt($(this).data('stok'));
          const $input = $('.quantity-input[data-id="' + cartId + '"]');
          let currentQty = parseInt($input.val());

          // Update quantity value
          if (isPlus) {
            if (currentQty < maxStok) currentQty++;
            else return swal.fire("Error!", "Quantity exceeds stock of inventory!", "error");
          } else {
            if (currentQty > 1) currentQty--;
            else return swal.fire("Error!", "Minimum quantity 1!", "error");
          }

          // Tampilkan perubahan langsung di input
          $input.val(currentQty);
          $('input.qty-hidden[name="qty[' + cartId + ']"]').val(currentQty);

          // AJAX untuk update ke server
          $.ajax({
            url: '<?= base_url("Peminjaman/update_keranjang") ?>',
            method: 'POST',
            data: {
              id_cart: cartId,
              jumlah: currentQty
            },
            success: function (res) {
              console.log('The number of items was successfully updated.');
              swal.fire("Success!", "The number of items was successfully updated!", "success");
              // Tambahkan update total harga atau notifikasi jika perlu
            },
            error: function () {
              swal.fire("Error!", "The number of items failed to update!", "error");
            }
          });
        });

      });
      function formatRupiah(angka) {
        return parseInt(angka).toLocaleString('id-ID');
      }

      $(document).on('click', '.btn-delete', function () {
        const cartId = $(this).data('id');
        Swal.fire({
          title: 'Are you sure you want to delete data?',
          text: "You can't return this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Delete'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "<?php echo base_url('Peminjaman/hapus_keranjang') ?>",
              method: "post",
              data: {
                id_keranjang: cartId
              }
            })
            Swal.fire({
              title: 'Succeed!',
              text: 'Data deleted successfully!',
              type: 'success',
              icon: 'success'
            }).then(okay => {
              if (okay) {
                $('.btn-delete[data-id="' + cartId + '"]').closest('.cart-item').remove();
                $.get('<?= base_url("Peminjaman/get_summary") ?>', function(res) {
                  $('#select-all-label').text('Select All (' + res.total + ')');
                });
              }
            })
          }
        })
      });


    </script>
</body>
</html>