<?php include("../website/inc_header.php")?>
<?php 
if($_SESSION['members_email'] == ''){
    header("location:index.php");
    exit();
}
?>

<?php
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
?>

<body>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="what do you want to know?" name="katakunci" value="<?php echo $katakunci ?>" style="padding: 5px; />
    </div>
    <br/>
    <div class="col-auto">
        <input type="submit" name="cari" value="Search" class="btn btn-secondary" style="padding: 5px;" />
    </div>
</form>
<?php
        $sqltambahan = "";
        $per_halaman = 2;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(subject like '%" . $array_katakunci[$x] . "%' or quote like '%" . $array_katakunci[$x] . "%' or description like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan     = "where" . implode("or", $sqlcari);
        }
        $sql1       = "select * from halaman $sqltambahan";
        $page       = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai      = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1         = mysqli_query($koneksi, $sql1);
        $total      = mysqli_num_rows($q1);
        $pages      = ceil($total / $per_halaman);
        $nomor      = $mulai + 1;
        $sql1       = $sql1." order by id desc limit $mulai, $per_halaman";

        $q1         = mysqli_query($koneksi, $sql1);
        
        while ($r1 = mysqli_fetch_array($q1)) {
            ?>
       <div class="kolom">
        <p class="deskripsi"><?php echo $r1['quote'] ?></p>
        <h2><?php echo $r1['subject'] ?></h2>
        <p><?php echo maximum_kata(ambil_isi($r1['id']), 30) ?></p>
        <p><a href="<?php echo (buat_link_post($r1['id'])) ?>" class="tbl-2">Read more...</a></p>
    </div>
    <?php
        }
        ?>
</body>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
        $cari      = isset($_GET['cari'])? $_GET['cari']: "";
        for($i=1;  $i <= $pages; $i++){
            ?>
            <li class="page-item">
                <a class="page-link" href="post.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
</html>
<?php include("../website/inc_footer.php")?>