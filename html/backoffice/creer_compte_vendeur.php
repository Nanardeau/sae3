<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creer Compte Vendeur</title>
</head>
<body>
    <header>
        <img src="" alt="">
        <h1>Back Office</h1>
    </header>
    <main>
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
            <input type="text" name="identifiant" id="identifiant">
            <h5>
                Nom* :
            </h5>
            <input type="text" name="nom" id="nom">
            <h5>
                Prenom* :
            </h5>
            <input type="text" name="prenom" id="prenom">
            <h5>
                Adresse e-mail* :
            </h5>
            <input type="text" name="email" id="email">
            <h5>
                Confirmer adresse e-mail* :
            </h5>
            <input type="text" name="email_conf" id="email_conf">
            <h5>
                Numéro de téléphone* :
            </h5>
            <input type="text" name="num_tel" id="num_tel">
            <h5>
                mot de passe* :
            </h5>
            <input type="text" name="mdp" id="mdp">
            <h5>
                Confirmer mot de passe* :
            </h5>
            <input type="text" name="mdp_conf" id="mdp_conf">
        </div>
        <hr>
        <div>
            <h3>
                Information entreprise
            </h3>
            <h5>
                Numéro de SIREN* :
            </h5>
            <input type="text" name="num_siren" id="num_siren">
            <h5>
                Raison sociale* :
            </h5>
            <input type="text" name="raison_soc" id="raison_soc">
            <h5>
                ligne d'adresse 1* :
            </h5>
            <input type="text" name="adresse1" id="adresse1" value="Adresse">
            <h5>
                ligne d'adresse 2 :
            </h5>
            <input type="text" name="adresse2" id="adresse2" value="Apt, suite, unité, nom de l’entreprise (facultatif)">
            <h5>
                Code postal* :
            </h5>
            <input type="text" name="code_post" id="code_post" >
            <h5>
                Ville* :
            </h5>
            <input type="text" name="ville" id="ville">
        </div>
    </main>
    <footer>
        <button type="submit">Créer le compte</button>
    </footer>
</body>
</html>