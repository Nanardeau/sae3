<?php
//Connexion à la base de données.
require_once __DIR__ . '/_env.php';
loadEnv(__DIR__ . '/.env');

// Récupération des variables
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');


// Connexion à PostgreSQL

try {
    $ip = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';';
    $bdd = new PDO($ip, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    // "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    // "❌ Erreur de connexion : " . $e->getMessage();
}
$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/panier.css" rel="stylesheet" type="text/css">
    <script src="js/Panier.js"></script>
</head>

<body>

    <?php include 'includes/header.php' ?>
    <main>
        <?php //Si le client n'a rien dans so panier afficher -> panier vide 
        //Sinon -> afficher les informations du panier.  
        $stmU = $bdd->prepare('SELECT codeCompte FROM Client WHERE pseudo = ?'); // Ligne test pour tester si le client a un panier vide
        $stmU->execute(['test']);
        //$stmU->execute(['Nanardeau']);
        $idUsertmp = $stmU->fetchAll();
        $idUser =  $idUsertmp[0]['codecompte'];

        // Rercherche du panier par rapport au code compte 
        $stmP = $bdd->prepare('SELECT * from Panier where codeCompte = \''.$idUser.'\'');
        $stmP->execute();
        $ifPanierTemp = $stmP->fetch();
        //print_r($nbProdPanier);
        if($ifPanierTemp == null){?>

            <!--version panier vide-->
            <div class="vide">
                <h1> Votre panier est vide </h1>
                <a href="index.html">Revenir à l'acceuil<a>
            </div>

        <?php
        }
        else{
            //Nombre d'élément dans le panier
            $stmNb = $bdd->query('SELECT ALL count(*) from ProdUnitPanier where idPanier = 1');
            $nbProdPanier = $stmNb->fetch();
        
            $infoPanier['idpanier'] = $ifPanierTemp["idpanier"];
            $infoPanier['prixTTC'] = $ifPanierTemp["prixttctotal"];
            $infoPanier['prixHT'] = $ifPanierTemp["prixhttotal"];
            $infoPanier['nbProd'] = $nbProdPanier['count'];
              // Récupération de la liste des produits dans le panier
            $stmProd = $bdd->query('SELECT ALL codeProduit,qteprod,prixTTCtotal from ProdUnitPanier where idPanier = 1 ORDER BY codeProduit');
            $ListeProdPanier = $stmProd->fetchAll();
            ?>

        <h2>Votre Panier (<?php echo $infoPanier['nbProd'] ?> articles)</h2>
    <div class="recap">
            <h4>Récapitulatif ( <?php echo $infoPanier['nbProd']?> articles) </h4>
            <p>Prix HT : <?php echo $infoPanier["prixHT"]?></p>
            <p style="font-weight : bold">Prix TTC : <?php echo $infoPanier["prixTTC"]?></p>
            <input type="button" value="Commander"/>
        </div>
        <article>
        <?php
        foreach($ListeProdPanier as $liste){
            $stmInfoProd = $bdd->query('SELECT libelleProd,urlphoto,codecomptevendeur from Produit where codeProduit = '.$liste["codeproduit"] );
            $infoProd = $stmInfoProd->fetch();
            //print_r($infoProd);
            $codeVendeur = $infoProd["codecomptevendeur"];
            
            $stmInfoVend = $bdd->query('SELECT nom from Vendeur where codecompte = '. $codeVendeur);
            $infoVendeur = $stmInfoVend->fetch();
            //print_r($infoVendeur);

            $nomProd = $infoProd["libelleprod"];
            $urlImg = $infoProd["urlphoto"];
            $vendeur = $infoVendeur["nom"];
            $qteProd = $liste["qteprod"];
            $qteProd = round($qteProd);
            $prixTTC = $liste["prixttctotal"];
        ?>
        
        <div class="articlePanier" data-idpanier="<?php echo $infoPanier['idpanier']?>" data-codeprod="<?php echo $liste["codeproduit"]?>">
            <div>
                <h3><?php echo $nomProd?></h3>
                <p> Vendu par <strong><?php echo $vendeur?></strong></p>
            </div>
            <img src="<?php echo $urlImg?> " alt="Image produit"/>
            <article>
            <div class="compteur">
                <?php 
                    if($qteProd == 1){?>
                        <input type="button" value="*" class="btn-supp">
                        </input>
                    <?php }else{?>
                    
                <input type="button" value="-" class="btn-moins">
                <?php
                }
                ?>
                <p class="nbArt"><?php echo $qteProd?></p>
                <input type="button" value="+" class="btn-plus">
            </div>
            <p class="prix"><?php echo $prixTTC?> €</p>
            </article>
        </div>
        
        <?php }?>
        </article>
        
        <input type="button" value="Vider Panier" class="btn-vider" data-idpanier="<?php echo $infoPanier['idpanier']?>"/>
        
    
        
        <?php }?>
    </main>
    <?php include 'includes/footer.php' ?>
</body>

</html>