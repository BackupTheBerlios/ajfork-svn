<?PHP
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  Path to the CuteNews directory (to make the includng easyer)
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
$path = ".";

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  This is a fix if register_globals is turned off
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if(!$PHP_SELF){
	if($HTTP_POST_VARS) 	{extract($HTTP_POST_VARS, EXTR_PREFIX_SAME, "post_");}
	if($HTTP_GET_VARS)  	{extract($HTTP_GET_VARS, EXTR_PREFIX_SAME, "get_");}
	if($HTTP_COOKIE_VARS)	{extract($HTTP_COOKIE_VARS, EXTR_PREFIX_SAME, "cookie_");}
	if($HTTP_ENV_VARS)	 	{extract($HTTP_ENV_VARS, EXTR_PREFIX_SAME, "env_");}
}
if($PHP_SELF == ""){ $PHP_SELF = $HTTP_SERVER_VARS[PHP_SELF]; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AJ-Fork Example page</title>
	<style type="text/css" title="example vivid" media="screen">@import "example.css";</style>
</head>
<body>
	<div id="body">

	<div id="header">
		AJ-Fork example-page<br />
		<small>currently running version 168</small>
	</div>

	<div id="content">

		<div id="menu">
			<strong>internal links</strong>
			<p><a href="example.php?">main page</a><br />
			<a href="example.php?do=archives">archives</a><br />
			<a href="readme.htm">readme</a><br />
			<a href="index.php">admin</a>
			</p>

			<strong>quick search</strong>
			<!-- The Quick Search Form -->
			<div id="smallsearchbox">
			<form id="smallsearchform" method="post" action="">
			<p>
			<input type="text" name="story" size="14" />
			<input type="hidden" name="do" value="search" />
			</p>
			</form>
			</div>
			<!-- End of the Search Form -->
			
			<strong>external links</strong>
			<p>
			<a href="http://cutephp.com">CutePHP Scripts</a><br />
			<a href="http://cutephp.com/forum/">CutePHP Forums</a><br />
			<a href="http://appelsinjuice.org/?vis=cutenews-aj">AJ-Fork Home</a><br />
			<a href="http://www.textbones.com/">Textbones</a><br />
			<a href="http://mozilla.org/products/firefox/">Firefox</a>
			</p>
			
			<div id="latestcomments">
				<strong>latest 10 comments</strong><br /><br />
				<?php include('latest_comments.php'); 
				?>
			</div>
			
			</div>
			
		<div id="news">
			<?PHP
				
			/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  			Here we decide what page to include
 			~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
			
			if($do == "search" or $dosearch == "yes"){ $aj_go = "search"; $dosearch = "yes"; include("$path/search.php"); }
			elseif($do == "archives"){ include("$path/show_archives.php"); }
			elseif($do == "stats"){ echo"You can download the stats addon and include it here to show how many news, comments ... you have"; /* include("$path/stats.php"); */ }
			else{ include("$path/show_news.php"); }
			
			?>
		</div>
		<div class="spacer">1</div>
	</div>

	<div id="footer">
		Example Powered by AJ-Fork - tentatively valid <a href="http://validator.w3.org/check/referer">XHTML1.1</a> / 
		<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS2</a>
	</div>
</div>
</body>
</html>
