<?php

/*
Plugin Name: Mailing System
Plugin URI: 
Description: Notifies users about updates (ALPHA quality, but will mail any address you put in the plugin options)
Version: 0.1
Required Framework: 1.1.5
Application: CuteNews
Author: Øivind Hoel
Author URI: http://appelsinjuice.org/
*/

@add_action('new-save-entry','msp_send');
@add_action('edit-save-entry','msp_send');
@add_action('plugin-options','msp_Listen');
@add_filter('cutenews-options', 'msp_addOption');
@add_action('comment-added','msp_send');
/*
	In place:
			Mail to author of story when edited and when added. Basically useless
			in other words ;)

	This plugin will need the following:
			- A template-configuration for the message
			- A config for extra headers (html/plain/etc)
			- A database of emails that need to have mail sent to them

	TODO:
			Mail to author of story when comment is posted
			Mail to admins and editors when a story is added or edited
			More?
*/

function msp_addOption($options, $hook) {
	global $PHP_SELF;

	$options[] = array(
		'name'		=> 'Mailing System Setup',
		'url'		=> $PHP_SELF.'?mod=options&amp;action=msp',
		'access'	=> '1',
	);
	
	return $options;
}

function msp_Listen($hook) {
	if ($_GET['action'] == 'msp')
		msp_AdminOptions();
}

/* Options */

function msp_AdminOptions() {
	global $cutepath;
	include($cutepath.'/data/config.php');
	echoheader('user','Mailing System Setup');
	$msp = new PluginSettings('Mailing_System');
	$mhelp = '<p><a href="?mod=options&action=msp">Back</a> / <a href="http://www.brandedthoughts.co.uk/cutewiki/index.php/Mailing_System">Help</a></p>';

	switch ($_GET['subaction']) {
		
	case 'doedit':
			$mails = array(
				"AddedEmails"	=> stripslashes($_POST[msp][addedmails]),
				"EditedEmails"		=> stripslashes($_POST[msp][editedmails]),
				"CommentEmails"		=> stripslashes($_POST[msp][commentmails]),
				"AuthorEdited"	=> stripslashes($_POST[msp][authoredited]),
				"AuthorComments" => stripslashes($_POST[msp][authorcomments]),
			);
			$msp->settings['mails']['me'] = stripslashes($_POST['AdminEmail']); //From
			$msp->settings['mails']['subject'] = stripslashes($_POST['subject']); //Subject Template
			$msp->settings['mails']['0'] = $mails;
			
			$buffer = $mhelp.'<p>Saved mailing list</p>';
			$msp->save();
	break;
	default:
	$mails = $msp->settings['mails']['0'];
	$me = $msp->settings['mails']['me'];
	if (empty($me)) { $me = 'ajfork@'.$_SERVER['SERVER_NAME']; }
	$subject = $msp->settings['mails']['subject'];
	if (empty($subject)) { $subject = "Site updated @ {maildate} by {mailuser}"; }
	if ($mails[AuthorEdited] == "true") { $aesel = "checked=\"checked\""; }
	if ($mails[AuthorComments] == "true") { $acsel = "checked=\"checked\""; }
	$buffer = $mhelp .'
	<p>This is where you set up the mailing lists. Input emails in the textareas seperated by comma+space. ie &quot;<strong>first@email.com, second@email.com</strong>&quot;</p>
	<form method="post" action="?mod=options&amp;action=msp&amp;subaction=doedit" class="easyform">		
		<div>
			<label style="width: 50%;" for="txtAdminEmail">Admin Email</label>
			<input type="text" style="width: 100%;" id="txtAdminEmail" name="AdminEmail" value="'.$me.'" />
		</div>
		<div>
			<label style="width: 50%;" for="txtSubject">Subject: Use {maildate} and {mailuser}</label>
			<input type="text" style="width: 100%;" id="txtSubject" name="subject" value="'.$subject.'" />
		</div>
		<div>
			<label style="width: 50%;" for="txtAddedEmails">Who to mail when a story is added</label>
			<textarea class="medium" style="width: 100%;" id="txtAddedEmails" name="msp[addedmails]">'.$mails[AddedEmails].'</textarea>
		</div>
		<div>
			<label style="width: 50%;" for="txtEditedEmails">Who to mail when a story is edited</label>
			<input type="checkbox" id="txtAuthoredited" name="msp[authoredited]" value="true" '.$aesel.'/>
			<label style="width: 300px;" for="txtAuthoredited">Mail author</label>
			<textarea class="medium" style="width: 100%;" id="txtEditedEmails" name="msp[editedmails]">'.$mails[EditedEmails].'</textarea>
		</div>		
		<div>
			<label style="width: 50%;" for="txtCommentEmails">Who to mail when a comment is added</label>
			<input type="checkbox" id="txtAuthorcomments" name="msp[authorcomments]" value="true" '.$acsel.'/>
			<label style="width: 300px;" for="txtAuthorcomment">Mail author</label>
			<textarea class="medium" style="width: 100%;" id="txtCommentEmails" name="msp[commentmails]">'.$mails[CommentEmails].'</textarea>
		</div>
		<div>
		<input type="submit" value="Save" />
		</div>
	</form>';	}	
	echo $buffer;
	echofooter();
}
/* /Options */
function msp_send($hook) {
	global $added_time, $member_db, $title, $short_story, $old_db_arr, $time, $name, $comments, $id, $cutepath;
	$msp = new PluginSettings('Mailing_System');
	$mails = $msp->settings['mails']['0'];
	$me = $msp->settings['me'];
	$subject = $msp->settings['mails']['subject'];
	if (empty($subject)) { $subject = "Site updated @ {maildate} by {mailuser}"; }
	if (empty($me)) { $me = 'ajfork@'.$_SERVER['SERVER_NAME']; }
		// Common and required
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain; charset=utf-8\r\n";

		/* additional headers */
		// $headers .= "To: $member_db[4] <$member_db[5]>\r\n";
		$headers .= "From: AJ-Fork <$me>\r\n";
			
		// Var sanitizing for news
		$msp_send_short_story = str_replace("{nl}", "\r\n", $short_story);
		$msp_send_short_story = explode('<!--more-->', $msp_send_short_story);
		$msp_send_short = $msp_send_short_story[0];
		$more = $msp_send_short_story[1];
		$old = $old_db_arr[3];
		$oshort_story = str_replace("{nl}", "\r\n", $old);
		$oshort_story = explode('<!--more-->', $oshort_story);
		$oshort = $oshort_story[0];
		$omore = $oshort_story[1];
		if ($added_time != "") { $humandate = date("d/m/y", $added_time); }
		elseif ($old_db_arr[0] != "") { $humandate = date("d/m/y", $old_db_arr[0]); }
		elseif ($time != "") { $humandate = date("d/m/y", $time); }
		// Var senitizing for comments
		$comments = str_replace("{nl}", "\r\n", $comments);

	switch ($hook) {
	
	case 'new-save-entry':
	$to = $mails[AddedEmails];
	$action = "News Added";
	$message = "AJ-Fork Mailing System Plugin\r\n\r\n$member_db[4] ($member_db[2]) just added \"$title\" (added $humandate), containing the following:\r\n\r\nShort:\r\n\t$msp_send_shortMore:\r\n\t$more";
	$subject = str_replace("{mailuser}",$member_db[4],$subject);
break;

	case 'edit-save-entry':
	$to = $mails[EditedEmails];
	if ($mails[AuthorEdited]) { $to .= ", $member_db[5]"; }
	$action = "News Edited";
	$message = "AJ-Fork Mailing System Plugin\r\n\r\n$member_db[4] ($member_db[2]) edited article titled \"$title\" @ $humandate. Old and new short story follows:\r\n\r\nOld:\r\n\tShort:\r\n\t\t$oshort\r\n\r\n\tMore:\r\n\t\t$omore\r\n\r\nNew:\r\n\tShort:\r\n\t\t$msp_send_short\r\n\r\n\tMore:\r\n\t\t$more";
	$subject = str_replace("{mailuser}",$member_db[4],$subject);
break;

	case 'comment-added':
	$to = $mails[CommentEmails];
	if ($mails[AuthorComments]) { 
		$this_post_arr = aj_PostInfo($id, "$cutepath/data/news.txt");
		$owner_arr = aj_get_member($this_post_arr["author"]);
		$authoremail = $owner_arr[5];
		$title = $this_post_arr["title"];
		$to .= ", $authoremail";
		}
	$action = "Comment added";
	$message = "AJ-Fork Mailing System Plugin\r\n\r\n$name added a comment for article $title @ $humandate. Content follows:\r\n\r\n\t$comments";
	$subject = str_replace("{mailuser}",$name,$subject);
break;
	}
$subject = str_replace("{maildate}",$humandate,$subject);
mail($to, "$subject", "$message", $headers);
}
?>
