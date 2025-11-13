<?php
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
    ?>
    <script>
        alert("Erreur lors du chargement");
    </script>
    <?php
        header('Location: http://localhost:8888/index.php');
        exit();
}
$_SESSION["codeCompte"] = 5; //ligne temporaire, en attendant d"avoir le système de connexion 

if(!isset($_SESSION["codeCompte"])){
        header('Location: http://localhost:8888/backoffice/index.php');
        exit();   
    }
$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style/ajoutProd.css" rel="stylesheet" type="text/css">
    <title>Alizon BACK</title>
</head>
<body>
    <?php include("../includes/backoffice/header.php"); ?>
<main>
<form>
    <h2>Ajouter Produit</h2>

    <label for="intitule">Intitulé *</label>
    <input type="text" name="intitule" placeholder="Intitulé..." id="intitule" pattern="[A-Za-z._0-9]{2,20}" required/> 
    <label for="categorie">Catégorie *</label>
    <select name="categorie" id="categorie-select" required>
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
    <label for="appelation">Appélation simplifiée *</label>
    <input type="text" name="appelation" placeholder="appélation simplifiee" id="appelation" pattern="[A-Za-z._0-9]{2,20}" required/> 
    <label for="photoProd">Photo du Produit</label>
    <input type="file" name="photo" id="photoProd" accept="image/*"/>
    <label for="appelation">Déscription détaillée *</label>
    <textarea name="description" id="description" rows="5" cols="33" required></textarea>
        <label for="prix">Prix *</label>
    <input type="text" name="prix" placeholder="Prix €" id="prix" pattern="[.0-9]{2,20}" required/> 
    <input class="bouton" type="submit" id="creerProduit" value="Valider le produit"/>
</form>
        
</main>
</body>
</html>