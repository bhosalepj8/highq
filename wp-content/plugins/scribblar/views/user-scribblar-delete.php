<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Delete user from Scribblar' , 'scribblar'); ?></h2>
    <?php
    if ( isset( $error_message ) && $error_message ){
        echo '<div id="message" class="error below-h2"><p>'.$error_message.'</p></div>';
	}
	
	if ( isset( $message ) && $message ){
        echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div>';
	}

	if ( true == $display_form ):
	?>
		<form method="post" action="" enctype="multipart/form-data">
			<?php wp_nonce_field( 'delete-user-from-scribblar', '_wpnonce-delete-user-from-scribblar' ); ?>
		    <table class="form-table">
		        <tr class="">
		            <th scope="row"><?php _e( 'First name:' , 'scribblar'); ?></th>
		            <td><?php echo $user_first_name;?></td>
		        </tr>
				<tr class="">
		            <th scope="row"><?php _e( 'Last name:' , 'scribblar'); ?></th>
		            <td><?php echo $user_last_name;?></td>
		        </tr>
				<tr class="">
		            <th scope="row"><?php _e( 'Email address:' , 'scribblar'); ?></th>
		            <td><?php echo $user_email;?></td>
		        </tr>
				<tr class="">
		            <th scope="row"><?php _e( 'Username:' , 'scribblar'); ?></th>
		            <td><?php echo $user_username;?></td>
				</tr>
			</table>
			<input type="hidden" name="user_id" value="<?php echo isset( $the_user_id )? $the_user_id : '' ;?>" />
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Delete user from Scribblar' , 'scribblar'); ?>" />
			</p>
		</form>
		
	<?php
	else:
	?>
		<p><a href="?page=scribblar-user-list" class="button">Delete another user</a></p>
	<?php
	endif;
	?>

</div>