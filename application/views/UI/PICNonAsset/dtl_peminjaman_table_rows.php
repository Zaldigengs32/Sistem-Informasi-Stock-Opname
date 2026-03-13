<?php $no = 1; foreach ($dtl_peminjaman as $data): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td>
      <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <img src="<?= base_url(); ?>assets/foto/barang/<?= $data->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
        </div>
        <div>
          <div class="fw-medium text-dark text-wrap"><?= $data->nama_barang ?></div>
          <div class="d-flex align-items-center" style="gap: 6px; white-space: nowrap;">
            <?php switch ($data->kategori_barang) {
              case 'Asset':
                echo '<span class="badge fw-semibold rounded-pill bg-success-600 text-white">'.$data->kategori_barang.'</span>';
                break;
              case 'Non Asset':
                echo '<span class="badge fw-semibold rounded-pill bg-info-600 text-white">'.$data->kategori_barang.'</span>';
                break;
            } ?>
            <?php switch ($data->tipe_barang) {
              case 'Consummable':
                echo '<span class="badge fw-semibold rounded-pill bg-lilac-600 text-white">'.$data->tipe_barang.'</span>';
                break;
              case 'Non Consummable':
                echo '<span class="badge fw-semibold rounded-pill bg-pink-600 text-white">'.$data->tipe_barang.'</span>';
                break;
            } ?>
          </div>
        </div>
      </div>
    </td>
    <td style="text-align: center;"><?= $data->nomor_aktiva ?></td>
    <!-- <td class="center"></td> -->
    <td><?= $data->jumlah_peminjaman . ' ' . $data->satuan_barang ?></td>
    <td class="center">
      <?php switch ($data->kondisi_barang) {
        case 'Good':
          echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">'.$data->kondisi_barang.'</span>';
          break;
        case 'Not Good':
          echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">'.$data->kondisi_barang.'</span>';
          break;
        case 'Maintenance':
          echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">'.$data->kondisi_barang.'</span>';
          break;
      } ?>
    </td>
    <td><?= $data->gambar_sebelum==null? '-': '<img width="250px" src="'.base_url().'assets/foto/Peminjaman/before/'.$data->gambar_sebelum.'" alt="Produk" class="me-3" onclick="showImageModal(this.src)">' ?></td>
    <td><?= $data->gambar_sesudah==null? '-': '<img width="250px" src="'.base_url().'assets/foto/Peminjaman/after/'.$data->gambar_sesudah.'" alt="Produk" class="me-3" onclick="showImageModal(this.src)">' ?></td>
    <td>
      <?php  switch ($data->status_barang) {
          case 'On Progress Approval PIC Asset':
            echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$data->status_barang.'</span>';
            break;
          case 'On Progress Approval Koordinator UPT':
            echo '<span class="badge fw-semibold bg-lilac-600 text-white me-2">'.$data->status_barang.'</span>';
            break;
          case 'Approved':
            echo '<span class="badge fw-semibold bg-info-600 text-primary-600 me-2">'.$data->status_barang.'</span>';
            break;
          case 'Reject by PIC Asset dan Non Asset':
            echo '<span class="badge fw-semibold bg-danger-600 text-white-600 me-2">'.$data->status_barang.'</span>';
            break;
          case 'Reject by PIC Non Asset':
            echo '<span class="badge fw-semibold bg-danger-600 text-white-600 me-2">'.$data->status_barang.'</span>';
            break;
          case 'Reject by Koordinator UPT':
            echo '<span class="badge fw-semibold bg-danger-600 text-white-600 me-2">'.$data->status_barang.'</span>';
            break;
          case 'Borrowed':
            echo '<span class="badge fw-semibold bg-secondary-600 text-white me-2">'.$data->status_barang.'</span>';
            break;
          case 'Waiting for Return':
            echo '<span class="badge fw-semibold bg-primary-600 text-white me-2">'.$data->status_barang.'</span>';
            break;
          case 'Completed':
            echo '<span class="badge fw-semibold bg-success-600 text-white me-2">'.$data->status_barang.'</span>';
            break;
        } ?>
    </td>
    <td class="center">
      <div style="gap: 10px; white-space: nowrap;">
        <?php 
          if ($data->status_barang =='On Progress Approval PIC Non Asset'){ 
            echo '
            <button href="javascript:void(0)" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center accbtn" data-id="'.$data->id_dtl_peminjaman.'">
              <iconify-icon icon="lucide:check"></iconify-icon>
            </button>
            <button class="w-32-px h-32-px  bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center rejectbtn" data-id="'.$data->id_dtl_peminjaman.'">
              <iconify-icon icon="lucide:x"></iconify-icon>
            </button>
          '; 
          }  
        ?>
        <button class="w-32-px h-32-px  bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center infobtn" data-id="<?= $data->id_dtl_peminjaman?>">
          <iconify-icon icon="lucide:info"></iconify-icon>
        </button>
      </div>
      
    </td>
    <td ><?= $data->id_dtl_peminjaman ?></td>
  </tr>
<?php endforeach; ?>
