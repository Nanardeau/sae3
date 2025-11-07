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

        // Récupération du nombre de produit dans le panier
        $stmNb = $bdd->query('SELECT ALL count(*) from ProdUnitPanier where idPanier = 1');
        $nbProdPanier = $stmNb->fetch();

        //print_r($nbProdPanier);
        if($ifPanierTemp == null){
            ?>
            <!--version panier vide-->
            <div class="vide">
                <h1> Votre panier est vide </h1>
                <a href="index.html">Revenir à l'acceuil<a>
            </div>
        <?php
        }
        else{
            $infoPanier['idpanier'] = $ifPanierTemp["idpanier"];
            $infoPanier['prixTTC'] = $ifPanierTemp["prixttctotal"];
            $infoPanier['prixHT'] = $ifPanierTemp["prixhttotal"];
            $infoPanier['nbProd'] = $nbProdPanier['count'];
            
        }
        ?>
        <h2>Votre Panier (<?php echo $infoPanier['nbProd'] ?> articles)</h2>
        <div>

        </div>
        <input type="button" value="Vider Panier"></input>
        

        





    </main>
    <?php include 'includes/footer.php' ?>
</body>

</html>