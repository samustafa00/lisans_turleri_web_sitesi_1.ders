<?php
session_start();
if (!isset($_SESSION['ogrenci_id'])) { header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Seviye 1: Para Kazan</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
    <style>
        .soru-kutu { display: none; }
        .active { display: block; animation: fadeIn 0.5s; }
        .skor-board { background: #1e293b; padding: 10px; border-radius: 10px; margin-bottom: 20px; color: #fbbf24; font-weight: bold; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="ana-kart" style="width: 600px;">
        <div class="skor-board">💰 Mevcut Bakiye: <span id="bakiye">0</span> TL</div>
        
        <div id="sorular-alani">
            </div>

        <div id="final-alani" style="display:none;">
            <h2>Harika! Seviye 1 Tamamlandı.</h2>
            <p>Toplam <span id="final-para"></span> TL kazandın.</p>
            <button class="btn-basla" onclick="window.location.href='seviye2_lisans.php'">SEVİYE 2'YE GEÇ</button>
        </div>
    </div>

    <script>
        const sorular = [
            { s: "Bir oyunun tüm özelliklerini içeren ama sınırlı süre (örn: 30 gün) kullanabildiğin sürüm nedir?", c: ["Demo", "Geçici Kullanım (Trial)", "Freeware", "Beta"], a: "Geçici Kullanım (Trial)" },
            { s: "Kullanımı tamamen serbest olan, herhangi bir kısıtlaması bulunmayan yazılım türü?", c: ["Demo", "Crack", "Ücretsiz Yazılım (Freeware)", "Lisanslı"], a: "Ücretsiz Yazılım (Freeware)" },
            { s: "Yazılımın kaynak kodlarının herkes tarafından geliştirilebildiği özgür lisans?", c: ["Açık Kaynak", "Demo", "Trial", "Ücretli"], a: "Açık Kaynak" },
            { s: "Tam sürümün sadece küçük bir kısmını (örn: sadece 1. bölüm) denemen için sunan sürüm?", c: ["Full", "Demo", "Beta", "Sınırsız"], a: "Demo" },
            { s: "Bir yazılımı yasa dışı yollarla açmaya ve kullanmaya çalışmak hangisine girer?", c: ["Etik Kullanım", "Lisanslama", "Korsan/Hileli", "Demo"], a: "Korsan/Hileli" }
        ];

        let aktifSoru = 0;
        let toplamPara = 0;

        function soruGoster() {
            if(aktifSoru >= sorular.length) {
                bitir();
                return;
            }
            let soru = sorular[aktifSoru];
            let html = `<h3>Soru ${aktifSoru + 1}</h3><p style='font-size:1.2rem;'>${soru.s}</p><div style='display:grid; grid-template-columns: 1fr 1fr; gap: 10px;'>`;
            soru.c.forEach(secenek => {
                html += `<button class="btn-basla" style="background:#334155" onclick="cevapla('${secenek}')">${secenek}</button>`;
            });
            html += `</div>`;
            document.getElementById('sorular-alani').innerHTML = html;
        }

        function cevapla(secim) {
            if(secim === sorular[aktifSoru].a) {
                toplamPara += 200; // Her soru 200 TL (Toplam 1000 TL max)
                document.getElementById('bakiye').innerText = toplamPara;
            }
            aktifSoru++;
            soruGoster();
        }

        function bitir() {
            document.getElementById('sorular-alani').style.display = 'none';
            document.getElementById('final-alani').style.display = 'block';
            document.getElementById('final-para').innerText = toplamPara;

            // Veritabanına kaydet
            fetch('islemler/seviye1_kaydet.php?para=' + toplamPara + '&dogru=' + (toplamPara/200));
        }

        soruGoster();
    </script>
</body>
</html>