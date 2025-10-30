<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantımızı çağır
include 'db.php';

// POST ile veri gelip gelmediğini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Formdan gelen verileri al ve temizle
    // (htmlspecialchars ile XSS açığını basitçe engelliyoruz)
    $kullanici_adi = htmlspecialchars($_POST['kullanici_adi']);
    $email = htmlspecialchars($_POST['email']);
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];

    // 2. Basit Doğrulamalar
    // Boş alan var mı?
    if (empty($kullanici_adi) || empty($email) || empty($sifre) || empty($sifre_tekrar)) {
        $_SESSION['error_message'] = "Lütfen tüm alanları doldurun.";
        header("Location: index.php?sayfa=register"); 
        exit; // Kodu burada durdur
    }

    // Şifreler uyuşuyor mu?
    if ($sifre != $sifre_tekrar) {
        $_SESSION['error_message'] = "Şifreler birbirleriyle uyuşmuyor.";
        header("Location: index.php?sayfa=register");
        exit;
    }

    // 3. E-posta adresi zaten kayıtlı mı?
    try {
        $stmt = $db->prepare("SELECT id FROM kullanicilar WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            // Eğer fetch() bir sonuç döndürürse, bu email kayıtlıdır
            $_SESSION['error_message'] = "Bu e-posta adresi zaten kayıtlı.";
            header("Location: index.php?sayfa=register");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Veritabanı hatası: " . $e->getMessage();
        header("Location: index.php?sayfa=register");
        exit;
    }


    // 4. Şifreyi Hash'leme (Güvenlik için çok önemli!)
    // Şifreyi ASLA veritabanına olduğu gibi kaydetmeyiz.
    $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);


    // 5. Veritabanına Ekleme (INSERT)
    try {
        // Hazırlıklı ifadeler (Prepared Statements) SQL Injection'ı engeller
        $stmt = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre) VALUES (?, ?, ?)");
        
        // Sorguyu çalıştır
        $stmt->execute([$kullanici_adi, $email, $hashed_sifre]);

        // Başarılı olursa...
        $_SESSION['success_message'] = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
        header("Location: index.php?sayfa=login"); // Giriş sayfasına yönlendir
        exit;

    } catch (PDOException $e) {
        // Bir hata olursa...
        $_SESSION['error_message'] = "Kayıt sırasında bir hata oluştu: " . $e->getMessage();
        header("Location: index.php?sayfa=register");
        exit;
    }

} else {
    // Eğer bu sayfaya POST ile gelinmediyse (örn: tarayıcıdan direkt adres yazıldıysa)
    // Ana sayfaya yolla
    header("Location: index.php");
    exit;
}
?>