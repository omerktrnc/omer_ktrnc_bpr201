<?php
// oturumu başlat
session_start();
// veritabanı bağlantısı
include 'db.php';

// === güvenlik 1 giriş yapmış mı ===
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sayfa=login");
    exit;
}

// === güvenlik 2 post ile mi gelindi ===
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1 formdan gelen tüm verileri al
    // (aynı ilan-kaydet.php'deki gibi)
    $user_id = $_SESSION['user_id']; // giriş yapan kullanıcı
    $ilan_id = $_POST['ilan_id'];   // bu, gizli input'tan geldi

    $baslik = htmlspecialchars($_POST['baslik']);
    $aciklama = htmlspecialchars($_POST['aciklama']);
    $fiyat = $_POST['fiyat'];
    $marka = htmlspecialchars($_POST['marka']);
    $model = htmlspecialchars($_POST['model']);
    $yil = $_POST['yil'];
    $il = htmlspecialchars($_POST['il']);
    $ilce = htmlspecialchars($_POST['ilce']);
    $mahalle = htmlspecialchars($_POST['mahalle']);
    $km = $_POST['km'];
    $yakit_tipi = htmlspecialchars($_POST['yakit_tipi']);
    $vites = htmlspecialchars($_POST['vites']);
    $kasa_tipi = htmlspecialchars($_POST['kasa_tipi']);
    $motor_gucu = htmlspecialchars($_POST['motor_gucu']);
    $motor_hacmi = htmlspecialchars($_POST['motor_hacmi']);
    $renk = htmlspecialchars($_POST['renk']);
    $kimden = htmlspecialchars($_POST['kimden']);
    $takas = htmlspecialchars($_POST['takas']);

    // boş alan kontrolü (basit)
    if (empty($baslik) || empty($fiyat) || empty($ilan_id)) {
        $_SESSION['error_message'] = "başlık fiyat veya ilan id'si boş olamaz";
        header("Location: index.php?sayfa=ilan-duzenle&id=" . $ilan_id);
        exit;
    }

    // 2 veritabanını güncelle (update)
    try {
        // güvenlik: ilanın hala bu kullanıcıya ait olduğunu
        // update sorgusunun where kısmında tekrar kontrol et

        $sql = "UPDATE ilanlar SET 
                    baslik = ?, aciklama = ?, fiyat = ?, marka = ?, model = ?, yil = ?, 
                    il = ?, ilce = ?, mahalle = ?, km = ?, yakit_tipi = ?, vites = ?, 
                    kasa_tipi = ?, motor_gucu = ?, motor_hacmi = ?, renk = ?, kimden = ?, takas = ?
                WHERE id = ? AND user_id = ?"; // <-- en önemli güvenlik burada

        $stmt = $db->prepare($sql);

        // execute sırası çok önemli
        $stmt->execute([
            $baslik, $aciklama, $fiyat, $marka, $model, $yil,
            $il, $ilce, $mahalle, $km, $yakit_tipi, $vites,
            $kasa_tipi, $motor_gucu, $motor_hacmi, $renk, $kimden, $takas,
            $ilan_id, $user_id // son iki ?'nin karşılığı (where)
        ]);

        // güncelleme başarılı
        $_SESSION['success_message'] = "ilan (id: $ilan_id) başarıyla güncellendi";
        header("Location: index.php?sayfa=hesabim"); // hesabım sayfasına dön
        exit;

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "güncelleme sırasında hata: " . $e->getMessage();
        // hata olursa düzenleme formuna geri dön
        header("Location: index.php?sayfa=ilan-duzenle&id=" . $ilan_id);
        exit;
    }

} else {
    // post ile gelinmediyse ana sayfaya at
    header("Location: index.php");
    exit;
}
?>