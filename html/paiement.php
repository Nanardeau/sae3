
    <?php
        session_start(); 
        /*$_SESSION["codeCompte"] = 1;
        $codeCompte = $_SESSION["codeCompte"];*/
        $codeCompte = 3;

        if(!array_key_exists("codeCompte", $_SESSION)){
            //header("location:index.php");
        }
        
        
        require_once __DIR__ . '/_env.php';

        loadEnv(__DIR__ . '/.env');

        $host = getenv('PGHOST');
        $port = getenv('PGPORT');
        $dbname = getenv('PGDATABASE');
        $user = getenv('PGUSER');
        $password = getenv('PGPASSWORD');

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
            $bdd = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        $nomPrenom = $bdd->query("SELECT nom, prenom FROM alizon.Client WHERE codeCompte = '".$codeCompte."'")->fetch();
        $infosAdresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.adrFactCli adrFact ON adresse.idAdresse = adrFact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();
    ?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="./css/style/paiement.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
    <link href="./bootstrap-5.3.8-dist/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>
<?php include "./includes/header.php"?>
<main>
    <section id="adresseLivraison">
        <h2>Adresse livraison</h2>
        <article>
        <?php 
            #print_r($nomPrenom);
            #print_r($infosAdresse);
            
        ?>
        <div class="container-fluid gap-2">
        <form action="paiement.php?adresse=1">
            <div class="row">
                <div class="col">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" id="nom" value="<?php echo $nomPrenom["nom"]?>" required/>                    
                </div>
                <div class="col">
                    
                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" value="<?php echo $nomPrenom["prenom"]?>" required/>
                    
                </div>
                <div class="col">
                </div>
                <div class="col-4 labelInput">
                    <br/>
                    <input type="submit" class="btnJaune" value="Valider"/>     
                </div>
            </div>
            <?php if($infosAdresse)?>
            <div class="row">
                <div class="col-2">
                    <label for="numRue">Numéro *</label>
                    <input type="text" name="numRue" id="numRue" value="<?php echo $infosAdresse["num"]?>" required/>
                </div>
                <div class="col-6">
                    <div class="labelInput">
                        <label for="nomRue">Rue *</label>
                        <input type="text" name="nomRue" id="nomRue" value="<?php echo $infosAdresse["nomrue"]?>" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3 labelInput">
                    
                    <label for="codePostal">Code postal *</label>
                    <input type="text" name="codePostal" id="codePostal" value="<?php echo $infosAdresse["codepostal"]?>" required/>
                </div>
                <div class="col-5 labelInput">
                    <label for="ville">Ville *</label>
                    <input type="text" name="ville" id="ville" value="<?php echo $infosAdresse["nomville"]?>" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-3 labelInput">
                    <label>N° appartement</label>
                    <input type="text" name="numApt" id="numApt" value="<?php echo $infosAdresse["numappart"]?>" required/> 
                </div>
                <div class="col-5 labelInput">
                    <label for="complement">Complément d'adresse</label>
                    <input type="text" name="comp" id="comp" value="<?php echo $infosAdresse["complementadresse"]?>" required/>
                </div>
            </div>            
        </form>
        </div>
        </article>
    </section>
    <section>
        <h2>Articles</h2>
        <article id="articles">

                
                    <?php
                        $panier = $bdd->query("SELECT * FROM alizon.Panier WHERE codeCompte = '".$codeCompte."'")->fetch();
                        $idPanier = $panier["idpanier"];
                        $produits = $bdd->query("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = '".$idPanier."'")->fetchAll();
                        foreach($produits as $prodUnit){
                            echo "<div class=\"ligne\">";
                            $detailProd = $bdd->query("SELECT * FROM alizon.Produit WHERE codeProduit = '".$prodUnit["codeproduit"]."'")->fetch();
                            echo "<div>".$detailProd["libelleprod"] . "</div>";
                            ?>
                            <div class="prixPoub">
                                <div class="prix"><?php echo $prodUnit["prixttctotal"]?>€</div>
                                <div><button onclick="supprimerProd(<?php echo $prodUnit["codeproduit"]?>)">poub</button></div><?php
                                echo "</div></div>";
                        }

                    ?>

        </article>
    </section>

</main>

<?php include("./includes/footer.php")?>
<script>
    function supprimerProd(codeProd){
        console.log(codeProd);
    }

</script>
</body>

</html>
