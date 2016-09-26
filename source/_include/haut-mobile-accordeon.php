<div class="mp-pusher" id="mp-pusher">

    <div class="scroller">
        <div class="scroller-inner">

            <header>
                <div class="toggle-menu">
                    <a href="#" id="trigger" class="menu-trigger header-lien">
                        <span class="menu-icon"><i class="icon-menu"></i> <strong class="icon-closed"></strong></span>
                    </a>
                </div>
                <a href="<?php echo LIEN; ?>" class="logosite">
                    <img src="<?php echo RACINE; ?>_image/header-logo-ctd-x2.png" height="38" alt="CTD Pulverisation">
                </a>
                <a href="#" class="header-lien">
                    <img src="<?php echo RACINE; ?>_image/mobile/en.svg" width="44" height="44" alt="">
                </a>
                <a href="<?= $urlmaps; ?>" class="header-lien">
                    <img src="<?php echo RACINE; ?>_image/mobile/map.svg" width="44" height="44" alt="">
                </a>
                <a href="tel:<?php echo TEL_SOCIAL; ?>" class="header-lien">
                    <img src="<?php echo RACINE; ?>_image/mobile/telephone.svg" width="44" height="44" alt="">
                </a>
            </header>
            <p class="slogan"><?php echo LEAD_CTD; ?></p>

            <nav class="navbar content">
                <div class="content-menu">
                    <ul>
                        <li id="mn-acc"><a href="<?php echo LIEN; ?>" title="<?php echo sprintf(RETOUR_ACCUEIL, NOM_SITE); ?>"><?php echo ACCUEIL; ?></a></li>
                        <li class="arrow-left"> <a href="#"><?php echo QSN; ?></a> </li>
                    </ul>
                </div>
            </nav>
