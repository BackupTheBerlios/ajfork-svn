<?PHP

if (!defined('PLUGIN_FRAMEWORK_VERSION')) {
@include($cutepath.'/inc/plugins.php');
@LoadActivePlugins();
}

do{ # Used if we want to display some error to the user and halt the rest of the script


# Load the language file set in config
$vis_lang_file = $cutepath . "/" . $config_cn_lang;
if (file_exists($vis_lang_file) && !$lang_floodprot) {
	include($vis_lang_file);
	}

	
$user_query = cute_query_string($QUERY_STRING, array("aj_page", "start_from", "archive", "aj_go", "id", "ucat"));
$user_post_query = cute_query_string($QUERY_STRING, array("aj_page", "start_from", "archive", "aj_go", "id", "ucat"), "post");

#####################################################################################################################
#			 Define Categories
#####################################################################################################################
$cat_lines = file("$cutepath/data/category.db.php");
foreach($cat_lines as $null => $single_line){
	$cat_arr = explode("|", $single_line);
    $cat[$cat_arr[0]] = $cat_arr[1];
    $cat_icon[$cat_arr[0]]=$cat_arr[2];
}
$cat = run_filters('news-define-categories',$cat);
#####################################################################################################################
#			 Define Users
#####################################################################################################################
$all_users = file("$cutepath/data/users.db.php");
foreach($all_users as $null => $user)
{
	if(!eregi("<\?",$member_db_line)){
		$user_arr = explode("|",$user);
			if($user_arr[4] != "")
			    {
			    	if($user_arr[7] != 1 and $user_arr[5] != ""){ $my_names[$user_arr[2]] = "<a href=\"mailto:$user_arr[5]\">$user_arr[4]</a>"; }
					else{ $my_names[$user_arr[2]] = "$user_arr[4]"; }
                    $name_to_nick[$user_arr[2]] = $user_arr[4];
                    $profile_to_nick[$user_arr[2]][msn] = $user_arr[11];
                    $profile_to_nick[$user_arr[2]][web] = $user_arr[12];
                    $profile_to_nick[$user_arr[2]][pro] = $user_arr[13];
			    }
				else
			    {
			    	if($user_arr[7] != 1 and $user_arr[5] != ""){ $my_names[$user_arr[2]] = "<a href=\"mailto:$user_arr[5]\">$user_arr[2]</a>"; }
					else{ $my_names[$user_arr[2]] = "$user_arr[2]"; }
                    $name_to_nick[$user_arr[2]] = $user_arr[2];
                    $profile_to_nick[$user_arr[2]][msn] = $user_arr[11];
                    $profile_to_nick[$user_arr[2]][web] = $user_arr[12];
                    $profile_to_nick[$user_arr[2]][pro] = $user_arr[13];
                }

                if($user_arr[7] != 1){ $my_mails[$user_arr[2]] = $user_arr[5]; }
                else{ $my_mails[$user_arr[2]] = ""; }
                $my_passwords[$user_arr[2]] = $user_arr[3];
				$my_users[] = $user_arr[2];
    }
}
#####################################################################################################################
# 			Add Comment
#####################################################################################################################
$allow_add_comment = run_filters('news-allow-comment',$allow_add_comment);
if($allow_add_comment){
	$name = trim($name);

echo '<script type="text/javascript">

function AJsC(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
      ((expires) ? "; expires=" + expires.toGMTString() : "") +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      ((secure) ? "; secure" : "");
  document.cookie = curCookie;
}

function AJgC(name) {
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
    begin = dc.indexOf(prefix);
    if (begin != 0) return null;
  } else
    begin += 2;
  var end = document.cookie.indexOf(";", begin);
  if (end == -1)
    end = dc.length;
  return unescape(dc.substring(begin + prefix.length, end));
}

function AJdC(name, path, domain) {
  if (getCookie(name)) {
    document.cookie = name + "=" +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}

</script>';

	if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
	elseif(isset($HTTP_CLIENT_IP))	{ $ip = $HTTP_CLIENT_IP; }
	if($ip == "")				    { $ip = $REMOTE_ADDR; }
	if($ip == "")					{ $ip = "not detected";}

# keep scriptkiddies out
settype($id, "int");

# Check Flood Protection
    if($config_flood_time != 0 and $config_flood_time != "" ){
        if(flooder($ip, $id) == TRUE ){
        	echo("<div style=\"text-align: center;\">$lang_floodprot</div>");
			 $CN_HALT = TRUE;
             break 1;
		}
    }
# Check if IP is banned

    $blockip = FALSE;
    $old_ips = file("$cutepath/data/ipban.db.php");
    $new_ips = fopen("$cutepath/data/ipban.db.php", "w");
    @flock ($new_ips,2);
    foreach($old_ips as $null => $old_ip_line){
            $ip_arr = explode("|", $old_ip_line);        
            
            # ?id = "168". ?title = "Ban partial IPs";
			$_allowed = true;
			$this_banned_ip = str_replace('.','\.',$ip_arr[0]);
			$this_banned_ip = str_replace('*','[0-9]{1,3}',$this_banned_ip);
			$this_banned_ip = str_replace('?','[0-9]{1}',$this_banned_ip);
			if(ereg("^{$this_banned_ip}$", $ip)) $_allowed = false;
			
			if($_allowed) {
            # Oldstatement
            # $ip_arr[0] != $ip #
				fwrite($new_ips, $old_ip_line);
				}
			else {
			$countblocks = $ip_arr[1] = $ip_arr[1] + 1;
			fwrite($new_ips, "$ip_arr[0]|$countblocks||\n"); $blockip = TRUE;
        	}
    	}
    @flock ($new_ips,3);
    fclose($new_ips);
    if($blockip){
    	echo("<div style=\"text-align: center;\">$lang_blocked</div>");
	 $CN_HALT = TRUE;
     break 1;
    }

# Check if name is Protected
    $is_member = FALSE;
    foreach($all_users as $null => $member_db_line)
    {
        if(!eregi("<\?",$member_db_line) and $member_db_line != ""){
			$user_arr = explode("|",$member_db_line);

            #if the name is protected
            if((strtolower($user_arr[2]) == strtolower($name) or strtolower($user_arr[4]) == strtolower($name)) and $user_arr[3] != md5(md5($password)) and $name != "")
        	{
        		# run regged through kses-allow, too
        		$comments	= run_filters('news-posted-comment-content', $comments);
				$comments	= preg_replace(array("'\"'", "'\''", "''"), array("&quot;", "&#039;", ""), $comments);
			    $name		= replace_comment("add", preg_replace("/\n/", "",$name));
				$mail 		= replace_comment("add", preg_replace("/\n/", "",$mail));

             echo"<div style=\"text-align: center;\">$lang_commentregistered<br />
             <form method=\"post\" action=\"\">
             <input type=\"password\" name=\"password\" />
             <input type=\"hidden\" name=\"name\" value=\"$name\" />
             <input type=\"hidden\" name=\"comments\" value=\"$comments\" />
             <input type=\"hidden\" name=\"mail\" value=\"$mail\" />
             <input type=\"hidden\" name=\"ip\" value=\"$ip\" />
             <input type=\"hidden\" name=\"aj_go\" value=\"addcomment\" />
             <input type=\"hidden\" name=\"javasubaction\" value=\"$javasubaction\" />
             <input type=\"hidden\" name=\"show\" value=\"$show\" />
             <input type=\"hidden\" name=\"ucat\" value=\"$ucat\" />
	     <input type=\"hidden\" name=\"category\" value=\"$category_hidden\" />
             <input type=\"hidden\" name=\"rememberme\" value=\"$rememberme\" />
             <input type=\"hidden\" name=\"ntitle\" value=\"$ntitle\" />

             $user_post_query
             <input type=\"hidden\" name=\"id\" value=\"$id\" />
             <input type=\"submit\" value=\"$lang_commentregisteredbutton\"/></form></div>";
			 $CN_HALT = TRUE;
             break 2;
#			 exit();
        	}

            if(strtolower($user_arr[2]) == strtolower($name)) $is_member = TRUE;
        }
	}

# Check if only members can post comments
	if($config_only_registered_comment == "yes" and !$is_member){
	    echo"<div style=\"text-align: center;\">$lang_onlyregistered</div>";
			 $CN_HALT = TRUE;
             break 1;
    }

#* Wrap long words
    if($config_auto_wrap > 1){
        $comments_arr = explode("\n", $comments);
        foreach($comments_arr as $null => $line){
        	$wraped_comm .= ereg_replace("([^ \/\/]{".$config_auto_wrap."})","\\1\n", $line) ."\n";
        }
	    if(strlen($name) > $config_auto_wrap){ $name = substr($name, 0, $config_auto_wrap)." ..."; }
    $comments = $wraped_comm;
    }
#*/

    $comments 	= replace_comment("add", run_filters('news-posted-comment-content',$comments));
    $name		= replace_comment("add", preg_replace("/\n/", "",$name));
	$mail 		= replace_comment("add", preg_replace("/\n/", "",$mail));



# accomodate future spamblocking
$CN_HALT = run_filters('news-posted-comment-authorize', $CN_HALT);

if ($CN_HALT == TRUE) {
	break 1;
	}

    if($name == " " or $name == ""){
    	echo("<div style=\"text-align: center;\">$lang_comment_needname</div>");
		$CN_HALT = TRUE;
		break 1;
	}
    if($mail == " " or $mail == ""){ $mail = "none"; }
    else{ $ok = FALSE;
    	if(preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $mail)) $ok = TRUE;
        elseif($config_allow_url_instead_mail == "yes" and preg_match("/((http(s?):\/\/)|(www\.))([\w\.]+)([\/\w+\.-?]+)/", $mail)) $ok = TRUE;
        elseif($config_allow_url_instead_mail != "yes"){
        	echo("<div style=\"text-align: center;\">$lang_comment_invalidmail</div>");
			$CN_HALT = TRUE;
			break 1;
        }
		else{
        	echo("<div style=\"text-align: center;\">$lang_comment_needvalidmail</div>");
			$CN_HALT = TRUE;
			break 1;
        }
    }

    if($comments == ""){
    	echo("<div style=\"text-align: center;\">$lang_comment_notblank</div>");
			$CN_HALT = TRUE;
			break 1;
    }

    $time = time()+($config_date_adjust*60);

# Add the Comment
    $old_comments = file("$comm_file");
    $new_comments = fopen("$comm_file", "w");
    @flock ($new_comments,2);
    $found = FALSE;
    foreach($old_comments as $null => $old_comments_line)
    {
		$old_comments_arr = explode("|>|", $old_comments_line);
		if($old_comments_arr[0] == $id)
		{
			$old_comments_arr[1] = trim($old_comments_arr[1]);
			fwrite($new_comments, "$old_comments_arr[0]|>|$old_comments_arr[1]$time|$name|$mail|$ip|$comments||\n");
            $found = TRUE;
        }else{
			fwrite($new_comments, $old_comments_line);
		}
	}
    if(!$found){ fwrite($new_comments, "$id|>|$time|$name|$mail|$ip|$comments||\n"); }
    @flock ($new_comments,3);
    fclose($new_comments);

# Add Flood Protection
    if($config_flood_time != "0" and $config_flood_time != "" ){

    	$flood_file = fopen("$cutepath/data/flood.db.php", "a");
	    @flock ($flood_file,2);
        fwrite($flood_file, time()."|$ip|$id|\n");
	    @flock ($flood_file,3);
        fclose($flood_file);
    }
    # Sort problems with browser refresh posting comments twice + remembermefeature
    
if ($rememberme == "yes") {
	echo "
		<script type=\"text/javascript\">
		var now = new Date();
		now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
		AJsC(\"commentname\", \"$name\", now, \"/\");
		AJsC(\"commentmail\", \"$mail\", now, \"/\");
		</script>";
	}
else { 
	echo "
		<script type=\"text/javascript\">
		var now = new Date();
		now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
		AJdC(\"commentname\");
		AJdC(\"commentmail\");
		</script>";
	}
	run_actions('comment-added');
	$java_redirect = "<script type=\"text/javascript\">self.location.href='http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?aj_go=$javasubaction&id=$id&archive=$archive&start_from=$start_from&ucat=$ucat&$user_query';</script>";
	$java_redirect = run_filters('comment-added-java-redirection', $java_redirect);
	echo $java_redirect;
}
#####################################################################################################################
#		 Show Full Story
#####################################################################################################################
if($allow_full_story){
	$all_active_news = file("$news_file");
	
    foreach($all_active_news as $null => $active_news)
    {	
        $news_arr = explode("|", $active_news);

        $id = run_filters('news-fullstory-loop', $id);
        if($news_arr[0] == $id)
        {
		if ($azid) { /* */ }

        	run_actions('news-fullstory-page');
            $found = TRUE;
            if($news_arr[4] == "" and (!eregi("\{short-story\}", $template_full)) ){ $news_arr[4] = $news_arr[3]; }

            if($my_names[$news_arr[1]]){ $my_author = $my_names[$news_arr[1]]; }
    		else{ $my_author = $news_arr[1]; }
			$output = $template_full;
			$output = run_filters('news-show-generic', $output);
			$output = str_replace("{title}", $news_arr[2], $output);
		# Add Elapsed
		$output = str_replace("{date-elapsed}", aj_elapsed($news_arr[0]), $output);
		$output = str_replace("{date}", langdate($config_timestamp_active, $news_arr[0]), $output);
			$output = str_replace("{author}", $my_author, $output);
			
			# TEIT highlight-HACK
        	if($highlight) {
        		$news_arr[3] = str_replace($highlight, "<em>$highlight</em>", $news_arr[3]);
        		$news_arr[4] = str_replace($highlight, "<em>$highlight</em>", $news_arr[4]);
        	}
        	# end teit highlight-hack
		
		 #MORE HACK        
        $content = explode('<!--more-->', $news_arr[3]);

	# Pagination Hack by Will
	$page_array = explode("<!--nextpage-->", run_filters('news-entry-content',$content[1]));
	$pagination = "";
	if($aj_page == ''){ 
		$aj_page = 1; 
		}
	if ( count($page_array) > 1){
		if($aj_page != 1){ 
			$less=$aj_page-1; 
			$pagination .= "<a href=?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query&amp;aj_page=$less>«</a> ";
			$output = str_replace("{short-story}", "", $output);
			}
		$for_to = count($page_array);
		for ($i=1; $i<=$for_to; $i++){
			if ($i == $aj_page){ 
				$pagination .= $i;
				}
			else { 
				$lookup = $i-1;
				$pagination .= " <a href=?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query&amp;aj_page=$i>$i</a> ";
				}
		}
		if ($aj_page != count($page_array)){ 
			$more = $aj_page + 1; 
			$pagination .= "<a href=?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query&amp;aj_page=$more>»</a> ";
			}
		$output = str_replace("{pagination}", $pagination, $output);
		$output = str_replace("{full-story}", $page_array[$aj_page-1], $output);
		}
	else{ 
		$output = str_replace("{pagination}", "", $output);
		$output = str_replace("{full-story}", implode($page_array), $output);
		}
	# END Pagination Hack

        $output = str_replace("{short-story}", run_filters('news-entry-content',$content[0]), $output);
        # Obsolete: $output = str_replace("{full-story}", run_filters('news-entry-content',$content[1]), $output);

	        if($news_arr[5] != ""){$output = str_replace("{avatar}", "<img alt=\"\" src=\"$news_arr[5]\" style=\"border: none;\" />", $output); }
	        else{ $output = str_replace("{avatar}", "", $output); }
			$output = str_replace("{avatar-url}", "$news_arr[5]", $output);

	# Music hack by rilmith 3 lines below.
	if ($news_arr[7] != "") {
	$output = str_replace("{music}", $news_arr[7], $output); }
	else { $output = str_replace("{music}", "", $output); }

			$output = str_replace("{comments-num}", countComments($news_arr[0], $archive), $output);
			$output = str_replace("{category}", $cat[$news_arr[6]], $output);
			$output = str_replace("{category-id}", $news_arr[6], $output);
			if($cat_icon[$news_arr[6]] != ""){ $output = str_replace("{category-icon}", "<img style=\"border: none;\" alt=\"".$cat[$news_arr[6]]." icon\" src=\"".$cat_icon[$news_arr[6]]."\" />", $output); }
			else{ $output = str_replace("{category-icon}", "", $output); }
	
			$output = str_replace("{author-name}", $name_to_nick[$news_arr[1]], $output);

            if($my_mails[$news_arr[1]] != ""){
                $output = str_replace("[mail]","<a href=\"mailto:".$my_mails[$news_arr[1]]."\">", $output);
                $output = str_replace("[/mail]","</a>", $output);
			}else{
                $output = str_replace("[mail]","", $output);
                $output = str_replace("[/mail]","", $output);
            }
        $output = str_replace("[link]","<a title=\"$lang_article_linktext\" href=\"$PHP_SELF?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query\">", $output);
        $output = str_replace("[/link]","</a>", $output);     

			$output = str_replace("{news-id}", $news_arr[0], $output);
			$output = str_replace("{archive-id}", $archive, $output);
			$output = str_replace("{php-self}", $PHP_SELF, $output);
			$output = str_replace("{cute-http-path}", $config_http_script_dir, $output);
			
			# Display author's MSN, WEBSITE and PROFILE
			
			#$profile_to_nick[$user_arr[2]][pro] = $user_arr[13];
			$output = str_replace("{author-msn}", $profile_to_nick[$news_arr[1]][msn], $output);
			$output = str_replace("{author-web}", $profile_to_nick[$news_arr[1]][web], $output);
			$output = str_replace("{author-profile}", run_filters('news-profile-content',$profile_to_nick[$news_arr[1]][pro]), $output);
			# END MSN,WEBSITE,PROFILE
						

# XFields v2.1 - addblock
$xfieldsaction = "templatereplace";
$xfieldsinput = $output;
$xfieldsid = $news_arr[0];
include("xfields.mdu");
$output = $xfieldsoutput;
# XFields v2.1 - End addblock
  
			$output = run_filters('news-entry',$output);

			$output = replace_news("show", $output);

			echo $output;
			$allow_comments = run_filters('news-show-comments', $allow_comments);
        }
	}
	if(!$found){
    	echo("<div style=\"text-align: center;\">$lang_article_notfound</div>");
		$CN_HALT = TRUE;
		break 1;
    }
}
#####################################################################################################################
#		 Show Comments
#####################################################################################################################
if($allow_comments){
	$all_comments = file("$comm_file");

	foreach($all_comments as $null => $comment_line)
	{

		$comment_line = trim($comment_line);
		$comment_line_arr = explode("|>|", $comment_line);
		if($id == $comment_line_arr[0])
		{
			$individual_comments = explode("||", $comment_line_arr[1]);
            # Comments Pagination
            if($config_reverse_comments == "yes"){
            	$individual_comments = array_reverse($individual_comments);
				$cghost = 1;} else {$cghost = 0;}
				$total_comments = count($individual_comments)-1;
			# Comments Pagination
			
			# {comnum} (a bloody mess that doesn't make sense this early in the morning!)
			$i = 0;
			if ($config_reverse_comments == "yes") {
				$cjnumber = $total_comments;
				if ($cstart) { $cjnumber -= $cstart -2; }
			}
			else { $cjnumber = 1;
				if ($cstart) { $cjnumber += $cstart -1;}
			}
			
            foreach($individual_comments as $null => $comment)
			{

			# Comments Pagination
			if ($config_comments_pagination == "Yes") {
			$comment_index++;

			!isset($cnum) and $cnum = $config_comments_pagination_number;
			$cstart < 1 and $cstart = 1+$cghost; 
	
			if ($comment_index < $cstart) continue;
			if ($comment_index >= $cstart + $cnum) break;
			}
			# Comments Pagination


				$comment_arr = explode("|", $comment);
				if($comment_arr[0] != "") {
				
				# Admin hack part One: Checking if user is registered (appelsinjuice.org)
					$admin_posting = FALSE;
    				foreach($all_users as $null => $member_db_line) {
        				if(!eregi("<\?",$member_db_line) and $member_db_line != ""){
							$user_arr = explode("|",$member_db_line);
            				if(strtolower($user_arr[2]) == strtolower($comment_arr[1]) || strtolower($user_arr[4]) == strtolower($comment_arr[1])) { 
        						$admin_posting = TRUE;
								}
        					}
						}
				# END Admin hack part One
				
					$comment_arr[4] = stripslashes(rtrim($comment_arr[4]));

					if($comment_arr[2] != "none"){
                        if( preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $comment_arr[2])){
				$url_target = "";
				$mail_or_url = "mailto:"; 
				$isurl = "no";
				if ($config_comments_spamprotection == "yes") {
					$comment_arr[2] = str_replace("@", " -at- ", $comment_arr[2]);
					$comment_arr[2] = str_replace(".", " -dot- ", $comment_arr[2]);
					}
				}
                        else{
			    $isurl = "yes";
                            $url_target = "";
                            $mail_or_url = "";
                            if(substr($comment_arr[2],0,3) == "www"){ $mail_or_url = "http://"; }
						}
			$authorhref = "$mail_or_url" . stripslashes($comment_arr[2]);
			$authorhref = run_filters('news-comment-display-authorhref', $authorhref);

			$authorlink = "<a $url_target href=\"$authorhref\">".stripslashes($comment_arr[1])."</a>";
			$authorlink = run_filters('news-comment-display-authorlink', $authorlink);

                    	$output = str_replace("{author}", $authorlink , $template_comment);
                    }
					else{ $output = str_replace("{author}", $comment_arr[1], $template_comment); }
					$comment_arr[4] = run_filters('news-comment-content',$comment_arr[4]);
					$output = str_replace("{mail}", "$comment_arr[2]",$output);
					
					# Show commenters host hack - adding variable {host} (appelsinjuice.org)
					if (!!stristr($output, "{host}")) {
						if ($comment_arr[3] && $comment_arr[3] != "not detected") {
							$hostname = @gethostbyaddr($comment_arr[3]);
							$hostname = "*." . substr($hostname, strpos($hostname, ".") + 1);
							$output = str_replace("{host}", $hostname, $output);
						} 
						else { 
							$output = str_replace("{host}", "no host", $output); 
						}
					}
					# END Show commenters host
				
					$output = str_replace("{music}", "$comment_arr[7]",$output);
					
					# Admin hack part Two: Adding a template variable (appelsinjuice.org)
					if ($admin_posting == "TRUE") {
					$output = str_replace("{admin}", $config_admin_template,$output); }
					else { $output = str_replace("{admin}", "",$output); }
					# END Admin hack part Two
					
		# Add Elapsed
		$output = str_replace("{date-elapsed}", aj_elapsed($comment_arr[0]), $output);
		$output = str_replace("{date}", langdate($config_timestamp_comment, $comment_arr[0]), $output);
		
		if ($isurl == "yes") {
			$comment_arr[2] = run_filters('news-comment-display-url', $comment_arr[2]);
			}
		elseif ($comment_arr[2] != "none") {
			$comment_arr[2] = run_filters('news-comment-display-email', $comment_arr[2]);
			}

		# Favatar support
		if ($isurl == "yes" && $comment_arr[2] != "none" && strpos($output, "{favatar}")) {
			$favatar = getFavicon($comment_arr[2]);
			if ($favatar) {
				$output = str_replace("{favatar}", "<img alt=\"Favatar\" src=\"$favatar_url\" width=\"16\" height=\"16\" class=\"favatar_image\" />", $output);
				}
			else {
	                        $urlParts = parse_url($comment_arr[2]);
        	                $faviconURL = $urlParts['scheme'].'://'.$urlParts['host'].'/favicon.ico';
				if (url_validate($faviconURL)) {
					$output = str_replace("{favatar}", "<img alt=\"Favatar\" src=\"$faviconURL\" width=\"16\" height=\"16\" class=\"favatar_image\" />", $output);
					}
				else {
					$output = str_replace("{favatar}", "", $output);
					}
				}
			}
		elseif ($isurl == "no" || $comment_arr[2] == "none") {
			$output = str_replace("{favatar}", "", $output);
			}


					$output = str_replace("{comment-id}", $comment_arr[0],$output);				
					$output = str_replace("{comment}", "<a id=\"" ."C" .$comment_arr[0]."\"></a>$comment_arr[4]",$output);
					# {comnum} & altcolors
					if($i%2 == 0) { 
						$com_alternating = "cn_comment_odd";
					} 
					else { 
						$com_alternating = "cn_comment_even";
					}
					$output = str_replace("{alternating}", $com_alternating, $output);
					$i++;
					
					$output = str_replace("{comnum}", $cjnumber, $output);
					if ($config_reverse_comments == "yes") {
						$cjnumber--;
					}
					else { $cjnumber++; }
					$output = run_filters('news-comment',$output);
					$output = replace_comment("show", $output);
					echo $output;

				}
			}
		}
	}

		# Comments Pagination
		if ($config_comments_pagination == "Yes") {
			$cprev_next_msg = $template_cprev_next;
			$nextcstart = $cstart + $cnum;
			$prevcstart = $cstart - $cnum;
			$COM_REQUEST_URI = $PHP_SELF . "?" . cute_query_string($QUERY_STRING, array("cstart"));
		
			# <--- Previous
			if($cstart>1+$cghost){
				$cprev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'si", "<a href=\"{$COM_REQUEST_URI}&amp;cstart={$prevcstart}\">\\1</a>", $cprev_next_msg);
			}
			else { 
				$cprev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'si", "\\1", $cprev_next_msg); $no_cprev = TRUE;
			}
    		# |<-- Previous
    	
    		# {pages}
			$cnumadd = 0;
			$cpages = "";
			for($k=1;$cnumadd<$total_comments;$k++){
				$cstartnum = $cnum*($k-1)+1+$cghost;
				if($cstartnum != $cstart) {
					$cpages .= "<a href=\"{$COM_REQUEST_URI}&amp;cstart={$cstartnum}\">$k</a> ";
				}
				else {
					$cpages .= " <strong>| $k |</strong> ";
				}
			$cnumadd = $cnum*$k;
			}
			$cprev_next_msg = str_replace("{pages}", $cpages, $cprev_next_msg);
			# {pages} |

			# Next -->
			if($cstart+$cnum-1-$cghost < $total_comments) {
				$cprev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'si", "<a href=\"{$COM_REQUEST_URI}&amp;cstart={$nextcstart}\">\\1</a>", $cprev_next_msg);
			}
			else { 
				$cprev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'si", "\\1", $cprev_next_msg); $no_cnext = TRUE;
			}
	    	# Next -->|
    	
	    	if (!$no_cprev or !$no_cnext){ echo $cprev_next_msg; }
    	}
		# Comments Pagination 
		
	$template_form = str_replace("{config_http_script_dir}", "$config_http_script_dir", $template_form);
	$template_form = run_filters('add-comment-box', $template_form);

    $smilies_form = "\n<script type=\"text/javascript\">
	//<![CDATA[
	function insertext(text, spot){
	document.forms['comment'].elements['comments'].value += ' ' +text;
	}
	//]]></script>
	".insertSmilies('short', FALSE);

    $template_form = str_replace("{smilies}", $smilies_form, $template_form);
    if ($_COOKIE['commentname']) { $template_form = str_replace("{savedname}", utf8_encode($_COOKIE['commentname']), $template_form); } else { $template_form = str_replace("{savedname}", "", $template_form); }
    if ($_COOKIE['commentmail'] && $_COOKIE['commentmail'] != "none") { $template_form = str_replace("{savedmail}", $_COOKIE['commentmail'], $template_form); } else { $template_form = str_replace("{savedmail}", "", $template_form); }
    # rememberme input
    $template_form = str_replace("{remember}","<input type=\"checkbox\" id=\"rememberme\" name=\"rememberme\" value=\"yes\" checked=\"checked\" />", $template_form);

    echo"<form method=\"post\" id=\"comment\" action=\"\">".$template_form."<div><input type=\"hidden\" name=\"javasubaction\" value=\"$aj_go\" /><input type=\"hidden\" name=\"aj_go\" value=\"addcomment\" /><input type=\"hidden\" name=\"ucat\" value=\"$ucat\" /><input type=\"hidden\" name=\"show\" value=\"$show\" />$user_post_query<input type=\"hidden\" name=\"id\" value=\"$id\" /><input type=\"hidden\" name=\"ntitle\" value=\"$ref_title\" /></div></form>";

}
#####################################################################################################################
#		 Active News
#####################################################################################################################
if($allow_active_news){

	$all_news = file("$news_file");
	
		# stupid hack for sorting dates
		# if ($config_sortbydate == "yes") {
		asort($all_news);
		reset($all_news);
		$all_news = array_reverse($all_news);
		if ($shufflenews == "1") {
			shuffle($all_news);
			}
		# }
		
    if($reverse == TRUE){ $all_news = array_reverse($all_news); }
	$all_news = run_filters('news-recordset',$all_news);
    $count_all = 0;
    if(isset($category) and $category != ""){
	    foreach($all_news as $null => $news_line){
			$news_arr = explode("|", $news_line);
			if($requested_cats and $requested_cats[$news_arr[6]] == TRUE){ $count_all ++; }
	        else{ continue; }
		}
	}else{ $count_all = count($all_news); }

    $i = 0;
    $o = 0;
    $showed = 0;
	$repeat = TRUE;
    $url_archive = $archive;
    
    while($repeat != FALSE){

		foreach($all_news as $null => $news_line){

	   	$news_arr = explode("|", $news_line);
        $modifier = run_actions('news-loop', '');
        
        if ($modifier == "skip") {
        	$count_all--;
        	continue;
        	}
        
		if($category and $requested_cats[$news_arr[6]] != TRUE){ continue; }

        if(isset($start_from) and $start_from != ""){
        	if($i < $start_from){ 
        		$i++; 
        		continue; }
            elseif($showed == $number){  break; }
        }
            
        if($my_names[$news_arr[1]]){ $my_author = $my_names[$news_arr[1]]; }
        else{ $my_author = $news_arr[1]; }

        $output = $template_active;
        # alternating
        if($o%2 == 0) { $nws_alternating = "cn_news_odd"; } else { $nws_alternating = "cn_news_even"; }
		$output = str_replace("{alternating}", $nws_alternating, $output);
		$o++;
        $output = str_replace("{title}", $news_arr[2], $output);
		
		# Add Elapsed
		$output = str_replace("{date-elapsed}", aj_elapsed($news_arr[0]), $output);
		$output = str_replace("{date}", langdate($config_timestamp_active, $news_arr[0]), $output);
        $output = str_replace("{author}", $my_author, $output);
        if($news_arr[5] != ""){$output = str_replace("{avatar}", "<img alt=\"\" src=\"$news_arr[5]\" style=\"border: none;\" />", $output); }
        else{ $output = str_replace("{avatar}", "", $output); }
		$output = str_replace("{avatar-url}", "$news_arr[5]", $output);

	# Music hack by rilmith 3 lines below.
	if ($news_arr[7] != "") {
	$output = str_replace("{music}", $news_arr[7], $output); }
	else { $output = str_replace("{music}", "", $output); }

        $output = str_replace("[link]","<a title=\"$lang_article_linktext\" href=\"$PHP_SELF?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query\">", $output);
        $output = str_replace("[/link]","</a>", $output);     
        
        $output = str_replace("{comments-num}", countComments($news_arr[0], $archive), $output);
        
        #MORE HACK        
        $content = explode('<!--more-->', $news_arr[3]);
if ($allow_rss == TRUE) { 
#		$content[0] = str_replace(array("\r", "\n", "\t","{nl}"), "", $content[0]);
		$content[0] = strip_tags($content[0]);
		}
		
		$short_story = run_filters('news-entry-content',$content[0]);
		
if ($allow_rss == TRUE) { 
#		$content[0] = str_replace(array("\r", "\n", "\t","{nl}"), "", $content[0]);
		$short_story = strip_tags($short_story);
		}
		
        $output = str_replace("{short-story}", $short_story, $output);
        $output = str_replace("{full-story}", run_filters('news-entry-content',$content[1]), $output);

		$output = str_replace("{category}", $cat[$news_arr[6]], $output);
		$output = str_replace("{category-id}", $news_arr[6], $output);
		if($cat_icon[$news_arr[6]] != ""){ $output = str_replace("{category-icon}", "<img alt=\"".$cat[$news_arr[6]]." icon\" style=\"border: none;\" src=\"".$cat_icon[$news_arr[6]]."\" />", $output); }
		else{ $output = str_replace("{category-icon}", "", $output); }

		$output = str_replace("{author-name}", $name_to_nick[$news_arr[1]], $output);

         if($my_mails[$news_arr[1]] != ""){
             $output = str_replace("[mail]","<a href=\"mailto:".$my_mails[$news_arr[1]]."\">", $output);
             $output = str_replace("[/mail]","</a>", $output);
		}else{
             $output = str_replace("[mail]","", $output);
             $output = str_replace("[/mail]","", $output);
         }
		# RSS
			$rssmail = $my_mails[$news_arr[1]];
			if (!$rssmail or $rssmail == "") {
				$rssmail = "anonymous@anonymoushost.org";
					}
		$output = str_replace("{rssmail}", $rssmail, $output);
		$output = str_replace("{rssdate}", date("r", $news_arr[0]), $output);
		$output = str_replace("{rssauthor}", $name_to_nick[$news_arr[1]], $output);
		# end rss
		$output = str_replace("{news-id}", $news_arr[0], $output);
		$output = str_replace("{archive-id}", $archive, $output);
		$output = str_replace("{php-self}", $PHP_SELF, $output);
		$output = str_replace("{cute-http-path}", $config_http_script_dir, $output);

# XFields v2.1 - addblock
$xfieldsaction = "templatereplace";
$xfieldsinput = $output;
$xfieldsid = $news_arr[0];
include("xfields.mdu");
$output = $xfieldsoutput;
# XFields v2.1 - End addblock

		$output = run_filters('news-entry',$output);
        $output = replace_news("show", $output);


        if($action == "showheadlines" or $content[1]){#if full story
            if($config_full_popup == "yes"){

            	$output = preg_replace("/\\[full-link\\]/","<a href=\"#\" onclick=\"window.open('$config_http_script_dir/show_news.php?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;template=$template', '_News', '$config_full_popup_string');return false;\">", $output);
            }else{
            	$output = str_replace("[full-link]","<a href=\"$PHP_SELF?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query\">", $output);
            }
                $output = str_replace("[/full-link]","</a>", $output);
		}else{
			$output = preg_replace("'\\[full-link\\].*?\\[/full-link\\]'si","<!-- no full story-->", $output);
		}

#		$output = run_filters('news-active-comlink', $output);
		if($config_comments_popup == "yes"){
			$output = str_replace("[com-link]","<a href=\"#\" onclick=\"window.open('$config_http_script_dir/show_news.php?aj_go=more&amp;template=$template&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]', '_News', '$config_comments_popup_string');return false;\">", $output);
		}else{
			$output = str_replace("[com-link]","<a href=\"$PHP_SELF?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]&amp;$user_query\">", $output);
		}
		
		$output = str_replace("[/com-link]","</a>", $output);

# AJB Date header option (based on code by SMKILLER2, rescued by The Dude)
if ($config_date_header == "Yes") {
	if ($dateheader_S != date("dmY", $news_arr[0])) {
		# 161-hacks above and below
		$dateheader_S = date("dmY", $news_arr[0]);

 		$dateheader = date($config_date_headerformat, $news_arr[0]);
 		$dateheader_local = strftime($config_date_headerformatlocal, $news_arr[0]);
 		$dateheader_p = $template_dateheader;
 		$dateheader_p = str_replace("{dateheader}", $dateheader, $dateheader_p);
 		$dateheader_p = str_replace("{dateheader-local}", strftime($dateheader_local, $news_arr[0]), $dateheader_p);

		 echo $dateheader_p;
		}
	}
# End AJB Date header option



		echo $output;
		$showed++;
        $i++;

        if($number != 0 and $number == $i){ break; }
	    }
        $used_archives[$archive] = TRUE;
# Archives Looop
        if($i < $number and $only_active != TRUE){

			if(!$handle = opendir("$cutepath/data/archives")){ die("<div style=\"text-align: center;\">$lang_archive_notopen</div>"); }
         		while (false !== ($file = readdir($handle)))
                 {
         			if($file != "." and $file != ".." and eregi("news.arch", $file))
                     {
         				$file_arr = explode(".",$file);
                        $archives_arr[$file_arr[0]] = $file_arr[0];
         			}
         		}
			closedir($handle);

            $archives_arr[$in_use]="";
            $in_use = max($archives_arr);

			if($in_use != "" and !$used_archives[$in_use]){
				$all_news = file("$cutepath/data/archives/$in_use.news.arch");
				$archive = $in_use;
                $used_archives[$in_use] = TRUE;
			}else{ $repeat = FALSE; }

	    }else{ $repeat = FALSE; }
	}

# << Previous   &   Next >>

    $prev_next_msg = $template_prev_next;

    #----------------------------------
    # Previous link
    #----------------------------------
    if(isset($start_from) and $start_from != "" and $start_from > 0){
    	$prev = $start_from - $number;
        $prev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'si", "<a href=\"$PHP_SELF?start_from=$prev&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">\\1</a>", $prev_next_msg);
    }else{ $prev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'si", "\\1", $prev_next_msg); $no_prev = TRUE; }

    #----------------------------------
    # Pages
    #----------------------------------
    if($number){
    $pages_count = @ceil($count_all/$number);
    $pages_start_from = 0;
    $pages = "";
    $pages_per_section = 3;
    if($pages_count > 10){
    	for($j = 1; $j <= $pages_per_section; $j++) {
        	if($pages_start_from != $start_from){
            	$pages .= "<a href=\"$PHP_SELF?start_from=$pages_start_from&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">$j</a> ";
                }
            else {
            	$pages .= " <strong>$j</strong> ";
				}
            $pages_start_from += $number;
            }
        if(((($start_from / $number) + 1) > 1) && ((($start_from / $number) + 1) < $pages_count)){
        	$pages   .= ((($start_from / $number) + 1) > ($pages_per_section + 2)) ? '... ' : ' ';
        	$page_min = ((($start_from / $number) + 1) > ($pages_per_section + 1)) ? ($start_from / $number) : ($pages_per_section + 1);
        	$page_max = ((($start_from / $number) + 1) < ($pages_count - ($pages_per_section + 1))) ? (($start_from / $number) + 1) : $pages_count - ($pages_per_section + 1);
        	$pages_start_from = ($page_min - 1) * $number;

        for($j = $page_min; $j < $page_max + ($pages_per_section - 1); $j++) {
	        if($pages_start_from != $start_from){
		        $pages .= "<a href=\"$PHP_SELF?start_from=$pages_start_from&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">$j</a> ";
		        }
        	else{
        		$pages .= " <strong>$j</strong> ";
        		}
			$pages_start_from += $number;
			}
        $pages .= ((($start_from / $number) + 1) < $pages_count - ($pages_per_section + 1)) ? '... ' : ' ';
		}
        else{
        	$pages .= '... ';
        	}
        $pages_start_from = ($pages_count - $pages_per_section) * $number;
        for($j=($pages_count - ($pages_per_section - 1)); $j <= $pages_count; $j++){
	        if($pages_start_from != $start_from){
		        $pages .= "<a href=\"$PHP_SELF?start_from=$pages_start_from&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">$j</a> ";
		        }
	        else{
		        $pages .= " <strong>$j</strong> ";
		        }
	        $pages_start_from += $number;
	        }
        }
        else{
        	for($j=1;$j<=$pages_count;$j++){
        		if($pages_start_from != $start_from){
        			$pages .= "<a href=\"$PHP_SELF?start_from=$pages_start_from&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">$j</a> ";
        			}
        		else{
        			$pages .= " <strong>$j</strong> ";
        			}
        		$pages_start_from += $number;
        		}
        	}
        $prev_next_msg = str_replace("{pages}", $pages, $prev_next_msg);
        }

    #----------------------------------
    # Next link
    #----------------------------------
    if($number < $count_all and $i < $count_all){
        $prev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'si", "<a href=\"$PHP_SELF?start_from=$i&amp;archive=$url_archive&amp;aj_go=$aj_go&amp;id=$id&amp;$user_query\">\\1</a>", $prev_next_msg);
    }else{ $prev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'si", "\\1", $prev_next_msg); $no_next = TRUE;}


    if	(!$no_prev or !$no_next){ echo $prev_next_msg; }
}
}while(0);
?>
