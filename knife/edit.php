<?php


include(KNIFE_PATH.'/class.articles.php');

#
#	Show edit for for single article
#

$menus["sub_edit"] = "
<ul><li>proof</li><li>of</li><li>concept</li></ul>
";

if ($_GET[id] && !$_POST[id] && !$_GET[action]) {

	
	$settingsclass = new SettingsStorage('settings');
	$currentcats = $settingsclass->settings['categories'];
	
	$KAclass = new KArticles;
	$editentry = $KAclass->getarticle($_GET[id]);
	
	$moduletitle = i18n("edit_module_edit"). " &quot;$editentry[title]&quot;";
	# form stuff here
	
	# set up category checkboxes
	$editcats = explode(", ", $editentry[category]);
		foreach ($editcats as $catkey => $catvalue) {
			$newcats["$catvalue"] = $catvalue;
			}
			
	foreach ($currentcats as $catid => $catinfo) {
		if (array_key_exists($catid, $newcats)) { $selected = 'checked="checked"'; }
		$catformfields .= "<input $selected type=\"checkbox\" name=\"article[category][]\" id=\"catbox$catid\" value=\"$catid\" />
							<label for=\"catbox$catid\">$catinfo[name]</label><br />";
							unset ($selected);
	}
	
$main_content .= '
<script src="inc/quicktags.js" language="JavaScript" type="text/javascript"></script>
<div id="edit_article_wrapper">
	<form id="edit_article_form" method="post">
	<div class="div_normal">
		<fieldset>
			<legend>'.i18n("write_metainfo").'</legend>
		<ul><li><strong>'.i18n("generic_author").'</strong>: '.$editentry[author].'</li><li><strong>'.i18n("generic_date").'</strong>: '.date("j F Y, H:i", $_GET[id]).'</li></ul>

		<input type="hidden" name="panel" value="edit" />
		<input type="hidden" name="id" value="'.$_GET[id].'" />
		<p>
			<label for="edit_article_title">'.i18n("generic_title").'</label><br />
			<input class="inlong" value="'.$editentry[title].'" type="text" id="edit_article_title" name="article[title]" />
		</p>
		</fieldset>
		<fieldset>
			<legend>'.i18n("write_content").'</legend>
		<p>
			<script language="JavaScript" type="text/javascript">edToolbar();</script>
			<textarea class="tamedium" id="edit_article_content" name="article[content]">'.$editentry[content].'</textarea>
		</p>
		</fieldset>
		<p>
			<input type="submit" value="'.i18n("edit_save").'" />
		</p>
	</div>
	
	<script type="text/javascript" language="JavaScript">
	<!--
	edCanvas = document.getElementById(\'edit_article_content\');
	//-->
	</script>

	<div class="div_extended">
		<fieldset>
			<legend>'.i18n("write_category").'</legend>
			'.$catformfields.'
		</fieldset>
	</div>
	</form>
</div>';
}

#
#	Edit article routine
#

if ($_POST[id] && !$_POST[editlist][submit]) {

	$id = $_POST[id];
	$dataclass = new ArticleStorage('storage');
	$articles = $dataclass->settings['articles'];

	$oldart = $articles[$id];
	# Remove unwanted stuff!
	$_POST[article][content] = sanitize_variables($_POST[article][content]);
	$_POST[article][title] = sanitize_variables($_POST[article][title]);
	$_POST[article][category] = sanitize_variables($_POST[article][category]);
	$savecats = implode(", ", $_POST[article][category]);

	# Put the posted and santitized stuff into an array for saving
	$data = array(
		# "timestamp" => $now,
		"content" 	=> stripslashes($_POST[article][content]),
		"title" 	=> stripslashes($_POST[article][title]),
		"author" 	=> stripslashes($oldart[author]),
		"lastedit"	=> stripslashes($check[user]),
		"category" 	=> stripslashes($savecats),
		);
# hook to add custom fields here.
#	$data = run_filters('admin-new-savedata', $data);


	$dataclass->settings['articles'][$id] = $data;
	$dataclass->save();
	
	$moduletitle = "Edit &quot;$data[title]&quot;";
	
	# Give the user a status message
	$statusmessage = "Article successfully edited!<br /><a href=\"javascript:history.go(-1);\">Go back</a>";
	
}




#
#	Show list of articles
#

if (!$_GET[id] && !$_POST[editlist]) {

	$KAclass = new KArticles;
	$allarticles = $KAclass->listarticles();
		
	$dataclass = new SettingsStorage('settings');
	$allcats = $dataclass->settings['categories'];
	
	krsort($allarticles);
	$moduletitle = i18n("edit_module_list");
	$main_content .= "
	<form id=\"edit_article_list\" method=\"post\" class=\"cpform\">
	<table>
		<tr>
			<th>".i18n("generic_title")."</th>
			<th>".i18n("generic_date")."</th>
			<th>".i18n("generic_category")."</th>
			<th>".i18n("generic_author")."</th>
			<th style=\"text-align: right;\">".i18n("generic_actions")."</th>
		</tr>";
	foreach($allarticles as $date => $article) {

	$catarray = explode(", ", $article[category]);
	$catamount = count($catarray);
	
	if($catamount == 1) { 
		$catrowcontent = $allcats[$article[category]][name]; 
		}

	else {
	# Replace the category numbers with their names
		foreach ($catarray as $null => $thiscatid) {
			$thiscatinfo = $allcats[$thiscatid];
			$catarray[$null] = $thiscatinfo[name];
			}
		
		$thiscatnamelisting = implode(", ", $catarray);
		$catrowcontent = "<acronym title=\"$thiscatnamelisting\">$article[category]</acronym>";
		}
		
	$main_content .= "<tr>
			<td><a href=\"?panel=edit&amp;id=$date\">$one $article[title]</a></td>
			<td>".date("d/m/y", $date)."</td>
			<td>$catrowcontent</td>
			<td title=\"".i18n("edit_lastedit")." $article[lastedit]\">$article[author]</td>
			<td style=\"text-align: right;\"><span class=\"delete\"><a href=\"?panel=edit&amp;id=$date&amp;action=delete\" title=\"".i18n("edit_quickerase")." $article[title] ?\">X</a></span> <input type=\"checkbox\" name=\"id[]\" value=\"$date\" /></td>
		</tr>";	
	}
	$main_content .= "</table><div style=\"text-align: right;\"><br /><input type=\"submit\" name=\"editlist[submit]\" value=\"".i18n("generic_do")."\" /></div></form>";

}

#
#	Delete
#
if ($_GET[action] == "delete" || $_POST[editlist]) {

		$dataclass = new ArticleStorage('storage');
		$articles = $dataclass->settings['articles'];

	if ($_GET[action] == "delete") {
		$id = $_GET[id];
	
		$dataclass->delete($id);
	
		$moduletitle = "Delete article";
	
		# Give the user a status message
		$statusmessage = "Article successfully deleted!";
	}

	else {
	$id = $_POST[id];
	$statusmessage = "All selected articles deleted<br /><a href=\"?panel=edit\">Back to list?</a>";
	foreach ($id as $null => $thisid) {
		$dataclass->delete($thisid);
		}
	}

}


?>