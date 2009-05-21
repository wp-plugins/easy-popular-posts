=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://thisismyurl.com/plugins/easy-popular-posts
Tags: wordpress,easy,popular,posts
Donate link: http://www.thisismyurl.com/
Requires at least: 2.0.0
Tested up to: 2.7.1
Stable tag: 0.0.1


An easy to use WordPress function to add popular posts to any theme.

== Description ==

An easy to use WordPress function to add popular posts to any theme.

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

== Updates ==
Updates to the plugin will be posted here, to [thisismyurl](http://www.thisismyurl.com/plugins/easy-popular-posts)

== Frequently Asked Questions ==

= How do I display the results? =

Insert the following code into your WordPress theme files: 

<strong>General results
<span style="font-weight: normal;">Without passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.</span></strong>

&lt;?php popularPosts();?&gt;

<strong>Specific number of results
<span style="font-weight: normal;">If you would like to return a specific number of results as your maximum:</span> </strong>

&lt;?php popularPosts('count=10');?&gt;
<div><strong>Altering the before and after values</strong></div>
<div>By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:</div>
<div>

&lt;?php popularPosts('before=&lt;p&gt;&amp;after=&lt;/p&gt;');?&gt;

<strong>Echo vs. Return
</strong>Finally, if you'd like to copy the results into a variable you can return the results as follows:

&lt;?php popularPosts('echo=false');?&gt; 


= Is this plugin stable? = 

Technically yes. Until I upgrade the version to 1.x, I still consider it to be in development but yes it has been tested and works well.

== Donations ==
If you would like to donate to help support future development of this tool, please visit [thisismyurl](http://www.thisismyurl.com/)


== Change Log ==

