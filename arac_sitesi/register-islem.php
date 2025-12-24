<?php
session_start();
include 'db.php'; // Veritabanı bağlantı değişkenin: $db

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Formdan gelen verileri temizleyerek alıyoruz
    $k_ad = trim($_POST['k_ad']);
    $email = trim($_POST['email']);
    $sifre = $_POST['sifre'];

    // 2. MÜHÜR: Kullanıcı adı veya E-posta zaten var mı kontrolü
    $kontrol_sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ? OR email = ?");
    $kontrol_sorgu->execute([$k_ad, $email]);

    if ($kontrol_sorgu->rowCount() > 0) {
        // Eğer veritabanında bu bilgilerden biri varsa işlemi durduruyoruz
        echo "<script>alert('Hata: Bu kullanıcı adı veya e-posta adresi zaten kullanımda!'); window.history.back();</script>";
        exit();
    }

    // 3. GÜVENLİK: Şifreyi veritabanında gizli (hash) olarak saklıyoruz
    $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);

    try {
        // 4. KAYIT İŞLEMİ: Tüm kontroller geçtiyse veriyi ekliyoruz
        $ekle = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre, rol) VALUES (?, ?, ?, 'user')");
        $ekle->execute([$k_ad, $email, $hashed_sifre]);
        
        echo "<script>alert('Kayıt Başarılı! Giriş yapabilirsiniz.'); window.location.href='sayfalar/login.php';</script>";
    } catch (PDOException $e) {
        // Veritabanı kaynaklı beklenmedik bir hata olursa burası çalışır
        echo "<script>alert('Beklenmedik bir hata oluştu: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>