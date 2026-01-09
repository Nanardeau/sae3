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

$bdd->query('set schema \'alizon\'');

    if(isset($_POST["q"])){
        $recherche = "%" . $_POST["q"] . "%" ; // formatage pour la requette sql
        $nomRecherche = $_POST["q"];
        $stmt = $bdd->prepare("
            SELECT codeproduit,libelleProd,urlphoto,prixttc
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

    if(isset( $_SESSION["codeCompte"])){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
    ?>

<main style="display:block;">
    
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
                        ?>

                        <div class="card">
                            <figure>
                                <a href="dproduit.php?id=<?= $codeProduit ?>"><img src="<?php echo $img ?>" /></a>
                                <figcaption><?php echo $libArt ?></figcaption>
                            </figure>
                            <p class="prix"><?php  echo $prix ?> €</p>
                            <div>
                                <a href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>&page=Catalogue.php"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.37531 4.25298C1.13169 4.5778 1 4.97288 1 5.3789V17.8889C1 18.3865 1.19771 18.8639 1.54963 19.2158C1.90155 19.5677 2.37885 19.7654 2.87654 19.7654H16.0123C16.51 19.7654 16.9873 19.5677 17.3392 19.2158C17.6912 18.8639 17.8889 18.3865 17.8889 17.8889V5.3789C17.8889 4.97288 17.7572 4.5778 17.5135 4.25298L15.637 1.75062C15.4622 1.51756 15.2356 1.3284 14.975 1.19811C14.7144 1.06783 14.4271 1 14.1358 1H4.75308C4.46176 1 4.17443 1.06783 3.91387 1.19811C3.6533 1.3284 3.42664 1.51756 3.25185 1.75062L1.37531 4.25298Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.1971 6.89746C13.1971 7.89284 12.8017 8.84745 12.0978 9.55129C11.394 10.2551 10.4394 10.6505 9.444 10.6505C8.44862 10.6505 7.49401 10.2551 6.79017 9.55129C6.08633 8.84745 5.69092 7.89284 5.69092 6.89746" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1.09668 4.78418H17.7923" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.8272 15.6617H7.43353" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.63037 13.4648V17.8585" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <a class="button" href="OverlayAcheter.php?codeProd=<?php echo $codeProduit?>">Ajouter au panier</a>
                                <a class="button" href="dproduit.php?id=<?= $codeProduit  ?>">Détails</a>
                                        
                            </div>

                        </div>

                <?php
                            
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