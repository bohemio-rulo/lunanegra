<?php
//This file is used for Event Espresso 3.1.*
function espresso_calendar_add_to_featured_image_meta_box($event_meta) {
	$values = array(
			array('id' => true, 'text' => __('Yes', 'event_espresso')),
			array('id' => false, 'text' => __('No', 'event_espresso')));
	?>

<p>
	<label>
		<?php _e('Add image to event calendar', 'event_espresso'); ?>
	</label>
	<?php echo select_input('show_on_calendar', $values, isset($event_meta['display_thumb_in_calendar']) ? $event_meta['display_thumb_in_calendar'] : '', 'id="show_on_calendar"'); ?> </p>
<?php
}

add_action('action_hook_espresso_featured_image_add_to_meta_box', 'espresso_calendar_add_to_featured_image_meta_box');

function espresso_add_calendar_to_admin_menu($espresso_manager) {
	add_submenu_page('events', __('Event Espresso - Calendar Settings', 'event_espresso'), __('Calendar', 'event_espresso'), apply_filters('filter_hook_espresso_management_capability', 'administrator', $espresso_manager['espresso_manager_calendar']), 'espresso_calendar', 'espresso_calendar_config_mnu');
}

add_action('action_hook_espresso_add_new_submenu_to_group_settings', 'espresso_add_calendar_to_admin_menu', 5);

function espresso_calendar_config_mnu() {
	global $espresso_calendar, $notices, $espresso_premium;

	/* Calendar */
	function espresso_calendar_updated() {
		
	}

	if (isset($_POST['update_calendar']) && check_admin_referer('espresso_form_check', 'update_calendar')) {
		$espresso_calendar['espresso_page_post'] = isset($_POST['espresso_page_post']) ? $_POST['espresso_page_post'] : 'R';
		$espresso_calendar['espresso_calendar_header'] = isset($_POST['espresso_calendar_header']) ? $_POST['espresso_calendar_header'] : '';;
		$espresso_calendar['espresso_calendar_buttonText'] = isset($_POST['espresso_calendar_buttonText']) ? $_POST['espresso_calendar_buttonText'] : '';;
		$espresso_calendar['espresso_calendar_firstday'] = isset($_POST['espresso_calendar_firstday']) ? $_POST['espresso_calendar_firstday'] : '';;
		$espresso_calendar['espresso_calendar_weekends'] = isset($_POST['espresso_calendar_weekends']) ? $_POST['espresso_calendar_weekends'] : '';;
		$espresso_calendar['espresso_calendar_height'] = isset($_POST['espresso_calendar_height']) ? $_POST['espresso_calendar_height'] : '';;
		$espresso_calendar['enable_calendar_thumbs'] = isset($_POST['enable_calendar_thumbs']) ? $_POST['enable_calendar_thumbs'] : '';;
		$espresso_calendar['show_tooltips'] = isset($_POST['show_tooltips']) ? $_POST['show_tooltips'] : '';;
		$espresso_calendar['tooltips_pos']['my_1'] = isset($_POST['tooltips_pos_my_1']) ? $_POST['tooltips_pos_my_1'] : '';;
		$espresso_calendar['tooltips_pos']['my_2'] = isset($_POST['tooltips_pos_my_2']) ? $_POST['tooltips_pos_my_2'] : '';;
		$espresso_calendar['tooltips_pos']['at_1'] = isset($_POST['tooltips_pos_at_1']) ? $_POST['tooltips_pos_at_1'] : '';;
		$espresso_calendar['tooltips_pos']['at_2'] = isset($_POST['tooltips_pos_at_2']) ? $_POST['tooltips_pos_at_2'] : '';;
		$espresso_calendar['show_time'] = isset($_POST['show_time']) ? $_POST['show_time'] : '';;
		$espresso_calendar['throttle']['enable'] = isset($_POST['throttle_enable']) ? $_POST['throttle_enable'] : '';;
		$espresso_calendar['throttle']['amount'] = isset($_POST['throttle_amount']) ? $_POST['throttle_amount'] : '';;
		$espresso_calendar['disable_categories'] = isset($_POST['disable_categories']) ? $_POST['disable_categories'] : '';;
		$espresso_calendar['show_attendee_limit'] = isset($_POST['show_attendee_limit']) ? $_POST['show_attendee_limit'] : '';;
		$espresso_calendar['time_format'] = isset($_POST['time_format_custom']) ? $_POST['time_format_custom'] : '';;
		$espresso_calendar['espresso_use_pickers'] = isset($_POST['espresso_use_pickers']) ? $_POST['espresso_use_pickers'] : '';;
		$espresso_calendar['ee_event_background'] = (!empty($_POST['ee_event_background']) ) ? $_POST['ee_event_background'] : $espresso_calendar['ee_event_background'];
		$espresso_calendar['ee_event_text_color'] = (!empty($_POST['ee_event_text_color']) ) ? $_POST['ee_event_text_color'] : $espresso_calendar['ee_event_text_color'];
		$espresso_calendar['enable_cat_classes'] = isset($_POST['enable_cat_classes']) ? $_POST['enable_cat_classes'] : '';;
		//$espresso_calendar['use_themeroller'] = $_POST['use_themeroller'];
		$espresso_calendar['espresso_calendar_titleFormat'] = isset($_POST['espresso_calendar_titleFormat']) ? $_POST['espresso_calendar_titleFormat'] : '';;
		$espresso_calendar['espresso_calendar_columnFormat'] = isset($_POST['espresso_calendar_columnFormat']) ? $_POST['espresso_calendar_columnFormat'] : '';;
		$espresso_calendar['espresso_calendar_monthNames'] = isset($_POST['espresso_calendar_monthNames']) ? $_POST['espresso_calendar_monthNames'] : '';;
		$espresso_calendar['espresso_calendar_monthNamesShort'] = isset($_POST['espresso_calendar_monthNamesShort']) ? $_POST['espresso_calendar_monthNamesShort'] : '';;
		$espresso_calendar['espresso_calendar_dayNames'] = isset($_POST['espresso_calendar_dayNames']) ? $_POST['espresso_calendar_dayNames'] : '';;
		$espresso_calendar['espresso_calendar_dayNamesShort'] = isset($_POST['espresso_calendar_dayNamesShort']) ? $_POST['espresso_calendar_dayNamesShort'] : '';;
		$espresso_calendar['calendar_pages'] = $_POST['calendar_pages'] == '' ? 0 : $_POST['calendar_pages'];

		update_option('espresso_calendar_settings', $espresso_calendar);
		add_action('admin_notices', 'espresso_calendar_updated');
		$notices['updates'][] = __('The calendar settings were saved ', 'event_espresso');
	}
	if (!empty($_REQUEST['reset_calendar']) && check_admin_referer('espresso_form_check', 'reset_calendar_nonce')) {
		delete_option("espresso_calendar_settings");
		espresso_calendar_install();
		$notices['updates'][] = __('The calendar settings were reset ', 'event_espresso');
	}
	$espresso_calendar = get_option('espresso_calendar_settings');

	$values = array(
			array('id' => false, 'text' => __('No', 'event_espresso')),
			array('id' => true, 'text' => __('Yes', 'event_espresso'))
	);
################## Begin admin settings screen ###########################
	?>
<div id="ee-calendar-settings" class="wrap meta-box-sortables ui-sortable">
	<div id="icon-options-event" class="icon32"> </div>
	<h2>
		<?php _e('Event Espresso - Calendar Settings', 'event_espresso'); ?>
		</h2>
	<?php ob_start(); ?>
		<form class="espresso_form" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
			<div class="metabox-holder">
				<div class="postbox">
					<div title="Click to toggle" class="handlediv"><br />
				</div>
				<h3 class="hndle">
					<?php _e('Calendar Usage', 'event_espresso'); ?>
				</h3>
				<div class="inside">
					<div class="padding">
						<ul>
							<li> <strong>
								<?php _e('Directions:', 'event_espresso'); ?>
								</strong><br />
								<?php _e(' Add [ESPRESSO_CALENDAR] to any page or post to display a calendar of Event Espresso events. Use [ESPRESSO_CALENDAR event_category_id="your_category_identifier"] to show events of a certain category (also creates a CSS using the category_identifier as the class name.) Use [ESPRESSO_CALENDAR show_expired="true"] to show expired events, can also be used inconjunction with the category ID.', 'event_espresso'); ?>
							</li>
							<li><strong>
								<?php _e('Examples Shortcodes:', 'event_espresso'); ?>
								</strong><br />
								[ESPRESSO_CALENDAR]<br />
								[ESPRESSO_CALENDAR show_expired="true"]<br />
								[ESPRESSO_CALENDAR event_category_id="your_category_identifier"]<br />
								[ESPRESSO_CALENDAR event_category_id="your_category_identifier" show_expired="true"]<br />
								[ESPRESSO_CALENDAR cal_view="month"] (Available parameters: month, basicWeek, basicDay, agendaWeek, agendaDay) </li>
							<li><strong>
								<?php _e('Styles/Colors:', 'event_espresso'); ?>
								</strong><br />
								<?php _e('To edit the calendar styles, copy the CSS file located in the plugin folder to your "wp-content/uploads/espresso/" directory. Then edit as needed. Refer to <a href="http://arshaw.com/fullcalendar/docs/event_rendering/Colors/" target="_blank">this page</a> for an example of styling the calendar and colors.', 'event_espresso'); ?>
							</li>
							<li><strong>
								<?php _e('Category Colors:', 'event_espresso'); ?>
								</strong><br />
								<?php _e('Event Categories can have their own colors on the calendar. To use this feature, simply create a class in theme CSS file with the names of your event categories. For more inforamtion <a href="http://eventespresso.com/forums/?p=650" target="_blank">please visit the tutorial</a> for this topic.', 'event_espresso'); ?>
							</li>
						</ul>
					</div>
					<!-- / .padding --> 
				</div>
				<!-- / .inside --> 
			</div>
			<!-- / .postbox --> 
		</div>
		<!-- / .metabox-holder --> 
		
		<!-- Calendar basic settings metabox -->
		<div class="metabox-holder">
			<div class="postbox">
				<div title="Click to toggle" class="handlediv"><br />
				</div>
				<h3 class="hndle">
					<?php _e('Basic Settings', 'event_espresso'); ?>
				</h3>
				<div class="inside">
					<div class="padding">
						<h4>
							<?php _e('Time/Date Settings', 'event_espresso'); ?>
						</h4>
						<table class="form-table">
							<tbody>
								<tr>
									<th> <label for="show_time">
											<?php _e('Show Event Time in Calendar', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php
	echo select_input('show_time', $values, $espresso_calendar['show_time'], 'id="show_time"');
	?></td>
								</tr>
								<tr>
									<th><label for="time_format">
											<?php _e('Time Format') ?>
										</label></th>
									<td><?php
	$espresso_calendar['time_format'] = empty($espresso_calendar['time_format']) ? get_option('time_format') : $espresso_calendar['time_format'];
	$time_formats = apply_filters('time_formats', array(
			__('g:i a'),
			'ga',
			'g:i A',
			'gA',
			'H:i',
					));

	$custom = true;

	foreach ($time_formats as $format) {
		echo "\t<label title='" . esc_attr($format) . "'><input type='radio' name='time_format' value='" . esc_attr($format) . "'";
		if ($espresso_calendar['time_format'] === $format) { // checked() uses "==" rather than "==="
			echo " checked='checked'";
			$custom = false;
		}
		echo ' /> <span>' . date_i18n($format) . "</span></label><br />\n";
	}

	echo '	<label><input type="radio" name="time_format" id="time_format_custom_radio" value="\c\u\s\t\o\m"';
	checked($custom);
	echo '/> ' . __('Custom:') . ' </label> <input type="text" name="time_format_custom" value="' . esc_attr($espresso_calendar['time_format']) . '" class="small-text" /> ';
	echo '<span class="example"> ' . date_i18n($espresso_calendar['time_format']) . "</span> <img class='ajax-loading' src='" . esc_url(admin_url('images/wpspin_light.gif')) . "' alt='' />";
	?>
										<br />
										<span class="description"><a href="http://codex.wordpress.org/Formatting_Date_and_Time">
										<?php _e('Documentation on date and time formatting', 'event_espresso'); ?>
										</a></span></td>
								</tr>
								<tr>
									<th> <label for="espresso_calendar_firstday">
											<?php _e('First Day of the Week', 'event_espresso'); ?>
										</label>
									</th>
									<td><input id="espresso_calendar_firstday" type="text" name="espresso_calendar_firstday" size="10" maxlength="1" value="<?php echo $espresso_calendar['espresso_calendar_firstday']; ?>" />
										<br />
										<span class="description">
										<?php _e('(Sunday=0, Monday=1, Tuesday=2, etc.)', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="espresso_calendar_weekends">
											<?php _e('Show Weekends', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('espresso_calendar_weekends', $values, $espresso_calendar['espresso_calendar_weekends'], 'id="espresso_calendar_weekends"'); ?><br />
										<span class="description">
										<?php _e('This setting allows you to remove the weekends from your calendar views. This may be useful if you don\'t have events on weekends.', 'event_espresso'); ?>
										</span></td>
								</tr>
							</tbody>
						</table>
						<h4>
							<?php _e('Page Settings', 'event_espresso'); ?>
						</h4>
						<table class="form-table">
							<tbody>
								<tr>
									<th> <label for="espresso_calendar_height">
											<?php _e('Height', 'event_espresso'); ?>
										</label>
									</th>
									<td><input id="espresso_calendar_height" type="text" name="espresso_calendar_height" size="100" maxlength="100" value="<?php echo $espresso_calendar['espresso_calendar_height']; ?>" />
										<br />
										<span class="description">
										<?php _e('Will make the entire calendar (including header) a pixel height.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="calendar_pages">
											<?php _e('Page(s) Displaying the Calendar', 'event_espresso'); ?>
										</label>
									</th>
									<td><input id="calendar_pages" type="text" name="calendar_pages" size="100" maxlength="100" value="<?php echo isset($espresso_calendar['calendar_pages']) && !empty($espresso_calendar['calendar_pages']) ? $espresso_calendar['calendar_pages'] : 0; ?>" />
										<br />
										<span class="description">
										<?php _e('This tells the plugin to load the calendar CSS file on specific pages. This should be a comma separated list of page id\'s. If left to the default of 0, the calendar stylesheet will load on every page of the site. You can find Page ID\'s by going to the WordPress menu Pages > All Pages, and hovering your mouse over the Page title, at the bottom of your browser a small box will appear with some code in it. Where it says post= then a number (post=4), that number is the Page ID. You can improve site performance and reduce conflicts by specifying which page/s have calendars on them.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<?php if ($espresso_premium == true) { ?>
								<tr>
									<th> <label for="calendar_page_post">
											<?php _e('Link to Post or Registration Page', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('espresso_page_post', array(array('id' => 'R', 'text' => __('Registration Page', 'event_espresso')), array('id' => 'P', 'text' => __('Post', 'event_espresso'))), $espresso_calendar['espresso_page_post'], 'id="calendar_page_post"'); ?> <br />
										<span class="description">
										<?php _e('If you are using the "Create a Post" feature. Use this option to link to the posts that are created by Event Espresso, or select the link to go to the standard registration page.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="enable-calendar-thumbs">
											<?php _e('Enable Images in Calendar', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('enable_calendar_thumbs', $values, isset($espresso_calendar['enable_calendar_thumbs']) && !empty($espresso_calendar['enable_calendar_thumbs']) ?  $espresso_calendar['enable_calendar_thumbs']: 0, 'id="enable-calendar-thumbs"'); ?> <br />
										<span class="description">
										<?php _e('The "Featured Image" box in the event editor handles the thumbnail image URLs for each event. After setting the "Enable Calendar images" option to "Yes" in the calendar settings, upload an event image in the built-in WordPress media uploader, then click the Insert into post button on the media uploader.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php if ($espresso_premium == true) { ?>
						<h4>
							<?php _e('Theme Settings', 'event_espresso'); ?>
						</h4>
						<table class="form-table">
							<tbody>
								<tr>
									<th> <label for="enable-cat-classes">
											<?php _e('Enable CSS for Categories', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('enable_cat_classes', $values, $espresso_calendar['enable_cat_classes'], 'id="enable-cat-classes"'); ?><br />
										<span class="description">
										<?php _e('This setting allows you to set each category to display a different color. Set each category color in Event Espresso > Categories.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="espresso_use_pickers">
											<?php _e('Use Color Pickers', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('espresso_use_pickers', $values, $espresso_calendar['espresso_use_pickers'], 'id="espresso_use_pickers"'); ?><br />
										<span class="description">
										<?php _e('This allows you to customize the event background color and text color.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr class="color-picker-selections">
									<th class="color-picker-style"> <label for="background-color">
											<?php _e('Event Background Color', 'event_espresso') ?>
										</label>
									</th>
									<td><input id="background-color"type="text" name="ee_event_background" <?php echo (isset($espresso_calendar['ee_event_background']) && !empty($espresso_calendar['ee_event_background'])) ? 'value="' . $espresso_calendar['ee_event_background'] . '"' : 'value="#486D96"' ?> />
										<div id="colorpicker-1"></div></td>
								</tr>
								<tr class="color-picker-selections">
									<th class="color-picker-style"> <label for="text-color">
											<?php _e('Event Text Color', 'event_espresso') ?>
										</label>
									</th>
									<td><input id="text-color" type="text" name="ee_event_text_color" <?php echo (isset($espresso_calendar['ee_event_text_color']) && !empty($espresso_calendar['ee_event_text_color'])) ? 'value="' . $espresso_calendar['ee_event_text_color'] . '"' : 'value="#ebe6e8"' ?> />
										<div id="colorpicker-2"></div></td>
								</tr>
								<tr>
									<th> <label for="show_tooltips">
											<?php _e('Show Tooltips', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('show_tooltips', $values, $espresso_calendar['show_tooltips'], 'id="show_tooltips"'); ?><br />
										<span class="description">
										<?php _e('This allows you to display a short description of the event on hover. The "display short descriptions" feature set in Event Espresso>Template settings should be switched on when using this feature. Be sure to use the <code>&lt;!--more--&gt;</code> tag to separate the short description from the entire event description.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<?php 
								$values_1 = array(
										array('id' => 'top', 'text' => __('Top', 'event_espresso')),
										array('id' => 'center', 'text' => __('Center', 'event_espresso')),
										array('id' => 'bottom', 'text' => __('Bottom', 'event_espresso'))
								);
								$values_2 = array(
										array('id' => 'left', 'text' => __('Left', 'event_espresso')),
										array('id' => 'center', 'text' => __('Center', 'event_espresso')),
										array('id' => 'right', 'text' => __('Right', 'event_espresso'))
								);
							?>
								<tr class="tooltip-position-selections">
									<th class="tooltip-positions"> <label for="tooltips_pos_my_1">
											<?php _e('Tooltip Position 1', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('tooltips_pos_my_1', $values_1, !empty($espresso_calendar['tooltips_pos']['my_1']) ? $espresso_calendar['tooltips_pos']['my_1'] : 'bottom', 'id="tooltips_pos_my_1"'); ?> <?php echo select_input('tooltips_pos_my_2', $values_2, !empty($espresso_calendar['tooltips_pos']['my_2']) ? $espresso_calendar['tooltips_pos']['my_2'] : 'center', 'id="tooltips_pos_my_2"'); ?><br />
										<span class="description">
										<?php _e('Default: bottom center', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr class="tooltip-position-selections">
									<th class="tooltip-positions"> <label for="tooltips_pos_at_1">
											<?php _e('Tooltip Position 2', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('tooltips_pos_at_1', $values_1, !empty($espresso_calendar['tooltips_pos']['at_1']) ? $espresso_calendar['tooltips_pos']['at_1'] : 'top', 'id="tooltips_pos_at_1"'); ?> <?php echo select_input('tooltips_pos_at_2', $values_2, !empty($espresso_calendar['tooltips_pos']['at_2']) ? $espresso_calendar['tooltips_pos']['at_2'] : 'center', 'id="tooltips_pos_at_2"'); ?><br />
										<span class="description">
										<?php _e('Default: top center', 'event_espresso'); ?>
										</span></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
						<p>
							<input class="button-primary" type="submit" name="save_calendar_settings" value="<?php _e('Save Calendar Options', 'event_espresso'); ?>" id="save_calendar_settings2" />
							<?php wp_nonce_field('espresso_form_check', 'update_calendar') ?>
						</p>
					</div>
					<!-- / .padding --> 
				</div>
				<!-- / .inside --> 
			</div>
			<!-- / .postbox --> 
		</div>
		<!-- / .metabox-holder --> 
		<?php if ($espresso_premium == true) { ?>
		<!-- Advanced settings metabox -->
		<div class="metabox-holder">
			<div class="postbox">
				<h3 class="hndle">
					<?php _e('Advanced Settings', 'event_espresso'); ?>
				</h3>
				<div class="inside">
					<div class="padding">
						<table class="form-table">
							<tbody>
								<tr>
									<th><label>
											<?php _e('Header Style', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_header" id="espresso_calendar_header" cols="30" rows="5"><?php echo htmlentities(stripslashes_deep($espresso_calendar['espresso_calendar_header'])) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Defines the buttons and title at the top of the calendar.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Button Text', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_buttonText" id="espresso_calendar_buttonText" cols="30" rows="5"><?php echo htmlentities(stripslashes_deep($espresso_calendar['espresso_calendar_buttonText'])) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Text that will be displayed on buttons of the header.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Title Format', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_titleFormat" id="espresso_calendar_titleFormat" cols="30" rows="5"><?php echo htmlentities(stripslashes_deep($espresso_calendar['espresso_calendar_titleFormat'])) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Determines the text that will be displayed in the header\'s title.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Column Format', 'event_espresso'); ?>
										</label></th>
										</th>
									<td><textarea name="espresso_calendar_columnFormat" id="espresso_calendar_columnFormat" cols="30" rows="5"><?php echo htmlentities(stripslashes_deep($espresso_calendar['espresso_calendar_columnFormat'])) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Determines the text that will be displayed on the calendar\'s column headings.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Month Names', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_monthNames" id="espresso_calendar_monthNames" cols="30" rows="5"><?php echo stripslashes_deep($espresso_calendar['espresso_calendar_monthNames']) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Full names of months.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Month Names Short', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_monthNamesShort" id="espresso_calendar_monthNamesShort" cols="30" rows="5"><?php echo stripslashes_deep($espresso_calendar['espresso_calendar_monthNamesShort']) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Abbreviated names of months.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Day Names', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_dayNames" id="espresso_calendar_dayNames" cols="30" rows="5"><?php echo stripslashes_deep($espresso_calendar['espresso_calendar_dayNames']) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Full names of days-of-week.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th><label>
											<?php _e('Day Names Short', 'event_espresso'); ?>
										</label></th>
									<td><textarea name="espresso_calendar_dayNamesShort" id="espresso_calendar_dayNamesShort" cols="30" rows="5"><?php echo stripslashes_deep($espresso_calendar['espresso_calendar_dayNamesShort']) ?></textarea>
										<br />
										<span class="description">
										<?php _e('Abbreviated names of days-of-week.', 'event_espresso'); ?>
										</span></td>
								</tr>
							</tbody>
						</table>
						<h4>
							<?php _e('Memory Management', 'event_espresso'); ?>
						</h4>
						<table class="form-table">
							<tbody>
								<?php 
									//Throttle settings
									$throttle_values = array(
											array('id' => '50', 'text' => __('Really Low (50 records)', 'event_espresso')),
											array('id' => '100', 'text' => __('Low (100 records)', 'event_espresso')),
											array('id' => '250', 'text' => __('Low - Medium  (250 records)', 'event_espresso')),
											array('id' => '500', 'text' => __('Medium (500 records)', 'event_espresso')),
											array('id' => '750', 'text' => __('Medium - High (750 records)', 'event_espresso')),
											array('id' => '1000', 'text' => __('High (1000 records)', 'event_espresso')),
											array('id' => '1', 'text' => __('All the Way! (all records)', 'event_espresso')),
									);
									?>
								<tr>
									<th> <label for="throttle_enable">
											<?php _e('Enable Database Throttling', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('throttle_enable', $values, empty($espresso_calendar['throttle']['enable']) ? $espresso_calendar['throttle']['enable'] : false, 'id="throttle_enable"'); ?> <?php echo select_input('throttle_amount', $throttle_values, !empty($espresso_calendar['throttle']['amount']) ? $espresso_calendar['throttle']['amount'] : '250', 'id="throttle_amount"'); ?><br />
										<span class="description">
										<?php _e('Enabling this setting allows you to limit the amount of records retrieved from the database.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="show_attendee_limit">
											<?php _e('Display Attendee Limits', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('show_attendee_limit', $values, !empty($espresso_calendar['show_attendee_limit']) ? $espresso_calendar['show_attendee_limit'] : false, 'id="show_attendee_limit"'); ?><br />
										<span class="description">
										<?php _e('Enabling this setting increases the amount database queries and may break the calendar on some servers.', 'event_espresso'); ?>
										</span></td>
								</tr>
								<tr>
									<th> <label for="disable_categories">
											<?php _e('Disable Categories?', 'event_espresso'); ?>
										</label>
									</th>
									<td><?php echo select_input('disable_categories', $values, !empty($espresso_calendar['disable_categories']) ? $espresso_calendar['disable_categories'] : false, 'id="disable_categories"'); ?><br />
										<span class="description">
										<?php _e('Disabling categories in the calendar may potentially speed up the calendar and allow you to load more events, but you will not be able to use the category colors and css class options.', 'event_espresso'); ?>
										</span></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="update_calendar" value="update" />
						<p>
							<input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Calendar Options', 'event_espresso'); ?>" id="save_calendar_settings_1" />
							<?php wp_nonce_field('espresso_form_check', 'update_calendar') ?>
						</p>
						
					</div>
					<!-- / .padding --> 
				</div>
				<!-- / .inside --> 
			</div>
			<!-- / .postbox --> 
		</div>
		<!-- / .metabox-holder -->
		<?php } ?>
		<!--</li>
	</ul>-->
	<p>
							<?php _e('Reset Calendar Settings?', 'event_espresso'); ?>
							<input name="reset_calendar" type="checkbox" />
							<?php wp_nonce_field('espresso_form_check', 'reset_calendar_nonce') ?>
						</p>
	</form>
	<?php
		$main_post_content = ob_get_clean();
		espresso_choose_layout($main_post_content, event_espresso_display_right_column());
		include_once('calendar_help.php');
		?>
</div>
<!-- / #wrap --> 
<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function($){
			$("input[name='time_format']").click(function(){
				if ( "time_format_custom_radio" != $(this).attr("id") )
					$("input[name='time_format_custom']").val( $(this).val() ).siblings('.example').text( $(this).siblings('span').text() );
			});
			$("input[name='time_format_custom']").focus(function(){
				$("#time_format_custom_radio").attr("checked", "checked");
			});
			<?php if ($espresso_premium == true) { ?>
			// disable color picker & thumb sizes inputs & fade if not use controls true
			window.scp = $('select#espresso_use_pickers option:selected').val();
			window.ect = $('select#enable-calendar-thumbs option:selected').val();
			window.ectt = $('select#show_tooltips option:selected').val();

			
			if(window.ect == 'false'){
				$('tr#thumbnail-sizes td input').attr('disabled', true);
				$('tr#thumbnail-sizes').attr('style', "opacity: .3");
			}
			$('select#enable-calendar-thumbs').change(function(){
				window.ect = $('select#enable-calendar-thumbs option:selected').val();
				if(window.ect == 'false'){
					$('tr#thumbnail-sizes td input').attr('disabled', true);
					$('tr#thumbnail-sizes').attr('style', "opacity: .3");
				}else{
					$('tr#thumbnail-sizes td input').removeAttr('disabled', true);
					$('tr#thumbnail-sizes').removeAttr('style', "opacity: .3");
				}
			});
			
			// color picker settings
			if(window.scp == ''){
				$('input#event-background, input#event-text').attr('disabled', true);
				$('.color-picker-style').attr('style', "opacity: .3");
				$('tr.color-picker-selections th, tr.color-picker-selections td').attr('style', "opacity: .3");
			}
			$('select#espresso_use_pickers').change(function(){
				window.scp = $('select#espresso_use_pickers option:selected').val();
				if(window.scp == ''){
					$('input#event-background, input#event-text').attr('disabled', true);
					$('tr.color-picker-selections th, tr.color-picker-selections td').attr('style', "opacity: .3");
				}else {
					$('input#event-background, input#event-text').removeAttr('disabled', true);
					$('tr.color-picker-selections th, tr.color-picker-selections td').removeAttr('style');
				}
			});
			$('#colorpicker-1').hide();
			$('#colorpicker-2').hide();
			$('#colorpicker-1').farbtastic("#background-color");
			$('#colorpicker-2').farbtastic("#text-color");
			$("#background-color").click(function(){$('#colorpicker-1').slideToggle()});
			$("#text-color").click(function(){$('#colorpicker-2').slideToggle()});
			
			
			// tooltip settings initialization
			if(window.ectt == ''){
				$('input#show_tooltips').attr('disabled', true);
				$('.tooltip-positions').attr('style', "opacity: .3");
				$('tr.tooltip-position-selections th, tr.tooltip-position-selections td').attr('style', "opacity: .3");
			}
			$('select#show_tooltips').change(function(){
				window.ectt = $('select#show_tooltips option:selected').val();
				if(window.ectt == ''){
					$('input#event-background, input#event-text').attr('disabled', true);
					$('tr.tooltip-position-selections th, tr.tooltip-position-selections td').attr('style', "opacity: .3");
				}else {
					$('input#tooltips_pos_my_1, input#tooltips_pos_my_2, input#tooltips_pos_at_1, input#tooltips_pos_at_2').removeAttr('disabled', true);
					$('tr.tooltip-position-selections th, tr.tooltip-position-selections td').removeAttr('style');
				}
			});
			
			<?php } ?>
			// WP toggle function
			postboxes.add_postbox_toggles('espresso_calendar');

		});

		//]]>
	</script>
<?php
}

