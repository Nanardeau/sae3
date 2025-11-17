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



$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Produit introuvable.");

$produit = $bdd->query("SELECT * FROM Produit WHERE codeProduit = $id")->fetch(PDO::FETCH_ASSOC);
if (!$produit) die("Produit introuvable !");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>
    <link rel="stylesheet" href="css/style/dproduit.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <div class="detail-produit">
            <div class="detail-produit-content">
                <?php if (!empty($produit['urlphoto'])): ?>
                    <img src="<?= $produit['urlphoto'] ?>" alt="Image du produit">
                <?php endif; ?>
                <div class="info-produit">
                    <h1><?= $produit['libelleprod'] ?></h1>
                    <p><strong>Description :</strong> <?= $produit['descriptionprod'] ?></p>
                    <p class="prix"><?= round($produit['prixttc'], 2) ?> €</p>
                </div>
                    
            </div>
        </div>
        <div class="partie-droite">

            <div class="panier-section">
                <p class="price"><?= round($produit['prixttc'], 2) ?> €</p>

                <div class="quantity">
                    <label for="qte">Quantité :</label>
                </div>

                <button class="add-to-cart">Ajouter au panier</button>
            </div>

            <form class="avis-section" method="POST" action="ajout_avis.php">

                <h2>Votre avis</h2>

                <div class="noter">
                    <span>★</span>
                    <span>★</span>
                    <span>★</span>
                    <span>★</span>
                    <span>★</span>
                </div>

                <span id="note-value" style="display:none;">0</span>

                <textarea name="commentaire" placeholder="Rédiger un commentaire..."></textarea>

                <div class="buttons">
                    <button type="reset" class="cancel">Annuler</button>
                    <button type="submit" class="submit">Publier</button>
                </div>

            </form>

        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
