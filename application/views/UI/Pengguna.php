<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('Header');
?>
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">User</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium">User</li>
      </ul>
    </div>
    <!-- END HEADER -->

    <div class="card  basic-data-table">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-md-6">
            <!-- <h6 class="mb-0"><b>Filter</b></h6> -->
          </div>
          <div class="col-md-6 text-end">
            <a href="#" class="btn btn-primary btn-md text-white" data-toggle="modal" data-target="#tambahData">
              <i class="fa fa-plus mr-1"></i> Add User
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="dataTablePengguna" class=" table bordered-table mb-0" style="width:100%">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">NPK</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Username</th>
                <th style="text-align: center;">Password</th>
                <th style="text-align: center;">Role</th>
                <th style="text-align: center;">Main Job</th> 
                <th style="text-align: center;">Other Job</th>
                <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                  <th style="text-align: center;">Action</th>
                <?php } ?> 
                <th >Foto</th>
                <th >Name Only</th>
                <th >Password</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $status;
              foreach ($getData as $Pengguna):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td ><?= $Pengguna->id_pengguna ?></td>
                  <td >
                    <div class="d-flex align-items-center" style="gap: 10px; ">
                      <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <img src="<?= base_url(); ?>assets/foto/tim/<?= $Pengguna->foto ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
                      </div>
                      <div>
                        <!-- <div class="fw-medium text-dark"></div> -->
                        <h6 class="text-primary-light text-md mb-8"><?= $Pengguna->nama_pengguna ?></h6>
                      </div>
                    </div>
                  </td>
                  <td ><?= $Pengguna->email_pengguna ?></td>
                  <td ><?= $Pengguna->username_pengguna ?></td>
                  <td >
                    <div style="position: relative;">
                      <input type="password" id="password-<?= $Pengguna->id_pengguna ?>" value="<?= $Pengguna->password_pengguna ?>" readonly style="border: none; background: transparent; width: 100px;">
                      <i class="ri-eye-line" id="togglePassword-<?= $Pengguna->id_pengguna ?>" style="cursor: pointer; position: absolute; right: 5px; top: 5px;"></i>
                  </div>
                  </td>
                  <td style="text-align: center;"><?= $Pengguna->role_pengguna ?></td>
                  <td ><?= $Pengguna->main_job ?></td>
                  <td ><?= $Pengguna->other_job ?></td>
                  <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
                    <td style="text-align: center;">
                      <div style="gap: 10px; white-space: nowrap;">
                        <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn">
                          <iconify-icon icon="lucide:edit"></iconify-icon>
                        </button>
                        <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center btndelete" data-id="<?=$Pengguna->id_pengguna ?>">
                          <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                      </div>
                        
                    </td>
                  <?php } ?>
                    
                  <td><?= $Pengguna->foto ?></td>
                  <td ><?= $Pengguna->nama_pengguna ?></td>
                  <td ><?= $Pengguna->password_pengguna ?></td>
                  
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- END TABLE -->

    <!-- MODAL -->
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
        <form action="<?= base_url('functions/savePengguna') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Add User</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <label for="namaPengguna" class="form-label">NPK <span style="color:red;">*</span></label>
                  <input  type="text" class="form-control" name="npkPengguna" placeholder="NPK" required />
                </div>
                <div class="col-12">
                  <label for="namaPengguna" class="form-label">Name <span style="color:red;">*</span></label>
                  <input  type="text" class="form-control" name="namaPengguna" placeholder="Name" required />
                </div>
                <div class="col-12">
                  <label for="emailPengguna" class="form-label">Email <span style="color:red;">*</span></label>
                  <input type="email" class="form-control" name="emailPengguna" placeholder="Email" required />
                </div>
                <div class="col-12">
                  <label for="usernamePengguna" class="form-label">User Name <span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="usernamePengguna" placeholder="User Name" required />
                </div>
                <div class="col-12">
                  <label for="passwordPengguna" class="form-label">Password <span style="color:red;">*</span></label>
                  <input type="password" class="form-control" name="passwordPengguna" placeholder="Password" required />
                </div>
                <div class="col-12">
                  <label for="rolePengguna" class="form-label">Role <span style="color:red;">*</span></label>
                  <select name="rolePengguna" id="rolePengguna" class="form-control" required>
                    <option value="">--Role--</option>
                    <option value="Koordinator UPT">Koordinator UPT</option>
                    <option value="PIC LAB">PIC LAB</option>
                    <option value="Super Admin">Super Admin</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="mainJob" class="form-label">Main Job <span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="mainJob" placeholder="Main Job" required />
                </div>
                <div class="col-12">
                  <label for="otherJob" class="form-label">Other Job <span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="otherJob" placeholder="Other Job" required />
                </div>
                <div class="col-12">
                  <label for="foto">User Photos <span class="form-group-text" style="color:red;">*</span></label>
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
        <form action="<?= base_url('functions/editPengguna') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="card-title mb-0">Edit User</h6>
            </div>
            <div class="modal-body">
              <div class="row gy-3">
                <div class="col-12">
                  <input type="hidden" id="idPenggunaE" name="idPenggunaE" class="form-control form-control-user" readonly required value="" />
                  <label for="namaPenggunaE" class="form-label">Name <span style="color:red;">*</span></label>
                  <input id="namaPenggunaE" type="text" class="form-control" name="namaPenggunaE" placeholder="Name" required />
                </div>
                <div class="col-12">
                  <label for="emailPenggunaE" class="form-label">Email <span style="color:red;">*</span></label>
                  <input id="emailPenggunaE" type="email" class="form-control" name="emailPenggunaE" placeholder="Email" required />
                </div>
                <div class="col-12">
                  <label for="usernamePenggunaE" class="form-label">User Name <span style="color:red;">*</span></label>
                  <input id="usernamePenggunaE" type="text" class="form-control" name="usernamePenggunaE" placeholder="User Name" required />
                </div>
                <div class="col-12">
                  <label for="passwordPenggunaE" class="form-label">Password <span style="color:red;">*</span></label>
                  <input id="passwordPenggunaE" type="password" class="form-control" name="passwordPenggunaE" placeholder="Password" required />
                </div>
                <div class="col-12">
                  <label for="rolePenggunaE" class="form-label">Role <span style="color:red;">*</span></label>
                  <select name="rolePenggunaE" id="rolePenggunaE" class="form-control" required>
                    <option value="">--Role--</option>
                    <option value="Koordinator UPT">Koordinator UPT</option>
                    <option value="PIC LAB">PIC LAB</option>
                    <option value="Super Admin">Super Admin</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="mainJobE" class="form-label">Main Job <span style="color:red;">*</span></label>
                  <input  type="text" class="form-control" id="mainJobE" name="mainJobE" placeholder="Main Job" required />
                </div>
                <div class="col-12">
                  <label for="otherJobE" class="form-label">Other Job <span style="color:red;">*</span></label>
                  <input  type="text" class="form-control" name="otherJobE" id="otherJobE" placeholder="Other Job" required />
                </div>
                <div class="col-12">
                  <label for="fotoE">User Photos </label>
                  <!-- <span class="form-group-text" style="color:red;">*</span> -->
                  <input type="file" accept=".jpg, .jpeg, .png" id="fotoE" class="form-control" onchange="Ganti(this,'lbfoto');" name="fotoE"  />
                </div>
                <input type="text" hidden class="form-control" id="fotoO" name="fotoO" />
                <img id="image" class="mt-2" style="width:20%">
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php foreach ($getData as $Pengguna): ?>
        const passwordInput<?= $Pengguna->id_pengguna ?> = document.getElementById("password-<?= $Pengguna->id_pengguna ?>");
        const toggleBtn<?= $Pengguna->id_pengguna ?> = document.getElementById("togglePassword-<?= $Pengguna->id_pengguna ?>");

        toggleBtn<?= $Pengguna->id_pengguna ?>.addEventListener("click", function () {
            const isPassword = passwordInput<?= $Pengguna->id_pengguna ?>.type === "password";
            passwordInput<?= $Pengguna->id_pengguna ?>.type = isPassword ? "text" : "password";
            toggleBtn<?= $Pengguna->id_pengguna ?>.classList.toggle("ri-eye-line");
            toggleBtn<?= $Pengguna->id_pengguna ?>.classList.toggle("ri-eye-close-line");
        });
        <?php endforeach; ?>
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    <?php if ($this->session->userdata('role') == 'Super Admin') { ?>
      var tableData = $('#dataTablePengguna').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num',
          targets: 4, type: 'string',
          targets: 1, type: 'string' },
          {
            targets: [10,11,12], 
            visible: false,
            searchable: false
          }
          
        ]
      });
    <?php }else{ ?>
      var tableData = $('#dataTablePengguna').DataTable({
        "ordering": true,
        columnDefs: [
          { targets: 0, type: 'num',
          targets: 4, type: 'string',
          targets: 1, type: 'string' },
          {
            targets: [9,10,11], 
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
      $('#idPenggunaE').val(data[1]);
      $('#namaPenggunaE').val(data[11]);
      $('#emailPenggunaE').val(data[3]);
      $('#usernamePenggunaE').val(data[4]);
      $('#rolePenggunaE').val(data[6]);
      $('#mainJobE').val(data[7]);
      $('#otherJobE').val(data[8]);
      $('#passwordPenggunaE').val(data[12]);
      $('#fotoO').val(data[10]);
      var link = "<?php echo base_url() ?>assets/foto/tim/";
      $("#image").attr("src", link + data[10]);
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
          url: "<?php echo base_url('Functions/deletePengguna') ?>",
          method: "post",
          data: {
            id_pengguna: id
          }
        })
        Swal.fire({
          title: 'Succeed!',
          text: 'Data deleted successfully!',
          type: 'success',
          icon: 'success'
        }).then(okay => {
          if (okay) {
            window.location.href = "<?php echo base_url('Functions/Pengguna') ?>"
          }
        })
      }
    })
  });
</script>