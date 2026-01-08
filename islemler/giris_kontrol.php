<?php
session_start();
include 'baglanti.php';

if ($_POST) {
    $ad_soyad = htmlspecialchars($_POST['ad_soyad']);
    
    // Öğrenciyi veritabanına ekle
    $sorgu = $db->prepare("INSERT INTO ogrenciler (ad_soyad) VALUES (?)");
    $sorgu->execute([$ad_soyad]);
    
    // Eklenen öğrencinin ID'sini al ve session'a kaydet
    $_SESSION['ogrenci_id'] = $db->lastInsertId();
    $_SESSION['ogrenci_ad'] = $ad_soyad;
    
    // Seviye 1'e yönlendir
    header("Location: ../seviye1.php");
}
?>