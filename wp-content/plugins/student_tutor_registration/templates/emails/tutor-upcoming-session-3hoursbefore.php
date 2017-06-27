<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->tutor_name)?></p>
        
        <p><?php printf( __( 'This is to remind you of your tutoring/ coaching session , scheduled today %s in 3 hours at %s.'),$data->session_date, $data->session_time)?></p>
        
        <p><?php _e("Please login 10 minutes before your lesson and check your computer to see that it is working well in the virtual classroom.",'woocommerce'); ?></p>
        
        <p><?php _e('If you have any problems, please contact our support team and we will be glad to assist.','woocommerce'); ?></p>
        
        <p><?php _e('Thank you for being part of the HIghq community and working with us towards building a <strong>“World of Successful Learners!”</strong>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
