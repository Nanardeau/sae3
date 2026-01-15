<?php
if(isset($_GET["erreur"])){
        $erreur = $_GET["erreur"];
}
else{
        $erreur = NULL;
    }
session_start();
//Connexion à la base de données.
require_once('../_env.php');
loadEnv('../.env');

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

        
}

if(!isset($_SESSION["codeCompte"])){
        header('Location: index.php');
           
}
$bdd->query('set schema \'alizon\'');

$codeCompte = $_SESSION["codeCompte"];

$sql = "SELECT * FROM alizon.Vendeur WHERE codeCompte = '".$codeCompte."'";
$stmt = $bdd->query($sql);
$vendeur = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style/backoffice/ajouterPromotion.css" rel="stylesheet" type="text/css">
    <link href="../css/style/backoffice/ficheProduit.css" rel="stylesheet" type="text/css">
    <link href="../css/components/fonts.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="img/favicon_alizon.png" type="image/x-icon">
    <title>Alizon Back Office - Modifier la fiche produit</title>
</head>

<body>
    <?php include("../includes/backoffice/header.php"); ?>
        <!-- <label class="label-retour btn-retour" for="retour"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>Retour</label>
        <INPUT id="retour" TYPE="button" VALUE="RETOUR" onclick="history.back();"> -->
        <!-- <a href="index.php" class="btn-retour">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="m14 16-4-4 4-4"/>
            </svg>
            Retour
        </a> -->

<main>
    <?php include '../includes/backoffice/menuCompteVendeur.php'; ?>
    <section class="nav-btn">
        <?php $code_produit=$_GET["Produit"]; ?>
        <a href="index.php" class="btnacc">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Accueil
        </a>
        <a class="btnacc" href="#" onclick="event.preventDefault(); history.back();" >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chevron-left-icon lucide-square-chevron-left"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m14 16-4-4 4-4"/></svg>
            Retour au produit
        </a>
        <a class="btnacc" href="modifProduit.php?codeProduit=<?php echo $code_produit?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-line-icon lucide-pen-line"><path d="M13 21h8"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>
            Modifier le produit
        </a>
        <a href="#avis-produits" class="btnacc">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-icon lucide-message-circle"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/></svg>
            Voir les avis
        </a>
        <a class="btnacc" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
            Ajouter une promotion
        </a>
        <a class="btnacc" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket-percent-icon lucide-ticket-percent"><path d="M2 9a3 3 0 1 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 1 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M9 9h.01"/><path d="m15 9-6 6"/><path d="M15 15h.01"/></svg>
            Ajouter une remise
        </a>
    </section>
    <div class="right-content">
        <?php if($erreur == "succes"){
                    echo "<h2 style=\"color:green\">Produit créé avec succès</h2>";
                }
                else if($erreur == "image"){
                    echo "<h2 style=\"color:red\">Produit image avec erreur</h2>";
                }
        ?>
        <form action="reqAjouterPromotion.php" method="post" enctype="multipart/form-data">
            <h2>Ajouter une promotion</h2>
            <div class="dropreview">
                <div id="dropZone">
                    <span>Glissez une image ici ou cliquez</span>
                    <input type="file" name="photo" id="photoProd" accept="image/*" hidden>
                </div>
                <!-- <input type="file" name="photo" id="photoProd" accept="image/*"/> -->
                <div id="preview">

                </div>
            </div>

            <label for="dateD">Date de début de la promotion</label>
            <input type="date" name="dateD" placeholder="" id="dateD" required/> 

            <label for="dateF">Date de fin de la promotion</label>
            <input type="date" name="dateF" placeholder="" id="dateF" required/>

            <input class="bouton" type="submit" id="creerPromo" value="Créer la promotion"/>
        </form>
    </div>
</main>
    <?php include('../includes/backoffice/footer.php');?>
    <script src="../js/preview-img.js"></script>
    <script>

    let qtestock = document.getElementById("qteStock");
    let seuil = document.getElementById("seuil");

    qtestock.addEventListener("focusout", verfifQte);
    seuil.addEventListener("focusout", verfifQte);

    function verfifQte(evt){
        if(evt.type === "focusout"){
            if(parseInt(evt.target.value) < 0){
                evt.target.classList.add("invalid");
            }else{
                evt.target.classList.remove("invalid");
        }
    }

    let spe1 = document.getElementById("spe1");
    let spe2 = document.getElementById("spe2");
    let spe3 = document.getElementById("spe3");
    let formatSpe = /^([A-Za-zÀ-ÖØ-öø-ÿ0-9\s-]{1,}):([A-Za-zÀ-ÖØ-öø-ÿ0-9\s,.-]{1,})$/;
    spe1.addEventListener("focusout", verifFormatSpe);
    spe2.addEventListener("focusout", verifFormatSpe);
    spe3.addEventListener("focusout", verifFormatSpe);

    let validationForm = document.getElementById("creerProduit");
    validationForm.addEventListener("click", fullverif);

    function verifFormatSpe(evt){
        if(evt.type === "focusout"){
            if((!formatSpe.test(evt.target.value)) && evt.target.value !== ""){
                // alert("Le format de la spécificité 1 n'est pas respecté. Veuillez respecter le format NOMDELASPE:Description");
                // spe1.value = NULL;
                evt.target.classList.add("invalid");
            }else{
                evt.target.classList.remove("invalid");
            }
        }
    }

    function fullverif(evt){
        if(spe1.value !== "" && !formatSpe.test(spe1.value)){
            evt.preventDefault();
            spe1.classList.add("invalid");
        }
        if(spe2.value !== "" && !formatSpe.test(spe2.value)){
            evt.preventDefault();
            spe2.classList.add("invalid");
        }
        if(spe3.value !== "" && !formatSpe.test(spe3.value)){
            evt.preventDefault();
            spe3.classList.add("invalid");
        }else{
            spe1.classList.remove("invalid");
            spe2.classList.remove("invalid");
            spe3.classList.remove("invalid");

        }
    }
</script>
<script src="../js/overlayCompteVendeur.js"></script>

</body>
</html>