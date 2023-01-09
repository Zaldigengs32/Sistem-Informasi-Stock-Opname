<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('Header');
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ruangan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item">Ruangan</li>
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
                    <th hidden>ID Ruangan</th>
                    <th hidden>ID Jenis Ruangan</th>
                    <th>Nama Ruangan</th>
                    <th>Jenis Ruangan</th>
                    <th>Kapasitas</th>
                    <th>PIC</th>
                    <?php if ($this->session->userdata('role') == '1') { ?>
                      <th>Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php
                  foreach ($getData as $data) {
                  ?>
                    <tr>
                      <td><?php echo $i;
                          $i++; ?></td>
                      <td hidden>
                        <?php echo $data->id_ruangan ?>
                      </td>
                      <td hidden><?php echo $data->id_jenis_ruangan; ?></td>
                      <td><?php echo $data->nama_ruangan ?></td>
                      <td><?php if ($data->nama_jenis_ruangan != '') echo $data->nama_jenis_ruangan;
                          else echo '-'; ?></td>
                      <td><?php echo $data->kapasitas_ruangan . ' Orang' ?></td>
                      <td><?php echo $data->pic_lab ?></td>
                      <?php if ($this->session->userdata('role') == '1') { ?>
                        <td>
                          <!-- <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editbtn"></a> -->
                          <a href="<?= base_url('functions/deleteRuangan/' . $data->id_ruangan) ?>" class="ml-2" onclick="return confirm('Apakah Anda yakin menghapus data berikut?')"><i class="fas fa-trash"></i></a>
                          <a href="<?= base_url('functions/detailRuangan/' . $data->id_ruangan) ?>" class="fa fa-tasks color-muted ml-2"></a>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- END TABLE -->

        <!-- MODAL -->
        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!-- tambahData Modal -->
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Data Ruangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php echo form_open_multipart('Functions/saveruangan'); ?>
                <div class="form-group">
                  <label for="namaRuangan">Nama Ruangan <span style="color:red;">*</span></label>
                  <input type="text" required class="form-control" id="namaRuangan" placeholder="Masukkan Nama Ruangan" name="namaRuangan" />
                </div>
                <div class="form-group">
                  <label for="jenisRuangan">Jenis Ruangan <span style="color:red;">*</span></label>
                  <select class="custom-select form-control-border" name="jenisRuangan" required="">
                    <option value="" required selected="selected" disabled>Pilih Jenis Ruangan</option>
                    <?php
                    foreach ($getDataJenisRuangan  as $row) {
                      echo '<option value="' . $row->id_jenis_ruangan . '">' . $row->nama_jenis_ruangan   . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <!-- dummy nama pembuat
                <div class="form-group">
                  <input type="hidden" class="form-control" id="nama" name="nama" value="1" readonly />
                </div> -->
                <div class="form-group">
                  <label for="lokasiRuangan">Lokasi<span style="color:red;">*</span></label>
                  <input type="text" required class="form-control" id="lokasiRuangan" placeholder="Masukkan Lokasi Ruangan" name="lokasiRuangan" />
                </div>
                <div class="form-group">
                  <label for="kapasitas">Kapasitas <span style="color:red;">*</span></label>
                  <input type="number" required class="form-control" id="kapasitas" placeholder="Masukkan Total Kapasitas" name="kapasitas" />
                </div>
                <label for="fasilitas">Fasilitas <span style="color:red;">*</span></label>
                <!-- Checkbox Fasilitas with icon -->
                <?php foreach ($getDataFasilitas as $fasil) { ?>
                  <div class="form-check">
                    <input class="form-check-input" name="fasilitas[]" type="checkbox" value="<?= $fasil->id_fasilitas ?>" id="<?= $fasil->nama_fasilitas ?>">
                    <label class="form-check-label " for="<?= $fasil->nama_fasilitas ?>">
                      <?= $fasil->nama_fasilitas ?>
                      <!-- <img src="<?= base_url(); ?>assets/foto/fasilitas/<?= $fasil->gambar_fasilitas ?>" width="50"> -->
                    </label>
                  </div>
                <?php } ?>
                <div class="form-group">
                  <label for="koor">Koor UPT<span style="color:red;">*</span></label>
                  <select class="custom-select form-control-border" name="koor" required="">
                    <option value="" required selected="selected" disabled>Pilih PIC</option>
                    <option value="Sisia Dika Ariyanto">Sisia Dika Ariyanto</option>
                    <option value="Candra Bagus Kristanto">Candra Bagus Kristanto</option>
                    <option value="Kristina Hutajulu">Kristina Hutajulu</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="pic">PIC Lab<span style="color:red;">*</span></label>
                  <select class="custom-select form-control-border" name="pic" required="">
                    <option value="" required selected="selected" disabled>Pilih PIC</option>
                    <option value="Sisia Dika Ariyanto">Sisia Dika Ariyanto</option>
                    <option value="Candra Bagus Kristanto">Candra Bagus Kristanto</option>
                    <option value="Kristina Hutajulu">Kristina Hutajulu</option>
                    <option value="Eko Abdul Goffar">Eko Abdul Goffar</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="AdminLab1">Admin Lab 1<span style="color:red;">*</span></label>
                  <input type="text" required class="form-control" id="AdminLab1" placeholder="Masukkan Nama Admin Lab 1" name="AdminLab1" />
                </div>
                <div class="form-group">
                  <label for="AdminLab2">Admin Lab 2<span style="color:red;">*</span></label>
                  <input type="text" required class="form-control" id="AdminLab2" placeholder="Masukkan Nama Admin Lab 2" name="AdminLab2" />
                </div>
                <div class="form-group">
                  <label for="fotoRuangan">Foto Ruangan<span style="color:red;">*</span></label>
                  <input type="file" required id="fotoRuangan" class="form-control" name="fotoRuangan[]" multiple />
                </div>
<!--                 <div id="fooBar"><span></span></div>
                <a href="javascript:add();" value="add">Tambah Foto ?</a> -->
                <!-- <div class="form-group">
                  <label for="fotoRuangan">Foto Ruangan 2<span style="color:red;">*</span></label>
                  <input type="file" required id="fotoRuangan2" class="form-control" name="fotoRuangan2" />
                </div>
                <div class="form-group">
                  <label for="fotoRuangan">Foto Ruangan 3<span style="color:red;">*</span></label>
                  <input type="file" required id="fotoRuangan3" class="form-control" name="fotoRuangan3" />
                </div> -->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button name="submit" name="imgSubmit" value="upload" class="btn btn-primary shadow-sm">Tambah</button>
              </div>
              <?php echo form_close() ?>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.tambahData Modal -->

        <!-- editData Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Data Ruangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url('Functions/editruangan') ?>" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" class="form-control" name="idRuanganE" value="<?= $data->idRuangan ?>" id="idRuanganE" readonly>
                  </div>
                  <div class="form-group">
                    <label for="jenisRuanganE">Jenis Ruangan</label>
                    <select class="custom-select form-control-border" id="jenisRuanganE" name="jenisRuanganE" required="">
                      <option value="" selected="selected">Pilih Jenis Ruangan</option>
                      <?php
                      foreach ($getDataJenisRuangan as $row) {
                        echo '<option value="' . $row->idJenisRuangan . '">' . $row->namaJenisRuangan  . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="sopE">SOP</label>
                    <select class="custom-select form-control-border" id="sopE" name="sopE" required="">
                      <option value="" selected="selected">Pilih SOP</option>
                      <?php
                      foreach ($getDataSOP as $row) {
                        echo '<option value="' . $row->idSop . '">' . $row->deskripsi  . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="picE">PIC</label>
                    <select class="custom-select form-control-border" id="picE" name="picE">
                      <option value="" selected="selected">Pilih PIC</option>
                      <?php
                      foreach ($getDatausername as $row) {
                        echo '<option value="' . $row->username . '">' . $row->nama  . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="namaRuanganE">Nama Ruangan</label>
                    <input type="text" class="form-control" id="namaRuanganE" name="namaRuanganE" placeholder="Enter Nama Ruangan" value="namaRuangan" />
                  </div>
                  <div class="form-group">
                    <label for="kapasitasE">Kapasitas</label>
                    <input type="number" class="form-control" id="kapasitasE" name="kapasitasE" placeholder="Enter Total Kapasitas" value="30" />
                  </div>
                  <div class="form-group">
                    <label for="fotoRuanganE">Foto Ruangan</label>
                    <input type="hidden" class="form-control" id="fotoRuanganO" name="fotoRuanganO" />
                    <input type="file" name="fotoRuanganE" id="fotoRuanganE" class="form-control" />
                    <img id="image" class="mt-2" width="70%">
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button ID="submit" Text="Edit" class="btn btn-primary shadow-sm">Ubah</button>
              </div>
              <form action="<?php echo base_url('Functions/editjenisruangan') ?>" method="POST" enctype="multipart/form-data">
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.editData Modal -->

        <!-- detailData Modal -->

        <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Detail Data Ruangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <div class="form-group">
                    <label for="jenisRuanganD">Jenis Ruangan</label>
                    <input type="text" class="form-control" id="jenisRuanganD" name="jenisRuanganD" readonly />
                  </div>
                  <div class="form-group">
                    <label for="deskripsiD">Nama Deskripsi</label>
                    <input id="deskripsiD" type="text" class="form-control" name="deskripsiD" value="<?= $data->nama_ruangan ?>" readonly required>
                  </div>

                  <div class="form-group">
                    <label for="sopD">SOP</label>
                    <input type="text" class="form-control" id="sopD" name="sopD" readonly />
                  </div>

                  <div class="form-group">
                    <label for="usernameD">PIC</label>
                    <input type="text" class="form-control" id="usernameD" name="usernameD" readonly />
                  </div>

                  <div class="form-group">
                    <label for="namaRuanganD">Nama Ruangan</label>
                    <input type="text" class="form-control" id="namaRuanganD" name="namaRuanganD" readonly />
                  </div>

                  <div class="form-group">
                    <label for="statusPinjamD">Status Pinjam</label>
                    <input type="text" class="form-control" id="statusPinjamD" name="statusPinjamD" readonly />
                  </div>
                  <div class="form-group">
                    <label for="kapasitas">Kapasitas</label>
                    <input type="number" class="form-control" id="kapasitasD" placeholder="Enter Total Kapasitas" value="30" readonly />
                  </div>
                  <div class="slideshow-container">

                    <!-- Full-width images with number and caption text -->
                    <div class="mySlides fade">
                      <div class="numbertext">1 / 3</div>
                      <img src="img1.jpg" style="width:100%">
                      <div class="text">Caption Text</div>
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">2 / 3</div>
                      <img src="img2.jpg" style="width:100%">
                      <div class="text">Caption Two</div>
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">3 / 3</div>
                      <img src="img3.jpg" style="width:100%">
                      <div class="text">Caption Three</div>
                    </div>

                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                  </div>
                  <br>

                  <!-- The dots/circles -->
                  <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                  </div>
                  <!-- Status Ruangan bukan Status Pinjam -->
                  <div class="form-group">
                    <label for="status">Status Ruangan</label>
                    <select class="custom-select form-control-border" id="status" disabled>
                      <option holder>Pilih Status Ruangan</option>
                      <option selected>Aktif</option>
                      <option>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.detailData Modal -->



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
  <?php } ?>
?>

<script>
    $(document).ready(function() {
    var table = $('#dataTable').DataTable({
        columnDefs: [
            {className: 'dt-body-center',targets: 0},
            {className: 'dt-head-center',targets: 0},
            {className: 'dt-body-center',targets: 3},
            {className: 'dt-head-center',targets: 3},
            {className: 'dt-body-center',targets: 5},
            {className: 'dt-head-center',targets: 5},
            {className: 'dt-body-center',targets: 7},
            {className: 'dt-head-center',targets: 7}
          ],
          scrollX: true,
          responsive: true
      });
  });
  $(document).ready(function() {
    $('.editbtn').on('click', function() {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
        return $(this).text();
      }).get();
      console.log(data);

      var link = "<?php echo base_url() ?>assets/foto/ruangan/";

      $('#idRuanganE').val(data[1]);
      $('#jenisRuanganE').val(data[2]);
      alert(data[2]);
      $('#sopE').val(data[3]);
      $('#picE').val(data[5]);
      $('#namaRuanganE').val(data[6]);
      $('#statusPinjamE').val(data[10]);
      $('#kapasitasE').val(data[7]);
      $('#fotoRuanganO').val(data[11]);
      $("#image").attr("src", link + data[11]);
    });
  });

  $(document).ready(function() {
    $('.detailbtn').on('click', function() {
      $('#detailData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function() {
        return $(this).text();
      }).get();
      console.log(data);

      var link = "<?php echo base_url() ?>assets/foto/ruangan/";

      $('#idRuanganD').val(data[0]);
      $('#jenisRuanganD').val(data[1]);
      $('#sopD').val(data[2]);
      $('#usernameD').val(data[3]);
      $('#namaRuanganD').val(data[4]);
      $('#kapasitasD').val(data[5]);
      $('#fotoRuanganD').val(data[7]);
      $("#imageD").attr("src", link + data[6]);
    });
  });
  var i = 1;

  function add() {
    i++;
    //Create div
    var div = document.createElement("div");
    div.setAttribute("class", "form-group");

    //Create Labels
    var label = document.createElement("Label");
    label.innerHTML = "Foto Ruangan " + i;
    label.setAttribute("for", "fotoRuangan")

    //Create span
    var span = document.createElement("span");
    span.setAttribute("style", "color:red;");
    span.innerHTML = "*";

    //Assign different attributes to the element.
    var element = document.createElement("input");
    element.setAttribute("type", "file");
    element.setAttribute("id", "fotoruangan" + i);
    element.setAttribute("name", "fotoruangan" + i);
    element.setAttribute("class", "form-control");

    // 'foobar' is the div id, where new fields are to be added
    var foo = document.getElementById("fooBar");
    div.appendChild(label);
    div.appendChild(span);
    div.appendChild(element);
    //Append the element in page (in span).
    foo.appendChild(div);
  }
  // SWING ALERT !
</script>