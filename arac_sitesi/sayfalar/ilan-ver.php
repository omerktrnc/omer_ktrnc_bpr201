<?php 
session_start(); 
if(!isset($_SESSION['user_id'])){ 
    header("Location: login.php"); 
    exit; 
} 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlan Ver | HızlıSat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .form-konteynir { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .form-baslik { color: #2c3e50; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px; margin-bottom: 20px; font-family: 'Poppins', sans-serif; }
        .form-grup { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; }
        .input-alan { display: flex; flex-direction: column; }
        label { font-size: 14px; font-weight: bold; color: #555; margin-bottom: 5px; }
        input, select, textarea { padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
        .tam-genislik { grid-column: span 2; }
        .kaydet-btn { background: #2c3e50; color: white; padding: 15px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.3s; width: 100%; margin-top: 10px; }
        .kaydet-btn:hover { background: #34495e; }
    </style>
</head>
<body>

<div class="form-konteynir">
    <h2 class="form-baslik"><i class="fa-solid fa-plus"></i> Yeni İlan Oluştur</h2>
    <form action="../ilan-kaydet.php" method="POST" enctype="multipart/form-data">
        
        <div class="form-grup">
            <div class="input-alan tam-genislik">
                <label>İlan Başlığı</label>
                <input type="text" name="baslik" placeholder="Örn: Hatasız Boyasız BMW 3 Serisi" required>
            </div>
            
            <div class="input-alan">
                <label>Marka</label>
                <input type="text" name="marka" placeholder="Örn: BMW" required>
            </div>

            <div class="input-alan">
                <label>Seri</label>
                <input type="text" name="seri" placeholder="Örn: 3 Serisi">
            </div>

            <div class="input-alan">
                <label>Model</label>
                <input type="text" name="model" placeholder="Örn: 320i ED 40th Year" required>
            </div>

            <div class="input-alan">
                <label>Model Yılı</label>
                <input type="number" name="yil" required>
            </div>

            <div class="input-alan">
                <label>Fiyat (TL)</label>
                <input type="number" name="fiyat" required>
            </div>
            
            <div class="input-alan">
                <label>Kilometre</label>
                <input type="number" name="km" required>
            </div>

            <div class="input-alan">
                <label>Yakıt Türü</label>
                <select name="yakit">
                    <option value="Benzin">Benzin</option>
                    <option value="Dizel">Dizel</option>
                    <option value="LPG">LPG / Benzin</option>
                    <option value="Elektrik">Elektrik</option>
                </select>
            </div>
            
            <div class="input-alan">
                <label>Vites</label>
                <select name="vites">
                    <option value="Manuel">Manuel</option>
                    <option value="Otomatik">Otomatik</option>
                    <option value="Yarı Otomatik">Yarı Otomatik</option>
                </select>
            </div>

            <div class="input-alan">
                <label>Şehir</label>
                <input type="text" name="sehir" placeholder="Örn: İstanbul" required>
            </div>
            
            <div class="input-alan">
                <label>İlçe</label>
                <input type="text" name="ilce" placeholder="Örn: Kadıköy" required>
            </div>

            <div class="input-alan">
                <label>Renk</label>
                <input type="text" name="renk" placeholder="Örn: Metalik Gri" required>
            </div>

            <div class="input-alan">
                <label>Motor Gücü (HP)</label>
                <input type="text" name="motor_gucu" placeholder="Örn: 170">
            </div>

            <div class="input-alan tam-genislik">
                <label>İlan Açıklaması</label>
                <textarea name="aciklama" rows="5" required placeholder="Aracınızın tüm özelliklerini buraya yazın..."></textarea>
            </div>

            <div class="input-alan tam-genislik">
                <label>Araç Fotoğrafları</label>
                <input type="file" name="ilan_resmi[]" multiple required>
            </div>
        </div>

        <button type="submit" class="kaydet-btn">İLAN YAYINLA</button>
    </form>
</div>

</body>
</html>