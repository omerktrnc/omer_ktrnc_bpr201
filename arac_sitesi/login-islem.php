<?php
session_start(); // 1. Kural: Her zaman en üstte
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alıyoruz
    $email = trim($_POST['email']);
    $sifre = $_POST['sifre'];

    // 1. ADIM: Kullanıcıyı sadece E-POSTA ile çekiyoruz
    // Şifreyi burada sorguya katmıyoruz çünkü veritabanındaki şifre hash'lenmiş durumda.
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE email = ?");
    $sorgu->execute([$email]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    // 2. ADIM: Kullanıcı bulundu mu ve şifre doğrulanıyor mu kontrol et
    if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
        
        // ŞİFRE DOĞRU: Oturum bilgilerini mühürlüyoruz
        $_SESSION['user_id'] = $kullanici['id'];
        $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
        
        // Giriş başarılı, ana sayfaya yönlendir
        header("Location: index.php"); 
        exit();
    } else {
        // ŞİFRE VEYA E-POSTA HATALI
        echo "<script>alert('E-posta veya şifre hatalı!'); window.location.href='sayfalar/login.php';</script>";
    }
}
?>