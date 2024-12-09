CREATE TABLE kaubagrupid(
                            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            grupinimi VARCHAR(255)
);

INSERT INTO kaubagrupid(grupinimi) VALUES ('tellised');
INSERT INTO kaubagrupid(grupinimi) VALUES ('katusematerjal');

CREATE TABLE kaubad(
                       id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       nimetus VARCHAR(255),
                       kaubagrupi_id INT,
                       hind DECIMAL(10, 2)
);

INSERT INTO kaubad (nimetus, kaubagrupi_id, hind) VALUES ('ahjutellis', 1, 8.20);
INSERT INTO kaubad (nimetus, kaubagrupi_id, hind) VALUES ('fassaaditellis', 1, 7.50);
INSERT INTO kaubad (nimetus, kaubagrupi_id, hind) VALUES ('bituumenrull', 2, 520);

SELECT * FROM kaubad;
SELECT * FROM kaubagrupid;

SELECT nimetus, grupinimi, hind
FROM kaubad, kaubagrupid
WHERE kaubad.kaubagrupi_id=kaubagrupid.id;

SELECT nimetus, grupinimi, hind
FROM kaubad, kaubagrupid
WHERE kaubad.kaubagrupi_id=kaubagrupid.id
  AND nimetus LIKE '%tellis%';