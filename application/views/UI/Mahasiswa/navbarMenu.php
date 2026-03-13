<script src="<?php echo base_url() ?>assets/swal/sweetalert2@11.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/Style/responsive_navbar.css"> -->
<script type="text/javascript">
  function logOut() {
    Swal.fire({
      title: 'Are you sure you want to Log Out?',
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      customClass: {
        actions: 'my-actions',
        cancelButton: 'order-1',
        confirmButton: 'order-2'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?php echo base_url() . 'Dashboard/logout'; ?> ";
      }
    })
  }
  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
</script>
<style>
  @media only screen and (max-width: 991px) {}
  /* Pastikan header selalu fleksibel */
.header_content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}

/* Agar navigasi di tengah dan user icon selalu ke kanan */
.main_nav_container {
  flex: 1;
}

#login {
  order: 2; /* selalu di ujung kanan */
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
  .header_content {
    flex-wrap: nowrap;
  }

  .main_nav_container {
    display: none; /* kalau mau menu disembunyikan di mobile */
  }

  #login {
    margin-left: auto;
  }

  .main_nav_item,
  .main_nav {
    font-size: 10px;
  }
}

</style>

<div class="header_content d-flex align-items-center" style="width: 100%;border-radius: 0.4rem;">
  <img src="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" alt="" style="height: 3rem;padding-left: 2%;">
  <!-- Main Navigation -->
  <nav class="main_nav_container" style="padding-right:0;">
    <div class="main_nav" style="margin-top:0">
      <ul class="main_nav_list" style="font-size:12px;margin-bottom: 0;">
        <li class="main_nav_item active" style="margin-right: 20px;"><a
            href="<?php echo base_url() ?>Dashboard">Home</a></li>
        <li class="main_nav_item" style="margin-right: 20px;"><a
            href="<?php echo base_url() ?>Dashboard/strukturOrganisasi">Member</a></li>
        <li class="main_nav_item" style="margin-right: 20px;"><a
            href="<?php echo base_url() ?>Dashboard/peminjamanBarang">Asset & Non-Asset</a></li>
        <?php if (isset($_COOKIE['nim']) && $_COOKIE['nim'] != '') { ?>
          <li class="main_nav_item" style="margin-right: 20px;">
            <a type="button" style="width:190px"  href="<?php echo base_url() ?>Dashboard/riwayatPeminjamanBarang">Loan History</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
  <?php if (isset($_COOKIE['nim']) && $_COOKIE['nim'] != '') { ?>
  <?php
    $jumlah_keranjang=0;
    if(isset($jumlahKeranjang)){
      $jumlah_keranjang= $jumlahKeranjang;
    }
  ?>
  <div class="main_nav_item d-flex align-items-center" style="gap: 10px; margin-right: 3%;">
    <!-- Nama user -->
    <div class="dropdown">
      <a style="color: #007bff;" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user" style="font-size:12px;color: black;"></i>
        <?php echo "<script>document.write(getCookie('nama'))</script>"; ?>
      </a>
      <div class="dropdown-menu" style="width:200px">
        <center>
          <div class="col-lg-12">
            <button class="btn btn-danger col-lg-8" onclick="logOut()">Logout</button>
          </div>
        </center>
      </div>
    </div>

    <!-- Icon Keranjang dengan Badge -->
    <!-- <div class="cart-icon-container">
      <a href="<?php echo base_url() ?>Dashboard/keranjang" title="Keranjang">
        <i class="material-icons" style="font-size: 24px; vertical-align: middle;">shopping_cart</i>
          <span id="cart-count" class="cart-badge"><?php echo $jumlah_keranjang; ?></span>
      </a>
    </div> -->
    <div class="cart-icon-container dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Keranjang">
        <i class="material-icons" style="font-size: 24px; vertical-align: middle;">shopping_cart</i>
        <span id="cart-count" class="cart-badge"><?= $jumlah_keranjang ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right p-0" id="cart-summary" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
          <strong>Cart <span id="cart-total-items">(0)</span></strong>
          <a href="<?= base_url('Dashboard/keranjang') ?>" class="text-primary small">View Details</a>
        </div>
        <div id="cart-items">
          <!-- Barang akan dimuat di sini via Ajax -->
          <p class="text-muted text-center my-3">Loading...</p>
        </div>
      </div>

    </div>

  </div>
<?php } ?>


  <!-- Nampilin Drop Down Login -->
  <div class="dropdown" id="login" style="padding-right: 2%;<?php if (!isset($_COOKIE['nim']) || $_COOKIE['nim'] == '') {
    echo "display: block;";
  } else {
    echo "display: none;";
  } ?>">
    <a style="color: #007bff;" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="fa fa-user-circle" style="font-size:30px;"></i></a>
    <div class="dropdown-menu" style="width:250px">
      <div>
        <center>
          <div class="col-lg-4 mt-2 mb-2">
            <a class="btn btn-primary" href="<?php echo site_url('/LoginUser') ?>">Login</a>
          </div>
        </center>
      </div>
    </div>
  </div>
  <!-- after login -->
</div>
