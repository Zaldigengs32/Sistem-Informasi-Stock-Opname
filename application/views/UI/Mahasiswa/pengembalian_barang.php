<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/dist/css/styles.css" rel="stylesheet" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Course Project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.css">
    <link href="<?php echo base_url() ?>assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/responsive.css">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> 
   

    <style>
        body {font-family: Arial, Helvetica, sans-serif;}

        #myImg {
          border-radius: 5px;
          cursor: pointer;
          transition: 0.3s;
        }
        #myImg:hover {opacity: 0.7;}
        /* The Modal (background) */
        .modal {
          display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          /*z-index: 1;  Sit on top */
          padding-top: 10px; /* Location of the box */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
          margin: auto;
          display: block;
          width: 50%;
          max-width: 700px;
        }


        /* Add Animation */
        .modal-content, #caption {  
          -webkit-animation-name: zoom;
          -webkit-animation-duration: 0.6s;
          animation-name: zoom;
          animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
          from {-webkit-transform:scale(0)} 
          to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
          from {transform:scale(0)} 
          to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
          position: absolute;
          top: 15px;
          right: 35px;
          color: #f1f1f1;
          font-size: 40px;
          font-weight: bold;
          transition: 0.3s;
        }

        .close:hover,
        .close:focus {
          color: #bbb;
          text-decoration: none;
          cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
          .modal-content {
            width: 100%;
          }
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
        <div class="" style="margin-top:120px;margin-bottom: 50px;">
            <h1 style="color:black;font-size: 28px;">RIWAYAT PEMINJAMAN BARANG</h1>
            <div class="col-lg-11" style="margin-top:20px;margin-bottom: 100px;">
                
                <table class="col-lg-12 table-strip table " width="100%" id="example">
                    
                    <thead>
                        <tr>
                            <th><center>No</center></th>
                            <th><center>No Pengajuan</center></th>
                            <th><center>Tanggal Peminjaman</center></th>
                            <th><center>Waktu Peminjaman</center></th>
                            <th><center>Keperluan</center></th>
                            <th><center>Status</center></th>
                            <th><center>AKSI</center></th>
                        </tr>
                    </thead>
                     <tbody>
                    <?php
                        $count = 0;
                        foreach($peminjaman as $row) {
                            $count++;
                    ?>
                       
                            <tr>
                                <td><center><?php echo $count; ?></center></td>
                                <td><?php echo $row->no_pengajuan; ?></td>
                                <td><?php echo $row->tanggal; ?></td>
                                <td><center><?php echo $row->mulai_pinjam.' WIB - '.$row->selesai_pinjam.' WIB'; ?></center></td>
                                <td><center><?php echo $row->keperluan; ?></center></td>
                                <td>
                                    <center>
                                        <?php echo $row->status; ?>
                                    </center>
                                </td>
                                <?php if (isset($_COOKIE['nim'])&&$_COOKIE['nim']!='') { ?>
                                    <td>
                                    <center>
                                        <a href="<?php if($row->status == "Disetujui"){
                                            echo base_url('Dashboard/formUbahPeminjamanBarang/'.$row->id_peminjaman_barang);}
                                          elseif($row->status == "Dipinjam"){ 
                                            echo base_url('Dashboard/formUbahPeminjamanSesudahBarang/'.$row->id_peminjaman_barang);
                                          }?>  "                                            
                                          id="ubahriwayatRuangan<?php echo $count; ?>"<?php if($row->status == "Pengajuan" or $row->status == 'Ditolak' or $row->status == 'Selesai'){ 
                                            echo "style='display:none'";
                                          }?>
                                           ><i class="fas fa-edit" style="font-size:15px"></i></a>
                                        <a href="<?php echo base_url('Dashboard/formDetailPeminjamanBarang/'.$row->id_peminjaman_barang) ?>"><i class="fa fa-tasks color-muted ml-2"></i></a></center>
                                    </td>
                                <?php } ?>
                            </tr>
                            
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </center>
    <!-- Footer Content -->
    
    <!-- Footer -->
    <footer class="footer" style="position:fixed; bottom:0;">
        <div class="container">
            <div class="footer_bar d-flex flex-column flex-sm-row align-items-center">
                <div class="footer_copyright">
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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <span class="close">&times;</span>
      <img class="modal-content" id="img01">
    </div>
    <script>
        function zoom(id){
            // Get the modal
            var modal = document.getElementById("myModal");
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById(id);
            var modalImg = document.getElementById("img01");
            img.onclick = function(){
              modal.style.display = "block";
              modalImg.src = this.src;
              captionText.innerHTML = this.alt;
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() { 
                modal.style.display = "none";
            }
        }
        function pinjamBarang(id){

            document.getElementById("submitButton"+id).style.display = 'block';
            document.getElementById("jumlah"+id).style.display = 'block';
            document.getElementById("pinjamButton"+id).style.display = 'none';
        }
    </script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/easing/easing.js"></script>

</body>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="<?php echo base_url() ?>assets/dist/js/scripts.js"></script>

</html>