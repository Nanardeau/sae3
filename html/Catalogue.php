<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alizon</title>
    <link href="./css/style/catalogue.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header></header>
    <main>
        <h1>Toutes les catégories</h1>
        <div class="separateur"></div>

        <h2>
            Catégorie <?php //Choisir la catégorie  
                        ?>
        </h2>
        <article>
        <?php 
        for($i = 0; $i < 10;$i++){

        ?>
            <div class="card">
                <figcaption>
                    <img src="./img/img_test.jpg"></img>
                    <caption>libelProduit</caption>
                </figcaption>
                <p class="prix">test</p>
            </div>
        <?php
            }
        ?>
        <article>


    </main>
    <footer></footer>
</body>

</html>