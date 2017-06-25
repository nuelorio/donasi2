<?php require 'isi/header.php';?>
<?php
	if(!isset($_GET['email']) || empty($_GET['email'])){
		header('location:index.php');
	}
	$email = $_GET['email'];
	$cek = "SELECT * FROM password WHERE email = '$email'";
    $cek_result = $db->query($cek);
    $cek_email = mysqli_num_rows($cek_result);
    if($cek_email == 0){
    	header('location:index.php');
    }
    $ambil_data = "SELECT * FROM donasi WHERE email = '$email'";
    $result_data = $db->query($ambil_data);
    $data = mysqli_fetch_assoc($result_data);

 	$ambil_donatur = "SELECT * FROM donatur WHERE email = '$email'";
    $result_donatur = $db->query($ambil_donatur);	
    $donatur = mysqli_fetch_assoc($result_donatur);


?>
<fieldset class="container">
	<div class="row">
		<div class="col-md-1"></div>
        <div class="col-md-10">
            <ul class="nav nav-pills nav-justified thumbnail" id="pills">
                <li><a data-toggle="">
                    <h4 class="list-group-item-heading">Langkah ke-1</h4>
                    <p class="list-group-item-text">Data Donatur</p>
                </a></li>
                <li><a data-toggle="">
                    <h4 class="list-group-item-heading">Langkah ke-2</h4>
                    <p class="list-group-item-text">Data Donasi</p>
                </a></li>
                <li class="active"><a data-toggle="">
                    <h4 class="list-group-item-heading">Langkah ke-3</h4>
                    <p class="list-group-item-text">Pembayaran</p>
                </a></li>
            </ul>
			<form action="index.php" method="post">
				<b><legend class="text-primary">Pembayaran</legend></b>
				<div class="col-md-1"></div>
				<div class="col-md-10 panel panel-default">
					<div class="panel panel-default tes"><span class="text-primary">Terima Kasih, Donasi anda sudah tercatat di database kami. Silahkan melakukan Pembayaran.</span></div>
					<b><h4 class="text-primary">Informasi Pembayaran</h4></b>

					<table class="table table-stripped">
						<tr>
							<th>Nomor Donasi</th>
							<td><?= $donatur['id']?><?= $data['ke']?></td>
						</tr>
						<tr>
							<th>Nominal Donasi</th>
							<td>Rp <?= number_format($data['nominal'],2)?></td>
						</tr>
						<tr>
							<th>Kode Unik Donasi</th>
							<td><?= $donatur['id']?></td>
						</tr>
					</table>	
					<p class="text-success">*Kode Unik adalah Kode yang ditambahkan pada Nominal Donasi, diperlukan untuk Verifikasi. </p>
					<div class="panel panel-default tes" style="font-size: 20px"><span class="text-primary">Nominal yang Ditransfer : <b>Rp <?= number_format($data['kode_donasi'],2)?></b></span></div>

					<div class="text-center bank">
						<b>Silahkan lakukan pembayaran ke rekening berikut:</b><br>
						<div class="col-md-4">
							<img src="img/mandiri.png" alt="Jika anda melihat tulisan ini maka ada masalah pada database ketika menampilkan gambar" class="img-thumb"><br>
							<span>No Rekening:1310004765774</span><br>
							<span>Donasi Pendidikan - YPT</span>
						</div>
					</div>
					<br>
					<div class="col-md-12 panel panel-default tes" id="bawahBank"><span class="text-primary">Transfer donasi sebelum <?php 
						$tambah = "SELECT time, DATE_ADD(time, INTERVAL 2 DAY) AS endDate FROM donasi";
						$tambah_result = $db->query($tambah);	
    					$tambah_date = mysqli_fetch_assoc($tambah_result);
    					echo $tambah_date['endDate'];
					?></span></div>
					<div class="col-md-12 panel panel-default tes" id="bawahBank"><span class="text-primary">Untuk melihat status konfirmasi pembayaran, anda dapat melihatnya di tab 'Data Donasi'. Kami akan mengirim email jika kami sudah melakukan konfirmasi atas pembayaran anda</span></div>
				</div>

				<div class="col-md-1"></div>
			</form>
        </div>
        <div class="col-md-1"></div>
	</div>
</fieldset>
<?php include 'isi/footer.php';?>