<?php
session_start();

//Connexion à la base de données.
require_once( __DIR__ . '/_env.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/overlayAchat.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php 

    if(isset($_SESSION['codeCompte'])){
        include 'includes/headerCon.php' ;
        $codeCompte = $_SESSION['codeCompte'];
    }else{
        include 'includes/header.php';
        include 'includes/menu_cat.php';
    }
    $codeProduit = $_GET["codeProd"];
    ?>

    <main>
        <?php if(isset($_GET["ajout"])):?>
        <div class="ajoutPanierFait">
            <div class="partieGauche" onclick="fermerPopUpPanier()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div class="partieDroite">
                <p>Produit ajouté au panier</p>
                <a href="Panier.php" class="bouton">Aller au panier</a>
            </div>
        </div>
        <?php endif?>

        <h4>Ajouter au panier</h4>
        <figure>
            <a href="dproduit.php?id=<?= $codeProduit ?>"><img src="<?php echo $img ?>" /></a>
            <figcaption><?php echo $libArt ?></figcaption>
        </figure>
        <p>Souhaitez vous ajouter ce produit au panier ou l'acheter instantanément?</p>
        <?php if(!isset($_SESSION["codeCompte"])):?>
        <a class="button" href="ConnexionClient.php?page=paiement">Acheter</a>
        <?php endif?>
        <?php if(isset($_SESSION["codeCompte"])):?>
        <a class="button" href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>&instant=1">Acheter</a>
        <?php endif?>
        <a class="button" href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>&page=Catalogue.php">Ajouter au panier</a>

    </main>
    <?php include 'includes/footer.php';?>
    <script>
        function fermerPopUpPanier(){
            window.location.href = "index.php";
        }

    </script>
</body>

</html>