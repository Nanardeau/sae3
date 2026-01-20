<?php
session_start();


//$codeCompte = $_SESSION["codecompte"];
//Connexion à la base de données.
require_once  '../_env.php';
loadEnv('../.env');

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
    //echo "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}

$bdd->query("SET SCHEMA 'alizon'");

$signalements = $bdd->query("SELECT * FROM Signalement")->fetchAll(PDO::FETCH_ASSOC);

?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon BackOffice</title>
    <link rel="stylesheet" href="../css/style/backoffice/accueilBack.css" type="text/css">
    <link href="../css/components/fonts.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include '../includes/backoffice/header.php';?>
    <main>
        <?php
            include '../includes/backoffice/menuCompteVendeur.php';
            include '../includes/backoffice/menu.php'; 
        ?>
        
        <section>
            <h1 class="bvn-vendeur">Signalement d'avis</h1>
            <?php 
            foreach ($signalements as $signalement) { 
                // Récupérer le nom du produit associé au signalement
                $produitStmt = $bdd->prepare("SELECT libelleProd FROM Produit WHERE codeProduit = :codeproduit");
                $produitStmt->execute(['codeproduit' => $signalement['idsignalement']]);
                $produit = $produitStmt->fetch(PDO::FETCH_ASSOC);
                $nomProduit = $produit ? $produit['libelleprod'] : 'Produit inconnu';
                ?>
                <div class="signalement-item" style="background-color: white; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc;">
                    <p>Produit: <?= $nomProduit ?></p>
                    <p>Message: <?= $signalement['motif'] ?></p>
                    <p>Date: <?= $signalement['datesignalement'] ?></p>
                </div>
            <?php } ?>
        </section>
    </main>
</body>
</html>