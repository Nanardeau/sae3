<?php

    if(!$_GET){
        header('location:infosCompte.php');

    }

    
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
    $mdpBase = ($bdd->query("SELECT mdp FROM alizon.Client WHERE codeCompte = '".$codeCompte."'")->fetch())["mdp"];

    if($mdpBase == $_POST["mdpPourValider"]){
        $_SESSION["mdpValide"] = 1;
        if($_GET["modifMdp"] == 1){
            $_SESSION["nouveauMdp"] = $_POST["mdpModifCli"];
            header('location:modifCompteCli.php?modif=mdp');
            exit();
        }
    }
    else{
        $_SESSION["mdpValide"] = 0;
        if($_GET["modifMdp"] == 1){
            header('location:infosCompte.php');
        }        
        
    }
print_r($_SESSION);