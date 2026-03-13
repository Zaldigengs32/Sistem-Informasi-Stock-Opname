<?php
$this->load->view('UI/KoordinatorUPT/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Stock Opname</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?= base_url('Functions/DashboardKoorUPT') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
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
      </div>

      <?= form_open('Functions/StockOpnameKoorUPT', ['method' => 'post', 'id' => 'filterForm']) ?>
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
                  <?php switch ($so->so_status) {
                    case 'Draft':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #F59E0B; color: white;">'.$so->so_status.'</span>';
                      break;
                    case 'On Progress Approval Koor UPT':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #8B5CF6; color: white;">On Progress Approval Koor UPT</span>';
                      break;
                    case 'Approved':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #DBEAFE; color: #3B82F6;">'.$so->so_status.'</span>';
                      break;
                    case 'Rejected':
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #EF4444; color: white;">'.$so->so_status.'</span>';
                      break;
                    default:
                      echo '<span class="badge fw-semibold rounded-pill" style="background-color: #6B7280; color: white;">'.$so->so_status.'</span>';
                  } ?>
                </td>
                <td style="text-align: center;">
                  <div style="gap: 10px; white-space: nowrap;">
                    <a href="<?= base_url('Functions/StockOpnameDetailKoorUPT/' . $so->so_id_opname) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                      <iconify-icon icon="lucide:list"></iconify-icon>
                    </a>
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

</div> <!-- End dashboard-main-body -->

<?php
$this->load->view('Footer');
?>

<script type="text/javascript">
$(document).ready(function() {
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
});
</script>
