<?php

/*
Plugin Name:	Auto Archive
Description:	Automatically creates an archive at the beginning of every month.
Version:		1.0
Author:			David Carrington
Author URI:		http://www.brandedthoughts.co.uk
Application:	CuteNews
Required Framework: 1.1.1
*/

// Define some date constants - do not edit these!
define('AA_HOURLY', 'H');
define('AA_DAILY', 'd');
define('AA_WEEKLY', 'W');
define('AA_MONTHLY', 'm');
define('AA_YEARLY', 'Y');


# === USER OPTIONS ===

// Define how often the archives will be made (see constants above)
define('AA_OCCURENCE', AA_MONTHLY);

// Define where the archives will be saved
define('AA_ARCHIVE_FOLDER', ROOTPATH.'/data/archives/');

# === END USER OPTIONS ===


// Run the aa_CheckArchive() function for every page load
aa_CheckArchive();

function aa_CheckArchive() {
	global $config_date_adjust;
	
	// Get the current time/date
	$now = time();
	
	// Load all the plugin settings
	$aa = new PluginSettings('Auto_Archive');
	
	// Find the "last archive" time
	$last_archive = (int) $aa->settings['last_archive'];
	
	// Check if this is the first time it has been run
	if ($last_archive == 0) {
		// Set the new "last archive" time
		$aa->settings['last_archive'] = $now;

		// Save the plugin settings
		$aa->save();
	}
	
	// Check if an archive is needed
	if (date(AA_OCCURENCE, $last_archive) != date(AA_OCCURENCE, $now)) {
		// Create an archive
		aa_CreateArchive($now);
		
		// Set the new "last archive" time
		$aa->settings['last_archive'] = $now;
		
		// Save the plugin settings
		$aa->save();
	}
}

function aa_CreateArchive($time) {
	if(filesize(ROOTPATH.'/data/news.txt') == 0)
		return false;

	$archive_name = $time;

	if(!@copy(ROOTPATH.'/data/news.txt', AA_ARCHIVE_FOLDER.$archive_name.'.news.arch'))
		return false;
	if(!@copy(ROOTPATH.'/data/comments.txt', AA_ARCHIVE_FOLDER.$archive_name.'.comments.arch'))
		return false;

	@fclose(fopen(ROOTPATH.'/data/news.txt', 'w'));
	@fclose(fopen(ROOTPATH.'/data/comments.txt', 'w'));
	
	return true;
}

?>
