<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style/consulter_fiche_produit_vendeur.css" >
        <link rel="stylesheet" type="text/css" href="../css/style/header_back.css" >
        <title>alizon</title>
    </head>
    <body>
        
        <?php include '../includes/backoffice/header.php';?>
        <main>
            <?php include 'includes/menu_cat.php';?>
            <div>
                <img src="../img/cafe.jpg" alt="image du produit" width="340px" height="340px">
                <section>
                    <h1>Libelle Produit</h1>
                
                    <div>
                        <img src="" alt="etoile">
                        <input type="button" value="Afficher les commentaires" class="buton_commentaire">
                    </div>
                    <p>
                        description produit..................................................................
                        ...............
                    </p>
                    <hr>
                    <div>
                        <h2>00.00 €</h2>
                        <input type="button" value="Modifier le produit" class="buton_modif">
                        <input type="button" value="Retirer du catalogue" class="buton_ret_cat">
                    </div>
                </section>
                
            </div>
            <h2>Caractéristique</h2>
        </main>

        <?php

        
        
        
        ?>
    </body>
</html>