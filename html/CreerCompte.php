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
    <title>Créer compte</title>
    <link href="./css/style/creerCompteFront.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
    <link href="./bootstrap-5.3.8-dist/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>   
    <main>
        <a href="accueil.php"><img src="../../img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></a>

        <form action="enreg.php" method="post" enctype="multipart/form-data">
            <h2>Création de compte</h2>
            <label for="pseudo">Identifiant *</label>
            <?php 
            if($erreur == "pseudo"){
                echo "<p style=\"color:red\">Pseudonyme déjà utilisé</p>";
            }
            ?>
            <input type="text" name="pseudo" placeholder="Identifiant..." id="identifiant" pattern="[A-Za-z._0-9]{2,20}" required/> 
            <span>L'identifiant doit faire entre 2 et 20 caractères (lettres, ".", "_" acceptés)</span>
            <div id="nomPrenomCli">
                <div class="labelInput">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" placeholder="Nom..." id="nomCli" required/>
                </div>
                <div class="labelInput">
                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" placeholder="Prénom..." id="prenomCli" required/>
                </div>
            </div>
            <label for="pdp">Photo de profil</label>
            <input type="file" name="photo" id="photoCli" accept="image/*"/>
            <label for="mail">Adresse e-mail *</label>
            <?php if($erreur == "mail"){
                echo "<p>Adresse e-mail déjà utilisée</p>";   
            }?>
            <input type="text" name="mail" placeholder="E-mail..." id="mailCli" required/>
            <span>Le mail doit être de la forme "abc@def.gh"</span>
            <label for="confMail">Confirmer adresse mail *</label>
            <input type="text" name="confMail" id="confMailCli"/>
            <span>Les deux adresses e-mail doivent être identiques</span>
            <label for="numTel">Numéro de téléphone</label>
            <input type="text" name="numTel" id="numTelCli" pattern="[0-9]{10}"/>
            <span>Le numéro doit être dans le format suivant : 0102030405</span>
            <label for="dateNaiss">Date de naissance *</label>
            <input type="date" name="dateNaiss" class="boutonSec" id="dateNaiss" onChange="verifDate(event)" required/>
            <span>La date de naissance doit être antérieure à la date du jour</span>
            <h3>Adresse</h3> <!-- essayer de faire display grid pour adresse !-->
            <div class="container-fluid p-0">
                <div class="row ">
                    <div class="col-3 labelInput">
                        <label for="numRue">Numéro</label>
                        <input type="text" name="numRue" placeholder="1, 2A, 3Bis etc." id="numRueCli"/>
                    </div>
                    <div class="col-9 labelInput">
                        <label for="nomRue">Nom de la rue, voie</label>
                        <input type="text" name="nomRue" placeholder="Ex : Rue des lilas" id="nomRueCli"/>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-4 labelInput">
                        <label for="codePostal">Code postal</label>
                        <input type="text" name="codePostal" id="codePostalCli" pattern="^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$"/>
                    </div>
                    <div class="col-8 labelInput">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="villeCli"/>
                    </div>
                </div>
            </div>
            <label for="numApp">Numéro d'appartement</label>
            <input type="text" name="numApt" id="numAptCli"/>
            <label for="comp">Complément</label>
            <input type="text" name="comp" placeholder="Numéro de bâtiment, d'escalier etc." id="compAdrCli"/>
            <label for="mdp">Mot de passe *</label>
            <input type="password" name="mdp" placeholder="Mot de passe..." id="mdpCli" pattern="[A-Za-z0-9?,.;:§!$£*µù%]{2,20}" required />
            <span>Le mot de passe doit faire entre 2 et 20 caractères</span>
            <label for="confMdp">Confirmer mot de passe *</label>
            <input type="password" name="confMdp" id="confMdpCli" required/>
            <span>Les deux mots de passe doivent être identiques</span>
            <input class="bouton" type="submit" value="Créer un compte"/>
        </form>   
        <aside>
            <figure>
                <img src="../../img/line_1.svg"/>
                <p>Déjà un compte ?</p>
                <img src="../../img/line_1.svg"/>
            </figure>
            <nav>
                <a href="ConnexionClient.php" class="bouton">Se connecter</a>
                <a href="Catalogue.php" class="btnJaune">Retour</a>
            <nav>
        </aside>

    </main>
    <?php include('./includes/footer.php');?>

    <script>
        let mail = document.getElementById("mailCli");
        let confMail = document.getElementById("confMailCli");
        let mdp = document.getElementById("mdpCli");
        let confMdp = document.getElementById("confMdpCli");
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
                if(mail.value != confMail.value){
                    confMail.classList.add("invalid");
                }
                else{
                    confMail.classList.remove("invalid");
                }
                if(mdp.value != confMdp.value){

                    confMdp.classList.add("invalid");
                }
                else{
                    confMdp.classList.remove("invalid");
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