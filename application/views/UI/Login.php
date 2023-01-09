<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PeminjamanRuangan | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/fontawesome/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png">
  <!-- Swing Alert -->
  <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
  <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
</head>

<body class="hold-transition login-page" style="background-image: url(<?php echo base_url() ?>assets/adminlte3.2/dist/img/IMG_Background.jpg); background-repeat: no-repeat; background-size: cover;">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <b class="h2">Peminjaman Ruangan dan Barang</b>
      </div>
      <div class="card-body">
        <h3 class="login-box-msg">Masuk</h3>

        <form action="<?php echo site_url('LoginUser/aksi_login') ?>" method="post" autocomplete="off">
          <div class="form-group">
            <label><strong>Username</strong></label>
            <input type="text" class="form-control" value="" name="email">
          </div>

          <div class="form-group">
            <label><strong>Kata Sandi</strong></label>
            <input type="password" class="form-control" value="" name="password">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
        </form>

        <!-- /.col -->
      </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
  <!-- /.login-box -->
  <!-- jQuery -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jqvmap/jquery.vmap.min.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/moment/moment.min.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>assets/adminlte3.2/dist/js/adminlte.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/dist/js/pages/dashboard.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/jquery.dataTables.min.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

  <script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/fontawesome/js/fontawesome.js"></script>
</body>

</html>
<?php if (isset($notfound)) {
?>
  <script>
    swal("Gagal!", "Username atau password tidak ditemukan!", "error");
  </script>
<?php } ?>