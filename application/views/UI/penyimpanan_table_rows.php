<?php $no = 1; foreach ($penyimpanan as $data): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td style="text-align: center;"><?= $data->nama_penyimpanan ?></td>
    <td><?= $data->nama_barang ?></td>
    <td><?= $data->total_barang.' '.$data->satuan_barang?></td>
  </tr>
<?php endforeach; ?>
