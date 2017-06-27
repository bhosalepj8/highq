<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

        <p><?php _e("Hello admin,",'woocommerce'); ?></p>

        <p><?php printf( __( 'We have today received an application for tutor from %s.'),$data->tutor_name)?></p>
        
        <p><?php printf( __( 'Kindly review the initial application. If you wish to proceed further, please click (insert yes button) and if you do not wish to proceed further please click (no button).'))?></p>
               
        <p><?php _e("Warm Regards,",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
