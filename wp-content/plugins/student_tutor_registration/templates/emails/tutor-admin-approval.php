<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->user_name)?></p>

        <p><?php _e("Congratulations and welcome to the Highq Community!",'woocommerce'); ?></p>
          
        <p><?php _e('Your registration is now approved and ready to go live! ','woocommerce'); ?></p>
                
        <p><?php printf( __( 'Your profile will now be made public on our <a href="'.get_site_url().'">portal</a>.'))?></p>
        
        <p><?php _e('Thank you for registering with Highq and we look forward to working together towards creating a <strong>“World of Successful Learners!”</strong>','woocommerce'); ?></p>
               
        <p><?php _e("Have a great Day!",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
