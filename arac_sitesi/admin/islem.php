<?php
session_start();
include '../db.php';

// Admin kontrolü
if (!isset($_SESSION['user_id'])) { die("Yetkisiz erişim."); }

$id = (int)($_GET['id'] ?? 0);
$islem = $_GET['islem'] ?? '';

if ($id > 0) {
    if ($islem == 'onayla') {
        $guncelle = $db->prepare("UPDATE ilanlar SET durum = 'onaylandi' WHERE id = ?");
        $guncelle->execute([$id]);
    } elseif ($islem == 'sil') {
        // İncelediğimiz dosya yapısına uygun silme işlemi
        $sil = $db->prepare("DELETE FROM ilanlar WHERE id = ?");
        $sil->execute([$id]);
    }
}

header("Location: index.php");
exit();