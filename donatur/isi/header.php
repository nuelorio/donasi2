<?php require_once ('../init.php');?>
<?php 
$errors = array();
session_start();
if(!isset($_SESSION['email']) && is_null($_SESSION['email'])){
	session_destroy();
	header("Location: ../index.php");
}
if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$cek = "SELECT * FROM password WHERE email = '$email'";
    $cek_result = $db->query($cek);
    $cek_email = mysqli_num_rows($cek_result);
    $cek_ambil = mysqli_fetch_assoc($cek_result);
    if ($cek_email == 0 && $cek_ambil['donatur'] != '1' && $cek_ambil['konfirmasi'] != '1'){
    	header("Location: ../index.php");
    }
}
$donatur = "SELECT * FROM donatur WHERE email = '$email'";
$db_donatur = $db->query($donatur);
$ambil_donatur = mysqli_fetch_assoc($db_donatur);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Donasi YPT</title>
	<meta name="description" content="Donasi Untuk Sesama" />
	<meta name="author" content="Vitalis Emanuel Setiawan" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="../css/bajinga.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="../js/bajinga.js"></script>
</head>
<body>
	<!-- header -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#ribbon">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand">Donasi</a> 
				<!-- will change -->
			</div>
			<div class="collapse navbar-collapse" id="ribbon">
				<ul class="nav navbar-nav">
					<li>
						<a href="dataDonasi.php">
							<span class="glyphicon glyphicon-list-alt"></span> Data Donasi
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a>Selamat Datang <?= $ambil_donatur['nama'] ?></a></li>
					<li><a href="aturIdentitas.php"><span class="glyphicon glyphicon-cog"></span> Atur identitas</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-user"></span> Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
<br><br><br>