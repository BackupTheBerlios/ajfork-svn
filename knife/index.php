<?php

#
#	required init
#	

	include('./inc/functions.php');					# load common functions
	include('./config.php');						# load temporary config


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
	
		$check = c_login($_POST[username], $_POST[password]);
		if ($check[status] == "verified") {
			$statusmessage = "You are logged in, $check[nickname]!";
			$c_md5password = md5($check[password]);
			setcookie("kusername", $check[user], time()+3600);
			setcookie("kmd5password", $c_md5password, time()+3600);		
			}
		
		else {
			$statusmessage = "Sorry, $check[user], but I couldn't verify you...";
			}
		}
		
	elseif ($_COOKIE["kusername"] && $_COOKIE["kmd5password"]) {
	
			$check = c_login($_COOKIE["kusername"], $_COOKIE["kmd5password"], "yes");
		if ($check[status] == "verified") {
			$statusmessage = "You are logged in, $check[nickname]!";
			$c_md5password = md5($check[password]);
			}
		
		else {
			$statusmessage = "Sorry, $check[user], but I couldn't verify you...";
			}
		
		}
	
	}
	

if ($check[status] == "unverified" or !$_COOKIE["kusername"] or !$_COOKIE["kmd5password"]) {

	$moduletitle = "knife - Authorization required";
	$menus[0] = "";
	
	# FIXME: Insert menu filter?
	
	$main_content = '<div id="login_div"><p>You need to provide valid credentials to view any sections of this software. This requires a browser that supports cookies.</p>
	<form id="login" method="post" action="">
	<input type="hidden" name="panel" value="dashboard" />
<p><input class="inshort" type="text" name="username" id="login_username" /> <label for="login_username">Username</label></p>
<p><input class="inshort" type="password" name="password" id="login_password" /> <label for="login_password">Password</label></p>
<p><input type="submit" name="sendlogin" value="Login" /></p>
	</form></div>';
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
		<li><a href=\"index.php\">dashboard</a></li>
		<li><a href=\"?panel=write\">write</a></li>
		<li><a href=\"?panel=edit\">edit</a></li>
		<li><a href=\"?panel=options\">options</a></li>
		<li>help</li>
		<li>plugins</li>
		<li><a href=\"?panel=logout\">$check[nickname] (logout)</a></li>
	</ul>
	";

	# FIXME: Insert menu filter?
	
	if($_POST[panel] == "write" || $_GET[panel] == "write") {
		if ($check[level] >= 2) {
		include("write.php");
		}
		else { $main_content = "Insufficient access"; }
	}

	if($_POST[panel] == "template" || $_GET[panel] == "template") {
		if ($check[level] >= 4) {
		include("template.php");
		}
		else { $main_content = "Insufficient access"; }
	}
	
	if($_POST[panel] == "edit" || $_GET[panel] == "edit") {
		if ($check[level] >= 3) {
		include("edit.php");
		}
		else { $main_content = "Insufficient access"; }
	}

	if($_POST[panel] == "users" || $_GET[panel] == "users") {
		if ($check[level] >= 4) {
		include("users.php");
		}
		else { $main_content = "Insufficient access"; }
	}

	if($_POST[panel] == "options" || $_GET[panel] == "options") {
		include("options.php");
		}
		
	if($_POST[panel] == "logout" || $_GET[panel] == "logout") {
		
		# delete cookies
		$menus[0] = "";
		setcookie("kusername", "", time() - 3600);
		setcookie("kmd5password", "", time() - 3600);
		
		# status message
		$moduletitle = "Logout";
		$statusmessage = "Successfully logged out.";
		$main_content = "Cookies cleared. Do you want to <a href=\"index.php\">log in again?</a>";
	}

	if (!$_GET[panel] && !$_POST[panel] or $_POST[panel] == "dashboard") {
		include("dashboard.php");
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
	width: 900px;
	}
#mainframe {
	padding: 0 5px 5px 5px;
	border: 1px solid #f3eedc;
	}
	
#header h1 {
	background: url(graphics/logo.png) no-repeat top left;
	padding: 0 0 0 35px;
}

#header h1:first-letter {
	color: #f32988;
	}
	
#menu li {
	display: inline;
	border: 1px dotted #999;
	margin: 0 8px 0 0;
	padding: 3px;
	}
#menu li:hover {
	background: #efefef;
	cursor: pointer;
	border-bottom: 3px solid #333;
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
}

.div_extended {
	padding-right: 10px;
	float: right;
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
	width: 700px;
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

.templates_fields textarea {
	width: 640px;
	}
.templates_options {
	width: 210px;
	}
</style>
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
				echo " (debug mode)<br /><pre>";
				print_r($_GET);
				echo "\n\n-----------&lt;- get  | post   -&gt;---------------\n\n";
				print_r($_POST);
				echo "\n\n-----------&lt;- post | cookie -&gt;---------------\n\n;";
				print_r($_COOKIE);
				echo "</pre>";
				}
				?>
	</div>

</div>
</div>
</body>
</html>