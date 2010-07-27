=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://regentware.com/software/web-based/wordpress-plugins/easy-popular-posts-plugin-for-wordpress/
Tags: popular posts, best, post-plugins, most-viewed, popular, posts,comments, most popular, sidebar, widget, theme, php, code, plugin, post, posts

Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5725847
Requires at least: 2.0.0
Tested up to: 3.0.0
Stable tag: 1.5.2


An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

== Description ==

An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

== Screenshots ==

1. screenshot-1.png


== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

1. Screenshot of Widget

== Updates ==
Updates to the plugin will be posted here, to [thisismyurl]
(http://www.thisismyurl.com/download/wordpress-downloads/easy-popular-posts)

== Frequently Asked Questions ==

= How do I display the results? =

Insert the following code into your WordPress theme files: 

=General results=
Without passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.

 popularPosts();

=Specific number of results=
If you would like to return a specific number of results as your maximum:

 popularPosts('count=10');

=Altering the before and after values=<
By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:

 popularPosts('before=&lt;p&gt;&amp;after=&lt;/p&gt;');


=The Order=<
You can now change the order of the results using ASC, DESC or RAND to return the results in ascending, descending or random order.

 popularPosts('order=ASC');


=Echo vs. Return=
Finally, if you'd like to copy the results into a variable you can return the results as follows:

 popularPosts('show=false'); 

=Combining Arguements=

If you'd like to call multiple arguments you can do so by separating them with a & symbol:

 popularPosts('show=false&order=ASC'); 


== Donations ==
If you would like to donate to help support future development of this tool, please visit [thisismyurl]
(https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5725847)


== Change Log ==

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