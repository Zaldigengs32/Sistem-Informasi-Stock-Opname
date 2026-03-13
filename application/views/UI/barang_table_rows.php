<?php $no = 1;
              $status;
              foreach ($barang as $brg):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td>
                    <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                      <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $brg->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
                      </div>
                      <div>
                        <div class="fw-medium text-dark"><?= $brg->nama_barang ?></div>
                        <div class="d-flex align-items-center" style="gap: 6px; white-space: nowrap;">
                          <?php switch ($brg->kategori_barang) {
                            case 'Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white">'.$brg->kategori_barang.'</span>';
                              break;
                            case 'Non Asset':
                              echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white">'.$brg->kategori_barang.'</span>';
                              break;
                          } ?>
                          <?php switch ($brg->tipe_barang) {
                            case 'Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white">'.$brg->tipe_barang.'</span>';
                              break;
                            case 'Non Consummable':
                              echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white">'.$brg->tipe_barang.'</span>';
                              break;
                          } ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td style="text-align: center;"><?= $brg->nomor_aktiva ?></td>
                  <!-- <td class="center"></td> -->
                  <td><?= $brg->jumlah_barang . ' ' . $brg->satuan_barang ?></td>
                  <td><?= $brg->jumlah_optimum . ' ' . $brg->satuan_barang ?></td>
                  <td><?= $brg->jumlah_minimum . ' ' . $brg->satuan_barang ?></td>
                  <td class="center">
                    <?php switch ($brg->kondisi_barang) {
                      case 'Good':
                        echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->kondisi_barang.'</span>';
                        break;
                      case 'Not Good':
                        echo '<span class="bg-info-focus text-info-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->kondisi_barang.'</span>';
                        break;
                      case 'Maintenance':
                        echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->kondisi_barang.'</span>';
                        break;
                    } ?>
                  </td>
                  <td><?php echo $brg->nama_ruangan.' '.$brg->nama_penyimpanan.' '.$brg->keterangan_penyimpanan; ?></td>
                  <td class="center">
                    <?php 
                    switch ($brg->ketersediaan_barang) {
                      case 'Available':
                        echo '<span class="bg-info-focus text-info-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                      case 'Booked':
                        echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                      case 'Borrowed':
                        echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">'.$brg->ketersediaan_barang.'</span>';
                        break;
                    } ?>
                  </td>
                  <td class="center">
                    <div style="gap: 10px; white-space: nowrap;">
                      <button href="javascript:void(0)" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editbtn">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                      </button>
                      <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center btndelete" data-id="<?=$brg->id_barang ?>">
                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                      </button>
                    </div>
                  </td>
                  <td ><?= $brg->id_barang ?></td>
                  <td ><?= $brg->nama_barang ?></td>
                  <td ><?= $brg->tipe_barang ?></td>
                  <td ><?= $brg->kategori_barang ?></td>
                  <td ><?= $brg->kondisi_barang ?></td>
                  <td ><?= $brg->gambar_barang ?></td>
                  <td  ><?= $brg->id_penyimpanan ?></td>
                  <td  ><?= $brg->id_ruangan ?></td>
                </tr>
              <?php endforeach; ?>