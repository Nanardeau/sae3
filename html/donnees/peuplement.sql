set schema 'alizon';
INSERT INTO TVA(nomTVA,tauxTVA) 
VALUES
('super-réduite',5.5),
('réduite',10),
('normale',20);

INSERT INTO Tarification(nomTarif,tauxTarif) 
VALUES
('tarif1',2),
('tarif2',5),
('tarif3',8),
('tarif4',10),
('tarif5',15);

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
('/img/tasse.jpg'),
('/img/sac.jpg'),
('/img/lunettes.jpg'),
('/img/stylo.jpg'),
('/img/pommes.jpg'),
('/img/miel.jpg'),
('/img/chocolat.jpg'),
('/img/confiture.jpg'),
('/img/huile.jpg'),
('/img/biscottes.jpg'),
('/img/pull.jpg'),
('/img/parka.jpg'),
('/img/sweat.jpg'),
('/img/sandales.jpg'),
('/img/echarpe.jpg'),
('/img/gants.jpg'),
('/img/short.jpg'),
('/img/robe.jpg'),
('/img/bougie.jpg'),
('/img/tapis.jpg'),
('/img/boite.jpg'),
('/img/plaid.jpg'),
('/img/moulin.jpg'),
('/img/horloge.jpg'),
('/img/iris.jpg'),
('/img/argent.jpg'),
('/img/soleil.jpg'),
('/img/luxe.jpg'),
('/img/savon.jpg'),
('/img/trousse.jpg'),
('/img/serviette.jpg'),
('/img/peignoir.jpg'),
('/img/cristal.jpg'),
('/img/yoga.jpg'),
('/img/carafe.jpg'),
('/img/bouteille.jpg'),
('/img/tente.jpg'),
('/img/couchage.jpg'),
('/img/boussole.jpg'),
('/img/torche.jpg'),
('/img/thermos.jpg'),
('/img/bottes.jpg'),
('/img/tshirtalamer.jpg'),
('/img/tshirtcrabe.jpg'),
('../img/photosProduit/imgErr.jpg')
--('/img/coussin.jpg'), --
--('/img/montre.jpg'),--
--('/img/parfum.jpg'), -- 
--('/img/collier.jpg'), --
--('/img/riz.jpg'), -- 
--('/img/pois.jpg'), --
--('/img/pates.jpg'), --
--('/img/haricots.jpg'), --
--('/img/toile.jpg'), --
--('/img/lampebureau.jpg'), --
--('/img/assiette.jpg'), --
--('/img/coussindeco.jpg'), --
--('/img/encens.jpg'), --
--('/img/acier.jpg'), --
--('/img/gel.jpg'), --
--('/img/shampooing.jpg'), --
--('/img/creme.jpg'), --
--('/img/baume.jpg'), --
--('/img/eau.jpg'), --
--('/img/gommage.jpg'), --
--('/img/mains.jpg'), --
--('/img/lotion.jpg'), --
--('/img/huilemas.jpg'), --
--('/img/brosse.jpg'), --
--('/img/peigne.jpg'),--
--('/img/statuebois.jpg'), --
--('/img/statue.jpg'), --
--('/img/bijoux.jpg'), --
--('/img/bouilloire.jpg'), --
--('/img/grillepain.jpg'), --
--('/img/balance.jpg'), --
--('/img/cafetiere.jpg'), --
--('/img/halteres.jpg'), --
--('/img/cocotte.jpg'), --
--('/img/couteaux.jpg'), --
--('/img/wok.jpg'), --
--('/img/poele.jpg'), --;

INSERT INTO Client(pseudo, dateCreation, dateNaissance, nom, prenom, email, mdp, numTel, cmtBlq, cmtBlqMod) VALUES
('test0','2025-09-25', '2003-04-03','Mulish','Isigor','isizou@gmail.com','test0','0605040608',false,false),
('test1','2025-10-26', '2006-05-08', 'Pilup','Eude','Eudeux@gmail.com','test1','0704090506',true, false),
('test2','2025-10-26','2001-09-11','test','test','test@gmail.com','test2','0701480506',false, false),
('Nanardeau','2025-10-29','2006-12-29','Bernel','michar','moviestar@gmail.com','oupala!','0704090506',false, false);


INSERT INTO Vendeur(dateCreation, nom, prenom, pseudo, email, mdp, numTel, siren, raisonSociale) VALUES
('2025-10-23','test','test', 'test','email@gmail.com','admin','0204826759','000000000','admin'),
('2025-10-23', 'Dupont', 'Martin', 'mdupont', 'martin.dupont@gmail.com', 'Password123', '0612345678', '812345678', 'Dupont & Fils SARL'),
('2025-09-15', 'Moreau', 'Léa', 'lmoreau', 'lea.moreau@gmail.com', 'L3a!Secure', '0678912345', '352000799', 'Moreau Boutique'),
('2025-11-01', 'Nguyen', 'tnguyen', 'Thierry', 'thierry.nguyen@techsolutions.fr', 'TnG!2025', '0780554433', '489765432', 'Tech Solutions');

INSERT INTO Client(pseudo, dateCreation, dateNaissance, nom, prenom, email, mdp, numTel, cmtBlq, cmtBlqMod) VALUES
('Camille','2025-11-21','1999-03-03','Guillou','Camille','camille@gmail.com','camille1','0649786246', false, false),
('AudreyM','2025-11-21','1989-09-04','Asma','Audrey','audrey3@gmail.com','Audrey3','0748956215', false, false);

INSERT INTO Produit (libelleProd, descriptionProd, prixHT, nomTVA, hauteur, longueur, largeur, qteStock, Origine, Disponible, seuilAlerte, urlPhoto, codeCompteVendeur)
VALUES
-- Nourriture
('Fraises', 'Fruit frais de Plougastel', 6.20, 'réduite', NULL, NULL, NULL, 200, 'Breizh',false, 20, '/img/fraises.jpg', 5),
('Thé noir', 'Qualité supérieure, fabrique de Carhaix', 5.60, 'réduite', NULL, NULL, NULL, 150, 'Étranger', true, 15, '/img/the.jpg', 6),
('Lait', '1L demi-écrémé', 1.50, 'réduite', NULL, NULL, NULL, 100, 'Breizh', true, 10, '/img/lait.jpg', 7),
('Fromage', 'Camembert AOP', 3.80, 'réduite', NULL, NULL, NULL, 60, 'Breizh', true, 10, '/img/fromage.jpg', 8),
('Café', 'Moulu 250g', 4.90, 'réduite', NULL, NULL, NULL, 80, 'Breizh', true, 10, '/img/cafe.jpg', 5);
('Pommes Chantecler', 'Des pommes croquantes et parfumées issues d’arbres cultivés dans des vergers bretons. Leur chair légèrement acidulée et leur texture ferme en font un fruit idéal pour une consommation quotidienne, mais également pour la pâtisserie. Récoltées à maturité pour garantir une saveur optimale.', 3.40, 'réduite', NULL, NULL, NULL, 180, 'Breizh', 15, '/img/pommes.jpg', 5, 'tarif1'),
('Miel de sarrasin', 'Un miel sombre et puissant produit dans des ruches installées au cœur des campagnes bretonnes. Sa saveur boisée et son parfum profond le rendent particulièrement apprécié des amateurs de produits authentiques. Parfait pour sucrer tisane, desserts ou tartines.', 8.90, 'réduite', NULL, NULL, NULL, 90, 'Breizh', 8, '/img/miel.jpg', 8, 'tarif1'),
('Chocolat noir 80%', 'Un chocolat intense fabriqué avec du cacao issu de plantations équitables. Ses arômes profonds et sa légère amertume le rendent parfait pour les connaisseurs ou pour la pâtisserie. Chaque tablette est travaillée pour garantir une fondance idéale.', 3.10, 'réduite', NULL, NULL, NULL, 150, 'France', 6, '/img/chocolat.jpg', 8, 'tarif1'),
('Confiture de fraise', 'Confiture préparée avec des fraises mûries au soleil et cuites en petite quantité pour garantir une saveur fruitée intense. Sa texture onctueuse et son goût authentique la rendent parfaite pour les tartines, les crêpes ou les desserts faits maison.', 4.80, 'réduite', NULL, NULL, NULL, 85, 'Breizh', 8, '/img/confiture.jpg', 6, 'tarif1'),
('Huile d’olive', 'Huile extra vierge issue d’une première pression à froid. Son parfum fruité et sa saveur équilibrée en font un ingrédient essentiel pour la cuisine du quotidien. Idéale pour assaisonnement, cuisson douce ou marinade.', 7.50, 'réduite', NULL, NULL, NULL, 100, 'Étranger', 8, '/img/huile.jpg', 8, 'tarif1'),
('Biscottes complètes', 'Des biscottes croustillantes élaborées avec de la farine complète pour un petit-déjeuner nutritif. Leur texture légère et leur goût délicat en font une alternative saine au pain traditionnel. Elles se conservent longtemps sans perdre leur croquant.', 2.40, 'réduite', NULL, NULL, NULL, 130, 'France', 15, '/img/biscottes.jpg', 8, 'tarif1'),

-- Vêtements
('T-shirt Armor lux', 'Coton blanc M', 15.00, 'super-réduite', NULL, NULL, NULL, 50, 'Breizh', 10, '/img/tshirt.jpg', 6),
('T-shirt Crabe', 'synthétique XXL', 18.00, 'super-réduite', NULL, NULL, NULL, 30, 'Étranger', 5, '/img/tshirtcrabe.jpg', 7),
('T-shirt à la vie, à la mer', 'synthétique L', 18.00, 'super-réduite', NULL, NULL, NULL, 40, 'Étranger', 15, '/img/tshirtalamer.jpg', 7),
('Jean à motif', 'denim 42', 45.00, 'super-réduite', NULL, NULL, NULL, 40, 'Étranger', 5, '/img/pantalon.jpg', 7),
('Veste papillon', 'Noire homme L', 70.00, 'super-réduite', NULL, NULL, NULL, 25, 'France', 5, '/img/veste.jpg', 8),
('Derbies', 'Cuir marron 40', 90.00, 'super-réduite', NULL, NULL, NULL, 35, 'Breizh', 5, '/img/mocassins.jpg', 5),
('Casquette Cobrec', 'Bleue ajustable', 12.00, 'super-réduite', NULL, NULL, NULL, 60, 'Breizh', 5, '/img/chapeau.jpg', 6),
('Short de sport', 'Short léger conçu pour une pratique sportive régulière. Son tissu respirant et sa coupe ergonomique offrent un confort optimal, même lors d’efforts intenses. Idéal pour course à pied, fitness ou activités extérieures grâce à sa grande liberté de mouvement.', 18.00, 'super-réduite', NULL, NULL, NULL, 45, 'France', 5, '/img/short.jpg', 8, 'tarif1'),
('Sweat capuche', 'Sweat chaud muni d’une capuche ajustable. Fabriqué en coton épais, il offre une grande douceur et une excellente résistance. Sa coupe classique le rend adapté à un usage quotidien, autant pour le confort intérieur que les sorties en extérieur.', 35.00, 'super-réduite', 0.05, 0.60, 0.50, 30, 'Breizh', 5, '/img/sweat.jpg', 6, 'tarif2'),
('Parka impermeable', 'Parka longue conçue pour affronter les intempéries. Son revêtement imperméable et sa doublure isolante assurent une protection optimale contre le vent et la pluie. Idéale pour les déplacements quotidiens en saison froide ou pluvieuse.', 85.00, 'super-réduite', 0.10, 0.80, 0.60, 20, 'France', 5, '/img/parka.jpg', 7, 'tarif3'),
('Robe été', 'Robe légère fabriquée dans un tissu fluide et agréable au toucher. Ses motifs colorés et sa coupe aérée en font une tenue parfaite pour les journées chaudes. Confortable et facile à porter, elle convient aussi bien à la plage qu’aux sorties estivales.', 28.00, 'super-réduite', 0.02, 0.90, 0.50, 35, 'Étranger', 6, '/img/robe.jpg', 5, 'tarif1'),
('Bottes cuir', 'Bottes en cuir véritable offrant une grande robustesse et une finition élégante. Leur semelle résistante ainsi que leur maintien confortable permettent une utilisation prolongée, que ce soit en ville ou en environnement plus exigeant.', 110.00, 'super-réduite', 0.40, 0.35, 0.12, 25, 'France', 3, '/img/bottes.jpg', 8, 'tarif3'),
('Pull laine', 'Pull tricoté en laine naturelle offrant chaleur et douceur. Sa coupe ajustée et son style intemporel en font un vêtement indispensable pour la saison froide. Fabriqué avec des matériaux de qualité pour garantir longévité et confort.', 42.00, 'super-réduite', 0.03, 0.70, 0.50, 40, 'Breizh', 5, '/img/pull.jpg', 6, 'tarif1'),
('Écharpe douce', 'Écharpe longue et épaisse conçue pour offrir une chaleur optimale lors des journées froides. Son tissu doux ne pique pas et assure un confort prolongé. Disponible en plusieurs coloris pour s’adapter à tous les styles vestimentaires.', 16.00, 'super-réduite', NULL, NULL, NULL, 60, 'France', 8, '/img/echarpe.jpg', 8, 'tarif1'),
('Gants hiver', 'Gants chauds rembourrés, idéals pour faire face aux températures basses. Leur doublure interne assure une isolation efficace tandis que l’extérieur résistant protège du vent. Compatibles avec les écrans tactiles pour une utilisation pratique.', 14.00, 'super-réduite', NULL, NULL, NULL, 55, 'Breizh', 8, '/img/gants.jpg', 6, 'tarif1'),
('Sandales cuir', 'Sandales élégantes fabriquées en cuir souple de haute qualité. Leur semelle confortable et leur style épuré en font une chaussure idéale pour l’été. Conçues pour offrir un maintien stable lors de la marche.', 38.00, 'super-réduite', NULL, NULL, NULL, 40, 'France', 5, '/img/sandales.jpg', 6, 'tarif1'),

-- Objets divers
('Lampe rouge', 'De chevet LED', 25.00, 'super-réduite', 0.35, 0.20, 0.20, 30, 'France', 4, '/img/lampe.jpg', 7),
('Gourde', 'Inox 1L', 18.00, 'super-réduite', 0.25, 0.08, 0.08, 45, 'Étranger', 5, '/img/gourde.jpg', 8),
('Tasse Bretagne', 'Céramique blanche', 8.00, 'super-réduite', 0.10, 0.08, 0.08, 80, 'Breizh', 8, '/img/tasse.jpg', 6),
('Sac à dos', 'Noir imperméable', 35.00, 'super-réduite', 0.45, 0.30, 0.20, 20, 'France', 3, '/img/sac.jpg', 7),
('Boîte rangement', 'Boîte de rangement en plastique robuste, idéale pour organiser vêtements, documents ou jouets. Son couvercle hermétique protège le contenu de la poussière. Adaptée à un usage domestique ou professionnel grâce à sa grande capacité.', 12.00, 'super-réduite', 0.25, 0.40, 0.30, 60, 'Breizh', 8, '/img/boite.jpg', 5, 'tarif2'),
('Bougie parfumée', 'Bougie coulée à la main avec cire naturelle. Son parfum discret mais durable permet de créer une ambiance apaisante dans n’importe quelle pièce. Le contenant esthétique peut être réutilisé une fois la bougie consommée.', 9.50, 'super-réduite', NULL, NULL, NULL, 80, 'France', 8, '/img/bougie.jpg', 5, 'tarif1'),
('Moulin poivre', 'Moulin de table en bois massif, équipé d’un mécanisme de broyage durable. Permet d’ajuster précisément la mouture selon les préférences culinaires. Un accessoire élégant et pratique pour rehausser les saveurs de vos plats.', 22.00, 'super-réduite', 0.22, 0.06, 0.06, 40, 'France', 5, '/img/moulin.jpg', 8, 'tarif1'),
('Tapis salon', 'Tapis de salon tissé avec soin, offrant un toucher doux et une excellente résistance à l’usage. Ses motifs modernes permettent d’apporter une touche décorative chaleureuse à votre intérieur tout en assurant une bonne isolation du sol.', 55.00, 'super-réduite', 0.02, 2.00, 1.50, 15, 'Étranger', 3, '/img/tapis.jpg', 5, 'tarif3'),
('Plaid laine', 'Plaid en laine chaude tissé avec une grande finesse. Parfait pour se réchauffer lors des soirées fraîches, il peut également servir d’élément décoratif sur canapé ou lit. Sa texture douce procure une sensation agréable au toucher.', 39.00, 'super-réduite', 0.08, 1.20, 1.00, 30, 'France', 5, '/img/plaid.jpg', 6, 'tarif2'),
('Horloge murale', 'Horloge murale design avec un mécanisme silencieux. Sa grande lisibilité et son style épuré en font un accessoire décoratif autant qu’un outil pratique. Facile à installer, elle s’intègre parfaitement à tout type d’intérieur.', 32.00, 'super-réduite', 0.35, 0.30, 0.05, 25, 'Breizh', 5, '/img/horloge.jpg', 6, 'tarif2'),

('Vase cristal', 'Vase élégant en cristal soufflé offrant une grande clarté et des reflets lumineux. Parfait pour mettre en valeur des fleurs ou pour servir de pièce décorative sur une table ou une étagère.', 95.00, 'normale', 0.30, 0.18, 0.18, 15, 'Étranger', 3, '/img/cristal.jpg', 6, 'tarif2'),
('Carafe verre', 'Carafe en verre soufflé à la bouche, offrant une grande transparence et une élégance naturelle. Idéale pour servir eau, vin ou jus lors des repas. Sa forme ergonomique assure une prise en main confortable.', 28.00, 'normale', 0.25, 0.15, 0.15, 40, 'France', 5, '/img/carafe.jpg', 8, 'tarif1'),

('Tapis de yoga', 'Tapis de yoga antidérapant offrant une excellente adhérence au sol. Son épaisseur confortable réduit les impacts et assure un maintien stable pour toutes les postures. Idéal pour yoga, pilates et étirements.', 24.00, 'super-réduite', 0.02, 1.80, 0.60, 40, 'Étranger', 6, '/img/yoga.jpg', 8, 'tarif2'),
('Bouteille sport', 'Bouteille de sport légère conçue dans un plastique sans BPA. Son embout étanche et son format pratique permettent de l’emporter partout : salle de sport, bureau ou sorties extérieures.', 8.50, 'super-réduite', NULL, NULL, NULL, 100, 'Breizh', 15, '/img/bouteille.jpg', 8, 'tarif1'),
('Tente randonnée', 'Tente légère adaptée aux randonnées et bivouacs courts. Son montage rapide et sa toile résistante aux intempéries offrent un abri fiable. Compacte et facile à transporter, elle convient parfaitement aux excursions régulières.', 75.00, 'super-réduite', 0.30, 2.00, 1.80, 18, 'France', 5, '/img/tente.jpg', 6, 'tarif3'),
('Sac couchage', 'Sac de couchage conçu pour offrir une bonne isolation thermique lors des nuits fraîches. Sa forme enveloppante assure un confort optimal et limite les déperditions de chaleur. Livré avec housse de compression.', 55.00, 'super-réduite', 0.30, 0.80, 0.40, 30, 'France', 5, '/img/couchage.jpg', 7, 'tarif2'),
('Boussole pro', 'Boussole de randonnée précise et résistante, dotée d’un cadran lumineux pour une lecture facile, même par faible luminosité. Un outil fiable pour les passionnés d’orientation et les explorateurs.', 16.00, 'super-réduite', NULL, NULL, NULL, 70, 'Étranger', 8, '/img/boussole.jpg', 6, 'tarif1'),
('Lampe torche', 'Lampe torche compacte équipée d’une LED très puissante assurant une excellente visibilité de nuit. Son autonomie longue durée en fait un accessoire incontournable en randonnée, camping ou dépannage.', 12.90, 'super-réduite', NULL, NULL, NULL, 90, 'Breizh', 8, '/img/torche.jpg', 6, 'tarif1'),
('Gourde thermique', 'Gourde isotherme capable de conserver la chaleur ou la fraîcheur pendant plusieurs heures. Son revêtement robuste la protège des chocs et assure une étanchéité parfaite pour un transport sécurisé.', 22.00, 'super-réduite', NULL, NULL, NULL, 50, 'Étranger', 5, '/img/thermos.jpg', 8, 'tarif1'),

-- Produits de luxe
('Lunettes Sandrine', 'Soleil noires', 60.00, 'normale', NULL, NULL, NULL, 25, 'Breizh', 3, '/img/lunettes.jpg', 7),
('Stylo à bille', 'thème Océan, haut de gamme', 40.00, 'normale', NULL, NULL, NULL, 30, 'Breizh', 3, '/img/stylo.jpg', 8);
('Parfum iris', 'Eau de parfum mêlant notes florales d’iris et touches boisées. Son sillage élégant en fait une fragrance raffinée adaptée aux occasions spéciales. Le flacon soigné met en valeur ce parfum haut de gamme.', 85.00, 'normale', NULL, NULL, NULL, 18, 'Étranger', 3, '/img/iris.jpg', 5, 'tarif1'),
('Bracelet argent', 'Bijou en argent massif travaillé avec finesse. Léger et agréable à porter, il s’adapte à tous les styles vestimentaires. Livré dans un écrin élégant, il constitue également une excellente idée cadeau.', 70.00, 'normale', NULL, NULL, NULL, 20, 'France', 2, '/img/argent.jpg', 6, 'tarif1'),
('Lunettes soleil', 'Lunettes de soleil offrant une excellente protection UV. Leur monture légère et résistante assure un grand confort. Le design moderne et épuré permet de les porter en toutes occasions, été comme hiver.', 55.00, 'normale', NULL, NULL, NULL, 30, 'Breizh', 3, '/img/soleil.jpg', 5, 'tarif1'),
('Stylo luxe', 'Stylo haut de gamme au design élégant, doté d’une glisse fluide et régulière. Parfait pour la prise de notes ou la signature de documents importants. Présenté dans un coffret raffiné pour un effet hautement professionnel.', 45.00, 'normale', NULL, NULL, NULL, 30, 'France', 3, '/img/luxe.jpg', 8, 'tarif1'),

-- Produit de toilette
('Savon artisanal', 'Savon fabriqué à la main avec des huiles végétales de grande qualité. Son parfum discret et naturel en fait un produit agréable au quotidien. Respectueux de la peau, il convient même aux usages fréquents.', 3.80, 'réduite', NULL, NULL, NULL, 140, 'Breizh', 6, '/img/savon.jpg', 5, 'tarif1'),
('Trousse toilette', 'Trousse de toilette spacieuse et résistante conçue pour accueillir tous les essentiels de soin. Son tissu imperméable protège efficacement son contenu. Idéale pour voyages, déplacements ou utilisation quotidienne.', 14.00, 'super-réduite', 0.12, 0.30, 0.20, 60, 'France', 8, '/img/trousse.jpg', 6, 'tarif1'),
('Serviette bain', 'Grande serviette de bain en coton épais, absorbante et douce au contact de la peau. Durable et résistante, elle conserve ses qualités lavage après lavage. Disponible dans plusieurs coloris.', 18.50, 'super-réduite', 0.02, 1.40, 0.70, 45, 'Étranger', 5, '/img/serviette.jpg', 7, 'tarif2'),
('Peignoir coton', 'Peignoir confortable en coton moelleux conçu pour envelopper le corps d’une chaleur agréable après la douche. Son tissu épais assure une absorption optimale et une douceur durable.', 45.00, 'super-réduite', 0.08, 1.10, 0.70, 30, 'France', 5, '/img/peignoir.jpg', 6, 'tarif2'),

--('Riz basmati', 'Riz parfumé d’origine étrangère, soigneusement sélectionné pour son grain long, léger et aérien. Idéal pour accompagner des plats en sauce ou des recettes exotiques. Sa cuisson simple et son goût délicat en font un indispensable du quotidien.', 2.70, 'réduite', NULL, NULL, NULL, 120, 'Étranger', 8, '/img/riz.jpg', 7, 'tarif1'),
--('Pâtes artisanales', 'Pâtes fabriquées selon un savoir-faire traditionnel français, séchées lentement pour préserver leurs qualités nutritionnelles. Leur texture unique permet de très bien accrocher les sauces. Elles conviennent parfaitement à tous types de préparations culinaires.', 2.90, 'réduite', NULL, NULL, NULL, 200, 'France', 15, '/img/pates.jpg', 5, 'tarif1'),
--('Pois chiches', 'Pois chiches secs sélectionnés pour leur qualité et leur capacité à conserver une texture fondante après cuisson. Ils sont appréciés dans les salades, houmous ou plats mijotés. Leur longue conservation en fait un indispensable du garde-manger.', 2.30, 'réduite', NULL, NULL, NULL, 160, 'Étranger', 6, '/img/pois.jpg', 6, 'tarif1'),
--('Haricots verts', 'Haricots verts extra-fins sélectionnés pour leur fraîcheur. Leur texture croquante et leur saveur délicate en font un accompagnement idéal pour viandes et poissons. Conditionnés pour conserver leurs qualités gustatives longtemps.', 3.20, 'réduite', NULL, NULL, NULL, 140, 'Breizh', 15, '/img/haricots.jpg', 5, 'tarif1'),
--('Chaussures toile', 'Chaussures légères en toile, confortables et respirantes. Parfaites pour une utilisation quotidienne grâce à leur semelle souple et leur design simple. Elles offrent un bon maintien du pied tout en restant faciles à enfiler.', 32.00, 'super-réduite', NULL, NULL, NULL, 45, 'Étranger', 5, '/img/toile.jpg', 7, 'tarif1'),
--('Coussin brodé', 'Velours bleu', 22.00, 'super-réduite', 0.15, 0.40, 0.40, 40, 'Étranger', 5, '/img/coussin.jpg', 5),
--('Lampe bureau', 'Lampe de bureau articulée avec éclairage LED doux. Conçue pour limiter la fatigue visuelle pendant le travail ou l’étude. Sa structure stable et son bras ajustable permettent d’orienter facilement la lumière selon les besoins.', 27.00, 'super-réduite', 0.40, 0.20, 0.20, 35, 'France', 5, '/img/lampebureau.jpg', 8, 'tarif2'),
--('Coussin deco', 'Coussin décoratif conçu dans un tissu doux et résistant. Son rembourrage assure un excellent maintien tout en offrant un confort agréable. Parfait pour canapé, lit ou fauteuil, il ajoute une touche chaleureuse à votre intérieur.', 18.00, 'super-réduite', 0.15, 0.40, 0.40, 50, 'Étranger', 5, '/img/coussindeco.jpg', 7, 'tarif2'),
--('Assiette céramique', 'Assiette en céramique émaillée fabriquée de manière artisanale. Sa surface résistante et son design élégant en font un choix idéal pour une table raffinée. Compatible lave-vaisselle et micro-ondes pour une utilisation quotidienne.', 14.00, 'super-réduite', 0.02, 0.28, 0.28, 90, 'Breizh', 8, '/img/assiette.jpg', 8, 'tarif1'),
--('Coffret encens', 'Coffret contenant différents bâtons d’encens parfumés aux essences naturelles. Parfait pour créer une atmosphère relaxante dans une pièce ou accompagner une séance de méditation. Présenté dans un étui élégant en bois.', 12.50, 'super-réduite', NULL, NULL, NULL, 70, 'Étranger', 8, '/img/encens.jpg', 8, 'tarif1'),
--('Statue bois', 'Statue décorative en bois massif sculptée à la main. Idéale pour décoration ou collection. Sa finition soignée et ses gravures élégantes en font une pièce unique inspirée du style médiéval.', 60.00, 'normale', 0.60, 0.40, 0.10, 8, 'Breizh', 2, '/img/statuebois.jpg', 5, 'tarif3'),
--('Statue pierre', 'Petite statue en pierre taillée représentant une figure abstraite. Chaque pièce est travaillée artisanalement pour offrir un rendu brut et authentique. Parfait pour apporter du caractère à un intérieur moderne ou rustique.', 75.00, 'normale', 0.40, 0.20, 0.20, 6, 'France', 2, '/img/statue.jpg', 8, 'tarif2'),
--('Boîte bijoux', 'Boîte à bijoux en bois précieux dotée de compartiments doublés de velours. Conçue pour protéger bagues, colliers et bracelets. Son design raffiné en fait un objet aussi utile qu’esthétique.', 48.00, 'normale', 0.15, 0.25, 0.20, 25, 'France', 3, '/img/bijoux.jpg', 8, 'tarif1'),
--('Coffret couteaux', 'Coffret comprenant trois couteaux de cuisine en acier forgé. Lame durable et poignée ergonomique pour une coupe précise. Indispensable pour tous les amateurs de cuisine recherchant qualité et fiabilité.', 89.00, 'normale', 0.05, 0.40, 0.20, 20, 'France', 3, '/img/couteaux.jpg', 5, 'tarif1'),
--('Poêle fonte', 'Poêle en fonte émaillée permettant une cuisson homogène et savoureuse des aliments. Très durable, elle conserve la chaleur longtemps et s’adapte à tous types de feux, y compris l’induction.', 65.00, 'normale', 0.08, 0.30, 0.30, 18, 'France', 2, '/img/poele.jpg', 7, 'tarif3'),
--('Wok acier', 'Wok léger en acier carbone permettant une cuisson vive et parfaitement maîtrisée. Idéal pour plats sautés, recettes asiatiques ou légumes croquants. Manche résistant garantissant une bonne prise en main.', 55.00, 'normale', 0.10, 0.35, 0.35, 25, 'Étranger', 5, '/img/wok.jpg', 8, 'tarif3'),
--('Cocotte fonte', 'Cocotte en fonte épaisse idéale pour les cuissons longues. Sa capacité importante permet de préparer des plats familiaux savoureux. Très résistante, elle constitue un investissement durable dans le temps.', 120.00, 'normale', 0.20, 0.35, 0.35, 6, 'France', 2, '/img/cocotte.jpg', 8, 'tarif4'),
--('Planche bambou', 'Planche de découpe en bambou écologique, résistante et durable. Sa surface douce pour les couteaux permet une utilisation fréquente sans abîmer les lames. Facile à nettoyer et idéale pour la préparation de repas.', 18.00, 'normale', 0.03, 0.40, 0.30, 50, 'Breizh', 8, '/img/bambou.jpg', 5, 'tarif1'),
--('Bouilloire inox', 'Bouilloire en acier inoxydable dotée d’une montée en température rapide. Son bec anti-goutte et sa résistance dissimulée assurent une grande facilité d’entretien. Idéale pour thé, infusion et café instantané.', 32.00, 'super-réduite', 0.30, 0.25, 0.20, 35, 'France', 5, '/img/bouilloire.jpg', 7, 'tarif2'),
--('Grille-pain double', 'Grille-pain deux fentes équipé de différents niveaux de chauffe pour s’adapter à tous types de pains. Son design compact et sa fonction surélévation rendent l’utilisation quotidienne pratique et sécurisée.', 36.00, 'super-réduite', 0.25, 0.28, 0.20, 33, 'Breizh', 5, '/img/grillepain.jpg', 5, 'tarif2'),
--('Balance cuisine', 'Balance électronique de cuisine permettant une mesure précise des ingrédients jusqu’à 5kg. Son écran rétroéclairé facilite la lecture. Ultra fine, elle se range sans effort dans un tiroir.', 14.00, 'super-réduite', NULL, NULL, NULL, 75, 'France', 8, '/img/balance.jpg', 8, 'tarif1'),
--('Cafetière filtre', 'Cafetière électrique dotée d’un réservoir généreux permettant de préparer plusieurs tasses en une seule fois. Son système anti-goutte évite les débordements et assure un service propre et rapide.', 38.00, 'super-réduite', 0.35, 0.30, 0.22, 20, 'France', 3, '/img/cafetiere.jpg', 8, 'tarif2'),
--('Haltères 2kg', 'Paire d’haltères recouverts d’un revêtement antidérapant. Parfaits pour renforcement musculaire, fitness ou séances à la maison. Leur forme ergonomique permet une bonne prise en main et évite les roulades.', 18.00, 'super-réduite', NULL, NULL, NULL, 50, 'France', 5, '/img/halteres.jpg', 7, 'tarif1'),
--('Montre LeDu', 'Acier argenté', 150.00, 'normale', NULL, NULL, NULL, 10, 'Étranger', 2, '/img/montre.jpg', 8),
--('Bleu de Chanel', 'Eau de toilette 100ml', 75.00, 'normale', NULL, NULL, NULL, 15, 'France', 2, '/img/parfum.jpg', 5),
-- ('Collier', 'Or plaqué', 120.00, 'normale', NULL, NULL, NULL, 8, 'Breizh', 1, '/img/collier.jpg', 6),
--('Montre acier', 'Montre élégante dotée d’un bracelet en acier inoxydable et d’un cadran travaillé avec soin. Son mécanisme précis garantit une lecture fiable de l’heure. Parfaite pour une tenue habillée ou professionnelle.', 160.00, 'normale', NULL, NULL, NULL, 6, 'France', 2, '/img/acier.jpg', 8, 'tarif1'),
--('Gel douche', 'Gel douche hydratant enrichi en extraits naturels pour nettoyer la peau tout en douceur. Sa mousse légère et son parfum frais apportent une sensation de bien-être au quotidien. Convient à tous types de peaux, même les plus sensibles.', 4.60, 'réduite', NULL, NULL, NULL, 100, 'France', 8, '/img/gel.jpg', 6, 'tarif1'),
--('Shampooing doux', 'Shampooing formulé avec des ingrédients respectueux du cuir chevelu. Sa texture légère nettoie efficacement tout en laissant les cheveux souples et brillants. Idéal pour un usage fréquent sans agresser la fibre capillaire.', 5.20, 'réduite', NULL, NULL, NULL, 120, 'France', 8, '/img/shampooing.jpg', 5, 'tarif1'),
--('Crème hydratante', 'Crème visage riche en agents nourrissants permettant de maintenir l’hydratation cutanée toute la journée. Sa texture onctueuse pénètre rapidement sans laisser de film gras. Adaptée aux peaux sèches et sensibles.', 12.00, 'réduite', NULL, NULL, NULL, 70, 'Étranger', 5, '/img/creme.jpg', 7, 'tarif1'),
--('Baume lèvres', 'Baume nourrissant permettant de protéger les lèvres contre le froid et la sécheresse. Sa formule douce enrichie en beurre végétal laisse un film protecteur durable. Pratique à emporter partout.', 3.20, 'réduite', NULL, NULL, NULL, 150, 'France', 15, '/img/baume.jpg', 8, 'tarif1'),
--('Eau florale', 'Eau florale obtenue par distillation douce de pétales de fleurs. Ses propriétés apaisantes en font un soin idéal pour le visage. Rafraîchissante et naturelle, elle peut être utilisée matin et soir pour tonifier la peau.', 9.90, 'réduite', NULL, NULL, NULL, 80, 'France', 6, '/img/eau.jpg', 8, 'tarif1'),
--('Gommage corps', 'Soin exfoliant composé de grains naturels permettant une élimination douce des impuretés. Laisse la peau lisse et éclatante après utilisation. Convient à tous types de peaux et peut s’utiliser une à deux fois par semaine.', 11.50, 'réduite', NULL, NULL, NULL, 60, 'Étranger', 5, '/img/gommage.jpg', 8, 'tarif1'),
--('Crème mains', 'Crème émolliente qui hydrate et protège les mains abîmées. Sa texture non grasse permet une application rapide et un confort immédiat. Parfaite au quotidien pour lutter contre la sécheresse cutanée.', 4.90, 'réduite', NULL, NULL, NULL, 110, 'France', 6, '/img/mains.jpg', 8, 'tarif1'),
--('Lotion tonique', 'Lotion délicate conçue pour rafraîchir et purifier la peau. Elle élimine les dernières impuretés et prépare le visage à recevoir un soin hydratant. Formule testée sous contrôle dermatologique.', 8.30, 'réduite', NULL, NULL, NULL, 80, 'France', 8, '/img/lotion.jpg', 7, 'tarif1'),
--('Huile massage', 'Huile corporelle aux extraits naturels permettant des massages relaxants. Sa texture fluide glisse parfaitement sur la peau et laisse un fini doux. Idéale pour les séances de bien-être à la maison.', 13.80, 'réduite', NULL, NULL, NULL, 70, 'Étranger', 6, '/img/huilemas.jpg', 5, 'tarif1'),
--('Brosse cheveux', 'Brosse ergonomique conçue pour un démêlage facile et sans douleur. Ses picots souples respectent la fibre capillaire tout en réduisant les risques de casse. Un accessoire indispensable pour tous types de cheveux.', 6.90, 'super-réduite', NULL, NULL, NULL, 100, 'France', 8, '/img/brosse.jpg', 8, 'tarif1'),
--('Peigne bois', 'Peigne fabriqué en bois naturel poli, offrant un démêlage doux. Recommandé pour limiter l’électricité statique et protéger la chevelure. Sa forme simple et robuste assure une excellente prise en main.', 5.20, 'super-réduite', NULL, NULL, NULL, 120, 'Breizh', 15, '/img/peigne.jpg', 6, 'tarif1'),

INSERT INTO Categorie (libelleCat) VALUES
('Alimentaire'),
('Vêtements'),
('Hygiène'),
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
('Douche'),
('Décoration'),
('Cuisine'),
('Salle de bain'),
('Rangements'),
('Bien-être'),
('Electronique'),
('Stylo'),
('Sport'),
('Extérieur'),
('Activités');

INSERT INTO SousCat(libCat,libSousCat) VALUES
('Alimentaire', 'Boissons'),
('Alimentaire', 'Fruits & Légumes'),
('Alimentaire', 'Epicerie sucrée'),
('Alimentaire', 'Epicerie salée'),
('Vêtements', 'Accessoire'),
('Vêtements', 'Chaussures'),
('Vêtements', 'Haut'),
('Vêtements', 'Bas'),
('Hygiène','Beauté'),
('Hygiène','Douche'),
('Intérieur', 'Décoration'),
('Intérieur', 'Cuisine'),
('Intérieur', 'Rangements'),
('Intérieur', 'Bien-être'),
('Intérieur', 'Salle de bain'),
('Intérieur', 'Electronique'),
('Intérieur', 'Sport'),
('Papeterie', 'Stylo'),
('Extérieur','Activités');


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
(17, 'Hygiène'),
(18, 'Vêtements'),
(19, 'Vêtements'),
(20, 'Papeterie'),
(21, 'Alimentaire'),
(22, 'Alimentaire'),
(23, 'Alimentaire'),
(24, 'Alimentaire'),
(25, 'Alimentaire'),
(26, 'Alimentaire'),
(27, 'Alimentaire'),
(28, 'Alimentaire'),
(29, 'Alimentaire'),
(30, 'Alimentaire'),
(31, 'Vêtements'),
(32, 'Vêtements'),
(33, 'Vêtements'),
(34, 'Vêtements'),
(35, 'Vêtements'),
(36, 'Vêtements'),
(37, 'Vêtements'),
(38, 'Vêtements'),
(39, 'Vêtements'),
(40, 'Vêtements'),
(41, 'Intérieur'),
(42, 'Intérieur'),
(43, 'Intérieur'),
(44, 'Intérieur'),
(45, 'Intérieur'),
(46, 'Intérieur'),
(47, 'Intérieur'),
(48, 'Intérieur'),
(49, 'Intérieur'),
(50, 'Intérieur'),
(51, 'Vêtements'),
(52, 'Hygiène'),
(53, 'Vêtements'),
(54, 'Vêtements'),
(55, 'Papeterie'),
(56, 'Hygiène'),
(57, 'Hygiène'),
(58, 'Hygiène'),
(59, 'Hygiène'),
(60, 'Hygiène'),
(61, 'Hygiène'),
(62, 'Hygiène'),
(63, 'Hygiène'),
(64, 'Hygiène'),
(65, 'Hygiène'),
(66, 'Hygiène'),
(67, 'Hygiène'),
(68, 'Hygiène'),
(69, 'Intérieur'),
(70, 'Intérieur'),
(71, 'Intérieur'),
(72, 'Intérieur'),
(73, 'Intérieur'),
(74, 'Intérieur'),
(75, 'Intérieur'),
(76, 'Intérieur'),
(77, 'Intérieur'),
(78, 'Intérieur'),
(79, 'Intérieur'),
(80, 'Intérieur'),
(81, 'Intérieur'),
(82, 'Intérieur'),
(83, 'Intérieur'),
(84, 'Intérieur'),
(85, 'Intérieur'),
(86, 'Intérieur'),
(87, 'Intérieur'),
(89, 'Intérieur'),
(90, 'Intérieur'),
(91, 'Extérieur'),
(92, 'Extérieur'),
(93, 'Extérieur'),
(94, 'Extérieur'),
(95, 'Extérieur'),
(96, 'Vêtements'),
(97, 'Intérieur'),
(98, 'Intérieur'),
(99, 'Intérieur'),
(100, 'Intérieur');

INSERT INTO Adresse(num,codePostal, nomVille, nomRue) VALUES
(10, '75001', 'Paris', 'Prad-land'),
(04,  '69003', 'Lyon', 'Kergaradec'),
(22, '13001', 'Marseille', 'Plougastel'),
(01,  '59000', 'Lille','Rue la bienfaisance'),
(07,  '06000', 'Nice','Avenue de la libération'),
(15, '33000', 'Bordeaux','Rue de la forêt'),
(02, '33000', 'Bordeaux','Rue Edouard Branly'),
(19, '33000', 'Bordeaux','Le Quedel'),
(16, '22300', 'Lannion', 'Rue Jeanne d''Arc'),
(02, '29300', 'Baye', 'Rue du Saule');

INSERT INTO AdrFactCli(codeCompte, idAdresse) VALUES 
(1,1),
(2,2),
(3,3),
(4,4),
(9,9),
(10,10);
INSERT INTO AdrSiegeSocial(codeCompte, idAdresse) VALUES
(5,5),
(6,6),
(7,7),
(8,8);




insert into Panier(codeCompte,dateCreaP) VALUES
(3,null);

insert into ProdUnitPanier(idPanier,codeProduit,qteProd) VALUES
(1,1,2),
(1,2,2),
(1,4,1),
(1,3,1);

INSERT INTO Photo(urlPhoto) VALUES 
('./img/photosProfil/Cunty.png'),
('./img/photosProfil/PDP_EU2.jpeg'),
('./img/photosProfil/PDP_tst.jpeg'),
('./img/photosProfil/PDP_BBl.jpeg');
INSERT INTO Profil(urlPhoto, codeClient) VALUES 
('./img/photosProfil/Cunty.png' , 1),
('./img/photosProfil/PDP_EU2.jpeg' , 2),
('./img/photosProfil/PDP_tst.jpeg' , 3),
('./img/photosProfil/PDP_BBl.jpeg' , 4);

insert into Avis(codeproduit,codecomptecli,noteprod,commentaire,datepublication) VALUES
(1,1,5,'J adore ce produit, il est vraiment bien, il est arrivé vite en plus',null),
(2,2,4,'Produit conforme à la description, satisfait de mon achat',null),
(5,3,2,'Le café n est pas à mon goût, je ne le rachèterai pas',null),
(4,3,1,'Aucune protection du produit dans le colis, il est arrivé abimé, je ne recommande pas ce vendeur',null),
(6,1,2,'Le produit est moyen',null),
(3,4,4,'Bon rapport qualité prix',null),
(5,2,5,'Excellent café, je le recommande vivement',null),
(7,3,3,'Le jean est correct mais la taille est un peu grande',null),
(10,4,4,'Casquette confortable et de bonne qualité',null),
(15,1,5,'Sac à dos super solide, très satisfait de mon achat',null),
(2,2,3,'J aime bien mais c est pas mon truc non plus',null);

insert into Carte(numCarte,nomTit,prenomTit,CVC,dateExp) VALUES
('1234 5678 9123 4567','test','adalbert','890','2026-01-01'),
('4567 1234 5678 9123','Bernard','Constance','980','2026-02-01');

insert into Commande(codeCompte,idCarte,dateCom) VALUES
(3,1,'2025-11-23'),
(3,2,'2025-11-24'),
(2,2,'2025-11-25');

insert into ProdUnitCommande(numCom,codeProduit,qteProd) VALUES
(1,1,2),
(1,2,2),
(1,4,1),
(1,5,1),
(2,6,1),
(2,8,2),
(3,2,2),
(3,4,1),
(3,9,1);

insert into AdrLiv(numCom,idAdresse) VALUES
(1,1),
(2,4);

select * from ProdUnitCommande;
select * from Commande;
select * from AdrLiv;
select * from adresse;
SELECT codeProduit FROM ProdUnitCommande WHERE numCom = 1 ORDER BY codeProduit LIMIT 2;
--SELECT PUC.codeProduit FROM ProdUnitCommande PUC WHERE;
SELECT DISTINCT puc.numCom FROM Produit p INNER JOIN ProdUnitCommande puc ON p.codeProduit = puc.codeProduit where  CodeCompteVendeur = 5 ORDER BY numCom  ;
                              

SELECT * FROM alizon.Client;
SELECT * FROM alizon.Vendeur;
SELECT * FROM alizon.Panier;
INSERT INTO alizon.Panier (prixTTCtotal) VALUES (0);
SELECT * FROM alizon.ProdUnitPanier;
--SELECT profil.urlphoto, produit.libelleprod, client.pseudo, avis.noteprod, avis.commentaire FROM avis INNER JOIN produit ON (avis.codeproduit = produit.codeproduit) INNER JOIN client ON (avis.codecomptecli = client.codecompte) INNER JOIN profil ON (profil.codeclient = client.codecompte) ORDER BY avis.codeproduit;
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