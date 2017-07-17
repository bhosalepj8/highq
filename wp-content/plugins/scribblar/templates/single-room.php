<?php
/**
 * The Template for displaying room post
 *
 * @package Scribblar
 * @subpackage Scribblar
 * @since Scribblar 1.0.21
 */

$room_id = $the_user_id = $the_username = null;
$user_id = get_current_user_id();

if ( have_posts() ):
	while ( have_posts() ) : the_post();
		$room_id = get_post_meta( get_the_ID(), '_room_id', true );
	endwhile;
endif;

if ( isset( $user_id ) && !empty( $user_id ) ):
	$the_user_id = get_user_meta( $user_id, '_scribblar_user_id', true );
	$the_username = get_user_meta( $user_id, '_scribblar_username', true );
endif;


if ( ! is_user_logged_in() ):
	// Now check if the user needs to be logged in to view the room.
	$is_public = get_post_meta( get_the_ID(), '_is_public', true );
	if ( ! $is_public ):
		auth_redirect();
		exit;
	endif;
endif;
?>

<html>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>


  <link href="//s3.amazonaws.com/media.muchosmedia.com/scribblar/styles/style.css" rel="stylesheet" type="text/css">    
  <script type="text/javascript" src="//s3.amazonaws.com/media.muchosmedia.com/scribblar/scripts/includes.js"></script>

	<script type="text/javascript">
        var targetID = "scribblar";
        var flashvars = {};
        /* pass necessary variables to the SWF */
        flashvars.userid = "<?php echo $the_user_id;?>"; /* to allow an anonymous guest pass 0 */
        flashvars.roomid = "<?php echo $room_id;?>"; /* the roomid for the room you'd like to access - substitute this for a valid roomid */
        flashvars.preferredLocales = "en_US";	 /* sets the language - if in doubt leave as en_US */

        <?php if ( $the_username ): ?>
		flashvars.username = "<?php echo $the_username; ?>";
        <?php endif; ?>
        var params = {};
        params.allowscriptaccess = "always";
        params.allowFullScreenInteractive = "true";

        var attributes = {};
        attributes.id = "scribblar";
        attributes.name = "scribblar";
        swfobject.embedSWF("//s3.amazonaws.com/media.muchosmedia.com/scribblar/v4/main.swf", "alternate", "100%", "100%", "11.1.0", "//s3.amazonaws.com/media.muchosmedia.com/swfobject/expressInstall.swf", flashvars, params, attributes);
    </script>
</head>

<body scroll="no">
<div id="alternate"> <a href="//www.adobe.com/go/getflashplayer">This page requires the latest version of Adobe Flash. Please download it now.<br>
  <img src="//s3.amazonaws.com/media.muchosmedia.com/scribblar/assets/get_flash_player.gif" border="0" alt="Get Adobe Flash Player" /></a></div>
</body>
</html>
