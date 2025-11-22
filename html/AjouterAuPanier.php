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
session_start();
$bdd->query('set schema \'alizon\'');
?>
<?php

    if(!isset($_SESSION["idPanier"])){
        if(!isset($_SESSION["codeCompte"])){
            $stmt = $bdd->prepare("INSERT INTO Panier (dateCreaP) VALUES ('".date("Y-m-s H:i:s")."')");

        }
        else{
            $stmt = $bdd->prepare("INSERT INTO Panier (dateCreaP, codeCompte) VALUES ('".date("Y-m-s H:i:s")."', '".$_SESSION["codeCompte"]."')");

        } 
        $stmt->execute();

        $_SESSION["idPanier"] = $bdd->lastInsertId();

        
    }
    $codeProduit = $_GET["codeProd"];
    $prodUnitPanier = $bdd->query("SELECT * FROM ProdUnitPanier WHERE codeProduit = '".$codeProduit."'")->fetch();
    if($prodUnitPanier){
        $qteProd = $prodUnitPanier["qteprod"];

        $req = $bdd->prepare("UPDATE ProdUnitPanier SET qteProd = '".$qteProd + 1 ."' WHERE codeProduit = '".$codeProduit."'");
    }
    else{
        $req = $bdd->prepare("INSERT INTO ProdUnitPanier(codeProduit, idPanier, qteProd) VALUES ('".$codeProduit."', '".$_SESSION["idPanier"]."',1)");
    }
    $req->execute();

    #alert("Le produit a bien été ajouté au panier.");
    exit(header("location:Catalogue.php?ajout=1"));