<?php
/*
Languagefile: Latvian
Language Name: Latviski
Author: Anonymous (Digitalz)
Author URI: http://hack.ilva.lv/
Author Email: Digitalz@ilva.lv
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flooda aizsardziba ir iespekta - uzgaidi ' . htmlentities($config_flood_time) . ' sekundes un varesi komentet..';
$lang_blocked = 'Tu esi blokets!.';
$lang_commentregistered = 'Šis niks ir registrets, lai to lietotu ieraksti paroli.';
$lang_commentregisteredbutton = 'Komenēt';
$lang_onlyregistered = 'Piedod, tikai registreti lietotaji var komentet, un ' . htmlentities($name) . ' nav registrets.';
$lang_comment_needname = 'Ieraksti niku(vārdu)..<br /><a href="javascript:history.go(-1)">atpakaļ</a>';
$lang_comment_invalidmail = 'Esi ievadījis nepareizu e-mailu.<br /><a href="javascript:history.go(-1)">atpakaļ</a>';
$lang_comment_needvalidmail = 'Esi ierakstījis napareizu e-mailu/web.<br /><a href="javascript:history.go(-1)">atpakaļ</a>';
$lang_comment_notblank = 'Ieraksti komentāru!<br /><a href="javascript:history.go(-1)">atpakaļ</a>';
$lang_article_notfound = 'Nevaru atrast rakstu: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Spied te lai komentētu';
$lang_archive_notopen = 'Nevaru atvērt mapi ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Meklēt...";
$lang_search_news = "Raksts";
$lang_search_title = "Virsraksts";
$lang_search_author = "Ievietoja";
$lang_search_from = "Meklēt no";
$lang_search_to = "meklēt līdz";
$lang_search_archives = "meklēt arhīvos";
$lang_search_advanced = "Iespējas..";
$lang_search_cnoarch = "Nevaru atvērt " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Atradu!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Neatradu</strong>.";
$lang_search_button = "Search!";

## Date
$lang_and = "un";
$lang_dates = array(
year => "gads",
month => "mēnesis",
week => "nedēļa",
day => "diena",
hour => "stunda",
minute => "minūte",
second => "sekunde",

 plural =>
  array(
   year => "gadi",
   month => "mēneši",
   week => "nedēļas",
   day => "dienas",
   hour => "stundas",
   minute => "minūtes",
   second => "sekundes",
   ),
	);

$lang_days = array(
monday => "pirmdiena",
tuesday => "otrdiena",
wednesday => "trešdiena",
thursday => "ceturdiena",
friday => "piekdiena",
saturday => "sestdiena",
sunday => "svētdiena",
);

$lang_months = array(
january => "janvāris",
february => "februāris",
march => "marts",
april => "aprīlis",
may => "maijs",
june => "jūnijs",
july => "jullijs",
august => "augusts",
september => "septembris",
october => "oktobris",
november => "novembris",
december => "decembris",
);
?>
