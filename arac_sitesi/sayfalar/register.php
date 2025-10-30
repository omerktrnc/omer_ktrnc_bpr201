<div class="container">
        <h2>Yeni Üye Kaydı</h2>

        <?php 
        // Eğer register-islem.php'den bir hata mesajı gelirse burada göster
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // Mesajı gösterdikten sonra sil
        }
        // Eğer başarı mesajı gelirse burada göster
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Mesajı gösterdikten sonra sil
        }
        ?>

        <form action="register-islem.php" method="POST">
            <label for="kullanici_adi">Kullanıcı Adı:</label>
            <input type="text" id="kullanici_adi" name="kullanici_adi" required>

            <label for="email">E-posta Adresi:</label>
            <input type="email" id="email" name="email" required>

            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre" name="sifre" required>
            
            <label for="sifre_tekrar">Şifre (Tekrar):</label>
            <input type="password" id="sifre_tekrar" name="sifre_tekrar" required>

            <button type="submit">Kayıt Ol</button>
        </form>

    </div>