<?php
session_start();
include 'islemler/baglanti.php';
if (!isset($_SESSION['ogrenci_id'])) { header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Seviye 3: Büyük Final</title>
    <link rel="stylesheet" href="varliklar/css/stil.css">
    <style>
        .game-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .match-item { background: #1e293b; padding: 15px; border: 2px solid #334155; border-radius: 10px; cursor: pointer; transition: 0.3s; }
        .match-item:hover { border-color: #38bdf8; }
        .selected { background: #38bdf8; color: #000; border-color: #fff; }
        .correct { background: #10b981 !important; border-color: #fff; opacity: 0.5; pointer-events: none; }
        #timer-box { font-size: 2rem; color: #fbbf24; font-weight: bold; }
    </style>
</head>
<body>
    <div class="ana-kart" style="width: 800px;">
        <div id="timer-box">Süre: <span id="saniye">0</span>s</div>
        <h2>Final: Bilgi Eşleştirme</h2>
        <p>Soldaki senaryoya uygun sağdaki terimi seç!</p>

        <div class="game-grid">
            <div id="left-col"></div> <div id="right-col"></div> </div>
    </div>

    <script>
        const data = [
            {id: 1, s: "Yazılımın çalınmasına karşı yasal hak", k: "Telif Hakkı"},
            {id: 2, s: "Ücretsiz ve kısıtlamasız yazılım", k: "Freeware"},
            {id: 3, s: "Kodları herkesçe görülebilen sistem", k: "Açık Kaynak"},
            {id: 4, s: "Satın almadan önce deneme sürümü", k: "Trial"},
            {id: 5, s: "Yasa dışı yollarla kırılmış yazılım", k: "Crackli/Korsan"}
        ];

        let selectedLeft = null;
        let selectedRight = null;
        let completed = 0;
        let seconds = 0;
        const timerInterval = setInterval(() => { seconds++; document.getElementById('saniye').innerText = seconds; }, 1000);

        function initGame() {
            const leftCol = document.getElementById('left-col');
            const rightCol = document.getElementById('right-col');
            
            // Karıştırarak ekrana bas
            [...data].sort(() => Math.random() - 0.5).forEach(item => {
                leftCol.innerHTML += `<div class="match-item" id="L${item.id}" onclick="select('L', ${item.id})">${item.s}</div>`;
            });
            [...data].sort(() => Math.random() - 0.5).forEach(item => {
                rightCol.innerHTML += `<div class="match-item" id="R${item.id}" onclick="select('R', ${item.id})">${item.k}</div>`;
            });
        }

        function select(side, id) {
            if(side === 'L') {
                if(selectedLeft) document.getElementById('L'+selectedLeft).classList.remove('selected');
                selectedLeft = id;
                document.getElementById('L'+id).classList.add('selected');
            } else {
                if(selectedRight) document.getElementById('R'+selectedRight).classList.remove('selected');
                selectedRight = id;
                document.getElementById('R'+id).classList.add('selected');
            }

            if(selectedLeft && selectedRight) {
                if(selectedLeft === selectedRight) {
                    document.getElementById('L'+selectedLeft).classList.add('correct');
                    document.getElementById('R'+selectedRight).classList.add('correct');
                    completed++;
                    if(completed === data.length) finishGame();
                }
                // Seçimleri temizle
                document.getElementById('L'+selectedLeft).classList.remove('selected');
                document.getElementById('R'+selectedRight).classList.remove('selected');
                selectedLeft = null; selectedRight = null;
            }
        }

        function finishGame() {
            clearInterval(timerInterval);
            const score = Math.max(100, 1000 - (seconds * 10)); // Hızlı bitiren çok puan alır
            location.href = `islemler/seviye3_kaydet.php?skor=${score}&sure=${seconds}`;
        }
        initGame();
    </script>
</body>
</html>