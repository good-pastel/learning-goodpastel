<?php include("inc_header.php") ?>
<?php
$succeed = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id   = $_GET['id'];
    $sql1 = "delete from halaman where id = '$id' ";
    $q1   = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $succeed    = "success delete file.";
    }
}
?>
<h1>Admin Page</h1>
<p>
    <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Create New Page" />
    </a>
</p>
<?php
if ($succeed) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $succeed ?>
    </div>
<?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Search here" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Search" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Subject</th>
            <th>Quote</th>
            <th class="col-2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 5;
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
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['subject'] ?></td>
                <td><?php echo $r1['quote'] ?></td>
                <td>
                    <a href="halaman_input.php?id=<?php echo $r1 ['id']?>">
                    <span class="badge bg-warning text-dark">Edit</span>
                    </a>
                    <a href="halaman.php?op=delete&id=<?php echo $r1['id'] ?>" onclick="return confirm('Are you sure you want to delete this file?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>

    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
        $cari      = isset($_GET['cari'])? $_GET['cari']: "";
        for($i=1;  $i <= $pages; $i++){
            ?>
            <li class="page-item">
                <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>