DROP DATABASE IF EXISTS `halaliweb`;
CREATE DATABASE IF NOT EXISTS `halaliweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `halaliweb`;

-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost:3306
-- Létrehozás ideje: 2025. Már 18. 09:19
-- Kiszolgáló verziója: 8.4.3
-- PHP verzió: 8.3.16

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

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `fh_nev` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `jelszo` varchar(10000) COLLATE utf8mb3_unicode_ci NOT NULL,
  `vezeteknev` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `keresztnev` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `szamlazasi_iranyitoszam` int NOT NULL,
  `szamlazasi_telepules` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `szamlazasi_utca` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `szamlazasi_hazszam` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `szamlazasi_cegnev` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `szamlazasi_adoszam` int NOT NULL,
  `kezbesitesi_iranyitoszam` int NOT NULL,
  `kezbesitesi_telepules` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `kezbesitesi_utca` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `kezbesitesi_hazszam` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefonszam` varchar(15) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `jogosultsag` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`fh_nev`, `jelszo`, `vezeteknev`, `keresztnev`, `szamlazasi_iranyitoszam`, `szamlazasi_telepules`, `szamlazasi_utca`, `szamlazasi_hazszam`, `szamlazasi_cegnev`, `szamlazasi_adoszam`, `kezbesitesi_iranyitoszam`, `kezbesitesi_telepules`, `kezbesitesi_utca`, `kezbesitesi_hazszam`, `telefonszam`, `email`, `jogosultsag`) VALUES
('admin', '$2y$10$ZV5/kz0Yn1IB687p5eqfAuMCureJAlRueIJwPNtionjFT/mh8lUGK', 'a', 'a', 8181, 'Berhida', 'Fő', '99', 'asd', 2147483647, 8181, 'Berhida', 'Fő', '99', '+36 36 242 3423', '13c-halasi@ipari.vein.hu', 'admin'),
('b', '$2y$10$/jo.zuoSmbDGDUS6O.4QBuGIcEg5q5uuV/ZrbauzPM18rZvnIube2', 'b', 'b', 0, '', '', '', '', 0, 0, '', '', '', '0', 'b@gmailcom', 'user');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int NOT NULL,
  `nev` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `leiras` varchar(1000) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `id` int NOT NULL,
  `fh_nev` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `szallitasi_mod` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'standard',
  `fizetesi_mod` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'kartya',
  `osszeg` int DEFAULT NULL,
  `szallitas` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `vegosszeg` int DEFAULT NULL,
  `leadas_datum` date NOT NULL,
  `statusz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'feldolgozás alatt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- A tábla adatainak kiíratása `megrendeles`
--

INSERT INTO `megrendeles` (`id`, `fh_nev`, `szallitasi_mod`, `fizetesi_mod`, `osszeg`, `szallitas`, `vegosszeg`, `leadas_datum`, `statusz`) VALUES
(33, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-09', 'kész'),
(34, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-18', 'feldolgozás alatt'),
(35, 'admin', 'standard', 'kartya', 100, '1690', 1790, '2025-02-18', 'feldolgozás alatt'),
(36, 'admin', 'standard', 'kartya', 502210, '0', 502210, '2025-02-18', 'feldolgozás alatt'),
(37, 'admin', 'standard', 'kartya', 73990, '0', 73990, '2025-02-18', 'feldolgozás alatt'),
(39, 'admin', 'standard', 'kartya', 210520, '0', 210520, '2025-02-18', 'feldolgozás alatt'),
(40, 'admin', 'standard', 'kartya', 787239, '0', 787239, '2025-02-18', 'feldolgozás alatt'),
(42, 'admin', 'standard', 'utanvet', 502210, '0', 502210, '2025-03-18', 'feldolgozás alatt'),
(43, 'admin', 'standard', 'utanvet', 419, '1690', 2109, '2025-03-18', 'feldolgozás alatt'),
(44, 'admin', 'standard', 'utanvet', 502210, '0', 502210, '2025-03-18', 'feldolgozás alatt'),
(45, 'admin', 'standard', 'utanvet', 502210, '0', 502210, '2025-03-18', 'feldolgozás alatt'),
(46, 'admin', 'standard', 'utanvet', 73990, '0', 73990, '2025-03-18', 'feldolgozás alatt'),
(47, 'admin', 'standard', 'utanvet', 73990, '0', 73990, '2025-03-18', 'feldolgozás alatt'),
(48, 'admin', 'standard', 'kartya', NULL, NULL, NULL, '2025-03-18', 'feldolgozás alatt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `termek` (
  `id` int NOT NULL,
  `nev` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `egysegar` int NOT NULL,
  `leiras` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `gyarto` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tipus` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `kategoria_id` int NOT NULL,
  `elerheto_darab` int NOT NULL,
  `kep` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `akcios_ar` int DEFAULT NULL,
  `akcio_kezdete` datetime DEFAULT NULL,
  `akcio_vege` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- A tábla adatainak kiíratása `termek`
--

INSERT INTO `termek` (`id`, `nev`, `egysegar`, `leiras`, `gyarto`, `tipus`, `kategoria_id`, `elerheto_darab`, `kep`, `akcios_ar`, `akcio_kezdete`, `akcio_vege`) VALUES
(9, 'Figyelmeztető Matrica 400V \"160x100MM\"', 180, 'Figyelmeztető Matrica Öntapadós \"Vigyázz! 400V\" 160x100mm.\r\n\r\n1 db, 160x100mm méretű matrica \"Vigyázz! 400V!\" felirattal!\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n\r\n', 'HaLáli Kft.', 'Öntapadós', 4, 300, 'képek/400voltvigyazzmatrica.webp', 119, '2025-03-17 10:17:00', '2025-03-21 10:17:00'),
(10, 'MCU 0,75 fekete vezeték', 55, 'MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték fekete (200m).\r\n\r\nMCu 0,75 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 0,75 mm2\r\nSzín: fekete\r\nSzigetelés: 500V\r\nKiszerelés: 200m/tekercs\r\nKülső átmérő : ~ 2,1mm\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásr', 'Prysmian Kft.', 'tömör ', 5, 233, 'képek/0,75tomor_fekete_rezvezetek.webp', NULL, NULL, NULL),
(11, 'Tűzálló kábel', 240, 'Tűzálló kábel 1x2x0,8 JB-H(St)H E90 (JE-H(St)H BD E90) árnyékolt tömör réz vezeték.\r\nA tűzálló kábel halogénmentes, csillámszalag érszigetelésű, halogénmentes műanyag fólia szigeteléssel, műanyag kasírozású fémfólia árnyékolás, halogénmentes tűzálló köpenyű, 2 egymástól külön elszigetelt tömör rézeret tartalmazó kábel. Igény esetén egyedi méretre vágjuk vásárláskor.\r\nAlkalmazása belső terekben tűzjelző készülékek számára rögzített elhelyezéssel, ahol előírás a 180 perces szigetelőképesség és a 90 perces funkciómegtartás a tűzterhelés kezdetétől.\r\n\r\nKeresztmetszet: 1x2x0,8 mm2\r\nKülső átmérő: ~7 mm\r\nSzín: vörös\r\nNévleges Feszültség: 225V\r\nKiszerelés: 500m/dob', 'HaLáli Kft.', 'tömör ', 6, 509, 'képek/tuzallo_kabel_0,8.webp', NULL, NULL, NULL),
(12, 'Lakáselosztó falon kívüli', 2950, 'Lakáselosztó falon kívüli 8 modulos elosztó szekrény Kanlux DB108S.\r\n20/Karton\r\n\r\n8 modulos, falon kívül szerelhető lakáselosztó\r\nkalapsínnel és föld, nulla (PE,N) sínekkel szerelve\r\nIp40, beltéri használatra ajánlott\r\nMéretek: 189x205x101mm (szé-ma-mé)', 'Kanlux', 'falon kívűli', 7, 18, 'képek/lakaseloszto_8modul_kanlux.webp', NULL, NULL, NULL),
(13, 'Fi relé', 5990, 'Fi relé 2P 25A 30mA 6kA (AC) áramvédő kapcsoló ÁVK ÉV relé TRACON TFV2-25030.\r\n\r\nTracon áramvédő-kapcsoló ÁVK (fi-relé). A készülék előlapján lévő teszt gomb segítségével ellenőrizhető a készülék működőképessége, amit szabvány szerint havonta egyszer ellenőrizni kell. A készülék villás vagy csapos fázissínnel sorolható, TS35-ös kalapsinre pattintható.\r\n\r\nNévleges áramerősség: 25A\r\nÉrzékenység: 30mA\r\nMegszakítóképesség: 6kA\r\nHálózati feszültség: 230V AC-váltakozó áram\r\nPólusok száma: 2\r\nBeköthető vezeték keresztmetszete: 1.5-25mm2\r\nKészülék szélessége: 2 modul\r\nKörnyezeti hőmérséklet üzem közben: - 25 - 55 °C', 'Tracon Electric', 'ÁVK', 8, 0, 'képek/fi_relé_2p_25a_30ma.webp', NULL, NULL, NULL),
(14, 'Villanyóra szekrény', 48990, 'Csatári Plast PVT 3075 Fm-SZ 1/3 fázisú villanyóra szekrény 80A szabadvezetékes.\r\n\r\nSzabadvezetékes csatlakozás, illetve társasházakban egyedülálló mérés (nem csoportos mérőhely) esetén alkalmazandó, 1/3 fázisú mindennapszaki vagy H tarifa mérésre 80A-ig.\r\nFelhasználási helyek száma: 1\r\n\r\nBeszerelhető mérőórák:\r\nÁrszabás 1 és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 3 és max. áramerőssége (H vagy GEO tarifa): H63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 5 és max. áramerőssége (Inverter): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\n\r\nBeltéri és kültéri használatra is alkalmas (IP65 védelem)\r\nÜtésállóság: IK08\r\nCsatlakozás módja: szabadvezetékes - légvezetékes\r\nKivitel: felületre szerelhető\r\nFogadott méretlen vezeték keresztmetszete: 35 mm2\r\n\r\nElmenő mért vezeték keresztmetszete: 25 mm2\r\nMéretei: Magasság 750 mm x Szélesség 300 mm x Mélység 203 mm\r\nNévleges fesz.: 3 x 230 V / 400 V\r\nKörnyezeti ', 'Csatári Plast Kft.', 'falon kívűli', 10, 2, 'képek/villanyoraszekreny.webp', NULL, NULL, NULL),
(15, 'Kalapsín', 470, 'Kalapsín (TS35 sín, C sín, Din sín) 137mm Tracon.\r\n\r\nTS35 kalapsín, 137mm-es szélességben, csavarokkal rögzíthető.', 'Tracon Electric', 'szerelvény', 11, 55, 'képek/kalapsin.webp', NULL, NULL, NULL),
(16, 'WAGO', 45, 'WAGO 2 vezetékes összekötő (tömör 0,5-2,5mm2) 24A átlátszó fehér 2273-202, 100db/doboz\r\n\r\nA Compact Wago vezetékösszekötő 2 db tömör vezeték ( 0,5 - 2,5 mm2-ig ) összekötését oldja meg. A 2273-202 sorkapocs belsejében az érintkező lemezke azonnal rögzíti a csatlakoztatott réz vezetéket és megakadályozza a visszairányú mozgást. Az átlátszó ház segítségével pontosan látható a csatlakoztatott vezeték és ellenőrizhető a megfelelő hosszúságú csupaszolt vezetékvég csatlakozása. A kisebb méret miatt könnyebb a beépítése a szerelvény dobozba.\r\nAlumínium vezeték összekötéséhez Wago Alu Pasta (249-130) ajánlott, amit kedvező áron megtalál webáruházunkban.\r\n\r\nWago terhelhetősége: 24A\r\nKiszerelés: 100db/doboz.', 'Wago ', 'szerelvény', 11, 443, 'képek/wago.webp', NULL, NULL, NULL),
(17, 'Figyelmeztető Matrica 230V \"20X10MM\"', 419, 'Figyelmeztető Matrica Öntapadós \"230V\" 20x10mm 30 db/ív.\r\n\r\nA bliszter tartalma: 30 db, egyenként 20x10mm méretű matrica \"230V\" felirattal!\r\nA feltüntetett ár 1db blisztert tartalmaz!\r\n\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n\r\n', 'HaLáli Kft.', 'Matrica', 4, 54, 'képek/230matricakicsi.webp', NULL, NULL, NULL),
(18, 'Figyelmeztető Matrica 230V \"100X60MM\"', 100, 'Figyelmeztető Matrica Öntapadós \"Vigyázz! 230V!\" 100x60mm 4db/ív\r\n\r\nA bliszter tartalma: 4 db, egyenként 100x60mm méretű matrica \"Vigyázz! 230V!\" felirattal!\r\nA feltüntetett ár 1db blisztert tartalmaz, melyen 4db matrica található!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.', 'HaLáli Kft.', 'Matrica', 4, 93, 'képek/figymatrica2304db.webp', NULL, NULL, NULL),
(19, 'Figyelmeztető Matrica Földelés \"20X20MM\"', 419, 'Figyelmeztető Matrica Öntapadós Földjel 20x20mm 20db/ív\r\nA bliszter tartalma: 20 db, egyenként 20x20mm méretű matrica földjellel!\r\nA feltüntetett ár 1db blisztert tartalmaz, melyen 20db matrica található!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n', 'HaLáli Kft.', 'Matrica', 4, 45, 'képek/foldmatrica.webp', NULL, NULL, NULL),
(20, 'Figyelmeztető Matrica Idegen Feszültség ', 100, 'Figyelmeztető Matrica Öntapadós \"Vigyázz! Idegen feszültség!\" 100x60mm\r\n\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.', 'HaLáli Kft.', 'Matrica', 4, 23, 'képek/25892-e5c4f-figyelmezteto-matrica-ontapados-vigyazz-idegen-feszultseg-100x60mm_w480.webp', NULL, NULL, NULL),
(21, 'Figyelmeztető Matrica Tűzeseti főkapcsoló', 100, 'Figyelmeztető Matrica Öntapadós \"Tűzeseti Főkapcsoló\" 160x100mm\r\n\r\n1 db, 160x100mm méretű matrica \"Tűzeseti Főkapcsoló\" felirattal!\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.', 'HaLáli Kft.', 'Matrica', 4, 67, 'képek/25664-dfae0-figyelmezteto-matrica-ontapados-tuzeseti-fokapcsolo-160x100mm_w480.webp', NULL, NULL, NULL),
(23, 'Figyelmeztető Matrica Világítási Főkapcsoló', 110, 'Figyelmeztető Matrica Öntapadós \"Világítási főkapcsoló\" 100x60mm.\r\n\r\n1 db, 100x60mm méretű matrica \"Világítási főkapcsoló\" felirattal!\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.', 'HaLáli Kft.', 'Matrica', 4, 14, 'képek/25670-4bd2a-figyelmezteto-matrica-ontapados-vilagitasi-fokapcsolo-100x60mm_w480.webp', NULL, NULL, NULL),
(24, 'MCU 0,75 kék vezeték', 57, 'MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték kék (200m).\r\n\r\nMCu 0,75 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 0,75 mm2\r\nSzín: kék\r\nSzigetelés: 500V\r\nKiszerelés: 200m/tekercs\r\nKülső átmérő : ~ 2,1mm\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.', 'Prysmian Kft.', 'tömör ', 5, 1000, 'képek/0,75tomor_kek_rezvezetek.webp', NULL, NULL, NULL),
(25, 'MCU 0,75 zöld/sárga vezeték', 57, 'MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték zöld/sárga (200m).\r\n\r\nMCu 0,75 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 0,75 mm2\r\nSzín: zöld/sárga\r\nSzigetelés: 500V\r\nKiszerelés: 200m/tekercs\r\nKülső átmérő : ~ 2,1mm\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.', 'Prysmian Kft.', 'tömör ', 5, 1051, 'képek/0,75tomor_zoldsarga_rezvezetek.webp', NULL, NULL, NULL),
(26, 'MCU 1,5 fekete vezeték', 82, 'MCu 1,5 mm2 réz vezeték egyerű műanyag érszigetelésű köpeny nélküli tömör elektromos kábel.\r\n\r\nAz MCU 1,5 vezeték (H07V-U) a kiváló minőségű elektromos villanyvezeték, mely 1,5 mm² keresztmetszetével ideális az áramátvitelhez. A fekete színű, egyerű műanyag érszigetelésű, tömör réz kábel rendkívül megbízható és biztonságos. Az MCU vezeték ára versenyképes, és kiváló választás lehet a költségtudatos vásárlók számára, miközben megfelel a magas minőségi elvárásoknak. A 1,5mm réz vezeték alkalmas védőcsőbe vezetve, így ideális választás vakolat alatt vagy falon való szereléshez. A kábel egyszerűsége és tartóssága révén optimális megoldást kínál egyszerű és hatékony elektromos bekötésekhez.\r\n\r\nA villanyvezeték alkalmazása: védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 1,5 mm2\r\nSzín: fekete\r\nSzigetelés: 700V\r\nKiszerelés: 100m/tekercs\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.\r\n\r\nMCU 1,5 \"elektromos kábel\" jellemzői:\r\nAz MCU 1x 1,5mm2 vezeték egy olyan típusú vezeték, amelynek 1,5mm2 keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz.\r\nEz a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.\r\n\r\nKeresztmetszet és terhelhetőség:\r\nAz MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.\r\n\r\nEzek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.', 'Prysmian Kft.', 'tömör ', 5, 987, 'képek/1,5tomor_fekete_rezvezetek.webp', NULL, NULL, NULL),
(27, 'MCU 1,5 kék vezeték', 82, 'MCu 1,5 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 1,5 mm2\r\nSzín: kék\r\nSzigetelés: 700V\r\nKiszerelés: 100m/tekercs\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.\r\n\r\nMCU 1,5 \"elektromos kábel\" jellemzői:\r\nAz MCU 1x 1,5mm2 vezeték egy olyan típusú vezeték, amelynek 1,5mm2 keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz.\r\nEz a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.\r\n\r\nKeresztmetszet és terhelhetőség:\r\nAz MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.\r\n\r\nEzek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.', 'Prysmian Kft.', 'tömör ', 5, 872, 'képek/1,5tomor_kek_rezvezetek.webp', NULL, NULL, NULL),
(28, 'MCU 1,5 zöld/sárga vezeték', 82, 'MCu 1,5 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 1,5 mm2\r\nSzín: zöld/sárga\r\nSzigetelés: 700V\r\nKiszerelés: 100m/tekercs\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásra ajánlott vezetéket a biztonság, az előírások és a funkciók figyelembevételével kell kiválasztani. Ennek kiválasztását érdemes minden esetben szakemberre bízni. Az MCU vezeték ideális választás lehet általános villanyszerelési célokra, konnektorok és kapcsolók vagy lámpák kialakításához. Az MCU vezeték abban az esetben megfelelő választás ha védőcsőben, gégecsőben vagy más védelmet nyújtó csőrendszerben kerül elvezetésre.\r\n\r\nMCU 1,5 \"elektromos kábel\" jellemzői:\r\nAz MCU 1x 1,5mm2 vezeték egy olyan típusú vezeték, amelynek 1,5mm2 keresztmetszetű rézvezetője van. Az M jelzi a műanyag szigetelést, a Cu pedig a vezető anyagát, ami réz.\r\nEz a vezeték különböző színekben kapható, és a kék szín például a nulla vezetőt, a zöld-sárga csíkos pedig a védőföldet jelöli. A fázisvezetőt általában a legsötétebb színű vezetékkel jelölik, például feketével (L1), míg az L2 általában barna, az L3 pedig szürke.\r\n\r\nKeresztmetszet és terhelhetőség:\r\nAz MCU vezetékek különböző keresztmetszetekben elérhetők, és a kiválasztott keresztmetszet határozza meg a vezeték terhelhetőségét, figyelembe véve a hosszúságot és a beépítési körülményeket.\r\n\r\nEzek az információk segítenek Önnek eligazodni a lakásban történő villanyszerelés során, és biztosítják a biztonságos és megfelelő vezeték kiválasztását.', 'Prysmian Kft.', 'tömör ', 5, 560, 'képek/1,5tomor_zoldsarga_rezvezetek.webp', NULL, NULL, NULL),
(29, '3 Fázisú Villanyóra Szekrény', 73990, 'Csatári Plast PVT 3075 Fm-SZ ÁK 12 1/3 fázisú villanyóra szekrény felső 12 mod elmenővel szabadvezetékes.\r\n\r\nCsatári Plast PVT villanyóra szekrény 80A-ig, nappali óra fogadására felső elhelyezésű mért elosztóval.\r\n1db 12 modulos, csapófedeles ablakkal, max. 12db kismegszakító elhelyezéséhez.\r\nTartalmaz magasított kalapsínt, PE és N sorkapcsot.\r\n\r\nSzabadvezetékes csatlakozás, illetve társasházakban egyedülálló mérés (nem csoportos mérőhely) esetén alkalmazandó, 1/3 fázisú mindennapszaki vagy H tarifa mérésre 80A-ig.\r\nFelhasználási helyek száma: 1\r\n\r\nBeszerelhető mérőórák:\r\nÁrszabás 1 és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 3 és max. áramerőssége (H vagy GEO tarifa): H63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 5 és max. áramerőssége (Inverter): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\n\r\nBeltéri és kültéri használatra is alkalmas (IP65 védelem)\r\nÜtésállóság: IK08\r\nCsatlakozás módja: szabadvezetékes - légvezetékes\r\nKivitel: felületre szerelhető\r\nFogadott méretlen vezeték keresztmetszete: 35 mm2\r\n\r\nElmenő mért vezeték keresztmetszete: 25 mm2\r\nMéretei: Magasság 900 mm x Szélesség 300 mm x Mélység 203 mm\r\nNévleges fesz.: 3 x 230 V / 400 V\r\nKörnyezeti hőmérséklet: Max. +40°C, 24 órás átlag max. +120°C / min. -40°C\r\nKizárólag UV stabilizált műanyagokból készült.\r\n\r\nA tartozék H07V-K 1x10mm2 vezetékcsomag 32A-ig történő szerelésre alkalmas!', 'Csatári Plast Kft.', 'szerelvény', 10, 10, 'képek/17545-55d1b-csatari-plast-pvt-3075-fm-sz-ak-12-13-fazisu-villanyora-szekreny-fel_w480.webp', NULL, NULL, NULL),
(31, '1/3 Fázisú Kombinált Villanyóra Szekrény', 210520, 'Hensel 1/3 fázisú kombinált villanyóra szekrény (n.+é) 80A szabadvezetékes 2x12 mod kism. HB33K024-U.\r\n\r\nKérjük rendelés előtt vegye fel a kapcsolatot ügyfélszolgálatunkkal, készletellenőrzés céljából!\r\nA \"Készleten\" jelzés ellenére, a már megrendelt de még fel nem dolgozott igények miatt előfordulhat, hogy a szekrényt nem tudjuk szállítani.\r\nEzesetben mindenképpen visszajelzünk rendelést követően.\r\nA termékre előrendelést nem veszünk fel, így a készlet erején túl érkezett rendelések törlésre kerülnek!\r\n\r\nFogyasztói főelosztóval: 2db Mi 1112-U .\r\n\r\nÁrszabás 1 és max. áramerőssége\r\n(Mindennapszaki) M63.80A (Mindennapszaki 3 x 80A-ig)\r\nÁrszabás 2 és max. áramerőssége\r\n(Vezérelt) V32A (Vezérelt 3 x 32A-ig)\r\nÁrszabás 3 és max. áramerőssége (H\r\nvagy Geo tarifa) H63A (H tarifa 3 x 63A-ig)\r\nÁrszabás 4 és max. áramerőssége\r\n(Autótöltő) M63.80A (Mindennapszaki 3 x 80A-ig)\r\nÁrszabás 5 és max. áramerőssége\r\n(Inverter) M63.80A (Mindennapszaki 3 x 80A-ig)\r\nBeltéri vagy kültéri telepítésre.\r\nSzabadvezetékes (légkábeles) kivitel\r\nFelületre szerelhető\r\nFogadott méretlen vezeték\r\nkeresztmetszete Max. 35 mm2\r\nElmenő mért vezeték\r\nkeresztmetszete Max. 25 mm2\r\nMéret Magasság 900 mm x Szélesség 600 mm x Mélység 270 mm\r\nNévleges feszültség 3 x 230 V / 400 V\r\nUV állóság UV-álló\r\nIP védettség IP 65\r\nÜtésállóság IK 08', 'Hensel Kft.', 'szerelvény', 10, 1, 'képek/17546-47690-hensel-13-fazisu-kombinalt-villanyora-szekreny-ne-80a-szabadvezeteke_w480.webp', NULL, NULL, NULL),
(32, '1/3 Fázisú Kombinált Villanyóra Szekrény Csatári', 502210, 'Csatári Plast PVT Á-V Fm-CSF50 1/3 fázisú kombinált villanyóra szekrény 80A főelosztóval.\r\n\r\nEgy felhasználási helyes M63.80A és V32A mérés, felületre szerelt kivitelben, csatlakozó főelosztóval.\r\nFöldkábeles és szabadvezetékes csatlakozás.\r\n\r\n-Árszabás 1 és max. áramerőssége M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\n\r\n-Árszabás 2 és max. áramerőssége V32A (Vezérelt max.3x32-es kialakítás)\r\n\r\n-Árszabás 3 és max. áramerőssége (H vagy GEO tarifa)\r\nHv32A (Vezérelt H tarifa max.3x32A-es kialakítás),\r\nH63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)\r\n\r\n-Árszabás 5 és max. áramerőssége (Inverter) M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\n\r\n\r\nBeltéren és kültéren is alkalmazható, IP65 és Ik08 védelemmel.\r\n\r\nNévleges feszültség: 3x230V/400V\r\nNévleges frekvencia: 50 Hz\r\nNévleges rövid idejű határáram (Icw, Ipk, Icc): 30 kA\r\nLökőfeszültség állóság: 6 kV\r\nKörnyezeti hőmérséklet: Max. +40°C, 24 órás átlag max. +120°C / min. -40°C\r\nMéret: Magasság 1050 mm x Szélesség 750 mm x Mélység 203 mm\r\nFogadott méretlen vezeték keresztmetszete 50 mm2\r\n\r\nElmenő mért vezeték keresztmetszete 25 mm2\r\n\r\nTartozéklistán szerepel többek között:\r\nSzakaszolható biztosító kapcsoló (NH00 apator)\r\nHLAK 35 sorkapcsok\r\nTűzeseti kapcsoló\r\n32A-ig komplett vezetékcsomag (fölötte vezetékcserét igényel)', 'Csatári Plast Kft.', 'szerelvény', 10, 4, 'képek/25947-bb111-csatari-plast-pvt-a-v-fm-csf50-13-fazisu-kombinalt-villanyora-szekre_w480.webp', NULL, NULL, NULL),
(33, 'Üres Villanyóra Szekrény Lábazattal', 140550, 'Csatári Plast PVT K-L 80x88/32 üres villanyóra szekrény lábazattal.\r\n\r\nTÚLMÉRETES TERMÉK! CSAK RAKLAPON SZÁLLÍTHATÓ!\r\n\r\nKülső méretei:\r\nSzélesség: 800mm\r\nMélység: 320mm\r\nMagasság: 1.750mm', 'Csatári Plast Kft.', 'szerelvény', 10, 30, 'képek/17451-d6357-csatari-plast-pvt-k-l-80x8832-ures-villanyora-szekreny-labazattal_w480.webp', NULL, NULL, NULL),
(34, 'Tokozott Kapcsoló 0-1', 9900, 'GANZ KKM-0-20-6002 tokozott kapcsoló 3P 20A IP65 0-1 állású BE-KI kapcsoló.\r\n\r\nGanz KKM-0-20-6002 3 pólusú tokozott ipari ki-be kapcsoló 0-1 állással. A kapcsolóba összesen 4db PG16 tömszelence helyezhető el (2db a kapcsoló alján, 2 db a kapcsoló tetején) kábelbevezetés céljából.\r\n\r\nPólusok száma: 3\r\nNévleges terhelhetőség: 20A\r\nNévleges feszültség: 400V\r\nVédettség: IP65\r\nMagasság: 88mm (tömszelence nélkül)\r\nSzélesség: 88mm\r\nMélység: 100mm (kapcsoló karral együtt)', 'Ganz KK Kft.', 'Kapcsolók', 16, 25, 'képek/26553-81ae2-ganz-kkm-0-20-6002-tokozott-kapcsolo-3p-20a-ip65-0-1-allasu-be-ki-ka_w480.webp', NULL, NULL, NULL),
(35, 'Tokozott Kapcsoló 1-0-2', 23788, 'GANZ KKM-1-32-6006 tokozott kapcsoló 3P 32A IP65 1-0-2 állású átkapcsoló.\r\n\r\nGanz KKM-1-32-6006, 3 pólusú tokozott ipari átkapcsoló 1-0-2 állással. A kapcsolóba összesen 4db PM21 tömszelence helyezhető el (2db a kapcsoló alján, 2 db a kapcsoló tetején) kábelbevezetés céljából.\r\n\r\nPólusok száma: 3\r\nNévleges terhelhetőség: 32A\r\nNévleges feszültség: 400V\r\nVédettség: IP65\r\nMagasság: 100mm (tömszelence nélkül)\r\nSzélesség: 100mm\r\nMélység: 140mm (kapcsoló karral együtt) (kar nélkül 112mm)', 'Ganz KK Kft.', 'Kapcsolók', 16, 21, 'képek/11396-9f7c6-ganz-kkm-1-32-6006-tokozott-kapcsolo-3p-32a-ip65-1-0-2-allasu-atkapc_w480.webp', NULL, NULL, NULL),
(36, 'Tokozott Kapcsoló 0-Y-D', 29780, 'GANZ KKM-1-32-6009 tokozott kapcsoló 3P 32A IP65 csillag-delta 0-Y-D állású átkapcsoló.\r\n\r\nGanz KKM-1-32-6009 3 pólusú tokozott csillag/delta kapcsoló 0-Y-D állással. A kapcsolóba összesen 4db PG21 tömszelence helyezhető el (2db a kapcsoló alján, 2 db a kapcsoló tetején) kábelbevezetés céljából.\r\n\r\nPólusok száma: 3\r\nNévleges terhelhetőség: 32A\r\nNévleges feszültség: 400V\r\nVédettség: IP65\r\nMagasság: 100mm (tömszelence nélkül)\r\nSzélesség: 100mm\r\nMélység: 140mm (kapcsoló karral együtt)', 'Ganz KK Kft.', 'Kapcsolók', 16, 14, 'képek/11400-e98f0-ganz-kkm-1-32-6009-tokozott-kapcsolo-3p-32a-ip65-csillag-delta-0-y-d_w480.webp', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tetelek`
--

CREATE TABLE `tetelek` (
  `id` int NOT NULL,
  `rendeles_id` int NOT NULL,
  `termek_id` int NOT NULL,
  `tetelek_mennyiseg` int NOT NULL,
  `fh_nev` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `statusz` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'kosárban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- A tábla adatainak kiíratása `tetelek`
--

INSERT INTO `tetelek` (`id`, `rendeles_id`, `termek_id`, `tetelek_mennyiseg`, `fh_nev`, `statusz`) VALUES
(221, 33, 18, 1, 'admin', 'leadva'),
(222, 34, 18, 1, 'admin', 'leadva'),
(223, 35, 18, 1, 'admin', 'leadva'),
(225, 36, 32, 1, 'admin', 'leadva'),
(226, 37, 29, 1, 'admin', 'leadva'),
(230, 40, 32, 1, 'admin', 'leadva'),
(231, 40, 29, 1, 'admin', 'leadva'),
(232, 40, 18, 1, 'admin', 'leadva'),
(233, 40, 17, 1, 'admin', 'leadva'),
(239, 42, 32, 1, 'admin', 'leadva'),
(240, 43, 17, 1, 'admin', 'leadva'),
(241, 44, 32, 1, 'admin', 'leadva'),
(242, 45, 32, 1, 'admin', 'leadva'),
(243, 46, 29, 1, 'admin', 'leadva'),
(244, 47, 29, 1, 'admin', 'leadva'),
(245, 48, 9, 1, 'admin', 'kosárban');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `megrendeles`
--
ALTER TABLE `megrendeles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT a táblához `tetelek`
--
ALTER TABLE `tetelek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

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
