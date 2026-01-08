<?php
session_start();
if (!isset($_SESSION['admin_giris'])) {
    header("Location: admin_giris.php");
    exit;
}
include '../islemler/baglanti.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../varliklar/css/stil.css">
    <meta http-equiv="refresh" content="5"> <style>
        .leader-row { display: flex; align-items: center; background: rgba(255,255,255,0.05); margin: 5px; padding: 15px; border-radius: 10px; border-left: 5px solid #38bdf8; }
        .rank { font-size: 2rem; width: 50px; font-weight: 800; color: #fbbf24; }
        .name { flex: 1; font-size: 1.5rem; text-align: left; padding-left: 20px; }
        .score { font-family: 'Courier New'; font-weight: bold; color: #4ade80; font-size: 1.8rem; }
    </style>
</head>
<body style="background: #020617;">
    <div style="width: 90%; text-align: center;">
        <h1 style="font-size: 3rem; text-shadow: 0 0 20px #38bdf8;">🏆 GÜNCEL SIRALAMA 🏆</h1>
        
        <?php
        $siralama = $db->query("SELECT * FROM ogrenciler ORDER BY puan DESC LIMIT 10")->fetchAll();
        $rank = 1;
        foreach($siralama as $ogrenci):
        ?>
            <div class="leader-row">
                <div class="rank">#<?php echo $rank++; ?></div>
                <div class="name"><?php echo $ogrenci['ad_soyad']; ?></div>
                <div class="details" style="margin-right: 30px; color: #94a3b8;">
                    💰 <?php echo $ogrenci['para']; ?> | ⭐ <?php echo $ogrenci['yildiz']; ?>
                </div>
                <div class="score"><?php echo $ogrenci['puan']; ?> Puan</div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>