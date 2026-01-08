<?php
session_start();
include 'baglanti.php';

if (isset($_SESSION['ogrenci_id'])) {
    $id = $_SESSION['ogrenci_id'];
    
    // 300 TL düş
    $guncelle = $db->prepare("UPDATE ogrenciler SET para = para - 300 WHERE id = ?");
    $guncelle->execute([$id]);

    // Yıldız toplama etkinliğine (eski seviye2.php) gönder
    header("Location: ../seviye2_etkinlik.php");
}
?>