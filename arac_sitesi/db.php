<?php
$host = "localhost:3306"; 
$user = "root";
$pass = ""; 
$dbname = "arac_sitesi";
try {   
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("bağlantı hatası: " . $e->getMessage());
}
?>