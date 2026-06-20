DROP TABLE IF EXISTS Selection;
DROP TABLE IF EXISTS Groupe;
DROP TABLE IF EXISTS GS;
DROP TABLE IF EXISTS Stade;
DROP TABLE IF EXISTS Matchs;

CREATE TABLE Selection (
    idSelection NUMBER PRIMARY KEY,
    Nom VARCHAR2(50),
    Continent VARCHAR2(50),
    Selectionneur VARCHAR2(50),
    Confederation VARCHAR(20),
    ClassementFifa NUMBER
);

CREATE TABLE Groupe (
    idGroupe NUMBER PRIMARY KEY,
    NomGroupe VARCHAR2(1)
);

CREATE TABLE GS (
    idGroupe NUMBER,
    idSelection NUMBER,
    PRIMARY KEY(idGroupe, idSelection),
    FOREIGN KEY (idSelection) REFERENCES Selection(idSelection),
    FOREIGN KEY (idGroupe) REFERENCES Groupe(idGroupe)
);

CREATE TABLE Stade (
    idStade NUMBER PRIMARY KEY,
    Ville VARCHAR2(50),
    Pays VARCHAR2(50),
    Capacite NUMBER
);

CREATE TABLE Matchs (
    idMatch NUMBER PRIMARY KEY,
    idSelection1 NUMBER,
    idSelection2 NUMBER,
    idStade NUMBER,
    DateMatch DATE,
    FOREIGN KEY (idSelection1) REFERENCES Selection(idSelection),
    FOREIGN KEY (idSelection2) REFERENCES Selection(idSelection),
    FOREIGN KEY (idStade) REFERENCES Stade(idStade)
);
