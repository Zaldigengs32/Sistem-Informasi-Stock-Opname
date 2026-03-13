<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/dist/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" sizes="16x16">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.css">
    <link href="<?php echo base_url() ?>assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/responsive.css">
    <style type="text/css">
        
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

    <center>
        <div class="">
            <!-- Hero Slider -->
            <div class="hero_slide_background" style="background-image:url('<?php echo base_url();?>assets/foto/beranda.jpg');"></div>
                <div class="hero_slide_container d-flex flex-column align-items-center " style="padding-top:5%">
                    <div class="hero_slide_content text-center">
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">Organize <span style="background: #0059ab;">Everything</span> You Own!</h1>
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">All Your <span style="background: #0059ab;">Assets.</span> One <span style="background: #0059ab;">Smart</span> Platform</h1>
                    </div>
                </div>
            </div>
        </div>
    </center>

    <!-- Footer Content -->
    <footer class="footer" style="padding-top: 0px;margin-top: 0px;">
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?php echo base_url() ?>assets/dist/js/scripts.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/scrollTo/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/easing/easing.js"></script>
    <script src="<?php echo base_url() ?>assets/js/custom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <?php if (isset($tambah)) {
      ?>
      <script>
        swal.fire("Succeed!", "Data successfully added!", "success");
      </script>
      <?php
    }?>
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

        });
        function formatRupiah(angka) {
            return parseInt(angka).toLocaleString('id-ID');
        }
    </script>
</body>
</html>
</body>
</html>