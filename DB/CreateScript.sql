-- This file creates all of the necessary tables we will be using to store
-- data collected. 


CREATE TABLE User
(
	uid		INT NOT NULL AUTO_INCREMENT,
	email   	VARCHAR(50) NOT NULL,
	pass_hash	VARCHAR(50) NOT NULL,
PRIMARY KEY (uid)
);
CREATE TABLE Student
(
	uid		INT NOT NULL,
	spam_count	INT NOT NULL,
	PRIMARY KEY (uid),
	FOREIGN KEY(uid) REFERENCES User(uid)
);
CREATE TABLE Instructor
(
       uid		INT NOT NULL,
       PRIMARY KEY (uid),
       FOREIGN KEY(uid) REFERENCES User(uid)
);
CREATE TABLE Course
(
       cid		INT NOT NULL AUTO_INCREMENT,
       name		VARCHAR(50),
       mailinglist	VARCHAR(50),
       PRIMARY KEY(cid)
);
CREATE TABLE Attends
(
       uid		INT,
       cid		INT,
       FOREIGN KEY(uid) REFERENCES Student(uid),
       FOREIGN KEY(cid) REFERENCES Course(cid)
);
CREATE TABLE Teaches
(
       uid		INT,
       cid		INT,
       FOREIGN KEY(uid) REFERENCES Teacher(uid),
       FOREIGN KEY(cid) REFERENCES Course(cid)
);
CREATE TABLE Session
(
       sid		INT NOT NULL AUTO_INCREMENT,
       cid		INT,
       TimeStamp	TIME,
       PRIMARY KEY(sid),
       FOREIGN KEY(cid) REFERENCES Course(cid)
);
CREATE TABLE Feedback
(
       fid		INT NOT NULL AUTO_INCREMENT,
       numvotes		INT,
       isread		INT,
       text		TEXT, 
       sid		INT,
       PRIMARY KEY(fid),
       FOREIGN KEY(sid) REFERENCES Session(sid)
);
CREATE TABLE Question
(
       qid		INT NOT NULL AUTO_INCREMENT,
       text		TEXT,
       numvotes		INT,
       answered		INT,
       sid		INT,
       FOREIGN KEY(sid) REFERENCES Session(sid),
       PRIMARY KEY(qid)
);
CREATE TABLE Survey
(
       sid		INT,
       sessionid        INT,
       FOREIGN KEY(sessionid) REFERENCES Session(sid),
       PRIMARY KEY(sid)
);
CREATE TABLE MultipleChoice
(
       sid		INT,
       text		TEXT,
       PRIMARY KEY(sid),
       FOREIGN KEY(sid) REFERENCES Survey(sid)        
);
CREATE TABLE FreeResponse
(
       frid		INT NOT NULL AUTO_INCREMENT,
       sid		INT,
       text		VARCHAR(50),
       PRIMARY KEY(frid),
       FOREIGN KEY(sid) REFERENCES Survey(sid)
);
CREATE TABLE Choices
(
       sid		INT,
       count		INT,
       text		TEXT,
       FOREIGN KEY(sid) REFERENCES Survey(sid)
);
CREATE TABLE VotedOn
(
       uid        	INT,
       qid        	INT,
       FOREIGN KEY(qid) REFERENCES Question(qid),
       FOREIGN KEY(uid) REFERENCES Student(uid)
);
