<?php

/*
Plugin Name: Enable/Disable Comments
Plugin URI: http://www.brandedthoughts.co.uk/cutewiki/index.php/Enable_Disable_Comments_Plugin
Description: Allows enabling/disabling of comments on a post-per-post basis.
Version: 2.0
Required Framework: 1.1.5
Application: CuteNews
Author: Øivind Hoel
Author URI: http://appelsinjuice.org/
*/

define('EDC_COMMENTS_XFIELD','comments');
define('EDC_DEFAULT_VALUE','on');
define('EDC_STOP_DEFAULT_VALUE','no');
define('EDC_STOPCOMMENTS_FIELD','commentsstop');

@add_action('edit-advanced-options','edc_checkbox');
@add_action('new-advanced-options','edc_checkbox');
@add_action('new-save-entry','edc_save');
@add_action('edit-save-entry','edc_save');
@add_filter('news-show-comments','edc_comments'); 
@add_filter('news-entry','edc_display',10);
@add_filter('template-variables-full','edc_addfullvariable'); 
@add_filter('add-comment-box', 'edc_stopcomments');
@add_filter('news-allow-comment', 'edc_stopadd');

# get saved value for an entry (or set default if new)
function edc_getsavedvalue($item_db = FALSE, $old_db_arr = FALSE, $added_time = FALSE) {
	global $endiscomments, $stopcomments;
	if ($added_time) {
		if ($endiscomments != "on") {
			$endiscomments = "off";
			}
		if ($stopcomments != "yes") {
			$stopcomments = "no";
			}
		}
	elseif ($item_db) {
		$news_id = $item_db[0];
		$xfields = new XfieldsData();
		$endiscomments = $xfields->fetch($news_id, EDC_COMMENTS_XFIELD);
		$stopcomments = $xfields->fetch($news_id, EDC_STOPCOMMENTS_FIELD);
		}
	elseif ($old_db_arr) {
		if ($endiscomments != "on") {
			$endiscomments = "off";
			}
		if ($stopcomments != "yes") {
			$stopcomments = "no";
			}
		}
	if (!$endiscomments) { $endiscomments = EDC_DEFAULT_VALUE; }
	if (!$stopcomments) { $stopcomments = EDC_STOP_DEFAULT_VALUE; }
	$return = array(
		allow => $endiscomments,
		stop => $stopcomments,
		added => $added_time,
		edit => $old_db_arr[0],
		);
	return $return;
}

#print the advanced options checkboxes
function edc_checkbox($hook) {
	global $added_time;
	global $item_db;
	$value = edc_getsavedvalue($item_db, "", $added_time);
	if ($value[allow] == "on") { $checked = "checked=\"checked\""; }
	if ($value[stop] == "yes") { $checked2 = "checked=\"checked\""; }

	if ($hook = "edit-advanced-options") {
		# insert checkbox to close comments here
		}
		
	return "<div>
		<input type=\"checkbox\" id=\"endiscomments\" name=\"endiscomments\" value=\"on\" $checked />
		<label for=\"endiscomments\">Show comments</label><br />
		<input type=\"checkbox\" id=\"stopcomments\" name=\"stopcomments\" value=\"yes\" $checked2 />
		<label for=\"stopcomments\">Stop commenting</label><br />
		</div>";

}

# save comment status for an article
function edc_save() {
	global $added_time;
	global $old_db_arr;
	global $item_db;
	$allow = edc_getsavedvalue("", $old_db_arr, $added_time);
	$xfields = new XfieldsData();
	if ($allow[added]) { $news_id = $allow[added]; } 
	else { $news_id = $allow[edit]; } 
	if ($allow[edit] && $item_db[0] != $old_db_arr[0]) {
		$news_id = $item_db[0];
		$xfields = new XfieldsData();
		$xfields->delete($news_id);
		$xfields->save();
		$news_id = $allow[edit];
		}
	$xfields->set($allow[allow], $news_id, EDC_COMMENTS_XFIELD);
	$xfields->set($allow[stop], $news_id, EDC_STOPCOMMENTS_FIELD);
	$xfields->save();
}

# parses templates - removes comment links if appropriate
function edc_display($output, $hook) {
	global $news_arr, $allow_full_story, $allow_active_news;
	$allow = edc_getsavedvalue($news_arr, "", "");
	if ($allow[allow] == "on" and $allow_full_story) { $output = preg_replace("'\[comheader\](.*?)\[/comheader\]'", "\\1", $output); }
	elseif ($allow_full_story) { 
		$output = preg_replace("'\[comheader\](.*?)\[/comheader\]'", "", $output);
		# insert code to remove comments if xfield set here.
		}
	elseif ($allow[allow] == "on" and $allow_active_news) {	return $output;	}
	else { 
		$output = preg_replace("'\[com-link\](.*?)\[/com-link\]'i", "", $output); 
		$output = preg_replace("'\[humancomlink\](.*?)\[/humancomlink\]'i", "", $output);}
	return $output;
}

function edc_comments($allowcomments) {
	global $news_arr;
	$allow = edc_getsavedvalue($news_arr, "", "");
	if ($allow[allow] == "on") {
		return $allowcomments;
		}
	else { 
		return FALSE; 
		}
}

# add the comheader template variable
function edc_addfullvariable($variables) {
	$variables["[comheader]...[/comheader]"] = "Displays ... before comments are displayed";
	return $variables;
	}

# kills the comment form if comments are stopped
function edc_stopcomments($template) {
	global $id, $lang_comment_notaccepted;
	$xfields = new XfieldsData();
	$stopcomments = $xfields->fetch($id, EDC_STOPCOMMENTS_FIELD);

	if ($stopcomments == "yes") {
		if ($lang_comment_notaccepted) { $template = $lang_comment_notaccepted; }
		else { $template = "Sorry, no more comments accepted at this time..."; }
		}
	return $template;
}


# stops all attempts to add comments to a disabled/stopped entry.
function edc_stopadd($allow_add_comment) {
	global $id;
	$xfields = new XfieldsData();
	$stop = $xfields->fetch($id, EDC_STOPCOMMENTS_FIELD);
	$allow = $xfields->fetch($id, EDC_STOPCOMMENTS_FIELD);

	if ($stop == "yes" or $allow == "off") {
		$allow_add_comment = false;
		}
	return $allow_add_comment;
}
?>
