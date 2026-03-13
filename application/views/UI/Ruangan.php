<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('Header');
?>
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Room</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Room</li>
      </ul>
    </div>
    <!-- END HEADER -->

    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!-- <h6 class="mb-0"><b>Filter</b></h6> -->
          </div>
          <div class="col-md-6 text-end">
            <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahData">
              <i class="fa fa-plus mr-1"></i> Add Room
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTableRuangan" class=" table" style="width:100%">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Room Name</th>
                <th style="text-align: center;">Room's PIC</th>
                <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                  <th style="text-align: center;">Action</th>
                <?php } ?>
                <th style="display: none;">ID</th>
                <th style="display: none;">PIC</th>
                
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $status;
              foreach ($getData as $ruangan):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td style="text-align: center;"><?= $ruangan->nama_ruangan ?></td>
                  <td><?= $ruangan->nama_pengguna ?></td>
                  <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                    <td style="text-align: center;">
                      <div style="gap: 10px; white-space: nowrap;">
                        <button class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center databtn">
                          <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                        </button>
                        <a href="<?= site_url('Functions/DetailRuangan/'.$ruangan->id_ruangan.''); ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center detailbtn">
                          <iconify-icon icon="lucide:list"></iconify-icon>
                        </a>
                        <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn">
                          <iconify-icon icon="lucide:edit"></iconify-icon>
                        </button>
                        <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center btndelete" data-id="<?=$ruangan->id_ruangan ?>">
                          <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                      </div>
                        
                    </td>
                  <?php } ?>
                    
                  <td style="display: none;"><?= $ruangan->id_ruangan ?></td>
                  <td style="display: none;"><?= $ruangan->pic_ruangan ?></td>
                  
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- END TABLE -->

    <!-- MODAL -->
    <!-- Detail Data Modal -->
    <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="detailData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Detail Storage</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3" style="padding:5px;">
              <table id="dataTableStorage" class=" table" style="width:100%;">
                <thead>
                  <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Storage</th>
                    <th style="text-align: center;">Inventory</th>
                    <th style="text-align: center;">Total Item</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="button"  data-dismiss="modal" onclick="$('#detailData').modal('hide')" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Detail Data Modal -->

    <!-- tambahData Modal -->
    <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?= base_url('functions/saveruangan') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Add Room</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <label class="form-label">Room Name <span style="color:red;">*</span></label>
                  <input for="namaRuangan" type="text" class="form-control" name="namaRuangan" placeholder="Room Name" required />
                </div>
                
                <div class="col-12">
                  <label for="picRuangan"  class="form-label">Room's PIC <span style="color:red;">*</span></label>
                  <select name="picRuangan" id="picRuangan" class="form-control" required>
                      <option value="">--Room's PIC--</option>
                      <?php foreach ($pengguna as $pgn): ?>
                        <option value="<?= $pgn->id_pengguna ?>"><?= $pgn->nama_pengguna ?></option>
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
        <form action="<?= base_url('functions/editRuangan') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Edit Room</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <input type="hidden" id="idRuanganE" name="idRuanganE" class="form-control form-control-user" readonly required value="" />
                  <label for="namaRuanganE" class="form-label">Room Name <span style="color:red;">*</span></label>
                  <input  type="text" class="form-control" name="namaRuanganE" id="namaRuanganE" placeholder="Room Name" required />
                </div>
                
                <div class="col-12">
                  <label for="picRuanganE"  class="form-label">Room's PIC <span style="color:red;">*</span></label>
                  <select name="picRuanganE" id="picRuanganE" class="form-control" required>
                      <option value="">--Room's PIC--</option>
                      <?php foreach ($pengguna as $pgn): ?>
                        <option value="<?= $pgn->id_pengguna ?>"><?= $pgn->nama_pengguna ?></option>
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
}else if (isset($error)) {
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
    <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
      var tableData = $('#dataTableRuangan').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num' },
          {
            targets: [4, 5], 
            visible: false,
            searchable: false
          }
          
        ]
      });
    <?php }else{ ?>
      var tableData = $('#dataTableRuangan').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num' },
          {
            targets: [3, 4], 
            visible: false,
            searchable: false
          }
          
        ]
      });
    <?php } ?>
    $('.databtn').on('click', function () {
      $('#detailData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function () {
        return $(this).text();
      }).get();
      var namaRuangan = data[1];
      $.ajax({
        url: '<?= base_url("Functions/getPenyimpananByRuangan") ?>',
        method: 'POST',
        data: { nama_ruangan: namaRuangan },
        dataType: 'html',
        success: function(response) {
          let table = $('#dataTableStorage').DataTable(); // simpan di variabel global
          table.destroy();

          // 2. Ganti isi tbody
          $('#dataTableStorage tbody').html(response);

          // 3. Inisialisasi ulang
          table = $('#dataTableStorage').DataTable({
            // optional: tambahkan konfigurasi jika ada
            responsive: true,
            "ordering": true,
            columnDefs: [
              
              { targets: 0, type: 'num' }
            ],
            drawCallback: function(settings) {
              const api = this.api();
              const rows = api.rows({ page: 'current' }).nodes();

              let lastStorage = null;
              let rowspan = 1;
              let startRowIndex = 0;

              api.column(1, { page: 'current' }).data().each(function(storage, i) {
                  const currentRow = $(rows).eq(i);
                  const storageCell = currentRow.find('td:eq(1)');
                  const noCell = currentRow.find('td:eq(0)');

                  if (lastStorage === storage) {
                      rowspan++;

                      // Hapus cell duplikat
                      storageCell.remove();
                      noCell.remove();
                  } else {
                      // Jika sebelumnya ada group, atur rowspan dan style
                      if (rowspan > 1) {
                          const firstRow = $(rows).eq(startRowIndex);
                          firstRow.find('td:eq(0)').attr('rowspan', rowspan).css({
                              'vertical-align': 'middle',
                              'text-align': 'center'
                          });
                          firstRow.find('td:eq(1)').attr('rowspan', rowspan).css({
                              'vertical-align': 'middle',
                              'text-align': 'center'
                          });
                      }

                      // Reset
                      lastStorage = storage;
                      rowspan = 1;
                      startRowIndex = i;
                  }
              });

              // Tangani group terakhir
              if (rowspan > 1) {
                  const firstRow = $(rows).eq(startRowIndex);
                  firstRow.find('td:eq(0)').attr('rowspan', rowspan).css({
                      'vertical-align': 'middle',
                      'text-align': 'center'
                  });
                  firstRow.find('td:eq(1)').attr('rowspan', rowspan).css({
                      'vertical-align': 'middle',
                      'text-align': 'center'
                  });
              }
            }
          });
        }
      });
    });
    $('.editbtn').on('click', function () {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var row = tableData.row($tr);
      var data = row.data(); // Ini akan mengembalikan array semua kolom, termasuk yang hidden
      $('#idRuanganE').val(data[4]);
      $('#namaRuanganE').val(data[1]);
      $('#picRuanganE').val(data[5]);
      
    });
  });
  //Sweet Alert to delete data
  $('.btndelete').on('click', function () {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to delete data?',
      text: "You can't return this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/deleteruangan') ?>",
          method: "post",
          data: {
            id_ruangan: id
          }
        })
        Swal.fire({
          title: 'Succeed!',
          text: 'Data deleted successfully!',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('Functions/Ruangan') ?>"
          }
        })
      }
    })
  });
</script>