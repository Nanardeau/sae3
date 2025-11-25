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
    $bdd->query("SET SCHEMA 'alizon'");
    $codeCompte = $_SESSION["codeCompte"];
if(array_key_exists("adresse", $_GET)){
    #Modification de l'adresse
    $_SESSION["adrModif"] = 1;

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

    exit(header("location:paiement.php?adr=1"));
}
if(!isset($_GET["adresse"])){
    if(isset($_SESSION["modifAdr"])){
        if($_SESSION["modifAdr"] == 0){

            #$idAdresseFact = $_SESSION["idAdresse"]/*($bdd->query("SELECT * FROM alizon.AdrFactCli WHERE codeCompte = '".$codeCompte."'")->fetch())["idAdresse"]*/;
            $adresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.adrFactCli adrFact ON adresse.idAdresse = adrFact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();
            $idAdresse = $adresse["idadresse"];
        }
    }

}

if(array_key_exists("banque", $_GET)){
    $nom = $_POST["nomTitulaireCB"];
    $numCarte = $_POST["numCB"];
    $expDate = $_POST["expDate"];
    $cvc = $_POST["cvc"];

    $stmt = $bdd->prepare("INSERT INTO alizon.Carte (numCarte, nomTit, cvc, dateExp) VALUES (:numCarte, :nomTit, :cvc, :dateExp)");
    $stmt->execute(array(
        ":numCarte" => $numCarte,
        ":nomTit" => $nom,
        ":cvc" => $cvc,
        ":dateExp" => $expDate
    ));
    $idCarte = $bdd->lastInsertId();
    $idPanier = ($bdd->query("SELECT idPanier FROM alizon.Panier WHERE codeCompte = '".$codeCompte."'")->fetch())["idpanier"];

    $stmt = $bdd->prepare("INSERT INTO alizon.Commande (dateCom, codeCompte, idCarte) VALUES (:dateCom, :codeCompte, :idCarte)");
    $stmt->execute(array( 
        ":dateCom" => date("Y-m-d H:i:s"),
        ":codeCompte" => $codeCompte,
        ":idCarte" => $idCarte
    ));

    $numCom = $bdd->lastInsertId();
    echo $numCom;
    $prodUnitPan = $bdd->query("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = '".$idPanier."'")->fetchAll();
    foreach($prodUnitPan as $prodUnit){
        $prixTTCProd = $bdd->query("SELECT prixTTC FROM alizon.Produit WHERE codeProduit = '".$prodUnit["codeproduit"]."'")->fetch();

        $stmt = $bdd->prepare("INSERT INTO alizon.ProdUnitCommande (codeProduit, numCom, qteProd) VALUES (:codeProduit, :numCom, :qteProd)");
        $stmt->execute(array(
            ":codeProduit" => $prodUnit["codeproduit"],
            ":numCom" => $numCom,
            ":qteProd" => $prodUnit["qteprod"]
        ));
    }
    $stmt = $bdd->prepare("INSERT INTO alizon.AdrLiv (idAdresse, numCom) VALUES (:idAdresse, :numCom)");
    $stmt->execute(array(
        ":idAdresse" => $_SESSION["idAdresse"],
        ":numCom" => $numCom
    ));
    $stmt = $bdd->prepare("DELETE FROM alizon.Panier WHERE codeCompte = '".$codeCompte."'");
    $stmt->execute();
    unset($_SESSION["idPanier"]);
    exit(header("location:paiementFini.php"));


}


?>