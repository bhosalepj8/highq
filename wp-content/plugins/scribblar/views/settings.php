<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Scribblar settings' , 'scribblar'); ?></h2>
    
	<?php if ( !isset( $hide_form ) || false == $hide_form ): ?>
	    <form method="post" action="options.php">
	        <?php
	        // This prints out all hidden setting fields
	        settings_fields( 'scribblar_account_group' );   
	        do_settings_sections( 'scribblar-account-admin' );
	        submit_button(); 
	        ?>
	    </form>
	<?php endif; ?>
	
	<h2 name="templates"><?php _e('Templates', 'scribblar');?></h2>
	<p><?php _e('We have included some templates to make things quicker and easier for you show your Scribblar rooms on your site', 'scribblar');?></p>
	<p><?php _e('If you would like ot change the template for the single room, copy the <strong>single-room.php</strong> template from this plugin\'s <strong>templates</strong> folder / directory', 'scribblar');?></p>
	<!--<p><?php _e('To copy templates to your theme:', 'scribblar');?> <a href="?page=scribblar-copy-templates" class="button"><?php _e('Copy templates', 'scribblar');?></a></p>-->
	
</div>
