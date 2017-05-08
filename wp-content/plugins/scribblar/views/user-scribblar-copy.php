<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Copy user from Scribblar' , 'scribblar'); ?></h2>
    <?php    
    if ( isset( $error_message ) && $error_message ){
        echo '<div id="message" class="error below-h2"><p>'.$error_message.'</p></div>';
	}
	
	if ( isset( $message ) && $message ){
        echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div>';
	}
    ?>
	
    <p><a href="?page=scribblar-user-list" class="button">Copy another user</a></p>	

</div>