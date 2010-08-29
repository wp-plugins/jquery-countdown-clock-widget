<?php
/*
Plugin Name: jQuery Countdown Clock Widget
Plugin URI: http://www.frakmedia.net/wordpress/jquery-countdown-clock-widget
Description: Display and configure a jQuery countdown clock on your sidebar, allowing you to style the result via custom CSS styles.
Version: 0.1 (beta)
Author: J. James Beaudoin (joe@frakmedia.net)
Author URI: http://www.frakmedia.net
Plugin URI: http://www.frakmedia.net/wordpress/jquery-countdown-clock-widget-plugin/
License: GPL2
*/

/*  Copyright 2010  J. James Beaudoin / FrakMedia! Productions, LLC  (email : joe@frakmedia.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Our Global Variables
$siteurl = get_bloginfo('url');
$gmt = get_option('gmt_offset'); // this gets the timezone from Wordpress, as it should be set by the lo(u)ser

// Inserts the jQuery calls and CSS into the theme's header

function jquery_countdown_clock_head()
{
    wp_register_script('jquery-countdown', $siteurl.'/wp-content/plugins/jquery-countdown-widget/js/jquery.countdown.js', false, '1.5.8');
    wp_register_style('jquery-countdown-css', $siteurl.'/wp-content/plugins/jquery-countdown-widget/js/jquery.countdown.css', false, '1.5.8', 'screen');
    wp_enqueue_script('jquery-countdown');
    wp_enqueue_style('jquery-countdown-css');

}

add_action('wp_head', 'jquery_countdown_clock_head', 2);

// The meat of the plugin

function jquery_countdown_clock_init() 
{

     if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
    	   return; 

    function jquery_countdown_clock_control() 
    {
	
	global $gmt;

        $newoptions = get_option('jquery_countdown_clock');
    	$options = $newoptions;
		$options_flag=0;

    	if ( empty($newoptions) )
	{
	   $options_flag=1;
      	   $newoptions = array(
	   		'title'=>'General Countdown',
			'id' => 'general-countdown',
           	'description' => 'Description One',
			'url' => $siteurl,
			// the main event numeros!
           	'event_day' => '12',
           	'event_month' => '11', // 0 = January; 11 = December
           	'event_year' => '2010',
			'event_hour' => '', // based on 24-hour clock
			'event_minute' => '',
			'event_second' => '',
			'compact' => 'true',
			'update' => '1', // sets standard update interval in seconds, based on the "onTick()"
			// and this is the part where we separate the adults from the children... this controls whether or not we see the following
			'years' => 'false',
			'months' => 'false',
			'weeks' => 'false',
			'days' => 'false',
			'hours' => 'true', // based on 24-hour clock
			'minutes' => 'true',
			'seconds' => 'true',
			'show_zero' => 'false' // true if you want to show zeroed variables (i.e. "0 days, 0 hours, and X minutes"), whilst false hides "days," "hours," and what not as they are zeroed out.
	   );
	}

	if ( $_POST['jquery-countdown-clock-submit'] ) {

	     $options_flag=1;
              $newoptions['title'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-title']));
              $newoptions['id'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-id']));
              $newoptions['description'] = stripslashes($_POST['jquery-countdown-clock-description']);
              $newoptions['url'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-url']));
              $newoptions['event_day'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-day']));
              $newoptions['event_month'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-month']));
              $newoptions['event_year'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-year']));
              $newoptions['event_hour'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-hour']));
              $newoptions['event_minute'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-minute']));
              $newoptions['event_second'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-event-second']));
              $newoptions['compact'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-compact']));
              $newoptions['update'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-update']));
              $newoptions['years'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-years']));
              $newoptions['months'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-months']));
              $newoptions['weeks'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-weeks']));
              $newoptions['days'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-days']));
              $newoptions['hours'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-hours']));
              $newoptions['minutes'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-minutes']));
              $newoptions['seconds'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-seconds']));
              $newoptions['show_zero'] = strip_tags(stripslashes($_POST['jquery-countdown-clock-show-zero']));
        }


      	if ( $options_flag == 1 ) {
              $options = $newoptions;
              update_option('jquery_countdown_clock', $options);
      	}

      	// Extract value from passed variables.
      	$title = htmlspecialchars($options['title'], ENT_QUOTES);
      	$id = htmlspecialchars($options['id'], ENT_QUOTES);
      	$description = htmlspecialchars($options['description'], ENT_QUOTES);
      	$url = htmlspecialchars($options['url'], ENT_QUOTES);
      	$event_day = htmlspecialchars($options['event_day'], ENT_QUOTES);
      	$event_month = htmlspecialchars($options['event_month'], ENT_QUOTES);
      	$event_year = htmlspecialchars($options['event_year'], ENT_QUOTES);
      	$event_hour = htmlspecialchars($options['event_hour'], ENT_QUOTES);
      	$event_minute = htmlspecialchars($options['event_minute'], ENT_QUOTES);
      	$event_second = htmlspecialchars($options['event_second'], ENT_QUOTES);
      	$compact = htmlspecialchars($options['compact'], ENT_QUOTES);
      	$update = htmlspecialchars($options['update'], ENT_QUOTES);
      	$years = htmlspecialchars($options['years'], ENT_QUOTES);
      	$months = htmlspecialchars($options['months'], ENT_QUOTES);
      	$weeks = htmlspecialchars($options['weeks'], ENT_QUOTES);
      	$days = htmlspecialchars($options['days'], ENT_QUOTES);
      	$hours = htmlspecialchars($options['hours'], ENT_QUOTES);
      	$minutes = htmlspecialchars($options['minutes'], ENT_QUOTES);
      	$seconds = htmlspecialchars($options['seconds'], ENT_QUOTES);
      	$show_zero = htmlspecialchars($options['show_zero'], ENT_QUOTES);

      	echo '<ul><li style="text-align:center;list-style: none;"><label for="clock-title">jQuery Countdown Clock<br> by <a href="http://www.frakmedia.net">J. James Beaudoin</a></label></li>';

      	// Event title
      	echo '<li style="list-style: none;align:center;text-align:center;margin:0px 0px 10px 0px"><label for="jquery-countdown-clock-title">'.'Event Title<br>';
        echo '<input id="jquery-countdown-clock-title" type="text" name="jquery-countdown-clock-title" style="width: 220px; font-size:13px;align:right;" value="'. $title .'">';
      	echo '</label>';
      	echo '</li>';

		// define our ID based off the title
		
		$id = strtolower($title); // convert everything to lowercase
		$id = str_replace(' ','-', $id); // replace spaces with dashes
		$id .= "-clock"; // adds this suffix in the event that we have classes of the same name declared elsewhere
        echo '<input id="jquery-countdown-clock-id" type="hidden" name="jquery-countdown-clock-id" value="'. $id .'">';
		  
		// Event Description 
      	echo '<li style="list-style: none;align:center;text-align:center"><label for="jquery-countdown-clock-description">'.'Description<br>';
        echo '<input id="jquery-countdown-clock-description" type="text" name="jquery-countdown-clock-description" style="width: 220px; font-size:13px;align:right;" value="'. $description .'">';
      	echo '</label>';
      	echo '</li>';

      	// Event URL
      	echo '<li style="list-style: none;align:center;text-align:center;margin:0px 0px 10px 0px"><label for="jquery-countdown-clock-url">'.'URL<br>';
        echo '<input id="jquery-countdown-clock-url" type="text" name="jquery-countdown-clock-url" style="width: 220px; font-size:13px;align:right;" value="'. $url .'">';
      	echo '</label>';
      	echo '</li>';

		// Event Date
      	echo '<li style="list-style: none;align:center;text-align:center;margin:0px 0px 10px 0px"><label for="jquery-countdown-clock-event-date">'.'Event Date (Month - Day - Year)<br>';
		$month_select_value = $event_month;
		$months_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
		$month_selectbox = '<select name="jquery-countdown-clock-event-month" id="jquery-countdown-clock-event-month">';
		foreach ($months_array as $month):
		  $month_selected = (strtolower($month_select_value) == strtolower($month)) ? " selected " : "";
		  $month_selectbox .= <<<EOL
<option value="$month" $month_selected >$month</option>

EOL;
endforeach;
$month_selectbox .= "</select>";
echo $month_selectbox. '&nbsp;';

$day_select_value = $event_day;
$days_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
$day_selectbox = '<select name="jquery-countdown-clock-event-day" id="jquery-countdown-clock-event-day">';
foreach ($days_array as $day):
  $day_selected = (strtolower($day_select_value) == strtolower($day)) ? " selected " : "";
  $day_selectbox .= <<<EOL
<option value="$day" $day_selected >$day</option>

EOL;
endforeach;
$day_selectbox .= "</select>";
echo $day_selectbox. '&nbsp;';

$year_select_value = $event_year;
$years_array = array("10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
$year_selectbox = '<select name="jquery-countdown-clock-event-year" id="jquery-countdown-clock-event-year">';
foreach ($years_array as $year):
  $year = "20".$year;
  $year_selected = (strtolower($year_select_value) == strtolower($year)) ? " selected " : "";
  $year_selectbox .= <<<EOL
<option value="$year" $year_selected >$year</option>

EOL;
endforeach;
$year_selectbox .= "</select>";
echo $year_selectbox;
echo '</label>';
echo '</li>';

// Event Time

echo '<li style="list-style: none;align:center;text-align:center;margin:0px 0px 10px 0px"><label for="jquery-countdown-clock-event-time">'.'Event Time (Hour - Minute - Second)<br>';
$hour_select_value = $event_hour;
$hours_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");
$hour_selectbox = '<select name="jquery-countdown-clock-event-hour" id="jquery-countdown-clock-event-hour">';
foreach ($hours_array as $hour):
  $hour_selected = (strtolower($hour_select_value) == strtolower($hour)) ? " selected " : "";
  $hour_selectbox .= <<<EOL
<option value="$hour" $hour_selected >$hour</option>

EOL;
endforeach;
$hour_selectbox .= "</select>";
echo $hour_selectbox. '&nbsp';

$minute_select_value = $event_minute;
$minutes_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59");
$minute_selectbox = '<select name="jquery-countdown-clock-event-minute" id="jquery-countdown-clock-event-minute">';
foreach ($minutes_array as $minute):
  $minute_selected = (strtolower($minute_select_value) == strtolower($minute)) ? " selected " : "";
  $minute_selectbox .= <<<EOL
<option value="$minute" $minute_selected >$minute</option>

EOL;
endforeach;
$minute_selectbox .= "</select>";
echo $minute_selectbox. '&nbsp;';

$second_select_value = $event_second;
$seconds_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59");
$second_selectbox = '<select name="jquery-countdown-clock-event-second" id="jquery-countdown-clock-event-second">';
foreach ($seconds_array as $second):
  $second_selected = (strtolower($second_select_value) == strtolower($second)) ? " selected " : "";
  $second_selectbox .= <<<EOL
<option value="$second" $second_selected >$second</option>

EOL;
endforeach;
$second_selectbox .= "</select>";
echo $second_selectbox;
echo '</label>';
echo '</li>';
		
		// Compact

		if ($compact == "true")
		   $compact = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-compact"> Compact View: 
		<input type="checkbox" id="jquery-countdown-clock-compact" name="jquery-countdown-clock-compact" value="true" '.$compact.' /> 
		</label></li>';
		
		// Update Interval in sec
      	echo '<li style="list-style: none;align:center;text-align:center"><label for="jquery-countdown-clock-update">'.'Update Interval (in seconds):<br>';
        echo '<input id="jquery-countdown-clock-update" type="text" name="jquery-countdown-clock-update" style="width: 220px; font-size:13px;align:right;" size="8" maxlength="8" value="'. $update .'">';
      	echo '</label>';
      	echo '</li>';

		// Years

		if ($years == "true")
		   $years = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-years"> Show years? 
		<input type="checkbox" id="jquery-countdown-clock-years" name="jquery-countdown-clock-years" value="true" '.$years.' /> 
		</label></li>';

		// Months

		if ($months == "true")
		   $months = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-months"> Show months? 
		<input type="checkbox" id="jquery-countdown-clock-months" name="jquery-countdown-clock-months" value="true" '.$months.' /> 
		</label></li>';

		// weeks

		if ($weeks == "true")
		   $weeks = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-weeks"> Show weeks?
		<input type="checkbox" id="jquery-countdown-clock-weeks" name="jquery-countdown-clock-weeks" value="true" '.$weeks.' /> 
		</label></li>';

		// days

		if ($days == "true")
		   $days = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-days"> Show days?
		<input type="checkbox" id="jquery-countdown-clock-days" name="jquery-countdown-clock-days" value="true" '.$days.' /> 
		</label></li>';

		// hours

		if ($hours == "true")
		   $hours = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-hours"> Show hours?
		<input type="checkbox" id="jquery-countdown-clock-hours" name="jquery-countdown-clock-hours" value="true" '.$hours.' /> 
		</label></li>';

		// minutes

		if ($minutes == "true")
		   $minutes = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-minutes"> Show minutes?
		<input type="checkbox" id="jquery-countdown-clock-minutes" name="jquery-countdown-clock-minutes" value="true" '.$minutes.' /> 
		</label></li>';

		// seconds

		if ($seconds == "true")
		   $seconds = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-seconds"> Show seconds?
		<input type="checkbox" id="jquery-countdown-clock-seconds" name="jquery-countdown-clock-seconds" value="true" '.$seconds.' /> 
		</label></li>';

		// show_zero

		if ($show_zero == "true")
		   $show_zero = "CHECKED";

		echo "\n";
	        echo '<li style="list-style: none;"><label for="jquery-countdown-clock-show-zero"> Show "zero" variables? (ex: "0 days, 0 hours, 12 minutes") 
		<input type="checkbox" id="jquery-countdown-clock-show-zero" name="jquery-countdown-clock-show-zero" value="true" '.$show_zero.' /> 
		</label></li>';

      	// Hidden "OK" button
      	echo '<label for="jquery-countdown-clock-submit">';
      	echo '<input id="jquery-countdown-clock-submit" name="jquery-countdown-clock-submit" type="hidden" value="Ok" />';
      	echo '</label>';

    }

	
	// Get the jQuery code and insert it in the head of the webpage
	
	function jquery_countdown_clock_header($args)
	{
		global $gmt;

	      	$options = get_option('jquery_countdown_clock');

			// Get our variables

	   		$title = htmlspecialchars($options['title'], ENT_QUOTES);
	      	$id = htmlspecialchars($options['id'], ENT_QUOTES);
	      	$description = stripslashes($options['description']);
	      	$url = htmlspecialchars($options['url'], ENT_QUOTES);
	      	$event_day = htmlspecialchars($options['event_day'], ENT_QUOTES);
	      	$event_month = htmlspecialchars($options['event_month'], ENT_QUOTES);
	      	$event_year = htmlspecialchars($options['event_year'], ENT_QUOTES);
	      	$event_hour = htmlspecialchars($options['event_hour'], ENT_QUOTES);
	      	$event_minute = htmlspecialchars($options['event_minute'], ENT_QUOTES);
	      	$event_second = htmlspecialchars($options['event_second'], ENT_QUOTES);
	      	$timezone = $gmt;
	      	$compact = htmlspecialchars($options['compact'], ENT_QUOTES);
	      	$update = htmlspecialchars($options['update'], ENT_QUOTES);
	      	$years = htmlspecialchars($options['years'], ENT_QUOTES);
	      	$months = htmlspecialchars($options['months'], ENT_QUOTES);
	      	$weeks = htmlspecialchars($options['weeks'], ENT_QUOTES);
	      	$days = htmlspecialchars($options['days'], ENT_QUOTES);
	      	$hours = htmlspecialchars($options['hours'], ENT_QUOTES);
	      	$minutes = htmlspecialchars($options['minutes'], ENT_QUOTES);
	      	$seconds = htmlspecialchars($options['seconds'], ENT_QUOTES);
	      	$show_zero = htmlspecialchars($options['show_zero'], ENT_QUOTES);

			// Assemble everything we need to assemble before calling ze widgetto

			// time... by Pink Floyd

			if ($event_hour > 0)
				$time = ", ".$event_hour;

			if ($event_minute > 0)
				$time .= ", ".$event_minute;

			if ($event_second > 0)
				$time .= ", ".$event_second;

			if ($timezone)
				$zone_call = "timezone: ".$timezone.", "; 

			$date = $event_year.", ".$event_month." - 1, ".$event_day.$time; // date and time assembled

			// Control the display of the time / date

			if ($years)
				$display = "y";

			if ($months)
				$display .= "o";

			if ($weeks)
				$display .= "w";

			if ($days)
				$display .= "d";

			if ($hours)
				$display .= "h";

			if ($minutes)
				$display .= "m";

			if ($seconds)
				$display .= "s";

			if ($show_zero)
				$display = strtoupper($display); // uppercases everything

			$format = "format: '".$display."', ";

			// compact and other options

			if ($compact)
				$compact_call = "compact: true, ";

			if ($update > 1)
				{
					$update = "update: ".$update;
				} else {
					$update = "tickInterval: 1";
				}
			
			// description text
			/*
			if ($description)
				$description = "description: '".$description."', ";
			*/
			// The final call

			$call = "until: new Date(".$date."), ".$zone_call.$format.$compact_call.$update."";
		
		$script = '<script type="text/javascript">'."\n";
		$script .= "jQuery(document).ready(function() {\n";
		$script .= "jQuery('#".$id."').countdown({".$call."});\n";
		$script .= '});'."\n";
		$script .= '</script>'."\n";

		echo $script."\n";
	}
	
	add_action('wp_head','jquery_countdown_clock_header',15,10);

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //	OUTPUT CLOCK WIDGET
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////

     function jquery_countdown_clock($args) 
     {

	// Get values 
		global $gmt;
      	extract($args);

      	$options = get_option('jquery_countdown_clock');

		// Get our variables

   		$title = htmlspecialchars($options['title'], ENT_QUOTES);
      	$id = htmlspecialchars($options['id'], ENT_QUOTES);
      	$description = stripslashes($options['description']);
      	$url = htmlspecialchars($options['url'], ENT_QUOTES);
      	$event_day = htmlspecialchars($options['event_day'], ENT_QUOTES);
      	$event_month = htmlspecialchars($options['event_month'], ENT_QUOTES);
      	$event_year = htmlspecialchars($options['event_year'], ENT_QUOTES);
      	$event_hour = htmlspecialchars($options['event_hour'], ENT_QUOTES);
      	$event_minute = htmlspecialchars($options['event_minute'], ENT_QUOTES);
      	$event_second = htmlspecialchars($options['event_second'], ENT_QUOTES);
      	$timezone = $gmt;
      	$compact = htmlspecialchars($options['compact'], ENT_QUOTES);
      	$update = htmlspecialchars($options['update'], ENT_QUOTES);
      	$years = htmlspecialchars($options['years'], ENT_QUOTES);
      	$months = htmlspecialchars($options['months'], ENT_QUOTES);
      	$weeks = htmlspecialchars($options['weeks'], ENT_QUOTES);
      	$days = htmlspecialchars($options['days'], ENT_QUOTES);
      	$hours = htmlspecialchars($options['hours'], ENT_QUOTES);
      	$minutes = htmlspecialchars($options['minutes'], ENT_QUOTES);
      	$seconds = htmlspecialchars($options['seconds'], ENT_QUOTES);
      	$show_zero = htmlspecialchars($options['show_zero'], ENT_QUOTES);

		// define url

		if ($url)
			$before_url = '<a href="'.$url.'">';
			$after_url = '</a>';

		// call Before Widget

		echo $before_widget; 

	// Output title
	echo $before_title . $title . $after_title; 

	// Output Clock
	
	if($description)
		$description = '<p>'.$description.'</p>'."\n";
	
	echo $description;
	
	echo $before_url.'<span id="'.$id.'" class="countdown"></span>'.$after_url; // placeholder

	echo $after_widget;
	
    }
  	
    register_sidebar_widget('jQuery Countdown Clock', 'jquery_countdown_clock');
    register_widget_control('jQuery Countdown Clock', 'jquery_countdown_clock_control', 245, 300);

}

add_action('plugins_loaded', 'jquery_countdown_clock_init');

?>