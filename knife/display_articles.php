<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>knife</title>
</head>
<body>

<?php


#
#	Reset some variables
#

$timestamp = 0;


#
#	Display articles
#

include("inc/functions.php");
include("plugins/markdown.php");


	$articledatabase = new ArticleStorage('storage');
	$templatesdatabase = new SettingsStorage('settings');
	$alltemplates = $templatesdatabase->settings['templates'];
	$template = $alltemplates[1];
	
	$allarticles = $articledatabase->settings['articles'];
	
	krsort($allarticles);
	reset($allarticles);

	if (!$_GET[k]) {
	echo "<div>";
	$i = 0;
	$amount = $_GET[amount] ? $_GET[amount] : "5";
	foreach($allarticles as $date => $article) {
		$output = $template[listing];
		
		# category stuff
		
		
		/*
			what should be done here is the following:
			grab categories (with index and name) from the settings database
			
			compare the !NUMBERS! in $article[category] with the database to find
			the relevant category names for use in {category}.
			
			display only items that match an array_key_exists($_GET[cat], $categories_arr)
			
			*/
		
		$categories_arr = explode(", ", $article[category]);
#		print_r($categories_arr);	
		if (array_key_exists($_GET[cat], $categories_arr)) {
			echo "yes!";
			}
		else { echo "noo"; continue; }	
		
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
		
		$output = str_replace("[friendlylink]","<a title=\"".htmlspecialchars($article[title])."\" href=\"$PHP_SELF?k=".urlTitle($article[title])."\">", $output);
        $output = str_replace("[/friendlylink]","</a>", $output);
		
		$output = str_replace("{content}", $article[content], $output);
		$output = str_replace("{extended}", "", $output);
		$output = str_replace("{author}", $article[author], $output);
		$output = str_replace("{category}", $article[category], $output);
		$output = str_replace("{date}", date("dmy H:i", $date), $output);

		echo $output;
		$i++;
		if ($i >= $amount) {
			break 1;
			}
		}
	echo "</div>";
	}
	
	elseif ($_GET[k] && !$_POST[comment]) {
	
		$k = $_GET[k];
		if (eregi("[a-z]", $k)) {
			# if $k is alpha , find the timestamp for this article

			foreach ($allarticles as $timestamp => $article) {
				if (urlTitle($article[title]) == $k) {
					$k = $timestamp;
					break 1;
					}
				}
			}
			
			
		$article = $allarticles[$k];

		# date can come from two places
		if ($timestamp) {
			$date = $timestamp;
			}
		else {
			$date = $k;
			}
			
		# select the current template
		$output = $template[view];
		# parse the listing template
		
		if (stristr($article[content], "<!--more-->")) {
			$article[content] = explode("<!--more-->", $article[content]);
			
				$article[content][0] = Markdown($article[content][0]);
				$article[content][1] = Markdown($article[content][1]);
			
			$output = str_replace("{content}", $article[content][0], $output);
			$output = str_replace("{extended}", $article[content][1], $output);
			}		
		$output = str_replace("{title}", $article[title], $output);
		
			$article[content] = Markdown($article[content]);
		
		$output = str_replace("{content}", $article[content], $output);
		$output = str_replace("{extended}", "", $output);
		$output = str_replace("{author}", $article[author], $output);
		$output = str_replace("{category}", $article[category], $output);
		$output = str_replace("{date}", date("dmy H:i", $date), $output);
		$output = str_replace("{link}", "<a href=\"?k=$date\" title=\"$article[title]\">Read</a>", $output);

		echo $output;
		
		$output = '
		<form method="post" style="margin-top: 20px; padding: 15px; border: 1px solid #999;">
		<input type="text" name="comment[name]" /> Name<br />
		<input type="text" name="comment[email]" /> Email<br />
		<input type="text" name="comment[url]" /> URL<br /><br />
		
		Comment<br />
		<textarea name="comment[content]" rows="7" cols="50"></textarea><br />
		<input type="submit" value="Add comment"/>
		</form>';
		
		echo $output;
		}
	
	
?>

</body>
</html>