<?php

/*
  Plugin Name: WP User
  Plugin URI: http://www.wpseeds.com/wp-user/
  Description: Create elegant Login, Register, and Forgot Your Password form on Page or Popups on your website, in just minutes in AngularJs.
  Author: Prashant Walke
  Version: 2.7.1
  Author URI: https://walkeprashant.in
  Text Domain: wpuser
  Domain Path: /lang
  License: GPLv2
 */

/*
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('WPUser')) :

    final class WPUser {

        public $version = '2.7.1';
        public $WPUSERprefix = "wpuser";
        protected static $_instance = null;
        public $query = null;

        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __clone() {
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), '1.0');
        }

        public function __construct() {
            // Define constants
            $this->define_constants();
            register_activation_hook(__FILE__, array($this, 'installation'));
            register_activation_hook(__FILE__, array($this, 'my_plugin_install_function'));
            add_action('plugins_loaded', array($this, 'load_textdomain'));
            $this->installation();
            // Include required files		
            $this->includes();
        }

         function my_plugin_install_function() {
            //post status and options
            $post = array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => 1,
                'post_date' => date('Y-m-d H:i:s'),
                'post_name' => 'User',
                'post_status' => 'publish',
                'post_title' => 'User',
                'post_content' => '[wp_user]',
                'post_type' => 'page',
            );
            //insert page and save the id
            $newvalue = wp_insert_post($post, false);
            //save the id in the database
            update_option('wp_user_page', $newvalue);
        }

        private function define_constants() {
            define('WPUSER_PLUGIN_FILE', __FILE__);
            define('WPUSER_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('WPUSER_PLUGIN_DIR', plugin_dir_path(__FILE__));
            define('WPUSER_TEMPLETE_URL', plugin_dir_url(__FILE__) . 'includes/admin/views/');
            define('WPUSER_USER_TEMPLETE_URL', plugin_dir_url(__FILE__) . 'includes/user/views/');
            define('WPUSER_USER_i18n', plugin_dir_url(__FILE__) . 'i18n');

            
            define('WPUSER_VERSION', $this->version);
            define('WPUSER_PREFIX', $this->WPUSERprefix);
            define('WPUSER_TYPE', 'FREE');
            define('WPUSER_ENV', 'LIVE'); //LIVE OR DEV    
        }

        function includes() {
            include_once( 'includes/admin/class-admin-assets.php' );
            include_once( 'includes/admin/class-admin-settings.php' );
            if (is_admin()) {
                include_once(WPUSER_PLUGIN_DIR . 'includes/admin/controller/settingController.php' );
                $WPUserSetting = new WPUserSetting();

                add_action('wp_ajax_wpuser_getSetting', array($WPUserSetting, 'get_setting'));
                add_action('wp_ajax_wpuser_addSetting', array($WPUserSetting, 'add_setting'));
                add_action('wp_ajax_wpuser_editSetting', array($WPUserSetting, 'edit_setting'));
                add_action('wp_ajax_wpuser_updateSetting', array($WPUserSetting, 'update_setting'));
                add_action('wp_ajax_wpuser_updatePageSetting', array($WPUserSetting, 'update_page_setting'));
                add_action('wp_ajax_wpuser_deleteSetting', array($WPUserSetting, 'delete_setting'));
            }
            include_once(WPUSER_PLUGIN_DIR . 'includes/user/controller/loginController.php' );
            $WPUserFrontEnd = new WPUserFrontEnd();
            //add_action( 'wp_ajax_wpuser_login_action', array( $WPUserFrontEnd, 'wpuser_login' ) );
            //add_action( 'wp_ajax_wpuser_forgot_action', array( $WPUserFrontEnd, 'wpuser_forgot' ) );
            //add_action( 'wp_ajax_wpuser_register_action', array( $WPUserFrontEnd, 'wpuser_register' ) );
            //executes for users that are not logged in.
            add_action('wp_ajax_nopriv_wpuser_login_action', array($WPUserFrontEnd, 'wpuser_login'));
            add_action('wp_ajax_nopriv_wpuser_forgot_action', array($WPUserFrontEnd, 'wpuser_forgot'));
            add_action('wp_ajax_nopriv_wpuser_register_action', array($WPUserFrontEnd, 'wpuser_register'));
            add_action('wp_ajax_nopriv_wpuser_getSettingLogin', array($WPUserFrontEnd, 'get_setting_login'));
            add_action('wp_ajax_nopriv_wpuser_getSettingRegister', array($WPUserFrontEnd, 'get_setting_register'));


            include_once( 'includes/user/shortcode.php' );
        }

        function installation() {
            include('includes/installation.php');
        }

        function load_textdomain() {
             load_plugin_textdomain('wpuser',plugin_dir_path(__FILE__) . '/i18n', plugin_dir_path(__FILE__) . '/i18n');
        }

    }

    endif;

function WPUserFunction() {
    return WPUser::instance();
}

$GLOBALS['WPUser'] = WPUserFunction();
