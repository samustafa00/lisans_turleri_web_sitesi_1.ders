<?php
session_start();
include 'islemler/baglanti.php';
if (!isset($_SESSION['ogrenci_id'])) { header("Location: index.php"); exit; }

$id = $_SESSION['ogrenci_id'];
$sorgu = $db->prepare("SELECT para FROM ogrenciler WHERE id = ?");
$sorgu->execute([$id]);
$ogrenci = $sorgu->fetch();
$mevcut_para = $ogrenci['para'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Seviye 2: Lisans Kararı</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
</head>
<body>
    <div class="ana-kart" style="width: 700px;">
        <h2>🔐 Yazılım Lisanslama</h2>
        <p>Seviye 3'e geçebilmek için lisanslı bir yazılıma ihtiyacın var.</p>
        <div class="skor-board" style="background: #1e293b; padding: 10px; color: #fbbf24;">
            Cüzdanındaki Para: <strong><?php echo $mevcut_para; ?> TL</strong>
        </div>

        <div style="flex: 1; padding: 20px; border: 1px solid #334155; border-radius: 15px;">
            <h3>Resmi Lisans</h3>
            <p>Güvenli ve yasal sürüm.</p>
            <p><strong>Fiyat: 300 TL</strong></p>
            
            <?php if($mevcut_para >= 300): ?>
                <button class="btn-basla" onclick="location.href='islemler/lisans_odeme.php'">SATIN AL</button>
            <?php else: ?>
                <p style="color: #ef4444; font-weight: bold; font-size: 0.9rem;">Bakiyen yetersiz!</p>
                <button class="btn-basla" style="background: #475569;" onclick="location.href='seviye1.php'">
                    YETERSİZ BAKİYE (TEKRAR DENE)
                </button>
                <p style="font-size: 0.8rem; margin-top: 5px; color: #94a3b8;">
                    Lisans almak için Seviye 1'e dönüp daha fazla doğru cevap vermelisin.
                </p>
            <?php endif; ?>
        </div>

            <div style="flex: 1; padding: 20px; border: 1px solid #ef4444; border-radius: 15px;">
                <h3 style="color: #ef4444;">Hileli / Crackli</h3>
                <p>Bedava ama riskli...</p>
                <button class="btn-basla" style="background: #ef4444;" onclick="if(confirm('Riskleri kabul ediyor musun?')) location.href='hile_uyari.php'">BEDAVA İNDİR</button>
            </div>
        </div>
    </div>
</body>
</html>