<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantısı
include 'db.php';

// === GÜVENLİK KONTROLÜ 1: Giriş Yapmış mı? ===
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Bu işlemi yapmak için giriş yapmalısınız.";
    header("Location: login.php");
    exit;
}

// === GÜVENLİK KONTROLÜ 2: Silinecek İlan ID'si Geldi mi? ===
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Geçersiz ilan ID'si.";
    header("Location: hesabim.php");
    exit;
}

$ilan_id = $_GET['id'];
$user_id = $_SESSION['user_id']; // Giriş yapan kullanıcının ID'si

try {
    // === GÜVENLİK KONTROLÜ 3: İlan Kullanıcıya mı Ait? (EN ÖNEMLİ KONTROL) ===
    // Başka birinin ID'sini adres çubuğuna yazarak onun ilanını silmesini engelle!
    $stmt_check = $db->prepare("SELECT user_id FROM ilanlar WHERE id = ?");
    $stmt_check->execute([$ilan_id]);
    $ilan = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$ilan) {
        $_SESSION['error_message'] = "İlan bulunamadı.";
        header("Location: hesabim.php");
        exit;
    }

    // İlandaki user_id ile oturumdaki user_id eşleşmiyorsa
    if ($ilan['user_id'] != $user_id) {
        // (Admin kontrolü de eklenebilir ama bu dosya kullanıcıya özel)
        $_SESSION['error_message'] = "Bu ilanı silme yetkiniz yok!";
        header("Location: hesabim.php");
        exit;
    }

    // === 1. AŞAMA: İLANA AİT RESİM DOSYALARINI SİL (Sunucudan) ===
    // Önce resimlerin adlarını DB'den al
    $stmt_resimler = $db->prepare("SELECT resim_yolu FROM resimler WHERE ilan_id = ?");
    $stmt_resimler->execute([$ilan_id]);
    $resimler = $stmt_resimler->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resimler as $resim) {
        $dosya_yolu = 'uploads/' . $resim['resim_yolu'];
        // dosya 'uploads/' klasöründe varsa, sil (unlink)
        if (file_exists($dosya_yolu)) {
            unlink($dosya_yolu);
        }
    }

    // === 2. AŞAMA: İLANI VERİTABANINDAN SİL ===
    // Sadece 'ilanlar' tablosundan silmemiz yeterli.
    // 'resimler' tablosundaki kayıtlar, 'ON DELETE CASCADE' sayesinde
    // veritabanı tarafından otomatik olarak silinecektir.
    $stmt_delete = $db->prepare("DELETE FROM ilanlar WHERE id = ? AND user_id = ?");
    $stmt_delete->execute([$ilan_id, $user_id]);

    // Başarılı
    $_SESSION['success_message'] = "İlanınız (ID: $ilan_id) başarıyla silindi.";
    header("Location: hesabim.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['error_message'] = "Silme işlemi sırasında bir hata oluştu: " . $e->getMessage();
    header("Location: hesabim.php");
    exit;
}
?>