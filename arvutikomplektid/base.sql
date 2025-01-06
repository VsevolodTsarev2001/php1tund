CREATE TABLE konkurss(
                         id int PRIMARY KEY AUTO_INCREMENT,
                         kirjeldus TEXT,
                         korpus BOOLEAN DEFAULT 0,
                         kuvar BOOLEAN DEFAULT 0,
                         pakitud BOOLEAN DEFAULT 0);