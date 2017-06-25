<?php include 'isi/header.php'; ?>
<?php
if(isset($_POST['lupa'])){
	$email = sanitize($_POST['email']);

	$cek = "SELECT * FROM password WHERE email = '$email'";
	$cek_result = $db->query($cek);
	$cek_email = mysqli_num_rows($cek_result);
	$cek_ambil = mysqli_fetch_assoc($cek_result);
    if ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '0'){
        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap namun belum melakukan konfirmasi email, silahkan cek email anda.';
    }elseif($cek_email == 0){
    	$errors[] .= 'email anda tidak terdaftar';
    }elseif($cek_email > 0 && $cek_ambil['donatur'] == '0'){
    	$errors[] .= 'anda belum mendaftar menjadi donatur tetap';
    }
    if(!empty($errors)){
    	echo display_errors($errors);
	}else{
		$sql_password = "UPDATE password SET password = '', donatur = '0', konfirmasi = '0' WHERE email = '$email'";
    	$db->query($sql_password);  

		echo '<div class="panel panel-default tes"><span class="text-primary">Terima kasih password anda sudah kami reset, silahkan pilih menu "Saya pernah mendonasi sekali namun ingin menjadi donatur tetap." pada halaman utama untuk mengupdate password.</span></div>';
	}
}
?>
<div class="container">
	<div class="col-md-3"></div>
	<div class="col-md-6 panel panel-default">
		<b><h4 class="text-primary">Lupa Password</h4></b>
		<form action="lupaPassword.php" method="post">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" name="email" class="form-control" 
                        value="<?=((isset($_POST['email']))?$_POST['email']:'');?>"
                        required>
			</div>
			<div class="text-center">
				<input type="submit" name="lupa" value="Reset Password" class="btn btn-primary">  

			</div>	
		</form>
	</div>
	<div class="col-md-3"></div>	
</div>
<?php include 'isi/footer.php'; ?>