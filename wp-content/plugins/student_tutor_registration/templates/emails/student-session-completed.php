<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->student_name)?></p>
        
        <!--<p><?php // printf( __( 'Your session was (no. of hours/ mins long).'),$data->session_interval)?></p>-->
        
        <p><?php _e("Congratulations! Your tutoring/coaching session has been successfully completed.",'woocommerce'); ?></p>
        
        <p><?php _e('We hope your session was effective and we look forward to welcoming you back on our portal very soon.','woocommerce'); ?></p>
        
        <p><?php _e('To help us improve the quality of our service, please rate your session before you logout.','woocommerce'); ?></p>
        
        <p><?php printf( __( 'If you wish to schedule any more sessions or courses, please click here <a href="%s">%s</a>'),$data->course_url)?></p>
        
        <p><?php _e('We look forward to meeting you at your next session and working with you towards becoming the <strong>“Successful Learners!”</strong>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
