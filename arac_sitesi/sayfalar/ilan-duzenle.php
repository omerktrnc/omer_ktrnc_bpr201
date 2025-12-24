<?php
// 1. OTURUM VE HATALARI AÇ
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. VERİTABANI BAĞLANTISI (Üst klasöre çıkış)
include '../db.php'; // Hata 9'u çözer

// 3. GİRİŞ KONTROLÜ (Hata 7'yi çözer)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$ilan_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// 4. İLAN BİLGİLERİNİ ÇEK (Sadece kendi ilanını düzenleyebilir)
$sorgu = $db->prepare("SELECT * FROM ilanlar WHERE id = ? AND user_id = ?");
$sorgu->execute([$ilan_id, $user_id]);
$ilan = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$ilan) {
    die("İlan bulunamadı veya bu ilanı düzenleme yetkiniz yok.");
}

// 5. GÜNCELLEME İŞLEMİ (Form gönderildiğinde)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baslik = $_POST['baslik'];
    $fiyat = $_POST['fiyat'];
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $yil = $_POST['yil'];
    $km = $_POST['km'];
    $aciklama = $_POST['aciklama'];

    $guncelle = $db->prepare("UPDATE ilanlar SET baslik=?, fiyat=?, marka=?, model=?, yil=?, km=?, aciklama=?, durum='beklemede' WHERE id=? AND user_id=?");
    $sonuc = $guncelle->execute([$baslik, $fiyat, $marka, $model, $yil, $km, $aciklama, $ilan_id, $user_id]);

    if ($sonuc) {
        echo "<script>alert('İlan güncellendi ve onaya gönderildi!'); window.location.href='ilanlarim.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlan Düzenle - Kadir Bey Otomotiv</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 20px; }
        .form-konteynir { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .nav-bar { background: #2c3e50; padding: 15px; text-align: center; margin-bottom: 20px; border-radius: 8px; }
        .nav-bar a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { background: #27ae60; color: white; border: none; padding: 15px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="../index.php">Ana Sayfa</a>
        <a href="ilanlarim.php">İlanlarıma Dön</a>
    </nav>

    <div class="form-konteynir">
        <h2>İlanı Düzenle: <?php echo htmlspecialchars($ilan['baslik']); ?></h2>
        <form method="POST">
            <label>İlan Başlığı</label>
            <input type="text" name="baslik" value="<?php echo htmlspecialchars($ilan['baslik']); ?>" required>
            
            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label>Fiyat (TL)</label>
                    <input type="number" name="fiyat" value="<?php echo $ilan['fiyat']; ?>" required>
                </div>
                <div style="flex: 1;">
                    <label>Kilometre</label>
                    <input type="number" name="km" value="<?php echo $ilan['km']; ?>" required>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <input type="text" name="marka" placeholder="Marka" value="<?php echo $ilan['marka']; ?>" required>
                <input type="text" name="model" placeholder="Model" value="<?php echo $ilan['model']; ?>" required>
                <input type="number" name="yil" placeholder="Yıl" value="<?php echo $ilan['yil']; ?>" required>
            </div>

            <label>Açıklama</label>
            <textarea name="aciklama" rows="5" required><?php echo htmlspecialchars($ilan['aciklama']); ?></textarea>

            <button type="submit">DEĞİŞİKLİKLERİ KAYDET</button>
        </form>
    </div>

</body>
</html>