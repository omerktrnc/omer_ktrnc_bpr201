<?php
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "İlanlarınızı görmek için önce giriş yapmalısınız.";
    header("Location: login.php");
    exit;
}

// Giriş yapan kullanıcının ID'sini al
$user_id = $_SESSION['user_id'];

// Kullanıcının TÜM ilanlarını çek (durumuna göre ayıracağız)
try {
    $stmt = $db->prepare("SELECT * FROM ilanlar WHERE user_id = ? ORDER BY ilan_tarihi DESC");
    $stmt->execute([$user_id]);
    $ilanlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // İlanları durumlarına göre ayıralım
    $bekleyen_ilanlar = [];
    $onaylanan_ilanlar = [];
    $reddedilen_ilanlar = [];

    foreach ($ilanlar as $ilan) {
        if ($ilan['durum'] == 'beklemede') {
            $bekleyen_ilanlar[] = $ilan;
        } elseif ($ilan['durum'] == 'onaylandi') {
            $onaylanan_ilanlar[] = $ilan;
        } elseif ($ilan['durum'] == 'reddedildi') {
            $reddedilen_ilanlar[] = $ilan;
        }
    }

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesabım - İlanlarım</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin/admin-style.css">
</head>
<body>
    <div class="admin-container"> 
        <h1>İlanlarım</h1>

        <?php 
        if (isset($_SESSION['success_message'])) {
            echo '<div class="message success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); 
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="message error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); 
        }
        ?>

        <h2>Onay Bekleyen İlanlarım (<?php echo count($bekleyen_ilanlar); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Fiyat</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bekleyen_ilanlar) == 0): ?>
                    <tr><td colspan="3" style="text-align:center;">Onay bekleyen ilanınız yok.</td></tr>
                <?php else: ?>
                    <?php foreach ($bekleyen_ilanlar as $ilan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ilan['baslik']); ?></td>
                            <td><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</td>
                            <td>
                                <a href="ilan-sil.php?id=<?php echo $ilan['id']; ?>" class="action-link reddet-link" onclick="return confirm('Bu ilanı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <h2 style="margin-top: 30px;">Yayındaki İlanlarım (<?php echo count($onaylanan_ilanlar); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Fiyat</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($onaylanan_ilanlar) == 0): ?>
                    <tr><td colspan="3" style="text-align:center;">Yayında olan ilanınız yok.</td></tr>
                <?php else: ?>
                    <?php foreach ($onaylanan_ilanlar as $ilan): ?>
                        <tr>
                            <td>
                                <a href="ilan-detay.php?id=<?php echo $ilan['id']; ?>" target="_blank">
                                    <?php echo htmlspecialchars($ilan['baslik']); ?> (Görüntüle)
                                </a>
                            </td>
                            <td><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</td>
                            <td>
                                <a href="ilan-sil.php?id=<?php echo $ilan['id']; ?>" class="action-link reddet-link" onclick="return confirm('Bu ilanı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <h2 style="margin-top: 30px;">Reddedilen İlanlarım (<?php echo count($reddedilen_ilanlar); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Fiyat</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reddedilen_ilanlar) == 0): ?>
                    <tr><td colspan="3" style="text-align:center;">Reddedilen ilanınız yok.</td></tr>
                <?php else: ?>
                    <?php foreach ($reddedilen_ilanlar as $ilan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ilan['baslik']); ?></td>
                            <td><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</td>
                            <td>
                                <a href="ilan-sil.php?id=<?php echo $ilan['id']; ?>" class="action-link reddet-link" onclick="return confirm('Bu ilanı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</body>
</html>