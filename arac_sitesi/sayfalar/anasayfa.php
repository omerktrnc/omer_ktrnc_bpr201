<?php
/* sayfalar/anasayfa.php
   Bu sayfa, ana index.php'nin İÇİNDE çalıştığı için,
   $db değişkenine (veritabanı bağlantısı) zaten sahiptir.
   Biz burada sadece anasayfaya özel olan "ilanları çekme" işini yapacağız.
*/

// Veritabanından ONAYLANMIŞ ilanları çek
try {
    // Sadece durumu 'onaylandi' olanları al ve en yeniden eskiye sırala
    $stmt_ilanlar = $db->prepare("SELECT * FROM ilanlar WHERE durum = 'onaylandi' ORDER BY ilan_tarihi DESC");
    $stmt_ilanlar->execute();
    $ilanlar = $stmt_ilanlar->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Hata olursa göster
    die("Veritabanı hatası: " . $e->getMessage());
}

?>
<div class="container">
        <h1>Ana Sayfa - Satılık Araçlar</h1>
        
        <?php 
        // İlan kaydederken gelen başarı/hata mesajlarını göster
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); 
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); 
        }
        ?>

        <div class="ilan-listesi">

            <?php
            // Eğer hiç onaylanmış ilan yoksa
            if (count($ilanlar) == 0) {
                echo "<p>Gösterilecek onaylanmış ilan bulunmamaktadır.</p>";
            } else {
                
                // Onaylanmış ilanlar varsa, her bir ilan için dön (foreach döngüsü)
                foreach ($ilanlar as $ilan) {
                    
                    // --- Her ilanın ilk resmini bul ---
                    $stmt_resim = $db->prepare("SELECT resim_yolu FROM resimler WHERE ilan_id = ? LIMIT 1");
                    $stmt_resim->execute([$ilan['id']]);
                    $ilk_resim = $stmt_resim->fetch(PDO::FETCH_ASSOC);

                    // Resim bulunduysa yolunu al, bulunamadıysa varsayılan resim kullan
                    if ($ilk_resim) {
                        $resim_yolu = 'uploads/' . htmlspecialchars($ilk_resim['resim_yolu']);
                    } else {
                        // Eğer hiç resmi yoksa (ki bizim sistemde zorunlu ama garanti olsun)
                        $resim_yolu = 'https://via.placeholder.com/300x200?text=Resim+Yok';
                    }
                    // --- İlk resim bulma bitti ---

                    // Şimdi bu ilanın HTML kartını ekrana bas
                    // Şimdi bu ilanın HTML kartını ekrana bas
                    // Kartın tamamını, ilanın detay sayfasına giden bir link yap
                    echo '<a href="index.php?sayfa=ilan-detay&id=' . $ilan['id'] . '" class="ilan-kart-link">';
                    echo '  <div class="ilan-kart">';
                    echo '      <img src="' . $resim_yolu . '" alt="' . htmlspecialchars($ilan['baslik']) . '">';
                    echo '      <div class="ilan-kart-body">';
                    echo '          <h3>' . htmlspecialchars($ilan['baslik']) . '</h3>';
                    // number_format ile fiyata binlik ayraç (1.000.000) ekleyelim
                    echo '          <p class="ilan-fiyat">' . number_format($ilan['fiyat'], 0, ',', '.') . ' TL</p>';
                    echo '          <p>' . htmlspecialchars($ilan['marka']) . ' ' . htmlspecialchars($ilan['model']) . ' (' . htmlspecialchars($ilan['yil']) . ')</p>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</a>';

                } // foreach döngüsü biter
            } // else biter
            ?>
            
        </div>
        </div>