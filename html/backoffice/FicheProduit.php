<?php 
    $_GET["codeProduit"]=1;
    //include '../includes/backoffice/header.php';
    require_once('../_env.php');
    

    // Charger le fichier .env
    loadEnv('../.env');

    // Récupérer les variables
    $host = getenv('PGHOST');
    $port = getenv('PGPORT');
    $dbname = getenv('PGDATABASE');
    $user = getenv('PGUSER');
    $password = getenv('PGPASSWORD');

    // Connexion à PostgreSQL

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $bdd = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style/ficheProduit.css" >
        <link rel="stylesheet" type="text/css" href="../css/style/header_back.css" >
        <title>alizon</title>
    </head>
    <body>
        <?php include '../includes/backoffice/header.php';?>

        <main>
            <div class="alignemnt_droite_gauche">
               
                <?php
                $code_produit=$_GET["codeProduit"];
                $info = $bdd->query("SELECT urlPhoto FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $res=$info["urlphoto"];
                ?>
                <img src=<?php echo "$res";?> alt="image du produit" width="340px" height="auto" class="image_prod"> 
                <section>
                    <h1>
                        <?php
                        
                        $info = $bdd->query("SELECT libelleProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                        
                        $res=$info["libelleprod"];
                        echo "$res";
                        
                        ?>
                    </h1>
                    <div class="alignemnt_droite_gauche">
                        <img src="" alt="etoile" class="img_etoile">
                        <input type="button" value="Afficher les commentaires" class="buton_commentaire">
                    </div>
                    <?php
                        $info = $bdd->query("SELECT descriptionProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                        
                        $res=$info["descriptionprod"];
                        echo "<p>$res</p>";
                    ?>
                    
                    <hr>
                    <div class="alignement_space_betwen">
                        <h2>
                            <?php
                                $info = $bdd->query("SELECT prixHT FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                                $res=$info["prixht"];
                                echo "$res €";
                            ?>
                        </h2>
                        <div>
                            <button onclick="retirerCatalogue(<?php echo $code_produit?>)" value="Modifier le produit" class="buton_modif">
                            <?php
                            $state = $bdd->query("SELECT Disponible FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                            
                            if($state['disponible'] == 1){                            
                            ?>
                            <button onclick="retirerCatalogue(<?php echo $code_produit?>)" value="Retirer du catalogue" class="buton_ret_cat">
                            <?php
                            }
                            elseif ($state['disponible'] != 1){?>

                            <input type="button" value="Ajouter au catalogue" class="buton_ajt_cat">

                            <?php } ?>
                        </div> 
                    </div>
                </section>
            </div>
            <h2>Caractéristiques</h2>
            <div class="catego">
                <?php
                
                $info = $bdd->query("SELECT longueur,largeur,hauteur FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $Org = $bdd->query("SELECT Origine FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();

                if ($info!= NULL){?>
                    <section class="caract">
                        <h2> Taille</h2>
                        <ul>
                            <li>Longueur : <?php echo $info['longueur']?> mètre</li>
                            <li>Largeur : <?php echo $info['largeur']?> mètre</li>
                            <li>Hauteur : <?php echo $info['hauteur']?> mètre</li>
                        </ul>
                    </section>
                <?php
                }
                if ($Org != NULL){
                    
                ?>
                
                <section class="caract">
                        <h2> Origine</h2>
                        <ul>
                            <li>Made in <?php echo $Org['origine']?></li>

                        </ul>
                </section>
                <?php
                }
                ?>
            </div>
        </main>
        <?php include '../includes/backoffice/footer.php';?>
    </body>
</html>