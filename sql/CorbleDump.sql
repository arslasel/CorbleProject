-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 18. Mai 2021 um 20:26
-- Server-Version: 10.3.28-MariaDB-log-cll-lve
-- PHP-Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `rigpdqdi_corbleCh`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game`
--

CREATE TABLE `tbl_game` (
  `indx` int(11) NOT NULL,
  `fk_lobby_indx_game` int(11) NOT NULL,
  `state` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_round`
--

CREATE TABLE `tbl_game_round` (
  `indx` int(11) NOT NULL,
  `fk_game_indx_game_round` int(11) NOT NULL,
  `fk_round_indx_game_round` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_lobby`
--

CREATE TABLE `tbl_lobby` (
  `indx` int(11) NOT NULL,
  `votetime` int(11) NOT NULL,
  `drawtime` int(11) NOT NULL,
  `maxplayer` int(11) NOT NULL,
  `fk_player_indx_lobby` int(11) NOT NULL,
  `state` varchar(15) NOT NULL,
  `joincode` int(11) NOT NULL,
  `starttime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_lobby`
--

INSERT INTO `tbl_lobby` (`indx`, `votetime`, `drawtime`, `maxplayer`, `fk_player_indx_lobby`, `state`, `joincode`, `starttime`) VALUES
(424, 60, 60, 8, 479, 'WaitForPlayers', 297329, 1621367282),
(425, 30, 60, 7, 491, 'WaitForPlayers', 161787, 1621368508),
(426, 30, 60, 7, 497, 'WaitForPlayers', 630664, 1621368586),
(427, 40, 50, 5, 502, 'WaitForPlayers', 988460, 1621368869),
(428, 30, 60, 0, 506, 'WaitForPlayers', 673668, 1621369141);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_lobby_player`
--

CREATE TABLE `tbl_lobby_player` (
  `indx` int(11) NOT NULL,
  `fk_lobby_indx_lobby_player` int(11) NOT NULL,
  `fk_player_indx_lobby_player` int(11) NOT NULL,
  `partyleader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_lobby_player`
--

INSERT INTO `tbl_lobby_player` (`indx`, `fk_lobby_indx_lobby_player`, `fk_player_indx_lobby_player`, `partyleader`) VALUES
(485, 424, 479, 1),
(486, 424, 481, 0),
(487, 424, 483, 0),
(488, 424, 484, 0),
(489, 424, 482, 0),
(490, 424, 487, 0),
(491, 424, 486, 0),
(492, 424, 485, 0),
(493, 425, 491, 1),
(494, 425, 493, 0),
(495, 425, 494, 0),
(496, 425, 495, 0),
(497, 426, 497, 1),
(498, 426, 501, 0),
(499, 426, 498, 0),
(500, 426, 500, 0),
(501, 426, 499, 0),
(502, 427, 502, 1),
(503, 427, 504, 0),
(504, 427, 503, 0),
(505, 428, 506, 1),
(506, 428, 505, 0),
(507, 428, 507, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_lobby_wordpool`
--

CREATE TABLE `tbl_lobby_wordpool` (
  `indx` int(11) NOT NULL,
  `fk_lobby_indx_lobby_wordpool` int(11) NOT NULL,
  `fk_wordpool_indx_lobby_wordpool` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_lobby_wordpool`
--

INSERT INTO `tbl_lobby_wordpool` (`indx`, `fk_lobby_indx_lobby_wordpool`, `fk_wordpool_indx_lobby_wordpool`) VALUES
(409, 424, 1),
(410, 424, 2),
(411, 424, 3),
(412, 424, 4),
(413, 424, 6),
(414, 425, 1),
(415, 425, 2),
(416, 425, 3),
(417, 425, 4),
(418, 425, 6),
(419, 426, 1),
(420, 426, 2),
(421, 426, 3),
(422, 426, 4),
(423, 426, 6),
(424, 427, 1),
(425, 427, 2),
(426, 427, 3),
(427, 427, 4),
(428, 427, 6),
(429, 428, 1),
(430, 428, 2),
(431, 428, 3),
(432, 428, 4),
(433, 428, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_player`
--

CREATE TABLE `tbl_player` (
  `indx` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_player`
--

INSERT INTO `tbl_player` (`indx`, `name`) VALUES
(479, 'gino1'),
(480, 'gino2'),
(481, 'kaya1'),
(482, 'roman1'),
(483, 'kaya2'),
(484, 'roman2'),
(485, 'Alguadom1'),
(486, 'Alguadom2'),
(487, 'gino3'),
(488, 'qwef'),
(489, 'Gino'),
(490, 'Selim'),
(491, 'GINO_gangster'),
(492, 'sexselim'),
(493, 'kaya96'),
(494, 'Alguadom3'),
(495, 'asdfv'),
(496, 'ulalalaselim'),
(497, 'Gino_chef'),
(498, 'romanofski'),
(499, 'Alguadom4'),
(500, 'SexyYugo'),
(501, 'kaya1131'),
(502, 'ginogino'),
(503, 'selimArslan'),
(504, 'romaan'),
(505, 'MongoChind'),
(506, 'Gino_Gino'),
(507, 'roman');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_round`
--

CREATE TABLE `tbl_round` (
  `indx` int(11) NOT NULL,
  `fk_word_indx_round` int(11) NOT NULL,
  `state` varchar(30) NOT NULL DEFAULT 'running',
  `fk_lobby_indx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_round`
--

INSERT INTO `tbl_round` (`indx`, `fk_word_indx_round`, `state`, `fk_lobby_indx`) VALUES
(1, 3, 'running', 197),
(4, 14, 'running', 296),
(5, 13, 'running', 297),
(6, 14, 'running', 298),
(7, 14, 'running', 299),
(8, 14, 'running', 300),
(9, 15, 'running', 301),
(10, 15, 'running', 302),
(11, 12, 'running', 303),
(12, 15, 'running', 304),
(13, 16, 'running', 305),
(14, 14, 'running', 308),
(15, 14, 'running', 309),
(16, 15, 'running', 310),
(17, 10, 'running', 311),
(18, 8, 'running', 312),
(19, 25, 'running', 313),
(20, 16, 'running', 314),
(21, 16, 'running', 315),
(22, 13, 'running', 316),
(23, 12, 'running', 317),
(24, 13, 'running', 318),
(25, 14, 'running', 319),
(26, 12, 'running', 320),
(27, 16, 'running', 321),
(28, 16, 'running', 322),
(29, 13, 'running', 323),
(30, 15, 'running', 324),
(31, 16, 'running', 325),
(32, 16, 'running', 326),
(33, 16, 'running', 327),
(34, 13, 'running', 328),
(35, 7, 'running', 329),
(36, 9, 'running', 330),
(37, 12, 'running', 331),
(38, 10, 'running', 332),
(39, 11, 'running', 333),
(40, 9, 'running', 334),
(41, 3, 'running', 335),
(42, 8, 'running', 336),
(43, 5, 'running', 337),
(44, 9, 'running', 338),
(45, 15, 'running', 339),
(46, 10, 'running', 340),
(47, 10, 'running', 341),
(48, 8, 'running', 342),
(49, 11, 'running', 343),
(50, 14, 'running', 344),
(51, 8, 'running', 345),
(52, 9, 'running', 346),
(53, 8, 'running', 347),
(54, 9, 'running', 348),
(55, 9, 'running', 349),
(56, 7, 'running', 350),
(57, 9, 'running', 351),
(58, 13, 'running', 352),
(59, 8, 'running', 353),
(60, 7, 'running', 354),
(61, 12, 'running', 355),
(62, 7, 'running', 356),
(63, 11, 'running', 357),
(64, 16, 'running', 358),
(65, 12, 'running', 359),
(66, 9, 'running', 360),
(67, 15, 'running', 361),
(68, 7, 'running', 362),
(69, 11, 'running', 363),
(70, 7, 'running', 364),
(71, 11, 'running', 365),
(72, 2, 'running', 366),
(73, 7, 'running', 367),
(74, 10, 'running', 368),
(75, 10, 'running', 369),
(76, 8, 'running', 370),
(77, 8, 'running', 371),
(78, 15, 'running', 372),
(79, 11, 'running', 373),
(80, 23, 'running', 374),
(81, 12, 'running', 375),
(82, 15, 'running', 376),
(83, 8, 'running', 377),
(84, 7, 'running', 378),
(85, 16, 'running', 379),
(86, 15, 'running', 380),
(87, 7, 'running', 381),
(88, 7, 'running', 382),
(89, 11, 'running', 383),
(90, 11, 'running', 384),
(91, 2, 'running', 385),
(92, 18, 'running', 386),
(93, 15, 'running', 389),
(94, 10, 'running', 390),
(95, 13, 'running', 391),
(96, 18, 'running', 392),
(97, 11, 'running', 393),
(98, 12, 'running', 394),
(99, 12, 'running', 395),
(100, 16, 'running', 396),
(101, 5, 'running', 397),
(102, 7, 'running', 398),
(103, 4, 'running', 399),
(104, 11, 'running', 401),
(105, 16, 'running', 402),
(106, 2, 'running', 403),
(107, 10, 'running', 404),
(108, 10, 'running', 405),
(109, 11, 'running', 406),
(110, 14, 'running', 407),
(111, 10, 'running', 409),
(112, 24, 'running', 410),
(113, 13, 'running', 411),
(114, 8, 'running', 412),
(115, 8, 'running', 413),
(116, 16, 'running', 414),
(117, 26, 'running', 415),
(118, 2, 'running', 416),
(119, 19, 'running', 417),
(120, 18, 'running', 418),
(121, 13, 'running', 419),
(122, 15, 'running', 420),
(123, 15, 'running', 421),
(124, 10, 'running', 422),
(125, 7, 'running', 423),
(126, 15, 'running', 424),
(127, 22, 'running', 425),
(128, 18, 'running', 426),
(129, 24, 'running', 427),
(130, 20, 'running', 428);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_round_sketch`
--

CREATE TABLE `tbl_round_sketch` (
  `indx` int(11) NOT NULL,
  `fk_sketch_indx_round_sketch` int(11) NOT NULL,
  `fk_round_indx_round_sketch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_round_sketch`
--

INSERT INTO `tbl_round_sketch` (`indx`, `fk_sketch_indx_round_sketch`, `fk_round_indx_round_sketch`) VALUES
(345, 656, 126),
(346, 655, 126),
(347, 657, 126),
(348, 658, 126),
(349, 659, 126),
(350, 660, 126),
(351, 661, 126),
(352, 662, 126),
(353, 663, 128),
(354, 664, 128),
(355, 665, 128),
(356, 666, 128),
(357, 667, 128),
(358, 668, 129),
(359, 669, 129),
(360, 670, 129),
(361, 671, 130),
(362, 672, 130),
(363, 673, 130);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_sketch`
--

CREATE TABLE `tbl_sketch` (
  `indx` int(11) NOT NULL,
  `path` varchar(256) DEFAULT NULL,
  `computerscore` float NOT NULL DEFAULT 0,
  `fk_player_indx_sketch` int(11) NOT NULL,
  `fk_word_indx_sketch` int(11) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `fk_round_indx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_sketch`
--

INSERT INTO `tbl_sketch` (`indx`, `path`, `computerscore`, `fk_player_indx_sketch`, `fk_word_indx_sketch`, `votes`, `fk_round_indx`) VALUES
(655, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/481.txt', 4, 481, 15, 0, 126),
(656, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/484.txt', 0, 484, 15, 2, 126),
(657, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/483.txt', 0, 483, 15, 0, 126),
(658, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/482.txt', 4, 482, 15, 0, 126),
(659, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/485.txt', 1, 485, 15, 0, 126),
(660, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/486.txt', 3, 486, 15, 1, 126),
(661, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/479.txt', 0, 479, 15, 1, 126),
(662, '/home/rigpdqdi/public_html/corble.ch/sketches/424/126/487.txt', 1, 487, 15, 3, 126),
(663, '/home/rigpdqdi/public_html/corble.ch/sketches/426/128/498.txt', 4, 498, 18, 1, 128),
(664, '/home/rigpdqdi/public_html/corble.ch/sketches/426/128/501.txt', 4, 501, 18, 1, 128),
(665, '/home/rigpdqdi/public_html/corble.ch/sketches/426/128/497.txt', 4, 497, 18, 1, 128),
(666, '/home/rigpdqdi/public_html/corble.ch/sketches/426/128/500.txt', 4, 500, 18, 2, 128),
(667, '/home/rigpdqdi/public_html/corble.ch/sketches/426/128/499.txt', 4, 499, 18, 0, 128),
(668, '/home/rigpdqdi/public_html/corble.ch/sketches/427/129/504.txt', 4, 504, 24, 0, 129),
(669, '/home/rigpdqdi/public_html/corble.ch/sketches/427/129/503.txt', 0, 503, 24, 1, 129),
(670, '/home/rigpdqdi/public_html/corble.ch/sketches/427/129/502.txt', 4, 502, 24, 2, 129),
(671, '/home/rigpdqdi/public_html/corble.ch/sketches/428/130/507.txt', 0, 507, 20, 1, 130),
(672, '/home/rigpdqdi/public_html/corble.ch/sketches/428/130/506.txt', 6, 506, 20, 2, 130),
(673, '/home/rigpdqdi/public_html/corble.ch/sketches/428/130/505.txt', 1, 505, 20, 0, 130);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_word`
--

CREATE TABLE `tbl_word` (
  `indx` int(11) NOT NULL,
  `primaryColor` varchar(15) NOT NULL,
  `secondaryColor` varchar(15) NOT NULL,
  `primaryColorRatio` decimal(10,0) NOT NULL,
  `secondaryColorRatio` decimal(10,0) NOT NULL,
  `word` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_word`
--

INSERT INTO `tbl_word` (`indx`, `primaryColor`, `secondaryColor`, `primaryColorRatio`, `secondaryColorRatio`, `word`) VALUES
(1, 'red', 'blue', '1', '1', 'Mackie Messer'),
(2, 'brown', 'white', '1', '0', 'Haus'),
(3, 'black', 'white', '0', '1', 'Fabrik'),
(4, 'grey', 'brown', '1', '1', 'Garage'),
(5, 'black', 'grey', '1', '0', 'Hochhaus'),
(6, 'brown', 'black', '1', '0', 'Scheune'),
(7, 'brown', 'black', '1', '0', 'Baer'),
(8, 'yellow', 'brown', '1', '0', 'Loewe'),
(9, 'grey', 'white', '1', '0', 'Elefant'),
(10, 'black', 'white', '1', '0', 'Panter'),
(11, 'white', 'black', '1', '0', 'Schwan'),
(12, 'green', 'black', '1', '0', 'Gurke'),
(13, 'yellow', 'brown', '1', '0', 'Banane'),
(14, 'brown', 'black', '1', '0', 'Wallnuss'),
(15, 'red', 'green', '1', '1', 'Apfel'),
(16, 'brown', 'green', '1', '0', 'Ananas'),
(17, 'green', 'brown', '1', '1', 'Palme'),
(18, 'red', 'green', '1', '0', 'Rose'),
(19, 'brown', 'green', '0', '1', 'Baum'),
(20, 'green', 'yellow', '1', '1', 'Loewenzahn'),
(21, 'brown', 'green', '1', '0', 'Tanne'),
(22, 'red', 'black', '1', '1', 'Velo'),
(23, 'yellow', 'black', '1', '0', 'Auto'),
(24, 'green', 'black', '1', '0', 'Traktor'),
(25, 'orange', 'black', '1', '1', 'Lastwagen'),
(26, 'white', 'black', '1', '0', 'Schiff');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_wordpool`
--

CREATE TABLE `tbl_wordpool` (
  `indx` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_wordpool`
--

INSERT INTO `tbl_wordpool` (`indx`, `name`) VALUES
(1, 'Gebaeude'),
(2, 'Tiere'),
(3, 'Pflanzen'),
(4, 'Lebensmittel'),
(6, 'Fahrzeuge');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_wordpool_word`
--

CREATE TABLE `tbl_wordpool_word` (
  `indx` int(11) NOT NULL,
  `fk_word_indx_wordpool_word` int(11) NOT NULL,
  `fk_wordpool_indx_wordpool_word` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_wordpool_word`
--

INSERT INTO `tbl_wordpool_word` (`indx`, `fk_word_indx_wordpool_word`, `fk_wordpool_indx_wordpool_word`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 5, 1),
(5, 6, 1),
(6, 7, 2),
(7, 8, 2),
(8, 9, 2),
(9, 10, 2),
(10, 11, 2),
(11, 12, 3),
(12, 13, 3),
(13, 14, 3),
(14, 15, 3),
(15, 16, 3),
(16, 17, 4),
(17, 18, 4),
(18, 19, 4),
(19, 20, 4),
(20, 21, 4),
(21, 22, 6),
(22, 23, 6),
(23, 24, 6),
(24, 25, 6),
(25, 26, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_game`
--
ALTER TABLE `tbl_game`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_lobby_indx_game` (`fk_lobby_indx_game`);

--
-- Indizes für die Tabelle `tbl_game_round`
--
ALTER TABLE `tbl_game_round`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_game_indx_game_round` (`fk_game_indx_game_round`),
  ADD KEY `fk_round_indx_game_round` (`fk_round_indx_game_round`);

--
-- Indizes für die Tabelle `tbl_lobby`
--
ALTER TABLE `tbl_lobby`
  ADD PRIMARY KEY (`indx`),
  ADD UNIQUE KEY `joincode` (`joincode`),
  ADD KEY `fk_player_indx_lobby` (`fk_player_indx_lobby`);

--
-- Indizes für die Tabelle `tbl_lobby_player`
--
ALTER TABLE `tbl_lobby_player`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_lobby_indx_Lobby_player` (`fk_lobby_indx_lobby_player`),
  ADD KEY `fk_player_indx_lobby_player` (`fk_player_indx_lobby_player`);

--
-- Indizes für die Tabelle `tbl_lobby_wordpool`
--
ALTER TABLE `tbl_lobby_wordpool`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_lobby_indx_lobby_wordpool` (`fk_lobby_indx_lobby_wordpool`),
  ADD KEY `fk_wordpool_indx_lobby_wordpool` (`fk_wordpool_indx_lobby_wordpool`);

--
-- Indizes für die Tabelle `tbl_player`
--
ALTER TABLE `tbl_player`
  ADD PRIMARY KEY (`indx`);

--
-- Indizes für die Tabelle `tbl_round`
--
ALTER TABLE `tbl_round`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_word_indx_round` (`fk_word_indx_round`);

--
-- Indizes für die Tabelle `tbl_round_sketch`
--
ALTER TABLE `tbl_round_sketch`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_sketch_indx_round_sketch` (`fk_sketch_indx_round_sketch`),
  ADD KEY `fk_round_indx_round_sketch` (`fk_round_indx_round_sketch`);

--
-- Indizes für die Tabelle `tbl_sketch`
--
ALTER TABLE `tbl_sketch`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_player_indx_sketch` (`fk_player_indx_sketch`),
  ADD KEY `fk_word_indx_sketch` (`fk_word_indx_sketch`);

--
-- Indizes für die Tabelle `tbl_word`
--
ALTER TABLE `tbl_word`
  ADD PRIMARY KEY (`indx`),
  ADD UNIQUE KEY `word` (`word`);

--
-- Indizes für die Tabelle `tbl_wordpool`
--
ALTER TABLE `tbl_wordpool`
  ADD PRIMARY KEY (`indx`);

--
-- Indizes für die Tabelle `tbl_wordpool_word`
--
ALTER TABLE `tbl_wordpool_word`
  ADD PRIMARY KEY (`indx`),
  ADD KEY `fk_word_indx_wordpool_word` (`fk_word_indx_wordpool_word`),
  ADD KEY `fk_wordpool_indx_wordpool_word` (`fk_wordpool_indx_wordpool_word`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_game`
--
ALTER TABLE `tbl_game`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_game_round`
--
ALTER TABLE `tbl_game_round`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_lobby`
--
ALTER TABLE `tbl_lobby`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT für Tabelle `tbl_lobby_player`
--
ALTER TABLE `tbl_lobby_player`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=508;

--
-- AUTO_INCREMENT für Tabelle `tbl_lobby_wordpool`
--
ALTER TABLE `tbl_lobby_wordpool`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

--
-- AUTO_INCREMENT für Tabelle `tbl_player`
--
ALTER TABLE `tbl_player`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=508;

--
-- AUTO_INCREMENT für Tabelle `tbl_round`
--
ALTER TABLE `tbl_round`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT für Tabelle `tbl_round_sketch`
--
ALTER TABLE `tbl_round_sketch`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT für Tabelle `tbl_sketch`
--
ALTER TABLE `tbl_sketch`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=674;

--
-- AUTO_INCREMENT für Tabelle `tbl_word`
--
ALTER TABLE `tbl_word`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT für Tabelle `tbl_wordpool`
--
ALTER TABLE `tbl_wordpool`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `tbl_wordpool_word`
--
ALTER TABLE `tbl_wordpool_word`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_game`
--
ALTER TABLE `tbl_game`
  ADD CONSTRAINT `fk_lobby_indx_game` FOREIGN KEY (`fk_lobby_indx_game`) REFERENCES `tbl_lobby` (`indx`);

--
-- Constraints der Tabelle `tbl_game_round`
--
ALTER TABLE `tbl_game_round`
  ADD CONSTRAINT `fk_game_indx_game_round` FOREIGN KEY (`fk_game_indx_game_round`) REFERENCES `tbl_game` (`indx`),
  ADD CONSTRAINT `fk_round_indx_game_round` FOREIGN KEY (`fk_round_indx_game_round`) REFERENCES `tbl_round` (`indx`);

--
-- Constraints der Tabelle `tbl_lobby`
--
ALTER TABLE `tbl_lobby`
  ADD CONSTRAINT `fk_player_indx_lobby` FOREIGN KEY (`fk_player_indx_lobby`) REFERENCES `tbl_player` (`indx`);

--
-- Constraints der Tabelle `tbl_lobby_player`
--
ALTER TABLE `tbl_lobby_player`
  ADD CONSTRAINT `fk_lobby_indx_Lobby_player` FOREIGN KEY (`fk_lobby_indx_lobby_player`) REFERENCES `tbl_lobby` (`indx`),
  ADD CONSTRAINT `fk_player_indx_lobby_player` FOREIGN KEY (`fk_player_indx_lobby_player`) REFERENCES `tbl_player` (`indx`);

--
-- Constraints der Tabelle `tbl_lobby_wordpool`
--
ALTER TABLE `tbl_lobby_wordpool`
  ADD CONSTRAINT `fk_lobby_indx_lobby_wordpool` FOREIGN KEY (`fk_lobby_indx_lobby_wordpool`) REFERENCES `tbl_lobby` (`indx`),
  ADD CONSTRAINT `fk_wordpool_indx_lobby_wordpool` FOREIGN KEY (`fk_wordpool_indx_lobby_wordpool`) REFERENCES `tbl_wordpool` (`indx`);

--
-- Constraints der Tabelle `tbl_round`
--
ALTER TABLE `tbl_round`
  ADD CONSTRAINT `fk_word_indx_round` FOREIGN KEY (`fk_word_indx_round`) REFERENCES `tbl_word` (`indx`);

--
-- Constraints der Tabelle `tbl_round_sketch`
--
ALTER TABLE `tbl_round_sketch`
  ADD CONSTRAINT `fk_round_indx_round_sketch` FOREIGN KEY (`fk_round_indx_round_sketch`) REFERENCES `tbl_round` (`indx`),
  ADD CONSTRAINT `fk_sketch_indx_round_sketch` FOREIGN KEY (`fk_sketch_indx_round_sketch`) REFERENCES `tbl_sketch` (`indx`);

--
-- Constraints der Tabelle `tbl_sketch`
--
ALTER TABLE `tbl_sketch`
  ADD CONSTRAINT `fk_player_indx_sketch` FOREIGN KEY (`fk_player_indx_sketch`) REFERENCES `tbl_player` (`indx`),
  ADD CONSTRAINT `fk_word_indx_sketch` FOREIGN KEY (`fk_word_indx_sketch`) REFERENCES `tbl_word` (`indx`);

--
-- Constraints der Tabelle `tbl_wordpool_word`
--
ALTER TABLE `tbl_wordpool_word`
  ADD CONSTRAINT `fk_word_indx_wordpool_word` FOREIGN KEY (`fk_word_indx_wordpool_word`) REFERENCES `tbl_word` (`indx`),
  ADD CONSTRAINT `fk_wordpool_indx_wordpool_word` FOREIGN KEY (`fk_wordpool_indx_wordpool_word`) REFERENCES `tbl_wordpool` (`indx`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
