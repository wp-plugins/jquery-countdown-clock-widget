=== jQuery Countdown Clock ===

Contributors: J. James Beaudoin (joe@frakmedia.net)
Donate link: http://www.frakmedia.net
Tags: countdown, jQuery countdown, countdown clock, countdown widget, countdown generator, countdown ticker, ticker, countup, days since, days till, countdown till days, jQuery
Tested up to: 3.0.1
Requires at least: 3.0.1
Stable tag: trunk

== Description ==

Generates a countdown widget using jQuery. No Flash required, just a JavaScript enabled webbrowser. More advanced users can even use CSS to customize the appearance of the timer.

Requirements: 

* A widget-enabled theme.
* Wordpress 3.0.1
* jQuery 1.5.8

Please rate this plugin!

== Installation ==

1. Download the zip file and extract the contents,

2. Upload the folder `jquery-countdown-clock` to your WP plugin folder `/wp-content/plugins/` directory,

3. Go to Plugins > Installed, and activate the plugin,

4. Go to Appearance > Widgets, and drag the widget ("jQuery Countdown Clck") to a sidebar.

5. Expand the Widget box and, from that, you can change the appearance and display of the countdown timer.

== Changelog ==

= 0.1 (beta) =

* Released 08/20/2010 

* Initial release includes customizations based on jQuery examples laid out at: http://keith-wood.name/countdown.html

==Frequently Asked Questions ==

= How do I customize the colors? =

Define the styles in your theme's styles.css file, or whatever your default CSS file happens to be. 

For instance, if you had an event that was named "Product Launch," the shortcode would be "product-launch," which is then added to the div id as:

	<div id="countdown-product-launch">
	[code would be here, encased in the DIVs]
	</div>

For example:

	#countdown-product-launch { color: #fff; font-size: 12pt; }

Adding that line would define your first countdown box as having white text (#fff) that is 12pt in size.

You can customize it as much as your CSS abilities and knowledge permit.

= Can I set the time of day and world timezone for the event? =

Those settings are available under "timezone" and in time fields, respectively.

= How about support? = 

The plugin is fairly easy to use and is based off the jQuery countdown library. 

Support text is available at this website:

	http://keith-wood.name/countdown.html

You may also use the corresponding forum attached to this plugin at Wordpress.org.