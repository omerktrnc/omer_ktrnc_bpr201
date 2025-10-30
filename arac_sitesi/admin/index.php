<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantısı (Bir üst klasördeki db.php'yi çağırır)
include '../db.php'; 

// === ADMİN GÜVENLİK KONTROLÜ ===
// 1. Giriş yapmamışsa VEYA 
// 2. Giriş yapmış ama 'is_admin' hafızada yoksa VEYA 
// 3. 'is_admin' değeri 1 değilse
// Admin değildir, ana sayfaya at
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $_SESSION['error_message'] = "Bu sayfaya erişim yetkiniz yok.";
    header("Location: ../index.php"); // Ana dizindeki index.php'ye yolla
    exit;
}
// === GÜVENLİK KONTROLÜ BİTTİ ===


// Admin olduğuna göre, onay bekleyen ilanları çek
try {
    // user_id'ye göre join yaparak ilanı kimin verdiğini de alabiliriz
    $stmt = $db->prepare("SELECT i.*, k.kullanici_adi 
                         FROM ilanlar i
                         JOIN kullanicilar k ON i.user_id = k.id
                         WHERE i.durum = 'beklemede'
                         ORDER BY i.ilan_tarihi ASC");
    $stmt->execute();
    $bekleyen_ilanlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Onay Bekleyenler</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

    <nav class="admin-nav">
        <a href="../index.php">Siteye Dön</a>
        <a href="index.php">Onay Bekleyenler</a>
        <a href="../logout.php">Çıkış Yap</a>
    </nav>

    <div class="admin-container">
        <h1>Onay Bekleyen İlanlar</h1>

        <?php 
        // 9. Adım'da yapacağımız onay/red işleminden sonra mesaj gelirse burada göstereceğiz
        if (isset($_SESSION['success_message'])) {
            echo '<div class="message success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); 
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Başlık</th>
                    <th>İlan Sahibi</th>
                    <th>Fiyat</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bekleyen_ilanlar) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Onay bekleyen ilan bulunmamaktadır.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bekleyen_ilanlar as $ilan): ?>
                        <tr>
                            <td><?php echo $ilan['id']; ?></td>
                            <td><?php echo htmlspecialchars($ilan['baslik']); ?></td>
                            <td><?php echo htmlspecialchars($ilan['kullanici_adi']); ?></td>
                            <td><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</td>
                            <td><?php echo $ilan['ilan_tarihi']; ?></td>
                            <td>
                                <a href="islem.php?id=<?php echo $ilan['id']; ?>&action=onayla" class="action-link onayla-link">Onayla</a>
                                <a href="islem.php?id=<?php echo $ilan['id']; ?>&action=reddet" class="action-link reddet-link">Reddet</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</body>
</html>