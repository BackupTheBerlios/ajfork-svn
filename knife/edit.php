<?php


#
#	Show edit for for single article
#

if ($_GET[id] && !$_POST[id] && !$_GET[action]) {
	$articledatabase = new ArticleStorage('storage');
	$allarticles = $articledatabase->settings['articles'];
	
	$editentry = $allarticles[$_GET[id]];
	
	$moduletitle = "Edit &quot;$editentry[title]&quot;";
	# form stuff here
	
$main_content .= '
<script src="inc/quicktags.js" language="JavaScript" type="text/javascript"></script>

<div id="edit_single_article_screen">Written by '.$editentry[author].' at '.date("j F Y, H:i", $_GET[id]).'<form id="edit_article_form" class="cpform" method="post">
	<input type="hidden" name="panel" value="edit" />
	<input type="hidden" name="id" value="'.$_GET[id].'" />
	<p><label for="edit_article_title">Title</label> and <label for="edit_article_category">Category (fixme)</label><br /><input class="inlong" value="'.$editentry[title].'" type="text" id="edit_article_title" name="article[title]" /> <input value="'.$editentry[category].'" type="text" id="edit_article_category" value="General" name="article[category]" /></p>
	<p><label for="edit_article_content">Content</label><br />
	<script language="JavaScript" type="text/javascript">edToolbar();</script>
	<textarea class="tamedium" id="edit_article_content" name="article[content]">'.$editentry[content].'</textarea>
	<script type="text/javascript" language="JavaScript">
<!--
edCanvas = document.getElementById(\'edit_article_content\');
//-->
</script>
</p>
	<p><input type="submit" value="Edit article" /></p>
	
	</form></div>';
}

#
#
#

if ($_POST[id] && !$_POST[editlist][submit]) {

	$id = $_POST[id];
	$dataclass = new ArticleStorage('storage');

	# Remove unwanted stuff!
	$_POST[article][content] = sanitize_variables($_POST[article][content]);
	$_POST[article][title] = sanitize_variables($_POST[article][title]);
	$_POST[article][category] = sanitize_variables($_POST[article][category]);
	$_POST[article][author] = sanitize_variables($_POST[article][author]);

	# Put the posted and santitized stuff into an array for saving
	$data = array(
		# "timestamp" => $now,
		"content" 	=> stripslashes($_POST[article][content]),
		"title" 	=> stripslashes($_POST[article][title]),
		"author" 	=> stripslashes($_POST[article][author]),
		"category" 	=> stripslashes($_POST[article][category]),
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
	
	$articledatabase = new ArticleStorage('storage');
	$allarticles = $articledatabase->settings['articles'];
	
	$dataclass = new SettingsStorage('settings');
	$allcats = $dataclass->settings['categories'];
	
	krsort($allarticles);
	$moduletitle = "Edit articles";
	$main_content .= "<form id=\"edit_article_list\" method=\"post\" class=\"cpform\"><table><tr><th>Title</th><th>Date</th><th>Category</th><th>Author</th><th style=\"text-align: right;\">Actions</th></tr>";
	foreach($allarticles as $date => $article) {
	
	$catarray = explode(", ", $article[category]);

	# Replace the category numbers with their names
		foreach ($catarray as $null => $thiscatid) {
			$thiscatinfo = $allcats[$thiscatid];
			$catarray[$null] = $thiscatinfo[name];
			}
	$thiscatnamelisting = implode(", ", $catarray);
	$main_content .= "<tr>
			<td><a href=\"?panel=edit&amp;id=$date\">$article[title]</a></td>
			<td>".date("d/m/y", $date)."</td>
			<td><acronym title=\"$thiscatnamelisting\">$article[category]</acronym></td>
			<td>$article[author]</td>
			<td style=\"text-align: right;\"><span class=\"delete\"><a href=\"?panel=edit&amp;id=$date&amp;action=delete\" title=\"Quick-Erase $article[title] ?\">X</a></span> <input type=\"checkbox\" name=\"id[]\" value=\"$date\" /></td>
		</tr>";	
	}
	$main_content .= "</table><div style=\"text-align: right;\"><br /><input type=\"submit\" name=\"editlist[submit]\" value=\"Perform\" /></div></form>";

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