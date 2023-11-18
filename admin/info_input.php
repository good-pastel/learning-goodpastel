<?php
include("inc_header.php");
?>
<?php
$subject        = "";
$description    = "";
$error          = "";
$succeed        = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

if ($id != "") {
    $sql1           = "select * from info where id = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $subject        = $r1['subject'];
    $description    = $r1['description'];

    if ($description == '') {
        $error      = "Data Not Found.";
    }
}

if (isset($_POST['save'])) {
    $subject        = $_POST['subject'];
    $description    = $_POST['description'];

    if ($subject == '' or $description == '') {
        $error  = "Please input the correct way.";
    }
    if (empty($error)) {
        if($id != ""){
            $sql1       = "update info set subject = '$subject', description = '$description', tgl_isi=now() where id = '$id'";
        }else{
            $sql1           = "INSERT INTO info (subject,description) VALUES ('$subject','$description')";
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
<h1>Admin Page Input Info</h1>
<div class="mb-3 row">
    <a href="info.php">
        << Back to the info Page</a>
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
<form action="" method="post">
    <div class="mb-3 row">
        <label for="subject" class="col-sm-2 col-form-label">Subject</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="subject" value="<?php echo $subject ?>" name="subject">
        </div>
    </div>
    
    <div class="mb-3 row">
        <label for="description" class="col-sm-2 col-form-label">description</label>
        <div class="col-sm-10">
            <textarea name="description" class="form-control" id="summernote"><?php echo $description ?></textarea>
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