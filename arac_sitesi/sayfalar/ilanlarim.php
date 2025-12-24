<?php
session_start();
include '../db.php'; // Bağlantın: $db

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];

$sorgu = $db->prepare("SELECT i.*, r.resim_yolu FROM ilanlar i 
                       LEFT JOIN resimler r ON i.id = r.ilan_id 
                       WHERE i.user_id = ? 
                       GROUP BY i.id ORDER BY i.id DESC");
$sorgu->execute([$u_id]);
$ilanlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlanlarım | Mert Otomotiv</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .ilan-konteynir { max-width: 900px; margin: 0 auto; }
        .ilan-kart { display: flex; background: white; border-radius: 12px; margin-bottom: 15px; padding: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); align-items: center; position: relative; }
        .col-resim { width: 140px; height: 100px; border-radius: 8px; overflow: hidden; background: #eee; }
        .col-resim img { width: 100%; height: 100%; object-fit: cover; }
        .col-detay { flex: 1; padding: 0 20px; }
        
        .islem-butonlari { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); display: flex; gap: 8px; }
        .btn { text-decoration: none; font-size: 12px; font-weight: bold; padding: 6px 12px; border-radius: 6px; transition: 0.2s; }
        
        .btn-goruntule { color: #004dae; border: 1px solid #004dae; }
        .btn-goruntule:hover { background: #004dae; color: white; }
        
        .btn-duzenle { color: #f0ad4e; border: 1px solid #f0ad4e; }
        .btn-duzenle:hover { background: #f0ad4e; color: white; }
        
        .btn-sil { color: #d9534f; border: 1px solid #d9534f; }
        .btn-sil:hover { background: #d9534f; color: white; }

        .durum-etiket { font-size: 11px; padding: 2px 8px; border-radius: 10px; color: white; margin-top: 5px; display: inline-block; }
    </style>
</head>
<body>

<div class="ilan-konteynir">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="color: #2c3e50; margin:0;">Verdiğim İlanlar</h2>
        <a href="../index.php" style="text-decoration:none; color:#666; font-size:14px;">← Ana Sayfaya Dön</a>
    </div>
    
    <?php if(count($ilanlar) > 0): ?>
        <?php foreach($ilanlar as $ilan): ?>
            <div class="ilan-kart">
                <div class="col-resim">
                    <?php 
                        $resim = $ilan['resim_yolu'] ?? '';
                        // Klasör bir üstte olduğu için ../uploads/ kullanıyoruz
                        if (!empty($resim) && file_exists("../uploads/" . $resim)) {
                            $resim_yolu = "../uploads/" . $resim;
                        } else {
                            $resim_yolu = "../uploads/varsayilan.jpg";
                        }
                    ?>
                    <img src="<?php echo $resim_yolu; ?>" alt="Araç Görseli">
                </div>

                <div class="col-detay">
                    <div style="font-weight:bold; color:#004dae; font-size: 16px;">
                        <?php echo htmlspecialchars($ilan['baslik'] ?? 'Başlıksız'); ?>
                    </div>
                    <div style="font-size: 13px; color: #333; margin-top: 5px;">
                        <b><?php echo htmlspecialchars($ilan['marka'] ?? ''); ?> <?php echo htmlspecialchars($ilan['model'] ?? ''); ?></b> 
                        | <?php echo htmlspecialchars($ilan['motor_tipi'] ?? ''); ?>
                    </div>
                    <div style="color: #27ae60; font-weight: bold; margin-top: 5px;">
                        <?php echo number_format($ilan['fiyat'] ?? 0, 0, ',', '.'); ?> TL
                    </div>
                    
                    <span class="durum-etiket" style="background: <?php echo (($ilan['durum'] ?? '') == 'onaylandi') ? '#27ae60' : '#f0ad4e'; ?>">
                        <?php echo (($ilan['durum'] ?? '') == 'onaylandi') ? '● Yayında' : '● Onay Bekliyor'; ?>
                    </span>
                </div>

                <div class="islem-butonlari">
                    <a href="ilan-detay.php?id=<?php echo $ilan['id']; ?>" class="btn btn-goruntule">Görüntüle</a>
                    <a href="ilan-duzenle.php?id=<?php echo $ilan['id']; ?>" class="btn btn-duzenle">Düzenle</a>
                    <a href="../ilan-sil.php?id=<?php echo $ilan['id']; ?>" 
                       class="btn btn-sil" 
                       onclick="return confirm('Bu ilanı silmek istediğine emin misin?')">
                       Sil
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; padding: 40px; background: white; border-radius: 12px; color:#888;">Henüz bir ilan vermemişsiniz.</p>
    <?php endif; ?>
</div>

</body>
</html>