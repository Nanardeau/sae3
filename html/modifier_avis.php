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

$commentaire = $_POST['commentaire'];
$noteProduit = $_POST['noteProduit'];
$codeProduit = $_POST['codeProduit'];
$codeAvis = $_POST['codeAvis'];
$urlPhotos = "img/" . $_FILES['contact_upload']['full_path'];

$update = $pdo->prepare("UPDATE Avis SET commentaire = :commentaire, noteprod = :noteProduit WHERE numavis = :codeAvis");
$update->execute([
    ':commentaire' => $commentaire,
    ':noteProduit' => $noteProduit,
    ':codeAvis' => $codeAvis
]);
$avis = $update->fetchAll(PDO::FETCH_ASSOC);


$tmpName = $_FILES['contact_upload']['tmp_name'];
$fileName = $_FILES['contact_upload']['name'];
$folder = __DIR__ . '/uploads/avis/avis_';

$urlPhotos = './uploads/avis/avis_' . $fileName;
if ($tmpName){
    if (!file_exists($urlPhotos)){
        move_uploaded_file($tmpName, $folder . $fileName);
        $insert = $pdo->prepare("INSERT INTO Photo (urlphoto) VALUES (:urlPhotos)");
        $insert->execute([
            ':urlPhotos' => $urlPhotos
        ]);
    }

    $update = $pdo->prepare("UPDATE JustifierAvis SET urlPhoto = :urlPhotos WHERE numAvis = :codeAvis");
    $update->execute([
        ':urlPhotos' => $urlPhotos,
        ':codeAvis' => $codeAvis
    ]);
}

?>

<div>
    <?php
        echo $urlPhotos;


        echo '<br>';
        echo $fileName;

        echo '<br>';

        echo $folder;
        echo '<br>';

        print_r($_POST);
        
        echo '<br>';

        print_r($_FILES);

        echo '<br>';

        echo $_FILES['contact_upload']['full_path'];
        
        echo '<br>';

        print_r($_SESSION);

        print_r($_GET);

        print_r($avis);

        print_r($produit);
?>
</div>
