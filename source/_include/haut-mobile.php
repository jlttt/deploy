<div class="container-mobile">
	<!-- Push Wrapper -->
	<div class="mp-pusher" id="mp-pusher">

       <!-- mp-menu -->
        <nav id="mp-menu" class="mp-menu">
            <div class="mp-level">

                <ul<?= @$ongletActive!=NULL ? ' class="'.$ongletActive.'"' : NULL; ?>>
                    <li class="arrow-left menu-head">
                        <a href="<?php echo LIEN; ?>" title="<?php echo sprintf(RETOUR_ACCUEIL, NOM_SITE); ?>"><?php echo NOM_SITE; ?></a>
                    </li>
                    <?php if (is_callable($domainConfiguration['main-menu'])) {
                        $mainMenu = $domainConfiguration['main-menu']();
                    } else {
                        $mainMenu = $domainConfiguration['main-menu'];
                    }
                    foreach ($mainMenu as $item) {
                        if ($item['type'] != 'single-item') {
                            $liAttributes = ' class="arrow-left"';
                            $mainLinkHref = 'javascript:void(0)';
                        } else {
                            $liAttributes = '';
                            $mainLinkHref = $item['href'];
                        } ?>
                        <li<?= $liAttributes; ?>>
                            <a href="<?= $mainLinkHref; ?>" title="<?= $item['label']; ?>"><?= $item['label']; ?></a>
                            <?php if ($item['type'] != 'single-item') { ?>
                                <div class="mp-level">
                                    <h2><?= $item['label']; ?></h2>
                                    <a class="mp-back" href="javascript:void(0);"><?= RETOUR_MENU; ?></a>
                                    <ul>
                                        <?php foreach($item['source'] as $subItem) { ?>
                                            <li><a href="<?= $subItem['href']; ?>" title="<?= $subItem['label']; ?>"><?= $subItem['label']; ?></a></li>
                                        <?php } ?>
                                        <?php if (isset($item['secondary-source'])) { ?>
                                            <li class="arrow-left">
                                                <a href="" title=""><?= PAR_MARQUES; ?></a>
                                                <div class="mp-level">
                                                    <h2><?= PAR_MARQUES; ?></h2>
                                                    <a class="mp-back" href="javascript:void(0);"><?= RETOUR_MENU; ?></a>
                                                    <ul>
                                                        <?php foreach($item['secondary-source'] as $subItem) { ?>
                                                            <li><a href="<?= $subItem['href']; ?>" title="<?= $subItem['label']; ?>"><?= $subItem['label']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <!--<li>
                        <a href="" title="">Pulvérisateurs</a>
                        <div class="mp-level">
                            <h2>Pulvérisateurs</h2>
                            <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                            <ul>
                                <li><a href="<?= LIEN; ?>" title="">Gâchette</a></li>
                                <li><a href="<?= LIEN; ?>" title="">Petits pression préalable</a></li>
                                <li><a href="<?= LIEN; ?>" title="">Pression préalable</a></li>
                                <li><a href="<?= LIEN; ?>" title="">Pression entretenue</a></li>
                                <li><a href="<?= LIEN; ?>" title="">Electriques</a></li>
                                <li><a href="<?= LIEN; ?>" title="">Seringue</a></li>

                                <li class="arrow-left">
                                    <a href="" title="">Par marques</a>
                                    <div class="mp-level">
                                        <h2>Les marques</h2>
                                        <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                                        <ul>
                                            <li><a href="<?= LIEN; ?>" title="">Berthoud Jardin</a></li>
                                            <li><a href="<?= LIEN; ?>" title="">Cooper Pegler</a></li>
                                            <li><a href="<?= LIEN; ?>" title="">Tecnoma</a></li>
                                            <li><a href="<?= LIEN; ?>" title="">Laser</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="arrow-left">
                        <a href="#">Dosage</a>
                        <div class="mp-level">
                            <h2>Dosage</h2>
                            <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                                <ul>
                                    <li class="arrow-left">
                                        <a href="<?= LIEN; ?>" title="">Systèmes sur véhicules</a>
                                        <div class="mp-level">
                                            <h2>Systèmes sur véhicules</h2>
                                            <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                                            <ul>
                                                <li><a href="<?= LIEN; ?>" title="">Triton</a></li>
                                                <li><a href="<?= LIEN; ?>" title="">Palléon</a></li>
                                                <li><a href="<?= LIEN; ?>" title="">Caméléon</a></li>
                                                <li><a href="<?= LIEN; ?>" title="">Guecko</a></li>
                                                <li><a href="<?= LIEN; ?>" title="">Iguane</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="<?= LIEN; ?>" title="">Systèmes sur berces</a>
                                        <div class="mp-level">
                                            <h2>Systèmes sur berces</h2>
                                            <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                                            <ul>
                                                <li><a href="<?= LIEN; ?>" title="">Salamandre</a></li>
                                                <li><a href="<?= LIEN; ?>" title="">MPVE</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="<?= LIEN; ?>" title="">Systèmes sur remorques</a></li>
                                    <li><a href="<?= LIEN; ?>" title="">Systèmes fixes</a></li>
                                    <li><a href="<?= LIEN; ?>" title="">Systèmes autonomes</a></li>
                                </ul>
                    </li>
                    <li class="arrow-left">
                        <a href="#">Dosage</a>
                        <div class="mp-level">
                            <h2>Dosage</h2>
                            <a class="mp-back" href="#"><?= RETOUR_MENU; ?></a>
                            <ul>
                                <li><a href="<?= LIEN; ?>" title=""></a></li>
                                <li><a href="<?= LIEN; ?>" title=""></a></li>
                                <li><a href="<?= LIEN; ?>" title=""></a></li>
                            </ul>
                        </div>
                    </li>-->
                </ul>

            </div>
        </nav>
        <!-- /mp-menu -->

        <div class="scroller"><!-- this is for emulating position fixed of the nav -->
            <div class="scroller-inner">

    			<header class="header-container">
                    <div id="mobile-header">
                        <a id="button-menu" class="button" href="#">
                            <img src="<?= RACINE; ?>_image/mobile/menu.svg" height="48" alt="">
                        </a>
                        <a href="<?= LIEN; ?>" class="logosite">
                            <img src="<?= RACINE; ?>_image/header-logo-ctd-x2.png" height="38" alt="CTD Pulverisation">
                        </a>
                        <?php if (count($domainConfiguration['languages']) > 1) { ?>
                            <a href="<?=RACINE; ?>en/" class="header-lien">
                                <img src="<?= RACINE; ?>_image/mobile/en.svg" width="44" height="44" alt="">
                            </a>
                        <?php } ?>
                        <a href="<?= $urlmaps; ?>" class="header-lien">
                            <img src="<?= RACINE; ?>_image/mobile/map.svg" width="44" height="44" alt="">
                        </a>
                        <a href="tel:<?= TEL_SOCIAL; ?>" class="header-lien">
                            <img src="<?= RACINE; ?>_image/mobile/telephone.svg" width="44" height="44" alt="">
                        </a>
                    </div>
                </header>

                <p class="slogan"><?= LEAD_CTD; ?></p>

                <div class="page-color ctd-color">
