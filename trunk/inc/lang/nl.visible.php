<?php
/*
Languagefile: Dutch
Language Name: Nederlands
Author: Anonymous (StealthEye)
Author URI: http://cutephp.com/forum/index.php?showuser=4
Author Email: seye@xs4all.nl
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flood-protection staat aan - je moet ' . htmlentities($config_flood_time) . ' seconden wachten na je laatste reactie voordat je een volgende kunt plaatsen..';
$lang_blocked = 'Sorry, maar het plaatsen van reacties met jouw ip is geblokkeerd.';
$lang_commentregistered = 'Deze naam is geregistreerd, voer je wachtwoord in om te bewijzen dat hij van jou is.';
$lang_commentregisteredbutton = 'Reageer';
$lang_onlyregistered = 'Sorry, alleen geregistreerde leden kunnen reageren, en ' . htmlentities($name) . ' is niet geregistreerd.';
$lang_comment_needname = 'Je moet een naam opgeven..<br /><a href="javascript:history.go(-1)">ga terug</a>';
$lang_comment_invalidmail = 'Je hebt een incorrect email-adres opgegeven.<br /><a href="javascript:history.go(-1)">ga terug</a>';
$lang_comment_needvalidmail = 'Je hebt geen email-adres of url opgegeven.<br /><a href="javascript:history.go(-1)">ga terug</a>';
$lang_comment_notblank = 'Het commentaar-veld mag niet leeg zijn.<br /><a href="javascript:history.go(-1)">ga terug</a>';
$lang_article_notfound = 'Kon het artikel met id <strong>' . htmlentities($id) . ' niet vinden.</strong>';
$lang_article_linktext = 'Klik hier om te reageren.';
$lang_archive_notopen = 'Kon de map ' . htmlentities($cutepath) . '/data/archives niet openen.';

## search.php
$lang_search_header = "Zoeken...";
$lang_search_news = "Artikel";
$lang_search_title = "Titel";
$lang_search_author = "Geschreven door";
$lang_search_from = "Zoeken vanaf";
$lang_search_to = "Zoeken tot";
$lang_search_archives = "In archieven zoeken";
$lang_search_advanced = "Geavanceerd...";
$lang_search_cnoarch = "Kon " . htmlentities($cutepath) . "/data/archives niet openen";
$lang_search_found = "<strong>Artikelen gevonden die aan jouw zoekopdracht voldoen!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Geen</strong> artikelen gevonden die aan jouw zoekopdracht voldoen.";
$lang_search_button = "Zoek!";

## Date
$lang_and = "en";
$lang_dates = array(
year => "jaar",
month => "maand",
week => "week",
day => "dag",
hour => "uur",
minute => "minuut",
second => "seconde",

 plural =>
  array(
   year => "jaren",
   month => "maanden",
   week => "weken",
   day => "dagen",
   hour => "uren",
   minute => "minuten",
   second => "secondes",
   ),
	);

$lang_days = array(
monday => "maandag",
tuesday => "dinsdag",
wednesday => "woensdag",
thursday => "donderdag",
friday => "vrijdag",
saturday => "zaterdag",
sunday => "zondag",
);
$lang_months = array(
january => "januari",
february => "februari",
march => "maart",
april => "april",
may => "mei",
june => "juni",
july => "juli",
august => "augustus",
september => "september",
october => "october",
november => "november",
december => "december",
);
?>
