<?php
/*
Languagefile: Icelandic
Language Name: Íslenska
Author: Grimur Danielsson
Author URI:	http://www.half-life.is
Author Email: skizy@half-life.is
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flóð vörn er virk - þú þarft að bíða í ' . htmlentities($config_flood_time) . ' sekúntur þangað til þú getur skráð annað álit.';
$lang_blocked = 'Því miður þá hefur IP Talan þín verið bönnuð frá því að skrifa álit.';
$lang_commentregistered = 'Þetta notendanafn er þegar skráð, vinsamlegast sláðu inn lykilorð til að staðfesta eign þína á því.';
$lang_commentregisteredbutton = 'Senda Álit';
$lang_onlyregistered = 'Því miður þá geta aðeins skráðir notendur skrifað álit og notendanafnið ' . htmlentities($name) . ' er ekki skráð í notendagagnagrunninn.';
$lang_comment_needname = 'Þú þarft að skrifa notendanafn..<br /><a href="javascript:history.go(-1)">Til Baka</a>';
$lang_comment_invalidmail = 'You supplied an invalid email-address.<br /><a href="javascript:history.go(-1)">Til Baka</a>';
$lang_comment_needvalidmail = 'Þú hefur ekki skrifað gilt email/URL<br /><a href="javascript:history.go(-1)">Til Baka</a>';
$lang_comment_notblank = 'Skilaboða reiturinn getur ekki verið tómur.<br /><a href="javascript:history.go(-1)">Til Baka</a>';
$lang_comment_notaccepted = 'Því miður en það verða engin álit samþykkt núna.';
$lang_article_notfound = 'Gat ekki fundið grein með númeri: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Klikkaðu hér til að skrifa álit';
$lang_archive_notopen = 'Gat ekki opnað möppu ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Leita...";
$lang_search_news = "Grein";
$lang_search_title = "Titill";
$lang_search_author = "Höfundur:";
$lang_search_from = "Frá Dags";
$lang_search_to = "Til Dags";
$lang_search_archives = "Leita í eldri skrám";
$lang_search_advanced = "Ýtarleg Leit..";
$lang_search_cnoarch = "Gat ekki opnað " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Fann greinar sem pössuðu við leitarstrenginn!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Fann <strong>engar</strong> greinar sem pössuðu við leitarstrenginn .";
$lang_search_button = "Leita!";

## Date
$lang_and = "og";
$lang_dates = array(
	year => "ár",
	month => "mánuður",
	week => "vika",
	day => "dagur",
	hour => "klukkustund",
	minute => "mínúta",
	second => "sekúnta",
	
		plural => 
			array(
				year => "ár",
				month => "mánuðir",
				week => "vikur",
				day => "dagar",
				hour => "klukkustundir",
				minute => "mínútur",
				second => "sekúntur",
				),
		);

$lang_days = array(
	monday => "mánudagur",
	tuesday => "þriðjudagur",
	wednesday => "miðvikudagur",
	thursday => "fimmtudagur",
	friday => "föstudagur",
	saturday => "laugardagur",
	sunday => "sunnudagur",
);

$lang_months = array(
	january => "janúar",
	february => "febrúar",
	march => "mars",
	april => "apríl",
	may => "mai",
	june => "júní",
	july => "júlí",
	august => "ágúst",
	september => "september",
	october => "október",
	november => "nóvember",
	december => "desember",
	);
?>
