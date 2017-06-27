<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->user_name)?></p>
        
        <p><?php _e("Good news! New courses now available online.",'woocommerce'); ?></p>
        
        <p><?php printf( __( 'Click on %s and find out more about these new and exciting courses on offer.'),$data->course_page)?></p>
        
        <p><?php _e('We look forward to meeting you online and working with you towards becoming that <b>“Successful Learner!“</b>','woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
