<?php
$this->load->view('UI/PICAsset/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Dupat</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Dupat</li>
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
          <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahDupat">
            <i class="fa fa-plus mr-1"></i> Add Session
          </a>
        </div>
      </div>

      <?= form_open('Functions/DupatPICAsset', ['method' => 'post', 'id' => 'filterForm']) ?>
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
        <table id="dataTableDupat" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Date</th>
              <th style="text-align: center;">PIC</th>
              <th style="text-align: center;">Description</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center;">Action</th>
              <th style="display: none;">ID</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($dupat as $d): ?>
              <tr>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td style="text-align: right;" data-order="<?= $d->tanggal_dupat ?>">
                  <?= (new DateTime($d->tanggal_dupat))->format('d/m/Y') ?>
                </td>
                <td style="text-align: center;"><?= $d->nama_pengguna ?></td>
                <td style="text-align: center;"><?= $d->keterangan_dupat ?></td>
                <td style="text-align: center;">
                  <?php switch ($d->status_dupat) {
                    case 'Draft':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">'.$d->status_dupat.'</span>';
                      break;
                    case 'On Progress Approval Koordinator UPT':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #8B5CF6; color: white;">On Progress Approval Koor UPT</span>';
                      break;
                    case 'Approved':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #DBEAFE; color: #3B82F6;">'.$d->status_dupat.'</span>';
                      break;
                    case 'Rejected':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #EF4444; color: white;">'.$d->status_dupat.'</span>';
                      break;
                    default:
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #6B7280; color: white;">'.$d->status_dupat.'</span>';
                  } ?>
                </td>
                <td style="text-align: center;">
                  <div style="gap: 10px; white-space: nowrap;">
                    <?php if ($d->status_dupat == 'Draft'): ?>
                      <a href="<?= base_url('Functions/AddItemDupatPage/' . $d->id_dupat) ?>" class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: #EDE9FE; color: #8B5CF6;" title="Add Item">
                        <iconify-icon icon="lucide:plus"></iconify-icon>
                      </a>
                      <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn" data-id="<?= $d->id_dupat ?>" title="Edit">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                      </button>
                      <a href="<?= base_url('Functions/DupatDetailPICAsset/' . $d->id_dupat) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>
                      <button class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center deletebtn" data-id="<?= $d->id_dupat ?>" title="Delete">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                      </button>
                      <button class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center sendbtn" style="background-color: #DBEAFE; color: #3B82F6;" data-id="<?= $d->id_dupat ?>" title="Send">
                        <iconify-icon icon="lucide:send"></iconify-icon>
                      </button>
                    <?php else: ?>
                      <a href="<?= base_url('Functions/DupatDetailPICAsset/' . $d->id_dupat) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
                <td style="display: none;"><?= $d->id_dupat ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Dupat Session Modal -->
  <div class="modal fade" id="tambahDupat" tabindex="-1" role="dialog" aria-labelledby="tambahDupat" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/saveDupatSession') ?>" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Add Dupat Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-md-6">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="pic_name" value="<?= $this->session->userdata('nama') ?>" readonly style="background-color: #e9ecef;" />
                <input type="hidden" name="id_pengguna" value="<?= $this->session->userdata('id') ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="tanggal_dupat" value="<?= date('Y-m-d') ?>" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-12">
                <label class="form-label">Description <span style="color:red;">*</span></label>
                <textarea class="form-control" name="keterangan_dupat" rows="3" placeholder="Enter description" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" data-dismiss="modal" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetAddDupatForm()">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Dupat Session Modal -->
  <div class="modal fade" id="editDupat" tabindex="-1" role="dialog" aria-labelledby="editDupat" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/updateDupatSession') ?>" method="POST">
        <input type="hidden" name="id_dupat" id="edit_id_dupat" />
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Edit Dupat Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-12">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_pic_name" readonly style="background-color: #e9ecef;" />
                <input type="hidden" name="id_pengguna" id="edit_id_pengguna" />
              </div>
              <div class="col-12">
                <label class="form-label">Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="tanggal_dupat" id="edit_tanggal_dupat" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-12">
                <label class="form-label">Description <span style="color:red;">*</span></label>
                <textarea class="form-control" name="keterangan_dupat" id="edit_keterangan_dupat" rows="3" placeholder="Enter description" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetEditDupatForm()">Cancel</button>
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
    swal.fire("Succeed!", "Dupat session added successfully!", "success");
  </script>
<?php } else if (isset($ubah)) { ?>
  <script>
    swal.fire("Succeed!", "Dupat session updated successfully!", "success");
  </script>
<?php } ?>

<script type="text/javascript">
function resetAddDupatForm() {
  $('#tambahDupat form')[0].reset();
  $('#tambahDupat').modal('hide');
}

function resetEditDupatForm() {
  $('#editDupat form')[0].reset();
  $('#editDupat').modal('hide');
}

$(document).ready(function() {
  var tableData = $('#dataTableDupat').DataTable({
    "ordering": true,
    "deferRender": true,
    "pageLength": 25,
    "autoWidth": false,
    columnDefs: [
      { targets: 0, type: 'num', className: 'text-end' },
      { targets: 1, type: 'date', className: 'text-end' },
      { targets: 2, className: 'text-center' },
      { targets: 3, className: 'text-center' },
      { targets: 4, className: 'text-center' },
      { targets: 5, className: 'text-center' },
      { targets: [6], visible: false, searchable: false }
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

  $('#tambahDupat').on('hidden.bs.modal', function () {
    resetAddDupatForm();
  });

  $('#editDupat').on('hidden.bs.modal', function () {
    $('#editDupat form')[0].reset();
  });

  // Edit button click handler
  $('#dataTableDupat').on('click', '.editbtn', function() {
    var id = $(this).data('id');
    $.ajax({
      url: '<?= base_url("Functions/getDupatById") ?>',
      method: 'POST',
      data: { id_dupat: id },
      dataType: 'json',
      success: function(response) {
        $('#edit_id_dupat').val(response.id_dupat);
        $('#edit_pic_name').val(response.nama_pengguna);
        $('#edit_id_pengguna').val(response.id_pengguna);
        $('#edit_tanggal_dupat').val(response.tanggal_dupat);
        $('#edit_keterangan_dupat').val(response.keterangan_dupat);
        $('#editDupat').modal('show');
      }
    });
  });

  // Delete button click handler
  $('#dataTableDupat').on('click', '.deletebtn', function() {
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
          url: '<?= base_url("Functions/deleteDupatSession") ?>',
          method: 'POST',
          data: { id_dupat: id },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Deleted!',
                text: 'Dupat session has been deleted.',
                icon: 'success'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to delete dupat session.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to delete dupat session.', 'error');
          }
        });
      }
    });
  });

  // Send button click handler
  $('#dataTableDupat').on('click', '.sendbtn', function() {
    var id = $(this).data('id');
    
    // First check if dupat has items
    $.ajax({
      url: '<?= base_url("Functions/checkDupatItems") ?>',
      method: 'POST',
      data: { id_dupat: id },
      dataType: 'json',
      success: function(response) {
        if (response.count === 0) {
          Swal.fire('Warning!', 'Cannot send dupat without items. Please add at least one item first.', 'warning');
          return;
        }
        
        Swal.fire({
          title: 'Send for Approval?',
          text: "This dupat will be submitted for approval. You won't be able to edit it after sending.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#E5E7EB',
          confirmButtonText: 'Yes, send it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url("Functions/sendDupatForApproval") ?>',
              method: 'POST',
              data: { id_dupat: id },
              dataType: 'json',
              success: function(response) {
                if (response.status === 'success') {
                  Swal.fire({
                    title: 'Sent!',
                    text: 'Dupat has been sent for approval.',
                    icon: 'success'
                  }).then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire('Error!', response.message || 'Failed to send dupat.', 'error');
                }
              },
              error: function() {
                Swal.fire('Error!', 'Failed to send dupat.', 'error');
              }
            });
          }
        });
      }
    });
  });
});
</script>
