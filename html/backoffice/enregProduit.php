 <?php

session_start();
$code_produit = $_GET["codeproduit"];
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

$nomProd = $_POST["nom"];
$descProd = $_POST["description"];
$catProd = $_POST["categorie"];
$qteProd = $_POST["qteStock"] ? $_POST["qteStock"] : NULL ;
$tvaProd = $_POST["TVA"];
$seuilProd = $_POST["seuil"];
$prixProd = $_POST["prix"];

// TAILLE 
$tailleH = $_POST["tailleHaut"] ? $_POST["tailleHaut"] : NULL;
$tailleLong = $_POST["tailleLong"] ? $_POST["tailleLong"] : NULL;
$tailleLarg = $_POST["tailleLarg"] ? $_POST["tailleLarg"] : NULL;
print_r($_POST);

$info = $bdd->query("SELECT libelleProd FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["libelleProd"];
if ($nomProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET libelleProd = '".$nomProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT descriptionProd FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["descriptionProd"];
if ($descProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET descriptionProd = '".$descProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT libelleCat FROM alizon.Categoriser WHERE codeproduit=$code_produit")->fetch();
$res=$info["libelleCat"];
if ($catProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Categoriser SET libelleCat = '".$catProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT qteStock FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["qteStock"];
if ($qteProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET qteStock = '".$qteProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT nomTVA FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["nomTVA"];
if ($tvaProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET nomTVA = '".$tvaProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}

$info = $bdd->query("SELECT seuilAlerte FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["seuilAlerte"];
if ($seuilProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET seuilAlerte = '".$seuilProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT prixHT FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["prixHT"];
if ($prixProd!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET prixHT = '".$prixProd."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT hauteur FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["hauteur"];
if ($tailleH!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET hauteur = '".$tailleH."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT longueur FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["longueur"];
if ($tailleLong!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET longueur = '".$tailleLong."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}
$info = $bdd->query("SELECT largeur FROM alizon.Produit WHERE codeproduit=$code_produit")->fetch();
$res=$info["largeur"];
if ($tailleLarg!=$res){
    $stmt = $bdd->prepare("UPDATE alizon.Produit SET largeur = '".$tailleLarg."' WHERE codeproduit = '".$code_produit."'");
    $stmt->execute();
}

header('location:modifier_info_produit.php?codeProduit='.$code_produit.'&&erreur=succes');


?>




