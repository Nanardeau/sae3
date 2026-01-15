<?php
session_start();

if(!array_key_exists("codeCompte", $_SESSION) || !isset($_SESSION["codeCompte"]) || $_GET['numCom'] == null){
            header("location:index.php");
}

$codeCompte = $_SESSION["codeCompte"];
$numCom = $_GET['numCom'];

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
    //"❌ Erreur de connexion : " . $e->getMessage();
    ?>
    <script>
        alert("Erreur lors du chargement");
    </script>
    <?php
        header('Location: http://localhost:8888/index.php');
        exit();
}
$bdd->query('set schema \'alizon\'');
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style/Commande.css" rel="stylesheet" type="text/css">
    <title>Alizon</title>
</head>
<body>
    <?php

    if(isset( $_SESSION["codeCompte"])){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
    ?>

    <main>
        <?php
            include 'includes/menu_cat.php';
            include 'includes/menuCompte.php';
        ?>
        <div class="titre-cat">
            <h1>Suivi commande</h1>
            <div class="separateur"></div>
        </div>
        <article>
            <?php
            //Récupération des informations de la commande 
            $commande = $bdd->query("SELECT * FROM Commande where numCom = ".$numCom)->fetch();
            $client = $commande["codecompte"];
            $prixTTC = $commande["prixttctotal"];
            $prixHT = $commande["prixhttotal"];
            $date = date( 'd/m/Y', strtotime($commande["datecom"]));
            
            //Récupération des informations de l'acheteur
            $infoCpt = $bdd->query("SELECT nom,prenom,numtel from Client where codeCompte = ".$client)->fetch();
            $nomCli = $infoCpt['nom'] ;
            $prenomCli = $infoCpt['prenom'];
            $numTel = wordwrap($infoCpt['numtel'], 2, ".", 1);


            //Récupération des informations de l'adresse de facturation
            $adrLiv = $bdd->query("SELECT idAdresse FROM AdrLiv where numCom = ".$numCom)->fetch();
            $infoAdr = $bdd->query("SELECT * FROM Adresse WHERE idAdresse = ".$adrLiv['idadresse'])->fetch();
            $num = $infoAdr['num'];
            $nomRue = $infoAdr['nomrue'];
            $ville = $infoAdr['nomville'];
            $codePostal = $infoAdr['codepostal'];            
                
            ?>
            <div>
                <p><strong>Numero de commande :</strong> <?php echo $numCom ?></p>
                <p><strong>Date de commande :</strong> <?php echo $date ?></p>
            </div>
            <div>
                <p><strong>Informations Client :</strong> <?php echo $nomCli .' '.$prenomCli; ?></p>
                <p><strong>Numéro téléphone :</strong> <?php echo $numTel ?></p>
            </div>
            <div>
                <p><strong>Adresse Livraison :</strong></p>
                <p><?php echo $num.' '.$nomRue.' '.$ville.' '.$codePostal ;?></p>
            </div>

        </article>
        <div class="titre-cat">
            <h1>Avancement</h1>
            <div class="separateur"></div>
        </div>
        <section>
            <?php
            $etape = 5; 
            switch ($etape) { #en fonction de l'étape recue par delivraptor, afficher l'avancement
                case 1:
                    ?>
                    <div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Livrée</p>
                        </div>

                    </div>
                    <?php 
                    break;
                case 2:
                    ?>
                    <div>
                    <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Livrée</p>
                        </div>

                    </div>
                    <?php
                    break;
                case 3:
                case 4:
                    ?>
                    <div>
                    <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Livrée</p>
                        </div>

                    </div>
                    <?php
                    break;
                case 5:  
                case 6:
                    ?>
                    <div>
                    <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Livrée</p>
                        </div>


                    </div>
                    <?php
                    break;
                case 7:
                case 8:
                    ?>
                    <div>
                    <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#FCB66B" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#FCB66B"/>
                            </svg>
                            <p>Livrée</p>
                        </div>

                    </div>
                    <?php
                    break;
                case 9: 
                    ?>
                    <div>
                    <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 22C1.11929 22 0 23.1193 0 24.5C0 25.8807 1.11929 27 2.5 27L2.5 24.5L2.5 22ZM212.5 27L215 27V22L212.5 22V24.5V27ZM2.5 24.5L2.5 27L212.5 27V24.5V22L2.5 22L2.5 24.5Z" fill="#064082"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Création bordereau  <br>de livraison</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> Alizon</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge  <br> transporteur</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> plateforme régionale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Prise en charge <br> plateforme locale</p>
                        </div>
                        <div>
                            <svg width="215" height="50" viewBox="0 0 215 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 24.5L212.5 24.5" stroke="#064082" stroke-width="5" stroke-linecap="square"/>
                                <circle cx="106" cy="25" r="25" fill="#064082"/>
                            </svg>
                            <p>Livrée</p>
                        </div>

                    </div>
                    <?php 
                    break;
                }
            ?>
        </section>
        <div class="titre-cat">
            <h1>Produits</h1>
            <div class="separateur"></div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nom produit</th>
                    <th>Code Produit</th>
                    <th>Prix TTC</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $lesProduits = $bdd->query("SELECT ALL * FROM ProdUnitCommande where numCom = ".$numCom)->fetchAll();
                //print_r($lesProduits);
                foreach($lesProduits as $prod){
                    $idProd = $prod['codeproduit'];
                    $prixTTC = $prod['prixttctotal'];
                    $qteprod =$prod['qteprod'];
                    $nomProd = $bdd->query('SELECT libelleProd FROM Produit where codeProduit = '. $idProd)->fetch();
                    
                    ?>
                    
                     <tr>
                        <td>
                            <a href="dproduit.php?id=<?= $idProd ?>" class="btn-prod">
                            <?php echo $nomProd['libelleprod'];?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right-icon lucide-arrow-up-right">
                                    <path d="M7 7h10v10"/>
                                    <path d="M7 17 17 7"/>
                                </svg>
                            </a>
                        </td>
                        <td><?php echo $idProd ; ?></td>
                        <td><?php echo $prixTTC ;?></td>
                        <td><?php echo $qteprod ;?></td>
                     </tr>
                   
                     <?php
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php include "includes/footer.php"?>
</body>
</html>