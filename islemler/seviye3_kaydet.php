<?php
session_start();
include 'baglanti.php';

$id = $_SESSION['ogrenci_id'];
$oyun_skoru = intval($_GET['skor']); // Eşleştirme oyunundan gelen puan

$sorgu = $db->prepare("SELECT para, yildiz FROM ogrenciler WHERE id = ?");
$sorgu->execute([$id]);
$o = $sorgu->fetch();

// FORMÜL: Oyun Skoru + Kalan Para + (Kalan Yıldız * 50)
$toplam_puan = $oyun_skoru + $o['para'] + ($o['yildiz'] * 50);

$guncelle = $db->prepare("UPDATE ogrenciler SET puan = ? WHERE id = ?");
$guncelle->execute([$toplam_puan, $id]);

header("Location: ../sonuc.php");
exit;
?>