<?php

/*
Plugin Name: Format Switcher
Plugin URI: http://www.brandedthoughts.co.uk/cutewiki/index.php/Format_Switcher_Plugin
Description: Allows users to select different output formats. Can be extended to handle many formats such as Textile, MarkDown, etc.
Version: 1.0
Required Framework: 1.1.3
Application: CuteNews
Author: David Carrington
Author URI: http://www.brandedthoughts.co.uk
*/

define('FS_FORMAT_XFIELD','fs_format');
define('FS_DEFAULT_FORMAT','Markdown');


@add_action('edit-advanced-options', 'fs_FormatSelectBox');
@add_action('new-advanced-options', 'fs_FormatSelectBox');
@add_action('new-save-entry','fs_SaveFormat');
@add_action('edit-save-entry','fs_SaveFormat');

@add_filter('news-entry-content','fs_ApplyFormat', 10);
@add_filter('news-comment-content','fs_ApplyFormat', 10);
@add_filter('news-profile-content','fs_ApplyFormat', 10);

function fs_FormatDropDownOptions() {
	global $fs_formats, $item_db;

	if ($item_db[0]) {
		$news_id = $item_db[0];

		$xfields = new XfieldsData();

		$format = $xfields->fetch($news_id, FS_FORMAT_XFIELD);

		$item_db[3] = str_replace('{nl}',"\n", $item_db[3]);
		$item_db[4] = str_replace('{nl}',"\n", $item_db[4]);

	} else {
		$format = $_POST['fs_format'] ? $_POST['fs_format'] : FS_DEFAULT_FORMAT;
	}

	$buffer = '';
	if (!empty($fs_formats))
		foreach ($fs_formats as $fs_name => $fs_function)
			$buffer .= '<option value="'.$fs_name.'"'.($format == $fs_name ? ' selected="selected"' : '').'>'.$fs_name.'</option>';
	return $buffer;
}

function fs_FormatSelectBox($hook) {
	$buffer = '
	<tr>

		<td>
		<label for="cboFS_Format">Format</label><br />
		<select name="fs_format" id="cboFS_Format">'.fs_FormatDropDownOptions().'</select></td>
	</tr>
';
	return $buffer;
}

function fs_SaveFormat($hook) {
	global $added_time, $old_db_arr;

	if ($added_time)
		$news_id = $added_time; // new
	else
		$news_id = $old_db_arr[0]; // edit

	$format = stripslashes($_POST['fs_format']);

	$xfields = new XfieldsData();

	$xfields->set($format ,$news_id, FS_FORMAT_XFIELD);

	$xfields->save();
}

function fs_ApplyFormat($content, $hook) {
	global $news_arr, $id, $fs_formats;

	if (isset($_POST['fs_format']))
		$format = $_POST['fs_format'];
	else {
		// get the current news ID
		$news_id = $news_arr[0];

		# fix for comments
		if (!$news_id or $news_id == "") {
			$news_id = $id;
			}

		// Load all the xfield data
		$xfields = new XfieldsData();

		// Get the Format for the current news ID
		$format = $xfields->fetch($news_id, FS_FORMAT_XFIELD);
	}

	// Get the function name
	$format_function = $fs_formats[$format];

	// Swap the strange formatting thing
	$content = str_replace('{nl}',"\n", $content);

	if (!$format_function || !function_exists($format_function))
		$format_function = $fs_formats[FS_DEFAULT_FORMAT];


	// Run the formatting function
	$content = $format_function($content);

	return $content;
}


/* Default formats */

$GLOBALS['fs_formats']['Plain'] = 'fs_Plain';
$GLOBALS['fs_formats']['HTML'] = 'fs_HTML';

function fs_Plain($content) {
	$content = htmlentities($content);

	$content = str_replace("\n",'<br />', $content);

	return '<p>'.$content.'</p>';
}

function fs_HTML($content) {
	return $content;
}

?>
