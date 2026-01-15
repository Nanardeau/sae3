                <section id="secRecap">
                    <?php 

                    $nbProd = ($bdd->query("SELECT ALL SUM(qteProd) somme from alizon.ProdUnitPanier where idPanier = '".$idPanier."'")->fetch())["somme"];
                    ?>
                    <h2>Récapitulatif ( <?php echo number_format((int)$nbProd, 0, '.', '')?> articles ) </h2>
                    <article id="recapitulatif">

                            <?php 
                            $i = 1;

                            $produits = $bdd->query("SELECT ALL * FROM alizon.ProdUnitPanier WHERE idPanier = '".$idPanier."'")->fetchAll();
                            
                            foreach($produits as $prodUnit){
                                ?><div class="libelleProdRecap"><?php
                                $detailProd = $bdd->query("SELECT * FROM alizon.Produit WHERE codeProduit = '".$prodUnit["codeproduit"]."'")->fetch();
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
                </section>

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
                </section>