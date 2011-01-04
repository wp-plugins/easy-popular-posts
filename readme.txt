=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/
Tags: popular posts, best, post-plugins, most-viewed, popular, posts,comments, most popular, sidebar, widget, theme, php, code, plugin, post, posts
Donate link:  http://thisismyurl.com/
Requires at least: 2.8.0
Tested up to: 3.0.4
Stable tag: 1.7


An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

== Description ==

An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

You can also include the the list in a post using a shortcode [popularPosts] or as a widget.

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

1. Screenshot of Widget

== Updates ==
Updates to the plugin will be posted here, to [Christopher Ross]
(http://thisismyurl.com)

== Frequently Asked Questions ==

= How do I display the results in my PHP code? =

&lt;?php popularPosts(); ?&gt;

= How do I display the results in my posts? =

Include the shortcode [popularPosts] in any post or page.

= How do I include the results as a widget? =

On your Widgets page, simply drag and drop the widget to your sidebar!

=General results=
Without passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.

&lt;?php popularPosts(); ?&gt;

=Specific number of results=
If you would like to return a specific number of results as your maximum:

&lt;?php popularPosts('count=10'); ?&gt;

=Altering the before and after values=<
By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:

&lt;?php popularPosts('before=&lt;p&gt;&amp;after=&lt;/p&gt;'); ?&gt;


=The Order=<
You can now change the order of the results using ASC, DESC or RAND to return the results in ascending, descending or random order.

&lt;?php popularPosts('order=ASC'); ?&gt;


=Echo vs. Return=
Finally, if you'd like to copy the results into a variable you can return the results as follows:

&lt;?php popularPosts('show=false'); ?&gt;

=Combining Arguements=

If you'd like to call multiple arguments you can do so by separating them with a & symbol:

&lt;?php popularPosts('show=false&order=ASC'); ?&gt;


== Donations ==
If you would like to donate to help support future development of this tool, please visit [Christopher Ross]
(http://thisismyurl.com/)


== Change Log ==

= 1.7 =

* Rewrote widget from the ground up using WP_Widget class introduced in 2.8.
* Output may differ from previous versions as tags/classes are no longer hard-coded, but now driven by the theme.


= 1.6.5 =

* removed RSS feed from thisismyurl.com
* removed manual link
* fixed credit link to work reliably for show / no-show options


= 1.6.4 =

* Added title option for Widget
* Added credit option for Widget


= 1.5.4 =

* Removed update routines, now using WP.org

= 1.5.2 =

* Fixed documentation
* Updated Links

= 1.5.1 =

* Added widget

= 1.5.0 =

* Rewrote common functions
* Removed options page (no options)
* Added credit option to plugin

= 1.1.5  =

* WP2.8.6 Compatibility Review, documentation fixes

= 1.1.0   =

* WP2.8 Compatibility Fixes

= 1.0.0 =

* Official Release

= 0.1.0 =

* Added admin menus