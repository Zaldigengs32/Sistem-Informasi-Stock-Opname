<?php
$this->load->view('UI/KoordinatorUPT/Header');
?>

<!-- HEADER -->
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Mutation Detail</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">
        <a href="<?= base_url('Functions/MutasiKoorUPT') ?>" class="hover-text-primary">Mutation</a>
      </li>
      <li>-</li>
      <li class="fw-medium">Detail</li>
    </ul>
  </div>
  <!-- END HEADER -->

  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Mutation Detail</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <?php if ($mutasi->status_mutasi === 'Approved'): ?>
          <button class="btn btn-success btn-md text-white me-2" onclick="exportToExcel()">
            <i class="fa fa-file-excel mr-1"></i> Export Excel
          </button>
          <button class="btn btn-danger btn-md text-white me-2" onclick="exportToPDF()">
            <i class="fa fa-file-pdf mr-1"></i> Export PDF
          </button>
          <?php endif; ?>
          <a href="<?= base_url('Functions/MutasiKoorUPT') ?>" class="btn btn-secondary btn-md text-white">
            <i class="fa fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <!-- Info section -->
      <div class="row mt-3 gx-2">
        <div class="col">
          <label class="form-label small text-muted mb-1">Origin Location</label>
          <input type="text" class="form-control form-control-sm" value="<?= $mutasi->lokasi_asal ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Destination Location</label>
          <input type="text" class="form-control form-control-sm" value="<?= $mutasi->lokasi_tujuan ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Mutation Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= (new DateTime($mutasi->tanggal_mutasi))->format('d/m/Y') ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Reason</label>
          <input type="text" class="form-control form-control-sm" value="<?= $mutasi->alasan_mutasi ?>" readonly>
        </div>
      </div>
      
      <?php if ($mutasi->status_mutasi === 'Rejected'): ?>
      <!-- Rejection Reason Section -->
      <div class="row mt-3">
        <div class="col-12">
          <div class="alert alert-danger mb-0">
            <div class="d-flex align-items-start">
              <i class="fa fa-times-circle me-2 mt-1" style="color: #EF4444;"></i>
              <div>
                <strong>Rejection Reason:</strong><br>
                <?php 
                  // Extract rejection reason from disetujui_oleh field (format: "Nama - Rejected: alasan")
                  $rejectionInfo = $mutasi->disetujui_oleh ?? '';
                  $rejectionReason = '';
                  if (strpos($rejectionInfo, 'Rejected:') !== false) {
                    $parts = explode('Rejected:', $rejectionInfo);
                    $rejectionReason = trim($parts[1] ?? '');
                  }
                ?>
                <?= $rejectionReason ?: 'No reason provided' ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableDetailMutasi" class="table" style="width:100%;">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Inventory</th>
              <th style="text-align: center;">Asset/Non Asset Number</th>
              <th style="text-align: center;">Quantity</th>
              <th style="text-align: center;">Condition</th>
              <th style="text-align: center;">Description</th>
              <th style="display: none;">ID</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($detail as $item): ?>
            <tr>
              <td style="text-align: right;"><?= $no++; ?></td>
              <td>
                <div class="d-flex align-items-center" style="gap: 10px; white-space: nowrap;">
                  <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <img src="<?= base_url(); ?>assets/foto/barang/<?= $item->gambar_barang ?>" alt="" style="max-width: 100%; max-height: 100%;" onclick="showImageModal(this.src)">
                  </div>
                  <div>
                    <div class="fw-medium text-dark"><?= $item->nama_barang ?></div>
                    <span class="badge fw-semibold rounded-pill bg-success-600 text-white"><?= $item->kategori_barang ?></span>
                    <span class="badge fw-semibold rounded-pill bg-pink-600 text-white"><?= $item->tipe_barang ?></span>
                  </div>
                </div>
              </td>
              <td style="text-align: right;"><?= $item->nomor_aktiva ?></td>
              <td style="text-align: right;"><?= $item->kuantitas ?></td>
              <td style="text-align: center;">
                <?php 
                $kondisi = $item->kondisi_barang ?: '-';
                switch ($kondisi) {
                  case 'Good':
                    echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">Good</span>';
                    break;
                  case 'Not Good':
                    echo '<span class="px-20 py-4 rounded-pill fw-medium text-sm" style="background-color: #FEF9C3; color: #CA8A04; white-space: nowrap;">Not Good</span>';
                    break;
                  case 'Minor Damage':
                    echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">Minor Damage</span>';
                    break;
                  case 'Major Damage':
                    echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">Major Damage</span>';
                    break;
                  default:
                    echo $kondisi;
                }
                ?>
              </td>
              <td style="text-align: center;"><?= $item->catatan ?: '-' ?></td>
              <td style="display: none;"><?= $item->id_dtl_mutasi ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <?php if ($mutasi->status_mutasi === 'On Progress Approval Koordinator UPT'): ?>
      <!-- Approval/Rejection Button Section -->
      <div class="mt-3 d-flex justify-content-end gap-2">
        <button type="button" id="btnReject" class="btn btn-danger" data-id="<?= $mutasi->id_mutasi ?>">
          Reject
        </button>
        <button type="button" id="btnApprove" class="btn btn-success" data-id="<?= $mutasi->id_mutasi ?>">
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
</div>

<?php $this->load->view('Footer'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script src="<?= base_url('assets/js/barlow-font.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script type="text/javascript">
function exportToExcel() {
  if (typeof XLSX === 'undefined') {
    alert('Excel library is still loading. Please try again in a moment.');
    return;
  }

  // Prepare header data
  const headerData = [
    ['PERSETUJUAN MUTASI AKTIVA TETAP'],
    [],
    []
  ];

  // Prepare table data with headers
  const tableData = [
    ['No', 'Nomor Aktiva', 'Nama Asset', 'Dari Ruang', 'Ke Ruang', 'Kondisi']
  ];

  <?php $no = 1; foreach ($detail as $item): ?>
  tableData.push([
    <?= json_encode($no++) ?>,
    <?= json_encode($item->nomor_aktiva) ?>,
    <?= json_encode($item->nama_barang) ?>,
    <?= json_encode($mutasi->lokasi_asal) ?>,
    <?= json_encode($mutasi->lokasi_tujuan) ?>,
    <?= json_encode($item->kondisi_barang ?: "Good") ?>
  ]);
  <?php endforeach; ?>

  // Combine header and table data
  const allData = headerData.concat(tableData);
  
  const ws = XLSX.utils.aoa_to_sheet(allData);
  
  // Set column widths
  ws['!cols'] = [
    { wch: 5 },  // No
    { wch: 20 }, // Nomor Aktiva
    { wch: 47 }, // Nama Asset
    { wch: 25 }, // Dari Ruang
    { wch: 25 }, // Ke Ruang
    { wch: 15 }  // Kondisi
  ];

  // Merge cells for title
  ws['!merges'] = [
    { s: { r: 0, c: 0 }, e: { r: 0, c: 5 } } // Title
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
      
      // Title row (0) - Bold, Center, Middle
      if (R === 0) {
        ws[cellAddress].s.font = { name: 'Arial', bold: true };
        ws[cellAddress].s.alignment = { horizontal: 'center', vertical: 'center' };
      }
      
      // Header row (3) - Bold, Center, Gray background
      if (R === 3) {
        ws[cellAddress].s.font = { name: 'Arial', bold: true };
        ws[cellAddress].s.alignment = { horizontal: 'center', vertical: 'center' };
        ws[cellAddress].s.fill = { fgColor: { rgb: 'D3D3D3' } };
      }
      
      // Data rows (4+) - Left align
      if (R > 3) {
        ws[cellAddress].s.alignment = { horizontal: 'left', vertical: 'center' };
      }
    }
  }

  // Apply AutoFilter to table (starting from row 4, which is index 3)
  const dataRange = XLSX.utils.decode_range(ws['!ref']);
  ws['!autofilter'] = { ref: XLSX.utils.encode_range({
    s: { r: 3, c: 0 },
    e: { r: dataRange.e.r, c: 5 }
  })};

  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Mutasi');
  XLSX.writeFile(wb, 'Mutasi_<?= $mutasi->id_mutasi ?>.xlsx', { cellStyles: true });
}

async function exportToPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF('p', 'mm', 'a4');
  const pageWidth = doc.internal.pageSize.getWidth();
  const pageHeight = doc.internal.pageSize.getHeight();
  
  // Load Barlow font
  const fontFamily = await initPDFWithBarlow(doc);
  
  const logoImg = new Image();
  logoImg.src = '<?= base_url("assets/foto/fasilitas/LogoAstratech.png") ?>';
  
  logoImg.onload = function() {
    // Aligments
    const alignmentWidth = 188; 
    const alignmentMargin = (pageWidth - alignmentWidth) / 2;
    
    // Logo (di kiri atas)
    const logoHeight = 15;
    const logoWidth = (logoImg.width / logoImg.height) * logoHeight;
    doc.addImage(logoImg, 'PNG', alignmentMargin, 15, logoWidth, logoHeight);
    
    // Nomor & Tanggal (kanan atas, sejajar logo)
    doc.setFontSize(10);
    doc.setFont(fontFamily, 'normal');
    const labelX = alignmentMargin + alignmentWidth - 55;
    const colonX = labelX + 18;
    const endX = alignmentMargin + alignmentWidth;

    doc.text('Nomor', labelX, 18);
    doc.text(':', colonX, 18);
    const dotCount = Math.floor((endX - (colonX + 3)) / 1.2);
    doc.text('.'.repeat(dotCount), colonX + 3, 18);
    
    // Tanggal otomatis hari ini
    const today = new Date();
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const todayFormatted = today.toLocaleDateString('id-ID', options);
    
    doc.text('Tanggal', labelX, 25);
    doc.text(': ' + todayFormatted, colonX, 25);
    
    // Title (di bawah logo)
    doc.setFontSize(16);
    doc.setFont(fontFamily, 'bold');
    doc.text('PERSETUJUAN MUTASI AKTIVA TETAP', pageWidth / 2, 45, { align: 'center' });
    
    doc.setFontSize(10);
    doc.setFont(fontFamily, 'normal');
    doc.text('Mohon agar Aktiva Tetap dengan data sebagai berikut dimutasikan :', alignmentMargin, 60);
    
    // Section DARI & KE
    doc.setDrawColor(0, 0, 0);
    doc.setLineWidth(0.5);
    
    doc.setFillColor(0, 0, 0);
    doc.rect(alignmentMargin, 65, alignmentWidth, 7, 'FD');
    doc.setFont(fontFamily, 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('DARI', pageWidth / 2, 70, { align: 'center' });
    doc.setTextColor(0, 0, 0);
    
    doc.setFont(fontFamily, 'normal');
    doc.rect(alignmentMargin, 72, alignmentWidth, 8, 'S');
    doc.text('UPT/DIR/Dept', alignmentMargin + 3, 77);
    doc.text(': <?= $mutasi->lokasi_asal ?>', alignmentMargin + 33, 77);
    
    doc.setFillColor(0, 0, 0);
    doc.rect(alignmentMargin, 80, alignmentWidth, 7, 'FD');
    doc.setFont(fontFamily, 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('KE', pageWidth / 2, 85, { align: 'center' });
    doc.setTextColor(0, 0, 0);
    
    doc.setFont(fontFamily, 'normal');
    doc.rect(alignmentMargin, 87, alignmentWidth, 8, 'S');
    doc.text('UPT/DIR/Dept', alignmentMargin + 3, 92);
    doc.text(': <?= $mutasi->lokasi_tujuan ?>', alignmentMargin + 33, 92);
    
    const tableData = [
      <?php $no = 1; foreach ($detail as $item): ?>
      ['<?= $no++ ?>', '<?= $item->nomor_aktiva ?>', '<?= addslashes($item->nama_barang) ?>', '<?= $mutasi->lokasi_asal ?>', '<?= $mutasi->lokasi_tujuan ?>', '<?= $item->kondisi_barang ?: "Good" ?>'],
      <?php endforeach; ?>
    ];
    
    doc.autoTable({
      startY: 99,
      head: [['NO', 'ASSET NO.', 'NAMA ASSET', 'Dari Ruang', 'Ke Ruang', 'KETERANGAN']],
      body: tableData,
      theme: 'grid',
      headStyles: { fillColor: [255, 255, 255], textColor: [0, 0, 0], fontStyle: 'bold', halign: 'center', lineWidth: 0.5, lineColor: [0, 0, 0], fontSize: 9 },
      bodyStyles: { textColor: [0, 0, 0], lineWidth: 0.5, lineColor: [0, 0, 0], halign: 'center' },
      columnStyles: { 0: { cellWidth: 12 }, 1: { cellWidth: 26 }, 2: { cellWidth: 55 }, 3: { cellWidth: 35 }, 4: { cellWidth: 35 }, 5: { cellWidth: 25 } },
      margin: { left: alignmentMargin },
      styles: { fontSize: 8, cellPadding: 3 }
    });
    
    // --- MODIFIKASI TANDA TANGAN (SIGNATURE) - 3 KOLOM ---
    let signatureY = doc.lastAutoTable.finalY + 30;
    
    // Check if signature section will fit on current page (need ~70mm for signature + footer)
    if (signatureY + 70 > pageHeight - 10) {
      doc.addPage();
      signatureY = 30; // Start from top of new page
    }
    
    const pageCenterX = pageWidth / 2;
    const colWidth = alignmentWidth / 3;
    const leftSignX = alignmentMargin + (colWidth / 2);
    const centerSignX = pageCenterX;
    const rightSignX = alignmentMargin + alignmentWidth - (colWidth / 2);
    
    // Posisi kiri sejajar dengan kurung tanda tangan
    const leftColTextX = leftSignX - 30;
    const centerColTextX = centerSignX - 30;
    const rightColTextX = rightSignX - 30;
    
    doc.setFontSize(10);
    doc.setFont(fontFamily, 'normal');
    
    // Kolom Kiri - Pengirim
    doc.text('Pengirim', leftSignX, signatureY, { align: 'center' });
    doc.text('(........................................)', leftSignX, signatureY + 30, { align: 'center' });
    doc.text('Nama :', leftColTextX, signatureY + 37);
    doc.text('Tanggal :', leftColTextX, signatureY + 44);
    
    // Kolom Tengah - Penerima
    doc.text('Penerima', centerSignX, signatureY, { align: 'center' });
    doc.text('(........................................)', centerSignX, signatureY + 30, { align: 'center' });
    doc.text('Nama :', centerColTextX, signatureY + 37);
    doc.text('Tanggal :', centerColTextX, signatureY + 44);
    
    // Kolom Kanan - General Affair
    doc.text('General Affair', rightSignX, signatureY, { align: 'center' });
    doc.text('(........................................)', rightSignX, signatureY + 30, { align: 'center' });
    doc.text('Nama :', rightColTextX, signatureY + 37);
    doc.text('Tanggal :', rightColTextX, signatureY + 44);
    doc.setFontSize(8);
    doc.text('*) nomor diisi oleh GA', rightSignX, signatureY + 52, { align: 'center' });
    
    // Kalimat Dicopi 2x
    doc.setFontSize(8);
    doc.setFont(fontFamily, 'normal');
    const copyText = 'Dicopi 2x, Distribusi: lembar asli --> GA, copy 1 --> Penerima Aktiva, copy 2 --> Pengirim Aktiva';
    doc.text(copyText, alignmentMargin, signatureY + 60);
    
    // Footer
    const footerY = doc.internal.pageSize.getHeight() - 25;
    doc.setDrawColor(180, 180, 180);
    doc.line(20, footerY, pageWidth - 20, footerY);
    doc.setFontSize(10);
    doc.setFont(fontFamily, 'italic');
    doc.setTextColor(100, 100, 100);
    doc.text('Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Asset', pageCenterX, footerY + 7, { align: 'center' });
    doc.text('UPT Informatika - Politeknik Astra © <?= date("Y") ?>', pageCenterX, footerY + 12, { align: 'center' });
    
    doc.save('Mutasi_<?= $mutasi->id_mutasi ?>.pdf');
  };
  
  logoImg.onerror = function() {
    // If logo fails to load, generate PDF without logo
    Swal.fire('Error', 'Failed to load logo image', 'error');
  };
}

function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  const imageModalEl = document.getElementById('imageModal');
  const modal = new bootstrap.Modal(imageModalEl);
  modal.show();
}

$(document).ready(function() {
  var table = $('#dataTableDetailMutasi').DataTable({
    "ordering": true,
    "deferRender": true,
    columnDefs: [
      { targets: 0, type: 'num' },
      {
        targets: [6],
        visible: false,
        searchable: false
      }
    ]
  });

  // Approve Button
  $('#btnApprove').on('click', function() {
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to approve this mutation?',
      text: "You can't undo this action!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#E5E7EB',
      confirmButtonText: 'Yes, Approve'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?php echo base_url('Functions/accMutasiKoorUPT') ?>",
          method: "post",
          data: { id_mutasi: id },
          success: function() {
            Swal.fire({
              title: 'Succeed!',
              text: 'Mutation approved successfully!',
              icon: 'success'
            }).then(okay => {
              if (okay) {
                location.reload();
              }
            });
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
      html: '<p>Are you sure you want to reject this mutation?</p>',
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
          url: "<?php echo base_url('Functions/rejectMutasiKoorUPT') ?>",
          method: "post",
          data: {
            id_mutasi: id,
            alasan: result.value
          },
          success: function() {
            Swal.fire({
              title: 'Rejected!',
              text: 'Mutation has been rejected.',
              icon: 'success'
            }).then(okay => {
              if (okay) {
                location.reload();
              }
            });
          }
        });
      }
    });
  });
});
</script>
