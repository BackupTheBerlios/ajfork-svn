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

function getusers() {
	$settingclass = KUsers::connect();
	$users = $settingclass->settings['users'];
	return $users;
}

function collectlogin() {
	$checkpost = array();
	
	if ($_COOKIE[kusername] && $_COOKIE[kmd5password]) {
		$checkpost[username] = $_COOKIE[kusername];
		$checkpost[password] = $_COOKIE[kmd5password];
		$checkpost[logintype] = "cookie";
		}

	elseif ($_POST[username] && $_POST[password]) {
		$checkpost[username] = $_POST[username];
		$checkpost[password] = $_POST[password];
		$checkpost[logintype] = "standard";
		}
	
		if ($_COOKIE[klanguage]) {
			$checkpost[language] = $_COOKIE[klanguage];
			}
		elseif ($_POST[language]) {
			$checkpost[language] = $_POST[language];
			}
			
/*	$checkpost = array(
		"username" => $_POST[username],
		"password" => $_POST[password],
		"language" => $_POST[language],
		"cookiename" => $_COOKIE[kusername],
		"cookiepass" => $_COOKIE[kmd5password],
		"cookielang" => $_COOKIE[klanguage],
		);*/
		
	return $checkpost;
}

function verify() {
	$userdata = KUsers::collectlogin();
	
	if (!$userdata) { return false; }
	$users = KUsers::getusers();
	$unique = UNIQUE;
	$return = false;
	# $unique_password = $userdata[ . $unique;
	
	if ($userdata[logintype] == "standard") {
		$e_md5 = md5($userdata[password]);
		$e_given = sha1($e_md5.$unique);
	}
	else {
		$e_given = sha1($userdata[password].$unique);
		}
	
	foreach ($users as $thisuser => $thisuserdata) {
		if (urlTitle($userdata[username]) == urlTitle($thisuser)) {
			if ($e_given == $thisuserdata[password]) {
				$return = array(
					"user" => $thisuser,
					"nickname" => $thisuserdata[nickname],
					"status" => "verified",
					"level" => $thisuserdata[level],
					"language" => $userdata[language],
					"type" => $userdata[logintype],
					);
					
				if ($userdata[logintype] == "standard") {
					setcookie("kusername", $thisuser, time()+3600);
					setcookie("kmd5password", $e_md5, time()+3600);	
					setcookie("klanguage", $userdata[language]);
					}
			}
		}
	}
	
	return $return;
	}

function logout() {
	setcookie("kusername", "", time() - 3600);
	setcookie("kmd5password", "", time() - 3600);
	}
}
?>