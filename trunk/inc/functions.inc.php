<?PHP
if ($HTTP_GET_VARS)     {extract($HTTP_GET_VARS, EXTR_SKIP);}
if ($_GET)              {extract($_GET, EXTR_SKIP);}
if ($HTTP_POST_VARS)    {extract($HTTP_POST_VARS, EXTR_SKIP);}
if ($_POST)             {extract($_POST, EXTR_SKIP);}
if ($HTTP_COOKIE_VARS)  {extract($HTTP_COOKIE_VARS, EXTR_SKIP);}
if ($_COOKIE)           {extract($_COOKIE, EXTR_SKIP);}
if ($HTTP_SESSION_VARS) {extract($HTTP_SESSION_VARS, EXTR_SKIP);}
if ($_SESSION)          {extract($_SESSION, EXTR_SKIP);}
if ($HTTP_ENV_VARS)     {extract($HTTP_ENV_VARS, EXTR_SKIP);}
if ($_ENV)              {extract($_ENV, EXTR_SKIP);}
if($PHP_SELF == ""){ $PHP_SELF = $HTTP_SERVER_VARS["PHP_SELF"]; }

$cstart = htmlspecialchars($cstart);
$start_from = htmlspecialchars($start_from);
$archive = htmlspecialchars($archive);
$aj_go = htmlspecialchars($aj_go);
$id = htmlspecialchars($id);
$ucat = htmlspecialchars($ucat);
$category = htmlspecialchars($category);
$number = htmlspecialchars($number);
$template = htmlspecialchars($template);
$furls_date = htmlspecialchars($furls_date);
$aj_server_time = time();


/*
   Function:		sane_post_var
   Description:		Kills db-killing strings
   Credit:			eruin
*/
	# fix posted variables, ffs
	function sane_post_var($input) {
		$input = preg_replace( array("'<'", "'>'", "'\n'", "'\r'", "'\|'"), array("", "", "", "", ""), $input);
		return $input;
	}


/*
   Function:		makeRandomPassword
   Description:		Creates a random password
   Credit:		NyNe
*/
function makeRandomPassword() {
	$salt = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789";
	$pass = "";
	srand((double)microtime()*1000000);
	$i = 0;
	while ($i <= 7) {
		$num = rand() % 33;
		$tmp = substr($salt, $num, 1);
		$pass = $pass . $tmp;
		$i++;
		}
	return $pass;
}

/*
   Function:		list_templates
   Description:		Generates a list of all available templates
   Credit:		eruin
*/
function list_templates() {
        $templates_list = array();
        if(!$handle = opendir("./data")){ die("<div align=\"center\">Can not open directory $cutepath/data</div> "); }
   		while (false !== ($file = readdir($handle))){
   			if(eregi(".tpl", $file)){
            	$file_arr		 = explode(".", $file);
                $templates_list["$file_arr[0]"]= $file_arr[0];
   			}
   		}
        closedir($handle);
	return $templates_list;
}

/*
	Function: 	url_validate, getFavicon
	Description:	Favatar support, as suggested by k0nsl
	Credit:		http://www.peej.co.uk/projects/favatars.html
*/
function url_validate( $link ) {  
        $url_parts = @parse_url( $link );
        if ( empty( $url_parts["host"] ) ) { return false; }
        if ( !empty( $url_parts["path"] ) ) {
                $documentpath = $url_parts["path"];
        } else {
                $documentpath = "/";
        }
        if ( !empty( $url_parts["query"] ) ) {
                $documentpath .= "?" . $url_parts["query"];
        }
        $host = $url_parts["host"];
        $port = $url_parts["port"];
        if ( empty($port) ) { $port = "80"; }
        $socket = @fsockopen( $host, $port, $errno, $errstr, 30 );
        if (!$socket) {
                return false;
        } else {
                fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
                $http_response = fgets( $socket, 22 );
                $responses = "/(200 OK)|(30[0-9] Moved)/";
                if ( preg_match($responses, $http_response) ) {
                        return true;
                        fclose($socket);
                } else {
                        // echo "HTTP-Response: $http_response<br>";
                        return false;
                }
        }
} 

function getFavicon($url) {
        // start by fetching the contents of the URL they left...
        if( $html = @file_get_contents($url) ) {
                if (preg_match('/<link[^>]+rel="(?:shortcut )?icon"[^>]+?href="([^"]+?)"/si', $html, $matches)) {
                        // Attempt to grab a favicon link from their webpage url
                        $linkUrl = html_entity_decode($matches[1]);
                        if (substr($linkUrl, 0, 1) == '/') {
                                $urlParts = parse_url($url);
                                $faviconURL = $urlParts['scheme'].'://'.$urlParts['host'].$linkUrl;
                        } else if (substr($linkUrl, 0, 7) == 'http://') {
                                $faviconURL = $linkUrl;
                        } else if (substr($url, -1, 1) == '/') {
                                $faviconURL = $url.$linkUrl;
                        } else {
                                $faviconURL = $url.'/'.$linkUrl;
                        }
                } else {
                        // If unsuccessful, attempt to "guess" the favicon location

                        $urlParts = parse_url($url);
                        $faviconURL = $urlParts['scheme'].'://'.$urlParts['host'].'/favicon.ico';
                }
                // Run a test to see if what we have attempted to get actually exists.
                if( $faviconURL_exists = url_validate($faviconURL) ) {
                        return $faviconURL;
                }
        } 
        // Finally, if we haven't 'returned' yet then there is nothing to see here.
        return false;
} 

/*
	Function: 	available_languages
	Description:	Create an array with info on available language packs
	Credit:		eruin
*/
function available_languages() {
	global $aj_buildid;

	$lffl = FileFolderList("inc/lang",1);
	$languages = $lffl[file];
	if (!empty($languages)) {

		foreach ($languages as $null => $languagefile) {
			$language_data = GetContents($languagefile);
			preg_match("{Languagefile:(.*)}i", $language_data, $language[name]);
			preg_match("{Language Name:(.*)}i", $language_data, $language[localname]);
			preg_match("{Author:(.*)}i", $language_data, $language[author]);
			preg_match("{Author URI:(.*)}i", $language_data, $language[uri]);
			preg_match("{Author Email:(.*)}i", $language_data, $language[email]);
			preg_match("{For Version:(.*)}i", $language_data, $language[version]);
				
			// Skip plugins designed for other versions
			settype($aj_buildid, "int");
			$testlang = trim($language[version][1]);
			settype($testlang, "int");

			if ($aj_buildid > $testlang) { continue; }

			$available_languages[] = array(
				name		=> trim($language[name][1]),
				localname	=> trim($language[localname][1]),
				author		=> trim($language[author][1]),
				uri		=> trim($language[uri][1]),
				email		=> trim($language[email][1]),
				version		=> trim($language[version][1]),
				filename	=> trim($languagefile),
			);
		}
	}
	else {
		$available_languages = array();
		} 

	return $available_languages;
}

/*
	Function: 	dropdownlangs
	Description:	Format the list of available languages for use in makeDropDown
	Credit:		eruin
*/
function dropdownlangs() {
	$langlistarr = available_languages();
	foreach ($langlistarr as $null => $language) {
		$langlist[$language[filename]] = "$language[name] ( $language[localname] )";
		}
	return $langlist;
}

/*
	Function: 	showRow
	Description:	Print system config rows
	Credit:		Flexer/eruin
*/
    function showRow($title="", $description="", $field="", $juice="")
    {
        global $i;
        if( $i%2 == 0 and $title != ""){ 
		$bg = 'alternate';
	}
	else { $bg = ''; }
		
        echo"<tr>
        <td class=\"$bg\">$title</td>
	<td class=\"$bg\">$field<br /><em>$description</em></td>
	</tr>";
    	$bg = ""; $i++;
    }


/*
	Function: 	langdate
	Description:	Output localized dates
	Credit:		eruin
*/
function langdate($format, $timestamp="") {
  global $lang_days, $lang_months;

	$date = date($format, $timestamp);

	foreach ($lang_days as $english => $local) {
		$date = eregi_replace($english, $local, $date);
		}

	foreach ($lang_months as $english => $local) {
		$date = eregi_replace($english, $local, $date);
		}
	return $date;
}

/*
	Function: 	makeDropDown
	Description:	Create a html dropdown list
	Credit:		Flexer
*/

function makeDropDown($options, $name, $selected="FALSE")
    {
		$output = "<select size=1 name=\"$name\">\r\n";

	array_multisort($options, SORT_DESC, $options);
        foreach($options as $value=>$description)
        {
          $output .= "<option value=\"$value\"";
          if($selected == $value){ $output .= " selected "; }
          $output .= ">$description</option>\n";
        }
		$output .= "</select>";
    	return $output;
    }

/*
	Function: 	aj_elapsed
	Description:	Returns elapsed time since $original
	Credit:		Unknown
*/
function aj_elapsed($original) {
		global $lang_dates, $lang_and;

   $chunks = array(
       array(60 * 60 * 24 * 365 , $lang_dates["year"], $lang_dates[plural]["year"]),
        array(60 * 60 * 24 * 30 , $lang_dates["month"], $lang_dates[plural]["month"]),
        array(60 * 60 * 24 * 7, $lang_dates["week"], $lang_dates[plural]["week"]),
        array(60 * 60 * 24 , $lang_dates["day"] , $lang_dates[plural]["day"]),
        array(60 * 60 , $lang_dates["hour"] , $lang_dates[plural]["hour"]),
        array(60 , $lang_dates["minute"], $lang_dates[plural]["minute"]),
    );
    
    $today = time();
    $since = $today - $original;
    
    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        $pname = $chunks[$i][2];
        
        // finding the biggest chunk (if the chunk fits, break)
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }
    
    $print = ($count == 1) ? '1 '.$name : "$count $pname";
    
    if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];
        $pname2 = $chunks[$i + 1][2];

        // add second item if it's greater than 0
        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
            $print .= ($count2 == 1) ? ', 1 '.$name2 : " $lang_and $count2 $pname2";
        }
    }
    return $print;
}
/*
	Function: 	aj_prepareTitle
	Description:	Formats an item's title for use in urls
	Credit:		The Wordpress team, http://www.wordpress.org
*/
function aj_prepareTitle($title) {
	
    $title = strtolower($title);
    $title = str_replace("å", "aa", $title);
    $title = str_replace("ø", "o", $title);
    $title = str_replace("æ", "ae", $title);    
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = preg_replace('/[^a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', ' ', $title);
    $title = str_replace(' ', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');

    return $title;
	}

/*
	Function: 	aj_get_member
	Description:	Get info on a username
	Credit:		eruin
*/
function aj_get_member($username){
global $cutepath;
    $allmembers = file("$cutepath/data/users.db.php");

    foreach($allmembers as $null => $memberline)
    {
		if(!eregi("<\?",$memberline)){
	        $member_db = explode("|",$memberline);
	        if(strtolower($member_db[2]) == strtolower($username))
	        {
				$memberinfo = $member_db;
            	break;
            }
		}
	}
	return $memberinfo;
}

/*
	Function: 	aj_getCat
	Description:	Get a category name
	Credit:		eruin
*/
function aj_getCat($id) {
global $cutepath;
$all_cats = file("$cutepath/data/category.db.php");
foreach($all_cats as $null => $cat_line){
	$cat_arr = explode("|", $cat_line);
    $cat_arr[1] = stripslashes( preg_replace(array("'\"'", "'\''"), array("&quot;", "&#039;"), $cat_arr[1]) );
    if($cat_arr[0] == $id) {
    	$cat = $cat_arr[1];
    	}
    }
    if ($cat == "") { $cat = "none"; }
	return $cat;
}

/*
	Function: 	aj_PostInfo
	Description:	Fetches the contents of a post
	Credit:		eruin
*/
function aj_PostInfo($id, $newsfile) {
	$lines = file("$newsfile");
	foreach ($lines as $null => $line) {
			list($date, $user, $title,$short,$unused1,$unknown1, $cat, $unknown3) = explode('|',trim($line));
			if($id == $date) {
			
	   			$news = array(
	       		"title" => $title,
	       		"date" => $date,
	       		"author" => $user,
	       		"short" => $short,
	       		"category" => $cat,
	   			);
	   		return $news;
	   		break;
	   			}
	   		else { continue; }	   		
		}
}


/*
	Function: 	formatsize
	Description:	Properly formats the size of a file
	Credit:		Flexer
*/
function formatsize($file_size){
	if($file_size >= 1073741824)
		{$file_size = round($file_size / 1073741824 * 100) / 100 . "GB";}
    elseif($file_size >= 1048576)
    	{$file_size = round($file_size / 1048576 * 100) / 100 . "MB";}
    elseif($file_size >= 1024)
    	{$file_size = round($file_size / 1024 * 100) / 100 . "KB";}
    else{$file_size = $file_size . "b";}
return $file_size;
}

/*
	Function: 	microtimer
	Description:	Calculates execution time
	Credit:		Flexer
*/
class microTimer {
    function start() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
    }
    function stop() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round (($endtime - $starttime), 5);
        return $totaltime;
    }
}

/*
	Function: 	check_login
	Description:	Validate login credentials
	Credit:		Flexer
*/
function check_login($username, $md5_password){
	$result = FALSE;
    $full_member_db = file("./data/users.db.php");
    global $member_db;

    foreach($full_member_db as $null => $member_db_line)
    {
		if(!eregi("<\?",$member_db_line)){
	        $member_db = explode("|",$member_db_line);
	        if(strtolower($member_db[2]) == strtolower($username) && $member_db[3] == md5($md5_password))
	        {
				$result = TRUE;
            	break;
            }
		}
	}
	return $result;
}

/*
	Function: 	cute_query_string
	Description:	Format the query string for usage by cutenews
	Credit:		Flexer
*/
function cute_query_string($q_string, $strips, $type="get"){
	foreach($strips as $null => $key){
		$strips[$key] = TRUE;
    }
	$var_value = explode("&", $q_string);

    foreach($var_value as $null => $var_peace){
        $parts = explode("=", $var_peace);
        if($strips[$parts[0]] != TRUE and $parts[0] != ""){
			if($type == "post"){
            	$my_q .= "<input type=\"hidden\" name=\"".$parts[0]."\" value=\"".$parts[1]."\" />\n";
            }else{
            	$my_q .= "$var_peace&amp;";
			}
        }
    }

if( substr($my_q, -5) == "&amp;" ){ $my_q = substr($my_q, 0, -5); }

return $my_q;
}

/*
	Function: 	flooder
	Description:	Flood protection
	Credit:		Flexer
*/
function flooder($ip, $comid){
    global $cutepath, $config_flood_time;

	$old_db = file("$cutepath/data/flood.db.php");
	$new_db = fopen("$cutepath/data/flood.db.php", w);
    $result = FALSE;
    foreach($old_db as $null => $old_db_line){
        $old_db_arr = explode("|", $old_db_line);

        if(($old_db_arr[0] + $config_flood_time) > time() ){
        	fwrite($new_db, $old_db_line);
        	if($old_db_arr[1] == $ip and $old_db_arr[2] == $comid)
            { $result = TRUE; }
        }
    }
    fclose($new_db);
    return $result;
}

/*
	Function: 	msg
	Description:	Displays status messages
	Credit:		Flexer
*/
function msg($type, $title, $text, $back=FALSE){
  echoheader($type, $title);
  global $lang;
  	echo"$text";
    if($back){
		echo"<br /><br /> <a href=\"$back\">go back</a>";
    }
  echofooter();
exit();
}

/*
	Function: 	echoheader
	Description:	Displays skin header
	Credit:		Flexer
*/
function echoheader($image, $header_text){
	global $PHP_SELF, $is_loged_in, $config_skin, $skin_header, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name, $config_version_id, $member_db;

    if($is_loged_in == TRUE){ 
    	//------------------------------------------------
    	// Cut the options for wich we don't have access
    	//------------------------------------------------
    	$count_headerlinks = count($skin_menu);
    	for($i=0; $i<$count_headerlinks; $i++){
	    	if($member_db[1] > $skin_menu[$i]['access']){
				unset($skin_menu[$i]);
		        }
    		}
    	$i = 0;
    	$skin_header_replace = " ";

		foreach($skin_menu as $null => $skin_link){
			if ($skin_link['name'] == "Home") { $skin_header_replace .= "
				<li class=\"submenuparent\"><a href=\"?mod=main\">Common tasks</a>
				<ul>\n";
				}
			if ($skin_link['name'] == "Personal Options") { $skin_header_replace .= "

				</ul></li>
				<li class=\"submenuparent\"><a href=\"?mod=options&amp;action=syscon\">Configuration</a>
				<ul>\n";
				}
			if ($skin_link['name'] == "Help / About") { $skin_header_replace .= "
				</ul></li>
				<li class=\"submenuparent\">Miscellaneous
				<ul>\n";
				}
			if ($skin_link['name'] == "Plugin Manager") { $skin_header_replace .= "
				</ul></li>
				<li class=\"submenuparent\"><a href=\"?mod=options&amp;action=plugins\">Plugin System</a>
				<ul>\n";
				}
		        $skin_header_replace .= "<li><a href='".$skin_link['url']."'>".$skin_link['name']."</a></li>\n";
		    	$i++;
		    	}
		if ($member_db[4]) { $membermenu = $member_db[4]; }
			else { $membermenu = $member_db[2]; }
			
		$skin_header_replace .= "	</ul></li>";
		$skin_header = preg_replace("/{menu}/", "<ul>$skin_header_replace</ul><strong>$membermenu</strong>. [ <a href=\"?action=logout\" style=\"display: inline;\">Logout</a> ]", "$skin_header"); 
		}
    	else { 
		$skin_header = preg_replace("/{menu}/", " ", "$skin_header");
		}

		$skin_header = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_header);
		$skin_header = preg_replace("/{header-text}/", $header_text, $skin_header);
		$skin_header = preg_replace("/{content-type}/", $lang_content_type, $skin_header);
    
	    echo $skin_header;
}

/*
	Function: 	echofooter
	Description:	Displays the skin footer
	Credit:		Flexer
*/
function echofooter(){

	global $PHP_SELF, $is_loged_in, $config_skin, $skin_footer, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name, $config_version_id;

    $skin_footer = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_footer);
    $skin_footer = preg_replace("/{header-text}/", $header_text, $skin_footer);
    $skin_footer = preg_replace("/{content-type}/", $lang_content_type, $skin_footer);
    $skin_footer = preg_replace("/{copyrights}/", "Powered by <a href=\"http://ajfork.berlios.de/\">$config_version_name ($config_version_id)</a> © 2004  ( forked from <a href=\"http://cutephp.com/\">Cutenews</a> by CutePHP )", $skin_footer);

    echo $skin_footer;

}

/*
	Function: 	CountComments
	Description:	Count number of comments for an entry
	Credit:		Flexer
*/
function CountComments($id, $archive = FALSE){

    global $cutepath;

    if($cutepath == ""){ $cutepath = "."; }
    $result = "0";
    if($archive){ $all_comments = file("$cutepath/data/archives/${archive}.comments.arch"); }
    else{ $all_comments = file("$cutepath/data/comments.txt"); }

    foreach($all_comments as $null => $comment_line)
    {
		$comment_arr_1 = explode("|>|", $comment_line);
        if($comment_arr_1[0] == $id)
        {
			$comment_arr_2 = explode("||", $comment_arr_1[1]);
            $result = count($comment_arr_2)-1;

        }
    }

return $result;
}

/*
	Function: 	insertSmilies
	Description:	Prints smiley-javascript
	Credit:		Flexer
*/
function insertSmilies($insert_location, $break_location = FALSE)
{
    global $config_http_script_dir, $config_smilies;

    $smilies = explode(",", $config_smilies);
	foreach($smilies as $null => $smile)
	{
        $i++; $smile = trim($smile);

        $output .= "<a href=\"javascript:insertext(':$smile:','$insert_location')\"><img style=\"border: 0px;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" /></a>";
		$output .= "";
    }
	return $output;
}

/*
	Function: 	replace_comments
	Description:	Crude replacements on comments
	Credit:		Flexer
*/
function replace_comment($way, $sourse){
    global $config_http_script_dir, $config_smilies;

    $sourse = stripslashes(trim($sourse));

	if($way == "add"){

		$find = array(
					"'\|'",
					"'\n'",
					"'\r'",
	                 );
		$replace = array(
 					"&#124;",
					"<br />",
                    "",
	                 );

    }
    elseif($way == "show"){

		$smilies_arr = explode(",", $config_smilies);
	    foreach($smilies_arr as $null => $smile){
	        $smile = trim($smile);
	        $find[] = "':$smile:'";
	        $replace[] = "<img style=\"border: 0px;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" />";
	    }

    }

$sourse  = preg_replace($find,$replace,$sourse);
return $sourse;
} 

/*
	Function: 	replace_news
	Description:	Crude replacements in news
	Credit:		Flexer
*/
function replace_news($way, $sourse, $replce_n_to_br=TRUE, $use_html=TRUE){
    global $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;
    $sourse = stripslashes($sourse);

    if($way == "show")
    {
		$find= array(
    	                "'{nl}'",
                       );

		$replace=array(
    					"\n",
                        );

    	$smilies_arr = explode(",", $config_smilies);
	    foreach($smilies_arr as $null => $smile){
	        $smile = trim($smile);
	        $find[] = "':$smile:'";
	        $replace[] = "<img style=\"border: none;\" alt=\"$smile\" src=\"$config_http_script_dir/data/emoticons/$smile.gif\" />";
	    }
    }
    elseif($way == "add"){

		$find = array(
					"'\|'",
					"'\r'",
	                 );
		$replace = array(
					"&#124;",
					"",
	                 );
        	$find[] 	= "'\n'";
			$replace[] 	= "{nl}";

    }
    elseif($way == "admin"){

		$find = array(
					"''",
					"'<br />'",
					"'{nl}'",
                    );
		$replace = array(
					"",
					"\n",
					"\n",
	                 );

    }

$sourse  = preg_replace($find,$replace,$sourse);
return $sourse;
}

/*
	Function: 	spostr_replace
	Description:	Crude replacements in single-line form fields
	Credit:		Flexer
*/
function spostr_replace($field) {
	$field = str_replace("\n", "", $field);
	$field = str_replace("\r", "", $field);
	$field = str_replace("|", "&#124;", $field);
	return $field;
}
?>
