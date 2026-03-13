<?php $this->load->view('UI/PICLab/Header.php'); ?>

<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Item to Stock Opname</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?= base_url('Functions/DashboardPICLab') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i> Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">
        <a href="<?= base_url('Functions/StockOpnamePICLab') ?>" class="hover-text-primary">Stock Opname</a>
      </li>
      <li>-</li>
      <li class="fw-medium">Add Item</li>
    </ul>
  </div>

  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Select Item for Stock Opname</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <a href="<?= base_url('Functions/StockOpnameDetailPICLab/' . $so_id) ?>" class="btn btn-primary btn-md text-white me-2">
            <i class="fa fa-list mr-1"></i> Stock Opname Detail
          </a>
          <a href="<?= base_url('Functions/StockOpnamePICLab') ?>" class="btn btn-secondary btn-md text-white">
            <i class="fa fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>

      <div class="row mt-10 gx-2">
        <div class="col-md-2">
          <select class="form-select form-select-sm" id="select-ruangan">
            <option value="">- Location -</option>
            <?php foreach ($rooms as $room): ?>
              <option value="<?= $room->nama_ruangan ?>" data-id="<?= $room->id_ruangan ?>"><?= $room->nama_ruangan ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select form-select-sm" id="select-storage">
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
      <div id="loadingIndicator" class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading data...</p>
      </div>
      
      <div class="table-responsive" id="tableContainer" style="display: none;">
        <table id="dataTableAsset" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center; width: 50px; vertical-align: middle;">
                <div>Select</div>
                <div class="mt-1"><input type="checkbox" id="selectAllCheckbox" class="form-check-input" style="cursor: pointer; margin: 0;" title="Select All"></div>
              </th>
              <th style="text-align: center; width: 40px;">No</th>
              <th style="text-align: left;">Inventory Name</th>
              <th style="text-align: center; width: 100px;">Asset Number</th>
              <th style="text-align: center; width: 140px;">Inventory Location</th>
              <th style="text-align: center; width: 60px;">Qty</th>
              <th style="text-align: center; width: 120px;">Inventory Condition</th>
              <th>Ruangan</th>
              <th>Storage</th>
              <th>Kondisi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($assets as $asset): ?>
              <tr>
                <td style="text-align: center; vertical-align: middle;">
                  <input type="checkbox" name="item_barang[]" class="form-check-input item-checkbox" 
                         value="<?= $asset->id_barang ?>" 
                         data-ruangan="<?= $asset->id_ruangan ?>"
                         data-penyimpanan="<?= $asset->id_penyimpanan ?>"
                         style="cursor: pointer;">
                </td>
                <td style="text-align: right; vertical-align: middle;"><?= $no++; ?></td>
                <td style="vertical-align: middle;">
                  <div class="d-flex align-items-center" style="gap: 10px;">
                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                      <?php if (!empty($asset->gambar_barang) && strpos($asset->gambar_barang, '.') !== false): ?>
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $asset->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)" onerror="this.style.display='none'">
                      <?php else: ?>
                        <iconify-icon icon="mdi:image-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                      <?php endif; ?>
                    </div>
                    <div>
                      <div class="fw-medium text-dark"><?= $asset->nama_barang ?></div>
                      <span class="badge fw-semibold rounded-pill bg-<?= $asset->kategori_barang == 'Asset' ? 'success' : 'info' ?>-600 text-white" style="font-size: 10px;"><?= $asset->kategori_barang ?></span>
                      <span class="badge fw-semibold rounded-pill bg-<?= $asset->tipe_barang == 'Consummable' ? 'lilac' : 'pink' ?>-600 text-white" style="font-size: 10px;"><?= $asset->tipe_barang ?></span>
                    </div>
                  </div>
                </td>
                <td style="text-align: center; vertical-align: middle;"><?= $asset->nomor_aktiva ?></td>
                <td style="vertical-align: middle;">
                  <select name="id_ruangan[<?= $asset->id_barang ?>]" class="form-select form-select-sm ruangan-select mb-1" data-barang="<?= $asset->id_barang ?>">
                    <?php foreach ($rooms as $r): ?>
                      <option value="<?= $r->id_ruangan ?>" <?= $r->id_ruangan == $asset->id_ruangan ? 'selected' : '' ?>><?= $r->nama_ruangan ?></option>
                    <?php endforeach; ?>
                  </select>
                  <select name="id_penyimpanan[<?= $asset->id_barang ?>]" id="penyimpanan_<?= $asset->id_barang ?>" class="form-select form-select-sm">
                    <?php foreach ($storages as $s): ?>
                      <?php if ($s->id_ruangan == $asset->id_ruangan): ?>
                        <option value="<?= $s->id_penyimpanan ?>" <?= $s->id_penyimpanan == $asset->id_penyimpanan ? 'selected' : '' ?>><?= $s->nama_penyimpanan ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td style="vertical-align: middle;">
                  <input type="number" name="so_quantity[<?= $asset->id_barang ?>]" class="form-control form-control-sm text-center" value="<?= $asset->jumlah_barang ?>" min="0" style="width: 70px;">
                </td>
                <td style="vertical-align: middle;">
                  <select name="kondisi_barang[<?= $asset->id_barang ?>]" class="form-select form-select-sm">
                    <option value="Good" <?= $asset->kondisi_barang == 'Good' ? 'selected' : '' ?>>Good</option>
                    <option value="Not Good" <?= $asset->kondisi_barang == 'Not Good' ? 'selected' : '' ?>>Not Good</option>
                    <option value="Minor Damaged" <?= $asset->kondisi_barang == 'Minor Damaged' ? 'selected' : '' ?>>Minor Damaged</option>
                    <option value="Major Damaged" <?= $asset->kondisi_barang == 'Major Damaged' ? 'selected' : '' ?>>Major Damaged</option>
                  </select>
                </td>
                <td><?= $asset->nama_ruangan ?></td>
                <td><?= $asset->nama_penyimpanan ?></td>
                <td><?= $asset->kondisi_barang ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <div id="buttonSection" class="mt-4 pt-3 d-flex justify-content-between align-items-center border-top" style="display: none !important;">
        <div>
          <span id="selectedCount" class="text-muted">0 item selected</span>
        </div>
        <button type="button" id="btnAddSelected" class="btn btn-primary" disabled>
          Add Selected Items to Stock Opname
        </button>
      </div>
    </div>
  </div>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
var allStorages = <?= json_encode($storages) ?>;

function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  var modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}

function updateFilterStorageOptions(idRuangan) {
  var $storageSelect = $('#select-storage');
  var options = '<option value="">- Storage -</option>';
  if (idRuangan) {
    allStorages.forEach(function(s) {
      if (s.id_ruangan == idRuangan) {
        options += '<option value="' + s.nama_penyimpanan + '">' + s.nama_penyimpanan + '</option>';
      }
    });
  }
  $storageSelect.html(options);
}

$(document).ready(function() {
  var table = $('#dataTableAsset').DataTable({
    "ordering": true,
    "autoWidth": false,
    "deferRender": true,
    "processing": false,
    "pageLength": 10,
    "order": [[1, 'asc']],
    columnDefs: [
      { targets: 0, orderable: false, width: '50px' },
      { targets: 1, type: 'num', width: '40px' },
      { targets: 2, width: '200px' },
      { targets: 3, type: 'string', width: '100px' },
      { targets: 4, width: '140px' },
      { targets: 5, width: '60px' },
      { targets: 6, width: '120px' },
      { targets: [7, 8, 9], visible: false, searchable: true }
    ],
    "initComplete": function() {
      $('#loadingIndicator').hide();
      $('#tableContainer').show();
      $('#buttonSection').show().css('display', 'flex');
    }
  });

  var $selectAllCheckbox = document.getElementById('selectAllCheckbox');
  var $selectedCount = document.getElementById('selectedCount');
  var $btnAddSelected = document.getElementById('btnAddSelected');

  function updateSelectedCount() {
    var count = document.querySelectorAll('.item-checkbox:checked').length;
    $selectedCount.textContent = count + ' item' + (count !== 1 ? 's' : '') + ' selected';
    $btnAddSelected.disabled = count === 0;
  }

  function updateSelectAllState() {
    var visibleCheckboxes = document.querySelectorAll('#dataTableAsset tbody .item-checkbox');
    var total = visibleCheckboxes.length;
    var checked = document.querySelectorAll('#dataTableAsset tbody .item-checkbox:checked').length;
    $selectAllCheckbox.checked = total > 0 && checked === total;
    $selectAllCheckbox.indeterminate = checked > 0 && checked < total;
  }

  $selectAllCheckbox.addEventListener('change', function() {
    var isChecked = this.checked;
    var checkboxes = document.querySelectorAll('#dataTableAsset tbody .item-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = isChecked;
    }
    updateSelectedCount();
  });

  document.querySelector('#dataTableAsset tbody').addEventListener('change', function(e) {
    if (e.target.classList.contains('item-checkbox')) {
      updateSelectedCount();
      updateSelectAllState();
    }
  });

  $('#select-ruangan').on('change', function() {
    var val = this.value;
    var selectedOption = $(this).find('option:selected');
    var idRuangan = selectedOption.data('id');
    
    updateFilterStorageOptions(idRuangan);
    $('#select-storage').val('');
    
    table.column(7).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false);
    table.column(8).search('');
    table.draw();
  });

  $('#select-storage').on('change', function() {
    var val = this.value;
    table.column(8).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
  });

  $('#select-kondisi').on('change', function() {
    var val = this.value;
    table.column(9).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
  });

  $('#btnResetFilter').on('click', function() {
    $('#select-ruangan').val('');
    $('#select-storage').html('<option value="">- Storage -</option>');
    $('#select-kondisi').val('');
    table.search('').columns().search('').draw();
  });

  table.on('draw.dt', function() {
    updateSelectAllState();
    updateSelectedCount();
  });

  $(document).on('change', '.ruangan-select', function() {
    var idRuangan = $(this).val();
    var idBarang = $(this).data('barang');
    var $penyimpananSelect = $('#penyimpanan_' + idBarang);
    
    var options = '';
    allStorages.forEach(function(s) {
      if (s.id_ruangan == idRuangan) {
        options += '<option value="' + s.id_penyimpanan + '">' + s.nama_penyimpanan + '</option>';
      }
    });
    $penyimpananSelect.html(options);
  });

  $('#btnAddSelected').on('click', function() {
    var selectedItems = [];
    var formData = new FormData();
    formData.append('so_id_opname', '<?= $so_id ?>');
    
    var index = 0;
    $('.item-checkbox:checked').each(function() {
      var idBarang = $(this).val();
      var $row = $(this).closest('tr');
      
      formData.append('items[' + index + '][id_barang]', idBarang);
      formData.append('items[' + index + '][id_ruangan]', $row.find('[name="id_ruangan['+idBarang+']"]').val());
      formData.append('items[' + index + '][id_penyimpanan]', $row.find('[name="id_penyimpanan['+idBarang+']"]').val());
      formData.append('items[' + index + '][so_quantity]', $row.find('[name="so_quantity['+idBarang+']"]').val());
      formData.append('items[' + index + '][kondisi_barang]', $row.find('[name="kondisi_barang['+idBarang+']"]').val());
      
      selectedItems.push(idBarang);
      index++;
    });

    if (selectedItems.length === 0) {
      Swal.fire('Warning!', 'Please select at least one item.', 'warning');
      return;
    }

    Swal.fire({
      title: 'Add to Stock Opname?',
      html: 'Add <b>' + selectedItems.length + ' item' + (selectedItems.length > 1 ? 's' : '') + '</b> to this stock opname?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Yes, add them!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Processing...',
          html: 'Adding items to stock opname...',
          allowOutsideClick: false,
          didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
          url: '<?= base_url("Functions/addItemsToStockOpnameBatch") ?>',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Completed!',
                html: response.message,
                icon: 'success'
              }).then(() => { location.reload(); });
            } else {
              Swal.fire('Error!', response.message || 'Failed to add items.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to add items to stock opname.', 'error');
          }
        });
      }
    });
  });
});
</script>
