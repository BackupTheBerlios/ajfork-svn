<?PHP

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\show_news\.php'", "", $cutepath);
$cutepath = preg_replace( "'/show_news\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/data/config.php");

//----------------------------------
// Check if we are included by PATH
//----------------------------------
if($HTTP_SERVER_VARS["HTTP_ACCEPT"] or $HTTP_SERVER_VARS["HTTP_ACCEPT_CHARSET"] or $HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"] or $HTTP_SERVER_VARS["HTTP_CONNECTION"]){ /* do nothing */ }
elseif(eregi("show_news.php", $PHP_SELF)){
die("<h4>CuteNews has detected that you are including show_news.php using the URL to this file.<br>
This is incorrect and you must include it using the PATH to show_news.php</h4><br>Example:<br>
this is <font color=red>WRONG</font> : &lt;?PHP include(\"http://yoursite.com/cutenews/show_news.php\"); ?&gt;<br>
this is <font color=green>CORRECT</font>: &lt;?PHP include(\"cutenews/show_news.php\"); ?&gt;<br>
<br><BR>// <font size=2>if you think this message shouldn't be shown, open show_news.php and delete it from there</font>");
}
//----------------------------------
// End of the check
//----------------------------------

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
		$category_hidden = $cat_arr[1];
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

if($archive == ""){
	$news_file = "$cutepath/data/news.txt";
	$comm_file = "$cutepath/data/comments.txt";
}else{
	$news_file = "$cutepath/data/archives/$archive.news.arch";
	$comm_file = "$cutepath/data/archives/$archive.comments.arch";
}

$allow_add_comment			= FALSE;
$allow_full_story			= FALSE;
$allow_active_news 			= FALSE;
$allow_comments 			= FALSE;

# Get user status
if( $CN_HALT != TRUE and $static != TRUE and ($aj_go == "more" or $aj_go == "addcomment")){
    if($aj_go == "addcomment"){ $allow_add_comment	= TRUE; $allow_comments = TRUE; }
    if($aj_go == "more"){ $allow_full_story = TRUE; $allow_comments = TRUE; $ref_title = $ref_title; }

}
else{
    if($config_reverse_active == "yes"){ $reverse = TRUE; }
	$allow_active_news = TRUE;
}

$ref_title = $id;
require("$cutepath/inc/shows.inc.php");

unset($static, $template, $requested_cats, $category, $catid, $cat,$reverse, $in_use, $archives_arr, $number, $no_prev, $no_next, $i, $showed, $prev, $used_archives);
?>


	<!-- 
		#	Content proudly powered by AJ-Fork
		#	URL: http://appelsinjuice.org/?vis=cutenews-aj
		#	 @ : cutenews at appels in juice dot org
	-->
	
	
