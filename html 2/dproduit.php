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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
            if (!isset($_GET['id'])) {
            die("Aucun produit indiqué");
        }

        $id = (int)$_GET['id']; // sécurisation basique

        // Requête
        $stmt = $pdo->query("SELECT * FROM Produit WHERE id = ?");
        // $stmt->execute([$id]);
        // $produit = $stmt->fetch();

        if (!$produit) {
            die("Produit introuvable");
        }
?>

        <h1><?= htmlspecialchars($produit['nom']) ?></h1>
        <p><?= htmlspecialchars($produit['description']) ?></p>
        <p>Prix : <?= number_format($produit['prix'], 2) ?> €</p>

</body>
</html>