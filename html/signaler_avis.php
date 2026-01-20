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
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

$pdo->query("SET SCHEMA 'alizon'");

$signalement=$_POST['raison'];
$codeAvis = $_GET['codeavis'];
$codeproduit = $_GET['codeproduit'];

echo $signalement;
echo $codeAvis;
echo $codeproduit;

$insert = $pdo->prepare("INSERT INTO Signalement (raison, numavis) VALUES (:signalement, :codeAvis)");
$insert->execute([
    ':signalement' => $signalement,
    ':codeAvis' => $codeAvis
]);
?>