<?php
/*
Languagefile: German
Language Name: Deutsch
Author: Lars Wohlfahrt
Author URI: http://www.digitalday.de
Author Email: info@digitalday.de
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Der Flood Schutz ist aktiviert - du\'musst mindestens ' . htmlentities($config_flood_time) . 'warten nach deinem letzten Kommentar, bevor du wieder einen verfassen kannst..';
$lang_blocked = 'Sorry, deine IP-Adresse wurde gesperrt, daher kannst du keine Kommentare verfassen.';
$lang_commentregistered = 'Dieser Name ist registriert, bitte gib dein Passwort ein, um deine Identität zu bestätigen.';
$lang_commentregisteredbutton = 'Kommentar speichern';
$lang_onlyregistered = 'Sorry, nur registrierte Mitglieder können Kommentare verfassen und der Name ' . htmlentities($name) . ' ist nicht registriert .';
$lang_comment_needname = 'Du musst einen Namen eingeben..<br /><a href="javascript:history.go(-1)">zurück</a>';
$lang_comment_invalidmail = 'Du hast eine ungültige E-Mail Adresse eingegeben.<br /><a href="javascript:history.go(-1)">zurück</a>';
$lang_comment_needvalidmail = 'Du hast keine gültige E-Mail Adresse oder URL angegeben.<br /><a href="javascript:history.go(-1)">zurück</a>';
$lang_comment_notblank = 'Das Kommentar-Feld darf nicht leer sein.<br /><a href="javascript:history.go(-1)">zurück</a>';
$lang_comment_notaccepted = 'Sorry, zur Zeit werden keine weiteren Artikel akzeptiert.';
$lang_article_notfound = 'Der Artikel mit der id: <strong>' . htmlentities($id) . '</strong> konnte nicht gefunden werden.';
$lang_article_linktext = 'Klick um zu kommentieren';
$lang_archive_notopen = 'Der Ordner ' . htmlentities($cutepath) . '/data/archives konnte nicht geöffnet werden.';

## search.php
$lang_search_header = "Suche...";
$lang_search_news = "Artikel";
$lang_search_title = "Titel";
$lang_search_author = "Verfasst von";
$lang_search_from = "Suche von";
$lang_search_to = "Suche bis";
$lang_search_archives = "Suche im Archiv";
$lang_search_advanced = "Erweitert..";
$lang_search_cnoarch = "Der Ordner " . htmlentities($cutepath) . "/data/archives konnte nicht geöffnet werden.";
$lang_search_found = "<strong>Es wurden Artikel gefunden, die deinen Kriterien entsprachen!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Es wurden <strong>keine</strong> Artikel gefunden, die deinen Kriterien entsprachen.";
$lang_search_button = "Suchen";

## Date
$lang_and = "und";
$lang_dates = array(
year => "Jahr",
month => "Monat",
week => "Woche",
day => "Tag",
hour => "Stunde",
minute => "Minute",
second => "Sekunde",

 plural =>
  array(
   year => "Jahre",
   month => "Monate",
   week => "Wochen",
   day => "Tage",
   hour => "Stunden",
   minute => "Minuten",
   second => "Sekunden",
   ),
	);

$lang_days = array(
monday => "Montag",
tuesday => "Dienstag",
wednesday => "Mittwoch",
thursday => "Donnerstag",
friday => "Freitag",
saturday => "Samstag",
sunday => "Sonntag",
);

$lang_months = array(
january => "Januar",
february => "Februar",
march => "März",
april => "April",
may => "Mai",
june => "Juni",
july => "Juli",
august => "August",
september => "September",
october => "Oktober",
november => "November",
december => "Dezember",
);
?>
