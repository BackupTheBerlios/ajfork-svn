<?php
$moduletitle = "Manage users";

if($_POST[adduser]) {

#
#	Add a new user (Routine)
#

	$now = time();
	$dataclass = new SettingsStorage('settings');
	$currentusers = $dataclass->settings['users'];
	
	

	# Remove unwanted stuff!
	$_POST[adduser][name] = sanitize_variables($_POST[adduser][name]);
	$_POST[adduser][password] = sanitize_variables($_POST[adduser][password]);
	
			$postaddpassu = $_POST[adduser][password].UNIQUE;
	$_POST[adduser][password] = sha1(md5($postaddpassu));
	
	$_POST[adduser][email] = sanitize_variables($_POST[adduser][email]);
	$_POST[adduser][url] = sanitize_variables($_POST[adduser][url]);
	$_POST[adduser][profile] = sanitize_variables($_POST[adduser][profile]);
	
	$adduserkey = urlTitle($_POST[adduser][name]);
	
	if (array_key_exists($adduserkey, $currentusers)) { 
		$statusmessage = "User &quot;$adduserkey&quot; already exists in the database!<br /><a href=\"javascript:history.go(-1);\">How about choosing another name?</a>";
		}
		
	# if the name is available
	else {
		$data = array(
		"registered"=> stripslashes($now),
		"nickname"	=> stripslashes($_POST[adduser][nickname]),
		"password" 	=> stripslashes($_POST[adduser][password]),
		"email" 	=> stripslashes($_POST[adduser][email]),
		"url" 		=> stripslashes($_POST[adduser][url]),
		"profile" 	=> stripslashes($_POST[adduser][profile]),
		"level"		=> stripslashes($_POST[adduser][level]),
		);
	
	$dataclass->settings['users'][$adduserkey] = $data;
	$dataclass->save();
	
	# Give the user a status message
	$statusmessage = "User &quot;$adduserkey&quot; successfully added";
	}
}


if($_POST[edituser]) {

#
#	Edit user (Routine)
#

	$now = time();
	$dataclass = new SettingsStorage('settings');
	$currentusers = $dataclass->settings['users'];
	
	

	# Remove unwanted stuff!
	$_POST[edituser][name] = sanitize_variables($_POST[edituser][name]);
	$_POST[edituser][password] = sanitize_variables($_POST[edituser][password]);
		
	$_POST[edituser][email] = sanitize_variables($_POST[edituser][email]);
	$_POST[edituser][url] = sanitize_variables($_POST[edituser][url]);
	$_POST[edituser][profile] = sanitize_variables($_POST[edituser][profile]);
	
	$adduserkey = urlTitle($_POST[edituser][name]);
	
	if (!array_key_exists($adduserkey, $currentusers)) { 
		$statusmessage = "User &quot;$adduserkey&quot; does not exist.<br /><a href=\"javascript:history.go(-1);\">How about choosing another name?</a>";
		}
		
	# if the name is available
	else {
	
		$olduser = $currentusers[$adduserkey];
		# has the password changed?
		
		if ($_POST[edituser][password] != "") {
			$postaddpassu = $_POST[edituser][password].UNIQUE;
			$_POST[edituser][password] = sha1(md5($postaddpassu));
			$passchange = "y";
			}
		# guess not
		else {
			$_POST[edituser][password] = $olduser[password];
			}
				
		$data = array(
		"registered"=> stripslashes($olduser[registered]),
		"nickname"	=> stripslashes($_POST[edituser][nickname]),
		"password" 	=> stripslashes($_POST[edituser][password]),
		"email" 	=> stripslashes($_POST[edituser][email]),
		"url" 		=> stripslashes($_POST[edituser][url]),
		"profile" 	=> stripslashes($_POST[edituser][profile]),
		"level"		=> stripslashes($_POST[edituser][level]),
		);
	
	$dataclass->settings['users'][$adduserkey] = $data;
	$dataclass->save();
	
	# Give the user a status message
	$statusmessage = "User &quot;$adduserkey&quot; edited";
	if ($passchange == "y") {
		$statusmessage = "User &quot;$adduserkey&quot; edited - password changed";
		}
	}
}

if($_GET[edit] && !$_POST[edituser] && !$_GET[action]) {

#
#	Edit a user
#

	$now = time();
	$dataclass = new SettingsStorage('settings');
	$currentusers = $dataclass->settings['users'];
	
	$usertoedit = urlTitle($_GET[edit]);
	if (array_key_exists($usertoedit, $currentusers)) {
		$userkey = $usertoedit;
		$usertoedit = $currentusers[$userkey];

		$main_content = '
		<div id="manage_users_main" style="float: left; width: 80%;"><h2>Edit <u>'.$userkey.'</u> ('.$usertoedit[nickname].')</h2>
		<form id="edit_user_form" class="cpform" method="post">
		<input type="hidden" name="panel" value="users" />
		<input type="hidden" name="edituser[name]" value="'.$userkey.'" />
		<p><select name="edituser[level]">';
		
	if($usertoedit[level] == 4){$main_content .= ' <option value="4" selected="selected">Admin</option>';}
		else {$main_content .= ' <option value="4">Admin</option>';}
	if($usertoedit[level] == 3){$main_content .= ' <option value="3" selected="selected">Editor</option>';}
		else {$main_content .= ' <option value="3">Editor</option>';}
	if($usertoedit[level] == 2){$main_content .= ' <option value="2" selected="selected">Journalist</option>';}
		else {$main_content .= ' <option value="2">Journalist</option>';}
	if($usertoedit[level] == 1){$main_content .= ' <option value="1" selected="selected">Commenter</option>';}
		else {$main_content .= ' <option value="1">Commenter</option>';}
		
		
		$main_content .='
		</select></p><p><input type="text" id="edit_user_nname" name="edituser[nickname]" value="'.$usertoedit[nickname].'" /><label for="edit_user_nname">Nickname</label></p>
		<p><input type="text" id="edit_user_password" name="edituser[password]" /><label for="edit_user_password">Password</label></p>
		<p><input type="text" id="edit_user_email" name="edituser[email]" value="'.$usertoedit[email].'" /><label for="edit_user_email">Email</label></p>
		<p><input type="text" id="edit_user_url" name="edituser[url]" value="'.$usertoedit[url].'" /><label for="edit_user_url">Website</label></p>
		<p><label for="edit_user_profile">Profile</label><br /><textarea id="edit_user_profile" name="edituser[profile]">'.$usertoedit[profile].'</textarea></p>
		<p><input type="submit" value="Save changes" /></p>
		</form></div><div style="float: right;"><p>Extended options</p></div>';
		}
	
	else {
	
		$statusmessage = "User &quot;$usertoedit&quot; does not exist in the database";
		}
}

#
#	Display add user form and current users
#
if (!$_POST[adduser] && !$_GET[edit]) {

	$dataclass = new SettingsStorage('settings');
	$currentusers = $dataclass->settings['users'];
	
	$leveltotext = array(
		4 => "Admin",
		3 => "Editor",
		2 => "Journalist",
		1 => "Commenter",
		);

	$main_content = '
	<div id="manage_users_main" style="float: left; width: 80%;"><h2>Add user</h2>
	<form id="add_user_form" class="cpform" method="post">
	<input type="hidden" name="	panel" value="users" />
	<p><label for="add_user_name">Name</label><br /><input type="text" id="add_user_name" name="adduser[name]" /> 
	<select id="add_user_level" name="adduser[level]">
		<option value="4">Admin</option>
		<option value="3">Editor</option>
		<option value="2">Journalist</option>
		<option value="1">Commenter</option>
	</select> <label for="add_user_level">Access level</label></p>
	<p><input type="text" id="add_user_nname" name="adduser[nickname]" /><label for="add_user_nname">Nickname</label></p>
	<p><input type="text" id="add_user_password" name="adduser[password]" /><label for="add_user_password">Password</label></p>
	<p><input type="text" id="add_user_email" name="adduser[email]" /><label for="add_user_email">Email</label></p>
	<p><input type="text" id="add_user_url" name="adduser[url]" /><label for="add_user_url">Website</label></p>
	<p><label for="add_user_profile">Profile</label><br /><textarea id="add_user_profile" name="adduser[profile]"></textarea></p>
	<p><input type="submit" value="Add user" /></p>
	</form>
	
	<h2>Currently registered users</h2>
	<table><thead><th>Username</th><th>Level</th><th>Registration date</th><th>Articles</th><th>Actions</th></thead>';
	
	foreach ($currentusers as $username => $userdata) {
		$level = $userdata[level];
		$level = $leveltotext[$level];
		$main_content .= "<tr><form method=\"get\"><input type=\"hidden\" name=\"panel\" value=\"users\" /><input type=\"hidden\" name=\"edit\" value=\"$username\" /><td>$username</td><td>$level</td><td>$userdata[registered]</td><td></td><td><input type=\"submit\" value=\"Edit\" /><input type=\"submit\" name=\"action\" class=\"delete\" value=\"Delete\" /></td></form></tr>";
		}
	$main_content .='
	</table>
	</div><div style="float: right;"><p>Extended options</p></div>';
	
	}

#
#	Delete
#
if ($_GET[action] == "Delete") {

	$userkey = $_GET[edit];
	$dataclass = new SettingsStorage('settings');
	$users = $dataclass->settings['users'];
	
	$dataclass->delete("users", $userkey);
	
	$moduletitle = "Delete article";
	
	# Give the user a status message
	$statusmessage = "User &quot;$userkey&quot; dropped from database.";
	
}

?>