<?php
define('ROOTPATH', $cutepath ? $cutepath : '.');
define('PLUGIN_SETTINGS_FILE', './saved.php');
/* File Functions */

function FileFolderList($path, $depth = 0, $current = '', $level=0) {
	if ($level==0 && !@file_exists($path))
		return false;
	if (is_dir($path)) {
		$handle = @opendir($path);
		if ($depth == 0 || $level < $depth)
			while($filename = @readdir($handle))
				if ($filename != '.' && $filename != '..')
					$current = @FileFolderList($path.'/'.$filename, $depth, $current, $level+1);
		@closedir($handle);
		$current[folder][] = $path.'/'.$filename;
	} else
		if (is_file($path))
			$current[file][] = $path;
	return $current;
}

function LoadArray($pathandfilename) {
	if (is_file($pathandfilename)) {
		@include($pathandfilename);
		return $array;
	}
	return array();
}

function WriteContents($contents,$filename) {
	if (file_exists($filename))
		if (!is_writable($filename))
			if (!chmod($filename, 0666))
				 return false;
	if (!$fp = @fopen($filename, 'wb+'))
		return false;
	if (@fwrite($fp, $contents) === false)
		return false;
	if (!@fclose($fp))
		return false;
	return true;
}

function GetContents($filename) {
	$file = @fopen($filename, 'rb');
	if ($file) {
		while (!feof($file)) $data .= fread($file, 1024);
		fclose($file);
	} else {
		return false;
	}
	return $data;
}

function SaveArray($array,$filename) {
	$contents = '<?php
$array = '. var_export($array,1) .';
?>';
	return WriteContents($contents, $filename);
}

/* Data Handling Classes */

class ArticleStorage {
	function ArticleStorage($plugin_name) {
		$this->name = $plugin_name;
		$this->all_settings = LoadArray("./data/articles.php");
		$this->settings = $this->all_settings[$plugin_name];
	}

	function save() {
		$this->all_settings[$this->name] = $this->settings;
		return SaveArray($this->all_settings, "./data/articles.php");
	}

	function delete($article_id) {
		unset($this->settings['articles'][$article_id]);
		return $this->save();
	}
	
	

}

class SettingsStorage {
	function SettingsStorage($plugin_name) {
		$this->name = $plugin_name;
		$this->all_settings = LoadArray("./data/settings.php");
		$this->settings = $this->all_settings[$plugin_name];
	}

	function save() {
		$this->all_settings[$this->name] = $this->settings;
		return SaveArray($this->all_settings, "./data/settings.php");
	}

	function delete($where, $id) {
		unset($this->settings[$where][$id]);
		return $this->save();
	}
}


function msg_status($message) {
		echo $message;
		}
		
function sanitize_variables($variable) {
		
		$search = array(
				"\"",
				"\'",
#				"'\t'",
				);
				
		$replace = array(
				"&quot;",
				"&#39;",
#				"",
				);

		$variable = str_replace($search, $replace, $variable);
		return $variable;
}

function urlTitle($title) {
	
    $title = strtolower($title);
    $title = str_replace("å", "aa", $title);
    $title = str_replace("ø", "o", $title);
    $title = str_replace("æ", "ae", $title);    
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = preg_replace('/[^a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', ' ', $title);
    $title = str_replace(' ', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');

    return $title;
	}

#
# Bad dropdown
#
function makeDropDown($options, $name, $selected="FALSE")
    {
		$output = "<select name=\"$name\">\r\n";

#	array_multisort($options, SORT_DESC, $options);
        foreach($options as $value => $description)
        {
          $output .= "<option value=\"$value\"";
          if($selected == $value){ $output .= " selected=\"selected\" "; }
          $output .= ">$description[name]</option>\n";
        }
		$output .= "</select>";
    	return $output;
    }

#
# Good dropdown
#

function htmldropdown($options, $name, $selected="FALSE")
    {
		$output = "<select size=1 name=\"$name\">\r\n";

	array_multisort($options, SORT_DESC, $options);
        foreach($options as $value=>$description)
        {
          $output .= "<option value=\"$value\"";
          if($selected == $value){ $output .= " selected "; }
          $output .= ">$description</option>\n";
        }
		$output .= "</select>";
    	return $output;
    }


/*
	Function: 	formatsize
	Description:	Properly formats the size of a file
	Credit:		Flexer
*/
function formatsize($file_size){
	if($file_size >= 1073741824)
		{$file_size = round($file_size / 1073741824 * 100) / 100 . "GB";}
    elseif($file_size >= 1048576)
    	{$file_size = round($file_size / 1048576 * 100) / 100 . "MB";}
    elseif($file_size >= 1024)
    	{$file_size = round($file_size / 1024 * 100) / 100 . "KB";}
    else{$file_size = $file_size . "b";}
return $file_size;
}


?>