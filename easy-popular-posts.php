<?php
/*
Plugin Name: Easy Popular Posts 
Plugin URI: http://regentware.com/software/web-based/wordpress-plugins/easy-popular-posts-plugin-for-wordpress/
Description: An easy to use WordPress function to add popular posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, popular, preview, plugin, post, posts
Author URI: http://thisismyurl.com
Version: 1.6.4
*/

/*
/--------------------------------------------------------------------\
|                                                                    |
| License: GPL                                                       |
|                                                                    |
| Copyright (C) 2010, Christopher Ross						  	     |
| http://christopherross.ca                     		             |
| All rights reserved.                                               |
|                                                                    |
| This program is free software; you can redistribute it and/or      |
| modify it under the terms of the GNU General Public License        |
| as published by the Free Software Foundation; either version 2     |
| of the License, or (at your option) any later version.             |
|                                                                    |
| This program is distributed in the hope that it will be useful,    |
| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
| GNU General Public License for more details.                       |
|                                                                    |
| You should have received a copy of the GNU General Public License  |
| along with this program; if not, write to the                      |
| Free Software Foundation, Inc.                                     |
| 51 Franklin Street, Fifth Floor                                    |
| Boston, MA  02110-1301, USA                                        |   
|                                                                    |
\--------------------------------------------------------------------/
*/



/* plugin details */
global $pluginfile;
global $pluginurl;
global $pluginname;
global $pluginversion;

$pluginname 	= "Easy popular Posts";
$pluginfile 	= "easy-popular-posts.zip";
$pluginurl 		= "http://regentware.com/software/web-based/wordpress-plugins/easy-popular-posts-for-wordpress/";
$pluginversion 		= "1.5.0";
$pluginwporg 	= "easy-popular-posts";

/* plugin details */

add_filter ( 'plugin_action_links', 'cr_easy_popular_posts_action' , - 10, 2 ); 
add_action('wp_footer', 'cr_easy_popular_posts_footer_code');
register_activation_hook(__FILE__, 'cr_easy_popular_posts_activate');


function cr_easy_popular_posts_activate() {
	
	global $pluginwporg;
	if ((get_option('cr_easy_popular_posts_email')+(1300000)) < date('U')) {
	
		update_option('cr_easy_popular_posts_email', date('U'));

		$email=get_bloginfo('admin_email');
		$name = get_bloginfo('name');
		$message = "Thank you for installing my Easy Popular Posts plugin on ".$name."\r\n\r\n";
		$message .= "If you enjoy this plugin, I have over 20 more on my site. They range from plugins to help you market your blog to utilities and more. Please take a few minutes to visit http://regentware.com\r\n\r\n";
		
		$message .= "You can support development of this plugin by making a donation via PayPal (http://regentware.com/donate/) or even better, if you enjoy it please take a few moments and vote for it at http://wordpress.org/extend/plugins/easy-popular-posts/. Thank you again for trying my plugin on your website.";
		
		
		$message .= "\r\n\r\nChristopher Ross\r\nhttp://regentware.com/";

		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n\\";
		wp_mail($email, 'Easy Popular Posts', $message, $headers);	

		
	}

}

function cr_easy_popular_posts_action($links, $file) {
	global $pluginurl;
	$this_plugin = plugin_basename ( __FILE__ );
	if ($file == $this_plugin) {$links [] = "<a href='".$pluginurl ."?".get_bloginfo('url')."'>Manual</a>";}
	return $links;
}


function cr_easy_popular_posts_footer_code($options='') {
	echo "<!--  Easy Popular Posts by Christopher Ross - http://christopherross.ca   -->";
	
}




function popularPosts($options='') {
	$ns_options = array(
                    "count" => "10",
					"comments" => "0",
                    "before"  => "<li>",
                    "after" => "</li>",
					"order" => "desc",
					"nofollow" => false,
					"credit" => "1",
					"show" => true
                   );
	$options = explode("&",$options);
	
	
	foreach ($options as $option) {
	
		$parts = explode("=",$option);
		$options[$parts[0]] = $parts[1];
	
	}
	
	if ($options['count']) {$ns_options['count'] = $options['count'];}
	if ($options['before']) {$ns_options['before'] = $options['before'];}
	if ($options['after']) {$ns_options['after'] = $options['after'];}
	if ($options['nofollow']) {$ns_options['nofollow'] = $options['nofollow'];}
	if ($options['show']) {$ns_options['show'] = $options['show'];}
	if ($options['credit'] == 0) {$ns_options['credit'] = $options['credit'];}
	
	
	
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

	if ($ns_options['credit'] == "1") {
		$popular .= "<li >".cr_easy_popular_fetch_rss()."</li>";
	}
	
	if ($ns_options['show']==1) {echo $popular;} else {return $popular;}
}




function widget_cr_easy_popular() {
?>
  <h2 class="widgettitle"><?php 
  
$options = get_option("widget_cr_easy_popular");
  if (!is_array( $options ))
{
$options = array(
      'title' => 'Popular Posts',
	  'credit' => '1'
      );
  }
  
  if ($options['credit'] != '1') {$options['credit'] = '0';}
  
  
    echo  $options['title']; ?></h2>
	<ul><?php popularPosts('credit='.$options['credit']); ?></ul>
<?php
}
 
 
 
function widget_cr_easy_popular_control()
{
  $options = get_option("widget_cr_easy_popular");
  if (!is_array( $options ))
{
$options = array(
      'title' => 'Popular Posts',
	  'credit' => '1'
      );
  }
 
  if ($_POST['widget_cr_easy_popular-Submit'])
  {
    $options['title'] = htmlspecialchars($_POST['widget_cr_easy_popular_title']);
	$options['credit'] = htmlspecialchars($_POST['widget_cr_easy_popular_credit']);
    update_option("widget_cr_easy_popular", $options);
  }
 
?>
  <p>
    <label for="widget_cr_easy_popular_title">Widget Title: </label>
    <input type="text" id="widget_cr_easy_popular_title" name="widget_cr_easy_popular_title" value="<?php echo $options['title'];?>" />
    
  </p>
  <p>
    <label for="widget_cr_easy_popular_title">Include Credit Link: </label>
    <input name="widget_cr_easy_popular_credit" type="checkbox" value="1" <?php if ($options['credit'] == 1) {echo " checked ";}?>>
  </p>
    <input type="hidden" id="widget_cr_easy_popular-Submit" name="widget_cr_easy_popular-Submit" value="1" />
<?php
}

 

 
function cr_easy_popular_init()
{
  register_sidebar_widget(__('Popular Posts'), 'widget_cr_easy_popular');
  register_widget_control(   'Popular Posts', 'widget_cr_easy_popular_control', 200, 200 );

  register_sidebar_widget(__('Popular Posts'), 'widget_cr_easy_popular');
}
add_action("plugins_loaded", "cr_easy_popular_init");
 
 
 function cr_easy_popular_fetch_rss() {
	$link = "http://feeds.feedburner.com/thisismyurl";
	$rss = fetch_feed($link);
	$maxitems = $rss->get_item_quantity(1); 
	$rss_items = $rss->get_items(0, $maxitems); 
	if ($maxitems > 0) {
		foreach ( $rss_items as $item ) {	
		
			$link = "<a target='_blank' href='".$item->get_permalink()."' title='".$item->get_title()."'>".$item->get_title()."</a>";
			return $link;
		}
	}
}


 add_shortcode('popularPosts', 'popularPosts');

 
?>