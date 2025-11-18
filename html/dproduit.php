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

$_SESSION["codeCompte"] = 1; //ligne temporaire, en attendant d"avoir le système de connexion 



$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Produit introuvable.");

$produit = $bdd->query("SELECT * FROM Produit WHERE codeProduit = $id")->fetch(PDO::FETCH_ASSOC);
if (!$produit) die("Produit introuvable !");


// --- RÉCUPÉRATION DES AVIS DU PRODUIT --- //
$sqlAvis = "SELECT A.*, C.prenom, C.nom 
            FROM Avis A
            LEFT JOIN Client C ON C.codeCompte = A.codeCompteCli
            WHERE A.codeProduit = :id
            ORDER BY A.datePublication DESC";

$stmtAvis = $bdd->prepare($sqlAvis);
$stmtAvis->execute(['id' => $id]);
$avisList = $stmtAvis->fetchAll(PDO::FETCH_ASSOC);
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
        <section class="prod">
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
                    
                    <p class="price" id="price" data-price="<?= round($produit['prixttc'], 2) ?>"><?= round($produit['prixttc'], 2) ?> €</p>
                    <div class="quantity">
                        <label for="qte">Quantité :</label>
                        <select id="qte" name="qte">
                            <?php for ($i = 1; $i <= 100; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <a class="add-to-cart" href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>">Ajouter au panier</a>
                    <!--<button class="add-to-cart">Ajouter au panier</button>-->
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

                    <textarea name="commentaire" maxlength="255" placeholder="Rédiger un commentaire..." required></textarea>

                    <div class="buttons">
                        <button type="reset" class="cancel">Annuler</button>
                        <button type="submit" class="submit">Publier</button>
                    </div>
                    <input type="hidden" name="codeProduit" value="<?= $produit['codeproduit'] ?>">
                    <input type="hidden" name="noteProd" value="4">


                </form>

            </div>
        </section>
        <section class="avis-produits">
            <h1>Les avis</h1>

            <div class="liste-avis">
                <?php if (empty($avisList)): ?>
                    <p>Aucun avis pour ce produit.</p>
                <?php else: ?>
                    <?php foreach ($avisList as $avis): ?>
                        <div class="avis">
                            <div class="avis-header">
                                <strong>
                                    <?= htmlspecialchars($avis['prenom'] . " " . strtoupper($avis['nom'])) ?>
                                </strong>
                                <!-- <span class="note">
                                    <?= str_repeat("★", (int)$avis['noteprod']) ?>
                                    <?= str_repeat("☆", 5 - (int)$avis['noteprod']) ?>
                                </span> -->
                                <span class="date">
                                    <?= date("d/m/Y", strtotime($avis['datepublication'])) ?>
                                </span>
                            </div>

                            <p class="commentaire">
                                <?= htmlspecialchars($avis['commentaire']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
