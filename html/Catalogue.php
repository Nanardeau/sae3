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
    print "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    print "❌ Erreur de connexion : " . $e->getMessage();
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
    <header></header>
    <main>
        <h1>Toutes les catégories</h1>
        <div class="separateur"></div>

        <h2>
            <?php $bdd->query('SELECT libCat FROM SousCat')//Choisir la catégorie  
                        ?>
        </h2>
        <article>
        <?php 
        for($i = 0; $i < 10;$i++){

        ?>
            <div class="card">
                <figure>
                    <img src="./img/img_test.jpg"></img>
                    <figcaption>libelProduit</figcaption>
                </figure>
                <p class="prix">00.00€</p>
                <div>
                    <input type="button" value="Ajouter au panier"></input>
                    <input type="button" value="Détails"></input>
                </div>
                
            </div>
        <?php
            }
        ?>
        </article>


    </main>
    <footer></footer>
</body>

</html>