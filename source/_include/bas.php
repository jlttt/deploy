</div> <!-- END - Div.page-color - haut.php et haut-mobile.php -->

<footer class="footer">
    <?php if (!$smartphone) { ?>
        <div class="footer-coordonnees">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="left footer-logo"></div>
                    </div>
                    <div class="col-md-10 content-coordonnees">
                        <div class="adresse"><span><?= SIEGE_SOCIAL_BIS; ?></span></div>
                        <div class="telephone"><span><i class="fa fa-phone"
                                                        aria-hidden="true"></i> <strong><?= TEL_SOCIAL; ?></strong></span>
                        </div>
                        <div class="fax"><span><i class="fa fa-print"
                                                  aria-hidden="true"></i> <strong><?= FAX_SOCIAL; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($smartphone) { ?>
        <div class="footer-groupe">
            <a href="<?= $domainConfigurations['ctd']['url']; ?>" target="_blank"><?= DECOUVREZ . " " . LE_GROUPE_CTD; ?></a>
        </div>
    <?php } ?>

    <div class="footer-menu">
        <div class="container">
            <div class="row">
                <?php if (!$smartphone) { ?>
                    <div class="col-md-6">
                        <ul class="list-unstyled list-activites">
                            <?php
                            $bottomCategories = $rootCategory->getVisibleChildren();
                            if ($rootCategory->ref == FAMILLE_ACTIVITE_CONNEXE_REF) {
                                $bottomCategories = array_merge(
                                    array_filter(
                                        Famille::findRootCategories(null, true), function ($item) {
                                        return $item->ref != FAMILLE_ACTIVITE_CONNEXE_REF;
                                    }),
                                    $bottomCategories);
                            }
                            foreach ($bottomCategories as $category) { ?>
                                <li>
                                    <a href="<?= $category->getUrl(); ?>"<?= $category->niveau == 1 ? ' target="_blank"' : ''; ?>><?= $category->getShortTitle(); ?></a>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <ul class="list-unstyled">
                            <li><?= HTML::link('actu'); ?></li>
                            <?php if ($domainConfiguration['displayBackLink']) { ?>
                                <li><a href="<?= $domainConfigurations['ctd']['url']; ?>"><?= GROUPE_CTD; ?></li>
                            <?php } else { ?>
                                <li><a href="<?= Router::getPageUrl('groupe-ctd'); ?>"><?= QSN; ?></li>
                            <?php } ?>
                            <li>
                                <a href="<?= Router::getPageUrl('actualites'); ?>"><?= Router::getPageTitle('actualites'); ?>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <div class="col-xs-8 col-md-2 acces-rapide">
                    <ul class="list-unstyled">
                        <li><?= HTML::link('contact'); ?></li>
                        <li><a href="<?= Router::getPageUrl('mentions'); ?>"><?= MENTIONS_COURTE; ?></a></li>
                    </ul>
                </div>
                <div class="col-xs-4 col-md-2 noPaddingGauche">
                    <div class="certification">
                        <img src="<?= RACINE; ?>_image/footer-iso9001-2008-x2.png" width="82"
                             alt="<?= strip_tags(CERTIF_ISO_9001); ?>" class="img-responsive"/>
                        <span><?= CERTIF_ISO_9001; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-mention">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-md-push-6">
                    <span class="shared-toolbox">
                        <strong><?= PARTAGER_SITE; ?></strong>
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_sharing_toolbox"></div>
                    </span>
                </div>
                <div class="col-xs-12 col-md-6 col-md-pull-6">
                    <p>
                        <?php echo COPYRIGHT; ?> <a href="<?php echo LIEN; ?>"
                                                    title="<?php echo sprintf(RETOUR_ACCUEIL, NOM_SITE); ?>"><?php echo NOM_SITE; ?></a><?= TOUT_DROIT_RESERVER; ?>
                        <a href="http://www.pmpconcept.com/" title="<?php echo CREA_SITES; ?>" target="_blank"
                           class="retour-mobile"><?php echo CREA_PMP; ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>

<?php if($smartphone) { ?>
			</div><!-- /scroller-inner -->
		</div><!-- /scroller -->

	</div><!-- /pusher -->
</div><!-- /container -->

<?php } ?>

<?php if (ENV == 'prod') { ?>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5773dab516213b3a"></script>
<?php } ?>
<?php
#Appel fichiers Javascript
$GLOBALS['objScript']->callScript();
?>

<?php if (ENV == "dev") { ?>
    <!-- <section style="position:fixed; top:0; left:0; background: white; z-index:10000000; border-right: 2px solid black; border-bottom: 2px solid black;">
        <div class="visible-xs" style="color: white; background-color: #9d2323; padding: 5px 8px;">XS</div>
        <div class="visible-md" style="color: white; background-color: #23279e; padding: 5px 8px;">MD</div>
        <div class="visible-lg" style="color: white; background-color: #238a9e; padding: 5px 8px;">LG</div>
    </section> -->
<?php } ?>
</body>
</html>
