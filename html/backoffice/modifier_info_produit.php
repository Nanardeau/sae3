<?php
$_GET["codeProduit"]=11;
if(isset($_GET["erreur"])){
        $erreur = $_GET["erreur"];
}
else{
        $erreur = NULL;
    }
session_start();
//Connexion à la base de données.
require_once('../_env.php');
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

        header('Location: http://localhost:8888/index.php');
        
}
$_SESSION["codeCompte"] = 5; //ligne temporaire, en attendant d"avoir le système de connexion 

if(!isset($_SESSION["codeCompte"])){
        header('Location: http://localhost:8888/backoffice/index.php');
           
    }
$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style/modifier_info_produit.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
    <title>Alizon BACK</title>
</head>
<body>
    <?php include("../includes/backoffice/header.php"); ?>
<main>
    <?php if($erreur == "succes"){
                echo "<h2 style=\"color:green\">Produit créé avec succès</h2>";
            }
            else if($erreur == "image"){
                echo "<h2 style=\"color:red\">Produit image avec erreur</h2>";
            }
    ?>
<form action="enregProduit.php" method="post" enctype="multipart/form-data">
    <h2>Modifier Produit</h2>
    
    <label for="nom">Intitulé</label>
    <?php
    $code_produit=$_GET["codeProduit"];
    $info = $bdd->query("SELECT libelleProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
    $res=$info["libelleprod"];
        
    ?>
    <input type="text" name="nom" placeholder="Intitulé..." value=<?php echo "$res"; ?> id="nom" required/> 
    <?php 
    if($erreur == "produit"){
        echo "<p style=\"color:red\">Produit déjà existant</p>";
    }
    $info = $bdd->query("SELECT descriptionProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                        
    $res=$info["descriptionprod"];
    ?>
    
    <label for="description">Déscription détaillée</label>
    <textarea name="description" id="description" rows="5" cols="33" value=<?php echo "$res"; ?> required></textarea>
    <label for="categorie">Catégorie</label>
    <select name="categorie" id="categorie" required>
        <option value="" disabled selected>Choisir une catégorie</option>
        <?php 
    $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  
    
    foreach ($listCat as $libcat) {
        ?>
    <option value="<?php echo $libcat['libcat']; ?>"><?php echo $libcat['libcat']; ?></option>
    <?php
    }
    ?>
    </select>
    <label for="TVA">TVA</label>
    <select name="TVA" id="TVA" required>
        <option value="" disabled selected>Choisir le taux TVA</option>
        <?php 
    $listTVA = $bdd->query('SELECT DISTINCT nomTVA FROM TVA'); //Nom de la catégorie  
    foreach ($listTVA as $nomTVA) {
        ?>
    <option value="<?php echo $nomTVA['nomtva']; ?>"><?php echo $nomTVA['nomtva']; ?></option>
    <?php
    }
    ?>
    </select>
    
    <label for="qteStock" class="pObl">Quantité Stock</label>
    <input type="number" name="qteStock" placeholder="Nombre de produit en stock" id="qteStock"/> 
    <label for="prix">Seuil d'alerte</label>
    <input type="number" name="seuil" placeholder="Seuil d'alerte du produit" id="seuil" required/>
    <label for="photoProd" class="pObl">Photo du Produit</label>
    <input type="file" name="photo" id="photoProd" accept="image/*"/>
    <h3> Taille Produit </h3>
    <div class="taille container-fluid p-0">
        <div class="row">
            <div class="col-3 labelInput">
                <label for="tailleHaut">Hauteur</label>
                <input type="text" name="tailleHaut" placeholder="en mètre" id="tailleHaut"/>
            </div>
            <div class="col-3 labelInput">
                <label for="tailleLarg">Largeur</label>
                <input type="text" name="tailleLarg" placeholder="en mètre" id="tailleLarg"/>
            </div>
            <div class="col-3 labelInput">
                <label for="tailleLong">Longueur</label>
                <input type="text" name="tailleLong" placeholder="en mètre" id="tailleLong"/>
            </div>
        </div>
    </div>
    <label for="prix">Prix</label>
    <input type="text" name="prix" placeholder="Prix Hors Taxe € (XX.XX)" id="prix" pattern="[.0-9]" required/> 
    <input class="bouton" type="submit" id="creerProduit" value="Valider le produit"/>
</form>
        
</main>
</body>
</html>