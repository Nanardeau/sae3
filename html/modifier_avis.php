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


$codeProduit = $_POST['codeProduit'] ?? null;
$commentaire = $_POST['commentaire'] ?? null;
$noteProd     = $_POST['noteProd'] ?? null;
$codeCompteCli = $_SESSION['codeCompte'] ?? null;
$codeavis = $_GET['num'] ?? null;

$sql = "UPDATE Avis 
        SET commentaire = :commentaire, noteProd = :noteProd, codeCompteCli = :cli, codeProduit = :prod, datePublication = null 
        WHERE numAvis = :numAvis";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":commentaire" => $commentaire,
    ":noteProd"    => $noteProd,
    ":cli"         => $codeCompteCli,
    ":prod"        => $codeProduit,
    ":numAvis"     => $codeavis
]);

$sql = "SELECT * FROM JustifierAvis WHERE numAvis = $codeavis";
$photo = $pdo->query($sql)->fetch();
if ($photo==NULL){
    if (!empty($_FILES['photos']['name'][0])) {
        foreach ($_FILES['photos']['name'] as $index => $name) {
            if ($_FILES['photos']['error'][$index] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['photos']['tmp_name'][$index];

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($ext, $allowedExtensions)) {
                    continue; 
                }

                $newName = "avis_" . uniqid() . "." . $ext;
                $destPath = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $destPath)) {
                    $relativePath = "uploads/avis/" . $newName;

                    $stmtPhoto = $pdo->prepare("INSERT INTO Photo (urlPhoto) VALUES (:p) RETURNING urlPhoto");
                    $stmtPhoto->execute([":p" => $relativePath]);
                    $urlPhoto = $stmtPhoto->fetchColumn();

                    $stmtJust = $pdo->prepare("INSERT INTO JustifierAvis (numAvis, urlPhoto) VALUES (:a, :p)");
                    $stmtJust->execute([
                        ":a" => $numAvis,
                        ":p" => $urlPhoto
                    ]);
                }
            }
        }
    }
} else {
    if (!empty($_FILES['photos']['name'][0])) {
        


    }
}




//header("Location: dproduit.php?id=" . urlencode($codeProduit));
//exit();
?>