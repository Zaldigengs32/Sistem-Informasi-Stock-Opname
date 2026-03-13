<?php
$this->load->view('UI/KoordinatorUPT/Header');
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

        <?= form_open('Functions/ApprovalPICNonAsset', ['method' => 'post']) ?>
          <div class="row mt-10 gx-2">
            <div class="col-md-2">
              <input type="date" class="form-control form-control-sm" name="start_date" value="<?= set_value('start_date', $start_date ?? '') ?>">
            </div>
            <div class="col-md-2">
              <input type="date" class="form-control form-control-sm" name="end_date" value="<?= set_value('end_date', $end_date ?? '') ?>">
            </div>
            <div class="col-md-1">
              <button class="btn btn-sm btn-primary w-100" type="submit">Filter</button>
            </div>
          </div>
        <?= form_close() ?>
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
                      case 'On Progress Approval PIC':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'On Progress Approval PIC Non Asset':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'On Progress Approval Koordinator UPT':
                        echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Approved':
                        echo '<span class="badge fw-semibold bg-info-600 text-primary-600 me-2">'.$app->status_peminjaman.'</span>';
                        break;
                      case 'Rejected':
                        echo '<span class="badge fw-semibold bg-danger-600 text-white-600 me-2">'.$app->status_peminjaman.'</span>';
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
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document" style="max-width: 80%;">
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
                    <th style="text-align: center;">Initial Condition</th>
                    <th style="text-align: center;">Final Condition</th>
                    <th style="text-align: center;">Status</th>
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
            <button style="width:150px" type="button"  data-dismiss="modal" onclick="closeModalAndRefresh()" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal log data -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal"
      aria-hidden="true" >
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document" style="max-width: 80%;">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Log Approval</h6>
          </div>
          <div class="modal-body">
            <div class="row gy-3" style="padding:5px;">
              <table id="logApproval" class=" table" style="width:100%;">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
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
<script>
function closeModalAndRefresh() {
    $('#detailData').modal('hide');
    setTimeout(function() {
        location.reload();
    }, 500); // beri jeda agar modal sempat tertutup dulu
}
</script>
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
    $('#detailData').on('hidden.bs.modal', function () {
      if (!$('#detailData').hasClass('show') && !$('#infoModal').hasClass('show')) {
          location.reload();
      }
        
    });
    $(document).on('click', '.infobtn', function() {
      var id = $(this).data('id');
      $('#detailData').modal('hide');
      $('#infoModal').modal('show');
      // Kosongkan isi tabel logApproval
      $('#logApproval tbody').html('<tr><td colspan="4" style="text-align:center;">Loading...</td></tr>');

      // Panggil data log via AJAX
      $.ajax({
        url: '<?= base_url('Peminjaman/getStatusLog') ?>',
        type: 'POST',
        data: { id_dtl_peminjaman: id },
        dataType: 'json',
        success: function(response) {
          var html = '';
          if (response.length > 0) {
            $.each(response, function(index, item) {
              html += `
                      <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama_approval}</td>
                        <td>${item.user_approval}</td>
                        <td>${item.waktu_approval}</td>
                      </tr>
                    `;
            });
          } else {
            html = '<tr><td colspan="4" style="text-align:center;">Data tidak ditemukan</td></tr>';
          }
          $('#logApproval tbody').html(html);
        },
        error: function() {
          $('#logApproval tbody').html('<tr><td colspan="4" style="text-align:center;">Terjadi kesalahan</td></tr>');
        }
      });
    });
    // Ketika modal infoModal ditutup
    $('#infoModal').on('hidden.bs.modal', function () {
      $('#detailData').modal('show');
    });
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
      // Custom filter for date range
      // $.fn.dataTable.ext.search.push(
      //   function(settings, data, dataIndex) {
      //     const startDate = $('#start-date').val();
      //     const endDate = $('#end-date').val();
      //     const loanStart = data[4]; // kolom Start of Loan (index ke-4)

      //     if (!startDate && !endDate) return true;

      //     const momentLoanStart = new Date(loanStart);
      //     const momentStartDate = startDate ? new Date(startDate) : null;
      //     const momentEndDate = endDate ? new Date(endDate) : null;

      //     if (
      //       (!momentStartDate || momentLoanStart >= momentStartDate) &&
      //       (!momentEndDate || momentLoanStart <= momentEndDate)
      //     ) {
      //       return true;
      //     }
      //     return false;
      //   }
      // );

      // Tombol filter diklik
      $('#filter-date').on('click', function () {
        tableData.draw();
      });
    function loadDetailData(id_peminjaman) {
      $.ajax({
        url: '<?= base_url("Functions/getDtlPeminjamanByIdPeminjamanKoorUPT") ?>',
        method: 'POST',
        data: { id_peminjaman: id_peminjaman },
        dataType: 'html',
        success: function(response) {
          let table = $('#dataTableDetailPeminjaman').DataTable();
          table.destroy();

          $('#dataTableDetailPeminjaman tbody').html(response);

          table = $('#dataTableDetailPeminjaman').DataTable({
            responsive: true,
            "ordering": true,
            columnDefs: [
              { targets: 0, type: 'num' },
              {
                targets: [9], 
                visible: false,
                searchable: false
              }
            ]
          });

          //Acc Button
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
                  url: "<?php echo base_url('Functions/accpeminjamanKoorUPT') ?>",
                  method: "post",
                  data: { id_dtl_peminjaman: id },
                  success: function() {
                    Swal.fire({
                      title: 'Succeed!',
                      text: 'Data saved successfully!',
                      icon: 'success'
                    }).then(okay => {
                      if (okay) {
                        loadDetailData(id_peminjaman); // reload modal data
                      }
                    });
                  }
                });
              }
            });
          });

          //Reject Button
          $('.rejectbtn').on('click', function () {
            
            var id = $(this).data('id');
            Swal.fire({
              title: 'Are you sure you want to reject data?',
              input: 'text',
              inputLabel: 'Enter the reason for rejection',
              inputPlaceholder: 'Example: Data tidak valid',
              showCancelButton: true,
              confirmButtonText: 'Reject',
              cancelButtonText: 'Cancel',
              inputValidator: (value) => {
                if (!value) {
                  return 'Reason is required!';
                }
              }
            }).then((result) => {
              if (result.isConfirmed) {
                
                $.ajax({
                  url: "<?php echo base_url('Functions/rejectpeminjamanKoorUPT') ?>",
                  method: "post",
                  data: {
                    id_dtl_peminjaman: id,
                    alasan: result.value
                  },
                  success: function() {
                    Swal.fire({
                      title: 'Succeed!',
                      text: 'Data saved successfully!',
                      icon: 'success'
                    }).then(okay => {
                      if (okay) {
                        $('#detailData').modal('show');
                        loadDetailData(id_peminjaman); // reload modal data
                      }
                    });
                  }
                });
              }
            });
          });
        }
      });
    }

    $('#dataTableApproval').on('click', '.databtn', function () {
        const id = $(this).data('id');
        // Lanjutkan aksi sesuai kebutuhan, contoh:
        console.log("ID terpilih:", id);

        // Misalnya, buka modal detail:
        $('#detailData').modal('show');
        var id_peminjaman = $(this).data('id');
      loadDetailData(id_peminjaman);
        // Lalu panggil AJAX isi tabel detail jika perlu
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