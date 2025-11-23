<?php
session_start();


require_once __DIR__ . '/_env.php';
loadEnv(__DIR__ . '/.env');

$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');

try {
    $bdd = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

$bdd->query("SET SCHEMA 'alizon'");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée.");
}

$codeProduit = intval($_POST['codeProduit']);
$commentaire = trim($_POST['commentaire']);
$noteProd = floatval($_POST['noteProd']);
$codeCompteCli = intval($_SESSION['codeCompte']);

if ($codeProduit <= 0) die("Produit invalide.");
if ($commentaire === '') die("Commentaire vide.");
if ($noteProd < 0 || $noteProd > 5) $noteProd = 5;

$stmt = $bdd->prepare("SELECT 1 FROM Client WHERE codeCompte = :cc");
$stmt->execute([':cc' => $codeCompteCli]);

if (!$stmt->fetch()) die("Client introuvable.");

$sql = "INSERT INTO Avis (codeProduit, codeCompteCli, noteProd, commentaire, datePublication)
        VALUES (:prod, :cli, :note, :commentaire, NOW())
        RETURNING numAvis";

$stmt = $bdd->prepare($sql);
$stmt->execute([
    ':prod' => $codeProduit,
    ':cli' => $codeCompteCli,
    ':note' => $noteProd,
    ':commentaire' => $commentaire,
]);

$numAvis = $stmt->fetchColumn();


if (!empty($_FILES['photos']) && $_FILES['photos']['error'][0] !== UPLOAD_ERR_NO_FILE) {

    $uploadDir = "uploads/avis/";
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {

        if ($_FILES['photos']['error'][$i] !== UPLOAD_ERR_OK)
            continue;

        $tmpName = $_FILES['photos']['tmp_name'][$i];
        $name = basename($_FILES['photos']['name'][$i]);

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) continue;

        $photoName = uniqid("avis_") . "." . $ext;
        $destination = $uploadDir . $photoName;

        move_uploaded_file($tmpName, $destination);

        $stmtPhoto = $bdd->prepare("INSERT INTO Photo (urlPhoto) VALUES (:url) ON CONFLICT DO NOTHING;");
        $stmtPhoto->execute([':url' => $destination]);

        $stmtLink = $bdd->prepare("INSERT INTO JustifierAvis (urlPhoto, numAvis) VALUES (:url, :avis)");
        $stmtLink->execute([
            ':url' => $destination,
            ':avis' => $numAvis
        ]);
    }
}

header("Location: dproduit.php?id=" . $codeProduit);
exit;
