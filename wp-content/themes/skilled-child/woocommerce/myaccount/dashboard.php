<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<p  class="dashboard-para">
	<?php
		echo sprintf( esc_attr__( 'Hello %s%s%s (not %2$s? %sLog out%s)', 'woocommerce' ), '<strong>', esc_html( $current_user->display_name ), '</strong>', '<a href="' . esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a>' );
	?>
</p>

<p class="dashboard-para">
	<?php
		echo sprintf( esc_attr__( 'From your account dashboard you can view your %1$srecent orders%2$s, manage your %3$sbilling address%2$s and %4$sedit your password and account details%2$s.', 'woocommerce' ), '<a href="' . esc_url( wc_get_endpoint_url( 'my-orders' ) ) . '">', '</a>', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">', '<a href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' );
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );
        $user_id = get_current_user_id();
        $arr_userdata = get_userdata( $user_id );
        if($arr_userdata->roles[0] == 'student'){
                //echo '<div class="student-registration ">';
            wc_print_notice('<p>Want to learn something new? <a href="'.get_site_url().'/courses/academic-courses/" class="search-btn" target="_blank">Search & book a course </a>&nbsp;or <a href="'.get_site_url().'/tutors/academic-courses/" class="search-btn" target="_blank">A 1on1 Tutoring Session</a></p>','notice');
            wc_print_notices();
            echo do_shortcode('[edit_user_form role="student" viewmode="1"]');
            echo do_shortcode('[my_account role="student"]');
            //echo '</div>';
        }
        if($arr_userdata->roles[0] == 'tutor'){
            $is_approved = get_user_meta(get_current_user_id(),'is_approved',true);
            if($is_approved == 0){
                wc_print_notice('<p>Please upload all the documents by clicking on <a href="'.get_site_url().'//tutor-account-edit//" class="search-btn" target="_blank">Edit</a> link</p>','notice');
            }
            echo do_shortcode('[edit_user_form role="tutor" viewmode="1"]');
            echo do_shortcode('[my_account role="tutor"]');
        }
                        
        
	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
?>
