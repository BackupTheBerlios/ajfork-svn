<?php
/*
Languagefile: Italian
Language Name: Italiano
Author: Alex Grossini (Aske)
Author URI: http://bbll.altervista.org/
Author Email: alex_grossini@virgilio.it
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Protezione contro l\'ammassamento - per favore attendi ' . htmlentities($config_flood_time) . ' secondi prima di postare di nuovo...';
$lang_blocked = 'Spiacenti, ma al tuo ip non &egrave; permesso postare commenti.';
$lang_commentregistered = 'Questo nome &egrave; registrato: inserirsci la password per provare la tua identit&agrave;.';
$lang_commentregisteredbutton = 'Salva il commento';
$lang_onlyregistered = 'Solo i membri registrati possono aggiungere commenti, e ' . htmlentities($name) . ' non risulta registrato.';
$lang_comment_needname = 'Inserisci un nome..<br /><a href="javascript:history.go(-1)">indietro</a>';
$lang_comment_invalidmail = 'La tua e-mail non risulta valida.<br /><a href="javascript:history.go(-1)">indietro</a>';
$lang_comment_needvalidmail = 'Non hai inserito una e-mail o una URL valide.<br /><a href="javascript:history.go(-1)">indietro</a>';
$lang_comment_notblank = 'Lo spazio per il commento non pu&ograve; restare vuoto.<br /><a href="javascript:history.go(-1)">indietro</a>';
$lang_comment_notaccepted = 'Spiacenti, non si accettano altri commenti per questo articolo.';
$lang_article_notfound = 'Non riesco a trovare un articolo con id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Lascia un commento';
$lang_archive_notopen = 'Non riesco ad aprire la cartella ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "<h2>Cerca...</h2>";
$lang_search_news = "Articolo";
$lang_search_title = "Titolo";
$lang_search_author = "Scritto da";
$lang_search_from = "Cerca da";
$lang_search_to = "Cerca fino a";
$lang_search_archives = "Cerca negli archivi";
$lang_search_advanced = "Ricerca avanzata..";
$lang_search_cnoarch = "Non riesco ad aprire " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Ecco gli articoli che soddisfano la tua ricerca!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Non ho trovato <strong>nessun</strong> articolo che soddisfa la tua ricerca.";
$lang_search_button = "Cerca!";

## Date
$lang_dates = array(
year => "anno",
month => "mese",
week => "settimana",
day => "giorno",
hour => "ora",
minute => "minuto",
second => "secondo",

 plural =>
  array(
   year => "anni",
   month => "mesi",
   week => "settimane",
   day => "giorni",
   hour => "ore",
   minute => "minuti",
   second => "secondi",
   ),

monday => "luned&igrave;",
tuesday => "marted&igrave;",
wednesday => "mercoled&igrave;",
thursday => "gioved&igrave;",
friday => "venerd&igrave;",
saturday => "sabato",
sunday => "domenica",

january => "gennaio",
february => "febbraio",
march => "marzo",
april => "aprile",
may => "maggio",
june => "giunio",
july => "luglio",
august => "agosto",
september => "settembre",
october => "ottobre",
november => "novembre",
december => "dicembre",
);
?>
