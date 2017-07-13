<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->user_name)?></p>

        <p><?php _e("Thank you for registering with Highq. We are reviewing your application and will revert to you shortly.",'woocommerce'); ?></p>
          
        <p><?php _e('We look forward to seeing you at the sessions.','woocommerce'); ?></p>
        
        <p><?php printf( __( 'Please click on the link below to activate your account:<br><a href="%s">Activation Link</a>'),$data->activation_link)?></p>
               
        <p><?php _e("Have a great Day!",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
