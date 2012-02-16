<?php

	$basestart = strpos(__FILE__, 'wp-content/');
	$basepath = substr(__FILE__, 0, $basestart);
	$wp_load = $basepath . 'wp-load.php';
	$wp_conf = $basepath . 'wp-config.php';
	if(file_exists($wp_load)) include_once($wp_load);
	elseif(file_exists($wp_conf)) include_once($wp_conf);
	else die();
	
	// Define the field ID
	if(eregi("^[0-9]+$", trim($_GET['fieldid']))) 
		$field_id = trim($_GET['fieldid']);
	else
		die();
		
	session_start();
	
	$sql = "SELECT * FROM " . FORMBUILDER_TABLE_FIELDS . " WHERE id = '" . $_GET['fieldid'] . "';";
	$results = $wpdb->get_results($sql, ARRAY_A);
	$field = $results[0];

	$field['value'] = trim($_GET['val']);


	if(!formbuilder_validate_field($field))
	{
		$error_msg = $field['error_message'];
		$post_errors = true;
	}

	if(isset($error_msg)) {
		echo "<div class='formBuilderError'>$error_msg</div>";
	}
	else
		echo "";
