<?php
/**
 * Scribblar Admin
 *
 * A set of functions to output pages in the administration system
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.14
 */

include( SCRIBBLARPATH . 'classes/scribblar-user.php' );

class ScribblarAdmin extends ScribblarCore
{

	static $account_settings;// Used to store the account details from the API.
	static $merged_settings;// Used to store the merged settings between the API and WP Options.
	static $display_activation_message = false;

    function init()
    {
        parent::init();

        // Support installation and uninstallation
		register_activation_hook( $this->plugin_file, array( __CLASS__, 'install' ) );
		register_deactivation_hook( $this->plugin_file, array( __CLASS__, 'uninstall' ) );

		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'settings_init' ) );

		add_action('init', array( __CLASS__, 'register_styles_and_scripts' ) );

		add_action('admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		$settings = self::get_settings();
		if ( !isset( $settings['api_key'] ) || ( isset( $settings['api_key'] ) && empty( $settings['api_key'] ) )
			|| ( !isset( $settings['api_key'] ) &&  !isset($_POST['submit'] ) ) ) {

			self::$display_activation_message = true;

			add_action('admin_notices', array( __CLASS__, 'api_activation_warning') );
		}
    }

	/**
	 * Register the styles and scripts
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function register_styles_and_scripts()
    {
		wp_register_script( 'scribblar-admin', plugins_url('assets/js/scribblar-admin.js', dirname(__FILE__) ), array('wp-color-picker', 'jquery'), 2, true );

		wp_register_script( 'scribblar-image-uploader', plugins_url('assets/js/scribblar-media-uploader.js', dirname(__FILE__) ), array('jquery'), 2, true );
    }


	/**
	 * Enqueue the scripts
	 *
	 * @param string $hook
	 *
	 * @return void
	 */
	static function enqueue_scripts( $hook )
	{
		wp_enqueue_script('jquery');

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script('scribblar-admin');

	}


	/**
	 * Set up the administration menu
	 *
	 * @param void
	 *
	 * @return void
	 */
    static function admin_menu()
    {
		add_options_page( 'Scribblar settings', 'Scribblar settings', 'edit_plugins', 'scribblar-settings', array( __CLASS__,'settings_page' ) );

		add_submenu_page( null, 'Scribblar API', 'Scribblar API', 'edit_plugins', 'scribblar-api', array( __CLASS__,'api_page' ) );

		add_submenu_page( null, 'Copy Scribblar templates', 'Copy Scribblar templates', 'edit_plugins', 'scribblar-copy-templates', array( __CLASS__,'copy_templates' ) );

		add_submenu_page( '', 'Add user to Scribblar', 'Add user to Scribblar', 'edit_users', 'scribblar-add-user', array( 'ScribblarUser','add_user_to_scribblar' ) );

    }


    /**
     * Install the plugin and create the database.
     *
     * @param void
     * @return void
     */
    static function install()
    {
		parent::install();
    }

    /**
     * Uninstall the plugin and create the database.
     *
     * @param void
     * @return void
     */
    static function uninstall()
    {
		parent::uninstall();
    }


    /**
     * The most viewed index page
     *
     * @param void
     * @return void
     */
    static function index_page()
    {
		self::include_view( 'index' );
    }


	/**
	 * Init the settings API
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function settings_init()
	{
		register_setting(
            'scribblar_api_group', // Option group
            'scribblar_settings', // Option name
            array( __CLASS__, 'sanitise_api' ) // Sanitise
        );

        add_settings_section(
            'setting_api', // ID
            'API Settings', // Title
            array( __CLASS__, 'print_section_info' ), // Callback
            'scribblar-api-admin' // Page
        );

        add_settings_field(
            'scribblar_api',
            'Scibblar API key',
            array( __CLASS__, 'api_callback' ),
            'scribblar-api-admin',
            'setting_api'
        );

		register_setting(
			'scribblar_account_group',
			'scribblar_account',
			array( __CLASS__, 'sanitise_account' )
		);

		add_settings_section(
            'account_settings', // ID
            'Account details', // Title
            array( __CLASS__, 'print_account_info' ), // Callback
            'scribblar-account-admin' // Page
        );


		add_settings_field( 'logo_url', 'Logo', array( __CLASS__, 'logo_url_callback' ), 'scribblar-account-admin', 'account_settings' );
		add_settings_field( 'logo_clickurl', 'Logo click URL', array( __CLASS__, 'logo_clickurl_callback' ), 'scribblar-account-admin', 'account_settings');
		add_settings_field( 'support_mail', 'Support email address', array( __CLASS__, 'support_mail_callback' ), 'scribblar-account-admin', 'account_settings' );
		add_settings_field( 'gradient_from', 'Gradient from', array( __CLASS__, 'gradient_from_callback' ), 'scribblar-account-admin', 'account_settings' );
		add_settings_field( 'gradient_to', 'Gradient to',  array( __CLASS__, 'gradient_to_callback' ), 'scribblar-account-admin', 'account_settings' );


	}


	/*
	 * Print the section info above the Scribblar settings
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function print_section_info()
	{
		echo '<p>From here you can change your Scribblar configuration.</p>';
	}

	/*
	 * Print the section info above the account settings
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function print_account_info()
	{
		echo '<p>From here you can change your Scribblar account details.</p>';
	}


	/*
	 * API callback function
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function api_callback()
    {
		return self::text_callback( 'api_key', 'scribblar_settings' );
    }


	/*
	 * Logo URL callback
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function logo_url_callback()
    {
		return self::image_callback( 'logo_url', 'scribblar_account' );
    }


	/*
	 * Click URL callback
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function logo_clickurl_callback()
    {
		return self::text_callback( 'logo_clickurl', 'scribblar_account' );
    }


	/*
	 * Support email callback
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function support_mail_callback()
    {
		return self::text_callback( 'support_mail', 'scribblar_account' );
    }


	/*
	 * Gradient from callback
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function gradient_from_callback()
    {
		return self::colour_picker_callback( 'gradient_from', 'scribblar_account' );
    }


	/*
	 * Gradient to callback
	 *
	 * @param void
	 *
	 * @return string
	 */
	static public function gradient_to_callback()
    {
		return self::colour_picker_callback( 'gradient_to', 'scribblar_account' );
    }


	/*
	 * General text callback
	 *
	 * @param void
	 *
	 * @return void
	 */
	static public function text_callback( $option_name, $option_group = 'scribblar_account' )
    {
		if ( 'scribblar_settings' == $option_group ){
			$settings = self::get_settings( );
		} else {
			$settings = self::merge_settings_with_api_settings();
		}

        printf(
            '<input class="all-options" id="%2$s" name="%3$s[%2$s]" value="%s" />',
            isset( $settings[ $option_name ] ) ? esc_attr( $settings[ $option_name ]) : '', $option_name, $option_group
        );
    }


	/*
	 * Colour picker callback
	 *
	 * @param void
	 *
	 * @return void
	 */
	static public function colour_picker_callback( $option_name, $option_group = 'scribblar_settings' )
    {
		$using_api = $settings = null;

		$settings = self::merge_settings_with_api_settings();

		if ( ! isset( $settings[ $option_name ] ) || empty( $settings[ $option_name ] ) ){
			$details = self::get_account_settings();
			$settings[ $option_name ] = isset( $details[ $option_name] ) && !empty( $details[ $option_name] )? esc_attr( $details[ $option_name] ) : null ;

			$using_api = true;
		}

        printf ('<input type="text" class="all-options color-picker" id="%2$s" name="%3$s[%2$s]" value="%1$s" data-default-color="%1$s" />', '#'.$settings[ $option_name ], $option_name, $option_group );
    }


	/*
	 * Image callback
	 *
	 * @param void
	 *
	 * @return void
	 */
	static public function image_callback( $option_name, $option_group = 'scribblar_settings' )
	{
		wp_enqueue_media();

		wp_enqueue_script('scribblar-image-uploader');

		$settings = self::merge_settings_with_api_settings();
		?>
		<div class="uploader">
			<input type="text" name="<?php echo $option_group . '['. $option_name .']';?>" id="<?php echo $option_name; ?>" value="<?php echo $settings[ $option_name ]; ?>" />
			<input class="button button-primary" name="<?php echo $option_name;?>" id="<?php echo $option_name; ?>_button" value="Select / Upload" />
		</div>
		<?php

		/* printf ('<input type="text" class="all-options" id="%2$s" name="%3$s[%2$s]" value="%1$s" />',
            $settings[ $option_name ], $option_name, $option_group );
            */

		printf('<div id="%1$s">', $option_name.'_preview');

		if ( !empty( $settings[ $option_name ] ) ){
			printf( '<br /><img src="%s" alt="Logo" width="250px"/>', $settings[ $option_name ] );
		}

		echo '</div>';

	}


	/*
	 * Sanitize the API information
	 *
	 * @param string $input
	 *
	 * @return string
	 */
	static function sanitise_api( $input )
	{
		$new_input = array();
        if( isset( $input['api_key'] ) ){
            $new_input['api_key'] = esc_attr( $input['api_key'] );
        }
        return $new_input;
	}


	/*
	 * Sanitize the account information
	 *
	 * @param string $input
	 *
	 * @return string
	 */
	static function sanitise_account( $input )
	{
		$new_input = array();

		/* @todo if the module is enabled let's try to cURL the image to make sure it's valid */
		$new_input['logo_url'] 		= isset( $input['logo_url'] )? esc_url( $input['logo_url'] ) : '' ;

		$new_input['logo_clickurl'] = isset( $input['logo_clickurl'] )? esc_url( $input['logo_clickurl'] ) : '' ;

		if ( isset( $input['support_mail'] ) && is_email( $input['support_mail'] )){
			$new_input['support_mail'] = esc_attr( $input['support_mail'] );
		}else{
			add_settings_error( 'scribblar_account', 'invalid-email', 'You have entered an invalid e-mail address.' );
		}

		$new_input['gradient_from'] = isset( $input['gradient_from'] ) && !empty( $input['gradient_from'] )? str_replace( '#', '', esc_attr( $input['gradient_from'] ) ) : '';

		$new_input['gradient_to'] 	= isset( $input['gradient_to'] ) && !empty( $input['gradient_to'] )? str_replace( '#', '', esc_attr( $input['gradient_to'] ) ) : '';

		// Now let's try to update the settings using the  Scribblar API
		$errors = get_settings_errors( 'scribblar_account' );

		if ( count( $errors ) == 0 ){
			$result = ScribblarApi::update_account( $new_input );
		}

		return $new_input;
	}


	/*
	 * Output the settings page
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function settings_page()
	{
		$hide_form = false;

		if ( true == self::$display_activation_message ){
			self::api_activation_warning( true );
			$hide_form = true;
		}
		$details = self::get_account_settings();

		self::include_view( 'settings' );
	}


	/**
	 * Output the API settings page
	 *
	 * @param void
	 *
	 * @return void
	 */
	static function api_page()
	{
		self::include_view( 'api' );
	}


	/*
	 * Get the account settings
	 *
	 * @param void
	 *
	 * @return array
	 */
	static function get_account_settings()
	{
		if ( isset( self::$account_settings )  && !empty( self::$account_settings ) ){
			return self::$account_settings;
		}

		$detail = ScribblarApi::get_account();

		if ( isset( $detail['result'] ) && !empty( $detail['result'] ) ){
			self::$account_settings = $detail['result'];
		} else{
			self::$account_settings = array();
		}

		return self::$account_settings;
	}


	/*
	 * Merge the WordPress settings with the Scribblar API results.
	 *
	 * The Scribblar results take precedence over the WordPress settings.
	 *
	 * @param void
	 *
	 * @return array
	 */
	static function merge_settings_with_api_settings(){
		if ( isset( self::$merged_settings ) ){
			return self::$merged_settings;
		}

		$details = array('logo_url' => null, 'logo_clickurl' => null, 'support_mail' => null, 'gradient_to' => null, 'gradient_from'=>null);
		$settings 		= self::get_settings( 'scribblar_account', true );
		$api_details 	= self::get_account_settings();

		if( !is_array( $settings) ){
			$settings = array( $settings );
		}

		if( !is_array( $api_details) ){
			$settings = array( $api_details );
		}

		self::$merged_settings = array_merge( $details, $settings, $api_details );

		return self::$merged_settings;
	}


	/**
	 * Display a message informing the user to provide the API key for Scribblar
	 *
	 */
	static public function api_activation_warning( $override_display = false ) {
		global $hook_suffix;

		$display_activation_message = false;

		if( true == $override_display ){
			$display_activation_message = true;
		}

		if( 'plugins.php' == $hook_suffix ){
			$display_activation_message = true;
		}

		if( 'edit.php' == $hook_suffix && isset( $_GET['post_type'] ) && ( 'room' == $_GET['post_type'] ) ){
			$display_activation_message = true;
		}

		if ( true == $display_activation_message ) {
            echo '<div class="updated">';
			echo '<p>';
			echo sprintf( __('To make full use of Scribblar on your site, please <a href="%s" class="button  button-primary">Activate your license</a>', 'scribblar'), 'options-general.php?page=scribblar-api');
			echo '<p/>';
			echo '</div>';
   		}
	}

	/*
	 * Output the copy template page
	 *
	 * @param void
	 *
	 * @return array
	 */
	static function copy_templates()
	{
		$error = $message = null;

		// Get the theme directory.
		$stylesheet_directory = get_stylesheet_directory();
		$scribblar_template_directory = realpath( dirname( dirname( __FILE__ ) ) . '/templates' );

		self::include_view( 'copy-templates' );
	}

}
