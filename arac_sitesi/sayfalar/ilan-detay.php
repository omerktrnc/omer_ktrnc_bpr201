<?php
/*
   sayfalar/ilan-detay.php
   İlanın ID'sini alıp ($ilan_id), o ilanın bilgilerini ($ilan)
   ve resimlerini ($resimler) çekeceğiz.
*/

// 1. Adresten (GET) ilanın ID'sini al
// ?sayfa=ilan-detay&id=X  <-- 'id'yi almamız lazım
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ilan_id = $_GET['id'];
} else {
    // ID yoksa veya sayı değilse, hata ver
    echo "Geçersiz ilan ID'si.";
    exit; // (veya ana sayfaya yönlendir)
}

// 2. İlan Bilgilerini Çek (JOIN ile satıcı adını da al)
try {
    // Sadece 'onaylandi' durumundakileri göster
    $stmt_ilan = $db->prepare("SELECT i.*, k.kullanici_adi 
                              FROM ilanlar i
                              JOIN kullanicilar k ON i.user_id = k.id
                              WHERE i.id = ? AND i.durum = 'onaylandi'");
    $stmt_ilan->execute([$ilan_id]);
    $ilan = $stmt_ilan->fetch(PDO::FETCH_ASSOC);

    // Eğer ilan bulunamazsa (ya ID yanlıştır ya da onaylı değildir)
    if (!$ilan) {
        echo "İlan bulunamadı veya onay bekliyor.";
        exit;
    }

    // 3. İlanın TÜM resimlerini çek
    $stmt_resimler = $db->prepare("SELECT resim_yolu FROM resimler WHERE ilan_id = ?");
    $stmt_resimler->execute([$ilan_id]);
    $resimler = $stmt_resimler->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}
?>
<div class="container">
        <h1><?php echo htmlspecialchars($ilan['baslik']); ?></h1>

        <div class="ilan-detay-container">

            <div class="ilan-resimler">
                <?php if (count($resimler) > 0): ?>
                    <img src="uploads/<?php echo htmlspecialchars($resimler[0]['resim_yolu']); ?>" alt="Ana Resim" class="ana-resim" id="anaResim">

                    <div class="kucuk-resimler">
                        <?php foreach ($resimler as $resim): ?>
                            <img src="uploads/<?php echo htmlspecialchars($resim['resim_yolu']); ?>" 
                                 alt="Küçük Resim" 
                                 onclick="document.getElementById('anaResim').src = this.src;">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <img src="https://via.placeholder.com/600x400?text=Resim+Yok" class="ana-resim" alt="Resim Yok">
                <?php endif; ?>
            </div>

            <div class="ilan-bilgiler">
                <p class="detay-fiyat"><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</p>
                <h3>İlan Bilgileri</h3>
                <p><strong>Satıcı:</strong> <?php echo htmlspecialchars($ilan['kullanici_adi']); ?></p>
                <p><strong>Marka:</strong> <?php echo htmlspecialchars($ilan['marka']); ?></p>
                <p><strong>Model:</strong> <?php echo htmlspecialchars($ilan['model']); ?></p>
                <p><strong>Yıl:</strong> <?php echo htmlspecialchars($ilan['yil']); ?></p>
                <p><strong>İlan Tarihi:</strong> <?php echo date('d M Y', strtotime($ilan['ilan_tarihi'])); ?></p>
            </div>

            <div class="detay-aciklama" style="width: 100%;">
                <h3>İlan Açıklaması</h3>
                <p><?php echo nl2br(htmlspecialchars($ilan['aciklama'])); ?></p>
            </div>

        </div>
    </div>