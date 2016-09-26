<?php
/************************************************************/
/*				META										*/
/************************************************************/

#doctype
echo "<!doctype html>\n";
#echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";

#html
#echo sprintf("<!--[if lt IE 8]><html class=\"lt-ie9 lt-ie8 lt-ie7\" xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"%1\$s\" lang=\"%1\$s\"><![endif]-->\n", LANGUE);
echo sprintf("<!--[if IE 8]><html class=\"lt-ie9 lt-ie8\" lang=\"%1\$s\"><![endif]-->\n", LANGUE);
echo sprintf("<!--[if IE 9]><html class=\"lt-ie9\" lang=\"%1\$s\"><![endif]-->\n", LANGUE);
echo sprintf("<!--[if gt IE 9]><!<html lang=\"%1\$s\"><![endif]-->\n", LANGUE);

#head
echo "<head>\n";

#titre
if(isset($titre_page) && $titre_page != '') { echo sprintf("<title>%s</title>\n", $titre_page); }

#codage
echo sprintf("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=%s\" />\n", CONTENT_TYPE);

#auteur
echo sprintf("<meta name=\"Author\" content=\"%s\" />\n", AUTHOR);

#description
if(isset($metadescription) && $metadescription != '') { echo sprintf("<meta name=\"description\" content=\"%s\" />\n", $metadescription); }

#mots clés
if(isset($metakeywords) && $metakeywords != '') { echo sprintf("<meta name=\"keywords\" content=\"%s\" />\n", $metakeywords); }

#fenêtre navigateur :: largeur site
$viewport_desktop = 'width=1024';
$viewport_mobile = 'width=device-width, initial-scale=1.0, user-scalable=no'; // Zoom : user-scalable=false
$viewport = $smartphone == true ? $viewport_mobile : $viewport_desktop;
echo sprintf("<meta id=\"viewport\" name=\"viewport\" content=\"%s\" />\n", $viewport);
echo "<meta name=\"apple-mobile-web-app-capable\" content=\"no\" />\n";

#meta
if (isset($GLOBALS['metas'])) { foreach ($GLOBALS['metas'] as $meta) { echo '<meta'; foreach ($meta as $var => $val) echo ' ' . $var . '="' . $val . '"'; echo '/>' . "\n"; } }

#facebook
$GLOBALS['metas'] = array(
    array('property' => 'og:title', 'content' => $titre_page),
    array('property' => 'og:image', 'content' => RACINE . "_image/favicons/favicon.ico"),
    array('property' => 'og:description', 'content' => $metadescription),
    array('property' => 'og:url', 'content' => isset($_SERVER['REDIRECT_SCRIPT_URI']) ?
        $_SERVER['REDIRECT_SCRIPT_URI']
        : (ENV == 'dev' ? str_replace(RACINE, HTTP, $_SERVER['SCRIPT_NAME']) : $_SERVER['SCRIPT_NAME'])),
    array('property' => 'og:site_name', 'content' => NOM_SITE),
    array('property' => 'og:type', 'content' => 'article'),

    array('itemprop' => 'url', 'content' => isset($_SERVER['REDIRECT_SCRIPT_URI']) ?
        $_SERVER['REDIRECT_SCRIPT_URI']
        : (ENV == 'dev' ? str_replace(RACINE, HTTP, $_SERVER['SCRIPT_NAME']) : $_SERVER['SCRIPT_NAME'])),
    array('itemprop' => 'name', 'content' => NOM_SITE),
    array('itemprop' => 'image', 'content' => RACINE."_image/favicons/favicon.ico"),
    array('itemprop' => 'description', 'content' => $metadescription),
);

#langue
echo '<meta http-equiv="content-language" content="' . (LANGUE . '-' . strtoupper(LANGUE)) . '" />' . PHP_EOL;
echo '<meta name="language" content="' . (LANGUE . '-' . strtoupper(LANGUE)) . '" />' . PHP_EOL;

#favicon
echo sprintf('<link rel="apple-touch-icon" href="%s_image/apple-touch-icon.png" />' . "\n", $domainConfiguration['url']);
echo sprintf('<link rel="shortcut icon" href="%sfavicon.ico" />' . "\n", $domainConfiguration['url']);
echo '<meta name="msapplication-TileColor" content="#2c2981">';
echo '<meta name="theme-color" content="#2c2981">';

#option IE
echo "<!--[if IE]><meta http-equiv=\"imagetoolbar\" content=\"no\" /><![endif]-->\n"; // Désactive l'affichage automatique de la petit barre d'outil d'Internet Explorer 6 lorsque l'on survole une grande image et qui permet d'enregistrer, d'imprimer ou d'envoyer l'image
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';

includeColorThemes($lessCompiler, array_merge($categories, [$rootCategory, $pageCategory]));
#css
echo sprintf("<link rel=\"stylesheet\" type=\"text/css\" href=\"%s_css/all.css\" media=\"all\" />\n", RACINE);
//echo sprintf("<link rel=\"stylesheet\" type=\"text/css\" href=\"%s_css/theme-bleu.css\" media=\"all\" />\n", RACINE);
// Famille couleurs
// $GLOBALS['objScript']->addScript(RACINE . '_css/theme-color.css');
$GLOBALS['objScript']->callScript("css"); // appel des CSS déclarés dans les pages

#link
if (isset($GLOBALS['link'])) { foreach ($GLOBALS['link'] as $link) { echo '<link'; foreach ($link as $var => $val) echo ' ' . $var . '="' . $val . '"'; echo '/>' . "\n"; } }

echo "<!--[if lt IE 9]>\n";

#message navigateur obsolète
echo sprintf("<script type=\"text/javascript\" src=\"%snavi_obsolete/navi_obsolete_%s.js\"></script>\n", HTTP_PMP_MODULE, LANGUE);

#HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries
echo sprintf("<script src=\"%s_scripts/ie8-responsive/ie8-responsive-file-warning.js\"></script>\n", RACINE);
echo sprintf("<script src=\"%s_scripts/ie8-responsive/html5shiv.js\"></script>\n", RACINE);
echo sprintf("<script src=\"%s_scripts/ie8-responsive/respond.min.js\"></script>\n", RACINE);

echo "<![endif]-->\n";

# Variable detection mobile pour Javascript
echo '<script>var isMobile = ' . $smartphone . '; var racine = "' . RACINE . '";</script>' . "\n";

?>
<script>
    var racine = <?= json_encode(RACINE); ?>;
</script>
<?php
#Google analytics
if (ENV == 'prod') {
	include_once(ROOT . '_include/analyticstracking.php');
}

#fermeture head
echo "</head>\n";

#body
$onLoad = NULL; if(isset($GLOBALS['onLoadFunction'])) { $onLoad .= ' onload="'; foreach($GLOBALS['onLoadFunction'] as $i=>$func) { $onLoad .= $func; } $onLoad .= '"'; }
$hoverTouch = !$touch ? ' no-touch' : ' touch';
$mobileControl = $smartphone == true ? ' mobile' : ' desktop';
$themeColor = isset($themeColor) ? ' ' . $themeColor : NULL;
echo "<body role=\"document\" class=\"langue-" . LANGUE . $mobileControl . $hoverTouch . ' ' . $rootCategory->getColorClass() . ' ' . $domainConfiguration['themeClass'] . "\"" . $onLoad . ">\n";
