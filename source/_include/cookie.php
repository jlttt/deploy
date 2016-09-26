<?php
/************************************************************/
/*				PARAMETRES DE CONFIGURATION					*/
/************************************************************/
# paramètres généraux du site
include('../_pmpconf/pmpconfig.inc.php');

/************************************************************/
/*		EXECUTION DU CODE COMMUM A TOUTES LES PAGES			*/
/*		  (CLASSES DE BASE, LANGUE, SESSION, ...)			*/
/************************************************************/
include(ROOT.'_include/depart.php');

/****************************************************************/
/*		DECLARATION DES LIBRAIRIES ET CLASSES PRINCIPALES		*/
/****************************************************************/
# Librarie de gestion des chaines de caractères
require_once(GESTION_LIBRARY."string.lib.php");

?>
<!-- COOKIES : Informations -->
<div id="conditionalbanner" class="bg banneractive">
    <div id="cookieprivacy" class="conditionalbanner">
        <div class="cell message"><?php echo NOTIF_COOKIES; ?> <a href="<?php echo LIEN . $GLOBALS['plan_site']['mentions']['url'][LANGUE]; ?>#cookies" target="_blank"><strong><?php echo BTN_PLUS_INFOS; ?></strong></a></div>
        <div class="cell"><a href="javascript:void(0)" class="btn btn-sm btn-cookie"><?php echo BTN_COOKIES; ?></a></div>
    </div>
</div>
<!-- COOKIES : Informations -->
