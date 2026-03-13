<?php
$this->load->view('UI/PICAsset/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Mutation</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Mutation</li>
    </ul>
  </div>
  <!-- END HEADER -->

  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Filter</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahMutasi">
            <i class="fa fa-plus mr-1"></i> Add Session
          </a>
        </div>
      </div>

      <?= form_open('Functions/MutasiPICAsset', ['method' => 'post', 'id' => 'filterForm']) ?>
        <div class="row mt-10 gx-2">
          <div class="col-md-2">
            <label class="form-label small text-muted mb-1">Start Date</label>
            <input type="date" class="form-control form-control-sm filter-input" name="start_date" id="start_date" value="<?= set_value('start_date', $start_date ?? '') ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label small text-muted mb-1">End Date</label>
            <input type="date" class="form-control form-control-sm filter-input" name="end_date" id="end_date" value="<?= set_value('end_date', $end_date ?? '') ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label small text-muted mb-1">Status</label>
            <select class="form-select form-select-sm filter-input" name="status_filter" id="status_filter">
              <option value="">- All Status -</option>
              <option value="Draft" <?= (isset($status_filter) && $status_filter == 'Draft') ? 'selected' : '' ?>>Draft</option>
              <option value="On Progress Approval Koordinator UPT" <?= (isset($status_filter) && $status_filter == 'On Progress Approval Koordinator UPT') ? 'selected' : '' ?>>On Progress Koor UPT</option>
              <option value="Approved" <?= (isset($status_filter) && $status_filter == 'Approved') ? 'selected' : '' ?>>Approved</option>
              <option value="Rejected" <?= (isset($status_filter) && $status_filter == 'Rejected') ? 'selected' : '' ?>>Rejected</option>
            </select>
          </div>
          <div class="col-md-1">
            <label class="form-label small text-muted mb-1">&nbsp;</label>
            <button class="btn btn-sm btn-secondary w-100" type="button" id="btnResetFilter">Reset</button>
          </div>
        </div>
      <?= form_close() ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableMutasi" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Mutation Date</th>
              <th style="text-align: center;">PIC</th>
              <th style="text-align: center;">Origin Location</th>
              <th style="text-align: center;">Destination Location</th>
              <th style="text-align: center;">Destination Room</th>
              <th style="text-align: center;">Reason</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center;">Action</th>
              <th style="display: none;">ID</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($mutasi as $m): ?>
             <tr>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td style="text-align: right;" data-order="<?= $m->tanggal_mutasi ?>">
                  <?= (new DateTime($m->tanggal_mutasi))->format('d/m/Y') ?>
                </td>
                <td style="text-align: center;"><?= $m->nama_pengguna ?></td>
                <td style="text-align: center;"><?= $m->lokasi_asal ?></td>
                <td style="text-align: center;"><?= $m->lokasi_tujuan ?></td>
                <td style="text-align: center;"><?= $m->ruang_penyimpanan_tujuan ?></td>
                <td style="text-align: center;"><?= $m->alasan_mutasi ?></td>
                <td style="text-align: center;">
                  <?php switch ($m->status_mutasi) {
                    case 'Draft':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">'.$m->status_mutasi.'</span>';
                      break;
                    case 'Pending':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">'.$m->status_mutasi.'</span>';
                      break;
                    case 'On Progress Approval Koordinator UPT':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #8B5CF6; color: white;">On Progress Approval Koor UPT</span>';
                      break;
                    case 'Approved':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #DBEAFE; color: #3B82F6;">'.$m->status_mutasi.'</span>';
                      break;
                    case 'Rejected':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #EF4444; color: white;">'.$m->status_mutasi.'</span>';
                      break;
                    default:
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #6B7280; color: white;">'.$m->status_mutasi.'</span>';
                  } ?>
                </td>
                <td style="text-align: center;">
                  <div style="gap: 10px; white-space: nowrap;">
                    <?php if ($m->status_mutasi == 'Draft'): ?>
                      <!-- 1. Tambah - Ungu -->
                      <a href="<?= base_url('Functions/AddItemMutasiPage/' . $m->id_mutasi) ?>" class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: #EDE9FE; color: #8B5CF6;" title="Add Item">
                        <iconify-icon icon="lucide:plus"></iconify-icon>
                      </a>

                      <!-- 2. Edit - Hijau -->
                      <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn" data-id="<?= $m->id_mutasi ?>" title="Edit">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                      </button>

                      <!-- 3. Detail - Kuning -->
                      <a href="<?= base_url('Functions/MutasiDetailPICAsset/' . $m->id_mutasi) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>

                      <!-- 4. Hapus - Merah -->
                      <button class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center deletebtn" data-id="<?= $m->id_mutasi ?>" title="Delete">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                      </button>

                      <!-- 5. Kirim - Biru -->
                      <button class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center sendbtn" style="background-color: #DBEAFE; color: #3B82F6;" data-id="<?= $m->id_mutasi ?>" title="Send">
                        <iconify-icon icon="lucide:send"></iconify-icon>
                      </button>
                      
                    <?php else: ?>
                      <a href="<?= base_url('Functions/MutasiDetailPICAsset/' . $m->id_mutasi) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
                <td style="display: none;"><?= $m->id_mutasi ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Zoom Image -->
  <div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center p-0">
          <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
        </div>
      </div>
    </div>
  </div>

  <!-- Add Mutation Session Modal -->
  <div class="modal fade" id="tambahMutasi" tabindex="-1" role="dialog" aria-labelledby="tambahMutasi" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/saveMutasiSession') ?>" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Add Mutation Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-md-6">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="pic_name" value="<?= $this->session->userdata('nama') ?>" readonly />
                <input type="hidden" name="id_pengguna" value="<?= $this->session->userdata('id') ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Mutation Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="tanggal_mutasi" value="<?= date('Y-m-d') ?>" readonly />
              </div>
              <div class="col-md-6">
                <label class="form-label">Origin Location <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="lokasi_asal" value="UPT-Informatika" readonly />
              </div>
              <div class="col-md-6">
                <label class="form-label">Destination Location <span style="color:red;">*</span></label>
                <select class="form-select" name="lokasi_tujuan" id="lokasiTujuan" required>
                  <option value="">-- Select Destination Location --</option>
                  <?php foreach ($institusi as $inst): ?>
                    <option value="<?= $inst->nama_lembaga ?>"><?= $inst->nama_lembaga ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Destination Room <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="ruang_penyimpanan_tujuan" placeholder="Enter Destination Room" required />
              </div>
              <div class="col-12">
                <label class="form-label">Mutation Reason <span style="color:red;">*</span></label>
                <textarea class="form-control" name="alasan_mutasi" rows="3" placeholder="Enter the reason for mutation" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" data-dismiss="modal" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetAddMutasiForm()">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>



  <!-- Edit Mutation Session Modal -->
<div class="modal fade" id="editMutasi" tabindex="-1" role="dialog" aria-labelledby="editMutasi" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/updateMutasiSession') ?>" method="POST">
        <input type="hidden" name="id_mutasi" id="edit_id_mutasi" />
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Edit Mutation Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-12">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_pic_name" readonly />
                <input type="hidden" name="id_pengguna" id="edit_id_pengguna" />
              </div>
              <div class="col-12">
                <label class="form-label">Mutation Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="tanggal_mutasi" id="edit_tanggal_mutasi" readonly />
              </div>
              <div class="col-12">
                <label class="form-label">Origin Location <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="lokasi_asal" id="editLokasiAsal" value="UPT-Informatika" readonly />
              </div>
              <div class="col-12">
                <label class="form-label">Destination Location <span style="color:red;">*</span></label>
                <select class="form-select" name="lokasi_tujuan" id="editLokasiTujuan" required>
                  <option value="">-- Select Destination Location --</option>
                  <?php foreach ($institusi as $inst): ?>
                    <option value="<?= $inst->nama_lembaga ?>"><?= $inst->nama_lembaga ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Destination Room <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="ruang_penyimpanan_tujuan" id="edit_ruang_penyimpanan_tujuan" placeholder="Enter Destination Room" required />
              </div>
              <div class="col-12">
                <label class="form-label">Mutation Reason <span style="color:red;">*</span></label>
                <textarea class="form-control" name="alasan_mutasi" id="edit_alasan_mutasi" rows="3" placeholder="Enter the reason for mutation" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetEditMutasiForm()">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
$this->load->view('Footer');
if (isset($error)) { ?>
  <script>
    swal.fire("Error!", "<?=$error?>", "error");
  </script>
<?php } else if (isset($tambah)) { ?>
  <script>
    swal.fire("Succeed!", "Mutation session added successfully!", "success");
  </script>
<?php } else if (isset($ubah)) { ?>
  <script>
    swal.fire("Succeed!", "Mutation session updated successfully!", "success");
  </script>
<?php } else if (isset($accept)) { ?>
  <script>
    swal.fire("Succeed!", "Data saved successfully!", "success");
  </script>
<?php } else if (isset($reject)) { ?>
  <script>
    swal.fire("Succeed!", "Data saved successfully!", "success");
  </script>
<?php } ?>

<script type="text/javascript">
// Reset Add Mutation Session form
function resetAddMutasiForm() {
  // Reset form fields
  $('#tambahMutasi form')[0].reset();
  
  // Reset destination select (Select2)
  if ($('#lokasiTujuan').hasClass('select2-hidden-accessible')) {
    $('#lokasiTujuan').val('').trigger('change');
  }
  
  // Close modal
  $('#tambahMutasi').modal('hide');
}



// Reset Edit Mutation form
function resetEditMutasiForm() {
  $('#editMutasi form')[0].reset();
  if ($('#editLokasiTujuan').hasClass('select2-hidden-accessible')) {
    $('#editLokasiTujuan').val('').trigger('change');
  }
  $('#editMutasi').modal('hide');
}

function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  const imageModalEl = document.getElementById('imageModal');
  const modal = new bootstrap.Modal(imageModalEl);
  modal.show();
  setTimeout(() => {
    imageModalEl.style.zIndex = 1060;
    const backdrops = document.querySelectorAll('.modal-backdrop');
    if (backdrops.length > 0) {
      backdrops[backdrops.length - 1].style.zIndex = 1040;
    }
  }, 150);
}

$(document).ready(function() {
  var tableData = $('#dataTableMutasi').DataTable({
    "ordering": true,
    "deferRender": true,
    "pageLength": 25,
    "autoWidth": false,
    columnDefs: [
      { targets: 0, type: 'num', className: 'text-end' }, // No
      { targets: 1, type: 'date', className: 'text-end' }, // Mutation Date
      { targets: 2, className: 'text-center' }, // PIC
      { targets: 3, className: 'text-center' }, // Origin Location
      { targets: 4, className: 'text-center' }, // Destination Location
      { targets: 5, className: 'text-center' }, // Destination Room
      { targets: 6, className: 'text-center' }, // Reason
      { targets: 7, className: 'text-center' }, // Status
      { targets: 8, className: 'text-center' }, // Action
      { targets: [9], visible: false, searchable: false }
    ]
  });

  // Auto-filter on change
  $('.filter-input').on('change', function() {
    $('#filterForm').submit();
  });

  // Reset filter
  $('#btnResetFilter').on('click', function() {
    $('#start_date').val('');
    $('#end_date').val('');
    $('#status_filter').val('');
    $('#filterForm').submit();
  });

  // Reset form when modal is hidden (closed by any method)
  $('#tambahMutasi').on('hidden.bs.modal', function () {
    resetAddMutasiForm();
  });
  

  
  $('#editMutasi').on('hidden.bs.modal', function () {
    $('#editMutasi form')[0].reset();
    if ($('#editLokasiTujuan').hasClass('select2-hidden-accessible')) {
      $('#editLokasiTujuan').val('').trigger('change');
    }
  });

  // Initialize Select2 for Add Mutation modal
  $('#tambahMutasi').on('shown.bs.modal', function () {
    $('#lokasiTujuan').select2({
      dropdownParent: $('#tambahMutasi'),
      placeholder: '-- Select Destination Location --',
      allowClear: true,
      width: '100%'
    });
  });

  // Edit button click handler
  $('#dataTableMutasi').on('click', '.editbtn', function() {
    var id = $(this).data('id');
    // Store lokasi_tujuan for later use
    $('#edit_id_mutasi').data('lokasi_tujuan', '');
    
    $.ajax({
      url: '<?= base_url("Functions/getMutasiById") ?>',
      method: 'POST',
      data: { id_mutasi: id },
      dataType: 'json',
      success: function(response) {
        // Populate edit form
        $('#edit_id_mutasi').val(response.id_mutasi);
        $('#edit_pic_name').val(response.nama_pengguna);
        $('#edit_id_pengguna').val(response.id_pengguna);
        $('#edit_tanggal_mutasi').val(response.tanggal_mutasi);
        $('#edit_alasan_mutasi').val(response.alasan_mutasi);
        $('#edit_ruang_penyimpanan_tujuan').val(response.ruang_penyimpanan_tujuan || '');
        
        // Set Origin Location (readonly - always UPT-Informatika)
        $('#editLokasiAsal').val('UPT-Informatika');
        
        // Store lokasi tujuan for Select2
        $('#edit_id_mutasi').data('lokasi_tujuan', response.lokasi_tujuan);
        
        // Show modal
        $('#editMutasi').modal('show');
      }
    });
  });

  // Initialize Select2 for Edit Mutation modal
  $('#editMutasi').on('shown.bs.modal', function () {
    $('#editLokasiTujuan').select2({
      dropdownParent: $('#editMutasi'),
      placeholder: '-- Select Destination Location --',
      allowClear: true,
      width: '100%'
    });
    
    // Set destination value after Select2 is initialized
    var lokasiTujuan = $('#edit_id_mutasi').data('lokasi_tujuan');
    setTimeout(function() {
      if (lokasiTujuan) {
        $('#editLokasiTujuan').val(lokasiTujuan).trigger('change');
      }
    }, 100);
  });

  // Delete button click handler
  $('#dataTableMutasi').on('click', '.deletebtn', function() {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#EF4444',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        cancelButton: 'swal2-cancel-dark-text'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= base_url("Functions/deleteMutasiSession") ?>',
          method: 'POST',
          data: { id_mutasi: id },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title : 'Deleted!',
                text: 'Mutation session has been deleted.',
                icon: 'success'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to delete mutation session.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to delete mutation session.', 'error');
          }
        });
      }
    });
  });



  // Send button click handler (submit mutation for approval)
  $('#dataTableMutasi').on('click', '.sendbtn', function() {
    var id = $(this).data('id');
    
    // First check if mutation has items
    $.ajax({
      url: '<?= base_url("Functions/checkMutasiItems") ?>',
      method: 'POST',
      data: { id_mutasi: id },
      dataType: 'json',
      success: function(response) {
        if (response.count === 0) {
          Swal.fire('Warning!', 'Cannot send mutation without items. Please add at least one item first.', 'warning');
          return;
        }
        
        // Has items, proceed with confirmation
        Swal.fire({
          title: 'Send for Approval?',
          text: "This mutation will be submitted for approval. You won't be able to edit it after sending.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#E5E7EB',
          confirmButtonText: 'Yes, send it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url("Functions/sendMutasiForApproval") ?>',
              method: 'POST',
              data: { id_mutasi: id },
              dataType: 'json',
              success: function(response) {
                if (response.status === 'success') {
                  Swal.fire({
                    title: 'Sent!',
                    text: 'Mutation has been sent for approval.',
                    icon: 'success'
                  }).then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire('Error!', response.message || 'Failed to send mutation.', 'error');
                }
              },
              error: function() {
                Swal.fire('Error!', 'Failed to send mutation.', 'error');
              }
            });
          }
        });
      }
    });
  });
});
</script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


