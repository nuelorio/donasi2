<?php include 'isi/header.php'; ?>
<?php
if(isset($_POST['login']) || isset($_POST['daftar']) || isset($_POST['lupa'])){
	$email = sanitize($_POST['email']);
	$password = md5(sanitize($_POST['password']));
	$cek = "SELECT * FROM password WHERE email = '$email'";
	$cek_result = $db->query($cek);
	$cek_email = mysqli_num_rows($cek_result);
	$cek_ambil = mysqli_fetch_assoc($cek_result);
	if(isset($_POST['login'])){
	    if ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '0'){
	        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap namun belum melakukan konfirmasi email, silahkan cek email anda atau kirim ulang.';
	    }elseif ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $password != $cek_ambil['password']){
	        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap jika anda lupa dengan password anda, anda dapat memilih tautan "lupa password?".';
	    }elseif($cek_email == 0){
	    	$errors[] .= 'email anda tidak terdaftar';
	    }elseif($cek_email > 0 && $cek_ambil['donatur'] == '0'){
	    	$errors[] .= 'anda belum mendaftar menjadi donatur tetap';
	    }
	    if(!empty($errors)){
        	echo display_errors($errors);
    	}else{
    		session_start();
    		$_SESSION['email'] = $email;
    		session_write_close();
    		if($cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $cek_ambil['admin'] == '1'){
    			echo '<div class="text-center">';
    			echo '<p class="text-primary"><b>anda login sebagai?</b></p>';
    			echo '<a href="admin/index.php" class="btn btn-primary">Admin</a>&nbsp';
    			echo '<a href="donatur/index.php" class="btn btn-default">Donatur</a><br><br>';
    			echo '</div>';
    		}elseif($cek_ambil['admin'] == '1'){
    			header("Location: admin/index.php");
    		}elseif($cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $cek_ambil['admin'] == '0'){
    			header("Location: donatur/index.php");
    		}else{
    			header("Location: login.php");
    		}
    		
    	}
	}
	if (isset($_POST['daftar'])) {
	    if ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '0'){
	        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap namun belum melakukan konfirmasi email, silahkan cek email anda atau kirim ulang..';
	    }elseif ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $password != $cek_ambil['password']){
	        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap jika anda lupa dengan password anda, anda dapat memilih tautan "lupa password?" pada menu login.';
	    }elseif($cek_email == 0){
	    	$errors[] .= 'email anda tidak terdaftar';
	    }elseif ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $password == $cek_ambil['password']) {
	    	$errors[] .= 'email anda sudah terdaftar sebagai donatur tetap silahkan melakukan login';
	    }

	    if(!empty($errors)){
	        echo display_errors($errors);
	    }else{
	    	$sql_password = "UPDATE password SET password = '$password', donatur = '1' WHERE email = '$email'";
	    	$db->query($sql_password);  
	    	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			
			$to = $email;
			$subject="Konfirmasi Donatur Tetap";
			$from = 'your email';
			$link = $_SERVER['SERVER_NAME'] .':'. $_SERVER['SERVER_PORT'];
			$body='Terima kasih sudah mendaftar menjadi Donatur Tetap klik tautan berikut untuk melakukan konfirmasi di '.$link.'/donasi/konfirmasi.php?email='.$email;
			$headers = "From:".$from;
			mail($to,$subject,$body,$headers);

			echo '<div class="panel panel-default tes"><span class="text-primary">Terima kasih telah mendaftar menjadi donatur tetap. Silahkan cek email anda untuk melakukan tahap selanjutnya.</span></div>';
	    }
	}
	if(isset($_POST['lupa'])){
	    if ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $password != $cek_ambil['password']){
	        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap jika anda lupa dengan password anda, anda dapat memilih tautan "lupa password?" pada menu login.';
	    }elseif($cek_email == 0){
	    	$errors[] .= 'email anda tidak terdaftar';
	    }elseif($cek_email > 0 && $cek_ambil['donatur'] == '0'){
	    	$errors[] .= 'anda belum mendaftar menjadi donatur tetap';
	    }elseif ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1' && $password == $cek_ambil['password']) {
	    	$errors[] .= 'email anda sudah terdaftar sebagai donatur tetap silahkan melakukan login';
	    }

	    if($password != $cek_ambil['password']){
	    	$errors[] .= 'Password anda salah';
	    }

	    if(!empty($errors)){
	        echo display_errors($errors);
	    }else{
			$to = $email;
			$subject="Konfirmasi Donatur Tetap";
			$from = 'your email';
			$link = $_SERVER['SERVER_NAME'] .':'. $_SERVER['SERVER_PORT'];
			$body='Terima kasih sudah mendaftar menjadi Donatur Tetap klik tautan berikut untuk melakukan konfirmasi di '.$link.'/donasi/konfirmasi.php?email='.$email;
			$headers = "From:".$from;
			mail($to,$subject,$body,$headers);

			echo '<div class="panel panel-default tes"><span class="text-primary">Terima kasih telah meminta konfirmasi email ulang. Silahkan cek email anda untuk melakukan tahap selanjutnya.</span></div>';
	    }
	}
}
?>
<div class="container">
	<div class="col-md-3"></div>
	<div class="col-md-6 panel panel-default">
		<b><h4 class="text-primary">Login</h4></b>
		<form action="login.php" method="post">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" name="email" class="form-control" 
                        value="<?=((isset($_POST['email']))?$_POST['email']:'');?>"
                        required>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control" 
				value="<?=((isset($_POST['password']))?$_POST['password']:'');?>" 
				required oninvalid="this.setCustomValidity('tolong isi password')"
				oninput="setCustomValidity('')">
			</div>
			<div class="text-center">
				<input type="submit" name="login" value="Login" class="btn btn-primary"> <br>
				<a href="lupaPassword.php">Lupa Password?</a><br>
				<input type="submit" name="daftar" value="Daftarkan email menjadi donatur tetap" class="btn btn-default">  
				<input type="submit" name="lupa" value="Belum Konfirmasi email" class="btn btn-default">
			</div>	
		</form>
	</div>
	<div class="col-md-3"></div>	
</div>
<?php include 'isi/footer.php'; ?>