<?php
/*
Languagefile: English
Language Name: UK English
Author: Øivind Hoel
Author URI:	http://appelsinjuice.org/
Author Email: oivind.hoel@appelsinjuice.org
For Version: 168
*/

## shows.inc.php
$lang_floodprot = 'Flood-protection is on - you\'ll have to wait ' . htmlentities($config_flood_time) . ' seconds after your last comment before you can post again..';
$lang_blocked = 'Sorry, your ip has been blocked from posting comments.';
$lang_commentregistered = 'This name is registered, please supply your password to prove your identity.';
$lang_commentregisteredbutton = 'Save comment';
$lang_onlyregistered = 'Sorry, only registered members can write comments, and ' . htmlentities($name) . ' is not registered.';
$lang_comment_needname = 'You have to supply a name..<br /><a href="javascript:history.go(-1)">go back</a>';
$lang_comment_invalidmail = 'You supplied an invalid email-address.<br /><a href="javascript:history.go(-1)">go back</a>';
$lang_comment_needvalidmail = 'You haven\'t supplied a valid email or URL.<br /><a href="javascript:history.go(-1)">go back</a>';
$lang_comment_notblank = 'The comment-field cannot be empty.<br /><a href="javascript:history.go(-1)">go back</a>';
$lang_comment_notaccepted = 'Sorry, not more comments accepted at this time.';
$lang_article_notfound = 'Could not find article with id: <strong>' . htmlentities($id) . '</strong>';
$lang_article_linktext = 'Click here to comment';
$lang_archive_notopen = 'Couldn\'t open folder ' . htmlentities($cutepath) . '/data/archives';

## search.php
$lang_search_header = "Search...";
$lang_search_news = "Article";
$lang_search_title = "Title";
$lang_search_author = "Written by";
$lang_search_from = "Search from";
$lang_search_to = "Search to";
$lang_search_archives = "Search in archives";
$lang_search_advanced = "Advanced..";
$lang_search_cnoarch = "Couldn't open " . htmlentities($cutepath) . "/data/archives";
$lang_search_found = "<strong>Found articles matching your query!</strong><br />";
$lang_search_founddate = " ";
$lang_search_notfound = "Found <strong>no</strong> articles matching your query.";
$lang_search_button = "Search!";

## Date
$lang_and = "and";
$lang_dates = array(
	year => "year",
	month => "month",
	week => "week",
	day => "day",
	hour => "hour",
	minute => "minute",
	second => "second",
	
		plural => 
			array(
				year => "years",
				month => "months",
				week => "weeks",
				day => "days",
				hour => "hours",
				minute => "minutes",
				second => "seconds",
				),
		);

$lang_days = array(
	monday => "monday",
	tuesday => "tuesday",
	wednesday => "wednesday",
	thursday => "thursday",
	friday => "friday",
	saturday => "saturday",
	sunday => "sunday",
);

$lang_months = array(
	january => "january",
	february => "february",
	march => "march",
	april => "april",
	may => "may",
	june => "june",
	july => "july",
	august => "august",
	september => "september",
	october => "october",
	november => "november",
	december => "december",
	);
?>
