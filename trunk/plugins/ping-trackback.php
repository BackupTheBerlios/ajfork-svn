<?php
/*
Plugin Name:	Trackback System
Description:	Allows to transmit and receive trackbacks, and allows the transmission of weblogUpdate.ping style pings.
Version:		3.0
Author:			J-Dawg
Author URI:		http://www.jubbag.com
Application:	CuteNews
Required Framework: 1.1.3
*/
@add_action('new-save-entry','pingme');
@add_action('new-advanced-options','sitestoping');
@add_action('edit-advanced-options','sitespinged');
@add_action('edit-save-entry','post_edit_ping');
@add_action('plugin-options','pingstuff_listener');
@add_filter('cutenews-options', 'add_pingstuff_to_options');
@add_filter('news-entry','tb_stuff');
@add_filter('help-sections','tb_help');
@add_action('edit-extra-content','edit_tbs');
@add_filter('template-variables-full', 'tb_vars_full');
@add_filter('template-variables-active', 'tb_vars_active');

function pingme($hook)
{
	global $short_story,$title,$category,$added_time,$cutepath,$_POST,$skin_header;
	$xf = new XfieldsData();
	if ($_POST['disabletbs'] == "yes") {$xf->set("yes",$added_time,"tbs_disabled"); }
	else {$xf->set("no",$added_time,"tbs_disabled"); }
	$xf->save();
	$settings = new PluginSettings('Ping_Settings');
	$blog_name = $settings->settings['blogname'];
	$url = $settings->settings['mainpage'];
	$the_exerpt = (strlen(strip_tags($short_story)) > 255) ? substr(strip_tags($short_story),0,252) . '...' : strip_tags($short_story);
	$the_exerpt = str_replace("<!--more-->", "", $the_exerpt);
	$the_exerpt = str_replace("{nl}", "<br />", $the_exerpt);
	$pingtitle = urlencode(stripslashes($title));
	$excerpt = urlencode(stripslashes($the_exerpt));
	$blog_name = urlencode(stripslashes($blog_name));
	$blog_url = $url;
	$url = urlencode($url."?aj_go=more&id=$added_time&ucat=$category");
	weblog_updates_ping($blog_name,$blog_url,$category);
	$query_string = "title=$pingtitle&url=$url&blog_name=$blog_name&excerpt=$excerpt";
	if (!empty($_POST['pings']))
	{
		$trackback_url_array = explode("\n",$_POST['pings']);
		
		$xfieldpings = str_replace("\n","|",$_POST['pings']);
		$pingurls = new XfieldsData();
		$pingurls->set($xfieldpings,$added_time,"urls_to_ping");
		$pingurls->save();
		foreach ($trackback_url_array as $null => $trackback_url)
		{
			$trackback_url = parse_url($trackback_url);
			$http_request  = 'POST ' . $trackback_url['path'] . "?" . $trackback_url['query'] . " HTTP/1.0\r\n";
			$http_request .= 'Host: '.$trackback_url['host']."\r\n";
			$http_request .= 'Content-Type: application/x-www-form-urlencoded'."\r\n";
			$http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
			$http_request .= "\r\n";
			$http_request .= $query_string;
			$fs = @fsockopen($trackback_url['host'], 80);
			@fputs($fs, $http_request);
			
			//$debug_file = "data/trackback.log";
			//$fp = fopen($debug_file, 'a');
			//fwrite($fp, "\n*****\nRequest:\n\n$http_request\n\nResponse:\n\n");
			while(!@feof($fs)) {
				//fwrite($fp, @fgets($fs, 4096));
				$response .= @fgets($fs,4096);
			}
			//preg_match_all("#<error>(.*)</error>#siU",$response,$error,PREG_SET_ORDER);
			if (strstr($response,"<error>1</error>"))
			{
				preg_match_all("#<message>(.*)</message>#siU",$response,$message,PREG_SET_ORDER);
				$skin_header .= '<strong>Trackback Error!</strong> '."The following error was received while sending the trackback: ".$message[0][1].".<br /><br />";
			}
			//fwrite($fp, "\n\n");
			//fclose($fp);
		
			@fclose($fs);
		}
	}
}
function sitestoping($hook)
{
	?><input onclick="javascript:ShowOrHide('pings','')" type="checkbox" name="pingbox" id="pingbox" value="pingbox" /> <label for="pingbox">Pings?</label><div class="panel" style="display:none" id="pings"><label for="pings">Pings (each on newline)</label><textarea name="pings" id="pings" style="height: 100px; width: 100%;" wrap="off"></textarea></div><br /><input type="checkbox" name="disabletbs" id="disabletbs" value="yes" /> <label for="disabletbs">Disable Trackbacks?</label><br />
	<?php
}
function sitespinged($hook)
{
	global $item_db;
	$pings = new XfieldsData();
	$pingz = $pings->fetch($item_db[0],"urls_to_ping");
	$checked = $pings->fetch($item_db[0],"tbs_disabled");
	if ($checked == "yes") { $checked = "checked"; }
	$pingz = str_replace("|","\n",$pingz);
	?><br /><input onclick="javascript:ShowOrHide('pings','')" type="checkbox" name="pingbox" id="pingbox" value="pingbox" /> <label for="pingbox">Pings?</label><div class="panel" style="display:none" id="pings"><label for="pings">Pings (each on newline)</label><textarea name="pings" style="height: 100px; width: 100%;" wrap="off"><?php echo $pingz; ?></textarea></div><br /><input type="checkbox" name="disabletbs" id="disabletbs" value="yes" <?php echo $checked; ?> /> <label for="disabletbs">Disable Trackbacks?</label><br />
	<?php
}

function post_edit_ping($hook)
{
	global $short_story,$title,$cutepath,$_POST,$old_db_arr,$skin_header;
	$xf = new XfieldsData();
	if ($_POST['disabletbs'] == "yes") {$xf->set("yes",$old_db_arr[0],"tbs_disabled"); }
	else {$xf->set("no",$old_db_arr[0],"tbs_disabled"); }
	$xf->save();
	$settings = new PluginSettings('Ping_Settings');
	$blog_name = $settings->settings['blogname'];
	$url = $settings->settings['mainpage'];
	$the_exerpt = (strlen(strip_tags($short_story)) > 255) ? substr(strip_tags($short_story),0,252) . '...' : strip_tags($short_story);
	$the_exerpt = str_replace("<!--more-->", "", $the_exerpt);
	$the_exerpt = str_replace("{nl}", "<br />", $the_exerpt);
	$pingtitle = urlencode(stripslashes($title));
	$excerpt = urlencode(stripslashes($the_exerpt));
	$blog_name = urlencode(stripslashes($blog_name));
	$blog_url = $url;
	$url = urlencode($url."?aj_go=more&id=".$old_db_arr[0]."&ucat=".$old_db_arr[6]);
	weblog_updates_ping($blog_name,$blog_url,$old_db_arr[6]);
	$query_string = "title=$pingtitle&url=$url&blog_name=$blog_name&excerpt=$excerpt";
	if (!empty($_POST['pings']))
	{
		$trackback_url_array = explode("\n",$_POST['pings']);
		
		$xfieldpings = str_replace("\n","|",$_POST['pings']);
		$pings = new XfieldsData();
		$pingz = $pings->fetch($old_db_arr[0],"urls_to_ping");
		if ($xfieldpings != $pingz)
		{
			
			$pings->set($xfieldpings,$old_db_arr[0],"urls_to_ping");
			$pings->save();
		}
		foreach ($trackback_url_array as $null => $trackback_url)
		{
			$trackback_url = parse_url($trackback_url);
			$http_request  = 'POST ' . $trackback_url['path'] . "?" . $trackback_url['query'] . " HTTP/1.0\r\n";
			$http_request .= 'Host: '.$trackback_url['host']."\r\n";
			$http_request .= 'Content-Type: application/x-www-form-urlencoded'."\r\n";
			$http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
			$http_request .= "\r\n";
			$http_request .= $query_string;
			$fs = @fsockopen($trackback_url['host'], 80);
			@fputs($fs, $http_request);
			
			//$debug_file = "data/trackback.log";
			//$fp = fopen($debug_file, 'a');
			//fwrite($fp, "\n*****EDIT PING*****\nRequest:\n\n$http_request\n\nResponse:\n\n");
			while(!@feof($fs)) {
				//fwrite($fp, @fgets($fs, 4096));
				$response .= @fgets($fs,4096);
			}
			//fwrite($fp, "\n\n");
			//preg_match_all("#<error>(.*)</error>#siU",$response,$error,PREG_SET_ORDER);
			if (strstr($response,"<error>1</error>"))
			{
				preg_match_all("#<message>(.*)</message>#siU",$response,$message,PREG_SET_ORDER);
				$skin_header .='<strong>Trackback Error!</strong>'." The following error was received while sending the trackback: ".$message[0][1].".<br /><br />";
			}
			//fclose($fp);
		
			@fclose($fs);
		}
	}
}
function pingstuff_listener($hook)
{
	if ($_GET['action'] == 'ping') 
	{
		ping_options();
	}
}
function add_pingstuff_to_options($options, $hook)
{
	global $PHP_SELF;
	
	// Add a custom screen to the "options" screen
	$options[] = array(
		'name'		=> 'Trackback/Ping Setup',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=ping',
		'access'	=> '1',
			);

	// return the customized options
	return $options;
}
function ping_options()
{
	global $PHP_SELF;
	$blogname = $_POST['blogname'];
	$mainpage = $_POST['mainpage'];
	$defaultsites = $_POST['defaultsites'];
	$defaultsites = str_replace("\n","|",$defaultsites);
	echoheader("pingsetup", "Trackback Ping Setup");
	$pingsettings = new PluginSettings('Ping_Settings');
	if (!empty($blogname) || !empty($mainpage))
	{
		$pingsettings->settings['blogname'] = $blogname;
		$pingsettings->settings['mainpage'] = $mainpage;		
		$pingsettings->settings['defaultsites'] = stripslashes($defaultsites);
		$pingsettings->save();
	}
	$buffer = '<form action="'.$PHP_SELF.'?mod=options&action=ping" method="post">
<label for="blogname">Blog Name:</label><br />
<input type="text" id="blogname" name="blogname" value="'.stripslashes($pingsettings->settings['blogname']).'"><br />
<label for="mainpage">Full path to main page that news will be displayed on:</label><br />
<input type="text" id="mainpage" name="mainpage" value="'.$pingsettings->settings['mainpage'].'"><br />
<label for="defaultsites">Default XML/RPC sites to ping:</label><br />
<textarea rows="10" id="defaultsites" cols="40" name="defaultsites" wrap="off">'.stripslashes($pingsettings->settings['defaultsites']).'</textarea><br />
<input type="submit" value="update"></form>
				';
	echo $buffer;
	echofooter();
}
function weblog_updates_ping($blog_name,$url,$category)
{
	$pluginsettings = new PluginSettings('Ping_Settings');
	$defaultpings = $pluginsettings->settings['defaultsites'];
	if (!empty($defaultpings))
	{
		$weblog_updates_ping_name = urldecode($blog_name);
		$weblog_updates_ping_url = urldecode($url);
		$weblog_updates_ping_url = str_replace('&','&amp;',$weblog_updates_ping_url);
		$http_post_buffer = '<?xml version="1.0"?>'."\r\n<methodCall>\r\n\t<methodName>weblogUpdates.ping</methodName>\r\n\t<params>\r\n\t\t<param>\r\n\t\t\t<value>$weblog_updates_ping_name</value>\r\n\t\t\t</param>\r\n\t\t<param>\r\n\t\t\t<value>$weblog_updates_ping_url</value>\r\n\t\t\t</param>\r\n\t\t</params>\r\n</methodCall>";
		$defaultping_arr = explode("|",$defaultpings);
		foreach ($defaultping_arr as $null => $defaultping)
		{
			$trackback_url = parse_url($defaultping);
			$http_request  = 'POST /' . $trackback_url['path'] . $trackback_url['query'] . " HTTP/1.0\r\n";
			$http_request .= 'User-Agent: Radio UserLand/7.1b7 (WinNT)'."\r\n";
			$http_request .= 'Host: '.$trackback_url['host']."\r\n";
			$http_request .= 'Content-Type: text/xml'."\r\n";
			$http_request .= 'Content-Length: '.strlen($http_post_buffer)."\r\n";
			$http_request .= "\r\n";
			$http_request .= $http_post_buffer;
			$fs = @fsockopen($trackback_url['host'], 80);
			@fputs($fs, $http_request);
			//$debug_file = "data/xmlrpc.log";
			//$fp = fopen($debug_file, 'a');
			//fwrite($fp, "\n*****PING*****\nRequest:\n\n$http_request\n\nResponse:\n\n");
			//while(!@feof($fs)) {
			//	fwrite($fp, @fgets($fs, 4096));
			//}
			//fwrite($fp, "\n\n");
			//fclose($fp);
			@fclose($fs);
		}
	}
}
function tb_stuff($entry,$hook)
{
	global $cutepath,$news_arr,$archive,$my_start_from,$config_http_script_dir;
	$xftb = new XfieldsData();
	$tbs = $xftb->fetch($news_arr[0],'trackbacks');
	preg_match_all("#\[iftbs\](.*?)\[/iftbs\]#siU",$entry,$iftbs,PREG_SET_ORDER);
	preg_match_all("#\[tbcontainer\](.*?)\[/tbcontainer\]#siU",$entry,$tbbody,PREG_SET_ORDER);
	if (!empty($tbs))
	{
		$tbtemplate = $tbbody[0][1];
		preg_match_all("#\{tbtime\=(.*?)\}#siU",$tbtemplate,$tbtimeformat,PREG_SET_ORDER);
		settype($tbs,"array");
		$disptb = "";
		$tbcount = count($tbs);
		$alternating = 0;
		foreach ($iftbs as $null => $iftb)
		{
			$entry = str_replace($iftb[0],$iftb[1],$entry);
		}
		foreach ($tbs as $time => $trackback)
		{
			$thistb = $tbtemplate;
			$thistb = str_replace("{tblink}",$trackback['url'],$thistb);
			$thistb = str_replace("{tbtitle}",$trackback['title'],$thistb);
			$thistb = str_replace("{tbblogname}",$trackback['blog_name'],$thistb);
			$thistb = str_replace("{tbexcerpt}",$trackback['excerpt'],$thistb);
			$thistb = str_replace("{tbhost}",$trackback['host'],$thistb);
			if (empty($tbtimeformat))
			{
				$thistb = str_replace("{tbtime}",date("F jS, Y h:s A",$time),$thistb);
			}
			else
			{
				foreach ($tbtimeformat as $null => $tbtimeformat1)
				{
					$thistb = str_replace($tbtimeformat1[0],date($tbtimeformat1[1],$time),$thistb);
				}
			}
			if ($alternating == 0)
			{
				$thistb = str_replace("{tbalternating}","cn_tb_even",$thistb);
				$alternating ++;
			}
			else
			{
				$thistb = str_replace("{tbalternating}","cn_tb_odd",$thistb);
				$alternating --;
			}	
			//$disptb .= '<p><a href="'.$trackback['url'].'">'. $trackback['title'] . "</a> from " . $trackback['blog_name'] . "<br />";
			//$disptb .= $trackback['excerpt'] . '&nbsp;<a href="'. $trackback['url'] . '">[Read More]</a></p>';
			//$disptb .= '<p class="posted">Tracked on '. date("F jS, Y h:s A",$time) . '</p>';
			$disptb .= $thistb;			
		}

	}
	else
	{
		$tbcount = 0;
		foreach ($iftbs as $null => $iftb)
		{
			$entry = str_replace($iftb[0],"",$entry);
		}
		foreach ($tbbody as $null => $tbbody1)
		{
			$entry = str_replace($tbbody1[0],"",$entry);
		}
	}
	$disabled = $xftb->fetch($news_arr[0],'tbs_disabled');
	if ($disabled != "yes")
	{
		$entry = str_replace('{tburl}',"$config_http_script_dir/aj_tb.php?id=$news_arr[0]",$entry);
		foreach ($tbbody as $null => $tbbody1)
		{
			$entry = str_replace($tbbody1[0],'<a id="trackback"></a>'.$disptb,$entry);
		}
	}
	else
	{
		$entry = str_replace('{tburl}',"",$entry);
		foreach ($tbbody as $null => $tbbody1)
		{
			$entry = str_replace($tbbody1[0],"",$entry);
		}
	}
	$entry = str_replace('{tbcount}',$tbcount,$entry);
	$entry = str_replace('[tblink]', "<a href=\"$PHP_SELF?aj_go=more&amp;id=$news_arr[0]&amp;archive=$archive&amp;start_from=$my_start_from&amp;ucat=$news_arr[6]#trackback\">",$entry);
	$entry = str_replace('[/tblink]',"</a>",$entry);
	return $entry;
}
function tb_help($help_sections,$hook)
{
	 $help_sections["Trackbacks/Pings"] = <<<HTML
<h1>Trackbacks/Pings For CuteNews</h1>
<p>Welcome to the wonderful world of Trackbacks and Pings! Now that you have this plugin installed, it's time to understand what it does:</p>
Trackbacks: 
<p>Say you read your friend's latest post on his blog and liked it and decided to post it on your blog. Wouldn't you want readers of your friends's blog to know about your post? That's what this plugin does. You enter the Trackback URL into the new pings textarea, post the news, and voila! An excerpt and link to your post are automatically created on your friend's blog.</p>
Pings:
<p>There are services out there that let people know what blogs have updated recently. An example is <a href="http://blo.gs">http://blo.gs/</a>. This plugin has a handy textarea in the config that you can input URL's to these update services to let them know when you've updated. I recommend http://rpc.pingomatic.com/ as it pings seven update services at once.</p>
Template Variables:
<p>This plugin allows for some new template variables to display information about pings your site has received. These are:</p>
<table border="0">
<tr><td>{tbcount}:</td><td>Returns the number of trackbacks this entry received.</td></tr>
<tr><td>{tburl}:</td><td>Returns the URL that other blogs should use to trackback the entry.</td></tr>
<tr><td>[iftbs] and [/iftbs]:</td><td>Anything in between these will only show up if there are trackbacks for this entry.</td></tr>
<tr><td>[tblink] and [/tblink]:</td><td>Returns a clickable URL that brings the reader of your blog to the location of the trackbacks for the entry.</td></tr>
<tr><td>[tbcontainer] and [/tbcontainer]:</td><td>Anything between these will be looped through for each trackback for this entry. If there are none, nothing will show up.</td></tr>
<tr><td>{tblink}:</td><td>URL to the entry in the blog that tracked back this entry.</td></tr>
<tr><td>{tbtitle}:</td><td>Title of the entry in the blog that tracked back this entry.</td></tr>
<tr><td>{tbtime}:</td><td>Time the trackback was made. (you can also use {tbtime=[PHP Date Format]} just like customize date tag. Default is F jS, Y h:s A)</td></tr>
<tr><td>{tbexcerpt}:</td><td>Displays the excerpt of the entry that tracked back this entry.</td></tr>
<tr><td>{tbhost}:</td><td>Displays the IP address of the server that sent the trackback.</td></tr>
<tr><td>{tbalternating}:</td><td>Prints either "cn_tb_even" or "cn_tb_odd" (tip: CSS classes)</td></tr>
</table>
Here is a complete example: 
<pre>&lt;p class="techstuff"&gt;TrackBack URL for this entry:&lt;br /&gt;
{tburl}&lt;/p&gt;
[iftbs]Below are links to sites that reference {title}: &lt;br /&gt;[/iftbs]
[tbcontainer]&lt;p&gt;&lt;a href="{tblink}"&gt;{tbtitle}&lt;/a&gt; from {tbblogname}&lt;br /&gt;
{tbexcerpt} &lt;a href="{tblink}"&gt;[Read More]&lt;/a&gt;&lt;/p&gt;
&lt;p class="posted"&gt;Tracked on {tbtime}&lt;/p&gt;[/tbcontainer]</pre>
HTML;
return $help_sections;
}
function edit_tbs($hook)
{
	global $id,$bg,$_POST;
	if ($_POST['deletetb'] == "yes")
	{
		$xfdel = new XfieldsData();
		$arraytbs = $xfdel->fetch($id,'trackbacks');
		foreach ($_POST['deltbid'] as $null => $thisid)
		{
			unset($arraytbs[$thisid]);
		}
		$xfdel->set($arraytbs,$id,'trackbacks');
		$xfdel->save();
	}
	echo<<<JSCRIPT
<script type="text/javascript">
<!--
function check_uncheck_all_tbs() {
	var frm = document.trackbacks;
	for (var i=0;i<frm.elements.length;i++) {
		var elmnt = frm.elements[i];
		if (elmnt.type=='checkbox') {
			if(frm.cmbox.checked == true){ elmnt.checked=true; }
            else{ elmnt.checked=false; }
		}
	}
	if(frm.cmbox.checked == true){ frm.cmbox.checked = true; }
    else{ frm.cmbox.checked = false; }
}

-->
</script>
JSCRIPT;
	echo "<table>	
	<tr>
	<td colspan=\"3\">
	<h1>Trackbacks</h1>
	</td>
	</tr>
	<tr>";
	$xf = new XfieldsData();
	$arrayoftbs = $xf->fetch($id,'trackbacks');
	if (empty($arrayoftbs))
	{
		echo "<td colspan=\"3\"><h2>No Trackbacks</h2></td></tr></table>";
	}
	else
	{
		echo "<td style=\"padding-right: 10px;\"><h2>Blog's Name</h2></td><td style=\"padding-right: 10px;\"><h2>Time Tracked</h2></td></tr>";
		echo '<form method="post" name="trackbacks" action="'.$PHP_SELF.'">';
		foreach ($arrayoftbs as $time => $tbarray)
		{
			if($flag == 1)
			{
				$bg = "alternate";
				$flag = 0;
			}
            else
			{
				$bg = "alternate2";
				$flag = 1;
			}
			$tbtime = date("D, d F Y h:i:s",$time);
			echo "<td class=\"$bg\"><a href=\"".stripslashes($tbarray['url'])."\" target=\"_blank\">".stripslashes($tbarray['blog_name'])."</a></td><td class=\"$bg\">".$tbtime."<td class=\"$bg\"><input type=\"checkbox\" name=\"deltbid[]\" value=\"$time\" /></td></tr>";
		}
		
		echo "<tr><td></td><td><p style=\"text-align:right;\">delete all?</p></td><td><input type=\"checkbox\" name=\"cmbox\" value=\"all\" onclick=\"javascript:check_uncheck_all_tbs()\" /></td></tr><tr><td></td><td colspan=\"2\"><p style=\"text-align:right;\"><input type=\"submit\" value=\"Delete Selected\" /></p></td>";
		echo "<input type=\"hidden\" name=\"newsid\" value=\"$id\" /><input type=\"hidden\" name=\"deletetb\" value=\"yes\" /><input type=\"hidden\" name=\"action\" value=\"editnews\" /><input type=\"hidden\" name=\"mod\" value=\"editnews\" /></form>";
        echo "</table>";        
	}
}


function tb_vars_active($output) {
	$output["{tblink}"] = "Displays a link to trackbacks for this article";	
	return $output;
}

function tb_vars_full($output) {
	$output["[iftbs]...[/iftbs]"] = "Anything in between these will only show up if there are trackbacks for this entry.";
	$output["[tbcontainer]...[/tbcontainer]"] = "Used around a single trackback";
	$output["{tbtime}"] = "Displays the time a trackback was added";
	$output["{tbtlink}"] = "Displays the url to where the trackback originated";
	$output["{tbtitle}"] = "Displays the title of the trackback";
	$output["{tbblogname}"] = "Displays whatever the trackback sender identified itself as";
	$output["{tbexcerpt}"] = "Displays an exceprt from the trackback post";
	$output["{tburl}"] = "Displays trackback url for this article";
	$output["{tbhost}"] = "Displays the ip address of the server that sent the trackback";
	$output["{tbalternating}"] = "Outputs either cn_tb_odd or cn_tb_even (use for css styling)";
	return $output;
	
}
?>
