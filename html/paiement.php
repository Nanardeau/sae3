
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
    <?php         if($_POST){
            print_r($_POST);
        }?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <section id="adresseLivraison">
                    <h2>Adresse livraison</h2>
                    <h4 id="AdrInvalide" style="color:red" hidden>Veuillez remplir tous les champs</h4>
                    <article>
                    <?php 
                        #print_r($nomPrenom);
                        #print_r($infosAdresse);
                        
                    ?>
                    <div class="container-fluid gap-2">
                    <form action="enregPaiement.php" method="post" id="formulaireAdr">
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
                                <input type="text" name="numApt" id="numApt" value="<?php echo $infosAdresse["numappart"]?>" /> 
                            </div>
                            <div class="col-5 labelInput">
                                <label for="complement">Complément d'adresse</label>
                                <input type="text" name="comp" id="comp" value="<?php echo $infosAdresse["complementadresse"]?>" />
                            </div>
                        </div>            
                    </form>
                    </div>
                    </article>
                </section>
            </div>
            <div class="col-6">
                <section id="secRecap">
                    <h2>Récapitulatif ( <?php echo $nbProd?> articles) </h2>
                    <article id="recapitulatif">

                            <?php 
                            $i = 1;
                            $panier = $bdd->query("SELECT * FROM alizon.Panier WHERE codeCompte = '".$codeCompte."'")->fetch();
                            $idPanier = $panier["idpanier"];
                            $produits = $bdd->query("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = '".$idPanier."'")->fetchAll();
                            $nbProd = ($bdd->query("SELECT ALL count(*) from alizon.ProdUnitPanier where idPanier = '".$idPanier."'")->fetch())["count"];
                            foreach($produits as $prodUnit){
                                ?><div class="libelleProdRecap"><?php
                                $detailProd = $bdd->query("SELECT * FROM alizon.Produit WHERE codeProduit = '".$prodUnit["codeproduit"]."'")->fetch();
                                echo "<p>Article ".$i." (".$detailProd["libelleprod"]. ") : </p><p class=\"prixAffiche\">".number_format((float)$detailProd["prixht"], 2, '.', '')."€</p>";
                                $i++;
                                ?></div><?php
                            }
                            ?>      
                             
                            <!--<p>Prix HT : <?php echo $panier["prixhttotal"]?>€</p>!-->
                            <p>Sous-total (HT) <?php echo number_format((float)$panier["prixhttotal"], 2, '.', '') ?>€</p>
                            <p id="prixTTCRecap">Total (TTC) : <?php echo $panier["prixttctotal"]?>€</p>


                    </article>
                </section>
            </div>
        </div> <!-- Row container global !-->
        <div class="ligneArtPaye">

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

                <section>
                    <h2>Informations de paiement</h2>
                    <h4 id="BanqueInvalide" style="color:red" hidden>Veuillez remplir tous les champs</h4>
                    <article id="infosPaiement">
                            <form action="enregPaiement.php?banque=1" method="post" id="formulaireBanque">
                                <label for="nomTitulaireCB">Nom figurant sur la carte *</label>
                                <input type="text" name="nomCB" id="nomTitulaireCB" required/>
                                <label for="numCB">Numéro de carte *</label>
                                <input type="text" name="numCB" id="numCB" pattern="\d{16}" required/>
                                <div class="dateCVC">
                                    <div class="labelInput">
                                        <label for="expDate">Date d'expiration *</label>
                                        <input type="text" name="expDate" id="expDate" pattern="\d{4}"required/>
                                    </div>
                                    <div class="labelInput">
                                        <label for="cvc">Cryptogramme visuel *</label>
                                        <input type="text" name="cvc" id="cvc" pattern="\d{3}" required/>
                                    </div>
                                </div>

                            </form>

                    </article>
                    <nav>
                        <button class="bouton" onclick="annuler()">Annuler</button>
                        <button class="btnJaune"  id="btnPayer">Payer</button>
                        
                    </nav>
                </section>

        </div>
    </div>
</main>

<?php include("./includes/footer.php")?>
<?php
        if(array_key_exists("adr", $_GET)){
            echo "<script>document.getElementById(\"formulaireBanque\").submit()</script>";
        }
?>
<script>
    let btnPayer = document.getElementById("btnPayer");
    btnPayer.addEventListener("click", validerPaiement);

    function supprimerProd(codeProd){
        console.log(codeProd);
    }
    function annuler(){
        window.location.reload();
    }
    function validerPaiement(evt){
        let adrValide = true;
        let banqueValide = true;
        let champsAdresse = document.querySelectorAll("#adresseLivraison :required");
        let champsBanque = document.querySelectorAll("#infosPaiement :required");
        for(let i =0 ; i < champsAdresse.length ; i++){
            if(champsAdresse[i].value == ""){
                adrValide = false;
                document.getElementById("AdrInvalide").removeAttribute("hidden");


            }
        }
        for(let i = 0 ; i < champsBanque.length ; i++){
            if(champsBanque[i].value == ""){
                banqueValide = false;
                document.getElementById("BanqueInvalide").removeAttribute("hidden");
            }
        }
        if(banqueValide == false || adrValide == false){
            evt.preventDefault();
            console.log("non");
        }
        else{
            submitTout();
           
        }

    }
    function submitTout(){
        const formulaireAdr = document.getElementById("formulaireAdr");
        const formulaireBanque = document.getElementById("formulaireBanque");
        let envoiPost = [];
        for(let i = 0 ; i < formulaireBanque.elements.length ; i++){
            envoiPost.push(encodeURIComponent(formulaireBanque.elements[i].name) + "=" +
            encodeURIComponent(formulaireBanque.elements[i].value));
        }       
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "enregPaiement.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(envoiPost.join("&"));

        formulaireAdr.submit();
        console.log(envoiPost);

    }

    async function submitAll() {
    const formulaireAdr = document.getElementById("formulaireAdr");
    const formulaireBanque = document.getElementById("formulaireBanque");

    const res = await fetch(formulaireAdr.action, {
        method: formulaireAdr.method,
        headers: { "content-type": formulaireAdr.enctype },
        body: new FormData(formulaireAdr),

    });
    if (!res.ok) {
        const err = new Error(`DB Update Failed! Status: ${res.status}`);
        const isJSON = res.headers.get("content-type") == "application/json";
        err.body = await (isJSON ? res.json() : res.text());
        throw err;
    }

    formulaireBanque.submit();
    }
</script>
</body>

</html>
