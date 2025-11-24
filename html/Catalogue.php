<?php
session_start();

//Connexion à la base de données.
require_once( __DIR__ . '/_env.php');
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
$bdd->query('set schema \'alizon\'');
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php 

    if(isset($_SESSION['codeCompte'])){
        include 'includes/headerCon.php' ;
        $codeCompte = $_SESSION['codeCompte'];
    }else{
        include 'includes/header.php';
        include 'includes/menu_cat.php';
    }
    ?>

    <main>
        <div class="ajoutPanierFait">
            <div class="partieGauche" onclick="fermerPopUpPanier()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div class="partieDroite">
                <p>Produit ajouté au panier</p>
                <a href="Panier.php" class="bouton">Aller au panier</a>
            </div>
        </div>

        <h1>Toutes les catégories</h1>


        <?php
        
        $catCurr = null;
        $ArtDispo = $bdd->query('SELECT codeProduit FROM Produit where Disponible = true');
        //print_r($infoArt->fetchAll());
        
         
        $listCat = $bdd->query("SELECT DISTINCT libCat FROM SousCat ORDER BY libCat"); //Nom de la catégorie
 
        foreach($listCat as $lib){
            $catCurr = $lib['libcat'];
            $stmt = $bdd->prepare("SELECT p.codeProduit, p.libelleProd, p.prixTTC, p.urlPhoto
                                FROM Produit p
                                INNER JOIN Categoriser c ON p.codeProduit = c.codeProduit
                                WHERE p.disponible = TRUE
                                AND c.libelleCat = :categorie"
                                );
            $stmt->execute(['categorie' => $catCurr]);
            $articles = $stmt->fetchAll();
            $catCurr = $lib['libcat'];
            //print_r($articles);
        
            if($articles != null){
                
        ?>
            <div class="separateur"></div>
            <div class="titre-cat">
                <h2>
                    <?php echo $catCurr; ?>
                </h2>
                <div class="separateur2"></div>
            </div>
            <?php
            
            ?><article><?php
                        foreach($articles as $article){

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
                                <a href="Panier.php"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.37531 4.25298C1.13169 4.5778 1 4.97288 1 5.3789V17.8889C1 18.3865 1.19771 18.8639 1.54963 19.2158C1.90155 19.5677 2.37885 19.7654 2.87654 19.7654H16.0123C16.51 19.7654 16.9873 19.5677 17.3392 19.2158C17.6912 18.8639 17.8889 18.3865 17.8889 17.8889V5.3789C17.8889 4.97288 17.7572 4.5778 17.5135 4.25298L15.637 1.75062C15.4622 1.51756 15.2356 1.3284 14.975 1.19811C14.7144 1.06783 14.4271 1 14.1358 1H4.75308C4.46176 1 4.17443 1.06783 3.91387 1.19811C3.6533 1.3284 3.42664 1.51756 3.25185 1.75062L1.37531 4.25298Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.1971 6.89746C13.1971 7.89284 12.8017 8.84745 12.0978 9.55129C11.394 10.2551 10.4394 10.6505 9.444 10.6505C8.44862 10.6505 7.49401 10.2551 6.79017 9.55129C6.08633 8.84745 5.69092 7.89284 5.69092 6.89746" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1.09668 4.78418H17.7923" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.8272 15.6617H7.43353" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.63037 13.4648V17.8585" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <a class="button" popovertarget="overlayAchat">Ajouter au panier</a>
                                <a class="button" href="dproduit.php?id=<?= $codeProduit  ?>">Détails</a>
                            </div>

                        </div>

                <?php
                            
                        } ?>
            </article>
        <?php
            } 
           }
        ?>

        <div popover="auto" id="overlayAchat">
            <h4>Ajouter au panier</h4>
            <figure>
                <a href="dproduit.php?id=<?= $codeProduit ?>"><img src="<?php echo $img ?>" /></a>
                <figcaption><?php echo $libArt ?></figcaption>
            </figure>
            <p>Souhaitez vous ajouter ce produit au panier ou l'acheter instantanément?</p>
            <button>Acheter</button>
            <a class="button" href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>&page=Catalogue.php">Ajouter au panier</a>
        </div>




    </main>
    <?php include 'includes/footer.php';?>
    <script>
        function fermerPopUpPanier(){
            window.location.href = "index.php";
        }
    </script>
</body>

</html>