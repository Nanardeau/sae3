
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
    // "✅ Connecté à PostgreSQL ($dbname)";
} catch (PDOException $e) {
    // "❌ Erreur de connexion : " . $e->getMessage();
}
$bdd->query('set schema \'alizon\'');



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

}
?> 
