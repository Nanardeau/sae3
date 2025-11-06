<?php
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
        $prenom = strtoupper(substr($prenom, 0, 1)) . substr($prenom, 1, strlen($prenom));
        $numTel = $_POST["numTel"];
        $numRue = $_POST["numRue"] ? $_POST["numRue"] : NULL;

        $nomRue = $_POST["nomRue"] ? $_POST["nomRue"] : NULL;

        $codePostal = $_POST["codePostal"] ? $_POST["codePostal"] : NULL;

        $ville = $_POST["ville"] ? $_POST["ville"] : NULL;

        $numApt = $_POST["numApt"] ? $_POST["numApt"] : NULL;

        $complement = $_POST["comp"] ? $_POST["comp"] : NULL;
        
        $stmt = $bdd->prepare("INSERT INTO Client(pseudo, dateCreation, nom, prenom, email, mdp, numTel) VALUES (?,?,?,?,?,?,?");
        $stmt->bind_params("iiiiiii", $pseudo, $nom, $prenom, $mail, $mdp, $numTel);
        $stmt->execute();

        $stmt = $bdd->prepare("INSERT INTO Adresse(num,codePostal, nomVille, nomRue, complement, numAppart) VALUES (?,?,?,?,?,?)");
        $stmt->bind_params("iiiiii", $numRue, $codePostal, $ville, $nomRue, $complement, $numApt);
        $stmt->execute();
            
        //POUR RECUP CODE COMPTE : FAIRE VUE SUR CLIENT ET RECUPERER D'ICI

    }
