<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>


<p><?php printf( __( 'Dear %s,', 'woocommerce' ), $user_login ); ?></p>
<p><?php _e( 'We have received a request to reset the password for your highq account.', 'woocommerce' ); ?></p>
<p><?php _e( 'Simply click on the button to set a new password:', 'woocommerce' ); ?></p>
<p>
	<a class="search-btn" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), wc_get_endpoint_url( 'reset-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">
			<?php _e( 'Set a New Password', 'woocommerce' ); ?></a>
</p>
<p><?php _e( "If you didn't ask to change your password, don't worry! Your password is still safe and you can delete this email." , 'woocommerce' ); ?></p>
<p><?php _e( 'Lets build a community of <b>“Successful Learners”</b> together!', 'woocommerce' ); ?></p>
<p></p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
