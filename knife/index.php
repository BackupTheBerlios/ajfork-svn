<?php

#
#	required init
#	

	if (!defined( "KNIFE_PATH" )) {
    	define( "KNIFE_PATH", dirname(__FILE__)."/");	# Absolute path to current script
    	}
    	
	include(KNIFE_PATH.'/inc/functions.php');			# load common functions
	include(KNIFE_PATH.'/config.php');					# load temporary config
	include(KNIFE_PATH.'/class.users.php');



#
#	variable murdering
#

unset($_GET[check], $_POST[check]);

#
#	authorization is ofcourse required
#

	$settingsdatabase = new SettingsStorage('settings');
	$users = $settingsdatabase->settings['users'];
	
if (($_POST[username] and $_POST[password]) or ($_COOKIE["kusername"] && $_COOKIE["kmd5password"])) {

	if ($_POST[username] and $_POST[password]) {
	
		$check = c_login($_POST[username], $_POST[password], "", $_POST[language]);
		if ($check[status] == "verified") {
			$c_md5password = md5($check[password]);
			setcookie("kusername", $check[user], time()+3600);
			setcookie("kmd5password", $c_md5password, time()+3600);	
			setcookie("klanguage", $check[language]);
			}
		}
		
	elseif ($_COOKIE["kusername"] && $_COOKIE["kmd5password"]) {
	
			$check = c_login($_COOKIE["kusername"], $_COOKIE["kmd5password"], "yes", $_COOKIE["klanguage"]);
		if ($check[status] == "verified") {
			$c_md5password = md5($check[password]);
			}		
		}
	
	}
	
# Load default locale or chosen locale
# including en_gb is too static.
# this needs a config option -> default language for admin panels
# also, figure out why this doesn't work in the first screen.
#  - what's wrong with the order??

if	(!$_COOKIE[klanguage]) {
		if(!$check[language]) {
			include(KNIFE_PATH.'/lang/en_gb.php');
			}
		else {
			include(KNIFE_PATH."/lang/".$check[language]);
		}
	}
	else {
		include(KNIFE_PATH."/lang/".$_COOKIE[klanguage]);
		}
	
	

if ($check[status] == "unverified" or !$_COOKIE["kusername"] or !$_COOKIE["kmd5password"]) {

	$moduletitle = "knife - ". i18n("login_modtitle");
	$menus[0] = "";
	
	# FIXME: Insert menu filter?

	$i18nfiles = FileFolderList("./lang/", $depth = 1, $current = '', $level=0);
	$available_languages = available_languages($i18nfiles);

	foreach ($available_languages as $null => $languagedata) {
		$lang_input_fields .= '<input id="ls'.$languagedata[file].'" type="radio" name="language" value="'.$languagedata[file].'" /> 
		<label for="ls'.$languagedata[file].'">'.$languagedata[langinternational].' ( '.$languagedata[langnational].' )</label><br />';
		}

	$main_content = '
	<div id="login_wrapper">
		<div class="div_normal">
		<fieldset>
		<legend>'.i18n("login_Login").'</legend><p>'.i18n("login_AuthReq").'</p>
	<form id="login" method="post" action="">
	<input type="hidden" name="panel" value="dashboard" />
<p><input class="inshort" type="text" name="username" id="login_username" /> <label for="login_username">'.i18n("login_Username").'</label></p>
<p><input class="inshort" type="password" name="password" id="login_password" /> <label for="login_password">'.i18n("login_Password").'</label></p>
</fieldset>
<p><input type="submit" name="sendlogin" value="'.i18n("login_Login").'" /></p>
</div>
<div class="div_extended">
<fieldset>
	<legend>'.i18n("generic_language").'</legend>
<p>'.$lang_input_fields.'</p>

	</div></form></div>';
	}


#
#	If we're successfully logged in ($check[status] says verified), we can start including the modules
#		- Permission levels should be taken care of roughly in the includes below,
#		  while fine-grained access restriction should be done in the modules.
#

if ($check[status] == "verified") {

#	Set up the first menu

	$menus[0] = "
	<ul>
		<li id=\"main_menu_dashboard\"><a href=\"index.php\">".i18n("menu_dashboard")."</a></li>
		<li id=\"main_menu_write\"><a href=\"?panel=write\">".i18n("menu_write")."</a></li>
		<li id=\"main_menu_edit\"><a href=\"?panel=edit\">".i18n("menu_edit")."</a></li>
		<li id=\"main_menu_options\"><a href=\"?panel=options\">".i18n("menu_options")."</a></li>
		<li id=\"main_menu_help\"><a href=\"?panel=help\">".i18n("menu_help")."</a></li>
		<li id=\"main_menu_plugins\"><a href=\"#\">".i18n("menu_plugins")."</a></li>
		<li id=\"main_menu_info\"><a href=\"?panel=logout\">$check[nickname] (".i18n("menu_logout").")</a></li>
	</ul>
	";

	# FIXME: Insert menu filter?
	
	if($_POST[panel] == "write" || $_GET[panel] == "write") {
		if ($check[level] >= 2) {
		include(KNIFE_PATH."/write.php");
		}
		else { $main_content = i18n("login_noaccess"); }
	}

	if($_POST[panel] == "template" || $_GET[panel] == "template") {
		if ($check[level] >= 4) {
		include(KNIFE_PATH."/template.php");
		}
		else { $main_content = i18n("login_noaccess"); }
	}
	
	if($_POST[panel] == "edit" || $_GET[panel] == "edit") {
		if ($check[level] >= 3) {
		include(KNIFE_PATH."/edit.php");
		}
		else { $main_content = i18n("login_noaccess"); }
	}

	if($_POST[panel] == "users" || $_GET[panel] == "users") {
		if ($check[level] >= 4) {
		include(KNIFE_PATH."/users.php");
		}
		else { $main_content = i18n("login_noaccess"); }
	}

	if($_POST[panel] == "options" || $_GET[panel] == "options") {
		include(KNIFE_PATH."/options.php");
		}
		
	if($_POST[panel] == "help" || $_GET[panel] == "help") {
		include(KNIFE_PATH."/help.php");
		}
		
	if($_POST[panel] == "logout" || $_GET[panel] == "logout") {
		
		# delete cookies
		$menus[0] = "";
		setcookie("kusername", "", time() - 3600);
		setcookie("kmd5password", "", time() - 3600);
		# header reload?
		
		# status message
		$moduletitle = "Logout";
		$statusmessage = "Successfully logged out.";
		$main_content = i18n("login_loggedout");
		
		#header("Location: index.php");
		#http1.1 requires absolute redirects. snippet from manual
		
		header("Location: http://" . $_SERVER['HTTP_HOST']
                     . dirname($_SERVER['PHP_SELF'])
                     . "/" . "index.php");		
		
	}

	if (!$_GET[panel] && !$_POST[panel] or $_POST[panel] == "dashboard") {
		include(KNIFE_PATH."/dashboard.php");
	}
}
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$moduletitle ($check[user])"; ?></title>
<style type="text/css">

/*
	Tag redefinition
*/

html,body {
	background: #fffaee;
	color: #333;
	font: 0.87em "Trebuchet MS";
	margin: 0;
}

a {
	text-decoration: none;
	display: inline-block;
	color: #f32988;
	}
	
a:hover {
	}

h1, h2, h3 {
	margin-top: 3px;
/*	font-family: "Georgia";*/
	}
/*
	Major ID's
*/

#body {
	margin: auto;
	background: #fff;
	width: 910px;
	border: 5px solid #f3eedc;
	}
#mainframe {
	padding: 0 5px 5px 5px;
	border: 1px solid #e6d69e;
	}
	
#header h1 {
	background: url(graphics/logo.png) no-repeat top left;
	padding: 0 0 0 35px;
	font-size: 23px;
}

#header h1:first-letter {
	color: #f32988;
	}
	
/*
	Menus
*/
	
#menu li a {
	padding-left: 25px;
	}

#menu li {
	display: inline;
	margin: 0 8px 0 0;
	padding: 3px;
	border-bottom: 3px solid #f1f3d8;
	}
#menu li:hover {
	background: #fff9e2;
	cursor: pointer;
	border-bottom: 3px solid #819faf;
	}
	
li#main_menu_dashboard {
	background: url(graphics/icons/dashboard.png) no-repeat top left;
	}
	li#main_menu_dashboard:hover {
	background-image: url(graphics/icons/dashboard.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_write {
	background: url(graphics/icons/write.png) no-repeat top left;
	}
	li#main_menu_write:hover {
	background-image: url(graphics/icons/write.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_edit {
	background: url(graphics/icons/edit.png) no-repeat top left;
	}
	li#main_menu_edit:hover {
	background-image: url(graphics/icons/edit.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_help {
	background: url(graphics/icons/help.png) no-repeat top left;
	}
	li#main_menu_help:hover {
	background-image: url(graphics/icons/help.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_options {
	background: url(graphics/icons/options.png) no-repeat top left;
	}
	li#main_menu_options:hover {
	background-image: url(graphics/icons/options.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_plugins {
	background: url(graphics/icons/plugins.png) no-repeat top left;
	}
	li#main_menu_plugins:hover {
	background-image: url(graphics/icons/plugins.png);
	background-repeat: no-repeat;
	}
	
li#main_menu_info {
	background: url(graphics/icons/logout.png) no-repeat top left;
	}
	li#main_menu_info:hover {
	background-image: url(graphics/icons/logout.png);
	background-repeat: no-repeat;
	}

/*

	Options submenu
*/


li#options_menu_users {
	background: url(graphics/icons/users.png) no-repeat top left;
	}
	li#options_menu_users:hover {
	background-image: url(graphics/icons/users.png);
	background-repeat: no-repeat;
	}
	
li#options_menu_templates {
	background: url(graphics/icons/templates.png) no-repeat top left;
	}
	li#options_menu_templates:hover {
	background-image: url(graphics/icons/templates.png);
	background-repeat: no-repeat;
	}
		
li#options_menu_categories {
	background: url(graphics/icons/categories.png) no-repeat top left;
	}
	li#options_menu_categories:hover {
	background-image: url(graphics/icons/categories.png);
	background-repeat: no-repeat;
	}
		
li#options_menu_setup {
	background: url(graphics/icons/setup.png) no-repeat top left;
	}
	li#options_menu_setup:hover {
	background-image: url(graphics/icons/setup.png);
	background-repeat: no-repeat;
	}
		


#status {
	margin-left: auto;
	margin-right: 10px;
	text-align: right;
	width: 100%;
	background: #e5f363;
	border: 1px solid #e5f3c3;
	padding: 0px;
	margin-bottom: 10px;
}

.div_normal {
	float: left;
	min-width: 670px;
}

.div_extended {
	padding-right: 10px;
	float: right;
	min-width: 210px;
}

#footer {
	opacity: 0.2;
	border-top: 1px solid #dae4ea;
	border-bottom: 1px solid #dae4ea;
	margin-top: 20px;
	clear: both;
	}

/*
	buttons and form stuff
*/

span.delete a {
	color: fff;
	padding: 0 3px 0 3px;
	text-align: center;
	background: #d94848;
	color: #fff;
	margin-bottom: 2px;
	}

input.delete {
	background: #d94848;
	color: #fff;
	}

input, textarea {
	background: #f6f7f8;
	border: 1px solid #dae4ea;
	margin: 0 5px 1px 0;
	}

input:focus, textarea:focus {
	background: #fff;
	}

textarea {
	width: 640px;
	}

.inshort {
	width: 150px;
}
.inmedium {
	width: 250px;
}
.inlong {
	width: 350px;
}

.tasmall {
	height: 150px;
}
.tamedium {
	height: 350px;
}
.talarge {
	height: 550px;
}
	
fieldset {
	border: 1px solid #f3e3ac;
	-moz-border-radius: 5px;
	padding: 5px;
}
fieldset legend {
	font-weight: bold;
	font-size: 130%;
	}



/*
	tables
*/

table {
	width: 100%;
	font-size: 0.87em;
	text-align: left;
	}
td {
	padding: 1px 25px 1px 1px;
}
th {
	font-size: 120%;
}



.options_categorylist {
	width: 60%;
	}

.templates_options {
	width: 210px;
	}
	
	
	
/* 
	Hidden layers
*/

#markdown_help {
	display: none;
	}

</style>

<script type="text/javascript" src="inc/utility.js"></script>

</head>

<body>
<div id="body">
<div id="mainframe">
	<div id="header">
	<h1><?php echo $moduletitle; ?>	</h1>
		<div id="menu">
		<?php
#			$menu = run_filters('admin-menu-content',$menu);
			foreach ($menus as $menuname => $menucontent) {
				print $menucontent;
			}
			?>
		</div>
	</div>
	
	<div id="status">
		<span class=\"message\">
			<?php msg_status("$statusmessage"); ?></span>
	</div>
	
	<div id="content">
<?php

	echo $main_content;

?>

	</div>
	
	<div id="footer">
		<span style="color: #f32988;">k</span>nife 0.2 &quot;cutting edge personal publishing - do we need a new name?&quot; - Licensed under the <strong>GPL</strong>
		<?php 
			if (!$_GET[debug]) { 
				$_GET[debug] = 1;
				} 
			if ($_GET[debug] == 1) {
				echo "<br /><fieldset><legend>Debugging info</legend><pre>";
				print_r($_GET);
				echo "\n\n-----------&lt;- get  | post   -&gt;---------------\n\n";
				print_r($_POST);
				echo "\n\n-----------&lt;- post | cookie -&gt;---------------\n\n;";
				print_r($_COOKIE);
				echo "</pre></fieldset>";
				}
				?>
	</div>

</div>
</div>
</body>
</html>