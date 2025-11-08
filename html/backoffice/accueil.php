<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon BackOffice</title>
    <link rel="stylesheet" href="../css/style/backend.css" type="text/css">
</head>
<body>
    <?php include '../includes/backoffice/header.php'; ?>
    <main>
        <div class="btnAcceuil">
            <a href="ajouterproduit.php">Ajouter un produit</a>
            <a href="cataloguevendeur.php">Consulter la liste des produits</a>
        </div>
    </main>
    <aside>
        <h1>Les réductions</h1>
        <div>
            <a href="article.php" class="reduction">
                <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.95415 7.94658C2.80088 7.25617 2.82442 6.53824 3.02257 5.85935C3.22073 5.18047 3.58709 4.5626 4.08769 4.06305C4.58829 3.5635 5.20692 3.19843 5.88622 3.00169C6.56552 2.80496 7.2835 2.78293 7.97359 2.93764C8.35341 2.34361 8.87667 1.85475 9.49512 1.51612C10.1136 1.17749 10.8073 1 11.5124 1C12.2175 1 12.9112 1.17749 13.5297 1.51612C14.1481 1.85475 14.6714 2.34361 15.0512 2.93764C15.7423 2.78225 16.4615 2.80419 17.1419 3.0014C17.8223 3.19861 18.4418 3.5647 18.9427 4.0656C19.4436 4.56651 19.8097 5.18596 20.0069 5.86635C20.2041 6.54673 20.226 7.26594 20.0706 7.95708C20.6647 8.3369 21.1535 8.86016 21.4922 9.47861C21.8308 10.0971 22.0083 10.7908 22.0083 11.4959C22.0083 12.201 21.8308 12.8947 21.4922 13.5132C21.1535 14.1316 20.6647 14.6549 20.0706 15.0347C20.2253 15.7248 20.2033 16.4428 20.0066 17.1221C19.8098 17.8014 19.4448 18.42 18.9452 18.9206C18.4457 19.4212 17.8278 19.7875 17.1489 19.9857C16.47 20.1839 15.7521 20.2074 15.0617 20.0541C14.6824 20.6504 14.1587 21.1414 13.5392 21.4815C12.9197 21.8217 12.2244 22 11.5176 22C10.8109 22 10.1156 21.8217 9.49608 21.4815C8.87658 21.1414 8.35292 20.6504 7.97359 20.0541C7.2835 20.2088 6.56552 20.1868 5.88622 19.9901C5.20692 19.7933 4.58829 19.4283 4.08769 18.9287C3.58709 18.4292 3.22073 17.8113 3.02257 17.1324C2.82442 16.4535 2.80088 15.7356 2.95415 15.0452C2.35555 14.6664 1.86249 14.1423 1.52083 13.5217C1.17916 12.9012 1 12.2043 1 11.4959C1 10.7875 1.17916 10.0906 1.52083 9.47003C1.86249 8.84947 2.35555 8.3254 2.95415 7.94658Z" fill="#FF4444" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.5012 8.20062L8.20062 14.5012Z" fill="#FF4444"/>
                    <path d="M14.5012 8.20062L8.20062 14.5012" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.20062 8.20062H8.21112Z" fill="#FF4444"/>
                    <path d="M8.20062 8.20062H8.21112" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.5012 14.5012H14.5117Z" fill="#FF4444"/>
                    <path d="M14.5012 14.5012H14.5117" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <img src="" alt="Du cidre">
                <p class="nomArticle">Cidre</p>
                <p class="prixBase">5.00€</p>
                <p class="prixReduc">2.50€</p>
                <p class="pourcentReduc">-50%</p>
                <a href="modifArticle.php">
                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="15.0422" cy="15.0422" r="15.0422" fill="#6CA6E9"/>
                        <path d="M14.761 21.7632H20.9583H14.761Z" fill="#6CA6E9"/>
                        <path d="M14.761 21.7632H20.9583" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.0498 11.471C21.432 11.0888 21.6468 10.5705 21.6469 10.0299C21.647 9.48937 21.4323 8.97093 21.0501 8.58866C20.6679 8.20638 20.1496 7.99158 19.609 7.99152C19.0685 7.99145 18.5501 8.20612 18.1678 8.58829L8.51832 18.2401C8.35044 18.4074 8.2263 18.6135 8.1568 18.8402L7.20169 21.9868C7.183 22.0494 7.18159 22.1158 7.19761 22.179C7.21362 22.2423 7.24646 22.3001 7.29264 22.3462C7.33883 22.3923 7.39663 22.425 7.45992 22.4409C7.52322 22.4569 7.58963 22.4553 7.65213 22.4366L10.7995 21.4821C11.0259 21.4133 11.2319 21.2899 11.3996 21.1228L21.0498 11.471Z" fill="#6CA6E9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </a>
    </aside>
</body>
</html>