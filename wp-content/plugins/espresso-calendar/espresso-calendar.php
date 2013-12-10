<?php
/*
  Plugin Name: Event Espresso - Calendar
  Plugin URI: http://www.eventespresso.com
  Description: A full calendar addon for Event Espresso. Includes month, week, and day views.
  Version: 2.0.6.3
  Author: Event Espresso
  Author URI: http://www.eventespresso.com
  Copyright 2013 Event Espresso (email : support@eventespresso.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA02110-1301USA
 */

//Define the version of the plugin
function espresso_calendar_version() {
	return '2.0.6.3';
}

//Update notifications
add_action('action_hook_espresso_calendar_update_api', 'ee_calendar_load_pue_update');
function ee_calendar_load_pue_update() {
	global $org_options, $espresso_check_for_updates;
	if ( $espresso_check_for_updates == false )
		return;
		
	if (file_exists(EVENT_ESPRESSO_PLUGINFULLPATH . 'class/pue/pue-client.php')) { //include the file 
		require(EVENT_ESPRESSO_PLUGINFULLPATH . 'class/pue/pue-client.php' );
		$api_key = $org_options['site_license_key'];
		$host_server_url = 'http://eventespresso.com';
		$plugin_slug = 'espresso-calendar';
		$options = array(
			'apikey' => $api_key,
			'lang_domain' => 'event_espresso',
			'checkPeriod' => '24',
			'option_key' => 'site_license_key'
		);
		$check_for_updates = new PluginUpdateEngineChecker($host_server_url, $plugin_slug, $options); //initiate the class and start the plugin update engine!
	}
}

define("ESPRESSO_CALENDAR_VERSION", espresso_calendar_version());

$wp_plugin_url = WP_PLUGIN_URL;

if (is_ssl()) {
	$wp_plugin_url = str_replace('http://', 'https://', WP_PLUGIN_URL);
}

//Define the plugin directory and path
define("ESPRESSO_CALENDAR_PLUGINPATH", "/" . plugin_basename(dirname(__FILE__)) . "/");
define("ESPRESSO_CALENDAR_PLUGINFULLPATH", WP_PLUGIN_DIR . ESPRESSO_CALENDAR_PLUGINPATH);
define("ESPRESSO_CALENDAR_PLUGINFULLURL", $wp_plugin_url . ESPRESSO_CALENDAR_PLUGINPATH);

//Globals
global $espresso_calendar;
$espresso_calendar = get_option('espresso_calendar_settings');

//Install the plugin
function espresso_calendar_install() {
	$check_settings = get_option('espresso_calendar_settings');
	if (!empty($check_settings)) return;//Keeps fom overwriting the settings
	$espresso_calendar = array(
			'calendar_pages' => "0",
			'espresso_page_post' => "R",
			'espresso_calendar_header' => "left: 'prev, today', center: 'title', right: 'month,agendaWeek,agendaDay,next'",
			'espresso_calendar_buttonText' => "prev: '&nbsp;&#9668;&nbsp;',next: '&nbsp;&#9658;&nbsp;',prevYear: '&nbsp;&laquo;&nbsp;',nextYear: '&nbsp;&raquo;&nbsp;',today:'today',month:'month',week: 'week',day:'day'",
			'espresso_calendar_firstday' => '0',
			'espresso_calendar_weekends' => true,
			'espresso_calendar_height' => '650',
			'espresso_calendar_width' => '2',
			//'enable_calendar_thumbs' => false,
			'show_tooltips' => true,
			'tooltips_pos' => array('my_1' => "bottom", 'my_2' => "center", 'at_1' => "top", 'at_2' => "center"),
			'espresso_use_pickers' => false,
			'ee_event_background' => 'ffffff',
			'ee_event_text_color' => '555555',
			'enable_cat_classes' => false,
			'time_format' => get_option('time_format'),
			'show_time' => true,
			'throttle' => array('enable'=>true, 'amount'=>100),
			'disable_categories' => false,
			'show_attendee_limit' => false,
			//'use_themeroller' => false,
			'espresso_calendar_titleFormat' => "month: 'MMMM yyyy', week: 'MMM dS[ yyyy] - {[ MMM] dS yyyy}', day: 'dddd, MMM dS, yyyy'",
			'espresso_calendar_columnFormat' => "month: 'ddd', week: 'ddd M/d', day: 'dddd M/d'",
			'espresso_calendar_monthNames' => "'".__('January', 'event_espresso')."', '".__('February', 'event_espresso')."', '".__('March', 'event_espresso')."', '".__('April', 'event_espresso')."', '".__('May', 'event_espresso')."', '".__('June', 'event_espresso')."', '".__('July', 'event_espresso')."', '".__('August', 'event_espresso')."', '".__('September', 'event_espresso')."', '".__('October', 'event_espresso')."', '".__('November', 'event_espresso')."', '".__('December', 'event_espresso')."'",
			'espresso_calendar_monthNamesShort' => "'".__('Jan', 'event_espresso')."', '".__('Feb', 'event_espresso')."', '".__('Mar', 'event_espresso')."', '".__('Apr', 'event_espresso')."', '".__('May', 'event_espresso')."', '".__('Jun', 'event_espresso')."', '".__('Jul', 'event_espresso')."', '".__('Aug', 'event_espresso')."', '".__('Sep', 'event_espresso')."', '".__('Oct', 'event_espresso')."', '".__('Nov', 'event_espresso')."', '".__('Dec', 'event_espresso')."'",
			'espresso_calendar_dayNames' => "'".__('Sunday', 'event_espresso')."', '".__('Monday', 'event_espresso')."', '".__('Tuesday', 'event_espresso')."', '".__('Wednesday', 'event_espresso')."', '".__('Thursday', 'event_espresso')."', '".__('Friday', 'event_espresso')."', '".__('Saturday', 'event_espresso')."'",
			'espresso_calendar_dayNamesShort' => "'".__('Sun', 'event_espresso')."', '".__('Mon', 'event_espresso')."', '".__('Tue', 'event_espresso')."', '".__('Wed', 'event_espresso')."', '".__('Thu', 'event_espresso')."', '".__('Fri', 'event_espresso')."', '".__('Sat', 'event_espresso')."'"
	);
	update_option('espresso_calendar_settings', $espresso_calendar);
}

register_activation_hook(__FILE__, 'espresso_calendar_install');

/**
 * Add a settings link to the Plugins page, so people can go straight from the plugin page to the
 * settings page.
 */
function espresso_calendar_plugin_actions($links, $file) {
	// Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if (!$this_plugin)
		$this_plugin = plugin_basename(__FILE__);

	if ($file == $this_plugin) {
		$org_settings_link = '<a href="admin.php?page=espresso_calendar">' . __('Settings') . '</a>';
		array_unshift($links, $org_settings_link); // before other links
	}
	return $links;
}

add_filter('plugin_action_links', 'espresso_calendar_plugin_actions', 10, 2);
################## finish admin screen settings ###########################
//Load the scripts and css
if (!function_exists('espresso_init_calendar')) {

	function espresso_init_calendar() {
		global $espresso_calendar, $load_espresso_calendar_scripts;
		if (!$load_espresso_calendar_scripts)
			return;

		wp_enqueue_script('jquery');

		wp_register_script('fullcalendar-min-js', ESPRESSO_CALENDAR_PLUGINFULLURL . 'scripts/fullcalendar.min.js', array('jquery')); //core calendar script
		wp_print_scripts('fullcalendar-min-js');

		//Load tooltips script
		if (isset($espresso_calendar['show_tooltips']) && $espresso_calendar['show_tooltips'] == true) {
			wp_register_script('jquery-qtip', ESPRESSO_CALENDAR_PLUGINFULLURL . 'scripts/jquery.qtip.js', array('jquery')); //core calendar script
			wp_print_scripts('jquery-qtip');
		}
	}

}
add_action('wp_footer', 'espresso_init_calendar', 20);

if (!function_exists('espresso_init_calendar_style')) {

	function espresso_init_calendar_style() {
		global $espresso_calendar;
		$page_array = explode(',', $espresso_calendar['calendar_pages']);
		//print_r($page_array);
		if ($espresso_calendar['calendar_pages'] != 0) {
			if (!is_page($page_array)) {
				return;
			}
		}

		//Check to see if the calendar css file exists in the '/uploads/espresso/' directory
		if (file_exists(EVENT_ESPRESSO_UPLOAD_DIR . "css/calendar.css")) {
			wp_register_style('calendar', EVENT_ESPRESSO_UPLOAD_URL . 'css/calendar.css'); //This is the url to the css file if available
		} else {
			wp_register_style('calendar', ESPRESSO_CALENDAR_PLUGINFULLURL . 'css/calendar.css'); //calendar core style
		}
		wp_enqueue_style('calendar');

		//Load tooltips styles
		if (isset($espresso_calendar['show_tooltips']) && $espresso_calendar['show_tooltips'] == true) {
			wp_register_style('qtip', ESPRESSO_CALENDAR_PLUGINFULLURL . 'css/jquery.qtip.css'); //calendar core style
			wp_enqueue_style('qtip');
		}
	}

}
add_action('wp_print_styles', 'espresso_init_calendar_style');

function espresso_calendar_do_stuff($show_expired) {
	global $wpdb, $org_options, $espresso_calendar, $event_category_id, $events, $eventsArray;
	remove_shortcode( 'LISTATTENDEES' );
	$throttle = '';
	if ( isset($espresso_calendar['throttle']['enable']) && $espresso_calendar['throttle']['enable'] == true ) {
		if ($espresso_calendar['throttle']['amount'] > 1)
			$throttle = 'LIMIT ' . $espresso_calendar['throttle']['amount'];
	}
	// set boolean for categories 
	$use_categories = isset( $espresso_calendar['disable_categories'] ) && $espresso_calendar['disable_categories'] == FALSE ? TRUE : FALSE;
	//Build the SQL to run
	//Get the categories
	if ( ! empty( $event_category_id )) {
		$type = 'cat';
		$sql = "SELECT e.*, c.category_meta, c.category_identifier, c.category_name, c.category_desc, c.display_desc, ese.start_time, ese.end_time FROM " . EVENTS_DETAIL_TABLE . " e ";
		$sql .= " JOIN " . EVENTS_CATEGORY_REL_TABLE . " r ON r.event_id = e.id ";
		$sql .= " JOIN " . EVENTS_CATEGORY_TABLE . " c ON c.id = r.cat_id ";
		$sql .= " LEFT JOIN " . EVENTS_START_END_TABLE . " ese ON ese.event_id= e.id ";
		if ( function_exists('espresso_version') ) {
			if ( espresso_version() >= '3.2.P' ) { // if we're using ee 3.2+, is_active is true/false
				$sql .= " WHERE e.is_active != false ";
			} else {
				$sql .= " WHERE e.is_active != 'N' ";
			}
		}
		$sql .= " AND e.event_status != 'D' ";//Deleted
		$sql .= " AND e.event_status != 'S' ";//Secondary/Waitlist
		$sql .= " AND e.event_status != 'P' ";//Pending
		$sql .= " AND e.event_status != 'X' ";
		$sql .= " AND e.event_status != 'R' ";//Draft
		$sql .= " AND c.category_identifier = '" . $event_category_id . "' ";
		if ($show_expired == "false") {
			$sql .= " AND start_date >= '" . date('Y-m-d') . "' ";
			$sql .= " AND e.registration_start <= '" . date('Y-m-d') . "' ";
			$sql .= " AND e.registration_end >= '" . date('Y-m-d') . "' ";
		}
	} else {
		//Get all events
		$type = 'all';
		$sql = "SELECT e.*, ese.start_time, ese.end_time";

		$sql .= " FROM " . EVENTS_DETAIL_TABLE . " e ";
		$sql .= " LEFT JOIN " . EVENTS_START_END_TABLE . " ese ON ese.event_id= e.id ";

		if ( function_exists('espresso_version') ) {
			if ( espresso_version() >= '3.2.P' ) { // if we're using ee 3.2+, is_active is true/false
				$sql .= " WHERE e.is_active != false ";
			} else {
				$sql .= " WHERE e.is_active != 'N' ";
			}
		}
		$sql .= " AND e.event_status != 'D' ";//Deleted
		$sql .= " AND e.event_status != 'S' ";//Secondary/Waitlist
		$sql .= " AND e.event_status != 'P' ";//Pending
		$sql .= " AND e.event_status != 'X' ";
		$sql .= " AND e.event_status != 'R' ";//Draft
		if ($show_expired == "false") {
			$sql .= " AND e.start_date >= '" . date('Y-m-d') . "' ";
			$sql .= " AND e.registration_start <= '" . date('Y-m-d') . "' ";
			$sql .= " AND e.registration_end >= '" . date('Y-m-d') . "' ";
		}
	}
	$sql .= " GROUP BY e.id ORDER BY e.start_date = '0000-00-00' ASC " . $throttle;
	//Debug
	//echo '<h4>$sql : ' . $sql . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4><br /><br /><br />';

	$events = array();
	// grab event data with event IDs as the array keys
	$events_data = $wpdb->get_results( $wpdb->prepare( $sql, '' ), OBJECT_K );
	//echo '<h3>$events_data</h3><pre style="height:auto;border:2px solid lightblue;">' . print_r( $events_data, TRUE ) . '</pre><br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span>';
	
	//Do we need to get Category data ?
	if ( $use_categories && $type == 'all' ) {
		// grab event_ids from query results above to use in category query
		$EVT_IDs = array_keys( $events_data );
		$SQL = "SELECT event_id, c.category_meta, c.category_identifier, c.category_name, c.category_desc, c.display_desc";
		$SQL .= " FROM " . EVENTS_CATEGORY_REL_TABLE . ' r ';
		$SQL .= " LEFT JOIN " . EVENTS_CATEGORY_TABLE . " c ON c.id = r.cat_id ";
		$SQL .= " WHERE event_id IN ( '" . implode( "', '", $EVT_IDs ) . "' )";
		$categories = $wpdb->get_results( $wpdb->prepare( $SQL, '' ));
		$event_categories = array();
		foreach ( $categories as $category ) {
			$event_categories[ $category->event_id ][] = $category;
		}
	}
	
	foreach ( $events_data as $event ) {
		global $this_event_id;
		$this_event_id = $event->id;

		//Get details about the category of the event
		if ( $use_categories ) {
			// extract info from separate array of category data ?
			if ( isset( $event_categories[ $event->id ] ) && $type == 'all') {
				// get first element of array without modifying original array
				$primary_cat = array_shift( array_values( $event_categories[ $event->id ] ));
				$category_data['category_meta'] = unserialize( $primary_cat->category_meta );
			} else if ( $type == 'cat' ) {
				// or was one category set via the shortcode
				$category_data['category_meta'] = unserialize( $event->category_meta );
			} else {
				$category_data['category_meta'] = array();
			}
			//Assign colors to events by category
			if( isset( $category_data['category_meta']['use_pickers'] ) && $category_data['category_meta']['use_pickers'] == 'Y' ){				
				$eventArray['color'] = $category_data['category_meta']['event_background'];
				$eventArray['textColor'] = $category_data['category_meta']['event_text_color'];				
			}
		}
		
		$event_meta = unserialize($event->event_meta);
		
		//If the version of Event Espresso is 3.2 or older, we need to use the new permalink structure. If not, then we need to default to the structure.
		if ( function_exists('espresso_version') ) {
			if ( espresso_version() >= '3.2.P' ){
				switch ($espresso_calendar['espresso_page_post']) {
		
					case 'P':
						$registration_url = get_permalink($event->post_id);
						break;
					case 'R':
					default:
						//$registration_url = get_home_url(). '/?page_id=' . $org_options['event_page_id'] . '&regevent_action=register&event_id=' . $event->id;
						$registration_url = espresso_reg_url($event->id, $event->slug);
		
						break;
				}
			}else{
				
				switch ($espresso_calendar['espresso_page_post']){
		
						case 'P':
							$registration_url = get_home_url(). '/?p=' . $event->post_id;
						break;
						case 'R':
						default:
							$registration_url = get_home_url(). '/?page_id=' . $org_options['event_page_id'] . '&regevent_action=register&event_id=' . $event->id;
						break;
		
					}
			}
		}

		//Checkthe status of the event. If the event is expired, the link to the registration page will be deactivated.
		$eventArray['url'] = '';
		$status = '';
		//Changed 8-30-2011 by Seth
		/* switch (event_espresso_get_status($event->id)){
		  case 'NOT_ACTIVE':
		  $status = ' - ' . __('Expired','event_espresso');
		  break;
		  case 'ACTIVE':
		  $status = '';
		  break;
		  } */
		//End Seth
		// Build calendar array from $event data
		//Gets the URL of the event and links the event to the registration form.
		$eventArray['url'] = $event->externalURL != '' ? htmlspecialchars_decode($event->externalURL) : $registration_url;

		//Id of the event
		$eventArray['id'] = $event->id;
		
		if (isset($espresso_calendar['show_attendee_limit']) && $espresso_calendar['show_attendee_limit'] == true) {
			$num_completed = 0;
			$a_sql = "SELECT SUM(quantity) quantity FROM " . EVENTS_ATTENDEE_TABLE . " WHERE event_id=%d AND (payment_status='Completed' OR payment_status='Pending' OR payment_status='Refund') ";
			$wpdb->get_results( $wpdb->prepare( $a_sql, $event->id ), ARRAY_A);
			if ($wpdb->num_rows > 0 && $wpdb->last_result[0]->quantity != NULL) {
				$num_completed = $wpdb->last_result[0]->quantity;
			}
			$reg_limit = $event->reg_limit;
			if ($reg_limit >= 999999){
				$eventArray['attendee_limit'] = __('UNL', 'event_espresso');
			}else{
				$eventArray['attendee_limit'] = $num_completed.'/'.$reg_limit;
			}
		}

		//Get the title of the event
		$ee_event_title = htmlspecialchars_decode(stripslashes_deep($event->event_name . $status), ENT_QUOTES);
		$eventArray['title'] = $ee_event_title;

		
		//Gets the description of the event. This can be used for hover effects such as jQuery Tooltips or QTip
		if (isset($espresso_calendar['show_tooltips']) && $espresso_calendar['show_tooltips'] == true) {
			$eventArray['description'] = espresso_format_content($event->event_desc);
		}
		
		//Supports 3.2 short descriptions
		if (isset($org_options['template_settings']['display_short_description_in_event_list']) && $org_options['template_settings']['display_short_description_in_event_list'] == true) {
			$eventArray['description'] = array_shift(explode('<!--more-->', $eventArray['description']));
		}
		
		//Supports 3.1 short descriptions
		if (isset($org_options['display_short_description_in_event_list']) && $org_options['display_short_description_in_event_list'] == 'Y') {
			$eventArray['description'] = !empty($eventArray['description']) ? array_shift(explode('<!--more-->', $eventArray['description'])) : '';
		}
		
		$eventArray['display_reg_form'] = $event->display_reg_form;

		//Get the start and end times for each event
		//important! time must be in iso8601 format 2010-05-10T08:30!!
		$eventArray['start'] = date("c", strtotime($event->start_date . ' ' . event_date_display($event->start_time, get_option('time_format'))));
		$eventArray['end'] = date("c", strtotime($event->end_date . ' ' . event_date_display($event->end_time, get_option('time_format'))));
		$eventArray['day'] = date("j", strtotime($event->end_date));
		$eventArray['month'] = date("n", strtotime($event->end_date));
		if ( $eventArray['end'] < date('Y-m-d') ) {
			$eventArray['expired'] = 'expired';
		} else {
			$eventArray['expired'] = '';
		}
		$eventArray['today'] = date('Y-m-d');
		$eventArray['this_month'] = date('m');
		$eventArray['startTime'] = !empty($event->start_time) ? event_date_display($event->start_time, $espresso_calendar['time_format']) : '';
		$eventArray['endTime'] = !empty($event->end_time) ? event_date_display($event->end_time, $espresso_calendar['time_format']) : '';

		// Add thumb to eventArray
		$eventArray['event_img_thumb'] = '';
		if (isset($espresso_calendar['enable_calendar_thumbs']) && $espresso_calendar['enable_calendar_thumbs'] == true) {
			if (isset($event_meta['event_thumbnail_url'])) {
				$calendar_thumb = $event_meta['event_thumbnail_url'];
				//Debug:
				//echo '<a href="' . $registration_url . '"><img class="event-id-'. $event->id . '" src="'. $calendar_thumb . '" alt="" title="' . $ee_event_title . '" / ></a>';
				$eventArray['event_img_thumb'] = $calendar_thumb;
			}
		}

		//Custom fields:
		//These can be used to perform special functions in your display.
		//This decalares the category ID as the CSS class name
		$eventArray['className'] = '';
		$eventArray['eventType'] = '';
		if ( $use_categories ) {
			if ( isset( $espresso_calendar['enable_cat_classes'] ) && $espresso_calendar['enable_cat_classes'] == TRUE ) {
				
				if ( isset( $event_categories[ $event->id ] ) && $type == 'all' ) {
					foreach ( $event_categories[ $event->id ] as $EVT ) {
						//This is the css class name
						$eventArray['className'] .= ' ' . $EVT->category_identifier;	
					}
					// set event type to the category id
					$eventArray['eventType'] = isset( $primary_cat->category_name ) && ! empty( $primary_cat->category_name ) ? $primary_cat->category_name : '';
				} else {
					//This is the css class name
					$eventArray['className'] .= isset( $event->category_identifier ) ? ' ' . $event->category_identifier : '';
					// set event type to the category id
					$eventArray['eventType'] .= isset( $event->category_name ) ? ' ' . $event->category_name : '';
				}
			}
		}
		
		//If set to true, events will be shown as all day events
		$eventArray['allDay'] = FALSE;
		//Array of the event details
		$events[] = $eventArray;
		
		//Reset category colors
		$eventArray['color'] ='';
		$eventArray['textColor'] = '';
	}
	//Debug:
	//Print the results of the code above
	//echo json_encode($events);
	//echo '<style type="text/css">'.$category_styles.'</style>';
	
	
}

add_action('action_hook_espresso_calendar_do_stuff', 'espresso_calendar_do_stuff');

//Build the short code
//[ESPRESSO_CALENDAR]
//[ESPRESSO_CALENDAR show_expired="true"]
//[ESPRESSO_CALENDAR event_category_id="your_category_identifier"]
if (!function_exists('espresso_calendar')) {

	function espresso_calendar($atts) {
		global $wpdb, $org_options, $espresso_calendar, $load_espresso_calendar_scripts, $event_category_id, $events;
		//print_r($espresso_calendar);
		$load_espresso_calendar_scripts = true; //This tells the plugin to load the required scripts

		extract(shortcode_atts(array('event_category_id' => '', 'show_expired' => false, 'cal_view' => 'month'), $atts));
		$event_category_id = "{$event_category_id}";
		//echo '<h4>$event_category_id : ' . $event_category_id . '  <br /><span style="font-size:10px;font-weight:normal;">' . __FILE__ . '<br />line no: ' . __LINE__ . '</span></h4>';
		$show_expired = "{$show_expired}";
		$cal_view = "{$cal_view}";
		do_action('action_hook_espresso_calendar_do_stuff',$show_expired);

		//Start the output of the calendar
		ob_start();
		//echo "<pre>".print_r($espresso_calendar,true)."</pre>";
		?>
		<script type="text/javascript">

			jQuery(document).ready(function($) {

				var ee_total_images = 0;

				$('#espresso_calendar').fullCalendar({

					/**
					 * General Display
					 * http://arshaw.com/fullcalendar/docs/text/
					 **/
					<?php 
						//styles for color picker selection in the calendar settings > theme settings
						if ($espresso_calendar['espresso_use_pickers'] == true) {
					?>  
							eventColor: '<?php echo $espresso_calendar['ee_event_background'] ?>',
							eventTextColor: '<?php echo $espresso_calendar['ee_event_text_color'] ?>',
					<?php
						}
					?>
					//month, basicWeek, basicDay, agendaWeek, agendaDay
					defaultView: '<?php echo $cal_view ?>',

					//Defines the buttons and title at the top of the calendar.
					header: { //Settings: http://arshaw.com/fullcalendar/docs/display/header/
						<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_header']) ?>
					},

					/**
					 * Theme Settings
					 *
					 * Once you enable theming with true, you still need to include the CSS file for the theme you want.
					 * For example, if you just downloaded a theme from the jQuery UI Themeroller, you need to put a <link> tag in your page's <head>.
					 **/

					//jQuery UI Themeroller
					//Enables/disables use of jQuery UI theming.
					//Settings: http://arshaw.com/fullcalendar/docs/display/theme/
					<?php
					if ( function_exists('espresso_version') ) {
						if ( (!empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == 'Y') || (espresso_version() >= '3.2.P' && !empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == true) ) {
						echo "theme: true,";
						}
					}
					?>

					//This option only applies to calendars that have jQuery UI theming enabled with the theme option.
					/*buttonIcons:{ //Settings: http://arshaw.com/fullcalendar/docs/display/buttonIcons/
								prev: 'circle-triangle-w',
								next: 'circle-triangle-e'
							},*/

					//The day that each week begins.
					//The value must be a number that represents the day of the week.
					//Sunday=0, Monday=1, Tuesday=2, etc.
					firstDay:<?php echo $espresso_calendar['espresso_calendar_firstday']; ?>, //Settings: http://arshaw.com/fullcalendar/docs/display/firstDay/

					//Displays the calendar in right-to-left mode.
					isRTL: false,

					//Whether to include Saturday/Sunday columns in any of the calendar views.
					weekends: <?php echo $espresso_calendar['espresso_calendar_weekends'] == '' ? 'false':$espresso_calendar['espresso_calendar_weekends']; ?>,

					//Determines the number of weeks displayed in a month view. Also determines each week's height.
					weekMode:'fixed', //Settings: http://arshaw.com/fullcalendar/docs/display/weekMode/

					//Will make the entire calendar (including header) a pixel height.
					height:<?php echo $espresso_calendar['espresso_calendar_height']; ?>, //Settings: http://arshaw.com/fullcalendar/docs/display/height/

					//Will make the calendar's content area a pixel height.
					//contentHeight: 600, //Settings: http://arshaw.com/fullcalendar/docs/display/contentHeight/

					//Determines the width-to-height aspect ratio of the calendar.
					//aspectRatio: 2, //Settings: http://arshaw.com/fullcalendar/docs/display/aspectRatio/

					/**
					 * Agenda Options
					 * http://arshaw.com/fullcalendar/docs/agenda/
					 * Note: These ptions that apply to the agendaWeek and agendaDay views, and have beft out intentionally.
					 * Please refer to the URL above to add.manage your agenda views.
					 **/

					/**
					 * Text/Time Customization Settings
					 * http://arshaw.com/fullcalendar/docs/text/
					 **/

					//Determines the time-text that will be displayed on each event.
					timeFormat:{ //Settings: http://arshaw.com/fullcalendar/docs/text/timeFormat/
						// for agendaWeek and agendaDay
						agenda: 'h:mm{ - h:mm}', // 5:00 - 6:30

						// for all other views
						'': ''// 7p
					},

					//Changes the colors of the events as seen here:
					//http://code.google.com/p/fullcalendar/issues/detail?id=6&can=1&q=css&colspec=ID%20Type%20Status%20Milestone%20Summary%20Stars
					eventRender: function( event, element) {

						// set an event category class
						//alert(event.className);
						if(event.className){
							element.find('a').addClass(event.className);
						}
						//This displays the title of the event when hovering
						//element.attr('title', event.title + " - Event Times: " + event.start + event.end);

						// if the user selects show in thickbox we add this element
						//if(event.in_thickbox_url){
						//element.after($('<div style="display: none;"><div id="event-thumb-detail-' + event.id+ '"><h2 class="tb-event-title">' + event.title + '</h2><p class="tb-event-start">Event start: ' + event.start + '</p><p class="tb-event-end">Event End: ' + event.end + '</p>' + event.description + '<p class="tb-reg-link"><a href="' + event.url + '"title="Go to registration page for this event">Register for this event</a></p></div></div>'));
						//}

						<?php
						//Adds the themeroller styles to the links in the calendar
						if ( function_exists('espresso_version') ) {
							if ( (!empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == 'Y') || (espresso_version() >= '3.2.P' && !empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == true) ) { ?>
								$('a.fc-event').addClass('themeroller ui-state-focus');
								$('a.fc-event div').removeClass('fc-event-skin');
								$('.fc-view').addClass('ui-widget-content');
								$('.expired').removeClass('ui-state-focus').addClass('ui-state-default');
							<?php
							}
						}
						?>
						var ee_month_day = event.month + '-' + event.day;
						element.attr( 'rel', ee_month_day ).attr( 'id', 'EVT_ID-'+event.id );


						if(event.event_img_thumb){
							ee_total_images = parseInt( ee_total_images ) + 1;
							element.addClass('event-has-thumb');							
							element.find('.fc-event-title').after($('<span class="thumb-wrap"><img class="ee-event-thumb" src="' + event.event_img_thumb + '" alt="image of ' + event.title + '" \/></span>'));
						}
						
						if( event.expired ) {
							element.addClass('expired');
						}
						
			<?php
					if ($espresso_calendar['show_time'] == true) {
			?>				
								if ( event.startTime != '' && event.startTime != undefined ) {
									event.startTime = '<span class="event-start-time">' + event.startTime + '</span>';
								
								
									if ( event.startTime != false && event.endTime != '' && event.endTime != undefined ) {
										event.endTime = '<span class="event-end-time">' + event.endTime + '</span>';
									} else {
										event.endTime = '';
									}
									
									if ( event.startTime ) {
										element.find('.fc-event-title').after($('<p class="time-display-block">' + event.startTime + ' - ' + event.endTime + '</p>'));
									}
								}
								
								if ( event.display_reg_form == 'Y') {
									event.regButtonText = '<?php _e('Register Now', 'event_espresso'); ?>';
								} else {
									event.regButtonText = '<?php _e('View Details', 'event_espresso'); ?>';
								}

			<?php
					}

		if (isset($espresso_calendar['show_tooltips']) && $espresso_calendar['show_tooltips'] == true) {
			?>
										element.qtip({
											content: {
												text: event.description + '<div class="qtip_info">' + '<a class="reg_now" href="' + event.url + '">' + event.regButtonText + '</a>'  <?php if (isset($espresso_calendar['show_attendee_limit']) && $espresso_calendar['show_attendee_limit'] == true) {?>+' <span class="attendee_limit">' + event.attendee_limit + '</span>' <?php }?> <?php if ($espresso_calendar['show_time'] == true) {?> +(event.startTime != '' ? '<span class="time_cal_qtip">' + event.startTime + ' - ' + event.endTime + '</span>' : '')<?php }?> + '</div>',
												title: {
													text: '<?php _e('Description', 'event_espresso'); ?>',
													button: true,
												}

											},
											position: {
												/*at: 'top right',
												adjust: {
													x: 0, y: 30*/
												my: '<?php echo isset($espresso_calendar['tooltips_pos']['my_1']) && !empty($espresso_calendar['tooltips_pos']['my_1']) ? $espresso_calendar['tooltips_pos']['my_1'] : 'bottom' ?> <?php echo isset($espresso_calendar['tooltips_pos']['my_2']) && !empty($espresso_calendar['tooltips_pos']['my_2']) ? $espresso_calendar['tooltips_pos']['my_2'] : 'center' ?>',  // Position my top left...
												at: '<?php echo isset($espresso_calendar['tooltips_pos']['at_1']) && !empty($espresso_calendar['tooltips_pos']['at_1']) ? $espresso_calendar['tooltips_pos']['at_1'] : 'top' ?> <?php echo isset($espresso_calendar['tooltips_pos']['at_1']) && !empty($espresso_calendar['tooltips_pos']['at_1']) ? $espresso_calendar['tooltips_pos']['at_2'] : 'center' ?>', // at the bottom right of...
											},
											show: {
												event: 'click mouseenter',
												solo: true
											},
											hide: "unfocus",
											style: {//Additional informatio: http://craigsworks.com/projects/qtip2/docs/style/
												tip: {
													corner: '<?php echo isset($espresso_calendar['tooltips_pos']['my_1']) && !empty($espresso_calendar['tooltips_pos']['my_1']) ? $espresso_calendar['tooltips_pos']['my_1'] : 'bottom' ?> <?php echo isset($espresso_calendar['tooltips_pos']['my_2']) && !empty($espresso_calendar['tooltips_pos']['my_2']) ? $espresso_calendar['tooltips_pos']['my_2'] : 'center' ?>'
												},
									<?php
										if ( function_exists('espresso_version') ) {
											if ( (!empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == 'Y') || (espresso_version() >= '3.2.P' && !empty($org_options['style_settings']['enable_default_style']) && $org_options['style_settings']['enable_default_style'] == true) ) { ?>
												classes: 'ui-tooltip-rounded ui-tooltip-light ui-tooltip-shadow', //Themeroller styles
									<?php 	} else { ?>
												classes: 'ui-tooltip-rounded ui-tooltip-ee ui-tooltip-shadow', //Themeroller styles
									<?php 	}
										} ?>
												/*
												 * The important part: style.widget property

												 * This tells qTip to apply the ui-widget classes to
												 * the main, titlebar and content elements of the qTip.
												 * Otherwise they won't be applied and ThemeRoller styles
												 * won't effect this particular tooltip.
												 */
												widget: true
											}
										});
				<?php
		}
		?>


						//These are examples of custom parameters that can be passed
						/*if (event.eventType == 'meeting') {
									element.addClass('meeting');
									//alert(event.myType );
								}*/

						//This example basically applies different classes to the event
						/*switch (event.myType){
								case 'meeting' :
									element.find('.n, .w, .c, .e, .s').css('background-color', '#00cc33');
								break;
								case 'project' :
									element.find('.n, .w, .c, .e, .s').css('background-color', 'red');
								break;
								default :
								break;
								}*/

						 		
								

					},

					//Determines the text that will be displayed on the calendar's column headings.
					columnFormat:{ //Settings: http://arshaw.com/fullcalendar/docs/text/columnFormat/
		<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_columnFormat']); ?>
						/*month: 'ddd',// Mon
								week: 'ddd M/d', // Mon 9/7
								day: 'dddd M/d'// Monday 9/7*/
					},

					//For date formatting options, please refer to: http://arshaw.com/fullcalendar/docs/utilities/formatDate/
					titleFormat:{ //Settings: http://arshaw.com/fullcalendar/docs/text/columnFormat/
		<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_titleFormat']); ?>
						/*month: 'MMMM yyyy', // September 2009
								week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}", // Sep 7 - 13 2009
								day: 'dddd, MMM d, yyyy'// Tuesday, Sep 8, 2009*/
					},

					//Text that will be displayed on buttons of the header.
					buttonText: { //Settings: http://arshaw.com/fullcalendar/docs/text/buttonText/
		<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_buttonText']); ?>
						/*prev: '&nbsp;&#9668;&nbsp;',// left triangle
								next: '&nbsp;&#9658;&nbsp;',// right triangle
								prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
								nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
								today:'today',
								month:'month',
								week: 'week',
								day:'day'*/
					},

					//Full names of months.
					monthNames: [<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_monthNames']); ?>/*'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'*/],

					//Abbreviated names of months.
					monthNamesShort: [<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_monthNamesShort']); ?>/*'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'*/],

					//Full names of days-of-week.
					dayNames: [<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_dayNames']); ?>/*'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'*/],

					//Abbreviated names of days-of-week.
					dayNamesShort: [<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_dayNamesShort']); ?>/*'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'*/],

					//Load the events into json srrsy
					events: <?php echo json_encode($events) ?>,
					
					viewDisplay: function(view) {
				        $('.ui-state-active').each( function() {
					 		$(this).removeClass('ui-state-active');
					 	});
				        $('.fc-today').addClass('ui-state-active').removeClass('ui-state-highlight');
				    },

						// if an event in the array has already happened, it is expired and we'll give it an 'expired' class
						<?php /*if ( json_encode($events['expired'] != '' ) ) { ?>
							$('a.fc-event div').removeClass('fc-event-skin');
							$('a.fc-event').removeClass('ui-state-default').addClass('expired ui-state-focus');
						<?php } */?>
					loading: function(bool) {
						if (bool) $('#loading').show();
						else $('#loading').hide();
					}

											
				});

				
				var ee_imgTimeout = ee_total_images * 50;
				
				setTimeout(  
					function() {  
						
						// establish vars we need to resize calendar cells properly
						var ee_day = 0;
						var ee_month = 0;
						var ee_thisMonth = 0;
						var ee_thisYear = 0;
						var ee_prevMonth = 0;
						var ee_nextMonth = 0;
						var ee_newTop = 0;

						var ee_months = new Object();
						var ee_monthNames = new Object();
						ee_monthNames= [<?php echo stripslashes_deep($espresso_calendar['espresso_calendar_monthNames']); ?>];						
						for ( i=0; i<12; i++ ) {
							ee_months[ ee_monthNames[i] ] = i+1;
						}

						var ee_monthYear = $('.fc-header-title h2').html();
						var ee_monthYearArray = ee_monthYear.split(' ');
						ee_thisMonth = ee_months[ ee_monthYearArray[0] ];
						ee_thisYear = ee_monthYearArray[1];
						ee_prevMonth = ee_thisMonth - 1;
						ee_nextMonth =  ee_thisMonth +1;
//						console.log( 'prevMonth = ' + prevMonth + '\n' + 'nextMonth = ' + nextMonth );

						$('.fc-view-month .fc-widget-content').each(function(index) {	
							setMonth = ee_thisMonth;
							if ( $(this).closest('tr').hasClass('fc-first') && $(this).hasClass('fc-other-month') ){
								setMonth = ee_prevMonth;
							} else if ( $(this).hasClass('fc-other-month') ){
								setMonth = ee_nextMonth;
							}
							ee_setDay =$(this).find('.fc-day-number').html();
							ee_setID = 'md-' + setMonth + '-' + ee_setDay;
							//console.log( 'setID = ' + setID );
							$(this).find('.fc-day-content > div').attr( 'id', ee_setID );
						});
						
						$('.fc-event').each( function(index){ 						
							// determine what month and day this event is on
							ee_monthDay = $(this).attr( 'rel' );
							//console.log( 'monthDay: ' + monthDay );
							// find day container in calendar
							dayCnt = $('#md-'+ee_monthDay);
							dayCntHTML = dayCnt.html();
														
							if ( dayCntHTML != null && dayCntHTML != undefined ) {
								if ( dayCntHTML == '&nbsp;' ) {
									dayCntHTML = '';
									dayCnt.html( dayCntHTML );
									dayCnt.css({ 'height' : 0 });
								}

								// grab offset for dayCnt
								dayCntPos = dayCnt.position();
								//console.log( 'dayCntPos.top = ' + dayCntPos.top + '\n' + 'dayCntPos.left = ' + dayCntPos.left );
								dayCntHgt = dayCnt.css( 'height' );
								if ( dayCntHgt == undefined ){
									dayCntHgt = '0px';
								}
								dayCntHgt = dayCntHgt.replace( 'px', '' );
								dayCntHgt = parseInt( dayCntHgt );
								ee_newTop = dayCntPos.top + dayCntHgt;
								//console.log( 'newTop = ' + newTop + ' = dayCntPos.top ( ' + dayCntPos.top + ' ) + dayCntHgt ( ' + dayCntHgt + ' )' );
								$(this).css({ 'top' : ee_newTop });
								linkHeight = parseInt( $(this).find('.fc-event-inner').outerHeight() );
								//console.log( 'linkHeight = ' + linkHeight );
								ee_newHeight = dayCntHgt + linkHeight + 3;
								dayCnt.height( ee_newHeight ).css({ 'height' : ee_newHeight + 'px' });
								//console.log( 'newHeight = ' + newHeight );
								var ee_parentHeight = dayCnt.parents('tr').outerHeight();
								//console.log( 'parentHeight = ' + parentHeight );
								//dayCnt.parents('tr').css({ 'background' : 'pink' });
								if( ee_parentHeight < ee_newHeight ) {
									ee_newHeight = ee_newHeight + 30;
									dayCnt.parents('tr').height( ee_newHeight ).css({ 'height' : ee_newHeight + 'px' });
								}
							
							}
						});

					},
					ee_imgTimeout
				);

			});

</script>
<div id='espresso_calendar'></div>
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
		//End calendar output
	}

}
add_shortcode('ESPRESSO_CALENDAR', 'espresso_calendar');

/**
 * Calendar Widget
 * Displays a month-based espresso_calendar in the sidebar
 * @author Chris Reynolds
 * @since 2.0
 */
add_action('widgets_init', 'espresso_calendar_widget_init');

function espresso_calendar_widget_init() {
	register_widget('Espresso_Calendar_Widget'); // registers our widget
}

class Espresso_Calendar_Widget extends WP_Widget {

	function espresso_calendar_widget() {
		/* Widget settings. */
		$widget_options = array('classname' => 'espresso_calendar_widget', 'description' => 'Displays the Espresso Calendar in a widget.');

		/* Widget control settings. */
		$control_options = array('width' => 300, 'height' => 350, 'id_base' => 'espresso-calendar-widget');

		/* Create the widget. */
		$this->WP_Widget('espresso-calendar-widget', 'Event Espresso Calendar Widget', $widget_options, $control_options);
	}

	function widget($args, $instance) {
		global $wpdb, $org_options, $espresso_calendar, $load_espresso_calendar_scripts, $event_category_id, $events;
		extract($args);

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$widget_show_expired = $instance['show_expired'];
		$category_id = $instance['category_id'];
		$calendar_page = $instance['calendar_page'];
		$load_espresso_calendar_scripts = true;


		if (!is_page($calendar_page)) { // if we aren't on the calendar page, we can output the calendar in the sidebar safely
			// Before widget (defined by themes).
			echo $before_widget;
			// Title of widget (before and after defined by themes).
			if ($title)
				echo $before_title . $title . $after_title;

			//Start the output of the calendar
			if (!file_exists(ESPRESSO_CALENDAR_PLUGINFULLPATH . 'espresso-calendar-widget.php')) {
				echo 'Woah. I don\'t know what you did there, but I couldn\'t find espresso-calendar-widget.php.';
			} else {
				if (function_exists('espresso_calendar_do_stuff')) {
					if ( isset($category_id) ) {
						$event_category_id = $category_id;
					}
					if ( !$widget_show_expired ) {
						$dont_show_expired = "if( event.expired ) {
							element.css('display','none');
							}";
					} else {
						$dont_show_expired = null;
					}
					do_action('action_hook_espresso_calendar_do_stuff');
					include_once(ESPRESSO_CALENDAR_PLUGINFULLPATH . 'espresso-calendar-widget.php');
					//var_dump($events);
					echo $espresso_calendar_widget;
				} else {
					echo 'sorry, I couldn\'t figure out the action you wanted me to run';
				}
			}

			// After widget (defined by themes).
			echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags (if needed) and update the widget settings.
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show_expired'] = strip_tags($new_instance['show_expired']);
		$instance['category_id'] = strip_tags($new_instance['category_id']);
		$instance['calendar_page'] = strip_tags($new_instance['calendar_page']);

		return $instance;
	}

	function form($instance) {

		// Set up some default widget settings.
		$defaults = array('title' => 'Calendar', 'show_expired' => false, 'category_id' => '', 'calendar_page' => '');
		$instance = wp_parse_args((array) $instance, $defaults);

		$values = array(
				array('id' => false, 'text' => __('No', 'event_espresso')),
				array('id' => true, 'text' => __('Yes', 'event_espresso')));
		?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:', 'event_espresso'); ?>
	</label>
	<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" width="20" value="<?php echo $instance['title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('show_expired'); ?>">
		<?php _e('Display Expired Events?', 'event_espresso'); ?>
	</label>
	<?php echo select_input($this->get_field_name('show_expired'), $values, $instance['show_expired']); ?> </p>
<p>
	<label for="<?php echo $this->get_field_id('category_id'); ?>">
		<?php _e('Display Single Category?', 'event_espresso'); ?>
	</label>
	<input type="text" id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>" width="20" value="<?php echo $instance['category_id']; ?>" />
	<?php
		if ( function_exists('espresso_version') ) {
			if ( espresso_version() >= '3.2.P' )
				echo apply_filters('filter_hook_espresso_help', 'display_single_category');
		} ?>
</p>
<p>
	<label for="<?php echo $this->get_field_id('calendar_page'); ?>">
		<?php _e('Calendar Page', 'event_espresso'); ?>
	</label>
	<input type="text" id="<?php echo $this->get_field_id('calendar_page'); ?>" name="<?php echo $this->get_field_name('calendar_page'); ?>" width="20" value="<?php echo $instance['calendar_page']; ?>" />
	<?php
		if ( function_exists('espresso_version') ) {
			if ( espresso_version() >= '3.2.P' )
				echo apply_filters('filter_hook_espresso_help', 'calendar_page');
		}
	?>
</p>
<?php
	}

}
add_action( 'admin_notices', 'espresso_calendar_current_screen' );
function espresso_calendar_current_screen() {
	if( !is_admin() ) return;

	global $current_screen;
	if ( $current_screen->base == 'widgets' ) {
		include_once( ESPRESSO_CALENDAR_PLUGINFULLPATH . 'calendar_help.php'); // include the calendar help file, since that's what we're freaking trying to load
		wp_enqueue_style('thickbox'); //load the freaking thickbox style
		wp_enqueue_script('thickbox'); // load the freaking thickbox script
	}
}

if (is_admin()) {
	add_action('plugins_loaded', 'espresso_calendar_load_admin_file');
}

function espresso_calendar_load_admin_file() {
	if ( function_exists( 'espresso_version' )) {
		if ( espresso_version() >= '3.2' ){
			require_once('calendar_admin.php');
		} else {
			require_once('calendar_admin_classic.php');
		}
	}
}
