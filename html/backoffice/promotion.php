<?php
session_start();

if(!array_key_exists("codeCompte", $_SESSION) || !isset($_SESSION["codeCompte"])){
    header('location: connexionVendeur.php');
    
}else{

    $codeCompte = $_SESSION["codeCompte"];
    
}

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

$sql = "SELECT * FROM alizon.Vendeur WHERE codeCompte = '".$codeCompte."'";
$stmt = $bdd->query($sql);
$vendeur = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon BackOffice</title>
    <link rel="stylesheet" href="../css/style/backoffice/accueilBack.css" type="text/css">
    <link href="../css/components/fonts.css" rel="stylesheet" type="text/css">
    <link href="../css/style/backoffice/promotion.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include '../includes/backoffice/header.php';?>
    <main><?php
        include '../includes/backoffice/menuCompteVendeur.php';
    $bdd->query("SET SCHEMA 'alizon'"); ?>
    <?php include '../includes/backoffice/menu.php'; ?>
    <div class="right-content"> 
        <?php
        $sql = "SELECT * FROM alizon.Vendeur WHERE codeCompte = '".$codeCompte."'";
        $stmt = $bdd->query($sql);
        $vendeur = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<h1 class="bvn-vendeur">Bienvenue '.$vendeur['prenom'].' '.$vendeur['nom'].'</h1>';
        ?>
        <div class="mes-produits">
            <h1>Mes produits au catalogue</h1>
        </div>
    </main>
    <?php include '../includes/backoffice/footer.php'; ?>
    <!-- <script src="../js/preview-img.js"></script> -->
    <script src="../js/overlayCompteVendeur.js"></script>
</body>
</html>