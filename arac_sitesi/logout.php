<?php
session_start();
session_destroy(); // Tüm oturum bilgilerini sil
header("Location: index.php"); // Ana sayfaya gönder
exit();
?>