<?php
/*
Plugin Name: Scribblar
Description: A plugin to make it easier to integrate Scribblar with your WordPress site.
Version: 1.0.21
Author: Scribblar
Author URI: http://scribblar.com/
*/

$api_url = 'http://plugin.duefriday.com/';
$plugin_slug = basename(dirname(__FILE__));


if ( version_compare( $GLOBALS['wp_version'], '3.3', '<' ) || !function_exists( 'add_action' ) ) {
    if ( !function_exists( 'add_action' ) ) {
	$exit_msg = 'I\'m just a plugin, please don\'t call me directly';
    } else {
	$exit_msg = sprintf( __( 'This version of Most viewed requires WordPress 3.3 or greater.' ) );
    }
    exit( $exit_msg );
}

define( 'SCRIBBLARPATH',   	trailingslashit( dirname( __FILE__ ) ) );
define( 'SCRIBBLARDIR',   	trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
define( 'SCRIBBLARDURL',	plugin_dir_url( dirname( __FILE__ ) ) . SCRIBBLARDIR );

load_plugin_textdomain( 'scribblar', false, basename( dirname( __FILE__ ) ) . '/languages' );

// Set maximum execution time to 5 minutes - won't affect safe mode
$safe_mode = array( 'On', 'ON', 'on', 1 );
if ( !in_array( ini_get( 'safe_mode' ), $safe_mode ) && ini_get( 'max_execution_time' ) < 300 ) {
    @ini_set( 'max_execution_time', 300 );
}

global $scribblar;

//if ( ! class_exists( 'ScribblarUser' ) ){
//	require_once( SCRIBBLARPATH . 'classes/scribblar-user.php' );
//}

/**
 * Now let's load the main classes, depending upon if we are in the admininstration system
 */
require_once( SCRIBBLARPATH . 'classes/scribblar-core.php' );
if ( is_admin() ) {
    require_once( SCRIBBLARPATH . 'classes/scribblar-admin.php' );
    $scribblar = new ScribblarAdmin();
} else {
    require_once( SCRIBBLARPATH . 'classes/scribblar-frontend.php' );
    $scribblar = new ScribblarFrontend();
}

$scribblar->init();


/*************
 * WP Cron functionality
 *
 *************/



//add_action( 'scribblar_hourly_event', 'api_sync', 10, 2);

//function api_sync()
//{
//	ScribblarCron::api_sync();
//}


/*************
 * Plugin update functionality
 *
 *************/

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');

function check_for_plugin_update($checked_data) {
	global $api_url, $plugin_slug, $wp_version;

	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;

	$args = array(
		'slug' => $plugin_slug,
		'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
	);

	$request_string = array(
			'body' => array(
				'action' => 'basic_check',
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	// Start checking for an update
	$raw_response = wp_remote_post($api_url, $request_string);

	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;

	return $checked_data;
}


// Take over the Plugin info screen
add_filter('plugins_api', 'plugin_api_call', 10, 3);

function plugin_api_call($def, $action, $args) {
	global $plugin_slug, $api_url, $wp_version;

	if (!isset($args->slug) || ($args->slug != $plugin_slug))
		return false;

	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version = $current_version;

	$request_string = array(
			'body' => array(
				'action' => $action,
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	$request = wp_remote_post($api_url, $request_string);

	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}

	return $res;
}
