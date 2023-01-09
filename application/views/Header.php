<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte3.2/plugins/fontawesome/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte3.2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/adminlte3.2/dist/css/adminlte.min.css">
    <!-- Swing Alert -->
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte3.2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Ruangan</title>

    <style type="text/css">
        span.input-group-text :hover {
            cursor: pointer;
        }

        .modal {
            text-align: center;
            padding: 0 !important;
        }

        .hiddenField {
            display: none;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }

        * {
            box-sizing: border-box
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons*/
        /* .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        } */

        /* Position the "next button" to the right */
        /* .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        } */

        /* On hover, add a black background color with a little bit see-through */
        /* .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        } */

        /* Caption text */
        /* .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        } */

        /* Number text (1/3 etc) */
        /* .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        } */

        /* The dots/bullets/indicators */
        /* .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        } */

        /* .active,
        .dot:hover {
            background-color: #717171;
        } */

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }


        /* @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        } */
        .centerTable {
            text-align: center;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png" alt="Logo Politeknik Astra" width="8%">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link resetpw" title="ubah" href="javascript:void(0);">Ubah Kata Sandi ?</a>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">9 Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-toolbox mr-2"></i> 4 Pengajuan Barang
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-person-booth mr-2"></i> 5 Pengajuan Ruangan
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Lihat Semua</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo site_url('Functions/Dashboard'); ?>" class="brand-link">
                <img src="<?php echo base_url() ?>assets/adminlte3.2/dist/img/Logo.png" alt="Logo Politeknik Astra" class="brand-image ml-3">
                <center><span class="brand-text font-weight-thin">Peminjaman Ruangan</span></center>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url(); ?>assets/foto/admin/<?php echo $this->session->userdata('foto') ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $this->session->userdata('nama') ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-header">MENU</li>
                        <li class="nav-item <?= ($activePage == 'Dashboard') ? 'menu-open' : '' ?>">
                            <a href="<?= site_url('Functions/Dashboard'); ?>" class="nav-link <?= ($activePage == 'Dashboard') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Beranda
                                    <i class="right fas"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item
            <?= ($activePage == 'Data') ? 'menu-open' : ''; ?> 
            <?= ($activePage == 'Admin') ? 'menu-open' : ''; ?> 
            <?= ($activePage == 'Barang') ? 'menu-open' : ''; ?>
            <?= ($activePage == 'JenisRuangan') ? 'menu-open' : ''; ?>
            <?= ($activePage == 'Ruangan') ? 'menu-open' : ''; ?>
            <?= ($activePage == 'Fasilitas') ? 'menu-open' : ''; ?>
            <?= ($activePage == 'SOP') ? 'menu-open' : ''; ?>">

                            <a href="#" class="nav-link 
            <?= ($activePage == 'Data') ? 'active' : ''; ?> 
            <?= ($activePage == 'Admin') ? 'active' : ''; ?> 
            <?= ($activePage == 'Barang') ? 'active' : ''; ?>
            <?= ($activePage == 'JenisRuangan') ? 'active' : ''; ?>
            <?= ($activePage == 'Ruangan') ? 'active' : ''; ?>
            <?= ($activePage == 'Fasilitas') ? 'active' : ''; ?>
            <?= ($activePage == 'SOP') ? 'active' : ''; ?>">

                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Data
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if ($this->session->userdata('role') == 1) { ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Functions/Admin'); ?>" class="nav-link <?= ($activePage == 'Admin') ? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-solid fa-user"></i>
                                            <p>
                                                Admin
                                                <span class="badge badge-info right"></span>
                                            </p>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item">
                                    <a href="<?php echo site_url('Functions/Barang'); ?>" class="nav-link <?= ($activePage == 'Barang') ? 'active' : ''; ?>">
                                        <i class="nav-icon fas fa-toolbox"></i>
                                        <p>
                                            Barang
                                            <span class="badge badge-info right"></span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url('Functions/JenisRuangan'); ?>" class="nav-link <?= ($activePage == 'JenisRuangan') ? 'active' : ''; ?>">
                                        <i class="nav-icon fas fa-key"></i>
                                        <p>
                                            Jenis Ruangan
                                            <span class="badge badge-info right"></span>
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url('Functions/Ruangan'); ?>" class="nav-link <?= ($activePage == 'Ruangan') ? 'active' : ''; ?>">
                                        <i class="nav-icon fas fa-person-booth"></i>
                                        <p>
                                            Ruangan
                                            <span class="badge badge-info right"></span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo site_url('Functions/Fasilitas'); ?>" class="nav-link <?= ($activePage == 'Fasilitas') ? 'active' : ''; ?>">
                                        <i class="nav-icon fas fa-gears"></i>
                                        <p>
                                            Fasilitas
                                            <span class="badge badge-info right"></span>
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo site_url('Functions/SOP'); ?>" class="nav-link <?= ($activePage == 'SOP') ? 'active' : ''; ?>">
                                        <i class="nav-icon fas fa-scroll"></i>
                                        <p>
                                            SOP
                                            <span class="badge badge-info right"></span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url("Functions/RiwayatPeminjaman") ?>" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Riwayat Peminjaman
                                    <span class="badge badge-info right"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url("LoginUser\logout") ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Keluar
                                    <span class="badge badge-info right"></span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Reset Password Modal -->
        <div class="modal fade" id="resetpw" tabindex="-1" role="dialog" aria-labelledby="resetpw" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <form action="<?php echo base_url('Functions/resetPassword') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ubah Kata Sandi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" readonly value="<?= $this->session->userdata('username') ?>" />
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi Baru<span style="color:red;">*</span></label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" required class="form-control" id="password" name="password" placeholder="Masukkan Kata Sandi Baru" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button Text="Edit" class="btn btn-primary shadow-sm">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#show_hide_password span").on("click", function(event) {
                    event.preventDefault();
                    if ($("#show_hide_password input").attr("type") == "text") {
                        $("#show_hide_password input").attr("type", "password");
                        $("#show_hide_password i").addClass("fa-eye-slash");
                        $("#show_hide_password i").removeClass("fa-eye");
                    } else if ($("#show_hide_password input").attr("type") == "password") {
                        $("#show_hide_password input").attr("type", "text");
                        $("#show_hide_password i").removeClass("fa-eye-slash");
                        $("#show_hide_password i").addClass("fa-eye");
                    }
                });
            });
            $(document).ready(function() {
                $('.resetpw').on('click', function() {
                    $('#resetpw').modal('show');
                });
            });
        </script>