<?php
require_once __DIR__ . '/_env.php';

// Charger le fichier .env
loadEnv(__DIR__ . '/.env');

// Récupérer les variables
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');

// Connexion à PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
// try {
    
//     echo "✅ Connecté à PostgreSQL ($dbname)";
// } catch (PDOException $e) {
//     echo "❌ Erreur de connexion : " . $e->getMessage();
// }
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

</body>
</html>