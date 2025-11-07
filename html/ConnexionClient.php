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
        <form>
            <h2>Connexion</h2>
            <label for="pseudo">Identifiant</label>
            <input type="text" name="pseudo" placeholder="Identifiant..." id="identifiant"/>
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" placeholder="Mot de passe..." id="mdpCli"/>
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