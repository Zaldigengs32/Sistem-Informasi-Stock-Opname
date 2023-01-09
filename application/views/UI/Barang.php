<?php
$this->load->view('Header');
?>

<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item ">Data</li>
            <li class="breadcrumb-item ">Barang</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- END HEADER -->

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- TABLE -->
        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <button class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#tambahData"><a href="#" class="text-white"><i class="fa fa-plus mr-1"></i> Tambah Data</a></button>
            </div>


            <div class="card-body">
              <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden>ID</th>
                    <th>Nama Barang</th>
                    <th>Nomor Aktiva</th>
                    <th>Jumlah Barang</th> <!-- jumlah + satuan_barang -->
                    <th>Kondisi Barang</th>
                    <th>Lokasi Barang</th> <!-- lokasi_barang + baris_lokasi -->
                    <th hidden>Data Gambar</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <?php if ($this->session->userdata('role') == '1') { ?>
                      <th>Aksi</th><?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  $status;
                  foreach ($barang as $brg) :
                    if ($brg->status == 2) {
                      $status = "Tidak Aktif";
                    } else {
                      $status = "Aktif";
                    }
                  ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td hidden><?= $brg->id_barang ?></td>
                      <td><?= $brg->nama_barang ?></td>
                      <td><?= $brg->nomor_aktiva ?></td>
                      <td><?= $brg->jumlah . ' ' . $brg->satuan_barang ?></td>
                      <td><?= $brg->kondisi_barang ?></td>
                      <td><?= $brg->lokasi_barang . ',' . $brg->baris_lokasi ?></td>
                      <td hidden><?= $brg->gambar_barang ?></td>
                      <td><img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>" width="70"></td>
                      <td><?= $status ?></td>
                      <?php if ($this->session->userdata('role') == '1') { ?>
                        <td>
                          <a href="javascript:void(0);" title="Ubah" class="color-muted editbtn">
                            <i class="fa fa-pencil-square-o color-muted editbtn"></i>
                          </a>
                          <a href="<?= base_url('/Functions/deletebarang/' . $brg->id_barang) ?>" onclick="return confirm('Hapus data ini?')" class="ml-2">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <br /><br /><br />
          </div>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- END TABLE -->

        <!-- MODAL -->
        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!-- tambahData Modal -->
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?= base_url('functions/savebarang') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Data Barang</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="namaBarang">Nama Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="namaBarang" placeholder="Masukkan Nama Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="nomorAktiva">Nama Aktiva<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="nomorAktiva" placeholder="Masukkan Nama Aktiva" required />
                  </div>
                  <div class="form-group">
                    <label for="totalBarang">Total Barang<span style="color:red;">*</span></label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="totalBarang" placeholder="Masukkan Total Barang" required />
                      <br>
                      <div class="input-group-append">
                        <select name="satuanBarang" id="satuanBarang" class="form-control" required>
                          <option value="Pcs">Pcs</option>
                          <option value="Lembar">Lembar</option>
                          <option value="Pack">Pack</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kondisiBarang">Kondisi Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="kondisiBarang" placeholder="Masukkan Kondisi Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="lokasiBarang">Lokasi Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="lokasiBarang" placeholder="Masukkan Lokasi Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="barisLokasi">Baris Lokasi<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="barisLokasi" placeholder="Masukkan Baris Lokasi" required />
                  </div>
                  <div class="form-group">
                    <div class="form-group-prepend">
                      <label for="foto">Foto Barang<span class="form-group-text" style="color:red;">*</span></label>
                    </div>
                    <div class="custom-file">
                      <input type="file" required id="foto" class="custom-file-form" name="foto" required />
                      <label class="custom-file-label" for="foto">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" Text="Create" class="btn btn-primary shadow-sm">Tambah</button>
                </div>
              </div>
              <!-- /.modal-content -->
          </div>
          </form>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.tambahData Modal -->

        <!-- editData Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?= base_url('functions/editBarang') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ubah Data Barang</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="hidden" id="idBarangE" name="idBarangE" class="form-control form-control-user" readonly required></input>
                    <label for="namaBarangE">Nama Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="namaBarangE" id="namaBarangE" placeholder="Masukkan Nama Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="nomorAktivaE">Nama Aktiva<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="nomorAktivaE" id="nomorAktivaE" placeholder="Masukkan Nama Aktiva" required />
                  </div>
                  <div class="form-group">
                    <label for="totalBarangE">Total Barang<span style="color:red;">*</span></label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="totalBarangE" id="totalBarangE" placeholder="Masukkan Total Barang" required />
                      <br>
                      <div class="input-group-append">
                        <select name="satuanBarangE" id="satuanBarangE" class="form-control" required>
                          <option value="Pcs">Pcs</option>
                          <option value="Lembar">Lembar</option>
                          <option value="Pack">Pack</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kondisiBarangE">Kondisi Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="kondisiBarangE" id="kondisiBarangE" placeholder="Masukkan Kondisi Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="lokasiBarangE">Lokasi Barang<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="lokasiBarangE" id="lokasiBarangE" placeholder="Masukkan Lokasi Barang" required />
                  </div>
                  <div class="form-group">
                    <label for="barisLokasiE">Baris Lokasi<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" name="barisLokasiE" id="barisLokasiE" placeholder="Masukkan Baris Lokasi" required />
                  </div>
                  <div class="form-group">
                    <label for="statusBarangE">Status<span style="color:red;">*</span></label><br>
                    <select class="form-control" id="statusBarangE" name="statusBarangE" aria-label="Default select example" required>
                      <option selected value="" disabled>-- Status --</option>
                      <option value="1">Aktif</option>
                      <option value="2">Tidak Aktif</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="fotoE">Foto Barang</label>
                    <input type="hidden" class="form-control" id="fotoO" name="fotoO" />
                    <input type="file" name="fotoE" id="fotoE" class="form-control" />
                    <img id="image" class="mt-2" width="70%">
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button Text="Ubah" class="btn btn-primary shadow-sm">Ubah</button>
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.editData Modal -->

      <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
      <!-- END MODAL -->

    </div>
</div>
</section>
</div>

<?php
$this->load->view('Footer');
if (isset($tambah)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil ditambahkan!", "success");
  </script>
<?php
} else if (isset($hapus)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil dihapus!", "success");
  </script>
<?php
} else if (isset($ubah)) {
?>
  <script>
    swal("Berhasil!", "Data berhasil diubah!", "success");
  </script>
<?php } ?>
<script>
  $(document).ready(function() {
    $('.editbtn').on('click', function() {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
        return $(this).text();
      }).get();

      var link = "<?php echo base_url() ?>assets/foto/barang/";
      console.log(data);
      //data[4] -> 1Pcs
      //memisahkan angka dan huruf dengan space
      var jmlbrg = data[4];
      var jml = jmlbrg.split(" "); //output : ["1", "Pcs"]
      console.log(jml);

      //data[6] -> LEMARI 4,DIATAS LEMARI
      var lokasi = data[6];
      var lokasibrg = lokasi.split(","); //output : ["LEMARI 4", "DIATAS LEMARI"]
      console.log(lokasibrg);

      //data[7] -> nama gambar
      //data[9] -> status Aktif/tidak aktif di db ubah dulu bentuknya jadi int di db
      var status;
      if (data[9] == 'Aktif') {
        status = '1';
      } else if (data[9] == 'Tidak Aktif') {
        status = '2';
      }
      $('#idBarangE').val(data[1]);
      $('#namaBarangE').val(data[2]);
      $('#nomorAktivaE').val(data[3]);
      $('#totalBarangE').val(jml[0]);
      $('#satuanBarangE').val(jml[1]).change();
      $('#kondisiBarangE').val(data[5]);
      $('#lokasiBarangE').val(lokasibrg[0]);
      $('#barisLokasiE').val(lokasibrg[1]);
      $('#fotoO').val(data[7]);
      $("#image").attr("src", link + data[7]);
      $('#statusBarangE').val(status).change();
    });
  });
  $(document).ready(function() {
    var table = $('#dataTable').DataTable({
        columnDefs: [
            {className: 'dt-body-center',targets: 0},
            {className: 'dt-head-center',targets: 0},
            {className: 'dt-body-center',targets: 10},
            {className: 'dt-head-center',targets: 10},
            {className: 'dt-body-center',targets: 4},
            {className: 'dt-head-center',targets: 4}
          ],
          scrollX: true,
          responsive: true
      });
  });
</script>