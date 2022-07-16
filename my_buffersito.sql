-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 16, 2018 alle 23:09
-- Versione del server: 10.1.28-MariaDB
-- Versione PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_buffersito`
--
CREATE DATABASE IF NOT EXISTS `my_buffersito` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `my_buffersito`;

-- --------------------------------------------------------

--
-- Struttura della tabella `orari`
--

CREATE TABLE `orari` (
  `ID` int(11) NOT NULL,
  `IDpiz` int(11) NOT NULL,
  `orario` varchar(5) NOT NULL,
  `monday` varchar(20) NOT NULL,
  `tuesday` varchar(20) NOT NULL,
  `wednesday` varchar(20) NOT NULL,
  `thursday` varchar(20) NOT NULL,
  `friday` varchar(20) NOT NULL,
  `saturday` varchar(20) NOT NULL,
  `sunday` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `orari`
--

INSERT INTO `orari` (`ID`, `IDpiz`, `orario`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(2, 12, 'cn', ' chiuso-chiuso', '18:30-00:00', '18:30-00:00', '18:30-00:00', '18:30-01:30', '18:30-01:30', '18:30-01:30'),
(3, 12, 'pr', ' chiuso-chiuso', 'chiuso-chiuso', 'chiuso-chiuso', 'chiuso-chiuso', 'chiuso-chiuso', 'chiuso-chiuso', 'chiuso-chiuso');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordini`
--

CREATE TABLE `ordini` (
  `ID` int(11) NOT NULL,
  `nomePiz` varchar(200) NOT NULL,
  `orario` time NOT NULL,
  `prezzoTot` int(11) NOT NULL,
  `IDpiz` int(11) NOT NULL,
  `IDuser` int(11) NOT NULL,
  `telUser` bigint(20) NOT NULL,
  `tavolo` int(11) DEFAULT NULL,
  `via` varchar(30) DEFAULT NULL,
  `numCivico` int(11) DEFAULT NULL,
  `CAP` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `ordini`
--

INSERT INTO `ordini` (`ID`, `nomePiz`, `orario`, `prezzoTot`, `IDpiz`, `IDuser`, `telUser`, `tavolo`, `via`, `numCivico`, `CAP`, `status`) VALUES
(56, '4-Marinara||5-Capricciosa||3-Prosciutto||1-Prosciutto e Funghi||2-Porcini||1-Bufala||3-Tedesca||1-Panna e Crudo||2-Boscaiola||2-Napoli||', '21:56:00', 212, 12, 1, 2147483647, 0, '-', 0, 0, 'waiting'),
(57, '20-Panna e Crudo||', '22:27:00', 240, 12, 1, 2147483647, 0, '-', 0, 0, 'waiting'),
(58, '2-americana||', '23:26:00', 24, 12, 1, 2147483647, 2, '-', 0, 0, 'waiting'),
(59, '3-americana||', '23:23:00', 36, 12, 1, 2147483647, 0, '-', 0, 0, 'waiting'),
(60, '4-americana||', '23:23:00', 48, 12, 1, 2147483647, 0, '-', 0, 0, 'waiting'),
(61, '4-americana||', '23:24:00', 48, 12, 1, 2147483647, 0, '-', 0, 0, 'waiting');

-- --------------------------------------------------------

--
-- Struttura della tabella `pizze`
--

CREATE TABLE `pizze` (
  `IDpizza` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `ingredienti` varchar(60) NOT NULL,
  `prezzo` int(11) NOT NULL,
  `IDpiz` int(11) NOT NULL,
  `bought` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `pizze`
--

INSERT INTO `pizze` (`IDpizza`, `nome`, `ingredienti`, `prezzo`, `IDpiz`, `bought`) VALUES
(26, 'americana', 'patatine', 12, 12, 20),
(33, 'margherita', 'pomodoro, mozzarella', 7, 12, 8),
(34, 'Marinara', 'Pomodoro, Origano, Aglio', 7, 12, 4),
(35, 'Capricciosa', 'Pomodoro, Mozzarella, Prosciutto, Funghi, Carciof', 8, 12, 5),
(36, 'Prosciutto', 'Pomodoro, Mozzarella, Prosciutto', 8, 12, 3),
(37, 'Prosciutto e Funghi', 'Pomodoro, Mozzarella, Prosciutto, Funghi', 9, 12, 1),
(38, 'Porcini', 'Pomodoro, Mozzarella, Funghi Porcini', 7, 12, 2),
(39, 'Bufala', 'Pomodoro, Mozzarella di Bufala, Origano', 10, 12, 1),
(40, 'Tedesca', 'Pomodoro, Mozzarella, Patatine Fritte, Wurstel', 11, 12, 3),
(42, 'Panna e Crudo', 'Pomodoro, Mozzarella, Panne, Crudo', 12, 12, 21),
(43, 'Boscaiola', 'Pomodoro, Mozzarella, Porcini, Scaglie di Grana, Rucola', 12, 12, 2),
(44, 'Napoli', 'Pomodoro, Mozzarella, Acciughe, Origano', 9, 12, 2),
(45, 'margherita', 'pomorodo,mozzarella', 7, 29, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `pizzerie`
--

CREATE TABLE `pizzerie` (
  `nome` varchar(30) NOT NULL,
  `via` varchar(30) NOT NULL,
  `numCivico` int(11) NOT NULL,
  `CAP` int(11) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `iva` int(10) NOT NULL,
  `IDpiz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `pizzerie`
--

INSERT INTO `pizzerie` (`nome`, `via`, `numCivico`, `CAP`, `telefono`, `email`, `password`, `iva`, `IDpiz`) VALUES
('San Remo', 'Pastore', 70, 31029, '0438940164', 'sanremo@sanremo', '329e939f24e60359e9d810c98916ee96eae890ae0ac70c1705f14ddeda6922de7559012aa1d950e431f0487447f8c29d37e5dd08cc9fb7b396b3e5762ad0ad08', 2221111, 12),
('Capolinea', 'Del lavoro', 6, 31015, '043821487', 'capolinea@capolinea', '7a1db2c74f598115e742aa5a6306a913f2d9cff5e1ad58377b25012279f22c3840c7d8a757315f558179ff29d74d0a5ff6b64d04c340d31f851bcd44fb135d2e', 15968452, 29),
('Margherita', 'GiosuÃ¨ carducci', 22, 31029, '0438173666', 'margherita@margherita', '7d06ac0a11990fd476fb7fb4d7973ba22462d48e0a4c229b2177e9176e06e88bc3948df2cceca3315386b4011c11e619a5970c278cdeaaa7cd0758cc59839e68', 258964, 30),
('Al 128', 'Roma', 128, 31029, '0438556847', '128@128', 'e2bc8ca53e630757ef4a3e8f3d0fc48aac10a66dbe6d14d759d00c21263f4c0623f6841dc3995081f97eff9641ea9be42c9219f66e6c5b9ea9effa1c8450c3fb', 128935, 31),
('gennaro', 'Dante Alighieri,', 3, 31029, '043853376', 'gennaro@gennaro', 'd6fcb05dc56a83e3048510c13f88d7c10a4ef9e7a69af23c69d1f7e7d668a853d707a7da8ced66235a5d470c55fd8d6c7c486c10e44072bcc0c96c8cc887961d', 45263, 32),
('Cal de Livera', 'Cal de Livera', 30, 31029, '0438500556', 'calde@calde', 'b5c5e62d7c367795be4a8fa4c7c3aa2877151db1f9923e559558ac1629f9fb3751444988df044675ca254c17e01b9401c00e6394ccf698802c1b734960eadc03', 4759623, 33),
('Da Fausta Pizzeria dal 1957', 'Via Portico Oscuro', 10, 31100, '0422543739', 'dafausta@dafausta', '3805cde09a4741dedc44bb856d2329e6c37eb0644e500373e191291bf19ff5e8fce65603188a32c0d6164030f55c8e6738a17b2ed5c0906dc915298234ad37f6', 2147483647, 34),
('daPino', 'Piazza dei Signori,', 23, 31100, '042256426', 'dapino@dapino', '1837f6dd9b18d5792d6f377371de95b79351a031467b7a6cf242b2e136f4681e05ae39356a336f84d7bf97b6e1adde720e46097513afdd8289c483f1771f6ec4', 298872, 35);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`ID`, `nome`, `cognome`, `telefono`, `email`, `password`) VALUES
(1, 'alberto', 'morini', '3456945815', 'a@a', '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `orari`
--
ALTER TABLE `orari`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDpiz` (`IDpiz`);

--
-- Indici per le tabelle `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDpiz` (`IDpiz`),
  ADD KEY `IDuser` (`IDuser`);

--
-- Indici per le tabelle `pizze`
--
ALTER TABLE `pizze`
  ADD PRIMARY KEY (`IDpizza`),
  ADD KEY `IDpiz` (`IDpiz`);

--
-- Indici per le tabelle `pizzerie`
--
ALTER TABLE `pizzerie`
  ADD PRIMARY KEY (`IDpiz`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `orari`
--
ALTER TABLE `orari`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `ordini`
--
ALTER TABLE `ordini`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT per la tabella `pizze`
--
ALTER TABLE `pizze`
  MODIFY `IDpizza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT per la tabella `pizzerie`
--
ALTER TABLE `pizzerie`
  MODIFY `IDpiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `orari`
--
ALTER TABLE `orari`
  ADD CONSTRAINT `orari_ibfk_1` FOREIGN KEY (`IDpiz`) REFERENCES `pizzerie` (`IDpiz`);

--
-- Limiti per la tabella `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`IDpiz`) REFERENCES `pizzerie` (`IDpiz`),
  ADD CONSTRAINT `ordini_ibfk_2` FOREIGN KEY (`IDuser`) REFERENCES `user` (`ID`);

--
-- Limiti per la tabella `pizze`
--
ALTER TABLE `pizze`
  ADD CONSTRAINT `pizze_ibfk_1` FOREIGN KEY (`IDpiz`) REFERENCES `pizzerie` (`IDpiz`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
