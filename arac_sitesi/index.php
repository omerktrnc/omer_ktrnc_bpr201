<?php
session_start();
include 'db.php'; 

// Formdan gelen tüm filtreleme verilerini alıyoruz
$ilan_no = $_GET['ilan_no'] ?? ''; // YENİ: İlan Numarası
$ara = $_GET['ara'] ?? ''; 
$marka = $_GET['marka'] ?? '';
$sehir = $_GET['sehir'] ?? ''; // YENİ: Şehir
$min_fiyat = $_GET['min_fiyat'] ?? '';
$max_fiyat = $_GET['max_fiyat'] ?? '';

// Temel SQL sorgusu (Sadece onaylı ilanlar)
$sql = "SELECT i.*, r.resim_yolu FROM ilanlar i 
        LEFT JOIN resimler r ON i.id = r.ilan_id 
        WHERE i.durum = 'onaylandi'";
$params = [];

// 1. FİLTRE: İlan Numarasına göre ara (Eğer numara girilmişse diğer filtreleri genelde ezer)
if ($ilan_no) {
    $sql .= " AND i.id = ?";
    $params[] = (int)$ilan_no;
}

// 2. FİLTRE: Kelime ile ara
if ($ara) { 
    $sql .= " AND (i.baslik LIKE ? OR i.marka LIKE ? OR i.model LIKE ? OR i.seri LIKE ?)"; 
    $params[] = "%$ara%"; $params[] = "%$ara%"; $params[] = "%$ara%"; $params[] = "%$ara%";
}

// 3. FİLTRE: Markaya göre
if ($marka) { $sql .= " AND i.marka LIKE ?"; $params[] = "%$marka%"; }

// 4. FİLTRE: Şehre göre (YENİ)
if ($sehir) { $sql .= " AND i.sehir LIKE ?"; $params[] = "%$sehir%"; }

// 5. FİLTRE: Fiyat aralığı
if ($min_fiyat) { $sql .= " AND i.fiyat >= ?"; $params[] = (int)$min_fiyat; }
if ($max_fiyat) { $sql .= " AND i.fiyat <= ?"; $params[] = (int)$max_fiyat; }

$sql .= " GROUP BY i.id ORDER BY i.id DESC";
$sorgu = $db->prepare($sql);
$sorgu->execute($params);
$ilanlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>HızlıSat | Ana Sayfa</title> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; margin: 0; color: #333; }
        h1, h2, h3, .brand, .fiyat-etiketi, .ara-btn { font-family: 'Poppins', sans-serif; }

        .nav-bar { 
            background: linear-gradient(to right, #1a2a3a, #2c3e50); 
            padding: 15px 40px; 
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); position: sticky; top: 0; z-index: 1000;
        }
        .brand { font-size: 22px; font-weight: 700; color: white; text-decoration: none; text-transform: uppercase; letter-spacing: 1px;}
        .nav-links a { color: rgba(255,255,255,0.9); text-decoration: none; margin-left: 20px; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover { color: #3498db; }

        .arama-alani { background: white; padding: 25px; border-bottom: 1px solid #eee; }
        .arama-form { max-width: 1200px; margin: 0 auto; display: flex; gap: 10px; flex-wrap: wrap; }
        .arama-form input { padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; flex: 1; min-width: 140px; transition: 0.3s; font-size: 13px; }
        .arama-form input:focus { border-color: #004dae; outline: none; box-shadow: 0 0 0 3px rgba(0,77,174,0.1); }
        .ara-btn { background: #004dae; color: white; border: none; padding: 12px 25px; border-radius: 10px; cursor: pointer; font-weight: 700; transition: 0.3s; }
        .ara-btn:hover { background: #003a85; transform: translateY(-2px); }

        .ana-konteynir { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .ilan-satir { 
            display: flex; background: white; border-radius: 15px; margin-bottom: 20px; padding: 20px; 
            transition: 0.3s; position: relative; box-shadow: 0 5px 15px rgba(0,0,0,0.05); align-items: center; 
        }
        .ilan-satir:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
        .col-foto { width: 170px; height: 120px; overflow: hidden; border-radius: 10px; position: relative; }
        .col-foto img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .ilan-satir:hover .col-foto img { transform: scale(1.1); }

        .col-bilgi { flex: 1; padding: 0 25px; }
        .baslik { font-weight: 700; font-size: 19px; color: #2c3e50; margin-bottom: 4px; }
        .alt-baslik { font-size: 15px; color: #666; font-weight: 600; margin-bottom: 12px; }
        
        .badge-grubu { display: flex; flex-wrap: wrap; gap: 8px; }
        .badge { 
            background: #f8f9fa; padding: 6px 14px; border-radius: 20px; font-size: 12px; color: #555; font-weight: 600; 
            border: 1px solid #e9ecef; display: flex; align-items: center;
        }
        .badge i { margin-right: 6px; color: #004dae; font-size: 13px; }

        .col-fiyat { width: 180px; text-align: right; }
        .fiyat-etiketi { font-weight: 700; color: #d9534f; font-size: 22px; background: #fff0f0; padding: 6px 14px; border-radius: 10px; display: inline-block; }
    </style>
</head>
<body>

<nav class="nav-bar">
    <a href="index.php" class="brand"><i class="fa-solid fa-bolt-lightning"></i> HIZLISAT</a> 
    <div class="nav-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <a href="sayfalar/ilan-ver.php"><i class="fa-solid fa-plus"></i> İlan Ver</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="sayfalar/hesabim.php" style="color:#3498db;"><i class="fa-solid fa-user"></i> Hesabım</a>
            <a href="logout.php" style="color:#ff6b6b;"><i class="fa-solid fa-right-from-bracket"></i> Çıkış</a>
        <?php else: ?>
            <a href="sayfalar/login.php">Giriş Yap</a>
            <a href="sayfalar/register.php" style="background:#27ae60; padding:8px 15px; border-radius:10px;">Kayıt Ol</a>
        <?php endif; ?>
    </div>
</nav>

<div class="arama-alani">
    <form class="arama-form" method="GET" action="index.php">
        <input type="number" name="ilan_no" placeholder="İlan No" value="<?php echo htmlspecialchars($ilan_no); ?>">
        
        <input type="text" name="ara" placeholder="Kelime ile ara..." value="<?php echo htmlspecialchars($ara); ?>">
        <input type="text" name="marka" placeholder="Marka" value="<?php echo htmlspecialchars($marka); ?>">
        
        <input type="text" name="sehir" placeholder="Şehir" value="<?php echo htmlspecialchars($sehir); ?>">
        
        <input type="number" name="min_fiyat" placeholder="Min TL" value="<?php echo htmlspecialchars($min_fiyat); ?>">
        <input type="number" name="max_fiyat" placeholder="Max TL" value="<?php echo htmlspecialchars($max_fiyat); ?>">
        
        <button type="submit" class="ara-btn"><i class="fa-solid fa-magnifying-glass"></i> FİLTRELE</button>
        
        <?php if($ara || $marka || $sehir || $ilan_no || $min_fiyat || $max_fiyat): ?>
            <a href="index.php" style="color:#999; font-size:12px; align-self:center; text-decoration:none;">Temizle</a>
        <?php endif; ?>
    </form>
</div>

<div class="ana-konteynir">
    <?php if(count($ilanlar) > 0): ?>
        <?php foreach($ilanlar as $ilan): ?>
        <div class="ilan-satir">
            <a href="sayfalar/ilan-detay.php?id=<?php echo $ilan['id']; ?>" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1;"></a>
            
            <div class="col-foto">
                <?php 
                    $resim = $ilan['resim_yolu'] ?? ''; 
                    $resim_yolu = (!empty($resim) && file_exists("uploads/" . $resim)) ? "uploads/" . $resim : "uploads/varsayilan.jpg";
                ?>
                <img src="<?php echo $resim_yolu; ?>"> 
            </div>

            <div class="col-bilgi" style="z-index: 2;">
                <div class="baslik"><?php echo htmlspecialchars($ilan['baslik'] ?? ''); ?></div>
                <div class="alt-baslik"><?php echo htmlspecialchars(($ilan['marka'] ?? '') . " " . ($ilan['seri'] ?? '') . " " . ($ilan['model'] ?? '')); ?></div>
                <div class="badge-grubu">
                    <span class="badge"><i class="fa-solid fa-gas-pump"></i> <?php echo htmlspecialchars($ilan['yakit'] ?? ''); ?></span>
                    <span class="badge"><i class="fa-solid fa-gear"></i> <?php echo htmlspecialchars($ilan['vites'] ?? ''); ?></span>
                    <span class="badge"><i class="fa-solid fa-gauge-high"></i> <?php echo number_format($ilan['km'] ?? 0, 0, ',', '.'); ?> KM</span>
                    
                    <?php if(!empty($ilan['sehir'])): ?>
                    <span class="badge" style="background:#f0fff4; color:#22543d; border-color:#c6f6d5;">
                        <i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($ilan['sehir']); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-fiyat" style="z-index: 2;">
                <div class="fiyat-etiketi"><?php echo number_format($ilan['fiyat'] ?? 0, 0, ',', '.'); ?> TL</div>
                <div style="font-size: 10px; color: #aaa; margin-top: 5px;">İlan No: #<?php echo $ilan['id']; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align:center; padding: 80px; color: #888; background: white; border-radius: 15px;">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 40px; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
            Aradığınız kriterlere uygun ilan bulunamadı.
        </div>
    <?php endif; ?>
</div>

</body>
</html>