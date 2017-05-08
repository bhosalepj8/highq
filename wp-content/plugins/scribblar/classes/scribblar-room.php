<?php
/*
 * ScribblarRoom
 *
 * This class is used to control the room post type
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.18
 */

// Inclide the list table for displaying the Scribblar room list.
if(!class_exists('Scribblar_List_Table')){
	include_once( SCRIBBLARPATH . 'classes/scribblar-list-table.php' );
}


if ( ! class_exists( 'ScribblarRoom' ) ):


	class ScribblarRoom{

		/*
		 * $field_map
		 *
		 * Field mapping between the internal post metadata and the exernal Scribblar API.
		 *
		 * @var array
		 */
		static $field_map = array(
								'_password'				=> array( 'name' => 'password', 'type' => 'string' ),
								'_allow_guests'         => array( 'name' => 'allowguests', 'type' => 'boolean'),
								'_autopromote_guests'   => array( 'name' => 'promoteguests', 'type' => 'boolean'),
								'_allow_audio'          => array( 'name' => 'roomaudio', 'type' => 'boolean'),
								'_allow_video'          => array( 'name' => 'roomvideo', 'type' => 'boolean'),
								'_allow_chat'           => array( 'name' => 'roomchat', 'type' => 'boolean'),
								'_autostart_video'      => array( 'name' => 'autostartcam', 'type' => 'boolean'),
								'_autostart_audio'      => array( 'name' => 'autostartaudio', 'type' => 'boolean'),
								'_hide_header'          => array( 'name' => 'hideheader', 'type' => 'boolean'),
								'_hide_stamp'           => array( 'name' => 'hidestamp', 'type' => 'boolean'),
								'_hide_flickr'          => array( 'name' => 'hideflickr', 'type' => 'boolean'),
								'_locked'               => array( 'name' => 'locked', 'type' => 'boolean'),
								'_allow_locking'        => array( 'name' => 'allowlock', 'type' => 'boolean'),
								'_allow_wolfram'        => array( 'name' => 'roomwolfram', 'type' => 'boolean'),
								'_room_id'              => array( 'name' => 'roomid', 'type'=>'integer'),
								'_role' 				=> array( 'name' => null, 'type' => null ),
								'_is_public' 			=> array( 'name' => null, 'type' => null ),
							);


		public static function init()
		{
			// Register the room post type
			register_post_type('room',
				array('labels'	=> array(
								'name'		            => __('Rooms',	'scribblar'),
								'singular_name'         => __('Room',	'scribblar'),
								'add_new_item'          => __('Add New Room',	'scribblar'),
								'edit_item'             => __('Edit Room',	'scribblar'),
								'new_item'		        => __('New Room',	'scribblar'),
								'view_item'			    => __('View Room',	'scribblar'),
								'search_items'		    => __('Search Rooms',	'scribblar'),
								'not_found'			    => __('No Rooms Found',	'scribblar'),
								'not_found_in_trash'    => __('No Rooms Found in Trash', 'scribblar')
							),
							'public'		        => true,
							'menu_position'	        => 5,
							'supports'		        => array( 'title', 'revisions' ),
							'has_archive'	        => 'rooms',
							'query_var'		        => true,
							'rewrite'		        => true,
							'register_meta_box_cb' => array( __CLASS__, 'add_room_metaboxes' ),
							'exclude_from_search'   => false
				)
			);

			add_action('save_post', array( __CLASS__, 'save_room_meta'), 1, 2); // save the custom fields

			// Admin columns
			add_filter('manage_room_posts_columns', array( __CLASS__, 'room_custom_columns'), 10);
			add_action('manage_room_posts_custom_column', array( __CLASS__,'room_custom_row'), 10, 2);

			add_action( 'admin_menu', array( __CLASS__, 'room_menu' ) );

			add_action( 'before_delete_post', array( __CLASS__, 'delete_room' ), 10, 1 );

		}


		/*
		 * Set the field map
		 *
		 * @param array $file_map
		 *
		 * @return null
		 */
		static function set_field_map( $field_map )
		{
			self::$field_map = $field_map;
		}


		/*
		 * Get the field map
		 *
		 * @param void
		 *
		 * @return array
		 */
		static function get_field_map()
		{
			return self::$field_map;
		}


		/**
		 * Setup the room administration menu
		 *
		 * @param void
		 *
		 * @return void
		 */
		static function room_menu()
		{
			add_submenu_page( 'edit.php?post_type=room', 'Rooms on Scribblar', 'Rooms on Scribblar', 'edit_posts', 'scribblar-room-list', array( __CLASS__,'room_list_page' ) );

			add_submenu_page( null, 'Copy Room from Scribblar', 'Copy Room from Scribblar', 'edit_posts', 'copy-room-from-scribblar', array( __CLASS__,'copy_room_from_scribblar' ) );

			add_submenu_page( null, 'Sync posts with API', 'Sync posts with API', 'edit_posts', 'sync-post-with-api', array( __CLASS__,'sync_posts_with_api' ) );
		}

		/**
		 * Save the room post type meta data
		 *
		 * @param integer $post_id
		 * @param object Wp_Post $post
		 *
		 * @return void
		 */
		static function save_room_meta( $post_id, $post ) {

			$action = isset( $_GET['action'] ) && !empty( $_GET['action'] )? esc_attr( $_GET['action'] ) : null ;

			if ( 'trash' == $action ||  'delete' == $action ){
				return null;
			}


			$field_map = self::get_field_map();

			$post_type = get_post_type();

			if ( 'room' !==  $post_type ){ return $post->ID; }

			if ( !current_user_can( 'edit_post' , $post->ID )){ return $post->ID; }

			$api_data = array();

			foreach( $field_map AS $field_name => $api ){

				if( $post->post_type == 'revision' ){
					return; // Don't store custom data twice
				}

				$value = isset( $_POST[ $field_name ] )? $_POST[ $field_name ] : false ;

				$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)

				if ( 'boolean' == $api['type'] ){
					$api_data[ $api['name'] ] = (isset( $value ) && '1' == $value )? '1' : '0';
				} else {
					$api_data[ $api['name'] ] = $value;
				}



				if( get_post_meta( $post->ID, $field_name, FALSE ) ) { // If the custom field already has a value
					update_post_meta( $post->ID, $field_name, $value );
				} else { // If the custom field doesn't have a value
					add_post_meta( $post->ID, $field_name, $value );
				}

				if(!$value){
					delete_post_meta( $post->ID, $field_name ); // Delete if blank
				}
			}

			$api_data['roomname'] = $post->post_title;

			if ( isset( $api_data['roomid'] ) && !empty( $api_data['roomid'] ) ){
				do_action( 'scribblar_api_room_edit', $post_id, $api_data );
			}else{
				do_action( 'scribblar_api_room_add', $post_id, $api_data );
			}
		}


		/**
		 * Add the room post type metaboxes
		 *
		 * @param void
		 *
		 * @return void
		 */
		public static function add_room_metaboxes()
		{
			add_meta_box('scribblar_meta', 'Scribblar settings', array( __CLASS__, 'room_meta_boxes'), 'room', 'normal', 'default');

			// add_meta_box('scribblar_role', 'WordPress role', array( __CLASS__, 'room_role_meta_boxes'), 'room', 'side', 'default');

			add_meta_box('scribblar_public', 'Room publicity settings', array( __CLASS__, 'room_public_meta_boxes'), 'room', 'side', 'default');
		}

		/**
		 * Output the room post type metaboxes
		 *
		 * @param void
		 *
		 * @return void
		 */
		public static function room_meta_boxes()
		{
			global $post;
			global $current_screen;
			
			$password = null;

			$data = get_post_meta( $post->ID );

			$values = array();
			foreach ( self::get_field_map() AS $field_name => $api_values ){
				$values[ $field_name ] = isset( $data[ $field_name ][0] ) && 1 == $data[ $field_name ][0]? ' checked="checked" ' : '' ;
			}

			// Check if we are on the add room page, if so let's override the defaults.
			if ( 'add' == $current_screen->action ){
				$values['_allow_guests'] = $values['_allow_audio'] = $values['_allow_chat'] = $values['_allow_wolfram'] = ' checked="checked" ';
			}

			$room_id = isset( $data['_room_id'][0] )? esc_attr($data['_room_id'][0]) : null;
			
			if ( $room_id ){
				$values = self::sync_values_with_api( $room_id, $values );
			}
			
			echo '<label for="_password">' . __('Password:', 'scribblar') . ' </label>';
			echo '<input type="text" name="_password" id="_password" value="' . $values['_password'] . '" />';
			echo '<p><em>' . __('Set a password for the room.', 'scribblar'). '</em></p>';
			
			echo '<label for="_allow_guests"> <input type="checkbox" name="_allow_guests" id="_allow_guests" value="1" '.$values['_allow_guests'].' /> ' . __('Allow guests?', 'scribblar') . '</label>';
			echo '<p><em>' . __('Guests are anonymous users which are prompted for a username before entering the room.', 'scribblar'). '</em></p>';

			echo '<label for="_autopromote_guests"> <input type="checkbox" name="_autopromote_guests" id="_autopromote_guests" value="1" '.$values['_autopromote_guests'].' /> ' . __('Auto-promote guests?', 'scribblar') . '</label>';
			echo '<p><em>' . __('If guests are allowed, are they automatically promoted to presenter status.', 'scribblar'). '</em></p>';

			echo '<label for="_allow_audio"> <input type="checkbox" name="_allow_audio" id="_allow_audio" value="1" '.$values['_allow_audio'].' /> ' . __('Allow audio?', 'scribblar') . '</label>';
			echo '<p><em>' . __('Audio features enabled or disabled for this room.', 'scribblar'). '</em></p>';

			echo '<label for="_allow_video"> <input type="checkbox" name="_allow_video" id="_allow_video" value="1" '.$values['_allow_video'].' /> ' . __('Allow video?', 'scribblar') . '</label>';
			echo '<p><em>' . __('Video features enabled or disabled for this room.', 'scribblar'). '</em></p>';

			echo '<label for="_allow_chat"> <input type="checkbox" name="_allow_chat" id="_allow_chat" value="1"'.$values['_allow_chat'].'  /> ' . __('Allow chat', 'scribblar') . '</label>';
			echo '<p><em>' . __('Text chat feature enabled or disabled for this room.', 'scribblar'). '</em></p>';

			echo '<label for="_autostart_video"> <input type="checkbox" name="_autostart_video" id="_autostart_video" value="1" '.$values['_autostart_video'].' /> ' . __('Autostart video', 'scribblar') . '</label>';
			echo '<p><em>' . __('When enabled, it will start the user\'s camera as soon as they enter the room (if video is enabled for this room)', 'scribblar').'</em></p>';

			echo '<label for="_autostart_audio"> <input type="checkbox" name="_autostart_audio" id="_autostart_audio" value="1" '.$values['_autostart_audio'].' /> ' . __('Autostart audio', 'scribblar') . '</label>';
			echo '<p><em>' . __('When enabled, it will start the user\'s microphone as soon as they enter the room (if audio is enabled for this room)', 'scribblar').'</em></p>';

			echo '<label for="_hide_header"> <input type="checkbox" name="_hide_header" id="_hide_header" value="1" '.$values['_hide_header'].' /> ' . __('Hide header', 'scribblar') . '</label>';
			echo '<p><em>' . __('Allows you to hide the entire header section including logo and room name display to free up more space for the essential room features', 'scribblar').'</em></p>';

			echo '<label for="_hide_stamp"> <input type="checkbox" name="_hide_stamp" id="_hide_stamp" value="1" '.$values['_hide_stamp'].' /> ' . __('Hide stamp tool', 'scribblar') . '</label>';
			echo '<p><em>' . __('Allows you to hide the stamp tool', 'scribblar').'</em></p>';

			echo '<label for="_hide_flickr"> <input type="checkbox" name="_hide_flickr" id="_hide_flickr" value="1" '.$values['_hide_flickr'].' /> ' . __('Hide flickr', 'scribblar') . '</label>';
			echo '<p><em>' . __('Allows you to hide the Flickr upload button from the Assets panel', 'scribblar').'</em></p>';

			echo '<label for="_locked"> <input type="checkbox" name="_locked" id="_locked" value="1" '.$values['_locked'].' /> ' . __('Locked', 'scribblar') . '</label>';
			echo '<p><em>' . __('Allows you to hide the Flickr upload button from the Assets panel', 'scribblar').'</em></p>';

			echo '<label for="_allow_locking"> <input type="checkbox" name="_allow_locking" id="_allow_locking" value="1" '.$values['_allow_locking'].' /> ' . __('Allow locking', 'scribblar') . '</label>';
			echo '<p><em>' . __('Shows or hides the lock room button in the room and enables a room to be locked by a user.', 'scribblar').'</em></p>';

			echo '<label for="_allow_wolfram"> <input type="checkbox" name="_allow_wolfram" id="_allow_wolfram" value="1" '.$values['_allow_wolfram'].' /> ' . __('Allow Wolfram Alpha UI', 'scribblar') . '</label>';
			echo '<p><em>' . __('Provides Wolfram Alpha UI in the room if this feature is enabled on account level.', 'scribblar').'</em></p>';

			echo '<label for="_room_id">' . __('Room ID:', 'scribblar'). '</label><br />';
			echo '<p>'.$room_id.'</p>';
			echo '<input type="hidden" name="_room_id" id="_room_id" value="'.$room_id.'" />';
			echo '<p><em>' . __('The Scribblar ID of the room.', 'scribblar').'</em></p>';
			
		}

		/**
		 * Output the room role metaboxes
		 *
		 * @param void
		 *
		 * @return void
		 */
		public static function room_role_meta_boxes()
		{
			global $post;
			global $current_screen;

			$data = get_post_meta( $post->ID );

			$values = array();

			foreach ( self::get_field_map() AS $field_name => $api_values ){
				if ( '_role' == $field_name ){
					$values[ $field_name ] = isset( $data[ $field_name ][0] ) && !empty( $data[ $field_name ][0] )? esc_attr( $data[ $field_name ][0] ) : '' ;
					continue;
				}
				$values[ $field_name ] = isset( $data[ $field_name ][0] ) && 1 == $data[ $field_name ][0]? ' checked="checked" ' : '' ;
			}

			global $wp_roles;
			$roles = $wp_roles->get_names();


			$arr = array_reverse($roles, true);

			$arr['logged_in'] = __( 'All logged in users', 'scribblar' );
			$arr['all_users'] = __( 'Public - All Users (Including Logged Out Users)', 'scribblar' );
			$roles = array_reverse($arr, true);

			echo '<label for="_role">' . __('Role allowed to view the room:', 'scribblar'). '</label><br />';

			echo '<select name="_role" id="_role">';
			foreach( $roles AS $key => $value ){
				echo '<option value="'.$key.'" name="'.$key.'"';
				echo isset( $values['_role'] ) && !empty( $values['_role']) && $key == $values['_role']? ' selected="selected" ' : '' ;
				echo '>'.$value.'</option>';
			}
			echo '</select>';

			echo '<p><em>' . __('Using this control you can ensure that the Scribblar room is only viewable to a certain WordPress role or a logged in user.', 'scribblar').'</em></p>';
		}


		/**
		 * Output the room public visibility metaboxes
		 *
		 * @param void
		 *
		 * @return void
		 */
		public static function room_public_meta_boxes()
		{
			global $post;
			global $current_screen;

			$data = get_post_meta( $post->ID );

			$values = array();

			foreach ( self::get_field_map() AS $field_name => $api_values ){
				$values[ $field_name ] = isset( $data[ $field_name ][0] ) && 1 == $data[ $field_name ][0]? ' checked="checked" ' : '' ;
			}

			// Pre-select the public option for new rooms
			if ( ! isset( $data['_room_id'] ) ){
				$values['_is_public'] = ' checked="checked"';
			}

			echo '<label for="_is_public"> <input type="checkbox" name="_is_public" id="_is_public" value="1" '.$values['_is_public'].' /> ' . __('Room is public', 'scribblar') . '</label>';
			echo '<p><em>' . __('The room will be visible to all visitors when this is checked. Please uncheck this option if you would like the room to require visitors to be logged in', 'scribblar'). '</em></p>';
		}


		/**
		 * Add the Scribblar ID column to the room post type administation listing page
		 *
		 * @param array $defaults
		 *
		 * @return array
		 */
		public static function room_custom_columns($defaults) {
			$defaults['room_id'] = 'Scribblar ID';
			return $defaults;
		}


		/**
		 * Add the Scribblar ID to the individual row in the room post type administraton listing page
		 *
		 * @param string $column_name
		 * @param integer $post_id
		 *
		 * @return void
		 */
		public static function room_custom_row($column_name, $post_id) {
			if ($column_name == 'room_id') {
				echo get_post_meta( $post_id, '_room_id', true );
			}
			if ( $column_name == 'post_password'){
				echo 'asdsadsadsa';
			}
		}


		static function action_api_room_list( $value1, $value2 ){
			// Stub
		}


		/**
		 * Action to run with adding a room
		 *
		 * @param integer $post_id
		 * @param array $api_data
		 *
		 * @return void
		 */
		static function action_api_room_add( $post_id, $api_data )
		{
			unset( $api_data['roomid'] );

			$result = ScribblarApi::create_room( $api_data );

			// Let's save the Scribblar Room ID against the room post.
			if ( isset( $result['result']['roomid'] ) && !empty( $result['result']['roomid'] ) ){
				add_post_meta( $post_id, '_room_id', esc_attr( $result['result']['roomid'] ) );
			}
		}


		/**
		 * Action to run with editing a room
		 *
		 * @param integer $post_id
		 * @param array $api_data
		 *
		 * @return void
		 */
		static function action_api_room_edit( $post_id, $api_data )
		{
			foreach( $api_data AS $key => $value )
			{
				$api_data[ $key ] = (string) $value;
			}

			$result = ScribblarApi::update_room( $api_data );
		}

		static function action_api_room_delete( $post_id, $api_data )
		{
			// Stub
		}


		/**
		 * Sync the values from the API with the form data
		 *
		 * This function will use the API data in preference to the WordPress data
		 *
		 * @param string $room_id
		 * @param array $values the form data
		 *
		 * @return array
		 */
		static function sync_values_with_api( $room_id, $values )
		{
			$api_data = ScribblarApi::get_room( $room_id );

			if ( !isset( $api_data['result'] ) || empty( $api_data['result'] ) ){
				return $values;
			}

			$api_data = $api_data['result'];
			$field_mapping = self::get_field_map();
			
			foreach( $values  As $field_name => $field_value )
			{
				if( null == $field_mapping[ $field_name ]['type'] ){
					continue;
				}

				switch( $field_mapping[ $field_name ]['type'] ){
					case 'boolean':
						if ( isset( $api_data[ $field_mapping[ $field_name ]['name'] ] ) && '1' == $api_data[ $field_mapping[ $field_name ]['name'] ] ){
							$values[ $field_name ] = ' checked="checked" ';
						}else{
							$values[ $field_name ] = '';
						}
						break;
					case 'string':
						$values[ $field_name ] = esc_attr( $api_data[ $field_mapping[ $field_name ]['name'] ] );
						break;
					default:
						break;
				}
			}
			return $values;
		}


		/*
		 * View to display a list of rooms from Scribblar
		 *
		 * @param void
		 *
		 * @return void
		 */
		static function room_list_page()
		{
			// Let's get the list of rooms
			$raw_data = ScribblarApi::get_rooms();

			// Ensure that the API has loaded and returned data.
			if ( isset( $raw_data ) && isset( $raw_data['status'] ) && 'fail' == $raw_data['status'] ){
				$error_message = __('An error has occured:<br /><br />', 'scribblar').$raw_data['message'];

				ScribblarCore::include_view( 'room-scribblar-list', array( 'error_message' => $error_message ) );
				return;
			}


			$rooms = $raw_data['result_set']['result'];

			$args = array(
						'post_type' => 'room',
						'meta_key' => '_room_id',
						'meta_value' => '',
					);

			foreach( $rooms AS $key => $room )
			{
				$args['meta_value'] = $room['roomid'];

				$posts = get_posts( $args );

				if ( 1 == count( $posts ) || 0 < count( $posts ) ){
					$rooms[ $key ]['wp_post'] = $posts[0];
				}
			}

			$room_list = array();

			// var_dump( $rooms );
			foreach( $rooms AS $key => $room ){

				$room_list[$key]['title'] = $room['roomname'];

				$room_list[$key]['room_id'] = $room['roomid'];

				$room_list[$key]['ID'] = $key;

				if ( isset( $room['wp_post'] ) ){
					$room_list[$key]['post_id'] = $room['wp_post']->ID;

					$room_list[$key]['post_link'] = get_edit_post_link( $room['wp_post']->ID );
				} else {
					$room_list[$key]['post_id'] = null;
					$room_list[$key]['post_link'] = null;
				}

			}

			$room_list_table = '';
			//Create an instance of our package class...
			$room_list_table = new Scribblar_Room_List_Table();
			$room_list_table->set_data( $room_list );

			//Fetch, prepare, sort, and filter our data...
			$room_list_table->prepare_items();

			ScribblarCore::include_view( 'room-scribblar-list', array( 'rooms' => $rooms, 'room_list_table' => $room_list_table ) );

		}


		/**
		 * View for copying a room from Scribblar
		 *
		 * @param void
		 *
		 * @return void
		 */
		static function copy_room_from_scribblar()
		{
			$room_id = ( isset($_GET['room_id'] ) && !empty( $_GET['room_id'] ) )? esc_attr( $_GET['room_id'] ) : null ;

			// Get the room details from API
			$api_details = ScribblarApi::get_room( $room_id );
			$api_details = ( isset( $api_details['result'] ) && !empty( $api_details['result'] ) ) ? $api_details['result'] : $api_details;

			$values = self::convert_api_values( $api_details );

			$room_title = $api_details['roomname'];
			$room_password = ( isset( $api_details['password'] ) && !empty( $api_details['password'] ) && '' != $api_details['password'] )? esc_attr($api_details['password']) : null;

			$post = array(
				'post_title'     => esc_attr($api_details['roomname'] ),
				'post_status'    => 'publish',
				'post_type'      => 'room',
				'post_password'  => $room_password,
			);

			$post_id = wp_insert_post( $post );

			foreach( $values AS $field_name => $value )
			{
				add_post_meta( $post_id, $field_name, $value );
			}

			$edit_link = get_edit_post_link( $post_id );

			$message = sprintf(__('Congratulations, you have copied a room from Scribblar into your site, <a href="%1$s">edit room</a>', 'scribblar'), $edit_link);

			ScribblarCore::include_view( 'room-scribblar-copy', array( 'edit_link' => $edit_link, 'message' => $message ) );
		}


		/**
		 * Convert the API values from true | false to 1 | 0 for use in WordPress
		 *
		 * @param array $api_data
		 *
		 * @return array
		 */
		static function convert_api_values( $api_data )
		{
			$return_values = array();

			foreach ( self::get_field_map() AS $field_name => $api_values ){
				if ( 'boolean' == $api_values['type'] ){
					$return_values[ $field_name ] = isset( $api_data[ $api_values['name'] ] ) && 1 == $api_data[ $api_values['name'] ]? 1 : 0;
				} else {
					if ( isset( $api_values['name'] ) ){
						$return_values[ $field_name ] = $api_data[ $api_values['name'] ];
					}
				}
			}

			return $return_values;
		}


		/**
		 * Sync the posts with the API
		 *
		 * @param void
		 *
		 * @return true
		 */
		static function sync_posts_with_api()
		{

			$updated = 0;
			$api_posts = null;

			// Get the posts from the API.
			$api_posts = ScribblarApi::get_rooms();

			$updated = 0;

			if ( isset( $api_posts['result_set'] ) && isset( $api_posts['result_set']['totalResults'] ) && 0 < $api_posts['result_set']['totalResults'] ){

				$args = array(
							'post_type' => 'room',
							'meta_key' => '_room_id',
							'meta_value' => '',
							'numberposts' => 1
						);

				foreach( $api_posts['result_set']['result'] AS $key => $result )
				{
					$need_to_update_post = $room_updated = false;

					$args['meta_value'] = $result['roomid'];

					// Now let's get the post.
					$room_posts = get_posts( $args );

					if ( 1 == count( $room_posts ) ){
						$room = $room_posts[0];
					} else {
						return false;
					}

					$values = self::convert_api_values( $result );

					$room_meta = get_post_meta( $room->ID );

					if ( $room->post_title != $result['roomname'] ){
						$room->post_title = esc_attr( $result['roomname'] );
						$need_to_update_post = true;
					}

					if ( $room->post_password != $result['password'] ){
						$room->post_password = esc_attr( $result['password'] );
						$need_to_update_post = true;
					}

					if ( true == $need_to_update_post ){
						wp_update_post( $room );
						$room_updated = true;
					}

					// Now let's loop through the meta data to check for changes.
					foreach( $values AS $field_name => $value ){

						if ( '_room_id' == $field_name ){
							continue;
						}

						if ( !isset( $room_meta[ $field_name ][0] )  ){
							if ( 0 != $value){
								add_post_meta( $room->ID, $field_name, $value );

								$room_updated = true;
							}
							continue;
						}

						if ( isset( $room_meta[ $field_name ][0] ) && $room_meta[ $field_name ][0] != $value ){
							update_post_meta( $room->ID, $field_name, $value );

							$room_updated = true;

							continue;
						}

					}

					if ( $room_updated ){
						$updated++;
					}
				}
			}
			return true;
		}


		/**
		 * Delete the room from Scribblar
		 *
		 * @param integer $post_id
		 *
		 * @return void
		 */
		static function delete_room( $post_id )
		{
			// Let's get the post meta
			$room_id = get_post_meta( $post_id, '_room_id', true);
			if ( $room_id ){
				$deleted = ScribblarApi::delete_room( $room_id );

				if ( isset( $deleted['status'] ) && 'ok' == $deleted['status'] ){

					delete_post_meta( $post_id, '_room_id' );

					return true;
				}
			}
		}

	}

endif;


class Scribblar_Room_List_Table extends Scribblar_Core_List_Table{

	function __construct()
	{
		$this->set_columns( $columns = array(
								//'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
								'title'     => 'Title',
								'room_id'    => 'Scribblar Room ID',
								'wp_post'  => 'Exists on WordPress?',
								//'post_password' => 'Password protected?'
							)
						);

		$this->set_sortable_columns( 	$sortable_columns = array(
											'title'     => array('title',false),     //true means it's already sorted
											'room_id'    => array('room_id',false)
										)
								);
		parent::__construct();
	}

}
