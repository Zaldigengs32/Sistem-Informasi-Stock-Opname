<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('Header');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Peminjaman Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Menu</a></li>
                        <li class="breadcrumb-item">Riwayat Peminjaman</li>
                        <li class="breadcrumb-item">Peminjaman Barang</li>
                        <li class="breadcrumb-item">Detail Peminjaman Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END HEADER -->

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- START CONTENT -->
    <!-- DETAIL RUANGAN DATA START -->
    <section class="content" style="font-size: 17px;">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 20px;">DETAIL BARANG </h3>
                </div>
                <div class="card-body">
                    <?php foreach ($getDataSpan as $data) { 
                        $status = $data->status; ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">NIM Peminjam</label><br>
                                    <span id="dataNama"><?= $data->nim_peminjam; ?></span>
                                    <span hidden id="dataID"><?= $data->id_peminjaman_barang; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Nama Peminjam</label><br>
                                    <span id="dataJenis"><?= $data->nama_peminjam; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Tanggal Peminjaman</label><br>
                                    <span id="dataKapasitas"><?= date("d-m-Y",strtotime($data->tanggal)) ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Waktu Peminjaman</label><br>
                                    <span id="dataWaktuPeminjaman" ><?= date("H:i",strtotime($data->mulai_pinjam)) .' - '. $time2 = date("H:i",strtotime($data->selesai_pinjam)).' WIB' ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Keperluan</label><br>
                                    <span id="datakoorUpt"><?= $data->keperluan; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Jumlah Pengguna</label><br>
                                    <span class="PICC" id="PIC"><?= $data->jumlah_pengguna; ?> </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Tanggal Pengajuan</label><br>
                                    <span id="dataAdminLab1"><?= date("d-m-Y",strtotime($data->created_date)) ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Status</label><br>
                                    <span id="dataAdminLab2"><?= $data->status; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <hr>
                        <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Foto Sebelum</th>
                                    <th>Foto Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; 
                                foreach($getDataDetail as $data2){ ?>
                                    <tr>
                                        <td>
                                            <?php $i++;
                                            echo  $i; ?>
                                        </td>
                                        <td><?= $data2->nama_barang ?></td>
                                        <td><?= $data2->jumlah ?></td>
                                        <td>
                                            <?php if($data2->foto_sebelum == ''){
                                                echo '-';
                                            }else{ ?>
                                                <img style="max-height: 50;max-width: 20%;" src="<?php echo base_url(); ?>assets/foto/riwayat_barang/<?= $data2->foto_sebelum ?>">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if($data2->foto_setelah == ''){
                                                echo '-';
                                            }else{ ?>
                                                <img style="max-height: 50;max-width: 20%;" src="<?php echo base_url(); ?>assets/foto/riwayat_barang/<?= $data2->foto_setelah ?>">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="<?= site_url('Functions/RiwayatPeminjamanBarang') ?>" class="btn btn-secondary m-1">Batal</a>
                    <?php if($status == "Pengajuan" && $this->session->userdata('role') == "Super Admin"){?>
                        <button type="button" class="btn btn-danger float-sm-right btntolak m-1" data-id="<?= $data2->id_peminjaman_barang ?>">Tolak</i></button>
                        <button type="button" class="btn btn-success float-sm-right btnterima m-1" data-id="<?= $data2->id_peminjaman_barang ?>">Terima</button>                        
                    <?php } ?>
                </div>
            </div>
        </div>
    <!-- DETAIL RUANGAN DATA END -->
       
    </section>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END CONTENT -->
</div>

<?php
$this->load->view('Footer');
?>
<script>
  //Sweet Alert button terima pengajuan
  $('.btnterima').on('click', function () {
    var id = $(this).data('id');
    var temp_brg;
    // status 1 -> stock validation
    // status 2 -> succes
    var temp_status;
    console.log(id);
    Swal.fire({
      title: 'Apakah anda yakin menyetujui pengajuan ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya Setuju!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/terimaPengajuanBarang') ?>",
          method: "post",
          dataType: 'JSON',
          data: {
            id_peminjaman: id
          },
          success: function(result){
            console.log(result);
            for (let i = 0; i < result.length; i++) {
              //validasi ketika jumlah yang diajukan melebihi stok yang tersedia
              if(result[i].jumlah > result[i].stok){
                // lempar keluar looping masukin ke variable buat nampilin pesan erorr
                temp_brg = result[i].nama_barang;
                temp_status = 1;
                break;
              }else{
                $.ajax({
                  url: "<?php echo base_url('Functions/updateStok') ?>",
                  method: "post",
                  data:{
                    id_peminjaman: result[i].id_peminjaman_barang,
                    id_barang: result[i].id_barang,
                    jumlah: result[i].jumlah,
                  }
                })
                temp_status = 2; 
              }
            }
            console.log(temp_brg);
            console.log(temp_status);
            if(temp_status == 1){
                Swal.fire({
                  title: 'Pengajuan Gagal !',
                  text: 'Stok Barang '+temp_brg+' tidak cukup.',
                  type: 'error',
                  icon: 'error'
                })
            }else{
              Swal.fire({
                title: 'Berhasil !',
                text: 'Pengajuan Ruangan Disetujui.',
                type: 'success',
                icon: 'success'
                }).then(okay => {if (okay) {
                  window.location.href = "<?php echo base_url('Functions/RiwayatPeminjamanBarang') ?>"}
                })
            }
          },
          error: function(xhr,status,error){
            console.log(error.message);
          }
        })
      }
    })
  })

  //Sweet Alert button tolak pengajuan
  $('.btntolak').on('click', function() {
      var id = $(this).data('id');
      console.log(id);
      Swal.fire({
          title: 'Apakah anda yakin menolak pengajuan ?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Tolak !'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: "<?php echo base_url('Functions/tolakpengajuanBarang') ?>",
                  method: "post",
                  data: {
                      id_peminjaman: id
                  }
              })
              Swal.fire({
                  title: 'Berhasil !',
                  text: 'Pengajuan Ruangan Ditolak.',
                  type: 'success',
                  icon: 'success'
              }).then(okay => {
                  if (okay) {
                      window.location.href = "<?php echo base_url('Functions/RiwayatPeminjamanBarang') ?>"
                  }
              })
          }
      })
  });
</script>