<?php
/*
Plugin Name: Easy Popular Posts
Plugin URI: http://thisismyurl.com/downloads/wordpress/plugins/easy-popular-posts/
Description: An easy to use WordPress function to add popular posts to any theme.
Author: Christopher Ross
Tags: future, upcoming posts, upcoming post, upcoming, draft, Post, popular, preview, plugin, post, posts
Author URI: http://thisismyurl.com
Version: 1.7.3
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





// plugin definitions
load_plugin_textdomain('epp',false, dirname(plugin_basename(__FILE__) ) . '/languages');
load_plugin_textdomain('common',false, dirname(plugin_basename(__FILE__) ) . '/languages');




global $cr_wplink;
global $cr_wpname;
$cr_wpname = "Easy Popular Posts";
$cr_wplink = "wordpress-php-info";



// add menu to WP admin

function cr_epp_menu() {add_management_page('Easy Popular Posts', 'Easy Popular Posts', 10,'cr_epp.php', 'cr_epp_options');}
add_action('admin_menu', 'cr_epp_menu');





// add a comment to the footer

function cr_epp_footer_code($options='') {echo "<!--  Easy Popular Posts Plugin for WordPress by Christopher Ross  - http://thisismyurl.com  -->";}
add_action('wp_footer', 'cr_epp_footer_code');


// add plugin functions

function cr_epp_plugin_actions($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="tools.php?page=cr_epp.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}
add_filter('plugin_action_links', 'cr_epp_plugin_actions', 10, 2);




// options page for plugin

function cr_epp_options($options='') {
	
?>
    
<div class="wrap">

	<a href="http://thisismyurl.com/"><div id="cross-icon" style="background: url('<?php echo WP_PLUGIN_URL .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));?>/icon.png') no-repeat;" class="icon32"><br /></div></a>
	<h2><?php _e('Easy Popular Posts by Christopher Ross');?></h2>
	


	<div class="postbox-container" style="width:70%;">
		<div class="metabox-holder">	
		<div id="normal-sortables" class="meta-box-sortables">


		
			<div id="wpsettings" class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span><?php _e('Settings');?></span></h3>
			<div class="inside">
				<p><?php _e('This plugin has no settings. To use the plugin effectively, please consult the');?> <a target='_blank' href='<?php echo WP_PLUGIN_URL .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'readme.txt';?>'><?php _e('readme file');?></a>.</p>
			</div>
			</div>
			
			
			
			
			
			
			
		</div>
		</div>
		

		
	</div>
	

	<?php include(WP_PLUGIN_DIR .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'common.php');?>
	
	
			
<?php
}


	
	// add scripts to footer
	add_filter('admin_footer', 'cr_epp_add_scripts', 10, 2);
	// add scripts to header
	add_filter('admin_head', 'cr_epp_add_scripts_head', 10, 2);
	
	
	
	function cr_epp_add_scripts(){
		if ($_GET['page'] == "cr_epp.php") {
	   ?>
	   
	   
	   
	   <style>
	   		.row {padding: 5px; font-size: .75em;}
			.odd {background: #efefef;}
			.even {background: #ffffff;}
			
			.key {width: 30%; float: left;}
			.value {width: 70%; float: left;}
	   </style>
	   
	   <script type='text/javascript' src='<?php bloginfo('url');?>/wp-admin/load-scripts.php?c=1&amp;load=hoverIntent,common,jquery-color,wp-ajax-response,wp-lists,jquery-ui-core,jquery-ui-resizable,admin-comments,jquery-ui-sortable,postbox,dashboard,thickbox,plugin-install,media-upload&amp;ver=1c33e12a06a28402104d18bdc95ada53'></script>
	
	
	
	   <?php
		}
	}
	
	
	
	function cr_epp_add_scripts_head(){
		if ($_GET['page'] == "cr_epp.php") {
		?>
		
		
		
		<script type="text/javascript">
		//<![CDATA[
		addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
		var userSettings = {
				'url': '/',
				'uid': '2',
				'time':'1296327223'
			},
			ajaxurl = '<?php bloginfo('url');?>/wp-admin/admin-ajax.php',
			pagenow = 'settings_page_cr_epp',
			typenow = '',
			adminpage = 'settings_page_cr_epp',
			thousandsSeparator = ',',
			decimalPoint = '.',
			isRtl = 0;
		//]]>
		</script>
		<link rel='stylesheet' href='<?php bloginfo('url');?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=dashboard,plugin-install,global,wp-admin&amp;ver=030f653716b08ff25b8bfcccabe4bdbd' type='text/css' media='all' />
		<script type='text/javascript'>
		/* <![CDATA[ */
		var quicktagsL10n = {
			quickLinks: "(Quick Links)",
			wordLookup: "Enter a word to look up:",
			dictionaryLookup: "Dictionary lookup",
			lookup: "lookup",
			closeAllOpenTags: "Close all open tags",
			closeTags: "close tags",
			enterURL: "Enter the URL",
			enterImageURL: "Enter the URL of the image",
			enterImageDescription: "Enter a description of the image"
		};
		try{convertEntities(quicktagsL10n);}catch(e){};
		/* ]]> */
		</script>
		<script type='text/javascript' src='<?php bloginfo('url');?>/wp-admin/load-scripts.php?c=1&amp;load=jquery,utils,quicktags&amp;ver=b50ff5b9792a9e89a2e131ad3119a463'></script>
	
	
	

<?php
    }
}































// Shortcode
add_shortcode( 'popularPosts', 'popularPosts' );


// Widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "PopularPosts" );' ) );


function cr_easy_popular_posts_activate() {
	
	// create an email reminder for a week from now
	
	
	
}



function cr_easy_popular_posts_get_options($options = '' ) {
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
	
	return $ns_options;
}


function getPopularPosts($options = '' ) {
	$ns_options = cr_easy_popular_posts_get_options($options);

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
	
	return $posts;
}

function popularPosts( $options = '' ) {
	$ns_options = cr_easy_popular_posts_get_options($options);
	$posts = getPopularPosts($options);
	
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
	
	if ( $ns_options['credit'] == 'true' ) {
		$popular .= "<li><a href='http://thisismyurl.com/'>WordPress Consulting</a></li>";
	}

	if ( $ns_options['show'] !== 'false') {
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
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','epp' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'credit' ); ?>" name="<?php echo $this->get_field_name( 'credit' ); ?>" type="checkbox" value="true" <?php if ( $credit == true ) echo 'checked="checked" ';?>/>
			<label for="<?php echo $this->get_field_id( 'credit' ); ?>"><?php _e( 'Include Credit link','epp' ); ?></label>
		</p>
        <?php
	}
}


?>