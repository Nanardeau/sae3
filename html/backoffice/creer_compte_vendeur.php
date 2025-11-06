<!DOCTYPE html>
<html lang="en">
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
            <input type="text" name="mdp" id="mdp" class="dimension" required>
            <h5>
                Confirmer mot de passe* :
            </h5>
            <input type="text" name="mdp_conf" id="mdp_conf" class="dimension" required>
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
    </main>
    <footer>
        <button type="submit">Créer le compte</button>
    </footer>
</body>
</html>