<?php
// Oturumu ve Veritabanını en başta çağır
session_start();
include 'db.php';

// === HANGİ ODAYI AÇACAĞIMIZA KARAR VERELİM ===
// 1. Adres çubuğunda ?sayfa=... diye bir şey yazıyor mu?
if (isset($_GET['sayfa'])) {
    $sayfa = $_GET['sayfa'];
} else {
    // 2. Eğer yazmıyorsa (yani siteye ilk kez giriliyorsa), 'anasayfa'yı aç
    $sayfa = 'anasayfa';
}

// 3. İzin verilen sayfaların listesi (Güvenlik için)
$izinli_sayfalar = [
    'anasayfa', 
    'login', 
    'register', 
    'ilan-ver', 
    'ilan-detay', 
    'hesabim' // Bunu 11. adımda kullanacağız
];

// 4. İstenen sayfa, izinli listede var mı?
if (!in_array($sayfa, $izinli_sayfalar)) {
    // Eğer listede yoksa (kötü niyetli bir şey yazılmışsa)
    // yine 'anasayfa'yı aç
    $sayfa = 'anasayfa';
}

// === GÜVENLİK KONTROLLERİ (Hangi odaya kim girebilir?) ===

// 'İlan Ver' veya 'Hesabım' odalarına sadece GİRİŞ YAPANLAR girebilir
if ($sayfa == 'ilan-ver' || $sayfa == 'hesabim') {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "Bu odaya girmek için giriş yapmalısın.";
        // Giriş odasına yönlendir
        header("Location: index.php?sayfa=login");
        exit;
    }
}

// 'Giriş' veya 'Kayıt Ol' odalarına GİRİŞ YAPMIŞ olanlar giremez
if ($sayfa == 'login' || $sayfa == 'register') {
     if (isset($_SESSION['user_id'])) {
        // Ana salona (anasayfa) yönlendir
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Araç Satış Sitesi</title>
    <link rel="stylesheet" href="style.css">
    <?php if ($sayfa == 'hesabim'): ?>
        <link rel="stylesheet" href="admin/admin-style.css">
    <?php endif; ?>
</head>
<body>

    <nav>
        <a href="index.php?sayfa=anasayfa">Ana Sayfa</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?sayfa=ilan-ver">Ücretsiz İlan Ver</a>
            <a href="index.php?sayfa=hesabim">Hesabım (<?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?>)</a>
            <a href="logout.php">Çıkış Yap</a> <?php else: ?>
            <a href="index.php?sayfa=login">Giriş Yap</a>
            <a href="index.php?sayfa=register">Kayıt Ol</a>
            <a href="index.php?sayfa=ilan-ver">Ücretsiz İlan Ver</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <?php
        // İstenen odanın dosya yolunu oluştur
        $dosya_yolu = "sayfalar/" . $sayfa . ".php";
        // O dosyayı bul ve içeriğini buraya dahil et
        include $dosya_yolu;
        ?>
    </div>

</body>
</html>