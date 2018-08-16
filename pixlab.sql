-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Sie 2018, 14:26
-- Wersja serwera: 5.7.14
-- Wersja PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pixlab`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zawodnicy`
--

CREATE TABLE `zawodnicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(128) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `punkty` int(11) NOT NULL,
  `ile_meczy` int(11) NOT NULL COMMENT 'ilość rozegranych meczy w sezonie',
  `ranking` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `zawodnicy`
--

INSERT INTO `zawodnicy` (`id`, `nazwa`, `punkty`, `ile_meczy`, `ranking`) VALUES
(1, 'Adam', 1, 3, -1),
(2, 'Bartek', 3, 3, 3),
(3, 'Czarek', 1, 3, -1),
(4, 'Darek', 1, 3, -1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zawody`
--

CREATE TABLE `zawody` (
  `id` int(11) NOT NULL,
  `druzyny` varchar(256) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `wynik` varchar(9) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `sezon` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `zawody`
--

INSERT INTO `zawody` (`id`, `druzyny`, `wynik`, `sezon`) VALUES
(4, '1,2,3,4', '1:0', 2),
(5, '1,3,2,4', '0:2', 2),
(6, '1,4,2,3', '2:4', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `zawodnicy`
--
ALTER TABLE `zawodnicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zawody`
--
ALTER TABLE `zawody`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `zawodnicy`
--
ALTER TABLE `zawodnicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `zawody`
--
ALTER TABLE `zawody`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
