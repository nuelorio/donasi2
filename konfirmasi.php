<?php include 'isi/header.php';?>
<?php
	if(!isset($_GET['email']) || empty($_GET['email'] || $_GET['email'] == '')){
		header('location:index.php');
	}else{
		$email = $_GET['email'];
		$cek = "SELECT * FROM password WHERE email = '$email'";
	    $cek_result = $db->query($cek);
	    $cek_email = mysqli_num_rows($cek_result);
	    if ($cek_email == 0){
        	header('location:index.php');
    	}
    	$sql_password = "UPDATE password SET konfirmasi = '1' WHERE email = '$email'";
    	$db->query($sql_password); 
	}
?>
<div class="col-md-3"></div>
<div class="panel panel-default tes col-md-6"><span class="text-primary">email anda sudah dikonfirmasi silahkan login</span></div>
<div class="col-md-3"></div>
<?php include 'isi/footer.php';?>