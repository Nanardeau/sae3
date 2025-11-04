<?php
if($_POST){
    echo "c envoyé";
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer compte</title>
    <link href="./css/style/creaCompteFront.css" rel="stylesheet">
</head>
<body>
    <header></header>
    <main>
        <form action="enreg.php" method="post">
        <h1>Création de compte<h1>
        <label for="pseudo">Identifiant *</label>
        <input type="text" name="pseudo"/> 

        </form>   
    </main>
    <footer></footer>
</body>
</html>