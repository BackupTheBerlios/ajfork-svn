<?php
function dir_recurse($dirName) {
	$dirHandle = opendir($dirName);
	while ($currFile = readdir($dirHandle)) {
		if ($currFile == '.' or
			$currFile == '..' or
			$dirName == '.' and
			$currFile == 'listhooks.php') {

		    continue;
		}
		if (is_dir($dirName.'/'.$currFile)) {
		    dir_recurse($dirName.'/'.$currFile);
		} else {
			$matches = preg_grep('#(run_filters|run_actions)\\(\'(.*?)\'#i', file($dirName.'/'.$currFile));
//			echo $dirName,'\\',$currFile,' :: ';
//			echo count($matches),' matches found.<br />';
			if (count($matches) > 0) {
				foreach ($matches as $lineNr => $lineContents) {
					$GLOBALS['hooks'][$dirName.'/'.$currFile][$lineNr] = $lineContents;
				}
			}
		}
	}
}
dir_recurse('.');

echo '<pre>';
foreach ($hooks as $currFileName => $currFileMatches) {
	echo '<h1>',$currFileName,'</h1><ul>';
	foreach ($currFileMatches as $currMatchLineNr => $currMatchLineContents) {
		preg_match('#run_(filter|action)s\\(\'(.*?)\'#i', $currMatchLineContents, $match);
		echo '<li>',str_pad($currMatchLineNr,5,' '),' | ',str_pad($match[1],8,' '),' | ','<strong>',str_pad($match[2],35,' '),'</strong>',' | ',$currMatchLineContents,'</li>';
		$totalHooks++;
	}
	echo '</ul>';
}
echo '</pre>';

echo $totalHooks.' hooks total';
?>