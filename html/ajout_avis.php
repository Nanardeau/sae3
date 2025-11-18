<?php
session_start();

// --- TEMPORAIRE : SIMULE UN UTILISATEUR CONNECTÉ --- //
if (!isset($_SESSION['codeCompte'])) {
    $_SESSION['codeCompte'] = 1;  // un id client qui doit exister en base
}

require_once __DIR__ . '/_env.php';
loadEnv(__DIR__ . '/.env');

// Connexion
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

// Méthode POST requise
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée.");
}

// Récupération et sécurisation des champs
$codeProduit = isset($_POST['codeProduit']) ? intval($_POST['codeProduit']) : 0;
$commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';
$noteProd = isset($_POST['noteProd']) ? floatval($_POST['noteProd']) : 5;

// Vérifier session utilisateur
if (!isset($_SESSION['codeCompte'])) {
    // Option A : bloquer l'insertion (recommandé)
    //die("Vous devez être connecté pour poster un avis.");
    if (!isset($_SESSION['codeCompte'])) {
        $_SESSION['codeCompte'] = 1; // DEV MODE
    }


    // Option B (dev seulement) : définir un utilisateur de test
    // $_SESSION['codeCompte'] = 3;
}

// Récupérer le code du compte connecté
$codeCompteCli = intval($_SESSION['codeCompte']);

// Validation simple
if ($codeProduit <= 0) {
    die("Produit invalide.");
}
if ($commentaire === '') {
    die("Commentaire vide.");
}
if ($noteProd < 0 || $noteProd > 5) {
    $noteProd = 5;
}

// Vérifier que le client existe (évite la violation FK)
$stmt = $bdd->prepare("SELECT 1 FROM Client WHERE codeCompte = :cc LIMIT 1");
$stmt->execute([':cc' => $codeCompteCli]);
if ($stmt->fetchColumn() === false) {
    die("Client introuvable en base (codeCompte = $codeCompteCli).");
}

// Insertion
$sql = "INSERT INTO Avis (codeProduit, codeCompteCli, noteProd, commentaire, datePublication)
        VALUES (:prod, :cli, :note, :commentaire, :date)";
$stmt = $bdd->prepare($sql);

try {
    $stmt->execute([
        ':prod' => $codeProduit,
        ':cli' => $codeCompteCli,
        ':note' => $noteProd,
        ':commentaire' => $commentaire,
        ':date' => date('Y-m-d'),
    ]);
} catch (PDOException $e) {
    die("Erreur insertion : " . $e->getMessage());
}

// Redirection vers la fiche produit
header("Location: dproduit.php?id=" . $codeProduit);
exit;
