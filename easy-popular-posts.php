<?php
/*
Plugin Name: Easy Popular Posts
Plugin URI: http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/
Description: An easy to use WordPress function to add Popular Posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, popular, preview, plugin, post, posts
Author URI: http://thisismyurl.com
Version: 2.0.0
*/


/*  Copyright 2011  Christopher Ross  (email : info@thisismyurl.com)

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

add_shortcode( 'thisismyurl_easy_popular_posts', 'thisismyurl_easy_popular_posts' );

function thisismyurl_easy_popular_posts($options = '' ) {
	$ns_options = array(
		"count"    => "10",
		"comments" => "0",
		"before"   => "<li>",
		"after"    => "</li>",
		"order"    => "desc",
		"nofollow" => false,
		"credit"   => false,
		"show"     => true
	);

	$options = explode( "&", $options );
	foreach ( $options as $option ) {
		$parts = explode( "=", $option );
		$ns_options[$parts[0]] = $parts[1];
	}


	if ( strtolower( $ns_options['order'] ) == "desc" ) {
		$sqlorder = "ORDER BY comment_count DESC";
	}
	if ( strtolower( $ns_options['order'] ) == "asc" ) {
		$sqlorder = "ORDER BY comment_count ASC";
	}
	if ( strtolower($ns_options['order'] ) == "rand" ) {
		$sqlorder = "ORDER BY RAND()";
	}

	global $wpdb;
	$posts = $wpdb->get_results("
		SELECT ID
		FROM " . $wpdb->posts . "
		WHERE post_type='post' AND post_status = 'publish' AND comment_count >= " . $ns_options['comments']."
		" . $sqlorder . " LIMIT 0 , " . $ns_options['count']
	);
	
	
    foreach ( $posts as $post ) {
		$popular .=  $ns_options['before']."<a href='".get_permalink($post->ID)."'>".get_the_title($post->ID)."</a>".$ns_options['after'];
    }

	if ( $ns_options['credit'] == "true" ) {
		$popular .= "<li style='font-size: .5em;'><a href='http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/'>Popular Post Plugin by Christopher Ross</a></li>";
	}
	
	if ( $ns_options['show'] ) {
		echo $popular;
	} else {
		return $popular;
	}
}

class thisismyurl_popular_posts_widget extends WP_Widget
{
	
	
	function thisismyurl_popular_posts_widget(){
		$widget_ops = array('classname' => 'widget_thisismyurl_popular_posts', 'description' => __( "Popular Posts by Christopher Ross") );
		$control_ops = array('width' => 300, 'height' => 300);
		$this->WP_Widget('thisismyurl_popular_posts_widget', __('Popular Posts'), $widget_ops, $control_ops);
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['count'] = strip_tags(stripslashes($new_instance['count']));
		$instance['order'] = strip_tags(stripslashes($new_instance['order']));
		$instance['link'] = strip_tags(stripslashes($new_instance['link']));
		$instance['credit'] = strip_tags(stripslashes($new_instance['credit']));

		return $instance;
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array('title'=>'Popular Posts', 'count'=>'5', 'order'=>'desc', 'link'=>'false', 'credit'=>'false') );

		$title = htmlspecialchars($instance['title']);
		$count = htmlspecialchars($instance['count']);
		$order = htmlspecialchars($instance['order']);
		$link = htmlspecialchars($instance['link']);
		$credit = htmlspecialchars($instance['credit']);

		for ($i = 5; $i <= 25; $i=$i+5) {
			$countoption .= "<option value='$i' ";
			if ($count == $i) {$countoption .= "selected";}
			$countoption .= ">$i</option>";
		}
	
		if ($order == "desc") {$orderoption .= "<option value='desc' selected >Descending</option>";} else {$orderoption .= "<option value='desc'>Descending</option>";}
		if ($order == "asc") {$orderoption .= "<option value='asc' selected >Ascending</option>";} else {$orderoption .= "<option value='asc'>Ascending</option>";}


		if ($link == "true") {$linkoption .= "<option value='true' selected >Yes</option>";} else {$linkoption .= "<option value='true'>Yes</option>";}
		if ($link == "false") {$linkoption .= "<option value='false' selected >No</option>";} else {$linkoption .= "<option value='false'>No</option>";}

		if ($credit == "true") {$creditoption .= "<option value='true' selected >Yes</option>";} else {$creditoption .= "<option value='true'>Yes</option>";}
		if ($credit == "false") {$creditoption .= "<option value='false' selected >No</option>";} else {$creditoption .= "<option value='false'>No</option>";}


		# Output the options
		echo '	<p style="text-align:left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . '</label><br />
				<input style="width: 300px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
				</p>';
		echo '	<p style="text-align:left;"><label for="' . $this->get_field_name('count') . '">' . __('Count:') . '</label><br />
				<select id="' . $this->get_field_id('count') . '" name="' . $this->get_field_name('count') . '">'.$countoption.'</select>
				</p>';	
		
		echo '	<p style="text-align:left;"><label for="' . $this->get_field_name('order') . '">' . __('Order:') . '</label><br />
				<select id="' . $this->get_field_id('order') . '" name="' . $this->get_field_name('order') . '">'.$orderoption.'</select>
				</p>';
				
		echo '	<p style="text-align:left;"><label for="' . $this->get_field_name('link') . '">' . __('Include Link?') . '</label><br />
				<select id="' . $this->get_field_id('link') . '" name="' . $this->get_field_name('link') . '">'.$linkoption.'</select>
				</p>';
				
		echo '	<p style="text-align:left;"><label for="' . $this->get_field_name('credit') . '">' . __('Include Credit?') . '</label><br />
				<select id="' . $this->get_field_id('credit') . '" name="' . $this->get_field_name('credit') . '">'.$creditoption.'</select>
				</p>';		
	}


	/*  Displays the Widget */
	function widget($args, $instance){
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array('title'=>'Popular Posts', 'count'=>'5', 'order'=>'desc', 'link'=>'false', 'credit' => 'false') );

		# Before the widget
		echo $before_widget;
		echo '<h4 class="widgettitle">'.$instance['title'].'</h4>';
		echo '<ul>'.thisismyurl_easy_popular_posts('credit='.$instance['credit'].'&link='.$instance['link'].'&count='.$instance['count'].'&order='.$instance['order']).'</ul>';
		echo $after_widget;

	}

}// END class

function thisismyurl_popular_posts_widget_Init() {
	register_widget('thisismyurl_popular_posts_widget');
}
add_action('widgets_init', 'thisismyurl_popular_posts_widget_Init');
?>