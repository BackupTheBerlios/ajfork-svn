<?php

/*

	Convert old full story scheme to the new
	ajfork-preferred way of wordpress-style
	(shortstory<!--more-->fullstory)
*/

$old_file = file("data/news.txt");
$updated_file = fopen("data/news.txt", w);

$counter = 0;


foreach ($old_file as $null => $line) {
	if (stristr($line, "<!--more-->")) { 
		fwrite($updated_file, $line);
		continue;
		}
	else {
	
		# jolly good, this line didn't contain the new syntax, on we go then:
		$entry = explode("|", $line);
		if ($entry[4] and $entry[4] != "") {
			
			# replace any newlines/feeds that might corrupt the db
			$entry = str_replace("\n", "", $entry);
			$entry = str_replace("\r", "", $entry);
			#woohoo, we've got work to do!
			$updated_line = "$entry[0]|$entry[1]|$entry[2]|$entry[3]<!--more-->$entry[4]|$entry[5]|$entry[6]|$entry[7]|$entry[8]|$entry[9]|$entry[10]|$entry[11]|\n";

			#if the last rebuild went ok, that's great. write it.
			fwrite($updated_file, $updated_line);
			continue;
			}
		else {
			#no full story.. just write the line as-is
			fwrite($updated_file, $line);
			continue;
			}
		}
}

fclose($updated_file);
