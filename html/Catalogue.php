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


    //Liste des recherches SQL 
    $base= 'SELECT codeProduit, libelleProd, prixTTC, urlPhoto,noteMoy FROM Produit where Disponible = true' ;
    $pxCrois = ' ORDER BY prixTTC';
    $pxDecrois = ' ORDER BY prixTTC DESC';
    $ntCrois= ' ORDER BY noteMoy';
    $ntDecrois= ' ORDER BY noteMoy DESC';
    $note = ' AND noteMoy >= ';
    //TODO faire avec le js, selon ce qui est séléctionner pour le tri, 

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
        
            <aside>
                <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
                <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
                <div>
                    <h1>Tris</h1>
                    <select name="tri" id="tris" required>
                        <option value="" disabled selected>Trier par :</option>
                        <option value="pxCroissant">Prix : ordre croissant</option>
                        <option value="pxDecroissant">Prix : ordre décroissant</option>
                        <option value="ntCroissant">Note : ordre croissant</option>
                        <option value="ntDecroissant">Note : ordre décroissant</option>
                    </select>
                    <hr/>
                    <div class="separateur"></div>
                    <h1>Filtres</h1>
                    <hr/>
                    <h3>Note</h3>
                    <hr/>
                    <div class="noter" id="stars">
                        <span data-value="1">★</span>
                        <span data-value="2">★</span>
                        <span data-value="3">★</span>
                        <span data-value="4">★</span>
                        <span data-value="5">★</span>
                    </div>
                    <span id="note-value" style="display:none;">0</span>
                </div>   
            </aside>
            
            <div>
                <div>
                    <div class="filtres">
                        <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
                        <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal"><path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/></svg>
                            Filtres
                        </button>
                    </div>
                </div>
                <h1>Catalogue</h1>
                <div class="separateur"></div>
                <?php
                    $stmt = $bdd->prepare($sql);
                    $stmt->execute();
                    $articles = $stmt->fetchAll();
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
                    } // Fin foreach
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