<h1>Convert users database - Only do this once!</h1>
<pre>
<?php
$userdb = file_get_contents("./data/users.db.php") or die("<b>Could not open data from users.db.php</pre>");
echo "Opened data from users.db.php\r\n\r\n";
$userdb = str_replace("\r", "", $userdb);
$userdb = explode("\n", $userdb);
foreach ($userdb as $index => $userinfostring) {
	if (!is_numeric($userinfostring[0])) {
		echo "<b>Removed:</b>   " . htmlentities($userinfostring) . "\r\n";
		unset($userdb[$index]);
	    continue;
	}
	$userinfo = explode("|", $userinfostring);
	$userinfo[3] = md5($userinfo[3]);
	$userdb[$index] = implode("|", $userinfo);
	echo "<b>Converted:</b> " . htmlentities($userinfostring) . "\r\n";
}
$userdb = implode("\r\n", $userdb);
$userdb = "<?PHP die(\"You don't have access to open this file.\"); ?>\r\n" . $userdb;

echo "\r\n<b>End Results:</b>\r\n" . htmlentities($userdb);

if ($fh = fopen("./data/users.db.php", "w+")) {
	fwrite($fh, $userdb);
	fclose($fh);
	echo "\r\n\r\nSaved data to users.db.php\r\n\r\nEverything succeeded, the user database is now converted.";
} else {
	echo "\r\n\r\n<b>Could not save data to users.db.php!</b> Copy the &quot;End Results&quot; to the ./data/users.db.php file manually.";
}
@rename("md5_convert.php", "md5_convert.php.disabled");
?>
<b>You should now delete this file for security reasons!</b>
</pre>