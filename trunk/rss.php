<?php
$cutepath = ".";

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/data/config_rss.php");
require_once("$cutepath/inc/version.php");
require_once("$cutepath/data/config.php");


	#$rss_setup[sitelink] = "http://site.org/";
	#$rss_setup[title] = "my_title";
	#$rss_setup[language] = "no-nb";
	#$rss_setup[description] = "something descriptive";


if ($f == "view")  {

if($_POST[language]) { $rss_setup[language] = $_POST[language]; }

header("Content-type:text/xml;charset=utf-8");
echo"<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">
<channel>
<title>$rss_setup[title]</title>
<link>$rss_setup[link]</link>
<language>$rss_setup[language]</language>
<description>$rss_setup[description]</description>
<generator>$aj_version ($aj_buildid)</generator>
\n\n
";

$allow_add_comment			= FALSE;
$allow_full_story			= FALSE;
$allow_comments 			= FALSE;
$allow_active_news 			= TRUE;
$allow_rss					= TRUE;
$news_file					= "$cutepath/data/news.txt";

if ($_POST[number]) { $number = $_POST[number]; }
	else { $number = $rss_setup[number]; }
	

$template_active = $rss_setup[template];
	#<<<HTML
	#<item>
	#<title>{title} [{comments-num}]</title>
	#<guid isPermaLink="false">{news-id}</guid>
	#<category>{category}</category>
	#<link>http://appelsinjuice.org/{humanlink-url}</link>
	#<description><![CDATA[{short-story}]]></description>
	#<author>{rssmail}</author>
	#<dc:author>{rssauthor}</dc:author>
	#<pubDate>{rssdate}</pubDate>  
	#</item>
	#HTML;

if(eregi("[a-z]", $category)){	

	# id recognition for a-z categories
	$all_cats = file("$cutepath/data/category.db.php");
	foreach($all_cats as $null => $cat_line){
   		$cat_arr = explode("|", $cat_line);
    	$cat_arr[1] = stripslashes( preg_replace(array("'\"'", "'\''"), array("&quot;", "&#039;"), $cat_arr[1]) );
    	
    	if($cat_arr[1] == $category) {
    		$category = $cat_arr[0];
		$category_hidden = $cat_arr[1];
		$category_template = $cat_arr[5];
    		}
    	}

	# stop killing the script just because the user prefers a-z categories!
}

$category = preg_replace("/ /", "", $category);
$tmp_cats_arr = explode(",", $category);
foreach($tmp_cats_arr as $key=>$value){
    if($value != ""){ $requested_cats[$value] = TRUE; }
}

require("$cutepath/inc/shows.inc.php");

echo "\n\n</channel></rss>";
}
?>
