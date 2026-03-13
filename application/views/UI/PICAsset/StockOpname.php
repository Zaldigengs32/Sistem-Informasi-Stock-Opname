<?php
$this->load->view('UI/PICAsset/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Stock Opname</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Stock Opname</li>
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
          <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahStockOpname">
            <i class="fa fa-plus mr-1"></i> Add Session
          </a>
        </div>
      </div>

      <?= form_open('Functions/StockOpnamePICAsset', ['method' => 'post', 'id' => 'filterForm']) ?>
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
              <option value="On Progress Approval Koor UPT" <?= (isset($status_filter) && $status_filter == 'On Progress Approval Koor UPT') ? 'selected' : '' ?>>On Progress Koor UPT</option>
              <option value="Approved" <?= (isset($status_filter) && $status_filter == 'Approved') ? 'selected' : '' ?>>Approved</option>
              <option value="Rejected" <?= (isset($status_filter) && $status_filter == 'Rejected') ? 'selected' : '' ?>>Rejected</option>
            </select>
          </div>
          <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-sm btn-secondary w-100" type="button" id="btnResetFilter">Reset</button>
          </div>
        </div>
      <?= form_close() ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableStockOpname" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Start Date</th>
              <th style="text-align: center;">End Date</th>
              <th style="text-align: center;">PIC</th>
              <th style="text-align: center;">Description</th>
              <th style="text-align: center;">Total Items</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center;">Action</th>
              <th style="display: none;">ID</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($stockopname as $so): 
              $startDate = ($so->so_start_date && $so->so_start_date != '0000-00-00') ? (new DateTime($so->so_start_date))->format('d/m/Y') : '-';
              $endDate = ($so->so_end_date && $so->so_end_date != '0000-00-00') ? (new DateTime($so->so_end_date))->format('d/m/Y') : '-';
            ?>
              <tr>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td style="text-align: right;" data-order="<?= $so->so_start_date ?>">
                  <?= $startDate ?>
                </td>
                <td style="text-align: right;" data-order="<?= $so->so_end_date ?>">
                  <?= $endDate ?>
                </td>
                <td style="text-align: center;"><?= $so->nama_pengguna ?></td>
                <td style="text-align: center;"><?= $so->so_deskripsi ?></td>
                <td style="text-align: center;"><?= $so->so_total_item ?></td>
                <td style="text-align: center;">
                  <?php 
                  $status = $so->so_status ?? 'Draft'; // Default to Draft if NULL
                  switch ($status) {
                    case 'Draft':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">Draft</span>';
                      break;
                    case 'On Progress Approval Koor UPT':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #8B5CF6; color: white;">On Progress Approval Koor UPT</span>';
                      break;
                    case 'Approved':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #DBEAFE; color: #3B82F6;">Approved</span>';
                      break;
                    case 'Rejected':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #EF4444; color: white;">Rejected</span>';
                      break;
                    default:
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">Draft</span>';
                  } ?>
                </td>
                <td style="text-align: center;">
                  <div style="gap: 10px; white-space: nowrap;">
                    <?php 
                    $status = $so->so_status ?? 'Draft'; // Default to Draft if NULL
                    if ($status == 'Draft' || $status == '' || $status == null): ?>
                      <!-- Add Item -->
                      <a href="<?= base_url('Functions/AddItemStockOpnamePage/' . $so->so_id_opname) ?>" class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: #EDE9FE; color: #8B5CF6;" title="Add Item">
                        <iconify-icon icon="lucide:plus"></iconify-icon>
                      </a>

                      <!-- Edit -->
                      <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn" data-id="<?= $so->so_id_opname ?>" title="Edit">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                      </button>

                      <!-- Detail -->
                      <a href="<?= base_url('Functions/StockOpnameDetailPICAsset/' . $so->so_id_opname) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>

                      <!-- Delete -->
                      <button class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center deletebtn" data-id="<?= $so->so_id_opname ?>" title="Delete">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                      </button>

                      <!-- Send -->
                      <button class="w-32-px h-32-px rounded-circle d-inline-flex align-items-center justify-content-center sendbtn" style="background-color: #DBEAFE; color: #3B82F6;" data-id="<?= $so->so_id_opname ?>" title="Send">
                        <iconify-icon icon="lucide:send"></iconify-icon>
                      </button>
                      
                    <?php else: ?>
                      <a href="<?= base_url('Functions/StockOpnameDetailPICAsset/' . $so->so_id_opname) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                        <iconify-icon icon="lucide:list"></iconify-icon>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
                <td style="display: none;"><?= $so->so_id_opname ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Stock Opname Session Modal -->
  <div class="modal fade" id="tambahStockOpname" tabindex="-1" role="dialog" aria-labelledby="tambahStockOpname" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/saveStockOpnameSession') ?>" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Add Opname Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-md-6">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" name="pic_name" value="<?= $this->session->userdata('nama') ?>" readonly />
                <input type="hidden" name="id_pengguna" value="<?= $this->session->userdata('id') ?>" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Start Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="so_start_date" id="add_so_start_date" readonly required />
              </div>
              <div class="col-12">
                <label class="form-label">Description <span style="color:red;">*</span></label>
                <textarea class="form-control" name="so_deskripsi" rows="3" placeholder="Enter description" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" data-dismiss="modal" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetAddForm()">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Stock Opname Session Modal -->
  <div class="modal fade" id="editStockOpname" tabindex="-1" role="dialog" aria-labelledby="editStockOpname" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/updateStockOpnameSession') ?>" method="POST">
        <input type="hidden" name="so_id_opname" id="edit_so_id_opname" />
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Edit Opname Session</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-md-6">
                <label class="form-label">PIC <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_pic_name" readonly />
                <input type="hidden" name="id_pengguna" id="edit_id_pengguna" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Start Date <span style="color:red;">*</span></label>
                <input type="date" class="form-control" name="so_start_date" id="edit_so_start_date" readonly required />
              </div>
              <div class="col-12">
                <label class="form-label">Description <span style="color:red;">*</span></label>
                <textarea class="form-control" name="so_deskripsi" id="edit_so_deskripsi" rows="3" placeholder="Enter description" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" onclick="resetEditForm()">Cancel</button>
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
    swal.fire("Succeed!", "Stock opname session added successfully!", "success");
  </script>
<?php } else if (isset($ubah)) { ?>
  <script>
    swal.fire("Succeed!", "Stock opname session updated successfully!", "success");
  </script>
<?php } ?>

<script type="text/javascript">
// Get today's date string globally
function getTodayStr() {
  var today = new Date();
  var yyyy = today.getFullYear();
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var dd = String(today.getDate()).padStart(2, '0');
  return yyyy + '-' + mm + '-' + dd;
}

function setAddFormDate() {
  $('#add_so_start_date').val(getTodayStr());
}

function resetAddForm() {
  $('#tambahStockOpname form')[0].reset();
  setAddFormDate(); // Re-set the date after reset
  $('#tambahStockOpname').modal('hide');
}

function resetEditForm() {
  $('#editStockOpname form')[0].reset();
  $('#editStockOpname').modal('hide');
}

$(document).ready(function() {
  // Set start date to today's date on page load
  var todayStr = getTodayStr();
  
  $('#add_so_start_date').val(todayStr);
  $('#edit_so_start_date').val(todayStr);
  
  // Also set date when modal is shown
  $('#tambahStockOpname').on('show.bs.modal', function () {
    setAddFormDate();
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

  var tableData = $('#dataTableStockOpname').DataTable({
    "ordering": true,
    "deferRender": true,
    "pageLength": 25,
    "autoWidth": false,
    columnDefs: [
      { targets: 0, type: 'num', className: 'text-end' },
      { targets: 1, type: 'date', className: 'text-end' },
      { targets: 2, type: 'date', className: 'text-end' },
      { targets: 3, className: 'text-center' },
      { targets: 4, className: 'text-center' },
      { targets: 5, className: 'text-center' },
      { targets: 6, className: 'text-center' },
      { targets: 7, className: 'text-center' },
      { targets: [8], visible: false, searchable: false }
    ]
  });

  $('#tambahStockOpname').on('hidden.bs.modal', function () {
    $('#tambahStockOpname form')[0].reset();
    setAddFormDate(); // Re-set the date after modal close
  });

  $('#editStockOpname').on('hidden.bs.modal', function () {
    $('#editStockOpname form')[0].reset();
  });

  // Edit button click handler
  $('#dataTableStockOpname').on('click', '.editbtn', function() {
    var id = $(this).data('id');
    
    $.ajax({
      url: '<?= base_url("Functions/getStockOpnameById") ?>',
      method: 'POST',
      data: { so_id_opname: id },
      dataType: 'json',
      success: function(response) {
        $('#edit_so_id_opname').val(response.so_id_opname);
        $('#edit_so_start_date').val(todayStr);
        $('#edit_pic_name').val(response.nama_pengguna);
        $('#edit_id_pengguna').val(response.so_pic);
        $('#edit_so_deskripsi').val(response.so_deskripsi);
        $('#editStockOpname').modal('show');
      }
    });
  });

  // Delete button click handler
  $('#dataTableStockOpname').on('click', '.deletebtn', function() {
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
          url: '<?= base_url("Functions/deleteStockOpnameSession") ?>',
          method: 'POST',
          data: { so_id_opname: id },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Deleted!',
                text: 'Stock opname session has been deleted.',
                icon: 'success'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to delete session.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to delete session.', 'error');
          }
        });
      }
    });
  });

  // Send button click handler
  $('#dataTableStockOpname').on('click', '.sendbtn', function() {
    var id = $(this).data('id');
    
    // First check if stock opname has items
    $.ajax({
      url: '<?= base_url("Functions/checkStockOpnameItems") ?>',
      method: 'POST',
      data: { so_id_opname: id },
      dataType: 'json',
      success: function(response) {
        console.log('Check items response:', response); // Debug
        if (!response || response.count === 0 || response.count === '0') {
          Swal.fire('Warning!', 'Cannot send stock opname without items. Please add at least one item first.', 'warning');
          return;
        }
        
        // Has items, proceed with confirmation
        Swal.fire({
          title: 'Send for Approval?',
          text: "This stock opname will be submitted for approval. You won't be able to edit it after sending.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#E5E7EB',
          confirmButtonText: 'Yes, send it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url("Functions/sendStockOpnameForApproval") ?>',
              method: 'POST',
              data: { so_id_opname: id },
              dataType: 'json',
              success: function(response) {
                if (response.status === 'success') {
                  Swal.fire({
                    title: 'Sent!',
                    text: 'Stock opname has been sent for approval.',
                    icon: 'success'
                  }).then(() => {
                    location.reload();
                  });
                } else {
                  Swal.fire('Error!', response.message || 'Failed to send stock opname.', 'error');
                }
              },
              error: function() {
                Swal.fire('Error!', 'Failed to send stock opname.', 'error');
              }
            });
          }
        });
      },
      error: function(xhr, status, error) {
        console.log('AJAX Error:', error); // Debug
        Swal.fire('Error!', 'Failed to check items. Please try again.', 'error');
      }
    });
  });
});
</script>
