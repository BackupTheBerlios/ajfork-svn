<?PHP

error_reporting (E_ALL ^ E_NOTICE);

#$cutepath = ".";

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\show_archives\.php'", "", $cutepath);
$cutepath = preg_replace( "'/show_archives\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/data/config.php");
if (!defined('PLUGIN_FRAMEWORK_VERSION')) {
@include($cutepath.'/inc/plugins.php');
@LoadActivePlugins();
}

$vis_lang_file = $cutepath . "/" . $config_cn_lang;
if (file_exists($vis_lang_file) && !$lang_floodprot) {
	include($vis_lang_file);
	}

if(!isset($aj_go) or $aj_go == ""){ $aj_go = $POST["aj_go"]; }

if(!isset($template) or $template == ""){ 
	$template = "aj-not-set-template";
	}

if(eregi("[a-z]", $category)){	

	# id recognition for a-z categories
	$all_cats = file("$cutepath/data/category.db.php");
	foreach($all_cats as $null => $cat_line){
   		$cat_arr = explode("|", $cat_line);
    	$cat_arr[1] = stripslashes( preg_replace(array("'\"'", "'\''"), array("&quot;", "&#039;"), $cat_arr[1]) );
    	
    	if($cat_arr[1] == $category) {
    		$category = $cat_arr[0];
		$category_template = $cat_arr[5];
    		}
    	}

	# stop killing the script just because the user prefers a-z categories!
}

if ($template == "aj-not-set-template") {
	if (isset($category_template) and $category_template != "") {
		$template = $category_template;
		require_once("$cutepath/data/${template}.tpl");
		}
	else {
		require_once("$cutepath/data/Default.tpl");
	}
}

else{
	if(file_exists("$cutepath/data/${template}.tpl")){ require_once("$cutepath/data/${template}.tpl"); }
    else{ die("Error!<br>the template <b>$template</b> does not exists, note that templates are case sensetive and you must write the name exactly as it is"); }
}


$category = preg_replace("/ /", "", $category);
$tmp_cats_arr = explode(",", $category);
foreach($tmp_cats_arr as $key=>$value){
    if($value != ""){ $requested_cats[$value] = TRUE; }
}


if($archive == "" or !$archive){
	$news_file = "$cutepath/data/news.txt";
	$comm_file = "$cutepath/data/comments.txt";
}else{
	$news_file = "$cutepath/data/archives/$archive.news.arch";
	$comm_file = "$cutepath/data/archives/$archive.comments.arch";
	$desc_file = "$cutepath/data/archives/$archive.desc.arch";
}

/*
	Function: 	aaaaa
	Description:	Fetches the contents of a post
	Credit:		eruin
*/
function aj_archivelist($newsfile, $arch_file, $everything) {
	$lines = file("$newsfile");
	$i = 0;
	$t_everything = "";
	foreach ($lines as $null => $line) {
		list($date, $user, $title,$short,$unused1,$unknown1, $cat, $unknown3) = explode('|',trim($line));			
	   	$news = array(
		"title" => $title,
		"category" => $cat,
		"home" => $arch_file,
		);
		$everything["$date"] = $news;
		}
	return $everything;
}

if($aj_go == "" or !isset($aj_go)){
		$user_query = cute_query_string($QUERY_STRING, array("start_from", "archive", "aj_go", "id", "ucat"));

        if(!$handle = opendir("$cutepath/data/archives")){ die("<center>Can not open directory $cutepath/data/archives "); }
        while (false !== ($file = readdir($handle))) {
			$file_arr = explode(".",$file);
			if($file != "." and $file != ".." and $file_arr[1] == "news"){
				$arch_arr[] = $file_arr[0];
			}
		}
        closedir($handle);

        if(is_array($arch_arr)){
	        $arch_arr = array_reverse($arch_arr);
		$i = 0;
		$everything = array();
	        foreach($arch_arr as $null => $arch_file){

				#$news_lines = file("$cutepath/data/archives/$arch_file.news.arch");
				#$description = @file("$cutepath/data/archives/$arch_file.desc.arch");
				#$description = $description[0];
				#$count = count($news_lines);
				#$last = $count-1;
				#$first_news_arr = explode("|", $news_lines[$last]);
				#$last_news_arr	= explode("|", $news_lines[0]);

				#$first_timestamp = $first_news_arr[0];
				#$last_timestamp	 = $last_news_arr[0];
				
				$everything = aj_archivelist("$cutepath/data/archives/$arch_file.news.arch", $arch_file, $everything);
				}

		$totalt = count($everything);
		$i = 0;
		$mc = 0;
		$ma = 1;
		krsort($everything);
		reset($everything);
		foreach($everything as $date => $info) {

			$archivelink = "<a href=\"$PHP_SELF?archive=$info[home]&amp;ucat=$info[category]&amp;aj_go=more&amp;id=$date&amp;$user_query\">$info[title]</a>";
			$archivelink = run_filters('monthly-link-title-url', $archivelink);
	
			if ($i != 0) { $opener = "\t</ul>\n"; $openertwo = "</li>"; } else { $opener = ""; $opener2 = ""; }

			# Monthly headers
			if ($dateheader_S != date("mY", $date)) {
				if ($num_months && $ma > $num_months) { break 1; }
				$m_amount = $mc;
				$mc = 0;
				$dateheader_S = date("mY", $date);
 				$dateheader = langdate("F Y", $date);
				$dateheader_p = "$openertwo\n$opener\n<h1>{month}</h1>\n\t<ul class=\"ajforkmonthlist\">";
		 		$dateheader_p = str_replace("{month}", $dateheader, $dateheader_p);
				echo $dateheader_p;
				$ma++;
				}
			
			if ($entrydayofmonth == date("d", $date)) {
				$multiple = 1;
				echo "<strong> , </strong>$archivelink";
				}
			else {
				if ($mc == 0) { $openertwo = ""; }
				$daysingle = date("d", $date);
				echo "$openertwo\n\t\t<li><strong>$daysingle</strong>: $archivelink";
				}

			$entrydayofmonth = date("d", $date);
			$i++;
			$mc++;
			}
			echo "</li>\n\t</ul>\n\n<div id=\"ajforkmonthlist_total\">$totalt</div>";
		}
}
else{

if( $CN_HALT != TRUE and $static != TRUE and ($aj_go == "more" or $aj_go == "addcomment") and ((!isset($category) or $category == "") or $requested_cats[$ucat] == TRUE) ){
    if($aj_go == "addcomment"){ $allow_add_comment	= TRUE; $allow_comments = TRUE; }
    if($aj_go == "more"){ $allow_full_story = TRUE; $allow_comments = TRUE; $ref_title = $ref_title; }

}
else{
    if($config_reverse_active == "yes"){ $reverse = TRUE; }
	$allow_active_news = TRUE;
}
$ref_title = $id;
require("$cutepath/inc/shows.inc.php");

}
unset($template, $requested_cats, $reverse, $in_use, $archive, $archives_arr, $number, $no_prev, $no_next, $i, $showed, $prev, $used_archives);
?>

	<!-- 
		#	Content proudly powered by AJ-Fork
		#	URL: http://appelsinjuice.org/?vis=cutenews-aj
		#	 @ : cutenews at appels in juice dot org
	-->
