<?php

#
#	required init
#	

	include('./inc/functions.php');					# load common functions
	include('./config.php');						# load temporary config


#
#	Default menu
#

	$menu = "
	<ul>
		<li><a href=\"index.php\">dashboard</a></li>
		<li><a href=\"?panel=write\">write</a></li>
		<li><a href=\"?panel=edit\">edit</a></li>
		<li><a href=\"?panel=options\">options</a></li>
		<li>help</li>
		<li>plugins</li>
		<li>Øivind (logout)</li>
	</ul>
	";

#
#	Include modules
#

if($_POST[panel] == "write" || $_GET[panel] == "write") {
	include("write.php");
}

if($_POST[panel] == "template" || $_GET[panel] == "template") {
	include("template.php");
	}
	
if($_POST[panel] == "edit" || $_GET[panel] == "edit") {
	include("edit.php");
}

if($_POST[panel] == "users" || $_GET[panel] == "users") {
	include("users.php");
}

if($_POST[panel] == "options" || $_GET[panel] == "options") {
	include("options.php");
}


if (!$_GET[panel] && !$_POST[panel]) {
	include("dashboard.php");
	}

#
#	If loaded module doesn't output a status message, Print this
#

if (!$statusmessage) { 
	$statusmessage = "Login successful";
	}
	
	
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>knife: <?php echo "$moduletitle (Øivind)"; ?></title>
<style type="text/css">

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

#body {
	margin: auto;
	background: #fff;
	width: 900px;
	}
#mainframe {
	padding: 5px;
	border: 1px solid #f3eedc;
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
	width: 70%;
	background: #fffaee url(graphics/fade-butt.png) repeat-x;
	border: 1px solid #333;
	padding: 3px;
	margin-bottom: 10px;
}

#footer {
	opacity: 0.2;
	border-top: 1px solid #dae4ea;
	border-bottom: 1px solid #dae4ea;
	margin-top: 20px;
	clear: both;
	}

	
form.cpform textarea {
		width: 90%;
		height: 150px;
		}

input, textarea {
	background: #f6f7f8;
	border: 1px solid #dae4ea;
	}

input:focus, textarea:focus {
	background: #fff;
	}
	
form.cpform input {
	margin: 0 5px 0 0;
	}
	
#edit_template_switch {
	border: 1px solid #dae4ea;
	padding: 5px;
	}
	

table {
	width: 100%;
	font-size: 0.87em;
	text-align: left;
	}
td {
	padding: 1px 25px 1px 1px;
}


/*
	text-mode buttons
*/

span.delete a {
	color: fff;
	display: inline-block;
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
			echo $menu;
			echo $secondarymenu;
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
		<span style="color: #f32988;">k</span>nife 0.1 &quot;U2 - cutting edge stuff&quot; <?php $_GET[debug] = 1; if ($_GET[debug]) { echo "(debug mode)"; } ?>
		<?php
			if ($_GET[debug]) {
				echo "<pre>";
				print_r($_GET);
				echo "\n\n-----------&lt;- get | post -&gt;---------------\n\n";
				print_r($_POST);
				echo "</pre>";
				}
				?>
	</div>

</div>
</div>
</body>
</html>