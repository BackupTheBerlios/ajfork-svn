<?php

/*
Plugin Name:	Count Article Views
Description:	Creates a new template code: <code>{views}</code> which shows a count of how many times the article has been viewed.
Version:		1.0
Author:			David Carrington
Author URI:		http://www.brandedthoughts.co.uk
Application:	CuteNews
Required Framework: 1.1.0
*/

@add_filter('news-entry','count_article_views');
@add_action('news-fullstory-page','increment_article_views');


// define the name of the xfield to store the information
define('VIEW_COUNT_XFIELD','view_count');

function count_article_views($entry,$hook) {
	global $news_arr;

	// define the new template code
	$template_code = '{views}';

	// get the current news ID
	$news_id = $news_arr[0];

	// Load all the xfield data
	$xfields = new XfieldsData();

	// Get the counter value for the current news ID
	$view_count = (int) $xfields->fetch($news_id, VIEW_COUNT_XFIELD);

	// replace the template code with the number of views
	$entry = str_replace($template_code, $view_count, $entry);

	// return the newly formatted entry
	return $entry;
}

function increment_article_views($hook) {
	global $news_arr;

	// get the current news ID
	$news_id = $news_arr[0];

	// Load the counters
	$xfields = new XfieldsData();

	// Increment the counter value
	$xfields->increment($news_id, VIEW_COUNT_XFIELD);

	// Save the counters
	$xfields->save();
}

?>
