<?php 
    $_GET["codeProduit"]=11;
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
        <link rel="stylesheet" type="text/css" href="../css/style/consulter_fiche_produit_vendeur.css" >
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
                            <input type="button" value="Modifier le produit" class="buton_modif">
                            <input type="button" value="Retirer du catalogue" class="buton_ret_cat">
                        </div> 
                    </div>
                </section>
            </div>
            <h2>Caractéristique</h2>
            <div class="catego">
                <?php
                
                $info = $bdd->query("SELECT longueur FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $res=$info["longueur"];
                if ($res!=""){
                    echo "
                    <section class=\"caract\" >
                        <h2>• Longueur</h2>
                        <p>$res mètre</p>
                    </section>";
                }
                $info = $bdd->query("SELECT hauteur FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $res=$info["hauteur"];
                if ($res!=""){
                    echo "
                    <section class=\"caract\" >
                        <h2>• Taille</h2>
                        <p>$res mètre</p>
                    </section>";
                }
                $info = $bdd->query("SELECT largeur FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $res=$info["largeur"];
                if ($res!=""){
                    echo "
                    <section class=\"caract\" >
                        <h2>• Largeur</h2>
                        <p>$res mètre</p>
                    </section>";
                }
                
                
                ?>
            </div>
        </main>
        <?php include '../includes/backoffice/footer.php';?>
    </body>
</html>