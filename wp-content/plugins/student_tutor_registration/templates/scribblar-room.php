<?php // registration form fields
function scribblar_room_form() {
        ob_start(); 
        $site_url= get_site_url();
        
        require(get_stylesheet_directory_uri(). '/src/Httpful/Bootstrap.php');
        \Httpful\Bootstrap::init();
//        use \Httpful\Request;
        
        ?>
<div id="alternate">
<a href="//www.adobe.com/go/getflashplayer">This page requires the latest version of Adobe Flash. Please download it now.<br>
<img src="//s3.amazonaws.com/media.muchosmedia.com/scribblar/assets/get_flash_player.gif" border="0" alt="Get Adobe Flash Player" />
</a>
</div>

<?php
$uri = 'https://api.scribblar.com/v1/';
//
//$body = array(
//   'api_key'=>'D7203DAF-97A6-1849-713000C0CC50A15D',
//    'email'=>'bhosalepj83@leotechnosoft.net',
//    'firstname'=>'Punam',
//    'lastname'=>'Bhosale',
//    'roleid'=>100,
//    'username'=>'bhosalepj83@leotechnosoft.net',
//    'function'=>'users.add',
//);
//
//
//$args = array(
//    'body' => $body,
//    'timeout' => '5',
//    'redirection' => '5',
//    'httpversion' => '1.0',
//    'blocking' => true,
//    'headers' => array(),
//    'cookies' => array()
//);
//
//$response = wp_remote_post( $uri, $args );
//echo "<pre>";
//$body = wp_remote_retrieve_body( $response );
//print_r($response);

$data = [
    'api_key'=>'D7203DAF-97A6-1849-713000C0CC50A15D',
    'email'=>'bhosalepj85@leotechnosoft.net',
    'firstname'=>'Punam',
    'lastname'=>'Bhosale',
    'roleid'=>100,
    'username'=>'bhosalepj85@leotechnosoft.net',
    'function'=>'users.add',
];
$response = \Httpful\Request::post($uri)
    ->addHeaders(['Content-Type'=>'application/x-www-form-urlencoded'])
    ->body(http_build_query($data))
    ->expectsXml()
    ->send();

//print_r($response->body);

return ob_get_clean();
}?>
<script type="text/javascript">

var targetID = "scribblar";
var flashvars = {};
/* pass necessary variables to the SWF */
flashvars.userid = "7133700F-C96C-7CC8-D09D4AFAE361C3AC";											/* to allow an anonymous guest pass 0 */
flashvars.roomid = "030zndt";									/* the roomid for the room you'd like to access - substitute this for a valid roomid */
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