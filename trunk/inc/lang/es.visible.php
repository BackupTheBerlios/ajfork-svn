<?php
/*
Languagefile: Spanish
Language Name: Español
Author: Heitor Real (Xamataca)
Author URI: http://www.oclube.com/
Author Email: xamataca@oclube.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'La protección anti-flood está activada - tendrás que esperar ' . htmlentities($config_flood_time) . ' segundos después de tu último comentario antes de poder volver a comentar..';
$lang_blocked = 'Lo sentimos, tu dirección IP ha sido bloqueada para poder comentar.';
$lang_commentregistered = 'Este Nombre/Apodo está registrado, por favor, escribe tu clave para probar tu identidad.';
$lang_commentregisteredbutton = 'Guardar comentario';
$lang_onlyregistered = 'Lo sentimos, solo los/as miembros registrados/as pueden escribir comentarios, y ' . htmlentities($name) . ' no está registrado.';
$lang_comment_needname = 'Tienes que escribir un Nombre/Apodo..<br /><a href="javascript:history.go(-1)">volver</a>';
$lang_comment_invalidmail = 'Has escrito un eMail incorrecto.<br /><a href="javascript:history.go(-1)">volver</a>';
$lang_comment_needvalidmail = 'No has escrito un eMail o URL correcto.<br /><a href="javascript:history.go(-1)">volver</a>';
$lang_comment_notblank = 'El campo \"comentario\" no puede estar vacío.<br /><a href="javascript:history.go(-1)">volver</a>';
$lang_comment_notaccepted = 'Lo sentimos, no se aceptan más comentarios en este momento.';
$lang_article_notfound = 'No se pudo encontrar el artículo con la id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Haz click aquí para comentar';
$lang_archive_notopen = 'No se pudo abrir la carpeta ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "<h2>Buscar...</h2>";
$lang_search_news = "Artículo";
$lang_search_title = "Título";
$lang_search_author = "Escrito por";
$lang_search_from = "Buscar desde";
$lang_search_to = "Buscar hasta";
$lang_search_archives = "Buscar en Archivos";
$lang_search_advanced = "Avanzado..";
$lang_search_cnoarch = "No se pudo abrir " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Se encontraron artículos coincidentes con la búsqueda!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "<strong>No</strong> se encontaron artículos coincidentes con la búsqueda.";
$lang_search_button = "Buscar!";

## Date
$lang_dates = array(
year => "año",
month => "mes",
week => "semana",
day => "dia",
hour => "hora",
minute => "minuto",
second => "segundo",

 plural =>
  array(
   year => "años",
   month => "meses",
   week => "semanas",
   day => "dias",
   hour => "horas",
   minute => "minutos",
   second => "segundos",
   ),

monday => "Lunes",
tuesday => "Martes",
wednesday => "Miércoles",
thursday => "Jueves",
friday => "Viernes",
saturday => "Sábado",
sunday => "Domingo",

january => "enero",
february => "febrero",
march => "marzo",
april => "abril",
may => "mayo",
june => "junio",
july => "julio",
august => "agosto",
september => "septiembre",
october => "octubre",
november => "noviembre",
december => "diciembre",
);
?>
