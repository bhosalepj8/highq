<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $site_url= get_site_url();
  if ( is_user_logged_in() ) { 
        $current_user = wp_get_current_user();
        $role = $current_user->roles[0];
  }
 ?>
<table>
    <tbody>
        <tr>
            <td>
                <h4><?php _e('My Wallet Balance'); ?></h4>
            </td>
            <td>
                <?php echo do_shortcode('[uw_balance display_username="true" separator=":" username_type="display_name"]');?>
            </td>
        </tr>
    </tbody>
</table>

<?php if($role == 'student'):?>
    <h4><?php _e('Add Money To Your Wallet'); ?></h4>
    <?php echo do_shortcode('[uw_product_table]');?>
<?php endif;?>

