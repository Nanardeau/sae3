
<?php
//Connexion à la base de données.
require_once __DIR__ . '/_env.php';
loadEnv(__DIR__ . '/.env');

// Récupération des variables
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');


// Connexion à PostgreSQL

try {
    $ip = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';';
    $bdd = new PDO($ip, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    //echo "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    //echo "❌ Erreur de connexion : " . $e->getMessage();
}
$bdd->query('set schema \'alizon\'');
$error_msg = "";



if($_POST){
    $id = $_POST["pseudo"];
    $mdp = $_POST["mdp"];

    $req= $bdd->query ("SELECT * FROM Client WHERE pseudo = '".$id."' AND mdp = '".$mdp."'");
    $rep= $req->fetch();
    if($rep!=null){
        $blq = $rep["cmtblq"];
        //bon id mais verif si bloqué
        echo $blq;
        if($blq==1){
            $error_msg="Vous avez décidé de bloquer votre compte.";
            $debloq_msg="Pour le débloquer et vous connecter, entrez vos informations et cliquez ici.";

        }else{
            $blqMod=$rep["cmtblqmod"];
            //si compte pas bloqué, vérif si compte bloqué par modo
            if($blqMod==1){
                $error_msg="Votre compte a été bloqué car vous n'avez pas respecté les règles d'utilisation de ce site.";
            }else{
               header("location: accueil.php");
            }
        }
        
    }else{
        $error_msg="Identifiant ou mot de passe incorrect.";
    }
    
}
?> 


<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="./css/style/ConnexionClient.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
</head>
<body>
    <main>
        <a href="accueil.php"><img src="../html/img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></a>
        <form action="ConstanceCo.php" method="post">
            <h2>Connexion</h2>
            <label for="pseudo">Identifiant</label>
            <input type="text" name="pseudo" placeholder="Identifiant..." id="identifiant" required/>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" placeholder="Mot de passe..." id="mdpCli" required/>
            
            <input class="bouton" type="submit" value="Se connecter" id="validerConnexion"/>
        </form>
        <?php
                if($error_msg != ""):
            ?>
                    <p> <?php echo($error_msg); ?><br/>

                    
            <?php
                endif
            ?>
        <aside>
            <figure>
                <img src="./img/line_1.svg"/>
                <p>Pas encore de compte ?</p>
                <img src="./img/line_1.svg"/>
            </figure>
            <nav>
                <a href="CreerCompte.php" class="bouton">Créer un compte</a>
                <a href="Catalogue.php" class="btnJaune">Retour</a>
            <nav>
        </aside>
    
    </main>
    <?php include('./includes/footer.php');
   
    ?>
</body>
</html>

<script>
 function debloquerCompte(){
    window.load("debloquer.php");
    /*
        <?php    
    #            $stmt = $bdd->prepare("UPDATE Client SET cmtBlq = false WHERE pseudo = '".$_POST["pseudo"]."' AND mdp = '".$mdp."'");
    #            $stmt->execute();
    #            
    #            header("location: accueil.php");
           ?> 
    */        //le problème c'est que si un compte bloqué se connecte il est auto. débloqué même sans le vouloir.
        }
</script>