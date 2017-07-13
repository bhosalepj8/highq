<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->tutor_name)?></p>

        <p><?php _e("Thank you for your application to register as a tutor with Highq.",'woocommerce'); ?></p>
        
        <p><?php printf( __( 'Please complete the following, after which you will be approved as a tutor on Highq. Please upload the following by <a href="%s">login to Highq account</a>.'),$data->login_link)?></p>
        
        <p><?php _e("1)Certified academic certificates(docx|rtf|doc|pdf).",'woocommerce'); ?></p>
        
        <p><?php _e('2)A brief teaching video (2-3 minutes) in the formats mentioned on the registration form(mp4|ogv|webm|mov|wmv).','woocommerce'); ?></p>
        
        <p><?php _e("3)Testimonials from existing students and/or parents  which can be put up on the portal.",'woocommerce'); ?></p>
        
        <p><?php _e("You will receive an email from us to schedule an interview and a trial lesson.",'woocommerce'); ?></p>
        
        <p><?php _e("We will review your application for final approval once all of the above are duly completed. Once approved, you will be intimated via email and your profile will go live on Highq.",'woocommerce'); ?></p>
               
        <p><?php _e("Don’t forget to sign the terms and conditions!",'woocommerce'); ?></p>
        
        <p><?php _e("Looking forward to welcoming you to Highq and working with us in helping our students to <b>“Learn to make a Mark”</b> instead of just <b>“Learning for Marks!”</b>",'woocommerce'); ?></p>
        
        <p><?php _e("Warm Regards,",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
