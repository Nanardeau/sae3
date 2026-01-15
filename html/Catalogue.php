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

    $pmin = $_GET['pmin'] ??  null; 
    $pmax = $_GET['pmax'] ?? null; 
    $vendeur = $_GET['vendeur'] ?? null;
    
    $nt = isset($_GET['nt']) ? (int)$_GET['nt'] : null;

    $categorie = $_GET["cat"] ?? $_POST["cat"] ?? null;
    // traitement de catégorie.
    if(isset($categorie)){ 
        $cat = strtoupper(substr($categorie, 0, 1)) . substr($categorie, 1, strlen($categorie));
        $base = "SELECT p.codeProduit, p.libelleProd, p.prixTTC, p.urlPhoto, p.noteMoy
                FROM Produit p
                JOIN Categoriser c ON p.codeProduit = c.codeProduit
                WHERE c.libelleCat = :cat
                AND p.Disponible = true";
    }else {
        $base= 'SELECT codeProduit, libelleProd, prixTTC, urlPhoto,noteMoy FROM Produit where Disponible = true' ;
        $cat = null;
    }
    
    //Liste des recherches SQL 
    $pxCrois = ' ORDER BY prixTTC';
    $pxDecrois = ' ORDER BY prixTTC DESC';
    $ntCrois= ' ORDER BY noteMoy';
    $ntDecrois= ' ORDER BY noteMoy DESC';
    /* pas  à implementer */
    $dtCrois= ' ORDER BY dateModifProduit';
    $dtDecrois= ' ORDER BY dateModifProduit DESC';

    $cVend = ' AND codeCompteVendeur = ';
    $note = ' AND noteMoy >= ';
    $prixMin = ' AND prixTTC > '. $pmin;
    $prixMax = ' AND prixTTC < '. $pmax ;
    if($pmin !==null && $pmax !== null){
        $base = $base.$prixMin.$prixMax;
    }else if($pmin !==null && $pmax === null){
       $base = $base.$prixMin; 
    }else if($pmin ===null && $pmax !== null){
       $base = $base.$prixMax; 
    }
    
    if($nt !== null){
        $base = $base.$note.$nt;
    }
    if($vendeur !== null){
        $base = $base.$cVend.$vendeur;
    }

    //TODO faire avec le js, selon ce qui est séléctionner pour le tri, 
    
    $tri = $_GET["tri"] ?? null;
    switch ($tri){
        case 'pxCrois':
            $sql = $base.$pxCrois;
            break;
        case 'pxDecrois':
            $sql = $base.$pxDecrois;
            break;
        case 'ntCrois':
            $sql = $base.$ntCrois;
            break;
        case 'ntDecrois':
            $sql = $base.$ntDecrois;
            break;
        /*case 'dtCrois':
            $sql = $base.$dtCrois;
            break;
        case 'dtDecrois':
            $sql = $base.$dtDecrois;
            break;
        */
        default:
            $sql = $base;
            break;
    }
    $stmtMax = $bdd->query('SELECT MAX(prixTTC) from produit where disponible = true')->fetch();
    $maxPrix = round($stmtMax['max'] + 1);
    //echo $sql;
    

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
            <aside id="filtresAside">
                <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
                <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
                <div>
                <button class="btn-fermer-filtres" onclick="fermerFiltres()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
                    <?php include('filtretri.php') ;?> 
                </div>
            </aside>
            
            <div>
                
                <div id="ajoutPanierFait">
                    <div class="partieGauche" onclick="fermerPopUpPanier()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                    <div class="partieDroite">
                        <p>Produit ajouté au panier</p>
                        <a href="Panier.php" class="bouton">Aller au panier</a>
                    </div>
                </div>
                
                <div>
                    <div class="filtres">
                        <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
                        <input id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
                        <button onclick="ouvrirFiltres()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal"><path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/></svg>
                            Filtres
                        </button>
                    </div>
                </div>
                <?php if(!$categorie) {  
                    //Vérification si on ne recherche pas seulement une catégorie
                    ?>
                <h1>Catalogue</h1>
                <div class="separateur"></div>
                <?php
                    $stmt = $bdd->prepare($sql);
                    $stmt->execute();
                    $articles = $stmt->fetchAll();
                ?>
                
                <article class="catalogue">
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
                <?php }else { 
                    
                    
                    $stmt = $bdd->prepare($sql);
                        $stmt->execute(array(
                            ":cat"=> $cat
                        ));
                    $prodUnit = $stmt->fetchAll();
                            //print_r($prodUnit) ;
                    
                    ?>
                    <div class="titre-cat">
                        <h2>
                            <?php echo $cat?>
                        </h2>
                        <div class="separateur2"></div>
                    </div>
                    <div class="separateur"></div>
                    <?php if($prodUnit == null){ ?>
                    <article class="catalogue" style="justify-content: center"> 
                    
                            <div class="vide">
                                <h1> Aucun article trouvé </h1>
                                <a href="Catalogue.php">Revenir au catalogue</a>
                            </div>
                   <?php } else{
                    echo "<article class='catalogue'>"; // pour éviter de fermer & réouvrir php
                    $stmt = $bdd->prepare($sql);
                        $stmt->execute(array(
                            ":cat"=> $cat
                        ));
                        $prodUnit = $stmt->fetchAll();
                         //print_r($prodUnit);
                    foreach($prodUnit as $produit){
                        
                        
                        ?>
                        <div class="card">
                            <figure>
                                <a href="dproduit.php?id=<?= $produit["codeproduit"] ?>"><img src="<?php echo $produit["urlphoto"] ?>" /></a>
                                <figcaption><?php echo $produit["libelleprod"] ?></figcaption>
                            </figure>
                            <p class="prix"><?php  echo round($produit["prixttc"],2) ?> €</p>
                            <div>
                                <a href="Panier.php"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.37531 4.25298C1.13169 4.5778 1 4.97288 1 5.3789V17.8889C1 18.3865 1.19771 18.8639 1.54963 19.2158C1.90155 19.5677 2.37885 19.7654 2.87654 19.7654H16.0123C16.51 19.7654 16.9873 19.5677 17.3392 19.2158C17.6912 18.8639 17.8889 18.3865 17.8889 17.8889V5.3789C17.8889 4.97288 17.7572 4.5778 17.5135 4.25298L15.637 1.75062C15.4622 1.51756 15.2356 1.3284 14.975 1.19811C14.7144 1.06783 14.4271 1 14.1358 1H4.75308C4.46176 1 4.17443 1.06783 3.91387 1.19811C3.6533 1.3284 3.42664 1.51756 3.25185 1.75062L1.37531 4.25298Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.1971 6.89746C13.1971 7.89284 12.8017 8.84745 12.0978 9.55129C11.394 10.2551 10.4394 10.6505 9.444 10.6505C8.44862 10.6505 7.49401 10.2551 6.79017 9.55129C6.08633 8.84745 5.69092 7.89284 5.69092 6.89746" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1.09668 4.78418H17.7923" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.8272 15.6617H7.43353" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.63037 13.4648V17.8585" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <a class="button" href="AjouterAuPanier.php?codeProd=<?php echo $produit["codeproduit"]?>&page=Catalogue.php">Ajouter au panier</a>
                                <a class="button" href="dproduit.php?id=<?= $produit["codeproduit"] ?>">Détails</a>
                            </div>
                        </div>
                        <?php    } } ?>
                    </article>
                </div>
        <?php
                }
            include 'includes/menu_cat.php';
            include 'includes/menuCompte.php';
        ?>
    
        
        </div>
    </main>
    <?php include 'includes/footer.php';?>
    <script src="./js/Catalogue.js"></script>
    <script>
        <?php if(isset($_GET["ajout"])):?>
            document.getElementById("ajoutPanierFait").classList.toggle("open");
            console.log("salut");
            setTimeout(function() { fermerPopUpPanier(); }, 5000);
        <?php endif?>

        const form = document.getElementById('filtreForm');
        const etoiles = document.querySelectorAll('#stars span');
        const ntInput = document.getElementById('nt-input');
        const categorie = document.querySelectorAll('.cats');
        const vendeur = document.querySelectorAll('.vend');
        const tris = document.querySelectorAll('.tris');
        
        function fermerPopUpPanier(){
            document.getElementById("ajoutPanierFait").classList.remove("open");
        }
        
        function ouvrirFiltres(){
            document.getElementById("filtresAside").classList.add("mobile-open");
        }
        
        function fermerFiltres(){
            document.getElementById("filtresAside").classList.remove("mobile-open");
        }
        
        categorie.forEach(cat => {
                cat.addEventListener('change', function () {
                    form.submit();
                    fermerFiltres();
                });
            }
        )
        tris.forEach(tri => {
                tri.addEventListener('change', function () {
                    form.submit();
                    fermerFiltres();
                });
            }
        )
        vendeur.forEach(vd => {
                vd.addEventListener('change', function () {
                    form.submit();
                    fermerFiltres();
                });
            }
        )

        const minRange = document.querySelector('.min-range');
        const maxRange = document.querySelector('.max-range');
        minRange.addEventListener("change",function (){
            form.submit();
            fermerFiltres();
        })
        maxRange.addEventListener("change",function (){
            form.submit();
            fermerFiltres();
        });

        etoiles.forEach(star => {
            star.addEventListener("click", function(){
                const valeur = star.dataset.value;
                if (ntInput.value === valeur) {
                    ntInput.value = 0;
                } else {
                    ntInput.value = valeur;
                }
                form.submit();
                fermerFiltres();
            });
        });
                
        
        updateStars(<?php echo $nt ?>);
        
    </script>
</body>

</html>