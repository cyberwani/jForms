<?php formbuilder_admin_nav('edit form'); ?>
<form name="form1" method="post" class="formBuilderForm" action="<?php echo FB_ADMIN_PLUGIN_PATH; ?>&fbaction=editForm&fbid=<?php echo $form_id; ?>">

	<h3 class="info-box-title"><?php _e('Form Details', 'formbuilder'); ?></h3>
	<fieldset class="options">
		<p><?php _e('You may use these controls to modify a form on your blog.', 'formbuilder'); ?></p>

		<table width="100%" cellspacing="2" cellpadding="5" class="widefat">
			<tr valign="top">
				<td>
					<h4><?php _e('Form controls', 'formbuilder'); ?>:</h4>
	
					<script type="text/javascript">
					
						function toggleVis(boxid)
						{
							if(document.getElementById(boxid).isVisible == "true")
							{
								toggleVisOff(boxid);
							}
							else
							{
								toggleVisOn(boxid);
							}
						}
						
						function toggleVisOn(boxid) 
						{
								document.getElementById(boxid).setAttribute("class", "formBuilderHelpTextVisible");
								document.getElementById(boxid).isVisible = "true";
						}
						
						function toggleVisOff(boxid) 
						{
								document.getElementById(boxid).setAttribute("class", "formBuilderHelpTextHidden");
								document.getElementById(boxid).isVisible = "false";
						}
		
					</script>


		
					<?php $field = $fields['name']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Form name', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<input name='formbuilder[name]' 
								id='name' 
								type='text' 
								size='50' 
								maxlength='255' 
								value='<?php echo htmlentities($field['Value'], ENT_QUOTES, get_option('blog_charset')); ?>' 
								alt='<?php _e('What do you want to call this contact form?', 'formbuilder'); ?>' 
								title='<?php _e('What do you want to call this contact form?', 'formbuilder'); ?>' />
						</span>
					</div>
					
					<?php $field = $fields['subject']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Subject', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<input name='formbuilder[subject]' 
								id='subject' 
								type='text' 
								size='50' 
								maxlength='255' 
								value='<?php echo htmlentities($field['Value'], ENT_QUOTES, get_option('blog_charset')); ?>' 
								alt='<?php _e('The subject line for the email you receive from the form.', 'formbuilder'); ?>' 
								title='<?php _e('The subject line for the email you receive from the form.', 'formbuilder'); ?>' />
						</span>
					</div>
					
					<?php $field = $fields['recipient']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Recipient', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<input name='formbuilder[recipient]' 
								id='recipient' 
								type='text' 
								size='50' 
								maxlength='255' 
								value='<?php echo htmlentities($field['Value'], ENT_QUOTES, get_option('blog_charset')); ?>' 
								alt='<?php _e('What email address should the data from this contact form be mailed to?', 'formbuilder'); ?>' 
								title='<?php _e('What email address should the data from this contact form be mailed to?', 'formbuilder'); ?>' /></span>
					</div>
					
					<?php $field = $fields['method']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Method', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<select name='formbuilder[method]' 
								id='method' 
								alt='<?php _e('How should this form post data?  If you are unsure, leave it on POST', 'formbuilder'); ?>' 
								title='<?php _e('How should this form post data?  If you are unsure, leave it on POST', 'formbuilder'); ?>'>
								<option value='POST' <?php if($field['Value'] == 'POST') { echo 'selected'; } ?>>POST</option>
								<option value='GET' <?php if($field['Value'] == 'GET') { echo 'selected'; } ?>>GET</option>
							</select>
						</span>
					</div>
					
					<?php $field = $fields['action']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Action', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<select name='formbuilder[action]' 
								id='action' 
								alt='<?php _e('You may specify an alternate form processing system if necessary.  If you are unsure, leave it alone.', 'formbuilder'); ?>' 
								title='<?php _e('You may specify an alternate form processing system if necessary.  If you are unsure, leave it alone.', 'formbuilder'); ?>'>
								<?php
								if(file_exists(FORMBUILDER_PLUGIN_PATH . "/modules"))
								{
									$field['options'] = array( ''=>'Convert form results into an email.');
									$d = dir(FORMBUILDER_PLUGIN_PATH . "/modules");
									while (false !== ($entry = $d->read())) {
									   if($entry != "." AND $entry != "..") {
									   	$module_filename = FORMBUILDER_PLUGIN_PATH . "/modules/$entry";
									   	if(!is_file($module_filename)) continue;
									   	$module_data = implode("", file($module_filename));
				
									   	if(eregi("\n\w*name\: ([^\r\n]+)", $module_data, $regs)) {
									   		$module_name = $regs[1];
									   	} else {
									   		$module_name = $entry;
									   	}
									   	$field['options'][$entry] = $module_name;
									   	
									   	if(eregi("\n\w*instructions\: ([^\r\n]+)", $module_data, $regs)) {
									   		$module_instructions = "\\n\\n" . addslashes($regs[1]);
									   	} else {
									   		$module_instructions = "";
									   	}
									   	$field['HelpText'] .= $module_instructions;
									   	
									   }
									}
									$d->close();
									asort($field['options']);
								
									foreach($field['options'] as $entry=>$module_name)
									{
										if($field['Value'] == $entry) $selected = 'selected';
										else $selected = '';
									   	echo "<option value='{$entry}' {$selected}>{$module_name}</option>\n";
									}
								}
								?>
								
							</select>
						</span>
					</div>
					
					<?php $field = $fields['thankyoutext']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Thank you text', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<textarea name='formbuilder[thankyoutext]' 
								id='thankyoutext' 
								cols='52' rows='2' 
								alt='<?php _e('What message would you like to show your visitors?', 'formbuilder'); ?>' 
								title='<?php _e('What message would you like to show your visitors?', 'formbuilder'); ?>'
								><?php echo htmlentities($field['Value'], ENT_QUOTES, get_option('blog_charset')); ?></textarea>
						</span>
					</div>
					
					<!--<?php $field = $fields['autoresponse']; ?>
					<div style='padding: 1px 0 2px 20px;'>
						<span class='formbuilderLabel'><?php _e('Autoresponse', 'formbuilder'); ?>: </span>
						<span class='formbuilderField'>
							<select name='formbuilder[autoresponse]' 
								id='autoresponse' 
								alt='<?php _e('You may specify an autoresponse to send back if necessary.', 'formbuilder'); ?>' 
								title='<?php _e('You may specify an autoresponse to send back if necessary.', 'formbuilder'); ?>'>
								<option value=''></option>
								<?php
								$sql = "SELECT * FROM " . FORMBUILDER_TABLE_RESPONSES . " ORDER BY name ASC;";
								$response_ids = $wpdb->get_results($sql, ARRAY_A);
								if($response_ids) 
								{
									foreach($response_ids as $response_data)
									{
										if($field['Value'] == $response_data['id']) $selected = 'selected';
										else $selected = '';
										echo "<option value='{$response_data['id']}' $selected>{$response_data['name']}</option>";
									}
								}
								?>
							</select>
						</span>
					</div>-->
					
					<?php
						// Tag display and customization.
						$tags = array();
						$sql = "SELECT * FROM " . FORMBUILDER_TABLE_TAGS . " WHERE form_id = '{$form_id}' ORDER BY tag ASC;";
						$results = $wpdb->get_results($sql, ARRAY_A);
						foreach($results as $r)
						{
							$tags[] = $r['tag'];
						}
						$tags = implode(', ', $tags);
					?>
					<div style="padding: 1px 0pt 2px 20px;">
						<span class="formbuilderLabel"><?php _e('Tags', 'formbuilder'); ?>: </span>
						<span class="formbuilderField">
							<input type='text' name='formbuilder[tags]' id='tags'
								title	= '<?php _e('Add optional tags to the form separated by commas.', 'formbuilder'); ?>'
								alt		= '<?php _e('Add optional tags to the form separated by commas.', 'formbuilder'); ?>' 
								value	= '<?php echo $tags; ?>' />
						</span> 
					</div>
					
					
					
				
				</td>
			</tr>
			
			<tr valign="top">
				<td>
					<input type="submit" name="Save" value="<?php _e('Save Form', 'formbuilder'); ?>">
				</td>
			</tr>
			
			<tr valign="top">
				<td>
				<h4><?php _e('Fields', 'formbuilder'); ?>:</h4>
				
				<?php
					$sql = "SELECT * FROM " . FORMBUILDER_TABLE_FIELDS . " WHERE form_id = $form_id ORDER BY display_order ASC;";
					$related = $wpdb->get_results($sql, ARRAY_A);
					if($related)
					{
						$counter = 0;
						foreach($related as $fields)
						{
							$counter++;
							
							?>
							<p style='background-color: #E5F3FF;'>
								<a name='field_<?php echo $fields['id']; ?>'></a>
								<?php printf(__('Field #%d Options', 'formbuilder'), $counter); ?>: 
								<input type='submit' name='fieldAction[<?php echo $fields['id']; ?>]' value='Add Another' title='<?php _e('Add another field where this one is now.', 'formbuilder'); ?>'>
								<input type='submit' name='fieldAction[<?php echo $fields['id']; ?>]' value='Delete' title='<?php _e('Delete this field.', 'formbuilder'); ?>'>
								<input type='submit' name='fieldAction[<?php echo $fields['id']; ?>]' value='Move Up' title='<?php _e('Move this field up one.', 'formbuilder'); ?>'>
								<input type='submit' name='fieldAction[<?php echo $fields['id']; ?>]' value='Move Down' title='<?php _e('Move this field down one.', 'formbuilder'); ?>'>
							</p>
		
							<?php
								$key = 'field_type';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Type', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<select name='formbuilderfields[<?php echo $fields['id']; ?>][field_type]' 
										id='field_type' 
										alt='<?php _e('Select the type of field that you wish to have shown in this location.', 'formbuilder'); ?>' 
										title='<?php _e('Select the type of field that you wish to have shown in this location.', 'formbuilder'); ?>'>
										<?php 
											$help_text_html = "";
											$field_types = formbuilder_get_field_types();
											foreach($field_types as $field_type=>$help_text)
											{
												if($fields[$key] == $field_type) $selected = "selected";
												else $selected = "";
												echo "\n<option value='{$field_type}' $selected>{$field_type}</option>";
												$help_text_html .= "<strong>{$field_type}:</strong> {$help_text}<br/>\n";
											}
										?>
									</select>
								</span>
							</div>
							
					
							<?php
								$key = 'field_name';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Name', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<input name='formbuilderfields[<?php echo $fields['id']; ?>][field_name]' 
										id='field_name' 
										type='text' 
										size='50' 
										maxlength='255' 
										value='<?php echo htmlentities($fields[$key], ENT_QUOTES, get_option('blog_charset')); ?>' 
										alt='<?php _e('Enter a name for this field.  Should be only letters and underscores.', 'formbuilder'); ?>' 
										title='<?php _e('Enter a name for this field.  Should be only letters and underscores.', 'formbuilder'); ?>' />
								</span>
							</div>
							
							
							<?php
								$key = 'field_value';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Value', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<textarea name='formbuilderfields[<?php echo $fields['id']; ?>][field_value]' 
										id='field_value' 
										cols='52' 
										rows='2' 
										alt='<?php _e('If necessary, enter a predefined value for the field.', 'formbuilder'); ?>' 
										title='<?php _e('If necessary, enter a predefined value for the field.', 'formbuilder'); ?>'
										><?php echo htmlentities($fields[$key], ENT_QUOTES, get_option('blog_charset')); ?></textarea>
								</span>
							</div>
							
							
							<?php
								$key = 'field_label';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Label', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<input name='formbuilderfields[<?php echo $fields['id']; ?>][field_label]' 
										id='field_label' 
										type='text' 
										size='50' 
										maxlength='255' 
										value='<?php echo htmlentities($fields[$key], ENT_QUOTES, get_option('blog_charset')); ?>' 
										alt='<?php _e('The label you want to have in front of this field.', 'formbuilder'); ?>' 
										title='<?php _e('The label you want to have in front of this field.', 'formbuilder'); ?>' />
								</span>
							</div>
							
							
							<?php
								$key = 'required_data';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Validation', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<select name='formbuilderfields[<?php echo $fields['id']; ?>][required_data]' 
										id='required_data' 
										alt='<?php _e('If you want this field to be required, select the type of data it should look for.', 'formbuilder'); ?>' 
										title='<?php _e('If you want this field to be required, select the type of data it should look for.', 'formbuilder'); ?>'>
										<option value=''></option>
										<?php
											$help_text_html = "";
											$requiredTypes = formbuilder_get_required_types();
											foreach($requiredTypes as $required_type=>$help_text)
											{
												if($fields[$key] == $required_type) $selected = "selected";
												else $selected = "";
												echo "\n<option value='{$required_type}' $selected>{$required_type}</option>";
												$help_text_html .= "<strong>{$required_type}:</strong> {$help_text}<br/>\n";
											}
										?>
									</select>
								</span>
							</div>
							
							
							<?php
								$key = 'error_message';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Error message', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<input name='formbuilderfields[<?php echo $fields['id']; ?>][error_message]' 
										id='error_message' 
										type='text' 
										size='50' 
										maxlength='255' 
										value='<?php echo htmlentities($fields[$key], ENT_QUOTES, get_option('blog_charset')); ?>' 
										alt='<?php _e('The error message to be displayed if the required field is not filled in.', 'formbuilder'); ?>' 
										title='<?php _e('The error message to be displayed if the required field is not filled in.', 'formbuilder'); ?>' />
								</span>
							</div>
							
							
							<?php
								$key = 'help_text';
								if(isset($_POST['formbuilder'][$key]))
									$fields[$key] = $_POST['formbuilder'][$key];
							?>
							<!--<div style='padding: 1px 0 2px 20px;'>
								<span class='formbuilderLabel'><?php _e('Help text', 'formbuilder'); ?>: </span>
								<span class='formbuilderField'>
									<textarea name='formbuilderfields[<?php echo $fields['id']; ?>][help_text]' 
										id='help_text' cols='52' rows='2' 
										alt='<?php _e('The message to be shown in case the user needs additional help with filling out the field.', 'formbuilder'); ?>' 
										title='<?php _e('The message to be shown in case the user needs additional help with filling out the field.', 'formbuilder'); ?>'
										><?php echo htmlentities($fields[$key], ENT_QUOTES, get_option('blog_charset')); ?></textarea>
								</span>
							</div>
							
							
							<br/>-->
							&nbsp;
												
												
							<?php
							
						}

					}
				?>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<input type='submit' name='fieldAction[newField]' value='<?php _e('Add New Field', 'formbuilder'); ?>'>
					<input type="submit" name="Save" value="<?php _e('Save', 'formbuilder'); ?>">
				</td>
			</tr>
		</table>

	</fieldset>

</form>
