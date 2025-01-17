-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2023 at 10:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reviewsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int(10) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `userName` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `favlist` varchar(100) DEFAULT 'ENTER FAVOURATE LIST NAME'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `fname`, `lname`, `userName`, `email`, `password`, `favlist`) VALUES
(101, 'Tang1', 'yan', 'Eason2', 'test@gamil.com', '$2y$10$.Esybd8m', 'ENTER FAVOURATE LIST NAME'),
(102, NULL, NULL, '', '', '$2y$10$0Txp/c9C', 'ENTER FAVOURATE LIST NAME'),
(103, 'tang', 'yan', 'test3', 'test3@gamil.com', '$2y$10$lnZIxYY8', 'ENTER FAVOURATE LIST NAME'),
(104, 'Tang', 'Yan', 'eason5', 'tang@gamil.com', '$2y$10$XAhgGQa3ldA3zy2Jw5pyreaWohWp.moSmBfna1zdzAtA8dEC7BB42', 'ENTER FAVOURATE LIST NAME'),
(105, NULL, NULL, '', '', '$2y$10$lbtgnF1tIO0uBzrCmL4BQe.tlkLjUq78q8L2ft0ZJzdhNLN48lLmW', 'ENTER FAVOURATE LIST NAME'),
(106, 'Tang', 'Yan', 'Eason', 'test@gamil.com', '$2y$10$ki.NnQbflTu2rjupLXIApeIlmUnssBA8RN7vG7rKmqTYf5f7PeoS2', 'ENTER FAVOURATE LIST NAME'),
(107, NULL, NULL, '', '', '$2y$10$mROQmbdqSXq4d3wjk1tw4.P4R/2ma2p3zvQcLm.UTfocIUFRDM4m2', 'ENTER FAVOURATE LIST NAME'),
(108, 'Jintang', 'Yan', 'Eason3', 'tangYan@gamil.com', '$2y$10$Fa0jCydnJG0A.6xlG5RWF.BQiFOnQNNCNNz4Ryr7zCxv/imbECB7e', 'Eason\'s Fav1'),
(109, 'demo', 'Yan', 'Demo', 'Demo@gamil.com', '$2y$10$ImA0ac5bWsW5k.xzskhkqOl.dpyjAMvSVMq3MII5I.Q8IkxUx0v6e', 'ENTER FAVOURATE LIST NAME'),
(110, 'DemoSecond', 'Yan', 'EasonS', 'Demo1@gamil.com', '$2y$10$7Ujo4tEZjCk.OyNEOCLDh.enjZ.qwp9wefAca568lUawyEL0OuLg2', 'Eason\'s Fav2');

-- --------------------------------------------------------

--
-- Table structure for table `favlist`
--

CREATE TABLE `favlist` (
  `accountID` int(10) NOT NULL,
  `movieID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favlist`
--

INSERT INTO `favlist` (`accountID`, `movieID`) VALUES
(101, 3),
(101, 2),
(102, 4),
(102, 5),
(102, 3),
(102, 1),
(102, 2),
(105, 2),
(105, 1),
(105, 3),
(105, 4),
(105, 5),
(107, 2),
(107, 1),
(107, 3),
(107, 4),
(107, 5),
(107, 5),
(107, 7),
(107, 8),
(108, 14),
(108, 19),
(108, 15),
(108, 2),
(108, 13),
(110, 4),
(110, 13),
(110, 9);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movieID` int(10) NOT NULL,
  `rating` float DEFAULT NULL,
  `mname` varchar(255) NOT NULL,
  `intro` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `director` varchar(255) NOT NULL,
  `runtime` int(255) NOT NULL,
  `releaseDate` date NOT NULL,
  `starring` varchar(255) NOT NULL,
  `num_of_rate` int(10) NOT NULL,
  `total_rate` int(10) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `landscapeImg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movieID`, `rating`, `mname`, `intro`, `genre`, `director`, `runtime`, `releaseDate`, `starring`, `num_of_rate`, `total_rate`, `poster`, `landscapeImg`) VALUES
(1, 4, 'Gold finger', 'MI6 agent James Bond investigates a gold-smuggling ring run by businessman Auric Goldfinger. As he delves deeper into his activities, he uncovers a sinister plan to attack Fort Knox\'s gold reserves.', 'spy film, action, adventure', 'Guy Hamilton', 110, '1964-09-17', 'Sean Connery\r\nHonor Blackman\r\nGert Fröbe\r\nShirley Eaton\r\nTania Mallet\r\nHarold Sakata', 11, 44, 'Gold finger', 'Gold finger'),
(2, 3.8, 'Psycho', 'Marion disappears after stealing money from her employer. Her lover and sister try to find her and end up reaching the infamous Bates Motel, where they meet Norman Bates.', 'Horror Mystery Thriller', 'Alfred Hitchcock', 109, '1964-09-17', 'Anthony PerkinsJanet LeighVera Miles', 6, 23, 'Psycho', 'Psycho'),
(3, 4.3, 'Nightmare in Wax', 'Vince Rinaud is a former film special effects artist who is disfigured by Max Block, the head of Paragon Pictures, and also a rival for the affections of a woman (Anne Helm). Leaving the film industry, Vince becomes a recluse and opens a wax museum. Withi', 'Horror Thriller', 'Bud Townsend', 96, '1969-05-14', 'Cameron MitchellAnne HelmScott Brady', 20, 86, 'Nightmare in Wax', 'Nightmare in Wax'),
(4, 4.5, 'Night of the living dead', 'The radiation from a fallen satellite causes the recently deceased to rise from the grave and seek the living to use as food.', 'Horror Thriller Action', 'George A. Romero	', 98, '1968-06-16', 'Duane JonesJudith O\'DeaKarl Hardman', 10, 45, 'Night of the living dead', 'Night of the living dead'),
(5, 3.9, 'Django', 'Sergio Corbucci\'s Grand Guignol spaghetti western is set on the USA-Mexican border just after the Civil War. Django, an ex-Union soldier, wreaks bloody vengeance on the Ku Klux Klan.', 'Action Western Drama', 'Sergio Corbucci	', 95, '1966-06-17', 'Franco NeroJosé CanalejasJosé Bódalo', 23, 90, 'Django', 'Django'),
(6, 4.3, 'Batman', 'Batman and Robin discover a secret invention that the evil villains plan to use to dehydrate the entire population in exchange for ransom. The duo must find a way to stop them and save the world', 'Action Crime Fantacy', 'William Dozier', 98, '1966-06-16', '\r\nAdam WestBurt WardAlan Napier', 16, 68, 'Batman', 'Batman'),
(7, 3.9, 'Breakfast at Tiffany', 'Paul is a struggling writer who recently moves into a new apartment in New York. When he meets Holly, an eccentric but beautiful socialite, he hopelessly falls in love with her.', 'Comedy Drama Romance', 'Blake Edwards', 105, '1961-04-14', 'Audrey HepburnGeorge PeppardPatricia Neal', 22, 85, 'Breakfast at Tiffany', 'Breakfast at Tiffany'),
(8, 3.5, 'Chitty Chitty Bang Bang', 'Inventor Caractacus Potts transforms an old Grand Prix car into a magical flying vehicle that teleports him and his family to a kingdom ruled by the evil Baron Bomburst.', 'Adventure Family Fantasy', 'Ken Hughes', 144, '1968-05-14', '\r\nDick Van DykeSally Ann HowesLionel Jeffries', 23, 80, 'Chitty Chitty Bang Bang', 'Chitty Chitty Bang Bang'),
(9, 4.4, 'Dr strange love', 'An American general puts the world on the verge of catastrophe when he orders an attack on the Soviet Union. Soon, a war council tries to put a stop to it before it is too late.', 'Comedy War', 'Stanley Kubrick', 95, '1964-09-26', 'Peter SellersGeorge C. ScottSterling Hayden', 13, 57, 'Dr strange love', 'Dr strange love'),
(10, 4, 'El dorado', 'Heartless tycoon Bart Jason (Edward Asner) hires a group of thugs to force the MacDonald family out of El Dorado so he can claim their land. J.P. Harrah, the town\'s sheriff, is too deep in the throes of alcoholism to help the family. When Harrah\'s friend,', 'Drama Romance Western', 'Howard Hawks', 126, '1966-07-25', 'John WayneRobert MitchumJames Caan', 31, 125, 'El dorado', 'El dorado'),
(11, 4.7, 'Hercules in New York', 'Adventure ensues after Hercules moves to New York and learns that his ancient Greek lifestyle is not compatible with the modern life. To add to the woes, his father sends a few gods to bring him back.', 'Adventure Comedy Fantasy', 'Arthur Allan Seidelman', 91, '1970-02-25', 'Arnold StangArnold SchwarzeneggerDeborah Loomis', 15, 70, 'Hercules in New York', 'Hercules in New York'),
(12, 3.5, 'Lord of the files', '\r\nA group of 25 military cadets land on an island after their plane crashes. They then split into two groups. While one follows the values of civilisation, the other embraces savagery for survival.', 'Adventure Drama Thriller', 'Peter Brook', 93, '1963-03-19', 'James AubreyTom ChapinHugh Edwards', 31, 110, 'Lord of the files', 'Lord of the files'),
(13, 4.4, 'The green berets', 'A cynical reporter (David Janssen) who is opposed to the Vietnam War is sent to cover the conflict and assigned to tag along with a group of Green Berets. Led by the tough-as-nails Col. Mike Kirby (John Wayne), the team is given a top-secret mission to sn', 'Drama War', 'Ray Kellogg John Wayne	Mervyn LeRoy', 144, '1968-09-23', 'John WayneDavid JanssenJim Hutton', 16, 71, 'The green berets', 'The green berets'),
(14, 4.2, 'The pink panther', 'A clumsy detective is on the trail of a notorious thief planning to steal a diamond called \'The Pink Panther\'. His hunt leads him to the most unusual suspect.', 'Comedy Romance Crime', 'Blake Edwards', 115, '1963-08-12', 'David NivenPeter SellersRobert Wagner', 18, 75, 'The pink panther', 'The pink panther'),
(15, 3.4, 'The Jungle Book', 'Mowgli is a young boy who has been raised by wolves. When a man-eating tiger threatens his life, his animal family tries to convince him to leave the jungle and live in the human village.', 'Animation Adventure Comedy', 'Wolfgang Reitherman', 78, '1967-05-23', 'Phil HarrisSebastian CabotLouis Prima', 19, 65, 'The Jungle Book', 'The Jungle Book'),
(16, 3.6, 'The sound of music', '\r\nMaria, an aspiring nun, is sent as a governess to take care of seven motherless children. Soon her jovial and loving nature tames their hearts and the children become fond of her.', 'Biography Drama Family', 'Robert Wise', 172, '1965-04-14', 'Julie AndrewsChristopher PlummerEleanor Parker', 18, 65, 'The sound of music', 'The sound of music'),
(17, 4, 'To kill a mockingbird', 'In the Depression era, Atticus Finch, a lawyer, sets out to defend a black man, who is accused of raping a white woman. Meanwhile, his children, Scout and Jem, spy on their reclusive neighbour.', 'Crime Drama', 'Robert Mulligan', 129, '1962-09-23', 'Gregory PeckJohn MegnaFrank Overton', 19, 76, 'To kill a mockingbird', 'To kill a mockingbird'),
(18, 4, 'where the boys are', 'Four very different college girls drive to Fort Lauderdale, Florida for spring break and seek out various adventures and romance for themselves.', 'Comedy Drama Romance', 'Henry Levin', 99, '1960-09-17', 'Dolores HartGeorge HamiltonYvette Mimieux', 27, 109, 'where the boys are', 'where the boys are'),
(19, 3.1, 'Judgment at Nuremberg', 'Judgment at Nuremberg is a 1961 American epic courtroom film that was both directed and produced by Stanley Kramer. It features Spencer Tracy, Burt Lancaster, Richard Widmark, Maximilian Schell, Werner Klemperer, Marlene Dietrich, Judy Garland, William Sh', 'Drama War', 'Stanley Kramer', 179, '1961-11-11', 'Spencer TracyBurt LancasterRichard Widmark', 15, 47, 'Judgment at Nuremberg', 'Judgment at Nuremberg'),
(20, 3.9, 'Sam Whiskey', 'Great gambler Sam Whiskey (Burt Reynolds) has got his hands on a heist job that\'s pretty outrageous, even by Wild West standards. A drop-dead-gorgeous woman (Angie Dickinson) wants to quietly give back the gold her husband had stolen, now that he\'s dead. ', 'Comedy Western', 'Arnold Laven', 96, '1969-06-16', 'Burt ReynoldsAngie DickinsonClint Walker', 25, 98, 'Sam Whiskey', 'Sam Whiskey');

--
-- Triggers `movie`
--
DELIMITER $$
CREATE TRIGGER `update_rate` BEFORE UPDATE ON `movie` FOR EACH ROW BEGIN
  IF NEW.num_of_rate <> 0 THEN
    SET NEW.rating = ROUND(NEW.total_rate / NEW.num_of_rate, 1);
  ELSE
    SET NEW.rating = 0;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(10) NOT NULL,
  `movieID` int(4) NOT NULL,
  `accountID` int(4) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewID`, `movieID`, `accountID`, `description`) VALUES
(403, 4, 108, 'why star rating no working?'),
(404, 2, 108, 'hopefully it gonna work'),
(407, 9, 108, 'pretty good!!!'),
(408, 8, 108, ' this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  this is gonna be long  t'),
(409, 7, 108, 'She is beautiful!!'),
(410, 6, 108, 'very old memory'),
(411, 1, 108, 'lsjf eh classic !!classic !!classic !!classic !!classic !!'),
(412, 12, 108, 'the boy is a good actor'),
(417, 20, 110, 'DFJ SDHFHWEFA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `favlist`
--
ALTER TABLE `favlist`
  ADD KEY `accountID` (`accountID`),
  ADD KEY `movieID` (`movieID`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movieID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `accountID` (`accountID`),
  ADD KEY `movieID` (`movieID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movieID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favlist`
--
ALTER TABLE `favlist`
  ADD CONSTRAINT `favlist_ibfk_1` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `favlist_ibfk_2` FOREIGN KEY (`movieID`) REFERENCES `movie` (`movieID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`accountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`movieID`) REFERENCES `movie` (`movieID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
