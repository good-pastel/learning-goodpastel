<?php
include_once("inc/inc_koneksi.php");
include_once("inc/inc_fungsi.php");
// print_r($_SERVER);
$id = dapatkan_id();

$sql1 = "select * from halaman where id = '$id'";
$q1 = mysqli_query($koneksi, $sql1);
$n1 = mysqli_num_rows($q1);
$r1 = mysqli_fetch_array($q1);

$judul_halaman = $r1['subject'];

?>
<?php include_once("inc_header.php") ?>
<?php
if ($judul_halaman == "") {
    echo "<div><p>Sorry, Data wasn't found.</p></div>";
} else {
?>

    <p class="deskripsi"><?php echo $r1['quote'] ?></p>
    <h1><?php echo $r1['subject'] ?></h1>
    <p><?php echo set_isi($r1['description'])?></p>

<?php
}
?>
<?php include_once("inc_footer.php") ?>