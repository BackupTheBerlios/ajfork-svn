<?PHP
$skin_prefix = "";
// ********************************************************************************
// Skin MENU
// ********************************************************************************
$skin_menu = array(
                    array(
                   	'name'		=> "Home",
                   	'url'		=> "$PHP_SELF?mod=main",
                   	'access'	=> "4",
                    ),

                    array(
					'name'		=> "Write",
					'url'		=> "$PHP_SELF?mod=addnews&amp;action=addnews",
					'access'	=> "3",
                    ),
                    
                    array(
					'name'		=> "Edit",
					'url'		=> "$PHP_SELF?mod=editnews&amp;action=list",
					'access'	=> "3",
                    ),
                    array(
                   	'name'		=> "Categories",
                   	'url'		=> "$PHP_SELF?mod=categories",
                   	'access'	=> "1",
                    ),

                    array(
                   	'name'		=> "Templates",
                   	'url'		=> "$PHP_SELF?mod=options&action=templates",
                   	'access'	=> "1",
                    ),
                    array(
					'name'		=> "Personal Options",
					'url'		=> "$PHP_SELF?mod=options&action=personal",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "All Options",
					'url'		=> "$PHP_SELF?mod=options&amp;action=options",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "System Configuration",
					'url'		=> "$PHP_SELF?mod=options&action=syscon&rand=".time(),
					'access'	=> "1",
                    ),
                    array(
					'name'		=> "Manage Users",
					'url'		=> "$PHP_SELF?mod=editusers&action=list",
					'access'	=> "1",
                    ),
                    
                    array(
					'name'		=> "Help / About",
					'url'		=> "$PHP_SELF?mod=about&amp;action=about",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "Credits",
					'url'		=> "$PHP_SELF?mod=credits",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "Readme",
					'url'		=> "readme.htm",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "View site",
					'url'		=> "$config_http_home_url",
					'access'	=> "4",
                    ),
                    array(
					'name'		=> "Plugin Manager",
					'url'		=> "$PHP_SELF?mod=options&action=plugins",
					'access'	=> "1",
                    ),
                    
                    );

$skin_menu = run_filters('cutenews-options',$skin_menu);

// ********************************************************************************
// Skin HEADER
// ********************************************************************************

$skin_header = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="skins/default.css" media="all" />
		<title>AJ-Fork</title>
		<script type="text/javascript" src="skins/cute.js"></script>	
	</head>

<body>
<!--tyle="position:absolute; left:25px; top:10px; height:13px; z-index:3"  -->

<div id="mainframe">
		<div id="main_head">
		<!-- appelsinholder-->
		</div>

		<div id="main_menu">
			{menu}
		</div>

		<div id="main_content">
	<!--SELF-->
	<h1>{header-text}</h1>
	<!--MAIN area-->
HTML;

// ********************************************************************************
// Skin FOOTER
// ********************************************************************************
$skin_footer = <<<HTML
<!--MAIN area-->
	<!--/SELF-->
		<br style="clear:both;"/>
		</div>
		

	</div>

	</body>
	</html>

HTML;

?>
