<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('UI/PICNonAsset/Header');
?>
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Room's Storage</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Room's Storage</li>
      </ul>
    </div>
    <!-- END HEADER -->

    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h6 class="mb-0"><b><?= $namaRuangan?></b></h6>
          </div>
          <div class="col-md-6 text-end gap-2">
            <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahData">
              <i class="fa fa-plus mr-1"></i> Add Storage
            </a>
            <a href="<?= site_url('Functions/RuanganPICNonAsset'); ?>" class="btn btn-light btn-md text-dark" >
              <i class="fa fa-plus mr-1"></i> Back To Room
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTableDetailRuangan" class=" table" style="width:100%">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Storage</th>
                <th style="text-align: center;">Action</th>
                <th style="display: none;">ID</th>
                <th style="display: none;">ID Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $status;
              foreach ($penyimpanan as $dtlruangan):
                ?>
                <tr>
                  <td style="text-align: center;"><?= $no++; ?></td>
                  <td ><?= $dtlruangan->nama_penyimpanan ?></td>
                  <td style="text-align: center;">
                    <div style="gap: 10px; white-space: nowrap;">
                      <button href="javascript:void(0)" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                      </button>
                      <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center btndelete" data-id="<?=$dtlruangan->id_dtl_penyimpanan ?>">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                      </button>
                    </div>
                      
                  </td>
                  <td style="display: none;"><?= $dtlruangan->id_penyimpanan ?></td>
                  <td style="display: none;"><?= $dtlruangan->id_dtl_penyimpanan ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- END TABLE -->

    <!-- MODAL -->
    <!-- tambahData Modal -->
    <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?= base_url('functions/savedetailruanganPICNonAsset') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Add Room's Storage</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <label class="form-label">Room Name </label>
                  <input type="hidden" id="id_ruangan" name="id_ruangan" class="form-control form-control-user" readonly required value="<?= $idRuangan?>" />
                  <input for="namaRuangan" type="text" class="form-control" name="namaRuangan" placeholder="Room Name" required value="<?= $namaRuangan?>" />
                </div>
                
                <div class="col-12">
                  <label for="penyimpanan"  class="form-label">Storage <span style="color:red;">*</span></label>
                  <select name="penyimpanan" id="penyimpanan" class="form-control" required>
                      <option value="">--Storage--</option>
                      <?php foreach ($daftar_penyimpanan as $stg): ?>
                        <option value="<?= $stg->id_penyimpanan ?>"><?= $stg->nama_penyimpanan ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Tambah</button>
              <button style="width:150px" type="button"  data-dismiss="modal" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.tambahData Modal -->

    <!-- editData Modal -->
    <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?= base_url('functions/editDetailRuanganPICNonAsset') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Edit Room's Storage</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <label class="form-label">Room Name </label>
                  <input type="hidden" id="id_ruanganE" name="id_ruanganE" class="form-control form-control-user" readonly required value="<?= $idRuangan?>" />
                  <input type="hidden" id="idDetailRuanganE" name="idDetailRuanganE" class="form-control form-control-user" readonly required  />
                  <input for="namaRuangan" type="text" class="form-control" name="namaRuangan" placeholder="Room Name" required value="<?= $namaRuangan?>" />
                </div>
                
                <div class="col-12">
                  <label for="penyimpananE"  class="form-label">Storage <span style="color:red;">*</span></label>
                  <select name="penyimpananE" id="penyimpananE" class="form-control" required>
                      <option value="">--Storage--</option>
                      <?php foreach ($daftar_penyimpanan as $stg): ?>
                        <option value="<?= $stg->id_penyimpanan ?>"><?= $stg->nama_penyimpanan ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button style="width:150px" id="btn_update_barang" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Update</button>
              <button style="width:150px" id="btn_batal_update" type="button" onclick="$('#editData').modal('hide')" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
$this->load->view('Footer');
if (isset($error)) {
  ?>
  <script>
    swal.fire("Error!", "<?=$error?>", "error");
  </script>
  <?php
}else if (isset($tambah)) {
  ?>
  <script>
    swal.fire("Succeed!", "Data successfully added!", "success");
  </script>
  <?php
} else if (isset($hapus)) {
  ?>
    <script>
      swal.fire("Succeed!", "Data deleted successfully!", "success");
    </script>
  <?php
} else if (isset($ubah)) {
  ?>
      <script>
        swal.fire("Succeed!", "Data successfully changed!", "success");
      </script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function() {
    var tableData = $('#dataTableDetailRuangan').DataTable({
      "ordering": true,
      columnDefs: [
        { targets: 0, type: 'num' },
        {
          targets: [3,4], 
          visible: false,
          searchable: false
        }
        
      ]
    });
    
    $('.editbtn').on('click', function () {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var row = tableData.row($tr);
      var data = row.data(); // Ini akan mengembalikan array semua kolom, termasuk yang hidden
      $('#idDetailRuanganE').val(data[4]);
      $('#penyimpananE').val(data[3]);
      
    });
  });
  //Sweet Alert to delete data
  $('.btndelete').on('click', function () {
    var id_dtl_penyimpanan = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to delete data?',
      text: "You can't return this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/deletedetailruanganPICNonAsset') ?>",
          method: "post",
          data: {
            id_dtl_penyimpanan: id_dtl_penyimpanan
          }
        })
        Swal.fire({
          title: 'Succeed!',
          text: 'Data deleted successfully!',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('Functions/PICNonAsset/DetailRuangan/'.$idRuangan) ?>"
          }
        })
      }
    })
  });
</script>