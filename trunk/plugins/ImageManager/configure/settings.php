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
	<input name="id" type="hidden" value="settings" />
	<div id="header">
	<h1><a href="index.php" onclick="doSubmit(ima,this.href);return false;">ImageManager + Editor configuration</a></h1>
	<ul id="primary">
	<li><a href="index.php" onclick="doSubmit(ima,this.href);return false;">About</a></li>
	<li><span><strong>1 SETTINGS</strong></span></li>
	<li><a href="optional.php" onclick="doSubmit(ima,this.href);return false;"><strong>2 OPTIONAL</strong></a></li>
	<li><a href="save.php" onclick="doSubmit(ima,this.href);return false;"><strong>3 SAVE</strong></a></li>
	</ul>
	</div>
	<div id="main">
		<div id="contents">
			<fieldset>
			<legend>Paths (should point to your cutenews &quot;upimages&qupt; folder)</legend>			
				<div class="row"><span class="label">Base image directory</span><span class="formw"><input type="text" class="textbox" size="60" name="base_dir" value="<?php echo $base_dir?>"/></span></div>
				<div class="row"><span class="label">Base image URL</span><span class="formw"><input type="text" class="textbox" size="60" name="base_url" value="<?php echo $base_url?>"/></span></div>
			</fieldset>			
			<p />
			<div style="clear:left"></div>
			<fieldset>
			<legend>Image Manipulation Library</legend>			
				<div class="row" id="gd"><span class="label">GD</span><span class="formw"><input type="radio" name="IMAGE_CLASS" value="GD" <?php if ($IMAGE_CLASS == "GD") {print " checked=\"checked\" ";} ?>/></span></div>
				<div class="row"><span class="label">ImageMagick</span><span class="formw"><input type="radio" name="IMAGE_CLASS" value="IM" <?php if ($IMAGE_CLASS == "IM") {print " checked=\"checked\" ";} ?>/></span></div>
				<div class="row"><span class="label">NetPBM</span><span class="formw"><input type="radio" name="IMAGE_CLASS" value="NetPBM" <?php if ($IMAGE_CLASS == "NetPBM") {print " checked=\"checked\" ";} ?>/></span></div>
				<div class="row"><span class="label">Library path (IM or NetPBM)</span><span class="formw"><input type="text" class="textbox" size="60" name="IMAGE_TRANSFORM_LIB_PATH" value="<?php echo $IMAGE_TRANSFORM_LIB_PATH?>" /></span></div>
			</fieldset>
			<p />
			<div style="clear:left"></div>
			<fieldset>
			<legend>Security</legend>			
				<div class="row"><span class="label">PHP is running in Safe Mode</span><span class="formw"><input type="checkbox" name="safe_mode" value="true" <?php if ($safe_mode == "true") {print " checked=\"checked\" ";} ?> /></span></div>			
				<div class="row"><span class="label">Can create new directory</span><span class="formw"><input type="checkbox" name="allow_new_dir" value="true" <?php if ($allow_new_dir == "true") {print " checked=\"checked\" ";} ?>/></span></div>
				<div class="row"><span class="label">Can upload images</span><span class="formw"><input type="checkbox" name="allow_upload" value="true" <?php if ($allow_upload == "true") {print " checked=\"checked\" ";} ?>/></span></div>
			</fieldset>
			<div style="clear:left;"></div>
			<div class="xhtml">
				<a href="http://validator.w3.org/check/referer" target="_blank">xhtml</a>
			</div>
		</div>
	</div>
	</form>
</body>
</html>
