<?php include("inc_header.php")?>
<h3>Change Password</h3>
<?php
if(isset($_SESSION['members_email']) != ''){
    header("location:index.php");
    exit(); 
}
$err    = "";
$sukses = "";

$email = $_GET['email'];
$token = $_GET['token'];
if($email == '' or $token == ''){
    $err  .= " Link is not valid. Email and token is not available.";
}else{
    $sql1 = "select * from members where email ='$email' and token_ganti_password='$token'";
    $q1   = mysqli_query($koneksi,$sql1);
    $n1   = mysqli_num_rows($q1);

    if($n1 < 1){
        $err .= "Link is not valid. Email and token didn't match.";
    }
}

if(isset($_POST['submit'])){
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if($password == '' or $konfirmasi_password == ''){
        $err .= "Enter your password and confirm password.";
    }elseif($konfirmasi_password != $password){
        $err .= "Password didn't match. Please re-type correctly";
    }elseif(strlen($password) < 6){
        $err .= "Minimum password length is set to 6 or more character(s)";
    }
    if(empty($err)){
        $sql1 = "update members set token_ganti_password = '', password = md5($password) where email ='$email'";
        mysqli_query($koneksi,$sql1);
        $sukses = "Password successfully has been changed. Please <a href='".url_dasar()."/login.php'>login</a>.";
    }
}
?>
<?php if($err){echo"<div class='error'>$err</div>";}?>
<?php if($sukses){echo"<div class='sukses'>$sukses</div>";}?>
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Password</td>
            <td><input type="password" name="password" class="input"></td>
        </tr>
        <tr>
            <td class="label">Confirm Password</td>
            <td><input type="password" name="konfirmasi_password" class="input"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="save changes" class="tbl-biru"></td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>