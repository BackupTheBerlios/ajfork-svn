<?php
/*
Languagefile: Danish
Language Name: Dansk
Author: Niels Lemming (Lem.dk)
Author URI: none
Author Email: keine@users.1go.dk
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Kommentar beskyttelse er på, du må vente ' . htmlentities($config_flood_time) . ' sekunder efter din sidste kommentar, før du kan skrive igen.';
$lang_blocked = 'Beklager, men du har ikke tilladelse til at skrive en kommentar, din ip er blevet blokket.';
$lang_commentregistered = 'Dette navn er registreret, skriv venligst dit kodeord for at bevise din identitet.';
$lang_commentregisteredbutton = 'Gem kommentar';
$lang_onlyregistered = 'Beklager, men kun registrerede brugere kan skrive kommentarer, og ' . htmlentities($name) . ' er ikke registeret.';
$lang_comment_needname = 'Du er nød til at skrive et navn..<br /><a href="javascript:history.go(-1)">gå tilbage</a>';
$lang_comment_invalidmail = 'Du skrev en ugyldig email adresse.<br /><a href="javascript:history.go(-1)">gå tilbage</a>';
$lang_comment_needvalidmail = 'Du har ikke skrevet en gyldig email eller URL.<br /><a href="javascript:history.go(-1)">gå tilbage</a>';
$lang_comment_notblank = 'Kommentarfeltet kan ikke være tomt.<br /><a href="javascript:history.go(-1)">gå tilbage</a>';
$lang_comment_notaccepted = 'Beklager, kommentering er blevet lukket for den artikel';
$lang_article_notfound = 'Kunne ikke finde artiklen med id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Klik her for at kommentere.';
$lang_archive_notopen = 'Kunne ikke åbne mappen ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Søg...";
$lang_search_news = "Artikel";
$lang_search_title = "Titel";
$lang_search_author = "Skrevet af";
$lang_search_from = "Søg fra";
$lang_search_to = "Søg til";
$lang_search_archives = "Søg i arkivet";
$lang_search_advanced = "Avanceret";
$lang_search_cnoarch = "Kunne ikke åbne " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Fandt artikler der matchede dit spørgsmål!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Fandt <strong>ingen</strong> artikler der matchede dit spørgsmål.";
$lang_search_button = "Søg!";

## Date
$lang_and = "og";
$lang_dates = array(
year => "år",
month => "måned",
week => "uge",
day => "dag",
hour => "time",
minute => "minut",
second => "sekund",

 plural =>
  array(
   year => "år",
   month => "måneder",
   week => "uger",
   day => "dage",
   hour => "timer",
   minute => "minutter",
   second => "sekunder",
   ),
	);

$lang_days = array(
monday => "mandag",
tuesday => "tirsdag",
wednesday => "onsdag",
thursday => "torsdag",
friday => "fredag",
saturday => "lørdag",
sunday => "søndag",
);

$lang_months = array(
january => "januar",
february => "februar",
march => "marts",
april => "april",
may => "maj",
june => "juni",
july => "juli",
august => "august",
september => "september",
october => "oktober",
november => "november",
december => "december",
);
?>
