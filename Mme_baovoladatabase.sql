
Aller au contenu
Utiliser Gmail avec un lecteur d'écran
Activez les notifications sur le bureau pour Gmail.   OK  Non, merci
Conversations
0,01 Go (0 %) utilisés sur 15 Go
Gérer
Conditions d'utilisation · Confidentialité · Règlement du programme
Dernière activité sur le compte : il y a 8 heures
Détails

create database hertz2;
use hertz2;
/*create table Categorie(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	typeVehicule varchar(50))Engine=InnoDB;*/
create table Categorie(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nom varchar(50),
	referenceCateg int null,
	foreign key (referenceCateg) references Categorie(ID))Engine=InnoDB;

/*TABLE*/
create table Vehicule(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nom varchar(250),
	pu decimal(10,2),
	idCategorie int,
	idSousCategorie int,
	datyAjout date,
	place int,
	kilometre varchar(50),
	image varchar(50),
	foreign key (idSousCategorie) references Categorie(ID),
	foreign key (idCategorie) references Categorie(ID))Engine=InnoDB;

create table Region(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nom varchar(50),
	codePays int
	)Engine=InnoDB;
/*AGENCE 
create table Agence(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nom varchar(50),
	
	)Engine=InnoDB;*/
create table Agence2(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nom varchar(50),
	prix decimal(10, 2)
	
	)Engine=InnoDB;
	
create table Users(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	nomUser varchar(50),
	prenomUser varchar(50),
	emailUser varchar(50),
	mdpUser varchar(50),
	statusAdmin int
	)Engine=InnoDB;
/*PANIER*/
create table Panier(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idUser int,
	daty date,
	foreign key (idUser) references Users(ID))Engine=InnoDB;

create table PanierDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idPanier int,
	quantite int,
	pu decimal(10, 2),
	img varchar(50),
	foreign key (idPanier) references Panier(ID))Engine=InnoDB;

	/*LOCATION*/
create table Location(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idUser int,
	daty date,
	foreign key (idUser) references Users(ID))Engine=InnoDB;

create table LocationDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idLocation int,
	dateDebut date,
	dateFin date,
	pu decimal(10, 2),
	img varchar(50),
	foreign key (idLocation) references Location(ID))Engine=InnoDB;

	
	/*Bon de commande*/
create table BonCommande(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idUser int,
	dateCommande date,
	foreign key (idUser) references Users(ID))Engine=InnoDB;

create table BonCommandeDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idBonCommande int,
	idVehicule int,
	pu decimal(10,2),
	quantite date,
	foreign key (idBonCommande) references BonCommande(ID))Engine=InnoDB;

	
	/*Bon de livaison*/
/*create table BonLivraison(
ID INTEGER NOT NULL AUTO_INCREMENT primary key,
idUser int,
idBonCommande int,
status int,
foreign key (idUser) references Users(ID),
foreign key (idBonCommande) references BonCommande(ID))Engine=InnoDB;

create table BonLivraisonDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idBonLivraison int,
	idRegion int,
	Adresse int,
	prix decimal(10,2),
	dateLivraison date,
	foreign key (idBonLivraison) references BonLivraison(ID),
	foreign key (idRegion) references Region(ID))Engine=InnoDB;*/
create table BonLivraison2(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idUser int,
	idLocation int,
	status int,
	foreign key (idUser) references Users(ID),
	foreign key (idLocation) references Location(ID))Engine=InnoDB;

create table BonLivraisonDetail2(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idBonLivraison int,
	idRegion int,
	idAgence int,
	Adresse varchar(100),
	prix decimal(10,2),
	dateLivraison date,
	foreign key (idBonLivraison) references BonLivraison2(ID),
	foreign key (idRegion) references Region(ID),
	foreign key (idAgence) references Agence2(ID))Engine=InnoDB;

	
	/*Facturation*/
create table Facture(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idBonLivraison int,
	idUser int,
	dateFacture date,
	status int,
	foreign key (idUser) references Users(ID),
	foreign key (idBonLivraison) references BonLivraison2(ID))Engine=InnoDB;

create table FactureDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idFacture int,
	montantTotal decimal(10,2),
	idTVA int,
	remise int,
	foreign key (idFacture) references Facture(ID),
	foreign key (idTVA) references TVA(ID))Engine=InnoDB;

	
	/*TVA*/
create table TVA(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	valeur int)Engine=InnoDB;

create table TVAHistorique(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idTVA int,
	valeur int,
	daty date,
	foreign key (idTVA) references TVA(ID))Engine=InnoDB;

	/*PAYEMENT*/
create table Payement(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idFacture int,
	idUser int,
	daty int,
	status int,
	foreign key (idFacture) references Facture(ID),
	foreign key (idUser) references Users(ID))Engine=InnoDB;

create table PayementDetail(
	ID INTEGER NOT NULL AUTO_INCREMENT primary key,
	idPayement int,
	montant decimal(10,2),
	daty date,
	foreign key (idPayement) references Payement(ID))Engine=InnoDB;

	
	

insert into Categorie values(0,'locations',null);
insert into Categorie values(0,'ventes',null);	
	
insert into Categorie values(0,'Voiture de tourisme',1);
insert into Categorie values(0,'Modele Fun',1);
insert into Categorie values(0,'Green collection',1);
insert into Categorie values(0,'Prestige',1);
insert into Categorie values(0,'Family collection',1);
insert into Categorie values(0,'Utilitaire',1);
insert into Categorie values(0,'Special',1);

insert into Categorie values(0,'Prestige',2);
insert into Categorie values(0,'Family collection',2);
insert into Categorie values(0,'Utilitaire',2);
insert into Categorie values(0,'Special',2);



insert into Vehicule values(0,'Fiat 500', 10000, 1, 3, '2018-11-09', 4, '16000km','vt1.jpg');
insert into Vehicule values(0,'Renault Clio', 11000, 1, 3, '2017-11-09', 4, '120000km', 'vt2.jpg');
insert into Vehicule values(0,'Nissan Juke Winter', 13000, 1, 3, '2017-11-19', 4, '122000km', 'vt3.jpg');
insert into Vehicule values(0,'Renault Captur', 20000, 1, 3, '2017-12-29', 5, '50000km', 'vt4.jpg');
insert into Vehicule values(0,'Volkswagen Golf', 21000, 1, 3, '2017-11-19', 4, '30000km', 'vt5.jpg');
insert into Vehicule values(0,'Peugeot 508', 23000, 1, 3, '2017-12-10', 7, '129000km', 'vt6.jpg');
insert into Vehicule values(0,'Peugeot 2008', 23000, 1, 3, '2017-11-22', 5, '120000km', 'vt7.jpg');


insert into Vehicule values(0,'Fiat 500C', 120000, 1, 4, '2018-01-23', 4, '220000km', 'vf1.jpg');
insert into Vehicule values(0,'Citroen DS3 Softroof', 50000, 1, 4, '2017-10-12', 4, '320000km', 'vf2.jpg');
insert into Vehicule values(0,'Mini Cooper 5', 20000, 1, 4, '2018-01-12', 4, '90000km', 'vf3.jpg');
insert into Vehicule values(0,'Mercedes Class ', 300000, 1, 4, '2017-11-02', 4, '12000km', 'vf4.jpg');
insert into Vehicule values(0,'Audi Q2', 50000, 1, 4, '2017-12-15', 4, '110000km', 'vf5.jpg');




/*insert into Vehicule values(0,'Jog 50cc', 20000, 2, 7, '2017-12-29');
insert into Vehicule values(0,'Jog 100cc', 22000, 2, 7, '2017-10-22');
insert into Vehicule values(0,'Jog 70cc', 20000, 2, 7, '2018-01-11');
insert into Vehicule values(0,'transporteur', 500000,3 , 8, '2017-12-12');
insert into Vehicule values(0,'van', 500000,3 , 9, '2017-12-12');
insert into Vehicule values(0,'volks wagen type 3', 200000,1 , 5, '2017-11-13');
insert into Vehicule values(0,'caen 2', 500000,3 , 9, '2018-01-14');
*/
INSERT INTO Users values(0,'Lock to hang', 'Angelo','parkedenne@gmail.com',sha1('qwerty'), 0);
INSERT INTO Users values(0,'Lock', 'Julio','julio@gmail.com',sha1('azerty'), 0);
INSERT INTO Users values(0,'Admin', 'admin','admin@gmail.com',sha1('admin'), 1);




INSERT INTO Region values(0,'Madagascar','101');
INSERT INTO Region values(0,'Madagascar','102');
INSERT INTO Region values(0,'France','63000');

/*
INSERT INTO Agence values(0,'DHL');
INSERT INTO Agence values(0,'Fedex');
INSERT INTO Agence values(0,'EPRESS');
*/
INSERT INTO Agence2 values(0,'DHL', 100000);
INSERT INTO Agence2 values(0,'Fedex', 50000);
INSERT INTO Agence2 values(0,'EPRESS', 60000);

INSERT INTO TVA values(0, 20);




/*VIEWS*/
CREATE VIEW  Article2 AS SELECT a.ID, a.nom, a.pu, categ.nom AS nomCategorie, categ2.nom AS nomSousCategorie, a.datyAjout
FROM Article a
join Categorie categ
ON a.idCategorie = categ.ID
join Categorie categ2
ON a.idSousCategorie = categ2.ID;
	
CREATE VIEW  ArticleByConcat AS SELECT id, 
CONCAT(nom, "|", pu, "|", nomCategorie,"|", nomSousCategorie, "|", datyAjout) AS article
FROM Article2;

Bdd.sql
Affichage de Bdd.sql en cours...