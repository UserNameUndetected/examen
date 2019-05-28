-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 27 mei 2019 om 10:47
-- Serverversie: 5.5.64-MariaDB
-- PHP-versie: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thiemeluis_bean`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE `bestelling` (
  `id` int(11) NOT NULL,
  `tafel` varchar(3) CHARACTER SET utf8 NOT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `menuitemcode` int(4) NOT NULL,
  `aantal` int(11) NOT NULL,
  `prijs` decimal(5,2) NOT NULL,
  `geleverd` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bon`
--

CREATE TABLE `bon` (
  `id` int(11) NOT NULL,
  `tafel` varchar(3) CHARACTER SET utf8 NOT NULL,
  `datum` varchar(10) CHARACTER SET utf8 NOT NULL,
  `tijd` varchar(10) CHARACTER SET utf8 NOT NULL,
  `betalingswijze` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE `gerecht` (
  `gerechtcode` int(3) NOT NULL,
  `gerecht` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`gerechtcode`, `gerecht`) VALUES
(1, 'Voorgerecht'),
(2, 'Hoofdgerecht'),
(3, 'Nagerecht'),
(4, 'Dranken'),
(5, 'Hapjes');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `klantid` int(11) NOT NULL,
  `klantnaam` varchar(30) CHARACTER SET utf8 NOT NULL,
  `telefoon` varchar(15) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`klantid`, `klantnaam`, `telefoon`) VALUES
(1, 'Smit', '06111111111'),
(2, 'Janssen', '06222222222'),
(3, 'Heijn', '06444444444');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menuitem`
--

CREATE TABLE `menuitem` (
  `gerechtcode` int(3) NOT NULL,
  `subgerechtcode` int(4) NOT NULL,
  `menuitemcode` int(4) NOT NULL,
  `menuitem` varchar(30) CHARACTER SET utf8 NOT NULL,
  `prijs` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `menuitem`
--

INSERT INTO `menuitem` (`gerechtcode`, `subgerechtcode`, `menuitemcode`, `menuitem`, `prijs`) VALUES
(1, 1, 1, 'Tomatensoep', '4.95'),
(1, 1, 2, 'Groentesoep', '3.95'),
(1, 1, 3, 'Aspergesoep', '4.95'),
(1, 1, 4, 'Uiensoep', '3.95'),
(1, 2, 5, 'Salade met geitenkaas', '4.95'),
(1, 2, 6, 'Tonijnsalade', '5.95'),
(1, 2, 7, 'Zalmsalade', '5.95'),
(2, 3, 8, 'Gebakken makreel', '8.95'),
(2, 3, 9, 'Mosselen uit pan', '9.95'),
(2, 4, 10, 'Biefstuk in champignonsaus', '11.95'),
(2, 4, 11, 'Wienerschnitzel', '9.95'),
(2, 5, 12, 'Bonengerecht met diverse groen', '11.95'),
(2, 5, 13, 'Gebakken banaan', '10.95'),
(3, 6, 14, 'Black lady', '4.95'),
(3, 6, 15, 'Vruchtenijs', '2.95'),
(3, 7, 16, 'Chocolademousse', '4.95'),
(3, 7, 17, 'Vanillemousse', '3.95'),
(3, 7, 18, 'Koffie', '2.45'),
(4, 8, 19, 'Thee', '2.45'),
(4, 8, 20, 'Espresso', '2.45'),
(4, 8, 21, 'Cappuccino', '2.75'),
(4, 8, 22, 'Koffie verkeerd', '2.95'),
(4, 8, 23, 'Latte macchiato', '3.95'),
(4, 9, 24, 'Pilsner', '2.95'),
(4, 9, 25, 'Weizen', '3.95'),
(4, 9, 26, 'Stender', '2.95'),
(4, 9, 27, 'Palm', '3.60'),
(4, 9, 28, 'Kasteel donker', '4.75'),
(4, 9, 29, 'Brugse zot', '3.95'),
(4, 9, 30, 'Grimbergen dubbel', '3.95'),
(4, 10, 31, 'Per glas', '3.95'),
(4, 10, 32, 'Per fles', '17.95'),
(4, 10, 33, 'Seizoenswijn', '3.95'),
(4, 10, 34, 'Rode port', '3.60'),
(4, 11, 35, 'Tonic', '2.95'),
(4, 11, 36, 'Seven up', '2.95'),
(4, 11, 37, 'Verse jus', '3.95'),
(4, 11, 38, 'Chaudfontaine rood', '2.75'),
(4, 11, 39, 'Chaudfontaine blauw', '2.75'),
(4, 12, 40, 'Bitterballen met mosterd', '4.00'),
(4, 12, 41, 'Vlammetjes met chilisaus', '4.00'),
(4, 12, 42, 'Kipbites', '5.00'),
(4, 13, 43, 'Portie kaas met mosterd', '4.00'),
(4, 13, 44, 'Brood met kruidenboter', '5.00'),
(4, 13, 45, 'Portie salami worst', '4.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reservering`
--

CREATE TABLE `reservering` (
  `tafel` varchar(3) CHARACTER SET utf8 NOT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `klantid` int(5) NOT NULL,
  `aantal` int(11) NOT NULL,
  `gebruikt` tinyint(1) NOT NULL,
  `allergieen` text CHARACTER SET utf8 NOT NULL,
  `opmerkingen` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `reservering`
--

INSERT INTO `reservering` (`tafel`, `datum`, `tijd`, `klantid`, `aantal`, `gebruikt`, `allergieen`, `opmerkingen`) VALUES
('13', '2019-05-27', '21:00:00', 2, 5, 0, 'Lactose-introllerant', ''),
('17', '2019-05-27', '19:00:00', 3, 9, 0, '-', '-'),
('4', '2019-05-01', '18:00:00', 1, 2, 0, '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subgerecht`
--

CREATE TABLE `subgerecht` (
  `gerechtcode` int(3) NOT NULL,
  `subgerechtcode` int(4) NOT NULL,
  `subgerecht` varchar(25) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `subgerecht`
--

INSERT INTO `subgerecht` (`gerechtcode`, `subgerechtcode`, `subgerecht`) VALUES
(1, 1, 'Warme voorgerechten'),
(1, 2, 'Koude voorgerechten'),
(2, 3, 'Visgerechten'),
(2, 4, 'Vleesgerechten'),
(2, 5, 'Vegetarische gerechten'),
(3, 6, 'Ijs'),
(3, 7, 'Mousse'),
(4, 8, 'Warme dranken'),
(4, 9, 'Bieren'),
(4, 10, 'Huiswijnen'),
(4, 11, 'Frisdranken'),
(5, 12, 'Warme hapjes'),
(5, 13, 'Koude hapjes');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tafel` (`tafel`),
  ADD KEY `menuitemcode` (`menuitemcode`),
  ADD KEY `datum` (`datum`),
  ADD KEY `tijd` (`tijd`);

--
-- Indexen voor tabel `bon`
--
ALTER TABLE `bon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bon_ibfk_1` (`tafel`);

--
-- Indexen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD PRIMARY KEY (`gerechtcode`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantid`);

--
-- Indexen voor tabel `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`menuitemcode`),
  ADD KEY `gerechtcode` (`gerechtcode`),
  ADD KEY `subgerechtcode` (`subgerechtcode`);

--
-- Indexen voor tabel `reservering`
--
ALTER TABLE `reservering`
  ADD PRIMARY KEY (`tafel`,`datum`,`tijd`),
  ADD KEY `klantid` (`klantid`);

--
-- Indexen voor tabel `subgerecht`
--
ALTER TABLE `subgerecht`
  ADD PRIMARY KEY (`subgerechtcode`),
  ADD KEY `gerechtcode` (`gerechtcode`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `bon`
--
ALTER TABLE `bon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `gerecht`
--
ALTER TABLE `gerecht`
  MODIFY `gerechtcode` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `menuitemcode` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT voor een tabel `subgerecht`
--
ALTER TABLE `subgerecht`
  MODIFY `subgerechtcode` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `bestelling_ibfk_1` FOREIGN KEY (`menuitemcode`) REFERENCES `menuitem` (`menuitemcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bestelling_ibfk_2` FOREIGN KEY (`menuitemcode`) REFERENCES `menuitem` (`menuitemcode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `menuitem_ibfk_1` FOREIGN KEY (`gerechtcode`) REFERENCES `gerecht` (`gerechtcode`),
  ADD CONSTRAINT `menuitem_ibfk_2` FOREIGN KEY (`subgerechtcode`) REFERENCES `subgerecht` (`subgerechtcode`);

--
-- Beperkingen voor tabel `reservering`
--
ALTER TABLE `reservering`
  ADD CONSTRAINT `reservering_ibfk_1` FOREIGN KEY (`klantid`) REFERENCES `klant` (`klantid`);

--
-- Beperkingen voor tabel `subgerecht`
--
ALTER TABLE `subgerecht`
  ADD CONSTRAINT `subgerecht_ibfk_1` FOREIGN KEY (`gerechtcode`) REFERENCES `gerecht` (`gerechtcode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
