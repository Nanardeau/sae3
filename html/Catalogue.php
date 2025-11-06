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
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">
</head>

<body>
    
    <main>
        <h1>Toutes les catégories</h1>


        <?php
        $catCurr = null;
        $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  
        foreach ($listCat as $libcat) {

            $catCurr = $libcat['libcat'];
        ?>
            <div class="separateur"></div>
            <h2>
                <?php echo $catCurr; ?>
            </h2>
            <?php
            $listArt = $bdd->query('SELECT codeProduit FROM Categoriser where libelleCat =\'' . $catCurr . '\'');
            ?><article><?php
            foreach ($listArt as $article) {

                $infoArt = $bdd->query('SELECT DISTINCT libelleProd, prixTTC, urlPhoto FROM Produit where codeProduit =\'' . $article['codeproduit'] . '\'');

                foreach ($infoArt as $article) {
                    //print_r($article);
                    $img = $article['urlphoto'];
                    $libArt = $article['libelleprod'];
                    $prix = $article['prixttc'];
                    $prix = round($prix,2); // Arrondir à 2 chiffre après la virgule 
            ?>
                    
                        <div class="card">
                            <figure>
                                <img src="<?php echo $img ?>" />
                                <figcaption><?php echo $libArt ?></figcaption>
                            </figure>
                            <p class="prix"><?php echo $prix ?> €</p>
                            <div>
                                <input type="button" value="Ajouter au panier"></input>
                                <input type="button" value="Détails"></input>
                            </div>

                        </div>
                    
            <?php
                }
            } ?>
            </article>
        <?php
        } ?>






    </main>
    
</body>

</html>