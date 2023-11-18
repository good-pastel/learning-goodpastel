<?php include("inc_header.php")?>
<h3>Forgot Password</h3>
<?php
if(isset($_SESSION['members_email']) != ''){
    header("location:index.php");
    exit(); 
}
$err    = "";
$sukses = "";
$email  = "";
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    if($email == ''){
        $err = "Enter Your Email Account";
    }else{
        $sql1   = " select * from members where email = '$email'";
        $q1     = mysqli_query($koneksi,$sql1);
        $n1     = mysqli_num_rows($q1);

        if($n1 < 1){
            $err = " Couldn't find <b>$email</b>";
        }
    }

    if(empty($err)){
        $token_ganti_password = md5(rand(0,1000));
        $judul_email          = "Change Password";
        $isi_email            = " Forgot your account password? Please click link below:</br>";
        $isi_email           .= url_dasar()."/ganti_password.php?email=$email&token=$token_ganti_password";
        kirim_email($email,$email,$judul_email,$isi_email);

        $sql1 = " update members set token_ganti_password = '$token_ganti_password' where email = '$email'";
        mysqli_query($koneksi,$sql1);
        $sukses = "We already sent a link to your Email Address. Please check your inbox.";

    }
}
?>
<?php if($err){echo"<div class='error'>$err</div>";}?>
<?php if($sukses){echo"<div class='sukses'>$sukses</div>";}?>
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td><input type="text" name="email" class="input" value="<?php echo $email?>"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="forgot password" class="tbl-biru"></td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>