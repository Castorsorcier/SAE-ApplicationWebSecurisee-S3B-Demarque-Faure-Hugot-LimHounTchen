DROP TABLE commentaire;
DROP TABLE utilisateur;
DROP TABLE liste;

CREATE TABLE utilisateur (
	email varchar(30),
	passwd varchar(100),
	nom varchar(30),
	prenom varchar(30),
	genrePref varchar(30),
	numCarte int,

CONSTRAINT PK PRIMARY KEY (email));

CREATE TABLE commentaire (
	email varchar(30),
	id int,
	comment varchar(1000),
	note int,

CONSTRAINT PK PRIMARY KEY (email, id),
CONSTRAINT FK1_commentaire FOREIGN KEY (email) REFERENCES utilisateur(email),
CONSTRAINT FK2_commentaire FOREIGN KEY (id) REFERENCES serie(id));


CREATE TABLE liste (
	idListe int,
	nomListe varchar(30), -- jamais utilisé

CONSTRAINT PK PRIMARY KEY (idListe));

CREATE TABLE liste2utilisateur (
	idListe int,
	email varchar(30),
	id int,

CONSTRAINT PK PRIMARY KEY (idListe, email, id),
CONSTRAINT FK1_l2u FOREIGN KEY (idListe) REFERENCES liste(idListe),
CONSTRAINT FK2_l2u FOREIGN KEY (email) REFERENCES utilisateur(email),
CONSTRAINT FK3_l2u FOREIGN KEY (id) REFERENCES serie(id));

/* je vous recommande de creer l'utilisateur test (email=test@hotmail.com passwd=test)
sur le site avant d'inserer le commentaire pour que le mdp test soit hasher et puisse fonctionner*/

INSERT INTO commentaire VALUES ('test@hotmail.com',1,'C\'est trop bien parce que c\'est trop cool !');

INSERT INTO liste VALUES (1,'SeriesPref'), (2,'SeriesDejaVue'),(3,'SeriesEnCours');

/*Ensuite vous pouvez vous amuser à mettre ou supprimer des series dans votre liste de favories ^^ */