<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Oturum kontrolü: Giriş yapmamış kullanıcı ilan kaydedemez
    if(!isset($_SESSION['user_id'])){
        header("Location: sayfalar/login.php");
        exit;
    }

    $u_id = $_SESSION['user_id'];
    
    // Formdan gelen verileri alıyoruz
    $baslik = $_POST['baslik'];
    $marka = $_POST['marka'];
    $seri = $_POST['seri'] ?? ''; 
    $model = $_POST['model'];
    $fiyat = $_POST['fiyat'];
    $km = $_POST['km'];
    $yil = $_POST['yil'];
    $yakit = $_POST['yakit'];
    $vites = $_POST['vites'];
    $motor_hacmi = $_POST['motor_hacmi'] ?? '';
    $motor_gucu = $_POST['motor_gucu'];
    $renk = $_POST['renk'] ?? ''; 
    
    // Konum Bilgileri
    $sehir = $_POST['sehir'] ?? '';
    $ilce = $_POST['ilce'] ?? '';
    
    $motor_tipi = $_POST['motor_tipi'] ?? ''; 
    $aciklama = $_POST['aciklama'];

    // MÜHÜR: Durumu 'onaylandi' yerine 'beklemede' yapıyoruz
    $durum = 'beklemede'; 

    // SQL Sorgusu (Toplam 18 placeholder)
    $sql = "INSERT INTO ilanlar (user_id, baslik, marka, seri, model, fiyat, km, yil, yakit, vites, motor_hacmi, motor_gucu, renk, sehir, ilce, motor_tipi, aciklama, durum) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $sorgu = $db->prepare($sql);
    
    $sorgu->execute([
        $u_id, $baslik, $marka, $seri, $model, $fiyat, $km, $yil, 
        $yakit, $vites, $motor_hacmi, $motor_gucu, $renk, $sehir, $ilce, $motor_tipi, $aciklama, $durum
    ]);
    
    $ilan_id = $db->lastInsertId();

    // Fotoğraf yükleme kısmı (Aynı kalıyor)
    if (isset($_FILES['ilan_resmi']) && !empty($_FILES['ilan_resmi']['name'][0])) {
        foreach ($_FILES['ilan_resmi']['name'] as $key => $val) {
            $dosya_adi = time() . "_" . $_FILES['ilan_resmi']['name'][$key];
            $gecici_yol = $_FILES['ilan_resmi']['tmp_name'][$key];
            if (move_uploaded_file($gecici_yol, "uploads/" . $dosya_adi)) {
                $resim_sorgu = $db->prepare("INSERT INTO resimler (ilan_id, resim_yolu) VALUES (?, ?)");
                $resim_sorgu->execute([$ilan_id, $dosya_adi]);
            }
        }
    }

    // Kullanıcıya ilanının onay beklediğini bildiriyoruz
    echo "<script>alert('İlanınız başarıyla alındı! Admin onayından sonra HızlıSat\'ta yayınlanacaktır.'); window.location.href='index.php';</script>";
}
?>