<?php require 'isi/header.php';?>
<?php

if(isset($_POST['lanjutkan'])){
    $nama = sanitize($_POST['nama']);
    $kelamin = sanitize($_POST['kelamin']);
    $tempat_lahir = sanitize($_POST['tempat_lahir']);
    $tanggal_lahir = sanitize($_POST['tanggal_lahir']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp']);

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
    

    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        $sql_donatur =  "UPDATE donatur SET 
        nama = '$nama', 
        kelamin = '$kelamin', 
        tempat_lahir = '$tempat_lahir', 
        tanggal_lahir = '$tanggal_lahir',
        alamat = '$alamat',
        telp = '$no_telp'
        WHERE email =$email
        ";
        $sql_kantor = "UPDATE kantor SET
        nama = '$kantor',
        unit = '$unit',
        jabatan = '$jabatan',
        alamat = '$alamat_kantor'
        WHERE email =$email
        ";
        
        $db->query($sql_donatur);
        $db->query($sql_kantor);
    }
    $ambil_donatur = "SELECT * FROM donatur WHERE email = '$email'";
    $result_donatur = $db->query($ambil_donatur);	
    $donatur = mysqli_fetch_assoc($result_donatur);

    $ambil_kantor = "SELECT * FROM kantor WHERE email = '$email'";
    $result_kantor = $db->query($ambil_kantor);	
    $kantor = mysqli_fetch_assoc($result_kantor);
 }
?>
<fieldset class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form action="aturIdentitas.php" method="post">
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
                        <label for="kelamin">Jenis Kelamin</label><br>
                        <?php createRadioOption('kelamin', '1',  'Laki-laki'); ?>
                        <?php createRadioOption('kelamin', '2',  'Perempuan'); ?>
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir:</label><br>
                        <input type="text" name="tempat_lahir" class="form-control" 
                        value="<?=((isset($_POST['tempat_lahir']))?$_POST['tempat_lahir']:'');?>"
                        required oninvalid="this.setCustomValidity('Tolong Isi Tempat Lahir Anda')"
                        oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir:</label><br>
                        <input type="date" name="tanggal_lahir" class="form-control" 
                        value="<?=((isset($_POST['tanggal_lahir']))?$_POST['tanggal_lahir']:'');?>" 
                        required oninvalid="this.setCustomValidity('tolong isi tanggal lahir')"
                        oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Rumah:</label><br>
                        <textarea name="alamat" class="form-control" 
                        required oninvalid="this.setCustomValidity('Tolong Isi Alamat Rumah Anda')" oninput="setCustomValidity('')"><?= ((isset($_POST['alamat']))?$_POST['alamat']:'');?></textarea>
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon/HP:</label><br>
                        <input type="number" name="no_telp" class="form-control" 
                        value="<?=((isset($_POST['no_telp']))?$_POST['no_telp']:'');?>"
                        required oninvalid="this.setCustomValidity('Tolong Isi Nomor Telepon/HP Anda')" oninput="setCustomValidity('')">
                        <p class="text-danger">*Dibutuhkan</p>
                    </div>

                </div>
                <div class="col-md-1"></div>

                <b><legend class="text-primary">Data Kantor</legend></b>

                <div class="col-md-1"></div>
                <div class="col-md-10 panel panel-default">
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

                    <div class="form-group col-md-12 text-center">
                        <p><b>Harap Cek kembali Apakah data sudah benar atau belum.</b></p>
                        <input type="submit" name="lanjutkan" value="Update" class="btn btn-primary">
                    </div>
                </div>
                <div class="col-md-1"></div>
            </form>


        </div>
        <div class="col-md-1"></div>
    </div>
</fieldset>
<?php require 'isi/footer.php';?>