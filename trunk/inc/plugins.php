<?php

define('ROOTPATH', $cutepath ? $cutepath : '.');
define('CURRENT_APPLICATION', 'CN:AJ');

define('ACTIVE_PLUGINS_FILE', ROOTPATH.'/data/active-plugins.php');
define('PLUGINS_DIRECTORY', ROOTPATH.'/plugins');
define('PLUGINS_DATA_DIRECTORY', ROOTPATH.'/data/plugins');
define('PLUGIN_SETTINGS_FILE', PLUGINS_DATA_DIRECTORY.'/settings.php');
define('PLUGIN_XFIELDS_FILE', PLUGINS_DATA_DIRECTORY.'/xfields-data.php');
define('PLUGIN_FRAMEWORK_VERSION', '1.1.5');
define('PLUGIN_DEFAULT_PRIORITY', 50);


function LoadActivePlugins() {
	foreach (active_plugins() as $plugin_filename => $active) {
		$path = PLUGINS_DIRECTORY.'/'.$plugin_filename;
		if (is_file($path))
			include($path);
		else
			disable_plugin($plugin_filename);
	}
}

function plugin_enabled($plugin_filename) {
	$plugins = active_plugins();
	if ($plugins[$plugin_filename])
		return true;
	else
		return false;
}

function enable_plugin($plugin_filename) {
	$plugins = active_plugins();
	$plugins[$plugin_filename] = true;
	SaveArray($plugins, ACTIVE_PLUGINS_FILE);

}

function disable_plugin($plugin_filename) {
	$plugins = active_plugins();
	unset($plugins[$plugin_filename]);
	SaveArray($plugins, ACTIVE_PLUGINS_FILE);
}



/* List Plugins */

function available_plugins() {
	$ffl = FileFolderList(PLUGINS_DIRECTORY,1);
	$plugins = $ffl[file];
	if (!empty($plugins))
		foreach ($plugins as $null => $pluginfile) {
			if (stristr($pluginfile, ".htaccess")) { continue; }
			
			$plugin_data = GetContents($pluginfile);
			preg_match("{Plugin Name:(.*)}i", $plugin_data, $plugin[name]);
			preg_match("{Plugin URI:(.*)}i", $plugin_data, $plugin[uri]);
			preg_match("{Description:(.*)}i", $plugin_data, $plugin[description]);
			preg_match("{Author:(.*)}i", $plugin_data, $plugin[author]);
			preg_match("{Author URI:(.*)}i", $plugin_data, $plugin[author_uri]);
			preg_match("{Version:(.*)}i", $plugin_data, $plugin[version]);
			preg_match("{Application:(.*)}i", $plugin_data, $plugin[application]);
			preg_match("{Conflicts:(.*)}i", $plugin_data, $plugin[conflicts]);
			preg_match("{Required Framework:(.*)}i", $plugin_data, $plugin[framework]);

			$required_version = trim($plugin[framework][1]);
			$conflicts = trim($plugin[conflicts][1]);
			$application = trim($plugin[application][1]);

			// Skip plugins that need a better framework
			if ($required_version && version_compare(PLUGIN_FRAMEWORK_VERSION, $required_version, '<'))
				$compatible = false;
			else
				$compatible = true;
			
			if ($conflicts && in_array($conflicts, active_plugins()))
				$conflicting = true;
			else
				$conflicting = false;
				
			// Skip plugins designed for other systems
			if ($application && $application != 'CuteNews')
				continue;

			$available_plugins[] = array(
				name		=> trim($plugin[name][1]),
				uri		=> trim($plugin[uri][1]),
				description	=> trim($plugin[description][1]),
				author		=> trim($plugin[author][1]),
				author_uri	=> trim($plugin[author_uri][1]),
				version		=> trim($plugin[version][1]),
				application	=> trim($plugin[application][1]),
				file		=> basename($pluginfile),
				framework	=> $required_version,
				compatible	=> $compatible,
				conflicting => $conflicting,
			);
		}
	else
		$available_plugins = array();
	return $available_plugins;
}

function active_plugins() {
	if (!is_file(ACTIVE_PLUGINS_FILE))
		return array();

	$active_plugins = LoadArray(ACTIVE_PLUGINS_FILE);

	return $active_plugins;
}




/* Actions And Filters */

function add_action($hook, $functionname, $priority = PLUGIN_DEFAULT_PRIORITY) {
	global $actions;
	$actions[$hook][] = array(
		'name' => $functionname,
		'priority' => $priority,
	);
}

function run_actions($hookname) {
	global $actions;
	$todo = $actions[$hookname];
	if (!$todo)
		return false;
	usort($todo, 'SortByActionPriority');
	foreach ($todo as $null => $action)
		$buffer .= $action['name']($hookname);
	return $buffer;
}

function add_filter($hook, $functionname, $priority = PLUGIN_DEFAULT_PRIORITY) {
	global $filters;
	$filters[$hook][] = array(
		'name' => $functionname,
		'priority' => $priority,
	);
}

function run_filters($hookname, $tofilter) {
	global $filters;
	$todo = $filters[$hookname];
	if ($todo) {
		usort($todo, 'SortByActionPriority');
		foreach ($todo as $null => $filter)
			$tofilter = $filter['name']($tofilter, $hookname);
	}
	return $tofilter;
}

function SortByActionPriority($a, $b) {
	return $a[priority] > $b[priority] ? 1 : -1;
}


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

class PluginSettings {
	function PluginSettings($plugin_name) {
		$this->name = $plugin_name;
		$this->all_settings = LoadArray(PLUGIN_SETTINGS_FILE);
		$this->settings = $this->all_settings[$plugin_name];
	}

	function save() {
		$this->all_settings[$this->name] = $this->settings;
		return SaveArray($this->all_settings, PLUGIN_SETTINGS_FILE);
	}

	function delete() {
		unset($this->settings);
		return $this->save();
	}
}

class XFieldsData {
	function XFieldsData() {
		$this->file = PLUGIN_XFIELDS_FILE;
		$this->data = LoadArray(PLUGIN_XFIELDS_FILE);
	}

	function fetch($news_id, $field_name) {
		return $this->data[$news_id][$field_name];
	}

	function set($value, $news_id, $field_name) {
		$this->data[$news_id][$field_name] = $value;
	}

	function increment($news_id, $field_name) {
		return $this->data[$news_id][$field_name]++;
	}

	function decrement($news_id, $field_name) {
		return $this->data[$news_id][$field_name]--;
	}
	
	function delete($news_id) {
		unset($this->data[$news_id]);
	}

	function save() {
		return SaveArray($this->data, $this->file);
	}
}

/* XFields self-cleaning plugin */

add_action('deleted-single-entry', 'clean_single_xfields');
add_action('deleted-multiple-entries', 'clean_multiple_xfields');

function clean_single_xfields($hook) {
	global $old_db_arr;
	$news_id = $old_db_arr[0];
	$xfields = new XfieldsData();
	$xfields->delete($news_id);
	$xfields->save();	
}

function clean_multiple_xfields($hook) {
	global $selected_news;
	$xfields = new XfieldsData();
	foreach ($selected_news as $null => $news_id)
		$xfields->delete($news_id);
	$xfields->save();	
}

?>
