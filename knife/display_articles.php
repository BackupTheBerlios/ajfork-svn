<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>knife</title>
</head>
<body>

<?php

	if (!defined( "KNIFE_PATH" )) {
    	define( "KNIFE_PATH", dirname(__FILE__)."/");	# Absolute path to current script
    	}

	include(KNIFE_PATH.'/config.php');					# load temporary config
	include(KNIFE_PATH.'/class.articles.php');
	
include("inc/functions.php");
include("plugins/markdown.php");
$pathinfo_array = explode("/",$_SERVER[PATH_INFO]);
print_r($pathinfo_array);

$commentsclass = new CommentStorage('comments');

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
	
	$template = $alltemplates[1];
	
	$KAclass = new KArticles;
	$allarticles = $KAclass->listarticles();
	
	krsort($allarticles);
	reset($allarticles);

	if (!$_GET[k] and !$pathinfo_array[1]) {
	
	echo "<div>";
	$i = 0;
	
	# set the number of articles to display
	$amount = $_GET[amount] ? $_GET[amount] : "5";
	$cat = $_GET[cat];
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
			if (!$cat) {
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
		
#		$output = str_replace("[friendlylink]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$PHP_SELF?k=".urlTitle($article[title])."\">", $output);
#        $output = str_replace("[/friendlylink]","</a>", $output);
		
		$output = str_replace("[friendlylink]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$_SERVER[PHP_SELF]/".urlTitle($article[title])."\">", $output);
        $output = str_replace("[/friendlylink]","</a>", $output);
        
		$output = str_replace("{content}", $article[content], $output);
		$output = str_replace("{extended}", "", $output);
		$output = str_replace("{author}", $article[author], $output);
		$output = str_replace("{category}", $thiscatnamelisting, $output);
		$output = str_replace("{date}", date("dmy H:i", $date), $output);
		
		#
		#	NEEDS ABSTRACTION
		#
		$articlescomments = $commentsclass->settings[$date];
		$article[comments] = count($articlescomments);
		
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
	
	elseif ($_GET[k] or $pathinfo_array[1]) {
		include("display_article.php");
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