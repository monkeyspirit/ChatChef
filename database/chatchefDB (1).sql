-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 24, 2020 alle 18:11
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatchefDB`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `picture_path` text NOT NULL,
  `recipe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `picture`
--

INSERT INTO `picture` (`id`, `picture_path`, `recipe_id`) VALUES
(1, 'upload/1/16876_focaccia_strip_1-3.webp', NULL),
(2, 'upload_cover/1/focaccia-rosmarino.jpg', 1),
(3, 'upload_cover/1/focaccia-3-683x1024.jpg', 1),
(4, 'upload/1/16876_focaccia_strip_4-6.webp', NULL),
(5, 'upload/1/16876_focaccia_strip_7-9.webp', NULL),
(6, 'upload/1/16876_focaccia_strip_10-12.webp', NULL),
(7, 'upload/1/16876_focaccia_strip_13-15.webp', NULL),
(8, 'upload/2/1823_fette_al_latte_new_strip_1-3.webp', NULL),
(9, 'upload_cover/2/fetta-al-latte-fatte-in-casa.jpg', 2),
(10, 'upload_cover/2/kinder-fetta-al-latte.jpg', 2),
(11, 'upload_cover/2/download.jpeg', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `preparation_time` varchar(250) NOT NULL,
  `cooking_time` varchar(250) NOT NULL,
  `difficult` varchar(250) NOT NULL,
  `doses` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `ingredients_name` text NOT NULL,
  `ingredients_quantity` text NOT NULL,
  `steps_text` text NOT NULL,
  `steps_image` text NOT NULL,
  `tags` text NOT NULL,
  `approved` int(11) NOT NULL,
  `comment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recipe`
--

INSERT INTO `recipe` (`id`, `title`, `description`, `preparation_time`, `cooking_time`, `difficult`, `doses`, `user_id`, `date`, `ingredients_name`, `ingredients_quantity`, `steps_text`, `steps_image`, `tags`, `approved`, `comment`) VALUES
(1, 'Focaccia', 'Chiamatela schiacciata, ciaccia, street food all’italiana o ricetta antica come il mondo ma sarà sempre lei, la sola ed inimitabile focaccia!', '35 min', '40 min', 'Media', '4 persone', 1, '2020-09-24', '_Farina 0_Zucchero_Latte intero_Sale fino', '_470_16_115_12/_2_2_2_2', '_Per preparare la focaccia cominciate mescolando insieme in una ciotolina il lievito con lo zucchero 1 e andate a versarlo, insieme alla farina, nella tazza di una planetaria munita di foglia 2. Azionate la planetaria e versate a filo latte e acqua che avrete mescolato insieme 3._Poi unite l’olio, anche questo a filo 4. Continuate ad impastare fino a quando non notate che l’impasto avrà preso un po’ di consistenza, perciò sostituite la foglia 5 con il gancio 6._Versate il sale 7 e continuate ad impastare per circa 15 minuti 8 fin quando l’impasto non sarà ben incordato: l’impasto è molto idratato quindi aiutatevi con un tarocco per staccarlo dal gancio 9._Trasferite il composto sul piano da lavoro leggermente infarinato sempre aiutandovi con il tarocco 10 e sempre con quest\'ultimo date un paio di pieghe, cioè sollevate un lembo 11 e portatelo al centro 12. Poi sollevate l’altra estremità e portate anche questa nel mezzo e ripetete una volta ancora._Trasferite il composto in una ciotola 13 e coprite con pellicola trasparente. Riponete la ciotola in forno spento con luce accesa e lasciate lievitare per 2 ore o comunque fine al raddoppio 14. Ungete una teglia (noi abbiamo usato una teglia rettangolare 35x28 cm) spennellando accuratamente tutta la superficie e lungo i bordi 15,', '_1_4_5_6_7', '_8_4', 3, NULL),
(2, 'Fetta al latte', 'Le fette di cacao al latte sono delle golosissime merendine fatte in casa composte da due soffici strati di pasta biscotto al cacao e poi farciti con una gustosa e vellutata crema al latte.', ' 40 min', ' 12 min', 'Media', '10 pezzi', 1, '2020-09-24', '_Cacao amaro in polvere_Uova_Farina 00_Miele_Zucchero_Baccello di vaniglia', '_25_4_35_10_80_0.5/_2_3_2_2_2_3', '_Per preparare le fette di cacao al latte, iniziate con la preparazione della crema al latte: mettete in ammollo la gelatina in fogli in acqua fredda per almeno 10 minuti 1. Montate 300 g di panna fresca liquida con le fruste elettriche 2. In un\'altra ciotolina versate il latte condensato a temperatura ambiente. Unite l\'estratto di vaniglia e il miele e mescolate 3.', '_8', '_3', 3, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `birthday` date NOT NULL,
  `favorites` text,
  `role` int(11) NOT NULL,
  `ban` int(11) NOT NULL,
  `image_profile` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `birthday`, `favorites`, `role`, `ban`, `image_profile`) VALUES
(1, 'maria', 'Maria', 'Saleri', 'marias.pubb@gmail.com', '9c5530bc03b828f7257b46fcefe44cac', '1997-05-06', NULL, 1, 0, 'user_profile/1/paw.jpg'),
(2, 'Culooooo', 'Claudio', 'Questo username non ce l\'ha nessuno scommetto', 'claudiocito@libero.it', '8c6c9c47f01fe37d5084daf2b3e88e64', '2020-09-24', NULL, 0, 0, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
