<?php
/*
Languagefile: Croatian
Language Name: Hrvatski
Author: Marin Knezović (Hann)
Author URI:	http://ps2.gamer.hr
Author Email: hann@net.hr
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Zaštita od floodanja je uključena, morati ćete pričekati ' . htmlentities($config_flood_time) . ' sekunda prije nego li mognete postati ponovno..';
$lang_blocked = 'Vaš IP je blokiran, ne možete postati.';
$lang_commentregistered = 'Ovaj nick je zauzet. Upišite zaporku ako je ovo vaš nick.';
$lang_commentregisteredbutton = 'Sačuvaj komentar';
$lang_onlyregistered = 'Žao nam je, samo registrirani korisnici mogu pisati komentare, a ' . htmlentities($name) . ' nije registriran.';
$lang_comment_needname = 'Morati upisati ime.<br /><a href="javascript:history.go(-1)">Nazad</a>';
$lang_comment_invalidmail = 'Upisali ste pogrešnu e-mail adresu.<br /><a href="javascript:history.go(-1)">Nazad</a>';
$lang_comment_needvalidmail = 'Upisali ste pogrešnu e-mail adresu ili pogrešan URL.<br /><a href="javascript:history.go(-1)">Nazad</a>';
$lang_comment_notblank = 'Polje komentara ne može biti prazno.<br /><a href="javascript:history.go(-1)">Nazad</a>';
$lang_comment_notaccepted = 'Žao nam je, trenutano ne možete postati komentar.';
$lang_article_notfound = 'Nema članka sa ID: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Klikni ovdje za komentar';
$lang_archive_notopen = 'Folder se ne može otvoriti ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Traži...";
$lang_search_news = "Članak";
$lang_search_title = "Naslov";
$lang_search_author = "Napisao/la";
$lang_search_from = "Traži od";
$lang_search_to = "Traži do";
$lang_search_archives = "Pretraži arhivu";
$lang_search_advanced = "Napredna pretraga..";
$lang_search_cnoarch = "Ne može se otvoriti " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Nađeni članci koji odgovaraju vašem upitu!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Nema</strong> članaka koji odgovaraju vašem upitu.";
$lang_search_button = "Pretraži!";

## Date
$lang_and = "i";
$lang_dates = array(
	year => "godina",
	month => "mjesec",
	week => "tjedan",
	day => "dan",
	hour => "sat",
	minute => "minuta",
	second => "sekunda",
	
		plural => 
			array(
				year => "godine",
				month => "mjeseci",
				week => "tjedni",
				day => "dani",
				hour => "sati",
				minute => "minute",
				second => "sekunde",
				),
		);

$lang_days = array(
	monday => "ponedjeljak",
	tuesday => "utorak",
	wednesday => "srijeda",
	thursday => "četvrtak",
	friday => "petak",
	saturday => "subota",
	sunday => "nedjelja",
);

$lang_months = array(
	january => "siječanj",
	february => "veljača",
	march => "ožujak",
	april => "travanj",
	may => "svibanj",
	june => "lipanj",
	july => "srpanj",
	august => "kolovoz",
	september => "rujan",
	october => "listopad",
	november => "studeni",
	december => "prosinac",
	);
?>
