=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://thisismyurl.com/plugins/easy-popular-posts
Tags: popular posts, best, post-plugins, most-viewed, popular, posts,comments, most popular, sidebar, widget
Donate link: http://www.thisismyurl.com/
Requires at least: 2.0.0
Tested up to: 2.7.1
Stable tag: 0.0.2


An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

== Description ==

An easy to use WordPress function to add popular posts to any theme. The results can be displayed in many ways and it has been tested with popular caching scripts. This is the code that I use on my own website, as well as several popular client websites.

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

== Updates ==
Updates to the plugin will be posted here, to [thisismyurl](http://www.thisismyurl.com/plugins/easy-popular-posts)

== Frequently Asked Questions ==

= How do I display the results? =

Insert the following code into your WordPress theme files: 

<strong>General results</strong>
Without passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.

&lt;?php popularPosts();?&gt;

<strong>Specific number of results</strong>
If you would like to return a specific number of results as your maximum:

&lt;?php popularPosts('count=10');?&gt;

<strong>Altering the before and after values</strong><
By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:

&lt;?php popularPosts('before=&lt;p&gt;&amp;after=&lt;/p&gt;');?&gt;

<strong>Echo vs. Return</strong>
Finally, if you'd like to copy the results into a variable you can return the results as follows:

&lt;?php popularPosts('show=false');?&gt; 


= Is this plugin stable? = 

Technically yes. Until I upgrade the version to 1.x, I still consider it to be in development but yes it has been tested and works well.

== Donations ==
If you would like to donate to help support future development of this tool, please visit [thisismyurl](http://www.thisismyurl.com/)


== Change Log ==

