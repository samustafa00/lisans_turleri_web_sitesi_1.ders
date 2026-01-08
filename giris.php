<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
</head>
<body>
    <div class="ana-kart">
        <h2>Kimliğini Belirle</h2>
        <p>Skor tablosunda görünmek için adını yazmalısın.</p>
        
        <form action="islemler/giris_kontrol.php" method="POST">
            <input type="text" name="ad_soyad" class="giris-input" placeholder="Adınız ve Soyadınız" required>
            <button type="submit" class="btn-basla">OYUNA GİR</button>
        </form>
    </div>
</body>
</html>