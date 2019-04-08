DROP TABLE IF EXISTS utilisateur ;
CREATE TABLE utilisateur (
    idUtilisateur INT AUTO_INCREMENT NOT NULL,
    pseudo VARCHAR(45),
    email VARCHAR(250),
    statut INT, 
    motdepasse VARCHAR(255),
    dateInscription DATETIME,
PRIMARY KEY (idUtilisateur)) ENGINE=InnoDB; 

DROP TABLE IF EXISTS questionnaire ;
CREATE TABLE questionnaire (
    idQuestionnaire INT AUTO_INCREMENT NOT NULL,
    titreQuestionnaire VARCHAR(250), 
    etat INT NOT NULL ,
    dateQuestionnaire DATETIME,
    dateModification DATETIME,
    idUtilisateur INT NOT NULL,
    idCategorie INT NOT NULL,
PRIMARY KEY (idQuestionnaire)) ENGINE=InnoDB; 

DROP TABLE IF EXISTS categorie ;
CREATE TABLE categorie (
    idCategorie INT AUTO_INCREMENT NOT NULL,
    nomCategorie VARCHAR(45), 
    couleur VARCHAR(10) ,
    icon VARCHAR(250),
PRIMARY KEY (idCategorie)) ENGINE=InnoDB;

DROP TABLE IF EXISTS note ;
CREATE TABLE note (
    idNote INT AUTO_INCREMENT NOT NULL,
    note INT NOT NULL,
PRIMARY KEY (idNote)) ENGINE=InnoDB;

DROP TABLE IF EXISTS reçoit ;
CREATE TABLE reçoit (
    idReçoit INT AUTO_INCREMENT NOT NULL,
    idNote INT NOT NULL, 
    idQuestionnaire INT NOT NULL,
PRIMARY KEY (idReçoit)) ENGINE=InnoDB;

DROP TABLE IF EXISTS question ;
CREATE TABLE question (
    idQuestion INT AUTO_INCREMENT NOT NULL,
    question VARCHAR(250),
    choix JSON,
    idQuestionnaire INT NOT NULL, 
PRIMARY KEY (idQuestion)) ENGINE=InnoDB;



ALTER TABLE questionnaire ADD CONSTRAINT FK_questionnaire_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (idUtilisateur);
ALTER TABLE questionnaire ADD CONSTRAINT FK_questionnaire_idCategorie FOREIGN KEY (idCategorie) REFERENCES categorie (idCategorie);
ALTER TABLE question ADD CONSTRAINT FK_question_idQuestionnaire FOREIGN KEY (idQuestionnaire) REFERENCES questionnaire (idQuestionnaire);
ALTER TABLE reçoit ADD CONSTRAINT FK_reçoit_idNote FOREIGN KEY (idNote) REFERENCES note (idNote);
ALTER TABLE reçoit ADD CONSTRAINT FK_reçoit_idQuestionnaire FOREIGN KEY (idQuestionnaire) REFERENCES questionnaire (idQuestionnaire);



