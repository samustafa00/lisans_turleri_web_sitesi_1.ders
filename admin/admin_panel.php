

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
    <title>Yönetim Paneli</title>
    <link rel="stylesheet" href="../varliklar/css/stil.css">
    <style>
        body { align-items: flex-start; padding: 50px; }
        table { width: 100%; border-collapse: collapse; background: #1e293b; color: white; border-radius: 15px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #334155; }
        th { background: #334155; color: #38bdf8; }
        .danger-row { background: rgba(239, 68, 68, 0.2) !important; }
    </style>
</head>
<body>
    <div style="width: 100%;">
        <h1>🖥️ Öğrenci Takip</h1>
        <table>
            <thead>
                <tr>
                    <th>Öğrenci Adı</th>
                    <th>Para</th>
                    <th>Yıldız</th>
                    <th>Final Puanı</th>
                    <th>Hile Durumu</th>
                    <th>Detay</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ogrenciler = $db->query("SELECT * FROM ogrenciler ORDER BY id DESC")->fetchAll();
                foreach($ogrenciler as $o):
                    // Hile kaydı var mı kontrol et
                    $hk = $db->prepare("SELECT COUNT(*) FROM hile_kayitlari WHERE ogrenci_id = ?");
                    $hk->execute([$o['id']]);
                    $hasHacked = $hk->fetchColumn() > 0;
                ?>
                <tr class="<?php echo $hasHacked ? 'danger-row' : ''; ?>">
                    <td><?php echo $o['ad_soyad']; ?></td>
                    <td><?php echo $o['para']; ?> TL</td>
                    <td>⭐ <?php echo $o['yildiz']; ?></td>
                    <td><strong><?php echo $o['puan']; ?></strong></td>
                    <td><?php echo $hasHacked ? '🚨 Hileye Tıkladı' : '✅ Güvenli'; ?></td>
                    <td><button class="btn-basla" style="padding: 5px 10px; font-size: 0.8rem;" onclick="alert('Öğrenci ID: <?php echo $o['id']; ?>')">İncele</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>