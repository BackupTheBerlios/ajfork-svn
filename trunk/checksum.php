<?php
$distsums = file('md5sums');
foreach ($distsums as $null => $distsum_line) {
	$distsum = trim(substr($distsum_line, 0, 32));
	$filetocheck = trim(substr($distsum_line, 34));
//	if ($filetocheck == "./md5sums") { continue; }
	$sumfound = md5_file($filetocheck);
	if ($sumfound == $distsum) { 
		$results[$filetocheck] = "OK";
		} 
	else { 
		$results[$filetocheck] = "FAIL";
		}

	}


foreach ($results as $file => $status) {
	if ($status == "FAIL") {
		echo "<span style=\"font-color: red\";>$file</span> is<strong> corrupt</strong>!<br />";
		}
}

?>
