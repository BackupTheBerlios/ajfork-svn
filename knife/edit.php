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
	
$main_content .= '<form id="edit_article_form" class="cpform" method="post">
	<input type="hidden" name="panel" value="edit" />
	<input type="hidden" name="id" value="'.$_GET[id].'" />
	<p><input value="'.$editentry[title].'" type="text" id="edit_article_title" name="article[title]" /><label for="edit_article_title">Title</label></p>
	<p><input value="'.$editentry[category].'" type="text" id="edit_article_category" value="General" name="article[category]" /><label for="edit_article_category">Category</label></p>
	<p><input value="'.$editentry[author].'" type="text" id="edit_article_author" name="article[author]" /><label for="edit_article_author">Author</label></p>
	<p><label for="edit_article_content">Content</label><br /><textarea id="edit_article_content" name="article[content]">'.$editentry[content].'</textarea></p>
	<p><input type="submit" value="Edit article" /></p>
	
	</form>';
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
	
	krsort($allarticles);
	$moduletitle = "Edit articles";
	$main_content .= "<form id=\"edit_article_list\" method=\"post\" class=\"cpform\"><table><thead><th>Title</th><th>Date</th><th>Category</th><th>Actions</th></thead>";
	foreach($allarticles as $date => $article) {
	
	$main_content .= "<tr>
			<td><a href=\"?panel=edit&amp;id=$date\">$article[title]</a></td>
			<td>".date("d/m/y", $date)."</td>
			<td>$article[category]</td>
			<td><span class=\"delete\"><a href=\"?panel=edit&amp;id=$date&amp;action=delete\" title=\"Quick-Erase $article[title] ?\">X</a></span> <input type=\"checkbox\" name=\"id\" value=\"$date\" /></td>
		</tr>";	
	}
	$main_content .= "</table><div style=\"text-align: right;\"><input type=\"submit\" name=\"editlist[submit]\" value=\"Perform\" /></div></form>";

}

#
#	Delete
#
if ($_GET[action] == "delete" || $_POST[editlist]) {

	$id = $_GET[id];
	if (!$id) { $id = $_POST[id]; }
	
	if (!is_array($id)) {
	echo "id = $id";
	$dataclass = new ArticleStorage('storage');
	$articles = $dataclass->settings['articles'];

#	$dataclass->delete($id);
	
	$moduletitle = "Delete article";
	
	# Give the user a status message
	$statusmessage = "Article successfully deleted!".print_r($id);
	}
	
	else {
		$statusmessage = "Many selected!".print_r($id);
		}
}
?>