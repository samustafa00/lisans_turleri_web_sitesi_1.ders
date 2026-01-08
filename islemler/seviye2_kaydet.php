<?php
session_start();
include 'baglanti.php';

if (isset($_GET['yildiz']) && isset($_SESSION['ogrenci_id'])) {
    $id = $_SESSION['ogrenci_id'];
    $toplamYildiz = intval($_GET['yildiz']);

    // 5 yıldız giriş için harcandı, kalanı puana gidecek
    $kalanYildiz = $toplamYildiz - 5; 

    // Bakiyeden 400 TL düş ve kalan yıldızları güncelle
    $guncelle = $db->prepare("UPDATE ogrenciler SET para = para - 400, yildiz = ? WHERE id = ?");
    $guncelle->execute([$kalanYildiz, $id]);

    header("Location: ../seviye3.php");
    exit;
}
?>