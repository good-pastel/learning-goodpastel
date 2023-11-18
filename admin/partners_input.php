<?php
include("inc_header.php");
?>
<?php
$nama           = "";
$isi            = "";
$foto           = "";
$foto_name      = "";
$error          = "";
$succeed        = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

if ($id != "") {
    $sql1           = "select * from partners where id = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nama           = $r1['nama'];
    $isi            = $r1['isi'];
    $foto           = $r1['foto'];

    if ($isi == '') {
        $error      = "Data Not Found.";
    }
}

if (isset($_POST['save'])) {
    $nama        = $_POST['nama'];
    $isi         = $_POST['isi'];

    if ($nama == '' or $isi == '') {
        $error  = "Please input the correct way.";
    }
    // Array ( )
    // print_r($_FILES);
    if($_FILES['foto']['name']){
        $foto_name = $_FILES['foto']['name'];
        $foto_file = $_FILES['foto']['tmp_name'];
        
        $detail_file = pathinfo($foto_name);
        $foto_ext = $detail_file['extension'];
        // print_r($detail_file);
        // Array ( [dirname] => . [basename] => foto.jpg [extension] => jpg [filename] => foto )
        $ext_boleh = array("jpg","jpeg","tiff","gif","png","Bitmap");
        if(!in_array($foto_ext,$ext_boleh)){
            $error = "extension invalid. Please upload in jgp, jpeg, tiff, gif, png, Bitmap";

        }
    }
    if (empty($error)) {
        if($foto_name){
            $direktori = "../gambar/";

            @unlink($direktori."/$foto"); //delete data

            $foto_name = "partners_".time()."_".$foto_name;
            move_uploaded_file($foto_file,$direktori."/".$foto_name);
            $foto = $foto_name;
        }else{
            $foto_name = $foto; //memasukkan data dari data yang sebelumnya ada
        }

        if($id != ""){
            $sql1           = "update partners set nama = '$nama', isi = '$isi', foto = '$foto_name', tgl_isi=now() where id = '$id'";
        }else{
            $sql1           = "INSERT INTO partners (nama,foto,isi) VALUES ('$nama','$foto_name','$isi')";
        }
        $q1             = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $succeed     = "Succees input data";
        } else {
            $error          = "failed to input data";
        }
    }
}
?>
<h1>Partners Admin</h1>
<div class="mb-3 row">
    <a href="partners.php">
        << Back to the Partners Admin</a>
</div>
<?php
if ($error) {
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php

}
?>
<?php
if ($succeed) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $succeed ?>
    </div>
<?php

}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" value="<?php echo $nama ?>" name="nama">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
        <div class="col-sm-10">
            <?php
            if($foto){
                echo "<img src='../gambar/$foto' style='max-height:100px; max-width:100px;'/>";
            }
            ?>
            <input type="file" class="form-control" id="foto" name="foto">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">isi</label>
        <div class="col-sm-10">
            <textarea name="isi" class="form-control" id="summernote"><?php echo $isi ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="save" value="Save" class="btn btn-primary" />
        </div>
    </div>
</form>

<?php include("inc_footer.php") ?>