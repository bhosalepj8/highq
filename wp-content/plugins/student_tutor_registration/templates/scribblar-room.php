<?php // registration form fields
function scribblar_room_form() {
        ob_start(); 
        $site_url= get_site_url();
        ?>
<div id="alternate">
<a href="//www.adobe.com/go/getflashplayer">This page requires the latest version of Adobe Flash. Please download it now.<br>
<img src="//s3.amazonaws.com/media.muchosmedia.com/scribblar/assets/get_flash_player.gif" border="0" alt="Get Adobe Flash Player" />
</a>
</div>

<?php
//$uri = $site_url."/wp-admin/edit.php?post_type=room&page=copy-room-from-scribblar&room_id=pr004bucr";
//$response = wp_remote_get($uri);
//$body = wp_remote_retrieve_body( $response );
//print_r($body);
return ob_get_clean();
}?>
<script type="text/javascript">

var targetID = "scribblar";
var flashvars = {};
/* pass necessary variables to the SWF */
flashvars.userid = "D7B9E82B-FB23-2AE9-11AE7FE369B9B536";											/* to allow an anonymous guest pass 0 */
flashvars.roomid = "p0rbwyfbq";									/* the roomid for the room you'd like to access - substitute this for a valid roomid */
flashvars.preferredLocales = "en_US";								/* sets the language - if in doubt leave as en_US */
/* optional: if you pass userid=0 you may also pass a username to skip the username prompt and log the 
user in using that username 
flashvars.username = "John";	*/
var params = {};
params.allowscriptaccess = "always";
var attributes = {};
attributes.id = "scribblar";
attributes.name = "scribblar";
swfobject.embedSWF("//s3.amazonaws.com/media.muchosmedia.com/scribblar/v4/main.swf", "alternate", "100%", "100%", "11.1.0", "//s3.amazonaws.com/media.muchosmedia.com/swfobject/expressInstall.swf", flashvars, params, attributes);
</script>