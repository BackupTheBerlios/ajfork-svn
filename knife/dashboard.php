<?php
$moduletitle = "Dashboard";

	$articledatabase = new ArticleStorage('storage');
	$allarticles = $articledatabase->settings['articles'];
	krsort($allarticles);
	
	$total = count($allarticles);
	$main_content = "
			Articles: $total<br />
			Article cumulative size: ".formatsize(filesize("./data/articles.php"))."<br />
			<acronym title=\"Templates, Users, etc\">Settings</acronym> size: ".formatsize(filesize("./data/settings.php"));
	
	#
	#	TODO. Remove later.
	#
	
	$main_content .= "
	<h2>TODO:</h2>
		<ol>
			<li>Users<ul><li><del>Add</del></li><li><del>Edit</del></li><li><del>Delete</del></li><li><del>Passwords encrypted sha1(md5(password+unique_id_generated_on_install))</del></li><li>Non-Admin Profiles</li></ul></li>
			<li>Options</li>
			<li>Templates<ul><li><del>Add template</del></li><li><del>Edit template</del></li><li><del>Delete template</del></li></ul></li>
			<li>Login system<ul><li>Access levels (4admin, 3editor, 2journalist, 1commenter)</li></ul></li>
			<li>Categories<ul><li>Default template</li></ul></li>
			<li>Plugins</li>
			<li>Comments</li>
			<li><del>Write news</del><ul><li>Custom date</li></ul></li>
			<li><del>Edit news</del><ul><li>Custom date</li><li><del>Delete article</del></li><li>Delete articles</li></ul></li></ol>
	<h2>Musical drive:</h2>
		<ol>
			<li>The Donnas ( Spend the night )</li>
			<li>Porcupine Tree ( In absentia )</li>
			<li>Ed Harcourt ( From every sphere )</li>
			<li>U2
				<ul><li>How to dismantle an atomic bomb</li>
				<li>All that you can't leave behind</li></ul></li>
			<li>Kent
				<ul><li>Hagnesta Hill</li><li>Isola</li></ul></li>
			<li>Kula Shaker ( K )</li>
			<li>Lisa Miskovsky<ul><li>Lisa Miskovsky</li><li>Fallingwater</li></ul></li>
			</ol>";
?>
