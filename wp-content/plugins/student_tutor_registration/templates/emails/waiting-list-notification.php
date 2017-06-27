<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->user_name)?></p>
        
        <p><?php printf( __( '%s you had requested has seats available now.'),$data->course_name)?></p>
        
        <p><?php _e("Please click on below link to book your seats:",'woocommerce'); ?></p
        
        <p><?php printf( __( '<a href="%s" target="_blank">%s</a>'),$data->course_detail_page)?></p>
        
        <p><?php _e('Thank you once again for being part of the Highq community; where we always strive to create <b>“Successful Learner!“</b>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
