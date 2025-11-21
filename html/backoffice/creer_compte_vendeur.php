<!DOCTYPE html>
<?php 
    if($_GET["erreur"]){
        $erreur = $_GET["erreur"];
    }
    else{
        $erreur = NULL;
    }
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style/creer_compte_vendeur.css" >
    <title>Creer Compte Vendeur</title>
</head>
<body>
    <main>
        <div class="header">
            <img src="../img/logoAlizonBack.svg" alt="Alizon">
            <h1>Back Office</h1>
        </div>
        <form action="creer_compte_vendeur.php" method="post">
            <div class="main">
                <section>
                    <h2>
                        Création de compte
                    </h2>
                    <h3>
                        Profil Responsable
                    </h3>
                    <div class="label">
                        <label>
                            Identifiant* :
                        </label>
                        <?php 
                            if($erreur == "pseudo"){
                                echo "<p style=\"color:red\">Pseudonyme déjà utilisé</p>";
                            }
                        ?>
                        <input type="text" name="identifiant" id="identifiant" pattern="[A-Za-z._0-9]{2,20}" required>
                        <span>L'identifiant doit faire entre 2 et 20 caractères (lettres, ".", "_" acceptés)</span>
                    </div>
                    <div class="alignementdesentrer">
                        <div class="label">
                            <label>
                                Nom* :
                            </label>
                            <input type="text" name="nom" id="nom" required>
                            <span>Le nom doit faire entre 2 et 20 caractères (lettres, ".", "_" acceptés)</span>
                        </div>
                        <div class="label">
                            <label>
                                Prenom* :
                            </label>
                            <input type="text" name="prenom" id="prenom"  class="dimension_petit" required>
                            <span>Le prenom doit faire entre 2 et 20 caractères (lettres, ".", "_" acceptés)</span>
                        </div>
                    </div>
                    <div class="label">
                        <label>
                            Adresse e-mail* :
                        </label>
                        <?php 
                            if($erreur == "mail"){
                                echo "<p>Adresse e-mail déjà utilisée</p>";   
                            }
                        ?>
                        <input type="text" name="email" id="email" pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$" placeholder="Adresse e-mail(ex: nomadresse@gmail.fr)" required>
                        <span>le format est incorrecte ("exemple : a@gmail.fr")</span>
                    </div>
                    <div class="label">
                        <label>
                            Confirmer adresse e-mail* :
                        </label>
                        <input type="text" name="email_conf" id="email_conf"  required>
                        <span>Les deux adresses e-mail doivent être identiques</span>
                    </div>
                    <div class="label">
                        <label>
                            Numéro de téléphone* :
                        </label>
                        <input type="text" name="num_tel" id="num_tel" pattern="[0-9]{10}" placeholder="Numéro de téléphone(ex: 0298525236)" required>
                        <span>Le numero de telephone doit faire 10 numéros</span>
                    </div>
                    <div class="label">
                        <label>
                            Mot de passe* :
                        </label>
                        <input type="password" name="mdp" id="mdp" pattern="[A-Za-z0-9?,.;:§!$£*µù%]{2,20}" required>
                        <span>incorecte : minimum 2 et maximum 20 caractère</span>
                    </div>
                    <div class="label">
                        <label>
                            Confirmer mot de passe* :
                        </label>
                        <input type="password" name="mdp_conf" id="mdp_conf" required>
                        <span>les deux mots de passe doivent être pareil</span>
                    </div>
                </section>
                <hr>
                <section>
                    <h3>
                        Information entreprise
                    </h3>
                    <div class="label">
                        <label>
                            Numéro de SIREN* :
                        </label>
                        <input type="text" name="num_siren" id="num_siren" required>
                        <span>Le numéro siren existe déjà</span>
                    </div>
                    <div class="label">
                        <label>
                            Raison sociale* :
                        </label>
                        <input type="text" name="raison_soc" id="raison_soc" required>
                    </div>
                    <div class="label">
                        <label>
                            Numéro d'adresse* :
                        </label>
                        <input type="text" name="num_adresse1" id="num_adresse1" required>
                    </div>
                    <div class="label">
                        <label>
                            Rue* :
                        </label>
                        <input type="text" name="rue_adresse1" id="rue_adresse1" required>
                    </div>
                    <div class="label">
                        <label>
                            Complément :
                        </label>
                        <input type="text" name="adresse2" id="adresse2">
                    </div>
                    <div class="label">
                        <label>
                            Code postal* :
                        </label>
                        <input type="text" name="code_post" id="code_post" pattern="^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$" required>
                        <span>incorrecte on doit avoir 5 chiffres à la suite</span>
                    </div>
                    <div class="label">
                        <label>
                            Ville* :
                        </label>
                        <input type="text" name="ville" id="ville" required>
                    </div>
                </section>
            </div>
            <div class="boutton">
                <button type="submit" id="valider" >Créer le compte</button>
            </div>
        </form>
    </main>
    <?php include("../includes/backoffice/footer.php"); ?>
        <script>
        
        let mail = document.getElementById("email");
        let confMail = document.getElementById("email_conf");
        let valider = document.getElementById("valider");

        let mdp = document.getElementById("mdp");
        let confMdp = document.getElementById("mdp_conf");
        confMail.addEventListener("focusout", verifConfMail);
        confMdp.addEventListener("focusout", verifFormat);.
        

        function verifFormat(evt){
            if(evt.type == "focusout"){
                if(mail.value != confMail.value){
                    console.log("cc");
                    confMail.classList.add("invalid");
                }
                else{
                    confMail.classList.remove("invalid");
                    confMail.setAttribute("isvalid", false);
                }
                if(mdp.value != confMdp.value){
                    confMdp.classList.add("invalid");
                    onfMail.setAttribute("invalid", true);
                }
                else{
                    confMdp.classList.remove("invalid");
                }
            }
        }
        function verifFormatClic(evt){
            if(confMail.value != mail.value){
                evt.preventDefault();
                confMail.classList.add("invalid");
            }
            if(confMdp.value != mdp.value){
                evt.preventDefault();
                confMdp.classList.add("invalid");
            }
        }
  
    </script>
    <?php
    if($_POST){
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
        $identifiant = $_POST["identifiant"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $email_conf = $_POST["email_conf"];
        $num_tel = $_POST["num_tel"];
        $mdp = $_POST["mdp"];
        $mdp_conf = $_POST["mdp_conf"];
        $num_siren = $_POST["num_siren"];
        $raison_soc = $_POST["raison_soc"];
        $num_adresse1 = $_POST["num_adresse1"];
        $rue_adresse1 = $_POST["rue_adresse1"];
        $adresse2 = $_POST["adresse2"];
        $code_post = $_POST["code_post"];
        $ville = $_POST["ville"];
        
        
            
        //insertion d'une adresse dans la base de données
        $stmt = $pdo->prepare("INSERT INTO alizon.Adresse(num, nomRue, codePostal, nomVille, complementAdresse) VALUES (:num, :nomRue, :codePostal, :nomVille, :complementAdresse)");
        $stmt->execute(array(
            ":num" => $num_adresse1,
            ":nomRue" => $rue_adresse1,
            ":codePostal" => $code_post,
            ":nomVille" => $ville,
            ":complementAdresse" => $adresse2, 
            
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

    ?>

</body>
</html>

