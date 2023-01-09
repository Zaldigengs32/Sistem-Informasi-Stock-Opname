<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('Header');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Beranda</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('Functions/Dashboard') ?>">Menu</a></li>
            <li class="breadcrumb-item">Beranda</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>2</h3>
              <p>Menunggu Persetujuan</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Informasi Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>10<sup style="font-size: 20px"></sup></h3>
              <p>Riwayat Peminjaman</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="" class="small-box-footer">Informasi Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <?php foreach($getData as $data){ ?>
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $data->jumlahruangan ?></h3>
              <p>Ruangan Aktif</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('Functions/Ruangan') ?>" class="small-box-footer">Informasi Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $data->jumlahbarang ?></h3>
              <p>Barang Aktif</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?= base_url('Functions/Barang') ?>" class="small-box-footer">Informasi Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <?php } ?>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Ruangan Yang Sering Dipinjam</h3>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- PIE CHART -->
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Barang Yang Sering Dipinjam</h3>
            </div>
            <div class="card-body">
              <canvas id="barChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col (RIGHT) -->
        <div class="col-md-12">
          <!-- PIE CHART -->
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Waktu Peminjaman</h3>
            </div>
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<script>
  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- BAR CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var barChartData = {
      labels: ['January'],
      datasets: [{
          label: 'LAB 108',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label: 'LAB 109',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [65, 59, 80, 81, 56, 55, 40]
        }, {
          label: 'LAB 110',
          backgroundColor: 'rgb(0, 192, 239)',
          borderColor: 'rgb(0, 192, 239)',
          pointRadius: false,
          pointColor: 'rgb(0, 192, 239)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgb(0, 192, 239)',
          data: [20, 59, 80, 81, 56, 55, 40]
        },
      ]
    }
    var temp0 = barChartData.datasets[0]
    var temp1 = barChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }
    // This will get the first returned node in the jQuery collection.
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
    //--------------
    //- BAR CHART 2 -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

    var barChartData2 = {
      labels: ['January'],
      datasets: [{
          label: 'LAB 108',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label: 'LAB 109',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [65, 59, 80, 81, 56, 55, 40]
        }, {
          label: 'LAB 110',
          backgroundColor: 'rgb(0, 192, 239)',
          borderColor: 'rgb(0, 192, 239)',
          pointRadius: false,
          pointColor: 'rgb(0, 192, 239)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgb(0, 192, 239)',
          data: [20, 59, 80, 81, 56, 55, 40]
        },
      ]
    }
    var temp02 = barChartData2.datasets[0]
    var temp12 = barChartData2.datasets[1]
    barChartData2.datasets[0] = temp12
    barChartData2.datasets[1] = temp02
    var barChartOptions2 = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }
    // This will get the first returned node in the jQuery collection.
    new Chart(barChartCanvas2, {
      type: 'bar',
      data: barChartData2,
      options: barChartOptions2
    })
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
      labels: [
        '08.00 - 18.00',
        '18.00 - 21.00',
      ],
      datasets: [{
        data: [20, 8],
        backgroundColor: ['#f56954', '#00c0ef', '#3c8dbc', '#d2d6de'],
      }]
    }
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

  })
</script>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- END TABLE -->
<?php
$this->load->view('Footer');
?>