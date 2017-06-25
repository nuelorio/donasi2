<?php require 'isi/header.php';?>
<?php
    if(isset($_GET['confirm']) && $_GET['confirm'] != ''){
    	$confirm_id = $_GET['confirm'];
    	$confirm_sql = "UPDATE donasi SET konfirmasi = '1' WHERE id = '$confirm_id'";
    	$db->query($confirm_sql);
    	header('location:dataDonasi.php');
    }

    if(isset($_GET['delete']) && $_GET['delete'] != ''){
    	$delete_id = $_GET['delete'];

    	//donasi, lembaga peruntukan
    	$delete_stuff = "DELETE donasi, lembaga, peruntukan FROM donasi INNER JOIN lembaga INNER JOIN peruntukan WHERE donasi.id = '$delete_id' AND lembaga.id = donasi.id AND lembaga.id = peruntukan.id ";
    	$db->query($delete_stuff);
    	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    	header('location:dataDonasi.php');
    }

    if(isset($_POST['cari']) && $_POST['cari'] != ''){
    	$harga = sanitize($_POST['nominal']);
    	$ambil_data = "SELECT * FROM donasi WHERE kode_donasi = '$harga'";
    	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }else{
    	$ambil_data = "SELECT * FROM donasi";
    }
    $result_data = $db->query($ambil_data);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (isset($_POST['print'])) {
    	$output ='d:dataDonasi.csv';
    	$comma = ',';
    	$enter = '\n';
    	$quote = '"';
      	$print =" SELECT * INTO OUTFILE '$output' FIELDS TERMINATED BY '$comma' OPTIONALLY ENCLOSED BY '$quote' LINES TERMINATED BY '$enter' FROM donasi, lembaga, peruntukan WHERE donasi.id = lembaga.id AND donasi.id = peruntukan.id GROUP BY lembaga.id ";
      	$db->query($print);
      }  

?>

<div class="container panel panel-default">
	<b><legend class="text-primary">
		Data Donasi
	</legend></b>
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<form action="#" method="post">
			<div><input type="submit" name="print" value="export jadi excel" class="btn btn-primary"></div><br>
			<div class="input-group">
				<div class="input-group-addon">Rp</div>
				
				<input type="number" min="50000" name="nominal" class="form-control input-md tes" value="<?=((isset($_POST['nominal']))?$_POST['nominal']:'');?>">

				<div><input type="submit" name="cari" value="cari" class="btn btn-primary"></div>
			</div>
		</form>

		<table class = "table table-bordered table-striped table-auto table-condensed">
			<thead>
				<th>No</th>
				<th>Donatur</th>
				<th>Donasi</th>
				<th>Nomor Donasi</th>
				<th>Konfirmasi Admin</th>
				<th>Edit</th>
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
						<td>Rp <?= number_format($data['kode_donasi'],2)?></td>			
						<td><?=$donatur['id']?><?=$data['ke']?></td>
						<td><?= (($data['konfirmasi']=='1')?'Sudah':'Belum')?></td>	
						<td>
							<a href="dataDonasi.php?confirm=<?= $data['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ok"></span></a>
							<a href="dataDonasi.php?delete=<?= $data['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
						</td>		
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>								
	</div>
	<div class="col-md-1"></div>
	
</div>
<?php require 'isi/footer.php';?>