<?php

#
#	This script will convert an AJ-Fork v.2.1 news.txt to
#	knife's internal articles database format.
#
#	This is the flat-file version, meaning the knife database will
#	be saved in data/articles.php
#

	include("inc/functions.php");								# get needed functions/classes
	$ajforkdb = file("news.txt");								# load ajfork database
	$knifedb = array();											# set up the knife database array
	foreach ($ajforkdb as $null => $article) {					# traverse the ajfork db entry by entry
		$article = explode("|", $article);						# split up the ajfork entry fields
		$article[3] = str_replace("{nl}", "\n", $article[3]);	# remove the silly {nl} in content
		$knifedb[$article[0]] = array(							# start writing to the array
			"content" => $article[3],							# fill knife content
			"title" => $article[2],								# fill knife title
			"author" => $article[1],
			"lastedit" => $article[1],
			"category" => $article[6],
			"views" => 0,										# set views to neutral
			);
		}
	$dataclass = new ArticleStorage('storage');					# load a knife article class
	$dataclass->settings['articles'] = $knifedb;				# overwrite the knife db with our db
	$dataclass->save();											# save it all

																# FINISHED
?>