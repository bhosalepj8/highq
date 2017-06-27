<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->student_name)?></p>
        
        <p><?php _e("A gentle reminder that the balance in your wallet is running low.  To avoid any problems while booking a session or a course, please top up your balance.",'woocommerce'); ?></p>
        
        <p><?php printf( __( 'To Top up your balance go to %s'),$data->my_wallet_page)?></p>
        
        <p><?php _e('Thank you once again for being part of the Highq community; where we always strive to create <b>“Successful Learner!“</b>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
