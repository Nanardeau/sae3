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

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php

    if(isset( $_SESSION["codeCompte"])){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
    ?>
    

    <main>
        <div class="grid-main">
        <aside>
            <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
            <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
            <div>
                <h1>Filtres</h1>
                <hr/>
            </div>   
        </aside>
    <div>
        <div class="filtres">
            <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
            <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal"><path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/></svg>
                Filtres
            </button>
        </div>
       <h1>Catalogue</h1>
        
        <div class="separateur"></div>
        <?php
        
        $listArtTmp = $bdd->query('SELECT codeProduit, libelleProd, prixTTC, urlPhoto FROM Produit where Disponible = true');
        $articles = $listArtTmp->fetchAll();
            ?>
        <article>
            <?php    
                foreach ($articles as $article) {
                    //print_r($article);
                    $codeProduit = $article['codeproduit'];
                    $img = $article['urlphoto'];
                    $libArt = $article['libelleprod'];
                    $prix = $article['prixttc'];
                    $prix = round($prix, 2); // Arrondir à 2 chiffre après la virgule 
            ?>

            <div class="card">
                <figure>
                        <a href="./ficheProduit.php?Produit=<?php echo $codeProduit; ?>"><img src="<?php echo $img ?>" /></a>
                    <figcaption><?php echo $libArt ?></figcaption>
                </figure>
                <p class="prix"><?php echo $prix ?> €</p>
                <div>
                    <a class="button" href="modifProduit.php?codeProduit=<?php echo $codeProduit?>">Modifier</a>
                    <a class="button" href="./ficheProduit.php?Produit=<?php echo $codeProduit ?>">Détails</a>
                </div>

            </div>

            <?php
            }
        ?>

        </article>
    </div>
        <?php
            include 'includes/menu_cat.php';
            include 'includes/menuCompte.php';
        ?>
    
        <?php if(isset($_GET["ajout"])):?>
        <div class="ajoutPanierFait">
            <div class="partieGauche" onclick="fermerPopUpPanier()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div class="partieDroite">
                <p>Produit ajouté au panier</p>
                <a href="Panier.php" class="bouton">Aller au panier</a>
            </div>
        </div>
        <?php endif?>
        

        <?php
        
            
        ?>
        </div>
    </main>
    <?php include 'includes/footer.php';?>
    <script>
        function fermerPopUpPanier(){
            window.location.href = "Catalogue.php";
        }
    </script>
</body>

</html>