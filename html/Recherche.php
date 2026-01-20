<?php
    session_start(); 
    require_once __DIR__ . '/_env.php';

    loadEnv(__DIR__ . '/.env');

    $host = getenv('PGHOST');
    $port = getenv('PGPORT');
    $dbname = getenv('PGDATABASE');
    $user = getenv('PGUSER');
    $password = getenv('PGPASSWORD');

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $bdd = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
$estClient = false;
if(isset($_SESSION["codeCompte"])){

    $clients = $bdd->query("SELECT ALL codeCompte FROM alizon.Client")->fetchAll();
    foreach($clients as $client){
        if($client["codecompte"] == $_SESSION["codeCompte"]){
            $estClient = true;
        }
    }
}

$bdd->query('set schema \'alizon\'');

    if(isset($_POST["q"])){
        $recherche = "%" . $_POST["q"] . "%" ; // formatage pour la requette sql
        $nomRecherche = $_POST["q"];
        $stmt = $bdd->prepare("
            SELECT codeproduit,libelleProd,urlphoto,prixttc,descriptionProd
            FROM Produit 
            WHERE unaccent(libelleProd) 
            ILIKE unaccent('$recherche')
            AND Disponible = true 
        ");
        $stmt->execute();
        $resRecherche =  $stmt->fetchAll();
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">

    <title><?php echo $nomRecherche?></title>
</head>
<style>

    section{
        display:flex;
        flex-wrap:wrap;
        .card{
            margin-bottom:2em;
        }
    }
</style>
<body>
    <?php

    if(isset( $_SESSION["codeCompte"]) && $estClient){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
    ?>

<main>
    
    <div>
    <?php

    if(isset($resRecherche) && $resRecherche){
            //print_r($resRecherche);
            ?>
            
            <div class="titre-cat">
                <h2>Résultat pour "<?php echo $nomRecherche ?>":</h2>
                <div class="separateur2"></div>
            </div>
            <div class="separateur" style="margin-bottom:1em"></div>
            <article>
                <?php
                    foreach($resRecherche as $article){

                        $codeProduit = $article["codeproduit"];    
                        //print_r($article);
                        $img = $article['urlphoto'];
                        $libArt = $article['libelleprod'];
                        $prix = $article['prixttc'];
                        $prix = round($prix, 2); // Arrondir à 2 chiffre après la virgule 
                        $id = $article['codeproduit'];
                        $p = $article;
                        $desc = $article['descriptionprod'];

                        include 'includes/card.php';
                            
                        } ?>
            </article>
        <?php } 
        else if(isset($resRecherche) && !$resRecherche) { 
            ?>
            <div class="titre-cat">
                <h2>Résultat pour "<?php echo $nomRecherche ?>":</h2>
                <div class="separateur2"></div>
            </div>
            <div class="separateur" style="margin-bottom:1em"></div>
            <div class="vide">
                <h1> Aucun article trouvé </h1>
                <a href="Catalogue.php">Revenir au catalogue</a>
            </div>
       <?php } ?>
      </div>
</main>
<?php include 'includes/footer.php';?>
<script>
    function retour(){
        history.back();
    }
</script>
</body>
</html>