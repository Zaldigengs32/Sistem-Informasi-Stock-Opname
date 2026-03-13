<body>

<div class="super_container">

<!-- Header -->
<header class="header d-flex flex-row" style="top: 10px;height: 70px;">
<title>tete</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<link href="<?php echo base_url()?>assets/dist/css/styles.css" rel="stylesheet" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Course Project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styles/bootstrap4/bootstrap.min.css">
<link href="<?php echo base_url()?>assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/styles/responsive.css">

<div class="header_content d-flex flex-row align-items-center" style="width: 100%;">
	<img src="<?php echo base_url()?>assets/img/logo.png" alt="" style="width: 25%;padding-left: 2%;">
	<!-- Main Navigation -->
	<nav class="main_nav_container">
		<div class="main_nav">
			<ul class="main_nav_list">
				<li class="main_nav_item"><a href="index.php">Beranda</a></li>
				<li class="main_nav_item"><a href="struktur_organisasi.php">Struktur Organisasi</a></li>
				<li class="main_nav_item"><a href="courses.html">Peminjaman Ruangan</a></li>
				<li class="main_nav_item"><a href="elements.html">Peminjaman Barang</a></li>
			</ul>
		</div>
	</nav>
</div>
</div>


</header>
<br/>
<br/>
<br/>
<br/>
<br/>


<!-- Home -->

<center>
<div class="home">
	<!-- foto Slider -->
	<div class="hero_slider_container">
		<div class="hero_slider owl-carousel">

			<!-- foto Slide -->
			<?php
            $count = 0;
            foreach($queryDRuangan as $row) {
			?>
			<div class="hero_slide">
				<div class="hero_slide_background" style="background-image:url(<?php echo base_url() . 'image/' . $row->foto ?>)"></div>
				
				<div class="hero_slide_container d-flex flex-column align-items-center justify-content-center">
				</div>
			</div>
			<?php
                $count++;
                } 
            ?>
		</div>
	</div>
</div>

<br/>
<br/>
<br/>
<!-- bawah -->
<div style="
	width: 1500px;
	">

	<div class="register">

		<div class="container-fluid">

			<div class="row row-eq-height">
				<div class="col-lg-6 nopadding">

					<!-- fasilitas -->

					<div class="register_section d-flex flex-column align-items-center justify-content-center">
						<div class="search_content text-center">
							<h1 style="color: #ffffff" >PIC</h1>
							<h2>
								<li style="color: #ffffff"><?php echo $row->pic_lab ?></li>
								<li style="color: #ffffff"><?php echo $row->admin_lab1 ?></li>
								<li style="color: #ffffff"><?php echo $row->admin_lab2 ?></li>
							</h2>
							<!-- isi -->
						</div>
					</div>

				</div>

				<div class="col-lg-6 nopadding">

					<!-- PIC -->

					<div class="search_section d-flex flex-column align-items-center justify-content-center">
						<div class="search_background" style="background-image:url(images/search_background.jpg);"></div>
						<div class="search_content text-center">
							<h1 style="color: #095baa">Fasilitas</h1>
							<h2 style="color: #095baa"><?php echo $row->fasilitas ?></h2>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>

<!-- Services -->

<div class="services page_section">

	<div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title text-center">
					<!-- <h1>Our Services</h1> -->
					<a class="mt-4 btn text-white" style="background-color: #0089FF; width: 500px; height: 50px; " href="<?php echo base_url('Dashboard/formPeminjaman') ?>/<?php echo $row->id_ruangan ?>">Pinjam</a>
				</div>
			</div>
		</div>

		<div class="row services_row">
		</div>
	</div>
</div>
</body>