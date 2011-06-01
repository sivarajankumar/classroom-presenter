-- This file creates all of the necessary tables we will be using to store
-- data collected. 


CREATE TABLE User
(
	uid		INT NOT NULL AUTO_INCREMENT,
	email   VARCHAR(50) NOT NULL,
PRIMARY KEY (uid)
);
CREATE TABLE Student
(
	uid		INT NOT NULL,
	spam_count	INT NOT NULL,
    netid   VARCHAR(30),
	alias	VARCHAR(30), 
	PRIMARY KEY (uid),
	FOREIGN KEY(uid) REFERENCES User(uid) ON DELETE CASCADE
);
CREATE TABLE Instructor
(
       uid		INT NOT NULL,
       PRIMARY KEY (uid),
       FOREIGN KEY(uid) REFERENCES User(uid) ON DELETE CASCADE
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
       PRIMARY KEY(uid, cid),
       FOREIGN KEY(uid) REFERENCES Student(uid) ON DELETE CASCADE,
       FOREIGN KEY(cid) REFERENCES Course(cid) ON DELETE CASCADE
);
CREATE TABLE Teaches
(
       uid		INT,
       cid		INT,
       PRIMARY KEY(uid, cid),
       FOREIGN KEY(uid) REFERENCES Instructor(uid) ON DELETE CASCADE,
       FOREIGN KEY(cid) REFERENCES Course(cid) ON DELETE CASCADE
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
       FOREIGN KEY(cid) REFERENCES Course(cid) ON DELETE CASCADE,
       FOREIGN KEY(uid) REFERENCES Instructor(uid)
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
       FOREIGN KEY(sid) REFERENCES Session(sid) ON DELETE CASCADE
);
CREATE TABLE Question
(
       qid		INT NOT NULL AUTO_INCREMENT,
       text		TEXT,
       numvotes		INT,
       answered		INT,
       sid		INT,
       time		TIMESTAMP DEFAULT NOW(),
       FOREIGN KEY(sid) REFERENCES Session(sid) ON DELETE CASCADE,
       PRIMARY KEY(qid)
);
CREATE TABLE Survey
(
       sid		INT NOT NULL AUTO_INCREMENT,
       sessionid        INT,
       open				INT, 
       FOREIGN KEY(sessionid) REFERENCES Session(sid) ON DELETE CASCADE,
       PRIMARY KEY(sid)
);
CREATE TABLE MultipleChoice
(
       sid		INT,
       text		TEXT,
       PRIMARY KEY(sid),
       FOREIGN KEY(sid) REFERENCES Survey(sid) ON DELETE CASCADE        
);
CREATE TABLE FreeResponse
(
       sid		INT,
       text		TEXT,
       PRIMARY KEY(sid),
       FOREIGN KEY(sid) REFERENCES Survey(sid) ON DELETE CASCADE
);
CREATE TABLE Answer
(
	   sid		INT, 
	   text		varchar(1000),
	   uid		INT,
	   PRIMARY KEY(sid, uid),
	   FOREIGN KEY(sid) REFERENCES Survey(sid) ON DELETE CASCADE,
	   FOREIGN KEY(uid) REFERENCES Student(uid) ON DELETE CASCADE
	   ON DELETE CASCADE
);			
CREATE TABLE Choices
(
       sid		INT,
       count		INT,
       text		TEXT,
       FOREIGN KEY(sid) REFERENCES MultipleChoice(sid) ON DELETE CASCADE
);
CREATE TABLE QuestionVotedOn
(
       uid        	INT,
       qid        	INT,
       FOREIGN KEY(qid) REFERENCES Question(qid) ON DELETE CASCADE,
       FOREIGN KEY(uid) REFERENCES Student(uid) ON DELETE CASCADE
);

CREATE TABLE FeedbackVotedOn
(
	uid				INT,
	fid				INT,
	FOREIGN KEY(fid) REFERENCES Feedback(fid) ON DELETE CASCADE,
	FOREIGN KEY(uid) REFERENCES Student(uid) ON DELETE CASCADE
);

CREATE TABLE Joined
(
	sid			INT,
	uid			INT,
	FOREIGN KEY(sid) REFERENCES Session(sid) ON DELETE CASCADE,
	FOREIGN KEY(uid) REFERENCES Student(uid) ON DELETE CASCADE,
	PRIMARY KEY(sid, uid)
);

CREATE TABLE BugReports
(
	summary VARCHAR(100),
	description VARCHAR(1000),
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id)
);
