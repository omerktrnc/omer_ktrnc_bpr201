<?php
session_start();
include 'db.php'; // Bağlantın: $db

// Giriş yapılmamışsa veya ID gelmemişse ana sayfaya dön
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$ilan_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// GÜVENLİK: Sadece bu ilanı veren kişi silebilir
$sil = $db->prepare("DELETE FROM ilanlar WHERE id = ? AND user_id = ?");
$sil->execute([$ilan_id, $user_id]);

// Silme işleminden sonra ana sayfaya yönlendir
header("Location: index.php");
exit();
?>