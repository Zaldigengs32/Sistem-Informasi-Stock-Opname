<?php ob_start();?>

<section id="contact" class="contact section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center pb-5">
                    <h1>Ruang 101</h1>
                    <p>Detail Ruangan</p>
                </div>
            </div>
        </div>
        <div class="row">
              <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-post">
                            <img src="https://via.placeholder.com/900x400" alt="" class="img-fluid"><br><br>
                            <h4>Detail SOP</h4>
                            <p class="mt-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, tenetur debitis iste eos doloremque praesentium nulla numquam nostrum quas distinctio sapiente illum nam laudantium laboriosam nobis odit nesciunt error? Dolor. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam, tenetur debi.</p>
                        </div>
                    </div>
                </div>
              </div>

              <div class="col-lg-4">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="blog-post">
                              <img src="https://via.placeholder.com/300x300" alt="" class="img-fluid"><br><br>
                              <h4>Nama PIC</h4>
                              <p class="mt-3">Distinctio nulla hic repudiandae aliquid sint architecto dolore similique amet laboriosam suscipit in officia rerum, pariatuz.</p>
                          </div>
                      </div>
                  </div>
              </div>   
              <br>

              <div class="container">
                <a href="#" class="btn text-white" style="background-color: #0089FF">Form Peminjaman</a>
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