<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Scribblar API details' , 'scribblar'); ?></h2>
    
    <form method="post" action="options.php">
        <?php
        // This prints out all hidden setting fields
        settings_fields( 'scribblar_api_group' );   
        do_settings_sections( 'scribblar-api-admin' );
        submit_button(); 
        ?>
    </form>
</div>