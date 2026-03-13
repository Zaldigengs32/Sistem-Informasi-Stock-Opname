<?php
$this->load->view('UI/PICAsset/Header');
?>

<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Dupat Detail</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
          <i class="ri-dashboard-line"></i>
          Dashboard
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">
        <a href="<?= base_url('Functions/DupatPICAsset') ?>" class="hover-text-primary">Dupat</a>
      </li>
      <li>-</li>
      <li class="fw-medium">Detail</li>
    </ul>
  </div>
  <div class="card">
    <div class="card-header">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="mb-0"><b>Dupat Detail</b></h6>
        </div>
        <div class="col-md-6 text-end">
          <?php if ($dupat->status_dupat === 'Draft'): ?>
          <a href="<?= base_url('Functions/AddItemDupatPage/' . $dupat->id_dupat) ?>" class="btn btn-primary btn-md text-white me-2">
            <i class="fa fa-plus mr-1"></i> Add Item
          </a>
          <?php endif; ?>
          <?php if ($dupat->status_dupat === 'Approved'): ?>
          <button class="btn btn-success btn-md text-white me-2" onclick="exportToExcel()">
            <i class="fa fa-file-excel mr-1"></i> Export Excel
          </button>
          <button class="btn btn-danger btn-md text-white me-2" onclick="exportToPDF()">
            <i class="fa fa-file-pdf mr-1"></i> Export PDF
          </button>
          <?php endif; ?>
          <a href="<?= base_url('Functions/DupatPICAsset') ?>" class="btn btn-secondary btn-md text-white">
            Back
          </a>
        </div>
      </div>
      <div class="row mt-3 gx-2">
        <div class="col">
          <label class="form-label small text-muted mb-1">No. DUPAT</label>
          <input type="text" class="form-control form-control-sm" value="<?= $dupat->id_dupat ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Date</label>
          <input type="text" class="form-control form-control-sm" value="<?= (new DateTime($dupat->tanggal_dupat))->format('d/m/Y') ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">PIC</label>
          <input type="text" class="form-control form-control-sm" value="<?= $dupat->nama_pengguna ?>" readonly>
        </div>
        <div class="col">
          <label class="form-label small text-muted mb-1">Status</label>
          <input type="text" class="form-control form-control-sm" value="<?= $dupat->status_dupat ?>" readonly>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-12">
          <label class="form-label small text-muted mb-1">Description</label>
          <input type="text" class="form-control form-control-sm" value="<?= $dupat->keterangan_dupat ?>" readonly>
        </div>
      </div>
      
      <?php if ($dupat->status_dupat === 'Rejected'): ?>
      <div class="row mt-3">
        <div class="col-12">
          <div class="alert alert-danger mb-0">
            <div class="d-flex align-items-start">
              <i class="fa fa-times-circle me-2 mt-1" style="color: #EF4444;"></i>
              <div>
                <strong>Rejection Reason:</strong><br>
                <?= $dupat->alasan_penolakan ?: 'No reason provided' ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTableDetailDupat" class="table" style="width:100%;">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th style="text-align: center;">Inventory</th>
              <th style="text-align: center;">Asset / Non Asset Number</th>
              <th style="text-align: center;">Quantity</th>
              <th style="text-align: center;">Condition</th>
              <th style="text-align: center;">Proposal</th>
              <th style="text-align: center;">Description</th>
              <th style="text-align: center;">Condition Photo</th>
              <?php if ($dupat->status_dupat === 'Draft'): ?>
              <th style="text-align: center;">Action</th>
              <?php endif; ?>
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
              <td style="text-align: right;">1</td>
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
              <td style="text-align: center;">
                <?php 
                  $proposal = $item->usulan_pengeluaran ?: 'Deleted';
                  // Handle both English and Indonesian values (for legacy data)
                  switch ($proposal) {
                    case 'Sold':
                    case 'Dijual':
                    case 'Dijual kpd pihak ketiga':
                      echo '<span class="bg-info-focus text-info-main px-20 py-4 rounded-pill fw-medium text-sm">Sold</span>';
                      break;
                    case 'Auction':
                    case 'Lelang':
                      echo '<span class="bg-warning-focus text-warning-main px-20 py-4 rounded-pill fw-medium text-sm">Auction</span>';
                      break;
                    case 'Deleted':
                    case 'Dihapus':
                      echo '<span class="bg-danger-focus text-danger-main px-20 py-4 rounded-pill fw-medium text-sm">Deleted</span>';
                      break;
                    case 'Donated':
                    case 'Hibah':
                      echo '<span class="bg-success-focus text-success-main px-20 py-4 rounded-pill fw-medium text-sm">Donated</span>';
                      break;
                    default:
                      echo '<span class="bg-secondary-focus text-secondary-main px-20 py-4 rounded-pill fw-medium text-sm">' . $proposal . '</span>';
                  }
                ?>
              </td>
              <td style="text-align: center;"><?= $item->keterangan ?: '-' ?></td>
              <td style="text-align: center;">
                <?php if (!empty($item->foto_barang)): ?>
                  <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px; cursor: pointer;" onclick="showImageModal('<?= base_url('assets/foto/dupat/' . $item->foto_barang) ?>')">
                    <img src="<?= base_url('assets/foto/dupat/' . $item->foto_barang) ?>" alt="Photo" style="max-width: 100%; max-height: 100%; border-radius: 4px;" onerror="this.parentElement.innerHTML='<iconify-icon icon=\'mdi:camera-off\' style=\'font-size: 24px; color: #ccc;\'></iconify-icon>'">
                  </div>
                <?php else: ?>
                  <div class="rounded bg-light d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <iconify-icon icon="mdi:camera-off" style="font-size: 24px; color: #ccc;"></iconify-icon>
                  </div>
                <?php endif; ?>
              </td>
              <?php if ($dupat->status_dupat === 'Draft'): ?>
              <td style="text-align: center;">
                <button class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center editItembtn" 
                  data-id="<?= $item->id_dtl_dupat ?>" 
                  data-nama="<?= $item->nama_barang ?>"
                  data-nomor="<?= $item->nomor_aktiva ?>"
                  data-kondisi="<?= $item->kondisi_barang ?>" 
                  data-usulan="<?= $item->usulan_pengeluaran ?>"
                  data-keterangan="<?= $item->keterangan ?>" 
                  data-foto="<?= $item->foto_barang ?>"
                  title="Edit">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </button>
                <button class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center deleteItembtn" data-id="<?= $item->id_dtl_dupat ?>" title="Delete">
                  <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </button>
              </td>
              <?php endif; ?>
              <td style="display: none;"><?= $item->id_dtl_dupat ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center p-0">
          <img id="zoomedImage" src="" class="img-fluid" style="width: 100%; height: auto;" />
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Item Modal -->
  <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <form id="formEditItem" enctype="multipart/form-data">
        <input type="hidden" name="id_dtl_dupat" id="edit_id_dtl_dupat" />
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="card-title mb-0">Edit Item</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row gy-3">
              <div class="col-md-6">
                <label class="form-label">Inventory <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_nama_barang" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Asset / Non Asset Number <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="edit_nomor_aktiva" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Quantity <span style="color:red;">*</span></label>
                <input type="number" class="form-control" id="edit_quantity" value="1" readonly style="background-color: #e9ecef;" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Condition <span style="color:red;">*</span></label>
                <select class="form-select" name="kondisi_barang" id="edit_kondisi_barang" required>
                  <option value="Good">Good</option>
                  <option value="Not Good">Not Good</option>
                  <option value="Minor Damage">Minor Damage</option>
                  <option value="Major Damage">Major Damage</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Proposal <span style="color:red;">*</span></label>
                <select class="form-select" name="usulan_pengeluaran" id="edit_usulan_pengeluaran" required>
                  <option value="Sold">Sold</option>
                  <option value="Auction">Auction</option>
                  <option value="Deleted">Deleted</option>
                  <option value="Donated">Donated</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Description (optional)</label>
                <input type="text" class="form-control" name="keterangan" id="edit_keterangan" placeholder="Enter description" />
              </div>
              <div class="col-12">
                <label class="form-label">Upload Photo (optional)</label>
                <input type="file" class="form-control" name="foto_barang" id="edit_foto_barang" accept="image/*" />
                <div id="current_foto_preview" class="mt-2"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button style="width:150px" type="submit" class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">Save</button>
            <button style="width:150px" type="button" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
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

  // Translate proposal values to Indonesian
  function translateProposal(value) {
    const translations = {
      'Sold': 'Dijual kpd pihak ketiga',
      'Auction': 'Lelang',
      'Deleted': 'Dihapus',
      'Donated': 'Hibah'
    };
    return translations[value] || value;
  }

  // Prepare header data
  const headerData = [
    ['DAFTAR USULAN PENGELUARAN AKTIVA TETAP (DUPAT)'],
    [],
    []
  ];

  // Prepare table data with headers
  const tableData = [
    ['No', 'Deskripsi Aktiva Tetap', 'Nomor Aktiva Tetap', 'Kondisi', 'Usulan Pengeluaran', 'Alasan']
  ];

  <?php $no = 1; foreach ($detail as $item): ?>
  tableData.push([
    <?= json_encode($no++) ?>,
    <?= json_encode($item->nama_barang) ?>,
    <?= json_encode($item->nomor_aktiva) ?>,
    <?= json_encode($item->kondisi_barang ?: "Good") ?>,
    translateProposal(<?= json_encode($item->usulan_pengeluaran ?: "Deleted") ?>),
    <?= json_encode($item->keterangan ?: "-") ?>
  ]);
  <?php endforeach; ?>

  // Combine header and table data
  const allData = headerData.concat(tableData);
  
  const ws = XLSX.utils.aoa_to_sheet(allData);
  
  // Set column widths
  ws['!cols'] = [
    { wch: 5 },  // No
    { wch: 47 }, // Deskripsi
    { wch: 20 }, // Nomor Aktiva
    { wch: 15 }, // Kondisi
    { wch: 25 }, // Usulan
    { wch: 30 }  // Alasan
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
  XLSX.utils.book_append_sheet(wb, ws, 'Dupat');
  XLSX.writeFile(wb, 'Dupat_<?= $dupat->id_dupat ?>.xlsx', { cellStyles: true });
}

async function exportToPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF('l', 'mm', 'a4'); // Landscape
  const pageWidth = doc.internal.pageSize.getWidth();
  
  // Load Barlow font
  let fontFamily = 'helvetica';
  if (typeof loadBarlowFont === 'function') {
    const fontLoaded = await loadBarlowFont(doc);
    if (fontLoaded) fontFamily = 'Barlow';
  }
  
  const logoImg = new Image();
  logoImg.src = '<?= base_url("assets/foto/fasilitas/LogoAstratech.png") ?>';
  
  logoImg.onload = function() {
    const alignmentWidth = 277; 
    const alignmentMargin = (pageWidth - alignmentWidth) / 2;
    
    // Logo (kiri atas)
    const logoHeight = 15;
    const logoWidth = (logoImg.width / logoImg.height) * logoHeight;
    doc.addImage(logoImg, 'PNG', alignmentMargin, 15, logoWidth, logoHeight);
    
    // Nomor & Tanggal (kanan atas, sejajar logo - Y position sama dengan logo)
    doc.setFontSize(10);
    doc.setFont(fontFamily, 'normal');
    const labelX = alignmentMargin + alignmentWidth - 50;
    const colonX = labelX + 15;
    const endX = alignmentMargin + alignmentWidth;

    doc.text('Nomor:', labelX, 18);
    const dotCount = Math.floor((endX - colonX) / 1.2);
    doc.text('.'.repeat(dotCount), colonX, 18);
    
    // Tanggal otomatis hari ini
    const today = new Date();
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const todayFormatted = today.toLocaleDateString('id-ID', options);
    
    doc.text('Tanggal:', labelX, 25);
    doc.text(todayFormatted, colonX, 25);
    
    // Title (di bawah logo, center) - digeser ke bawah
    doc.setFontSize(16);
    doc.setFont(fontFamily, 'bold');
    doc.text('DAFTAR USULAN PENGELUARAN AKTIVA TETAP (DUPAT)', pageWidth / 2, 45, { align: 'center' });
    
    // Translate proposal values to Indonesian
    function translateProposal(value) {
      const translations = {
        'Sold': 'Dijual kpd pihak ketiga',
        'Dijual': 'Dijual kpd pihak ketiga',
        'Dijual kpd pihak ketiga': 'Dijual kpd pihak ketiga',
        'Auction': 'Lelang',
        'Lelang': 'Lelang',
        'Deleted': 'Dihapus',
        'Dihapus': 'Dihapus',
        'Donated': 'Hibah',
        'Hibah': 'Hibah'
      };
      return translations[value] || value;
    }
    
    const tableData = [
      <?php $no = 1; foreach ($detail as $item): ?>
      ['<?= $no++ ?>', '<?= addslashes($item->nama_barang) ?>', '<?= $item->nomor_aktiva ?>', '<?= $item->kondisi_barang ?: "Good" ?>', translateProposal('<?= $item->usulan_pengeluaran ?: "Deleted" ?>'), '<?= addslashes($item->keterangan ?: "-") ?>'],
      <?php endforeach; ?>
    ];
    
    doc.autoTable({
      startY: 55,
      head: [['No', 'Deskripsi Aktiva Tetap', 'Nomor Aktiva Tetap', 'Kondisi', 'Usulan Pengeluaran', 'Alasan']],
      body: tableData,
      theme: 'grid',
      headStyles: { fillColor: [255, 255, 255], textColor: [0, 0, 0], fontStyle: 'bold', halign: 'center', lineWidth: 0.3, lineColor: [0, 0, 0], fontSize: 9 },
      bodyStyles: { textColor: [0, 0, 0], lineWidth: 0.3, lineColor: [0, 0, 0], halign: 'center' },
      columnStyles: { 
        0: { cellWidth: 15 },
        1: { cellWidth: 110 },  // Deskripsi Aktiva Tetap (diperlebar)
        2: { cellWidth: 40 },
        3: { cellWidth: 25 },
        4: { cellWidth: 45 },
        5: { cellWidth: 41 }
      },
      margin: { left: alignmentMargin, right: alignmentMargin },
      tableWidth: 276,
      styles: { fontSize: 8, cellPadding: 3 }
    });
    
    // Signature Table
    const signatureY = doc.lastAutoTable.finalY + 10;
    
    doc.autoTable({
      startY: signatureY,
      head: [[
        { content: 'Diajukan oleh UPT/Dept/Dir asal Aktiva,', colSpan: 2 },
        { content: 'Disetujui oleh,', colSpan: 3 },
        { content: 'Disetujui oleh,', colSpan: 1 }
      ]],
      body: [
        ['PIC', 'Ka.Dept', 'WADIR', 'Ka.Dept DAKAP', 'Ka.Dept DPUSDM', 'Direktur'],
        [
          { content: '\n\n\n\n\nNama: <?= addslashes($dupat->nama_pengguna) ?>\nTanggal: <?= (new DateTime($dupat->tanggal_dupat))->format("d F Y") ?>', styles: { halign: 'left', valign: 'bottom' } },
          { content: '\n\n\n\n\nNama:\nTanggal:', styles: { halign: 'left', valign: 'bottom' } },
          { content: '\n\n\n\n\nNama:\nTanggal:', styles: { halign: 'left', valign: 'bottom' } },
          { content: '\n\n\n\n\nNama:\nTanggal:', styles: { halign: 'left', valign: 'bottom' } },
          { content: '\n\n\n\n\nNama:\nTanggal:', styles: { halign: 'left', valign: 'bottom' } },
          { content: '\n\n\n\n\nNama:\nTanggal:', styles: { halign: 'left', valign: 'bottom' } }
        ]
      ],
      theme: 'grid',
      headStyles: { fillColor: [240, 240, 240], textColor: [0, 0, 0], fontStyle: 'bold', halign: 'center', lineWidth: 0.3, lineColor: [0, 0, 0], fontSize: 10 },
      bodyStyles: { textColor: [0, 0, 0], lineWidth: 0.3, lineColor: [0, 0, 0], halign: 'center', fontSize: 10, minCellHeight: 25 },
      columnStyles: { 0: { cellWidth: 46 }, 1: { cellWidth: 46 }, 2: { cellWidth: 46 }, 3: { cellWidth: 46 }, 4: { cellWidth: 46 }, 5: { cellWidth: 46 } },
      margin: { left: alignmentMargin, right: alignmentMargin },
      styles: { fontSize: 10, cellPadding: 2 }
    });
    
    // Catatan
    const catatanY = doc.lastAutoTable.finalY + 5;
    doc.setFontSize(8);
    doc.setFont(fontFamily, 'bold');
    doc.text('Catatan:', alignmentMargin, catatanY);
    doc.setFont(fontFamily, 'normal');
    doc.text('2. *) Keterangan untuk kolom Usulan :', alignmentMargin, catatanY + 4);
    doc.text('A. Dijual kpd pihak ketiga          B. Lelang          C. Dihapus          D. Hibah', alignmentMargin + 10, catatanY + 8);
    
    // Footer
    const footerY = doc.internal.pageSize.getHeight() - 15;
    doc.setDrawColor(180, 180, 180);
    doc.line(20, footerY, pageWidth - 20, footerY);
    doc.setFontSize(8);
    doc.setFont(fontFamily, 'italic');
    doc.setTextColor(100, 100, 100);
    doc.text('Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Asset', pageWidth / 2, footerY + 5, { align: 'center' });
    doc.text('UPT Informatika - Politeknik Astra © <?= date("Y") ?>', pageWidth / 2, footerY + 9, { align: 'center' });
    
    doc.save('Dupat_<?= $dupat->id_dupat ?>.pdf');
  };
  
  logoImg.onerror = function() {
    Swal.fire('Error', 'Failed to load logo image', 'error');
  };
}

function showImageModal(imageSrc) {
  document.getElementById('zoomedImage').src = imageSrc;
  const modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
}

$(document).ready(function() {
  var hiddenCol = <?= ($dupat->status_dupat === 'Draft') ? '9' : '8' ?>;
  var table = $('#dataTableDetailDupat').DataTable({
    "ordering": true,
    "deferRender": true,
    columnDefs: [{ targets: 0, type: 'num' }, { targets: [hiddenCol], visible: false, searchable: false }]
  });

  $('.editItembtn').on('click', function() {
    $('#edit_id_dtl_dupat').val($(this).data('id'));
    $('#edit_nama_barang').val($(this).data('nama'));
    $('#edit_nomor_aktiva').val($(this).data('nomor'));
    $('#edit_kondisi_barang').val($(this).data('kondisi') || 'Good');
    $('#edit_usulan_pengeluaran').val($(this).data('usulan') || 'Deleted');
    $('#edit_keterangan').val($(this).data('keterangan') || '');
    
    var foto = $(this).data('foto');
    if (foto) {
      $('#current_foto_preview').html('<img src="<?= base_url() ?>assets/foto/dupat/' + foto + '" style="max-width: 100px; max-height: 100px;">');
    } else {
      $('#current_foto_preview').html('');
    }
    
    $('#editItemModal').modal('show');
  });

  $('#formEditItem').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
      url: "<?= base_url('Functions/updateDtlDupat') ?>",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          $('#editItemModal').modal('hide');
          Swal.fire('Succeed!', 'Item updated!', 'success').then(() => location.reload());
        } else {
          Swal.fire('Error!', response.message || 'Failed to update item.', 'error');
        }
      }
    });
  });

  $('.deleteItembtn').on('click', function() {
    var id = $(this).data('id');
    var $row = $(this).closest('tr');
    Swal.fire({ 
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning', 
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#EF4444',
      cancelButtonColor: '#E5E7EB',
      customClass: {
        cancelButton: 'swal2-cancel-dark-text'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Show loading
        Swal.fire({
          title: 'Deleting...',
          allowOutsideClick: false,
          didOpen: () => { Swal.showLoading(); }
        });
        
        $.ajax({
          url: "<?= base_url('Functions/deleteDtlDupat') ?>",
          method: "POST",
          data: { id_dtl_dupat: id },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              // Remove row from DataTable without reload
              table.row($row).remove().draw();
              Swal.fire('Deleted!', 'Item has been deleted.', 'success');
            } else {
              Swal.fire('Error!', response.message || 'Failed to delete item.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error!', 'Failed to delete item.', 'error');
          }
        });
      }
    });
  });
});
</script>
