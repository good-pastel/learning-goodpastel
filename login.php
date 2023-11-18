<?php include("inc_header.php")?>
<h3>Login into Member Page</h3>
<?php
$email      = "";
$password   = "";
$err        = "";

if(isset($_POST['login'])){
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    if($email == '' or $password == ''){
        $err .= "<li>The fields cannot be blank.</li>";
    }else{
        $sql1       = "select * from members where email = '$email'";
        $q1         = mysqli_query($koneksi, $sql1);
        $r1         = mysqli_fetch_array($q1);
        $n1         = mysqli_num_rows($q1);

        if($r1['status'] != '1' && $n1 > 0){
                $err  = "<li>Your account hasn't been activated yet. Please confirm your Email.</li>";
        }

        if($r1['password'] != md5($password) && $n1 > 0 && $r1['status'] !='1'){
                $err  = "<li>Password didn't match. Please re-type correctly.</li>";
        }

        if($n1 < '1'){
                $err  = "<li>Couldn't found your Email Account.</li>";
        }

        if(empty($err)){
            $_SESSION['members_email'] = $email;
            $_SESSION['members_nama_lengkap'] = $r1['nama_lengkap'];
            header("location:secr3t.php");
            exit();
        }
    }
}
?>
<?php if($err){echo "<div class ='error'><ul class='pesan'>$err</ul></div>";}?>
<!-- <?php if($sukses){echo "<div class ='sukses'>$sukses</div>";}?> -->
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td><input type="text" name="email" class="input" value="<?php echo $email?>"></td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td><input type="password" name="password" class="input"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login" value="login" class="tbl-biru"></td>
            <td><p><a href='<?php echo url_dasar()?>/forgot_password.php'>forgotten password?</a></p></td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>