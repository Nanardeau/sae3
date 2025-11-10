<nav class="nav-cat tab-only">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="openOverlay()">
                    <path d="M1.5 1.5H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 10.7993H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 20.0986H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            <?php
                $catCurr = null;
                $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  

                foreach ($listCat as $libcat) {

                    $catCurr = $libcat['libcat'];
                ?>

                <a href="#"><?php echo $catCurr;?></a>
                <?php
                }
                ?>
        </nav>
        <div id="overlayMenuCat" class="overlayMenuCat tab-only">
            <div class="overlayContentCat">
                <ul>
                    <?php
                    $catCurr = null;
                    $listCat = $bdd->query('SELECT DISTINCT libCat FROM SousCat'); //Nom de la catégorie  

                    foreach ($listCat as $libcat) {

                        $catCurr = $libcat['libcat'];
                    ?>

                    <li><a href="#"><?php echo $catCurr;?></a></li>
                    <?php

                    $listSousCats = $bdd->query("SELECT DISTINCT libSousCat FROM SousCat WHERE libCat = '" . $catCurr . "'");

                    // Vérifier s'il y a des sous-catégories
                    if ($listSousCats->rowCount() > 0) {
                        echo "<ul>";
                        foreach ($listSousCats as $libSousCat) {
                            $sousCatCurr = $libSousCat['libsouscat'];
                            echo "<li><a href='#'>" . $sousCatCurr . "</a></li>";
                        }
                        echo "</ul>";
                    }

                    echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>