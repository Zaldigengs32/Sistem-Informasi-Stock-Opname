<?php ob_start();?>


<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lemari</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Menu</a></li>
              <li class="breadcrumb-item active">Penyimpanan</li>
              <li class="breadcrumb-item active">Lemari</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END HEADER -->

<!-- TABLE -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <div class="col-lg-12">
         <div class="card">

           <div class="card-header border-0">
             <div class="d-flex justify-content-between">
               <!-- <h3 class="card-title">Daftar Lemari</h3> -->
             </div>
             <button type="button" id="btnTambah" style="margin-top: 10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#tambahData">Tambah Data</button>
           </div>

           <div class="card-body">
                  <table id="dataTable" class="display nowrap table-striped table" style="width:100%" >
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Deskripsi</th>
                              <th>Ukuran</th>
                              <th>Status</th>
                              <th hidden="true">Status Int</th>
                              <th hidden="true">Created By</th>
                              <th hidden="true">Created Date</th>
                              <th hidden="true">Modified By</th>
                              <th hidden="true">Modified Date</th>
                              <th>Aksi</th>
                         </tr>
                      </thead>
                      <tbody>
                        <?php
                            foreach($getData as $data){
                        ?>
                        <tr>                             
                            <td><?php echo $data->idLemari?></td>
                            <td><?php echo $data->deskripsiLemari?></td>
                            <td><?php echo $data->ukuranLemari?></td>
                            <td>
                                <?php if($data->status == 0){
                                  echo "Tidak Aktif";
                                }else{ 
                                  echo "Aktif";
                                } ?>
                            </td>
                            <td hidden="true"><?php echo $data->status?></td>
                            <td hidden="true"><?php echo $data->createdBy?></td>
                            <td hidden="true"><?php echo $data->createdDate?></td>
                            <td hidden="true"><?php echo $data->modifiedBy?></td>
                            <td hidden="true"><?php echo $data->modifiedDate?></td>
                            <td>
                                <a href="javascript:void(0);" class="fa fa-pencil-square-o color-muted editbtn"></a>
                                <a href="javascript:void(0);" class="fa fa-tasks color-muted detailbtn" style="margin-left: 25px;"></a>
                            </td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
           </div>

           <br/><br/><br/>

         </div>
        </div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END TABLE -->



<!-- MODAL -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!-- TAMBAH DATA -->
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahData" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                <form action="<?php echo base_url('Functions/saveLemari')?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                              <form role="form" action="<?php echo site_url('Functions/saveLemari')?>" method="post" autocomplete="off">
                                  <div class="form-group row align-items-center">
                                      <label class="col-sm-3 col-form-label text-label">Deskripsi</label>
                                      <div class="col-sm-9">
                                          <div class="input-group">
                                               <input type="text" id="deskripsiLemari" name="deskripsiLemari" class="form-control form-control-user" required></input>
                                          </div> 
                                      </div>
                                  </div>
                                  <div class="form-group row align-items-center">
                                      <label class="col-sm-3 col-form-label text-label">Ukuran</label>
                                      <div class="col-sm-9">
                                          <div class="input-group">
                                               <input type="text" id="ukuranLemari" name="ukuranLemari" class="form-control form-control-user" required></input>
                                          </div> 
                                      </div>
                                  </div>         
                              </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button ID="submit" name="submit" class="btn btn-primary shadow-sm" Text="Create">Tambah</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end TAMBAH DATA-->


        <!-- EDIT DATA -->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                <form action="<?php echo base_url('Functions/editLemari')?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <div class="row match-height">
                                <div class="col-12">
                                <form role="form" action="<?php echo site_url('Functions/editLemari')?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-3 col-form-label text-label">ID</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                 <input type="text" id="idU" name="idU" class="form-control form-control-user" readonly required></input>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-3 col-form-label text-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                               <input type="text" id="deskripsiLemariU" name="deskripsiLemariU" class="form-control form-control-user" required></input>
                                            </div> 
                                        </div>
                                    </div>
                                     <div class="form-group row align-items-center">
                                        <label class="col-sm-3 col-form-label text-label">Ukuran</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                               <input type="text" id="ukuranLemariU" name="ukuranLemariU" class="form-control form-control-user" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-sm-3 col-form-label text-label">Status</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                              <select name="statusU" id="statusU" class="form-control form-control-user" style="width: 180px;">
                                                <option value='1'>Aktif</option>
                                                <option value='0'>Tidak Aktif</option>
                                              </select>
                                            </div>
                                        </div>
                                    </div>               
                                </div>
                            </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button ID="submit" name="updateData" class="btn btn-primary shadow-sm" Text="Edit">Ubah</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end EDIT DATA-->

        <!-- DETAIL-->
        <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="detailData" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">ID</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                       <input type="text" id="idD" name="idD" class="form-control form-control-user" disabled required></input>
                                  </div> 
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">Deskripsi</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                       <input type="text" id="deskripsiLemariD" name="deskripsiLemariD" class="form-control form-control-user" disabled required></input>
                                  </div> 
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">Ukuran</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                       <input type="text" id="ukuranLemariD" name="ukuranLemariD" class="form-control form-control-user" disabled required></input>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">Status</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                  <select disabled name="statusD" id="statusD" class="form-control form-control-user" style="width: 180px;">
                                    <option value='1'>Aktif</option>
                                    <option value='0'>Tidak Aktif</option>
                                  </select>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">Tanggal dibuat</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                       <input type="text" id="creadateD" name="creadateD" class="form-control form-control-user" disabled required></input>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-3 col-form-label text-label">Tanggal diubah</label>
                              <div class="col-sm-9">
                                  <div class="input-group">
                                       <input type="text" id="modidateD" name="modidateD" class="form-control form-control-user" disabled required></input>
                                  </div>
                              </div>
                          </div>  
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                      </div>
                    </div>
            </div>
        </div>
        <!-- end DETAIL DATA-->

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END MODAL -->

        </div>
      </div>
    </section>
  </div>
<?php
$data = ob_get_clean();
?>

<?php ob_start();?>

<!-- SCRIPT -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    <script type="text/javascript">
      $(document).ready(function(){
        var modiDate = $('#modidateD').val();

        if (modiDate === '0000-00-00 00:00:00') {
            $('#modidateD').val('-');
        }else{
          
        }
      });
    </script>

    <script>
        $(document).ready(function(){
            $('.editbtn').on('click', function(){
                $('#editmodal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();
                console.log(data);

                $('#idU').val(data[0]);
                $('#deskripsiLemariU').val(data[1]);
                $('#ukuranLemariU').val(data[2]);
                $('#statusU').val(data[4]);            
            });
        });

        $(document).ready(function(){
            $('.detailbtn').on('click', function(){
                $('#detailData').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();
                console.log(data);

                $('#idD').val(data[0]);
                $('#deskripsiLemariD').val(data[1]);
                $('#ukuranLemariD').val(data[2]);
                $('#statusD').val(data[4]); 
                $('#creadateD').val(data[6]); 
                $('#modidateD').val(data[8]); 
            });
        });
    </script>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END SCRIPT -->

<?php
$script = ob_get_clean();
include('master_page.php');
ob_flush();
?>
