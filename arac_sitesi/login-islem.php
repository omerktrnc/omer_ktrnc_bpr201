<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantımızı çağır
include 'db.php';

// Sadece POST metodu ile gelindiyse işlem yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Formdan verileri al
    $email = htmlspecialchars($_POST['email']);
    $sifre_form = $_POST['sifre']; // Hash'lenecek şifre değil, karşılaştırılacak şifre

    // Boş alan kontrolü
    if (empty($email) || empty($sifre_form)) {
        $_SESSION['error_message'] = "Lütfen e-posta ve şifre alanlarını doldurun.";
        header("Location: index.php?sayfa=login");
        exit;
    }

    // 2. Veritabanından kullanıcıyı sorgula
    try {
        $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE email = ?");
        $stmt->execute([$email]);
        
        // fetch() ile kullanıcıyı bir dizi olarak al
        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Kullanıcı var mı?
        if ($kullanici) {
            
            // 4. Kullanıcı varsa, şifre doğru mu?
            // password_verify() fonksiyonu, formdan gelen şifre ile DB'deki hash'lenmiş şifreyi karşılaştırır.
            if (password_verify($sifre_form, $kullanici['sifre'])) {
                
                // GİRİŞ BAŞARILI!
                // 5. Kullanıcı bilgilerini "hafızaya" (Session) kaydet
                $_SESSION['user_id'] = $kullanici['id'];
                $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
                $_SESSION['is_admin'] = $kullanici['is_admin']; // Admin durumunu hafızaya al
                
                // Ana sayfaya yönlendir
                header("Location: index.php");
                exit;

            } else {
                // Şifre yanlış
                $_SESSION['error_message'] = "Hatalı şifre girdiniz.";
                header("Location: index.php?sayfa=login");
                exit;
            }

        } else {
            // E-posta bulunamadı
            $_SESSION['error_message'] = "Bu e-posta adresi ile kayıtlı bir kullanıcı bulunamadı.";
            header("Location: index.php?sayfa=login");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Veritabanı hatası: " . $e->getMessage();
        header("Location: index.php?sayfa=login");
        exit;
    }

} else {
    // POST ile gelinmediyse ana sayfaya yolla
    header("Location: index.php");
    exit;
}
?>