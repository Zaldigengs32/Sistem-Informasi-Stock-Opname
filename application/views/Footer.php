<!-- /.content-wrapper -->

<style>
  /* Footer text - hitam untuk light mode */
  .footer-text,
  .d-footer .footer-text,
  footer .footer-text {
    color: #000000 !important;
  }
  
  /* Footer text - putih untuk dark mode */
  [data-theme="dark"] .footer-text,
  [data-theme="dark"] .d-footer .footer-text,
  [data-theme="dark"] footer .footer-text,
  html[data-theme="dark"] .footer-text,
  .dark .footer-text,
  body.dark-mode .footer-text {
    color: #ffffff !important;
  }

  /* SweetAlert2 font size */
  .swal2-title {
    font-size: 1.5rem !important;
  }
  .swal2-html-container {
    font-size: 1rem !important;
  }
  
  /* SweetAlert2 Cancel button - teks hitam default, putih saat hover */
  .swal2-cancel {
    color: #000000 !important;
  }
  .swal2-cancel:hover {
    background-color: #374151 !important;
    color: #ffffff !important;
  }
</style>

<footer class="d-footer">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <p class="mb-0 footer-text">© 2025 UPT INFORMATIKA - Politeknik Astra. All Rights Reserved.</p>
    </div>
  </div>
</footer>

 <!-- jQuery library js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/jquery-3.7.1.min.js"></script>
  <script src="<?php echo base_url() ?>assets/adminlte/js/bootstrap.bundle.min.js"></script>
  <!-- Apex Chart js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/apexcharts.min.js"></script>
  <!-- Data Table js -->

  <!-- Iconify Font js -->
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <!-- jQuery UI js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/jquery-ui.min.js"></script>
  <!-- Vector Map js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="<?php echo base_url() ?>assets/adminlte/js/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Popup js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/magnifc-popup.min.js"></script>
  <!-- Slick Slider js -->
  <script src="<?php echo base_url() ?>assets/adminlte/js/slick.min.js"></script>
  
  <!-- main js -->
  <!-- <script src="<?php echo base_url() ?>assets/adminlte/js/app.js"></script> -->
<!-- jQuery (harus sebelum DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="<?php echo base_url() ?>assets/adminlte/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function showImageModal(src) {
    document.getElementById("zoomedImage").src = src;
    $('#imageModal').modal('show');
  }
</script>
<script src="<?php echo base_url() ?>assets/adminlte/js/app.js"></script>


</body>

</html>