<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Asset | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->

  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png">
  <!-- Swing Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .nav-static-top{
      top: 0; 
      left: 0;
      right: 0;
      position: fixed;
      height: 70px;
      width: 100% !important;
      box-shadow: 0px 2px 0px 0px #eee;
      background-color: white;
      z-index: 4;
      opacity: 0.9;
    }
  </style>
</head>
<script type="text/javascript">
    function LOGIN()
    {
      // call get token function
        var usernameUser = document.getElementById('username').value;
        var pass = document.getElementById('pass').value;
        var nim = usernameUser;
            var username = usernameUser;
            var nama = "Roni Prasetyo";
            var role = "Mahasiswa";
            const d = new Date();
            d.setTime(d.getTime() + (1*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            if(username!=null && role != 'STAFF' ){
                document.cookie = "nim=" + username + ";"+expires+"; path=/";
                document.cookie = "nama=" + nama + ";" + expires + ";path=/";
                Swal.fire({
                  icon: 'success',
                  title: 'Login Success!',
                  showConfirmButton: false,
                  sleep:1000
                })
                setTimeout(() => {  window.location.href= "<?php echo base_url().'LoginUser/loginMhsAPI';?> "; }, 1000);
                
            }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Login Failed',
                  text: 'Wrong Username or Password!'
                })   
            }
    }
</script>
<body class="hold-transition login-page" style="background-image: url(<?php echo base_url() ?>assets/adminlte/img/IMG_Background.jpg); background-repeat: no-repeat; background-size: cover;">
  <div class="nav-static-top">
    <div class="float-left">
      <a href="<?php echo base_url('LoginUser/aksi_login') ?>">
        <img class="mt-3 ml-4" src="<?php echo base_url() ?>assets/adminlte/img/IMG_Logo.png" style="height:40px;">
      </a>
    </div>
  </div>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-body">
        <div class="text-center">
          <b class="h2">Manajemen Asset</b>
        </div>
        <hr>
        <h4 class="login-box-msg">Login as Student</h4>
        <!-- <form action="<?= base_url('LoginUser/loginMhs') ?>" method="POST" enctype="multipart/form-data"> -->
          <div class="form-group">
            <label>NIM <span style="color:red;">*</span></label>
            <input type="text" class="form-control" value="" name="username" id="username">
          </div>

          <div class="form-group">
            <label>Password <span style="color:red;">*</span></label>
            <input type="password" class="form-control" value="" name="password" id="pass">
          </div>
          
          <div>
            <div class="form-group">
              <p>Login as Admin?<a href="<?= base_url('LoginUser/LoginAdmin') ?>" style="color: #1767b1"> Click Here</a></p>
            </div>
          </div>
          <div class="text-center">
            <button type="button" onclick="LOGIN()" class="btn btn-primary btn-block">Login</button>
            <!-- <button type="submit" class="btn btn-primary btn-block">Login</button> -->
          </div>
        <!-- </form> -->
          
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
  <script src="<?php echo base_url() ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() ?>assets/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>assets/adminlte/plugins/bootstrap/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>assets/adminlte/dist/js/adminlte.js"></script>

</body>

</html>
<?php if (isset($notfound)) {
?>
  <script>
    swal.fire("Gagal!", "Username atau password tidak ditemukan!", "error");
  </script>
<?php } ?>
