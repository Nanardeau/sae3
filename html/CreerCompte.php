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
    <header><img src="../../img/logo_alizon_front.svg" alt="logo-alizon" title="logo-alizon"/></header>
    <main>
        
        <form action="enreg.php" method="post">
        <h2>Création de compte</h2>
        <label for="pseudo">Identifiant *</label>
        <input type="text" name="pseudo"/> 
        <label for="nom">Nom *</label>
        <input type="text" name="nom"/>
        <label for="prenom">Prénom *</label>
        <input type="text" name="prenom"/>
        <label for="pdp">Photo de profil</label>
        <input type="file" name="photo"/>
        <label for="mail">Adresse e-mail *</label>
        <input type="text" name="mail"/>
        <label for="confMail">Confirmer adresse mail *</label>
        <input type="text" name="confMail"/>
        <label for="numTel">Numéro de téléphone</label>
        <input type="text" name="numTel"/>
        <label for="dateNaiss">Date de naissance *</label>
        <input type="date" name="dateNaiss" class="btnSec"/>
        <h3>Adresse</h3>
        <label for="numRue">Numéro</label>
        <input type="text" name="numRue"/>
        <label for="nomRue">Nom de la rue, voie</label>
        <input type="text" name="nomRue"/>
        <label for="codePostal">Code postal</label>
        <input type="text" name="codePostal"/>
        <label for="ville">Ville</label>
        <input type="text" name="ville"/>
        <label for="comp">Complément</label>
        <input type="text" name="comp"/>
        <label for="mdp">Mot de passe *</label>
        <input type="password" name="mdp"/>
        <label for="confMdp">Confirmer mot de passe *</label>
        <input type="password" name="confMdp"/>
        <input class="btn" type="submit" value="Créer un compte"/>
        </form>   
        <aside>
            <img src="../../img/line_1.svg"/>
            <p>Déjà un compte ?</p>
            <img src="../../img/line_1.svg"/>
            <nav>
                <a href="Connexion.php" class="btn">Se connecter</a>
                <a href="Catalogue.php" class="btnJaune">Retour</a>
            <nav>
        </aside>

    </main>
    <footer></footer>
</body>
</html>