<?php
session_start();
include 'islemler/baglanti.php';
if (!isset($_SESSION['ogrenci_id'])) { header("Location: index.php"); exit; }

$id = $_SESSION['ogrenci_id'];

// Öğrencinin son verilerini çekiyoruz
$sorgu = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
$sorgu->execute([$id]);
$ogrenci = $sorgu->fetch();

// Hile kontrolü
$hileSorgu = $db->prepare("SELECT COUNT(*) FROM hile_kayitlari WHERE ogrenci_id = ?");
$hileSorgu->execute([$id]);
$hileYaptiMi = $hileSorgu->fetchColumn() > 0;

// Detaylı Puan Hesaplama Bilgisi (Öğrenciye göstermek için)
$kalanYildiz = $ogrenci['yildiz']; // Veritabanında zaten 5 tanesi düşülmüş hali var
$yildizBonusu = $kalanYildiz * 50;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Maceranın Sonu | Başarı Belgesi</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
    <style>
        .sertifika { border: 4px solid #38bdf8; padding: 40px; border-radius: 30px; position: relative; }
        .puan-detay-list { text-align: left; background: rgba(0,0,0,0.2); padding: 20px; border-radius: 15px; margin: 20px 0; }
        .puan-satir { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px; }
        .toplam-skor-box { font-size: 2.5rem; color: #4ade80; font-weight: 800; text-shadow: 0 0 15px rgba(74, 222, 128, 0.5); }
        .rozet { font-size: 5rem; filter: drop-shadow(0 0 10px #fbbf24); }
    </style>
</head>
<body>
    <div class="ana-kart sertifika" style="width: 650px;">
        <div class="rozet">🏆</div>
        <h1>GÖREV TAMAMLANDI!</h1>
        <p>Tebrikler <strong><?php echo htmlspecialchars($ogrenci['ad_soyad']); ?></strong>!</p>
        <p>Lisanslı ve güvenli oyun yolculuğunu başarıyla bitirdin.</p>
        
        <div class="puan-detay-list">
            <div class="puan-satir">
                <span>💰 Harcamalar Sonrası Kalan Nakit:</span>
                <span>+ <?php echo $ogrenci['para']; ?></span>
            </div>
            <div class="puan-satir">
                <span>⭐ Kalan Yıldız Bonusu (<?php echo $kalanYildiz; ?> x 50):</span>
                <span>+ <?php echo $yildizBonusu; ?></span>
            </div>
            <div class="puan-satir">
                <span>🎮 Oyun Performans Puanı:</span>
                <span>Dahil Edildi</span>
            </div>
            <div style="text-align: center; margin-top: 15px;">
                <div style="font-size: 0.9rem; color: #94a3b8;">GENEL TOPLAM PUAN</div>
                <div class="toplam-skor-box"><?php echo $ogrenci['puan']; ?></div>
            </div>
        </div>

        <?php if($hileYaptiMi): ?>
            <div style="background: rgba(248, 113, 113, 0.1); padding: 15px; border-radius: 10px; border: 1px solid #f87171; margin-bottom: 20px;">
                <p style="color: #f87171; font-weight: bold; margin: 0;">⚠️ SİBER RİSK UYARISI</p>
                <p style="font-size: 0.85rem; margin: 5px 0 0 0;">Yolculuğunda kısa yoldan gitmeyi (hile) denedin ve sistemin nasıl tehlikeye girdiğini gördün. Unutma, gerçek hayatta "Geri Dön" butonu olmayabilir!</p>
            </div>
        <?php else: ?>
            <p style="color: #4ade80; font-weight: bold;">🛡️ TAM GÜVENLİK: Hiçbir riskli yola sapmadan etik bir kahraman gibi ilerledin!</p>
        <?php endif; ?>

        <a href="cikis.php"><button class="btn-basla" style="background: linear-gradient(135deg, #475569 0%, #1e293b 100%);">MACERAYI BİTİR</button></a>
    </div>
</body>
</html>