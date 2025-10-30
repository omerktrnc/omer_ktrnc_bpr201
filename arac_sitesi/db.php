<?php
/* Veritabanı Bağlantı Bilgileri */
$sunucu = "localhost";    // Sunucu adı
$kullanici = "root";      // Veritabanı kullanıcı adı (XAMPP için varsayılan 'root')
$sifre = "SimonRiley141.";              // Veritabanı şifresi (XAMPP için varsayılan 'boş')
$veritabani = "arac_sitesi"; // Veritabanı adı

/* Bağlantıyı Oluşturma */
try {
    $db = new PDO("mysql:host=$sunucu;dbname=$veritabani;charset=utf8", $kullanici, $sifre);
    // Hata modunu ayarla
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Bağlantı başarılı!"; // Test için bu satırı açabilirsiniz
} catch(PDOException $e) {
    // Bağlantı hatası varsa göster
    die("Bağlantı hatası: " . $e->getMessage());
}
?>