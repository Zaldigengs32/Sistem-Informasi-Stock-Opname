<?php
$this->load->view('UI/PICLab/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Stock Opname Detail</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?= base_url('Functions/StockOpnamePICLab') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Stock Opname
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">Detail</li>
    </ul>
  </div>
  <!-- END HEADER -->

  <!-- Stock Opname Detail Card -->
  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Stock Opname Detail</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <?php if ($session->so_status == 'Draft'): ?>
          <a href="<?= base_url('Functions/AddItemStockOpnamePagePICLab/' . $session->so_id_opname) ?>" class="btn btn-primary btn-md text-white me-2">
            <i class="fa fa-plus mr-1"></i> Add Item
          </a>
          <?php endif; ?>
          <a href="<?= base_url('Functions/StockOpnamePICLab') ?>" class="btn btn-secondary btn-md text-white">
            Back
          </a>
        </div>
      </div>
      <div class="row mt-3 gx-2">
        <div class="col">
          <label class="form-label small text-muted mb-1">No. Stock Opname</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_id_opname ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Start Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= (new DateTime($session->so_start_date))->format('d/m/Y') ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">End Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_end_date ? (new DateTime($session->so_end_date))->format('d/m/Y') : '-' ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">PIC</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->nama_pengguna ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Status</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_status ?>" readonly>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-12">
          <label class="form-label small text-muted mb-1">Description</label>
          <input type="text" class="form-control form-control-sm" value="<?= !empty($session->so_deskripsi) ? $session->so_deskripsi : '-' ?>" readonly>
        </div>
      </div>
      
      <?php if ($session->so_status == 'Rejected' && !empty($session->so_reject_reason)): ?>
      <div class="row mt-3">
        <div class="col-12">
          <div class="alert alert-danger mb-0">
            <div class="d-flex align-items-start">
              <i class="fa fa-times-circle me-2 mt-1" style="color: #EF4444;"></i>
              <div>
                <strong>Rejection Reason:</strong><br>
                <?= $session->so_reject_reason ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableDetail" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Item Name</th>
              <th style="text-align: center;">Lab</th>
              <th style="text-align: center;">Storage</th>
              <th style="text-align: center;">Qty</th>
              <th style="text-align: center;">Condition</th>
              <th style="text-align: center;">Description</th>
              <th style="text-align: center;">Photo</th>
              <?php if ($session->so_status == 'Draft'): ?>
              <th style="text-align: center;">Action</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($items as $item): ?>
              <tr>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td>
                  <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                      <?php if (!empty($item->gambar_barang) && strpos($item->gambar_barang, '.') !== false): ?>
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $item->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)" onerror="this.style.display='none'">
                      <?php else: ?>
                        <iconify-icon icon="mdi:image-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                      <?php endif; ?>
                    </div>
                    <div>
                      <div class="fw-medium text-dark"><?= $item->nama_barang ?></div>
                      <span class="text-muted small"><?= $item->nomor_aktiva ?></span>
                    </div>
                  </div>
                </td>
                <td style="text-align: center;"><?= $item->nama_ruangan ?></td>
                <td style="text-align: center;"><?= $item->nama_penyimpanan ?></td>
                <td style="text-align: center;"><?= $item->so_quantity ?></td>
                <td style="text-align: center;">
                  <?php switch ($item->kondisi_barang) {
                    case 'Good':
                      echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">Good</span>';
                      break;
                    case 'Not Good':
                      echo '<span class="px-20 py-4 rounded-pill fw-medium text-sm" style="background-color: #FEF9C3; color: #CA8A04; white-space: nowrap;">Not Good</span>';
                      break;
                    case 'Minor Damaged':
                      echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">Minor Damaged</span>';
                      break;
                    case 'Major Damaged':
                      echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">Major Damaged</span>';
                      break;
                    default:
                      echo '<span class="bg-secondary-focus text-secondary-main px-20 py-4 rounded-pill fw-medium text-sm">'.($item->kondisi_barang ?: '-').'</span>';
                  } ?>
                </td>
                <td style="text-align: center;"><?= !empty($item->keterangan_tambahan) ? $item->keterangan_tambahan : '-' ?></td>
                <td style="text-align: center;">
                  <?php if (!empty($item->foto_barang)): ?>
                    <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; cursor: pointer;" onclick="showImageModal('<?= base_url('assets/foto/stockopname/' . $item->foto_barang) ?>')">
                      <img src="<?= base_url('assets/foto/stockopname/' . $item->foto_barang) ?>" alt="Photo" style="max-width: 100%; max-height: 100%; border-radius: 4px;" onerror="this.parentElement.innerHTML='<iconify-icon icon=\'mdi:camera-off\' style=\'font-size: 24px; color: #ccc;\'></iconify-icon>'">
                    </div>
                  <?php else: ?>
                    <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                      <iconify-icon icon="mdi:camera-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                    </div>
                  <?php endif; ?>
                </td>
                <?php if ($session->so_status == 'Draft'): ?>
                <td style="text-align: center;">
                  <div style="gap: 10px; white-space: nowrap;">
                    <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn" 
                      data-id="<?= $item->id_detail ?>"
                      data-nama="<?= $item->nama_barang ?>"
                      data-id-ruangan="<?= $item->id_ruangan ?>"
                      data-id-penyimpanan="<?= $item->id_penyimpanan ?>"
                      data-quantity="<?= $item->so_quantity ?>"
                      data-kondisi="<?= $item->kondisi_barang ?>"
                      data-keterangan="<?= $item->keterangan_tambahan ?>"
                      data-foto="<?= $item->foto_barang ?>"
                      title="Edit">
                      <iconify-icon icon="lucide:edit"></iconify-icon>
                    </button>
                    <button class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center deletebtn" data-id="<?= $item->id_detail ?>" title="Delete">
                      <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                    </button>
                  </div>
                </td>
                <?php endif; ?>
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

  <!-- Edit Item Modal -->
  <?php if ($session->so_status == 'Draft'): ?>
  <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form action="<?= base_url('Functions/updateStockOpnameItemPICLab') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_detail" id="edit_id_detail" />
        <input type="hidden" name="so_id_opname" value="<?= $session->so_id_opname ?>" />
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Edit Item</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-12">
                <label class="form-label">Item Name <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_nama_barang" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Lab <span style="color:red;">*</span></label>
                <select class="form-select" name="id_ruangan" id="edit_id_ruangan" required>
                  <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room->id_ruangan ?>"><?= $room->nama_ruangan ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Storage <span style="color:red;">*</span></label>
                <select class="form-select" name="id_penyimpanan" id="edit_id_penyimpanan" required>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity <span style="color:red;">*</span></label>
                <input type="number" class="form-control" name="so_quantity" id="edit_so_quantity" min="0" required />
              </div>
              <div class="col-md-6">
                <label class="form-label">Condition <span style="color:red;">*</span></label>
                <select class="form-select" name="kondisi_barang" id="edit_kondisi_barang" required>
                  <option value="Good">Good</option>
                  <option value="Not Good">Not Good</option>
                  <option value="Minor Damaged">Minor Damaged</option>
                  <option value="Major Damaged">Major Damaged</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Description (optional)</label>
                <textarea class="form-control" name="keterangan_tambahan" id="edit_keterangan_tambahan" rows="3" placeholder="Enter description"></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Upload Photo (optional)</label>
                <input type="file" class="form-control" name="foto_barang" id="edit_foto_barang" accept=".jpg,.jpeg,.png" onchange="validateFileUpload(this)" />
                <small class="text-muted">Allowed: JPG, JPEG, PNG. Max size: 2MB.</small>
                <div id="file_error" class="text-danger small mt-1" style="display: none;"></div>
                <div id="current_photo_preview" class="mt-2"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11" id="btnSaveEdit">Save</button>
            <button style="width:150px" type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php
$this->load->view('Footer');
if (isset($error)) { ?>
  <script>
    swal.fire("Error!", "<?=$error?>", "error");
  </script>
<?php } else if (isset($update_success)) { ?>
  <script>
    swal.fire("Succeed!", "Item updated successfully!", "success");
  </script>
<?php } else if (isset($delete_success)) { ?>
  <script>
    swal.fire("Succeed!", "Item deleted successfully!", "success");
  </script>
<?php } ?>

<script type="text/javascript">
var allStorages = <?= json_encode($penyimpanan_list) ?>;

function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  var modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}

function updateStorageOptions(idRuangan, selectedPenyimpanan) {
  var $penyimpananSelect = $('#edit_id_penyimpanan');
  var options = '';
  allStorages.forEach(function(s) {
    if (s.id_ruangan == idRuangan) {
      var selected = (s.id_penyimpanan == selectedPenyimpanan) ? 'selected' : '';
      options += '<option value="' + s.id_penyimpanan + '" ' + selected + '>' + s.nama_penyimpanan + '</option>';
    }
  });
  $penyimpananSelect.html(options);
}

function validateFileUpload(input) {
  var fileError = document.getElementById('file_error');
  var btnSave = document.getElementById('btnSaveEdit');
  
  fileError.style.display = 'none';
  fileError.textContent = '';
  btnSave.disabled = false;
  
  if (input.files && input.files[0]) {
    var file = input.files[0];
    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    var maxSize = 2 * 1024 * 1024;
    
    if (!allowedTypes.includes(file.type)) {
      fileError.textContent = 'Invalid file type. Only JPG, JPEG, and PNG are allowed.';
      fileError.style.display = 'block';
      input.value = '';
      btnSave.disabled = true;
      return false;
    }
    
    if (file.size > maxSize) {
      fileError.textContent = 'File size exceeds 2MB limit.';
      fileError.style.display = 'block';
      input.value = '';
      btnSave.disabled = true;
      return false;
    }
  }
  return true;
}

$(document).ready(function() {
  var tableData = $('#dataTableDetail').DataTable({
    "ordering": true,
    "deferRender": true,
    "pageLength": 25,
    "autoWidth": false,
    columnDefs: [
      { targets: 0, type: 'num', className: 'text-end' },
      { targets: 4, className: 'text-center' },
      { targets: 5, className: 'text-center' }
    ]
  });

  $('#edit_id_ruangan').on('change', function() {
    updateStorageOptions($(this).val(), null);
  });

  $('#dataTableDetail').on('click', '.editbtn', function() {
    var btn = $(this);
    var idRuangan = btn.data('id-ruangan');
    var idPenyimpanan = btn.data('id-penyimpanan');
    
    $('#edit_id_detail').val(btn.data('id'));
    $('#edit_nama_barang').val(btn.data('nama'));
    $('#edit_id_ruangan').val(idRuangan);
    updateStorageOptions(idRuangan, idPenyimpanan);
    $('#edit_so_quantity').val(btn.data('quantity'));
    $('#edit_kondisi_barang').val(btn.data('kondisi'));
    $('#edit_keterangan_tambahan').val(btn.data('keterangan') || '');
    
    var foto = btn.data('foto');
    if (foto) {
      $('#current_photo_preview').html('<img src="<?= base_url("assets/foto/stockopname/") ?>' + foto + '" style="max-width: 100px; max-height: 100px; border-radius: 4px;">');
    } else {
      $('#current_photo_preview').html('<span class="text-muted">No photo</span>');
    }
    
    $('#edit_foto_barang').val('');
    $('#editItemModal').modal('show');
  });

  $('#dataTableDetail').on('click', '.deletebtn', function() {
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
          url: '<?= base_url("Functions/deleteStockOpnameItemPICLab") ?>',
          method: 'POST',
          data: { id_detail: id, so_id_opname: '<?= $session->so_id_opname ?>' },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Deleted!',
                text: 'Item has been deleted.',
                icon: 'success'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to delete item.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to delete item.', 'error');
          }
        });
      }
    });
  });
});
</script>
