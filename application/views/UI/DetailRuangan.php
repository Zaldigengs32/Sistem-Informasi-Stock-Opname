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

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- START CONTENT -->
    <!-- DETAIL RUANGAN DATA START -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Detail Ruangan </h3>
                    <button class="btn btn-outline-primary float-right editbtn" data-toggle="modal" data-target="#editDetailData"><a href="#"> <i class="fa fa-pencil mr-1"></i> Ubah Data</a></button>
                </div>
                <div class="card-body">
                    <?php foreach ($getData as $data) { ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Nama Ruangan</label><br>
                                    <span id="dataNama"><?= $data->nama_ruangan; ?></span>
                                    <span hidden id="dataID"><?= $data->id_ruangan; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Jenis Ruangan</label><br>
                                    <span id="dataJenis"><?= $data->nama_jenis_ruangan; ?></span>
                                    <span hidden id="dataJenisId"><?= $data->id_jenis_ruangan; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Lokasi Ruangan</label><br>
                                    <span id="dataLokasi"><?= $data->lokasi_ruangan; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Kapasitas Ruangan</label><br>
                                    <span id="dataKapasitas"><?= $data->kapasitas_ruangan; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Fasilitas</label><br>
                                    <span id="dataFasilitas" class="text-warning">
                                        <?php foreach ($getDataDetilFasilitas as $key) {?>
                                            <img class="mr-3" src="<?= base_url(); ?>assets/foto/fasilitas/<?= $key->gambar_fasilitas ?>" width="50">
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Koordinator UPT</label><br>
                                    <span id="datakoorUpt"><?= $data->koor_upt; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">PIC Ruangan</label><br>
                                    <span id="dataPIC"><?= $data->pic_lab; ?> </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Admin Lab 1</label><br>
                                    <span id="dataAdminLab1"><?= $data->admin_lab1; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="font-weight: bold;">Admin Lab 2</label><br>
                                    <span id="dataAdminLab2"><?= $data->admin_lab2; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
    <!-- DETAIL RUANGAN DATA END -->

    <!-- GALERI START -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Galeri Ruangan</h3>
                    <button class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#tambahGambar"><a href="#" class="text-white"><i class="fa fa-plus mr-1"></i> Tambah Galeri</a></button>
                </div>
                <div class="card-body">
                    <table id="detail" class="display nowrap table-striped table" style="width:100%">
                        <!-- table table-bordered table-hover dataTable dtr-inline -->
                        <thead>
                            <tr>
                                <th>No</th>
                                <th hidden>ID Ruangan</th>
                                <th hidden>ID Galeri</th>
                                <th hidden>Nama Foto</th>
                                <th>Foto Ruangan</th>
                                <?php if ($this->session->userdata('role') == '1') { ?>
                                    <th>Aksi</th><?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php
                            foreach ($getFoto as $data) {
                            ?>
                                <tr>
                                    <td>
                                        <?php $i++;
                                        echo  $i; ?>
                                    </td>
                                    <td hidden><?php echo $data->id_ruangan ?></td>
                                    <td hidden><?php echo $data->id_galeri ?></td>
                                    <td hidden><?= $data->foto ?></td>
                                    <td>
                                        <a href="javascipt:void(0);" class="expand">
                                            <img style="max-height: 100;max-width: 30%;" src="<?php echo base_url(); ?>assets/foto/ruangan/<?php echo $data->foto ?>">
                                        </a>
                                    </td>
                                    <?php if ($this->session->userdata('role') == '1') { ?>
                                        <td>
                                            <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editGambarbtn" tooltip=""></a>
                                            <a href="<?= base_url('functions/deleteGaleri/' . $data->id_ruangan . '-' . $data->id_galeri) ?>" class="ml-2" onclick="return confirm('Apakah Anda yakin menghapus data berikut?')"><i class="fas fa-trash"></i>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- GALERI END -->
            <a class="btn btn-secondary btn-lg" href="<?= site_url('Functions/Ruangan') ?>">Kembali</a>
            <br>
            <br>
    </section>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END CONTENT -->

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- MODAL START -->

    <!-- Detail Galeri Modal -->
    <div class="modal fade" id="expandModal" tabindex="-1" role="dialog" aria-labelledby="expand" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Foto Ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <img id="foto" name="foto" src="" style="max-height: 100;max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.Detail Galeri Modal -->

    <!-- Edit Galeri Modal -->
    <div class="modal fade" id="editGambar" tabindex="-1" role="dialog" aria-labelledby="editGambar" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/editGaleri') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Foto Ruangan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fotoRuanganE">Foto Ruangan<span style="color:red;">*</span></label>
                            <input hidden type="text" required id="idRuanganEG" class="form-control" name="idRuanganEG" />
                            <input hidden type="text" required id="idGaleriEG" class="form-control" name="idGaleriEG" />
                            <input type="file" required id="fotoRuanganE" class="form-control" name="fotoRuanganE" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button ID="submit" Text="Edit" class="btn btn-primary shadow-sm">Ubah</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.Edit Galeri Modal -->

    <!-- Tambah Galeri Modal -->
    <div class="modal fade" id="tambahGambar" tabindex="-1" role="dialog" aria-labelledby="tambahGambar" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/tambahGaleri') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Foto Ruangan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fotoRuanganE">Foto Ruangan<span style="color:red;">*</span></label>
                            <input hidden type="text" required id="idRuanganT" class="form-control" name="idRuanganT" value="<?php foreach($getData as $data){ echo $data->id_ruangan;} ?>" />
                            <input type="file" required id="fotoRuanganT" class="form-control" name="fotoRuanganT[]" multiple />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button ID="submit" name="imgSubmitT" Text="Tambah" class="btn btn-primary shadow-sm">Tambah</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.Tambah Galeri Modal -->

    <!-- Edit Detail Data Modal -->
    <div class="modal fade" id="editDetailData" tabindex="-1" role="dialog" aria-labelledby="editDetailData" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <form action="<?php echo base_url('Functions/editRuangan') ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Detail Ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" required class="form-control" id="idRuanganE" name="idRuanganE" />
                        <label for="namaRuangan">Nama Ruangan <span style="color:red;">*</span></label>
                        <input type="text" required class="form-control" id="namaRuanganE" placeholder="Masukkan Nama Ruangan" name="namaRuanganE" />
                    </div>
                    <div class="form-group">
                        <label for="jenisRuangan">Jenis Ruangan <span style="color:red;">*</span></label>
                        <select class="custom-select form-control-border" name="jenisRuanganE" id="jenisRuanganE" required="">
                            <option value="" required disabled>Pilih Jenis Ruangan</option>
                            <?php
                            foreach ($getDataJenisRuangan  as $row) {
                                echo '<option value="' . $row->id_jenis_ruangan . '">' . $row->nama_jenis_ruangan   . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasiRuangan">Lokasi<span style="color:red;">*</span></label>
                        <input type="text" required class="form-control" id="lokasiRuanganE" placeholder="Masukkan Lokasi Ruangan" name="lokasiRuanganE" />
                    </div>
                    <div class="form-group">
                        <label for="kapasitas">Kapasitas <span style="color:red;">*</span></label>
                        <input type="number" required class="form-control" id="kapasitasE" placeholder="Masukkan Total Kapasitas" name="kapasitasE" />
                    </div>
                    <label for="fasilitas">Fasilitas <span style="color:red;">*</span></label>
                    <!-- Checkbox Fasilitas with icon -->
                    <?php foreach ($getDataFasilitas as $fasil) { ?>
                        <div class="form-check">
                            <input class="form-check-input" name="fasilitas[]" type="checkbox" value="<?= $fasil->id_fasilitas ?>" 
                             <?php foreach($getDataDetilFasilitas as $key){ 
                                if($fasil->id_fasilitas == $key->id_fasilitas){?> checked <?php }} ?> id="<?= $fasil->nama_fasilitas ?>">
                             <label class="form-check-label " for="<?= $fasil->nama_fasilitas ?>">
                                <?= $fasil->nama_fasilitas ?>
                                <!-- <img src="<?= base_url(); ?>assets/foto/fasilitas/<?= $fasil->gambar_fasilitas ?>" width="50"> -->
                            </label>
                            <br>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="koorE">Koor UPT<span style="color:red;">*</span></label>
                        <select class="custom-select form-control-border" name="koorE" id="koorE" required="">
                            <option value="" required disabled>Pilih Koor UPT</option>
                            <option value="Sisia Dika Ariyanto">Sisia Dika Ariyanto</option>
                            <option value="Candra Bagus Kristanto">Candra Bagus Kristanto</option>
                            <option value="Kristina Hutajulu">Kristina Hutajulu</option>
                            <option value="Eko Abdul Goffar">Eko Abdul Goffar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="picRuanganE">PIC Ruangan<span style="color:red;">*</span></label>
                        <select class="custom-select form-control-border" name="picRuanganE" id="picRuanganE" required="">
                            <option value="" required disabled>Pilih PIC Ruangan</option>
                            <option value="Sisia Dika Ariyanto">Sisia Dika Ariyanto</option>
                            <option value="Candra Bagus Kristanto">Candra Bagus Kristanto</option>
                            <option value="Kristina Hutajulu">Kristina Hutajulu</option>
                            <option value="Eko Abdul Goffar">Eko Abdul Goffar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="AdminLab1">Admin Lab 1<span style="color:red;">*</span></label>
                        <input type="text" required class="form-control" id="AdminLab1E" placeholder="Masukkan Nama Admin Lab 1" name="AdminLab1E" />
                    </div>
                    <div class="form-group">
                        <label for="AdminLab2">Admin Lab 2<span style="color:red;">*</span></label>
                        <input type="text" required class="form-control" id="AdminLab2E" placeholder="Masukkan Nama Admin Lab 2" name="AdminLab2E" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button name="submit" value="upload" class="btn btn-primary shadow-sm">Ubah</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.Edit Detail Data Modal -->
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
        table = $('#detail').DataTable({
            columnDefs: [
                {width: '3%',className: 'dt-body-center',targets: 0},
                {className: 'dt-head-center',targets: 0},
                {width: '50%',targets: 4},
                {width: '15%',className: 'dt-body-center',targets: 5}, 
                {className: 'dt-head-center',targets: 5}
            ],
            searching: false,
            paging: false,
            info: false
        });
        $('.expand').on('click', function() {
            $('#expandModal').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#foto').attr("src", '<?php echo base_url(); ?>' + 'assets/foto/ruangan/' + data[3]);
        });
        $('.editGambarbtn').on('click', function() {
            $('#editGambar').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            //fetch into textbox modal edit
            $('#idRuanganEG').val(data[1]);
            $('#idGaleriEG').val(data[2]);
        });
        // ada 2 cara, bisa get dari span / get lagsung dari database soalnya datanya spesifik dari 1 baris data
        $('.editbtn').on('click', function() {
            $('#editDetailData').modal('show');
            $('#namaRuanganE').val(document.getElementById('dataNama').innerHTML);
            $('#idRuanganE').val(document.getElementById('dataID').innerHTML);
            $('#jenisRuanganE').val(document.getElementById('dataJenisId').innerHTML).change();
            $('#lokasiRuanganE').val(document.getElementById('dataLokasi').innerHTML);
            $('#kapasitasE').val(document.getElementById('dataKapasitas').innerHTML);
            $('#koorE').val(document.getElementById('datakoorUpt').innerHTML).change();
            $('#picRuanganE').val(document.getElementById('dataPIC').innerHTML).change();
            $('#AdminLab1E').val(document.getElementById('dataAdminLab1').innerHTML);
            $('#AdminLab2E').val(document.getElementById('dataAdminLab2').innerHTML);
            var fasilitas = [];
            document.querySelectorAll('.dataFasilitasValue').forEach(item => list.push(item.innerText));
            console.log(document.getElementById('datakoorUpt').innerHTML);            
            console.log(document.getElementById('dataPIC').innerHTML);            
        });
    });
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });
</script>