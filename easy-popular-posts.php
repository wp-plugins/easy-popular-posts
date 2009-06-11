<?php
/*
Plugin Name: Easy Popular Posts 
Plugin URI: http://thisismyurl.com/plugins/easy-popular-posts
Description: An easy to use WordPress function to add popular posts to any theme.
Author: Christopher Ross
Author URI: http://thisismyurl.com
Version: 1.0.1
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




add_action('admin_menu', 'EasyPopularPosts_menu');

function EasyPopularPosts_menu() {
  add_options_page('Easy Popular Posts', 'Easy Popular Posts', 10,'EasyPopularPosts.php', 'EasyPopularPosts_options');
}

function EasyPopularPosts_options() {

?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2>Easy Popular Posts Settings</h2>
    
    
    
    <div id="poststuff" class="metabox-holder">
    <div class="inner-sidebar">
    <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
    
    <div id="sm_pnres" class="postbox">
    <h3 class="hndle"><span>About this Plugin:</span></h3>
    <div class="inside">
    <ul class='options'>
    <style>.options a {text-decoration:none;}</style>
    <li><a href="http://www.thisismyurl.com/free-downloads/easy-popular-posts/">Plugin Homepage</a></li>
    <li><a href="http://wordpress.org/extend/plugins/easy-popular-posts/">Vote for this Plugin</a></li>
    <li><a href="http://forums.thisismyurl.com/">Support Forum</a></li>
    <li><a href="http://support.thisismyurl.com/">Report a Bug</a></li>
    <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5725847">Donate with PayPal</a></li>
    </ul>
    </div>
    </div>


    <?php 
	if (function_exists(zip_open)) {
	$file = "easy-popular-posts";
			$lastupdate = get_option($file."-update");
		if (strlen($lastupdate )==0 || date("U")-$lastupdate > $lastupdate) {
			$pluginUpdate = file_get_contents('http://downloads.wordpress.org/plugin/'.$file.'.zip');
			$myFile = "../wp-content/uploads/cache-".$file.".zip";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = $pluginUpdate;
			fwrite($fh, $stringData);
			fclose($fh);
			
			$zip = zip_open($myFile);
			while ($zip_entry = zip_read($zip)) {
				if (zip_entry_name($zip_entry) == $file."/".$file.".php") {$size = zip_entry_filesize($zip_entry);}
			}
			zip_close($zip);
			unlink($myFile);
			
			if ($size != filesize("../wp-content/plugins/".$file."/".$file.".php")) {?>    
			<div id="sm_pnres" class="postbox">
				<h3 class="hndle"><span>Plugin Status</span></h3>
				<div class="inside">
				<ul class='options'>
				<style>.options a {text-decoration:none;}</style>
				<li>This plugin is out of date. <a href='http://downloads.wordpress.org/plugin/<?php echo $file;?>.zip'>Please <strong>download</strong> the latest version.</a></li>
				</ul>
				</div>
				</div>
	<?php
		} 
		update_option($file."-update", date('U'));
    }}
	?>



    </div>
    </div>
    
    <div class="has-sidebar sm-padded" >
    
    <div id="post-body-content" class="has-sidebar-content">
    
    <div class="meta-box-sortabless">
    
    <!-- Rebuild Area -->
    <!-- Basic Options -->
    <div id="sm_basic_options" class="postbox">
    <h3 class="hndle"><span>Basic Options</span></h3>
    <div class="inside">
    <p class="hndle">This plugin has no Administation level settings. </p>
    </div>
    </div>
    
    <div id="sm_basic_options2" class="postbox">
      <h3 class="hndle"><span>Read Me File Contents</span></h3>
    <div class="inside">
      <?php 
	  $contents = file_get_contents('../wp-content/plugins/easy-popular-posts/readme.txt');
	  $contents = str_replace("\n","<br>",$contents);
	  echo $contents;
	  ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
<?php
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