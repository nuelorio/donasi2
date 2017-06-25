<?php require 'isi/header.php';?>
<?php
	$ambil_data = "SELECT * FROM donasi";
    $result_data = $db->query($ambil_data);  
?>

<div class="container panel panel-default">
	<b><legend class="text-primary">
		Data Donasi
	</legend></b>
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<table class = "table table-bordered table-striped table-auto table-condensed">
			<thead>
				<th>No</th>
				<th>Donatur</th>
				<th>Donasi</th>
				<th>Nomor Donasi</th>
				<th>Konfirmasi Admin</th>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php while($data = mysqli_fetch_assoc($result_data)):?>
					<?php 
						$email = $data['email'];
					 	$ambil_donatur = "SELECT * FROM donatur WHERE email = '$email'";
					    $result_donatur = $db->query($ambil_donatur);	
					    $donatur = mysqli_fetch_assoc($result_donatur);
					?>
					<tr>
						<td><?= $i=$i+1; ?></td>
						<td><?=$donatur['nama']?></td>				
						<td>Rp <?= number_format($data['nominal'],2)?></td>			
						<td><?=$donatur['id']?><?=$data['ke']?></td>
						<td><?= (($data['konfirmasi']=='1')?'Sudah':'Belum')?></td>			
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>								
	</div>
	<div class="col-md-1"></div>
	
</div>
<?php require 'isi/footer.php';?>