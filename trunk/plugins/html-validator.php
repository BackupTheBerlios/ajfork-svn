<?php
/*
Plugin Name:	HTML validity checker
Description:	Using validator.w3.org, this plugin checks if your site is valid.
Version:		1.0
Author:			J-Dawg
Author URI:		http://www.jubbag.com
Application:	CuteNews
Required Framework: 1.0.0
*/

@add_action('system-check','validity');

function validity($hook) {
	global $config_http_home_url;
	$w3c = file_get_contents("http://validator.w3.org/check?uri=".urlencode($config_http_home_url));
	preg_match_all('/<h2[^>]*>(.*)<\/h2>/si',$w3c,$matches,PREG_SET_ORDER);
	foreach ($matches as $null => $match)
	{
		$thispage = array("This Page", "This page");
		$match[1] = str_replace($thispage,'<a href="'.$config_http_home_url.'">'.$config_http_home_url.'</a>',$match[1]);
		$match[1] = str_replace("not",'<a href="http://validator.w3.org/check?uri='.urlencode($config_http_home_url).'">not</a>',$match[1]);
		echo '<tr><td height="1" valign="middle" colspan="4" align="center">'.$match[1]."</td></tr>";
	}
}
?>
