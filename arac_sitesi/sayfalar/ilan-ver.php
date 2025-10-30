<div class="container">
        <h2>Yeni Araç İlanı Ver</h2>
        
        <?php 
        // İlan kaydederken bir hata olursa (Adım 6'da yapacağız)
        // mesajı burada göstereceğiz.
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); 
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); 
        }
        ?>

        <form action="ilan-kaydet.php" method="POST" enctype="multipart/form-data">
            
            <label for="baslik">İlan Başlığı:</label>
            <input type="text" id="baslik" name="baslik" required placeholder="Örn: Sahibinden Temiz Focus">

            <label for="aciklama">Açıklama:</label>
            <textarea id="aciklama" name="aciklama" rows="6" placeholder="Aracın özelliklerini, durumunu vb. detaylıca yazın..."></textarea>

            <label for="fiyat">Fiyat (TL):</label>
            <input type="number" id="fiyat" name="fiyat" required placeholder="Örn: 500000">

            <label for="marka">Marka:</label>
            <input type="text" id="marka" name="marka" required placeholder="Örn: Ford">

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required placeholder="Örn: Focus">

            <label for="yil">Yıl:</label>
            <input type="number" id="yil" name="yil" required placeholder="Örn: 2018">

            <label for="resimler">Araç Resimleri (Birden fazla seçebilirsiniz):</label>
            <input type="file" id="resimler" name="resimler[]" multiple accept="image/jpeg, image/png">

            <button type="submit">İlanı Gönder</button>
        </form>

    </div>