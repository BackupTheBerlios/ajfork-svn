<?php

/*
Plugin Name: Search Hilite
Plugin URI: http://wordpress.org/
Description: When someone is referred from a search engine like Google or AJ-Fork's internal search engine, the terms they search for are highlighted with this plugin. You'll have to add the css class "hilite" to your stylesheet manually for this to work.
Version: 1.2
Required Framework: 1.1.5
Application: CuteNews
Author: Ryan Boren
Author URI: http://rboren.nu
*/ 

@add_filter('news-entry-content', 'hilite');
@add_filter('news-comment-content', 'hilite');

/* Highlighting code c/o Ryan Boren */
function get_search_query_terms($engine = 'google') {
    global $s, $s_array, $aj_search;
	$referer = urldecode($_SERVER[HTTP_REFERER]);
	$query_array = array();
	switch ($engine) {
	case 'google':
		// Google query parsing code adapted from Dean Allen's
		// Google Hilite 0.3. http://textism.com
		$query_terms = preg_replace('/^.*q=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

	case 'lycos':
		$query_terms = preg_replace('/^.*query=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

	case 'yahoo':
		$query_terms = preg_replace('/^.*p=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

    case 'fork':
		$query_terms = $aj_search;
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;
     }

	return $query_array;
}

function is_referer_search_engine($engine = 'google') {
	global $aj_search;
	$referer = urldecode($_SERVER['HTTP_REFERER']);
    //echo "referer is: $referer<br />";
	if ( ! $engine ) {
		return 0;
	}

	switch ($engine) {
	case 'google':
		if (preg_match('|^http://(www)?\.?google.*|i', $referer)) {
			return 1;
		}
		break;

    case 'lycos':
		if (preg_match('|^http://search\.lycos.*|i', $referer)) {
			return 1;
		}
        break;

    case 'yahoo':
		if (preg_match('|^http://search\.yahoo.*|i', $referer)) {
			return 1;
		}
        break;
        
    case 'fork':
		if ($aj_search != "") {
			return 1;
		}
        break;
	}

	return 0;
}

function hilite($text) {
	$search_engines = array('google', 'lycos', 'yahoo', 'fork');

	foreach ($search_engines as $null => $engine) {
		if ( is_referer_search_engine($engine)) {
			$query_terms = get_search_query_terms($engine);
			foreach ($query_terms as $null => $term) {
				if (!empty($term) && $term != ' ') {
					if (!preg_match('/<.+>/',$text)) {
						$text = preg_replace('/(\b'.$term.'\b)/i','<span class="hilite">$1</span>',$text);
					} else {
						$text = preg_replace('/(?<=>)([^<]+)?(\b'.$term.'\b)/i','$1<span class="hilite">$2</span>',$text);
					}
				}
			}
			break;
		}
	}

	return $text;
}

?>
