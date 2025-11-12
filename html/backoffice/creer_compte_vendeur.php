<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style/creer_compte_vendeur.css" >
    <title>Creer Compte Vendeur</title>
</head>
<body>
    <header>
        <img src="../img/logoAlizonBack.svg" alt="Alizon">
        <h1>Back Office</h1>
    </header>
    <main>
        <form action="creer_compte_vendeur.php" method="post">
        <div class="alignementPR_IE">
            <div>
                
                <h2>
                    Création de compte
                </h2>
                <h3>
                    Profil Responsable
                </h3>
                <h5>
                    Identifiant* :
                </h5>
                <input type="text" name="identifiant" id="identifiant" class="dimension" required>
                <div class="nomPrenom">
                        <div class="labelInput">
                            <h5>
                                Nom* :
                            </h5>
                            
                            <input type="text" name="nom" id="nom"  class="dimension_petit" required>
                        </div>
                        <div class="labelInput">
                            <h5>
                                Prenom* :
                            </h5>
                            <input type="text" name="prenom" id="prenom"  class="dimension_petit" required>
                        </div>
                    </div>
                
                <h5>
                    Adresse e-mail* :
                </h5>
                <input type="text" name="email" id="email" class="dimension" required>
                <h5>
                    Confirmer adresse e-mail* :
                </h5>
                <input type="text" name="email_conf" id="email_conf" class="dimension" required>
                <h5>
                    Numéro de téléphone* :
                </h5>
                <input type="text" name="num_tel" id="num_tel" class="dimension_petit" required>
                <h5>
                    mot de passe* :
                </h5>
                <input type="password" name="mdp" id="mdp" class="dimension" required>
                <h5>
                    Confirmer mot de passe* :
                </h5>
                <input type="password" name="mdp_conf" id="mdp_conf" class="dimension" required>
            </div>
            <hr>
            <div>
                <h3>
                    Information entreprise
                </h3>
                <h5>
                    Numéro de SIREN* :
                </h5>
                <input type="text" name="num_siren" id="num_siren" class="dimension" required>
                <h5>
                    Raison sociale* :
                </h5>
                <input type="text" name="raison_soc" id="raison_soc" class="dimension" required>
                <h5>
                    ligne d'adresse 1* :
                </h5>
                <input type="text" name="num_adresse1" id="num_adresse1" placeholder="Numéro de l'adresse" class="num_adresse" required>
                <input type="text"name="rue_adresse1" id="rue_adresse1" placeholder="Rue" class="rue_adresse" required>
                <h5>
                    ligne d'adresse 2 :
                </h5>
                <input type="text" name="adresse2" id="adresse2" placeholder="Apt, suite, unité, nom de l’entreprise (facultatif)" class="dimension">
                <h5>
                    Code postal* :
                </h5>
                <input type="text" name="code_post" id="code_post" required>
                <h5>
                    Ville* :
                </h5>
                <input type="text" name="ville" id="ville" class="dimension" required>
                
                
                
            </div>
        </div>
        <div class="button">
            <button type="submit" >Créer le compte</button>
        </div>
        
        
        </form>
    </main>
    
    <?php
        require_once('../env.php');
        
        
        // Charger le fichier .env
        loadEnv('../.env');

        // Récupérer les variables
        $host = getenv('PGHOST');
        $port = getenv('PGPORT');
        $dbname = getenv('PGDATABASE');
        $user = getenv('PGUSER');
        $password = getenv('PGPASSWORD');

        // Connexion à PostgreSQL
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
            $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
            echo "✅ Connecté à PostgreSQL ($dbname)";
        } catch (PDOException $e) {
            echo "❌ Erreur de connexion : " . $e->getMessage();
        }
        
        //initialisation des variables
        $identifiant= $_POST["identifiant"];
        $nom= $_POST["nom"];
        $prenom= $_POST["prenom"];
        $email= $_POST["email"];
        $email_conf= $_POST["email_conf"];
        $num_tel= $_POST["num_tel"];
        $mdp= $_POST["mdp"];
        $mdp_conf= $_POST["mdp_conf"];
        $num_siren= $_POST["num_siren"];
        $raison_soc= $_POST["raison_soc"];
        $num_adresse1= $_POST["num_adresse1"];
        $rue_adresse1= $_POST["rue_adresse1"];
        $adresse2= $_POST["adresse2"];
        $code_post= $_POST["code_post"];
        $ville= $_POST["ville"];
        
        if ($mdp==$mdp_conf && $email==$email_conf){
            
            //insertion d'une adresse dans la base de données
            $stmt = $pdo->prepare("INSERT INTO alizon.Adresse(num, nomRue, codePostal, nomVille) VALUES (:num, :nomRue, :codePostal, :nomVille)");
            $stmt->execute(array(
                ":num" => $num_adresse1,
                ":nomRue" => $rue_adresse1,
                ":codePostal" => $code_post,
                ":nomVille" => $ville,
                ":complement" => $adresse2, 
                ":numAppart" => $adresse2 //A revoir
            ));

            //Prise de l'id de l'adresse créée
            $res = $pdo->query("SELECT idAdresse FROM alizon.Adresse ORDER BY idAdresse DESC LIMIT 1")->fetch();
            $idAdresse = $res["idAdresse"];

            //insertion d'un vendeur dans la base de données
            $stmt = $pdo->prepare('INSERT INTO alizon.Vendeur(nom, prenom, numTel, SIREN, email, identifiant, raisonSociale, idAdresseSiege, mdp) VALUES (:nom, :prenom, :numtel, :siren, :mail, :id, :raisonsoc, :idAdresseSiege, :mdp)');
            $stmt->execute(array(
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":numtel" => $num_tel,
                ":siren" => $num_siren,
                ":id" => $identifiant,
                ":raisonsoc" => $raison_soc,
                ":idAdresseSiege" => $idAdresse, //insertion de l'id associé au vendeur
                ":mail" => $email,
                ":mdp" => $mdp
            ));
        }
        else {

            echo "<p>le mot de passe ou l'email n'est pas le même dans la confirmation</p>";
        }
        
    ?>
</body>
</html>