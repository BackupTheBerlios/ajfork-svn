<?php

/*
Plugin Name:	Custom Quick Tags
Plugin URI:		http://www.brandedthoughts.co.uk/cutewiki/index.php/Custom_Quick_Tags_Plugin
Description:	Allows users to create custom "Quick Tags" that are available in news and/or comments.
Version:		1.0
Author:			David Carrington
Author URI:		http://www.brandedthoughts.co.uk
Required Framework: 1.1.2
Application:	CuteNews
*/

@add_filter('cutenews-options', 'cqt_AddToOptions');
@add_action('plugin-options','cqt_CheckAdminOptions');

@add_filter('news-entry-content','apply_cqt');
@add_filter('news-comment-content','apply_cqt');


function cqt_AddToOptions($options, $hook) {
	global $PHP_SELF;
	
	// Add a custom screen to the "options" screen
	$options[] = array(
		'name'		=> 'Custom Quick Tags',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=cqt',
		'access'	=> '1',
	);
	
	// return the customized options
	return $options;
}

// 
function cqt_CheckAdminOptions($hook) {
	// chek if the user is requesting the CQT options
	if ($_GET['action'] == 'cqt')
		// show the CQT admin screen
		cqt_AdminOptions();
}

function cqt_AdminOptions() {
	echoheader('user','Custom Quick Tags');
	
	$cqt = new PluginSettings('Custom_Quick_Tags');
	
	switch ($_GET['subaction']) {
		case 'edit':
			$tag = $cqt->settings['tags'][$_GET['id']];
		case 'add':
			$id = $tag ? '&amp;id='.$_GET['id'] : '';
			$buffer = '
	<p><a href="http://www.brandedthoughts.co.uk/cutewiki/index.php/Custom%20Quick%20Tags%20Plugin">Help</a></p>
	<form method="post" action="?mod=options&amp;action=cqt&amp;subaction=doadd'.$id.'" class="easyform">
		<div>
			<label for="txtName">Name</label>
			<input id="txtName" name="cqt[name]" value="'.$tag[name].'" />
		</div>
		<div>
			<label for="txtTag">Tag</label>
			<input id="txtTag" name="cqt[tag]" value="'.$tag[tag].'" />
		</div>
		<div>
			<label for="txtComplex">Complex</label>
			<input type="checkbox" id="txtComplex" name="cqt[complex]"'.($tag[complex] ? ' checked="checked"' : '').' value="true" />
		</div>
		<div>
			<label for="txtReplace">Replace</label>
			<textarea id="txtReplace" rows="2" name="cqt[replace]">'.$tag[replace].'</textarea>
		</div>
		<input type="submit" value="Save" />
	</form>';
			break;
		

		case 'delete':
			$tag = $cqt->settings['tags'][$_GET['id']];
			if ($tag[name])
				$buffer = '<p>Removed tag: <strong>'.$tag[name].'</strong></p>';
			unset($cqt->settings['tags'][$_GET['id']]);
			$cqt->save();
			break;


		case 'doadd':
			$tag = array(
				name	=> stripslashes($_POST[cqt][name]),
				tag		=> stripslashes($_POST[cqt][tag]),
				complex	=> stripslashes($_POST[cqt][complex]),
				replace	=> stripslashes($_POST[cqt][replace]),
			);
			
			if ($_GET['id'])
				$cqt->settings['tags'][$_GET['id']] = $tag;
			else
				$cqt->settings['tags'][] = $tag;
			
			$buffer = '<p>Saved tag: <strong>'.$_POST[cqt][name].'</strong></p>';
			$cqt->save();


		default:
			$buffer .= '
		<table class="grid" id="cqt_tags">
			<thead>
				<tr>
					<th>Name</th>
					<th>Tag</th>
					<th>Type</th>
					<th>Replace</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>';
			
			$tags = $cqt->settings['tags'];
			
			if (empty($tags)) {
				$buffer .= '<td colspan="5">No custom quick tags</td>';
			} else
				foreach ($cqt->settings['tags'] as $id => $tag) {
					$buffer .= '
				<tr>
					<td>'.$tag[name].'</td>
					<td>['.$tag[tag].']</td>
					<td>'.($tag[complex] ? 'Complex' : 'Simple' ).'</td>
					<td>'.htmlentities($tag[replace]).'</td>
					<td><a href="?mod=options&amp;action=cqt&amp;subaction=edit&amp;id='.$id.'">Edit</a> <a href="?mod=options&amp;action=cqt&amp;subaction=delete&amp;id='.$id.'">Delete</a></td>
				</tr>';
				}
			
			$buffer .= '
			<tbody>
		</table>
		<p><a href="?mod=options&amp;action=cqt&amp;subaction=add">Add</a></p>';
	}
	
	echo $buffer;
	
	echofooter();
}

function apply_cqt($content, $hook) {
	$cqt = new PluginSettings('Custom_Quick_Tags');
	$tags = $cqt->settings['tags'];
	if (!empty($tags))
		foreach ($tags as $null => $tag)
			if ($tag[complex] == 'true')
				$content = preg_replace('{\['.$tag[tag].'=([^[]*)\](.*?)\[\/'.$tag[tag].'\]}i', $tag[replace], $content);
			else
				$content = preg_replace('{\['.$tag[tag].'\](.*?)\[\/'.$tag[tag].'\]}i', $tag[replace], $content);
	
	return $content;
}

?>
