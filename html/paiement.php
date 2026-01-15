<?php
        session_start(); 


        


        if(!array_key_exists("codeCompte", $_SESSION)){
            header("location:index.php");
        }
        $codeCompte = $_SESSION["codeCompte"];
        
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
        // if(array_key_exists("adrModif", $_SESSION)){
        //     if($_SESSION["adrModif"] == 1){
        //         $infosAdresse = $bdd->query("SELECT * FROM alizon.Adresse  WHERE idAdresse = '".$_SESSION["idAdresse"]."'")->fetch();
        //         $_SESSION["adrModif"] = 0;
                
        //     }

        //     else{
        //         $_SESSION["adrModif"] = 0;
        //         $infosAdresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.adrFactCli adrFact ON adresse.idAdresse = adrFact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();
        //         $_SESSION["idAdresse"] = $infosAdresse["idadresse"];
        //     }
        // }
        // else{
            
        //     $_SESSION["adrModif"] = 0;

                    $infosAdresse = $bdd->prepare("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.adrFactCli adrFact ON adresse.idAdresse = adrFact.idAdresse WHERE codeCompte = :codeCompte");
                    $infosAdresse->execute([':codeCompte' => $codeCompte]);
                    $infosAdresse = $infosAdresse->fetch();
                   

          
        // }

    $panier = $bdd->prepare("SELECT * FROM alizon.Panier WHERE codeCompte = :codeCompte");
    $panier->execute([':codeCompte' => $codeCompte]);
    $panier = $panier->fetch();
    $idPanier = $panier["idpanier"];

   ?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="./css/style/paiement.css" rel="stylesheet" type="text/css">
    <link href="./css/components/fonts.css" rel="stylesheet" type="text/css">
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
            
            include 'includes/menuCompte.php';
        ?>

    <?php   
    if($_POST){
        print_r($_POST);
    }
    if(isset($_GET["suppProd"])){
        
        $stmt = $bdd->prepare("DELETE FROM ProdUnitPanier WHERE idPanier = :idPanier AND codeProduit = :codeProduit");
        $stmt->execute([
            ':idPanier' => $idPanier,
            ':codeProduit' => $_GET["suppProd"]
        ]);
    }
    ?>
    <div class="ariane">
        <a class="arianeItem" href="index.php">Accueil > </a><a class="arianeItem" href="Catalogue.php">Catalogue > </a><a class="arianeItem" href="Panier.php">Panier</a>
    </div>
    <div class="conteneur">
        <div class="ligneSection">
            <div class="colonne">
                <section id="adresseLivraison">
                    <h2>Adresse livraison</h2>
                    <h4 id="AdrInvalide" style="color:red" hidden>Veuillez remplir tous les champs</h4>
                    <article>
                    <?php 
                        #print_r($nomPrenom);
                        #print_r($infosAdresse);
                        
                    ?>
                    <div class="conteneur">
                    <form action="enregPaiement.php?adresse=1" method="post" id="formulaireAdr">
                        <div class="ligneInput">
                            <div class="labelInput">
                                <label for="nom">Nom *</label>
                                <input type="text" name="nom" id="nom" value="<?php echo $nomPrenom["nom"]?>" required disabled/>                    
                            </div>
                            <div class="labelInput">
                                
                                <label for="prenom">Prénom *</label>
                                <input type="text" name="prenom" id="prenom" value="<?php echo $nomPrenom["prenom"]?>" required disabled/>
                                
                            </div>


                        </div>
                        <?php if($infosAdresse)?>
                        <div class="ligneInput">
                            <div class="labelInput">
                                <label for="numRue">Numéro *</label>
                                <input type="text" name="numRue" id="numRue" value="<?php echo $infosAdresse["num"]?>" required disabled/>
                            </div>
                        
                            <div class="labelInput">
                                <label for="nomRue">Rue *</label>
                                <input type="text" name="nomRue" id="nomRue" value="<?php echo $infosAdresse["nomrue"]?>" required disabled/>
                            </div>
                            

                        </div>
                        <div class="ligneInput">
                            <div class="labelInput">
                                
                                <label for="codePostal">Code postal *</label>
                                <input type="text" name="codePostal" id="codePostal" value="<?php echo $infosAdresse["codepostal"]?>" required disabled/>
                            </div>
                            <div class="labelInput">
                                <label for="ville">Ville *</label>
                                <input type="text" name="ville" id="ville" value="<?php echo $infosAdresse["nomville"]?>" required disabled/>
                            </div>
                        </div>
                        <div class="ligneInput">
                            <div class="labelInput">
                                <label>N° appartement</label>
                                <input type="text" name="numApt" id="numApt" value="<?php echo $infosAdresse["numappart"]?>" disabled/> 
                            </div>
                            <div class="labelInput">
                                <label for="complement">Complément d'adresse</label>
                                <input type="text" name="comp" id="comp" value="<?php echo $infosAdresse["complementadresse"]?>" disabled />
                                <p class="btnJaune" value="Valider" onclick="validerAdresse()" id="validerAdr" hidden>Valider</p>
                            </div>
                        </div>
                    </form>
                    </div>
                    </article>
                    <button class="bouton" id="modifAdr">Modifier</button>
                </section>
            </div>
            

                <section id="secRecap">
                    <?php 

                    $nbProd = ($bdd->query("SELECT ALL SUM(qteProd) somme from alizon.ProdUnitPanier where idPanier = '".$idPanier."'")->fetch())["somme"];
                    ?>
                    <h2>Récapitulatif ( <?php echo number_format((int)$nbProd, 0, '.', '')?> articles ) </h2>
                    <article id="recapitulatif">

                            <?php 
                            $i = 1;

                            $produits = $bdd->prepare("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = :idPanier");
                            $produits->execute([':idPanier' => $idPanier]);
                            $produits = $produits->fetchAll();
                            foreach($produits as $prodUnit){
                                ?><div class="libelleProdRecap"><?php
                                $detailProd = $bdd->prepare("SELECT * FROM alizon.Produit WHERE codeProduit = :codeProduit");
                                $detailProd->execute([':codeProduit' => $prodUnit["codeproduit"]]);
                                $detailProd = $detailProd->fetch();
                                echo "<p>Article ".$i." (".$detailProd["libelleprod"]. ") : ( x ". number_format((int)$prodUnit["qteprod"], 0, '.', '')." )</p><p class=\"prixAffiche\">".number_format((float)$prodUnit["prixhttotal"], 2, '.', '')."€</p>";
                                $i++;
                                ?></div><?php
                            }
                            ?>      
                             
                            <!--<p>Prix HT : <?php echo $panier["prixhttotal"]?>€</p>!-->
                            <div class="libelleProdRecap">
                            <p>Sous-total (HT) : </p><p class="prixAffiche"><?php echo number_format((float)$panier["prixhttotal"], 2, '.', '') ?>€</p>
                            </div>
                            <p id="prixTTCRecap">Total (TTC) : <?php echo $panier["prixttctotal"]?>€</p>


                    </article>
                </section>
            
        </div> <!-- Row container global !-->
        <div class="ligneArtPaye">

                <section>
                    <h2>Articles</h2>
                    <article id="articles">

                            
                                <?php
                                    $panier = $bdd->prepare("SELECT * FROM alizon.Panier WHERE codeCompte = :codeCompte");
                                    $panier->execute([':codeCompte' => $codeCompte]);
                                    $panier = $panier->fetch();
                                    $idPanier = $panier["idpanier"];
                                    $produits = $bdd->prepare("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = :idPanier");
                                    $produits->execute([':idPanier' => $idPanier]);
                                    $produits = $produits->fetchAll();
                                    foreach($produits as $prodUnit){
                                        echo "<div class=\"ligne\">";
                                        $detailProd = $bdd->prepare("SELECT * FROM alizon.Produit WHERE codeProduit = :codeProduit");
                                        $detailProd->execute([':codeProduit' => $prodUnit["codeproduit"]]);
                                        $detailProd = $detailProd->fetch();
                                        echo "<div>".$detailProd["libelleprod"] . "</div>";
                                        ?>
                                        <div class="prixPoub">
                                            <div class="prix"><?php echo $prodUnit["prixttctotal"]?>€</div>
                                            
                                            <div><button id="poubelle" onclick="supprimerProd(<?php echo $idPanier ?> , <?php echo $prodUnit['codeproduit']?>)"><img src="img/Icon_poubelle.svg" alt="poubelle" title="poubelle"/></button></div><?php
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
                                <input type="text" name="nomTitulaireCB" id="nomTitulaireCB" required/>
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
                    <div>
                        <button class="bouton" onclick="annuler()">Annuler</button>
                        <button class="btnJaune"  id="btnPayer">Payer</button>
                        
                                </div>
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
    let btnModifAdr = document.getElementById("modifAdr");
    let btnValiderAdr = document.querySelector("#adresseLivraison .btnJaune");
    btnPayer.addEventListener("click", validerPaiement);
    btnModifAdr.addEventListener("click", modifierAdr);


    function sendGet(url, onSuccess, onError) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                if (typeof onSuccess === 'function') onSuccess(xhr);
            } else {
                if (typeof onError === 'function') onError(xhr);
            }
        };
        xhr.onerror = function() {
            if (typeof onError === 'function') onError(xhr);
        };
        xhr.send();
    }
    function supprimerProd(idPanier, codeProd){
        if(confirm("Voulez vous supprimer cet article ?")){
        url = "modifPanier.php?Action=supprimerProduit&Panier=" + encodeURIComponent(idPanier) + "&Produit=" + encodeURIComponent(codeProd);
        sendGet(url,function() { 
            location.reload(); 
        },
        function() { 
            alert('Erreur côté serveur.');
         }
        )

    }
    }
    function annuler(){
        window.location = "Panier.php";
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
        //Il faut que les champs soient modifiables pour être pris en compte dans le $_POST
        for(let i = 0 ; i < champsAdresse.length ; i++){
            champsAdresse[i].removeAttribute("disabled");
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
            document.getElementById("formulaireAdr").submit();           
           
        }

    }
    function modifierAdr(){
        let champsAdresse = document.querySelectorAll("#adresseLivraison input");
        for(let i = 0 ; i < champsAdresse.length ; i++){
            champsAdresse[i].removeAttribute("disabled");
        }
        btnValiderAdr.removeAttribute("hidden");
        
    }
    function validerAdresse(){
        let champsAdresse = document.querySelectorAll("#adresseLivraison input");
        for(let i = 0 ; i < champsAdresse.length ; i++){
            champsAdresse[i].setAttribute("disabled", null);
        }
        btnValiderAdr.setAttribute("hidden", null);        
    }
    /*
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
    }*/
</script>
</body>

</html>
