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
          <h1 class="m-0">Admin</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item">Admin</li>
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
              <button class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#tambahData"><a
                  href="#" class="text-white"><i class="fa fa-plus mr-1"></i> Tambah Data</a></button>
            </div>
            <div class="card-body">
              <table id="dataTable" class="display nowrap table-striped table" style="width:100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th hidden>ID</th>
                    <th>Username</th>
                    <th hidden="true">Kata Sandi</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th hidden>Data Foto</th>
                    <th>Foto</th>
                    <th>Role</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0; ?>
                  <?php
                  foreach ($getData as $data) {
                    ?>
                    <tr>
                      <td><?php $i++; ?><?= $i; ?>
                      </td>
                      <td hidden>
                        <?= $data->id ?>
                      </td>
                      <td><?= $data->username ?></td>
                      <td hidden="true">
                        <?php echo $data->password ?>
                      </td>
                      <td><?= $data->nama ?></td>
                      <td class="center"><?= $data->nohp ?></td>
                      <td><?= $data->email ?></td>
                      <td hidden><?= $data->foto; ?></td>
                      <td class="center">
                        <img src="<?= base_url(); ?>assets/foto/admin/<?= $data->foto ?><?='?' . rand(1, 32000) ?>"width="70">
                      </td>
                      <td class="center"><?= $data->role ?></td>
                      <td class="center">
                        <div class="btn-group">
                          <a href="javascript:void(0);" title="Ubah" class="btn btn-primary color-muted editbtn">
                            <i class="fa fa-pencil-square-o color-muted editbtn"></i>
                          </a>
                          <button class="btn btn-danger btndelete" data-id="<?= $data->id ?>">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
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
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData"
          aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/saveadmin') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Data Admin</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="usernameAdmin">Username <span style="color:red;">*</span></label>
                    <input type="text" autocomplete="FALSE" required class="form-control" id="usernameAdmin"
                      name="usernameAdmin" placeholder="Masukkan Username" />
                  </div>
                  <div class="form-group">
                    <label for="passwordAdmin">Kata Sandi <span style="color:red;">*</span></label>
                    <div class="input-group" id="show_hide_password">
                      <input type="password" required class="form-control" id="passwordAdmin" name="passwordAdmin"
                        placeholder="Masukkan Password" />
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-eye-slash" aria-hidden="true"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="namaAdmin">Nama <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" required id="namaAdmin" name="namaAdmin"
                      placeholder="Masukkan Nama Admin" />
                  </div>
                  <div class="form-group">
                    <label for="noTelpAdmin">Nomor Telepon <span id="nohp" style="color:red;">*</span></label>
                    <input pattern="\d*" type="tel" class="form-control" required id="noTelpAdmin" name="noTelpAdmin"
                      placeholder="Masukkan Nomor Telepon Admin" minlength="11" maxlength="13"
                      onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" />
                  </div>
                  <div class="form-group">
                    <label for="emailAdmin">Email <span style="color:red;">*</span></label>
                    <input type="email" class="form-control" required id="emailAdmin" name="emailAdmin"
                      placeholder="Masukkan Admin Email" />
                  </div>
                  <div class="form-group">
                    <label for="roleAdmin">Role <span style="color:red;">*</span></label><br>
                    <select class="form-control" id="roleAdmin" name="roleAdmin" aria-label="Default select example"
                      required>
                      <option selected value="" disabled>-- Pilih Role --</option>
                      <option value="Super Admin">Super Admin</option>
                      <option value="Admin">Admin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="foto" id="lblfoto">Foto Admin <span class="form-group-text"
                        style="color:red;">*</span></label><br>
                    <div class="custom-file">
                      <input type="file" id="foto" name="foto" class="custom-file-input"
                        onchange="Ganti(this,'lbfoto');" accept=".jpg,.jpeg,.png" required />
                      <label class="custom-file-label" id="lbfoto" for="foto">Pilih file</label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button name="submit" Text="Create" class="btn btn-primary shadow-sm">Tambah</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.tambahData Modal -->

        <!-- editData Modal -->
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="tambahData"
          aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <form action="<?php echo base_url('Functions/editadmin') ?>" method="POST" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ubah Data Admin</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="usernameAdminE">Username <span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" id="usernameAdminE" name="usernameAdminE"
                      placeholder="Masukkan Username" readonly="" />
                  </div>
                  <div class="form-group">
                    <label for="namaAdminE">Nama <span style="color:red;">*</span></label>
                    <input type="text" required class="form-control" id="namaAdminE" name="namaAdminE"
                      placeholder="Masukkan Nama Admin" />
                  </div>
                  <div class="form-group">
                    <label for="noTelpAdminE">Nomor Telepon <span id="nohpE" style="color:red;">*</span></label>
                    <input type="tel" required class="form-control" id="noTelpAdminE" name="noTelpAdminE"
                      placeholder="Masukkan Nomor Telepon Admin" maxlength="13"
                      onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" />
                  </div>
                  <div class="form-group">
                    <label for="emailAdminE">Email <span style="color:red;">*</span></label>
                    <input type="email" required class="form-control" id="emailAdminE" name="emailAdminE"
                      placeholder="Masukkan Email" />
                  </div>
                  <div class="form-group">
                    <label for="roleAdmin">Role <span style="color:red;">*</span></label><br>
                    <select class="form-control" id="roleAdminE" name="roleAdminE" aria-label="Default select example">
                      <option selected value="" disabled>-- Pilih Role --</option>
                      <option value="Super Admin">Super Admin</option>
                      <option value="Admin">Admin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="fotoE" id="lblfotoE">Foto Admin <span class="form-group-text"
                        style="color:red;">*</span></label><br>
                    <div class="custom-file">
                      <input type="hidden" class="form-control" id="fotoO" name="fotoO" />
                      <input type="file" accept=".jpg, .jpeg, .png" id="fotoE" name="fotoE" class="custom-file-input"
                        onchange="Ganti(this,'lbfotoE');" aria-describedby="lblfotoE" />
                      <label class="custom-file-label" id="lbfotoE" for="fotoE">Pilih file</label>
                      <img id="image" class="mt-2" width="50%">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button Text="Edit" class="btn btn-primary shadow-sm">Ubah</button>
                </div>
              </div>
            </form>
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
if (isset($duplicate)) {
  ?>
  <script>
    swal.fire("Gagal!", "Username sudah digunakan!", "error");
  </script>
  <?php
} else if (isset($tambah)) {
  ?>
    <script>
      swal.fire("Berhasil!", "Data berhasil ditambahkan!", "success");
    </script>
  <?php
} else if (isset($hapus)) {
  ?>
      <script>
        swal.fire("Berhasil!", "Data berhasil dihapus!", "success");
      </script>
  <?php
} else if (isset($ubah)) {
  ?>
        <script>
          swal.fire("Berhasil!", "Data berhasil diubah!", "success");
        </script>
<?php } ?>

<script type="text/javascript">
  $(document).ready(function () {
    var table = $('#dataTable').DataTable({
      columnDefs: [
        { className: 'dt-body-center', targets: 0 },
        { className: 'dt-head-center', targets: 0 },
        { className: 'dt-body-center', targets: 8 },
        { className: 'dt-head-center', targets: 8 }
      ],
      scrollX: true,
      // responsive: true,
      ordering: false
    });
  });
  $(document).ready(function () {
    $("#show_hide_password span").on("click", function (event) {
      event.preventDefault();
      if ($("#show_hide_password passwordAdmin input").attr("type") == "text") {
        $("#show_hide_password passwordAdmin input").attr("type", "password");
        $("#show_hide_password input-group-append i").addClass("fa-eye-slash");
        $("#show_hide_password input-group-append i").removeClass("fa-eye");
      } else if ($("#show_hide_password passwordAdmin input").attr("type") == "password") {
        $("#show_hide_password passwordAdmin input").attr("type", "text");
        $("#show_hide_password input-group-append i").removeClass("fa-eye-slash");
        $("#show_hide_password input-group-append i").addClass("fa-eye");
      }
    });
  });
  $(document).ready(function () {
    $('.editbtn').on('click', function () {
      $('#editData').modal('show');
      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function () {
        return $(this).text();
      }).get();

      var link = "<?php echo base_url() ?>assets/foto/admin/";
      var role;
      console.log(data);
      $('#usernameAdminE').val(data[2]);
      $('#passwordAdminE').val(data[3]);
      $('#namaAdminE').val(data[4]);
      $('#noTelpAdminE').val(data[5]);
      $('#emailAdminE').val(data[6]);
      $('#fotoO').val(data[7]);
      $("#image").attr("src", link + data[7]);
      $('#roleAdminE').val(data[9]).change();
    });
  });
  function Ganti(input, lbl) {
    document.getElementById(lbl).innerHTML = input.files[0].name;
  };
  //Sweet Alert to delete data
  $('.btndelete').on('click', function () {
    var id = $(this).data('id');
    console.log(id);
    Swal.fire({
      title: 'Yakin ingin menghapus data ?',
      text: "Anda tidak dapat mengembalikan ini!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/hapusAdmin') ?>",
          method: "post",
          data: {
            id_admin: id
          }
        })
        Swal.fire({
          title: 'Dihapus!',
          text: 'Data berhasil dihapus.',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('Functions/Admin') ?>"
          }
        })
      }
    })
  });
</script>