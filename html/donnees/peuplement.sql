set schema 'alizon';
INSERT INTO TVA(nomTVA,tauxTVA) 
VALUES
('super-réduite',5.5),
('réduite',10),
('normale',20);

INSERT INTO Photo(urlPhoto) VALUES
('/img/fraises.jpg'),
('/img/the.jpg'),
('/img/lait.jpg'),
('/img/fromage.jpg'),
('/img/cafe.jpg'),
('/img/tshirt.jpg'),
('/img/pantalon.jpg'),
('/img/veste.jpg'),
('/img/mocassins.jpg'),
('/img/chapeau.jpg'),
('/img/lampe.jpg'),
('/img/gourde.jpg'),
('/img/coussin.jpg'),
('/img/tasse.jpg'),
('/img/sac.jpg'),
('/img/montre.jpg'),
('/img/parfum.jpg'),
('/img/collier.jpg'),
('/img/lunettes.jpg'),
('/img/stylo.jpg'),
('../img/photosProduit/imgErr.jpg');

INSERT INTO Client(pseudo, dateCreation, nom, prenom, email, mdp, numTel, pdProfil) VALUES
('Zigor','2025-09-25','Mulish','Isigor','isizou@gmail.com','bababou0','0605040608','/img/photosProfil/PDP_ZIG.jpeg'),
('Eude02','2025-10-26','Pilup','Eude','Eudeux@gmail.com','oupala!','0704090506','/img/photosProfil/PDP_EU2.jpeg'),
('test','2025-10-26','test','test','test@gmail.com','test','0701480506','/img/photosProfil/PDP_tst.jpeg'),
('Nanardeau','2025-10-29','Bernel','michar','moviestar@gmail.com','oupala!','0704090506','/img/photosProfil/PDP_BBl.jpeg');


INSERT INTO Vendeur(dateCreation, nom, prenom, email, mdp, numTel, siren, raisonSociale) VALUES
('2025-10-23','test','test','email@gmail.com','admin','020482675','000000000','admin'),
('2025-10-23', 'Dupont', 'Martin', 'martin.dupont@gmail.com', 'Password123', '0612345678', '812345678', 'Dupont & Fils SARL'),
('2025-09-15', 'Moreau', 'Léa', 'lea.moreau@gmail.com', 'L3a!Secure', '0678912345', '352000799', 'Moreau Boutique'),
('2025-11-01', 'Nguyen', 'Thierry', 'thierry.nguyen@techsolutions.fr', 'TnG!2025', '0780554433', '489765432', 'Tech Solutions');

INSERT INTO Produit (libelleProd, descriptionProd, prixHT, nomTVA, hauteur, longueur, largeur, qteStock, Origine, Disponible, seuilAlerte, urlPhoto, codeCompteVendeur)
VALUES
-- Nourriture
('Fraises', 'Fruit frais de Plougastel', 6.20, 'réduite', NULL, NULL, NULL, 200, 'Breizh',false, 20, '/img/fraises.jpg', 5),
('Thé noir', 'Qualité supérieure, fabrique de Carhaix', 5.60, 'réduite', NULL, NULL, NULL, 150, 'Étranger', true, 15, '/img/the.jpg', 6),
('Lait', '1L demi-écrémé', 1.50, 'réduite', NULL, NULL, NULL, 100, 'Breizh', true, 10, '/img/lait.jpg', 7),
('Fromage', 'Camembert AOP', 3.80, 'réduite', NULL, NULL, NULL, 60, 'Breizh', true, 10, '/img/fromage.jpg', 8),
('Café', 'Moulu 250g', 4.90, 'réduite', NULL, NULL, NULL, 80, 'Breizh', true, 10, '/img/cafe.jpg', 5);
INSERT INTO Produit (libelleProd, descriptionProd, prixHT, nomTVA, hauteur, longueur, largeur, qteStock,Origine, seuilAlerte, urlPhoto, codeCompteVendeur)
VALUES
-- Vêtements
('T-shirt Armor lux', 'Coton blanc M', 15.00, 'super-réduite', NULL, NULL, NULL, 50, 'Breizh', 10, '/img/tshirt.jpg', 6),
('Jean à motif', 'denim 42', 45.00, 'super-réduite', NULL, NULL, NULL, 40, 'Étranger', 5, '/img/pantalon.jpg', 7),
('Veste papillon', 'Noire homme L', 70.00, 'super-réduite', NULL, NULL, NULL, 25, 'France', 5, '/img/veste.jpg', 8),
('Derbies', 'Cuir marron 40', 90.00, 'super-réduite', NULL, NULL, NULL, 35, 'Breizh', 5, '/img/mocassins.jpg', 5),
('Casquette Cobrec', 'Bleue ajustable', 12.00, 'super-réduite', NULL, NULL, NULL, 60, 'Breizh', 5, '/img/chapeau.jpg', 6),

-- Objets divers
('Lampe rouge', 'De chevet LED', 25.00, 'super-réduite', 0.35, 0.20, 0.20, 30, 'France', 4, '/img/lampe.jpg', 7),
('Gourde', 'Inox 1L', 18.00, 'super-réduite', 0.25, 0.08, 0.08, 45, 'Étranger', 5, '/img/gourde.jpg', 8),
('Coussin brodé', 'Velours bleu', 22.00, 'super-réduite', 0.15, 0.40, 0.40, 40, 'Étranger', 5, '/img/coussin.jpg', 5),
('Tasse Bretagne', 'Céramique blanche', 8.00, 'super-réduite', 0.10, 0.08, 0.08, 80, 'Breizh', 8, '/img/tasse.jpg', 6),
('Sac à dos', 'Noir imperméable', 35.00, 'super-réduite', 0.45, 0.30, 0.20, 20, 'France', 3, '/img/sac.jpg', 7),

-- Produits de luxe
('Montre LeDu', 'Acier argenté', 150.00, 'normale', NULL, NULL, NULL, 10, 'Étranger', 2, '/img/montre.jpg', 8),
('Bleu de Chanel', 'Eau de toilette 100ml', 75.00, 'normale', NULL, NULL, NULL, 15, 'France', 2, '/img/parfum.jpg', 5),
('Collier', 'Or plaqué', 120.00, 'normale', NULL, NULL, NULL, 8, 'Breizh', 1, '/img/collier.jpg', 6),
('Lunettes Sandrine', 'Soleil noires', 60.00, 'normale', NULL, NULL, NULL, 25, 'Breizh', 3, '/img/lunettes.jpg', 7),
('Stylo à bille', 'thème Océan, haut de gamme', 40.00, 'normale', NULL, NULL, NULL, 30, 'Breizh', 3, '/img/stylo.jpg', 8);


INSERT INTO Adresse(num,codePostal, nomVille, nomRue) VALUES
(10, '75001', 'Paris', 'Prad-land'),
(04,  '69003', 'Lyon', 'Kergaradec'),
(22, '13001', 'Marseille', 'Plougastel'),
(01,  '59000', 'Lille','Rue la bienfaisance'),
(07,  '06000', 'Nice','Avenue de la libération'),
(15, '33000', 'Bordeaux','Rue de la forêt'),
(02, '33000', 'Bordeaux','Rue Edouard Branly'),
(19, '33000', 'Bordeaux','Le Quedel');

INSERT INTO AdrFactCli(codeCompte, idAdresse) VALUES 
(1,1),
(2,2),
(3,3),
(4,4);

INSERT INTO AdrSiegeSocial(codeCompte, idAdresse) VALUES
(5,5),
(6,6),
(7,7),
(8,8);

INSERT INTO Categorie(libelleCat) VALUES
('Alimentaire'),
('Vêtements'),
('Beauté'),
('Intérieur'),
('Papeterie'),
('Boissons'),
('Fruits & Légumes'),
('Epicerie sucrée'),
('Epicerie salée'),
('Accessoire'),
('Chaussures'),
('Haut'),
('Bas'),
('Parfum'),
('Décoration'),
('Cuisine'),
('Stylo');

INSERT INTO SousCat(libCat,libSousCat) VALUES
('Alimentaire', 'Boissons'),
('Alimentaire', 'Fruits & Légumes'),
('Alimentaire', 'Epicerie sucrée'),
('Alimentaire', 'Epicerie salée'),
('Vêtements', 'Accessoire'),
('Vêtements', 'Chaussures'),
('Vêtements', 'Haut'),
('Vêtements', 'Bas'),
('Beauté','Parfum'),
('Intérieur', 'Décoration'),
('Intérieur', 'Cuisine'),
('Papeterie', 'Stylo');

INSERT INTO Categoriser(codeProduit, libelleCat) VALUES
(1,'Alimentaire'),
(2, 'Alimentaire'),
(3, 'Alimentaire'),
(4, 'Alimentaire'),
(5, 'Alimentaire'),
(6, 'Vêtements'),
(7, 'Vêtements'),
(8, 'Vêtements'),
(9, 'Vêtements'),
(10, 'Vêtements'),
(11, 'Intérieur'),
(12, 'Intérieur'),
(13, 'Intérieur'),
(14, 'Intérieur'),
(15, 'Intérieur'),
(16, 'Vêtements'),
(17, 'Beauté'),
(18, 'Vêtements'),
(19, 'Vêtements'),
(20, 'Papeterie');


insert into Panier(codeCompte,dateCreaP) VALUES
(3,null);

insert into ProdUnitPanier(idPanier,codeProduit,qteProd) VALUES
(1,1,2),
(1,2,2),
(1,4,1),
(1,3,1);

INSERT INTO Photo(urlPhoto) VALUES ('./img/photosProfil/Cunty.png');
INSERT INTO Profil(urlPhoto, codeClient) VALUES ('./img/photosProfil/Cunty.png' , 1);

insert into Avis(codeproduit,codecomptecli,noteprod,commentaire,datepublication) VALUES
(1,1,5,'J adore ce produit, il est vraiment bien, il est arrivé vite en plus', DATE '08-01-2025'),
(4,3,1,'Aucune protection du produit dans le colis, il est arrivé abimé, je ne recommande pas ce vendeur', DATE '15-06-2025'),
(6,1,2,'Le produit est moyen', DATE '05-10-2025'),
(2,2,3,'J aime bien mais c est pas mon truc non plus', DATE '22-03-2025');

--SELECT client.pdprofil, produit.libelleprod, client.pseudo, avis.noteprod, avis.commentaire FROM avis INNER JOIN produit ON (avis.codeproduit = produit.codeproduit) INNER JOIN client ON (avis.codecomptecli = client.codecompte) ORDER BY avis.codeproduit;
--select SUM(prixttctotal) FROM ProdUnitPanier INTO Panier.prixTTCtotal;
--select * from ProdUnitPanier where idPanier = 1;
--select * from Panier where codecompte = 3;
--SELECT ALL count(*) from ProdUnitPanier where idPanier = 1;
--SELECT ALL codeProduit,qteprod from ProdUnitPanier where idPanier = 1;
--select * from client;
--select * from produit where codeproduit = 1;
--SELECT libelleProd,urlphoto,codecomptevendeur from Produit where codeProduit = 1;
--SELECT * from Vendeur where codecompte = 5;
--update ProdUnitPanier set qteProd = qteProd + 1 where idPanier = 1 AND codeProduit = 1;
--select all * from ProdUnitPanier where idPanier = 1;
--delete from ProdUnitPanier where idPanier = 1 and codeProduit = 1;
--select all * from ProdUnitPanier where idPanier = 1;
--delete from ProdUnitPanier where idPanier = 1;
--delete from  Panier where idPanier = 1;
--SELECT * FROM Categoriser;
--SELECT * FROM Categoriser where libelleCat = 'Alimentaire';