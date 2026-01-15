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

                    $infosAdresse = $bdd->query("SELECT * FROM alizon.Adresse adresse INNER JOIN alizon.adrFactCli adrFact ON adresse.idAdresse = adrFact.idAdresse WHERE codeCompte = '".$codeCompte."'")->fetch();
                   

          
        // }

    $panier = $bdd->query("SELECT * FROM alizon.Panier WHERE codeCompte = '".$codeCompte."'")->fetch();
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
            include 'includes/menu_cat.php';
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
    <div class="conteneur">
    <nav class="ariane">
        <a class="arianeItem" href="index.php">
        <svg width="172" height="76" viewBox="0 0 172 76" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_d_1309_8154)">
        <path d="M456.866 0H0L50.0272 35.4545L0 72H456.866L540 32.1818L456.866 0Z" fill="#D9D9D9"/>
        </g>
        <line x1="172.629" x2="172.629" y2="72" stroke="#BABABA" stroke-width="3"/>
        <path d="M71.872 43V26.08H79.384C81.24 26.08 82.656 26.528 83.632 27.424C84.608 28.32 85.096 29.552 85.096 31.12C85.096 32.672 84.608 33.904 83.632 34.816C82.656 35.728 81.24 36.184 79.384 36.184H74.968V43H71.872ZM74.968 33.736H79.024C80.048 33.736 80.816 33.512 81.328 33.064C81.84 32.6 82.096 31.952 82.096 31.12C82.096 30.288 81.84 29.648 81.328 29.2C80.816 28.736 80.048 28.504 79.024 28.504H74.968V33.736ZM91.7339 43.24C90.6779 43.24 89.7499 42.992 88.9499 42.496C88.1499 41.984 87.5259 41.256 87.0779 40.312C86.6299 39.368 86.4059 38.24 86.4059 36.928C86.4059 35.616 86.6299 34.496 87.0779 33.568C87.5259 32.624 88.1499 31.904 88.9499 31.408C89.7499 30.896 90.6779 30.64 91.7339 30.64C92.7579 30.64 93.6539 30.896 94.4219 31.408C95.2059 31.904 95.7259 32.576 95.9819 33.424H95.7179L95.9819 30.88H98.8619C98.8139 31.376 98.7659 31.88 98.7179 32.392C98.6859 32.904 98.6699 33.408 98.6699 33.904V43H95.6939L95.6699 40.504H95.9579C95.7019 41.336 95.1819 42 94.3979 42.496C93.6139 42.992 92.7259 43.24 91.7339 43.24ZM92.5739 40.936C93.5179 40.936 94.2779 40.608 94.8539 39.952C95.4299 39.28 95.7179 38.272 95.7179 36.928C95.7179 35.584 95.4299 34.584 94.8539 33.928C94.2779 33.272 93.5179 32.944 92.5739 32.944C91.6299 32.944 90.8699 33.272 90.2939 33.928C89.7179 34.584 89.4299 35.584 89.4299 36.928C89.4299 38.272 89.7099 39.28 90.2699 39.952C90.8459 40.608 91.6139 40.936 92.5739 40.936ZM101.937 43V33.904C101.937 33.408 101.921 32.904 101.889 32.392C101.857 31.88 101.809 31.376 101.745 30.88H104.649L104.889 33.28H104.601C104.985 32.432 105.553 31.784 106.305 31.336C107.057 30.872 107.929 30.64 108.921 30.64C110.345 30.64 111.417 31.04 112.137 31.84C112.857 32.64 113.217 33.888 113.217 35.584V43H110.217V35.728C110.217 34.752 110.025 34.056 109.641 33.64C109.273 33.208 108.713 32.992 107.961 32.992C107.033 32.992 106.297 33.28 105.753 33.856C105.209 34.432 104.937 35.2 104.937 36.16V43H101.937ZM116.398 43V30.88H119.398V43H116.398ZM116.23 28.6V25.672H119.566V28.6H116.23ZM128.511 43.24C126.479 43.24 124.887 42.68 123.735 41.56C122.583 40.44 122.007 38.904 122.007 36.952C122.007 35.688 122.255 34.584 122.751 33.64C123.247 32.696 123.935 31.96 124.815 31.432C125.711 30.904 126.751 30.64 127.935 30.64C129.103 30.64 130.079 30.888 130.863 31.384C131.647 31.88 132.239 32.576 132.639 33.472C133.055 34.368 133.263 35.416 133.263 36.616V37.408H124.431V35.824H131.127L130.719 36.16C130.719 35.04 130.479 34.184 129.999 33.592C129.535 33 128.855 32.704 127.959 32.704C126.967 32.704 126.199 33.056 125.655 33.76C125.127 34.464 124.863 35.448 124.863 36.712V37.024C124.863 38.336 125.183 39.32 125.823 39.976C126.479 40.616 127.399 40.936 128.583 40.936C129.271 40.936 129.911 40.848 130.503 40.672C131.111 40.48 131.687 40.176 132.231 39.76L133.119 41.776C132.543 42.24 131.855 42.6 131.055 42.856C130.255 43.112 129.407 43.24 128.511 43.24ZM135.78 43V33.976C135.78 33.464 135.764 32.944 135.732 32.416C135.716 31.888 135.676 31.376 135.612 30.88H138.516L138.852 34.192H138.372C138.532 33.392 138.796 32.728 139.164 32.2C139.548 31.672 140.012 31.28 140.556 31.024C141.1 30.768 141.692 30.64 142.332 30.64C142.62 30.64 142.852 30.656 143.028 30.688C143.204 30.704 143.38 30.744 143.556 30.808L143.532 33.448C143.228 33.32 142.964 33.24 142.74 33.208C142.532 33.176 142.268 33.16 141.948 33.16C141.26 33.16 140.676 33.304 140.196 33.592C139.732 33.88 139.38 34.28 139.14 34.792C138.916 35.304 138.804 35.888 138.804 36.544V43H135.78Z" fill="#787878"/>
        <defs>
        <filter id="filter0_d_1309_8154" x="-4" y="0" width="548" height="80" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1309_8154"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1309_8154" result="shape"/>
        </filter>
        </defs>
        </svg>    
        
        
        </a><a class="arianeItem" href="Catalogue.php">
        <svg width="172" height="76" viewBox="0 0 172 76" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_d_1309_8154)">
        <path d="M283.866 0H-173L-122.973 35.4545L-173 72H283.866L367 32.1818L283.866 0Z" fill="#D9D9D9"/>
        </g>
        <line x1="-0.371094" x2="-0.371094" y2="72" stroke="#BABABA" stroke-width="3"/>
        <line y1="-1.5" x2="72.0103" y2="-1.5" transform="matrix(0.0183822 0.999831 -0.999922 0.0124855 169.634 0)" stroke="#BABABA" stroke-width="3"/>
        <path d="M36 43L43.656 26.08H46.248L54 43H50.856L48.792 38.248L50.04 39.088H39.888L41.184 38.248L39.12 43H36ZM44.928 29.392L41.544 37.408L40.92 36.664H48.984L48.48 37.408L45.024 29.392H44.928ZM60.2188 43.24C59.1628 43.24 58.2268 42.992 57.4108 42.496C56.6108 41.984 55.9868 41.256 55.5388 40.312C55.0908 39.368 54.8668 38.24 54.8668 36.928C54.8668 35.616 55.0908 34.496 55.5388 33.568C55.9868 32.624 56.6108 31.904 57.4108 31.408C58.2268 30.896 59.1628 30.64 60.2188 30.64C61.2268 30.64 62.1148 30.888 62.8828 31.384C63.6668 31.864 64.1868 32.52 64.4428 33.352H64.1308V25.336H67.1308V43H64.1788V40.432H64.4668C64.2108 41.296 63.6908 41.984 62.9068 42.496C62.1388 42.992 61.2428 43.24 60.2188 43.24ZM61.0588 40.936C62.0028 40.936 62.7628 40.608 63.3388 39.952C63.9148 39.28 64.2028 38.272 64.2028 36.928C64.2028 35.584 63.9148 34.584 63.3388 33.928C62.7628 33.272 62.0028 32.944 61.0588 32.944C60.1148 32.944 59.3468 33.272 58.7548 33.928C58.1788 34.584 57.8908 35.584 57.8908 36.928C57.8908 38.272 58.1788 39.28 58.7548 39.952C59.3468 40.608 60.1148 40.936 61.0588 40.936ZM70.3736 43V33.976C70.3736 33.464 70.3576 32.944 70.3256 32.416C70.3096 31.888 70.2696 31.376 70.2056 30.88H73.1096L73.4456 34.192H72.9656C73.1256 33.392 73.3896 32.728 73.7576 32.2C74.1416 31.672 74.6056 31.28 75.1496 31.024C75.6936 30.768 76.2856 30.64 76.9256 30.64C77.2136 30.64 77.4456 30.656 77.6216 30.688C77.7976 30.704 77.9736 30.744 78.1496 30.808L78.1256 33.448C77.8216 33.32 77.5576 33.24 77.3336 33.208C77.1256 33.176 76.8616 33.16 76.5416 33.16C75.8536 33.16 75.2696 33.304 74.7896 33.592C74.3256 33.88 73.9736 34.28 73.7336 34.792C73.5096 35.304 73.3976 35.888 73.3976 36.544V43H70.3736ZM85.488 43.24C83.456 43.24 81.864 42.68 80.712 41.56C79.56 40.44 78.984 38.904 78.984 36.952C78.984 35.688 79.232 34.584 79.728 33.64C80.224 32.696 80.912 31.96 81.792 31.432C82.688 30.904 83.728 30.64 84.912 30.64C86.08 30.64 87.056 30.888 87.84 31.384C88.624 31.88 89.216 32.576 89.616 33.472C90.032 34.368 90.24 35.416 90.24 36.616V37.408H81.408V35.824H88.104L87.696 36.16C87.696 35.04 87.456 34.184 86.976 33.592C86.512 33 85.832 32.704 84.936 32.704C83.944 32.704 83.176 33.056 82.632 33.76C82.104 34.464 81.84 35.448 81.84 36.712V37.024C81.84 38.336 82.16 39.32 82.8 39.976C83.456 40.616 84.376 40.936 85.56 40.936C86.248 40.936 86.888 40.848 87.48 40.672C88.088 40.48 88.664 40.176 89.208 39.76L90.096 41.776C89.52 42.24 88.832 42.6 88.032 42.856C87.232 43.112 86.384 43.24 85.488 43.24ZM97.1004 43.24C96.0604 43.24 95.1004 43.12 94.2204 42.88C93.3564 42.624 92.6284 42.272 92.0364 41.824L92.8764 39.808C93.4844 40.224 94.1564 40.544 94.8924 40.768C95.6284 40.992 96.3724 41.104 97.1244 41.104C97.9244 41.104 98.5164 40.968 98.9004 40.696C99.3004 40.424 99.5004 40.056 99.5004 39.592C99.5004 39.224 99.3724 38.936 99.1164 38.728C98.8764 38.504 98.4844 38.336 97.9404 38.224L95.5404 37.768C94.5164 37.544 93.7324 37.16 93.1884 36.616C92.6604 36.072 92.3964 35.36 92.3964 34.48C92.3964 33.728 92.5964 33.064 92.9964 32.488C93.4124 31.912 93.9964 31.464 94.7484 31.144C95.5164 30.808 96.4124 30.64 97.4364 30.64C98.3324 30.64 99.1724 30.76 99.9564 31C100.756 31.24 101.428 31.6 101.972 32.08L101.108 34.024C100.612 33.624 100.044 33.312 99.4044 33.088C98.7644 32.864 98.1404 32.752 97.5324 32.752C96.7004 32.752 96.0924 32.904 95.7084 33.208C95.3244 33.496 95.1324 33.872 95.1324 34.336C95.1324 34.688 95.2444 34.984 95.4684 35.224C95.7084 35.448 96.0764 35.616 96.5724 35.728L98.9724 36.184C100.044 36.392 100.852 36.76 101.396 37.288C101.956 37.8 102.236 38.504 102.236 39.4C102.236 40.2 102.02 40.888 101.588 41.464C101.156 42.04 100.556 42.48 99.7884 42.784C99.0204 43.088 98.1244 43.24 97.1004 43.24ZM109.124 43.24C108.084 43.24 107.124 43.12 106.244 42.88C105.38 42.624 104.652 42.272 104.06 41.824L104.9 39.808C105.508 40.224 106.18 40.544 106.916 40.768C107.652 40.992 108.396 41.104 109.148 41.104C109.948 41.104 110.54 40.968 110.924 40.696C111.324 40.424 111.524 40.056 111.524 39.592C111.524 39.224 111.396 38.936 111.14 38.728C110.9 38.504 110.508 38.336 109.964 38.224L107.564 37.768C106.54 37.544 105.756 37.16 105.212 36.616C104.684 36.072 104.42 35.36 104.42 34.48C104.42 33.728 104.62 33.064 105.02 32.488C105.436 31.912 106.02 31.464 106.772 31.144C107.54 30.808 108.436 30.64 109.46 30.64C110.356 30.64 111.196 30.76 111.98 31C112.78 31.24 113.452 31.6 113.996 32.08L113.132 34.024C112.636 33.624 112.068 33.312 111.428 33.088C110.788 32.864 110.164 32.752 109.556 32.752C108.724 32.752 108.116 32.904 107.732 33.208C107.348 33.496 107.156 33.872 107.156 34.336C107.156 34.688 107.268 34.984 107.492 35.224C107.732 35.448 108.1 35.616 108.596 35.728L110.996 36.184C112.068 36.392 112.876 36.76 113.42 37.288C113.98 37.8 114.26 38.504 114.26 39.4C114.26 40.2 114.044 40.888 113.612 41.464C113.18 42.04 112.58 42.48 111.812 42.784C111.044 43.088 110.148 43.24 109.124 43.24ZM122.683 43.24C120.651 43.24 119.059 42.68 117.907 41.56C116.755 40.44 116.179 38.904 116.179 36.952C116.179 35.688 116.427 34.584 116.923 33.64C117.419 32.696 118.107 31.96 118.987 31.432C119.883 30.904 120.923 30.64 122.107 30.64C123.275 30.64 124.251 30.888 125.035 31.384C125.819 31.88 126.411 32.576 126.811 33.472C127.227 34.368 127.435 35.416 127.435 36.616V37.408H118.603V35.824H125.299L124.891 36.16C124.891 35.04 124.651 34.184 124.171 33.592C123.707 33 123.027 32.704 122.131 32.704C121.139 32.704 120.371 33.056 119.827 33.76C119.299 34.464 119.035 35.448 119.035 36.712V37.024C119.035 38.336 119.355 39.32 119.995 39.976C120.651 40.616 121.571 40.936 122.755 40.936C123.443 40.936 124.083 40.848 124.675 40.672C125.283 40.48 125.859 40.176 126.403 39.76L127.291 41.776C126.715 42.24 126.027 42.6 125.227 42.856C124.427 43.112 123.579 43.24 122.683 43.24Z" fill="#064082"/>
        <defs>
        <filter id="filter0_d_1309_8154" x="-177" y="0" width="548" height="80" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1309_8154"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1309_8154" result="shape"/>
        </filter>
        </defs>
        </svg>    
        
        
        </a><a class="arianeItem" href="Panier.php">
        <svg width="195" height="76" viewBox="0 0 195 76" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_d_1309_8154)">
        <path d="M111.866 0H-345L-294.973 35.4545L-345 72H111.866L195 32.1818L111.866 0Z" fill="#D9D9D9"/>
        </g>
        <line y1="-1.5" x2="72.0103" y2="-1.5" transform="matrix(0.0183822 0.999831 -0.999922 0.0124855 -2.36621 0)" stroke="#BABABA" stroke-width="3"/>
        <path d="M22.872 43V26.08H30.384C32.24 26.08 33.656 26.528 34.632 27.424C35.608 28.32 36.096 29.552 36.096 31.12C36.096 32.672 35.608 33.904 34.632 34.816C33.656 35.728 32.24 36.184 30.384 36.184H25.968V43H22.872ZM25.968 33.736H30.024C31.048 33.736 31.816 33.512 32.328 33.064C32.84 32.6 33.096 31.952 33.096 31.12C33.096 30.288 32.84 29.648 32.328 29.2C31.816 28.736 31.048 28.504 30.024 28.504H25.968V33.736ZM42.7339 43.24C41.6779 43.24 40.7499 42.992 39.9499 42.496C39.1499 41.984 38.5259 41.256 38.0779 40.312C37.6299 39.368 37.4059 38.24 37.4059 36.928C37.4059 35.616 37.6299 34.496 38.0779 33.568C38.5259 32.624 39.1499 31.904 39.9499 31.408C40.7499 30.896 41.6779 30.64 42.7339 30.64C43.7579 30.64 44.6539 30.896 45.4219 31.408C46.2059 31.904 46.7259 32.576 46.9819 33.424H46.7179L46.9819 30.88H49.8619C49.8139 31.376 49.7659 31.88 49.7179 32.392C49.6859 32.904 49.6699 33.408 49.6699 33.904V43H46.6939L46.6699 40.504H46.9579C46.7019 41.336 46.1819 42 45.3979 42.496C44.6139 42.992 43.7259 43.24 42.7339 43.24ZM43.5739 40.936C44.5179 40.936 45.2779 40.608 45.8539 39.952C46.4299 39.28 46.7179 38.272 46.7179 36.928C46.7179 35.584 46.4299 34.584 45.8539 33.928C45.2779 33.272 44.5179 32.944 43.5739 32.944C42.6299 32.944 41.8699 33.272 41.2939 33.928C40.7179 34.584 40.4299 35.584 40.4299 36.928C40.4299 38.272 40.7099 39.28 41.2699 39.952C41.8459 40.608 42.6139 40.936 43.5739 40.936ZM52.9367 43V30.88H55.9367V43H52.9367ZM52.7687 28.6V25.672H56.1047V28.6H52.7687ZM65.0505 43.24C63.0185 43.24 61.4265 42.68 60.2745 41.56C59.1225 40.44 58.5465 38.904 58.5465 36.952C58.5465 35.688 58.7945 34.584 59.2905 33.64C59.7865 32.696 60.4745 31.96 61.3545 31.432C62.2505 30.904 63.2905 30.64 64.4745 30.64C65.6425 30.64 66.6185 30.888 67.4025 31.384C68.1865 31.88 68.7785 32.576 69.1785 33.472C69.5945 34.368 69.8025 35.416 69.8025 36.616V37.408H60.9705V35.824H67.6665L67.2585 36.16C67.2585 35.04 67.0185 34.184 66.5385 33.592C66.0745 33 65.3945 32.704 64.4985 32.704C63.5065 32.704 62.7385 33.056 62.1945 33.76C61.6665 34.464 61.4025 35.448 61.4025 36.712V37.024C61.4025 38.336 61.7225 39.32 62.3625 39.976C63.0185 40.616 63.9385 40.936 65.1225 40.936C65.8105 40.936 66.4505 40.848 67.0425 40.672C67.6505 40.48 68.2265 40.176 68.7705 39.76L69.6585 41.776C69.0825 42.24 68.3945 42.6 67.5945 42.856C66.7945 43.112 65.9465 43.24 65.0505 43.24ZM72.3429 43V33.904C72.3429 33.408 72.3269 32.904 72.2949 32.392C72.2629 31.88 72.2149 31.376 72.1509 30.88H75.0549L75.2949 33.28H75.0069C75.3429 32.448 75.8549 31.8 76.5429 31.336C77.2469 30.872 78.0789 30.64 79.0389 30.64C79.9989 30.64 80.7909 30.872 81.4149 31.336C82.0549 31.784 82.5029 32.488 82.7589 33.448H82.3749C82.7109 32.584 83.2629 31.904 84.0309 31.408C84.7989 30.896 85.6789 30.64 86.6709 30.64C88.0309 30.64 89.0469 31.04 89.7189 31.84C90.3909 32.64 90.7269 33.888 90.7269 35.584V43H87.7269V35.704C87.7269 34.744 87.5669 34.056 87.2469 33.64C86.9269 33.208 86.4149 32.992 85.7109 32.992C84.8789 32.992 84.2229 33.288 83.7429 33.88C83.2629 34.456 83.0229 35.24 83.0229 36.232V43H80.0229V35.704C80.0229 34.744 79.8629 34.056 79.5429 33.64C79.2229 33.208 78.7109 32.992 78.0069 32.992C77.1749 32.992 76.5189 33.288 76.0389 33.88C75.5749 34.456 75.3429 35.24 75.3429 36.232V43H72.3429ZM99.7849 43.24C97.7529 43.24 96.1609 42.68 95.0089 41.56C93.8569 40.44 93.2809 38.904 93.2809 36.952C93.2809 35.688 93.5289 34.584 94.0249 33.64C94.5209 32.696 95.2089 31.96 96.0889 31.432C96.9849 30.904 98.0249 30.64 99.2089 30.64C100.377 30.64 101.353 30.888 102.137 31.384C102.921 31.88 103.513 32.576 103.913 33.472C104.329 34.368 104.537 35.416 104.537 36.616V37.408H95.7049V35.824H102.401L101.993 36.16C101.993 35.04 101.753 34.184 101.273 33.592C100.809 33 100.129 32.704 99.2329 32.704C98.2409 32.704 97.4729 33.056 96.9289 33.76C96.4009 34.464 96.1369 35.448 96.1369 36.712V37.024C96.1369 38.336 96.4569 39.32 97.0969 39.976C97.7529 40.616 98.6729 40.936 99.8569 40.936C100.545 40.936 101.185 40.848 101.777 40.672C102.385 40.48 102.961 40.176 103.505 39.76L104.393 41.776C103.817 42.24 103.129 42.6 102.329 42.856C101.529 43.112 100.681 43.24 99.7849 43.24ZM107.077 43V33.904C107.077 33.408 107.061 32.904 107.029 32.392C106.997 31.88 106.949 31.376 106.885 30.88H109.789L110.029 33.28H109.741C110.125 32.432 110.693 31.784 111.445 31.336C112.197 30.872 113.069 30.64 114.061 30.64C115.485 30.64 116.557 31.04 117.277 31.84C117.997 32.64 118.357 33.888 118.357 35.584V43H115.357V35.728C115.357 34.752 115.165 34.056 114.781 33.64C114.413 33.208 113.853 32.992 113.101 32.992C112.173 32.992 111.437 33.28 110.893 33.856C110.349 34.432 110.077 35.2 110.077 36.16V43H107.077ZM126.722 43.24C125.282 43.24 124.194 42.864 123.458 42.112C122.722 41.36 122.354 40.232 122.354 38.728V33.136H120.026V30.88H122.354V27.784L125.354 27.016V30.88H128.594V33.136H125.354V38.536C125.354 39.368 125.514 39.952 125.834 40.288C126.154 40.624 126.594 40.792 127.154 40.792C127.458 40.792 127.714 40.768 127.922 40.72C128.146 40.672 128.362 40.608 128.57 40.528V42.904C128.298 43.016 127.994 43.096 127.658 43.144C127.338 43.208 127.026 43.24 126.722 43.24Z" fill="#717171"/>
        <defs>
        <filter id="filter0_d_1309_8154" x="-349" y="0" width="548" height="80" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1309_8154"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1309_8154" result="shape"/>
        </filter>
        </defs>
        </svg>    
        
        </a>
    </nav>
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
            


<!-- 
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
                                            
                                            <div><button id="poubelle" onclick="supprimerProd(<?php echo $idPanier ?> , <?php echo $prodUnit['codeproduit']?>)"><img src="img/Icon_poubelle.svg" alt="poubelle" title="poubelle"/></button></div><?php
                                            echo "</div></div>";
                                    }

                                ?>

                    </article>
                </section> -->

                <!-- <section>
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
                    <nav>
                        <button class="bouton" onclick="annuler()">Annuler</button>
                        <button class="btnJaune"  id="btnPayer">Payer</button>
                        
                    </nav>
                </section> -->

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
    //let btnPayer = document.getElementById("btnPayer");
    let btnModifAdr = document.getElementById("modifAdr");
    let btnValiderAdr = document.querySelector("#adresseLivraison .btnJaune");
    //btnPayer.addEventListener("click", validerPaiement);
    btnModifAdr.addEventListener("click", modifierAdr);


    // function sendGet(url, onSuccess, onError) {
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('GET', url, true);
    //     xhr.onload = function() {
    //         if (xhr.status >= 200 && xhr.status < 300) {
    //             if (typeof onSuccess === 'function') onSuccess(xhr);
    //         } else {
    //             if (typeof onError === 'function') onError(xhr);
    //         }
    //     };
    //     xhr.onerror = function() {
    //         if (typeof onError === 'function') onError(xhr);
    //     };
    //     xhr.send();
    // }
    // function supprimerProd(idPanier, codeProd){
    //     if(confirm("Voulez vous supprimer cet article ?")){
    //     url = "modifPanier.php?Action=supprimerProduit&Panier=" + encodeURIComponent(idPanier) + "&Produit=" + encodeURIComponent(codeProd);
    //     sendGet(url,function() { 
    //         location.reload(); 
    //     },
    //     function() { 
    //         alert('Erreur côté serveur.');
    //      }
    //     )

    // }
    // }
    function annuler(){
        window.location = "Panier.php";
    }
    // function validerPaiement(evt){

    //     let adrValide = true;
    //     let banqueValide = true;
    //     let champsAdresse = document.querySelectorAll("#adresseLivraison :required");
    //     //let champsBanque = document.querySelectorAll("#infosPaiement :required");
    //     for(let i =0 ; i < champsAdresse.length ; i++){
    //         if(champsAdresse[i].value == ""){
    //             adrValide = false;
    //             document.getElementById("AdrInvalide").removeAttribute("hidden");


    //         }
    //     }
    //     //Il faut que les champs soient modifiables pour être pris en compte dans le $_POST
    //     for(let i = 0 ; i < champsAdresse.length ; i++){
    //         champsAdresse[i].removeAttribute("disabled");
    //     }
    //     for(let i = 0 ; i < champsBanque.length ; i++){
    //         if(champsBanque[i].value == ""){
    //             banqueValide = false;
    //             document.getElementById("BanqueInvalide").removeAttribute("hidden");
    //         }
    //     }
    //     if(banqueValide == false || adrValide == false){
    //         evt.preventDefault();
    //         console.log("non");
    //     }
    //     else{
    //         document.getElementById("formulaireAdr").submit();           
           
    //     }

    // }
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
    
    // function submitTout(){
    //     const formulaireAdr = document.getElementById("formulaireAdr");
    //     const formulaireBanque = document.getElementById("formulaireBanque");
    //     let envoiPost = [];
    //     for(let i = 0 ; i < formulaireBanque.elements.length ; i++){
    //         envoiPost.push(encodeURIComponent(formulaireBanque.elements[i].name) + "=" +
    //         encodeURIComponent(formulaireBanque.elements[i].value));
    //     }       
    //     var xhr = new XMLHttpRequest();
    //     xhr.open("POST", "enregPaiement.php", true);
    //     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //     xhr.send(envoiPost.join("&"));

    //     formulaireAdr.submit();
    //     console.log(envoiPost);

    // }

    // async function submitAll() {
    // const formulaireAdr = document.getElementById("formulaireAdr");
    // const formulaireBanque = document.getElementById("formulaireBanque");

    // const res = await fetch(formulaireAdr.action, {
    //     method: formulaireAdr.method,
    //     headers: { "content-type": formulaireAdr.enctype },
    //     body: new FormData(formulaireAdr),

    // });
    // if (!res.ok) {
    //     const err = new Error(`DB Update Failed! Status: ${res.status}`);
    //     const isJSON = res.headers.get("content-type") == "application/json";
    //     err.body = await (isJSON ? res.json() : res.text());
    //     throw err;
    // }

    // formulaireBanque.submit();
    // }
</script>
</body>

</html>
