<?php

/*
Plugin Name: Prev and Next Link Text In Full Story
Plugin URI: http://www.jubbag.com
Description: Adds a link with the next and previous news stories with their title as the Link Text. Use {prevlink} and {nextlink}. Comes with formatting: << Previous | and | Next >>. Feel free to edit it in the code of the plugin. Based on code from <a href="http://cutephp.com/forum-old/index.php?showtopic=3690&hl=prev%20next&st=0">CuteNews Forum</a> by <a href="http://www.cncreneclips.com">Stealtheye</a>
Version: 0.7
Author:	J-Dawg
Author URI:	http://www.jubbag.com
Application: CuteNews
Required Framework: 1.0.0
*/
define('STAY_IN_CATEGORIES', 'true');
@add_filter('cutenews-options', 'PN_AddToOptions');
@add_action('plugin-options','PN_CheckAdminOptions');
@add_filter('news-show-generic','prev_next');


function prev_next($output,$hook)
{

	global $all_active_news, $active_news, $news_arr, $category, $ucat, $aj_plugins, $archive;
	$PN = new PluginSettings('Previous-Next');
	$catrestrict = $PN->settings['prevnext'];
	if (empty($catrestrict)) $catrestrict = STAY_IN_CATEGORIES;
	$prevnum = 1;
	$nextnum = 1;
	$thisnews = explode("|", $active_news);
	$thiscat = $thisnews[6];
	$all_active_news = array_reverse($all_active_news);
	$index = array_search($active_news, $all_active_news);
	if ($catrestrict == 'true')
	{
		do 
		{
			$prev = explode("|", $all_active_news[$index - $prevnum]);
			if (empty($prev[6]))
			{
				break;
			}
			$prevnum ++;
		}
		while ($thiscat != $prev[6]);
		do
		{
			$next = explode("|", $all_active_news[$index + $nextnum]);
			if (empty($next[6]))
			{
				break;
			}
			$nextnum ++;
		}
		while ($thiscat != $next[6]);
	}
	else
	{
		$next = explode("|", $all_active_news[$index + 1]);
		$prev = explode("|", $all_active_news[$index - 1]);
	}

# humanfriendly stuff
if (!$ucat && $category) { $ucat = $category; }

	$nid = aj_prepareTitle($next[2]);
	if($nid == "") { $nid = $next[0]; }
	$pid = aj_prepareTitle($prev[2]);
	if($pid == "") { $pid = $prev[0]; }

// Friendly urls w/ archive recognition
if (isset($GLOBALS['aj_plugins']['friendlyurls'])) { 
	$kat = aj_getCat($ucat);
	if (!$archive) {
		$next_link = "<a href=\"".date("Y/m/d/", $next[0])."$kat/$nid.html\">$next[2]</a>";
		$prev_link = "<a href=\"".date("Y/m/d/", $prev[0])."$kat/$pid.html\">$prev[2]</a>";
		}
	else {
	  	$furls = new PluginSettings('Userfriendly_URLs');
	  	$linkdata = $furls->settings['text']['0'];

		$next_link = "<a href=\"$linkdata[AR]/$archive/".date("Y/m/d/", $next[0])."$kat/$nid.html\">$next[2]</a>";
		$prev_link = "<a href=\"$linkdata[AR]/$archive/".date("Y/m/d/", $prev[0])."$kat/$pid.html\">$prev[2]</a>";
		}
	}
else {
	$next_link = "<a href='$PHP_SELF?aj_go=more&amp;id=$next[0]&amp;archive=$archive&amp;start_from=$start_from&amp;ucat=$ucat&amp;$user_query'>$next[2]</a>";
	$prev_link = "<a href='$PHP_SELF?aj_go=more&amp;id=$prev[0]&amp;archive=$archive&amp;start_from=$start_from&amp;ucat=$ucat&amp;$user_query'>$prev[2]</a>";
	}
	if (!empty($next[0]))
	{
		$output = str_replace("{nextlink}", $next_link, $output);
	}
	else
	{
		$output = str_replace("{nextlink}", "", $output);
	}
	if (!empty($prev[0]))
	{
		$output = str_replace("{prevlink}", $prev_link, $output);
	}
	else
	{
		$output = str_replace("{prevlink}", "", $output);
	}
	return $output;
	
}

function PN_CheckAdminOptions($hook) {
	// check if the user is requesting the PN options
		if ($_GET['action'] == 'PN')
			// show the PN admin screen
		PN_AdminOptions($hook);
}

function PN_AdminOptions($hook) {
	
	// Load the plugin settings
	$PN = new PluginSettings('Previous-Next');
	
	if (!empty($_GET['PN'])) {
		$PN->settings['prevnext'] = $_GET['PN'];
		$PN->save();
		msg('info','Previous Next Settings Saved', 'Your settings were saved successfully', '?mod=options&amp;action=PN');
	}
	
	// Display header
	echoheader('user','Previous Next Configuration');
	
	$catrestrict = $PN->settings['prevnext'];

	if (empty($catrestrict))
	{
		$catrestrict = STAY_IN_CATEGORIES;
	}
	if ($catrestrict == 'true')
	{
		$text = "Staying In Category<br />";
		$link = "false";
		$linktext = "Check all categories";
	}
	else
	{
		$text = "Checking all categories<br />";
		$link = "true";
		$linktext = "Stay In Category";
	}
	$buffer = $text.'<br /><a href="?mod=options&amp;action=PN&amp;subaction=save&amp;PN='.$link.'">'.$linktext.'</a>';	
	echo $buffer;	
	
	// Display footer
	echofooter();
}

function PN_AddToOptions($options, $hook) {
	global $PHP_SELF;

	// Add a custom screen to the "options" screen
	$options[] = array(
		'name'		=> 'Previous Next Options',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=PN',
		'access'	=> '1',
	);

	// return the customized options
	return $options;
}
?>
