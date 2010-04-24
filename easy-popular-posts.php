<?php
/*
Plugin Name: Easy Popular Posts 
Plugin URI: http://regentware.com/software/web-based/wordpress-plugins/easy-popular-posts-plugin-for-wordpress/
Description: An easy to use WordPress function to add popular posts to any theme.
Author: Christopher Ross
Author URI: http://thisismyurl.com
Version: 1.1.6
*/

/*  Copyright 2008  Christopher Ross  (email : info@thisismyurl.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!function_exists(smallbox)) {include_once("common.php");}


add_action('admin_menu', 'EasyPopularPosts_menu');

function EasyPopularPosts_menu() {
  add_options_page('Easy Popular Posts', 'Easy Popular Posts', 10,'EasyPopularPosts.php', 'EasyPopularPosts_options');
}

function EasyPopularPosts_options() {


	$title = "Easy Popular Posts";
	$link = "easy-popular-posts";
	$donate = "5725847";


	/* Page Start */
	echo "<div class='wrap'><div id='icon-options-general' class='icon32'><br /></div><h2>$title Settings</h2>
	
  <form name='addlink' id='addlink' method='post' action='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=$donate'>
    <div id='poststuff' class='metabox-holder has-right-sidebar'>
      <div id='side-info-column' class='inner-sidebar'>
        <div id='side-sortables' class='meta-box-sortables'>
          <div id='linksubmitdiv' class='postbox ' >";
		  
		  
		  // Donate box
		  
		 echo makedonation("Donate","If you find this plugin useful, please consider a small donation.");


							
		// add links box
		echo smallbox("Links",makelinks($link));	
		
		// add update check
		echo smallbox("Updates",updates($link));	
	  
		  
		// scan website for news  
		$news = file_get_contents("http://www.thisismyurl.com/download/wordpress-downloads/".$link."/#".urlencode($_SERVER['HTTP_HOST']));		
		preg_match ("/<div id='updates'>([^`]*?)<\/div>/", $news, $match);
		$news = $match[1];
		if ($news) {echo smallbox("Plugin News",$news);}  
		
		
		
	// end the sidebar
	echo "</div></div>";
		
		
	// start the main body
	echo "<div id='post-body'><div id='post-body-content'>";

		$message = "This plugin has no administation level settings.";
		echo bigbox("Administation",$message);

		$readme = "<pre>".wordwrap(parse_urls(file_get_contents('../wp-content/plugins/'.$link.'/readme.txt'), 80, "\n",true))."</pre>";
		echo bigbox("Readme.txt File Contents",$readme);
	
	// wrap the rest of the page.
	echo "</div></div></div></form></div>";
}














function popularPosts($options='') {
	$ns_options = array(
                    "count" => "10",
					"comments" => "0",
                    "before"  => "<li>",
                    "after" => "</li>",
					"order" => "desc",
					"nofollow" => false,
					"show" => true
                   );

	$options = explode("&",$options);
	
	
	foreach ($options as $option) {
		$parts = explode("=",$option);
		$options[$parts[0]] = $parts[1];
	
	}
	
	if ($options['count']) {$ns_options['count'] = $options['count'];}
	if ($options['comments']) {$ns_options['comments'] = $options['comments'];}
	if ($options['before']) {$ns_options['before'] = $options['before'];}
	if ($options['after']) {$ns_options['after'] = $options['after'];}
	if ($options['order']) {$ns_options['order'] = $options['order'];}
	if ($options['nofollow']) {$ns_options['nofollow'] = $options['nofollow'];}
	if ($options['show']) {$ns_options['show'] = $options['show'];}
	
	if(strtolower($ns_options['order']) == "desc") {$sqlorder = "ORDER BY comment_count DESC";}
	if(strtolower($ns_options['order']) == "asc") {$sqlorder = "ORDER BY comment_count ASC";}
	if(strtolower($ns_options['order']) == "rand") {$sqlorder = "ORDER BY RAND()";}


	global $wpdb;  
    $posts = $wpdb->get_results("SELECT comment_count, ID, post_title FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' AND comment_count >= ".$ns_options['comments']." ".$sqlorder."  LIMIT 0 , ".$ns_options['count']);  

    foreach ($posts as $post) {  
        setup_postdata($post);  
        $id = $post->ID;  
        $title = $post->post_title;  
        $count = $post->comment_count;  
  
        $popular .= $ns_options['before'].'<a href="' . get_permalink($id) . '" title="' . $title . '"';
		if ($ns_options['nofollow'] == true) $popular .= " rel='nofollow' ";
		$popular .= '>' . $title . '</a>'.$ns_options['after'];  
    }  

	if ($ns_options['show']==1) {echo $popular;} else {return $popular;}
}

?>