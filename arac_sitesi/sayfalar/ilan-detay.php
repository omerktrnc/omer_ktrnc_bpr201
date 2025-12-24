<?php
session_start();
include '../db.php'; 

$id = (int)($_GET['id'] ?? 0);

// 1. İlanı ve resimleri veritabanından çekiyoruz
$sorgu = $db->prepare("SELECT * FROM ilanlar WHERE id = ?");
$sorgu->execute([$id]);
$ilan = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$ilan) { echo "İlan bulunamadı."; exit(); }

$resim_sorgu = $db->prepare("SELECT resim_yolu FROM resimler WHERE ilan_id = ?");
$resim_sorgu->execute([$id]);
$resimler = $resim_sorgu->fetchAll(PDO::FETCH_ASSOC);

$ana_resim = !empty($resimler) ? $resimler[0]['resim_yolu'] : 'varsayilan.jpg';
$resimListesiJSON = json_encode(array_column($resimler, 'resim_yolu'));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ilan['baslik'] ?? 'İlan Detayı'); ?> | HızlıSat</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .detay-konteynir { max-width: 1200px; margin: 0 auto; display: flex; gap: 30px; }
        .sol-kolon { flex: 2; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        .ana-resim-alanı { position: relative; background: #222; border-radius: 8px; overflow: hidden; height: 500px; display: flex; align-items: center; justify-content: center; }
        .ana-resim-alanı img { max-width: 100%; max-height: 100%; object-fit: contain; cursor: pointer; }

        .zoom-btn { position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.7); color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; z-index: 5; font-size: 14px; }

        .galeri { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px; margin-bottom: 20px; }
        .galeri img { width: 80px; height: 60px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 2px solid transparent; opacity: 0.6; transition: 0.3s; }
        .galeri img.aktif { border-color: #004dae; opacity: 1; }

        .fiyat-alanı { font-size: 24px; font-weight: bold; color: #d9534f; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .aciklama-alanı { line-height: 1.6; color: #444; white-space: pre-wrap; margin-top: 15px; }

        .sag-kolon { flex: 1; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: fit-content; }
        .teknik-liste { list-style: none; padding: 0; margin: 0; }
        .teknik-liste li { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dotted #ddd; font-size: 14px; }
        .teknik-liste li b { color: #333; width: 45%; }
        .teknik-liste li span { color: #004dae; width: 55%; text-align: right; }

        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); }
        .modal-icerik-alanı { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative; }
        .modal-content { max-width: 98%; max-height: 98%; object-fit: contain; cursor: pointer; }
        .close { position: absolute; top: 20px; right: 30px; color: white; font-size: 50px; font-weight: bold; cursor: pointer; z-index: 1100; }
    </style>
</head>
<body>

<div style="margin-bottom: 20px; max-width: 1200px; margin: 0 auto 20px auto;">
    <a href="../index.php" style="text-decoration:none; color:#004dae; font-weight: 600;">← HızılıSat Ana Sayfaya Dön</a>
</div>

<div class="detay-konteynir">
    <div class="sol-kolon">
        <h1 style="margin-top:0; font-size:22px; color:#2c3e50;"><?php echo htmlspecialchars($ilan['baslik'] ?? ''); ?></h1>
        
        <div class="ana-resim-alanı">
            <img id="buyukResim" src="../uploads/<?php echo $ana_resim; ?>" onclick="sonrakiResim()">
            <button class="zoom-btn" onclick="modaliAc()">⤢ Büyüt</button>
        </div>

        <div class="galeri">
            <?php foreach($resimler as $index => $r): ?>
                <img src="../uploads/<?php echo $r['resim_yolu']; ?>" 
                     onclick="resimDegistir(<?php echo $index; ?>)"
                     class="thumb-img <?php echo ($index === 0) ? 'aktif' : ''; ?>">
            <?php endforeach; ?>
        </div>
        
        <div class="fiyat-alanı"><?php echo number_format($ilan['fiyat'] ?? 0, 0, ',', '.'); ?> TL</div>
        
        <h3 style="border-left: 5px solid #004dae; padding-left: 10px;">Açıklama</h3>
        <div class="aciklama-alanı"><?php echo htmlspecialchars($ilan['aciklama'] ?? 'Açıklama girilmedi.'); ?></div>
    </div>

    <div class="sag-kolon">
        <ul class="teknik-liste">
            <li><b>İlan No</b> <span>#<?php echo $ilan['id']; ?></span></li>
            <li><b>İlan Tarihi</b> <span><?php echo date("d.m.Y"); ?></span></li>
            
            <li><b>Şehir</b> <span><?php echo htmlspecialchars($ilan['sehir'] ?? '-'); ?></span></li>
            <li><b>İlçe</b> <span><?php echo htmlspecialchars($ilan['ilce'] ?? '-'); ?></span></li>
            
            <li><b>Marka</b> <span><?php echo htmlspecialchars($ilan['marka'] ?? '-'); ?></span></li>
            <li><b>Seri</b> <span><?php echo htmlspecialchars($ilan['seri'] ?? '-'); ?></span></li>
            <li><b>Model</b> <span><?php echo htmlspecialchars($ilan['model'] ?? '-'); ?></span></li>
            <li><b>Yıl</b> <span><?php echo htmlspecialchars($ilan['yil'] ?? '-'); ?></span></li>
            <li><b>Yakıt Tipi</b> <span><?php echo htmlspecialchars($ilan['yakit'] ?? '-'); ?></span></li>
            <li><b>Vites</b> <span><?php echo htmlspecialchars($ilan['vites'] ?? '-'); ?></span></li>
            <li><b>KM</b> <span><?php echo number_format($ilan['km'] ?? 0, 0, ',', '.'); ?></span></li>
            <li><b>Motor Gücü</b> <span><?php echo htmlspecialchars($ilan['motor_gucu'] ?? '-'); ?> HP</span></li>
            <li><b>Motor Hacmi</b> <span><?php echo htmlspecialchars($ilan['motor_hacmi'] ?? '-'); ?> cc</span></li>
            <li><b>Renk</b> <span><?php echo htmlspecialchars($ilan['renk'] ?? '-'); ?></span></li>
            <li><b>Takas</b> <span>Evet</span></li>
        </ul>
        
        <button style="width: 100%; padding: 15px; background: #27ae60; color: white; border: none; border-radius: 5px; margin-top: 20px; font-weight: bold; cursor: pointer;">
            İlan Sahibiyle İletişime Geç
        </button>
    </div>
</div>

<div id="resimModal" class="modal">
    <span class="close" onclick="modaliKapat()">&times;</span>
    <div class="modal-icerik-alanı">
        <img class="modal-content" id="modalResim" onclick="sonrakiResim()">
    </div>
</div>

<script>
    const resimler = <?php echo $resimListesiJSON; ?>;
    const uploadsKlasoru = '../uploads/';
    let mevcutIndex = 0;

    function resimDegistir(index) {
        mevcutIndex = index;
        guncelle();
    }

    function sonrakiResim() {
        mevcutIndex = (mevcutIndex + 1) % resimler.length;
        guncelle();
    }

    function guncelle() {
        const yeniYol = uploadsKlasoru + resimler[mevcutIndex];
        document.getElementById('buyukResim').src = yeniYol;
        document.getElementById('modalResim').src = yeniYol;
        
        document.querySelectorAll('.thumb-img').forEach((img, i) => {
            img.classList.toggle('aktif', i === mevcutIndex);
        });
    }

    function modaliAc() {
        document.getElementById('resimModal').style.display = "block";
        document.getElementById('modalResim').src = document.getElementById('buyukResim').src;
    }

    function modaliKapat() {
        document.getElementById('resimModal').style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target.className == 'modal-icerik-alanı') modaliKapat();
    }
</script>

</body>
</html>