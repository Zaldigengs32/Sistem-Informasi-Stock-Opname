<?php
$this->load->view('UI/KoordinatorUPT/Header');
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
      </div>

      <?= form_open('Functions/MutasiKoorUPT', ['method' => 'post', 'id' => 'filterForm']) ?>
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
              <th style="text-align: center;">Destination Storage</th>
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
                    <a href="<?= base_url('Functions/MutasiDetailKoorUPT/' . $m->id_mutasi) ?>" class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Detail">
                      <iconify-icon icon="lucide:list"></iconify-icon>
                    </a>
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

</div>

<?php
$this->load->view('Footer');
if (isset($error)) { ?>
  <script>
    swal.fire("Error!", "<?=$error?>", "error");
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
      { targets: 5, className: 'text-center' }, // Destination Storage
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
});
</script>
