<?php
    session_start();
    require_once __DIR__ . '/env.php';

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

    $codeCompte = $_SESSION["codeCompte"];
    $codeCompte = 1;
    $infosCompte = $bdd->query("SELECT * FROM alizon.Client WHERE codeCompte = '".$codeCompte."'")->fetch();
    print_r($infosCompte);
    $precPseudo = $infosCompte["pseudo"];
    $precNom = $infosCompte["nom"];
    $precPrenom = $infosCompte["prenom"];

    if($_POST["pseudo"]){
        $res = $bdd->query("SELECT * FROM alizon.Client WHERE pseudo = '".$_POST["pseudo"]."'")->fetch();
        if($res == NULL){
            $stmt = $bdd->prepare("UPDATE alizon.Client SET pseudo = ':pseudo'");
            $stmt->execute(array(
                ":identifiant" => $_POST["pseudo"]
            ));

        }
    }