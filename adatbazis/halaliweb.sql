-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Dec 02. 17:19
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
  `telefonszam` int(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jogosultsag` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`fh_nev`, `jelszo`, `vezeteknev`, `keresztnev`, `szamlazasi_iranyitoszam`, `szamlazasi_telepules`, `szamlazasi_utca`, `szamlazasi_hazszam`, `szamlazasi_cegnev`, `szamlazasi_adoszam`, `kezbesitesi_iranyitoszam`, `kezbesitesi_telepules`, `kezbesitesi_utca`, `kezbesitesi_hazszam`, `telefonszam`, `email`, `jogosultsag`) VALUES
('admin', '$2y$10$ZV5/kz0Yn1IB687p5eqfAuMCureJAlRueIJwPNtionjFT/mh8lUGK', 'a', 'a', 0, '', '', '', '', 0, 0, '', '', '', 0, 'a@gmail.com', 'admin'),
('b', '$2y$10$/jo.zuoSmbDGDUS6O.4QBuGIcEg5q5uuV/ZrbauzPM18rZvnIube2', 'b', 'b', 0, '', '', '', '', 0, 0, '', '', '', 0, 'b@gmailcom', 'user');

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
(1, 'Kapcsoló', 'Villanykapcsoló, stb.'),
(2, 'Teszt kategória', 'teszt'),
(3, 'asd', 'asd');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `megrendeles`
--

CREATE TABLE `megrendeles` (
  `id` int(10) NOT NULL,
  `fh_nev` varchar(25) NOT NULL,
  `leadas_datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'Figyelmeztető Matrica 400V', 420, 'Figyelmeztető Matrica Öntapadós \"Vigyázz! 400V\" 160x100mm.\r\n\r\n1 db, 160x100mm méretű matrica \"Vigyázz! 400V!\" felirattal!\r\nA feltüntetett ár 1db matricát tartalmaz!\r\n\r\n\r\n\r\nAz öntapadós matricák rendkívül hasznosak a villanyszerelés területén, amikor pontos és jól látható jelölésekre van szükség. Ezek a matricák a következőképpen használhatók:\r\n\r\nVálassza ki a Megfelelő Matricát: Mindig válassza ki azon matricákat, amelyek a kívánt információval rendelkeznek. Például, címkézze fel a konnektorokat a feszültség, áramlás vagy egyéb releváns adatokkal.\r\n\r\nAlapos Tisztítás: A felragasztás előtt biztosítsa, hogy a felület tiszta és száraz legyen. A por és szennyeződések befolyásolhatják az öntapadós matrica tapadását.\r\n\r\nPontos Helymeghatározás: Helyezze a matricát olyan helyre, amely könnyen látható és olvasható. A kapcsolók, konnektorok és egyéb elektromos berendezések közelében alkalmazva segít az azonnali azonosításban.\r\n\r\nJól Rögzített Tapadás: Győződjön meg róla, hogy a matrica jól tapa', 'HaLáli Kft.', 'Matrica', 2, 150, 'képek/400voltvigyazzmatrica.webp'),
(3, 'MCU 0,75 vezeték tömör', 55, 'MCU 0,75 vezeték (H05V-U) tömör réz kábel elektromos villanyvezeték fekete (200m).\r\n\r\nMCu 0,75 mm2 vezeték egyerű műanyag érszigetelésű, köpeny nélküli tömör rézvezeték.\r\nA villanyvezeték alkalmazása védőcsőbe vezetve vakolat alatt vagy falon szerelve.\r\n\r\nVezeték keresztmetszet: 0,75 mm2\r\nSzín: fekete\r\nSzigetelés: 500V\r\nKiszerelés: 200m/tekercs\r\nKülső átmérő : ~ 2,1mm\r\n\r\nAz MCU vezeték kiváló választás lehet a lakásban történő villanyszereléshez. Az MCU vezeték egy eres, merev szerkezetű és szigetelt elektromos vezeték, amely többféle színben elérhető a könnyebb azonosítás érdekében.\r\n\r\nMire jó az MCU vezeték?\r\nAz MCU vezeték alkalmas a háztartási villanyszerelési feladatokhoz. Kiválóan használható konnektorok, kapcsolók, világítás és egyéb elektromos berendezések csatlakoztatására. Az MCU vezeték lehetővé teszi az elektromos áram biztonságos és hatékony átvitelét a lakásban.\r\n\r\nMilyen vezetéket válasszak a lakásba? (Milyen villanyvezeték kell a lakásba?)\r\nA lakásban való felhasználásr', 'Prysmian Kft.', 'Vezeték', 2, 100, 'képek/0,75tomor_fekete_rezvezetek.webp'),
(4, 'Multiméter Somogyi', 4980, 'Somogyi digitális multiméter VC 830L.', 'Somogyi', 'Műszer', 2, 25, 'képek/dig_multimeter_somogyi.webp');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tetelek`
--

CREATE TABLE `tetelek` (
  `id` int(10) NOT NULL,
  `rendeles_id` int(100) NOT NULL,
  `termek_id` int(10) NOT NULL,
  `tetelek_mennyiseg` int(5) NOT NULL
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
  ADD UNIQUE KEY `fh_nev` (`fh_nev`);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `megrendeles`
--
ALTER TABLE `megrendeles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `tetelek`
--
ALTER TABLE `tetelek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
