<?php
session_start();
include 'baglanti.php';

if (isset($_GET['para']) && isset($_SESSION['ogrenci_id'])) {
    $id = $_SESSION['ogrenci_id'];
    $para = intval($_GET['para']);
    $dogru = intval($_GET['dogru']);

    // 1. Öğrencinin genel bakiye bilgisini güncelle
    $guncelle = $db->prepare("UPDATE ogrenciler SET para = ? WHERE id = ?");
    $guncelle->execute([$para, $id]);

    // 2. Seviye 1 detay tablosuna ekle
    $kayit = $db->prepare("INSERT INTO seviye1_sonuc (ogrenci_id, dogru_sayisi, kazanilan_para) VALUES (?, ?, ?)");
    $kayit->execute([$id, $dogru, $para]);

    echo "Başarılı";
}
?>