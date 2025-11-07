
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
    echo "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
//$bdd->query('set schema \'alizon\'');



if($_POST){
    $id= $_POST["pseudo"];
    $mdp = $_POST["mdp"];
    if($id=!"" && $mdp=!""){
        $req= $bdd->query ("SELECT * FROM Client WHERE pseudo ='$pseudo' AND mdp= '$mdp'");
        $rep= $req->fetch();
        if($rep['id']=!false){
            //connexion
            header("location: accueil.php");
        }else{
            $error_msg="Identifiant ou mot de passe incorrect.";
        }
    }
}else{
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
    <header><a href="accueil.php"><img src="../../img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></a></header>
    <main>
        <form action="ConnexionClient.php" method="post">
            <h2>Connexion</h2>
            <label for="pseudo">Identifiant</label>
            <input type="text" name="pseudo" placeholder="Identifiant..." id="identifiant"/>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" placeholder="Mot de passe..." id="mdpCli"/>
            <?php 
                if($error_msg){
            ?>
                    <p> <?php echo($error_msg); ?> </p>
            <?php
                }
            ?>
            <input class="bouton" type="submit" value="Se connecter"/>
        </form>
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
    <footer></footer>
</body>
</html>

<?php
}
?>