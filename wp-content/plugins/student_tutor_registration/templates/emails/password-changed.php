<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        <p><?php _e("This email confirms that your password has been changed.",'woocommerce'); ?></p>
        
        <p><?php _e("To log on to the site, use the following credentials:",'woocommerce'); ?></p>

        <p><?php printf( __( 'Username: %s'),$data->username)?></p>

        <p><?php printf( __( 'Password: %s'),$data->password)?></p>
        
        <p><?php _e("If you have any questions or encounter any problems logging in, please contact our support team at Support@highqedu.com.",'woocommerce'); ?></p>
        
        <p><?php _e("Lets build a community of <b>“Successful Learners”</b> together!",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
