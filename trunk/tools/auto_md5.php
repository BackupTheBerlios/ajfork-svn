<?php

$userfile = 'data/users.db.php';

if (file_exists('data/users-md5')) {
	echo 'ERROR: It appears the encryption has already been performed';
	exit;
}

if ($action == 'hash') {
	$users = file($userfile);
	$firstline = 1;
	$out = '<?PHP die("You don\'t have access to open this file."); ?>'."\n";
	foreach ($users as $user) {
		if ($firstline) {
			unset($firstline);
		}else {
			list($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l) = explode('|',trim($user));
			$out .= $a.'|'.$b.'|'.$c.'|'.md5($d).'|'.$e.'|'.$f.'|'.$g.'|'.$h.'|'.$i.'|'.$j.'|'.$k.'|'.$l."\n";
			echo "<li>Done: {$c}".(($e) ? "(aka {$e})" : '')."</li>\n";
		}
	}
	if (WriteContents($out,$userfile)) {
		echo '<p style="color:green; font-weight: bold;">Success</p>';
		WriteContents('1','data/users-md5');
	} else {
		echo '<p style="color:red; font-weight: bold;">Creating the user file failed. Check permisions.</p>';
	}
	exit;
} else {
	echo '<p>This script will automatically perform the required double-md5 encrpytion required to complete the install of aj-blog.</p>
<p><a href="auto-md5-upgrade.php?action=hash">I understand and want to perform this action</a></p>';
	exit;
}


/* Binary safe file functions */

function WriteContents($contents,$filename) {
	if ($handle = fopen($filename, 'wb+'))
		fwrite($handle, $contents);
	else {
		return false;
	}
	return true;		
}


?>