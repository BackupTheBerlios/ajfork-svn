<?php

#
#	Users class
#

class KUsers {

#
#	We need
#
#	info()
#	verify()
#	add()
#	delete()
#	edit()

function connect() {
	$settingclass = new SettingsStorage('settings');
	return $settingclass;
}

function verify($gusername, $gpassword, $cookie=FALSE, $glanguage=FALSE) {
	$users = $settingclass->settings['users'];
	global $users, $configuration;
	
	$unique = UNIQUE;
	$unique_password = $gpassword . $unique;

	if (!$cookie) {
		$e_given = md5($gpassword);
		$e_given = sha1($e_given.$unique);
	}
	
	if ($cookie) {
		$e_given = sha1($gpassword.$unique);
		}
	
		
	foreach ($users as $user => $userdata) {
		if (urlTitle($gusername) == urlTitle($user)) {
			if ($e_given == $userdata[password]) {
				$return = array(
					"user" => $user,
					"nickname" => $userdata[nickname],
					"password" => $gpassword,
					"status" => "verified",
					"level" => $userdata[level],
					"language" => $glanguage,
					);
				}
			}
		}
				
	if (!$return) {
		$return = array(
			"user" => $gusername, 
			"password" => $gpassword,
			"status" => "unverified",
			"level" => 0,
			"language" => $glanguage,
			);
		}
	
	return $return;

}




















}
?>