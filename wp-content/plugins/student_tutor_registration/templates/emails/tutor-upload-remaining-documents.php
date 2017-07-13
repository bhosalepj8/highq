<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->tutor_name)?></p>

        <p><?php _e("Thank you for uploading the required documents as part of your registration process.",'woocommerce'); ?></p>
        
        <p><?php printf( __( 'The following documents are still pending. Please upload the same by clicking <a href="%s">%s</a>.'),$data->tutor_edit_link,$data->tutor_edit_link)?></p>
        
        <?php foreach ($data->remaining_docs_list as $key => $value) { ?>
             
        <p><?php printf( __( '%s) %s documents.'),$key+1,$value)?></p>
        
        <?php }?>
        
        <p><?php _e("Once all the requirements are complete, you will receive an email scheduling an interview and a trial lesson.",'woocommerce'); ?></p>
        
        <p><?php _e("After the interview, your application will be reviewed for final approval. Upon approval, you will receive an email and your profile will go live on Highq.",'woocommerce'); ?></p>
               
        <p><?php _e("Don’t forget to sign the terms and conditions!",'woocommerce'); ?></p>
        
        <p><?php _e("Looking forward to welcoming you to Highq and working with us in helping our students to <b>“Learn to make a Mark”</b> instead of just <b>“Learning for Marks!”</b>",'woocommerce'); ?></p>
        
        <p><?php _e("Warm Regards,",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
