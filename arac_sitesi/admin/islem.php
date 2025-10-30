<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantısı (Bir üst klasördeki db.php'yi çağırır)
include '../db.php';

// === ADMİN GÜVENLİK KONTROLÜ ===
// Bu işlemi sadece giriş yapmış ve admin olanlar yapabilir
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Yetkisi yoksa, ana sayfaya at
    header("Location: ../index.php");
    exit;
}

// === 1. Verileri Al (GET ile) ===
// Linkten gelen 'id' ve 'action' parametrelerini al
if (isset($_GET['id']) && isset($_GET['action'])) {
    
    $ilan_id = $_GET['id'];
    $action = $_GET['action'];
    $yeni_durum = "";

    // 2. Aksiyona (action) göre yeni durumu belirle
    if ($action == 'onayla') {
        $yeni_durum = 'onaylandi';
    } elseif ($action == 'reddet') {
        $yeni_durum = 'reddedildi';
    } else {
        // Geçersiz bir aksiyon gelirse, admin paneline geri yolla
        header("Location: index.php");
        exit;
    }

    // 3. Veritabanını Güncelle (UPDATE)
    try {
        $stmt = $db->prepare("UPDATE ilanlar SET durum = ? WHERE id = ?");
        $stmt->execute([$yeni_durum, $ilan_id]);

        // İşlem başarılıysa...
        if ($action == 'onayla') {
            $_SESSION['success_message'] = "İlan (ID: $ilan_id) başarıyla onaylandı.";
        } else {
            $_SESSION['success_message'] = "İlan (ID: $ilan_id) başarıyla reddedildi.";
        }
        
        // Admin paneli ana sayfasına geri yönlendir
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        // Hata olursa (örn: o ID'de ilan yoksa)
        // Hata mesajını değişkene atıp geri yollayabilirdik ama şimdilik basit tutalım
        $_SESSION['error_message'] = "İşlem sırasında bir hata oluştu: " . $e->getMessage();
        header("Location: index.php");
        exit;
    }

} else {
    // Eğer 'id' veya 'action' parametresi gelmemişse,
    // direkt admin paneline geri yolla
    header("Location: index.php");
    exit;
}
?>