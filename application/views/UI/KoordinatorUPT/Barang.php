<?php
$this->load->view('UI/KoordinatorUPT/Header');
?>

<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <!-- <div class="content-wrapper"> -->
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Inventory</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Inventory</li>
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
            
          </div>
        </div>

        <div class="row mt-10 gx-2">
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-ruangan">
              <option value="">- Inventory Location -</option>
              <?php foreach ($ruangans as $ruangan): ?>
                <option value="<?= $ruangan->nama_ruangan ?>"><?= $ruangan->nama_ruangan ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-penyimpanan">
              <option value="">- Inventory Storage -</option>
              <?php foreach ($penyimpanans as $penyimpanan): ?>
                <option value="<?= $penyimpanan->nama_penyimpanan ?>"><?= $penyimpanan->nama_penyimpanan ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-kategori">
              <option value="">- Inventory Category -</option>
              <option value="Asset">Assets</option>
              <option value="Non Asset">Non Assets</option>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-tipe">
              <option value="">- Inventory Type -</option>
              <option value="Consummable">Consummable</option>
              <option value="Non Consummable">Non Consummable</option>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-kondisi">
              <option value="">- Inventory Condition -</option>
              <option value="Good">Good</option>
              <option value="Not Good">Not Good</option>
              <option value="Minor Damaged">Minor Damaged</option>
              <option value="Major Damaged">Major Damaged</option>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-select form-select-sm" id="select-status">
              <option value="">- Inventory Status -</option>
              <option value="Available">Available</option>
              <option value="Booked">Booked</option>
              <option value="Borrowed">Borrowed</option>
              
            </select>
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
          <table id="dataTableBarang" class=" table" style="width:100%">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Inventory Name</th>
                <th style="text-align: center;">Asset/Non Asset Number</th>
                <th style="text-align: center;">Total Item</th> 
                <th style="text-align: center;">Inventory Condition</th>
                <th style="text-align: center;">Inventory Location</th>
                <th style="text-align: center;">Status</th>
                <th style="display:none;">ID</th>
                <th style="display:none;">Nama</th>
                <th style="display:none;">Tipe</th>
                <th style="display:none;">Kategori</th>
                <th style="display:none;">Kondisi</th>
                <th style="display:none;">Data Gambar</th> 
                <th style="display:none;">Penyimpanan</th>
                <th style="display:none;">Ruangan</th>
                
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $status;
              foreach ($barang as $brg):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td>
                    <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                      <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
                      </div>
                      <div>
                        <div class="fw-medium text-dark"><?= $brg->nama_barang ?></div>
                        <div class="d-flex align-items-center" style="gap: 6px; white-space: nowrap;">
                          <?php switch ($brg->kategori_barang) {
                            case 'Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white">'.$brg->kategori_barang.'</span>';
                              break;
                            case 'Non Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white">'.$brg->kategori_barang.'</span>';
                              break;
                          } ?>
                          <?php switch ($brg->tipe_barang) {
                            case 'Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white">'.$brg->tipe_barang.'</span>';
                              break;
                            case 'Non Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white">'.$brg->tipe_barang.'</span>';
                              break;
                          } ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td style="text-align: center;"><?= $brg->nomor_aktiva ?></td>
                  <!-- <td class="center"></td> -->
                  <td><?= $brg->jumlah_barang . ' ' . $brg->satuan_barang ?></td>
                  <td class="center">
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
                  <td><?php echo $brg->nama_ruangan.' '.$brg->nama_penyimpanan.' '.$brg->keterangan_penyimpanan; ?></td>
                  <td class="center">
                    <?php 
                    switch ($brg->ketersediaan_barang) {
                      case 'Available':
                        echo '<span class="bg-info-focus text-info-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                      case 'Booked':
                        echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                      case 'Borrowed':
                        echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                    } ?>
                  </td>
                  <td ><?= $brg->id_barang ?></td>
                  <td ><?= $brg->nama_barang ?></td>
                  <td ><?= $brg->tipe_barang ?></td>
                  <td ><?= $brg->kategori_barang ?></td>
                  <td ><?= $brg->kondisi_barang ?></td>
                  <td ><?= $brg->gambar_barang ?></td>
                  <td  ><?= $brg->id_penyimpanan ?></td>
                  <td  ><?= $brg->id_ruangan ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal Zoom Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-0">
            <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
          </div>
        </div>
      </div>
    </div>

  </div> <!-- End dashboard-main-body -->


<?php
$this->load->view('Footer');
 ?>
<script type="text/javascript">
  function showImageModal(imageSrc) {
    document.getElementById('zoomedImage').src = imageSrc;
    // Tampilkan modal
    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
  }

  $(document).ready(function() {
    var tableData = $('#dataTableBarang').DataTable({
        "ordering": true,
        "deferRender": true,
        "pageLength": 25,
        columnDefs: [
          { targets: 0, type: 'num' },
          { targets: 2, type: 'string' },
          {
            targets: [7, 8, 9, 10, 11,12,13,14], 
            visible: false,
            searchable: true
          }
        ],
        "initComplete": function() {
          $('#loadingIndicator').hide();
          $('#tableContainer').show();
        }
      });

    // Client-side filtering (FAST)
    $('#select-ruangan').on('change', function() {
      tableData.column(14).search(this.value).draw();
    });
    $('#select-penyimpanan').on('change', function() {
      tableData.column(13).search(this.value).draw();
    });
    $('#select-kategori').on('change', function() {
      tableData.column(10).search(this.value).draw();
    });
    $('#select-tipe').on('change', function() {
      tableData.column(9).search(this.value).draw();
    });
    $('#select-kondisi').on('change', function() {
      tableData.column(11).search(this.value).draw();
    });
    $('#select-status').on('change', function() {
      tableData.column(6).search(this.value).draw();
    });
  });
</script>