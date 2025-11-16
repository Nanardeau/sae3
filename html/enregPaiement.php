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
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $bdd = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
if(!array_key_exists("banque", $_GET)){

    $numRue = $_POST["numRue"];
    $nomRue = $_POST["nomRue"];
    $codePostal = $_POST["codePostal"];
    $nomVille = $_POST["ville"];
    $numApt = $_POST["numApt"] ? $_POST["numApt"] : "";
    $complement = $_POST["comp"] ? $_POST["comp"] : ""; 
    $stmt = $bdd->prepare("INSERT INTO alizon.Adresse (num, nomRue, codePostal, nomVille, numAppart, complementAdresse) VALUES (:num, :nomRue, :codePostal, :nomVille, :numAppart, :complementAdresse)");
    $stmt->execute(array(
        ":num" => $numRue,
        ":nomRue" => $nomRue,
        ":codePostal" => $codePostal,
        ":nomVille" => $nomVille,
        ":numAppart" => $numApt,
        ":complementAdresse" => $complement
    ));
    $idAdresse = $bdd->lastInsertId();
    $_SESSION["idAdresse"] = $idAdresse;
    //header("location:paiement.php?adr=1");
}
if(array_key_exists("banque", $_GET)){
    $nom = $_POST["nomTitulaireCB"];
    $numCarte = $_POST["numCB"];
    $expDate = $_POST["expDate"];
    $cvc = $_POST["cvc"];

    $stmt = $bdd->prepare("INSERT INTO alizon.Banque (numCarte, nomTit, cvc, dateExp) VALUES (:numCarte, :nomTit, :cvc, :dateExp)");
    $stmt->execute(array(
        ":numCarte" => $numCarte,
        ":nomTit" => $nom,
        ":cvc" => $cvc,
        ":dateExp" => $expDate
    ));
    #$infosPanier = 
    #$stmt = $bdd->prepare("INSERT INTO alizon.Commande (")
}

?>