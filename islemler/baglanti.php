<?php
$host = "localhost"; // Genelde localhost olarak kalır
$db_ad = "samustafa_lisans_oyunu"; // Panelde oluşturduğunuz TAM veritabanı adı
$kullanici = "samustafa_admin";    // Panelde oluşturduğunuz TAM kullanıcı adı
$sifre = "Mustafa21."; // Belirlediğiniz güçlü şifre

try {
    $db = new PDO("mysql:host=$host;dbname=$db_ad;charset=utf8mb4", $kullanici, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>