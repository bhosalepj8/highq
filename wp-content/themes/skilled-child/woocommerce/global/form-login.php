<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>

<form method="post" class="login" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>

	<p class="form-row form-row-first">
		<label for="username"><?php _e( 'Email address', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="username" id="username" />
	</p>
	<p class="form-row form-row-last">
		<label for="password"><?php _e( 'Password', 'woocommerce' ); ?></label>
		<input class="input-text" type="password" name="password" id="password" class='form-control' />
	</p>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<p class="form-row">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
<!--		<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
		</label>-->
                &nbsp;&nbsp;<strong><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Forgot your password?', 'woocommerce' ); ?></a></strong>
	</p>
	<p class="lost_password">
		<!--<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>-->
	</p>

	<div class="clear"></div>
        <p class="register-para">
            <?php _e( '', 'woocommerce' ); ?>
            <a href="<?php echo get_permalink( get_page_by_path( 'student-registration' ) ); ?>" class="register-student">Register as Student</a> 
            <a href="<?php echo get_permalink( get_page_by_path( 'tutor-registration' ) ); ?>" class="register-tutor">Register as Tutor</a>
        </p>
	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
