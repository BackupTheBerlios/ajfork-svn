<?php

/*
Plugin Name:	Filter By Author
Plugin URI:		http://www.cutephp.com/forum/index.php?showtopic=37&amp;view=findpost&amp;p=540
Description:	Allows the news to be filtered by author.
Version:		1.0
Author:			David Carrington
Author URI:		http://www.brandedthoughts.co.uk
Application:	CuteNews
Required Framework: 1.0.0
*/

@add_filter('news-recordset','filter_by_author');


function filter_by_author($news_rs, $hook) {
	global $filters;
	
	
	
	// if the user has defined some filters
	if ($filters)
	
		// loop through all the news
		foreach ($news_rs as $id => $news_item) {
		
			// split up the news data
			list($date, $author, $title, $short, $long, $avatar, $category_id, $u1, $u2) = explode('|',$news_item);
			
			// if an author filter has been defined then check if the current news author is the same as the filter
			if (isset($filters[author]) && $author != $filters[author])
			
				// author doesn't match, filter out that author
				unset($news_rs[$id]);
		}
	
	
	
	// return the filtered news
	return $news_rs;
}



?>
