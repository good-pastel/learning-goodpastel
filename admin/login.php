<?php
session_start();
if(isset($_SESSION['admin_username']) != ''){
    header("location:index.php");
}
include("../inc/inc_koneksi.php");

$username   = "";
$password   = "";
$err        = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == '' or $password == ''){
           $err        = "Please input the correct way"; 
    }else{
        $sql1 = "select * from admin where username = '$username'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);
        $n1 = mysqli_num_rows($q1);

        if($n1 < 1){
            $err = "username not found";
        }elseif($r1['password'] != md5($password)){
            $err = "password didn't match";
        }else{
            $_SESSION['admin_username'] = $username;
            header("location:index.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin Login Page</title>
</head>
<body style="width: 100%; max-width: 500px; margin:auto; margin-top: 100px; padding: 15px; background-color:azure;">
    <form action="" method="POST">
        <h1>Admin Login Page</h1>
        <div class="form-group">
            <label for="username" style="margin-left:5px;" >Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Please input your username" value="<?php echo $username?>" style="margin-bottom:5px;">
        </div>
        <div class="form-group">
            <label for="password" style="margin-left:5px;">Password</label>
            <input type="password" class="form-control" id="password" name="password" style="margin-bottom:5px;"/>
        </div>
        <button type="submit" class="btn btn-primary" name="login" style="margin-top:15px; margin-bottom:15px;">Login</button>
        <?php
            if($err){
             ?>
             <div class="alert alert-danger">
                <?php echo $err ?>
             </div>
             <?php   
            }
        ?>
    </form>
</body>
</html>