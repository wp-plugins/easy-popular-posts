<?php
/*

This common file is used for many of my plugins for WordPress, please visit http://www.thsismyurl.com to learn more about my plugins

*/


function smallbox($title,$content) {
	$box ="
            <div class='handlediv' title='Click to toggle'><br />
            </div>
            <h3 class='hndle'><span>$title</span></h3>
            <div class='inside'>
              <div class='submitbox' id='submitlink'>
                <div id='minor-publishing'>
                  <div id='minor-publishing-actions'>
                    <div id='preview-action'> </div>
                    <div class='clear'></div>
                  </div>
                  <div id='misc-publishing-actions'>
                    <div class='misc-pub-section misc-pub-section-last'>
                        <ul class='options' style='padding-left: 20px;'>
							<style>.options a {text-decoration:none;}</style>$content</ul>
                    </div>
                  </div>
                </div>
                <div class='clear'></div>
              </div>
            </div>
         ";
		
	return $box;
}

	function makedonation($title,$content) {
	
	 echo "
            <div class='handlediv' title='Click to toggle'><br />
            </div>
            <h3 class='hndle'><span>$title</span></h3>
            <div class='inside'>
              <div class='submitbox' id='submitlink'>
                <div id='minor-publishing'>
                  <div style='display:none;'>
                    <input type='submit' name='save' value='Save' />
                  </div>
                  <div id='minor-publishing-actions'>
                    <div id='preview-action'> </div>
                    <div class='clear'></div>
                  </div>
                  <div id='misc-publishing-actions'>
                    <div class='misc-pub-section misc-pub-section-last'>
                          <ul class='options' style='padding-left: 20px;'>
							<style>.options a {text-decoration:none;}</style>$content</ul>
                    </div>
                  </div>
                </div>
                <div id='major-publishing-actions'>
                  <div id='delete-action'> </div>
                  <div id='publishing-action'>
                    <input name='save' type='submit' class='button-primary' id='publish' tabindex='4' accesskey='p' value='Donate' />
                  </div>
                  <div class='clear'></div>
                </div>
                <div class='clear'></div>
              </div>
            </div>
          </div>";
	}
	function makelinks($link) {
			$links = "<li><a href='http://www.thisismyurl.com/download/wordpress-downloads/$link/'>Plugin Homepage</a></li>
			<li><a href='http://wordpress.org/extend/plugins/$link/'>Vote for this Plugin</a></li>
			<li><a href='http://forums.thisismyurl.com/'>Support Forum</a></li>
			<li><a href='http://support.thisismyurl.com/'>Report a Bug</a></li>";
			return $links;	
	}
	
	
	function updates($link) {
		if (function_exists(zip_open)) {
			$lastupdate = get_option($link."-update");
			if (strlen($lastupdate )==0 || date("U")-$lastupdate > $lastupdate) {
				$pluginUpdate = file_get_contents('http://downloads.wordpress.org/plugin/'.$link.'.zip');
				$myFile = "../wp-content/uploads/cache-".$link.".zip";
				$fh = fopen($myFile, 'w') or die("can't open file");
				$stringData = $pluginUpdate;
				fwrite($fh, $stringData);
				fclose($fh);
				
				$zip = zip_open($myFile);
				while ($zip_entry = zip_read($zip)) {
					if (zip_entry_name($zip_entry) == $link."/".$link.".php") {$size = zip_entry_filesize($zip_entry);}
				}
				zip_close($zip);
				unlink($myFile);
				
				if ($size != filesize("../wp-content/plugins/".$link."/".$link.".php")) {
					return "This plugin is out of date. <a href='http://downloads.wordpress.org/plugin/<?php echo $link;?>.zip'>Please <strong>download</strong> the latest version</a>.";    			
				}  else {
					return "This plugin is updated.";
				}
				update_option($link."-update", date('U'));
			} else {
				return "This plugin is updated.";
			}
		}	
	}

	
function bigbox($title,$content) {
	$box = "<div id='addressdiv' class='stuffbox'>
            	<h3><label for='link_url'>$title</label></h3>
            	<div class='inside'>$content</div>
            </div>";
			
	return $box;
}



function parse_urls($text, $link, $maxurl_len = 35, $target = '_self')
{
	if (preg_match_all('/((ht|f)tps?:\/\/([\w\.]+\.)?[\w-]+(\.[a-zA-Z]{2,4})?[^\s\r\n\(\)"\'<>\,\!]+)/si', $text, $urls))
	{
	
		foreach (array_unique($urls[1]) AS $url)
		{
			$urltext = $url;
			$text = str_replace($url, '<a href="'. $url .'#'.urlencode($link).'-'.urlencode($_SERVER['HTTP_HOST']).'" target=”'. $target .'” title=”'. $url .'”>'. $urltext .'</a>', $text);
		}
	}
	
	return $text;
}
?>