<?php

/*
Plugin Name: Userfriendly URLs
Plugin URI: http://www.brandedthoughts.co.uk/cutewiki/index.php/Userfriendly%20URLs%20Plugin
Description: Manages usage of prettier URLS for your articles. Example: http://site.org/2005/01/28/category/condensed-title-of-post.html. <a href="http://appelsinjuice.org/fork/index.php?mod=options&action=furls">Configuration is done via this separate interface</a>.
Version: 0.9
Required Framework: 1.1.5
Conflicts: Subcategories, 
Application: CuteNews
Author: Øivind Hoel
Author URI: http://appelsinjuice.org/
*/

$GLOBALS['aj_plugins']['friendlyurls'] = 'Running';

@add_filter('cutenews-options', 'furls_addOption');
@add_filter('news-entry', 'furls_parseTemplates', 20);
@add_action('plugin-options','furls_Listen');
@add_filter('news-fullstory-loop', 'furls_useTitles');
@add_filter('comment-added-java-redirection', 'furls_javaRedirect');
@add_filter('news-comment', 'furls_request');
@add_filter('help-sections', 'furls_help');
@add_filter('template-variables-active', 'furls_var_active');
@add_filter('template-variables-full', 'furls_var_full');
@add_filter('monthly-link-title-url', 'furls_monthlyarchive');

// Notice: 	Depends on aj_prepareTitle() in functions.inc.php
//			The reason this function isn't placed in the plugin is that other plugins might want to use 
//			it even if this plugin is disabled...

function furls_help($help_sections, $hook) {
$help_sections["FURLS"] = <<<HTML
<h1>Friendly URLS</h1>
<p>
	Friendly urls rock!
	</p>
HTML;
return $help_sections;
}

function furls_addOption($options, $hook) {
	global $PHP_SELF;

	$options[] = array(
		'name'		=> 'Friendly URL Setup',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=furls',
		'access'	=> '1',
	);
	
	return $options;
}

function furls_Listen($hook) {
	if ($_GET['action'] == 'furls')
		furls_AdminOptions();
}

function furls_AdminOptions() {
	global $cutepath, $cute_query_string;
	include($cutepath.'/data/config.php');
	echoheader('user','Userfriendly URL Setup');
	$furls = new PluginSettings('Userfriendly_URLs');
	$bhelp = '<p><a href="?mod=options&action=furls">Back</a> / <a href="http://www.brandedthoughts.co.uk/cutewiki/index.php/Userfriendly%20URLs%20Plugin">Help</a></p>';

	switch ($_GET['subaction']) {
	
	case 'edit':
	$linkdata = $furls->settings['text']['0'];
	$buffer = $bhelp .'
	<p>This version of the plugin only needs to know the path to your include-file and what prefix you want on archived entry and category links.</p>
	<form method="post" action="?mod=options&amp;action=furls&amp;subaction=doadd" class="easyform">
		<div>
			<label for="txtCA">Category</label>
			<input id="txtCA" name="furls[category]" value="'.$linkdata[CA].'" />
		</div>
		<div>
			<label for="txtAR">Archive prefix</label>
			<input id="txtAR" name="furls[archives]" value="'.$linkdata[AR].'" />
		</div>
		<div style="padding-top: 10px;"><label for="txtPATH" style="width: 100%;">Path to including file<br /><small>If your including file is located at http://yoursite.com/content/news/index.php, type &quot;/content/news/index.php&quot; in this box. <br />Note that it\'s the full url to the file without &quot;http://yoursite.com/&quot;.</small></label>
			<input style="width: 200px;" id="txtPATH" name="furls[path]" value="'.$linkdata[PATH].'" />
		</div>
		<div>
		<input type="submit" value="Save" />
		</div>
	</form>';
			break;
	
	case 'templates':
	
	// List templates
	        $templates_list = array();
        if(!$handle = opendir("$cutepath/data")){ die("<center>Can not open directory $cutepath/data "); }
   		while (false !== ($file = readdir($handle))){
   			if(eregi(".tpl", $file)){
            	$file_arr		 = explode(".", $file);
                $templates_list[]= $file_arr[0];
   			}
   		}
        closedir($handle);
    echo $bhelp;
	echo '<p>This tool will automatically convert your old link, full-link and com-link tags to the new humanlink, 
			humanmorelink and humancomlink tags used by this plugin to create friendly url links to your posts. If you want to reverse 
			the process, check the &quot;reverse&quot; checkbox.</p>
		
		<form method="post" action="?mod=options&amp;action=furls&amp;subaction=dotemplates" class="easyform">
		<div>
			<label for="txtTemplate">Template</label>
		<select id="txtTemplate" name="furls[template]">';

    	foreach($templates_list as $null => $single_template){
    		if($single_template == "Default"){ 
    			echo"<option selected=\"selected\" value=\"$single_template\">$single_template</option>"; }
        	else{ 
        		echo"<option value=\"$single_template\">$single_template</option>"; }
    		}

   		echo'</select></div>
   		<div>
			<label for="txtReverse">Reverse</label>
			<input type="checkbox" id="txtReverse" name="furls[reverse]" value="true" />
		</div>
			<div>
				<input type="submit" value="Update my templates" />
			</div>
		</form>';
	break;
	
	case 'htaccess':
	$info = $furls->settings['text']['0'];
	$rewritebase = dirname($info[PATH]);
	if ($rewritebase != "/") { $rewritebase = $rewritebase."/"; }
	$includefile = str_replace(dirname($info[PATH])."/", "", $info[PATH]);
	$htaccesscont = 'RewriteEngine On
RewriteBase '.$rewritebase.'
RewriteRule ^'.$info[AR].'/([0-9]{10})/([0-9]{4})/([0-9]{2})/([0-9]{2})/(.*)/(.*)\.html$ '.$includefile.'?archive=$1&furls_date=$2/$3/$4&aj_go=more&category=$5&id=$6 [QSA]
RewriteRule ^([0-9]{4})/([0-9]{2})/([0-9]{2})/(.*)/(.*)\.html$ '.$includefile.'?furls_date=$1/$2/$3&aj_go=more&category=$4&id=$5 [QSA]
RewriteRule ^'.$info[CA].'/(.*)\.html$ '.$includefile.'?category=$1 [QSA]';
	echo $bhelp;
	echo '<p>This tool will try to create a .htaccess-file in the location you specify. If you\'ve pointed the plugin to the correct include-file-path, 
	the content shown below should be ready for use. You can add variables to the last part of each rewriterule-line. Say you have your include-code in 
	index.php, but it only shows news if you have show=news in your url; you would then add &quot;&show=news&quot; to the end of each line.</p>
	
	
		<form method="post" action="?mod=options&amp;action=furls&amp;subaction=dohtaccess" class="easyform">
		<div>
			<label style="width: 300px;" for="txtHtaccess">.htaccess contents:</label>
			<textarea style="width: 100%; height: 200px;" wrap="off" id="txtHtaccess" name="furls[htaccess]">'.$htaccesscont.'</textarea>
		</div>
		<div>
		
		<p>The location must be relative to 
	your cutenews directory. If you type just &quot;.htaccess&quot;, the file will be created in your cutenews directory. 
	If you type &quot;../.htaccess&quot;, the file will be created in the parent directory of your cutenews installation.
	If you have cutenews installed in &quot;/content/cutenews&quot; and your include-file in &quot;/&quot;, type &quot;../../.htaccess&quot; in the field (&quot;../&quot; means one directory up).<br /></p>

			<p><span class="warning">This <b>might</b> cause your server to crash - so be warned! Not exactly crash, but create a file that is 
			unreadable/unwritable/assigned to another user than yourself on the host machine, thus in a worst-case scenario rendering 
			your site non-functional. If you\'re uncomfortable 
			risking a server&quot;crash&quot;, you should do this manually by writing and uploading the .htaccess file yourself. 
			The directory you are writing .htaccess to must be writable and readable for this tool to work. ('.$_SERVER["PHP_SELF"].')</span></p>
			
			<label for="txtTemplate">Write to file:</label>
			<input id="txtTemplate" name="furls[htaccessfile]" value="../.htaccess" />
		</div>
		
			<div>
				<input type="submit" value="Write file!" />
				
			</div>
		</form>';
	break;
	
	case 'dohtaccess':
	if (WriteContents(stripslashes($_POST[furls][htaccess]), stripslashes($_POST[furls][htaccessfile])) == "true") {
	echo "$bhelp <p>Written to ".stripslashes($_POST[furls][htaccessfile])."</p>"; }
	else { echo "$bhelp <p>Couldn't write file - make sure the directory you are writing to is actually writable (CHMOD 777)</p>"; }
	break;
	
	case 'dotemplates':
	$templatefile = "$cutepath/data/".stripslashes($_POST[furls][template]).".tpl";
	$furl_templatec = GetContents($templatefile);
	if (stripslashes($_POST[furls][reverse]) == "true") {
		$furl_templatec = str_replace("humanmorelink", "full-link", $furl_templatec);
		$furl_templatec = str_replace("humancomlink", "com-link", $furl_templatec);
		$furl_templatec = str_replace("humanlink", "link", $furl_templatec);
		$state = "Original links placed";
		}
	else {
		$furl_templatec = str_replace("full-link", "humanmorelink", $furl_templatec);
		$furl_templatec = str_replace("com-link", "humancomlink", $furl_templatec);
		$furl_templatec = str_replace("[link]", "[humanlink]", $furl_templatec);
		$furl_templatec = str_replace("[/link]", "[/humanlink]", $furl_templatec);
		$state = "Friendly links placed";
		}
		
	if (WriteContents($furl_templatec,$templatefile) == "true") {
	echo $bhelp;
		echo "<p>Template <b>".stripslashes($_POST[furls][template])."</b> updated successfully! ($state)</p>";
		}
	else { 
		echo $bhelp;
		echo "<p>Something bad happened... couldn't write to template-file specified!<br /><a href=\"?mod=options&action=furls\">Back</a></p>";
		}
	break;
	
	case 'doadd':
			$linkdata = array(
				CA		=> stripslashes($_POST[furls][category]),
				AR		=> stripslashes($_POST[furls][archives]),
				PATH 	=> stripslashes($_POST[furls][path]),
			);
			
			$furls->settings['text']['0'] = $linkdata;
			
			$buffer = $bhelp.'<p>Saved link info</p>';
			$furls->save();
	break;
	default:
		$info = $furls->settings['text']['0'];
		$buffer .= '
		<ul>
			<li><a href="?mod=options&amp;action=furls&amp;subaction=edit">Edit friendly link settings</a></li>
			<li><a href="?mod=options&amp;action=furls&amp;subaction=templates">Auto-update templates</a></li>
			<li><a href="?mod=options&amp;action=furls&amp;subaction=htaccess">Write required .htaccess-file</a></li>
		</ul>';
		$buffer .= '
		<h2>General help:</h2>
		<p>To make these new links work, you\'ll need to upload the .htaccess-file generated in step two above and place it in the same
		 directory as the file you\'re including show_news.php in resides in. The plugin can also 
		 <a href="?mod=options&amp;action=furls&amp;subaction=htaccess">do this for you</a> if this directory is writable. 
		 Read the warning text given there before pressing submit!</p>
		 
		<p>After uploading the .htaccess-file to the correct directory, you can replace [link][/link], [full-link][/full-link]
		 and [com-link][/com-link] in your templates with [humanlink][/humanlink], [humanmorelink][/humanmorelink] and [humancomlink][/humancomlink] 
		 to make the plugin output your new, more aesthetical URLs. You can also 
		 <a href="?mod=options&amp;action=furls&amp;subaction=templates">make the plugin do this</a> for you.</p>
		 <p>The last thing you need to do is put a &lt;base href=&quot;http://path/&quot; /&gt; tag in the &lt;head&gt; section of your including file. 
		 If your including file is at http://yoursite.org/news/, the base tag href mentioned here should reflect that.</p>
		 <h2>Requirements</h2>
		<p>- Apache with mod_rewrite enabled<br />
		- Linux/Unix or Win32 OS<br />
		- Host must allow .htaccess overrides<br />
		- Host must have FollowSymLinks enabled</p>
		';
	}	
	echo $buffer;
	echofooter();
}




function furls_useTitles($id) {
	global $news_arr, $catid, $furls_date;
	if (aj_prepareTitle($id) == aj_prepareTitle($news_arr[2]) and ($furls_date == date("Y/m/d", $news_arr[0]))) {
		$id = $news_arr[0];
		}
	return $id;
	}

function furls_javaRedirect($java_redirect) {
	global $javasubaction, $archive, $id, $ucat, $ntitle, $category;
	$furls = new PluginSettings('Userfriendly_URLs');
	$linkdata = $furls->settings['text']['0'];
	$linktitle = aj_prepareTitle($ntitle);
	$red_modif = $linkdata[CM]; 
	$category = aj_getCat($ucat); 
	if (!$category) { $category = "none"; }
	if ($archive) { $red_arch = "/$linkdata[AR]/$archive"; }
	
	$humandate = date("Y/m/d", $id);
	$youarehere = $_SERVER['HTTP_HOST'];
	$youarehere .= $_SERVER['PHP_SELF'];
	$youarehere = dirname($youarehere);
	$java_redirect = "<script type=\"text/javascript\">self.location.href='http://$youarehere$red_arch/$humandate/$category/$linktitle.html';</script>";
	return $java_redirect;
	}

function furls_parseTemplates($output) {
	
	global $news_arr, $archive, $aj_go, $cat, $content, $lang_article_linktext;
  	$furls = new PluginSettings('Userfriendly_URLs');
  	$linkdata = $furls->settings['text']['0'];
  	$linktitle = aj_prepareTitle($news_arr[2]);
  	
  	// no a-z-characters in title-fix
  	if($linktitle == "") { $linktitle = $news_arr[0]; }
  	
	$kat = $cat[$news_arr[6]];
	if ($kat == "") { $kat = "archives"; }
	if(!$archive) {
		if ($content[1]) {
		$output = str_replace("[humanmorelink]","<a title=\"$lang_article_linktext\" href=\"".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humanmorelink]","</a>", $output);
        }
        else {
        $output = preg_replace("'\\[humanmorelink\\].*?\\[/humanmorelink\\]'si","<!-- AJF: no more text here -->", $output);
        }
        $output = str_replace("[humancomlink]","<a title=\"$lang_article_linktext\" href=\"".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humancomlink]","</a>", $output);
        
        $output = str_replace("[humanlink]","<a title=\"$lang_article_linktext\" href=\"".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humanlink]","</a>", $output);
        
        $output = str_replace("{humanlink-url}", date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html", $output);
    	}
    elseif ($archive) {
    	if ($content[1]) {
    	$output = str_replace("[humanmorelink]","<a title=\"$lang_article_linktext\" href=\"$linkdata[AR]/$archive/".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humanmorelink]","</a>", $output);
        }
        else {
        $output = preg_replace("'\\[humanmorelink\\].*?\\[/humanmorelink\\]'si","<!-- AJF: no more text here -->", $output);
        }
        $output = str_replace("[humancomlink]","<a title=\"$lang_article_linktext\" href=\"$linkdata[AR]/$archive/".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humancomlink]","</a>", $output);
        
        $output = str_replace("[humanlink]","<a title=\"$lang_article_linktext\" href=\"$linkdata[AR]/$archive/".date("Y/m/d", $news_arr[0])."/$kat/$linktitle.html\">", $output);
        $output = str_replace("[/humanlink]","</a>", $output);
		}
return $output;
}

function furls_monthlyarchive($output, $hook) {
	global $cutepath, $date, $info, $lang_article_linktext;
  	$furls = new PluginSettings('Userfriendly_URLs');
  	$linkdata = $furls->settings['text']['0'];
	$title = aj_prepareTitle($info[title]);
	$category = aj_getCat($info[category]);

	$output = "<a title=\"$info[title]\"href=\"$linkdata[AR]/$info[home]/".date("Y/m/d", $date)."/$category/$title.html\">$info[title]</a>";
	return $output;	
}

function furls_request($output) {
	$output = str_replace("{request}", $_SERVER['REQUEST_URI'], $output);
	return $output;
	}
function furls_var_active($vars) {
	$vars["[humancomlink]...[/humancomlink]"] = "Displays a link to the story if comments are enabled (in human-friendly-url format)";
	$vars["[humanmorelink]...[/humanmorelink]"] = "Displays a link to the story if it contains extended content (in human-friendly-url format)";
	$vars["[humanlink]...[/humanlink]"] = "Displays a permanent link to the story  (in human-friendly-url format)";
	$vars["{humanlink-url}"] = "Displays the friendly suburl of an article, ala 2005/01/24/category/post-title.html";
	return $vars;
	}

function furls_var_full($vars) {
	$vars["[humanlink]...[/humanlink]"] = "Displays a permanent link to the story  (in human-friendly-url format)";
	
	return $vars;
	}

?>
