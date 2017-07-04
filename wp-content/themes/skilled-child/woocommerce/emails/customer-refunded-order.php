<?php
/**
 * Customer refunded order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-refunded-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author   WooThemes
 * @package  WooCommerce/Templates/Emails
 * @version  2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<!--<p><?php
//	if ( $partial_refund ) {
//		printf( __( 'Hi there. Your order on %s has been partially refunded.', 'woocommerce' ), get_option( 'blogname' ) );
//	} else {
//		printf( __( 'Hi there. Your order on %s has been refunded.', 'woocommerce' ), get_option( 'blogname' ) );
//	}
?></p>-->
<p><?php 
if($order->payment_method == 'paypal'){
    if ( $partial_refund ) {
		printf( __( 'Hi there. Your order on %s has been partially refunded.', 'woocommerce' ), get_option( 'blogname' ) );
	} else {
		printf( __( 'Hi there. Your order on %s has been refunded.', 'woocommerce' ), get_option( 'blogname' ) );
	}
}else{
    printf( __( 'Hi there. Your session on %s has been refunded.', 'woocommerce' ), get_option( 'blogname' ) );
}
?></p>
<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_session_details', $order, $sent_to_admin, $plain_text, $email );
/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
if($order->payment_method == 'paypal'){
?>
<p><?php _e('Thank you for joining the Highq community and giving us the opportunity to work with you towards becoming a <strong>“Successful Learner !“</strong>','woocommerce'); ?></p>
<?php }else{
    $messaging_system = get_site_url().'/my-account/my-inbox/?fepaction=newmessage'
 ?>    
<!--<p><?php printf( __( "If you are doing a 1 on 1 session, please email your requirements for the lesson  to your tutor by accessing our messaging system <a href='%s'> messaging system</a>.  This will allow you to get the most out of your lesson.", 'woocommerce' ), $messaging_system ); ?></p>-->

<p><?php _e('We look forward to meeting you at your next session and working with you towards becoming a <strong>“Successful Learner !“</strong>','woocommerce'); ?></p>
<?php } ?>

<p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php do_action( 'woocommerce_email_footer', $email );
