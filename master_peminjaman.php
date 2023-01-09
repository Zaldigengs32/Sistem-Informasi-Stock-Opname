<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeminjamanRuangan</title>
    
    <!-- All CSS -->
    <link href="<?php echo base_url() ?>assets/mahasiswa/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mahasiswa/css/style.css">
</head>
<body>    
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#"><span style="color: #0089FF">Peminjaman</span>Ruangan</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#">Form Peminjaman</a>
              </li>        
            </ul>
          </div>
        </div>
      </nav>
      
      <?php echo $data;?>
      
      <footer class="bg-dark p-2 text-center">
          <div class="container">
              <p class="text-white">All Right Reserved By MI 2022</p>
          </div>
      </footer>
      <!-- footer ends --> 
    <!-- All Js -->
    <script src="<?php echo base_url() ?>assets/mahasiswa/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>assets/mahasiswa/js/script.js"></script>
    <?php echo $script;?>
</body>
</html>