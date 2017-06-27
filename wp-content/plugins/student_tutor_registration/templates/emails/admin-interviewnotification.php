<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

        <p><?php _e("Hello admin,",'woocommerce'); ?></p>

        <p><?php printf( __( 'You have received a registration request from a tutor %s.'),$data->tutor_name)?></p>
        
        <p><?php _e("You should have received a copy of the email sent to the tutor asking for completion of required documentation.",'woocommerce'); ?></p>
        
        <p><?php _e("Within the next 48 hours, please do the following:",'woocommerce'); ?></p>
        
        <p><?php _e("1)	Arrange to schedule an interview and trial lesson with the Tutor in order to review and approve this tutor to your portal.",'woocommerce'); ?></p>
        
        <p><?php _e("2)	Follow up and ensure that all he necessary documentation has been received in good order and uploaded to the Tutor’s registration page. ",'woocommerce'); ?></p>
               
        <p><?php _e("Thank you.",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
