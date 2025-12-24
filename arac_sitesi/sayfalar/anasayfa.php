<?php
// 1. ADIM: Arama ve Sıralama Mantığı
$kelime = isset($_GET['kelime']) ? $_GET['kelime'] : '';
$sehir = isset($_GET['sehir']) ? $_GET['sehir'] : '';
$sirala = isset($_GET['sirala']) ? $_GET['sirala'] : 'tarih_yeni';

$sorgu = "SELECT * FROM ilanlar WHERE durum = 'onaylandi'";

if (!empty($kelime)) {
    $sorgu .= " AND (baslik LIKE :kelime OR marka LIKE :kelime OR model LIKE :kelime)";
}
if (!empty($sehir)) {
    $sorgu .= " AND il = :sehir";
}

// Sıralama Seçenekleri
switch ($sirala) {
    case 'fiyat_artan':  $order = "fiyat ASC"; break;
    case 'fiyat_azalan': $order = "fiyat DESC"; break;
    case 'km_artan':     $order = "km ASC"; break;
    case 'yil_azalan':   $order = "yil DESC"; break;
    default:             $order = "ilan_tarihi DESC"; break;
}
$sorgu .= " ORDER BY $order";

$stmt = $db->prepare($sorgu);
if (!empty($kelime)) { $stmt->bindValue(':kelime', '%'.$kelime.'%'); }
if (!empty($sehir)) { $stmt->bindValue(':sehir', $sehir); }
$stmt->execute();
$ilanlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <div class="card border-0 shadow-sm p-4 mb-4 bg-light">
        <form action="index.php" method="GET" class="row g-2">
            <input type="hidden" name="sayfa" value="anasayfa">
            <div class="col-md-4">
                <input type="text" name="kelime" class="form-control" placeholder="Marka, model veya ilan başlığı..." value="<?php echo htmlspecialchars($kelime); ?>">
            </div>
            <div class="col-md-3">
                <select name="sehir" class="form-select">
                    <option value="">Tüm Şehirler</option>
                    <option value="İstanbul">İstanbul</option>
                    <option value="Ankara">Ankara</option>
                    <option value="İzmir">İzmir</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sirala" class="form-select">
                    <option value="tarih_yeni">İlan Tarihi (Önce En Yeni)</option>
                    <option value="fiyat_artan" <?php if($sirala=='fiyat_artan') echo 'selected'; ?>>Fiyat (Önce En Düşük)</option>
                    <option value="fiyat_azalan" <?php if($sirala=='fiyat_azalan') echo 'selected'; ?>>Fiyat (Önce En Yüksek)</option>
                    <option value="km_artan" <?php if($sirala=='km_artan') echo 'selected'; ?>>KM (Önce En Düşük)</option>
                    <option value="yil_azalan" <?php if($sirala=='yil_azalan') echo 'selected'; ?>>Yıl (Önce En Yeni)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Ara / Filtrele</button>
            </div>
        </form>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
            <thead class="table-light">
                <tr class="text-secondary text-uppercase" style="font-size: 12px;">
                    <th style="width: 130px;"></th>
                    <th>Marka</th>
                    <th>Model</th>
                    <th>İlan Başlığı</th>
                    <th>Yıl</th>
                    <th>KM</th>
                    <th>Fiyat</th>
                    <th>Tarih</th>
                    <th>İl / İlçe</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($ilanlar) == 0): ?>
                    <tr><td colspan="9" class="text-center py-5 text-muted">Aradığınız kriterlere uygun ilan bulunamadı.</td></tr>
                <?php else: ?>
                    <?php foreach ($ilanlar as $ilan): 
                        // Resim Bulma
                        $stmt_resim = $db->prepare("SELECT resim_yolu FROM resimler WHERE ilan_id = ? LIMIT 1");
                        $stmt_resim->execute([$ilan['id']]);
                        $resim = $stmt_resim->fetch(PDO::FETCH_ASSOC);
                        $resim_yolu = $resim ? 'uploads/' . $resim['resim_yolu'] : 'img/no-image.jpg';
                    ?>
                    <tr onclick="window.location='index.php?sayfa=ilan-detay&id=<?php echo $ilan['id']; ?>'" style="cursor: pointer;">
                        <td>
                            <img src="<?php echo $resim_yolu; ?>" class="rounded" style="width: 110px; height: 80px; object-fit: cover;">
                        </td>
                        <td class="fw-bold"><?php echo htmlspecialchars($ilan['marka']); ?></td>
                        <td><?php echo htmlspecialchars($ilan['model']); ?></td>
                        <td class="text-primary fw-medium"><?php echo htmlspecialchars($ilan['baslik']); ?></td>
                        <td><?php echo $ilan['yil']; ?></td>
                        <td><?php echo number_format($ilan['km'], 0, ',', '.'); ?></td>
                        <td class="fw-bold text-danger fs-6"><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> TL</td>
                        <td class="text-muted" style="white-space: nowrap;"><?php echo date('d.m.Y', strtotime($ilan['ilan_tarihi'])); ?></td>
                        <td class="text-muted"><?php echo htmlspecialchars($ilan['il']); ?> / <?php echo htmlspecialchars($ilan['ilce']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div><style>
    .table-hover tbody tr:hover {
        background-color: #fcfcfc !important;
        transition: 0.3s;
    }
    .table img {
        transition: transform .2s;
    }
    .table tr:hover img {
        transform: scale(1.05);
    }
</style>