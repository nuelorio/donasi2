<?php require 'isi/header.php';?>
<?php
$ambil_data = "SELECT * FROM donatur";
$result_data = $db->query($ambil_data);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if(isset($_GET['delete']) && $_GET['delete'] != ''){
	$delete_id = $_GET['delete'];

	//donasi, lembaga peruntukan
	$delete_stuff = "DELETE donatur, kantor, password, donasi, lembaga, peruntukan FROM donatur INNER JOIN kantor INNER JOIN password INNER JOIN donasi INNER JOIN lembaga INNER JOIN peruntukan WHERE donatur.email = '$delete_id' AND donatur.email = donasi.email AND donatur.email = peruntukan.email AND donatur.email = kantor.email AND donatur.email = password.email AND donatur.email = lembaga.email";
	$db->query($delete_stuff);
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	header('location:index.php');
}
?>
<div class="container panel panel-default">
	<b><legend class="text-primary">
		Data Donatur
	</legend></b>
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<table class = "table table-bordered table-striped table-auto table-condensed">
			<thead>
				<th>No</th>
				<th>Donatur</th>
				<th>Email</th>
				<th>No. Telp.</th>
				<th>Jenis Kelamin</th>
				<th>TTL</th>
				<th>Alamat</th>
				<th>Edit</th>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php while($data = mysqli_fetch_assoc($result_data)):?>
					<tr>
						<td><?= $i=$i+1; ?></td>
						<td><?=$data['nama']?></td>				
						<td><?=$data['email']?></td>			
						<td><?=$data['telp']?></td>
						<td><?= (($data['kelamin']=='1')?'Laki-laki':'Perempuan')?></td>	
						<td><?=$data['tempat_lahir']?>,<?=$data['tanggal_lahir']?></td>	
						<td><?=$data['alamat']?></td>	
						<td>
							<a href="index.php?delete=<?= $data['email']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
						</td>		
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>								
	</div>
	<div class="col-md-1"></div>
	
</div>
<?php require 'isi/footer.php';?>