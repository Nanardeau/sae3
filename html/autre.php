<!-- mettre dans session "enachat=1" et changer dans connexion client le bouton !
$_SESSION["enAchat"] = 1;


##DANS CONNEXION##
if(isset($_SESSION["enAchat"])){
    exit(header("location:paiement.php"));
} 
else{
    exit(header("location:index.php));
}
--> 

<div popover="auto" id="overlayAchat">
            <h4>Ajouter au panier</h4>
            <figure>
                <a href="test.php"><img src="<?php echo $img ?>" /></a>
                <figcaption><?php echo $libArt ?></figcaption>
                <p>Souhaitez vous acheter instantanément ce produit ou l'ajouter au panier?</p>
                <div class="compteur">
                <?php 
                        if($qteProd == 1){?>
                            <button class="btn-supp" onclick="supprimerPanier(<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            
                        <?php }else{?>
                        
                    <button class="btn-moins" onclick="modifProduit(this,<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg></button>
                    <?php
                    }
                    ?>
                    <p class="nbArt"><?php echo $qteProd?></p>
                    <button class="btn-plus" onclick="modifProduit(this,<?php echo $infoPanier['idpanier']?>,<?php echo $liste['codeproduit']?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></button>
                </div>
            </figure>
            <button href>Acheter</button>
            <button href="AjouterAuPanier.php?codeProd=<?php echo $codeProduit?>">Ajouter au panier</button>
        </div>
    
         <a class="button" popovertarget="overlayAchat" >Ajouter au panier</a>
