<?php include("inc_header.php")?>
<?php
if($_SESSION['members_email'] == ''){
    header("location:login.php");
    exit();
}
?>
<style>
    a {
        color:#fc9b7d;
    }
    a:hover{
        color:#ffffff;
        cursor:pointer;
    }
</style>
<div style="background-color: #fdf2d4; font-size:large; padding-bottom: 40px; text-align:center; padding-top:40px; font-weight:bold; color:#8f0341;;">Welcome to the Secret Page, <?php echo $_SESSION['members_nama_lengkap'] ?>. Click <a href='<?php echo url_dasar()?>/post.php'>here</a> to see what's available on this website</div>
<?php include("inc_footer.php")?>