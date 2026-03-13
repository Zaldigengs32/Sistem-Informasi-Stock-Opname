<!-- HEADER -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php
$this->load->view('UI/KoordinatorUPT/Header');
?>
<style>
  .line-bg-primary::before {
    background-color: var(--primary-600);
    box-shadow: 2px 1px 7px 0px rgba(29, 128, 252, 0.6);
  }
  .left-line::before {
    position: absolute;
    content: "";
    width: 4px;
    height: 44px;
    background-color: var(--primary-600);
    border-radius: 100px;
    left: -1px;
    top: 24px;
    box-shadow: 2px 1px 7px 0px rgba(29, 128, 252, 0.6);
  }
  .line-bg-success::before {
      background-color: var(--success-600);
      box-shadow: 2px 1px 7px 0px rgba(1, 144, 99, 0.6);
  }
  .line-bg-lilac::before {
      background-color: var(--lilac-600);
      box-shadow: 2px 1px 7px 0px rgba(98, 33, 245, 0.6);
  }
</style>
<!-- <div class="content-wrapper"> -->
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Dashboard</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
            <i class="ri-dashboard-line"></i>
            Dashboard
          </a>
        </li>
      </ul>
    </div>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card radius-12">
                <div class="card-body p-16">
                    <div class="row gy-4">
                        <div class="col-xxl-4 col-xl-4 col-sm-4">
                            <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-1 left-line line-bg-primary position-relative overflow-hidden" style="background: linear-gradient(270deg, #EEF7FF 0%, #DFF0FF 100%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-md">Total Asset Loaned</span>
                                        <h6 class="fw-semibold mb-1"><?= $total_asset_borrowed->total == ''?0:$total_asset_borrowed->total; ?></h6>
                                    </div>
                                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-primary-100 text-primary-600">
                                        <i class="ri-dropbox-fill"></i>
                                    </span>
                                </div>
                                <p class="text-sm mb-0">
                                  <?php if($total_asset_borrowed_last_30day->total>0){
                                    echo '<span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm"><i class="ri-arrow-right-up-line"></i></span>';
                                  }else if($total_asset_borrowed_last_30day->total==0){
                                    echo '<span class="bg-info-focus px-1 rounded-2 fw-medium text-info-main text-sm" style="background-color:rgb(69 179 105 / 15%)"><i class="ri-subtract-line"></i></span>';
                                  }else{
                                    echo '<span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm"><i class="ri-arrow-right-down-line"></i></span>';
                                  }?>
                                   <?= $total_asset_borrowed_last_30day->total == ''?0:$total_asset_borrowed_last_30day->total; ?></span> From 30 days </p>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-sm-4">
                            <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-2 left-line line-bg-lilac position-relative overflow-hidden" style="background: linear-gradient(270deg, #F7F2FF 0%, #EEE5FF 100%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-md">Total Non Asset Loaned</span>
                                        <h6 class="fw-semibold mb-1"><?= $total_non_asset_borrowed->total == ''?0:$total_non_asset_borrowed->total; ?></h6>
                                    </div>
                                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-lilac-100 text-lilac-600">
                                        <i class="ri-dropbox-fill"></i>
                                    </span>
                                </div>
                                <p class="text-sm mb-0">
                                <?php if($total_non_asset_borrowed_last_30day->total>0){
                                    echo '<span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm"><i class="ri-arrow-right-up-line"></i></span>';
                                  }else if($total_non_asset_borrowed_last_30day->total==0){
                                    echo '<span class="bg-info-focus px-1 rounded-2 fw-medium text-info-main text-sm" style="background-color:rgb(69 179 105 / 15%)"><i class="ri-subtract-line"></i></span>';
                                  }else{
                                    echo '<span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm"><i class="ri-arrow-right-down-line"></i></span>';
                                  }?> <?= $total_non_asset_borrowed_last_30day->total == ''?0:$total_non_asset_borrowed_last_30day->total; ?></span> From 30 days </p>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-sm-4">
                            <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-3 left-line line-bg-success position-relative overflow-hidden" style="background: linear-gradient(270deg, #E8FFF9 0%, #D1FFF3 100%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-md">Amount of Loan that needs Approval</span>
                                        <h6 class="fw-semibold mb-1"><?= $approval_koor_upt->total == ''?0:$approval_koor_upt->total; ?></h6>
                                    </div>
                                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-success-200 text-success-600">
                                        <i class="ri-shopping-cart-fill"></i>
                                    </span>
                                </div>
                                <p class="text-sm mb-0">
                                  <?php if($approval_koor_upt_30hari->total>0){
                                    echo '<span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm"><i class="ri-arrow-right-up-line"></i></span>';
                                  }else if($approval_koor_upt_30hari->total==0){
                                    echo '<span class="bg-info-focus px-1 rounded-2 fw-medium text-info-main text-sm" style="background-color:rgb(69 179 105 / 15%)"><i class="ri-subtract-line"></i></span>';
                                  }else{
                                    echo '<span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm"><i class="ri-arrow-right-down-line"></i></span>';
                                  }?> <?= $approval_koor_upt_30hari->total == ''?0:$approval_koor_upt_30hari->total; ?></span> From 30 days </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-3">
      <div class="row">
        <div class="col-xxl-6 col-lg-6">
          <div class="card h-100">
              <div class="card-body p-24">
                  <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                      <h6 class="mb-2 fw-bold text-lg mb-0">Top 10 Asset Most Loaned</h6>
                  </div>
                  <div class="table-responsive scroll-sm">
                      <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                              <th scope="col">No.</th>
                              <th scope="col">Inventory Name</th>
                              <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            if (empty($get_asset_sering_dipinjam)): 
                          ?>
                            <tr>
                              <td colspan="3" class="text-center text-muted">No data</td>
                            </tr>
                          <?php 
                            else: 
                              $no = 1;
                              foreach ($get_asset_sering_dipinjam as $brg): 
                          ?>
                            <tr>
                              <td class="text-sm mb-0"><?= $no++; ?></td>
                              <td class="text-sm mb-0"><?= $brg->nama_barang ?></td>
                              <td class="text-sm mb-0"><?= $brg->total_dipinjam ?></td>
                            </tr>
                          <?php 
                              endforeach;
                            endif; 
                          ?>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-xxl-6 col-lg-6">
          <div class="card h-100">
              <div class="card-body p-24">
                  <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                      <h6 class="mb-2 fw-bold text-lg mb-0">Top 10 Non Asset Most Loaned</h6>
                  </div>
                  <div class="table-responsive scroll-sm">
                      <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                              <th scope="col">No.</th>
                              <th scope="col">Inventory Name</th>
                              <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            if (empty($get_asset_sering_dipinjam)): 
                          ?>
                            <tr>
                              <td colspan="3" class="text-center text-muted">No data</td>
                            </tr>
                          <?php 
                            else: 
                              $no = 1;
                              foreach ($get_asset_sering_dipinjam as $brg): 
                          ?>
                            <tr>
                              <td class="text-sm mb-0"><?= $no++; ?></td>
                              <td class="text-sm mb-0"><?= $brg->nama_barang ?></td>
                              <td class="text-sm mb-0"><?= $brg->total_dipinjam ?></td>
                            </tr>
                          <?php 
                              endforeach;
                            endif; 
                          ?>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card mt-3">
      <div class="col-xxl-12 col-lg-12">
        <div class="card h-100">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                    <h6 class="mb-2 fw-bold text-lg mb-0">Top 10 Most Loaned</h6>
                </div>
                <div class="table-responsive scroll-sm">
                    <table id="tabel-summary" class="table bordered-table mb-0">
                      <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Inventory Name</th>
                            <th scope="col">Inventory Stock</th>
                            <th scope="col">Qty Minimum</th>
                            <th scope="col">Qty Optimum</th>
                            <th scope="col">Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                          foreach ($get_status_stok_menipis as $brg):
                        ?>
                          <tr>
                            <td class="text-sm mb-0"><?= $no++; ?></td>
                            <td class="text-sm mb-0"><?= $brg->nama_barang ?></td>
                            <td class="text-sm mb-0"><?= $brg->total_jumlah ?></td>
                            <td class="text-sm mb-0"><?= $brg->jumlah_minimum ?></td>
                            <td class="text-sm mb-0"><?= $brg->jumlah_optimum ?></td>
                            <td class="text-sm mb-0 text-center" >
                              <?php
                                if($brg->status_stok=='Need Addition'){
                                  echo '<span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Need Addition</span>';
                                }else if($brg->status_stok=='Suboptimal Amount'){
                                  echo '<span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">Suboptimal Amount</span>';
                                }
                                else if($brg->status_stok=='Very Good Quantity'){
                                  echo '<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Very Good Quantity</span>';
                                }
                                ?>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
    
  <!-- /.content -->
</div>
<?php
$this->load->view('Footer');
 ?>
<script>
  $(document).ready(function() {
    var tableData = $('#tabel-summary').DataTable({
        "ordering": true,
        
      });
    
  });
</script>