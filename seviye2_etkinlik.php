<?php
session_start();
include 'islemler/baglanti.php';
if (!isset($_SESSION['ogrenci_id'])) { header("Location: index.php"); exit; }

// Veritabanından en güncel para bilgisini alıyoruz
$sorgu = $db->prepare("SELECT para FROM ogrenciler WHERE id = ?");
$sorgu->execute([$_SESSION['ogrenci_id']]);
$ogrenci = $sorgu->fetch();
$mevcut_para = $ogrenci['para'] ? $ogrenci['para'] : 0;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Seviye 2: Final Kararı</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
    <style>
        .karar-kart { background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; margin-top: 20px; }
        .durum-cubugu { display: flex; justify-content: space-between; background: #1e293b; padding: 15px; border-radius: 10px; margin-bottom: 20px; color: #fbbf24; font-weight: bold; }
        .secenek-konteynir { display: flex; gap: 20px; margin-top: 20px; }
        .secenek-kart { flex: 1; padding: 20px; border-radius: 15px; background: rgba(255,255,255,0.1); border: 2px solid #334155; }
        .btn-secenek { background: #334155; color: white; border: none; padding: 12px; border-radius: 10px; cursor: pointer; width: 100%; margin-top: 10px; text-align: left; }
        .btn-secenek:hover { background: #475569; }
    </style>
</head>
<body>
    <div class="ana-kart" style="width: 800px;">
        <div class="durum-cubugu">
            <span>💰 Cüzdan: <span id="ekran-para"><?php echo $mevcut_para; ?></span> TL</span>
            <span>⭐ Toplanan Yıldız: <span id="yildiz-sayisi">0</span> / 8</span>
        </div>
        
        <div id="etkinlik-alan">
            <h2 id="senaryo-baslik">Yükleniyor...</h2>
            <div class="karar-kart">
                <p id="senaryo-metni"></p>
                <div id="secenekler"></div>
            </div>
        </div>

        <div id="final-onay" style="display:none; text-align: center;">
            <h2 style="color: #fbbf24;">⚠️ SEVİYE 3 ÖNCESİ SON SEÇİM ⚠️</h2>
            <p>Parkuru tamamladın. Mevcut durumunla hangi yolu seçeceksin?</p>
            
            <div class="secenek-konteynir">
                <div class="secenek-kart" style="border-color: #4ade80;">
                    <h3 style="color: #4ade80;">Resmi Lisans</h3>
                    <p style="font-size: 0.85rem;">Güvenli ve etik yol.</p>
                    <p><strong>Bedel: 400 TL + 5 Yıldız</strong></p>
                    <button class="btn-basla" style="background:#22c55e" onclick="lisansKontrol()">LİSANSLI BAŞLAT</button>
                </div>

                <div class="secenek-kart" style="border-color: #ef4444;">
                    <h3 style="color: #ef4444;">Hileli Sürüm</h3>
                    <p style="font-size: 0.85rem;">Bedava ama riskli.</p>
                    <p><strong>Bedel: 0 TL</strong></p>
                    <button class="btn-basla" style="background:#ef4444" onclick="location.href='hile_uyari.php'">HİLELİ DENE</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const senaryolar = [
            { s: "Yeni indirdiğin bir oyun rehberindeki tüm kişilere erişim izni istiyor. Ne yaparsın?", c: [{t:"İzin Ver", y:0}, {t:"Reddet", y:1}, {t:"İzinleri İncele", y:2}]},
            { s: "Bilgisayarında 'Lisanssız Yazılım Algılandı' uyarısı çıktı. Ne yaparsın?", c: [{t:"Hemen Sil", y:2}, {t:"İnterneti Kapat", y:0}, {t:"Antivirüsü Devre Dışı Bırak", y:0}]},
            { s: "Arkadaşın sana pahalı bir oyunun crackli dosyasını gönderdi. Ne yaparsın?", c: [{t:"Hemen Yükle", y:0}, {t:"Reddet", y:1}, {t:"Güvenli yolları araştır", y:2}]},
            { s: "Bir site 'Bedava Elmas' için şifreni istiyor. Ne yaparsın?", c: [{t:"Şifremi Girerim", y:0}, {t:"Siteyi şikayet ederim", y:2}, {t:"Arkadaşıma sorarım", y:1}]}
        ];

        let index = 0;
        let toplamYildiz = 0;
        let bakiye = <?php echo $mevcut_para; ?>;

        function soruGetir() {
            if(index >= senaryolar.length) {
                document.getElementById('etkinlik-alan').style.display = 'none';
                document.getElementById('final-onay').style.display = 'block';
                return;
            }
            let suankiSoru = senaryolar[index];
            document.getElementById('senaryo-baslik').innerText = "Senaryo " + (index + 1);
            document.getElementById('senaryo-metni').innerText = suankiSoru.s;
            let btns = "";
            suankiSoru.c.forEach(sec => {
                btns += `<button class="btn-secenek" onclick="kararVer(${sec.y})">${sec.t}</button>`;
            });
            document.getElementById('secenekler').innerHTML = btns;
        }

        function kararVer(yildiz) {
            toplamYildiz += yildiz;
            document.getElementById('yildiz-sayisi').innerText = toplamYildiz;
            index++;
            soruGetir();
        }

        function lisansKontrol() {
            if(bakiye < 400) {
                alert("Yetersiz Bakiye! Lisans için 400 TL gerekli. Para biriktirmek için Seviye 1'e yönlendiriliyorsun.");
                location.href = "seviye1.php";
            } 
            else if(toplamYildiz < 5) {
                alert("Yetersiz Yıldız! Bilinçli kullanım için en az 5 yıldız toplamalısın. Etik parkuruna (Seviye 2) yeniden başlıyorsun.");
                location.href = "seviye2_etkinlik.php";
            } 
            else {
                // Şartlar sağlandı, ödeme ve kayıt için gönder
                location.href = `islemler/seviye2_kaydet.php?yildiz=${toplamYildiz}`;
            }
        }

        window.onload = soruGetir;
    </script>
</body>
</html>