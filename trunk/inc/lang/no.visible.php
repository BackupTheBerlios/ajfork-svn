<?php
/*
Languagefile: Norwegian
Language Name: Norsk Bokmål
Author: Øivind Hoel
Author URI:	http://appelsinjuice.org/
Author Email: oivind.hoel@appelsinjuice.org
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flood-beskyttelse er på, du må vente ' . htmlentities($config_flood_time) . ' sekunder etter din siste kommentar før du kan skrive en ny kommentar.';
$lang_blocked = 'Beklager, du har ikke tillatelse til å poste kommentarer her (blokkert).';
$lang_commentregistered = 'Dette navnet er i bruk av en registrert person, og du må skrive inn passord for å bruke det.';
$lang_commentregisteredbutton = 'Lagre kommentar';
$lang_onlyregistered = 'Beklager, men bare registrerte brukere kan skrive kommentarer, og &quot; ' . htmlentities($name) . '&quot; er ikke registrert.';
$lang_comment_needname = 'Du må skrive inn et navn.<br /><a href="javascript:history.go(-1)">tilbake</a>';
$lang_comment_invalidmail = 'Du skrev inn en ugyldig email<br /><a href="javascript:history.go(-1)">tilbake</a>';
$lang_comment_needvalidmail = 'Du har ikke skreve inn en gyldig email eller URL.<br /><a href="javascript:history.go(-1)">tilbake</a>';
$lang_comment_notblank = 'Kommentarfeltet kan nok dessverre ikke være tomt.<br /><a href="javascript:history.go(-1)">tilbake</a>';
$lang_comment_notaccepted = 'Beklager, kommentering på denne artikkelen er avslått';
$lang_article_notfound = 'Kunne ikke finne artikkel med id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Trykk her for å legge inn en kommentar';
$lang_archive_notopen = 'Kunne ikke åpne mappen ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Søk...";
$lang_search_news = "Innlegg";
$lang_search_title = "Tittel";
$lang_search_author = "Skrevet av";
$lang_search_from = "Søk fra";
$lang_search_to = "Søk til";
$lang_search_archives = "Søk i arkiv";
$lang_search_advanced = "Avansert..";
$lang_search_cnoarch = "Kunne ikke åpne " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "Fant artikler som matchet ditt søk";
$lang_search_founddate = " ";
$lang_search_notfound = "Fant ingen artikler som matchet ditt søk";
$lang_search_button = "Søk!";

## Date
$lang_and = "og";
$lang_dates = array(
	"year" => "år",
	"month" => "måned",
	"week" => "uke",
	"day" => "dag",
	"hour" => "time",
	"minute" => "minutt",
	"second" => "sekund",
	
	"plural" => 
			array(
				"year" => "år",
				"month" => "måneder",
				"week" => "uker",
				"day" => "dager",
				"hour" => "timer",
				"minute" => "minutter",
				"second" => "sekunder",
				),
	);

$lang_days = array(
	"monday" => "mandag",
	"tuesday" => "tirsdag",
	"wednesday" => "onsdag",
	"thursday" => "torsdag",
	"friday" => "fredag",
	"saturday" => "lørdag",
	"sunday" => "søndag",
	);

$lang_months = array(
	"january" => "januar",
	"february" => "februar",
	"march" => "mars",
	"april" => "april",
	"may" => "mai",
	"june" => "juni",
	"july" => "juli",
	"august" => "august",
	"september" => "september",
	"october" => "oktober",
	"november" => "november",
	"december" => "desember",
	);
	
?>
