<?php
//Connexion à la base de données.
require_once __DIR__ . '/_env.php';
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
    <link rel="stylesheet" href="css/style/accueil.css">
</head>
<body>
    <?php
        include 'includes/header.php';
    ?>
    <main>
        <nav class="nav-cat tab-only">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="openOverlay()">
                    <path d="M1.5 1.5H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 10.7993H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 20.0986H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            <?php
                $catCurr = null;
                $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  

                foreach ($listCat as $libcat) {

                    $catCurr = $libcat['libcat'];
                ?>

                <a href="#"><?php echo $catCurr;?></a>
                <?php
                }
                ?>
        </nav>
        <div id="overlayMenuCat" class="overlayMenuCat tab-only">
            <div class="overlayContentCat">
                <ul>
                    <?php
                    $catCurr = null;
                    $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  

                    foreach ($listCat as $libcat) {

                        $catCurr = $libcat['libcat'];
                    ?>

                    <li><a href="#"><?php echo $catCurr;?></a></li>
                    <?php

                    $listSousCats = $bdd->query("SELECT DISTINCT libSousCat FROM SousCat WHERE libCat = '" . $catCurr . "'");

                    // Vérifier s'il y a des sous-catégories
                    if ($listSousCats->rowCount() > 0) {
                        echo "<ul>";
                        foreach ($listSousCats as $libSousCat) {
                            $sousCatCurr = $libSousCat['libsouscat'];
                            echo "<li><a href='#'>" . $sousCatCurr . "</a></li>";
                        }
                        echo "</ul>";
                    }

                    echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <section class="anonnces_produits">
            <div class="annonce_produit">
                <img src="" alt="Image voir les nou²veautés">
                <a class="boutton" href="">Voir les nouveautés</a>
            </div>
            <div class="annonce_produit">
                <img src="" alt="Image voir les articles en vedettes">
                <a class="boutton" href="">Voir les articles en vedettes</a>
            </div>
            <div class="annonce_produit annonce_produit_large">
                <img src="" alt="Image voir les evenement en cours">
                <a class="boutton" href="">Evenement en cours</a>
            </div>
            
        </section>
    
        <section id="Promotion" class="aff_prod">
            <div class="separateur"></div>
            <h1>Promotions</h1>
            <div class="separateur"></div>
        </section>
        <section id="Nouveautes" class="aff_prod">
            <h1>Nouveautés</h1>
        </section>
    </main>
    <?php
        include 'includes/footer.php';
    ?>
    <script src="script/script.js"></script>
</body>
</html>