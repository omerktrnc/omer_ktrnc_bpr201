<?php
// Oturumu başlat
session_start();

// Tüm oturum değişkenlerini temizle
session_unset();

// Oturumu yok et (dosyayı sil)
session_destroy();

// Kullanıcıyı ana sayfaya yönlendir
header("Location: index.php");
exit;
?>