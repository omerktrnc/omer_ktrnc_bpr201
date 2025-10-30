<div class="container">
        <h2>Üye Girişi</h2>

        <?php 
        // Eğer register-islem.php'den (kayıt sonrası) veya 
        // login-islem.php'den (hatalı giriş) bir mesaj gelirse göster
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // Mesajı gösterdikten sonra sil
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Mesajı gösterdikten sonra sil
        }
        ?>

        <form action="login-islem.php" method="POST">
            <label for="email">E-posta Adresi:</label>
            <input type="email" id="email" name="email" required>

            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre" name="sifre" required>

            <button type="submit">Giriş Yap</button>
        </form>

    </div>