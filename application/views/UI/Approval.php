<?php
$this->load->view('Header');
?>

<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <!-- <div class="content-wrapper"> -->
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Approval</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Approval</li>
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
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTableApproval" class=" table" style="width:100%">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Applicant NIM</th>
                <th style="text-align: center;">Applicant Name</th>
                <th style="text-align: center;">Loan Requirements</th>
                <th style="text-align: center;">Start of Loan</th>
                <th style="text-align: center;">End of Loan</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th> 
                <th >ID</th>
                
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $status;
              foreach ($approval as $app):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $app->nim_peminjam ?></td>
                  <td><?= $app->nama_peminjam ?></td>
                  <td><?= $app->keperluan_peminjaman ?></td>
                  <td><?php $date = new DateTime($app->mulai_peminjaman);
                  echo $date->format('d M Y');  ?></td>
                  <td><?php $date = new DateTime($app->selesai_peminjaman);
                  echo $date->format('d M Y');  ?></td>
                  <td>
                    <?php switch ($app->status_peminjaman) {
                      case 'On Progress Approval PIC Asset':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'On Progress Approval Koor UPT':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Approved':
                        echo '<span class="badge fw-semibold bg-info-600 text-primary-600 me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Rejected':
                        echo '<span class="badge fw-semibold bg-danger-600 text-danger-600 me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Borrowed':
                        echo '<span class="badge fw-semibold bg-secondary-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Waiting for Return':
                        echo '<span class="badge fw-semibold bg-primary-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Completed':
                        echo '<span class="badge fw-semibold bg-success-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                    } ?>
                  </td>
                  <td style="text-align: center;">
                    <div style="gap: 10px; white-space: nowrap;">
                      <center>
                      <button class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center databtn" data-id="<?=$app->id_peminjaman_barang ?>">
                            <iconify-icon icon="lucide:list"></iconify-icon>
                          </button></center>
                    </div></td>
                  <td  ><?= $app->id_peminjaman_barang ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal Zoom Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" >
      <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
          <div class="modal-body text-center p-0">
            <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
          </div>
        </div>
      </div>
    </div>
    <!-- Detail Modal -->
    <!-- Detail Data Modal -->
    <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="detailData"
      aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Detail Approval</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3" style="padding:5px;">
              <table id="dataTableDetailPeminjaman" class=" table" style="width:100%;">
                <thead>
                  <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Inventory</th>
                    <th style="text-align: center;">Asset/Non Asset Number </th>
                    <th style="text-align: center;">Total Item</th>
                    <th style="text-align: center;">Inventory Condition</th>
                    <th style="text-align: center;">Action</th>
                    <th >ID</th>
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
    <!-- tambahData Modal -->
    <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?= base_url('functions/savebarang') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Add Inventory</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <label class="form-label">Inventory Name <span style="color:red;">*</span></label>
                  <input for="namaBarang" type="text" class="form-control" name="namaBarang" placeholder="Inventory Name" required />
                </div>
                <div class="col-12">
                  <label for="nomorAktiva" class="form-label">Asset/Non Asset Number <span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="nomorAktiva" placeholder="Asset Number" required />
                </div>

                <div class="col-12">
                  <label for="totalBarang" class="form-label">Total Items <span style="color:red;">*</span></label>
                  <input type="number" class="form-control" name="totalBarang" placeholder="Total Items" required min="0" />
                </div>

                <div class="col-12">
                  <label for="satuanBarang" id="satuanBarang" class="form-label">Inventory Unit <span style="color:red;">*</span></label>
                  <select name="satuanBarang" id="satuanBarang" class="form-control" required>
                      <option value="">--Inventory Unit--</option>
                      <option value="Pcs">Pcs</option>
                      <option value="Lembar">Lembar</option>
                      <option value="Pack">Pack</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="kondisiBarang" id="kondisiBarang" class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="kondisiBarang" id="kondisiBarang" class="form-control" required>
                      <option value="">--Inventory Condition--</option>
                      <option value="Good">Good</option>
                      <option value="Not Good">Not Good</option>
                      <option value="Minor Damaged">Minor Damaged</option>
                      <option value="Major Damaged">Major Damaged</option>
                      <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="kategoriBarang"  class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="kategoriBarang" id="kategoriBarang" class="form-control" required>
                      <option value="">--Inventory Category--</option>
                      <option value="Asset">Asset</option>
                      <option value="Non Asset">Non Asset</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="tipeBarang"  class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="tipeBarang" id="tipeBarang" class="form-control" required>
                      <option value="">--Inventory Type--</option>
                      <option value="Consummable">Consummable</option>
                      <option value="Non Consummable">Non Consummable</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="lokasiBarang"  class="form-label">Inventory Location <span style="color:red;">*</span></label>
                  <select name="lokasiBarang" id="lokasiBarang" class="form-control" required>
                    <option value="">--Inventory Location--</option>
                    <?php foreach ($ruangans as $ruangan): ?>
                      <option value="<?= $ruangan->id_ruangan ?>"><?= $ruangan->nama_ruangan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-12">
                  <label for="penyimpananBarang"  class="form-label">Inventory Storage <span style="color:red;">*</span></label>
                  <select name="penyimpananBarang" id="penyimpananBarang" class="form-control" required>
                    <option value="">--Inventory Storage--</option>
                    <?php foreach ($penyimpanans as $penyimpanan): ?>
                      <option value="<?= $penyimpanan->id_penyimpanan ?>"><?= $penyimpanan->nama_penyimpanan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-12">
                  <label for="barisLokasi"  class="form-label">Storage Details <span style="color:red;">*</span></label>
                  <input type="text" id="barisLokasi" class="form-control" name="barisLokasi" placeholder="Storage Details" required />
                </div>

                <div class="col-12">
                  <label for="foto">Inventory Photos <span class="form-group-text" style="color:red;">*</span></label>
                  <input type="file" accept=".jpg, .jpeg, .png" required id="foto" class="form-control" onchange="Ganti(this,'lbfoto');" name="foto" required />
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

  </div>


<?php
$this->load->view('Footer');
if (isset($error)) {
  ?>
  <script>
    swal.fire("Error!", "<?=$error?>", "error");
  </script>
  <?php
}else if (isset($accept)) {
  ?>
  <script>
    swal.fire("Succeed!", "Data saved successfully!", "success");
  </script>
  <?php
} else if (isset($reject)) {
  ?>
    <script>
      swal.fire("Succeed!", "Data saved successfully!", "success");
    </script>
<?php } ?>
<script type="text/javascript">
  function showImageModal(imageSrc) {
    // Set src gambar
    document.getElementById('zoomedImage').src = imageSrc;

    // Tampilkan modal gambar
    const imageModalEl = document.getElementById('imageModal');
    const modal = new bootstrap.Modal(imageModalEl);
    modal.show();

    // Delay agar modal tampil dulu, baru kita ubah z-index-nya
    setTimeout(() => {
        // Ubah z-index modal gambar agar tampil di atas
        imageModalEl.style.zIndex = 1060;

        // Ambil semua backdrop, ubah yang terakhir z-index-nya agar tetap di bawah
        const backdrops = document.querySelectorAll('.modal-backdrop');
        if (backdrops.length > 0) {
            backdrops[backdrops.length - 1].style.zIndex = 1040;
        }
    }, 150); // tunggu 150ms agar modal sudah ter-render
  }

  $(document).ready(function() {
    <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
      var tableData = $('#dataTableApproval').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num' },
          { targets: 1, type: 'string' },
          {
            targets: [8], 
            visible: false,
            searchable: false
          }
        ]
      });
    <?php }else{ ?>
      var tableData = $('#dataTableApproval').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num' },
          { targets: 1, type: 'string' },
          {
            targets: [8], 
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
      var id_peminjaman = $(this).data('id');;
      $.ajax({
        url: '<?= base_url("Functions/getDtlPeminjamanByIdPeminjaman") ?>',
        method: 'POST',
        data: { id_peminjaman: id_peminjaman },
        dataType: 'html',
        success: function(response) {
          let table = $('#dataTableDetailPeminjaman').DataTable(); // simpan di variabel global
          table.destroy();

          // 2. Ganti isi tbody
          $('#dataTableDetailPeminjaman tbody').html(response);

          // 3. Inisialisasi ulang
          table = $('#dataTableDetailPeminjaman').DataTable({
            // optional: tambahkan konfigurasi jika ada
            responsive: true,
            "ordering": true,
            columnDefs: [
              
              { targets: 0, type: 'num' },
              {
                targets: [6], 
                visible: false,
                searchable: false
              }
            ]
          });
          $('.accbtn').on('click', function () {
            var id = $(this).data('id');
            Swal.fire({
              title: 'Are you sure you want to accept data?',
              text: "You can't return this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Accept'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: "<?php echo base_url('Functions/accpeminjaman') ?>",
                  method: "post",
                  data: {
                    id_dtl_peminjaman: id
                  }
                })
                Swal.fire({
                  title: 'Succeed!',
                  text: 'Data deleted successfully!',
                  type: 'success',
                  icon: 'success'
                }).then(okay => {
                  if (okay) {
                    window.location.href = "<?php echo base_url('Functions/Approval') ?>"
                  }
                })
              }
            })
          });
        }
      });
    });
    
  });
  //Sweet Alert to delete data
  
</script>

<!-- Ruangan Change -->
<script>
  $('#select-ruangan').on('change', function() {
    // Parameter
    const namaRuangan = $(this).val(); // text (label)
    const namaPenyimpanan = $('#select-penyimpanan').val();
    const kategoriBarang = $('#select-kategori').val();
    const tipeBarang = $('#select-tipe').val();
    const kondisiBarang = $('#select-kondisi').val();
    const statusBarang = $('#select-status').val();

    // Kosongkan dulu penyimpanan
    $('#select-penyimpanan').html('<option value="">Loading...</option>');

    $.ajax({
      url: '<?= base_url("Functions/getPenyimpanan") ?>',
      method: 'POST',
      data: { 
        nama_ruangan: namaRuangan },
      dataType: 'json',
      success: function(response) {
        let options = '<option value="">- Inventory Storage -</option>';
        response.forEach(function(penyimpanan) {
          options += `<option value="${penyimpanan.nama_penyimpanan}">${penyimpanan.nama_penyimpanan}</option>`;
        });
        $('#select-penyimpanan').html(options);
      },
      error: function() {
        $('#select-penyimpanan').html('<option value="">- Failed to load -</option>');
      }
    });


    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<!-- Penyimpangan Change -->
<script>
  $('#select-penyimpanan').on('change', function() {
    const namaRuangan = $('#select-ruangan').val(); // text (label)
    const namaPenyimpanan = $(this).val();
    const kategoriBarang = $('#select-kategori').val();
    const tipeBarang = $('#select-tipe').val();
    const kondisiBarang = $('#select-kondisi').val();
    const statusBarang = $('#select-status').val();

    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<!-- Kategori Change -->
<script>
  $('#select-kategori').on('change', function() {
    const namaRuangan = $('#select-ruangan').val(); // text (label)
    const namaPenyimpanan = $('#select-penyimpanan').val();
    const kategoriBarang = $(this).val();
    const tipeBarang = $('#select-tipe').val();
    const kondisiBarang = $('#select-kondisi').val();
    const statusBarang = $('#select-status').val();

    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<!-- tipe Change -->
<script>
  $('#select-tipe').on('change', function() {
    const namaRuangan = $('#select-ruangan').val(); // text (label)
    const namaPenyimpanan = $('#select-penyimpanan').val();
    const kategoriBarang = $('#select-kategori').val();
    const tipeBarang = $(this).val();
    const kondisiBarang = $('#select-kondisi').val();
    const statusBarang = $('#select-status').val();

    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<!-- kondisi Change -->
<script>
  $('#select-kondisi').on('change', function() {
    const namaRuangan = $('#select-ruangan').val(); // text (label)
    const namaPenyimpanan = $('#select-penyimpanan').val();
    const kategoriBarang = $('#select-kategori').val();
    const tipeBarang = $('#select-tipe').val();
    const kondisiBarang = $(this).val();
    const statusBarang = $('#select-status').val();

    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<!-- kondisi Change -->
<script>
  $('#select-status').on('change', function() {
    const namaRuangan = $('#select-ruangan').val(); // text (label)
    const namaPenyimpanan = $('#select-penyimpanan').val();
    const kategoriBarang = $('#select-kategori').val();
    const tipeBarang = $('#select-tipe').val();
    const kondisiBarang = $('#select-kondisi').val();
    const statusBarang = $(this).val();

    $.ajax({
      url: '<?= base_url("Functions/getBarangByFilter") ?>',
      method: 'POST',
      data: { nama_ruangan: namaRuangan, 
        nama_penyimpanan: namaPenyimpanan,
        nama_kategori: kategoriBarang,
        nama_tipe: tipeBarang,
        kondisi_barang: kondisiBarang,
        status_barang: statusBarang },
      dataType: 'html',
      success: function(response) {
        let table = $('#dataTableBarang').DataTable(); // simpan di variabel global
        table.destroy();

        // 2. Ganti isi tbody
        $('#dataTableBarang tbody').html(response);

        // 3. Inisialisasi ulang
        table = $('#dataTableBarang').DataTable({
          // optional: tambahkan konfigurasi jika ada
          responsive: true,
          "ordering": true,
          columnDefs: [
            
            { targets: 0, type: 'num' },
            { targets: 2, type: 'string' },
            {
              targets: [8, 9, 10, 11,12,13,14,15], 
              visible: false,
              searchable: false
            }
          ]
        });
      }
    });
  });
</script>
<script>
  $('#lokasiBarang').on('change', function() {
    // Parameter
    const namaRuangan = $(this).find('option:selected').text(); // text (label)
    $('#penyimpananBarang').html('<option value="">Loading...</option>');
    $.ajax({
      url: '<?= base_url("Functions/getPenyimpanan") ?>',
      method: 'POST',
      data: { 
        nama_ruangan: namaRuangan },
      dataType: 'json',
      success: function(response) {
        let options = '<option value="">- Inventory Storage -</option>';
        response.forEach(function(penyimpanan) {
          options += `<option value="${penyimpanan.nama_penyimpanan}">${penyimpanan.nama_penyimpanan}</option>`;
        });
        $('#penyimpananBarang').html(options);
      },
      error: function() {
        $('#penyimpananBarang').html('<option value="">- Failed to load -</option>');
      }
    });
  });
  $('#lokasiBarangE').on('change', function() {
    // Parameter
    const namaRuangan = $(this).find('option:selected').text(); // text (label)

    // Kosongkan dulu penyimpanan
    $('#penyimpananBarangE').html('<option value="">Loading...</option>');

    $.ajax({
      url: '<?= base_url("Functions/getPenyimpanan") ?>',
      method: 'POST',
      data: { 
        nama_ruangan: namaRuangan },
      dataType: 'json',
      success: function(response) {
        let options = '<option value="">- Inventory Storage -</option>';
        response.forEach(function(penyimpanan) {
          options += `<option value="${penyimpanan.nama_penyimpanan}">${penyimpanan.nama_penyimpanan}</option>`;
        });
        $('#penyimpananBarangE').html(options);
      },
      error: function() {
        $('#penyimpananBarangE').html('<option value="">- Failed to load -</option>');
      }
    });
  });
</script>