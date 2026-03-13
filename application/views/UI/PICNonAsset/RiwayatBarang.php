<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('UI/PICNonAsset/Header');
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
            <li class="breadcrumb-item">Peminjaman Ruangan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- END HEADER -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- TABLE -->
        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Data Peminjaman Barang</h3>
            </div>
            <div class="card-body">
              <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden>ID Peminjaman</th>
                    <th>No Pengajuan</th>
                    <th>NIM Peminjam</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal</th>
                    <th>Waktu Peminjaman</th>
                    <th>Status</th>
                    <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                      <th>Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0; ?>
                  <?php
                  foreach ($getData as $data) {
                    ?>
                    <tr>
                      <td>
                        <?php $i++; ?>
                        <?= $i; ?>
                      </td>
                      <td class="center">
                        <?= $data->no_pengajuan ?>
                      </td>
                      <td hidden>
                        <?= $data->id_peminjaman_barang ?>
                      </td>
                      <td class="center">
                        <?= $data->nim_peminjam ?>
                      </td>
                      <td>
                        <?= $data->nama_peminjam ?>
                      </td>
                      <td class="center">
                        <?= $newdate = date("d-m-Y", strtotime($data->tanggal)); ?>
                      </td>
                      <td class="center">
                        <?= $time1 = date("H:i", strtotime($data->mulai_pinjam)) . ' - ' . $time2 = date("H:i", strtotime($data->selesai_pinjam)) . ' WIB' ?>
                      </td>
                      <td class="center">
                        <?php if ($data->status == "Pengajuan") { ?>
                          <span class="badge badge-warning" style="font-size:15px;">
                            <?= $data->status ?>
                          </span>
                        <?php } elseif ($data->status == "Dipinjam") { ?>
                          <span class="badge badge-info" style="font-size:15px;">
                            <?= $data->status ?>
                          </span>
                        <?php } elseif ($data->status == "Selesai") { ?>
                          <span class="badge badge-primary" style="font-size:15px;">
                            <?= $data->status ?>
                          </span>
                        <?php } elseif ($data->status == "Ditolak") { ?>
                          <span class="badge badge-danger" style="font-size:15px;">
                            <?= $data->status ?>
                          </span>
                        <?php } elseif ($data->status == "Disetujui") { ?>
                          <span class="badge badge-success" style="font-size:15px;">
                            <?= $data->status ?>
                          </span>
                        <?php } ?>
                      </td>
                      <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                        <td class="center">
                          <div class="btn-group">
                            <a href="<?= base_url('functions/detailRiwayatBarang/' . $data->id_peminjaman_barang) ?>"
                              class="btn btn-info"><i class="fa fa-list color-muted"></i></a>
                            <?php if ($this->session->userdata('role') == "Super Admin" && $data->status == "Pengajuan") { ?>
                              <button type="button" class="btn btn-success btnterima"
                                data-id="<?= $data->id_peminjaman_barang ?>"><i class="fa fa-check-circle"></i></button>
                              <button type="button" class="btn btn-danger btntolak"
                                data-id="<?= $data->id_peminjaman_barang ?>"><i class="fas fa-times-circle"></i></button>
                            <?php } ?>
                          </div>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <br /><br /><br />
          </div>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- END TABLE -->
      </div>
    </div>
  </section>
</div>
<?php
$this->load->view('Footer'); ?>
<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').DataTable({
      dom: 'Bfrtip',
      scrollX: true,
      ordering: false,
      buttons: [{
        extend: 'excelHtml5',
        exportOptions: {
          columns: [0, 1, 3, 4, 5, 6, 7]
        },
        title: 'Riwayat Peminjaman Barang'
      }]
    });
  });
  //Sweet Alert button terima pengajuan
  $('.btnterima').on('click', function () {
    var id = $(this).data('id');
    var temp_brg = 0;
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
                console.log(temp_status);
                console.log(result[i].jumlah);
                console.log(result[i].stok);
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
                text: 'Pengajuan Barang Disetujui.',
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
  $('.btntolak').on('click', function () {
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