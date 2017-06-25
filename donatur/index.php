<?php require 'isi/header.php';?>
<?php
    if(isset($_POST['lanjutkan'])){

    	if(isset($_POST['lembaga'])){
    		$lembaga = $_POST['lembaga'];
	    	foreach ($lembaga as $key => $value) {
	    		if($value == 'paud'){$paud = '1';}
	    		if($value == 'tk'){$tk = '1';}
	    		if($value == 'sd'){$sd = '1';}
	    		if($value == 'smp'){$smp = '1';}
	    		if($value == 'sma'){$sma = '1';}
	    		if($value == 'smk'){$smk = '1';}
	    		if($value == 'pt'){$pt = '1';}		
	    		if($value == 'lain'){$lain = '1';}		
	    	}

	    	if(!isset($paud)){$paud = '0';}
	    	if(!isset($tk)){$tk = '0';}
	    	if(!isset($sd)){$sd = '0';}
	    	if(!isset($smp)){$smp = '0';}
	    	if(!isset($sma)){$sma = '0';}
	    	if(!isset($smk)){$smk = '0';}
	    	if(!isset($pt)){$pt = '0';}
	    	if(!isset($lain)){$lain = '0';}
	    	$lain2 = '';
	    	if($lain == '1' && $_POST['lain2'] == ''){
	    		$errors[] .= 'Anda mencentang lainnya di bagian Lembaga namun kolom isiannya dikosongkan';
	    	}elseif($lain == '1' && $_POST['lain2'] != ''){
	    		$lain2 = $_POST['lain2'];
	    	}
    	}else{
    		$errors[] .= 'Pilih minimal satu Lembaga Pendidikan';
    	}
    	
    	if(isset($_POST['untuk'])){
	    	$untuk = $_POST['untuk'];
	    	foreach ($untuk as $key => $value) {
	    		if($value == 'fp'){$fp = '1';}
	    		if($value == 'fu'){$fu = '1';}
	    		if($value == 'lain3'){$lain3 = '1';}
	    	}
	    	if(!isset($fp)){$fp = '0';}
		    if(!isset($fu)){$fu = '0';}
		    if(!isset($lain3)){$lain3 = '0';}

		    $lain4 = '';
		    if($lain3 == '1' && $_POST['lain4'] == ''){
	    		$errors[] .= 'Anda mencentang lainnya di bagian Peruntukan namun kolom isiannya dikosongkan';
	    	}elseif($lain3 == '1' && $_POST['lain4'] != ''){
	    		$lain4 = $_POST['lain4'];
	    	}
	    }else{
    		$errors[] .= 'Pilih minimal satu Fasilitas Tujuan Donasi';
    	}
    	$nominal = sanitize($_POST['nominal']);
    	if(!empty($errors)){
        	echo display_errors($errors);
    	}else{

    		$id = "SELECT * FROM donatur WHERE email = '$email'";
    		$ambil_id = $db->query($id);
   			$cek_id = mysqli_fetch_assoc($ambil_id);
   			$kode_donasi = $nominal + $cek_id['id'];

   			$cari_ke = "SELECT * FROM donasi WHERE email = '$email' ORDER BY ke DESC LIMIT 1";
    		$ambil_ke = $db->query($cari_ke);
    		$get_ke = mysqli_fetch_assoc($ambil_ke);
    		$ke = $get_ke['ke'] + 1; 			

    		$sql_donasi = "INSERT INTO donasi SET ke = '$ke', nominal = '$nominal', kode_donasi = '$kode_donasi', email = '$email'";

    		$sql_lembaga = "INSERT INTO lembaga SET
    		ke = '$ke', 
    		paud = '$paud', 
    		tk = '$tk', 
    		sd = '$sd', 
    		smp = '$smp', 
    		sma = '$sma', 
    		smk = '$smk', 
    		pt = '$pt', 
    		lain = '$lain2',
    		email = '$email'";
    		

    		$sql_peruntukan = "INSERT INTO peruntukan SET
    		ke = '$ke', 
    		pendidikan = '$fp',
    		umum = '$fu',
    		lain = '$lain4',
    		email = '$email'";

    		$db->query($sql_donasi);
    		$db->query($sql_lembaga);
    		$db->query($sql_peruntukan);

    		$baca = "SELECT * FROM donasi WHERE email = '$email' ORDER BY ke DESC LIMIT 1";
    		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    		$ambil_baca = $db->query($baca);
    		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    		$get_baca = mysqli_fetch_assoc($ambil_baca);
    		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    		$ke1 = $get_baca['ke'];
    		
    		header('Location:langkah3.php?ke='.$ke1);
    	}
    }
?>
<fieldset class="container">
	<div class="row">
		<div class="col-md-1"></div>
        <div class="col-md-10">
            <ul class="nav nav-pills nav-justified thumbnail" id="pills">
                <li class="active"><a data-toggle="">
                    <h4 class="list-group-item-heading">Langkah ke-1</h4>
                    <p class="list-group-item-text">Data Donasi</p>
                </a></li>
                <li><a data-toggle="">
                    <h4 class="list-group-item-heading">Langkah ke-2</h4>
                    <p class="list-group-item-text">Pembayaran</p>
                </a></li>
            </ul>

			<form action="#" method="post">
				<b><legend class="text-primary">Donasi</legend></b>

				<div class="col-md-1"></div>
				<div class="col-md-10 panel panel-default ">
					<div class="form-group">
						<label for="nominal">Nominal Donasi:</label><br>
						<div class="input-group">
							<div class="input-group-addon">Rp</div>
							<input type="number" min="50000" name="nominal" class="form-control input-md" 
							value="<?=((isset($_POST['nominal']))?$_POST['nominal']:'');?>"
							required oninvalid="this.setCustomValidity('Tolong isi nominal donasi anda lebih atau sama dengan 50000')"
							oninput="setCustomValidity('')">
						</div>
						
						<p class="text-danger">*Minimal Rp 50,000.00</p>
					</div>

					<div class="form-group">
						<label for="nominal">Lembaga Pendidikan yang Dituju:</label><br>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="paud" <?= ((isset($_POST['lembaga[]']) && in_array('paud', $_POST['lembaga[]']))?'checked':'') ?> /><label>PAUD</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="tk" <?= ((isset($_POST['lembaga[]']) && in_array('tk', $_POST['lembaga[]']))?'checked':'') ?> /><label>TK</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="sd" <?= ((isset($_POST['lembaga[]']) && in_array('sd', $_POST['lembaga[]']))?'checked':'') ?> /><label>SD</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="smp" <?= ((isset($_POST['lembaga[]']) && in_array('smp', $_POST['lembaga[]']))?'checked':'') ?> /><label>SMP</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="sma" <?= ((isset($_POST['lembaga[]']) && in_array('sma', $_POST['lembaga[]']))?'checked':'') ?> /><label>SMA</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="smk" <?= ((isset($_POST['lembaga[]']) && in_array('smk', $_POST['lembaga[]']))?'checked':'') ?> /><label>SMK</label>
						</div>
						<div class="col-md-3"><input type="checkbox" name="lembaga[]" value="pt" <?= ((isset($_POST['lembaga[]']) && in_array('pt', $_POST['lembaga[]']))?'checked':'') ?> /><label>Perguruan Tinggi</label>
						</div>
						<div class="col-md-3">
							<input type="checkbox" id="lain" name="lembaga[]" value="lain" <?= ((isset($_POST['lembaga[]']) && in_array('lain', $_POST['lembaga[]']))?'checked':'') ?> /><label>Lainnya</label>
							<div class="lembagaLain">
								<input type="text" class=" form-control" name="lain2">
								<p class="text-success">Pisahkan dengan koma (,) jika lebih dari satu.</p>
							</div>
						</div>
						<div class="col-md-12"><p class="text-danger tes">*Pilih Salah Satu atau Lebih</p></div>
					</div>
					
					<div class="form-group ">
						<label for="nominal">Peruntukan:</label><br>
						<div class="col-md-4"><input type="checkbox" name="untuk[]" value="fp" <?= ((isset($_POST['untuk[]']) && in_array('fp', $_POST['untuk[]']))?'checked':'') ?> /><label>Fasilitas Pendidikan</label>
						</div>
						<div class="col-md-4"><input type="checkbox" name="untuk[]" value="fu" <?= ((isset($_POST['untuk[]']) && in_array('fu', $_POST['untuk[]']))?'checked':'') ?> /><label>Fasilitas Umum</label>
						</div>

						<div class="col-md-4">
							<input type="checkbox" id="lain3" name="untuk[]" value="lain3" <?= ((isset($_POST['untuk[]']) && in_array('lain3', $_POST['untuk[]']))?'checked':'') ?> /><label>Lainnya</label>
							<div class="untukLain">
								<input type="text" class="form-control" name="lain4">
								<p class="text-success">Pisahkan dengan koma (,) jika lebih dari satu.</p>
							</div>
							
						</div>
					</div>
					<div class="col-md-12"><p class="text-danger">*Pilih Salah Satu atau Lebih</p></div>
					<div class="form-group col-md-12 text-center">
						<input type="submit" name="lanjutkan" value="lanjutkan" class="btn btn-primary">
					</div>
				</div>
				<div class="col-md-1"></div>
			</form>

        </div>
        <div class="col-md-1"></div>
	</div>
</fieldset>
<?php require 'isi/footer.php';?>