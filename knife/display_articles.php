<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>knife</title>
<style type="text/css">
.comment {
background: #fafef1;
color: #333;
}
.commentheader {
background: #fff;
color: #999;
}
blockquote {
padding: 5px;
border-left: 5px solid #333;
margin-left: 20px;
background: #fff;
}

</style>
</head>
<body>

<?php

	if (!defined( "KNIFE_PATH" )) {
    	define( "KNIFE_PATH", dirname(__FILE__)."/");	# Absolute path to current script
    	}

	include_once(KNIFE_PATH.'/config.php');					# load temporary config
	include_once(KNIFE_PATH.'/inc/class.articles.php');
	include_once(KNIFE_PATH.'/inc/class.comments.php');
	include_once(KNIFE_PATH.'/inc/class.users.php');				# load userclass - can't live without
	include_once(KNIFE_PATH.'/lang/nb_no.php');				# load a language
	
	include_once(KNIFE_PATH.'/inc/functions.php');
	include_once(KNIFE_PATH.'/plugins/markdown.php');
	
	$pathinfo_array = explode("/",$_SERVER[PATH_INFO]);
	$commentsclass = new KComments;
	$Userclass = new KUsers;
	$KAclass = new KArticles;

#
#	Reset some variables
#

$timestamp = 0;

#
#	Display articles
#

	$settingsdatabase = new SettingsStorage('settings');
	$alltemplates = $settingsdatabase->settings['templates'];
	$allcats = $settingsdatabase->settings['categories'];
	
	$allusers = $Userclass->getusers();
	
	$template = $alltemplates[1];
	
	$amount = $_GET[amount] ? $_GET[amount] : "5";			#FIXME
	if (!$cat && isset($_GET[cat])) { $cat = "$_GET[cat]"; }
	$from = $_GET[from];
	
	
	$allarticles = $KAclass->listarticles($amount, $from);
	
	if (!$_GET[k] and !$pathinfo_array[1] and !$_GET[display] or $static) {
	
	echo "<div>";
	$i = 0;
	
	# set the number of articles to display
	foreach($allarticles as $date => $article) {
	
		# Destroy variables from last loop
		unset($catarray);
		unset($newcatarray);
		
		$output = $template[listing];
		
		# category stuff
		
		
		/*
			what should be done here is the following:
			grab categories (with index and name) from the settings database
			
			compare the !NUMBERS! in $article[category] with the database to find
			the relevant category names for use in {category}.
			
			display only items that match an array_key_exists($_GET[cat], $categories_arr)
			
			*/
			
		$catarray = explode(", ", $article[category]);
		
		foreach ($catarray as $null => $catarraycatid) {
			$newcatarray[$catarraycatid] = $catarraycatid;
			}

		# Replace the category numbers with their names
		foreach ($catarray as $null => $thiscatid) {
			$thiscatinfo = $allcats[$thiscatid];
			$catarray[$null] = $thiscatinfo[name];
			}
			
		$thiscatnamelisting = implode(", ", $catarray);
			

		if ((isset($cat) and array_key_exists($cat, $newcatarray))) {
			# great, the article belongs to the requested category
			}
		else { 
			if (!isset($cat)) {
				# display anything then
				}
			else {
				# curses, this doesn't fit. move on
				continue;
				}	
			}
		
		
		# pre-parsing variable setup

		if (stristr($article[content], "<!--more-->")) {
			$article[content] = explode("<!--more-->", $article[content]);
			
				$article[content][0] = Markdown($article[content][0]);
				$article[content][1] = Markdown($article[content][1]);
			
		# start parsing template variables

			$output = str_replace("{content}", $article[content][0], $output);
			$output = str_replace("{extended}", $article[content][1], $output);
			}		
		$output = str_replace("{title}", $article[title], $output);
		
			$article[content] = Markdown($article[content]);
		
		$output = str_replace("[link]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$PHP_SELF?k=$date\">", $output);
        $output = str_replace("[/link]","</a>", $output);    
				
#		$output = str_replace("[friendlylink]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$_SERVER[PHP_SELF]/".urlTitle($article[title])."\">", $output);
#        $output = str_replace("[/friendlylink]","</a>", $output);
       
		$output = str_replace("[friendlylink]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$_SERVER[SCRIPT_NAME]/".$KAclass->urlconstructor($article, $catarray)."\">", $output);
        $output = str_replace("[/friendlylink]","</a>", $output);

		$output = str_replace("{content}", $article[content], $output);
		$output = str_replace("{extended}", "", $output);
		$output = str_replace("{author}", $article[author], $output);
		$output = str_replace("{category}", $thiscatnamelisting, $output);
		$output = str_replace("{date}", date("dmy H:i", $date), $output);
		
		#
		#	NEEDS ABSTRACTION
		#
#		$articlescomments = $commentsclass->settings[$date];
		$articlescomments = $commentsclass->articlecomments($date);
		if (is_array($articlescomments)) {
		krsort($articlescomments);
		reset($articlescomments);
		
		# get the latest
		$tempcomments = $articlescomments;
		$lastcomment = array_shift($tempcomments);
		unset($tempcomments);
		}
		
		$article[comments] = count($articlescomments);
		$output = str_replace("{latestcomment}", $lastcomment[name], $output);
		$output = str_replace("{comments}", $article[comments], $output);
		
		$article[views] = $KAclass->articleupdate($date, "views", "noupdate");
		$output = str_replace("{views}", $article[views], $output);
		
		if ($article[lastedit]) {
			$output = str_replace("{lastedit}", $article[lastedit], $output);
			}
			else { $output = str_replace("{lastedit}", "", $output);
				}

		echo $output;
		$i++;
		if ($i >= $amount) {
			break 1;
			}
		}
	echo "</div>";
	}
	
	elseif (($_GET[k] or $pathinfo_array[1]) and !$static) {
		include("display_article.php");
		}
	
	
	elseif ($_GET[display] == "documentation") {
		include("documentation.php");
		}
				echo " (debug mode)<br /><pre>";
				print_r($_GET);
				echo "\n\n-----------&lt;- get  | post   -&gt;---------------\n\n";
				print_r($_POST);
				echo "\n\n-----------&lt;- post | cookie -&gt;---------------\n\n;";
				print_r($_COOKIE);
				echo "</pre>";
		
?>

</body>
</html>