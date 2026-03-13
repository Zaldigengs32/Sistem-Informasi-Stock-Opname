<?php
$this->load->view('UI/KoordinatorUPT/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Stock Opname Detail</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="<?= base_url('Functions/DashboardKoorUPT') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">
        <a href="<?= base_url('Functions/StockOpnameKoorUPT') ?>" class="hover-text-primary">Stock Opname</a>
      </li>
      <li>-</li>
      <li class="fw-medium">Detail</li>
    </ul>
  </div>
  <!-- END HEADER -->

  <!-- Stock Opname Detail Card -->
  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Stock Opname Detail</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <?php if ($session->so_status == 'Approved'): ?>
          <button class="btn btn-success btn-md text-white me-2" onclick="exportToExcel()">
            <i class="fa fa-file-excel mr-1"></i> Export Excel
          </button>
          <button class="btn btn-danger btn-md text-white me-2" onclick="exportToPDF()">
            <i class="fa fa-file-pdf mr-1"></i> Export PDF
          </button>
          <?php endif; ?>
          <a href="<?= base_url('Functions/StockOpnameKoorUPT') ?>" class="btn btn-secondary btn-md text-white">
            <i class="fa fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="row mt-3 gx-2">
        <div class="col">
          <label class="form-label small text-muted mb-1">No. Stock Opname</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_id_opname ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Start Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= (new DateTime($session->so_start_date))->format('d/m/Y') ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">End Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_end_date ? (new DateTime($session->so_end_date))->format('d/m/Y') : '-' ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">PIC</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->nama_pengguna ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Status</label>
          <input type="text" class="form-control form-control-sm" value="<?= $session->so_status ?>" readonly>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-12">
          <label class="form-label small text-muted mb-1">Description</label>
          <input type="text" class="form-control form-control-sm" value="<?= !empty($session->so_deskripsi) ? $session->so_deskripsi : '-' ?>" readonly>
        </div>
      </div>
      
      <?php if ($session->so_status == 'Rejected' && !empty($session->so_reject_reason)): ?>
      <div class="row mt-3">
        <div class="col-12">
          <div class="alert alert-danger mb-0">
            <div class="d-flex align-items-start">
              <i class="fa fa-times-circle me-2 mt-1" style="color: #EF4444;"></i>
              <div>
                <strong>Rejection Reason:</strong><br>
                <?= $session->so_reject_reason ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableDetail" class="table" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Item Name</th>
              <th style="text-align: center;">Lab</th>
              <th style="text-align: center;">Storage</th>
              <th style="text-align: center;">Qty</th>
              <th style="text-align: center;">Condition</th>
              <th style="text-align: center;">Description</th>
              <th style="text-align: center;">Photo</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($items as $item): ?>
              <tr>
                <td style="text-align: right;"><?= $no++; ?></td>
                <td>
                  <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                      <?php if (!empty($item->gambar_barang) && strpos($item->gambar_barang, '.') !== false): ?>
                        <img src="<?= base_url(); ?>assets/foto/barang/<?= $item->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)" onerror="this.style.display='none'">
                      <?php else: ?>
                        <iconify-icon icon="mdi:image-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                      <?php endif; ?>
                    </div>
                    <div>
                      <div class="fw-medium text-dark"><?= $item->nama_barang ?></div>
                      <span class="text-muted small"><?= $item->nomor_aktiva ?></span>
                    </div>
                  </div>
                </td>
                <td style="text-align: center;"><?= $item->nama_ruangan ?></td>
                <td style="text-align: center;"><?= $item->nama_penyimpanan ?></td>
                <td style="text-align: center;"><?= $item->so_quantity ?></td>
                <td style="text-align: center;">
                  <?php switch ($item->kondisi_barang) {
                    case 'Good':
                      echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">Good</span>';
                      break;
                    case 'Not Good':
                      echo '<span class="px-20 py-4 rounded-pill fw-medium text-sm" style="background-color: #FEF9C3; color: #CA8A04; white-space: nowrap;">Not Good</span>';
                      break;
                    case 'Minor Damaged':
                      echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">Minor Damaged</span>';
                      break;
                    case 'Major Damaged':
                      echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">Major Damaged</span>';
                      break;
                    default:
                      echo '<span class="bg-secondary-focus text-secondary-main px-20 py-4 rounded-pill fw-medium text-sm">'.$item->kondisi_barang.'</span>';
                  } ?>
                </td>
                <td style="text-align: center;"><?= !empty($item->keterangan_tambahan) ? $item->keterangan_tambahan : '-' ?></td>
                <td style="text-align: center;">
                  <?php if (!empty($item->foto_barang)): ?>
                    <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; cursor: pointer;" onclick="showImageModal('<?= base_url('assets/foto/stockopname/' . $item->foto_barang) ?>')">
                      <img src="<?= base_url('assets/foto/stockopname/' . $item->foto_barang) ?>" alt="Photo" style="max-width: 100%; max-height: 100%; border-radius: 4px;" onerror="this.parentElement.innerHTML='<iconify-icon icon=\'mdi:camera-off\' style=\'font-size: 24px; color: #ccc;\'></iconify-icon>'">
                    </div>
                  <?php else: ?>
                    <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                      <iconify-icon icon="mdi:camera-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                    </div>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <?php if ($session->so_status == 'On Progress Approval Koor UPT'): ?>
      <!-- Approval/Rejection Button Section -->
      <div class="mt-3 d-flex justify-content-end gap-2">
        <button type="button" id="btnReject" class="btn btn-danger" data-id="<?= $session->so_id_opname ?>">
          Reject
        </button>
        <button type="button" id="btnApprove" class="btn btn-success" data-id="<?= $session->so_id_opname ?>">
          Approve
        </button>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Modal Zoom Image -->
  <div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center p-0">
          <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
        </div>
      </div>
    </div>
  </div>
</div> <!-- End dashboard-main-body -->

<?php
$this->load->view('Footer');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script src="<?= base_url('assets/js/barlow-font.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script type="text/javascript">
function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  var modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}

async function exportToPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF('p', 'mm', 'a4');
  const pageWidth = doc.internal.pageSize.getWidth();
  const pageHeight = doc.internal.pageSize.getHeight();
  
  // Load Barlow font
  let fontFamily = 'helvetica';
  if (typeof loadBarlowFont === 'function') {
    const fontLoaded = await loadBarlowFont(doc);
    if (fontLoaded) fontFamily = 'Barlow';
  }
  
  // Helper function untuk format tanggal Indonesia
  function formatTanggalIndonesia(dateStr) {
    const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const date = new Date(dateStr);
    const day = date.getDate().toString().padStart(2, '0');
    const month = bulanIndo[date.getMonth()];
    const year = date.getFullYear();
    return day + ' ' + month + ' ' + year;
  }
  
  const logoImg = new Image();
  logoImg.src = '<?= base_url("assets/foto/fasilitas/LogoAstratech.png") ?>';
  
  logoImg.onload = function() {
    const margin = 20;
    const contentWidth = pageWidth - (margin * 2);
    
    // Logo - di kiri atas, ukuran diperkecil
    const logoHeight = 12;
    const logoWidth = (logoImg.width / logoImg.height) * logoHeight;
    doc.addImage(logoImg, 'PNG', margin, 12, logoWidth, logoHeight);
    
    // Title dengan underline
    let yPos = 40; // Increased from 35 to 40 for more space
    doc.setFontSize(14);
    doc.setFont(fontFamily, 'bold');
    
    // Judul dengan deskripsi di samping (format: STOCK OPNAME ASSET - DESKRIPSI)
    const title1 = 'STOCK OPNAME ASSET';
    const title2 = '<?= strtoupper(addslashes($session->so_deskripsi ?: "")) ?>';
    const fullTitle = title2 ? title1 + ' - ' + title2 : title1 + ' - -';
    
    doc.text(fullTitle, pageWidth / 2, yPos, { align: 'center' });
    const fullTitleWidth = doc.getTextWidth(fullTitle);
    doc.setLineWidth(0.5);
    doc.line((pageWidth - fullTitleWidth) / 2, yPos + 1, (pageWidth + fullTitleWidth) / 2, yPos + 1);
    
    // Nomor dokumen
    yPos += 6; // Reduced from 8
    doc.setFontSize(11);
    doc.setFont(fontFamily, 'normal');
    <?php 
    $doc_number = $this->StockOpnameModel->getDocumentNumber($session->so_id_opname);
    ?>
    doc.text('No: <?= $doc_number ?>', pageWidth / 2, yPos, { align: 'center' });
    
    // Paragraf pembuka - dengan "di UPT Informatika"
    yPos += 10; // Reduced from 12
    const startDate = formatTanggalIndonesia('<?= $session->so_start_date ?>');
    const endDate = <?= $session->so_end_date ? "formatTanggalIndonesia('" . $session->so_end_date . "')" : "'-'" ?>;
    
    doc.setFontSize(11);
    const paragraf = 'Pada tanggal ' + startDate + ' hingga ' + endDate + ' telah dilakukan Stock Opname Asset di UPT Informatika, dengan rincian sebagai berikut:';
    const splitParagraf = doc.splitTextToSize(paragraf, contentWidth);
    doc.text(splitParagraf, margin, yPos);
    yPos += splitParagraf.length * 5 + 5;
    
    // Tim Stock Opname
    doc.setFont(fontFamily, 'bold');
    doc.text('Tim Stock Opname:', margin, yPos);
    doc.setFont(fontFamily, 'normal');
    
    // Kontributor list
    const col1X = margin + 8;
    const col2X = margin + 55;
    
    // PIC Stock Opname (tetap Roni Prasetyo)
    yPos += 8;
    doc.text('1.', col1X, yPos);
    doc.text('PIC Stock Opname', col1X + 5, yPos);
    doc.text(': Roni Prasetyo', col2X, yPos);
    
    // Anggota - semua dalam satu nomor dengan multiple baris
    <?php 
    $contributorList = isset($contributors) ? $contributors : [];
    if (!empty($contributorList)): 
    ?>
    yPos += 8;
    doc.text('2.', col1X, yPos);
    doc.text('Anggota', col1X + 5, yPos);
    <?php 
      $isFirst = true;
      foreach ($contributorList as $contributor): 
    ?>
    <?php if ($isFirst): ?>
    doc.text(': <?= addslashes($contributor->nama_pengguna) ?>', col2X, yPos);
    <?php $isFirst = false; ?>
    <?php else: ?>
    yPos += 6;
    doc.text(': <?= addslashes($contributor->nama_pengguna) ?>', col2X, yPos);
    <?php endif; ?>
    <?php 
      endforeach;
    endif; 
    ?>
    
    // Data Stock Opname
    yPos += 10;
    doc.setFont(fontFamily, 'bold');
    doc.text('Data Stock Opname:', margin, yPos);
    doc.setFont(fontFamily, 'normal');
    
    yPos += 7;
    doc.text('1.', col1X, yPos);
    const lampiranText = 'Lampiran 1 Data <?= addslashes($session->so_deskripsi ?: "") ?>';
    doc.text(lampiranText, col1X + 5, yPos);
    
    // Catatan dengan border box - Summary dari item
    yPos += 10;
    doc.setFont(fontFamily, 'bold');
    doc.text('Catatan:', margin, yPos);
    doc.setFont(fontFamily, 'normal');
    
    // Generate summary dari items
    <?php 
    // Hitung summary berdasarkan quantity dan kondisi
    $qtyZero = 0;
    $kondisiGood = 0;
    $kondisiNotGood = 0;
    $kondisiMinor = 0;
    $kondisiMajor = 0;
    $totalItems = count($items);
    
    foreach ($items as $item) {
      if ($item->so_quantity == 0) {
        $qtyZero++;
      }
      switch ($item->kondisi_barang) {
        case 'Good':
          $kondisiGood++;
          break;
        case 'Not Good':
          $kondisiNotGood++;
          break;
        case 'Minor Damaged':
          $kondisiMinor++;
          break;
        case 'Major Damaged':
          $kondisiMajor++;
          break;
      }
    }
    ?>
    
    // Draw box untuk catatan
    yPos += 3;
    const boxStartY = yPos;
    const boxPadding = 4;
    let catatanY = yPos + boxPadding + 3;
    
    // Summary catatan tanpa nama item
    <?php if ($totalItems == 0): ?>
    doc.text('- Tidak ada item', margin + boxPadding + 5, catatanY);
    const boxHeight = 15;
    <?php else: ?>
    <?php if ($qtyZero > 0): ?>
    doc.text('- <?= $qtyZero ?> Item 0 Kuantitasnya', margin + boxPadding + 5, catatanY);
    catatanY += 5;
    <?php endif; ?>
    <?php if ($kondisiGood > 0): ?>
    doc.text('- <?= $kondisiGood ?> Item Good', margin + boxPadding + 5, catatanY);
    catatanY += 5;
    <?php endif; ?>
    <?php if ($kondisiNotGood > 0): ?>
    doc.text('- <?= $kondisiNotGood ?> Item Not Good', margin + boxPadding + 5, catatanY);
    catatanY += 5;
    <?php endif; ?>
    <?php if ($kondisiMinor > 0): ?>
    doc.text('- <?= $kondisiMinor ?> Item Minor Damaged', margin + boxPadding + 5, catatanY);
    catatanY += 5;
    <?php endif; ?>
    <?php if ($kondisiMajor > 0): ?>
    doc.text('- <?= $kondisiMajor ?> Item Major Damaged', margin + boxPadding + 5, catatanY);
    catatanY += 5;
    <?php endif; ?>
    const boxHeight = catatanY - boxStartY + boxPadding;
    <?php endif; ?>
    
    // Draw border box
    doc.setDrawColor(0, 0, 0);
    doc.setLineWidth(0.3);
    doc.rect(margin + 3, boxStartY, contentWidth - 6, boxHeight);
    
    yPos = boxStartY + boxHeight + 10;
    
    // Check page break
    if (yPos > pageHeight - 85) {
      doc.addPage();
      doc.addImage(logoImg, 'PNG', margin, 12, logoWidth, logoHeight);
      yPos = 40; // Increased for more space after logo
    }
    
    // Closing text
    const closingText = 'Demikian Dokumen Stock Opname ini dibuat, untuk kemudian dapat diproses sebagaimana mestinya.';
    const splitClosing = doc.splitTextToSize(closingText, contentWidth);
    doc.text(splitClosing, margin, yPos);
    yPos += splitClosing.length * 5 + 15;
    
    // Check page break for signatures
    if (yPos + 60 > pageHeight - 10) {
      doc.addPage();
      doc.addImage(logoImg, 'PNG', margin, 12, logoWidth, logoHeight);
      yPos = 40; // Increased for more space after logo
    }
    
    // Signatures - 2 kolom
    const leftX = pageWidth / 4;
    const rightX = (pageWidth / 4) * 3;
    
    doc.setFont(fontFamily, 'bold');
    doc.text('Yang Menyerahkan', leftX, yPos, { align: 'center' });
    doc.text('Yang Menerima', rightX, yPos, { align: 'center' });
    
    doc.setFont(fontFamily, 'normal');
    doc.text('Pihak Pertama', leftX, yPos + 7, { align: 'center' });
    doc.text('Pihak Kedua', rightX, yPos + 7, { align: 'center' });
    
    // Garis tanda tangan
    yPos += 35;
    doc.text('(........................................)', leftX, yPos, { align: 'center' });
    doc.text('(........................................)', rightX, yPos, { align: 'center' });
    
    // Nama dan jabatan
    doc.setFont(fontFamily, 'bold');
    doc.text('<?= addslashes($session->nama_pengguna) ?>', leftX, yPos + 6, { align: 'center' });
    doc.text('<?= isset($koor_upt_name) && !empty($koor_upt_name) ? addslashes($koor_upt_name) : "" ?>', rightX, yPos + 6, { align: 'center' });
    
    doc.setFont(fontFamily, 'normal');
    doc.text('PIC Asset UPT Informatika', leftX, yPos + 12, { align: 'center' });
    doc.text('Kepala UPT Informatika', rightX, yPos + 12, { align: 'center' });
    
    // ========== PAGE 2: Table Data ==========
    doc.addPage();
    
    // Header for page 2 - logo di kiri
    doc.addImage(logoImg, 'PNG', margin, 12, logoWidth, logoHeight);
    
    // Lampiran header
    let tableYPos = 40; // Increased for more space after logo
    doc.setFontSize(14);
    doc.setFont(fontFamily, 'bold');
    
    // LAMPIRAN 1 - centered with underline
    const lampiran1Text = 'LAMPIRAN 1';
    doc.text(lampiran1Text, pageWidth / 2, tableYPos, { align: 'center' });
    const lampiran1Width = doc.getTextWidth(lampiran1Text);
    doc.setLineWidth(0.5);
    doc.line((pageWidth - lampiran1Width) / 2, tableYPos + 1, (pageWidth + lampiran1Width) / 2, tableYPos + 1);
    
    // DATA + deskripsi session - centered with underline
    tableYPos += 7;
    const lampiran2Text = 'DATA <?= strtoupper(addslashes($session->so_deskripsi ?: "")) ?>';
    doc.text(lampiran2Text, pageWidth / 2, tableYPos, { align: 'center' });
    const lampiran2Width = doc.getTextWidth(lampiran2Text);
    doc.line((pageWidth - lampiran2Width) / 2, tableYPos + 1, (pageWidth + lampiran2Width) / 2, tableYPos + 1);
    
    tableYPos += 10;
    
    // Table header
    const tableData = [
      <?php $no = 1; foreach ($items as $item): ?>
      ['<?= $no++ ?>', '<?= addslashes($item->nama_barang) ?>', '<?= $item->nomor_aktiva ?>', '<?= addslashes($item->nama_ruangan) ?> - <?= addslashes($item->nama_penyimpanan ?: '-') ?>', '<?= $item->so_quantity ?>', '<?= $item->kondisi_barang ?>', '<?= addslashes($item->keterangan_tambahan ?: '-') ?>'],
      <?php endforeach; ?>
    ];
    
    doc.autoTable({
      startY: tableYPos,
      head: [['No', 'Nama Barang', 'Nomor Asset', 'Ruangan', 'Qty', 'Kondisi', 'Keterangan']],
      body: tableData,
      theme: 'grid',
      headStyles: { 
        fillColor: [255, 255, 255], 
        textColor: [0, 0, 0], 
        fontStyle: 'bold', 
        halign: 'center',
        fontSize: 9
      },
      bodyStyles: { 
        textColor: [0, 0, 0], 
        fontSize: 8,
        halign: 'center',
        overflow: 'linebreak'
      },
      columnStyles: { 
        0: { cellWidth: 10, halign: 'center' }, 
        1: { cellWidth: 50, halign: 'left' }, 
        2: { cellWidth: 22, halign: 'center' }, 
        3: { cellWidth: 28, halign: 'center' }, 
        4: { cellWidth: 15, halign: 'center' }, 
        5: { cellWidth: 20, halign: 'center' },
        6: { cellWidth: 40, halign: 'left', overflow: 'linebreak' }
      },
      margin: { left: (pageWidth - 185) / 2, right: (pageWidth - 185) / 2, top: 30 },
      styles: { 
        cellPadding: 2,
        overflow: 'linebreak',
        cellWidth: 'wrap',
        lineColor: [0, 0, 0],
        lineWidth: 0.3
      },
      didDrawPage: function(data) {
        // Add logo di kiri on each new page (skip first table page since we already added it)
        if (data.pageNumber > 1) {
          doc.addImage(logoImg, 'PNG', margin, 12, logoWidth, logoHeight);
        }
      }
    });
    
    // Footer
    const footerY = pageHeight - 15;
    doc.setFontSize(11);
    doc.setFont(fontFamily, 'italic');
    doc.setTextColor(100, 100, 100);
    doc.text('Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Asset', pageWidth / 2, footerY, { align: 'center' });
    doc.text('UPT Informatika - Politeknik Astra © <?= date("Y") ?>', pageWidth / 2, footerY + 5, { align: 'center' });
    
    doc.save('StockOpname_<?= $session->so_id_opname ?>.pdf');
  };
  
  logoImg.onerror = function() {
    Swal.fire('Error', 'Failed to load logo image', 'error');
  };
}

$(document).ready(function() {
  var tableData = $('#dataTableDetail').DataTable({
    "ordering": true,
    "deferRender": true,
    "pageLength": 25,
    "autoWidth": false,
    columnDefs: [
      { targets: 0, type: 'num', className: 'text-end' },
      { targets: 4, className: 'text-center' },
      { targets: 5, className: 'text-center' }
    ]
  });

  // Approve Button
  $('#btnApprove').on('click', function() {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to approve this stock opname?',
      text: "You can't undo this action!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Yes, Approve'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/approveStockOpnameKoorUPT') ?>",
          method: "post",
          data: { so_id_opname: id },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Succeed!',
                text: 'Stock opname approved successfully!',
                icon: 'success'
              }).then(okay => {
                if (okay) {
                  location.reload();
                }
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to approve.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to approve stock opname.', 'error');
          }
        });
      }
    });
  });

  // Reject Button
  $('#btnReject').on('click', function() {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Reject',
      html: '<p>Are you sure you want to reject this stock opname?</p>',
      input: 'textarea',
      inputLabel: 'Rejection Reason',
      inputPlaceholder: 'Enter the reason for rejection...',
      inputAttributes: {
        'aria-label': 'Enter the reason for rejection'
      },
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Reject',
      cancelButtonText: 'Cancel',
      didOpen: () => {
        // Add red asterisk to label
        const label = document.querySelector('.swal2-input-label');
        if (label) {
          label.innerHTML = 'Rejection Reason <span style="color: #EF4444; margin-left: 2px;">*</span>';
        }
      },
      inputValidator: (value) => {
        if (!value) return 'Rejection reason is required!';
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/rejectStockOpnameKoorUPT') ?>",
          method: "post",
          data: {
            so_id_opname: id,
            reject_reason: result.value
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Rejected!',
                text: 'Stock opname has been rejected.',
                icon: 'success'
              }).then(okay => {
                if (okay) {
                  location.reload();
                }
              });
            } else {
              Swal.fire('Error!', response.message || 'Failed to reject.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to reject stock opname.', 'error');
          }
        });
      }
    });
  });
});
</script>


<script type="text/javascript">
function exportToExcel() {
  // Check if XLSX library is loaded
  if (typeof XLSX === 'undefined') {
    Swal.fire('Error', 'Excel library is still loading. Please try again in a moment.', 'error');
    return;
  }

  // Create workbook
  const wb = XLSX.utils.book_new();

  // Prepare header data
  const title1 = 'STOCK OPNAME ASSET';
  const title2 = '<?= strtoupper(addslashes($session->so_deskripsi ?: "")) ?>';
  const fullTitle = title2 ? title1 + ' - ' + title2 : title1 + ' - -';
  
  const headerData = [
    [fullTitle],
    ['No: <?= $doc_number ?>'],
    [],
    []
  ];

  // Prepare table data with headers
  const tableData = [
    ['No', 'Nama Barang', 'Nomor Asset', 'Ruangan', 'Qty', 'Kondisi', 'Keterangan']
  ];

  <?php 
  $no = 1;
  foreach ($items as $item): 
  ?>
  tableData.push([
    <?= $no++ ?>,
    '<?= addslashes($item->nama_barang) ?>',
    '<?= $item->nomor_aktiva ?>',
    '<?= addslashes($item->nama_ruangan) ?> - <?= addslashes($item->nama_penyimpanan ?: '-') ?>',
    <?= $item->so_quantity ?>,
    '<?= $item->kondisi_barang ?>',
    '<?= addslashes($item->keterangan_tambahan ?: '-') ?>'
  ]);
  <?php endforeach; ?>

  // Combine header and table data
  const allData = headerData.concat(tableData);
  
  const ws = XLSX.utils.aoa_to_sheet(allData);
  
  // Set column widths
  ws['!cols'] = [
    { wch: 5 },   // No
    { wch: 47 },  // Nama Barang
    { wch: 13 },  // Nomor Asset
    { wch: 23 },  // Ruangan
    { wch: 8 },   // Qty
    { wch: 15 },  // Kondisi
    { wch: 30 }   // Keterangan
  ];

  // Merge cells for title rows
  ws['!merges'] = [
    { s: { r: 0, c: 0 }, e: { r: 0, c: 6 } }, // Title 1
    { s: { r: 1, c: 0 }, e: { r: 1, c: 6 } }, // Title 2
    { s: { r: 2, c: 0 }, e: { r: 2, c: 6 } }  // No
  ];

  // Apply styles
  const range = XLSX.utils.decode_range(ws['!ref']);
  
  for (let R = range.s.r; R <= range.e.r; ++R) {
    for (let C = range.s.c; C <= range.e.c; ++C) {
      const cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
      if (!ws[cellAddress]) continue;
      
      // Initialize cell style
      if (!ws[cellAddress].s) ws[cellAddress].s = {};
      
      // Font Arial for all cells
      ws[cellAddress].s.font = { name: 'Arial' };
      
      // Title rows (0, 1, 2) - Bold, Center, Middle
      if (R <= 2) {
        ws[cellAddress].s.font = { name: 'Arial', bold: true };
        ws[cellAddress].s.alignment = { horizontal: 'center', vertical: 'center' };
      }
      
      // Header row (4) - Bold, Center, Gray background
      if (R === 4) {
        ws[cellAddress].s.font = { name: 'Arial', bold: true };
        ws[cellAddress].s.alignment = { horizontal: 'center', vertical: 'center' };
        ws[cellAddress].s.fill = { fgColor: { rgb: 'D3D3D3' } };
      }
      
      // Data rows (5+) - Left align
      if (R > 4) {
        ws[cellAddress].s.alignment = { horizontal: 'left', vertical: 'center' };
      }
    }
  }

  // Apply AutoFilter to table (starting from row 5, which is index 4)
  const dataRange = XLSX.utils.decode_range(ws['!ref']);
  ws['!autofilter'] = { ref: XLSX.utils.encode_range({
    s: { r: 4, c: 0 },
    e: { r: dataRange.e.r, c: 6 }
  })};

  XLSX.utils.book_append_sheet(wb, ws, 'Stock Opname');

  // Generate filename
  const filename = 'StockOpname_<?= $session->so_id_opname ?>.xlsx';
  
  // Save file
  XLSX.writeFile(wb, filename, { cellStyles: true });
}
</script>
