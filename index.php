<?php include 'isi/header.php';?>
<?php

if(isset($_POST['lanjutkan'])){
    $nama = sanitize($_POST['nama']);
    $no_telp = sanitize($_POST['no_telp']);
    $email = sanitize($_POST['email']);

    if(!isset($_POST['kelamin']) || empty($_POST['kantor'])){
    	$kelamin = '';
    }else{
    	$kelamin = sanitize($_POST['kelamin']);
    }
    if(!isset($_POST['tempat_lahir']) || empty($_POST['tempat_lahir'])){
    	$tempat_lahir = '';
    }else{
    	$tempat_lahir = sanitize($_POST['tempat_lahir']);
    }
    if(!isset($_POST['tanggal_lahir']) || empty($_POST['tanggal_lahir'])){
    	$tanggal_lahir = '';
    }else{
    	$tanggal_lahir = sanitize($_POST['tanggal_lahir']);
    }       
    if(!isset($_POST['alamat']) || empty($_POST['alamat'])){
    	$alamat = '';
    }else{
    	$alamat = sanitize($_POST['alamat']);
    }     
    if(!isset($_POST['password']) || empty($_POST['password'])){
    	$password = '';
    }else{
    	$password = md5(sanitize($_POST['password']));
    } 
    if (!isset($_POST['kantor']) || empty($_POST['kantor'])) {
        $kantor = '';
    }else{
        $kantor = sanitize($_POST['kantor']);
    }
    if (!isset($_POST['unit']) || empty($_POST['unit'])) {
        $unit = '';
    }else{
        $unit = sanitize($_POST['unit']);
    }
    if (!isset($_POST['jabatan']) || empty($_POST['jabatan'])) {
        $jabatan = '';
    }else{
        $jabatan = sanitize($_POST['jabatan']);
    }
    if (!isset($_POST['alamat_kantor']) || empty($_POST['alamat_kantor'])) {
        $alamat_kantor = '';
    }else{
        $alamat_kantor = sanitize($_POST['alamat_kantor']);
    }

    //cek email yang sudah terdaftar sebagai donatur tetap
    $cek = "SELECT * FROM password WHERE email = '$email'";
    $cek_result = $db->query($cek);
    $cek_email = mysqli_num_rows($cek_result);
    $cek_ambil = mysqli_fetch_assoc($cek_result);
    if ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '0'){
        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap namun belum melakukan konfirmasi email, silahkan cek email anda.';
    }elseif ($cek_email > 0 && $cek_ambil['donatur'] == '1' && $cek_ambil['konfirmasi'] == '1'){
        $errors[] .= 'email anda sudah terdaftar sebagai donatur tetap jika anda lupa dengan password anda, anda dapat memilih tautan "lupa password?" pada menu login.';
    }elseif ($cek_email > 0){
        $errors[] .= 'email anda sudah terdaftar, pilih menu "Saya pernah mendonasi sekali namun ingin menjadi donatur tetap. " pada halaman utama.';
    }
    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        $sql_donatur =  "INSERT INTO donatur SET 
        nama = '$nama', 
        kelamin = '$kelamin', 
        tempat_lahir = '$tempat_lahir', 
        tanggal_lahir = '$tanggal_lahir',
        alamat = '$alamat',
        telp = '$no_telp',
        email = '$email';
        ";
        $sql_kantor = "INSERT INTO kantor SET
        email = '$email',
        nama = '$kantor',
        unit = '$unit',
        jabatan = '$jabatan',
        alamat = '$alamat_kantor';
        ";
        $sql_donasi = "INSERT INTO donasi SET email = '$email'";
        $sql_lembaga = "INSERT INTO lembaga SET email = '$email'";
        $sql_password = "INSERT INTO password SET email = '$email', password = '$password', donatur = '1'";
        $sql_peruntukan = "INSERT INTO peruntukan SET email = '$email'";

        $db->query($sql_donatur);
        $db->query($sql_kantor);
        $db->query($sql_donasi);
        $db->query($sql_lembaga);
        $db->query($sql_password);
        $db->query($sql_peruntukan);

        if($_POST['muncul'] == 'one'){
        	$to = $email;
			$subject="Konfirmasi Donatur Tetap ";
			$from = 'your email';
			$link = $_SERVER['SERVER_NAME'] .':'. $_SERVER['SERVER_PORT'];
			$body='Terima kasih sudah mendaftar menjadi Donatur Tetap klik tautan berikut untuk melakukan konfirmasi di '.$link.'/donasi2/konfirmasi.php?email='.$email.' anda dapat melakukan donasi dengan melakukan login.';
			$headers = "From:".$from;
			mail($to,$subject,$body,$headers);

	        echo '<div class="panel panel-default tes"><span class="text-primary">Terima kasih telah mendaftar menjadi donatur tetap. Silahkan cek email anda untuk melakukan tahap selanjutnya.</span></div>';
        }else{
        	header('Location:langkah2.php?email='.$email);
        }

    }
 }
?>
<fieldset class="container">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10 panel">
        <ul class="nav nav-pills nav-justified thumbnail" id="pills">
            <li class="active"><a data-toggle="">
                <h4 class="list-group-item-heading">Langkah ke-1</h4>
                <p class="list-group-item-text">Data Donatur</p>
            </a></li>
            <li><a data-toggle="">
                <h4 class="list-group-item-heading">Langkah ke-2</h4>
                <p class="list-group-item-text">Data Donasi</p>
            </a></li>
            <li><a data-toggle="">
                <h4 class="list-group-item-heading">Langkah ke-3</h4>
                <p class="list-group-item-text">Pembayaran</p>
            </a></li>
        </ul>
		<form action="index.php" method="post">
			<b><legend class="text-primary">Data Diri</legend></b>
			<div class="col-md-1"></div>
            <div class="col-md-10 panel panel-default ">
            	<div class="form-group">
                    <label for="nama">Nama Lengkap:</label><br>
                    <input type="text" name="nama" class="form-control" 
                    value="<?=((isset($_POST['nama']))?$_POST['nama']:'');?>" 
                    required oninvalid="this.setCustomValidity('Tolong Isi Nama Lengkap Anda')"
                    oninput="setCustomValidity('')">
                    <p class="text-danger">*Dibutuhkan</p>
                </div>

                <div class="form-group">
                    <label for="no_telp">Nomor Telepon/HP:</label><br>
                    <input type="number" name="no_telp" class="form-control" 
                    value="<?=((isset($_POST['no_telp']))?$_POST['no_telp']:'');?>"
                    required oninvalid="this.setCustomValidity('Tolong Isi Nomor Telepon/HP Anda')" oninput="setCustomValidity('')">
                    <p class="text-danger">*Dibutuhkan</p>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" class="form-control" 
                    value="<?=((isset($_POST['email']))?$_POST['email']:'');?>"
                    required oninvalid="this.setCustomValidity('Tolong Isi Email Anda')" oninput="setCustomValidity('')">
                    <p class="text-danger">*Dibutuhkan</p>
                </div>

                <div class="form-group">
                	<label for="muncul">Ingin Menjadi Donatur Tetap?</label><br>
                	<input type="radio" name="muncul" id="value_radio" value="one" onclick="document.getElementById('value_input').focus()" required>Ya
                	<input type="radio" name="muncul" id="free" value="two" required checked>tidak
                </div>

                <div id="hilang">
                	<div class="form-group">
                        <label for="kelamin">Jenis Kelamin</label><br>
                        <?php createRadioOption('kelamin', '1',  'Laki-laki'); ?>
                        <?php createRadioOption('kelamin', '2',  'Perempuan'); ?>
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir:</label><br>
                        <input type="text" name="tempat_lahir" class="form-control value_input" 
                        value="<?=((isset($_POST['tempat_lahir']))?$_POST['tempat_lahir']:'');?>"
                        onclick="document.getElementById('value_radio').checked=true" oninvalid="this.setCustomValidity('Tolong Isi Tempat Lahir Anda')"
                        oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir:</label><br>
                        <input type="date" name="tanggal_lahir" class="form-control value_input" 
                        value="<?=((isset($_POST['tanggal_lahir']))?$_POST['tanggal_lahir']:'');?>" 
                        onclick="document.getElementById('value_radio').checked=true" oninvalid="this.setCustomValidity('tolong isi tanggal lahir')"
                        oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                   <div class="form-group">
                        <label for="alamat">Alamat Rumah:</label><br>
                        <textarea name="alamat" class="form-control value_input" 
                        onclick="document.getElementById('value_radio').checked=true" oninvalid="this.setCustomValidity('Tolong Isi Alamat Rumah Anda')"><?= ((isset($_POST['alamat']))?$_POST['alamat']:'');?></textarea>
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label><br>
                        <input type="password" name="password" class="form-control value_input" 
                        value="<?=((isset($_POST['password']))?$_POST['password']:'');?>"
                        onclick="document.getElementById('value_radio').checked=true" oninvalid="this.setCustomValidity('Tolong Isi Password')" oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="kantor">Nama Kantor:</label><br>
                        <input type="text" name="kantor" class="form-control" 
                        value="<?=((isset($_POST['kantor']))?$_POST['kantor']:'');?>"> 
                        <p class="text-success">*Opsional</p>
                    </div>

                    <div class="form-group">
                        <label for="unit">Unit Kerja:</label><br>
                        <input type="text" name="unit" class="form-control" 
                        value="<?=((isset($_POST['unit']))?$_POST['unit']:'');?>">
                        <p class="text-success">*Opsional</p>           
                    </div>

                    <div class="form-group">
                        <label for="jabatan">Jabatan:</label><br>
                        <input type="text" name="jabatan" class="form-control" 
                        value="<?=((isset($_POST['jabatan']))?$_POST['jabatan']:'');?>"> 
                        <p class="text-success">*Opsional</p>
                    </div>

                    <div class="form-group">
                        <label for="alamat_kantor">Alamat Kantor:</label><br>
                        <input type="text" name="alamat_kantor" class="form-control" 
                        value="<?=((isset($_POST['alamat_kantor']))?$_POST['alamat_kantor']:'');?>"> 
                        <p class="text-success">*Opsional</p>
                    </div>
                </div>
                <div class="form-group col-md-12 text-center">
                    <p><b>Harap Cek kembali Apakah data sudah benar atau belum.</b></p>
                    <input type="submit" name="lanjutkan" value="lanjutkan" class="btn btn-primary">
                </div>
                    
                
            </div>
			<div class="col-md-1"></div>
		</form>
			
		<script type="text/javascript">
			$('input[name="muncul"]').change(function () {
			if($("#value_radio").is(':checked')) {
				$('.value_input').attr('required', true);
			} else {
				$('.value_input').removeAttr('required');
			}
		});
		</script>

		</div>
        <div class="col-md-1"></div>
	</div>
</fieldset>
<?php include 'isi/footer.php';?>