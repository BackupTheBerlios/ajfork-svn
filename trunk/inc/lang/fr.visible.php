<?php
/*
Languagefile: French
Language Name: Français
Author: Anonymous (Colzilla)
Author URI: http://www.ex-ovo.com/
Author Email: littleprincess@ex-ovo.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Protection anti-spam activée - vous devez attendre ' . htmlentities($config_flood_time) . ' secondes après votre dernier commentaire avant de poster à nouveau...';
$lang_blocked = 'Désolé, votre IP a été bloqué, vous ne pouvez pas poster de commentaires.';
$lang_commentregistered = 'Ce nom est enregistré, merci de fournir votre mot de passe afin de prouver votre identité.';
$lang_commentregisteredbutton = 'Sauvegardez le commentaire';
$lang_onlyregistered = 'Désolé, seuls les membres enregistrés peuvent écrire, et ' . htmlentities($name) . 'n\'est pas enregistré.';
$lang_comment_needname = 'Vous devez fournir un nom..<br /><a href="javascript:history.go(-1)">retour</a>';
$lang_comment_invalidmail = 'Votre adresse email est invalide.<br /><a href="javascript:history.go(-1)">retour</a>';
$lang_comment_needvalidmail = 'Vous n\'avez pas fourni un email ou une url valide.<br /><a href="javascript:history.go(-1)">retour</a>';
$lang_comment_notblank = 'Le champ du commentaire ne peut pas être vide.<br /><a href="javascript:history.go(-1)">retour</a>';
$lang_article_notfound = 'Impossible de trouver l\'article mentionnant: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Commentez ici';
$lang_archive_notopen = 'Impossible d\'ouvrir le dossier ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Recherche...";
$lang_search_news = "Article";
$lang_search_title = "Titre";
$lang_search_author = "Ecrit par";
$lang_search_from = "Rechercher de";
$lang_search_to = "Rechercher à";
$lang_search_archives = "Rechercher dans les archives";
$lang_search_advanced = "Avancé..";
$lang_search_cnoarch = "Impossible d\'ouvrir " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Articles correspondants à votre requête!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Aucun</strong> article ne correspond à votre requête.";
$lang_search_button = "Cherchez!";

## Date
$lang_and = "et";
$lang_dates = array(
year => "année",
month => "mois",
week => "semaine",
day => "jour",
hour => "heure",
minute => "minute",
second => "seconde",

 plural =>
  array(
   year => "années",
   month => "mois",
   week => "semaines",
   day => "jours",
   hour => "heures",
   minute => "minutes",
   second => "secondes",
   ),
	);

$lang_days = array(
monday => "lundi",
tuesday => "mardi",
wednesday => "mercredi",
thursday => "jeudi",
friday => "vendredi",
saturday => "samedi",
sunday => "dimanche",
);

$lang_months = array(
january => "janvier",
february => "février",
march => "mars",
april => "avril",
may => "mai",
june => "juin",
july => "juillet",
august => "août",
september => "septembre",
october => "octobre",
november => "novembre",
december => "décembre",
);
?>
