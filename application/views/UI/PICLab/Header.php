<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <script>
      // Immediately set theme before page renders to prevent flash
      (function() {
        var theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', theme);
      })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Asset</title>
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/bootstrap.min.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/dataTables.min.css">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/editor-katex.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/editor.quill.snow.css">
    <!-- Date picker css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/flatpickr.min.css">
    <!-- Calendar css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/full-calendar.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/jquery-jvectormap-2.0.5.css">
    <!-- Popup css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/magnific-popup.css">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/slick.css">
    <!-- main css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/style.css">
    <!-- dark mode table css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/css/dark-table.css">
    <style type="text/css">
        @media (min-width: 1400px) {
            .sidebar {
                width: 16rem;
            }
        }
        @media (min-width: 1400px) {
            .dashboard-main {
                margin-inline-start: 16rem;
            }   
        }
        @media (min-width: 1400px) {
            .dashboard-main-body {
                padding: 1rem;
            }
            .sidebar-menu-area {
              padding: 0.75rem;
            }
        }
        .zoomable-img {
          transition: transform 0.3s ease;
        }

        .zoomable-img:hover {
          transform: scale(1.5);
          z-index: 999;
          position: relative;
        }
        .bg-pink-600{
            background-color:#e952a9 !important
        }
        .sidebar.sidebar-logo span.light-logo
        {
          display: inline-block;
            
        }
        .sidebar.active .sidebar-logo span.light-logo{
          display: none;
        }
        .bg-primary-600 {
            --bs-text-opacity: 1;
            background-color: rgba(255, 196, 63, 1) !important;
        }
        .bg-danger-600 {
            /*--bs-text-opacity: 1;*/
            background-color: #FEE2E2 !important;
            border-color: #FEE2E2 !important;
        }
        .bg-secondary-600 {
            background-color: #2563EB;
            color: #fff;
            border-color: #2563EB;
        }
        .bg-success-600 {
            background-color: #16A34A !important;
        }
        .bg-lilac-600 {
            background-color: #8252E9 !important;
        }
        .bg-info-600 {
            background-color: #BFDCFF !important;
        }
        .bg-pink-600{
            background-color:#e952a9 !important
        }
    </style>
</head>

<body>
<aside class="sidebar ">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <center><a href="<?php echo site_url('Functions/DashboardPICLab'); ?>" class="sidebar-logo">
        <img  src="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" alt="Logo Politeknik Astra" width="8%" style="margin-left: 0.5rem;" class="light-logo">
        <img src="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" alt="Logo Politeknik Astra" width="8%" style="margin-left: 0.5rem;" class="dark-logo">
        <img src="<?php echo base_url() ?>assets/adminlte/dist/img/Logo.png" alt="Logo Politeknik Astra" width="50%" style="margin-left: 0.5rem;" class="logo-icon">
        <span style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;margin-left: 0.5rem;font-weight: bold;font-size: 20px;" class="light-logo">Management Asset</span>
    </a></center>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
        <li class="nav-item <?=($activePage == 'DashboardPICLab') ? 'menu-open' : '' ?>">
            <a href="<?= site_url('Functions/DashboardPICLab'); ?>"
                class="nav-link <?=($activePage == 'DashboardPICLab') ? 'active-page' : '' ?>">
                <i class="ri-dashboard-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- <li>
            <a href="<?= site_url('Functions/Approval'); ?>" class="nav-link <?=($activePage == 'Approval') ? 'active-page' : '' ?>">
              <i class="ri-contract-line"></i>
              <span>Approval</span>
            </a>
        </li> -->
        <li>
            <a href="<?= site_url('Functions/BarangPICLab'); ?>" class="nav-link <?=($activePage == 'Barang') ? 'active-page' : '' ?>">
              <i class="ri-tools-line"></i>
              <span>Inventory</span>
            </a>
        </li>
        <li>
            <a href="<?= site_url('Functions/StockOpnamePICLab'); ?>" class="nav-link <?=($activePage == 'StockOpname') ? 'active-page' : '' ?>">
              <i class="ri-file-list-3-line"></i>
              <span>Stock Opname</span>
            </a>
        </li>
        <!-- <li>
            <a href="<?= site_url('Functions/Ruangan'); ?>" class="nav-link <?=($activePage == 'Ruangan') ? 'active-page' : '' ?>">
              <i class="ri-home-6-line"></i>
              <span>Room</span> 
            </a>
        </li>
        <li>
            <a href="<?= site_url('Functions/Penyimpanan'); ?>" class="nav-link <?=($activePage == 'Penyimpanan') ? 'active-page' : '' ?>">
              <i class="ri-box-3-line"></i>
              <span>Storage</span> 
            </a>
        </li>
        <li>
            <a href="<?= site_url('Functions/Pengguna'); ?>" class="nav-link <?=($activePage == 'Pengguna') ? 'active-page' : '' ?>">
              <i class="ri-user-3-line"></i>
              <span>User</span> 
            </a>
        </li> -->
    </ul>
  </div>
</aside>

<main class="dashboard-main ">
  <div class="navbar-header">
      <div class="row align-items-center justify-content-between">
        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-4">
            <button type="button" class="sidebar-toggle">
              <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
              <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
            </button>
            <button type="button" class="sidebar-mobile-toggle">
              <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
            </button>
          </div>
        </div>
        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-3">
            <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
            <div class="dropdown">
              <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
                <img src="<?php echo base_url() ?>assets/foto/Tim/<?= $this->session->userdata('foto')?>" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
              </button>
              <div class="dropdown-menu to-top dropdown-menu-sm">
                <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                  <div>
                    <h6 class="text-lg text-primary-light fw-semibold mb-2"><?= $this->session->userdata('nama') ?></h6>
                    <span class="text-secondary-light fw-medium text-sm"><?= $this->session->userdata('role') ?></span>
                  </div>
                  <button type="button" class="hover-text-danger">
                    <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon> 
                  </button>
                </div>
                <ul class="to-top-list">
                  <!-- <li>
                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="#"> 
                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>  My Profile</a>
                  </li> -->
                  
                  <li>
                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="<?= base_url("LoginUser\logout") ?>"> 
                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>  Log Out</a>
                  </li>
                </ul>
              </div>
            </div><!-- Profile dropdown end -->
          </div>
        </div>
      </div>
    </div> 