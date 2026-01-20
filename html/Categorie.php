<?php
include('connDb.php');

$cat = $_GET["cat"];
$cat = strtoupper(substr($cat, 0, 1)) . substr($cat, 1, strlen($cat));

$prodsCat = $bdd->query("SELECT ALL * FROM alizon.Categoriser WHERE libelleCat = '".$cat."'")->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">

    <title><?php echo $cat?></title>
</head>
<style>

    section{
        display:flex;
        flex-wrap:wrap;
        .card{
            margin-bottom:2em;
        }
    }
</style>
<body>
    <?php
    
    $estClient = false;
    if(isset($_SESSION["codeCompte"])){

        $clients = $bdd->query("SELECT ALL codeCompte FROM alizon.Client")->fetchAll();
        foreach($clients as $client){
            if($client["codecompte"] == $_SESSION["codeCompte"]){
                $estClient = true;
            }
        }
    }
    if(isset( $_SESSION["codeCompte"]) && $estClient){
        $idUser =  $_SESSION["codeCompte"];
        include 'includes/headerCon.php' ;
    }else{
        include 'includes/header.php';
    }
    ?>

    <main style="display:flex;flex-direction:column">
        <?php
            
            include 'includes/menuCompte.php';
        ?>
    <h2><?php echo $cat?></h2>
            <div class="separateur"></div>
            <div class="titre-cat">
            <h2>
            
            </h2>
                <div class="separateur2"></div>
            </div>
    
    <section>        
    <?php foreach($prodsCat as $produit){
        $p = $bdd->query("SELECT * FROM alizon.Produit WHERE codeProduit = '".$produit["codeproduit"]."'")->fetch();
        $img = $p['urlphoto'];
        $libArt = $p['libelleprod'];
        $prix = number_format($p['prixttc'], 2, ',', '');
        $desc = $p['descriptionprod'];
        $id = $p['codeproduit'];
        include 'includes/card.php';
        ?>
        
        
    <?php
    }
    ?>
    </section>
    <button class="bouton" style="padding:2em 5em" onclick="retour()">Retour</button>
</main>
<?php include 'includes/footer.php';?>
<script>
    function retour(){
        history.back();
    }
</script>
</body>
</html>