<?php
error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\search\.php'", "", $cutepath);
$cutepath = preg_replace( "'/search\.php'", "", $cutepath);
include($cutepath . "/data/config.php");

if (!defined('PLUGIN_FRAMEWORK_VERSION')) {
@include($cutepath.'/inc/plugins.php');
@LoadActivePlugins();
}

//AJB Visible language addon
$vis_lang_file = $cutepath . "/" . $config_cn_lang;
if (file_exists($vis_lang_file) && !$lang_floodprot) {
	include($vis_lang_file);
	}
	// END AJBVISLANGADD
	
require_once("$cutepath/inc/functions.inc.php");

	
$user_query = cute_query_string($QUERY_STRING, array("search_in_archives", "start_from", "archive", "aj_go", "id", "cnshow",
"ucat","dosearch", "story", "title", "user", "from_date_day", "from_date_month", "from_date_year", "to_date_day", "to_date_month", "to_date_year"));
$user_post_query = cute_query_string($QUERY_STRING, array("search_in_archives", "start_from", "archive", "aj_go", "id", "cnshow",
"ucat","dosearch", "story", "title", "user", "from_date_day", "from_date_month", "from_date_year", "to_date_day", "to_date_month", "to_date_year"), "post");

// Define Users
$all_users = file("$cutepath/data/users.db.php");
foreach($all_users as $null => $my_user)
{
	if(!eregi("<\?",$member_db_line)){
		$user_arr = explode("|",$my_user);
		if($user_arr[4] != ""){ $my_names[$user_arr[2]] = "$user_arr[4]"; }
		else{ $my_names[$user_arr[2]] = "$user_arr[2]"; }
    }
}
// Show Search Form
echo<<<HTML
<script type="text/javascript">
	function mySelect(form){
	    form.select();
    }
	function ShowOrHide(d1, d2) {
	  if (d1 != '') DoDiv(d1);
	  if (d2 != '') DoDiv(d2);
	}
	function DoDiv(id) {
	  var item = null;
	  if (document.getElementById) {
		item = document.getElementById(id);
	  } else if (document.all){
		item = document.all[id];
	  } else if (document.layers){
		item = document.layers[id];
	  }
	  if (!item) {
	  }
	  else if (item.style) {
		if (item.style.display == "none"){ item.style.display = ""; }
		else {item.style.display = "none"; }
	  }else{ item.visibility = "show"; }
 	}
</script>
<div id="cutesearch">
<h1>$lang_search_header</h1>
<form method="get" action="$PHP_SELF?aj_go=search">

<p>
	<input id="story" type="text" value="$story" name="story" size="24" />
	<label for="story">$lang_search_news</label>
	<input type="hidden" id="dosearch" name="dosearch" value="yes" />
</p>

<div id="advanced" style="display:none;z-index:1;">
	<p>
    <input id="title" type="text" value="$title" name="title" size="24" />
    <label for="title">$lang_search_title</label>
    </p>
    <p>
    <input id="user" type="text" value="$user" name="user" size="24" />
    <label for="user">$lang_search_author</label>
	</p>
	
HTML;
/*
	<p>
	<select id="from_date_day" name="from_date_day">
    <option value="">  </option>
HTML;

for($i=1;$i<32;$i++){
    if($from_date_day == $i){ 
    echo"<option selected=\"selected\" value=\"$i\">$i</option>"; 
    }
    else{ 
    echo"<option value=\"$i\">$i</option>"; 
    }
}

echo"</select><select id=\"from_date_month\" name=\"from_date_month\">       <option value=\"\">  </option>";

for($i=1;$i<13;$i++){
    $timestamp = mktime(0,0,0,$i,1,2003);
    if($from_date_month == $i){ 
    echo"<option selected=\"selected\" value=\"$i\">". ucfirst(strftime("%b", $timestamp)) ."</option>"; 
    }
    else{ 
    echo"<option value=\"$i\">". ucfirst(strftime("%b", $timestamp)) ."</option>"; 
    }
}

echo"</select><select id=\"from_date_year\" name=\"from_date_year\">       <option value=\"\">  </option>";

for($i=2003;$i<2011;$i++){
    if($from_date_year == $i){ echo"<option selected=\"selected\" value=$i>$i</option>"; }
    else{ echo"<option value=\"$i\">$i</option>"; }
}
//////////////////////////////////////////////////////////////////////////
echo<<<HTML
	</select>
	<label for="from_date_day">$lang_search_from</label>
	</p>
	<p>
    <select id="to_date_day" name="to_date_day">
    <option value="">  </option>
HTML;
for($i=1;$i<32;$i++){
    if($to_date_day == $i){ echo"<option selected=\"selected\" value=\"$i\">$i</option>"; }
    else{ echo"<option value=\"$i\">$i</option>"; }
}

echo"</select><select id=\"to_date_month\" name=\"to_date_month\"><option value=\"\">  </option>";

for($i=1;$i<13;$i++){
    $timestamp = mktime(0,0,0,$i,1,2003);
    if($to_date_month == $i){ echo"<option selected=\"selected\" value=\"$i\">". ucfirst(strftime("%b", $timestamp)) ."</option>"; }
    else{ echo"<option value=\"$i\">". ucfirst(strftime("%b", $timestamp)) ."</option>"; }
}

echo"</select><select id=\"to_date_year\" name=\"to_date_year\"><option value=\"\">  </option>";

for($i=2003;$i<2011;$i++){
    if($to_date_year == $i){ echo"<option selected=\"selected\" value=\"$i\">$i</option>"; }
    else{ echo"<option value=\"$i\">$i</option>"; }
}

if($search_in_archives){ $selected_search_arch = "checked=\"checked\""; }

echo<<<HTML
    </select>
    <label for="to_date_day">$lang_search_to</label>
    </p>
    */
    
echo<<<HTML
    <p>
    <input id="search_in_archives" type="checkbox" $selected_search_arch name="search_in_archives" value="TRUE" />
    <label for="search_in_archives">$lang_search_archives</label>
    </p>
	</div>
<p>
	<a href="javascript:ShowOrHide('advanced','')">$lang_search_advanced</a>
	<input type="submit" value="$lang_search_button" />
</p>
<p>
$user_post_query
</p>
</form>
</div>
<div id="cutesearchresults">
HTML;

// Don't edit below this line unless you know what you are doing !!!

if($dosearch == "yes")
{

    if( $from_date_day != "" and $from_date_month != "" and $from_date_year != "" and $to_date_day != "" and $to_date_month != "" and $to_date_year != "" )
    {
        $date_from 	= mktime(0,0,0,$from_date_month,$from_date_day,$from_date_year);
        $date_to 	= mktime(0,0,0,$to_date_month,$to_date_day,$to_date_year);

        $do_date = TRUE;
    }


	$story = trim($story);

	if($search_in_archives){
    	if(!$handle = opendir("$cutepath/data/archives")){ die($lang_search_cnoarch); }
		while (false !== ($file = readdir($handle)))
		{
			if($file != "." and $file != ".." and eregi("news", $file))
			{
				$files_arch[] = "$cutepath/data/archives/$file";
	        }
		}
	}
    $files_arch[] = "$cutepath/data/news.txt";

    foreach($files_arch as $null => $file)
    {
        $archive = FALSE;
        if(ereg("([[:digit:]]{0,})\.news\.arch", $file, $regs)){ $archive = $regs[1]; }
        $all_news_db = file("$file");
    	foreach($all_news_db as $null => $news_line){
			$news_db_arr = explode("|",$news_line);
			$found  = 0;

			$fuser  = FALSE;
			$ftitle = FALSE;
			$fstory = FALSE;
			if($title and @preg_match("/$title/i", "$news_db_arr[2]")){ $ftitle = TRUE; }
			if($user  and @preg_match("/\b$user\b/i", "$news_db_arr[1]")){ $fuser = TRUE; }
			if($story and (@preg_match("/$story/i", "$news_db_arr[4]") or @preg_match("/$story/i", "$news_db_arr[3]"))){ $fstory = TRUE;}

			if($title and $ftitle){ $ftitle = TRUE; }elseif(!$title){ $ftitle = TRUE; }else{ $ftitle = FALSE; }
			if($story and $fstory){ $fstory = TRUE; }elseif(!$story){ $fstory = TRUE; }else{ $fstory = FALSE; }
			if($user  and $fuser) { $fuser  = TRUE; }elseif(!$user) { $fuser  = TRUE; }else{ $fuser  = FALSE; }
            if($do_date)
            {
            	if($date_from < $news_db_arr[0] and  $news_db_arr[0] < $date_to){ $fdate = TRUE; }else{ $fdate = FALSE; }
            }else{ $fdate = TRUE; }

			if($fdate and $ftitle and $fuser and $fstory){ $found_arr[$news_db_arr[0]] = $archive; }

		}//foreach news line
	}


	echo "<h1>$lang_search_found</h1>";


    	if($do_date){echo $lang_search_founddate;}


    // Display Search Results
    if(is_array($found_arr)){
        foreach($found_arr as $news_id => $archive)
        {
            if($archive){$all_news = file("$cutepath/data/archives/$archive.news.arch");}
            else{ $all_news = file("$cutepath/data/news.txt"); }

            foreach($all_news as $null => $single_line)
   			{
   				$item_arr = explode("|",$single_line);
   				$local_id = $item_arr[0];

   				if($local_id == $news_id){
////////// Showing Result

	$localdate = langdate($config_timestamp_active, $item_arr[0]);
                    echo"<br /><strong><a title=\"".htmlentities($item_arr[2])."\" href=\"$PHP_SELF?misc=search&amp;aj_search=$story&amp;aj_go=more&amp;ucat=$item_arr[6]&amp;id=$local_id&amp;archive=$archive&amp;cnshow=news&amp;start_from=&amp;$user_query\">$item_arr[2]</a></strong> <small>($localdate)</small>";

////////// End Showing Result
                }
   			}
   		}
     }else{ echo $lang_search_notfound; }

}//if user wants to search
elseif( ($misc == "search") and ($aj_go == "more" or $_POST["aj_go"] == "more")){

	require_once("$cutepath/show_news.php");

	unset($action,$aj_go);
}
echo "</div>";

?>
