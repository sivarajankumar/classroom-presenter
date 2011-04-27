CREATE TABLE User
(
uid       INT           NOT NULL	PRIMARY_KEY,
email     VARCHAR(50)		NOT NULL,
pass_hash VARCHAR(50)		NOT NULL
);

CREATE TABLE Student
(
uid		INT			NOT NULL	PRIMARY_KEY,
spam_count	INT			NOT NULL,
FOREIGN KEY(uid) REFERENCES User(uid)
);

CREATE TABLE Instructor
(
uid		INT			NOT NULL	PRIMARY_KEY,
FOREIGN_KEY(uid) REFERENCES User(uid)
);


CREATE TABLE Course
(
	cid		INT	PRIMARY_KEY,
	name 		VARCHAR(50),
	mailinglist	VARCHAR(50)
);

CREATE TABLE Attends
(
	uid		INT,
	cid		INT,
	FOREIGN_KEY(uid) REFERENCES Student(uid),
  FOREIGN_KEY(cid) REFERENCES Course(cid)
);

CREATE TABLE Teaches
(
	uid		INT,
	cid		INT,
	FOREIGN_KEY(uid) REFERENCES Teacher(uid),
  FOREIGN_KEY(cid) REFERENCES Course(cid)
);

CREATE TABLE Session
(
	sid		INT	PRIMARY_KEY,
  cid		INT,
	TimeStamp 	TIME,
  FOREIGN_KEY(cid) REFERENCES Course(cid)
);

CREATE TABLE Feedback
(
	fid		INT	PRIMARY_KEY,
  numvotes	INT,
	read		INT,
	text		TEXT, 
	sid		INT,
	FOREIGN_KEY(sid) REFERENCES Session(sid)
);

CREATE TABLE Question
(
  qid		INT	PRIMARY_KEY,
  text		TEXT,
  numvotes	INT,
  answered	INT,
  sid		INT,
  FOREIGN KEY(sid) REFERENCES Session(sid)
);

CREATE TABLE Survey
(
	sid		INT	PRIMARY_KEY,
	sessionid	INT,
FOREIGN_KEY(sessionid) REFERENCES Session(sid)
);

CREATE TABLE MultipleChoice
(
  sid		INT 	PRIMARY_KEY,
  text		TEXT,
  FOREIGN_KEY(sid) REFERENCES Survey(sid)	
);


CREATE TABLE FreeResponse
(
	frid		INT			NOT NULL	PRIMARY_KEY,
	sid		INT,
	text		VARCHAR(50),
  FOREIGN_KEY(sid) REFERENCES Survey(sid)
);

CREATE TABLE Choices
(
	sid 		INT 			PRIMARY_KEY,
	count 		INT,
	text		TEXT,
	FOREIGN_KEY(sid) REFRENCES Survey(sid)
);

CREATE TABLE Answers
(
	sid 	INT 			PRIMARY_KEY,
	uid	INT,
	text	TEXT,
	FOREIGN_KEY(sid) REFRENCES Survey(sid),
	FOREIGN_KEY(uid) REFRENCES Student(uid)	
);

CREATE TABLE VotedOn
(
	uid 	INT,
	qid	INT,
	FOREIGN_KEY(qid) REFRENCES Question(qid),
	FOREIGN_KEY(uid) REFRENCES Student(uid)
);
