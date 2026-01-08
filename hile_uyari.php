<?php
session_start();
include 'islemler/baglanti.php';
// Hileyi veritabanına kaydedelim (Hangi çocuk hileye tıkladı görelim)
$kayit = $db->prepare("INSERT INTO hile_kayitlari (ogrenci_id, seviye, aciklama) VALUES (?, 'Seviye 2', 'Kullanıcı crackli sürümü seçti.')");
$kayit->execute([$_SESSION['ogrenci_id']]);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SİSTEM HATASI!</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
    <style>
        body { background: #000; color: #0f0; font-family: 'Courier New', monospace; overflow: hidden; }
        .hack-text { text-align: left; font-size: 0.9rem; line-height: 1.2; }
        #kilit-ekrani { position: fixed; top:0; left:0; width:100%; height:100%; background: black; z-index:9999; display:flex; flex-direction:column; justify-content:center; align-items:center; }
        .progress-bar { width: 300px; height: 20px; border: 1px solid #0f0; margin-top: 20px; }
        #progress-fill { width: 0%; height: 100%; background: #0f0; }
    </style>
</head>
<body>
    <div id="kilit-ekrani">
        <h1 style="color: red; text-shadow: 0 0 10px red;">⚠️ VİRÜS TESPİT EDİLDİ ⚠️</h1>
        <p>Lisans kontrolü atlatılırken sisteme zararlı yazılım sızdı!</p>
        <div class="hack-text" id="log"></div>
        <div class="progress-bar"><div id="progress-fill"></div></div>
        <h2 id="timer">45</h2>
        <p>Sistem dosyaları kurtarılana kadar bekleyin...</p>
    </div>

    <script>
        const logs = [
            "> Root yetkisi alındı...", "> IP: 185.122.45.16 sunucusuna veri sızıyor...",
            "> Kamera aktif: Görüntü kaydediliyor...", "> Şifre dosyaları okunuyor: Gmail_pass.txt...",
            "> Kredi kartı bilgileri taranıyor...", "> Tüm dosyalar şifreleniyor (.Crypted)..."
        ];
        let i = 0;
        setInterval(() => {
            if(i < logs.length) {
                let p = document.createElement('p');
                p.innerText = logs[i];
                document.getElementById('log').appendChild(p);
                i++;
            }
        }, 3000);

        let s = 45;
        let fill = 0;
        const interval = setInterval(() => {
            s--;
            fill += (100/45);
            document.getElementById('timer').innerText = s;
            document.getElementById('progress-fill').style.width = fill + "%";
            if(s <= 0) {
                clearInterval(interval);
                alert("Simülasyon Bitti. Şimdi dürüst yola geri dön.");
                location.href = "seviye2_lisans.php"; // Bu satırı güncelleyin
            }
        }, 1000);
    </script>
</body>
</html>