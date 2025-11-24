<?php
session_start();
if(!array_key_exists("codeCompte", $_SESSION) || !isset($_SESSION["codeCompte"])){
    header('location: connexionVendeur.php');
    
}else{

    $codeCompte = $_SESSION["codeCompte"];
    
}
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
        <link rel="stylesheet" type="text/css" href="../css/style/popupAvis.css" >
        <script src="../js/FicheProd.js"></script>
        <title>alizon</title>
    </head>
    <body>
        <?php include '../includes/backoffice/header.php';
        $bdd->query("SET SCHEMA 'alizon'");?>

        <main>
            <div class="alignemnt_droite_gauche">
               
                <?php
                $code_produit=$_GET["Produit"];
                $info = $bdd->query("SELECT urlPhoto FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                $res=$info["urlphoto"];
                ?>
                <?php echo '<img src="../'.htmlspecialchars($res).'" alt="image du produit" width="340px" height="auto" class="image_prod">'; ?> 
                <section>
                    <h1>
                        <?php
                        
                        $info = $bdd->query("SELECT libelleProd FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                        
                        $res=$info["libelleprod"];
                        echo "$res";
                        
                        ?>
                    </h1>
                    <div class="alignemnt_droite_gauche">
                        <div class="img_etoile">
                            <?php
                                $note = $bdd->query("SELECT AVG(noteProd) AS moyenne FROM alizon.avis WHERE codeProduit=$code_produit")->fetchColumn();

                                // Assurer que $note est un nombre et afficher les étoiles pleines puis les vides jusqu'à 5
                                $rempli = is_numeric($note) ? (int)floor($note) : 0;
                                $rempli = max(0, min(5, $rempli));

                                // étoiles pleines
                                for ($j = 0; $j < $rempli; $j++) {
                                    echo '<svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">';
                                    echo '<path d="M12.7205 0.886552C12.7767 0.770493 12.8635 0.6728 12.9712 0.604497C13.0789 0.536194 13.2031 0.5 13.3298 0.5C13.4565 0.5 13.5807 0.536194 13.6884 0.604497C13.796 0.6728 13.8829 0.770493 13.9391 0.886552L16.9022 7.01987C17.0974 7.42356 17.3856 7.77281 17.742 8.03765C18.0983 8.3025 18.5122 8.47502 18.9482 8.54041L25.5749 9.53139C25.7004 9.54998 25.8184 9.60411 25.9154 9.68764C26.0125 9.77118 26.0847 9.88079 26.1239 10.0041C26.1632 10.1274 26.1679 10.2594 26.1375 10.3853C26.1071 10.5112 26.0429 10.6259 25.952 10.7164L21.1597 15.4851C20.8436 15.7999 20.6072 16.1884 20.4706 16.6172C20.3341 17.046 20.3016 17.5023 20.3759 17.9468L21.5073 24.6844C21.5295 24.8127 21.5159 24.9447 21.4682 25.0655C21.4204 25.1862 21.3404 25.2908 21.2373 25.3674C21.1342 25.4439 21.0121 25.4893 20.885 25.4983C20.7579 25.5074 20.6308 25.4797 20.5183 25.4185L14.5946 22.2358C14.2043 22.0264 13.77 21.917 13.3291 21.917C12.8883 21.917 12.454 22.0264 12.0637 22.2358L6.14127 25.4185C6.02881 25.4793 5.9019 25.5067 5.77498 25.4975C5.64806 25.4883 5.52621 25.4428 5.42331 25.3664C5.3204 25.2899 5.24056 25.1854 5.19287 25.0649C5.14519 24.9443 5.13156 24.8125 5.15355 24.6844L6.28365 17.9482C6.3583 17.5034 6.32596 17.0468 6.18942 16.6177C6.05287 16.1886 5.81623 15.7999 5.49989 15.4851L0.707548 10.7177C0.615952 10.6273 0.551044 10.5124 0.520219 10.3861C0.489393 10.2599 0.49389 10.1273 0.533196 10.0035C0.572501 9.87976 0.645036 9.76975 0.742537 9.68605C0.840039 9.60234 0.958586 9.5483 1.08468 9.53008L7.71007 8.54041C8.14653 8.47553 8.56103 8.30323 8.91788 8.03835C9.27473 7.77348 9.56325 7.42395 9.75861 7.01987L12.7205 0.886552Z" fill="#FFD500" stroke="black" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                }

                                // étoiles vides pour compléter jusqu'à 5
                                for ($j = $rempli; $j < 5; $j++) {
                                    echo '<svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">';
                                    echo '<path d="M12.7205 0.886552C12.7767 0.770493 12.8635 0.6728 12.9712 0.604497C13.0789 0.536194 13.2031 0.5 13.3298 0.5C13.4565 0.5 13.5807 0.536194 13.6884 0.604497C13.796 0.6728 13.8829 0.770493 13.9391 0.886552L16.9022 7.01987C17.0974 7.42356 17.3856 7.77281 17.742 8.03765C18.0983 8.3025 18.5122 8.47502 18.9482 8.54041L25.5749 9.53139C25.7004 9.54998 25.8184 9.60411 25.9154 9.68764C26.0125 9.77118 26.0847 9.88079 26.1239 10.0041C26.1632 10.1274 26.1679 10.2594 26.1375 10.3853C26.1071 10.5112 26.0429 10.6259 25.952 10.7164L21.1597 15.4851C20.8436 15.7999 20.6072 16.1884 20.4706 16.6172C20.3341 17.046 20.3016 17.5023 20.3759 17.9468L21.5073 24.6844C21.5295 24.8127 21.5159 24.9447 21.4682 25.0655C21.4204 25.1862 21.3404 25.2908 21.2373 25.3674C21.1342 25.4439 21.0121 25.4893 20.885 25.4983C20.7579 25.5074 20.6308 25.4797 20.5183 25.4185L14.5946 22.2358C14.2043 22.0264 13.77 21.917 13.3291 21.917C12.8883 21.917 12.454 22.0264 12.0637 22.2358L6.14127 25.4185C6.02881 25.4793 5.9019 25.5067 5.77498 25.4975C5.64806 25.4883 5.52621 25.4428 5.42331 25.3664C5.3204 25.2899 5.24056 25.1854 5.19287 25.0649C5.14519 24.9443 5.13156 24.8125 5.15355 24.6844L6.28365 17.9482C6.3583 17.5034 6.32596 17.0468 6.18942 16.6177C6.05287 16.1886 5.81623 15.7999 5.49989 15.4851L0.707548 10.7177C0.615952 10.6273 0.551044 10.5124 0.520219 10.3861C0.489393 10.2599 0.49389 10.1273 0.533196 10.0035C0.572501 9.87976 0.645036 9.76975 0.742537 9.68605C0.840039 9.60234 0.958586 9.5483 1.08468 9.53008L7.71007 8.54041C8.14653 8.47553 8.56103 8.30323 8.91788 8.03835C9.27473 7.77348 9.56325 7.42395 9.75861 7.01987L12.7205 0.886552Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                } ?>
                        </div>
                        <button onclick="togglePopup()" class="buton_commentaire">Afficher les commentaires</button>
                        <?php include '../includes/backoffice/avis.php' ?>
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
                            <button class="buton_modif">Modifier le produit</button>
                            <?php
                            $state = $bdd->query("SELECT Disponible FROM alizon.Produit WHERE codeProduit=$code_produit")->fetch();
                            
                            if($state['disponible'] == 1){                            
                            ?>
                            <button onclick="retirerCatalogue(<?php echo $code_produit?>)" class="buton_ret_cat">Retirer du catalogue</button>
                            <?php
                            }
                            elseif ($state['disponible'] != 1){?>

                            <button onclick="ajouterCatalogue(<?php echo $code_produit?>)" class="buton_ajt_cat">Ajouter au catalogue</button>

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
        <script src="/js/popupAvis.js"></script>
    </body>
</html>