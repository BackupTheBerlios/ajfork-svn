<?php

/*
Plugin Name:	Easy Date Format
Plugin URI:		http://www.cutephp.com/forum/index.php?showtopic=118&amp;view=findpost&amp;p=510
Description:	Allows you to specify custom date formats: <code>{date=j M Y}</code>. Any <a href="http://www.php.net/date">PHP Date</a> format can be used.
Version:		1.0
Author:			David Carrington
Author URI:		http://www.brandedthoughts.co.uk
Application:	CuteNews
Required Framework: 1.0.0
*/

@add_filter('news-entry','easy_date_format_replace');

function easy_date_format_replace($entry,$hook) {
	global $news_arr, $config_date_adjust;
	
	// Create a regular expression
	$find = '#\{date=(.*?)\}#i';
	
	// Find all occurences of the regular expression
	preg_match_all($find,$entry,$matches,PREG_SET_ORDER);
	
	
	// If matches were found
	if (!empty($matches))
		// Loop through all the matches
		foreach ($matches as $null => $match)
			// Replaces current match with the correct date format
			$entry = str_replace($match[0],date($match[1],$news_arr[0] + ($config_date_adjust*60)), $entry);

	// return the newly formatted entry
	return $entry;
}

?>
