<?php
$moduletitle = "Write article";
if($_POST[article]) {

	$now = time();
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


	$dataclass->settings['articles'][$now] = $data;
	$dataclass->save();
	
	# Give the user a status message
	$statusmessage = "Article &quot;$data[title]&quot; successfully saved";
}


if (!$_POST[article]) {

	$main_content = '<div id="add_article_main" style="float: left; width: 80%;"><form id="add_article_form" class="cpform" method="post">
	<input type="hidden" name="panel" value="write" />
	<p><input type="text" id="add_article_title" name="article[title]" /><label for="add_article_title">Title</label></p>
	<p><input type="text" id="add_article_category" value="General" name="article[category]" /><label for="add_article_category">Category</label></p>
	<p><input type="text" id="add_article_author" value="Øivind" name="article[author]" /><label for="add_article_author">Author</label></p>
	<p><label for="add_article_content">Content</label><br /><textarea id="add_article_content" name="article[content]"></textarea></p>
	<p><input type="submit" value="Write article" /></p>
	</form></div><div style="float: right;"><p>Extended options</p></div>';
	
	}

?>