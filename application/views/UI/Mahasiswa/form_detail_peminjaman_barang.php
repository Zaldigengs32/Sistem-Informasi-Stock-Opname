

<!DOCTYPE html>
<html lang="en">

<body>

    <div class="super_container">

        <!-- Header -->
        <header class="header d-flex flex-row" style="top: 10px;height: 70px;">
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
            <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet" type="text/css"></link>
            <!-- Datatable -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> 

            <!-- RRQ -->

            <?php include('navbarMenu.php'); ?>
    </div>
    <style type="text/css">
       .left{
          text-align: left;
        }
        .swal-footer {
          text-align: center;
          padding-top: 13px;
          margin-top: 13px;
          padding: 13px 16px;
          border-radius: inherit;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
      }
        .button-pesan{
                    appearance: button;
                    background-color: #17a2b8;
                    background-image: none;
                    border: 1px solid #0059ab;
                    color: #000;
                    cursor: pointer;
                    display: inline-block;
                    font-family: ITCAvantGardeStd-Bk,Arial,sans-serif;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 20px;
                    /*margin: 100% 0px 0px -40px;*/
                    margin-left: -15%;
                    overflow: visible;
                    padding: 12px 40px;
                    text-align: center;
                    text-transform: none;
                    touch-action: manipulation;
                    user-select: none;
                    -webkit-user-select: none;
                    vertical-align: middle;
                    white-space: nowrap;
                }
                .button-pesan:hover {
                  appearance: button;
                    background-color: #17a2b8;
                    background-image: none;
                    border: 1px solid #0059ab;
                    box-sizing: border-box;
                    color: #000;
                    cursor: pointer;
                    display: inline-block;
                    font-family: ITCAvantGardeStd-Bk,Arial,sans-serif;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 20px;
                    overflow: visible;
                    /*padding: 12px 40px;*/
                    text-align: center;
                    text-transform: none;
                    touch-action: manipulation;
                    user-select: none;
                    -webkit-user-select: none;
                    vertical-align: middle;
                    white-space: nowrap;
                }
    </style>
       
    </header>
    
    <!-- Home -->
      <div class="row " style="margin-top: 100px;width: 100%;height:100%;background-color: #0059ab;margin-left: 0px;margin-right: 0px;">
        <center><h1 style="margin-top: 50px;color: white">FORM PEMINJAMAN BARANG SEBELUM</h1></center>
        <?php foreach($riwayat as $data){ ?>
          <center><form enctype="multipart/form-data" action="<?php echo base_url().'Peminjaman/UpdateBarangSetelah/';?>" method="post" style="margin-top: 50px;align-items: left;">
            <br>
            <div class="row">
              <div class="col-md">
                <div class="col-md row" >
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left" >
                    <span style="color: white;font-size: 18px;">Nomor Pengajuan</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="text" style="color: black;" name="no_pengajuan" class="form-control" required="true" value="<?php echo $data->no_pengajuan;  ?>" readonly="true">
                    <input hidden type="text" style="color: black;" name="id_Peminjaman" class="form-control" placeholder="id_Peminjaman" required="true" value="<?php echo $data->id_peminjaman_barang;  ?>" readonly="true">
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;" >
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left" >
                    <span style="color: white;font-size: 18px;">NIM</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="text" value="<?php echo $_COOKIE['nim'];  ?>" style="color: black;" name="nim" class="form-control" placeholder="NIM" required="true" readonly>
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Nama</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="text" value="<?php echo $_COOKIE['nama'];  ?>" style="color: black;" name="nama" class="form-control" placeholder="Nama Peminjam" required="true" readonly>
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Tanggal</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input id="datepciker" readonly type="date" min="<?php echo date("Y-m-d");?>" value="<?= $data->tanggal ?>" style="color: black;" name="tanggal" class="form-control" required="true">
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>  
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Jam Mulai</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="time" readonly style="color: black;" value="<?= $data->mulai_pinjam ?>" min="08:00" max="22:00" name="jam_mulai" class="form-control" required="true">
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Jam Selesai</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="time" readonly style="color: black;" value="<?= $data->selesai_pinjam ?>" min="08:00" max="22:00" name="jam_selesai" class="form-control" required="true">
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left" >
                    <span style="color: white;font-size: 18px;">Jumlah Pengguna</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <input type="number" readonly min="0" style="color: black;" value="<?= $data->jumlah_pengguna ?>" name="jumlah" class="form-control" required="true">
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Keperluan</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <textarea readonly id="keperluan" class="form-control" name="keperluan" rows="4" cols="50" required="true"><?= $data->keperluan ?></textarea>
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>  
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Foto Awal</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <?php if($data->foto_sebelum == '') {
                      echo 'Foto tidak ada';
                      }else{?>
                    <img style="width: 50%" src="<?php echo base_url()?>assets/foto/riwayat_barang/<?php echo $data->foto_sebelum ?>">
                  <?php } ?>
                  </div>
                </div>
                <div class="col-md row" style="margin-top: 20px;">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 left">
                    <span style="color: white;font-size: 18px;">Foto Setelah</span><span style="color:red;"> *</span>
                  </div>
                  <div class="col-md-8">
                    <?php
                    if($data->foto_setelah == ''){
                      echo 'Foto tidak ada';
                    }elseif(strpos($data->foto_setelah,'zip' !== FALSE)){ ?>
                      <p>yeyo</p>
                    <?php }else{ ?>
                    <img style="width: 50%" src="<?php echo base_url()?>assets/foto/riwayat_barang/<?php echo $data->foto_setelah ?>">
                  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-md-10 row">
                  <span style="color: white;font-size: 18px;">Barang</span>
                  <table class="table">
                    <thead style="background-color:#cccccc;">
                        <tr>
                            <th><center>No</center></th>
                            <th><center>Nama Barang</center></th>
                            <th><center>Jumlah</center></th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                    <?php
                        $count = 0;
                        foreach($awd as $row) {
                            $count++;?>
                            <tr>
                                <td><center><?php echo $count; ?></center></td>
                                <td><?php echo $row->nama_barang; ?></td>
                                <td><center><?php echo $row->jumlah; ?></center></td>
                            </tr>  
                            <?php } ?>   
                    </tbody>
                </table>
                </div>
              </div>
            </div>
            <div class="col-md-4 row" style="margin-top: 30px;margin-bottom: 30px;">
              
              <div hidden class="col-md-6 ">
                <input type="submit" name="submit" value="PESAN" class="button-pesan">
              </div>
              <center>
              <div class="col-md-6">
                <a  name="kembali" onclick="window.history.go(-1);" class="button-pesan" style="background-color: #fff;color: black">KEMBALI</a>
              </div>
              </center>
            </div>
            
          </form></center>
        <?php } ?>
          <br><br>
      </div>

    <!-- Footer Content -->

    <footer class="footer" style="padding-top: 0px;margin-top: 50px;">
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

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     
    <?php
       if(isset($sukses)){
        if($sukses==1){
          echo '<script>
            swal("Berhasil!", "Data berhasil disimpan!", "success");
          </script>';  
        }else{
          echo '<script>
            swal("Error!", "Data gagal disimpan!", "error");
          </script>';  
        }
      }
    ?>
    <script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/scrollTo/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/easing/easing.js"></script>
    <script src="<?php echo base_url() ?>assets/js/custom.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>


</body>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="<?php echo base_url() ?>assets/dist/js/scripts.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
      $('#example').DataTable({
        paging: false,
        ordering: false,
        info: false,
        searching: false
      });
  });
</script>
</html>