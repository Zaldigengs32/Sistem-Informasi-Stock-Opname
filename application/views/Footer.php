<!-- /.content-wrapper -->
<footer class="main-footer">
  ‎

  <div class="float-right d-none d-sm-inline-block">
    Designed By <a target="_blank" href="https://www.polytechnic.astra.ac.id/"> Politeknik Astra</a> MI 19-21
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/dist/js/adminlte.js"></script>

<script src="<?php echo base_url() ?>assets/adminlte3.2/dist/js/pages/dashboard.js"></script>

<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Ekko Lightbox -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/fontawesome/js/fontawesome.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url() ?>assets/adminlte3.2/plugins/chart.js/Chart.min.js"></script>
<!-- <script>
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
  });
</script> -->
<script type="text/javascript">
  let slideIndex = 1;
  showSlides(slideIndex);

  // Next/previous controls
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  // Thumbnail image controls
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {
      slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
  }
</script>

</body>

</html>