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
          <h1 class="m-0">Fasilitas</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item">Fasilitas</li>
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
            <div class="card-header ">
              <div class="d-flex justify-content-between">
              </div>
              <button class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#tambahData"><a href="#" class="text-white"><i class="fa fa-plus mr-1"></i>Tambah Data</a></button>
            </div>


        <div class="card-body">
              <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden>ID</th>
                    <th>Fasilitas</th>
                    <th hidden>Foto</th>
                    <th>Foto</th>
                    <?php if ($this->session->userdata('role') == '1') { ?>
                      <th>Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php
                  foreach ($getData as $data) {
                    $status;
                    if ($data->status == 2) {
                        $status = "Tidak Aktif";
                      } else {
                        $status = "Aktif";
                      }
                    ?>
                       <tr>
                      <td>
                        <?php $i++; ?>
                        <?= $i; ?>
                      </td>
                      <td hidden><?php echo $data->id_fasilitas ?></td>
                    <td><?php echo $data->nama_fasilitas ?></td>
                    <td hidden><?php echo $data->gambar_fasilitas; ?></td>
                    <td><img src="<?php echo base_url(); ?>assets/foto/fasilitas/<?php echo  $data->gambar_fasilitas; ?>" width="70"></td>
                    <td>
                        <a href="javascript:void(0);" title="Ubah" class="color-muted editbtn">
                          <i class="fa fa-pencil-square-o color-muted editbtn"></i>
                        </a>
                        <a href="<?= base_url('/Functions/hapusFasilitas/' . $data->id_fasilitas) ?>" onclick="return confirm('Hapus data ini?')" class="ml-2">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
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
            <form action="<?php echo base_url('Functions/savefasilitas') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Data Fasilitas</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="namaFasilitas">Nama <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" required id="namaFasilitas" name="namaFasilitas" placeholder="Enter Nama Fasilitas" />
                </div>
                <div class="form-group">
                    <div class="form-group-prepend">
                      <label for="foto">Foto Fasilitas<span class="form-group-text" style="color:red;">*</span></label>
                    </div>
                    <div class="custom-file">
                      <input type="file" required id="foto" class="custom-file-form" name="foto" required />
                      <label class="custom-file-label" for="foto">Choose file</label>
                    </div>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button name="submit" Text="Create" class="btn btn-primary shadow-sm">Tambah</button>
                  </div>
                  </div>
              </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.ecdit Data Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/editfasilitas') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Data Fasilitas</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <input hidden type="text" class="form-control" required id="idFasilitasE" name="idFasilitasE" />
                    <label for="namaFasilitasE">Nama <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" required id="namaFasilitasE" name="namaFasilitasE" placeholder="Enter Nama Fasilitas" />
                </div>
                <div class="form-group">
                    <label for="fotoE">Foto Fasilitas</label>
                    <input type="hidden" class="form-control" id="fotoO" name="fotoO" />
                    <input type="file" name="fotoE" id="fotoE" class="form-control" />
                    <img id="image" class="mt-2" width="70%">
                  </div>
                </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button Text="Edit" class="btn btn-primary shadow-sm">Ubah</button>
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
if (isset($duplicate)) {
?>
  <script>
    swal("Gagal!", "Nama Fasilitas sudah digunakan!", "error");
  </script>
<?php
} else if (isset($tambah)) {
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
            {className: 'dt-body-center',targets: 0,width: '3%'},
            {className: 'dt-head-center',targets: 0},
            {className: 'dt-body-center',targets: 5,width: '10%'},
            {className: 'dt-head-center',targets: 5}
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
      var link = "<?php echo base_url() ?>assets/foto/fasilitas/";
      $('#idFasilitasE').val(data[1]);
      $('#namaFasilitasE').val(data[2]);
      $('#fotoO').val(data[3]);
    });
  });
  
  $(document).ready(function() {
    $('.detailbtn').on('click', function() {
      $('#detailData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
        return $(this).text();
      }).get();
      console.log(data);

      var link = "<?php echo base_url() ?>assets/foto/fasilitas/";

      $('#namaFasilitasD').val(data[0]);
      $('#namaFasilitasD').val(data[1]);
      $("#imageD").attr("src", link + data[2]);
    });
  });
</script>





                
