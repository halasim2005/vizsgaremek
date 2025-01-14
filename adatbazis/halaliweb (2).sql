-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jan 14. 17:50
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

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
(6, 'admin', 'standard', 'kartya', 0, '1690', 1690, '0000-00-00', 'feldolgozás alatt'),
(8, 'admin', 'te', 'te', 10, 't', 100, '2025-01-14', 'feldolgozás alatt'),
(9, 'admin', 'standard', 'kartya', 30305, '0', 30305, '0000-00-00', 'feldolgozás alatt'),
(10, 'admin', 'standard', 'kartya', 30305, '0', 30305, '0000-00-00', 'feldolgozás alatt'),
(11, 'admin', 'standard', 'kartya', 30305, '0', 0, '2025-01-14', 'feldolgozás alatt'),
(12, 'admin', 'standard', 'utanvet', 100, '1690', 1690, '2025-01-14', 'feldolgozás alatt'),
(13, 'admin', 'standard', 'utanvet', 5990, '1690', 1690, '2025-01-14', 'feldolgozás alatt'),
(14, 'admin', 'standard', 'kartya', 8000, '1690', 1690, '2025-01-14', 'feldolgozás alatt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `termek` (
  `id` int(10) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `egysegar` int(8) NOT NULL,
  `leiras` varchar(1000) NOT NULL,
  `gyarto` varchar(100) NOT NULL,
  `tipus` varchar(100) NOT NULL,
  `kategoria_id` int(3) NOT NULL,
  `elerheto_darab` int(5) NOT NULL,
  `kep` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `termek`
--

INSERT INTO `termek` (`id`, `nev`, `egysegar`, `leiras`, `gyarto`, `tipus`, `kategoria_id`, `elerheto_darab`, `kep`) VALUES
(9, 'Figyelmeztető Matrica 400V', 100, 'Figyelmeztető Matrica Öntapadós \"Vigyázz! 400V\" 160x100mm.\r\n\r\n1 db, 160x100mm méretű matrica \"Vigyázz! 400V!\" felirattal!\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n\r\nJól Rögzített Tapadás: Győződjön meg róla, hogy a matrica jól tapad. Ü', 'HaLáli Kft.', 'Öntapadós', 4, 16, 'képek/400voltvigyazzmatrica.webp'),
(10, 'MCU 0,75 vezeték', 55, 'MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték fekete (200m).\r\n\r\nMCu 0,75 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 0,75 mm2\r\nSzín: fekete\r\nSzigetelés: 500V\r\nKiszerelés: 200m/tekercs\r\nKülső átmérő : ~ 2,1mm\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásr', 'Prysmian Kft.', 'tömör ', 5, 236, 'képek/0,75tomor_fekete_rezvezetek.webp'),
(11, 'Tűzálló kábel', 240, 'Tűzálló kábel 1x2x0,8 JB-H(St)H E90 (JE-H(St)H BD E90) árnyékolt tömör réz vezeték.\r\nA tűzálló kábel halogénmentes, csillámszalag érszigetelésű, halogénmentes műanyag fólia szigeteléssel, műanyag kasírozású fémfólia árnyékolás, halogénmentes tűzálló köpenyű, 2 egymástól külön elszigetelt tömör rézeret tartalmazó kábel. Igény esetén egyedi méretre vágjuk vásárláskor.\r\nAlkalmazása belső terekben tűzjelző készülékek számára rögzített elhelyezéssel, ahol előírás a 180 perces szigetelőképesség és a 90 perces funkciómegtartás a tűzterhelés kezdetétől.\r\n\r\nKeresztmetszet: 1x2x0,8 mm2\r\nKülső átmérő: ~7 mm\r\nSzín: vörös\r\nNévleges Feszültség: 225V\r\nKiszerelés: 500m/dob', 'HaLáli Kft.', 'tömör ', 6, 509, 'képek/tuzallo_kabel_0,8.webp'),
(12, 'Lakáselosztó falon kívüli', 2950, 'Lakáselosztó falon kívüli 8 modulos elosztó szekrény Kanlux DB108S.\r\n20/Karton\r\n\r\n8 modulos, falon kívül szerelhető lakáselosztó\r\nkalapsínnel és föld, nulla (PE,N) sínekkel szerelve\r\nIp40, beltéri használatra ajánlott\r\nMéretek: 189x205x101mm (szé-ma-mé)', 'Kanlux', 'falon kívűli', 7, 19, 'képek/lakaseloszto_8modul_kanlux.webp'),
(13, 'Fi relé', 5990, 'Fi relé 2P 25A 30mA 6kA (AC) áramvédő kapcsoló ÁVK ÉV relé TRACON TFV2-25030.\r\n\r\nTracon áramvédő-kapcsoló ÁVK (fi-relé). A készülék előlapján lévő teszt gomb segítségével ellenőrizhető a készülék működőképessége, amit szabvány szerint havonta egyszer ellenőrizni kell. A készülék villás vagy csapos fázissínnel sorolható, TS35-ös kalapsinre pattintható.\r\n\r\nNévleges áramerősség: 25A\r\nÉrzékenység: 30mA\r\nMegszakítóképesség: 6kA\r\nHálózati feszültség: 230V AC-váltakozó áram\r\nPólusok száma: 2\r\nBeköthető vezeték keresztmetszete: 1.5-25mm2\r\nKészülék szélessége: 2 modul\r\nKörnyezeti hőmérséklet üzem közben: - 25 - 55 °C', 'Tracon Electric', 'ÁVK', 8, 5, 'képek/fi_relé_2p_25a_30ma.webp'),
(14, 'Villanyóra szekrény', 48990, 'Csatári Plast PVT 3075 Fm-SZ 1/3 fázisú villanyóra szekrény 80A szabadvezetékes.\r\n\r\nSzabadvezetékes csatlakozás, illetve társasházakban egyedülálló mérés (nem csoportos mérőhely) esetén alkalmazandó, 1/3 fázisú mindennapszaki vagy H tarifa mérésre 80A-ig.\r\nFelhasználási helyek száma: 1\r\n\r\nBeszerelhető mérőórák:\r\nÁrszabás 1 és max. áramerőssége (Mindennapszaki): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 3 és max. áramerőssége (H vagy GEO tarifa): H63.80A (H tarifa max.3x63A és 3x80A-es kialakítás)\r\nÁrszabás 5 és max. áramerőssége (Inverter): M63.80A (Mindennapszaki max.3x63A és 3x80A-es kialakítás)\r\n\r\nBeltéri és kültéri használatra is alkalmas (IP65 védelem)\r\nÜtésállóság: IK08\r\nCsatlakozás módja: szabadvezetékes - légvezetékes\r\nKivitel: felületre szerelhető\r\nFogadott méretlen vezeték keresztmetszete: 35 mm2\r\n\r\nElmenő mért vezeték keresztmetszete: 25 mm2\r\nMéretei: Magasság 750 mm x Szélesség 300 mm x Mélység 203 mm\r\nNévleges fesz.: 3 x 230 V / 400 V\r\nKörnyezeti ', 'Csatári Plast Kft.', 'falon kívűli', 10, 4, 'képek/villanyoraszekreny.webp'),
(15, 'Kalapsín', 470, 'Kalapsín (TS35 sín, C sín, Din sín) 137mm Tracon.\r\n\r\nTS35 kalapsín, 137mm-es szélességben, csavarokkal rögzíthető.', 'Tracon Electric', 'szerelvény', 11, 55, 'képek/kalapsin.webp'),
(16, 'WAGO', 45, 'WAGO 2 vezetékes összekötő (tömör 0,5-2,5mm2) 24A átlátszó fehér 2273-202, 100db/doboz\r\n\r\nA Compact Wago vezetékösszekötő 2 db tömör vezeték ( 0,5 - 2,5 mm2-ig ) összekötését oldja meg. A 2273-202 sorkapocs belsejében az érintkező lemezke azonnal rögzíti a csatlakoztatott réz vezetéket és megakadályozza a visszairányú mozgást. Az átlátszó ház segítségével pontosan látható a csatlakoztatott vezeték és ellenőrizhető a megfelelő hosszúságú csupaszolt vezetékvég csatlakozása. A kisebb méret miatt könnyebb a beépítése a szerelvény dobozba.\r\nAlumínium vezeték összekötéséhez Wago Alu Pasta (249-130) ajánlott, amit kedvező áron megtalál webáruházunkban.\r\n\r\nWago terhelhetősége: 24A\r\nKiszerelés: 100db/doboz.', 'Wago ', 'szerelvény', 11, 450, 'képek/wago.webp'),
(17, 'Figyelmeztető Matrica Öntapadós \"230V\"', 419, 'Figyelmeztető Matrica Öntapadós \"230V\" 20x10mm 30 db/ív.\r\n\r\nA bliszter tartalma: 30 db, egyenként 20x10mm méretű matrica \"230V\" felirattal!\r\nA feltüntetett ár 1db blisztert tartalmaz!\r\n\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n\r\nJól Rögzített Tapadás: Győződjön meg róla, hogy a', 'HaLáli Kft.', 'Matrica', 4, 0, 'képek/230matricakicsi.webp');

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
-- A tábla adatainak kiíratása `tetelek`
--

INSERT INTO `tetelek` (`id`, `rendeles_id`, `termek_id`, `tetelek_mennyiseg`, `fh_nev`, `statusz`) VALUES
(103, 6, 13, 2, 'admin', 'leadva'),
(104, 6, 15, 1, 'admin', 'leadva'),
(105, 6, 10, 28, 'admin', 'leadva');

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
  ADD UNIQUE KEY `kategoria_id` (`kategoria_id`,`elerheto_darab`);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `tetelek`
--
ALTER TABLE `tetelek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

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
