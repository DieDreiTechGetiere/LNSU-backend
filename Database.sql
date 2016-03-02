-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.9-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.2.0.4948
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von Tabelle leavenoshipsunburned.tblmatch
CREATE TABLE IF NOT EXISTS `tblmatch` (
  `matchID` int(11) NOT NULL AUTO_INCREMENT,
  `User1` int(11) NOT NULL,
  `User2` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Winner` int(11) NOT NULL,
  `User2ELO` int(11) NOT NULL,
  `User1ELO` int(11) DEFAULT NULL,
  PRIMARY KEY (`matchID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tblmatch: ~5 rows (ungefähr)
DELETE FROM `tblmatch`;
/*!40000 ALTER TABLE `tblmatch` DISABLE KEYS */;
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(1, 84, 87, '2016-02-19', 84, 0, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(4, 91, 84, '2016-02-19', 91, 0, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(6, 87, 91, '2016-02-19', 91, 0, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(7, 84, 88, '2016-02-19', 84, 0, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(8, 92, 84, '2016-02-19', 92, 0, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(11, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(12, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(13, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(14, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(15, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(16, 97, 97, '2016-03-02', 0, 1000, NULL);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(17, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(18, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(19, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(20, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(21, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(22, 97, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(23, 91, 97, '2016-03-02', 0, 1000, 1000);
INSERT INTO `tblmatch` (`matchID`, `User1`, `User2`, `Date`, `Winner`, `User2ELO`, `User1ELO`) VALUES
	(24, 97, 97, '2016-03-02', 0, 1000, 1000);
/*!40000 ALTER TABLE `tblmatch` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle leavenoshipsunburned.tblmatchsteps
CREATE TABLE IF NOT EXISTS `tblmatchsteps` (
  `msID` int(11) NOT NULL AUTO_INCREMENT,
  `mMatchID` int(11) NOT NULL,
  `mUserID` int(11) NOT NULL,
  `mRow` int(11) NOT NULL,
  `mColumn` int(11) NOT NULL,
  `mState` int(11) NOT NULL,
  PRIMARY KEY (`msID`),
  KEY `fk_Match` (`mMatchID`),
  KEY `fk_User` (`mUserID`),
  CONSTRAINT `fk_Match` FOREIGN KEY (`mMatchID`) REFERENCES `tblmatch` (`matchID`),
  CONSTRAINT `fk_User` FOREIGN KEY (`mUserID`) REFERENCES `tbluser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tblmatchsteps: ~0 rows (ungefähr)
DELETE FROM `tblmatchsteps`;
/*!40000 ALTER TABLE `tblmatchsteps` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmatchsteps` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle leavenoshipsunburned.tblshipposition
CREATE TABLE IF NOT EXISTS `tblshipposition` (
  `spID` int(11) NOT NULL AUTO_INCREMENT,
  `spLength` int(11) NOT NULL,
  `spMatchID` int(11) NOT NULL,
  `spUserID` int(11) NOT NULL,
  `spStartCol` int(11) NOT NULL,
  `spStartRow` int(11) NOT NULL,
  `spDirection` int(11) NOT NULL,
  PRIMARY KEY (`spID`),
  KEY `fk_spMatch` (`spMatchID`),
  KEY `fk_spUser` (`spUserID`),
  CONSTRAINT `fk_spMatch` FOREIGN KEY (`spMatchID`) REFERENCES `tblmatch` (`matchID`),
  CONSTRAINT `fk_spUser` FOREIGN KEY (`spUserID`) REFERENCES `tbluser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tblshipposition: ~0 rows (ungefähr)
DELETE FROM `tblshipposition`;
/*!40000 ALTER TABLE `tblshipposition` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblshipposition` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle leavenoshipsunburned.tbluser
CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000',
  `timestamp` varchar(100) NOT NULL DEFAULT '0',
  `ELO` int(11) NOT NULL DEFAULT '1000',
  `loginName` varchar(25) DEFAULT NULL,
  `totalOppELO` int(11) DEFAULT '0',
  `ingameName` varchar(25) DEFAULT NULL,
  `password` mediumtext,
  `freigeschaltet` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uLoginName` (`loginName`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tbluser: ~12 rows (ungefähr)
DELETE FROM `tbluser`;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(84, 00000000000, '1455544267015', 1000, 'a', NULL, 'a', 'd9df475247cac44b8e735a1e5', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(85, 00000000000, '1455545612527', 1000, 'b', NULL, 'b', '0e7eb6c8d0ad66d65ee228bf9', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(86, 00000000000, '1455545758182', 1000, 'c', NULL, 'c', 'abd463199a2ed476cadcfea34', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(87, 00000000000, '1455545795614', 1000, 'd', NULL, 'd', '60382b4cbbf4d084ef215a9e1', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(88, 00000000000, '1455545944229', 1000, 'f', NULL, 'f', '6ec8ecef6474826aee26188b3', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(89, 00000000000, '1455546153531', 1000, 'as', NULL, 'as', '7dcd461e6102b21960019e425', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(90, 00000000000, '1455546185279', 2500, 'ab', NULL, 'ab', '824ea3081c95a7937351c4bdc9956eeb', b'1');
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(91, 00000000000, '1455547318036', 1000, 'marcus', NULL, 'marcus', 'c94bbd44c39c2b5d1024b2ebb0e13bc3', b'1');
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(92, 00000000000, '1455802885325', 1000, 'h', NULL, 'h', '9f4b3baf0ffc8d9ce2828449f1bf7608', b'1');
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(93, 00000000000, '1455894338035', 1000, 'awojnar', 0, 'Alexander Wojnar', '00793acec4e6cf95f3ed14f9d41b74eb', NULL);
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(96, 00000000000, '1455730271083', 1000, 'niklas', 0, 'Schokolade', '387565df7b1a27c8c30f68db480a6286', b'1');
INSERT INTO `tbluser` (`id`, `role`, `timestamp`, `ELO`, `loginName`, `totalOppELO`, `ingameName`, `password`, `freigeschaltet`) VALUES
	(97, 00000000000, '1455730121002', 1000, 'jakob', 0, 'jakob', '8853d1c173ad44cb02563885d5c0ab98', b'1');
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;


-- Exportiere Struktur von View leavenoshipsunburned.view_highscore
-- Erstelle temporäre Tabelle um View Abhängigkeiten zuvorzukommen
CREATE TABLE `view_highscore` (
	`id` INT(11) NOT NULL,
	`ELO` INT(11) NOT NULL,
	`ingameName` VARCHAR(25) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;


-- Exportiere Struktur von View leavenoshipsunburned.view_stats
-- Erstelle temporäre Tabelle um View Abhängigkeiten zuvorzukommen
CREATE TABLE `view_stats` (
	`id` INT(11) NOT NULL,
	`totalMatches` BIGINT(22) NOT NULL,
	`wins` BIGINT(21) NOT NULL,
	`loses` BIGINT(23) NOT NULL,
	`ELO` INT(11) NOT NULL
) ENGINE=MyISAM;


-- Exportiere Struktur von View leavenoshipsunburned.view_highscore
-- Entferne temporäre Tabelle und erstelle die eigentliche View
DROP TABLE IF EXISTS `view_highscore`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `view_highscore` AS select `tbluser`.`id` AS `id`,`tbluser`.`ELO` AS `ELO`,`tbluser`.`ingameName` AS `ingameName` from `tbluser` ;


-- Exportiere Struktur von View leavenoshipsunburned.view_stats
-- Entferne temporäre Tabelle und erstelle die eigentliche View
DROP TABLE IF EXISTS `view_stats`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `view_stats` AS select 
	`tbluser`.`id` AS `id`,
	(count(distinct `m1`.`matchID`) + count(distinct `m2`.`matchID`)) AS `totalMatches`,
	(count(distinct `win`.`matchID`)) AS `wins`,
	(count(distinct `m1`.`matchID`) + count(distinct `m2`.`matchID`)) - (count(distinct `win`.`matchID`)) AS `loses`,
	`tbluser`.`ELO` AS `ELO` 
from (((`tbluser` 
	left join `tblmatch` `m1` on((`tbluser`.`id` = `m1`.`User1`))) 
	left join `tblmatch` `m2` on((`tbluser`.`id` = `m2`.`User2`))) 
	left join `tblmatch` `win` on((`tbluser`.`id` = `win`.`Winner`))) 
group by `tbluser`.`id` ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
