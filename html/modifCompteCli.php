<?php
    header("location:infosCompte.php");
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
    $_SESSION["codeCompte"] = 1;
    $codeCompte = $_SESSION["codeCompte"];
    $infosCompte = $bdd->query("SELECT * FROM alizon.Client WHERE codeCompte = '".$codeCompte."'")->fetch();

    $infosAdresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.AdrFactCli fact ON adresse.idAdresse = fact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();

    print_r($infosCompte);
    print_r($infosAdresse);

    
    if($_GET["modif"] == "mdp"){
        $stmt = $bdd->prepare("UPDATE alizon.Client SET mdp = '".$_SESSION["nouveauMdp"]."' WHERE codeCompte = '".$_SESSION["codeCompte"]."'");
        $stmt->execute();
        $_SESSION["nouveauMdp"] = "";
    }



    //Faire les modifs sur tous les attributs    
    foreach($_POST as $attribut => $valeur){
        $item = strtolower($attribut);
        //Vérifier si on est sur un attribut de compte
        if(array_key_exists($item, $infosCompte)){

            if($valeur != $infosCompte[$item]){
                //Vérifier qu'un pseudo n'est pas déjà pris
                if($item == "pseudo"){
                    $verifPseudo = $bdd->query("SELECT * FROM alizon.Client WHERE pseudo = '".$valeur."'");
                    if($verifPseudo == NULL){
                        $stmt = $bdd->prepare("UPDATE alizon.Client SET ".$item." = '".$valeur."' WHERE codeCompte = '".$codeCompte."'");
                        $stmt->execute();                        
                    }
                    else{
                        header('location:infosCompte.php?erreur=pseudo');
                    }
                }  
                //Vérifier qu'un mail n'est pas déjà pris
                if($item == "email"){
                    $verifMail = $bdd->query("SELECT * FROM alizon.Client WHERE email = '".$valeur."'");
                    if($verifMail == NULL){
                        $stmt = $bdd->prepare("UPDATE alizon.Client SET ".$item." = '".$valeur."' WHERE codeCompte = '".$codeCompte."'");
                        $stmt->execute();                        
                    }
                    else{
                        header('location:infosCompte.php?erreur=email');
                    }
                }                 
                else{
                    $stmt = $bdd->prepare("UPDATE alizon.Client SET ".$item." = '".$valeur."' WHERE codeCompte = '".$codeCompte."'");
                    $stmt->execute();
                }

            }

        }        //Vérifier si on est sur un attribut d'adresse

        else if(array_key_exists($item, $infosAdresse)){
            if($valeur != $infosAdresse[$item]){
                $stmt = $bdd->prepare("UPDATE alizon.Adresse SET ".$item." = '".$valeur."' WHERE idAdresse = '".$infosAdresse["idadresse"]."'");
                $stmt->execute();
            }

        }
    }

if($_FILES["photo"]){
    $extension = $_FILES["photo"]["type"];
    $extension = substr($extension, strlen("image/"), (strlen($extension) - strlen("image/")));
    $chemin = "./img/photosProfil/".time().".".$extension;


    move_uploaded_file($_FILES["photo"]["tmp_name"], $chemin);


    $stmt = $bdd->prepare("INSERT INTO alizon.Photo (urlPhoto) VALUES (:urlphoto)");
    $stmt->execute(array(
        ":urlphoto" => $chemin
    ));
    $stmt = $bdd->prepare("UPDATE alizon.Profil SET urlPhoto = :urlPhoto WHERE codeClient = :codeCompte");
    $stmt->execute(array(
        ":urlPhoto" => $chemin,
        "codeCompte" => $codeCompte
    ));

    $_SESSION["mdpValide"] = "";
}
 