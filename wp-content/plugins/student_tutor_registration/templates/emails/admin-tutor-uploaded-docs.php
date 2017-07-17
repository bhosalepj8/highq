<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Hello Admin,'))?></p>
    
        <p><?php printf( __( 'This is to advise that tutor %s(%s) has today uploaded the following documents as part of the registrations process:'),$data->tutor_name,$data->tutor_email)?></p>
        
        <p><?php _e("List of documents uploaded :",'woocommerce'); ?></p>
        
        <?php foreach ($data->upload_documents_list as $key => $value) { ?>
             
        <p><?php printf( __( '%s) %s.'),$key+1,$value)?></p>
        
        <?php }?>
        
        <p><?php _e("The following documents are still pending :",'woocommerce'); ?></p>
        
        <?php foreach ($data->remaining_docs_list as $key => $value) { ?>
             
        <p><?php printf( __( '%s) %s.'),$key+1,$value)?></p>
        
        <?php }?>
        
        <p><?php _e("An email has been sent to the tutor to complete the process. Please follow up with the tutor to complete the documentation process in order to get approved as a tutor on the portal.",'woocommerce'); ?></p>
        
        <p><?php _e("Warm Regards,<br>The Highq Team",'woocommerce'); ?></p>
        
<?php


do_action( 'woocommerce_email_footer', $email );
