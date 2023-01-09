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
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden="true">ID</th>
                    <th>Nama SOP</th>
                    <th>File SOP</th>
                    <?php if ($this->session->userdata('role') == '1') { ?>
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
                      <td hidden="true"><?php echo $data->id_sop ?></td>
                      <td><?php echo $data->nama_sop ?></td>
                      <td><a target="_blank" href="<?= base_url('upload/'. str_replace(" ","_",$data->file_sop))?>"> <?php echo $data->nama_sop ?>.pdf</a></td>
                      <?php if ($this->session->userdata('role') == '1') { ?>
                        <td>
                          <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editbtn"></a>
                          <a href="<?= base_url('functions/deleteSOP/' . $data->id_sop) ?>" class="ml-2" onclick="return confirm('Apakah Anda yakin menghapus data berikut?')"><i class="fas fa-trash"></i></a>
                          <!-- <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn ml-2"></a> -->
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            <!-- END TABLE -->

            <!-- MODAL -->
            <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

            <!-- tambahData Modal -->
            <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <form action="<?php echo base_url('Functions/savesop') ?>" method="POST" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Data SOP</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="deskripsi">Nama SOP <span style="color:red;">*</span></label>
                        <input required type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Enter Deskripsi SOP" />
                      </div>
                      <div class="form-group">
                        <label for="file">File SOP <span style="color:red;">*</span></label>
                        <input required type="file" class="form-control" id="file" name="file" required />
                      </div>
                      <!--dummy nama pembuat -->
                      <div class="form-group">
                        <input type="hidden" class="form-control" id="nama" name="nama" value="1" readonly />
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
                <form action="<?php echo base_url('Functions/editsop') ?>" method="POST" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Data SOP</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <input type="hidden" id="idsop" name="idsop" value="<?= $data->id_sop ?>" />
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="deskripsi">Nama SOP <span style="color:red;">*</span></label>
                        <input type="text" required class="form-control" id="deskripsi" name="deskripsi" placeholder="Enter Deskripsi SOP" required value="<?= $data->nama_sop ?>" />
                      </div>
                      <div class="form-group">
                        <label for="file">File SOP <span style="color:red;">*</span></label>
                        <input type="file" required class="form-control" id="file" name="file" required value="<?= $data->file_sop ?>" />
                      </div>
                      <!--dummy nama pembuat -->
                      <div class="form-group">
                        <input type="hidden" class="form-control" id="nama" name="nama" value="1" readonly />
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

            <!-- detailData Modal -->
            <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Detail SOP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="deskripsiD">Nama Deskripsi</label>
                      <input id="deskripsiD" type="text" class="form-control" name="deskripsiD" value="<?= $data->nama_sop ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label for="deskripsiD">File SOP</label><br>
                      <a href="../upload/<?php echo $data->file_sop ?>"><?php echo $data->nama_sop ?>.pdf</a>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.detailData Modal -->

              <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
              <!-- END MODAL -->

            </div>
          </div>
  </section>
</div>

<?php
$this->load->view('Footer');
?>

<script>
    $(document).ready(function() {
    var table = $('#dataTable').DataTable({
        columnDefs: [
            {className: 'dt-body-center',targets: 0},
            {className: 'dt-head-center',targets: 0},
            {className: 'dt-body-center',targets: 4},
            {className: 'dt-head-center',targets: 4}
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
      $('#idsopE').val(data[1]);
      $('#deskripsiE').val(data[2]);
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
      $('#idsopD').val(data[1]);
      $('#deskripsiD').val(data[2]);
    });
  });
</script>