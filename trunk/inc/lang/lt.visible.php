<?php
/*
Languagefile: Lithuanian
Language Name: Lietuvių
Author: Vidas Bučinskas (Omid)
Author URI:	http://omid.kubas.net/
Author Email: omid@kubas.net
*/

## shows.inc.php
$lang_floodprot = 'Komentarų FLOOD apsauga įjungta  - Jūs turite palaukti ' . htmlentities($config_flood_time) . ' sekundžių(-es) ir tada vėl galėsite įrašyti komentarą.';
$lang_blocked = 'Atsiprašome, tačiau jūsų IP adresas yra užblokuotas. Jūs negalite rašyti komentarų...';
$lang_commentregistered = 'Šis vardas yra registruotas, prašome įvesti slaptažodį.';
$lang_commentregisteredbutton = 'Įrašyti komentarą';
$lang_onlyregistered = 'Atsiprašome tačiau tik prisiregistravę nariai gali rašyti komentarus, ir vardas ' . htmlentities($name) . ' nėra priregistruotas.';
$lang_comment_needname = 'Jūs turite įrašyti savo vardą..<br /><a href="javascript:history.go(-1)">grįžkite atgal</a>';
$lang_comment_invalidmail = 'Jūs įrašėte neteisingą E-MAIL adresą.<br /><a href="javascript:history.go(-1)">grįžkite atgal</a>';
$lang_comment_needvalidmail = 'Jūs neįrašėte teisingo E-MAIL arba WWW adreso.<br /><a href="javascript:history.go(-1)">grįžkite atgal</a>';
$lang_comment_notblank = 'Komentaro laukelis negali būti tuščias.<br /><a href="javascript:history.go(-1)">grįžkite atgal</a>';
$lang_article_notfound = 'Neįmanoma rasti įrašo su ID: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Spauskite čia ir komentuokite';
$lang_archive_notopen = 'Neįmanoma atidaryti direktorijos ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Ieškoti...";
$lang_search_news = "Įrašas";
$lang_search_title = "Pavadinimas";
$lang_search_author = "Autorius";
$lang_search_from = "Ieškoti nuo";
$lang_search_to = "Ieškoti iki";
$lang_search_archives = "Ieškoti archyvuose";
$lang_search_advanced = "Išplėsta paieška..";
$lang_search_cnoarch = "Neįmanoma atidaryti " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "Paieška <strong>rado</strong> šiuos įrašus<br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Atsiprašome, tačiau paieška <strong>nieko nerado</strong>.";
$lang_search_button = "Ieškoti!";

## Date
$lang_and = "ir";
$lang_dates = array(
	year => "metai",
	month => "mėnesis",
	week => "savaitė",
	day => "diena",
	hour => "valanda",
	minute => "minutė",
	second => "sekundė",
	
		plural => 
			array(
				year => "metai",
				month => "mėnesiai",
				week => "savaitės",
				day => "dienos",
				hour => "valandos",
				minute => "minutės",
				second => "sekundės",
				),
	
	monday => "pirmadienis",
	tuesday => "antradienis",
	wednesday => "trečiadienis",
	thursday => "ketvirtadienis",
	friday => "penktadienis",
	saturday => "šeštadienis",
	sunday => "sekmadienis",
	
	january => "sausis",
	february => "vasaris",
	march => "kovas",
	april => "balandis",
	may => "gegužė",
	june => "birželis",
	july => "liepa",
	august => "rugpjūtis",
	september => "rugsėjis",
	october => "spalis",
	november => "lapkritis",
	december => "gruodis",
	);
?>
