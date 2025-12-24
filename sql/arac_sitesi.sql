-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 24 Ara 2025, 23:24:14
-- Sunucu sürümü: 9.1.0
-- PHP Sürümü: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `arac_sitesi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilanlar`
--

DROP TABLE IF EXISTS `ilanlar`;
CREATE TABLE IF NOT EXISTS `ilanlar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text,
  `fiyat` decimal(12,2) DEFAULT NULL,
  `marka` varchar(50) DEFAULT NULL,
  `seri` varchar(100) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `yil` int DEFAULT NULL,
  `il` varchar(50) DEFAULT NULL,
  `ilce` varchar(50) DEFAULT NULL,
  `mahalle` varchar(50) DEFAULT NULL,
  `km` int DEFAULT NULL,
  `yakit` varchar(50) DEFAULT NULL,
  `yakit_tipi` varchar(50) DEFAULT NULL,
  `vites` varchar(50) DEFAULT NULL,
  `kasa_tipi` varchar(50) DEFAULT NULL,
  `motor_gucu` varchar(50) DEFAULT NULL,
  `motor_tipi` varchar(50) DEFAULT NULL,
  `motor_hacmi` varchar(50) DEFAULT NULL,
  `renk` varchar(50) DEFAULT NULL,
  `sehir` varchar(50) DEFAULT NULL,
  `kimden` varchar(50) DEFAULT NULL,
  `takas` varchar(10) DEFAULT NULL,
  `durum` varchar(20) DEFAULT 'beklemede',
  `ilan_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `ilanlar`
--

INSERT INTO `ilanlar` (`id`, `user_id`, `baslik`, `aciklama`, `fiyat`, `marka`, `seri`, `model`, `yil`, `il`, `ilce`, `mahalle`, `km`, `yakit`, `yakit_tipi`, `vites`, `kasa_tipi`, `motor_gucu`, `motor_tipi`, `motor_hacmi`, `renk`, `sehir`, `kimden`, `takas`, `durum`, `ilan_tarihi`) VALUES
(25, 11, 'MERT OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ MEGANE 4 TOUCH', 'ARAÇ 2018 ŞUBAT TRAFİK ÇKŞLIDIR\r\nTOCH PLUS PAKETTİR\r\nARAÇ İLK SAHİBİNDEN ALINMADIR\r\nİLK PLAKASIDIR\r\nARACIN İÇİ DIŞI TERTEMİZDİR \r\nEZİK ÇIZIK YANIK YIRTIK VS YOKTUR \r\nYEDEK ANAHTARI KİTAPÇIĞI STEPNESİ MEVCUTTUR \r\n\r\nARACIN BAŞLICA ÖZELLİKLERİ \r\nGERİ GÖRÜŞ KAMERASI\r\nTESLA EKRAN \r\nYOUTUBE VİDİO OYNATMA\r\nYOL BİLGİSAYARI\r\nANAHTARSIZ GİRİŞ ÇIKIŞ\r\nSTAR STOP\r\nLED FAR\r\nHIZ SABİTLEME\r\nYOKUŞ KALKIŞ DESTEĞİ\r\nKARARAN DİKİN AYNASI\r\nYAĞMUR SENSÖRÜ\r\nVS ', 1200000.00, 'renault', 'megane', 'touch', 2018, '', 'altındağ', '', 142000, 'Dizel', '', 'Otomatik', '', '110', '', '', 'füme', 'ankara', '', '', 'onaylandi', '2025-12-24 22:32:15'),
(26, 11, 'MERT OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ HONDA CİVİC ', '2012 MODEL HONDA CIVIC \r\n\r\n1.6 i-VTEC EcoElegance \r\n\r\n137 BIN KM DE\r\n\r\n\r\nEXPERTİZ BİLGİSİ |  \r\n\r\nBOYA YOK \r\n\r\nDEGISEN PARCA YOK\r\n\r\nTRAMER BİLGİSİ | YOK\r\n\r\n_________________________________________\r\n\r\n40. YIL\r\n\r\nSUNROOF\r\n\r\nELEKTİRİKLİ KATLANIR AYNA\r\n\r\nLED FARLAR\r\n\r\nPARK SENSORLERI\r\n\r\nHIZ SABITLEME\r\n\r\nYOKUS KALKIS DESTEGI\r\n\r\nFAR SENSORU\r\n\r\nYAGMUR SENSORU\r\n\r\nKUMAS DOSEMELER\r\n\r\nCIFT YONLI KLIMALATOR\r\n\r\nFONKSIYONEL DIREKSIYON\r\n\r\nIC AYDINLATMALAR\r\n\r\nABS/ESP/EDL\r\n\r\nAYARLANABILIR OTO AYNA\r\n\r\nBLUETOOTH/USB/CD/RADIO\r\n\r\nUYGUN ARACLARLA TAKAS IMKANI', 1250000.00, 'honda', 'civic', 'i-vtec eco elegance', 2012, '', 'altındağ', '', 137000, 'LPG', '', 'Otomatik', '', '125', '', '', 'füme', 'ankara', '', '', 'onaylandi', '2025-12-24 22:39:52'),
(27, 10, 'ÖMER OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ SIFIR AYARINDA TECHNO ESPRİT ALPİNE GSR2', 'HATASIZ BOYASIZ TRAMERSİZ \r\n\r\nEZİK ÇİZİK GÖÇÜK LEKE YOKTUR \r\n\r\nİÇİNDE YANIK YIRTIK DEFORME YOKTUR\r\n\r\nSIFIRDAN FARKSIZ \r\n\r\n\r\n2024 MODEL TECHNO ESPİRT ALPİNE\r\n\r\nEN DOLU MODELİ GSR2 PAKET \r\n\r\n\r\nYEDEK ANAHTARI KİTAPCIKLARI \r\n\r\nİLK YARDIM ÇANTASI MEVCUTTUR\r\n\r\n\r\nİLK SAHİBİNDEN ALINMIŞTIR TEK KİŞİ TARAFINDAN ÖZENLE KULLANILMIŞTIR\r\nKAPALI GARAJDA MUFAZA EDİLMİŞTİR\r\n\r\n\r\nBAKIMI YETKİLİ SERVİSTE EKİM AYINDA YAPILMIŞTIR FATURASI VE KAYITLARI MEVCUTTUR \r\nGARANTİSİ DEVAM ETMEKTEDİR\r\n\r\n\r\nÖZELLİKLER\r\n\r\nHAYALET GÖSTERGE - ŞERİT TAKİP SİSTEMİ\r\nKABLOSUZ ŞARJ - TESLA EKRAN \r\nGERİ GÖRÜŞ KAMERASI - ÇARPIŞMA ÖNLEYİCİ \r\nANAHTARSIZ GİRİŞ - PARK ASİSTANI \r\nANAHTARSIZ ÇALIŞTIRMA - APPLE CAR PLAY \r\nSPOR KOLTUKLAR - YENİ LOGO DİREKSİYON \r\nTABELA OKUMA - GSR2 GÜVENLİK PAKETİ \r\nSTART STOP            ', 1420000.00, 'renault', 'clio', 'techno esprit alpine', 2024, NULL, 'altındağ', NULL, 7200, 'Benzin', NULL, 'Otomatik', NULL, '90', '', '', 'turuncu', 'ankara', NULL, NULL, 'onaylandi', '2025-12-24 22:51:51'),
(28, 10, 'ÖMER OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ DÜŞÜK KM 40 TH YEAR EDİTİON 320İ ED', 'ÖMER OTOMOTİVDEN \r\n\r\n\r\nKREDİ KARTINA 12 TAKSİT\r\n\r\n24 AY KREDİ İMKANI\r\n\r\nARAÇ ÖZELLİKLERİ\r\n\r\nSUNROOF\r\n\r\nHAYALET EKRAN\r\n\r\nHARMAN KARDON PREMİUM (LOGİC 7)\r\n\r\nNBT (GENİŞ EKRAN)\r\n\r\nIŞIK PAKETİ -KAPI KOLU AYDINLATMALARI\r\n\r\nBLACK PAKET-SİYAH DETAYLAR ÖN LİP VS.\r\n\r\nRECARO SPORTİF KOLTUKLAR\r\n\r\nÇİFT HAFIZALI SÜRÜCÜ KOLTUĞU\r\n\r\nELEKTRİKLİ YOLCU KOLTUĞU\r\n\r\nFULL ELEKTRİKLİ ÖN İKİ KOLTUK\r\n\r\nGERİ GÖRÜŞ KAMERASI\r\n\r\nKATLANIR AYNALAR\r\n\r\nKABLOSUJ ŞARJ\r\n\r\nNAVIGASYON\r\n\r\nAPPLE CAR PLAY\r\n\r\nÖN İKİ KOLTUK ISITMA\r\n\r\nBMW DAYLİGHTS LED FAR LED SİS\r\n\r\nBLUETOOTH\r\n\r\nHIZ LİMİTLEME\r\n\r\nKEYLESS GO ANAHTARSIZ ÇALIŞTIRMA\r\n\r\n4 FARKLI SÜRÜŞ MODU\r\n\r\nECO-COMFORT-SPORT-SPORT PLUS\r\n\r\nÇİFT YÖNLÜ DİJİTAL KLİMA\r\n\r\nÖN ARKA PARK SENSÖRÜ\r\n\r\nYOKUŞ KALKIŞ\r\n\r\nEKSTRA ÖNLERDE COİL VARDIR\r\n\r\nKOBRA VİTES \r\n\r\nVS...\r\n\r\nEKSPERTİZ \r\n\r\nHATASIZ BOYASIZ TRAMERSİZ   ', 1960000.00, 'bmw', '3 serisi', '320i ED 40th Year Edition', 2016, NULL, 'altındağ', NULL, 115000, 'Benzin', NULL, 'Otomatik', NULL, '170', '', '', 'beyaz', 'ankara', NULL, NULL, 'onaylandi', '2025-12-24 22:54:21'),
(29, 10, 'ÖMER OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ ESTORİL BLUE DÜŞÜK KM M PLUS 320İ ED M PLUS', 'ÖMER OTOMOTİV DEN EXPERTİZ BİLGİSİ\r\nBOYA YOK DEĞİŞEN YOK HASAR KAYDI YOK\r\nMUAYENE 2 SENE\r\n2016 ÇIKIŞLI\r\nBMW 320 İED M PLUS\r\n170 HP\r\nMOTOR ,MEKANİK BÜTÜN BAKIMLARI BMV BAYİSİ TARAFINDAN ZAMANINDA EKSİKSİZ YAPILMIŞTIR\r\nBORUSAN SERVİS BAKIMLI, ORİJİNAL SIFIR AYARINDADIR NOT BİRTANE YAĞ KAÇA BİRTANE TERLEME YAĞ YAKMA DUMAN ATMA ÇIKARSA EKSPERTİZDE HEDİYE EDERİM ARACIMI EMSALSİZ TEMİZLİKTE\r\nARACIMIZIN DETAYLI TEMİZLİK VE PASTA CİLA \r\nSERAMİK UYGULAMASI TARAFIMIZCA YAPILMIŞTIR \r\nARAÇ DONANIM &ÖZELLİKLERİ\r\nSUNROOF\r\nDİKİŞLİ NUBUK RECARO KOLTUKLAR\r\nM DERİ DİREKSİYON NBT BÜYÜK EKRAN YENİ NESİL\r\nF1 VİTES\r\nHIZ LİMİTLEYİCİ\r\nHIZ SABİTLEME\r\nSÜRÜŞ ASİSTANI\r\nYAYA KORUMA UYARISI\r\nYOKUŞ KALKIŞ ASİSTANI CAR PLAY\r\n(DSC) DİNAMİK DENGE KONTROLÜ\r\n(EDL)ELEKTİRONİK DİFRANSYEL KONTROLÜ\r\nLCİ SİS \r\n18 İNÇ JANT M SPORT\r\nBLUETOOTH USB AUX\r\nRADYO PROFESYONEL \r\nBAĞLANTI\r\nANAHTARSIZ ÇALIŞTIRMA\r\nGERİ GÖRÜŞ KAMERASI\r\nSÜRÜŞ MODLARI (COMFORT-SPORT-ECO)\r\nÖN ARKA PARK SENSÖRÜ\r\nSTART STOP\r\nDİJİTAL KLİMA\r\nCRUISE CONTROL\r\nISOFIX\r\nABS  HİFİ SES SİSTEMİ\r\nISITMALI KATLANIR YAN AYNALAR\r\nSOS (GÜVENLİK SİSTEMİ)\r\nYAĞMUR VE FAR SENSÖRÜ \r\nFAR YIKAMA\r\nACİL FREN SİNYALİ(ESS)\r\nYOL BİLGİSAYARI \r\nFONKSİYONEL DİREKSİYON', 1820000.00, 'bmw', '3 serisi', '320i ED M PLUS', 2016, NULL, 'altındağ', NULL, 138000, 'Benzin', NULL, 'Otomatik', NULL, '170', '', '', 'mavi', 'ankara', NULL, NULL, 'onaylandi', '2025-12-24 22:58:44'),
(30, 10, 'ÖMER OTOMOTİVDEN HATASIZ BOYASIZ TRAMERSİZ 2016 TOUCH CLİO', '2016 MODEL RENAULT CLİO 1.5 dCİ TOUCH  \r\n\r\nARAÇ İLK SAHİBİNDEN ALINMİŞTİR\r\n\r\nİCİNDE SİGARA İÇİLMEMİŞ İLK SAHİBİ TARAFINDAN ÖZENLE KULLANILMIŞTIR\r\n\r\nHERHANGİBİR DEFARMASYON YOKTUR İLK GÜNKÜ GİBİ TERTEMİZ SIFIR KOKUSU ÜZERİNDE  \r\n\r\n STEPNESİ SIFIR HİÇ KULLANILMADI \r\n\r\n FATURASI KİTAPCIKLARI YEDEK ANAHTARI MEVCUTTUR \r\n\r\n   TÜM KIREDİ KARTLARINA TAKSİT YAPILIR       \r\nFİRMAMIZ SİGORTA KASKO YAPILMAKTADIR\r\n   BU FİYATA BU KM DE BAŞKA YOK KAÇIRMAYIN\r\n\r\nTAKAS FİYATIMIZ FARKLIDIR\r\n\r\n\r\n           ÖZELLİKLER           \r\n\r\n\r\nYOL BİLGİSAYARI\r\n\r\nABS+ESP+VSA+BAS\r\n\r\nKLİMA\r\n\r\nHIZ SABİTLEYİCİ + HIZ SINIRLAYICI\r\n\r\nELEKTRİKLİ + ISITMALI AYNA\r\n\r\nARKA PARK SENSÖRÜ\r\n\r\nLASTİK ARIZA GÖSTERGESİ\r\n\r\nSÜRÜCÜ + YOLCU﻿  HAVA YASTIĞI\r\n\r\nELEKTRİKLİ CAMLAR\r\n\r\nHİDROLİK DİREKSİYON + İSOFİX\r\n\r\nMUTLİMEDİA EKRAN\r\n\r\nÇELİK JANT \r\n\r\nSTAR STOP\r\n\r\nRADYO + USB + CD + AUX + TELEFON / BLUETOOTH\r\n\r\nDAHA SAYAMADIĞIMIZ BİRÇOK ÖZELLİĞİ MEVCUTTUR\r\n\r\n\r\n\r\n             EKSPERTİZ           \r\n\r\n\r\nARACIMIZ  HATASIZ TRAMERSİZ BOYASIZ \r\n\r\n\r\n\r\n( Tamponlar, plastik kaporta parçaları ve marşpiyeller expertiz kapsamı dışındadır.)\r\n\r\n\r\n\r\nTÜM ARAÇLARIMIZ KENDİ BÜNYEMİZDE EKSPERTİZ VE TÜM SORGULAMALARI YAPILARAK DOĞRU BİLGİYİ SİZ MÜŞTERİLERİMİZE SUNMAKTAYIZ.\r\n\r\n\r\nARAÇLARIMIZ EKSPERTİZ VE KM GARANTİLİDİR.      \r\n\r\n\r\nÖMER OTOMOTİV \r\n\r\n0545 356 0113 TELXFAKS        \r\n', 830000.00, 'renault', 'clio', 'touch', 2016, NULL, 'altındağ', NULL, 147000, 'Dizel', NULL, 'Manuel', NULL, '90', '', '', 'kırmızı', 'ankara', NULL, NULL, 'onaylandi', '2025-12-24 22:59:50'),
(31, 10, '123123', '757575', 42727575.00, 'bmw', '3 serisi', '320i ED', 2016, NULL, 'altındağ', NULL, 42224242, 'Benzin', NULL, 'Otomatik', NULL, '170', '', '', 'kırmızı', 'ankara', NULL, NULL, 'beklemede', '2025-12-24 23:04:03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` varchar(20) DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`, `email`, `rol`) VALUES
(2, 'ömer katırancı', '$2y$10$nq1jvOVVLO4X.qiMEvTgCOU8OAgOV6Ngpvmy/5kwdOdXij.yq.en2', 'omer.123@gmail.com', 'admin'),
(10, 'ömer otomotiv', '$2y$10$U/xqpaq9UymG1djlQu0rmeUle8FQxoWZ6BpwQvQhH95Ll39ju2iTq', 'omerotomotiv141@gmail.com', 'user'),
(11, 'mert otomotiv', '$2y$10$H6dKxSWeroUV1BMY7CpYqeyvcdUQnf60Cpuz246jC/71re2h7r.L6', 'mert_oto@gmail.com', 'user'),
(12, 'furkan', '$2y$10$7baDo1Cx80bi4lPCVTt.DeIbN0Is0rrdDadck8Az4viHZ3wg4vuvG', 'furkan123@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `resimler`
--

DROP TABLE IF EXISTS `resimler`;
CREATE TABLE IF NOT EXISTS `resimler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ilan_id` int DEFAULT NULL,
  `resim_yolu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ilan_id` (`ilan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb3;

--
-- Tablo döküm verisi `resimler`
--

INSERT INTO `resimler` (`id`, `ilan_id`, `resim_yolu`) VALUES
(49, NULL, '1766089464_WhatsApp Image 2025-11-30 at 17.14.42.jpeg'),
(171, 25, '1766615535_WhatsApp Görsel 2025-10-23 saat 01.25.00_fd95793c.jpg'),
(172, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_1e343519.jpg'),
(173, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_3fc79f8a.jpg'),
(174, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_6bc51cf0.jpg'),
(175, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_7b9af02a.jpg'),
(176, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_26c37c6e.jpg'),
(177, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_3552f7e1.jpg'),
(178, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_6394cee4.jpg'),
(179, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_af194ab5.jpg'),
(180, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_ca62f872.jpg'),
(181, 25, '1766615535_WhatsApp Görsel 2025-11-03 saat 02.25.06_ce1ae677.jpg'),
(182, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.01_a8d7cc86.jpg'),
(183, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_3a4c2b3c.jpg'),
(184, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_6f18b479.jpg'),
(185, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_45c20517.jpg'),
(186, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_209a449a.jpg'),
(187, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_9738aac7.jpg'),
(188, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_285648ed.jpg'),
(189, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_b9e16689.jpg'),
(190, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.02_fa7b7681.jpg'),
(191, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.03_23eab9e6.jpg'),
(192, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.03_8817487b.jpg'),
(193, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.03_bb3b6ad2.jpg'),
(194, 26, '1766615992_WhatsApp Görsel 2025-11-02 saat 23.01.03_ebc2a56e.jpg'),
(195, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.42.jpeg'),
(196, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.44.jpeg'),
(197, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.47.jpeg'),
(198, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.49 (1).jpeg'),
(199, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.50.jpeg'),
(200, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.51 (1).jpeg'),
(201, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.55.jpeg'),
(202, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.14.57.jpeg'),
(203, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.15.02.jpeg'),
(204, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.15.03.jpeg'),
(205, 27, '1766616711_WhatsApp Image 2025-11-30 at 17.15.04 (1).jpeg'),
(206, 28, '1766616861_WhatsApp Görsel 2025-10-23 saat 00.54.09_5d4d1ea9.jpg'),
(207, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.52.43_a0e429e0.jpg'),
(208, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.36_7a2590a7.jpg'),
(209, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.36_9461cd8d.jpg'),
(210, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.37_8269cc3b.jpg'),
(211, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.38_5d6a4cfa.jpg'),
(212, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.40_65dd7dd9.jpg'),
(213, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.40_93b514fa.jpg'),
(214, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.41_389ba908.jpg'),
(215, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.42_3ddfa286.jpg'),
(216, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.43_51110edf.jpg'),
(217, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.44_78b1cb25.jpg'),
(218, 28, '1766616861_WhatsApp Görsel 2025-11-02 saat 22.55.46_5109e2a3.jpg'),
(219, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.04.43 (1).jpeg'),
(220, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.04.44.jpeg'),
(221, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.23 (1).jpeg'),
(222, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.27 (3).jpeg'),
(223, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.27.jpeg'),
(224, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.28 (2).jpeg'),
(225, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.28 (3).jpeg'),
(226, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.32.jpeg'),
(227, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.33 (2).jpeg'),
(228, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.34 (2).jpeg'),
(229, 29, '1766617124_WhatsApp Image 2025-12-24 at 23.05.34 (3).jpeg'),
(230, 30, '1766617190_IMG-20251023-WA0002.jpg'),
(231, 30, '1766617190_IMG-20251023-WA0003.jpg'),
(232, 30, '1766617190_IMG-20251023-WA0004.jpg'),
(233, 30, '1766617190_IMG-20251023-WA0005.jpg'),
(234, 30, '1766617190_IMG-20251023-WA0006.jpg'),
(235, 30, '1766617190_IMG-20251023-WA0007.jpg'),
(236, 30, '1766617190_IMG-20251023-WA0008.jpg'),
(237, 30, '1766617190_IMG-20251023-WA0009.jpg'),
(238, 31, '1766617443_IMG-20251023-WA0007.jpg');

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `ilanlar`
--
ALTER TABLE `ilanlar`
  ADD CONSTRAINT `ilanlar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `resimler`
--
ALTER TABLE `resimler`
  ADD CONSTRAINT `resimler_ibfk_1` FOREIGN KEY (`ilan_id`) REFERENCES `ilanlar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
