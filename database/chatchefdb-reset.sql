-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2020 at 06:11 PM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatchefdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `date` date NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `comment`
--

TRUNCATE TABLE `comment`;
--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `recipe_id`, `date`, `text`) VALUES
(1, 1, 2, '2020-09-24', 'Wiiii'),
(2, 2, 5, '2020-09-28', 'Buonissimi!'),
(3, 2, 5, '2020-10-31', 'porvolone'),
(5, 12, 41, '2020-12-10', 'Odio tutti i romani!');

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `id` int NOT NULL,
  `picture_path` text NOT NULL,
  `recipe_id` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `picture`
--

TRUNCATE TABLE `picture`;
--
-- Dumping data for table `picture`
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
(12, 'upload/3/gamberi.jpg', NULL),
(13, 'upload/3/impasto.jpg', NULL),
(14, 'upload/3/ravioli-di-carne-al-vapore.jpg', NULL),
(15, 'upload/3/raviolii.jpg', NULL),
(16, 'upload_cover/3/ravioli.jpg', 3),
(17, 'upload_cover/3/raviolicinesi.jpg', 3),
(18, 'upload_cover/3/ravioli-cinesi-di-carne-al-vapore.jpg', 3),
(19, 'upload_cover/3/ravioliyummy.jpg', 3),
(20, 'upload/4/biscottoo.jpg', NULL),
(21, 'upload/4/crema-di-edgar.jpg', NULL),
(22, 'upload/4/edgar.jpg', NULL),
(23, 'upload_cover/4/groviera.jpg', 4),
(24, 'upload/5/la-cottura-ingredienti-uova-farina-zucchero-burro-lievito-sfondo-alimentare-e7ff7n.jpg', NULL),
(25, 'upload/5/maxresdefault.jpg', NULL),
(26, 'upload/5/pasta-frolla-per-biscotti-di-natale.jpg', NULL),
(27, 'upload/5/download.jpeg', NULL),
(28, 'upload/5/Biscotti-pasta-frolla-con-olio.webp', NULL),
(29, 'upload/5/download (1).jpeg', NULL),
(30, 'upload/5/illuminati-movies-alice-in-wonderland-cartoon-eat-me.jpg', NULL),
(31, 'upload_cover/5/biscotti-alice-disney.jpg', 5),
(32, 'upload_cover/3/78A2BD7D-BDB2-4A18-ABEF-735460E9D621.jpeg', 3),
(34, 'upload/6/21991.jpg', NULL),
(35, 'upload_cover/6/21991.jpg', 6),
(36, 'upload/7/Screenshot (4).png', NULL),
(37, 'upload_cover/7/Screenshot (4).png', 7),
(38, 'upload/8/photo_2020-10-28_12-03-08.jpg', NULL),
(39, 'upload_cover/8/photo_2020-10-28_12-03-07.jpg', 8),
(40, 'upload/9/parmigiana-di-melanzane-9.jpg', NULL),
(41, 'upload_cover/9/parmigiana-di-melanzane-9.jpg', 9),
(42, 'upload/10/parmigiana-di-melanzane-9.jpg', NULL),
(43, 'upload_cover/10/parmigiana-di-melanzane-9.jpg', 10),
(44, 'upload/11/IMG_20201003_172757.jpg', NULL),
(45, 'upload_cover/11/IMG_20201003_172757.jpg', 11),
(46, 'upload/12/IMG_20201003_172757.jpg', NULL),
(47, 'upload/13/IMG_20201003_172757.jpg', NULL),
(48, 'upload_cover/13/IMG_20201003_172757.jpg', 13),
(49, 'upload/14/IMG_20201003_172752.jpg', NULL),
(50, 'upload/15/IMG_20201003_172752.jpg', NULL),
(51, 'upload/16/IMG_20201003_172757.jpg', NULL),
(102, 'image/default_cover.jpg', 29),
(101, 'image/default_step_image/6.jpg', NULL),
(100, 'image/default_step_image/2.jpg', NULL),
(99, 'upload_cover/27/wgyn6dsk9ee51.jpg', 27),
(98, 'image/default_step_image/4.jpg', NULL),
(97, 'image/default_step_image/3.jpg', NULL),
(96, 'image/default_cover.jpg', 26),
(95, 'image/default_cover.jpg', 26),
(94, 'image/default_step_image/6.jpg', NULL),
(93, 'upload/26/IMG_20201003_172757.jpg', NULL),
(92, 'image/default_step_image/5.jpg', NULL),
(91, 'image/default_step_image/5.jpg', NULL),
(90, 'image/default_step_image/2.jpg', NULL),
(89, 'upload_cover/25/', 25),
(88, 'upload_cover/25/IMG_20201003_172757.jpg', 25),
(87, 'upload_cover/25/', 25),
(86, 'image/default_step_image/6.jpg', NULL),
(85, 'upload/25/IMG_20201003_172757.jpg', NULL),
(103, 'image/default_step_image/5.jpg', NULL),
(104, 'image/default_cover.jpg', 30),
(105, 'image/default_step_image/2.jpg', NULL),
(106, 'image/default_cover.jpg', 31),
(107, 'image/default_step_image/1.jpg', NULL),
(108, 'image/default_step_image/1.jpg', NULL),
(109, 'upload/32/IMG_20201003_172757.jpg', NULL),
(110, 'image/default_cover.jpg', 32),
(111, 'image/default_step_image/1.jpg', NULL),
(112, 'image/default_cover.jpg', 33),
(113, 'image/default_step_image/2.jpg', NULL),
(114, 'image/default_cover.jpg', 34),
(133, 'upload/35/IMG_20201003_172757.jpg', NULL),
(120, 'image/default_cover.jpg', 35),
(118, 'image/default_step_image/6.jpg', NULL),
(119, 'image/default_step_image/6.jpg', NULL),
(121, 'image/default_step_image/4.jpg', NULL),
(132, 'image/default_step_image/2.jpg', NULL),
(125, 'image/default_cover.jpg', 35),
(131, 'image/default_step_image/5.jpg', NULL),
(135, 'image/default_cover.jpg', 36),
(138, 'upload/37/bloody-mary-ricetta-03GNAMBOX.jpg', NULL),
(150, 'upload/37/bloody-mary-ricetta-03GNAMBOX.jpg', NULL),
(139, 'upload/37/bloody-mary-ricetta-01-1024x682GNAMBOXCOM.jpg', NULL),
(140, 'upload/37/bloody-mary-ricetta-02GNAMBOX.jpg', NULL),
(141, 'image/default_step_image/6.jpg', NULL),
(142, 'upload/37/757-bloody-mary-ricetta-mixing-glass-come-fare-il-cocktail-bloody-mary-casaWINEDHARMACOM.jpg', NULL),
(143, 'upload/37/bloodymary4smpost-imageGIALLOZAFFERANO.jpg', NULL),
(145, 'upload/37/bloody-mary-ricetta-01-1024x682GNAMBOXCOM.jpg', NULL),
(146, 'upload/37/bloody-mary-ricetta-02GNAMBOX.jpg', NULL),
(147, 'image/default_step_image/1.jpg', NULL),
(148, 'upload/37/bmWINEDHARMACOM.jpg', NULL),
(149, 'upload/37/bmGIALLOZAFFERANO.jpg', NULL),
(151, 'upload/37/bloody-mary-ricetta-01-1024x682GNAMBOXCOM.jpg', NULL),
(152, 'upload/37/bloody-mary-ricetta-02GNAMBOX.jpg', NULL),
(153, 'image/default_step_image/2.jpg', NULL),
(154, 'upload/37/bmWINEDHARMACOM.jpg', NULL),
(155, 'upload/37/bmGIALLOZAFFERANO.jpg', NULL),
(156, 'upload/37/japanese_jigger_fullAWESOMEDRINKSCOM.jpg', NULL),
(157, 'upload/38/cooking_man.jpg', NULL),
(158, 'upload_cover/38/cooking_woman.jpg', 38),
(190, 'upload/39/throwing.jpg', NULL),
(192, 'upload_cover/39/bm.png', 39),
(189, 'upload/39/shaker.jpg', NULL),
(188, 'upload/39/NeutralSaltPepperGrinderS2SHF16.jfif', NULL),
(187, 'upload/39/SH_salsa_Worcester.jpg', NULL),
(186, 'upload/39/8489b319d61e99e84d10bd111a3e3e02.jpg', NULL),
(167, 'image/default_step_image/2.jpg', NULL),
(168, 'image/default_step_image/4.jpg', NULL),
(169, 'upload_cover/40/frappè-cioccolato.jpg', 40),
(170, 'image/default_step_image/3.jpg', NULL),
(171, 'image/default_step_image/1.jpg', NULL),
(172, 'image/default_step_image/2.jpg', NULL),
(173, 'image/default_step_image/3.jpg', NULL),
(174, 'image/default_step_image/6.jpg', NULL),
(175, 'upload_cover/41/gnocchi-alla-romana.jpg', 41),
(176, 'upload_cover/41/gnocchi-romana-copertina.jpg', 41),
(177, 'image/default_step_image/4.jpg', NULL),
(178, 'image/default_step_image/5.jpg', NULL),
(179, 'image/default_step_image/5.jpg', NULL),
(180, 'image/default_step_image/3.jpg', NULL),
(181, 'image/default_step_image/2.jpg', NULL),
(182, 'image/default_step_image/6.jpg', NULL),
(183, 'upload_cover/42/SH_costine_di_maiale.jpg', 42),
(184, 'upload_cover/42/costine-di-maiale-alla-griglia-in-salsa-barbecue-bbq-ribs.jpg', 42),
(185, 'upload_cover/42/Costine-di-maiale-al-forno-marinatura-speciale.jpg', 42),
(191, 'upload/39/bmGIALLOZAFFERANO.jpg', NULL),
(193, 'upload/43/Orso.jpg', NULL),
(194, 'upload/43/orso-m29.jpg', NULL),
(195, 'upload/43/0004E574-un-orso-che-dorme.jpg', NULL),
(196, 'upload/43/gnam.jpg', NULL),
(197, 'upload_cover/43/salmon.jpg', 43),
(199, 'upload_cover/39/queen-mary-i.jpg', 39),
(200, 'upload_cover/39/Pic_ Homemade.jpg', 39),
(201, 'upload_cover/39/images.jfif', 39),
(202, 'upload/44/ingredienti.jpg', NULL),
(203, 'upload/44/frusta.jpg', NULL),
(204, 'upload/44/crepes.jpg', NULL),
(205, 'upload/44/strawberry-dorayaki.jpg', NULL),
(206, 'upload_cover/44/Dorayaki-salati.jpg', 44),
(207, 'upload_cover/44/Dorayaki.jpg', 44),
(208, 'upload_cover/44/doriyaki2-s.jpg', 44);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `preparation_time` varchar(250) NOT NULL,
  `cooking_time` varchar(250) NOT NULL,
  `difficult` varchar(250) NOT NULL,
  `doses` varchar(250) NOT NULL,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `ingredients_name` text NOT NULL,
  `ingredients_quantity` text NOT NULL,
  `steps_text` text NOT NULL,
  `steps_image` text NOT NULL,
  `tags` text NOT NULL,
  `approved` int NOT NULL,
  `comment` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `recipe`
--

TRUNCATE TABLE `recipe`;
--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `title`, `description`, `preparation_time`, `cooking_time`, `difficult`, `doses`, `user_id`, `date`, `ingredients_name`, `ingredients_quantity`, `steps_text`, `steps_image`, `tags`, `approved`, `comment`) VALUES
(1, 'Focaccia Genovese', 'Chiamatela schiacciata, ciaccia, street food all’italiana o ricetta antica come il mondo ma sarà sempre lei, la sola ed inimitabile focaccia!', '35 ', '40 ', '2', '4 ', 1, '2020-09-24', '_Farina 0_Zucchero_Latte intero_Sale fino', '_470_16_115_12/_2_2_2_2', '_Per preparare la focaccia cominciate mescolando insieme in una ciotolina il lievito con lo zucchero 1 e andate a versarlo, insieme alla farina, nella tazza di una planetaria munita di foglia 2. Azionate la planetaria e versate a filo latte e acqua che avrete mescolato insieme 3._Poi unite l’olio, anche questo a filo 4. Continuate ad impastare fino a quando non notate che l’impasto avrà preso un po’ di consistenza, perciò sostituite la foglia 5 con il gancio 6._Versate il sale 7 e continuate ad impastare per circa 15 minuti 8 fin quando l’impasto non sarà ben incordato: l’impasto è molto idratato quindi aiutatevi con un tarocco per staccarlo dal gancio 9._Trasferite il composto sul piano da lavoro leggermente infarinato sempre aiutandovi con il tarocco 10 e sempre con quest\'ultimo date un paio di pieghe, cioè sollevate un lembo 11 e portatelo al centro 12. Poi sollevate l’altra estremità e portate anche questa nel mezzo e ripetete una volta ancora._Trasferite il composto in una ciotola 13 e coprite con pellicola trasparente. Riponete la ciotola in forno spento con luce accesa e lasciate lievitare per 2 ore o comunque fine al raddoppio 14. Ungete una teglia (noi abbiamo usato una teglia rettangolare 35x28 cm) spennellando accuratamente tutta la superficie e lungo i bordi 15,', '_1_4_5_6_7', '_8_4', 0, NULL),
(2, 'Fetta al latte', 'Le fette di cacao al latte sono delle golosissime merendine fatte in casa composte da due soffici strati di pasta biscotto al cacao e poi farciti con una gustosa e vellutata crema al latte.', '5', '10', '1', '2', 1, '2020-09-24', '_Cacao amaro in polvere_Uova_Farina 00_Miele_Zucchero_Baccello di vaniglia', '_25_4_35_10_80_0.5/_2_3_2_2_2_3', '_Per preparare le fette di cacao al latte, iniziate con la preparazione della crema al latte: mettete in ammollo la gelatina in fogli in acqua fredda per almeno 10 minuti 1. Montate 300 g di panna fresca liquida con le fruste elettriche 2. In un\'altra ciotolina versate il latte condensato a temperatura ambiente. Unite l\'estratto di vaniglia e il miele e mescolate 3.', '_8', '_3', 3, NULL),
(3, 'Ravioli cinesi al vapore', 'I ravioli cinesi al vapore (Jiaozi) sono delicati involucri di pasta con un ripieno di carne e verdure, diffusi in tutta la Cina e molto popolari nelle loro varianti anche in Giappone e in Corea.', '40 ', ' 15 ', '2', '6 ', 1, '2020-09-25', '_Pazienza_Ravioli', '_100_4/_2_3', '_1_2_3_4', '_12_13_14_15', '_1_4', 2, NULL),
(4, 'Crème de la crème à la Edgar', 'La ricetta della crema gustata dagli Aristogatti e dal signor Groviera… ma senza il sonnifero!', '5 ', '10  ', '1', '6 ', 1, '2020-09-25', '_Latte_Tuorli_Zucchero_Farina_Bacca di vaniglia', '_500_2_3_1_0.5/_1_4_3_3_4', '_Versate i due tuorli all’interno di una ciotola. Unite lo zucchero e mescolate bene con una forchetta fino ad ottenere un composto omogeneo di colore chiaro. Unite anche la farina e, se necessario, aggiungete poco latte per farla sciogliere bene evitando la formazione di grumi._Nel frattempo versate il latte in un pentolino insieme alla bacca di vaniglia ed accendete la fiamma. Dovrà scaldarsi bene. Una volta caldo, eliminate la bacca di vaniglia e unitelo a filo e continuando a mescolare nella ciotola contenente i tuorli._Una volta incorporatolo tutto, trasferitelo nella pentola e rimettetelo nuovamente sulla fiamma. Fate addensare leggermente mescolando fino a quando otterrete una crema fluida e profumata.', '_20_21_22', '_3', 3, NULL),
(5, 'Biscotti magici', 'Perfetti per una festa di compleanno o una merenda golosa, ecco come preparare in casa i biscotti magici di Alice nel Paese delle meraviglie. ', '0', '0', '1', '0', 1, '2020-09-25', '_Farina 00_Burro_Zucchero_Uova_Sale_Zucchero a velo_Acqua', '_2500_125_125_1_1_100_1/_2_2_2_3_3_2_3', '_Versate in una ciotola la farina 00 e create, al centro, una fontana. Unite il burro morbido a cubetti ed iniziate a farlo sciogliere al suo interno con la punta delle dita._Adesso aggiungete anche lo zucchero, l’uovo ed il sale. Impastate bene ma brevemente su una spianatoia fino ad ottenere un impasto sodo ed omogeneo._Create una palla, avvolgetela nella pellicola trasparente e fatela riposare in frigorifero per mezz\'ora._Dopo il riposo in frigo, riprendete la pasta e stendetela con un mattarello sul piano di lavoro leggermente infarinato. Ricavate i biscotti con gli appositi stampini e poneteli su una teglia rivestita di carta forno._Trasferiteli in forno caldo a 180 °C per circa 10-12 minuti. Tirateli fuori dal forno e fateli intiepidire._Nel frattempo preparate la glassa mescolando lo zucchero a velo con pochissima acqua ed il colorante alimentare in modo da ottenere un composto molto denso._Trasferite la glassa in un conetto di carta forno e, con cura, decorate i biscotti disegnando la scritta “mangiami”. Fate rassodare la glassa per circa un’ora, quindi servite i biscotti.', '_24_25_26_27_28_29_30', '_3', 3, NULL),
(9, 'La parmegganaa @#@#', 'è la pargimgiana', '1', '10000', '1', '5 ', 7, '2020-11-20', '_melanzane', '_1000/_2', '_Fai la parmigiana e basta', '_40', '_1', 0, NULL),
(40, 'Frappè al cioccolato', 'Una merenda davvero buonissima veloce e super facilissima da preparare ora che sta arrivando il caldo (si spera) è il frappè al cioccolato ma potete prepararlo quando volete a dire il vero…', '5', '0', '1', '2', 1, '2020-12-10', '_Gelato al cioccolato_Latte_Cubetti di ghiaccio', '_100_200_4/_2_1_4', '_Girate un pochino il gelato con un cucchiaio in modo da renderlo cremoso poi mettetelo nel bicchiere del frullatore insieme ai cubetti di ghiaccio rotti (potete romperti mettendoli in una mano e battendoli con un cucchiaio) e il latte e frullate per qualche secondo fino a che sarà ben amalgamato._Servite il frappè al cioccolato con gelato con un pochino di cioccolato in scaglie.\r\n\r\n', '_167_168', '_3_8', 3, NULL),
(39, 'Bloody Mary', 'Un cocktail eterno a base di vodka, succo di pomodoro e spezie piccanti od aromi come la salsa Worcestershire ed il tabasco.\r\nQuasi certamente creato da George Jessel attorno al 1939, si trattava in origine di un drink per \"metà succo di pomodoro, metà vodka\". A perfezionare il drink e trasformarlo in quello che conosciamo ora fu Fernand Petiot. ', '10', '0', '2', '1', 8, '2020-12-07', '_Vodka_Succo di pomodoro_Succo di limone fresco_Salsa Worchestershire_Tabasco_Sale_Pepe_Ghiaccio_Sedano', '_45_90_12_2_2_1_1_15_1/_1_1_1_4_4_5_5_2_4', '_Per preparare il Bloody Mary versate il succo di pomodoro nello shaker. Spremete il limone._Procedete aggiungendo qualche goccia di tabasco e salsa Worchestershire. _Poi, aggiungete sale e pepe. Mescolate gli ingredienti nello shaker con l\'aiuto di un bar spoon. _Versate a questo punto la vodka con un jigger, il dosatore che vi permette di controllare con precisione le dosi degli ingredienti per un risultato equilibrato. Aggiungete qualche cubetto di ghiaccio direttamente nello shaker._Miscelate con la tecnica del Trowing, ossia versando da uno shaker all\'altro per più volte. Aprite lo shaker e nella parte dal quale il cocktail viene versato bloccate il ghiaccio con uno strainer, accessorio da bar, usato per rimuovere il ghiaccio dai cocktail dopo essere stati miscelati o agitati. Filtrate quindi il cocktail in un tumbler alto._Completate il vostro Bloody Mary decorandolo con un gambo di sedano. Buon aperitivo.', '_186_187_188_189_190_191', '_5_8', 2, NULL),
(41, 'Gnocchi alla romana', 'Gli gnocchi sono un antico primo piatto, preparati con le farine più varie e diffusi in tutto il mondo, anche in diverse forme. Come vuole la tradiziona romana, questi rappresentano proprio il classico piatto del giovedì, probabilmente posto in mezzo alla settimana per compensare la leggerezza del pasto del giorno successivo!', '15', '35', '2', '5', 9, '2020-12-10', '_Semolino_Burro_Parmigiano Reggiano DOP_Sale fino_Latte intero_Tuorli_Pecorino_Noce moscata', '_250_100_100_7_1000_2_40_2/_2_2_2_2_1_4_2_5', '_Per preparare gli gnocchi alla romana, ponete il latte in un tegame sul fuoco, e aggiungete una noce di burro (circa 30 g della dose totale), il sale, e un pizzico noce moscata; appena inizierà a bollire versatevi a pioggia il semolino , mescolando energicamente con una frusta, per evitare la formazione di grumi._Cuocete il composto a fuoco basso per qualche minuto, fino a che non si sarà addensato; dopodiché togliete il recipiente dal fuoco ed incorporate al composto i due tuorli mescolando questa volta con un mestolo di legno._Unite anche il parmigiano e mescolate il tutto nuovamente. A questo punto versate metà dell\'impasto ancora bollente su un foglio di carta forno e utilizzando le mani, dategli una forma cilindrica. Per non scottarvi troppo potete passare le mani sotto l\'acqua fredda. Una volta ottenuto un cilindro uniforme, avvolgetelo nella carta forno. Ripetete la stessa operazione per la seconda metà dell\'impasto tenuto da parte e riponete i due rotoli in frigorifero per una ventina di minuti._Una volta raffreddato, otterrete un impasto compatto e con un coltello riuscirete ad ottenere dei dischi perfetti. Per facilitarvi nel taglio consigliamo di inumidire la lama con dell\'acqua. Una volta ottenuti circa 40 pezzi disponeteli su una teglia precedentemente imburrata e cospargeteli con il burro fuso (circa 70 g), ma non bollente._Spolverizzate la superficie con il pecorino romano e cuocete in forno statico preriscaldato a 200° per 20-25 minuti (se utilizzate il forno ventilato 180° per 15 minuti). Dopodichè azionate la funzione grill e lasciateli gratinare per 4-5 minuti. Una volta pronti servite i vostri gnocchi alla romana ben caldi.', '_170_171_172_173_174', '_1_8', 3, NULL),
(42, 'Costine di maiale al forno', 'Queste appetitose costolette non solo sono buonissime, ma anche facilissime da fare. Il segreto del loro gusto non è soltanto la cottura, ma è soprattutto la marinatura, il processo più importante per ottenere una carne morbida e saporita. Oggi, oltre a tutti i passaggi, vedremo anche quali sono i principali segreti per una marinata perfetta.', '5', '45', '1', '4', 9, '2020-12-10', '_costine di maiale_rametto di timo_rametto di rosmarino_spicchio d’aglio_cucchiaino di paprika dolce_cipolla_grani di pepe nero_pizzico di sale_vino rosso_olio extravergine di oliva', '_1000_1_1_1_1_50_10_1_500_2/_2_4_4_4_3_2_4_4_1_5', '_Siete pronti per la ricetta delle costolette di maiale al forno? Allora Cominciamo dalla marinatura delle costine. Schiacciate l’aglio e mettetelo in un contenitore richiudibile insieme a tutte le erbe aromatiche, a un filo di olio di oliva extravergine, al pepe e alla cipolla. Aggiungete la carne mischiando per bene il tutto e coprite per intero con il vino rosso._Lasciate riposare in frigorifero per almeno 8 ore._Una volta atteso il tempo necessario, scolate la carne dalla marinata e adagiate le costine su una teglia da forno foderata. Cuocete alla temperatura di 200°C per una quindicina di minuti._Nel frattempo, filtrate la marinatura, tenendo da parte solo il liquido. Una volta passati i 15 minuti, togliete le costine dal forno e spennellatele con la salsa._Continuate la cottura delle costolette al forno per altri 30 minuti, bagnando altre due volte con la marinata._Quando le puntine saranno ben cotte, toglietele e fatele riposare, infine porzionatele incidendo la carne tra un osso e l’altro. Buon appetito!', '_177_178_179_180_181_182', '_2_6', 3, NULL),
(43, 'Salmone al forno', 'Una gustosa ricetta per cucinare il salmone al forno (ma d\'altronde si tratta di salmone, come potrebbe non essere gustosa)', '10', '20', '1', '4', 8, '2020-12-10', '_Salmone_Prezzemolo_Aglio_Sale_Olio extravergine di olive_Limone', '_600_1_2_1_2_0.5/_2_5_4_5_3_4', '_Sciacquate i tranci o le fette di salmone sotto l\'acqua corrente, dopo averli privati delle lische, e asciugateli._Nel frattempo mettete in una ciotola il prezzemolo tritato, l\'aglio tagliato a fettine, il sale, l\'olio e il limone e lasciate riposare per circa mezz\'ora, in modo da preparare un\'emulsione che andrà a insaporire il vostro salmone, ma che lo chef ritiene del tutto superflua vista la perfezione intrinseca del salmone._Trascorso il tempo necessario, rivestite una teglia con carta forno ed eventualmente (sconsigliato) cospargete il fondo con metà condimento. Adagiateci sopra i filetti di salmone e conditeli con il resto dell\'emulsione, se l\'avete preparata non ascoltando le ripetute avvertenze dell\'autore di questa ricetta. Cuocete in forno a 180° per 20 minuti e attendete pazientemente._Servite e gustate.', '_193_194_195_196', '_2_7', 3, NULL),
(44, 'Dorayaki', 'Dorayaki è uno dei tipici dolci giapponesi fatto come piccolo panino con la marmellata di fagioli rossi o bianchi oppure le altre creme chiamate anko, fatte con legumi, patate e castagne.', '10', '20', '1', '6', 8, '2020-12-10', '_Acqua_Farina 00_Zucchero a velo_Uova_Lievito in polvere per dolci_Miele', '_180_240_150_2_3_20/_1_2_2_4_2_2', '_Per preparare i dorayaki per prima cosa versate la farina in una ciotola, poi unite lo zucchero a velo e il lievito per dolci.\r\nA questo punto aggiungete anche le uova, il miele e l\'acqua a temperatura ambiente._Una volta che avrete aggiunto tutti gli ingredienti nella ciotola iniziate a sbattere con una frusta, prima lentamente, poi energicamente fino ad ottenere un composto privo di grumi e dalla consistenza fluida._Scaldate la padella per crepes (o una padella ampia antiaderente), versate un filo d\'olio e spandetelo sulla superficie con un foglio di carta da cucina; quindi versate un mestolo di composto per ciascun dorayaki (consigliamo di prepararne un paio per volta). Il fuoco deve essere medio: in questo modo non rischierete che i vostri dorayaki si scuriscano troppo. In base a quanto impasto utilizzerete, otterrete dei dorayaki più o meno grandi. Attendete circa 3 minuti e non appena in superficie spunteranno delle piccole bollicine potrete girarli._Proseguire la cottura per 1 minuto anche dall\'altro lato. Proseguite in questo modo fino a terminare l\'impasto e impilate man mano i vostri dorayaki, che potrete già gustare al naturale o servire a mò di panino farcendo con confetture e creme a piacere!', '_202_203_204_205', '_3_8', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `birthday` date DEFAULT NULL,
  `favorites` text,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isEditor` tinyint(1) NOT NULL DEFAULT '0',
  `isModerator` tinyint(1) NOT NULL DEFAULT '0',
  `ban` int NOT NULL,
  `image_profile` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `birthday`, `favorites`, `isAdmin`, `isEditor`, `isModerator`, `ban`, `image_profile`) VALUES
(1, 'maria', 'Maria', 'Saleri', 'mariasaleri@gmail.com', '9c5530bc03b828f7257b46fcefe44cac', '1997-05-06', '5_', 1, 1, 1, 0, NULL),
(2, 'claudio', 'Claudio', 'Cito', 'claudiocito@libero.it', '31ae8d9ba0e7631c8aa1e17717086afa', '2020-09-24', '2_4_', 1, 0, 0, 0, NULL),
(5, 'Inquisizione', 'Santa', 'Inquisizione', 'santainquisizione@burn.all', '5f4b15c188144b02979830c3d81104db', '1184-01-01', NULL, 0, 0, 1, 1, NULL),
(7, 'editorone', 'editorone', 'editorone', 'claudiocito@libero.it', '024b447877a518a48bdaea4d5ec4b993', '2020-10-30', '39_9_', 0, 0, 1, 0, NULL),
(8, 'LeChef', 'Paolino', 'Paperino', 'casamasapage@gmail.com', '522e6bf0be8955a0de9531dad8f01ccb', '1920-06-09', '4_', 0, 0, 0, 0, 'user_profile/8/exp (2).png'),
(9, 'superchef99', 'Pietro', 'Rossi', 'pietro.rossi1999@mail.it', 'b715f8edc62de93d145dc560a2bda818', '1999-03-11', NULL, 0, 0, 0, 0, NULL),
(18, 'Patrizio90', 'patry', 'melone', 'nonesiste@prova.it', 'bb490cbb6ff32573cc11740a5d88909a', NULL, NULL, 0, 1, 0, 0, NULL),
(11, 'GiorgiaPeletti', 'Giorgia', 'Peletti', 'giorgia@peletti.it', '3fe7e8c5d470c5009092f46b7855e45a', NULL, NULL, 1, 0, 0, 0, NULL),
(12, 'sbrizzarello01XD', 'utente', 'cattivo', 'noncelho@gmail.com', '5d11009c791aa1b9e4a7978533aacb54', NULL, NULL, 0, 1, 0, 0, NULL),
(13, 'MatteMod', 'Matteo', 'Gigotti', 'mettiew@gmail.com', '33cea6038009a645f33402bfd1292633', NULL, NULL, 0, 0, 1, 0, NULL),
(14, 'Inspired66', 'Marco', 'Ispirato', 'marco.isp@libero.it', 'c567e29f699c1d07c09f63e5d4979910', NULL, NULL, 0, 0, 0, 0, NULL),
(15, 'mamma_mia', 'Anna', 'Bianchi', 'mamma@mia.it', 'e7fd041f5b0fca005ed136a97adf45ee', '1975-05-08', NULL, 0, 0, 0, 0, NULL),
(16, 'cookie', 'Cookie', 'Saleri', 'cookie@mail.meow', '4a4be40c96ac6314e91d93f38043a634', '2020-07-15', '41_', 0, 0, 0, 0, NULL),
(17, 'gigio', 'luigi', 'rossi', 'gigio67@gmail.com', 'e6214a13c93c47ed1354ed903ff3fdfb', '1976-07-02', '41_', 0, 0, 0, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
