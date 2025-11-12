<nav class="nav-cat tab-only">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="openOverlay()">
                    <path d="M1.5 1.5H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 10.7993H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M1.5 20.0986H23.65" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            <div>
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
            </div>
            <h2>></h2>
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

        <div id="overlayMenuCatMob" class="overlayMenuCatMob mob-only">
            <div class="overlayContentCatMob">
                <div class="identification">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" class="croix" onclick="closeOverlayMobile()">
                        <path d="M26.5 1.5L1.5 26.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1.5 1.5L26.5 26.5" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <a href="#">Identifiez-vous</a>
                    <svg width="21" height="23" viewBox="0 0 21 23" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-user">
                        <path d="M10.3333 12.6667C13.555 12.6667 16.1667 10.055 16.1667 6.83333C16.1667 3.61167 13.555 1 10.3333 1C7.11167 1 4.5 3.61167 4.5 6.83333C4.5 10.055 7.11167 12.6667 10.3333 12.6667Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.6667 21.9998C19.6667 19.5245 18.6833 17.1505 16.933 15.4002C15.1826 13.6498 12.8087 12.6665 10.3333 12.6665C7.85798 12.6665 5.48401 13.6498 3.73367 15.4002C1.98333 17.1505 1 19.5245 1 21.9998" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                <p>Parcourir</p><br>
                <h3>Alizon</h3>
                </div>
                <a href="" class="page-acc">Page d'accueil d'Alizon
                    <svg width="30" height="32" viewBox="0 0 30 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.5 30.001V18.001C19.5 17.6032 19.342 17.2216 19.0607 16.9403C18.7794 16.659 18.3978 16.501 18 16.501H12C11.6022 16.501 11.2206 16.659 10.9393 16.9403C10.658 17.2216 10.5 17.6032 10.5 18.001V30.001" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1.5 13.5007C1.4999 13.0643 1.595 12.6332 1.77868 12.2373C1.96236 11.8414 2.2302 11.4904 2.5635 11.2087L13.0635 2.20872C13.605 1.75108 14.291 1.5 15 1.5C15.709 1.5 16.395 1.75108 16.9365 2.20872L27.4365 11.2087C27.7698 11.4904 28.0376 11.8414 28.2213 12.2373C28.405 12.6332 28.5001 13.0643 28.5 13.5007V27.0007C28.5 27.7964 28.1839 28.5594 27.6213 29.122C27.0587 29.6846 26.2956 30.0007 25.5 30.0007H4.5C3.70435 30.0007 2.94129 29.6846 2.37868 29.122C1.81607 28.5594 1.5 27.7964 1.5 27.0007V13.5007Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
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