<?php

include("options.php");
$moduletitle = "Edit templates";


#	Fetch and set up needed data

	$settingclass = new SettingsStorage('settings');
	$templates = $settingclass->settings['templates'];

if($_POST[template] && !$_POST["switch"]) {
	$id = sanitize_variables(stripslashes($_POST[template][id]));
	
	$templateid = sanitize_variables(stripslashes($_POST[template][id]));
	$data = array(
		"name"		=> stripslashes($_POST[template][name]),
		"listing" 	=> stripslashes($_POST[template][listing]),
		"view" 	=> stripslashes($_POST[template][view]),
		"comment" 	=> stripslashes($_POST[template][comment]),
		"commentform" 	=> stripslashes($_POST[template][commentform]),
		
		);		
		
	$settingclass->settings['templates'][$id] = $data;
	$settingclass->save();
	$statusmessage = "Template &quot;$data[name]&quot; updated <br /><a href=\"javascript:history.go(-1);\">Go back</a>";
	}

if($_POST[changet]) {


	$chtdo = $_POST[changet];
	
	#
	#	Delete template
	#
	if ($chtdo["delete"]) {
	
		$id = $_POST[id];
	
		$moduletitle = "Delete Template";
		$deletedtplname = $templates[$id][name];
	
		if ($deletedtplname != "Default") {
		$settingclass->delete("templates", $id);
		$statusmessage = "Template &quot;$deletedtplname&quot; deleted<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
		}		
		else {
			$statusmessage = "The default template cannot be deleted!";
			}
		}
	elseif($chtdo["new"]) { 
	
		$id = $_POST[id];
		$templatebase = $templates[$id];
		
		$data = array(
		"name"		=> stripslashes($_POST[changet][name]),
		"listing" 	=> stripslashes($templatebase[listing]),
		"view" 	=> stripslashes($templatebase[view]),
		"comment" 	=> stripslashes($templatebase[comment]),
		"commentform" 	=> stripslashes($templatebase[commentform]),
		);
		
		if ($data[name] && $data[name] != "") {
			$settingclass->settings['templates'][] = $data;
			$settingclass->save();
		
			$statusmessage = "New template created<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
			}
		else {
			$statusmessage = "Template not created. All templates need a name<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
			}
		}
		
	}


	
if (!$_POST[template] && !$_POST[changet] || $_POST[tswitch][submit]) {

	
	if ($_GET[id]) {
		$templateid = $_GET[id];
		}
	elseif ($_POST[id]) {
		$templateid = $_POST[id];
		}
	else {
		$templateid = 1;
		}


#	load selected template
	$template = $templates[$templateid];
#	set status message
	$statusmessage = "Working with template &quot;$template[name]&quot;";
#	load enabled variables

$tvars_listing = array(
	"{title}" => "Display Article Title",
	"{content}" => "Displays article content",
	"{extended}" => "Displays extended article content (if the &quot;more&quot; button was used)",
#	"{author}" => "Displays a link to the author's email",
	"{lastedit}" => "Displays the name of the last editor for this article",
	"{date}" => "Displays the article's date (check system config for formatting)",
	"{category}" => "Displays the name of the article's category",
	"{category-id}" => "Displays the integer ID of the article's category",
	"[link]...[/link]" => "Displays a permanent link to the article",
	"[friendlylink]...[/friendlylink]" => "Displays a permanent link to the article using its title",
	"[com-link]...[/com-link]" => "Displays a link to the article (only if comments are enabled for it)",
	);
	ksort($tvars_listing);

$tvars_view = array(
	"{title}" => "Display Article Title",
	"{content}" => "Displays article content",
	"{extended}" => "Displays extended article content (if the &quot;more&quot; button was used)",
	"{author}" => "Displays a link to the author's email",
	"{author-name}" => "Displays the author's name in plain text",
	"{date}" => "Displays the article's date (check system config for formatting)",
	"{category}" => "Displays the name of the article's category",
	"{category-id}" => "Displays the integer ID of the article's category",
	);
	ksort($tvars_view);
	
$tvars_comment = array(
	"{none}" => "Display nothing",
	);
	ksort($tvars_comment);
	
$tvars_commentform = array(
	"{none}" => "Display nothing",
	);
	ksort($tvars_commentform);

#
	$main_content .= '
	<div id="edit_templates_wrapper">
	<div class="div_normal templates_fields">
       <form method="post">
			<fieldset>
				<legend>Current template ('.$template[name].')</legend>
			<input type="hidden" name="template[id]" value="'.$templateid.'" />
			<input type="hidden" name="panel" value="template" />
			
			<p>
				Unlike CuteNews/AJ-Fork, we will explain templates here<br />
				eventually
			</p>
			
			<label for="edit_template_articlelist"><h3>Articlelist template</h3></label>
			<table>';
	
	foreach ($tvars_listing as $variable => $description) {
		$main_content .= "
				<tr>
					<td><span class=\"vinfo\" title=\"$description\">$variable</span></td>
					<td>$description</td>
				</tr>";
		}
		
	$main_content .= '
			</table>
			<textarea class="tamedium" id="edit_template_articlelist" name="template[listing]">'.$template[listing].'</textarea>
			
			<label for="edit_template_view"><h2>Article template</h2></label>
			<table>';
	
	foreach ($tvars_view as $variable => $description) {
		$main_content .= "
				<tr>
					<td><span class=\"vinfo\" title=\"$description\">$variable</span></td>
					<td>$description</td>
				</tr>";
		}
		
	$main_content .= '
			</table>
			<textarea class="tamedium" id="edit_template_view" name="template[view]">'.$template[view].'</textarea>
			
			<label for="edit_template_comment"><h2>Comment template</h2></label>
			<table>';
	
	foreach ($tvars_comment as $variable => $description) {
		$main_content .= "
				<tr>
					<td><span class=\"vinfo\" title=\"$description\">$variable</span></td>
					<td>$description</td>
				</tr>";
		}
		
	$main_content .= '
			</table>
			<textarea class="tasmall" id="edit_template_comment" name="template[comment]">'.$template[comment].'</textarea>
			<label for="edit_template_commentform"><h2>Commentform template</h2></label>
			<table>';
	
	foreach ($tvars_commentform as $variable => $description) {
		$main_content .= "
				<tr>
					<td><span class=\"vinfo\" title=\"$description\">$variable</span></td>
					<td>$description</td>
				</tr>";
		}
		
	$main_content .= '
			</table>
			<textarea class="tasmall" id="edit_template_commentform" name="template[commentform]">'.$template[commentform].'</textarea>
			
			<fieldset>
				<legend>Edit template name</legend>
				<input type="text" class="inshort" id="edit_template_name" name="template[name]" value="'.$template[name].'"/>
			</fieldset>

			
			
			<p><input type="submit" value="Save template" /></p>
			</fieldset>
		</form>
	</div>
	<div class="div_extended templates_options">
		<form id="edit_template_switch" method="post">
			<fieldset>
				<legend>Options</legend>
				<p>';
					$main_content .= makeDropDown($templates, "id", $templateid);
					$main_content .= '
					<input type="submit" name="tswitch[submit]" value="Edit" /> 
					<input type="submit" class="delete" name="changet[delete]" value="Delete" />
				</p>
				<p>
					New templates will be based on the currently selected above. Fill in the new template name below:
				</p>
				<p>
					<input type="text" name="changet[name]" class="inshort" id="changetname" /> 
					<br />
					<input type="submit" name="changet[new]" value="New template" />
				</p>
			</fieldset>
		</form>	
	</div>
	';
}
?>