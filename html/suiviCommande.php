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

$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/suiviCommande.css" rel="stylesheet" type="text/css">
    
    <!-- <script src="js/truc.js"></script> -->
</head>

<body>

    <?php 
    
    if(isset( $_SESSION["codeCompte"])){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }

    $numCommande = $_GET['numCommande']; #recuperer num de commande
    $req = $bdd->prepare('SELECT * from Panier where numCom = :numCom');
    $rep= $bdd->execute(array(
        ":numCom" => $numCommande
    ));
    $rep = $rep->fetch();
    $dateCom = $rep["datecom"];

    $req2 = $bdd->prepare('SELECT * from Compte where codeCompte = :idUser'); #recuperer info client
    $rep2= $bdd->execute(array(
        ":idUser" => $idUser
    ));
    $rep2 = $rep2->fetch();
    
    $nomCli=$rep2["nom"];
    $prenomCli=$rep2["prenom"];
    $telephoneCli=$rep2["numtel"];

    $req3= $bdd->prepare('SELECT * from AdrLiv INNER JOIN Adresse ON AdrLiv.idAdresse = Adresse.idAdresse where numCom = :numCommande');
    $rep3=$bdd->execute(array(":numCommande"=>$numCommande));
    $rep3 = $rep3->fetch();

    $adresse = $rep3["num"] . $rep3["nomrue"] . $rep3["codepostal"] . $rep3["nomville"]; #recuperer adresse de livraison


    $stmProd = $bdd->prepare('SELECT ALL codeProduit,qteprod from ProdUnitCommande where numCom = :numCommande ORDER BY codeProduit');
    $ProdCommande= $bdd->execute(array( 
        ":numCommande" => $numCommande
    ));
    $ProdCommande = $stmProd->fetchAll(); #recuperer les produits dans la commande
    ?>

    <main>
        <h2>Suivi de la commande</h2>
        <div>
            <div>
                <p>Numéro de commande : <?php echo "$numCommande"?></p>
                <p>Date de commande : <?php echo "$dateCom"?></p>
            </div>
            <div>
                <p>Nom client : <?php echo "$numCommande"?></p>
                <p>numero téléphone : <?php echo "$dateCom"?></p>
            </div>
            <div>
                <p>Adresse de livraison : <br> <?php echo "$adresse"?></p>
            </div>
            
        </div>
        
        <h3>Avancement</h3>
        <?php
        switch ($etape) { #en fonction de l'étape recue par delivraptor, afficher l'avancement
            case 1:
                ?>
                <img src="/img/etape1.svg" alt="Avancement livraison"/>
                <?php 
                break;
            case 2:
                ?>
                <img src="/img/etape2.svg" alt="Avancement livraison"/>
                <?php
                break;
            case 3:
            case 4:
                ?>
                <img src="/img/etape34.svg" alt="Avancement livraison"/>
                <?php
                break;
            case 5:  
            case 6:
                ?>
                <img src="/img/etape56.svg" alt="Avancement livraison"/>
                <?php
                break;
            case 7:
            case 8:
                ?>
                <img src="/img/etape78.svg" alt="Avancement livraison"/>
                <?php
                break;
            case 9: 
                ?>
                <img src="/img/etape9.svg" alt="Avancement livraison"/> 
                <?php 
                break;
            }
        ?>

        <h3>Récapitulatif</h3> 
        <table>
            <thead>
                <tr>
                <th scope="col">Quantité</th>
                <th scope="col">Code produit</th>
                <th scope="col">Nom produit</th>
                <th scope="col">vendeur</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($ProdCommande as $liste){
                    $stmInfoProd = $bdd->query('SELECT libelleProd,codecomptevendeur from Produit where codeProduit = '.$liste["codeproduit"] );
                    $infoProd = $stmInfoProd->fetch();
                    //print_r($infoProd);
                    $codeVendeur = $infoProd["codecomptevendeur"];
                    
                    $stmInfoVend = $bdd->query('SELECT nom from Vendeur where codecompte = '. $codeVendeur);
                    $infoVendeur = $stmInfoVend->fetch();
                    }
                    //print_r($infoVendeur);
                <tr>
                <th scope="row">Chris</th>
                <td>HTML tables</td>
                <td>22</td>
                </tr>
                ?>
                <tr>
                <th scope="row">Dennis</th>
                <td>Web accessibility</td>
                <td>45</td>
                </tr>
                <tr>
                <th scope="row">Sarah</th>
                <td>JavaScript frameworks</td>
                <td>29</td>
                </tr>
                <tr>
                <th scope="row">Karen</th>
                <td>Web performance</td>
                <td>36</td>
                </tr>
            </tbody>
        </table>

    </main>
    <?php include 'includes/footer.php'?>
</body>