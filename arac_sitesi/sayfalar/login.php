<?php
session_start();
if (isset($_SESSION['user_id'])) { header("Location: ../index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap | Mert Otomotiv</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 340px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2c3e50; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="text-align:center;">Giriş Yap</h2>
        <form action="../login-islem.php" method="POST">
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit">GİRİŞ YAP</button>
        </form>
        <p style="text-align:center; font-size:13px; margin-top:15px;"><a href="register.php">Hala kayıt olmadın mı?</a></p>
    </div>
</body>
</html>