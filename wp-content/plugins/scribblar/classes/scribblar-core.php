<?php
/**
 * Scribblar Core
 *
 * A set of core functions shared between frontend and the adminstration system
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.15
 */

 // Include the logging functions
include_once( SCRIBBLARPATH . 'classes/scribblar-logging.php' );

include( SCRIBBLARPATH . 'classes/scribblar-api.php' );

include( SCRIBBLARPATH . 'classes/scribblar-user.php' );

include( SCRIBBLARPATH . 'classes/scribblar-cron.php' );


class ScribblarCore
{
    var $plugin_file, $plugin_path, $plugin_url;

    static $log_dir_path = '';
	static $log_dir_url  = '';
    static $wpdb;
    static $settings;


    public static $logger;
    public static $debug = true;


    public static $option_name 	= 'scribblar_settings';

    function __construct()
    {
		global $wpdb;
        self::$wpdb         = $wpdb;
        $this->plugin_file  = dirname( dirname( __FILE__ ) ) . '/scribblar.php';
        $this->plugin_path  = dirname( dirname( __FILE__ ) ) . '/';

        $this->plugin_url   = plugin_dir_url(dirname( __FILE__ ) );

        add_action('init', array( __CLASS__, 'register_post_type' ) );
		// self::add_metaboxes();

		register_activation_hook( $this->plugin_file, array( __CLASS__, 'install' ) );
		register_deactivation_hook( $this->plugin_file, array( __CLASS__, 'uninstall' ) );


		// Add the Scribblar actions and filtes.
		self::add_actions();
		self::add_filters();

		// Setup the user class and fields.
		ScribblarUser::init();
    }

    static function register_post_type()
    {
		include( SCRIBBLARPATH . 'classes/scribblar-room.php' );

		ScribblarRoom::init();
    }

	static function add_metaboxes()
	{
		// include( SCRIBBLARPATH . 'classes/scribblar-metaboxes.php' );
	}


	static function add_actions()
	{
		add_action( 'scribblar_sanitise_settings', array( 'ScribblarAdmin', 'sanitise_account'), 10, 1 );

		/** Room actions **/
		add_action( 'scribblar_api_room_list', 		array( 'ScribblarRoom', 'action_api_room_list'), 10, 2 );

		add_action( 'scribblar_api_room_add', 		array( 'ScribblarRoom', 'action_api_room_add'), 10, 2 );
		add_action( 'scribblar_api_room_edit', 		array( 'ScribblarRoom', 'action_api_room_edit'), 10, 2 );
		add_action( 'scribblar_api_room_delete', 	array( 'ScribblarRoom', 'action_api_room_delete'), 10, 2 );

		add_action( 'scribblar_api_user_add', 		array( 'ScribblarUser', 'action_api_user_add'), 10, 2 );
		add_action( 'scribblar_api_user_edit', 		array( 'ScribblarUser', 'action_api_user_edit'), 10, 2 );

		add_action( 'scribblar_hourly_event', 		array( 'ScribblarCron', 'api_sync'), 10, 2);

	}


	static function add_filters()
	{
		// Let's include our own template if there isn't one already for the single-room.php in the theme directory
		add_filter( 'template_include', array( __CLASS__, 'template_chooser' ) );
		
		add_filter( 'http_request_timeout', array( __CLASS__, 'filter_timeout_time' ) );
	}


	static function scribblar_action_links( $links ) {

		return array_merge(
					array(
						  '<a href="' . admin_url( 'options-general.php?page=scribblar-api' ) . '">' . __( 'API Settings' ) . '</a>' , ),
					$links );
	}

    static function register_styles_and_scripts()
    {
		// Stub
    }

    static function enqueue_frontend_styles_and_scripts()
    {
		// Stub
    }

    function get_plugin_file()
    {
        return $this->plugin_file;
    }

    function get_plugin_path()
    {
        return $this->plugin_path;
    }

    function get_plugin_url()
    {
        return $this->plugin_url;
    }

    function init()
    {
    }

    static function install()
    {
		ScribblarCron::activate();
    }

    static function uninstall()
    {
		ScribblarCron::deactivate();
    }

	static function api_sync()
	{
		ScribblarCron::sync_rooms();

		ScribblarCron::sync_users();
	}

	function createLogger(){
        if ( ! isset( self::$logger ) ){
            self::$logger = new ScribblarLogging();
        }
        return self::$logger;
    }

    /**
     * Log messages, if in debug mode.
     *
     * @param string $message
     * @param string $type || null
     * @return boolean TRUE || FALSE
     */
    function log ( $message, $type = 'message' ){

        if ( ! self::$debug ){
            return false;
        }

        if ( ! self::$logger ){
            self::createLogger();
        }

        self::$logger->log( $message , $type );
        return true;
    }

    /**
	 * Log errors to a file
	 *
	 * @since 0.2
	 **/
	private static function log_errors( $errors ) {
		if ( empty( $errors ) )
			return;

		$log = @fopen( self::$log_dir_path . 'scribblar_errors.log', 'a' );
		@fwrite( $log, sprintf( __( 'BEGIN %s' , 'ivcpd'), date( 'Y-m-d H:i:s', time() ) ) . "\n" );

		foreach ( $errors as $key => $error ) {
			$line = $key + 1;
			$message = $error->get_error_message();
			@fwrite( $log, sprintf( __( '[Line %1$s] %2$s' , 'scribblar'), $line, $message ) . "\n" );
		}

		@fclose( $log );
	}


    /*
     * Get the plugin settings
     *
     * @param void
     *
     * @return array
     */
    static function get_settings( $option_name = null, $force_reload = false )
    {
        $settings = ScribblarCore::$settings;

		if ( $force_reload == true ){ $settings = array(); }

        if ( ( isset( $settings ) && !empty ( $settings ) && count( $settings ) > 0 ) ){
            return $settings;
        } else {
			if ( ! $option_name ){
				$option_name = ScribblarCore::$option_name;
			}
            ScribblarCore::$settings = get_option( $option_name );
            return ScribblarCore::$settings;
        }
    }

    /*
     * Save the plugin settings
     *
     * @param array $settings_to_save
     *
     * @return array
     */
    static function save_settings( $settings_to_save ){

        update_option( ScribblarCore::$option_name, $settings_to_save );

        ScribblarCore::$settings = $settings_to_save;

        return ScribblarCore::$settings;
    }


	static function include_view( $view, $data_for_view = null )
	{
		if ( $data_for_view )
		{
			extract($data_for_view);
		}

		$filepath = SCRIBBLARPATH . 'views/'.$view.'.php';
		if ( file_exists( $filepath ) ){
			include( $filepath );
		} else{
			include( SCRIBBLARPATH . 'views/index.php' );
		}
	}



	static function update_room_via_api( $post_id, $data = array() )
	{


	}



	public static function template_chooser( $template )
	{
	 	$post_id = get_the_ID();

	    if ( 'room' !== get_post_type( $post_id ) ) { return $template; }

	    if ( is_single() ) {
	        return self::get_template_hierarchy( 'single-room' );
	    }
	}


	public static function get_template_hierarchy( $template ) {
	    // Get the template slug
	    $template_slug = rtrim( $template, '.php' );
	    $template = $template_slug . '.php';

	    // Check if a custom template exists in the theme folder, if not, load the plugin template file
	    if ( $theme_file = locate_template( array( $template ) ) ) {
	        $file = $theme_file;
	    } else {
	        $file = SCRIBBLARPATH . '/templates/' . $template;
	    }
	    return apply_filters( 'scribblar_template_' . $template, $file );
	}
	
	
	/**
	 * Change the WordPress HTTP timeout limit
	 *
	 * @param integer $time
	 *
	 * @return integer
	 */
	public static function filter_timeout_time( $time ) {
		$time = 25; //new number of seconds
		return $time;	
	}

}
