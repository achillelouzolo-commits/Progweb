CREATE DATABASE IF NOT EXISTS mondial_2026 CHARACTER SET utf8mb4;
USE mondial_2026;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS match_equipes;
DROP TABLE IF EXISTS groupe_equipes;
DROP TABLE IF EXISTS matchs;
DROP TABLE IF EXISTS stades;
DROP TABLE IF EXISTS details_equipes;
DROP TABLE IF EXISTS equipes;
DROP TABLE IF EXISTS groupes;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE groupes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lettre CHAR(1) UNIQUE NOT NULL
);

CREATE TABLE equipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(60) UNIQUE NOT NULL,
    code_pays CHAR(2) NOT NULL,
    classement_fifa INT NOT NULL,
    confederation VARCHAR(20) NOT NULL
);

CREATE TABLE details_equipes (
    equipe_id INT PRIMARY KEY,
    surnom VARCHAR(80),
    nombre_cdm INT DEFAULT 0,
    entraineur VARCHAR(80),
    FOREIGN KEY (equipe_id) REFERENCES equipes(id) ON DELETE CASCADE
);

CREATE TABLE stades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(80) UNIQUE NOT NULL
);

CREATE TABLE matchs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    groupe_id INT NOT NULL,
    stade_id INT NOT NULL,
    date_match DATETIME NOT NULL,
    FOREIGN KEY (groupe_id) REFERENCES groupes(id),
    FOREIGN KEY (stade_id) REFERENCES stades(id)
);

CREATE TABLE groupe_equipes (
    groupe_id INT NOT NULL,
    equipe_id INT UNIQUE NOT NULL,
    PRIMARY KEY (groupe_id, equipe_id),
    FOREIGN KEY (groupe_id) REFERENCES groupes(id),
    FOREIGN KEY (equipe_id) REFERENCES equipes(id) ON DELETE CASCADE
);


CREATE TABLE match_equipes (
    match_id INT NOT NULL,
    equipe_id INT NOT NULL,
    PRIMARY KEY (match_id, equipe_id),
    FOREIGN KEY (match_id) REFERENCES matchs(id) ON DELETE CASCADE,
    FOREIGN KEY (equipe_id) REFERENCES equipes(id) ON DELETE CASCADE
);

INSERT INTO groupes (lettre) VALUES ('A'),('B'),('C'),('D'),('E'),('F'),('G'),('H'),('I'),('J'),('K'),('L');

DELIMITER //
CREATE PROCEDURE ajouter_equipe(
    IN lettre_groupe CHAR(1), IN nom_equipe VARCHAR(60), IN code CHAR(2),
    IN rang INT, IN conf VARCHAR(20), IN surnom_equipe VARCHAR(80),
    IN nb_titres INT, IN nom_entraineur VARCHAR(80)
)
BEGIN
    DECLARE equipe_creee INT;
    INSERT INTO equipes VALUES (NULL,nom_equipe,code,rang,conf);
    SET equipe_creee=LAST_INSERT_ID();
    INSERT INTO details_equipes
    VALUES (equipe_creee,NULLIF(surnom_equipe,''),nb_titres,nom_entraineur);
    INSERT INTO groupe_equipes
    SELECT id,equipe_creee FROM groupes WHERE lettre=lettre_groupe;
END //
DELIMITER ;


CALL ajouter_equipe('A','Mexique','MX',15,'CONCACAF','El Tri',0,'Javier Aguirre');
CALL ajouter_equipe('A','Afrique du Sud','ZA',55,'CAF','Bafana Bafana',0,'Hugo Broos');
CALL ajouter_equipe('A','Corée du Sud','KR',23,'AFC','Taegeuk Warriors',0,'Hong Myung-bo');
CALL ajouter_equipe('A','Tchéquie','CZ',42,'UEFA','',0,'Miroslav Koubek');
CALL ajouter_equipe('B','Canada','CA',26,'CONCACAF','Les Rouges',0,'Jesse Marsch');
CALL ajouter_equipe('B','Qatar','QA',51,'AFC','Al-Annabi',0,'Julen Lopetegui');
CALL ajouter_equipe('B','Suisse','CH',17,'UEFA','La Nati',0,'Murat Yakin');
CALL ajouter_equipe('B','Bosnie-Herzégovine','BA',68,'UEFA','Les Dragons',0,'Sergej Barbarez');
CALL ajouter_equipe('C','Brésil','BR',5,'CONMEBOL','Seleção',5,'Carlo Ancelotti');
CALL ajouter_equipe('C','Maroc','MA',11,'CAF','Lions de l’Atlas',0,'Mohamed Ouahbi');
CALL ajouter_equipe('C','Écosse','GB',38,'UEFA','Tartan Army',0,'Steve Clarke');
CALL ajouter_equipe('C','Haïti','HT',83,'CONCACAF','Grenadiers',0,'Sébastien Migné');
CALL ajouter_equipe('D','États-Unis','US',14,'CONCACAF','Team USA',0,'Mauricio Pochettino');
CALL ajouter_equipe('D','Paraguay','PY',39,'CONMEBOL','La Albirroja',0,'Gustavo Alfaro');
CALL ajouter_equipe('D','Australie','AU',25,'AFC','Socceroos',0,'Tony Popovic');
CALL ajouter_equipe('D','Türkiye','TR',27,'UEFA','Ay-Yıldızlılar',0,'Vincenzo Montella');
CALL ajouter_equipe('E','Allemagne','DE',9,'UEFA','Die Mannschaft',4,'Julian Nagelsmann');
CALL ajouter_equipe('E','Côte d’Ivoire','CI',45,'CAF','Les Éléphants',0,'Emerse Faé');
CALL ajouter_equipe('E','Équateur','EC',24,'CONMEBOL','La Tri',0,'Sebastián Beccacece');
CALL ajouter_equipe('E','Curaçao','CW',81,'CONCACAF','',0,'Dick Advocaat');
CALL ajouter_equipe('F','Suède','SE',29,'UEFA','Blågult',0,'Graham Potter');
CALL ajouter_equipe('F','Japon','JP',18,'AFC','Samurai Blue',0,'Hajime Moriyasu');
CALL ajouter_equipe('F','Pays-Bas','NL',7,'UEFA','Oranje',0,'Ronald Koeman');
CALL ajouter_equipe('F','Tunisie','TN',47,'CAF','Aigles de Carthage',0,'Hervé Renard');
CALL ajouter_equipe('G','Belgique','BE',8,'UEFA','Diables Rouges',0,'Rudi Garcia');
CALL ajouter_equipe('G','Iran','IR',20,'AFC','Team Melli',0,'Amir Ghalenoei');
CALL ajouter_equipe('G','Égypte','EG',31,'CAF','Les Pharaons',0,'Hossam Hassan');
CALL ajouter_equipe('G','Nouvelle-Zélande','NZ',86,'OFC','All Whites',0,'Darren Bazeley');
CALL ajouter_equipe('H','Espagne','ES',1,'UEFA','La Roja',1,'Luis de la Fuente');
CALL ajouter_equipe('H','Uruguay','UY',16,'CONMEBOL','La Celeste',2,'Marcelo Bielsa');
CALL ajouter_equipe('H','Arabie saoudite','SA',56,'AFC','Les Faucons Verts',0,'Georgios Donis');
CALL ajouter_equipe('H','Cap-Vert','CV',62,'CAF','Requins Bleus',0,'Bubista');
CALL ajouter_equipe('I','France','FR',3,'UEFA','Les Bleus',2,'Didier Deschamps');
CALL ajouter_equipe('I','Norvège','NO',28,'UEFA','Løvene',0,'Ståle Solbakken');
CALL ajouter_equipe('I','Sénégal','SN',19,'CAF','Lions de la Téranga',0,'Pape Thiaw');
CALL ajouter_equipe('I','Irak','IQ',58,'AFC','Lions de Mésopotamie',0,'Graham Arnold');
CALL ajouter_equipe('J','Argentine','AR',2,'CONMEBOL','Albiceleste',3,'Lionel Scaloni');
CALL ajouter_equipe('J','Autriche','AT',22,'UEFA','Das Team',0,'Ralf Rangnick');
CALL ajouter_equipe('J','Jordanie','JO',63,'AFC','Al-Nashama',0,'Jamal Sellami');
CALL ajouter_equipe('J','Algérie','DZ',36,'CAF','Les Fennecs',0,'Vladimir Petković');
CALL ajouter_equipe('K','Portugal','PT',6,'UEFA','A Seleção',0,'Roberto Martínez');
CALL ajouter_equipe('K','Colombie','CO',13,'CONMEBOL','Los Cafeteros',0,'Néstor Lorenzo');
CALL ajouter_equipe('K','RD Congo','CD',57,'CAF','Les Léopards',0,'Sébastien Desabre');
CALL ajouter_equipe('K','Ouzbékistan','UZ',50,'AFC','Loups Blancs',0,'Fabio Cannavaro');
CALL ajouter_equipe('L','Angleterre','GB',4,'UEFA','Three Lions',1,'Thomas Tuchel');
CALL ajouter_equipe('L','Ghana','GH',64,'CAF','Black Stars',0,'Carlos Queiroz');
CALL ajouter_equipe('L','Panama','PA',32,'CONCACAF','Los Canaleros',0,'Thomas Christiansen');
CALL ajouter_equipe('L','Croatie','HR',10,'UEFA','Vatreni',0,'Zlatko Dalić');

DROP PROCEDURE ajouter_equipe;

DELIMITER //
CREATE PROCEDURE ajouter_match(
    IN lettre_groupe CHAR(1),
    IN horaire_france DATETIME,
    IN nom_stade VARCHAR(80),
    IN nom_equipe1 VARCHAR(60),
    IN nom_equipe2 VARCHAR(60)
)
BEGIN
    DECLARE groupe INT;
    DECLARE stade INT;
    DECLARE nouveau_match INT;
    SELECT id INTO groupe FROM groupes WHERE lettre=lettre_groupe;
    INSERT IGNORE INTO stades (nom) VALUES (nom_stade);
    SELECT id INTO stade FROM stades WHERE nom=nom_stade;
    INSERT INTO matchs VALUES (NULL,groupe,stade,horaire_france);
    SET nouveau_match=LAST_INSERT_ID();
    INSERT INTO match_equipes
    SELECT nouveau_match,id FROM equipes WHERE nom IN (nom_equipe1,nom_equipe2);
END //
DELIMITER ;

CALL ajouter_match('A','2026-06-11 21:00:00','Estadio Azteca','Mexique','Afrique du Sud');
CALL ajouter_match('A','2026-06-12 04:00:00','Estadio Akron','Corée du Sud','Tchéquie');
CALL ajouter_match('A','2026-06-18 18:00:00','Mercedes-Benz Stadium','Tchéquie','Afrique du Sud');
CALL ajouter_match('A','2026-06-19 03:00:00','Estadio Akron','Mexique','Corée du Sud');
CALL ajouter_match('A','2026-06-25 03:00:00','Estadio Azteca','Tchéquie','Mexique');
CALL ajouter_match('A','2026-06-25 03:00:00','Estadio BBVA','Afrique du Sud','Corée du Sud');
CALL ajouter_match('B','2026-06-12 21:00:00','BMO Field','Canada','Bosnie-Herzégovine');
CALL ajouter_match('B','2026-06-13 21:00:00','Levi''s Stadium','Qatar','Suisse');
CALL ajouter_match('B','2026-06-18 21:00:00','SoFi Stadium','Suisse','Bosnie-Herzégovine');
CALL ajouter_match('B','2026-06-19 00:00:00','BC Place','Canada','Qatar');
CALL ajouter_match('B','2026-06-24 21:00:00','BC Place','Suisse','Canada');
CALL ajouter_match('B','2026-06-24 21:00:00','Lumen Field','Bosnie-Herzégovine','Qatar');
CALL ajouter_match('C','2026-06-14 00:00:00','MetLife Stadium','Brésil','Maroc');
CALL ajouter_match('C','2026-06-14 03:00:00','Gillette Stadium','Haïti','Écosse');
CALL ajouter_match('C','2026-06-20 00:00:00','Gillette Stadium','Écosse','Maroc');
CALL ajouter_match('C','2026-06-20 02:30:00','Lincoln Financial Field','Brésil','Haïti');
CALL ajouter_match('C','2026-06-25 00:00:00','Hard Rock Stadium','Écosse','Brésil');
CALL ajouter_match('C','2026-06-25 00:00:00','Mercedes-Benz Stadium','Maroc','Haïti');
CALL ajouter_match('D','2026-06-13 03:00:00','SoFi Stadium','États-Unis','Paraguay');
CALL ajouter_match('D','2026-06-14 06:00:00','BC Place','Australie','Türkiye');
CALL ajouter_match('D','2026-06-19 21:00:00','Lumen Field','États-Unis','Australie');
CALL ajouter_match('D','2026-06-20 05:00:00','Levi''s Stadium','Türkiye','Paraguay');
CALL ajouter_match('D','2026-06-26 04:00:00','SoFi Stadium','Türkiye','États-Unis');
CALL ajouter_match('D','2026-06-26 04:00:00','Levi''s Stadium','Paraguay','Australie');
CALL ajouter_match('E','2026-06-14 19:00:00','NRG Stadium','Allemagne','Curaçao');
CALL ajouter_match('E','2026-06-15 01:00:00','Lincoln Financial Field','Côte d’Ivoire','Équateur');
CALL ajouter_match('E','2026-06-20 22:00:00','BMO Field','Allemagne','Côte d’Ivoire');
CALL ajouter_match('E','2026-06-21 02:00:00','Arrowhead Stadium','Équateur','Curaçao');
CALL ajouter_match('E','2026-06-25 22:00:00','Lincoln Financial Field','Curaçao','Côte d’Ivoire');
CALL ajouter_match('E','2026-06-25 22:00:00','MetLife Stadium','Équateur','Allemagne');
CALL ajouter_match('F','2026-06-14 22:00:00','AT&T Stadium','Pays-Bas','Japon');
CALL ajouter_match('F','2026-06-15 04:00:00','Estadio BBVA','Suède','Tunisie');
CALL ajouter_match('F','2026-06-20 19:00:00','NRG Stadium','Pays-Bas','Suède');
CALL ajouter_match('F','2026-06-21 06:00:00','Estadio BBVA','Tunisie','Japon');
CALL ajouter_match('F','2026-06-26 01:00:00','AT&T Stadium','Japon','Suède');
CALL ajouter_match('F','2026-06-26 01:00:00','Arrowhead Stadium','Tunisie','Pays-Bas');
CALL ajouter_match('G','2026-06-15 21:00:00','Lumen Field','Belgique','Égypte');
CALL ajouter_match('G','2026-06-16 03:00:00','SoFi Stadium','Iran','Nouvelle-Zélande');
CALL ajouter_match('G','2026-06-21 21:00:00','SoFi Stadium','Belgique','Iran');
CALL ajouter_match('G','2026-06-22 03:00:00','BC Place','Nouvelle-Zélande','Égypte');
CALL ajouter_match('G','2026-06-27 05:00:00','Lumen Field','Égypte','Iran');
CALL ajouter_match('G','2026-06-27 05:00:00','BC Place','Nouvelle-Zélande','Belgique');
CALL ajouter_match('H','2026-06-15 18:00:00','Mercedes-Benz Stadium','Espagne','Cap-Vert');
CALL ajouter_match('H','2026-06-16 00:00:00','Hard Rock Stadium','Arabie saoudite','Uruguay');
CALL ajouter_match('H','2026-06-21 18:00:00','Mercedes-Benz Stadium','Espagne','Arabie saoudite');
CALL ajouter_match('H','2026-06-22 00:00:00','Hard Rock Stadium','Uruguay','Cap-Vert');
CALL ajouter_match('H','2026-06-27 02:00:00','NRG Stadium','Cap-Vert','Arabie saoudite');
CALL ajouter_match('H','2026-06-27 02:00:00','Estadio Akron','Uruguay','Espagne');
CALL ajouter_match('I','2026-06-16 21:00:00','MetLife Stadium','France','Sénégal');
CALL ajouter_match('I','2026-06-17 00:00:00','Gillette Stadium','Irak','Norvège');
CALL ajouter_match('I','2026-06-22 23:00:00','Lincoln Financial Field','France','Irak');
CALL ajouter_match('I','2026-06-23 02:00:00','MetLife Stadium','Norvège','Sénégal');
CALL ajouter_match('I','2026-06-26 21:00:00','Gillette Stadium','Norvège','France');
CALL ajouter_match('I','2026-06-26 21:00:00','BMO Field','Sénégal','Irak');
CALL ajouter_match('J','2026-06-17 03:00:00','Arrowhead Stadium','Argentine','Algérie');
CALL ajouter_match('J','2026-06-17 06:00:00','Levi''s Stadium','Autriche','Jordanie');
CALL ajouter_match('J','2026-06-22 19:00:00','AT&T Stadium','Argentine','Autriche');
CALL ajouter_match('J','2026-06-23 05:00:00','Levi''s Stadium','Jordanie','Algérie');
CALL ajouter_match('J','2026-06-28 04:00:00','Arrowhead Stadium','Algérie','Autriche');
CALL ajouter_match('J','2026-06-28 04:00:00','AT&T Stadium','Jordanie','Argentine');
CALL ajouter_match('K','2026-06-17 19:00:00','NRG Stadium','Portugal','RD Congo');
CALL ajouter_match('K','2026-06-18 04:00:00','Estadio Azteca','Ouzbékistan','Colombie');
CALL ajouter_match('K','2026-06-23 19:00:00','NRG Stadium','Portugal','Ouzbékistan');
CALL ajouter_match('K','2026-06-24 04:00:00','Estadio Akron','Colombie','RD Congo');
CALL ajouter_match('K','2026-06-28 01:30:00','Hard Rock Stadium','Colombie','Portugal');
CALL ajouter_match('K','2026-06-28 01:30:00','Mercedes-Benz Stadium','RD Congo','Ouzbékistan');
CALL ajouter_match('L','2026-06-17 22:00:00','AT&T Stadium','Angleterre','Croatie');
CALL ajouter_match('L','2026-06-18 01:00:00','BMO Field','Ghana','Panama');
CALL ajouter_match('L','2026-06-23 22:00:00','Gillette Stadium','Angleterre','Ghana');
CALL ajouter_match('L','2026-06-24 01:00:00','BMO Field','Panama','Croatie');
CALL ajouter_match('L','2026-06-27 23:00:00','MetLife Stadium','Panama','Angleterre');
CALL ajouter_match('L','2026-06-27 23:00:00','Lincoln Financial Field','Croatie','Ghana');

DROP PROCEDURE ajouter_match;
