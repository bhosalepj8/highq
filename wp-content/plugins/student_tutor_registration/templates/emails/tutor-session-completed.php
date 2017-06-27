<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->tutor_name)?></p>
        
        <!--<p><?php // printf( __( 'Your session was (no. of hours/ mins long).'),$data->session_interval)?></p>-->
        
        <p><?php _e("Congratulations! Your tutoring/coaching session has been successfully completed.",'woocommerce'); ?></p>
        
        <p><?php _e('In line with the Highq Policy and Requirements, please complete the follow up process and send to the student via the Highq messaging system:','woocommerce'); ?></p>
        
        <p><?php _e('1) Take screenshots of all whiteboards and screens used during the lesson and convert these into documents.','woocommerce'); ?></p>
        
        <p><?php _e('2) Upload all worksheets and screenshot documents and send to the student.','woocommerce'); ?></p>
        
        <p><?php _e('3) Send post lesson feedback to the student.','woocommerce'); ?></p>
        
        <p><?php _e('We hope your session was effective and we look forward to welcoming you back on our portal very soon.','woocommerce'); ?></p>
        
        <p><?php _e('If you wish to communicate with the student please do so by sending a message via the highq messaging system.','woocommerce'); ?></p>
        
        <p><?php _e('Thank you for being part of the HIghq community and working with us towards building a <strong>“World of Successful Learners!”</strong>','woocommerce'); ?></p>
        
        <p><?php _e('Have a great day!','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php

do_action( 'woocommerce_email_footer', $email );
