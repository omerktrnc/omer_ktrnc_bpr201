<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE id = ?");
$sorgu->execute([$_SESSION['user_id']]);
$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hesabım | Mert Otomotiv</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 50px; }
        .profil { background: white; padding: 30px; border-radius: 12px; max-width: 500px; margin: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="profil">
        <a href="../index.php">← Ana Sayfa</a>
        <h2>Profil Bilgileri</h2>
        <p><b>Kullanıcı Adı:</b> <?php echo htmlspecialchars($kullanici['kullanici_adi']); ?></p>
        <p><b>E-posta:</b> <?php echo htmlspecialchars($kullanici['email']); ?></p>
        <hr>
        <a href="ilanlarim.php" style="color:#3498db; font-weight:bold;">İlanlarımı Yönet</a>
    </div>
</body>
</html>