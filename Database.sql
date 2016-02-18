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

CREATE TABLE `tbluser` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`role` INT(11) NOT NULL DEFAULT '0',
	`timestamp` VARCHAR(100) NOT NULL DEFAULT '0',
	`loginName` VARCHAR(25) NULL DEFAULT NULL,
	`ingameName` VARCHAR(25) NULL DEFAULT NULL,
	`password` VARCHAR(25) NULL DEFAULT NULL,
	`freigeschaltet` BIT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `uLoginName` (`loginName`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=80
;
-- Exportiere Datenbank Struktur für leavenoshipsunburned
DROP DATABASE IF EXISTS `leavenoshipsunburned`;
CREATE DATABASE IF NOT EXISTS `leavenoshipsunburned` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `leavenoshipsunburned`;


-- Exportiere Struktur von Tabelle leavenoshipsunburned.tblmatch
DROP TABLE IF EXISTS `tblmatch`;
CREATE TABLE IF NOT EXISTS `tblmatch` (
  `matchID` int(11) NOT NULL AUTO_INCREMENT,
  `mUser1` int(11) NOT NULL,
  `mUser2` int(11) NOT NULL,
  `mTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`matchID`),
  KEY `fk_User1` (`mUser1`),
  KEY `fk_User2` (`mUser2`),
  CONSTRAINT `fk_User1` FOREIGN KEY (`mUser1`) REFERENCES `tbluser` (`id`),
  CONSTRAINT `fk_User2` FOREIGN KEY (`mUser2`) REFERENCES `tbluser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tblmatch: ~0 rows (ungefähr)
DELETE FROM `tblmatch`;
/*!40000 ALTER TABLE `tblmatch` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmatch` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle leavenoshipsunburned.tblmatchsteps
DROP TABLE IF EXISTS `tblmatchsteps`;
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
DROP TABLE IF EXISTS `tblshipposition`;
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
DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL DEFAULT '0',
  `timestamp` varchar(100) NOT NULL DEFAULT '0',
  `loginName` varchar(25) DEFAULT NULL,
  `ingameName` varchar(25) DEFAULT NULL,
  `password` varchar(10000) DEFAULT NULL,
  `freigeschaltet` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uLoginName` (`loginName`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle leavenoshipsunburned.tbluser: ~4 rows (ungefähr)
DELETE FROM `tbluser`;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
