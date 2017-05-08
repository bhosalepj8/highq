<?php
/**
 * Scribblar Frontend
 *
 * A class to control the WordPress front-end when using Scribblar
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.14
 */
class ScribblarFrontend extends ScribblarCore
{
    function init()
    {
        parent::init();

        add_action('wp_enqueue_scripts', array( __CLASS__, 'add_frontend_room_js_and_css' ) );

        // Stop Login from revealing the backend
        add_action( 'wp_login_failed', array( __CLASS__, 'login_fail' ) );

    }


    /**
     * Add the frontend room JS and CSS to the WP Head.
     *
     * @param void
     *
     * @return void
     */
    static function add_frontend_room_js_and_css( )
    {
        $post_type = get_post_type();

        if ( 'room' !== $post_type ){ return ''; }

        wp_register_style( 'scribblar-frontend-css', plugins_url('assets/css/scribblar-frontend.css', dirname(__FILE__) ) );
        wp_enqueue_style( 'scribblar-frontend-css' );

        wp_register_script( 'scribblar-frontend-js', plugins_url('assets/js/scribblar-frontend.js', dirname(__FILE__) ), array('jquery'), 2, false );
        wp_enqueue_script( 'scribblar-frontend-js' );
    }


    static function login_fail( $username ) {
        $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
        // if there's a valid referrer, and it's not the default log-in screen
        if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
            wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
            exit;
        }
    }

}
