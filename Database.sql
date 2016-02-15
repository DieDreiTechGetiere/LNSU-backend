CREATE DATABASE LeaveNoShipsUnburned;

USE LeaveNoShipsUnburned;

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

CREATE TABLE tblMatch
(
	matchID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	mUser1 int NOT NULL,
	mUser2 int NOT NULL,
	mTimestamp datetime,
	FOREIGN KEY fk_User1(mUser1) REFERENCES tblUser(uID),
	FOREIGN KEY fk_User2(mUser2) REFERENCES tblUser(uID)
);

CREATE TABLE tblMatchSteps
(
	msID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	msDateTime datetime,
	mMatchID int NOT NULL,
	mUserID int NOT NULL,
	mRow int NOT NULL,
	mColumn int NOT NULL,
	mState int NOT NULL,
	FOREIGN KEY fk_Match(mMatchID) REFERENCES tblMatch(matchID),
	FOREIGN KEY fk_User(mUserID) REFERENCES tblUser(uID)
);

CREATE TABLE tblShipPosition
(
	spID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	sStepNumber int NOT NULL,
	spLength int NOT NULL,
	spMatchID int NOT NULL,
	spUserID int NOT NULL,
	spStartCol int NOT NULL,
	spStartRow int NOT NULL,
	spDirection int NOT NULL,
	FOREIGN KEY fk_spMatch(spMatchID) REFERENCES tblMatch(matchID),
	FOREIGN KEY fk_spUser(spUserID) REFERENCES tblUser(uID)
);
