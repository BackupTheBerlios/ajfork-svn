<?php
$moduletitle = "Write article";

	$settingsclass = new SettingsStorage('settings');
	$dataclass = new ArticleStorage('storage');
	$currentcats = $settingsclass->settings['categories'];
	
if($_POST[article]) {

	$now = time();


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
		"author" 	=> stripslashes($check[user]),
		"category" 	=> stripslashes($savecats),
		);
# hook to add custom fields here.
#	$data = run_filters('admin-new-savedata', $data);


	$dataclass->settings['articles'][$now] = $data;
	$dataclass->save();

	# Give the user a status message
	$statusmessage = "Article &quot;$data[title]&quot; successfully saved";
}


if (!$_POST[article]) {

	# set up category checkboxes
	foreach ($currentcats as $catid => $catinfo) {
		$catformfields .= "<input type=\"checkbox\" name=\"article[category][]\" id=\"catbox$catid\" value=\"$catid\" />
							<label for=\"catbox$catid\">$catinfo[name]</label><br />";
	}

	$main_content = '
<script src="inc/quicktags.js" language="JavaScript" type="text/javascript"></script>
<div id="add_article_wrapper">
	<form id="add_article_form" class="cpform" method="post">
	<div class="div_normal">
		<input type="hidden" name="panel" value="write" />
		<p>
			<label for="add_article_title">Title</label><br />
			<input class="inlong" type="text" id="add_article_title" name="article[title]" />
		</p>
		<p>
			<label for="add_article_content">Content</label>	
			<script language="JavaScript" type="text/javascript">edToolbar();</script>
			<textarea class="tamedium" id="add_article_content" name="article[content]"></textarea>
		</p>
		<p>
			<input type="submit" value="Write article" />
		</p>
	</div>
	
	<script type="text/javascript" language="JavaScript">
	<!--
	edCanvas = document.getElementById(\'add_article_content\');
	//-->
	</script>
	
	<div class="div_extended">
		<fieldset>
			<legend>Category</legend>
			'.$catformfields.'
		</fieldset>
	</div>
	</form>
</div>';
	
	}

?>