<?php
/* Configuration
	
	$lcomments_number 	= "number of comments to show";
	$site_url 			= "full url, including any "?show=moo&run=baah", to where you show your news";
	$blogpath 			= "where AJ-Fork is located _relative_ to the page you're _including_ this script in";
	$maxlen				= "max length of comments displayed, including commenter's name";
	$maxpend			= "what to append after a comment if it has been shortened due to the above variable";
	$date_format		= "format of {date}, help @ http://www.php.net/manual/en/function.date.php";
	$lctemplate			= 	<<<HTML 
							<any html here. allowable variables are: {url}, {name}, {date}, {date-local} 
							(uses news-format-date-local from config), {comment}, {ip}, {mail}, {newsid}, 
							{comid}, {alternating}>
							HTML;
	*/

if(!isset($lcomments_number)) $lcomments_number = 10;
$site_url = 'example.php';
$blogpath = ".";
$maxlen = "60";
$maxpend = "[mer]";
$date_format = 'd M y H:i';
$lctemplate = <<<HTML
<div class="{alternating}">
	<a title="Skrevet til &quot;{title}&quot; ({date-local})" href="{url}">{name}</a>: 
	{comment} {more}
</div>
HTML;

require_once("$blogpath/inc/functions.inc.php");
/* ~E~N~D~~C~O~N~F~I~G~U~R~A~T~I~O~N~ */
	require("$blogpath/data/config.php");
	
	setlocale (LC_ALL, $config_locale_active);
	$latest_comments = array_fill(1, $lcomments_number, array('newsid'=>'0','comid'=>'0','name'=>'','mail'=>'','ip'=>'','comment'=>''));
	if (eregi("\?", $site_url)) { $modifier = "&amp;"; } else { $modifier = "?"; }

    function check_latest_comment($lcomment_line, $newsid) {
    	global $latest_comments;
        $tmp_latest_comments = $latest_comments;
        $lcomment_arr = explode("|", $lcomment_line);
        foreach($latest_comments as $key=>$latest_comment) {

            if($latest_comment['comid'] < $lcomment_arr[0]) {
                $previous = $latest_comments[$key];
                
                foreach($latest_comments as $my_key=>$latest_comment_arr) {
                	if($key < $my_key){
                    	$current = $latest_comments[$my_key];
                    	$latest_comments[$my_key] = $previous;
                    	$previous = $current;
                    	}
					}

                $latest_comments[$key] = array(
                'newsid'	=> trim($newsid),
                'comid'		=> trim($lcomment_arr[0]),
                'name'		=> trim($lcomment_arr[1]),
                'mail'		=> trim($lcomment_arr[2]),
                'ip'		=> trim($lcomment_arr[3]),
                'comment'	=> trim($lcomment_arr[4]),);
            	}
        	}
    	}

    $all_comments = file("$blogpath/data/comments.txt");
    foreach($all_comments as $null => $lcomment_line) {
		$lcomment_line_arr = explode("|>|", $lcomment_line);
        $newsid = $lcomment_line_arr[0];
        $lcomment_arr = explode("||", $lcomment_line_arr[1]);
		foreach($lcomment_arr as $null => $lsingle_comment) {	
            check_latest_comment($lsingle_comment, $newsid);
			}
   		}
    echo "<!-- Latest $lcomments_number comments from any article displayed here -->\n";
    $cc = 1;
    foreach($latest_comments as $null => $lcomment) {
    	// linkelements
    	$parententry = aj_PostInfo($lcomment["newsid"], "$blogpath/data/news.txt");
  		$title = aj_prepareTitle($parententry["title"]);
  		$urldate = date("Y/m/d/", $parententry["date"]);
  		
  		$flink = "$urldate$title";
    	
    	if ($lcomment['name'] == "") { continue; }
		$output = $lctemplate;
	    $output = str_replace("{url}", $flink, $output);
	    $output = str_replace("{name}", $lcomment['name'], $output);
	    $output = str_replace("{mail}", $lcomment['mail'], $output);
	    $output = str_replace("{ip}", $lcomment['ip'], $output);
	    
		$lcomment['comment'] = stripslashes(strip_tags($lcomment['comment']));
		$lcomment['comment'] = preg_replace("'\[(.*?)\](.*?)\[/(.*?)\]'i","\\2",$lcomment['comment']);
		$lcomment_length = strlen($lcomment['comment']);
		$maxlenminusnavn = $maxlen - strlen($lcomment['name']);
		if ($lcomment_length > $maxlen) { 
			$lcomment['comment'] = substr($lcomment['comment'], 0, $maxlenminusnavn);
			}
		
	    $output = str_replace("{comment}", $lcomment['comment'], $output);
	    if ($lcomment_length > $maxlen) { 
	    $output = str_replace("{more}", "<a href=\"$flink\">$maxpend</a>", $output);
	    }
	    else { $output = str_replace("{more}", "", $output); }
	    $output = str_replace("{title}", $parententry["title"], $output);
	    $output = str_replace("{date}", date($date_format, $lcomment['comid']), $output);
	    $output = str_replace("{date-local}", trim(strftime($config_timestamp_local_active, $lcomment['comid'])), $output);
	    $output = str_replace("{newsid}", $lcomment['newsid'], $output);
	    $output = str_replace("{comid}", $lcomment['comid'], $output);
	    if ($cc%2 == 0) { $output = str_replace("{alternating}", "cn_comment_odd", $output); }
	    else { $output = str_replace("{alternating}", "cn_comment_even", $output); }
        echo "$output\n";
        if ($cc == $lcomments_number) { break 1; }
        $cc++;
    	}
    echo "<!-- All tags and BBcode killed. -->";
 
?>
