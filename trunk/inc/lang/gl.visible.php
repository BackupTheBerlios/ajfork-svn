<?php
/*
Languagefile: Galician
Language Name: Galego
Author: Heitor Real (Xamataca)
Author URI: http://www.oclube.com
Author Email: xamataca@oclube.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'A protección anti-flood está activada - terás que agardar ' . htmlentities($config_flood_time) . ' segundos despois do teu último comentário para poderes facelo outra vez..';
$lang_blocked = 'Sentímolo, a tua dirección IP foi bloqueada e non podes engadir comentarios.';
$lang_commentregistered = 'Este Nome/Alcume, por favor, escrebe a tua clave para probar a tua identidade.';
$lang_commentregisteredbutton = 'gardar comentário';
$lang_onlyregistered = 'Sentímolo, só os membros/as rexistrados/as poden escreber comentários, e ' . htmlentities($name) . ' non está rexistrado.';
$lang_comment_needname = 'Tés que escreber o teu Nome/Alcume..<br /><a href="javascript:history.go(-1)">voltar</a>';
$lang_comment_invalidmail = 'Escrebeches un eMail incorrecto.<br /><a href="javascript:history.go(-1)">voltar</a>';
$lang_comment_needvalidmail = 'Non escrebeches unha URL ou eMail correctos.<br /><a href="javascript:history.go(-1)">voltar</a>';
$lang_comment_notblank = 'O campo \"comentário\" non pode estar valeiro.<br /><a href="javascript:history.go(-1)">voltar</a>';
$lang_comment_notaccepted = 'Sentímolo, non se aceptan máis comentários neste momento.';
$lang_article_notfound = 'Non se puido atopar o artigo coa id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Preme aquí para comentar';
$lang_archive_notopen = 'Non se puido abrir a carpeta ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "<h2>Pesquisar...</h2>";
$lang_search_news = "Artigo";
$lang_search_title = "Título";
$lang_search_author = "Escrito por";
$lang_search_from = "Pesquisar dende";
$lang_search_to = "Pesquisar ate";
$lang_search_archives = "Pesquisar nos Arquivos";
$lang_search_advanced = "Avanzado..";
$lang_search_cnoarch = "Non se puido abrir " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Atoparon-se artigos coincidentes co critério da pesquisa!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>Non</strong>se atoparon artigos coincidentes co critério da pesquisa.";
$lang_search_button = "Pesquisar!";

## Date
$lang_dates = array(
year => "ano",
month => "mes",
week => "semana",
day => "dia",
hour => "hora",
minute => "minuto",
second => "segundo",

 plural =>
  array(
   year => "anos",
   month => "meses",
   week => "semanas",
   day => "dias",
   hour => "horas",
   minute => "minutos",
   second => "segundos",
   ),

monday => "Luns",
tuesday => "Martes",
wednesday => "Mércores",
thursday => "Xoves",
friday => "Venres",
saturday => "Sábado",
sunday => "Domingo",

january => "xaneiro",
february => "febreiro",
march => "marzo",
april => "abril",
may => "maio",
june => "xuño",
july => "xullo",
august => "agosto",
september => "setembro",
october => "outubro",
november => "novembro",
december => "decembro",
);
?>
