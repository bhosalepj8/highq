<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->student_name)?></p>
        
        <p><?php printf( __( 'This is to remind you of your tutoring/ coaching session tomorrow %s with <strong>%s</strong> at %s.'),$data->session_date, $data->tutor_name, $data->session_time)?></p>
        
        <p><?php _e("Please login 10 minutes before your lesson and check your computer to see that it is working well in the virtual classroom.",'woocommerce'); ?></p>
        
        <p><?php _e('If you have any problems, please contact our support team and we will be glad to assist.','woocommerce'); ?></p>
        
        <p><?php _e('We look forward to meeting you at your next session and working with you towards becoming a <strong>“Successful Learners!”</strong>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
