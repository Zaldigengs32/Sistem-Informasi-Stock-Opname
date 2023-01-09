<?php
$this->load->view('Header');
?>

<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Jenis Ruangan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item">Jenis Ruangan</li>
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
              <button class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#tambahData"><a href="#" class="text-white"><i class="fa fa-plus mr-1"></i> Tambah Data</a></button>
            </div>


            <div class="card-body">
              <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                <!-- table table-bordered table-hover dataTable dtr-inline -->
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden="true">ID</th>
                    <th>Nama Jenis Ruangan</th>
                    <?php if ($this->session->userdata('role') == '1') { ?>
                      <th>Aksi</th><?php } ?>
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
                      <td hidden="true"><?php echo $data->id_jenis_ruangan ?></td>
                      <td><?php echo $data->nama_jenis_ruangan ?></td>
                      <?php if ($this->session->userdata('role') == '1') { ?>
                        <td>
                          <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editbtn" tooltip=""></a>
                          <a href="<?= base_url('functions/deleteJenisRuangan/' . $data->id_jenis_ruangan) ?>" class="ml-2" onclick="return confirm('Apakah Anda yakin menghapus data berikut?')"><i class="fas fa-trash"></i>
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

        <!-- MODAL -->
        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!-- tambahData Modal -->
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/savejenisruangan') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Data Jenis Ruangan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="namaJenisRuangan">Nama Jenis Ruangan <span style="color:red;">*</span></label>
                    <input required type="text" class="form-control" id="namaJenisRuangan" name="namaJenisRuangan" placeholder="Enter Nama Jenis Ruangan" />
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button id="submit" name="submit" Text="Create" class="btn btn-primary shadow-sm">Tambah</button>
                </div>
              </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.tambahData Modal -->

        <!-- editData Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/editjenisruangan') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Data Jenis Ruangan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="hidden" id="idJenisRuanganE" name="idJenisRuanganE" class="form-control form-control-user" readonly required></input>
                    <label for="namaJenisRuanganE">Nama Jenis Ruangan <span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" id="namaJenisRuanganE" name="namaJenisRuanganE" placeholder="Enter Nama Jenis Ruangan" required />
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button ID="submit" Text="Edit" class="btn btn-primary shadow-sm">Ubah</button>
                </div>
              </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.editData Modal -->

        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- END MODAL -->

      </div>
    </div>
  </section>
</div>




<?php
$this->load->view('Footer');
if (isset($tambah)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil ditambahkan!", "success");
  </script>
<?php
} else if (isset($hapus)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil dihapus!", "success");
  </script>
<?php
} else if (isset($ubah)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil diubah!", "success");
  </script>
<?php } ?>
<script>
    $(document).ready(function() {
    var table = $('#dataTable').DataTable({
        columnDefs: [
            {className: 'dt-body-center',targets: 0},
            {className: 'dt-head-center',targets: 0},
            {className: 'dt-body-center',targets: 3},
            {className: 'dt-head-center',targets: 3}
          ],
          scrollX: true,
          responsive: true
      });
  });
  $(document).ready(function() {
    $('.editbtn').on('click', function() {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
        return $(this).text();
      }).get();
      console.log(data);
      $('#idJenisRuanganE').val(data[1]);
      $('#namaJenisRuanganE').val(data[2]);
    });
  });
  //Sweet Alert to delete data
  $('.deletebtn').on('click', function() {
    var id = $(this).data('id');
    console.log(id);
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/deleteJenisRuangan') ?>",
          method: "post",
          data: {
            id_user: id
          }
        })
        Swal.fire({
          title: 'Deleted!',
          text: 'Your data has been deleted.',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('C_User') ?>"
          }
        })
      }
    })
  });
</script>