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
if (!isset($_SESSION["codeCompte"])) {
    $_SESSION["codeCompte"] = 1; 
}



$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Produit introuvable.");

$produit = $bdd->query("SELECT * FROM Produit WHERE codeProduit = $id")->fetch(PDO::FETCH_ASSOC);
if (!$produit) die("Produit introuvable !");


// --- RÉCUPÉRATION DES AVIS DU PRODUIT --- //
$sqlAvis = "SELECT A.*, C.prenom, C.nom,
        ARRAY(
            SELECT J.urlPhoto
            FROM JustifierAvis J
            WHERE J.numAvis = A.numAvis
        ) AS photos
    FROM Avis A
    LEFT JOIN Client C ON C.codeCompte = A.codeCompteCli
    WHERE A.codeProduit = :id
    ORDER BY A.datePublication DESC
";


$stmtAvis = $bdd->prepare($sqlAvis);
$stmtAvis->execute(['id' => $id]);
$avisList = $stmtAvis->fetchAll(PDO::FETCH_ASSOC);

foreach ($avisList as &$avis) {

    if (is_string($avis["photos"]) && $avis["photos"] !== "{}") {

        $str = trim($avis["photos"], "{}");

        $parts = array_map('trim', explode(',', $str));

        $photos = [];

        foreach ($parts as $p) {
            $p = trim($p, '"');

            if (strtoupper($p) !== "NULL" && $p !== "") {
                $photos[] = $p;
            }
        }

        $avis["photos"] = $photos;

    } else {
        $avis["photos"] = [];
    }
}
unset($avis);





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
    <?php include 'includes/menu_cat.php';?>

    <main>
        <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
        <INPUT id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();">
        
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
                                <option value="1000000">1000000</option>
                        </select>
                    </div>
                    <a class="add-to-cart" href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>">Ajouter au panier</a>
                    <!--<button class="add-to-cart">Ajouter au panier</button>-->
                </div>
                

                <form class="avis-section" method="POST" action="ajout_avis.php" enctype="multipart/form-data">

                    <h2>Votre avis</h2>

                    <div class="noter" id="stars">
                        <span data-value="1">★</span>
                        <span data-value="2">★</span>
                        <span data-value="3">★</span>
                        <span data-value="4">★</span>
                        <span data-value="5">★</span>
                    </div>

                    <span id="note-value" style="display:none;">0</span>

                    <textarea name="commentaire" maxlength="255" placeholder="Rédiger un commentaire..." required></textarea>

                    

                    <div class="plein-buttons">
                        <label class="photo" for="photos">Ajouter des photos</label>
                        <input id="photos" type="file" name="photos[]" multiple accept="image/*">
                        <button type="reset" class="cancel">Annuler</button>
                        <button type="submit" class="submit">Publier</button>
                    </div>

                    <input type="hidden" name="codeProduit" value="<?= $produit['codeproduit'] ?>">
                    <input type="hidden" name="noteProd" id="noteProd" value="0">

                </form>


            </div>
        </section>
        <section class="evaluation-produit">
            <h1>Évaluation du produit</h1>
            <div class="evaluation">
                <?php
                $totalAvis = count($avisList);
                $sommeNotes = 0;
                $noteCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]; 

                foreach ($avisList as $avis) {
                    $note = (int)$avis['noteprod'];
                    $sommeNotes += $note;
                    $noteCounts[$note]++;
                }

                $moyenneNote = $totalAvis > 0 ? round($sommeNotes / $totalAvis, 2) : 0;
                ?>

                <div class="eval-moy">
                    <div class="score-moyen">
                        <span class="score"><?= $moyenneNote ?></span>/5
                    </div>
                    <div class="etoiles">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="etoile <?= $i <= round($moyenneNote) ? 'pleine' : '' ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <div class="total">
                        (<?= $totalAvis ?> avis)
                    </div>
                </div>

                <div class="repartition-notes">
                    <?php foreach ($noteCounts as $note => $count): ?>
                        <div class="note-bar">
                            <span class="note-label"><?= $note ?>★</span>
                            <div class="progression-note">
                                <div class="barre-progression" style="width: <?= $totalAvis > 0 ? ($count / $totalAvis) * 100 : 0 ?>%"></div>
                            </div>
                            <span class="nbr-note"><?= $count ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

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
                                    <?php
                                    $prenom = htmlspecialchars($avis['prenom'] ?? 'Anonyme');
                                    $nom = strtoupper(htmlspecialchars($avis['nom'] ?? 'Utilisateur'));
                                    echo "$prenom $nom";
                                    ?>
                                </strong>
                                <!-- <strong>
                                    <?php
                                    $prenom = htmlspecialchars($avis['prenom']);
                                    $nom = strtoupper(htmlspecialchars($avis['nom']));
                                    echo "$prenom $nom";
                                    ?>

                                </strong> -->
                                <span class="date">
                                    <?= date("d/m/Y", strtotime($avis['datepublication'])) ?>
                                </span>
                            </div>
                            <span class="note">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= (int)$avis['noteprod'] ? 'full' : '' ?>">★</span>
                                <?php endfor; ?>
                            </span>

                            <p class="commentaire">
                                <?= htmlspecialchars($avis['commentaire']) ?>
                            </p>
                            <?php if (!empty($avis['photos'])): ?>
                                <div id="overlay-photos-avis" class="photos-avis">
                                    <?php foreach ($avis['photos'] as $photo): ?>
                                        <img src="<?= htmlspecialchars($photo) ?>" 
                                            alt="Photo de l'avis" 
                                            class="photo-avis">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
