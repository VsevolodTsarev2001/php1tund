CREATE TABLE konkurss(
                         id int PRIMARY KEY AUTO_INCREMENT,
                         konkursiNimi varchar(100),
                         lisamisaeg datetime,
                         kommentaarid TEXT,
                         punktid int,
                         avalik int DEFAULT 1);

INSERT into konkurss (konkursiNimi, punktid, lisamisaeg)
VALUES ('jõulukaart', 5, '2024-12-02');

SELECT * FROM konkurss;

UPDATE konkurss SET punktid=punktid+1
WHERE id=1;