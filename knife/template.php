<?php

include("options.php");
$moduletitle = "Edit templates";

if($_POST[template] && !$_POST["switch"]) {
	$id = sanitize_variables(stripslashes($_POST[template][id]));
	$settingclass = new SettingsStorage('settings');
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

		$dataclass = new SettingsStorage('settings');
		$templates = $dataclass->settings['templates'];

	$chtdo = $_POST[changet];
	if ($chtdo["delete"]) {
	
		$id = $_POST[id];
	
		$moduletitle = "Delete Template";
		$deletedtplname = $templates[$id][name];
	
		if ($deletedtplname != "Default") {
		$dataclass->delete("templates", $id);
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
			$dataclass->settings['templates'][] = $data;
			$dataclass->save();
		
			$statusmessage = "New template created<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
			}
		else {
			$statusmessage = "Template not created. All templates need a name<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
			}
		}
		
	}


	
if (!$_POST[template] && !$_POST[changet] || $_POST[tswitch][submit]) {

	$templatesdatabase = new SettingsStorage('settings');
	$alltemplates = $templatesdatabase->settings['templates'];
	
	
	
	if ($_GET[id]) {
		$templateid = $_GET[id];
		}
	elseif ($_POST[id]) {
		$templateid = $_POST[id];
		}
	else {
		$templateid = 1;
		}

#	templates select

	$main_content = "";
	$main_content .= '<form id="edit_template_switch" class="cpform" method="post">';
	$main_content .= makeDropDown($alltemplates, "id", $templateid);
	$main_content .= ' <input type="submit" name="tswitch[submit]" value="Edit" /><input type="submit" class="delete" name="changet[delete]" value="Delete" /><input type="submit" name="changet[new]" value="New based on this" /> named <input type="text" name="changet[name]" class="inshort" /></form>';


#	load selected template
	$template = $alltemplates[$templateid];
#	set status message
	$statusmessage = "Working with template &quot;$template[name]&quot;";
#	load enabled variables

$tvars_listing = array(
	"{title}" => "Display Article Title",
	"{content}" => "Displays article content",
	"{extended}" => "Displays extended article content (if the &quot;more&quot; button was used)",
	"{author}" => "Displays a link to the author's email",
	"{author-name}" => "Displays the author's name in plain text",
	"{date}" => "Displays the article's date (check system config for formatting)",
	"{category}" => "Displays the name of the article's category",
	"{category-id}" => "Displays the integer ID of the article's category",
	"[link]...[/link]" => "Displays a permanent link to the article",
	"[extended]...[/extended]" => "Displays a link to the article (only if the article contains extended content",
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
       <form id="edit_template" class="cpform" method="post">
       <input type="hidden" name="template[id]" value="'.$templateid.'" />
       <input type="hidden" name="panel" value="template" />
	<label for="edit_template_name">Template name</label><input type="text" class="inshort" id="edit_template_name" name="template[name]" value="'.$template[name].'"/>
	<label for="edit_template_articlelist"><h2>Articlelist template</h2></label>

	<table>';
	
	foreach ($tvars_listing as $variable => $description) {
		$main_content .= "<tr><td style=\"padding-right: 5px;\"><span class=\"vinfo\" title=\"$description\">$variable</span></td><td>$description</td></tr>";
		}
		
	$main_content .= '
	</table><textarea class="tamedium" id="edit_template_articlelist" name="template[listing]">'.$template[listing].'</textarea>
	<label for="edit_template_view"><h2>Article template</h2></label>
	<table>';
	
	foreach ($tvars_view as $variable => $description) {
		$main_content .= "<tr><td style=\"padding-right: 5px;\"><span class=\"vinfo\" title=\"$description\">$variable</span></td><td>$description</td></tr>";
		}
		
	$main_content .= '
	</table><textarea class="tamedium" id="edit_template_view" name="template[view]">'.$template[view].'</textarea>
	<label for="edit_template_comment"><h2>Comment template</h2></label>
	<table>';
	
	foreach ($tvars_comment as $variable => $description) {
		$main_content .= "<tr><td style=\"padding-right: 5px;\"><span class=\"vinfo\" title=\"$description\">$variable</span></td><td>$description</td></tr>";
		}
		
	$main_content .= '
	</table><textarea class="tasmall" id="edit_template_comment" name="template[comment]">'.$template[comment].'</textarea>
	<label for="edit_template_commentform"><h2>Commentform template</h2></label>
	<table>';
	
	foreach ($tvars_commentform as $variable => $description) {
		$main_content .= "<tr><td style=\"padding-right: 5px;\"><span class=\"vinfo\" title=\"$description\">$variable</span></td><td>$description</td></tr>";
		}
		
	$main_content .= '
	</table><textarea class="tasmall" id="edit_template_commentform" name="template[commentform]">'.$template[commentform].'</textarea>
	<div><input type="submit" value="Save template" /></div>
	</form>';
}
?>