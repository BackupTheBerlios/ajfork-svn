<?php
/*
Plugin Name:	Unarchive
Description:	Allows the restoration of archives back to news.txt
Version:		1.0
Author:			J-Dawg
Author URI:		http://www.jubbag.com
Application:	CuteNews
Required Framework: 1.1.3
*/

@add_action('plugin-options','unarch_options');
@add_filter('cutenews-options', 'add_unarch_to_options');

function unarch_options($hook) 
{
	if ($_GET['action'] == 'unarch') 
	{
		list_archs();
	}
}

function add_unarch_to_options($options, $hook) 
{
	global $PHP_SELF;
	
	// Add a custom screen to the "options" screen
	$options[] = array(
		'name'		=> 'Unarchive Manager',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=unarch',
		'access'	=> '1',
			);

	// return the customized options
	return $options;
}

function list_archs() 
{
	global $cutepath,$_GET;
	$archive = $_GET['archtounarch'];
	echoheader("archives", "UnArchives");
	echo "<p><b>Send news from archive to active news.</b></p>";
	if (!empty($archive))
	{
		$success = 0;
		if(!$handle = opendir("$cutepath/data/archives"))
		{
			die("Can not open directory $cutepath/data/archive ");
		}
   		while (false !== ($file = readdir($handle)))
		{
   			if($file == "$archive.desc.arch")
			{
           		unlink("./data/archives/$file"); $success ++;
   			}
			else if ($file == "$archive.news.arch")
			{
				$newsfp = fopen("$cutepath/data/news.txt", 'a');
				$newsarch = file("$cutepath/data/archives/$file");
				foreach ($newsarch as $null => $newsline)
				{
					fwrite($newsfp,$newsline);
				}
				fclose($newsfp);
				unlink("$cutepath/data/archives/$file");
				$success ++;
			}
			else if ($file == "$archive.comments.arch")
			{
				$commfp = fopen("$cutepath/data/comments.txt", 'a');
				$commarch = file("$cutepath/data/archives/$file");
				foreach ($commarch as $null => $commline)
				{
					fwrite($commfp,$commline);
				}
				fclose($commfp);
				unlink("$cutepath/data/archives/$file");
				$success ++;
			}
		}
	closedir($handle);
	}

	if(!$handle = opendir("$cutepath/data/archives"))
	{ 
		die("<center>Can not open directory $cutepath/data/archives ");
	}
	echo '<b>Available archives</b>
  <table style="width: 100%;">
    <tr>
      <td class="alternate"><u>description</u></td>
      <td class="alternate"><u>archivation date</u></td>
      <td class="alternate"><u>duration</u></td>
      <td class="alternate"><u>news</u></td>
      <td class="alternate"><u>action</u></td>
    </tr>';
   	while (false !== ($file = readdir($handle)))
	{
   		if($file != "." and $file != ".." and !is_dir("./data/archives/$file") and eregi("news.arch", $file))
        {
           	$file_arr = explode(".", $file);
            $id = $file_arr[0];
            $news_lines = file("./data/archives/$file");
            $creation_date = date("d F Y",$file_arr[0]);
            $archive_description = @file("./data/archives/$id.desc.arch");
            $archive_description = $archive_description[0];
            $count = count($news_lines);
            $last = $count-1;
            $first_news_arr = explode("|", $news_lines[$last]);
            $last_news_arr = explode("|", $news_lines[0]);
            $first_timestamp = $first_news_arr[0];
            $last_timestamp = $last_news_arr[0];
			$duration = (date("d M Y",$first_timestamp) ." - ". date("d M Y",$last_timestamp) );
			echo "
			<tr>
		      <td>$archive_description</td>
		      <td>$creation_date</td>
		      <td>$duration</td>
		      <td>$count</td>
		      <td><a title='Restore Archive' href=\"$PHP_SELF?mod=options&amp;action=unarch&amp;archtounarch=$id\">[restore]</a></td>
			</tr>
               ";
		}
   	}
	closedir($handle);
	    if($count == 0){
	    echo"<tr><td colspan=\"5\">There are no archives</td></tr>";
    }
	echo "</table>";
	echofooter();
}
				
				?>
