<?php if (!$smartphone) { ?>
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar">
            <div class="navbar-header<?= $domainConfiguration['navigationClass']; ?>">

                <div class="container noPaddingGauche noPaddingDroite">
                    <div class="content-logo col-md-2">
                        <?php if (isset($ongletActive) && $ongletActive == "mn-acc") { ?>
                            <h1 class="logosite"><a href="<?php echo LIEN; ?>"
                                                    title="<?php echo sprintf(RETOUR_ACCUEIL, NOM_SITE); ?>"><?php echo NOM_SITE; ?></a>
                            </h1>
                        <?php } else { ?>
                            <a href="<?php echo LIEN; ?>" title="<?php echo sprintf(RETOUR_ACCUEIL, NOM_SITE); ?>"
                               class="logosite"><?php echo NOM_SITE; ?></a>
                        <?php } ?>
                    </div>

                    <div class="col-md-10 noPaddingGauche">
                        <div class="left content-slogan"> <?= $domainConfiguration['slogan']; ?> </div>

                        <?php if ($domainConfiguration['displayAddress']) { ?>
                            <div class="right content-adresse">
                                <span class="picto-map"></span>
                                <span><?= str_replace(' - ', "<br />", SIEGE_SOCIAL) . "<strong> - " . SIEGE_PAYS . "</strong>"; ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($domainConfiguration['displayBackLink']) { ?>
                            <div class="right content-ctd">
                                <span><a href="<?= $domainConfigurations['ctd']['url']; ?>"
                                         target="_blank"><?= DECOUVREZ . "<br /> <strong>" . LE_GROUPE_CTD . "</strong>"; ?></a></span>
                            </div>
                        <?php } ?>

                        <div class="right content-phone">
                            <span class="picto-phone"></span>
                            <span><?= APPELEZ_NOUS . "<br /> <strong>" . TEL_SOCIAL . "</strong>"; ?></span>
                        </div>

                        <?php if (count($domainConfiguration['languages']) > 1) { ?>
                            <div class="right content-lang">
                                <div class="label-lang">
                                    <a href="javascript:void(0);" class="lien-infos">
                                        <strong class="flag fr"></strong>
                                        <span class="icon-drop"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                    </a>
                                    <ul class="liste-lang">
                                        <li><a href="<?= RACINE ?>en/" title="English version"><strong
                                                    class="flag en"></strong> English <i
                                                    class="fa fa-check" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- END - col-md-10 -->
                </div>
                <!-- END - container -->

            </div>
            <!-- END - navbar-header -->

            <div class="content-menu">
                <div class="container">
                    <div id="menu-nav">
                        <ul class="ss-menu<?php echo @$ongletActive != NULL ? ' ' . $ongletActive : NULL; ?>">
                            <?php if (is_callable($domainConfiguration['main-menu'])) {
                                $mainMenu = $domainConfiguration['main-menu']();
                            } else {
                                $mainMenu = $domainConfiguration['main-menu'];
                            }
                            foreach ($mainMenu as $item) {
                                $class = $item['type'] != 'single-item' ? 'fleche' : '';
                                if (isset($categoryForMenu) && $categoryForMenu->getUrl() == $item['href']) {
                                    $class .= ' onglet-actif';
                                }
                                ?>
                                <li class="<?= $class; ?>"> <!-- Ajouter class onglet-actif au click -->
                                    <?php if (!empty($item['href'])) {
                                        $linkAttributes = ' href="' . $item['href'] . '"';
                                    } else {
                                        $linkAttributes = '';
                                    } ?>
                                    <a<?= $linkAttributes; ?>><?= $item['label']; ?> <span></span></a>
                                    <?php
                                    switch ($item['type']) {
                                        case 'two-level-menu': ?>
                                            <div class="ss-menu-full">
                                                <?php
                                                if (is_callable($item['source'])) {
                                                    $source = $item['source']();
                                                } else {
                                                    $source = $item['source'];
                                                }
                                                ?>
                                                <?php foreach ($source as $column) { ?>
                                                    <ul>
                                                        <? foreach ($column as $subItem) { ?>
                                                            <li>
                                                                <a href="<?= $subItem['href']; ?>"><?= $subItem['label']; ?></a>
                                                                <ul>
                                                                    <?php foreach ($subItem['source'] as $subSubItem) { ?>
                                                                        <li>
                                                                            <a href="<?= $subSubItem['href']; ?>"><?= $subSubItem['label']; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                            <?php
                                            break;
                                        case 'double-menu': ?>
                                            <div class="ss-menu-trie">
                                                <div class="content">
                                                    <ul>
                                                        <li>
                                                            <a href="javascript:void(0)"><?= PAR_TYPES ?></a>
                                                            <ul>
                                                                <?php foreach ($item['source'] as $subItem) { ?>
                                                                    <li>
                                                                        <a href="<?= $subItem['href']; ?>"><?= $subItem['label']; ?></a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    <ul>
                                                        <li>
                                                            <a href="javascript:void(0)"><?= PAR_MARQUES ?></a>
                                                            <ul>
                                                                <?php foreach ($item['secondary-source'] as $subItem) { ?>
                                                                    <li>
                                                                        <a href="<?= $subItem['href']; ?>"><?= $subItem['label']; ?></a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                        case 'simple-menu':
                                            if (is_callable($item['source'])) {
                                                $source = $item['source']();
                                            } else {
                                                $source = $item['source'];
                                            }
                                            ?>
                                            <ul>
                                                <?php foreach ($source as $subItem) { ?>
                                                    <li>
                                                        <a href="<?= $subItem['href']; ?>"><?= $subItem['label']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <?php
                                            break;
                                        default :
                                    } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="reseaux-sociaux fleche">
                        <ul class="ss-menu">
                            <?php /*<li class="youtube"><a href="https://www.youtube.com/user/CTDPULVERISATION" target="_blank"><i
                                        class="fa-youtube-perso"></i></a></li>*/ ?>
                            <li class="facebook">
                                <a><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                <ul>
                                    <?php if ($domainConfiguration['rootCategoryId'] != FAMILLE_INCENDIE_REF) { ?>
                                        <li><a href="https://www.facebook.com/CTDPulverisation/?fref=ts" target="_blank"><i
                                                    class="fa fa-facebook-official"
                                                    aria-hidden="true"></i> <?= FB_ESPACES_VERT; ?></a></li>
                                    <?php } ?>
                                    <?php if (in_array($domainConfiguration['rootCategoryId'], [FAMILLE_INCENDIE_REF, FAMILLE_ACTIVITE_CONNEXE_REF])) { ?>
                                        <li>
                                            <a href="https://www.facebook.com/CTD-Pulvérisation-Lutte-contre-lincendie-240523022952726/?fref=ts"
                                               target="_blank"><i class="fa fa-facebook-official"
                                                                  aria-hidden="true"></i> <?= FB_INCENDIE; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php if (in_array($domainConfiguration['rootCategoryId'], [FAMILLE_INCENDIE_REF, FAMILLE_ACTIVITE_CONNEXE_REF])) { ?>
                                <li class="twitter"><a href="https://twitter.com/CTD_Incendie" target="_blank"><i
                                            class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <?php if (isset($domainConfiguration['second-menu'])) { ?><!-- Pas visible sur la version CTD Portail :: Bleu  -->
                    <ul class="list-inline lien-plus">
                        <?php foreach ($domainConfiguration['second-menu'] as $item) {
                            $containerAttributes = '';
                            $linkAttributes = '';
                            $containerAttributes .= !empty($item['class']) ? ' class="' . $item['class'] . '"' : '';
                            $linkAttributes .= !empty($item['href']) ? ' href="' . $item['href'] . '"' : '';
                            $linkAttributes .= !empty($item['target']) ? ' target="' . $item['target'] . '"' : '';
                            ?>
                            <li<?= $containerAttributes; ?>><a<?= $linkAttributes; ?>><?= $item['label']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <!-- FIN -->
                </div>
            </div>
            <!-- END - content-menu -->

        </nav>
        <!-- END // Fixed navbar -->
    </header>
    <div class="page-color <?= $pageCategory->getColorClass(); ?>">
<?php } else {
    include(ROOT . '_include/haut-mobile.php');
} ?>
