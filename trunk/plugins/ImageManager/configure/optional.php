<?php
require_once("sessionvars.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>ImageManager + Editor configuration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<script type="text/javascript" src="lib/misc.js"></script>
	<style type="text/css" media="screen">@import "css/basic.css";</style>
	<style type="text/css" media="screen">@import "css/tabs.css";</style>
	<style type="text/css" media="screen">@import "css/misc.css";</style>
</head>
<body>
	<form name="ima" id="ima" action="" method="post">
	<input name="id" type="hidden" value="optional" />
	<div id="header">
	<h1><a href="index.php" onclick="doSubmit(ima,this.href);return false;">ImageManager + Editor configuration</a></h1>
	<ul id="primary">
	<li><a href="index.php" onclick="doSubmit(ima,this.href);return false;">About</a></li>
	<li><a href="settings.php" onclick="doSubmit(ima,this.href);return false;"><strong>1 SETTINGS</strong></a></li>
	<li><span><strong>2 OPTIONAL</strong></span></li>
	<li><a href="save.php" onclick="doSubmit(ima,this.href);return false;"><strong>3 SAVE</strong></a></li>
	</ul>
	</div>
	<div id="main">
		<div id="contents">
			<fieldset>
			<legend>Thumbnails</legend>			
				<div class="row"><span class="label">Default thumbnail</span><span class="formw"><input type="text" class="textbox" size="60" name="default_thumbnail" value="<?php echo $default_thumbnail?>"/></span></div>
				<div class="row"><span class="label">Thumbnail width</span><span class="formw"><input type="text" class="textbox" size="60" name="thumbnail_width" value="<?php echo $thumbnail_width?>"/></span></div>
				<div class="row"><span class="label">Thumbnail height</span><span class="formw"><input type="text" class="textbox" size="60" name="thumbnail_height" value="<?php echo $thumbnail_height?>"/></span></div>
				<div class="row"><span class="label">Thumbnail prefix</span><span class="formw"><input type="text" class="textbox" size="60" name="thumbnail_prefix" value="<?php echo $thumbnail_prefix?>"/></span></div>
				<div class="row"><span class="label">Thumbnail directory</span><span class="formw"><input type="text" class="textbox" size="60" name="thumbnail_dir" value="<?php echo $thumbnail_dir?>"/></span></div>
			</fieldset>
			<p />
			<div style="clear:left;"></div>
			<fieldset>
			<legend>Misc. optional settings</legend>	
				<div class="row"><span class="label">Validate images(true)</span><span class="formw"><input type="checkbox" name="validate_images" value="true" <?php if ($validate_images == "true") {print " checked=\"checked\" ";} ?> /></span></div>
				<div class="row"><span class="label">tmp prefix</span><span class="formw"><input type="text" class="textbox" size="60" name="tmp_prefix" value="<?php echo $tmp_prefix?>"/></span></div>
			</fieldset>
			<div style="clear:left"></div>
			<div class="xhtml">
				<a href="http://validator.w3.org/check/referer" target="_blank">xhtml</a>
			</div>
		</div>
	</div>
	</form>
</body>
</html>
