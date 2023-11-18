<?php include("inc_header.php")?>
<?php
if(isset($_SESSION['members_email']) == ''){
    header("location:login.php");
    exit();
}
?>

<h3>Edit Profile</h3>
<?php
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $nama_lengkap           = $_POST['nama_lengkap'];
    $old_password           = $_POST['old_password'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];
    
    if($nama_lengkap == ''){
        $err            .= "<li>Please input your full name</li>";
    }

    if($password != ''){ //jika akan melakukan perubahan password//
        $sql1   = " select * from members where email = '".$_SESSION['members_email']."'";
        $q1     = mysqli_query($koneksi,$sql1);
        $r1     = mysqli_fetch_array($q1);
        if(md5($old_password) != $r1['password']){
            $err        .= "<li>Password didn't match. Please try again input correct password.</li>";
        }
        if($old_password == '' or $password == '' or $konfirmasi_password == ''){
            $err        .= "<li>Please input the 'Old password', 'New Password', & 'Confirm Password'.</li>";
        }
        if($password != $konfirmasi_password){
            $err        .= "<li>Password didn't match. Please re-type password correctly.</li>";
        }
        if(strlen($password) < 6){
            $err .= "<li>Minimum password length is set to 6 or more character(s)</li>";
        }

    }

    if(empty($err)){
        $sql1 = " update members set nama_lengkap = '".$nama_lengkap."' where email = '".$_SESSION['members_email']."'";
        mysqli_query($koneksi,$sql1);
        $_SESSION['members_nama_lengkap'] == $nama_lengkap;

        if($password){
            $sql2 = " update members set password = md5($password) where email = '".$_SESSION['members_email']."'";
            mysqli_query($koneksi,$sql2);
        }

        $sukses = "Data Profile has been changed.";

    }

}

?>
<?php if($err){echo "<div class='error'><ul>$err</ul></div>";}?>
<?php if($sukses){echo "<div class='sukses'><ul>$sukses</ul></div>";}?>

<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td>
                <?php echo $_SESSION['members_email']?>
            </td>
        </tr>
        <tr>
            <td class="label">Full Name</td>
            <td>
                <input type="text" name="nama_lengkap" class="input" value="<?php echo $_SESSION['members_nama_lengkap']?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Old Password</td>
            <td>
                <input type="password" name="old_password" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">New Password</td>
            <td>
                <input type="password" name="password" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">Confirm Password</td>
            <td>
                <input type="password" name="konfirmasi_password" class="input"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="save" class="tbl-biru" />
            </td>
        </tr>
    </table>
</form>

<?php include("inc_footer.php")?>