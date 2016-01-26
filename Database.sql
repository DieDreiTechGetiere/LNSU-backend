CREATE DATABASE LeaveNoShipsUnburned;

USE LeaveNoShipsUnburned;

CREATE TABLE tblUser
(
	uID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	uLoginName varchar(25),
	uIngameName varchar(25),
	uPassword varchar(25),
	uFreigeschaltet BIT 
); 

CREATE TABLE tblMatch
(
	matchID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	mUser1 int NOT NULL,
	mUser2 int NOT NULL,
	mTimestamp TIMESTAMP,
	FOREIGN KEY fk_User1(mUser1) REFERENCES tblUser(uID),
	FOREIGN KEY fk_User2(mUser2) REFERENCES tblUser(uID)
);

CREATE TABLE tblMatchSteps
(
	msID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
	spLength int NOT NULL,
	spMatchID int NOT NULL,
	spUserID int NOT NULL,
	spStartCol int NOT NULL,
	spStartRow int NOT NULL,
	spDirection int NOT NULL,
	FOREIGN KEY fk_spMatch(spMatchID) REFERENCES tblMatch(matchID),
	FOREIGN KEY fk_spUser(spUserID) REFERENCES tblUser(uID)
);
