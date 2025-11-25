<?php
session_start();
//$_SESSION["codeCompte"] = 5 ; 

if(!array_key_exists("codeCompte", $_SESSION) || !isset($_SESSION["codeCompte"])){
            header("location:index.php");
        }

$codeCompte = $_SESSION["codeCompte"];
//Connexion à la base de données.
require_once __DIR__ . '/_env.php';
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
    // "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    //"❌ Erreur de connexion : " . $e->getMessage();
    ?>
    <script>
        alert("Erreur lors du chargement");
    </script>
    <?php
        //header('Location: http://localhost:8888/index.php');
        exit();
}
$bdd->query('set schema \'alizon\'');


?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style/backoffice/CommandesVendeur.css" rel="stylesheet" type="text/css">
    <link href="../css/components/fonts.css" rel="stylesheet" type="text/css">
    <title>Alizon</title>
</head>
<body>
    <?php include("../includes/backoffice/header.php"); ?>
    <main>
    <a href="index.php" class="btn-retour">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <path d="m14 16-4-4 4-4"/>
        </svg>
        Retour
    </a>
    <h1>Vos commandes</h1>
    
    
    <?php  
    $sql = "SELECT DISTINCT puc.numCom FROM Produit p 
    INNER JOIN ProdUnitCommande puc ON p.codeProduit = puc.codeProduit 
    where  CodeCompteVendeur = :codeCompte ORDER BY numCom
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array("codeCompte"=>$codeCompte));
    $lesCommandes = $stmt->fetchAll();
    //print_r($lesCommandes);
    // Si ne possède pas des commandes -> Pas de commandes
    // Sinon afficher son nb de commandes
    if($lesCommandes == null){
        ?>
        <div class="separateur"></div>
        <div class="vide">
                <h1> Vous n'avez reçu aucune commande</h1>
                <a href="index.php">Revenir à l'accueil<a>
            </div>
        <?php
    }
    else {
        ?>
        <div class="cmd">
        <?php
        foreach($lesCommandes as $commande){
            $idCom = $commande["numcom"];
            $lesProduits = $bdd->query('SELECT DISTINCT p.codeProduit,puc.qteProd FROM Produit p INNER JOIN ProdUnitCommande puc ON p.codeProduit = puc.codeProduit where numCom =\''.$idCom.'\' AND CodeCompteVendeur =\''. $codeCompte.'\' ');
            //print_r($lesProduits);
            ?>
            <div class="separateur"></div>
            <article>
                <h2>Commande n°<?php echo $idCom ?></h2>
                <table>
            <thead>
                <tr>
                    <th>Nom produit</th>
                    <th>Code Produit</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //print_r($lesProduits);
                foreach($lesProduits as $prod){
                    $idProd = $prod['codeproduit'];
                    $qteprod =$prod['qteprod'];
                    $nomProd = $bdd->query('SELECT libelleProd FROM Produit where codeProduit = '. $idProd)->fetch();
                    
                    ?>
                    
                     <tr>
                        <td><?php echo $nomProd['libelleprod'];?></td>
                        <td><?php echo $idProd ; ?></td>
                        <td><?php echo $qteprod ;?></td>
                     </tr>
                   
                     <?php
                }
                ?>
            </tbody>
        </table>
                <div >
                <?php foreach($lesProduits as $prod){
                    $imgProd = $bdd->query("SELECT urlPhoto FROM Produit WHERE codeProduit =" .$prod['codeproduit'])->fetch();
                    
                    ?>
                    
                <?php }?>
                </div>
                <div class='info'>
                    <p>
                    
                </div>
                
            </article>
            <?php
        }
    }
    ?>
    </div>
    

    </main>
    <?php include "../includes/backoffice/footer.php"?>
</body>
</html>
