<?php 
    session_start();

    $codeCompte = $_SESSION["codeCompte"];
    
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
    $codeCompte = 1;
    $compte = $bdd->query("SELECT * FROM alizon.Client WHERE codeCompte = '".$codeCompte."'")->fetch();
    
    $adresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.AdrFactCli fact ON adresse.idAdresse = fact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();
    
    $photo = $bdd->query("SELECT profil.urlPhoto  FROM alizon.Photo photo INNER JOIN alizon.Profil profil ON photo.urlPhoto = profil.urlPhoto WHERE profil.codeClient = '".$codeCompte."'")->fetch();
        print_r($photo["urlphoto"]);
        print_r($adresse);
 
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link href="./css/style/infosCompte.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
    <link href="./bootstrap-5.3.8-dist/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>   
    <main>
        <a href="accueil.php"><img src="../../img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></a>

        <form action="modifCompteCli.php" method="post" enctype="multipart/form-data">
            <h2>Mon compte</h2>
            <img src="<?php echo $photo["urlphoto"]?>" alt="photoProfil" title="photoProfil"/>
            <label for="pseudo">Identifiant</label>

            <input type="text" name="pseudo" id="identifiant" pattern="[A-Za-z._]{2,20}" value="<?php echo $compte["pseudo"]?>" required disabled/> 
            <span>L'identifiant doit faire entre 2 et 20 caractères (lettres, ".", "_" acceptés)</span>
            <div id="nomPrenomCli">
                <div class="labelInput">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nomCli" value="<?php echo $compte["nom"] ?>" required disabled/>
                </div>
                <div class="labelInput">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenomCli" value="<?php echo $compte["prenom"]?>" required disabled/>
                </div>
            </div>
            <label for="mail">Adresse e-mail</label>
            <input type="text" name="mail" id="mailCli" value="<?php echo "mail"?>" required disabled/>
            <span>Le mail doit être de la forme "abc@def.gh"</span>
            <span>Les deux adresses e-mail doivent être identiques</span>
            <label for="numTel">Numéro de téléphone</label>
            <input type="text" name="numTel" id="numTelCli" pattern="[0-9]{10}" value="<?php echo $compte["numtel"]?>"disabled/>
            <span>Le numéro doit être dans le format suivant : 0102030405</span>
            <label for="dateNaiss">Date de naissance</label>
            <input type="date" name="dateNaiss" class="boutonSec" id="dateNaiss" onChange="verifDate(event)" value="<?php echo $compte["datenaissance"]?>"required disabled/>
            <span>La date de naissance doit être antérieure à la date du jour</span>
            <?php if($adresse):?>
            <h3>Adresse</h3> <!-- essayer de faire display grid pour adresse !-->
            <div class="container-fluid p-0">
                <div class="row ">                      
                    <div class="col-3 labelInput">
                        <label for="numRue">Numéro</label>
                        <input type="text" name="numRue" id="numRueCli" value="<?php echo $adresse["num"]?>"disabled/>
                    </div>
                    <div class="col-9 labelInput">
                        <label for="nomRue">Nom de la rue, voie</label>
                        <input type="text" name="nomRue" id="nomRueCli" value="<?php echo $adresse["nomrue"]?>"disabled/>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-4 labelInput">
                        <label for="codePostal">Code postal</label>
                        <input type="text" name="codePostal" id="codePostalCli" pattern="^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$" value="<?php echo $adresse["codepostal"]?>" disabled/>
                    </div>
                    <div class="col-8 labelInput">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="villeCli" value="<?php echo $adresse["nomville"]?>" disabled/>
                    </div>
                </div>
            </div>
            <label for="numApp">Numéro d'appartement</label>
            <input type="text" name="numApt" id="numAptCli" value="<?php if($adresse["numappart"]){echo $adresse["numappart"];}else{echo "aucun";}?>" disabled/>
            <label for="comp">Complément</label>
            <input type="text" name="comp" id="compAdrCli" value="<?php if($adresse["complementadresse"]){echo $adresse["complementadresse"];}else{echo "aucun";}?>" disabled/>
            <?php endif?>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdpCli" pattern="[A-Za-z0-9?,.;:§!$£*µù%]{2,20}" required disabled/>
            <span>Le mot de passe doit faire entre 2 et 20 caractères</span>
            <span>Les deux mots de passe doivent être identiques</span>
            <button class="bouton" onClick="modifierInfos">Modifier informations</button>
            <button class="bouton" onClick="bloquerCompte">Bloquer compte</button>
            
        </form>   


    </main>
    <?php include('./includes/footer.php');?>

    <script>

        let formatImage = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/;
        mail.addEventListener("focusout", verifFormat);
        confMail.addEventListener("focusout", verifFormat);
        confMdp.addEventListener("focusout", verifFormat);
        function verifFormat(evt){

            if(evt.type == "focusout"){
                if(formatImage.test(mail.value) == false){
                    mail.classList.add("invalid");
                }
                else{
                    mail.classList.remove("invalid");
                }


            }
        }

        function verifDate(evt){
            let elemDate = document.getElementById("dateNaiss");
            let date = document.getElementById("dateNaiss").value;
            date = Date.parse(date);
            let mtn = Date.now();
            if(date > mtn){
                elemDate.classList.add("invalid");
            }
            else{
                elemDate.classList.remove("invalid");
            }
        }


    </script>
</body>
</html>