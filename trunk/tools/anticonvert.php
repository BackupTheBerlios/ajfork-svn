<?php
$old_file = file("data/news.txt");
$updated_file = fopen("data/news.txt", w);
$counter = 0;
foreach ($old_file as $null => $line) {
	if (!stristr($line, "<!--more-->")) { 
		fwrite($updated_file, $line);
		continue;
		}
	else {
	
		# jolly good, this line didn't contain the new syntax, on we go then:
		$line = str_replace("\n", "", $line);
		$entry = explode("|", $line);
			#woohoo, we've got work to do!
			$short = explode("<!--more-->", $entry[3]);
			$updated_entry = "$entry[0]|$entry[1]|$entry[2]|$short[0]|$short[1]|$entry[5]|$entry[6]|$entry[7]|$entry[8]|$entry[9]|$entry[10]|$entry[11]|\n";

			#if the last rebuild went ok, that's great. write it.
			fwrite($updated_file, $updated_entry);
			continue;
		}
}
fclose($updated_file);
