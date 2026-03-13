<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<head>
    <title>Member</title>
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
    <style type="text/css">
        .struktur{
            height: 300px;
            display: block;
            background: transparent;    
            /*border: 2px solid #ccc;
            box-shadow: 10px 10px 10px #999;*/
        }
        .caption {
            padding: 20px;
            font-size: 12px;
            color: white;
            padding-left: 30px;
            padding-top: 30px;
        }
        .kotakan {
            background-image: linear-gradient(55deg, #e712ea 5%, #9858ff 91%);
            color: #fff;
        }

        .kotakan:before {
            content: '';
            width: 40%;
            height: 30px;
            background-color: #fff;
            position: absolute;
            top: -1px;
            right: -8px;
            z-index: 0;
            transform: skewX(30deg);
        }

        .kotakan:after {
            content: '';
            width: 28px;
            height: 28px;
            border-bottom: solid 14px #fff;
            border-right: solid 14px #fff;
            border-left: solid 14px transparent;
            border-top: solid 14px transparent;
            position: absolute;
            bottom: 0px;
            right: 0px;
            z-index: 1;
        }

        .kotakan .copy {
            padding: 30px 0 30px 30px;
        }
        .kotakan-kiri {
          background-image: linear-gradient(-55deg, #ea8e12 5%, #ffc458 91%);
          color: #fff;
        }

        .kotakan-kiri:before {
          content: '';
          width: 40%;
          height: 30px;
          background-color: #fff;
          position: absolute;
          top: -1px;
          left: -8px;
          z-index: 0;
          transform: skewX(-30deg);
        }

        .kotakan-kiri:after {
          content: '';
          width: 28px;
          height: 28px;
          border-bottom: solid 14px #fff;
          border-left: solid 14px #fff;
          border-right: solid 14px transparent;
          border-top: solid 14px transparent;
          position: absolute;
          bottom: 0px;
          left: 0px;
          z-index: 1;
        }

        .kotakan-kiri .copy {
          padding: 30px 30px 30px 0;
        }
        .title{
            font-weight: 600;
            font-size: 44px;
            letter-spacing: 0;
            font-style: italic;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 18px;
            font-weight: 500;
            font-style: italic;
            line-height: 29px;
            opacity: .6;
        }
        .ident {
          font-weight: 400;
          font-style: italic;
          margin: 5px -17px 0 -16px;
        }

        .ident li {
          padding: 3px 17px 3px 16px;
          position: relative;
        }
        .ident-left {
          font-weight: 400;
          font-style: italic;
          margin: 5px 65px 5px -50px;
        }

        .ident-left li {
          padding: 3px 17px 3px 16px;
          position: relative;
        }

        li:after {
          content: '';
          width: 1px;
          height: 100%;
          background-color: #fff;
          position: absolute;
          right: 0;
          top: 0;
        }

       .ident li:last-child:after {
          display: none;
        }
        .flex {
          display: flex;
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
    <?php 
        $warna[2]='style="margin-top: 30px;background-image: linear-gradient(55deg, #12ea9a 5%, #a8ff58 91%)"';
        $warna[7]='style="margin-top: 30px;background-image: linear-gradient(55deg, #12ea9a 5%, #a8ff58 91%)"';
        $warna[0]='style="margin-top: 30px;background-image: linear-gradient(55deg, #e712ea 5%, #9858ff 91%)"';
        $warna[5]='style="margin-top: 30px;background-image: linear-gradient(55deg, #e712ea 5%, #9858ff 91%)"';
        $warna[1]='style="margin-top: 30px;background-image: linear-gradient(-55deg, #ea8e12 5%, #ffc458 91%)"';
        $warna[6]='style="margin-top: 30px;background-image: linear-gradient(-55deg, #ea8e12 5%, #ffc458 91%)"';
        $warna[3]='style="margin-top: 30px;background-image: linear-gradient(-55deg, #1272ea 5%, #58f7ff 91%)"';
        $warna[8]='style="margin-top: 30px;background-image: linear-gradient(-55deg, #1272ea 5%, #58f7ff 91%)"';
        $warna[4]='style="margin-top: 30px;background-image: linear-gradient(70deg, #ea1280 5%, #ff58fa 91%)"';
        $warna[9]='style="margin-top: 30px;background-image: linear-gradient(70deg, #ea1280 5%, #ff58fa 91%)"';
    ?>
    <center>
    <div  style="margin-top: 100px;margin-bottom: 150px;width: 90%;">
        <!-- Hero Slider -->
        <?php
            $count = 0;
            foreach($member as $row) {
                $class ="kotakan-kiri";
                if($count%2==0){
                    $class ="kotakan";
                }
            ?>
            <div class="<?php echo $class;?>" <?php echo $warna[$count]; ?>>
                <div class="row">
                    <?php 
                        if($count%2==1){
                    ?>
                        <div class="col-md-5" style="justify-content: center;">
                            <center><img class="struktur"  src="<?php echo base_url();?>assets/foto/Tim/<?php echo $row->foto; ?>" ></center>
                        </div>
                    <?php } ?>
                    <div class="col-md-7 caption" >
                        <h1 class="title" align="left" style="padding-left: 30px;padding-top: 30px;"><?php echo $row->nama_pengguna; ?></h1>

                        <h3 class="subtitle" align="left" style="padding-left: 30px">
                            <span style="text-transform: uppercase; font-style: normal; padding: 0px 5px 0px 5px;">
                                <?php echo $row->main_job; ?>
                            </span>
                        </h3>
                        <ul class="ident flex">
                            <?php $second = explode(',',$row->other_job); 
                                for($i=0;$i<count($second);$i++){
                                    echo '<li><b>'.$second[$i].'</b></li>';
                                }
                            ?>
                        </ul>
                    </div>
                     <?php 
                        if($count%2==0){
                            
                    ?>
                        <div class="col-md-5" style="justify-content: center;">
                            <center><img class="struktur"  src="<?php echo base_url();?>assets/foto/Tim/<?php echo $row->foto; ?>" ></center>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php $count++; } ?>
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