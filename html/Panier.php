<?php
session_start();
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
    //"❌ Erreur de connexion : " . $e->getMessage();
    ?>
    <script>
        alert("Erreur lors du chargement");
    </script>
    <?php
        header('Location: http://localhost:8888/index.php');
        exit();
}
//$_SESSION["codeCompte"] = 3; //ligne temporaire, en attendant d"avoir le système de connexion 


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

    <?php 
    
    if(isset( $_SESSION["codeCompte"])){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
     ?>
    <main>
        <?php //Si le client n'a rien dans so panier afficher -> panier vide 
        //Sinon -> afficher les informations du panier.  
                
        

        // Rercherche du panier par rapport au code compte 
        if(isset($_SESSION['codeCompte'])){

        
        $stmP = $bdd->prepare('SELECT * from Panier where codeCompte = \''.$idUser.'\'');
        
        }else if(isset($_SESSION['idPanier'])) {
            $idPanier =  $_SESSION["idPanier"];
            $stmP = $bdd->prepare('SELECT * from Panier where idPanier = \''.$idPanier.'\'');
        }else{
            $stmP = $bdd->prepare('SELECT * from Panier where idPanier = -1'); // -1 est la valeur impossible à avoir en BDD donc aucun panier associer 
        }
        $stmP->execute();
        $ifPanierTemp = $stmP->fetch();
        //’print_r($ifPanierTemp);
        if($ifPanierTemp == null || $ifPanierTemp["prixttctotal"] == null){?>

            <!--version panier vide-->
            <div class="vide">
                <h1> Votre panier est vide </h1>
                <a href="index.php">Revenir à l'accueil<a>
            </div>

        <?php
        }
        else{
            $infoPanier['idpanier'] = $ifPanierTemp["idpanier"];
            $infoPanier['prixTTC'] = $ifPanierTemp["prixttctotal"];
            $infoPanier['prixHT'] = $ifPanierTemp["prixhttotal"];
            //Nombre d'élément dans le panier
            $stmNb = $bdd->query('SELECT ALL count(*) from ProdUnitPanier where idPanier = '.$infoPanier['idpanier']);
            $nbProdPanier = $stmNb->fetch();
            $infoPanier['nbProd'] = $nbProdPanier['count'];
        
            // Récupération de la liste des produits dans le panier
            $stmProd = $bdd->query('SELECT ALL codeProduit,qteprod,prixTTCtotal from ProdUnitPanier where idPanier = '.$infoPanier['idpanier'] .' ORDER BY codeProduit');
            $ListeProdPanier = $stmProd->fetchAll();
            ?>

        <h2>Votre Panier (<?php echo $infoPanier['nbProd'] ?> articles)</h2>
        <aside>
            <div class="recap">
                <h4>Récapitulatif ( <?php echo $infoPanier['nbProd']?> articles) </h4>
                <p>Prix HT : <?php echo $infoPanier["prixHT"]?></p>
                <p style="font-weight : bold">Prix TTC : <?php echo $infoPanier["prixTTC"]?></p>
                <a class="btn-recap" href="./paiement.php">Commander</a>
            </div>
                <a href="Catalogue.php" class="btn-recap">Retour</a>
        </aside>
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
        
        <div class="articlePanier">
            <div>
                <h3><?php echo $nomProd?></h3>
                <p> Vendu par <strong><?php echo $vendeur?></strong></p>
            </div>
            <img src="<?php echo $urlImg?> " alt="Image produit"/>
            
            <div class="compteur">
                <?php 
                    if($qteProd == 1){?>
                        <button class="btn-supp" onclick="supprimerPanier(<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                        
                    <?php }else{?>
                    
                <button class="btn-moins" onclick="modifProduit(this,<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg></button>
                <?php
                }
                ?>
                <p class="nbArt"><?php echo $qteProd?></p>
                <button class="btn-plus" onclick="modifProduit(this,<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></button>
            </div>
            <p class="prix"><?php echo $prixTTC?> €</p>
            
        </div>
        
        <?php }?>
        </article>
        
        <button type="button" value="" class="btn-vider" onclick="viderPanier(<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)">Vider Panier</button>
        
    
        
        <?php }?>
    </main>
    <?php include 'includes/footer.php' ?>
</body>

</html>