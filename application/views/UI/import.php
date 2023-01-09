<!-- <!DOCTYPE html>
<html>
<head>
	<title>Search Data</title>
</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<body>

<div class="container">
	<div class="row" style="margin-top: 30px;">
		<div class="col-md-4 col-md-offset-3">
			<h3>Import Data</h3>
			<?php if(!empty($this->session->flashdata('status'))){ ?>
			<div class="alert alert-info" role="alert"><?= $this->session->flashdata('status'); ?></div>
			<?php } ?>
			<form action="<?= base_url('ImportController/import_excel'); ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Pilih File Excel</label>
					<input type="file" name="fileExcel">
				</div>
				<div>
					<button class='btn btn-success' type="submit">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			    		Import		
					</button>
				</div>
			</form>
		</div>
		<div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
			<h3>Daftar Data</h3>
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$no = 1;
							foreach ($list_data as $row) {
						 ?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $row['nama_barang'] ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>	
			</div>
		</div>
	</div>
</div>
</body>
</html> -->