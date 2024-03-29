<?php

	// Allow showing an alert to the user when necessary.
	function formbuilder_admin_alert($msg = '', $msg2 = '')
	{
		if($msg2 AND $msg) echo "<div class='updated'><p><strong>$msg</strong><br/>$msg2</p></div>";
		elseif($msg) echo "<div class='updated'><p><strong>$msg</strong></p></div>";
	}
	
	// Allow showing an alert to the user when necessary.
	function formbuilder_admin_warning($msg = '', $msg2 = '')
	{
		if($msg2 AND $msg) echo "<div class='error'><p><strong>$msg</strong><br/>$msg2</p></div>";
		elseif($msg) echo "<div class='error'><p><strong>$msg</strong></p></div>";
	}

	function formbuilder_admin_css()
	{
		?>
		<link rel='stylesheet' href='<?php echo FORMBUILDER_PLUGIN_URL; ?>css/admin.css' type='text/css' media='all' />
		<?php
	}

	function formbuilder_options_page($action=""){
		global $wpdb, $formbuilder_admin_nav_options;
		
		$version = get_option('formbuilder_version');

		// Determine and set path to current formbuilder page.
		$path = $_SERVER['REQUEST_URI'];
		
		$path_length = strpos($path, FORMBUILDER_FILENAME) + strlen(FORMBUILDER_FILENAME);
		
		$path = substr($path, 0, strpos($path, '?')) . '?page=' . FORMBUILDER_FILENAME;

		define("FB_ADMIN_PLUGIN_PATH", $path);

		if($version != FORMBUILDER_VERSION_NUM)
		{	// FormBuilder is NOT set up correctly with the proper version number.  Rerun the activation script.
			formbuilder_activation();
		}

		$version = get_option('formbuilder_version');
		
		$formbuilder_admin_nav_options = array();
		if(formbuilder_user_can('create')) $formbuilder_admin_nav_options['forms'] = __("Forms", 'formbuilder');

		?>


		<div id="icon-tools" class="icon32"><br></div>
		<div class="wrap">
			<h2><?php _e('jForms', 'formbuilder'); ?></h2>
		<?php
		
		$problemThemes = array(
			'Thesis',
		);
		$theme_name = get_current_theme();
		if(array_search($theme_name, $problemThemes) !== false)
			formbuilder_admin_warning(sprintf(__("WARNING: FormBuilder has known compatibility issues with the '%s' theme.", 'formbuilder'), $theme_name));
		
		if(!isset($_GET['fbaction'])) $_GET['fbaction'] = false;
		switch($_GET['fbaction']) {

			case "newForm":
				formbuilder_options_newForm();
			break;

			case "editForm":
				formbuilder_options_editForm($_GET['fbid']);
			break;

			case "editFormObject":
				formbuilder_options_editFormObject($_GET['fbid']);
			break;

			case "copyForm":
				formbuilder_options_copyForm($_GET['fbid']);
			break;

			case "removeForm":
				formbuilder_options_removeForm($_GET['fbid']);
			break;

			case "newResponse":
				formbuilder_options_newResponse();
			break;

			case "editResponse":
				formbuilder_options_editResponse($_GET['fbid']);
			break;

			case "copyResponse":
				formbuilder_options_copyResponse($_GET['fbid']);
			break;

			case "removeResponse":
				formbuilder_options_removeResponse($_GET['fbid']);
				formbuilder_options_default();
			break;

			case "formResults":
				if(!isset($results_page)) $results_page = new formbuilder_xml_db_results();
				$results_page->show_adminpage();
			break;

			case "uninstall":
				if(!isset($_GET['confirm']))
					formbuilder_cleaninstall(false);
				else
					formbuilder_cleaninstall($_GET['confirm']);
			break;
			
			case "settings":
				formbuilder_options_settings();
			break;
			
			case "strings":
				formbuilder_options_strings();
			break;

			case "forms":
			default:
				if(!formbuilder_user_can('connect') AND formbuilder_user_can('manage'))
					formbuilder_options_settings();
				else
					formbuilder_options_default();
			break;

		}
		?>

		</div>

		<?php

	}

	function formbuilder_admin_nav($selected = 'forms')
	{
		global $formbuilder_admin_nav_options;
		?>
		<?php if(isset($_GET['fbmsg']) AND $_GET['fbmsg'] != "") formbuilder_admin_alert(stripslashes($_GET['fbmsg'])); ?>
<div class="formbuilder-subnav">
	<ul class="subsubsub">
		<?php foreach( $formbuilder_admin_nav_options as $key=>$value ) { ?>
		<li><a <?php if($selected == $key) { ?>class="current"<?php } ?> href="<?php echo FB_ADMIN_PLUGIN_PATH; ?>&fbaction=<?php echo $key; ?>"><?php echo $value; ?></a></li>
		<?php } ?>
	</ul>
</div>
		<?php
	}