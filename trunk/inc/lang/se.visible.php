<?php
/*
Languagefile: Swedish
Language Name: Svenska
Author: Franz H.
Author URI: http://localhost/
Author Email: system33r@gmail.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flood-protection är aktiverad - du måste vänta ' . htmlentities($config_flood_time) . ' sekunder efter din sista kommentar innan du kan skriva igen..';
$lang_blocked = 'Förlåt, Ditt ip har blivit blockerad ifrån att skriva kommentarer.';
$lang_commentregistered = 'Det här användarnamnet är redan registrerat, giv ditt lösenord för att bevisa din identitet.';
$lang_commentregisteredbutton = 'Spara kommentar';
$lang_onlyregistered = 'Förlåt, bara registrerade medlemmar kan skriva kommentarer, och ' . htmlentities($name) . ' är inte registrerad.';
$lang_comment_needname = 'Du måste skriva ett namn...<br /><a href="javascript:history.go(-1)">gå tillbaka</a>';
$lang_comment_invalidmail = 'Du har skrivit in en ogiltig email adress.<br /><a href="javascript:history.go(-1)">gå tillbaka</a>';
$lang_comment_needvalidmail = 'Du har inte skrivit in en giltig email eller webadress.<br /><a href="javascript:history.go(-1)">gå tillbaka</a>';
$lang_comment_notblank = 'Kommentar-fältet kan inte vara tomt.<br /><a href="javascript:history.go(-1)">gå tillbaka</a>';
$lang_comment_notaccepted = 'Förlåt, inga fler kommentarer för tillfället.';
$lang_article_notfound = 'Det gick inte att hitta en artikel med id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Klicka här för att kommentera';
$lang_archive_notopen = 'Kunde inte öppna mapp ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Sök...";
$lang_search_news = "Artikel";
$lang_search_title = "Titel";
$lang_search_author = "Skriven av";
$lang_search_from = "Sök från";
$lang_search_to = "Sök till";
$lang_search_archives = "Sök i arkiven";
$lang_search_advanced = "Avancerat..";
$lang_search_cnoarch = "Kunde inte öppna " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Hittade artiklar som matchade din sökning!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Hittade <strong>inga</strong> artiklar som matchade din sökning.";
$lang_search_button = "Sök!";

## Date
$lang_and = "och";
$lang_dates = array(
	year => "år",
	month => "månad",
	week => "vecka",
	day => "dag",
	hour => "timma",
	minute => "minut",
	second => "sekund",
	
		plural => 
			array(
				year => "år",
				month => "månader",
				week => "veckor",
				day => "dagar",
				hour => "timmar",
				minute => "minuter",
				second => "sekunder",
				),
		);

$lang_days = array(
	monday => "måndag",
	tuesday => "tisdag",
	wednesday => "onsdag",
	thursday => "torsdag",
	friday => "fredag",
	saturday => "lördag",
	sunday => "söndag",
);

$lang_months = array(
	january => "januari",
	february => "februari",
	march => "mars",
	april => "april",
	may => "maj",
	june => "juni",
	july => "july",
	august => "augusti",
	september => "september",
	october => "oktober",
	november => "november",
	december => "december",
	);
?>
