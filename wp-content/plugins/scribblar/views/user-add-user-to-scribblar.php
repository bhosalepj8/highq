<div class="wrap">
	<?php screen_icon(); ?>
    <h2><?php _e( 'Add user to Scribblar' , 'scribblar'); ?></h2>
    
	<?php
	if ( isset( $message ) && $message ){
        echo $message;
	}
	
    if ( true == $display_form ):?>
	
		<form method="post" action="" enctype="multipart/form-data">
			<?php wp_nonce_field( 'add-user-to-scribblar', '_wpnonce-add-user-to-scribblar' ); ?>
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
		        <tr class="">
		            <th scope="row"><label for="scribblar_role"><?php _e( 'Scribblar role:' , 'scribblar'); ?></label></th>
		            <td>
						<?php if ( isset( $roles ) && !empty( $roles ) ): ?>
							<select name="scribblar_role" id="scribblar_role">
								<?php foreach( $roles AS $role_level => $role_name ): ?>
									<option value="<?php echo $role_level;?>"<?php echo isset( $the_role_level ) && $the_role_level == $role_level ? ' selected="selected"" ' : '' ;?>><?php echo _e( ucfirst($role_name), 'scribblar');?></option>
								
								<?php endforeach;?>
							</select>
						<?php endif; ?>						
						<p><span><?php _e('The user will have this role in Scribblar and your rooms, but the role can be different from your WordPress site.', 'scribblar');?></span></p>
					</td>
		        </tr>
			</table>
			<input type="hidden" name="user_id" value="<?php echo isset( $the_user_id )? $the_user_id : '' ;?>" />
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Add user to Scribblar' , 'scribblar'); ?>" />
			</p>
		</form>
		
	<?php
	endif;?>
	
	<?php if ( $the_user_id ): ?>
        <p><a href="/wp-admin/user-edit.php?user_id=<?php echo $the_user_id; ?>#scribblar_details" class="button"><?php _e('Back to user profile', 'scribblar');?></a></p>
    <?php endif; ?>
	
	<?php if ( true == $display_form ):?>
	<h2><?php _e('Roles and capabilities', 'scribblar');?></h2>
	
	<h3><?php _e('Participant 10', 'scribblar');?></h3>
	<p><?php _e('No access to any tools including chat, audio or any other tools. The user has a kind of \'watch mode\' until an Admin grants permission by clicking the icons next to the user\'s name or upgrading their role.', 'scribblar');?></p>

	<h3><?php _e('Participant 30', 'scribblar');?></h3>
	<p><?php _e('No access to audio when entering the room. Has access to the chat and board, access to all drawing tools on the right but only limited access to the top toolbar (can only access the 8 left-most buttons plus the pointer). Full access to assets tab.', 'scribblar');?></p>
	
	<h3><?php _e('Participant 40', 'scribblar');?></h3>
	<p><?php _e('Same as Participant 30 but access to audio and all of the top toolbar apart from clear page and clear all pages.', 'scribblar');?></p>
	
	<h3><?php _e('Moderator', 'scribblar');?></h3>
	<p><?php _e('Same as Participant 40 but access to all of the top toolbar tools.', 'scribblar');?></p>
	
	<h3><?php _e('Administrator', 'scribblar');?></h3>
	<p><?php _e('Same as Moderator but can also toggle access to chat, board and audio to/from users by clicking icons next to their names in the userlist within the Scribblar room. Can also promote/demote users from role to role during a session.', 'scribblar');?></p>
    
	<?php endif; ?>
</div>