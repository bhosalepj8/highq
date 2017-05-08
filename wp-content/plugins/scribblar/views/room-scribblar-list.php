<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Scribblar room list' , 'scribblar'); ?></h2>
	
	
	<?php if ( isset( $error_message ) && $error_message ): ?>
        
		<div id="message" class="error below-h2"><p><?php echo $error_message; ?></p></div>
	
	<?php elseif ( !isset( $rooms ) || 0 == count( $rooms ) ): ?>
	
		<p><?php _e('Sorry, no rooms found in your Scribblar account.', 'scribblar');?></p>
		
	<?php else: ?>
	
		<p><?php _e('Below is a list of rooms in your Scribblar accout. You can copy them across into this site.', 'scribblar');?></p>
	
		
		 <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="rooms-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $room_list_table->display() ?>
        </form>
		
	
	
	<?php endif; ?>
	
	
	
</div>
