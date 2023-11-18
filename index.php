<?php include_once("inc_header.php") ?>
<section id="home">
    <img src="<?php echo ambil_gambar('11') ?>">
    <div class="kolom">
        <p class="deskripsi"><?php echo ambil_kutipan('11') ?></p>
        <h2><?php echo ambil_subject('11') ?></h2>
        <p><?php echo maximum_kata(ambil_description('11'), 30) ?></p>
        <p><a href="<?php echo buat_link_halaman('11') ?>" class="tbl-2">Read more...</a></p>
    </div>
</section>
<section id="courses">
    <div class="kolom">
        <p class="deskripsi"><?php echo ambil_kutipan('12') ?></p>
        <h2><?php echo ambil_subject('12') ?></h2>
        <p><?php echo maximum_kata(ambil_description('12'), 30) ?></p>
        <p><a href="<?php echo buat_link_halaman('12') ?>" class="tbl-2">Read more...</a></p>
    </div>
    <img src="<?php echo ambil_gambar('12') ?>">
</section>
<section id="tutors">
    <div class="tutor-s">
        <div class="kolom">
            <p class="deskripsi"> Our Top Tutors</p>
            <h2>Tutors</h2>
            <p><i>"You don't have to be great to start, but you have to start to be great."</i></p>
        </div>
        <div class="tutor-list">
            <?php
            $sql1 = "select * from tutors order by id desc";
            $q1 = mysqli_query($koneksi, $sql1);
            while ($r1 = mysqli_fetch_array($q1)) {
            ?>
                <div class="kartu-tutor">
                    <a href="<?php echo buat_link_tutors($r1['id']) ?>">
                        <img src="<?php echo url_dasar() . "/gambar/" . tutors_foto($r1['id']) ?>" />
                        <p><?php echo $r1['nama'] ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<section id="partners">
    <div class="tutor-s">
        <div class="kolom">
            <p class="deskripsi">Our Top Partners</p>
            <h2>Partners</h2>
            <p><i>"You don't have to be great to start, but you have to start to be great."</i></p>
        </div>
        <div class="partner-list">
            <?php
            $sql1 = "select * from partners order by id asc";
            $q1 = mysqli_query($koneksi, $sql1);
            while ($r1 = mysqli_fetch_assoc($q1)) {
            ?>      <div class="kartu-partner">
                    <a href="<?php echo buat_link_partners($r1['id']) ?>">
                    <img src="<?php echo url_dasar()."/gambar/".partners_foto($r1['id'])?>"/>
                    </a>
                    </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?php include_once("inc_footer.php") ?>