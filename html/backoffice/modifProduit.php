<?php
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

        
}

if(!isset($_SESSION["codeCompte"])){
        header('Location: index.php');
           
}
$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style/backoffice/modifier_info_produit.css" rel="stylesheet" type="text/css">
    <link href="../css/components/fonts.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="img/favicon_alizon.png" type="image/x-icon">
    <title>Alizon Back Office - Modifier la fiche produit</title>
</head>
<body>
    <?php include("../includes/backoffice/header.php"); 
        $code_produit=$_GET["codeProduit"];?>
    
<main>
    <a href="index.php" class="btn-retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</a>
    <?php if($erreur == "succes"){
                echo "<h2 style=\"color:green\">Produit modifié avec succès</h2>";
            }
            else if($erreur == "image"){
                echo "<h2 style=\"color:red\">ERREUR : Image indisponible</h2>";
            }
    ?>

<form action="reqModifProduit.php?codeproduit=<?php echo $_GET["codeProduit"] ?>" method="post" enctype="multipart/form-data">
    <h2>Modifier Produit</h2>
    
    <label for="nom">Intitulé</label>
    <?php

    $info = $bdd->query("SELECT libelleProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
    $res=$info["libelleprod"];
    ?>
    <input type="text" name="nom" placeholder="Intitulé..." value="<?php echo "$res"; ?>" id="nom" required/> 
    <?php 
    if($erreur == "produit"){
        echo "<p style=\"color:red\">Produit déjà existant</p>";
    }
    $info = $bdd->query("SELECT descriptionProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                        
    $res=$info["descriptionprod"];
    ?>
    
    <label for="description">Description détaillée</label>
    <textarea name="description" id="description" rows="5" cols="33" placeholder="Description détaillée..." required><?php echo $res; ?></textarea>
    <label for="categorie">Catégorie</label>
    <?php
        
        $info = $bdd->query("SELECT * FROM alizon.Categoriser WHERE codeproduit=$code_produit")->fetch();
        $res=$info["libellecat"];
    ?>
    <select name="categorie" id="categorie" required>
        <option value="Choisir une categorie" disabled selected><?php echo $res ?></option>
        <?php 
    $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  
    
    foreach ($listCat as $libcat) {
        ?>
    <option value="<?php echo $libcat['libcat']; ?>"><?php echo $libcat['libcat']; ?></option>
    <?php
    }
    ?>
    </select>
    <label for="origine">Origine</label>
    <span>Provenance du produit</span>
    <?php
        $info = $bdd->query("SELECT origine FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
        $res=$info["origine"];

    ?>
    <select name="origine" id="origine" required>
        <option value="<?php echo $res; ?>" disabled selected><?php echo $res; ?></option>
        <option value="Étranger">Étranger</option>
        <option value="France">France</option>
        <option value="Breizh">Breizh</option>
    </select>
    <label for="tarif">Tarification</label>
    <span>Ajout du coût de livraison au prix HT du produit</span>
    <?php
        $info = $bdd->query("SELECT nomTarif FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
        $res=$info["nomtarif"];

    ?>
    <select name="tarif" id="tarif" required>
        <option value="<?php echo $res; ?>" disabled selected><?php echo $res; ?></option>
        <option value="tarif1">Tarification 1 - 2,00€</option>
        <option value="tarif2">Tarification 2 - 5,00€</option>
        <option value="tarif3">Tarification 3 - 8,00€</option>
        <option value="tarif4">Tarification 4 - 10,00€</option>
        <option value="tarif5">Tarification 5 - 15,00€</option>
    </select>
    <label for="TVA">TVA</label>
    <span>taux de TVA à appliquée au produit </span>
    <?php
        $info = $bdd->query("SELECT nomtva FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
        $res=$info["nomtva"];

    ?>
    <select name="TVA" id="TVA" required>
        <option value="<?php echo $res; ?>" disabled selected><?php echo $res; ?></option>
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
    <?php
    $info = $bdd->query("SELECT * FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
    $res=$info["qtestock"];
    ?>
    <input type="number" name="qteStock" placeholder="Nombre de produit en stock" value="<?php echo $res; ?>" id="qteStock"/> 
    <label for="prix">Seuil d'alerte</label>
    <?php
    $res=$info["seuilalerte"];
    
    ?>
    <input type="number" name="seuil" placeholder="Seuil d'alerte du produit" value="<?php echo $res; ?>" id="seuil" required/>
    <label for="photoProd" class="pObl">Photo du Produit</label>
    <input type="file" name="photo" id="photoProd" accept="image/*"/>
    <?php
    $hauteur=$info["hauteur"];
    $largeur=$info["largeur"];
    $longueur=$info["longueur"];
    $prix=$info["prixht"];
    ?>
    <h3> Taille Produit </h3>
    <div class="taille">
            <div class="labelInput">
                <label for="tailleHaut">Hauteur</label>
                <input type="text" name="tailleHaut" placeholder="en mètre" value="<?php echo $hauteur; ?>" id="tailleHaut"/>
            </div>
            <div class="labelInput">
                <label for="tailleLarg">Largeur</label>
                <input type="text" name="tailleLarg" placeholder="en mètre" value="<?php echo $largeur; ?>" id="tailleLarg"/>
            </div>
            <div class="labelInput">
                <label for="tailleLong">Longueur</label>
                <input type="text" name="tailleLong" placeholder="en mètre" value="<?php echo $longueur; ?>" id="tailleLong"/>
            </div>
    </div>
    <label for="prix">Prix</label>
    <input type="text" name="prix" placeholder="Prix Hors Taxe € (XX.XX)" value="<?php echo $prix; ?>" id="prix" pattern="[0-9]{1,}.[0-9]{2}" required/> 
    <input class="bouton" type="submit" id="creerProduit" value="Valider le produit"/>
</form>
        
</main>
<?php include("../includes/backoffice/footer.php"); ?>
</body>
</html>