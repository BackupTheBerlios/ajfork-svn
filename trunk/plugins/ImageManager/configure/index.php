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
	<li><span>About</span></li>
	<li><a href="settings.php" onclick="doSubmit(ima,this.href);return false;"><strong>1 SETTINGS</strong></a></li>
	<li><a href="optional.php" onclick="doSubmit(ima,this.href);return false;"><strong>2 OPTIONAL</strong></a></li>
	<li><a href="save.php" onclick="doSubmit(ima,this.href);return false;"><strong>3 SAVE</strong></a></li>
	</ul>
	</div>
	<div id="main">
		<div id="contents">
			<fieldset>
			<legend>ImageManager</legend>
			<img src="ImageManager.jpg" alt="ImageManger" width="300" height="230" border="0" align="right" hspace="4" />
			<p>
			<a href="http://www.zhuo.org/htmlarea/docs/index.html">PHP ImageManager + Editor</a> for AJ-Fork. The ImageManager provides an interface for  browsing and uploading image files on/to your server. The Editor allows for some basic image manipulations such as, cropping, rotation, flip, and scaling.
			</p>
			<p>
			The plugin replaces the img quicktag, so .. to use it, click on the <strong>img quicktag</strong> :-)
			</p>
			<p>
			To use the ImageManager, you have to configure it by going through the 3 steps in this configuration tool. Step 2 is optional, so you don't have to do any changes in it. The parameters in step 1 and 2 are documented <a href="http://www.zhuo.org/htmlarea/docs/index.html#installation">here</a>.
			</p>
			</fieldset>
			<p />
			<div style="clear:left"></div>
			<fieldset>
			<legend>Credits</legend>
			<ul>
			<li>Obvious, Xiang Wei Zhuo (xiangweizhuo(at)hotmail.com), for writing the <a href="http://www.zhuo.org/htmlarea/docs/index.html">PHP ImageManager + Editor</a></li>
			<li>This interfaces is done using Daniel Burka's excellent <a href="http://labs.silverorange.com/archives/2004/may/updatedsimple">Simple CSS Tabs</a></li>
			</ul>
			</fieldset>
			<p />
			<div style="clear:left"></div>
			<fieldset>
			<legend>Copyright (c) 2004 Per Soderlind</legend>
			<p>
			The ImageManager plugin and this configuration tool are licensed under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a>, Copyright 2004 <a href="http://www.soderlind.no/">Per Soderlind</a>
			</p>
			<p>
			Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
			</p>
			<p>
			The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
			</p>
			<p>
			THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
			</p>
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
