<?php
session_start();
$_SESSION["codeCompte"] = 3 ; 

if(!array_key_exists("codeCompte", $_SESSION) || !isset($_SESSION["codeCompte"])){
            header("location:index.php");
        }

$codeCompte = $_SESSION["codeCompte"];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style/Commande.css" rel="stylesheet" type="text/css">
    <title>Alizon</title>
</head>
<body>
    <?php include "includes/headerCon.php"?>
    <main>
    <h1>Vos commandes</h1>
    <div class="separateur"></div>
    <?php  
    $lesCommandes = $bdd->query('SELECT * FROM Commande WHERE codeCompte =\''. $codeCompte .'\'')->fetchAll();
    print_r($lesCommandes);
    // Si ne possède pas des commandes -> Pas de commandes
    // Sinon afficher son nb de commandes
    if($lesCommandes == null){
        ?>
        <div class="vide">
                <h1> Vous n'avez pas passé de commande</h1>
                <a href="index.php">Revenir à l'accueil<a>
            </div>
        <?php
    }
    else {
        foreach($lesCommandes as $commande){
            $prixTTC = $commande["prixttctotal"];
            $prixHT = $commande["prixhttotal"];
            $date = $commande["datecom"];
            $idCom = $commande["numcom"];
            $lesProduits = $bdd->query('SELECT codeProduit FROM ProdUnitCommande WHERE numCom =\''.$idCom.'\' ORDER BY codeProduit LIMIT 3 ');
            
            ?>
            <article>
                <div >
                <?php foreach($lesProduits as $prod){
                    $imgProd = $bdd->query("SELECT urlPhoto FROM Produit WHERE codeProduit =" .$prod['codeproduit'])->fetch();
                    
                    ?>
                
                    <img src="<?php echo $imgProd['urlphoto']?>" alt="Image produit"/>
                
                <?php }?>
                <div>
            </article>
            <?php
        }
    }
    ?>
    

    </main>
    <?php include "includes/footer.php"?>
</body>
</html>