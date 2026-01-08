<?php
session_start();
include "../islemler/baglanti.php";

if (!isset($_SESSION["admin"])) {
    header("Location: admin_giris.php");
    exit;
}

$id = intval($_GET["id"]);
$ogrenci = mysqli_fetch_assoc(
    mysqli_query($baglanti, "SELECT * FROM ogrenciler WHERE id=$id")
);

$hileler = mysqli_query($baglanti, "
    SELECT * FROM hile_kayitlari WHERE ogrenci_id=$id
");
?>

<h3><?php echo $ogrenci["ad_soyad"]; ?></h3>
<p>Para: <?php echo $ogrenci["para"]; ?></p>
<p>Yildiz: <?php echo $ogrenci["yildiz"]; ?></p>
<p>Puan: <?php echo $ogrenci["puan"]; ?></p>

<h4>⚠️ Hile Kayitlari</h4>
<ul>
<?php while ($h = mysqli_fetch_assoc($hileler)) { ?>
    <li>Seviye <?php echo $h["seviye"]; ?> - <?php echo $h["aciklama"]; ?></li>
<?php } ?>
</ul>
