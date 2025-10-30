<?php
// Oturumu başlat
session_start();

// Veritabanı bağlantısı
include 'db.php';

// === GÜVENLİK KONTROLÜ 1: Giriş Yapılmış mı? ===
// Giriş yapmamış biri buraya veri gönderemez
if (!isset($_SESSION['user_id'])) {
    // login.php'ye yönlendir
    header("Location: login.php");
    exit;
}

// === GÜVENLİK KONTROLÜ 2: Form POST ile mi gönderildi? ===
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. AŞAMA: Form Verilerini Al
    // (htmlspecialchars ile basit XSS koruması)
    $user_id = $_SESSION['user_id']; // Giriş yapan kullanıcının ID'si
    $baslik = htmlspecialchars($_POST['baslik']);
    $aciklama = htmlspecialchars($_POST['aciklama']);
    $fiyat = $_POST['fiyat'];
    $marka = htmlspecialchars($_POST['marka']);
    $model = htmlspecialchars($_POST['model']);
    $yil = $_POST['yil'];

    // Basit doğrulama (Boş alan var mı?)
    if (empty($baslik) || empty($fiyat) || empty($marka) || empty($model) || empty($yil)) {
        $_SESSION['error_message'] = "Lütfen tüm zorunlu alanları (Başlık, Fiyat, Marka, Model, Yıl) doldurun.";
        header("Location: index.php?sayfa=ilan-ver");
        exit;
    }

    // 2. AŞAMA: Veritabanı İşlemlerini Başlat (TRANSACTION)
    // Bu, "Ya hep ya hiç" demektir. Resim yüklenmezse, ilan da eklenmez.
    try {
        $db->beginTransaction();

        // 3. AŞAMA: İlanın Metin Bilgilerini 'ilanlar' Tablosuna Kaydet
        // (Admin onayı için 'durum' varsayılan olarak 'beklemede' olacak - DB'de öyle ayarlamıştık)
        $stmt_ilan = $db->prepare("INSERT INTO ilanlar (user_id, baslik, aciklama, fiyat, marka, model, yil) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_ilan->execute([$user_id, $baslik, $aciklama, $fiyat, $marka, $model, $yil]);

        // Az önce eklediğimiz ilanın ID'sini al (resimleri bu ID'ye bağlamak için)
        $ilan_id = $db->lastInsertId();


        // 4. AŞAMA: Resimleri Yükle ve 'resimler' Tablosuna Kaydet

        // Resimlerin yükleneceği klasör
        $target_dir = "uploads/"; 
        $resim_kaydedildi_mi = false; // En az 1 resim var mı kontrolü

        // $_FILES['resimler'] bir dizidir. 'name' bir dizi, 'tmp_name' bir dizi vb.
        // count() ile kaç adet resim yüklendiğini buluyoruz.
        $toplam_resim = count($_FILES['resimler']['name']);

        for ($i = 0; $i < $toplam_resim; $i++) {
            
            // Sadece bir dosya adı varsa (boş değilse) işlem yap
            if (!empty($_FILES['resimler']['name'][$i])) {
                
                $dosya_adi = basename($_FILES['resimler']['name'][$i]);
                $gecici_dosya_yolu = $_FILES['resimler']['tmp_name'][$i];
                
                // Güvenlik: Dosya adını benzersiz yap (aynı isimli dosyalar çakışmasın)
                // uniqid() -> o anlık benzersiz bir kod üretir
                $benzersiz_ad = uniqid() . '_' . $dosya_adi;
                $hedef_yol = $target_dir . $benzersiz_ad;

                // Dosya uzantı kontrolü (Sadece izin verilenler)
                $dosya_tipi = strtolower(pathinfo($hedef_yol, PATHINFO_EXTENSION));
                if ($dosya_tipi != "jpg" && $dosya_tipi != "png" && $dosya_tipi != "jpeg") {
                    throw new Exception("Sadece JPG, JPEG ve PNG dosyalarına izin verilmektedir.");
                }

                // Dosyayı 'uploads/' klasörüne taşı
                if (move_uploaded_file($gecici_dosya_yolu, $hedef_yol)) {
                    
                    // Taşıma başarılıysa, 'resimler' tablosuna kaydet
                    $stmt_resim = $db->prepare("INSERT INTO resimler (ilan_id, resim_yolu) VALUES (?, ?)");
                    $stmt_resim->execute([$ilan_id, $benzersiz_ad]); // Sadece dosya adını kaydediyoruz
                    
                    $resim_kaydedildi_mi = true; // En az bir resim başarıyla yüklendi

                } else {
                    throw new Exception("Dosya yüklenirken bir hata oluştu.");
                }
            }
        }

        // En az bir resim yüklenmesi zorunluysa bu kontrolü yap
        if (!$resim_kaydedildi_mi) {
            // (Eğer en az 1 resim zorunlu değilse bu 'if' bloğunu silebilirsiniz)
            throw new Exception("Lütfen en az bir adet araç resmi yükleyin.");
        }


        // 5. AŞAMA: Her Şey Başarılıysa İşlemi Onayla
        $db->commit();

        $_SESSION['success_message'] = "İlanınız başarıyla gönderildi. Admin onayından sonra yayınlanacaktır.";
        header("Location: index.php"); // Ana sayfaya yönlendir
        exit;

    } catch (Exception $e) {
        // 6. AŞAMA: Bir Hata Olursa Tüm İşlemleri Geri Al
        $db->rollBack();

        $_SESSION['error_message'] = "İlan kaydedilirken bir hata oluştu: " . $e->getMessage();
        header("Location: index.php?sayfa=ilan-ver");
        exit;
    }

} else {
    // POST ile gelinmediyse ana sayfaya yolla
    header("Location: index.php");
    exit;
}
?>