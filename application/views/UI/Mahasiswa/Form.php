<?php ob_start();?>

<section id="contact" class="contact section-padding">
        <div class="container-sm">
          <div class="row">
              <div class="col-md-12">
                  <div class="section-header text-center pb-5">
                      <h2>Form Peminjaman</h2>
                      <p>Mohon diisi dengan benar!</p>
                  </div>
              </div>
          </div>
    			<div class="row container resize">
    				<div class="col-md-12">
    					<form action="<?php $id = $this->uri->segment(3); echo base_url('/Peminjaman/peminjaman/') ?><?php echo $id ?>" method="post" class="bg-light p-4 m-auto rounded-3">
    						<div class="row">
    							<!-- <div class="mb-3">
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <select class="form-select form-control" id="ruangan">
                      <option selected holder>Pilih Ruangan</option>
                      <option value="101">101</option>
                      <option value="102">102</option>
                      <option value="103">103</option>
                    </select>
                  </div> -->

                  <div class="mb-3">
                    <label for="keperluan" class="form-label">Keperluan</label>
                    <textarea class="form-control" id="keperluan" name="keperluan"></textarea>
                  </div>

                  <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                  </div>

                  <div class="mb-3">
                    <label for="mulaiPinjam" class="form-label">Mulai Pinjam</label>
                    <input type="time" class="form-control" id="mulaiPinjam" name="mulaiPinjam">
                  </div>

                  <div class="mb-3">
                    <label for="selesaiPinjam" class="form-label">Selesai Pinjam</label>
                    <input type="time" class="form-control" id="selesaiPinjam" name="selesaiPinjam">
                  </div>

                  <div class="mb-3">
                    <label for="jumlahPengguna" class="form-label">Jumlah Pengguna</label>
                    <input type="number" class="form-control" id="jumlahPengguna" name="jumlahPengguna">
                  </div>

                  <div class="mb-3">
                    <label for="nim" class="form-label">NIM Peminjam</label>
                    <input type="number" class="form-control" id="nim" name="nim">
                  </div>

                  <div class="mb-3">
                    <label for="peminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="peminjam" name="peminjam">
                  </div>
                  
                  <div class="mb-3">
                    <label for="tingkat" class="form-label">Tingkat</label>
                    <select class="form-select form-control" id="tingkat" name="tingkat">
                      <option selected holder>Pilih Tingkat</option>
                      <option value="MI 1 A">MI 1 A</option>
                      <option value="MI 1 B">MI 1 B</option>
                      <option value="MI 1 C">MI 1 C</option>
                      <option value="MI 2">MI 2</option>
                      <option value="MI 3">MI 3</option>
                    </select>
                  </div>

                  <div class="d-grid gap-2">
                    <button name="submit" type="submit" class="mt-4 btn text-white" style="background-color: #0089FF">Kirim</button>
                    <!-- <a class="btn btn-outline-dark mt-auto"href="<?php $id = $this->uri->segment(3); echo base_url('Peminjaman/peminjaman') ?>/<?php echo $id ?>">Kirim Form</a></div> -->
                  </div>
    					</form>
    				</div>
    			</div>
		</div>
  </section>

<?php
$data = ob_get_clean();
?>

<?php ob_start();?>

<?php
$script = ob_get_clean();
include('master_peminjaman.php');
ob_flush();
?>