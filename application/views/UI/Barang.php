<?php
$this->load->view('Header');
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
            <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahData">
              <i class="fa fa-plus mr-1"></i> Add Inventory
            </a>
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
              <option value="Borrowed">Borrowed</option>
              <option value="Not Available">Not Available</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
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
                <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                  <th style="text-align: center;">Action</th>
                <?php } ?>
                <th >ID</th>
                <th >Nama</th>
                <th >Tipe</th>
                <th >Kategori</th>
                <th >Kondisi</th>
                <th >Data Gambar</th> 
                <th >Penyimpanan</th>
                <th >Ruangan</th>
                
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
                    
                  </td>
                    
                  <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                    <td class="center">
                      <div style="gap: 10px; white-space: nowrap;">
                        <button href="javascript:void(0)" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn">
                          <iconify-icon icon="lucide:edit"></iconify-icon>
                        </button>
                        <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center btndelete" data-id="<?=$brg->id_barang ?>">
                          <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                      </div>
                    </td>
                  <?php } ?>
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

    <!-- editData Modal -->
    <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editData"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?= base_url('functions/editBarang') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Edit Inventory</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <input type="hidden" id="idBarangE" name="idBarangE" class="form-control form-control-user" readonly required />
                  <label class="form-label">Inventory Name <span style="color:red;">*</span></label>
                  <input for="namaBarangE" type="text" class="form-control" name="namaBarangE" id="namaBarangE" placeholder="Inventory Name" required />
                </div>
                <div class="col-12">
                  <label for="nomorAktivaE" class="form-label">Asset Number <span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="nomorAktivaE" id="nomorAktivaE" placeholder="Asset Number" required />
                </div>

                <div class="col-12">
                  <label for="totalBarangE" class="form-label">Total Items <span style="color:red;">*</span></label>
                  <input type="number" class="form-control" name="totalBarangE" id="totalBarangE" placeholder="Total Items" required min="0" />
                </div>

                <div class="col-12">
                  <label for="satuanBarangE" class="form-label">Inventory Unit <span style="color:red;">*</span></label>
                  <select name="satuanBarangE" id="satuanBarangE" class="form-control" required>
                    <option value="">--Inventory Unit--</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Lembar">Lembar</option>
                    <option value="Pack">Pack</option>
                  </select>
                </div>

                <div class="col-12">
                  <label for="kondisiBarangE" class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="kondisiBarangE" id="kondisiBarangE" class="form-control" required>
                      <option value="">--Inventory Condition--</option>
                      <option value="Good">Good</option>
                      <option value="Not Good">Not Good</option>
                      <option value="Minor Damaged">Minor Damaged</option>
                      <option value="Major Damaged">Major Damaged</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="kategoriBarangE"  class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="kategoriBarangE" id="kategoriBarangE" class="form-control" required>
                      <option value="">--Inventory Category--</option>
                      <option value="Asset">Asset</option>
                      <option value="Non Asset">Non Asset</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="tipeBarangE"  class="form-label">Inventory Condition <span style="color:red;">*</span></label>
                  <select name="tipeBarangE" id="tipeBarangE" class="form-control" required>
                      <option value="">--Inventory Type--</option>
                      <option value="Consummable">Consummable</option>
                      <option value="Non Consummable">Non Consummable</option>
                    </select>
                </div>

                <div class="col-12">
                  <label for="lokasiBarangE" class="form-label">Inventory Location <span style="color:red;">*</span></label>
                  <select name="lokasiBarangE" id="lokasiBarangE" class="form-control" required>
                    <option value="">--Inventory Location--</option>
                    <?php foreach ($ruangans as $ruangan): ?>
                      <option value="<?= $ruangan->id_ruangan ?>"><?= $ruangan->nama_ruangan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-12">
                  <label for="penyimpananBarangE"  class="form-label">Inventory Storage <span style="color:red;">*</span></label>
                  <select name="penyimpananBarangE" id="penyimpananBarangE" class="form-control" required>
                    <option value="">--Inventory Storage--</option>
                    <?php foreach ($penyimpanans as $penyimpanan): ?>
                      <option value="<?= $penyimpanan->id_penyimpanan ?>"><?= $penyimpanan->nama_penyimpanan ?></option>
                    <?php endforeach; ?>
                  </select>
                  
                </div>

                <div class="col-12">
                  <label for="keteranganLokasiE"  class="form-label">Storage Details <span style="color:red;">*</span></label>
                  <input type="text" id="keteranganLokasiE" class="form-control" name="keteranganLokasiE" placeholder="Storage Details" required />
                </div>

                <div class="col-12">
                  <label for="fotoE">Inventory Photos </label>
                  <!-- <span class="form-group-text" style="color:red;">*</span> -->
                  <input type="file" accept=".jpg, .jpeg, .png" id="fotoE" class="form-control" onchange="Ganti(this,'lbfoto');" name="fotoE"  />
                </div>
                <input type="text" hidden class="form-control" id="fotoO" name="fotoO" />
                <img id="image" class="mt-2" style="width:50%">
              </div>
            </div>
            <div class="modal-footer">
              <button style="width:150px" id="btn_update_barang" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Update</button>
              <button style="width:150px" id="btn_batal_update" type="button" onclick="$('#editData').modal('hide')" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Batal</button>
            </div>
          </div>
        </form>
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
}else if (isset($tambah)) {
  ?>
  <script>
    swal.fire("Succeed!", "Data successfully added!", "success");
  </script>
  <?php
} else if (isset($hapus)) {
  ?>
    <script>
      swal.fire("Succeed!", "Data deleted successfully!", "success");
    </script>
  <?php
} else if (isset($ubah)) {
  ?>
      <script>
        swal.fire("Succeed!", "Data successfully changed!", "success");
      </script>
<?php } ?>
<script type="text/javascript">
  function showImageModal(imageSrc) {
    document.getElementById('zoomedImage').src = imageSrc;
    // Tampilkan modal
    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
  }

  $(document).ready(function() {
    <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
      var tableData = $('#dataTableBarang').DataTable({
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
    <?php }else{ ?>
      var tableData = $('#dataTableBarang').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num' },
          { targets: 2, type: 'string' },
          {
            targets: [7, 8, 9, 10, 11,12,13,14], 
            visible: false,
            searchable: false
          }
        ]
      });
    <?php } ?>
    $('.editbtn').on('click', function () {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var row = tableData.row($tr);
      var data = row.data(); // Ini akan mengembalikan array semua kolom, termasuk yang hidden
      var link = "<?php echo base_url() ?>assets/foto/barang/";
      //data[4] -> 1Pcs
      //memisahkan angka dan huruf dengan space
      var jmlbrg = data[3];
      var jml = jmlbrg.split(" "); //output : ["1", "Pcs"]

      //data[5] -> LEMARI 4,DIATAS LEMARI
      var lokasi = data[5];
      var lokasibrg = lokasi.split(" "); //output : ["LEMARI 4", "DIATAS LEMARI"]

      //data[7] -> nama gambar
      //data[9] -> status Aktif/tidak aktif di db ubah dulu bentuknya jadi int di db
      var status;
      if (data[9] == 'Tersedia') {
        status = '1';
      } else if (data[9] == 'Tidak Tersedia') {
        status = '2';
      }
      $('#idBarangE').val(data[8]);
      $('#namaBarangE').val(data[9]);
      $('#nomorAktivaE').val(data[2]);
      $('#totalBarangE').val(jml[0]);
      $('#satuanBarangE').val(jml[1]).change();
      $('#kondisiBarangE').val(data[12]);
      $('#tipeBarangE').val(data[10]);
      $('#kategoriBarangE').val(data[11]);
      $('#lokasiBarangE').val(data[15]);
      $('#penyimpananBarangE').val(data[14]);
      if(lokasibrg[5]!=null&&lokasibrg[5]!= undefined){
        $('#keteranganLokasiE').val(lokasibrg[5]+' '+lokasibrg[6]);
      }else{
        $('#keteranganLokasiE').val('');
      }
      
      $('#fotoO').val(data[13]);
      $("#image").attr("src", link + data[13]);
      $('#statusBarangE').val(status).change();
    });
  });
  //Sweet Alert to delete data
  $('.btndelete').on('click', function () {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to delete data?',
      text: "You can't return this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/deletebarang') ?>",
          method: "post",
          data: {
            id_barang: id
          }
        })
        Swal.fire({
          title: 'Succeed!',
          text: 'Data deleted successfully!',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('Functions/Barang') ?>"
          }
        })
      }
    })
  });
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