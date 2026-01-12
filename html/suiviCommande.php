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
    $dateCom = $rep["dateCom"];

    $req2 = $bdd->prepare('SELECT * from Client where codeCompte = :idUser');
    $rep2= $bdd->execute(array(
        ":idUser" => $idUser
    ));
    
    $nomCli=$rep2[""];
    $prenomCli=$rep2[""];
    
    ?>
    <main>
        <h2>Suivi de la commande</h2>
        <div>
            <div>
                <p>Numéro de commande : <?php echo "$numCommande"?></p>
                <p>Date de commande : </p>
            </div>
            
        </div>
        
        <h3>Avancement</h3>

        <h3>Récapitulatif</h3>

    </main>
</body>