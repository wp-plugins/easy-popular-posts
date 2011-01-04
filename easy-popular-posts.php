<?php
/*
Plugin Name: Easy Popular Posts
Plugin URI: http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/
Description: An easy to use WordPress function to add popular posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, popular, preview, plugin, post, posts
Author URI: http://thisismyurl.com
Version: 1.7
*/

/*
	/--------------------------------------------------------------------\
	|                                                                    |
	| License: GPL                                                       |
	|                                                                    |
	| Copyright (C) 2011, Christopher Ross						  	     |
	| http://thisismyurl.com                     		            	 |
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


register_activation_hook( __FILE__, 'cr_easy_popular_posts_activate' );
add_action( 'wp_footer', 'cr_easy_popular_posts_footer_code' );

// Shortcode
add_shortcode( 'popularPosts', 'popularPosts' );

// Plugin Admin links
add_filter ( 'plugin_action_links', 'cr_easy_popular_posts_action' , -10, 2 );

// Widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "PopularPosts" );' ) );


function cr_easy_popular_posts_activate() {
	if ( ( get_option( 'cr_easy_popular_posts_email' ) + ( 1300000 ) ) < date( 'U' ) ) {
		update_option( 'cr_easy_popular_posts_email', date( 'U' ) );

		$email   = get_bloginfo( 'admin_email' );
		$name 	 = get_bloginfo( 'name' );
		$headers = "From: $name <$email>" . "\r\n\\";

		$message  = "";
		$message .= "Thank you for installing my Easy Popular Posts plugin on ".$name."\r\n\r\n";
		$message .= "If you enjoy this plugin, I have over 20 more on my site. They range from plugins to help you market your blog to utilities and more. Please take a few minutes to visit http://thisismyurl.com\r\n\r\n";
		$message .= "You can support development of this plugin by making a donation via PayPal (http://thisismyurl.com/) or even better, if you enjoy it please take a few moments and vote for it at http://wordpress.org/extend/plugins/easy-popular-posts/. Thank you again for trying my plugin on your website.";
		$message .= "\r\n\r\nChristopher Ross\r\nhttp://thisismyurl.com/";

		wp_mail( $email, 'Easy Popular Posts', $message, $headers );
	}
}


function cr_easy_popular_posts_footer_code( $options = '' ) {
	echo "<!--  Easy Popular Posts by Christopher Ross - http://thisismyurl.com   -->";
}


function cr_easy_popular_posts_action( $links, $file ) {
	$pluginurl = "http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/";
	$this_plugin = plugin_basename ( __FILE__ );
	if ( $file == $this_plugin ) {
		$links[] = "<a href='" . $pluginurl . "?" . get_bloginfo('url') . "'>Manual</a>";
	}
	return $links;
}


function popularPosts( $options = '' ) {
	$ns_options = array(
		"count"    => "10",
		"comments" => "0",
		"before"   => "<li>",
		"after"    => "</li>",
		"order"    => "desc",
		"nofollow" => false,
		"credit"   => true,
		"show"     => true
	);

	$options = explode( "&", $options );
	foreach ( $options as $option ) {
		$parts = explode("=",$option);
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
		SELECT comment_count, ID, post_title
		FROM " . $wpdb->posts . "
		WHERE post_type='post' AND post_status = 'publish' AND comment_count >= " . $ns_options['comments']."
		" . $sqlorder . " LIMIT 0 , " . $ns_options['count']
	);
    foreach ( $posts as $post ) {
        setup_postdata( $post );
        $id    = $post->ID;
        $title = $post->post_title;
        $count = $post->comment_count;
        $popular .= $ns_options['before'] . '<a href="' . get_permalink($id) . '" title="' . $title . '"';
		if ( $ns_options['nofollow'] ) {
			$popular .= " rel='nofollow' ";
		}
		$popular .= '>' . $title . '</a>' . $ns_options['after'];
    }

	if ( $ns_options['credit'] ) {
		$popular .= "<li style='opacity:0.4;filter:alpha(opacity=40);'><a href='http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/?source=" . urlencode(get_bloginfo('url')) . "' style='opacity:0.4;filter:alpha(opacity=40);' target='_blank'>Easy Popular Posts by Christopher Ross</a></li>";
	}

	if ( $ns_options['show'] ) {
		echo $popular;
	} else {
		return $popular;
	}
}


class PopularPosts extends WP_Widget {
	function PopularPosts() {
		$widget_ops = array( 'classname' => 'widget_popular_posts', 'description' => 'Your most popular posts' );
		$this->WP_Widget( 'popular_posts', 'Popular Posts', $widget_ops );
	}

	function widget( $args, $instance ) {
		// Backwards compatibility
		if ( empty( $instance ) ) {
			$instance = get_option( 'widget_cr_easy_popular' );
		}
		extract( $args );
		echo $before_widget;
		if( !empty( $instance['title'] ) ) {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>
		<ul><?php popularPosts( 'credit=' . $instance['credit'] ); ?></ul>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['credit'] = strip_tags( $new_instance['credit'] );
		return $instance;
	}

	function form( $instance ) {
		// Backwards compatibility
		if ( empty( $instance ) ) {
			$instance = get_option( 'widget_cr_easy_popular' );
		}
        $title = strip_tags( $instance['title'] );
		$credit = strip_tags( $instance['credit'] );
        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'credit' ); ?>" name="<?php echo $this->get_field_name( 'credit' ); ?>" type="checkbox" value="true" <?php if ( $credit == true ) echo 'checked="checked" ';?>/>
			<label for="<?php echo $this->get_field_id( 'credit' ); ?>"><?php _e( 'Include Credit link' ); ?></label>
		</p>
        <?php
	}
}


?>