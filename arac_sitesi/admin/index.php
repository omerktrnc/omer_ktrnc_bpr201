<?php
session_start();
include '../db.php';

// Güvenlik Kontrolü: Giriş yapılmamışsa veya admin değilse (is_admin != 1) engelle
if (!isset($_SESSION['user_id']) || (isset($_SESSION['rol']) && $_SESSION['rol'] != 'admin')) {
    // Veritabanındaki is_admin kontrolü
    die("Bu alana sadece yöneticiler erişebilir.");
}

// Bekleyen ilanları çek (JOIN ile resim getiriyoruz)
$sorgu = $db->query("SELECT i.*, r.resim_yolu FROM ilanlar i 
                     LEFT JOIN resimler r ON i.id = r.ilan_id 
                     WHERE i.durum = 'beklemede' 
                     GROUP BY i.id ORDER BY i.id DESC");
$ilanlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>HızlıSat | Yönetim Paneli</title>
    <link rel="stylesheet" href="admin-style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <div class="panel-header">
        <h2><i class="fa-solid fa-gauge-high"></i> Yönetim Paneli</h2>
        <a href="../index.php" style="color: #666; text-decoration:none;"><i class="fa-solid fa-arrow-left"></i> Siteye Dön</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <small>Onay Bekleyen</small>
            <h3><?php echo count($ilanlar); ?> İlan</h3>
        </div>
    </div>

    <div class="onay-listesi">
        <?php if(count($ilanlar) > 0): ?>
            <?php foreach($ilanlar as $ilan): ?>
            <div class="onay-kart">
                <div class="ilan-bilgi">
                    <?php 
                        $resim = !empty($ilan['resim_yolu']) ? "../uploads/".$ilan['resim_yolu'] : "../uploads/varsayilan.jpg";
                    ?>
                    <img src="<?php echo $resim; ?>">
                    <div class="ilan-detay">
                        <h4><?php echo htmlspecialchars($ilan['baslik']); ?></h4>
                        <p>
                            <i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($ilan['sehir'] . " / " . $ilan['ilce']); ?> | 
                            <b><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</b>
                        </p>
                    </div>
                </div>
                <div class="islem-butonlari">
                    <a href="islem.php?id=<?php echo $ilan['id']; ?>&islem=onayla" class="btn btn-onay"><i class="fa-solid fa-check"></i> Onayla</a>
                    <a href="islem.php?id=<?php echo $ilan['id']; ?>&islem=sil" class="btn btn-red" onclick="return confirm('İlanı silmek istediğinize emin misiniz?')"><i class="fa-solid fa-xmark"></i> Reddet</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center; padding:50px; background:white; border-radius:15px; color:#888;">
                <i class="fa-solid fa-circle-check" style="font-size:40px; color:#27ae60; margin-bottom:10px;"></i>
                <p>Onay bekleyen ilan bulunmuyor.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>