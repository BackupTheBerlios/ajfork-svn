<?php

/**
 * md5 hash hasher :->
 * for use with cutenews aj-fork when upgrading from
 * versions below build 148
 *
 * @version 0000
 * @copyright 2004 
 **/

     echo "<div style=\"width: 400px;\">
     <h3>Upgrade aj-fork users.db.php</h3>
     <p>If you're upgrading from a version of the aj-fork older than build 148, 
	 you'll need to open users.db.php, get the password-hash for your user(s) and 
	 paste it into the form.</p>

	 <p>Then replace the old password-hash from users.db.php with the one this file outputs. 
	 -Do this for all users if you have more than one.</p>
	 
	 <p><form method=\"post\">
	 Old md5-hash: <input type=\"text\" name=\"hash\" size=\"40\"><br /><br />
	 <input type=\"submit\" value=\"Get new password-hash\">
	 </form>";
	 
	$hash == $GET_['hash'];
	
	if($hash == "") {
	echo "";
	} else {
	echo "<p>Your Hash:<br /><b>".md5($hash)."</b></p></div>";
	}
?>