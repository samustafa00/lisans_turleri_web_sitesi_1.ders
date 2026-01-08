<?php
session_start();
include '../islemler/baglanti.php'; // Veritabanı bağlantısını dahil ediyoruz

$hata = "";

if ($_POST) {
    $kullanici = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    // PDO kullanarak güvenli sorgu yapıyoruz
    $sorgu = $db->prepare("SELECT * FROM adminler WHERE kullanici_adi = ? AND sifre = ?");
    $sorgu->execute([$kullanici, $sifre]);
    $admin = $sorgu->fetch();

    if ($admin) {
        $_SESSION['admin_giris'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admin_panel.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="../varliklar/css/stil.css">
</head>
<body>
    <div class="ana-kart">
        <h1>🔒 Yönetim Paneli</h1>
        <?php if($hata): ?>
            <p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 10px; border-radius: 8px;">
                <?php echo $hata; ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="kullanici_adi" class="giris-input" placeholder="Admin Kullanıcı Adı" required>
            <input type="password" name="sifre" class="giris-input" placeholder="Şifre" required>
            <button type="submit" class="btn-basla">SİSTEME GİRİŞ YAP</button>
        </form>
        <br>
        <a href="../index.php" style="color: #94a3b8; text-decoration: none; font-size: 0.8rem;">← Öğrenci Girişine Dön</a>
    </div>
</body>
</html>