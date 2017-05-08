<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Copy room from Scribblar' , 'scribblar'); ?></h2>
    <?php
    
    if ( isset( $message ) && $message ){
        echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div>';
	}
    ?>
	
    <p><a href="?post_type=room&page=scribblar-room-list" class="button">Copy another room</a></p>	

</div>