<?php

	$basestart = strpos(__FILE__, 'wp-content');
	$basepath = substr(__FILE__, 0, $basestart);
	$wp_load = $basepath . 'wp-load.php';
	$wp_conf = $basepath . 'wp-config.php';

	if(file_exists($wp_load)) include_once($wp_load);
	elseif(file_exists($wp_conf)) include_once($wp_conf);
	else die("Unable to include WordPress configuration files.");

	// Ensure that only editors or higher can access this page.
	get_currentuserinfo() ;
	global $user_level;

	if ($user_level >= 7 OR $userdata->wp_capabilities['administrator'] == 1) {
		include(FORMBUILDER_PLUGIN_PATH . "extensions/formbuilder_xml_db_results.class.php");
		if(!isset($fb_xml_stuff)) $fb_xml_stuff = new formbuilder_xml_db_results();
		$fb_xml_stuff->export_csv();
	}
	else
		die(__("You must be logged in as an editor or higher to access this page.", 'formbuilder'));
	
?>