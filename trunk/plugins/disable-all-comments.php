<?php

/*
Plugin Name: Disable All Comments
Plugin URI: http://www.brandedthoughts.co.uk/cutewiki/index.php/Disable_All_Comments_Plugin
Description: Completely disables all commenting.
Version: 1.0
Required Framework: 1.1.4
Application: CuteNews
Author: David Carrington
Author URI: http://www.brandedthoughts.co.uk
*/

@add_filter('news-show-comments','disable_all_comments', 11);
@add_filter('news-entry','dac_display');
@add_filter('news-allow-comment','disable_all_comments', 11);

function disable_all_comments($allow, $h) {
	return false;
}

function dac_display($entry, $h) {
	$entry = preg_replace('{\[humancomlink\].*?\[/humancomlink\]}i', '', $entry);
	$entry = preg_replace('{\[com-link\].*?\[/com-link\]}i', '', $entry);
	$entry = preg_replace("'\[comheader\](.*?)\[/comheader\]'", "", $entry);
	// Compatibility with userfriendly urls (eruin)
	return $entry;

}

?>
