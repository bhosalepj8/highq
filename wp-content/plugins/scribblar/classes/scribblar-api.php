<?php
/**
 * Scribblar API
 *
 * A set of functions to work with the scribblar API
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.18
 */

// Include the logging functions
include_once( SCRIBBLARPATH . 'classes/scribblar-logging.php' );

if( !class_exists( 'Scribblar_Xml' ) ){
    include_once( SCRIBBLARPATH . 'classes/scribblar-xml.php' );
}


class ScribblarApi
{

	static public $api_key, $settings;

	static private $api_url = 'https://api.scribblar.com/v1/';

	function __construct()
	{
		// Get the settings and the API key.
	}


	/**
	 * Set the API URL
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	static function set_api_url( $url )
	{
		self::$api_url = $url;
		return $url;
	}


	/**
	 * Get the API URL
	 *
	 * @param void
	 *
	 * @return string
	 */
	static function get_api_url( )
	{
		return self::$api_url;
	}


	/**
	 * Get the API key
	 *
	 * @param void
	 *
	 * @return string
	 */
	static private function get_api_key()
	{
		if ( !empty( self::$api_key ) ){
			return self::$api_key;
		}

		$settings = ScribblarCore::get_settings();

		if ( isset( $settings['api_key'] ) && !empty( $settings['api_key'] ) ){
			self::$api_key = $settings['api_key'];
			return self::$api_key;
		}

		return false;
	}


	/**
	 * Interact with the API via a GET request
	 *
	 * @param string $method
	 * @param array $payload || null
	 * @param string $api_key || null
	 * @param string $api_url || null
	 *
	 * @return array || false
	 */
	static private function get( $method, $payload = array(), $api_key = null, $api_url = null )
	{
		return self::prepare_and_parse_request( $method, $payload, 'get', $api_key, $api_url );
	}


	static private function post( $method, $payload, $api_key = null, $api_url = null )
	{
		return self::prepare_and_parse_request( $method, $payload, 'post', $api_key, $api_url );
	}

	static private function prepare_and_parse_request( $method, $payload, $verb = 'get', $api_key = null, $api_url = null )
	{
		if ( ! $api_key ){ $api_key = self::get_api_key(); }
		if ( ! $api_url ){ $api_url = self::get_api_url(); }

		$args = null;

		$request = new WP_Http();

		$url = sprintf( '%s?api_key=%s&function=%s', $api_url, $api_key, $method );
		
		if ( is_array( $payload ) ){
			foreach( $payload AS $key => $value )
			{
				if ( 'scribblar_uid' == $key ){
					unset( $payload['scribblar_uid'] );
				}

				if ( 'get' == $verb ){
					$url .= '&'.$key.'='.$value;
				}
				// $payload[ $key ] = urlencode( $value );
			}
		}

		if ( 'post' == $verb ){

			$args = array(
				'method' 	=> 'POST',
				'body' 		=> $payload
			);
		}

		return self::parse_result( $request->post( $url, $args ) );
	}


	/**
	 * Parse the result payload and return the values
	 *
	 * @param object $result
	 * @return object || false
	 */
	static private function parse_result( $result ){

		if( is_wp_error( $result ) ) {
			$data['status'] = 'fail';
			$data['message'] = $result->get_error_message();

			return $data;
		}


		$parser = new ScribblarXml();
		$parser->parse( $result['body'] );

		$data = $parser->get_data( $result['body'] );

		if ( isset( $data['result'] ) && 1 == count( $data['result'] )){
			$data['result'] = $data['result'][0];
		}

		if ( 'ok' == $data['status'] ){
			return $data;

		}elseif( 'fail' == $data['status'] ){
			return $data;
		}else{
			return false;
		}
	}


	/**
	 ************************************
	 * Account controls
	 ************************************
	 */

	static public function get_account( $api_key = null , $api_url = null )
	{
		return self::get( 'account.details' );
	}


	static public function update_account( $data, $api_key = null , $api_url = null )
	{
		return self::post( 'account.edit', $data, $api_key, $api_url );
	}


	/**
	 ************************************
	 * User controls
	 ************************************
	 */

	static public function get_users( $api_key = null , $api_url = null )
	{
		return self::get( 'users.list', null, $api_key, $api_url );
	}

	public static function count_users( $api_key = null , $api_url = null )
	{
		return self::get( 'users.count', null, $api_key, $api_url );
	}

	public static function get_user( $user_id, $api_key = null , $api_url = null )
	{
		return self::get( 'users.details', array( 'userid' => $user_id), $api_key, $api_url );
	}

	public static function create_user( $data, $api_key = null , $api_url = null )
	{
		return self::post( 'users.add', $data, $api_key, $api_url );
	}


	public static function update_user( $data, $api_key = null , $api_url = null )
	{
		return self::post( 'users.edit', $data, $api_key, $api_url );
	}

	public static function delete_user( $user_id, $api_key = null , $api_url = null )
	{
		return self::post( 'users.delete', array('userid' => $user_id), $api_key, $api_url );
	}


	/**
	 ************************************
	 * Room controls
	 ************************************
	 */

	static public function get_rooms( $api_key = null , $api_url = null )
	{
		return self::get( 'rooms.list', null, $api_key, $api_url );
	}

	static public function count_rooms( $api_key = null , $api_url = null )
	{
		return self::get( 'rooms.count', null, $api_key, $api_url );
	}

	static public function get_room( $room_id, $api_key = null , $api_url = null )
	{
		return self::get( 'rooms.details', array( 'roomid' => $room_id), $api_key, $api_url );
	}

	static public function create_room( $data, $api_key = null , $api_url = null )
	{
		return self::post( 'rooms.add', $data, $api_key, $api_url );
	}

	static public function update_room( $data, $api_key = null , $api_url = null )
	{
		return self::post( 'rooms.edit', $data, $api_key, $api_url );
	}

	static public function delete_room( $room_id, $api_key = null , $api_url = null )
	{
		return self::get( 'rooms.delete', array( 'roomid' => $room_id), $api_key, $api_url );
	}

	static private function assemble_payload()
	{
		$payload = null;

		return $payload;
	}

}
