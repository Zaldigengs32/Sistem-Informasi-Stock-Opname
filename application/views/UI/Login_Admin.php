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
      <!-- <div class="card-header text-center">
        <b class="h2">Peminjaman Ruangan dan Barang</b>
      </div> -->
      <div class="card-body">
        <div class="text-center">
          <b class="h2">Manajemen Asset</b>
        </div>
      <hr>
        <h4 class="login-box-msg">Login as Admin</h4>

        <!-- <form action="<?php echo site_url('LoginUser/aksi_login') ?>" method="post" autocomplete="off"> -->
          <div class="form-group">
            <label>Username <span style="color:red;">*</span></label>
            <input type="text" class="form-control" value="" name="email" id="email">
          </div>

          <div class="form-group">
            <label>Password <span style="color:red;">*</span></label>
            <input type="password" class="form-control" value="" name="password" id="password">
          </div>
          
          <div>
          <div class="form-group">
            <p>Login as Student ?<a href="<?php echo base_url('LoginUser') ?>" style="color: #1767b1"> Click here</a></p>
          </div>
        </div>
          <div class="text-center">
            <!-- <button type="submit" class="btn btn-primary btn-block">Login</button> -->
            <button type="button" onclick="LOGIN()" class="btn btn-primary btn-block">Login</button>
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
  <script type="text/javascript">
    function LOGIN()
    {
      // call get token function
        var usernameUser = document.getElementById('email').value;
        var pass = document.getElementById('password').value;
        var npk = usernameUser;
        var username = usernameUser;
        var nama = "Roni Prasetyo";
        var role = "STAFF";

        const d = new Date();
        d.setTime(d.getTime() + (1*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        if(username!=null && role != 'MAHASISWA'){
            document.cookie = "npk=" + username + ";"+expires+"; path=/";
            document.cookie = "nama=" + nama + ";" + expires + ";path=/";
            Swal.fire({
              icon: 'success',
              title: 'Login Success!',
              showConfirmButton: false,
              sleep:1000
            })
            setTimeout(() => {  window.location.href= "<?php echo base_url().'loginUser/loginUserAdmin';?> "; }, 1000);
            
        }else{
            Swal.fire({
              icon: 'error',
              title: 'Login Failed',
              text: 'Wrong Username or Password!'
            })   
        }
    }
</script>
</body>

</html>
<?php if (isset($notfound)) {
?>
  <script>
    swal.fire("Login Failed!", "Wrong Username or Password!", "error");
  </script>
<?php } ?>
