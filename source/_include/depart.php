<?php
//////////////////////////////////////////////////////////////////
//
// © PMP CONCEPT 2014 :: CODE COMMUN A TOUTES LES PAGES DU FRONT
//
//////////////////////////////////////////////////////////////////

session_start();

/****************************************************************/
/*		DECLARATION DES LIBRAIRIES ET CLASSES PRINCIPALES		*/
/****************************************************************/
// Classe de connexion à la base de données
require_once GESTION_LIBRARY . '_classes/sqldb.class.php';
$db = new SQLDB(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
// ferme la connexion à chaque requete
$db->autoClose = true;

// Classe de gestion des modules (paramètres de configuration, url, ...)
require_once GESTION_LIBRARY . '_classes/module.class.php';

// Classe de gestion des scripts et css
require_once GESTION_LIBRARY . '_classes/script.class.php';

require_once GESTION_LIBRARY . 'html.lib.php';
require_once GESTION_LIBRARY . '_classes/router.class.php';
require_once GESTION_LIBRARY . '_classes/TemplateEngine.php';
//echo HTML::link($code); => Génère un lien vers la page déclarée dans le fichier _pmpconf/pages.php
//echo HTML::title(constante); => Génère un attribut title si la constante passée en paramètre n'est pas vide
//echo Router::getPageUrl('accueil') => '/'
//echo Router::getPageUrl('mentions', 'en') => '/en/legal-notices.php',
//echo Router::getPageUrl('mentions', LANGUE, HTTP) => 'http://www.exemple.org/mentions-legales.php'


/****************************************************************/
/*						GESTION DE LA LANGUE					*/
/****************************************************************/
// Librarie de gestion des langue
require_once LIBRARY . 'langue.lib.php';
require_once(GESTION_LIBRARY . 'locale.lib.php');
// fichier langue generale
if(!array_search(ROOT . '_langage/' . LANGUE . '/general.php', get_included_files())) {
	if (file_exists(ROOT . '_langage/' . LANGUE . '/general.php')) {
		require_once ROOT . '_langage/' . LANGUE . '/general.php';
	} else {
		require_once ROOT . '_langage/' . LANGUE_DEPART . '/general.php';
	}
}


/****************************************************************/
/*						GESTION DES URLS ET SITEMAP				*/
/****************************************************************/
// liste des urls
require_once ROOT . '_pmpconf/pages.php';


/****************************************************************/
/*		DETECTION MATERIEL (http://blog.mobileesp.com)			*/
/****************************************************************/
require_once ROOT . '_library/mdetect.php';
//Instantiate the object to do our testing with.
$uagent_obj = new uagent_info();
$smartphone = $uagent_obj->DetectSmartphone();
$tablet = $uagent_obj->DetectTierTablet(); // tablette
$touch = $smartphone || $tablet ? 1 : 0;

// Devices
$ios = $uagent_obj->DetectIos();
$android = $uagent_obj->DetectAndroid();
$windowsphone = $uagent_obj->DetectWindowsPhone();


/****************************************************************/
/*		FONCTIONS												*/
/****************************************************************/
function debug($var) {
	if ($_SERVER['REMOTE_ADDR'] == '86.216.32.217' || $_SERVER['REMOTE_ADDR'] == '192.168.1.29') {
		$backTrace = debug_backtrace();
		echo '<pre>[' . $backTrace[0]['file'] . ', line : ' . $backTrace[0]['line'] . '] ', var_dump($var) , '</pre>';
	}
}

function includeColorThemes($lessCompiler, $categories = [])
{
    $colorThemes = [];
    foreach ($categories as $category) {
        if (!in_array($category->getColorClass(), $colorThemes)) {
            $colorThemes[] = $category->getColorClass();
            $configuration = [
                'destination' => ROOT . '_css/theme-color/' . $category->getColorClass() . '.css',
                'variables' => [
                    'hexColor' => '#' . $category->getColor(),
                    'classColor' => 'ctd-' . $category->getColor()
                ]
            ];
            $lessCompiler->run($configuration);
            $GLOBALS['objScript']->addScript(RACINE . '_css/theme-color/' . $category->getColorClass() . '.css');
        }
    }
}

/****************************************************************/
/*		DECLARATION DES SCRIPTS GENERAUX CSS & JAVASCRIPT		*/
/****************************************************************/
$GLOBALS['objScript'] = new Script();

// jQuery
$GLOBALS['objScript']->addScript(RACINE . '_scripts/jquery/jquery-1.11.1.min.js');

# menu mobile
if($smartphone) {
	$GLOBALS['objScript']->addScript(RACINE . '_css/menumobile.css');
	$GLOBALS['objScript']->addScript(RACINE . '_scripts/menumobile-min.js');
}

// GENERAL
$GLOBALS['objScript']->addScript(RACINE . '_scripts/script-min.js');


/****************************************************************/
/*		GEOLOCALISATION											*/
/****************************************************************/
// Géoloc URL itinéraire en fonction du device
$geoLatitude = '46.098719';
$geoLongitude = '4.772744';
$geoAdresse = ADRESSE_MAPS;
$urlmaps = 'https://goo.gl/maps/B7rxrkoZ3Tn';

if ($windowsphone) {
	$urlmaps = "bingmaps:?collection=point.".$geoLatitude."_".$geoLongitude."_".$geoAdresse;
} else if ($ios) {
	$urlmaps = "maps:daddr=$geoLatitude,$geoLongitude&saddr=Lieu%20actuel"; //Current%20Location
} else if ($android) {
	$urlmaps = "geo:$geoLatitude,$geoLongitude?q=$geoAdresse";
}

require_once(GESTION_LIBRARY . '_composants/form/FileManager/vendor/autoload.php');
require_once(GESTION_LIBRARY . '_composants/lessCompiler/vendor/autoload.php');

$lessCompiler = new \Pmpconcept\Less\LessCompiler(ROOT . '_less/theme-color.less');


$domainNames = [
    'espaces-verts' => null,
    'incendie' => null,
    'pulverisateurs-jardin' => null,
    'firefighting' => 'incendie'
];

$getDomain = function() use ($domainNames)
{
    $parts = explode('.', $_SERVER['SERVER_NAME']);
    if (in_array($parts[0], array_keys($domainNames))) {
        if (is_null($domainNames[$parts[0]])) {
            return $parts[0];
        }
        return $domainNames[$parts[0]];
    }
    return 'ctd';
};
$languageCode = LANGUE;
include(ROOT . '_pmpconf/conf.php');
$domainConfiguration = $domainConfigurations[$getDomain()];
Module::loadModule('produit', 'form');
require_once(GESTION_ROOT . 'produit/_classes/famille.class.php');
$rootCategory = Famille::load($domainConfiguration['rootCategoryId']);
$pageCategory = $rootCategory;
$categories = [];

