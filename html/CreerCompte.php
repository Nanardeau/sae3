<?php
if($_POST){
    echo "c envoyé";
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer compte</title>
    <link href="./css/style/creerCompteFront.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header><a href="accueil.php"><img src="../../img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></a></header>
    <main>
        <form action="enreg.php" method="post">
            <h2>Création de compte</h2>
            <label for="pseudo">Identifiant *</label>
            <input type="text" name="pseudo" placeholder="Identifiant..." id="identifiant" pattern="\w{2,20}" required/> 
            <span>L'identifiant doit faire au moins 2 caractères</span>
            <div id="nomPrenomCli">
                <div class="labelInput">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" placeholder="Nom..." id="nomCli"/>
                </div>
                <div class="labelInput">
                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" placeholder="Prénom..." id="prenomCli"/>
                </div>
            </div>
            <label for="pdp">Photo de profil</label>
            <input type="file" name="photo" id="photoCli"/>
            <label for="mail">Adresse e-mail *</label>
            <input type="text" name="mail" placeholder="E-mail..." id="mailCli"/>
            <label for="confMail">Confirmer adresse mail *</label>
            <input type="text" name="confMail" id="confMailCli"/>
            <label for="numTel">Numéro de téléphone</label>
            <input type="text" name="numTel" id="numTelCli"/>
            <label for="dateNaiss">Date de naissance *</label>
            <input type="date" name="dateNaiss" class="btnSec" id="dateNaiss"/>
            <h3>Adresse</h3> <!-- essayer de faire display grid pour adresse !-->
            <div class="numNomRue">
                <div class="labelInput">
                    <label for="numRue">Numéro</label>
                    <input type="text" name="numRue" placeholder="1, 2A, 3Bis etc." id="numRueCli"/>
                </div>
                <div class="labelInput">
                    <label for="nomRue">Nom de la rue, voie</label>
                    <input type="text" name="nomRue" placeholder="Ex : Rue des lilas" id="nomRueCli"/>
                </div>
            </div>
            <div class="CpVille">
                <div class="labelInput">
                    <label for="codePostal">Code postal</label>
                    <input type="text" name="codePostal" id="codePostalCli"/>
                </div>
                <div class="labelInput">
                    <label for="ville">Ville</label>
                    <input type="text" name="ville" id="villeCli"/>
                </div>
            </div>
            <label for="numApp">Numéro d'appartement</label>
            <input type="text" name="numApt" id="numAptCli"/>
            <label for="comp">Complément</label>
            <input type="text" name="comp" placeholder="Numéro de bâtiment, d'escalier etc." id="compAdrCli"/>
            <label for="mdp">Mot de passe *</label>
            <input type="password" name="mdp" placeholder="Mot de passe..." id="mdpCli"/>
            <label for="confMdp">Confirmer mot de passe *</label>
            <input type="password" name="confMdp" id="confMdpCli"/>
            <input class="btn" type="submit" value="Créer un compte"/>
        </form>   
        <aside>
            <figure>
                <img src="../../img/line_1.svg"/>
                <p>Déjà un compte ?</p>
                <img src="../../img/line_1.svg"/>
            </figure>
            <nav>
                <a href="Connexion.php" class="btn">Se connecter</a>
                <a href="Catalogue.php" class="btnJaune">Retour</a>
            <nav>
        </aside>

    </main>
    <footer></footer>
</body>
</html>