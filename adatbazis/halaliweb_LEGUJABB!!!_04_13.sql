-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Ápr 13. 20:37
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `halaliweb`
--

DELIMITER $$
--
-- Függvények
--
CREATE DEFINER=`root`@`localhost` FUNCTION `remove_accents` (`input_text` TEXT) RETURNS TEXT CHARSET utf8 COLLATE utf8_hungarian_ci DETERMINISTIC BEGIN
    DECLARE result TEXT;
    
    SET result = input_text;
    -- Kisbetűsítés és ékezetek eltávolítása
    SET result = LOWER(result);
    SET result = REPLACE(result, 'á', 'a');
    SET result = REPLACE(result, 'é', 'e');
    SET result = REPLACE(result, 'í', 'i');
    SET result = REPLACE(result, 'ó', 'o');
    SET result = REPLACE(result, 'ö', 'o');
    SET result = REPLACE(result, 'ő', 'o');
    SET result = REPLACE(result, 'ú', 'u');
    SET result = REPLACE(result, 'ü', 'u');
    SET result = REPLACE(result, 'ű', 'u');
    
    SET result = REPLACE(result, 'Á', 'a');
    SET result = REPLACE(result, 'É', 'e');
    SET result = REPLACE(result, 'Í', 'i');
    SET result = REPLACE(result, 'Ó', 'o');
    SET result = REPLACE(result, 'Ö', 'o');
    SET result = REPLACE(result, 'Ő', 'o');
    SET result = REPLACE(result, 'Ú', 'u');
    SET result = REPLACE(result, 'Ü', 'u');
    SET result = REPLACE(result, 'Ű', 'u');
	SET result = REPLACE(result, '/', '-');
	SET result = REPLACE(result, '"', '');

    RETURN result;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `fh_nev` varchar(25) NOT NULL,
  `jelszo` varchar(10000) NOT NULL,
  `vezeteknev` text NOT NULL,
  `keresztnev` text NOT NULL,
  `szamlazasi_iranyitoszam` int(4) NOT NULL,
  `szamlazasi_telepules` text NOT NULL,
  `szamlazasi_utca` varchar(50) NOT NULL,
  `szamlazasi_hazszam` varchar(20) NOT NULL,
  `szamlazasi_cegnev` varchar(50) NOT NULL,
  `szamlazasi_adoszam` int(11) NOT NULL,
  `kezbesitesi_iranyitoszam` int(4) NOT NULL,
  `kezbesitesi_telepules` text NOT NULL,
  `kezbesitesi_utca` varchar(50) NOT NULL,
  `kezbesitesi_hazszam` varchar(20) NOT NULL,
  `telefonszam` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jogosultsag` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`fh_nev`, `jelszo`, `vezeteknev`, `keresztnev`, `szamlazasi_iranyitoszam`, `szamlazasi_telepules`, `szamlazasi_utca`, `szamlazasi_hazszam`, `szamlazasi_cegnev`, `szamlazasi_adoszam`, `kezbesitesi_iranyitoszam`, `kezbesitesi_telepules`, `kezbesitesi_utca`, `kezbesitesi_hazszam`, `telefonszam`, `email`, `jogosultsag`) VALUES
('admin', '$2y$10$ZV5/kz0Yn1IB687p5eqfAuMCureJAlRueIJwPNtionjFT/mh8lUGK', 'a', 'a', 8181, 'Berhida', 'Fő', '99', 'asd', 2147483647, 8181, 'Berhida', 'Fő', '99', '+36 36 242 3423', 'a@gmail.com', 'admin'),
('b', '$2y$10$/jo.zuoSmbDGDUS6O.4QBuGIcEg5q5uuV/ZrbauzPM18rZvnIube2', 'b', 'b', 0, '', '', '', '', 0, 0, '', '', '', '0', 'b@gmailcom', 'user');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(3) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `leiras` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `kategoria`
--

INSERT INTO `kategoria` (`id`, `nev`, `leiras`) VALUES
(4, 'Feliratozás és matricázás', 'Feliratozás és matricázás'),
(5, 'Erősáramú vezetékek és kábelek', 'Erősáramú vezetékek és kábelek'),
(6, 'Gyengeáramú vezetékek és kábelek', 'Gyengeáramú vezetékek és kábelek'),
(7, 'Kislakáselosztók', 'Kislakáselosztók, moduláris elosztó szekrények, üres műanyag és fém szekrények, kiegészítők'),
(8, 'Áramvédő kapcsolók', 'Fi relék - Áramvédő kapcsolók'),
(9, 'Kismegszakítók', 'Kismegszakítók'),
(10, 'Villanyóra szekrények', 'Villanyóra szekrények, villanyóra dobozok és tartozékaik'),
(11, 'Egyéb szerelvények', 'Fésűs-villás sínek, Csapos sínek és tartozékaik\r\nRézsínek, gyűjtősínek, földelő sínek és tartozékaik - potenciál kiegyenlítők, kalapsínek\r\nSzerelvénydobozok és kötődobozok\r\nMűanyag védőcsövek és tartozékai\r\nSorkapcsok, Fővezetékkapcsok, Vezeték összekötők, Szigetelőszalagok\r\nRögzítéstechnika: csavarok, tiplik, ragasztástechnika, kötéstechnika, kötegelők, bilincsek, konzolok\r\n'),
(12, 'Falon kívüli szerelvények és tartozékaik', 'Falon kívüli szerelvények és tartozékaik / konnektorok, dugaljak'),
(13, 'Süllyesztett szerelvények és tartozékaik', 'Süllyesztett szerelvények és tartozékaik'),
(14, 'Világítástechnika', 'Világítástechnika'),
(15, 'Szerszámok és tartozékaik', 'Szerszámok és tartozékaik'),
(16, 'Ipari kapcsolók és tartozékaik', 'Ipari kapcsolók és tartozékaik'),
(17, 'Olvadóbiztosító aljzatok és biztosító betétek', 'Olvadóbiztosító aljzatok és biztosító betétek'),
(18, 'Vezérléstechnika', 'Vezérléstechnika: relék, impulzusrelék, időzítők, kapcsolóórák, alkonykapcsolók'),
(19, 'Villanyszerelési mérőműszerek', 'Villanyszerelési mérőműszerek, fogyasztásmérők és tartozékaik');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `megrendeles`
--

CREATE TABLE `megrendeles` (
  `id` int(10) NOT NULL,
  `fh_nev` varchar(25) NOT NULL,
  `szallitasi_mod` text NOT NULL,
  `fizetesi_mod` text NOT NULL,
  `osszeg` int(100) NOT NULL,
  `szallitas` text NOT NULL,
  `vegosszeg` int(100) NOT NULL,
  `leadas_datum` date NOT NULL,
  `statusz` text NOT NULL DEFAULT 'feldolgozás alatt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `megrendeles`
--

INSERT INTO `megrendeles` (`id`, `fh_nev`, `szallitasi_mod`, `fizetesi_mod`, `osszeg`, `szallitas`, `vegosszeg`, `leadas_datum`, `statusz`) VALUES
(33, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-09', 'kész'),
(34, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-18', 'csomagolva'),
(35, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-18', 'feldolgozás alatt'),
(36, 'admin', 'standard', 'kartya', 502210, '0', 502210, '2025-02-18', 'feldolgozás alatt'),
(37, 'admin', 'standard', 'kartya', 73990, '0', 73990, '2025-02-18', 'kész'),
(39, 'admin', 'standard', 'kartya', 210520, '0', 210520, '2025-02-18', 'feldolgozás alatt'),
(40, 'admin', 'standard', 'kartya', 787239, '0', 787239, '2025-02-18', 'csomagolva'),
(42, 'admin', 'standard', 'utanvet', 1506730, '0', 1506730, '2025-02-25', 'feldolgozás alatt'),
(43, 'admin', 'standard', 'utanvet', 419, '1690', 2109, '2025-02-28', 'feldolgozás alatt'),
(44, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-03-02', 'feldolgozás alatt'),
(45, 'admin', 'standard', 'kartya', 73990, '0', 73990, '2025-03-02', 'feldolgozás alatt'),
(46, 'admin', '', '', 0, '', 0, '2025-03-02', 'feldolgozás alatt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `termek` (
  `id` int(10) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `egysegar` int(8) NOT NULL,
  `leiras` mediumtext NOT NULL,
  `gyarto` varchar(100) NOT NULL,
  `tipus` varchar(100) NOT NULL,
  `kategoria_id` int(3) NOT NULL,
  `elerheto_darab` int(5) NOT NULL,
  `kep` text NOT NULL,
  `akcios_ar` int(11) DEFAULT NULL,
  `akcio_kezdete` datetime DEFAULT NULL,
  `akcio_vege` datetime DEFAULT NULL,
  `urlnev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `termek`
--

INSERT INTO `termek` (`id`, `nev`, `egysegar`, `leiras`, `gyarto`, `tipus`, `kategoria_id`, `elerheto_darab`, `kep`, `akcios_ar`, `akcio_kezdete`, `akcio_vege`, `urlnev`) VALUES
(9, 'Figyelmeztető Matrica 400V \"160x100MM\"', 100, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"Vigyázz! 400V\" 160x100mm</p>\r\n\r\n  <p>1 db, 160x100mm méretű matrica \"Vigyázz! 400V!\" felirattal!</p>\r\n\r\n  <p>A feltüntetett ár 1 db matricát tartalmaz.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'Öntapadós', 4, 104, 'képek/400voltvigyazzmatrica.webp', 50, '2025-04-13 20:30:00', '2025-06-21 20:30:00', 'figyelmezteto-matrica-400v-160x100mm'),
(10, 'MCU 0,75 fekete vezeték', 55, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték fekete (200m)</p>\r\n\r\n  <p>MCu 0,75 mm<sup>2</sup> vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték. A villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 0,75 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> fekete</p>\r\n  <p><strong>Szigetelés:</strong> 500V</p>\r\n  <p><strong>Kiszerelés:</strong> 200m/tekercs</p>\r\n  <p><strong>Külső átmérő:</strong> ~ 2,1mm</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n  <h3>Milyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)</h3>\r\n  <p>A lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás, ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.</p>\r\n\r\n  <h3>MCU 0,75 \"elektromos kábel\" jellemzői:</h3>\r\n  <p>Az MCU 1x 0,75mm<sup>2</sup> vezeték egy olyan típusú vezeték, amelynek 0,75mm<sup>2</sup> keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz. Ez a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.</p>\r\n\r\n  <h3>Keresztmetszet és terhelhetőség:</h3>\r\n  <p>Az MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.</p>\r\n\r\n  <p>Ezek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 233, 'képek/0,75tomor_fekete_rezvezetek.webp', NULL, NULL, NULL, 'mcu-0,75-fekete-vezetek'),
(11, 'Tűzálló kábel', 240, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Tűzálló kábel 1x2x0,8 JB-H(St)H E90 (JE-H(St)H BD E90) árnyékolt tömör réz vezeték.</strong></p>\r\n\r\n  <p>A tűzálló kábel halogénmentes, csillámszalag érszigetelésű, halogénmentes műanyag fólia szigeteléssel, műanyag kasírozású fémfólia árnyékolás, halogénmentes tűzálló köpenyű, 2 egymástól külön elszigetelt tömör rézeret tartalmazó kábel. Igény esetén egyedi méretre vágjuk vásárláskor.</p>\r\n\r\n  <h3>Alkalmazása:</h3>\r\n  <p>Alkalmazása belső terekben tűzjelző készülékek számára rögzített elhelyezéssel, ahol előírás a 180 perces szigetelőképesség és a 90 perces funkciómegtartás a tűzterhelés kezdetétől.</p>\r\n\r\n  <h3>Termék jellemzők:</h3>\r\n  <p><strong>Keresztmetszet:</strong> 1x2x0,8 mm<sup>2</sup></p>\r\n  <p><strong>Külső átmérő:</strong> ~7 mm</p>\r\n  <p><strong>Szín:</strong> vörös</p>\r\n  <p><strong>Névleges feszültség:</strong> 225V</p>\r\n  <p><strong>Kiszerelés:</strong> 500m/dob</p>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'tömör ', 6, 509, 'képek/tuzallo_kabel_0,8.webp', NULL, NULL, NULL, 'tuzallo-kabel'),
(14, 'Villanyóra szekrény', 48990, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Csatári Plast PVT 3075 Fm-SZ 1/3 fázisú villanyóra szekrény 80A szabadvezetékes</strong></p>\r\n\r\n  <p>Szabadvezetékes csatlakozás, illetve társasházakban egyedülálló mérés (nem csoportos mérőhely) esetén alkalmazandó, 1/3 fázisú mindennapszaki vagy H tarifa mérésre 80A-ig.</p>\r\n\r\n  <h3>Felhasználási helyek száma:</h3>\r\n  <p>1</p>\r\n\r\n  <h3>Beszerelhető mérőórák:</h3>\r\n  <ul>\r\n    <li><strong>Árszabás 1</strong> és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)</li>\r\n    <li><strong>Árszabás 3</strong> és max. áramerőssége (H vagy GEO tarifa): H63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)</li>\r\n    <li><strong>Árszabás 5</strong> és max. áramerőssége (Inverter): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)</li>\r\n  </ul>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Beltéri és kültéri használatra</strong> is alkalmas (IP65 védelem)</li>\r\n    <li><strong>Ütésállóság:</strong> IK08</li>\r\n    <li><strong>Csatlakozás módja:</strong> szabadvezetékes - légvezetékes</li>\r\n    <li><strong>Kivitel:</strong> felületre szerelhető</li>\r\n    <li><strong>Fogadott méretlen vezeték keresztmetszete:</strong> 35 mm<sup>2</sup></li>\r\n    <li><strong>Elmenő mért vezeték keresztmetszete:</strong> 25 mm<sup>2</sup></li>\r\n  </ul>\r\n\r\n  <h3>Méretek:</h3>\r\n  <p><strong>Magasság:</strong> 750 mm</p>\r\n  <p><strong>Szélesség:</strong> 300 mm</p>\r\n  <p><strong>Mélység:</strong> 203 mm</p>\r\n\r\n  <h3>Névleges feszültség:</h3>\r\n  <p>3 x 230 V / 400 V</p>\r\n\r\n</section>\r\n', 'Csatári Plast Kft.', 'falon kívűli', 10, 2, 'képek/villanyoraszekreny.webp', NULL, NULL, NULL, 'villanyora-szekreny'),
(17, 'Figyelmeztető Matrica 230V \"20X10MM\"', 419, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"230V\" 20x10mm (30 db/ív)</p>\r\n\r\n  <p>A bliszter tartalma: 30 db, egyenként 20x10mm méretű matrica \"230V\" felirattal!</p>\r\n\r\n  <p>A feltüntetett ár 1 db blisztert tartalmaz.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'Matrica', 4, 54, 'képek/230matricakicsi.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-230v-20x10mm'),
(18, 'Figyelmeztető Matrica 230V \"100X60MM\"', 100, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"Vigyázz! 230V!\" 100x60mm (4 db/ív)</p>\r\n\r\n  <p>A bliszter tartalma: 4 db, egyenként 100x60mm méretű matrica \"Vigyázz! 230V!\" felirattal!</p>\r\n\r\n  <p>A feltüntetett ár 1 db blisztert tartalmaz, melyen 4 db matrica található.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'Matrica', 4, 91, 'képek/figymatrica2304db.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-230v-100x60mm'),
(19, 'Figyelmeztető Matrica Földelés \"20X20MM\"', 419, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós Földjel 20x20mm (20 db/ív)</p>\r\n\r\n  <p>A bliszter tartalma: 20 db, egyenként 20x20mm méretű matrica földjellel!</p>\r\n\r\n  <p>A feltüntetett ár 1 db blisztert tartalmaz, melyen 20 db matrica található.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'Matrica', 4, 45, 'képek/foldmatrica.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-foldeles-20x20mm'),
(20, 'Figyelmeztető Matrica Idegen Feszültség ', 100, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"Vigyázz! Idegen feszültség!\" (100x60mm)</p>\r\n\r\n  <p>A feltüntetett ár 1 db matricát tartalmaz.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>', 'HaLáli Kft.', 'Matrica', 4, 23, 'képek/25892-e5c4f-figyelmezteto-matrica-ontapados-vigyazz-idegen-feszultseg-100x60mm_w480.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-idegen-feszultseg-'),
(21, 'Figyelmeztető Matrica Tűzeseti főkapcsoló', 100, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"Tűzeseti Főkapcsoló\" 160x100mm</p>\r\n\r\n  <p>1 db, 160x100mm méretű matrica \"Tűzeseti Főkapcsoló\" felirattal!</p>\r\n\r\n  <p>A feltüntetett ár 1 db matricát tartalmaz.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>\r\n', 'HaLáli Kft.', 'Matrica', 4, 67, 'képek/25664-dfae0-figyelmezteto-matrica-ontapados-tuzeseti-fokapcsolo-160x100mm_w480.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-tuzeseti-fokapcsolo'),
(23, 'Figyelmeztető Matrica Világítási Főkapcsoló', 110, '<section class=\"termek-leiras\">\r\n\r\n  <p>Figyelmeztető Matrica Öntapadós – \"Világítási főkapcsoló\" (100x60mm)</p>\r\n\r\n  <p>1 db, 100x60mm méretű matrica \"Világítási főkapcsoló\" felirattal!</p>\r\n\r\n  <p>A feltüntetett ár 1 db matricát tartalmaz.</p>\r\n\r\n  <p>Az öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:</p>\r\n\r\n  <ol>\r\n    <li>\r\n      <p><strong>Válassza ki a megfelelő matricát:</strong> Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Alapos tisztítás:</strong> A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.</p>\r\n    </li>\r\n    <li>\r\n      <p><strong>Pontos helymeghatározás:</strong> Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.</p>\r\n    </li>\r\n  </ol>\r\n\r\n</section>', 'HaLáli Kft.', 'Matrica', 4, 14, 'képek/25670-4bd2a-figyelmezteto-matrica-ontapados-vilagitasi-fokapcsolo-100x60mm_w480.webp', NULL, NULL, NULL, 'figyelmezteto-matrica-vilagitasi-fokapcsolo'),
(24, 'MCU 0,75 kék vezeték', 57, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték kék (200m).</p>\r\n\r\n  <p>MCu 0,75 mm<sup>2</sup> vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték. A villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 0,75 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> kék</p>\r\n  <p><strong>Szigetelés:</strong> 500V</p>\r\n  <p><strong>Kiszerelés:</strong> 200m/tekercs</p>\r\n  <p><strong>Külső átmérő:</strong> ~ 2,1mm</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 1000, 'képek/0,75tomor_kek_rezvezetek.webp', NULL, NULL, NULL, 'mcu-0,75-kek-vezetek'),
(25, 'MCU 0,75 zöld/sárga vezeték', 57, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték zöld/sárga (200m).</p>\r\n\r\n  <p>MCu 0,75 mm<sup>2</sup> vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték. A villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 0,75 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> zöld/sárga</p>\r\n  <p><strong>Szigetelés:</strong> 500V</p>\r\n  <p><strong>Kiszerelés:</strong> 200m/tekercs</p>\r\n  <p><strong>Külső átmérő:</strong> ~ 2,1mm</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 1051, 'képek/0,75tomor_zoldsarga_rezvezetek.webp', NULL, NULL, NULL, 'mcu-0,75-zold-sarga-vezetek'),
(26, 'MCU 1,5 fekete vezeték', 82, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCu 1,5 mm<sup>2</sup> réz vezeték egyerű műanyag érszigetelésű köpeny nélküli tömör elektromos kábel.</p>\r\n\r\n  <p>Az MCU 1,5 vezeték (H07V-U) a kiváló minőségű elektromos villanyvezeték, mely 1,5 mm² keresztmetszetével ideális az áramátvitelhez. A fekete színű, egyerű műanyag érszigetelésű, tömör réz kábel rendkívül megbízható és biztonságos. Az MCU vezeték ára versenyképes, és kiváló választás lehet a költségtudatos vásárlók számára, miközben megfelel a magas minőségi elvárásoknak. A 1,5mm réz vezeték alkalmas védőcsőbe vezetve, így ideális választás vakolat alatt vagy falon való szereléshez. A kábel egyszerűsége és tartóssága révén optimális megoldást kínál egyszerű és hatékony elektromos bekötésekhez.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 1,5 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> fekete</p>\r\n  <p><strong>Szigetelés:</strong> 700V</p>\r\n  <p><strong>Kiszerelés:</strong> 100m/tekercs</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n  <h3>Milyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)</h3>\r\n  <p>A lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás, ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.</p>\r\n\r\n  <h3>MCU 1,5 \"elektromos kábel\" jellemzői:</h3>\r\n  <p>Az MCU 1x 1,5mm<sup>2</sup> vezeték egy olyan típusú vezeték, amelynek 1,5mm<sup>2</sup> keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz. Ez a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.</p>\r\n\r\n  <h3>Keresztmetszet és terhelhetőség:</h3>\r\n  <p>Az MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.</p>\r\n\r\n  <p>Ezek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 987, 'képek/1,5tomor_fekete_rezvezetek.webp', NULL, NULL, NULL, 'mcu-1,5-fekete-vezetek'),
(27, 'MCU 1,5 kék vezeték', 82, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCu 1,5 mm<sup>2</sup> vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték. A villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 1,5 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> kék</p>\r\n  <p><strong>Szigetelés:</strong> 700V</p>\r\n  <p><strong>Kiszerelés:</strong> 100m/tekercs</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n  <h3>Milyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)</h3>\r\n  <p>A lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás, ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.</p>\r\n\r\n  <h3>MCU 1,5 \"elektromos kábel\" jellemzői:</h3>\r\n  <p>Az MCU 1x 1,5mm<sup>2</sup> vezeték egy olyan típusú vezeték, amelynek 1,5mm<sup>2</sup> keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz. Ez a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.</p>\r\n\r\n  <h3>Keresztmetszet és terhelhetőség:</h3>\r\n  <p>Az MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.</p>\r\n\r\n  <p>Ezek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 872, 'képek/1,5tomor_kek_rezvezetek.webp', NULL, NULL, NULL, 'mcu-1,5-kek-vezetek'),
(28, 'MCU 1,5 zöld/sárga vezeték', 82, '<section class=\"termek-leiras\">\r\n\r\n  <p>MCu 1,5 mm<sup>2</sup> vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték. A villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.</p>\r\n\r\n  <p><strong>Vezeték keresztmetszet:</strong> 1,5 mm<sup>2</sup></p>\r\n  <p><strong>Szín:</strong> zöld/sárga</p>\r\n  <p><strong>Szigetelés:</strong> 700V</p>\r\n  <p><strong>Kiszerelés:</strong> 100m/tekercs</p>\r\n\r\n  <p>Az MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.</p>\r\n\r\n  <h3>Mire jó az MCU vezeték?</h3>\r\n  <p>Az MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.</p>\r\n\r\n  <h3>Milyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)</h3>\r\n  <p>A lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás, ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.</p>\r\n\r\n  <h3>MCU 1,5 \"elektromos kábel\" jellemzői:</h3>\r\n  <p>Az MCU 1x 1,5mm<sup>2</sup> vezeték egy olyan típusú vezeték, amelynek 1,5mm<sup>2</sup> keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz. Ez a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.</p>\r\n\r\n  <h3>Keresztmetszet és terhelhetőség:</h3>\r\n  <p>Az MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.</p>\r\n\r\n  <p>Ezek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.</p>\r\n\r\n</section>\r\n', 'Prysmian Kft.', 'tömör ', 5, 560, 'képek/1,5tomor_zoldsarga_rezvezetek.webp', NULL, NULL, NULL, 'mcu-1,5-zold-sarga-vezetek'),
(29, '3 Fázisú Villanyóra Szekrény', 73990, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Csatári Plast PVT 3075 Fm-SZ ÁK 12 1/3 fázisú villanyóra szekrény felső 12 mod elmenővel szabadvezetékes</strong></p>\r\n\r\n  <p>Csatári Plast PVT villanyóra szekrény 80A-ig, nappali óra fogadására felső elhelyezésű mért elosztóval. 1db 12 modulos, csapófedeles ablakkal, max. 12db kismegszakító elhelyezéséhez. Tartalmaz magasított kalapsínt, PE és N sorkapcsot.</p>\r\n\r\n  <h3>Felhasználási helyek száma:</h3>\r\n  <p>1</p>\r\n\r\n  <h3>Beszerelhető mérőórák:</h3>\r\n  <ul>\r\n    <li><strong>Árszabás 1</strong> és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)</li>\r\n    <li><strong>Árszabás 3</strong> és max. áramerőssége (H vagy GEO tarifa): H63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)</li>\r\n    <li><strong>Árszabás 5</strong> és max. áramerőssége (Inverter): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)</li>\r\n  </ul>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Beltéri és kültéri használatra</strong> is alkalmas (IP65 védelem)</li>\r\n    <li><strong>Ütésállóság:</strong> IK08</li>\r\n    <li><strong>Csatlakozás módja:</strong> szabadvezetékes - légvezetékes</li>\r\n    <li><strong>Kivitel:</strong> felületre szerelhető</li>\r\n    <li><strong>Fogadott méretlen vezeték keresztmetszete:</strong> 35 mm<sup>2</sup></li>\r\n    <li><strong>Elmenő mért vezeték keresztmetszete:</strong> 25 mm<sup>2</sup></li>\r\n    <li><strong>Környezeti hőmérséklet:</strong> Max. +40°C, 24 órás átlag max. +120°C / min. -40°C</li>\r\n    <li><strong>Kizárólag UV stabilizált műanyagokból készült.</li>\r\n  </ul>\r\n\r\n  <h3>Méretek:</h3>\r\n  <p><strong>Magasság:</strong> 900 mm</p>\r\n  <p><strong>Szélesség:</strong> 300 mm</p>\r\n  <p><strong>Mélység:</strong> 203 mm</p>\r\n\r\n  <h3>Névleges feszültség:</h3>\r\n  <p>3 x 230 V / 400 V</p>\r\n\r\n  <h3>Tartozék:</h3>\r\n  <p><strong>H07V-K 1x10mm<sup>2</sup> vezetékcsomag</strong> 32A-ig történő szerelésre alkalmas!</p>\r\n\r\n</section>\r\n', 'Csatári Plast Kft.', 'szerelvény', 10, 11, 'képek/17545-55d1b-csatari-plast-pvt-3075-fm-sz-ak-12-13-fazisu-villanyora-szekreny-fel_w480.webp', NULL, NULL, NULL, '3-fazisu-villanyora-szekreny'),
(31, '1/3 Fázisú Kombinált Villanyóra Szekrény', 210520, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Hensel 1/3 fázisú kombinált villanyóra szekrény (n.+é) 80A szabadvezetékes 2x12 mod kism. HB33K024-U</strong></p>\r\n\r\n  <p><strong>Készletinformáció:</strong> Kérjük, rendelés előtt vegye fel a kapcsolatot ügyfélszolgálatunkkal készletellenőrzés céljából! A \"Készleten\" jelzés ellenére előfordulhat, hogy a már megrendelt, de még fel nem dolgozott igények miatt nem tudjuk szállítani a szekrényt. Ebben az esetben visszajelzést küldünk rendelés után. Előrendelést nem veszünk fel, így a készlet erején túl érkezett rendelések törlésre kerülnek.</p>\r\n\r\n  <h3>Fogyasztói főelosztóval:</h3>\r\n  <p>2db Mi 1112-U</p>\r\n\r\n  <h3>Árszabás és áramerősségek:</h3>\r\n  <ul>\r\n    <li><strong>Árszabás 1</strong> és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki 3 x 80A-ig)</li>\r\n    <li><strong>Árszabás 2</strong> és max. áramerőssége (Vezérelt): V32A (Vezérelt 3 x 32A-ig)</li>\r\n    <li><strong>Árszabás 3</strong> és max. áramerőssége (H vagy Geo tarifa): H63A (H tarifa 3 x 63A-ig)</li>\r\n    <li><strong>Árszabás 4</strong> és max. áramerőssége (Autótöltő): M63.80A (Mindennapszaki 3 x 80A-ig)</li>\r\n    <li><strong>Árszabás 5</strong> és max. áramerőssége (Inverter): M63.80A (Mindennapszaki 3 x 80A-ig)</li>\r\n  </ul>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Beltéri vagy kültéri telepítésre</strong></li>\r\n    <li><strong>Szabadvezetékes (légkábeles) kivitel</strong></li>\r\n    <li><strong>Felületre szerelhető</strong></li>\r\n    <li><strong>Fogadott méretlen vezeték keresztmetszete:</strong> Max. 35 mm<sup>2</sup></li>\r\n    <li><strong>Elmenő mért vezeték keresztmetszete:</strong> Max. 25 mm<sup>2</sup></li>\r\n    <li><strong>Névleges feszültség:</strong> 3 x 230 V / 400 V</li>\r\n    <li><strong>UV állóság:</strong> UV-álló</li>\r\n    <li><strong>IP védettség:</strong> IP 65</li>\r\n    <li><strong>Ütésállóság:</strong> IK 08</li>\r\n  </ul>\r\n\r\n  <h3>Méretek:</h3>\r\n  <p><strong>Magasság:</strong> 900 mm</p>\r\n  <p><strong>Szélesség:</strong> 600 mm</p>\r\n  <p><strong>Mélység:</strong> 270 mm</p>\r\n\r\n</section>\r\n', 'Hensel Kft.', 'szerelvény', 10, 1, 'képek/17546-47690-hensel-13-fazisu-kombinalt-villanyora-szekreny-ne-80a-szabadvezeteke_w480.webp', NULL, NULL, NULL, '1-3-fazisu-kombinalt-villanyora-szekreny'),
(32, '1/3 Fázisú Kombinált Villanyóra Szekrény Csatári', 502210, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Csatári Plast PVT Á-V Fm-CSF50 1/3 fázisú kombinált villanyóra szekrény 80A főelosztóval</strong></p>\r\n\r\n  <p><strong>Felhasználás:</strong> Egy felhasználási helyes M63.80A és V32A mérés, felületre szerelt kivitelben, csatlakozó főelosztóval. Földkábeles és szabadvezetékes csatlakozás is elérhető.</p>\r\n\r\n  <h3>Árszabás és áramerősségek:</h3>\r\n  <ul>\r\n    <li><strong>Árszabás 1:</strong> M63.80A (Mindennapszaki max. 3x63A és 3x80A-es kialakítás)</li>\r\n    <li><strong>Árszabás 2:</strong> V32A (Vezérelt max. 3x32A-es kialakítás)</li>\r\n    <li><strong>Árszabás 3:</strong> H63.80A (H tarifa max. 3x63A és 3x80A-es kialakítás), Hv32A (Vezérelt H tarifa max. 3x32A-es kialakítás)</li>\r\n    <li><strong>Árszabás 5:</strong> M63.80A (Inverter, Mindennapszaki max. 3x63A és 3x80A-es kialakítás)</li>\r\n  </ul>\r\n\r\n  <h3>Műszaki jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Beltéri és kültéri alkalmazásra is alkalmas</strong></li>\r\n    <li><strong>IP65 védelem</strong></li>\r\n    <li><strong>IK08 ütésállóság</strong></li>\r\n    <li><strong>Névleges feszültség:</strong> 3x230V/400V</li>\r\n    <li><strong>Névleges frekvencia:</strong> 50 Hz</li>\r\n    <li><strong>Névleges rövid idejű határáram (Icw, Ipk, Icc):</strong> 30 kA</li>\r\n    <li><strong>Lökőfeszültség állóság:</strong> 6 kV</li>\r\n    <li><strong>Környezeti hőmérséklet:</strong> Max. +40°C, 24 órás átlag max. +120°C / min. -40°C</li>\r\n    <li><strong>Fogadott méretlen vezeték keresztmetszete:</strong> 50 mm<sup>2</sup></li>\r\n    <li><strong>Elmenő mért vezeték keresztmetszete:</strong> 25 mm<sup>2</sup></li>\r\n  </ul>\r\n\r\n  <h3>Méretek:</h3>\r\n  <p><strong>Magasság:</strong> 1050 mm</p>\r\n  <p><strong>Szélesség:</strong> 750 mm</p>\r\n  <p><strong>Mélység:</strong> 203 mm</p>\r\n\r\n  <h3>Tartozékok:</h3>\r\n  <ul>\r\n    <li>Szakaszolható biztosító kapcsoló (NH00 apator)</li>\r\n    <li>HLAK 35 sorkapcsok</li>\r\n    <li>Tűzeseti kapcsoló</li>\r\n    <li>32A-ig komplett vezetékcsomag (fölötte vezetékcserét igényel)</li>\r\n  </ul>\r\n\r\n</section>\r\n', 'Csatári Plast Kft.', 'szerelvény', 10, 4, 'képek/25947-bb111-csatari-plast-pvt-a-v-fm-csf50-13-fazisu-kombinalt-villanyora-szekre_w480.webp', 450000, '2025-04-10 20:29:00', '2025-06-13 20:29:00', '1-3-fazisu-kombinalt-villanyora-szekreny-csatari'),
(33, 'Üres Villanyóra Szekrény Lábazattal', 140550, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>Csatári Plast PVT K-L 80x88/32 üres villanyóra szekrény lábazattal</strong></p>\r\n\r\n  <p><strong>Fontos információ:</strong> TÚLMÉRETES TERMÉK! CSAK RAKLAPON SZÁLLÍTHATÓ!</p>\r\n\r\n  <h3>Külső méretek:</h3>\r\n  <ul>\r\n    <li><strong>Szélesség:</strong> 800 mm</li>\r\n    <li><strong>Mélység:</strong> 320 mm</li>\r\n    <li><strong>Magasság:</strong> 1750 mm</li>\r\n  </ul>\r\n\r\n</section>\r\n', 'Csatári Plast Kft.', 'szerelvény', 10, 30, 'képek/17451-d6357-csatari-plast-pvt-k-l-80x8832-ures-villanyora-szekreny-labazattal_w480.webp', NULL, NULL, NULL, 'ures-villanyora-szekreny-labazattal'),
(34, 'Tokozott Kapcsoló 0-1', 9900, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>GANZ KKM-0-20-6002 tokozott kapcsoló 3P 20A IP65 0-1 állású BE-KI kapcsoló</strong></p>\r\n\r\n  <p>A Ganz KKM-0-20-6002 3 pólusú tokozott ipari ki-be kapcsoló, amely 0-1 állású működést kínál. A kapcsolóba összesen 4db PG16 tömszelence helyezhető el (2db a kapcsoló alján, 2 db a kapcsoló tetején) kábelbevezetés céljából.</p>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Pólusok száma:</strong> 3</li>\r\n    <li><strong>Névleges terhelhetőség:</strong> 20A</li>\r\n    <li><strong>Névleges feszültség:</strong> 400V</li>\r\n    <li><strong>Védettség:</strong> IP65</li>\r\n    <li><strong>Magasság:</strong> 88 mm (tömszelence nélkül)</li>\r\n    <li><strong>Szélesség:</strong> 88 mm</li>\r\n    <li><strong>Mélység:</strong> 100 mm (kapcsoló karral együtt)</li>\r\n  </ul>\r\n\r\n</section>\r\n', 'Ganz KK Kft.', 'Kapcsolók', 16, 25, 'képek/26553-81ae2-ganz-kkm-0-20-6002-tokozott-kapcsolo-3p-20a-ip65-0-1-allasu-be-ki-ka_w480.webp', NULL, NULL, NULL, 'tokozott-kapcsolo-0-1'),
(35, 'Tokozott Kapcsoló 1-0-2', 23788, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>GANZ KKM-1-32-6006 tokozott kapcsoló 3P 32A IP65 1-0-2 állású átkapcsoló</strong></p>\r\n\r\n  <p>A Ganz KKM-1-32-6006 egy 3 pólusú tokozott ipari átkapcsoló, amely 1-0-2 állással rendelkezik. Összesen 4 db PM21 tömszelence helyezhető el benne (2 db a kapcsoló alján, 2 db a tetején) a kábelbevezetéshez.</p>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Pólusok száma:</strong> 3</li>\r\n    <li><strong>Névleges terhelhetőség:</strong> 32A</li>\r\n    <li><strong>Névleges feszültség:</strong> 400V</li>\r\n    <li><strong>Védettség:</strong> IP65</li>\r\n    <li><strong>Magasság:</strong> 100 mm (tömszelence nélkül)</li>\r\n    <li><strong>Szélesség:</strong> 100 mm</li>\r\n    <li><strong>Mélység:</strong> 140 mm (kapcsoló karral együtt), 112 mm (kar nélkül)</li>\r\n  </ul>\r\n\r\n</section>\r\n', 'Ganz KK Kft.', 'Kapcsolók', 16, 21, 'képek/11396-9f7c6-ganz-kkm-1-32-6006-tokozott-kapcsolo-3p-32a-ip65-1-0-2-allasu-atkapc_w480.webp', NULL, NULL, NULL, 'tokozott-kapcsolo-1-0-2'),
(36, 'Tokozott Kapcsoló 0-Y-D', 29780, '<section class=\"termek-leiras\">\r\n\r\n  <p><strong>GANZ KKM-1-32-6009 tokozott kapcsoló 3P 32A IP65 csillag-delta 0-Y-D állású átkapcsoló</strong></p>\r\n\r\n  <p>A Ganz KKM-1-32-6009 egy 3 pólusú, tokozott ipari csillag-delta átkapcsoló, amely 0-Y-D állással rendelkezik. Összesen 4 db PG21 tömszelence helyezhető el benne (2 db alul, 2 db felül) a kábelek bevezetéséhez.</p>\r\n\r\n  <h3>Jellemzők:</h3>\r\n  <ul>\r\n    <li><strong>Pólusok száma:</strong> 3</li>\r\n    <li><strong>Névleges terhelhetőség:</strong> 32A</li>\r\n    <li><strong>Névleges feszültség:</strong> 400V</li>\r\n    <li><strong>Védettség:</strong> IP65</li>\r\n    <li><strong>Magasság:</strong> 100 mm (tömszelence nélkül)</li>\r\n    <li><strong>Szélesség:</strong> 100 mm</li>\r\n    <li><strong>Mélység:</strong> 140 mm (kapcsoló karral együtt)</li>\r\n  </ul>\r\n\r\n</section>\r\n', 'Ganz KK Kft.', 'Kapcsolók', 16, 14, 'képek/11400-e98f0-ganz-kkm-1-32-6009-tokozott-kapcsolo-3p-32a-ip65-csillag-delta-0-y-d_w480.webp', 25000, '2025-04-13 20:29:00', '2025-06-27 20:29:00', 'tokozott-kapcsolo-0-y-d');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tetelek`
--

CREATE TABLE `tetelek` (
  `id` int(10) NOT NULL,
  `rendeles_id` int(100) NOT NULL,
  `termek_id` int(10) NOT NULL,
  `tetelek_mennyiseg` int(5) NOT NULL,
  `fh_nev` varchar(100) NOT NULL,
  `statusz` text NOT NULL DEFAULT 'kosárban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`fh_nev`);

--
-- A tábla indexei `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `megrendeles`
--
ALTER TABLE `megrendeles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fh_nev` (`fh_nev`);

--
-- A tábla indexei `termek`
--
ALTER TABLE `termek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`,`elerheto_darab`) USING BTREE;

--
-- A tábla indexei `tetelek`
--
ALTER TABLE `tetelek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rendeles_id` (`rendeles_id`,`termek_id`),
  ADD KEY `termek_id` (`termek_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `megrendeles`
--
ALTER TABLE `megrendeles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT a táblához `tetelek`
--
ALTER TABLE `tetelek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `megrendeles`
--
ALTER TABLE `megrendeles`
  ADD CONSTRAINT `megrendeles_ibfk_1` FOREIGN KEY (`fh_nev`) REFERENCES `felhasznalo` (`fh_nev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `termek`
--
ALTER TABLE `termek`
  ADD CONSTRAINT `termek_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `tetelek`
--
ALTER TABLE `tetelek`
  ADD CONSTRAINT `tetelek_ibfk_1` FOREIGN KEY (`rendeles_id`) REFERENCES `megrendeles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tetelek_ibfk_2` FOREIGN KEY (`termek_id`) REFERENCES `termek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
