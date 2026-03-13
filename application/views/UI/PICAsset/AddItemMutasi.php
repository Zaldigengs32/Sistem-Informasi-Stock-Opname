<?php
$this->load->view('UI/PICAsset/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Item to Mutation</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">
        <a href="<?= base_url('Functions/MutasiPICAsset') ?>" class="hover-text-primary">Mutation</a>
      </li>
      <li>-</li>
      <li class="fw-medium">Add Item</li>
    </ul>
  </div>
  <!-- END HEADER -->

  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Select Item for Mutation</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <a href="<?= base_url('Functions/MutasiDetailPICAsset/' . $id_mutasi) ?>" class="btn btn-primary btn-md text-white me-2">
            <i class="fa fa-list mr-1"></i> Mutation Detail
          </a>
          <a href="<?= base_url('Functions/MutasiPICAsset') ?>" class="btn btn-secondary btn-md text-white">
            <i class="fa fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>

      <div class="row mt-10 gx-2">
        <div class="col-md-2">
          <select class="form-select form-select-sm" id="select-ruangan">
            <option value="">- Location -</option>
            <?php foreach ($ruangans as $ruangan): ?>
              <option value="<?= $ruangan->nama_ruangan ?>" data-id="<?= $ruangan->id_ruangan ?>"><?= $ruangan->nama_ruangan ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select form-select-sm" id="select-penyimpanan">
            <option value="">- Storage -</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select form-select-sm" id="select-kondisi">
            <option value="">- Condition -</option>
            <option value="Good">Good</option>
            <option value="Not Good">Not Good</option>
            <option value="Minor Damaged">Minor Damaged</option>
            <option value="Major Damaged">Major Damaged</option>
          </select>
        </div>
        <div class="col-md-1">
          <button class="btn btn-secondary btn-sm w-100" type="button" id="btnResetFilter">Reset</button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <!-- Loading indicator -->
      <div id="loadingIndicator" class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading data...</p>
      </div>
      <div class="table-responsive" id="tableContainer" style="display: none;">
        <table id="dataTableBarang" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center; width: 60px; vertical-align: middle;">
                <div>Select</div>
                <div class="mt-1"><input type="checkbox" id="selectAllCheckbox" class="form-check-input" style="cursor: pointer; margin: 0;" title="Select All"></div>
              </th>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Inventory Name</th>
              <th style="text-align: center;">Asset/Non Asset Number</th>
              <th style="text-align: center;">Condition</th>
              <th style="text-align: center;">Location</th>
              <th style="display: none;">ID</th>
              <th style="display: none;">Ruangan</th>
              <th style="display: none;">Penyimpanan</th>
              <th style="display: none;">Kondisi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($barang as $brg): 
            ?>
              <tr>
                <td style="text-align: center;">
                  <input type="checkbox" name="item_barang[]" class="form-check-input item-checkbox" value="<?= $brg->id_barang ?>" data-nama="<?= $brg->nama_barang ?>" data-nomor="<?= $brg->nomor_aktiva ?>" style="cursor: pointer;">
                </td>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td>
                  <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                      <?php if (!empty($brg->gambar_barang) && strpos($brg->gambar_barang, '.') !== false): ?>
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)" onerror="this.style.display='none'">
                      <?php else: ?>
                        <iconify-icon icon="mdi:image-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                      <?php endif; ?>
                    </div>
                    <div>
                      <div class="fw-medium text-dark"><?= $brg->nama_barang ?></div>
                      <span class="badge fw-semibold rounded-pill bg-<?= $brg->kategori_barang == 'Asset' ? 'success' : 'info' ?>-600 text-white" style="font-size: 10px;"><?= $brg->kategori_barang ?></span>
                      <span class="badge fw-semibold rounded-pill bg-<?= $brg->tipe_barang == 'Consummable' ? 'lilac' : 'pink' ?>-600 text-white" style="font-size: 10px;"><?= $brg->tipe_barang ?></span>
                    </div>
                  </div>
                </td>
                <td style="text-align: right;"><?= $brg->nomor_aktiva ?></td>
                <td style="text-align: center;">
                  <?php switch ($brg->kondisi_barang) {
                    case 'Good':
                      echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm text-center d-inline-block" style="min-width: 100px;">'.$brg->kondisi_barang.'</span>';
                      break;
                    case 'Not Good':
                      echo '<span class="px-20 py-4 rounded-pill fw-medium text-sm text-center d-inline-block" style="min-width: 100px; background-color: #FEF9C3; color: #CA8A04; white-space: nowrap;">'.$brg->kondisi_barang.'</span>';
                      break;
                    case 'Minor Damaged':
                      echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm text-center d-inline-block" style="min-width: 100px;">'.$brg->kondisi_barang.'</span>';
                      break;
                    case 'Major Damaged':
                      echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm text-center d-inline-block" style="min-width: 100px;">'.$brg->kondisi_barang.'</span>';
                      break;
                    default:
                      echo '<span class="bg-secondary-focus text-secondary-main px-20 py-4 rounded-pill fw-medium text-sm text-center d-inline-block" style="min-width: 100px;">'.$brg->kondisi_barang.'</span>';
                      break;
                  } ?>
                </td>
                <td style="text-align: center;"><?= $brg->nama_ruangan ?> - <?= $brg->nama_penyimpanan ?></td>
                <td style="display: none;"><?= $brg->id_barang ?></td>
                <td style="display: none;"><?= $brg->nama_ruangan ?></td>
                <td style="display: none;"><?= $brg->nama_penyimpanan ?></td>
                <td style="display: none;"><?= $brg->kondisi_barang ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <!-- Mutasi Button Section -->
      <div id="mutasiButtonSection" class="mt-4 pt-3 d-flex justify-content-between align-items-center border-top" style="display: none !important;">
        <div>
          <span id="selectedCount" class="text-muted">0 item selected</span>
        </div>
        <button type="button" id="btnMutasiSelected" class="btn btn-primary" disabled>
          Add Selected Items to Mutation
        </button>
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
</div>

<?php $this->load->view('Footer'); ?>

<?php if (isset($success)): ?>
<script>
  Swal.fire("Success!", "Item added to mutation successfully!", "success");
</script>
<?php endif; ?>

<script type="text/javascript">
function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  var modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}

// All storages data for filtering
var allStorages = <?= json_encode($penyimpanans) ?>;

// Function to update storage filter dropdown based on selected ruangan
function updateFilterStorageOptions(idRuangan) {
  var $storageSelect = $('#select-penyimpanan');
  $storageSelect.html('<option value="">- Storage -</option>');
  
  if (idRuangan) {
    allStorages.forEach(function(s) {
      if (s.id_ruangan == idRuangan) {
        $storageSelect.append('<option value="' + s.nama_penyimpanan + '">' + s.nama_penyimpanan + '</option>');
      }
    });
  }
}

$(document).ready(function() {
  var table = $('#dataTableBarang').DataTable({
    "ordering": true,
    "autoWidth": false,
    "deferRender": true,
    "processing": false,
    "order": [[1, 'asc']],
    columnDefs: [
      { targets: 0, orderable: false, width: '40px' }, // Checkbox
      { targets: 1, type: 'num', width: '50px' },
      { targets: 2, width: '250px' }, // Inventory Name
      { targets: 3, width: '120px' }, // Asset Number
      { targets: 4, width: '80px' },  // Condition
      { targets: 5, width: '150px' }, // Location
      { targets: [6, 7, 8, 9], visible: false, searchable: true }
    ],
    "initComplete": function() {
      $('#loadingIndicator').hide();
      $('#tableContainer').show();
      $('#mutasiButtonSection').show().css('display', 'flex');
    }
  });

  // Cache DOM elements
  var $selectAllCheckbox = document.getElementById('selectAllCheckbox');
  var $selectedCount = document.getElementById('selectedCount');
  var $btnMutasiSelected = document.getElementById('btnMutasiSelected');

  // Fast update selected count using native JS
  function updateSelectedCount() {
    var count = document.querySelectorAll('.item-checkbox:checked').length;
    $selectedCount.textContent = count + ' item' + (count !== 1 ? 's' : '') + ' selected';
    $btnMutasiSelected.disabled = count === 0;
  }

  // Fast update Select All state - only on current page
  function updateSelectAllState() {
    var visibleCheckboxes = document.querySelectorAll('#dataTableBarang tbody .item-checkbox');
    var total = visibleCheckboxes.length;
    var checked = document.querySelectorAll('#dataTableBarang tbody .item-checkbox:checked').length;
    $selectAllCheckbox.checked = total > 0 && checked === total;
    $selectAllCheckbox.indeterminate = checked > 0 && checked < total;
  }

  // Select All checkbox - fast native JS
  $selectAllCheckbox.addEventListener('change', function() {
    var isChecked = this.checked;
    var checkboxes = document.querySelectorAll('#dataTableBarang tbody .item-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = isChecked;
    }
    updateSelectedCount();
  });

  // Individual checkbox - use event delegation on tbody
  document.querySelector('#dataTableBarang tbody').addEventListener('change', function(e) {
    if (e.target.classList.contains('item-checkbox')) {
      updateSelectedCount();
      updateSelectAllState();
    }
  });

  // Filter by Ruangan (column 7) - also update storage dropdown
  $('#select-ruangan').on('change', function() {
    var val = this.value;
    var selectedOption = $(this).find('option:selected');
    var idRuangan = selectedOption.data('id');
    
    // Update storage filter dropdown
    updateFilterStorageOptions(idRuangan);
    $('#select-penyimpanan').val('');
    
    // Apply table filter
    table.column(7).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false);
    table.column(8).search(''); // Clear storage filter
    table.draw();
  });

  // Filter by Penyimpanan (column 8)
  $('#select-penyimpanan').on('change', function() {
    var val = this.value;
    table.column(8).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
  });

  // Filter by Kondisi (column 9)
  $('#select-kondisi').on('change', function() {
    var val = this.value;
    table.column(9).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
  });

  // Reset Filter
  $('#btnResetFilter').on('click', function() {
    $('#select-ruangan').val('');
    $('#select-penyimpanan').html('<option value="">- Storage -</option>');
    $('#select-kondisi').val('');
    table.search('').columns().search('').draw();
  });

  // Update Select All state when DataTable is redrawn (pagination, search, etc.)
  table.on('draw.dt', function() {
    // Re-attach event listener after draw since tbody content changes
    updateSelectAllState();
    updateSelectedCount();
  });

  // Mutasi Selected Items button click - BATCH (FAST)
  $('#btnMutasiSelected').on('click', function() {
    var selectedIds = [];
    $('.item-checkbox:checked').each(function() {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
      Swal.fire('Warning!', 'Please select at least one item.', 'warning');
      return;
    }

    Swal.fire({
      title: 'Add to Mutation?',
      html: 'Add <b>' + selectedIds.length + ' item' + (selectedIds.length > 1 ? 's' : '') + '</b> to this mutation?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Yes, add them!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Show loading
        Swal.fire({
          title: 'Processing...',
          html: 'Adding items to mutation...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        // Send all items in ONE request (BATCH)
        $.ajax({
          url: '<?= base_url("Functions/addItemsToMutasiBatch") ?>',
          method: 'POST',
          data: {
            id_mutasi: '<?= $id_mutasi ?>',
            items: selectedIds
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Completed!',
                html: response.message,
                icon: 'success'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to add items.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to add items to mutation.', 'error');
          }
        });
      }
    });
  });
});
</script>
