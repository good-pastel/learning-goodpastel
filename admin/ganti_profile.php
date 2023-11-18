<?php include("inc_header.php") ?>
<?php
$err        = "";
$sukses     = "";
if (isset($_POST['simpan'])) {
    

    $old_password           = $_POST['old_password'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];

    $sql1   = " select * from admin where username = '" . $_SESSION['admin_username'] . "'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    if (md5($old_password) != $r1['password']) {
        $err        .= "<li>Password didn't match. Please try again input correct password.</li>";
    }
    if ($old_password == '' or $password == '' or $konfirmasi_password == '') {
        $err        .= "<li>Please input the 'Old password', 'New Password', & 'Confirm Password'.</li>";
    }
    if ($password != $konfirmasi_password) {
        $err        .= "<li>Password didn't match. Please re-type password correctly.</li>";
    }
    if (strlen($password) < 6) {
        $err .= "<li>Minimum password length is set to 6 or more character(s)</li>";
    }

    if(empty($err)){
        $sql1 = " update admin set password = md5($password) where username = '".$_SESSION['admin_username']."'";
        mysqli_query($koneksi, $sql1);
        $sukses = "Password has been changed.";
    }
}
?>
<h1>Change Password</h1>
<?php
if($sukses){
    ?>
    <div class="alert alert-primary">
        <?php echo $sukses?>
    </div>
    <?php
}
?>
<?php
if($err){
    ?>
    <div class="alert alert-danger">
        <ul><?php echo $err?></ul>
    </div>
    <?php
}
?>
<form action="" method="POST">
    <div class="mb-3 row">
        <label for="old_password" class="col-sm-3 col-form-label">Old Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="old_password" name="old_password">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="password" class="col-sm-3 col-form-label">New Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="konfirmasi_password" class="col-sm-3 col-form-label">Confirm Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm"></div>
        <div class="col-sm-9">
            <input type="submit" class="btn btn-primary" name="simpan" value="Change New Password">
        </div>
    </div>
</form>
<?php include("inc_footer.php") ?>