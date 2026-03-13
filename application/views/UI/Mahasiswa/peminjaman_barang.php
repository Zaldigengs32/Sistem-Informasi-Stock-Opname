<!DOCTYPE html>
<html lang="en">
<head>
    <title>Asset & Non Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/dist/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png" sizes="16x16">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.css">
    <link href="<?php echo base_url() ?>assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/styles/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/User/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        .text-sm {
            font-size: 0.875rem !important;
        }
        .fw-semibold {
            font-weight: 600 !important;
        }
        .px-20 {
            padding-inline: 1.25rem !important;
        }
        .py-9 {
            padding-block: 0.5625rem !important;
        }
        .text-white {
            --bs-text-opacity: 1;
            color: rgba(255,255,255,1) !important;
        }
        .rounded-pill {
            border-radius: 50rem !important;
        }
        .bg-success-600 {
            background-color: #16A34A !important;
        }
        .bg-lilac-600 {
            background-color: #8252E9 !important;
        }
        .bg-info-600 {
            background-color: #2563EB !important;
        }
        .bg-pink-600{
            background-color:#e952a9 !important
        }
        .category-item img {
          max-height: 80px;
          margin-bottom: 10px;
        }

        .category-carousel .category-item .category-title {
          margin-top: auto;
          font-size: 1rem;
          font-weight: 700;
        }

        .cart-icon-container {
          position: relative;
          display: inline-block;
        }

        .cart-badge {
          position: absolute;
          top: -8px;
          right: -8px;
          background-color: red;
          color: white;
          font-size: 10px;
          font-weight: bold;
          border-radius: 50%;
          padding: 2px 6px;
          line-height: 1;
        }

        .card-custom-height {
            min-height: 200px; /* Sesuaikan tinggi minimal */
        }
        .truncate-multiline {
          display: -webkit-box;
          -webkit-line-clamp: 2; 
          -webkit-box-orient: vertical;
          overflow: hidden;
        }

    </style>
</head>
<body>
    <div class="super_container">
        <!-- Header -->
        <header  class="header d-flex flex-row" style="top: 10px;height: 70px;">
            <?php include('navbarMenu.php'); ?>
        </header>
    </div>
    <!-- Home -->
    
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <defs>
        <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
          <path fill="currentColor" d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
          <path fill="currentColor" d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z"/>
        </symbol>
        
        <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
          <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z"/>
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
          <path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/>
        </symbol>
        
        <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
          <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z"/>
        </symbol>
      </defs>
    </svg>

    <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>
    <?php
        $backgroundColors = [
            '#E6F4F1', // Mint & Forest
            '#F5F7FA', // Soft Gray & Indigo
            '#FFF4F0', // Peach & Coral
            '#EBF5FB', // Powder Blue & Navy
            '#FDEEF3', // Blush & Rose
            '#F4F9F4', // Sage & Olive
            '#FFF9F0', // Sand & Gold
            '#F4F1FA', // Lavender & Violet
            '#F0F8FF', // Sky & Steel
            '#FAF3E0'  // Cream & Brown
        ];
        $randomBg = $backgroundColors[array_rand($backgroundColors)];
        shuffle($backgroundColors);
        $index =0;
    ?>
    
    <!-- Product Section -->
    <section style="margin-top:7rem">
      <div class="container-fluid" style="width: 90%;margin-left:5%;max-width: 100%;">
        <div class="row">
          <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs">
              <div class="tabs-header d-flex justify-content-between border-bottom my-3">
                <h3>Inventory</h3>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a href="#nav-all" class="nav-link text-uppercase fs-6 active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                    <a href="#av-asset" class="nav-link text-uppercase fs-6" id="nav-asset-tab" data-bs-toggle="tab" data-bs-target="#nav-asset">Asset</a>
                    <a href="#nav-nonasset" class="nav-link text-uppercase fs-6" id="nav-non-asset-tab" data-bs-toggle="tab" data-bs-target="#nav-nonasset">Non Asset</a>
                  </div>
                </nav>
              </div>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                    <form class="mb-3" method="get" action="<?= base_url('Dashboard/peminjamanBarang') ?>">
                      <input type="hidden" name="tab" value="all">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" name="search_all"  value="<?= $this->input->get('search_all') ?>" placeholder="Search">
                        </div>
                        <div class="col-md-3">
                          <select name="kategori_all" class="form-control">
                            <option value="">-- Semua Kategori --</option>
                            <option value="Asset" <?= $this->input->get('kategori_all') == 'Asset' ? 'selected' : '' ?>>Asset</option>
                            <option value="Non Asset" <?= $this->input->get('kategori_all') == 'Non Asset' ? 'selected' : '' ?>>Non Asset</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <select name="tipe_all" class="form-control">
                            <option value="">-- Semua Tipe --</option>
                            <option value="Consummable" <?= $this->input->get('tipe_all') == 'Consummable' ? 'selected' : '' ?>>Consummable</option>
                            <option value="Non Consummable" <?= $this->input->get('tipe_all') == 'Non Consummable' ? 'selected' : '' ?>>Non Consummable</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-primary w-100" type="submit">Filter</button>
                        </div>
                      </div>
                    </form>

                    <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <?php 
                        foreach ($barang_all  as $brg): 
                    ?>
                        <div class="col">
                            <div class="product-item card-custom-height h-100">
                                <?php switch ($brg->kategori_barang) {
                                    case 'Asset':
                                      echo '<span class="badge position-absolute  fw-semibold rounded-pill bg-success-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                    case 'Non Asset':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-info-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                  } ?>
                                  
                                  <?php switch ($brg->tipe_barang) {
                                    case 'Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-lilac-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                    case 'Non Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-pink-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                  } ?>
                                
                                <figure>
                                  <a href="#" title="Product Title">
                                    <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>"  class="tab-image">
                                  </a>
                                </figure>
                                <h3 style="font-size: 0.75rem;"><?= $brg->nama_barang ?></h3>
                                <div class="d-flex align-items-center ">
                                  <h7><?= $brg->nomor_aktiva ?></h7>
                                  <span style="background-color: #aab4c8;width: 3px;height: 3px;display: block;border-radius: 100%;align-self: center;margin: 0 4px;"></span>
                                  <span class="qty" style="color:#6d7588">
                                    <?= $brg->jumlah_barang . ' ' . $brg->satuan_barang ?></span>
                                </div>
                                  
                                <?php if (isset($_COOKIE['nim']) ) {
                                    ?>

                                <div class="d-flex align-items-center justify-content-between">
                                  <div class="input-group product-qty" >
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                          </button>
                                      </span>
                                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" style="z-index: 0;">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                          </button>
                                      </span>
                                  </div>
                                    <a href="#" class="nav-link add-to-cart-btn"  data-id="<?= $brg->id_barang ?>" 
                                    data-nim="<?= $_COOKIE['nim']; ?>"> <iconify-icon icon="heroicons:shopping-cart"></iconify-icon></a>
                                  
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="pagination-wrapper d-flex justify-content-center mt-4">
                        <?= $pagination_all; ?>
                    </div>
                  <!-- / product-grid -->
                </div>

                <div class="tab-pane fade" id="nav-asset" role="tabpanel" aria-labelledby="nav-fruits-tab">
                  <form class="mb-3" method="get" action="<?= base_url('Dashboard/peminjamanBarang') ?>">
                    <input type="hidden" name="tab" value="asset">
                    <div class="row">
                      <div class="col-md-1">
                        <label>Search: </label>
                      </div>
                      <div class="col-md-4">

                        <input type="text" class="form-control" name="search_asset"  value="<?= $this->input->get('search_asset') ?>" placeholder="Search">
                      </div>
                      <div class="col-md-1">
                        <label>Tipe: </label>
                      </div>
                      <div class="col-md-4">
                        <select name="tipe_asset" class="form-control">
                          <option value="">-- Semua Tipe --</option>
                          <option value="Consummable" <?= $this->input->get('tipe_asset') == 'Consummable' ? 'selected' : '' ?>>Consummable</option>
                          <option value="Non Consummable" <?= $this->input->get('tipe_asset') == 'Non Consummable' ? 'selected' : '' ?>>Non Consummable</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Filter</button>
                      </div>
                    </div>
                  </form>
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <?php 
                        foreach ($barang_asset  as $brg): 
                    ?>
                        <div class="col" style="margin-top:10px">
                            <div class="product-item card-custom-height h-100" >
                                <?php switch ($brg->kategori_barang) {
                                    case 'Asset':
                                      echo '<span class="badge position-absolute  fw-semibold rounded-pill bg-success-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                    case 'Non Asset':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-info-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                  } ?>
                                  
                                  <?php switch ($brg->tipe_barang) {
                                    case 'Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-lilac-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                    case 'Non Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-pink-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                  } ?>
                                
                                <figure>
                                  <a href="#" title="Product Title">
                                    <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>"  class="tab-image">
                                  </a>
                                </figure>
                                <!-- $brg->nomor_aktiva.' | '. -->
                                <h5 class="truncate-multiline" style="font-size: 0.75rem;"><?= htmlspecialchars($brg->nama_barang) ?></h5>
                                <div class="d-flex align-items-center ">
                                  <h7><?= $brg->nomor_aktiva ?></h7>
                                  <span style="background-color: #aab4c8;width: 3px;height: 3px;display: block;border-radius: 100%;align-self: center;margin: 0 4px;"></span>
                                  <span class="qty" style="color:#6d7588"><?= $brg->jumlah_barang . ' ' . $brg->satuan_barang ?></span>
                                </div>

                                <?php if (isset($_COOKIE['nim']) ) {
                                    ?>
                                <div class="d-flex align-items-center justify-content-between">
                                  <div class="input-group product-qty">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                          </button>
                                      </span>
                                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                          </button>
                                      </span>
                                  </div>
                                  <a href="#" class="nav-link add-to-cart-btn"  data-id="<?= $brg->id_barang ?>" 
                                    data-nim="<?= $_COOKIE['nim']; ?>"> <iconify-icon icon="heroicons:shopping-cart"></iconify-icon></a>
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="pagination-wrapper d-flex justify-content-center mt-4">
                        <?= $pagination_asset; ?>
                    </div>
                  </div>
                  <!-- / product-grid -->
                </div>
                <div class="tab-pane fade" id="nav-nonasset" role="tabpanel" aria-labelledby="nav-juices-tab">
                  <form class="mb-3" method="get" action="<?= base_url('Dashboard/peminjamanBarang') ?>">
                    <input type="hidden" name="tab" value="non-asset">
                    <div class="row">
                      <div class="col-md-1">
                        <label>Search: </label>
                      </div>
                      <div class="col-md-4">

                        <input type="text" class="form-control" name="search_non_asset"  value="<?= $this->input->get('search_non_asset') ?>" placeholder="Search">
                      </div>
                      <div class="col-md-1">
                        <label>Tipe: </label>
                      </div>
                      <div class="col-md-4">
                        <select name="tipe_non_asset" class="form-control">
                          <option value="">-- Semua Tipe --</option>
                          <option value="Consummable" <?= $this->input->get('tipe_non_asset') == 'Consummable' ? 'selected' : '' ?>>Consummable</option>
                          <option value="Non Consummable" <?= $this->input->get('tipe_non_asset') == 'Non Consummable' ? 'selected' : '' ?>>Non Consummable</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Filter</button>
                      </div>
                    </div>
                  </form>
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <?php 
                        foreach ($barang_non_asset  as $brg): 
                    ?>
                        <div class="col">
                            <div class="product-item card-custom-height h-100">
                                <?php switch ($brg->kategori_barang) {
                                    case 'Asset':
                                      echo '<span class="badge position-absolute  fw-semibold rounded-pill bg-success-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                    case 'Non Asset':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-info-600 text-white m-1">'.$brg->kategori_barang.'</span>';
                                      break;
                                  } ?>
                                  
                                  <?php switch ($brg->tipe_barang) {
                                    case 'Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-lilac-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                    case 'Non Consummable':
                                      echo '<span class="badge position-absolute fw-semibold rounded-pill bg-pink-600 text-white " style="margin:1.5rem 0.2rem;">'.$brg->tipe_barang.'</span>';
                                      break;
                                  } ?>
                                
                                <figure>
                                  <a href="#" title="Product Title">
                                    <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>"  class="tab-image">
                                  </a>
                                </figure>
                                <h3 style="font-size: 0.75rem;"><?= $brg->nama_barang ?></h3>
                                <div class="d-flex align-items-center ">
                                  <h7><?= $brg->nomor_aktiva ?></h7>
                                  <span style="background-color: #aab4c8;width: 3px;height: 3px;display: block;border-radius: 100%;align-self: center;margin: 0 4px;"></span>
                                  <span class="qty" style="color:#6d7588"><?= $brg->jumlah_barang . ' ' . $brg->satuan_barang ?></span>
                                </div>

                                <?php if (isset($_COOKIE['nim']) ) {
                                    ?>
                                <div class="d-flex align-items-center justify-content-between">
                                  <div class="input-group product-qty">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                          </button>
                                      </span>
                                      <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                          </button>
                                      </span>
                                  </div>
                                  <a href="#" class="nav-link add-to-cart-btn"  data-id="<?= $brg->id_barang ?>" 
                                    data-nim="<?= $_COOKIE['nim']; ?>"> <iconify-icon icon="heroicons:shopping-cart"></iconify-icon></a>
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="pagination-wrapper d-flex justify-content-center mt-4">
                        <?= $pagination_non_asset; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div> -->
    </section>
    <!-- Footer -->
    <footer class="footer" style="padding-bottom: 0px;margin-top: 50px;">
        <div class="container">
            <div class="footer_bar d-flex flex-column flex-sm-row align-items-center">
                <div class="footer_copyright" style="color:white;">
                    <span>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Polteknik Astra</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                </div>
            </div>

        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/easing/easing.js"></script>

    <script src="<?php echo base_url() ?>assets/styles/bootstrap4/bootstrap.min.js"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <script src="<?php echo base_url() ?>assets/User/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>assets/User/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/User/js/script.js"></script>
    <script>
        // Simpan tab aktif saat diklik
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (e) {
                sessionStorage.setItem('activeTab', e.target.getAttribute('href'));
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
          const urlParams = new URLSearchParams(window.location.search);
          const tab = urlParams.get('tab') || 'all';

          const triggerEl = document.querySelector(`#nav-${tab}-tab`);
          if (triggerEl) {
            new bootstrap.Tab(triggerEl).show();
          }
        });
    </script>
    <script>
      $(document).ready(function(){
          $('.add-to-cart-btn').click(function(e){
              e.preventDefault();

              var id_barang = $(this).data('id');
              var nim = $(this).data('nim');
              var jumlah = $(this).closest('.product-item').find('input[name="quantity"]').val();
              if(jumlah<1){
                swal.fire("Error!", "Minimum quantity 1!", "error");
              }else{
                $.ajax({
                    url: "<?= site_url('Peminjaman/tambahKeranjang') ?>", // Controller/fungsi tujuan
                    method: "POST",
                    data: {
                        id_barang: id_barang,
                        nim: nim,
                        jumlah: jumlah
                    },
                    success: function(response){
                        if (typeof response === 'string') {
                          response = JSON.parse(response);
                        }
                        if (response.status === 'error') {
                          swal.fire("Error!", "Quantity exceeds stock of inventory!", "error");
                        } else {
                          $('#cart-count').text(response.total_items);
                          swal.fire("Succeed!", "Data successfully added!", "success");
                        }
                        // Notifikasi
                        
                    },
                    error: function(xhr){
                        alert('Terjadi kesalahan saat menambahkan ke keranjang.'+xhr.responseText);
                        console.log(xhr.responseText);
                    }
                });
              }
                
          });
          $('.cart-icon-container .dropdown-toggle').on('click', function() {
            $.ajax({
              url: '<?= base_url("Peminjaman/get_summary") ?>',
              type: 'GET',
              dataType: 'json',
              success: function(data) {
                let html = '';
                if (data.length > 0) {
                  $('#cart-total-items').text('(' + data.length + ')');

                  data.forEach(item => {
                    html += `
                      <div class="d-flex p-2 border-bottom">
                        <img src="<?= base_url('assets/foto/barang/') ?>${item.gambar_barang}" alt="${item.nama_barang}" width="50" height="50" class="rounded me-2" style="object-fit:cover;">
                        <div class="flex-grow-1">
                          <div class="fw-semibold small text-truncate">${item.nama_barang}</div>
                        </div>
                        <div class="text-nowrap ms-2 small">
                          <strong>${item.jumlah}</strong> 
                        </div>
                      </div>`;
                  });
                } else {
                      html = '<p class="text-muted text-center my-3">Cart is empty!</p>';
                    }

                    $('#cart-items').html(html);
                  },
                  error: function() {
                    $('#cart-items').html('<p class="text-danger text-center my-3">Failed to load data!</p>');
                  }
            });
          });

      });
      function formatRupiah(angka) {
        return parseInt(angka).toLocaleString('id-ID');
      }
    </script>
</body>
</html>