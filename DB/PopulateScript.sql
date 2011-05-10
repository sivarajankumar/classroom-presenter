
INSERT INTO User (uid, email, pass_hash)
VALUES (12345, 'alice@foo.com', 'abcdefg');
INSERT INTO User (uid, email, pass_hash)
VALUES (23456, 'bob@foo.com', 'bcdefgh');

INSERT INTO Student (uid, spam_count)
VALUES (23456, 0);

INSERT INTO Instructor (uid)
VALUES (12345);

INSERT INTO Course(cid, name, mailinglist)
VALUES (11111, 'CSE403', 'cse403_sp11@foo.com');

INSERT INTO Attends(uid, cid)
VALUES (23456, 11111);

INSERT INTO Teaches(uid, cid)
VALUES (12345, 11111);

INSERT INTO Session(sid, cid, TimeStamp)
VALUES (22222, 11111, '1970-01-01 00:00:01');

INSERT INTO Feedback(fid, numvotes, isread, text, sid)
VALUES (34567, 3, 0, 'feedback here', 22222);

INSERT INTO Question(qid, text, numvotes, answered, sid)
VALUES (65432, 'question here', 4, 0, 22222);

INSERT INTO Survey(sid, sessionid)
VALUES (33333, 22222);
INSERT INTO Survey(sid, sessionid)
VALUES (44444, 22222);

INSERT INTO MultipleChoice(sid, text)
VALUES (33333, 'multiple choice question');

INSERT INTO FreeResponse(frid, sid, text)
VALUES (44444, 44444, 'free response question');

INSERT INTO Choices(sid, count, text)
VALUES (33333, 0, 'choice one');
INSERT INTO Choices(sid, count, text)
VALUES (33333, 1, 'choice two');
INSERT INTO Choices(sid, count, text)
VALUES (33333, 3, 'choice three');

INSERT INTO VotedOn(uid, qid)
VALUES (23456, 65432);
