<?php
/*
Languagefile: 1337
Language Name: 1337 English
Author: JubbaG
Author URI:	http://www.jubbag.com/
Author Email: jubbag@gmail.com
For Version: 168
*/

## shows.inc.php
$lang_floodprot = '5u><00rs, f100d-pr073c710n 15 0n - j00\'ll h4v3 t0 wa1t ' . htmlentities($config_flood_time) . ' 53c0nd5 4f73r j00r l457 c0mm3|\|t b4 j00 c4n p0t5 4g41n!!!1111';
$lang_blocked = 'l00z0r, j00r 1P h45 b33n b10ck\'d fr0m p0751n6 c0mm3nts.';
$lang_commentregistered = '7h15 u53rn4m3 15 pr0t3c7ed. 3n73r j00r p4zzw0rd';
$lang_commentregisteredbutton = '54v3 c0mm3n7';
$lang_onlyregistered = '50rry, n00b, 0n1y r3g1573r3d m3m83r5 c4n wr173 c0mme7ns, 4nd ' . htmlentities($name) . ' 15 n07 r3g1573r\'d.';
$lang_comment_needname = 'j00 h4v3 t0 5upp1y 4 n4m3..<br /><a href="javascript:history.go(-1)">60 b4ck</a>';
$lang_comment_invalidmail = 'j00 5uppli3d 4n 1nv4lid 3m41l-4ddr355.<br /><a href="javascript:history.go(-1)">60 b4ck</a>';
$lang_comment_needvalidmail = 'j00 d1dn\'7 5upply 4 v4l1d 3m4il 0r URL.<br /><a href="javascript:history.go(-1)">g0 b4ck</a>';
$lang_comment_notblank = '73h c0mm3n7-f13ld c4nn07 b3 3mp7y.<br /><a href="javascript:history.go(-1)">60 b4ck</a>';
$lang_comment_notaccepted = '50rry, n0 m0r3 c0mm3n75 4cc3p73d 47 7h15 71m3.';
$lang_article_notfound = 'j00 h4ck1n. 41n\'7 n0 4r71cl3 w17h 1D: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'C1ick h3r3 70 c0mm3n7';
$lang_archive_notopen = '73h f0d13r ' . htmlentities($cutepath) . '/data/archives c0u1dn\'7 b3 0p3n3d';

## search.php
$lang_search_header = "534rch...";
$lang_search_news = "4r73cl3";
$lang_search_title = "717l3";
$lang_search_author = "Wr1773n by";
$lang_search_from = "534rch fr0m";
$lang_search_to = "534rch t0";
$lang_search_archives = "534rch 1n 4rch1v35";
$lang_search_advanced = "4dv4nc3d..";
$lang_search_cnoarch = '73h f0d13r ' . htmlentities($cutepath) . '/data/archives c0u1dn\'7 b3 0p3n3d';
$lang_search_found = "<strong>F0udn 4r71cl35 m47ch1ng j00r qu3ry!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "F0und <strong>n0</strong> 4rt1cl35 m47ch1ng j00r qu3ry.";
$lang_search_button = "534rch!";

## Date
$lang_and = "4nd";
$lang_dates = array(
	year => "y34r",
	month => "m0n7h",
	week => "w33k",
	day => "d4y",
	hour => "h0ur",
	minute => "m1nu73",
	second => "s3c0nd",
	
		plural => 
			array(
				year => "y34r5",
				month => "m0n7h5",
				week => "w33k5",
				day => "d4y5",
				hour => "h0ur5",
				minute => "m1nu735",
				second => "s3c0nd5",
				),
		);

$lang_days = array(
	monday => "m0nd4y",
	tuesday => "7u35d4y",
	wednesday => "w3dn35d4y",
	thursday => "7hur5d4y",
	friday => "fr1d4y",
	saturday => "547urd4y",
	sunday => "5und4y",
);

$lang_months = array(
	january => "j4nu4ry",
	february => "f3bru4ry",
	march => "m4rch",
	april => "4pr1l",
	may => "m4y",
	june => "j00n",
	july => "ju1y",
	august => "4ugu57",
	september => "5ep73mb3r",
	october => "0c7083r",
	november => "n0v3mb3r",
	december => "d3c3mb3r",
	);
?>
