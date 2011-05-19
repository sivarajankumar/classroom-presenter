-- This file creates all of the necessary tables we will be using to store
-- data collected. 


CREATE TABLE User
(
	uid		INT NOT NULL AUTO_INCREMENT,
	email   	VARCHAR(50) NOT NULL,
PRIMARY KEY (uid)
);
CREATE TABLE Student
(
	uid		INT NOT NULL,
	spam_count	INT NOT NULL,
	alias	VARCHAR(30), 
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
       FOREIGN KEY(cid) REFERENCES Course(cid),
       PRIMARY KEY(uid, cid)
);
CREATE TABLE Teaches
(
       uid		INT,
       cid		INT,
       FOREIGN KEY(uid) REFERENCES Teacher(uid),
       FOREIGN KEY(cid) REFERENCES Course(cid),
       PRIMARY KEY(uid, cid)
);
CREATE TABLE Session
(
       sid		INT NOT NULL AUTO_INCREMENT,
       cid		INT,
       uid    	INT,
       open		INT,
       start_time	TIMESTAMP DEFAULT NOW(),
       stop_time TIMESTAMP,
       PRIMARY KEY(sid, cid),
       FOREIGN KEY(cid) REFERENCES Course(cid)
);
CREATE TABLE Feedback
(
       fid		INT NOT NULL AUTO_INCREMENT,
       numvotes		INT,
       isread		INT,
       text		TEXT, 
       sid		INT,
       time		TIMESTAMP DEFAULT NOW(),
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
       time		TIMESTAMP DEFAULT NOW(),
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
       sid		INT,
       text		VARCHAR(50),
       PRIMARY KEY(sid),
       FOREIGN KEY(sid) REFERENCES Survey(sid)
);
CREATE TABLE Answer
(
	   sid		INT, 
	   text		INT,
	   uid		INT,
	   PRIMARY KEY(sid, uid),
	   FOREIGN KEY(sid) REFERENCES Survey(sid),
	   FOREIGN KEY(uid) REFERENCES Student(uid)
);			
CREATE TABLE Choices
(
       sid		INT,
       count		INT,
       text		TEXT,
       FOREIGN KEY(sid) REFERENCES Survey(sid)
);
CREATE TABLE QuestionVotedOn
(
       uid        	INT,
       qid        	INT,
       FOREIGN KEY(qid) REFERENCES Question(qid),
       FOREIGN KEY(uid) REFERENCES Student(uid)
);

CREATE TABLE FeedbackVotedOn
(
	uid				INT,
	fid				INT,
	FOREIGN KEY(fid) REFERENCES Feedback(fid),
	FOREIGN KEY(uid) REFERENCES Student(uid)
);

CREATE TABLE Joined
(
		sid			INT,
		uid			INT,
		FOREIGN KEY(sid) REFERENCES Session(sid),
		FOREIGN KEY(uid) REFERENCES Student(uid),
		PRIMARY KEY(sid, uid)
);
