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
	<input name="id" type="hidden" value="general" />
	<div id="header">
	<h1><a href="index.php" onclick="doSubmit(ima,this.href);return false;">ImageManager + Editor configuration</a></h1>
	<ul id="primary">
	<li><a href="index.php" onclick="doSubmit(ima,this.href);return false;">About</a></li>
	<li><a href="settings.php" onclick="doSubmit(ima,this.href);return false;"><strong>1 SETTINGS</strong></a></li>
	<li><a href="optional.php" onclick="doSubmit(ima,this.href);return false;"><strong>2 OPTIONAL</strong></a></li>
	<li><span><strong>3 SAVE</strong></span></li>
	</ul>
	</div>
	<div id="main">
		<div id="contents">
			<fieldset>
			<legend>config.inc.php</legend>
			<p>
			Save this to cutenews/plugins/ImageManager/config.inc.php
			</p>
			<input type="button" value="Select All" onclick="copycontent('config');" /><br />
			<textarea name="config" id="config" cols="60" rows="10">
&lt;?php
$IMConfig['base_dir'] = '<?php echo $base_dir?>';
$IMConfig['base_url'] = '<?php echo $base_url?>';
$IMConfig['safe_mode'] = <?php echo $safe_mode?>;
define('IMAGE_CLASS', '<?php echo $IMAGE_CLASS?>');
define('IMAGE_TRANSFORM_LIB_PATH', '<?php echo $IMAGE_TRANSFORM_LIB_PATH?>');
$IMConfig['thumbnail_prefix'] = '<?php echo $thumbnail_prefix?>';
$IMConfig['thumbnail_dir'] = '<?php echo $thumbnail_dir?>';
$IMConfig['allow_new_dir'] = <?php echo $allow_new_dir?>;
$IMConfig['allow_upload'] = <?php echo $allow_upload?>;
$IMConfig['validate_images'] = <?php echo $validate_images?>;
$IMConfig['default_thumbnail'] = '<?php echo $default_thumbnail?>';
$IMConfig['thumbnail_width'] = <?php echo $thumbnail_width?>;
$IMConfig['thumbnail_height'] = <?php echo $thumbnail_height?>;
$IMConfig['tmp_prefix'] = '<?php echo $tmp_prefix?>';
?&gt;</textarea>
			</fieldset>
			<p />
			<div style="clear:left"></div>
			<fieldset>
			<legend>.htaccess</legend>
			<p>
			<?php echo $base_dir?> should only contain static files, i.e. images. Thus, for extra security, only those file should be visible to the web. In apache we can write a .htaccess to deny/allow access to a particular type of file extension, say allow only JPEG, PNG and GIF files. For example:
			</p>
			<input type="button" value="Select All" onclick="copycontent('htaccess');" /><br />
			<textarea name="htaccess" id="htaccess" cols="60" rows="5">
&lt;Files ^(*.jpeg|*.jpg|*.png|*.gif)&gt;
   order deny allow
   deny from all
&lt;/Files&gt;</textarea>
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
