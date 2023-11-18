<?php include("inc_header.php")?>
<?php
if(isset($_SESSION['members_email']) != ''){
    header("location:index.php");
    exit();
}
?>

<h3>Sign Up</h3>
<?php
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $email                  = $_POST['email'];
    $nama_lengkap           = $_POST['nama_lengkap'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];
    
    if($email =='' or $nama_lengkap =='' or $password == '' or $konfirmasi_password == ''){
        $err .= "<li>The fields cannot be blank.</li>";
    }
    if($email != ''){
        $sql1       = "select email from members where email = '$email'";
        $q1         = mysqli_query($koneksi, $sql1);
        $n1         = mysqli_num_rows($q1);
        if($n1 > 0){
            $err .="<li>Email is Already Registered.</li>";
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $err .="<li>Email Account is not valid.</li>";
        }
    }
    if($password != $konfirmasi_password){
        $err .="<li>Password didn't match. Please re-type correctly.</li>";
    }
    if(strlen($password) <6 ){
        $err .="<li>Enter your password. Minimum password length is set to 6 or more character(s)</li>";
    }

    if(empty($err)){
        $status         = md5(rand(0,1000));
        $judul_email    = "Sign Up Confirmation";
        $isi_email      = "Your account <b>$email</b> has been successfully registered.<br/>";
        $isi_email     .= "Please activate link bellow: </br>";
        $isi_email     .= url_dasar()."/verification.php?email=$email&kode=$status";

        kirim_email($email, $nama_lengkap, $judul_email, $isi_email);
        
        $sql1                           = "insert into members(email,nama_lengkap,password,status) values('$email', '$nama_lengkap', md5($password), '$status')";
        $q1                                = mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses = "Registration success. Please check your email inbox to verification.";
        }  
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
                <input type="text" name="email" class="input" value="<?php echo $email?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Full Name</td>
            <td>
                <input type="text" name="nama_lengkap" class="input" value="<?php echo $nama_lengkap?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td>
                <input type="password" name="password" class="input"/>
            </td>
        </tr>
        <tr>
            <td class="label">Confirm Password</td>
            <td>
                <input type="password" name="konfirmasi_password" class="input"/>
                <br/>
                Have already an account? <a href='<?php echo url_dasar()?>/login.php'>Login</a> here.
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="save changes" class="tbl-biru" />
            </td>
        </tr>
    </table>
</form>

<?php include("inc_footer.php")?>