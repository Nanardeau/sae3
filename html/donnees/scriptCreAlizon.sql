DROP SCHEMA IF EXISTS alizon CASCADE;
CREATE SCHEMA alizon;
SET SCHEMA 'alizon';

CREATE TABLE Compte(
    codeCompte SERIAL PRIMARY KEY NOT NULL,
    dateCreation DATE,
    nom VARCHAR(20),
    prenom VARCHAR(20),
    email VARCHAR(50) NOT NULL,
    mdp VARCHAR(20) NOT NULL,
    numTel VARCHAR(20)
);
CREATE TABLE Adresse(
    idAdresse SERIAL PRIMARY KEY NOT NULL,
    num VARCHAR(20) NOT NULL,
	nomRue VARCHAR(50) NOT NULL,
    codePostal VARCHAR(20) NOT NULL,
    nomVille VARCHAR(20) NOT NULL, 
	numAppart VARCHAR(20),
    complementAdresse VARCHAR(20)
);

CREATE TABLE Client(
    pseudo VARCHAR(20) NOT NULL,
    cmtBlq BOOLEAN,
    cmtBlqMod BOOLEAN,
	UNIQUE(codeCompte)
) INHERITS (Compte);

CREATE TABLE AdrFactCli(
	codeCompte INTEGER NOT NULL REFERENCES Client(codeCompte),
	idAdresse INTEGER NOT NULL REFERENCES Adresse(idAdresse)
);

CREATE TABLE Gestionaire(UNIQUE(codeCompte)) INHERITS (Compte);

CREATE TABLE Vendeur(
    SIREN VARCHAR(20) UNIQUE,
    raisonSociale VARCHAR(20),
	idAdresseSiege INTEGER REFERENCES Adresse(idAdresse),
	UNIQUE(codeCompte)
) INHERITS (Compte);

CREATE TABLE AdrSiegeSocial(
	codeCompte INTEGER NOT NULL REFERENCES Vendeur(codeCompte),
	idAdresse INTEGER NOT NULL REFERENCES Adresse(idAdresse)
);

CREATE TABLE TVA(
    nomTVA VARCHAR(20) PRIMARY KEY NOT NULL CHECK (nomTVA IN ('normale', 'réduite', 'super-réduite')),
    tauxTVA FLOAT 
);
CREATE TABLE Photo(
    urlPhoto VARCHAR(40) PRIMARY KEY NOT NULL
);
CREATE TABLE Produit(
    codeProduit SERIAL PRIMARY KEY NOT NULL,
    libelleProd VARCHAR(200) NOT NULL,
    descriptionProd VARCHAR(200) NOT NULL,
    prixHT  FLOAT NOT NULL,
    nomTVA VARCHAR(20) REFERENCES TVA(nomTVA),--LIEN AVEC TVA
    prixTTC  NUMERIC,
    hauteur FLOAT, --en mètre
    longueur FLOAT, --en mètre
    largeur FLOAT, --en mètre
    qteStock NUMERIC(10,2) NOT NULL DEFAULT 0,
    seuilAlerte NUMERIC(10,2) NOT NULL,
    urlPhoto VARCHAR(40) REFERENCES Photo(urlPhoto),
    codeCompteVendeur INTEGER REFERENCES Vendeur(codeCompte)	
);



CREATE TABLE Categorie(
    libelleCat VARCHAR(20) PRIMARY KEY NOT NULL
);

CREATE TABLE SousCat(
    libCat VARCHAR(20) REFERENCES Categorie(libelleCat),
    libSousCat VARCHAR(20) REFERENCES Categorie(libelleCat),
    PRIMARY KEY(LibCat,LibSousCat)
);

CREATE TABLE Categoriser(
	codeProduit INTEGER NOT NULL REFERENCES Produit(codeProduit),
	libelleCat VARCHAR(20) NOT NULL REFERENCES Categorie(libelleCat),
	PRIMARY KEY(codeProduit, libelleCat)
);

CREATE TABLE Reduction(
	idReduction SERIAL PRIMARY KEY NOT NULL,
    dateDebut DATE,
    dateFin DATE,
    remise FLOAT
);
CREATE TABLE Promotion(
	idPromotion SERIAL PRIMARY KEY NOT NULL,
    dateDebut DATE,
    dateFin DATE
);

CREATE TABLE Facture(
    noFact SERIAL PRIMARY KEY NOT NULL,
    montantFact FLOAT,
    nomDest VARCHAR(20),
    prenomDest VARCHAR(20),
    idAdresseFact INTEGER REFERENCES Adresse(idAdresse)
);
CREATE TABLE Banque(
    numCarte VARCHAR(20) PRIMARY KEY NOT NULL,
    nomTit VARCHAR(20),
    prenomTit VARCHAR(20),
    CVC NUMERIC(3,0),
    dateExp DATE
);

CREATE TABLE Panier(
    idPanier SERIAL PRIMARY KEY NOT NULL,
    codeCompte INTEGER REFERENCES Client(codeCompte),
    dateCreaP DATE,
    prixTTCtotal FLOAT,
    prixHTtotal FLOAT
);

CREATE TABLE Commande(
    numCom SERIAL PRIMARY KEY NOT NULL,
    dateCom DATE,
    prixTTCtotal FLOAT, 
    prixHTtotal FLOAT,
    numCarte VARCHAR(20) REFERENCES Banque(numCarte)
);
CREATE TABLE Livraison(
    idLivraison SERIAL PRIMARY KEY NOT NULL,
    dateCommande DATE,
    dateEncaissement DATE,
    datePreparation DATE,
    dateExpedition DATE,
    statutLiv VARCHAR(20)
);

CREATE TABLE Avis(
    numAvis SERIAL PRIMARY KEY NOT NULL,
	codeProduit INTEGER REFERENCES Produit(codeProduit),
	codeCompteCli INTEGER REFERENCES Client(codeCompte),
    noteProd FLOAT,
    commentaire VARCHAR(20),
    datePublication DATE
);

CREATE TABLE Reponse(
    numReponse SERIAL PRIMARY KEY NOT NULL,
	numAvis INTEGER REFERENCES Avis(numAvis),
	dateReponse DATE,
    commentaire VARCHAR(20)
);

CREATE TABLE Signalement(
    idSignalement SERIAL PRIMARY KEY NOT NULL,
    motif VARCHAR(20),
    dateSignalement DATE,
	numAvis INTEGER REFERENCES Avis(numAvis)
);

CREATE TABLE FaireSignalement(
	codeCompte INTEGER REFERENCES Compte(codeCompte),
	idSignalement INTEGER REFERENCES Signalement(idSignalement),
	PRIMARY KEY(codeCompte, idSignalement)
);

CREATE TABLE ProdUnitCommande(
    codeProduit INTEGER REFERENCES Produit(codeProduit),
    numCom INTEGER REFERENCES Commande(numCom),
    prixUnitTTC NUMERIC(20,2),
    prixUnitHT NUMERIC(20,2),
    qteProd NUMERIC(20,2),
    PRIMARY KEY(codeProduit,numCom)
);
CREATE TABLE ProdUnitPanier(
    codeProduit INTEGER REFERENCES Produit(codeProduit),
    idPanier INTEGER REFERENCES Panier(idPanier),    
    qteProd NUMERIC(20,2),

    PRIMARY KEY(codeProduit,idPanier)
);


CREATE TABLE Vote(
    numAvis INTEGER REFERENCES Avis(numAvis),
    codeCompte INTEGER REFERENCES Client(codeCompte),
    typeVote INTEGER CHECK (typeVote IN (-1, 0, 1)),
    PRIMARY KEY(numAvis, codeCompte)
);

CREATE TABLE FairePromotion(
	codeProduit INTEGER REFERENCES Produit(codeProduit),
	idPromotion INTEGER REFERENCES Promotion(idPromotion),
	PRIMARY KEY(codeProduit, idPromotion)
);

CREATE TABLE FaireReduction(
	codeProduit INTEGER REFERENCES Produit(codeProduit),
	idReduction INTEGER REFERENCES Reduction(idReduction),
	PRIMARY KEY(codeProduit, idReduction)
);

CREATE TABLE Publier(
	codeCompte INTEGER REFERENCES Client(codeCompte),
	numAvis INTEGER REFERENCES Avis(numAvis),
	PRIMARY KEY(codeCompte, numAvis)
);

CREATE TABLE JustifierAvis(
	urlPhoto VARCHAR REFERENCES Photo(urlPhoto),
	numAvis INTEGER REFERENCES Avis(numAvis),
	PRIMARY KEY(urlPhoto, numAvis)
);

CREATE TABLE Profil(
	urlPhoto VARCHAR REFERENCES Photo(urlPhoto),
	codeClient INTEGER REFERENCES Client(codeCompte),
	PRIMARY KEY(urlPhoto, codeClient)
);

--FONCTIONS--

--PrixTTC = prixHT * tauxTVA--
CREATE OR REPLACE FUNCTION calcul_prixTTC()
RETURNS TRIGGER AS 
$$
	BEGIN
		SELECT NEW.prixHT * (1 + (tva.tauxTVA / 100)) INTO NEW.prixTTC
		FROM TVA tva WHERE tva.nomTVA = NEW.nomTVA;
		RETURN NEW;
	END;
$$ 
LANGUAGE plpgsql;

CREATE TRIGGER trg_calcul_prixTTC
BEFORE INSERT OR UPDATE ON Produit
FOR EACH ROW
EXECUTE FUNCTION calcul_prixTTC();
--ProdUnitCommande.PrixTTC = produit.prixTTC--

CREATE FUNCTION duplique_prixTTC()
RETURNS TRIGGER AS $$
BEGIN
	SELECT Produit.prixTTC INTO NEW.prixTTC
	FROM Produit WHERE Produit.codeProduit = NEW.codeProduit;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trg_dupli_prixTTC
BEFORE INSERT OR UPDATE ON ProdUnitCommande
FOR EACH ROW
EXECUTE FUNCTION duplique_prixTTC();

--ProdUnitCommande.PrixHT = produit.prixHT--

CREATE FUNCTION duplique_prixHT()
RETURNS TRIGGER AS $$
BEGIN
	SELECT Produit.prixHT INTO NEW.prixHT
	FROM Produit WHERE Produit.codeProduit = NEW.codeProduit;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trg_dupli_prixHT
BEFORE INSERT OR UPDATE ON ProdUnitCommande
FOR EACH ROW
EXECUTE FUNCTION duplique_prixHT();

--Triggers prixHT et prixTTC--

CREATE TRIGGER trg_dupli_prixHT_Panier
BEFORE INSERT OR UPDATE ON ProdUnitPanier
FOR EACH ROW
EXECUTE FUNCTION duplique_prixHT();

CREATE TRIGGER trg_dupli_prixTTC_Panier
BEFORE INSERT OR UPDATE ON ProdUnitPanier
FOR EACH ROW
EXECUTE FUNCTION duplique_prixTTC();

--PrixTTCPanier = Somme(PrixTTC * qtProd)--

CREATE FUNCTION calcul_prixTotalTTCPan()
RETURNS TRIGGER AS $$
BEGIN
	SELECT SUM(Produit.prixTTC * PUP.qteProd) INTO NEW.prixTTC
	FROM ProdUnitPanier PUP WHERE PUP.codeProduit = NEW.codeProduit;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trg_calcul_TTCPanier
BEFORE INSERT OR UPDATE ON ProdUnitPanier
FOR EACH ROW
EXECUTE FUNCTION calcul_prixTotalTTCPan();

--PrixHTPanier = Somme(PrixHT * qtProd)--

CREATE FUNCTION calcul_prixTotalHTPan()
RETURNS TRIGGER AS $$
BEGIN
	SELECT SUM(Produit.prixHT * PUP.qteProd) INTO NEW.prixTTC
	FROM ProdUnitPanier PUP WHERE PUP.codeProduit = NEW.codeProduit;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trg_calcul_HTPanier
BEFORE INSERT OR UPDATE ON ProdUnitPanier
FOR EACH ROW
EXECUTE FUNCTION calcul_prixTotalHTPan();


--prixTotalTTC dans commande = somme(prixUnitTTC * qteProd)--

CREATE FUNCTION calcul_prixTotalTTCCom()
RETURNS TRIGGER AS $$
BEGIN
	SELECT SUM(PUC.prixUnitTTC * PUC.qteProd) INTO NEW.prixTTC
	FROM ProdUnitCommande PUC WHERE PUC.codeProduit = NEW.codeProduit;
	RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_calcul_prixTotalTTCCom
BEFORE INSERT OR UPDATE ON Commande
FOR EACH ROW
EXECUTE FUNCTION calcul_prixTotalTTCCom();