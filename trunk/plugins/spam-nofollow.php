<?php

/*
Plugin Name:		Google Nofollow
Plugin URI:		http://appelsinjuice.org/
Description:		Adds rel="nofollow" to links submitted by commenters. This is <a href="http://www.google.com/googleblog/2005/01/preventing-comment-spam.html">an initiative by google</a> to combat comment spam on blogs. Google won't index links with this attribute.
Version:		0.1
Author:			Øivind Hoel
Author URI:		http://appelsinjuice.org/
Required Framework: 	1.0.0

*/

@add_filter('news-comment-display-authorlink','nofollow_authorfilter');
@add_filter('news-comment-content','nofollow_authorfilter',50);

# Needs to work with trackbacks too, or we're facing the worst kind of spam...
# Doesn't add rel=nofollow to registered users

function nofollowfy($str) {

    # Manipulate hyperlinks in $str...

    if (!isset($str)) return $str;
    return preg_replace_callback('#<a\s([^>]*\s*href\s*=[^>]*)>#i', 'nofollowfy_cb', $str);
}

function nofollowfy_cb($matches) {
    $str = $matches[1];
    preg_match_all('/[^=[:space:]]*\s*=\s*"[^"]*"|[^=[:space:]]*\s*=\s*\'[^\']*\'|[^=[:space:]]*\s*=[^[:space:]]*/', $str, $attr);
    $rel_arr = preg_grep('/^rel\s*=/i', $attr[0]);
    if (count($rel_arr) > 0)
        $rel = array_pop($rel_arr);
    if ($rel) {
        $rel = preg_replace('/^(rel\s*=\s*[\'"]?)/i', '\1nofollow ', $rel);
    } else {
        $rel = 'rel="nofollow"';
    }
    $attr = preg_grep('/^rel\s*=/i', $attr[0], PREG_GREP_INVERT);
    return '<a ' . join(' ', $attr) . ' ' . $rel . '>';
}

function nofollow_authorfilter($str, $hook) {
	
	# Don't nerf registered users. They deserve pagerank boost.
	
	global $admin_posting;
	if ($admin_posting == TRUE) {
		return $str;
		}
	else {
		$str = nofollowfy($str);
		}
	return $str;
}

?>
