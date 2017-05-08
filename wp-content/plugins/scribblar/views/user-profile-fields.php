<a name="scribblar_details" id="scribblar_details"></a>
<h3><?php _e('Scribblar details', 'scribblar');?></h3>

<?php if ( isset( $scribblar_user_id ) && !empty( $scribblar_user_id ) ): ?>

<?php wp_nonce_field( 'update-user-scribblar', '_wpnonce-update-user-scribblar' ); ?>

<table class="form-table">
    <tbody>
    <tr>
    	<th><label><?php _e('Scribblar ID', 'scribblar');?></label></th>
    	<td><?php echo $scribblar_user_id; ?></td>
    </tr>
    
    <tr>
    	<th><label><?php _e('Username', 'scribblar');?></label></th>
    	<td><?php echo $scribblar_username; ?></td>
    </tr>
    
    <tr>
    	<th><label><?php _e('Email', 'scribblar');?></label></th>
    	<td><?php echo $scribblar_email; ?></td>
    </tr>
    
    <tr>
    	<th><label for="scribblar_role_id"><?php _e('Scribblar role', 'scribblar');?></label></th>
    	<td><?php
        if ( isset( $roles ) && !empty( $roles ) ):?>
            <select name="scribblar_role_id">
            <?php foreach( $roles AS $role_level => $role_name ): ?>
                <option value="<?php echo $role_level;?>" <?php echo ( isset( $scribblar_role_id ) && $role_level == $scribblar_role_id )? ' selected="selected" ': '';?>><?php echo $role_name;?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
        </td>
    </tr>
    </tbody>
</table>

    
<?php else: ?>

    <p><em><?php _e('The user is not registered with Scribblar.', 'scribblar');?></em></p>
    <p><a href="?page=scribblar-add-user&user_id=<?php echo $user_id;?>" class="button"><?php _e('Add user to Scribblar', 'scribblar');?></a></p>

<?php endif; ?>