<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Scribblar user list' , 'scribblar'); ?></h2>
	
	<?php if ( isset( $error_message ) && $error_message ): ?>
        
		<div id="message" class="error below-h2"><p><?php echo $error_message; ?></p></div>
	
	<?php elseif ( !isset( $users ) || 0 == count( $users ) ):?>
	
		<p><?php _e('Sorry, no users found in your Scribblar account.', 'scribblar');?></p>
		
	<?php else: ?>
	
		<p><?php _e('Below is a list of users in your Scribblar accout. You can copy them across into this site.', 'scribblar');?></p>
		
		 <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="users-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $user_list_table->display() ?>
        </form>
		
	
	
	<?php endif; ?>
	
	
	
</div>
