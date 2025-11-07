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


    $mail = $_POST['mail'];
    $confMail = $_POST['confMail'];
    $mdp = $_POST['mdp'];
    $confMdp = $_POST['confMdp'];
    $dateNaissance = $_POST['dateNaiss'];
    if($mail != $confMail){
        header('location:CreerCompte.php?error=mail');
    }
    else if($mdp != $confMdp){
        header('location:CreerCompte.php?error=mdp');
    }
    else if($dateNaissance > date("Y-m-d H:i:s")){
        header('location:CreerCompte.php?error=date');
    }
    else{
        $pseudo = $_POST["pseudo"];
        $nom = strtoupper($_POST["nom"]);
        $prenom = $_POST["prenom"];
        $prenom = strtoupper(substr($prenom, 0, 1)) . substr($prenom, 1, strlen($prenom));
        $numTel = $_POST["numTel"];
        $numRue = $_POST["numRue"] ? $_POST["numRue"] : NULL;

        $nomRue = $_POST["nomRue"] ? $_POST["nomRue"] : NULL;

        $codePostal = $_POST["codePostal"] ? $_POST["codePostal"] : NULL;

        $ville = $_POST["ville"] ? strtoupper(substr($_POST["ville"], 0,1)) . substr($_POST["ville"],1,strlen($_POST["ville"]))  : NULL;

        $numApt = $_POST["numApt"] ? $_POST["numApt"] : NULL;

        $complement = $_POST["comp"] ? $_POST["comp"] : NULL;
        
        $stmt = $bdd->prepare("INSERT INTO alizon.Client(pseudo, dateCreation, nom, prenom, email, mdp, numTel) VALUES (:pseudo, :dateCreation, :nom, :prenom, :email, :mdp, :numTel)");
        $stmt->execute(array(
            ":pseudo" => $pseudo,
            ":dateCreation" => date("Y-m-d H:i:s"),
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":email" => $mail,
            ":mdp" => $mdp,
            ":numTel" => $numtel
        ));
        

        $stmt = $bdd->prepare("INSERT INTO alizon.Adresse(num,codePostal, nomVille, nomRue, complementAdresse, numAppart) VALUES(:num, :codePostal, :nomVille, :nomRue, :complement, :numAppart)");
        $stmt->execute(array(
            ":num" => $numRue,
            ":codePostal" => $codePostal,
            ":nomVille" => $ville,
            ":nomRue" => $nomRue,
            ":complement" => $complement,
            ":numAppart" => $numApt
        ));
            
        //POUR RECUP CODE COMPTE : FAIRE VUE SUR CLIENT ET RECUPERER D'ICI
        $res = ($bdd->query("SELECT codeCompte FROM alizon.Client WHERE pseudo = '".$pseudo."'")->fetch());
        $codeCompte = $res["codecompte"];
        $res = ($bdd->query("SELECT idAdresse FROM alizon.Adresse ORDER BY idAdresse DESC LIMIT 1")->fetch());
        $idAdresse = $res["idadresse"];

        $stmt = $bdd->prepare("INSERT INTO alizon.AdrFactCli(codeCompte, idAdresse) VALUES (:codeCompte, :idAdresse)");
        $stmt->execute(array(
            ":codeCompte" => $codeCompte,
            ":idAdresse" => $idAdresse,
        ));
        print_r($_FILES);
        if($_FILES["photo"]){
            
            $nomPhoto = $_FILES["photo"]["name"];

            move_uploaded_file($_FILES["photo"]["tmp_name"], "./img/photosProfil/".$nomPhoto);
        }

        echo $codeCompte . " " . $idAdresse;
        header('location:Accueil');


    }
