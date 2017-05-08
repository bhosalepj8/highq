<?php
/**
 * Scribblar Users
 *
 * A set of functions to help with user management
 *
 * @author scribblar
 * @package scribblar
 * @since 1.0
 * @version 1.0.18
 */

if(!class_exists('Scribblar_List_Table')){
	include_once( SCRIBBLARPATH . 'classes/scribblar-list-table.php' );
}

if ( ! class_exists( 'ScribblarUser' ) ):

    class ScribblarUser {

        static $roles = null;
        //array(
        //                    'administrator'=> 100,
        //                    'moderator' => 50,
        //                    'participant (40)' => 40,
        //                    'participant (30)' => 30,
        //                    'participant (10)' => 10,
        //               );

        static $role_map = array(
								'administrator'         => array( 'name' => 'admin', 'display_name' => 'Administrator', 'level' => '100'),
								//'editor'                => array( 'name' => 'moderator', 'level' => '50'),
								//'contributor'           => array( 'name' => 'participant40', 'level' => '40'),
								//'author'                => array( 'name' => 'participant40', 'level' => '40'),
                                'moderator'             => array( 'name' => 'moderator',  'display_name' => 'Moderator', 'level' => '50'),
                                'participant40'         => array( 'name' => 'participant40', 'display_name' => 'Participant (40)', 'level' => '40', 'wp_role' => 'subscriber'),
                                'participant30'         => array( 'name' => 'participant30', 'display_name' => 'Participant (30)', 'level' => '30', 'wp_role' => 'subscriber'),
								'participant20'         => array( 'name' => 'participant20', 'display_name' => 'Participant (20)', 'level' => '20', 'wp_role' => 'subscriber'),
                                'participant10'         => array( 'name' => 'participant10', 'display_name' => 'Participant (10)', 'level' => '10', 'wp_role' => 'subscriber'),
							);

        static $update_api_fields = array( 'userid' => null, 'firstname' => null, 'lastname' => null, 'email' => null, 'roleid' => null, 'skypename' => null, 'avatar' => null );

        public static function init()
        {
            add_action( 'show_user_profile', array(__CLASS__, 'user_profile_fields' ), 10 );
            add_action( 'edit_user_profile', array(__CLASS__, 'user_profile_fields' ), 10 );


			add_filter('manage_users_columns', array( __CLASS__, 'user_custom_columns'), 10);
			add_action('manage_users_custom_column', array( __CLASS__,'user_custom_row'), 10, 3 );

            add_action( 'admin_menu', array( __CLASS__, 'user_menu' ) );

            // add_role( 'moderator', __( 'Moderator' ), array( 'read' => true, ) );

            // add_role( 'participant40', __( 'Participant (40)' ), array( 'read' => true, ) );

            // add_role( 'participant30', __( 'Participant (30)' ), array( 'read' => true, ) );

            // add_role( 'participant10', __( 'Participant (10)' ), array( 'read' => true, ) );

            add_action( 'profile_update', array( __CLASS__, 'user_update'), 10, 2 );

            if ( get_role( 'participant10' ) ){
				remove_role( 'moderator' );
				remove_role( 'participant40' );
				remove_role( 'participant30' );
				remove_role( 'participant10' );
			}
        }


        /**
         * Set the roles
         *
         * @param array $roles
         *
         * @return void
         */
        public static function set_roles( $roles )
        {
            self::$roles = $roles;
        }


        /**
         * Get the roles
         *
         * @param void
         *
         * @return array
         */
        public static function get_roles()
        {
            if ( isset( self::$roles ) ){
                return self::$roles;
            }

            $roles = array();
            $role_map = self::get_role_map();

            foreach( $role_map AS $key => $value ){

                $roles[ $value['level'] ] = $value['display_name'];

			}
            self::$roles = $roles;

            return self::$roles;
        }


        /**
         * Get the role map
         *
         * Used to comnvert to and from the Scribblar API
         *
         * @param void
         *
         * @return array
         */
        public static function get_role_map()
        {
            return self::$role_map;
        }


        /**
         * Setup the user related menu items
         *
         * @param void
         *
         * @return void
         */
        static function user_menu()
		{
			add_users_page('Users on Scribblar', 'Users on Scribblar', 'edit_users', 'scribblar-user-list', array( __CLASS__,'user_list_page' ) );

			add_submenu_page( null, 'Copy User from Scribblar', 'Copy User from Scribblar', 'edit_users', 'copy-user-from-scribblar', array( __CLASS__,'copy_user_from_scribblar' ) );
			
			add_submenu_page( null, 'Delete User from Scribblar', 'Delete User from Scribblar', 'edit_users', 'delete-user-from-scribblar', array( __CLASS__,'delete_user_from_scribblar' ) );

			add_submenu_page( null, 'Sync users with API', 'Sync users with API', 'edit_users', 'sync-users-with-api', array( __CLASS__,'sync_users_with_api' ) );
		}


        /*
         * Setup the and show the user profile fields
         *
         * @param object WP_User || null
         *
         * @return void
         */
        static function user_profile_fields( $user = null )
        {
            if ( !$user ){ return ''; }

            $scribblar_user_id = $scribblar_role = $scribblar_username = $scribblar_email = null;

            $data_for_view = array();

            $scribblar_user_id = get_user_meta( $user->ID, '_scribblar_user_id', true );

            $data_for_view['user_id']   = $user->ID;

            $data_for_view['roles']     = self::get_roles();

            // The user is registered with Scribblar, so let's get the rest of the profile.
            if ( $scribblar_user_id ){
                $data_for_view['scribblar_user_id']     = $scribblar_user_id;

                $data_for_view['scribblar_role']        = get_user_meta( $user->ID, '_scribblar_role_name', true );
                $data_for_view['scribblar_role_id']     = get_user_meta( $user->ID, '_scribblar_role_id', true );
                $data_for_view['scribblar_username']    = get_user_meta( $user->ID, '_scribblar_username', true );
                $data_for_view['scribblar_email']       = get_user_meta( $user->ID, '_scribblar_email', true );
            }

            ScribblarCore::include_view( 'user-profile-fields', $data_for_view );
        }


        /**
         * Add the user to Scribblar
         *
         * @param void
         *
         * @return void
         */
        public static function add_user_to_scribblar()
        {
            $the_user_id = ( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) )? (int) $_GET['user_id'] : 0;

            $data_for_view = array();
            $data_for_view['message'] = null;
            $data_for_view['display_form'] = true;

            if ( !current_user_can( 'edit_user' , $the_user_id )){ return $the_user_id; }

            $the_user = get_userdata( $the_user_id );

            $data_for_view['roles']             = self::get_roles();
            $data_for_view['the_user_id']       = $the_user_id;
            $data_for_view['user_first_name']   = $the_user->first_name;
            $data_for_view['user_last_name']    = $the_user->last_name;
            $data_for_view['user_email']        = $the_user->user_email;
            $data_for_view['user_username']     = $the_user->user_login;

            $roles = self::get_roles();

            $data_for_view['the_role_level'] = get_user_meta( $the_user_id, '_scribblar_role_id', true);

            if ( isset( $_POST['_wpnonce-add-user-to-scribblar'] ) ) {
    			check_admin_referer( 'add-user-to-scribblar', '_wpnonce-add-user-to-scribblar' );

                $the_user_id = isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] )? (int)$_POST['user_id'] : '';

                $the_role = isset( $_POST['scribblar_role'] ) && !empty( $_POST['scribblar_role'] )? (int)$_POST['scribblar_role'] : '';

                // Make sure the role is valid.
                $valid_role = false;
                foreach( $data_for_view['roles'] AS $role_level => $role_name ){
                    if ( (int)$the_role == (int)$role_level ){
                        $the_role_name = $role_name;
                        $valid_role = true;
                        break;
                    }
                }

                $role = ( $valid_role )? (int)$the_role : 10 ;

                $avatar = self::get_avatar_url( get_avatar( $the_user_id ) );

                $api_data['username']   = $data_for_view['user_username'];
                $api_data['firstname']  = $data_for_view['user_first_name'];
                $api_data['lastname']   = $data_for_view['user_last_name'];
                $api_data['email']      = $data_for_view['user_email'];
                $api_data['roleid']     = $role;
                $api_data['skypename']  = '';
                $api_data['avatar']     = $avatar;

                // Now we have the data, let's add the user via the Scribblar API
                $result = ScribblarApi::create_user( $api_data );

                $result = isset( $result['result'] ) && isset( $result['result'][0] )? $result['result'][0] : $result;

                $result = isset( $result['result'] ) && !empty( $result['result'] )? $result['result'] : $result;

                // Let's save the Scribblar Room ID against the room post.
                if ( isset( $result['userid'] ) && !empty( $result['userid'] ) ){

                    add_user_meta( $the_user_id, '_scribblar_user_id', esc_attr( $result['userid'] ) );

                    add_user_meta( $the_user_id, '_scribblar_username', esc_attr( $api_data['username'] ) );
                    add_user_meta( $the_user_id, '_scribblar_email', esc_attr( $api_data['email'] ) );
                    add_user_meta( $the_user_id, '_scribblar_role_name', esc_attr( $the_role_name ) );
                    add_user_meta( $the_user_id, '_scribblar_role_id', esc_attr( $api_data['roleid'] ) );
                }

                $data_for_view['display_form'] = false;
                $data_for_view['message'] = __('Congratulations, the user has been added to Scribblar', 'scribblar');
            }

            ScribblarCore::include_view( 'user-add-user-to-scribblar', $data_for_view  );
        }


        /**
         * Get the avatar URL
         *
         * @param string $avatar_img
         *
         * @return string
         */
        public static function get_avatar_url($avatar_img){
            preg_match("/src='(.*?)'/i", $avatar_img, $matches);
            return $matches[1];
        }


        /**
         * User custom columns
         *
         * Used to add the Scribblar ID to the user listing page in the administration system.
         *
         * @param array $defaults
         *
         * @return array
         */
        public static function user_custom_columns($defaults) {
			$defaults['scribblar_id'] = 'Exists on Scribblar?';
            $defaults['scribblar_role'] = 'Scribblar role';
			return $defaults;
		}


        /**
         * Show the custom user row
         *
         * Display Scribblar ID for the user being iterated over
         *
         * @param string $empty
         * @param string $column_name
         * @param string $user_id
         *
         * @return string
         */
		public static function user_custom_row($empty='', $column_name = '', $user_id = ''  ) {
			if ($column_name == 'scribblar_id') {
                $scribblar_id = get_user_meta( $user_id, '_scribblar_user_id', true );

                if ( isset( $scribblar_id ) && !empty( $scribblar_id ) ){
                    return sprintf( __('<span title="%1$s">Yes</span>', 'scribblar'), $scribblar_id );
                }else{
                    return sprintf( __('<a href="%1$s">Copy to Scribblar</a>', 'scribblar'), '?page=scribblar-add-user&user_id='.$user_id );
                }
			}

            if ($column_name == 'scribblar_role') {
                $roles = self::get_role_map();
                $role_name = get_user_meta( $user_id, '_scribblar_role_name', true );
                if ( isset( $roles[ $role_name ] ) && !empty( $roles[ $role_name ] ) ){
                    return $roles[ $role_name ]['display_name'];
                }

                return '';

            }
		}


        /*
		 * View to display a list of users from Scribblar
		 *
		 * @param void
		 *
		 * @return void
		 */
		static function user_list_page()
		{

            $user_list = array();

			// Let's get the list of users
			$raw_data = ScribblarApi::get_users();

			// Let's get the list of roles
			$roles = self::get_roles();
			
			// Ensure that the API has loaded and returned data.
			if ( isset( $raw_data ) && isset( $raw_data['status'] ) && 'fail' == $raw_data['status'] ){

				$error_message = __('An error has occured:<br /><br />', 'scribblar')  . $raw_data['message'];

				ScribblarCore::include_view( 'user-scribblar-list', array( 'error_message' => $error_message ) );

				return;
			}

			$users = $raw_data['result_set']['result'];

			$args = array(
                        'meta_key' => '_scribblar_user_id',
						'meta_value' => '',
					);

				
            if ( isset( $users ) && 0 < count( $users ) ){

                foreach( $users AS $key => $user )
                {
                	$args['meta_value'] = $user['userid'];

                	$posts = get_users( $args );

                	if ( 1 == count( $posts) ){
                		$users[ $key ]['wp_user'] = $posts[0];
                	}
                }

                foreach( $users AS $key => $user ){
                	$user_list[$key]['title'] = trim( $user['firstname'].' '.$user['lastname'] );

                    $user_list[$key]['email'] = $user['email'];

                	$user_list[$key]['scribblar_id'] = $user['userid'];
					
					$user_list[$key]['scribblar_username'] = $user['username'];
					
					$user_list[$key]['scribblar_role_name'] = 'Participant (10)';
					
					if( isset($roles[$user['roleid']]) && !empty( $roles[$user['roleid']] ) ){
						$user_list[$key]['scribblar_role_name'] = $roles[$user['roleid']];
					}

                	$user_list[$key]['ID'] = $key;

                	if ( isset( $user['wp_user'] ) ){
                		$user_list[$key]['user_id'] = $user['wp_user']->ID;

                		$user_list[$key]['user_link'] = get_edit_user_link( $user['wp_user']->ID );
                	} else {
                		$user_list[$key]['user_id'] = null;
                		$user_list[$key]['user_link'] = null;
                	}
                }
			}

			
			$user_list_table = '';
			//Create an instance of our package class...
			$user_list_table = new Scribblar_User_List_Table();
			$user_list_table->set_data( $user_list );

			//Fetch, prepare, sort, and filter our data...
			$user_list_table->prepare_items();

			ScribblarCore::include_view( 'user-scribblar-list', array( 'users' => $users, 'user_list_table' => $user_list_table ) );
		}


        /*
		 * View to allow for a user to be copied from Scribblar
		 *
		 * @param void
		 *
		 * @return void
		 */
        static function copy_user_from_scribblar()
		{
			$message = $error_message = null;


			$scribblar_user_id = ( isset($_GET['user_id'] ) && !empty( $_GET['user_id'] ) )? esc_attr( $_GET['user_id'] ) : null ;

			// Get the user details from API
			$api_details = ScribblarApi::get_user( $scribblar_user_id );
			$api_details = ( isset( $api_details['result'] ) && !empty( $api_details['result'] ) ) ? $api_details['result'] : $api_details;

			// Ensure that the API has loaded and returned data.
			if ( isset( $api_details ) && isset( $api_details['status'] ) && 'fail' == $api_details['status'] ){
				$error_message = __('An error has occured:<br /><br />', 'scribblar' ) . $api_details['message'];

				ScribblarCore::include_view( 'user-scribblar-copy', array( 'error_message' => $error_message ) );
				return;
			}


            // We need to convert the scribblar role into it's WordPress equivalent.
            $roles = self::get_role_map();

            $the_role = $the_role_name = null;

            foreach( $roles AS $role_name => $scribblar_role )
            {

                if ( $api_details['roleid'] == $scribblar_role['level'] ){
                    // We have a winner

					// Sometimes the Scribblar role will not match with a WordPress role
					// In these instances a WordPress role is set in the role mapper data
					if ( isset( $scribblar_role['wp_role'] ) && !empty( $scribblar_role['wp_role'] ) ){
						$the_role = $scribblar_role['wp_role'];
					} else {
						$the_role = $role_name;
					}
                    $the_role_name = $scribblar_role['name'];
                    break;
                }
            }

            // We can add the user.
            $the_user = array();

            $random_password = wp_generate_password( 12, false );
            $user_email = esc_attr( $api_details['email'] );
            $user_name = esc_attr($api_details['username']);

            $user_to_insert = array(
                'user_login'    => $user_name,
                'user_email'    => $user_email,
                'first_name'    => esc_attr($api_details['firstname']),
                'last_name'     => esc_attr($api_details['lastname']),
                'role'          => $the_role,
                'user_pass'     => $random_password
            );

            $user_id = username_exists( $user_name );
            if ( !$user_id and email_exists($user_email) == false ) {
            	$user_id = wp_insert_user( $user_to_insert );
                // We need to insert the user scribblar ID.
                add_user_meta( $user_id, '_scribblar_user_id', esc_attr( $api_details['userid'] ) );

                add_user_meta( $user_id, '_scribblar_username', esc_attr( $api_details['username'] ) );
                add_user_meta( $user_id, '_scribblar_email', esc_attr( $api_details['email'] ) );
                add_user_meta( $user_id, '_scribblar_role_name', esc_attr( $the_role_name ) );
                add_user_meta( $user_id, '_scribblar_role_id', esc_attr( $api_details['roleid'] ) );

				$message_text = __('Congratulations, you have copied a user from Scribblar into your site, <a href="%1s$">edit user</a>', 'scribblar' );

            } else {
                // We need to insert the user scribblar ID.
                update_user_meta( $user_id, '_scribblar_user_id', esc_attr( $api_details['userid'] ) );

                update_user_meta( $user_id, '_scribblar_username', esc_attr( $api_details['username'] ) );
                update_user_meta( $user_id, '_scribblar_email', esc_attr( $api_details['email'] ) );
                update_user_meta( $user_id, '_scribblar_role_name', esc_attr( $the_role_name ) );
                update_user_meta( $user_id, '_scribblar_role_id', esc_attr( $api_details['roleid'] ) );

				$message_text = __('User already exists, but we have ammended the details for you, <a href="%1s$">edit user</a>', 'scribblar' ) ;
            }

			$edit_link = get_edit_user_link( $user_id );

			$message = sprintf( $message_text, $edit_link);

			ScribblarCore::include_view( 'user-scribblar-copy', array( 'edit_link' => $edit_link, 'message' => $message, 'error_message' => $error_message ) );
		}
		
		 /*
		 * View to allow for a user to be deleted from Scribblar
		 *
		 * @param void
		 *
		 * @return void
		 */
        static function delete_user_from_scribblar()
		{
            $data_for_view = array();
            $data_for_view['message'] = null;
            $data_for_view['display_form'] = true;
			
			$scribblar_user_id = ( isset($_GET['user_id'] ) && !empty( $_GET['user_id'] ) )? esc_attr( $_GET['user_id'] ) : null ;

            if ( !current_user_can( 'edit_user' , $scribblar_user_id )){ return $scribblar_user_id; }

			// Get the user details from API
			$api_details = ScribblarApi::get_user( $scribblar_user_id );
			$api_details = ( isset( $api_details['result'] ) && !empty( $api_details['result'] ) ) ? $api_details['result'] : $api_details;

			// Ensure that the API has loaded and returned data.
			if ( isset( $api_details ) && isset( $api_details['status'] ) && 'fail' == $api_details['status'] ){
				$data_for_view['error_message'] = __('An error has occured:<br /><br />', 'scribblar' ) . $api_details['message'];
				
				ScribblarCore::include_view( 'user-scribblar-delete', $data_for_view );
				return;
			}
			
			$data_for_view['roles']             = self::get_roles();
            $data_for_view['the_user_id']       = $scribblar_user_id;
            $data_for_view['user_first_name']   = $api_details['firstname'];
            $data_for_view['user_last_name']    = $api_details['lastname'];
            $data_for_view['user_email']        = $api_details['email'];
            $data_for_view['user_username']     = $api_details['username'];

            if ( isset( $_POST['_wpnonce-delete-user-from-scribblar'] ) ) {
    			check_admin_referer( 'delete-user-from-scribblar', '_wpnonce-delete-user-from-scribblar' );

                $the_user_id = isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] )? $_POST['user_id'] : '';
								
                // Now we have the data, let's add the user via the Scribblar API
                $result = ScribblarApi::delete_user( $the_user_id );
				
                $result = isset( $result['result'] ) && isset( $result['result'][0] )? $result['result'][0] : $result;

                $result = isset( $result['result'] ) && !empty( $result['result'] )? $result['result'] : $result;

				if (isset($result['status']) && 'fail' == $result['status']){
					$data_for_view['display_form'] = false;
					$error_message = isset($result['error']['message']) && isset($result['error']['message'])? $result['error']['message'] : 'Unknown error';
					$data_for_view['error_message'] = sprintf( __('An error occured: <em>%s</em>', 'scribblar'), $error_message);
				}else{
					$data_for_view['display_form'] = false;
					$data_for_view['message'] = __('Congratulations, the user has been deleted from Scribblar', 'scribblar');
				}
            }

            ScribblarCore::include_view( 'user-scribblar-delete', $data_for_view  );
		}


        /*
		 * Sync the users with the API
		 *
		 * @param void
		 *
		 * @return void
		 */
        static function sync_users_with_api()
		{

			$updated = 0;
			$api_users = null;

            $scribblar_user_list = array( );

            $roles = self::get_role_map();

            // Get the posts from the API.
			$api_results = ScribblarApi::get_users();

			$updated = 0;

            if ( isset( $api_results['result_set'] ) && isset( $api_results['result_set']['totalResults'] ) && 0 < $api_results['result_set']['totalResults'] ){

				$args = array(
                        'meta_key' => '_scribblar_user_id',
						'meta_value' => '',
					);

				foreach( $api_results['result_set']['result'] AS $key => $result )
				{
					$need_to_update_user = $user_updated = $scribblar_role = false;

					$args['meta_value'] = $result['userid'];

					// Now let's get the user.
					$the_users = get_users( $args );

					if ( 1 == count( $the_users ) ){
						$user = $the_users[0];
					} else {
						continue;
					}

                    $scribblar_user_list[] = $user->ID;

                    $new_user_details = $result;

                    if ( trim( $user->first_name ) !== trim( $result['firstname']) ){
                        $new_user_details['firstname'] = trim( $user->first_name );
                        $need_to_update_user = true;
                    }

                    if ( trim( $user->last_name ) !== trim( $result['lastname']) ){
                        $new_user_details['lastname'] = trim( $user->last_name );
                        $need_to_update_user = true;
                    }

                    if ( trim( $user->user_email ) !== trim( $result['email']) ){
                        $new_user_details['email'] = trim( $user->user_email );
                        $need_to_update_user = true;
                    }


                    // Let's check if the role has been changed.
                    $the_role = implode(', ', $user->roles);
                    if ( isset( $roles[ $the_role ] ) && !empty( $roles[ $the_role ] ) ){
                        $scribblar_role = $roles[ $the_role ]['level'];
                    }

                    if ( $scribblar_role !== $result['roleid'] ){
                        $new_user_details['roleid'] = $scribblar_role;
                        $need_to_update_user = true;
                    }

                    // Now we have checked the data, should we update the user?
                    if ( true == $need_to_update_user ){
                        ScribblarApi::update_user( $new_user_details );
                        $updated++;
                    }

				}

                // Now we have updated the linked users, let's clear the old users no longer on the Scribblar API.

                // Build a q query to get all the users that no longer exist.
                $args = array(
                        'meta_key' => '_scribblar_user_id',
                        'exclude' => $scribblar_user_list,
                        );

                $the_users = get_users( $args );

                // Now we have the users let's loop through and remove the Scribblar ID data
                foreach( $the_users AS $user ){
                    delete_user_meta( $user->ID, '_scribblar_user_id' );
                    delete_user_meta( $user->ID, '_scribblar_role_id' );
                    delete_user_meta( $user->ID, '_scribblar_role_name' );
                    delete_user_meta( $user->ID, '_scribblar_username' );
                    delete_user_meta( $user->ID, '_scribblar_email' );
                }

			}
			return true;
		}



        /**
         * Method that get runs when a user profile is updated
         *
         * @param interger $user_id
         * @param object WP_User
         *
         * @return void
         */
        static function user_update( $user_id, $old_user_data ){

            $scribblar_user_id = get_usermeta( $user_id, '_scribblar_user_id', true );

            if ( ! $scribblar_user_id ){
                return true;
            }

            if ( isset( $_POST['_wpnonce-update-user-scribblar'] ) ) {
    			check_admin_referer( 'update-user-scribblar', '_wpnonce-update-user-scribblar' );

                $role_id = isset( $_POST['scribblar_role_id'] ) && !empty( $_POST['scribblar_role_id'] )? esc_attr( $_POST['scribblar_role_id'] ) : null;

                if ( $role_id ){
                    $roles = self::get_roles();

                    if ( isset( $roles[ $role_id ] ) && !empty( $roles[ $role_id ] ) ){
                        $role_name = $roles[ $role_id ];
                    }
                    update_user_meta( $user_id, '_scribblar_role_id', $role_id );
                    update_user_meta( $user_id, '_scribblar_role_name', $role_name );
                }
            }

            $api_details = ScribblarApi::get_user( $scribblar_user_id );

            $scribblar_user_data = isset( $api_details['result'] ) && !empty( $api_details['result'] )? $api_details['result'] : array();

            if ( ! $scribblar_user_data ){
                return true;
            }

            $the_user   = get_user_by( 'id', $user_id );
            $check      = self::check_for_updated_user( $the_user, $scribblar_user_data );

            if ( true == $check->need_to_update ){
                $result = ScribblarApi::update_user( $check->data );
            }
        }


        /**
         * Check if the user has been updated
         *
         * This method will check the user data again with the Scribblar API
         *
         * @param object WP_User $user
         * @param array $api_data
         *
         * @return true
         */
        static function check_for_updated_user( WP_User $user, $api_data ){
            $roles = self::get_role_map();

            $return = new stdClass();
            $return->need_to_update = false;
            $return->data = $api_data;

            unset( $return->data['username']);
            unset( $return->data['account_type']);
            unset( $return->data['avatar']);
            unset( $return->data['skypename']);

            if ( trim( $user->first_name ) !== trim( $api_data['firstname']) ){
                $return->data['firstname'] = trim( $user->first_name );
                $return->need_to_update = true;
            }

            if ( trim( $user->last_name ) !== trim( $api_data['lastname']) ){
                $return->data['lastname'] = trim( $user->last_name );
                $return->need_to_update = true;
            }

            if ( trim( $user->user_email ) !== trim( $api_data['email']) ){
                $return->data['email'] = trim( $user->user_email );
                $return->need_to_update = true;
            }


            $the_role_id    = get_user_meta( $user->ID, '_scribblar_role_id', true );
            if ( $the_role_id !== $api_data['roleid'] ){
                $return->data['roleid'] = $the_role_id;
                $return->need_to_update = true;
            }

            return $return;
        }

	}

endif;


if(!class_exists('Scribblar_User_List_Table')){

    class Scribblar_User_List_Table extends Scribblar_Core_List_Table{

        function __construct()
        {
            $this->set_columns( array(
                                    //'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
                                    'title'     => 'Name',
                                    'email'     => 'Email',
									'scribblar_username' => 'Scribblar Username',
									'scribblar_role_name' => 'Scribblar Role',
                                    //'scribblar_id'    => 'Scribblar User ID',
                                    'wp_user'  => 'Exists on WordPress?',
									'delete_from_scribblar' => 'Scribblar User Management'
                                )
                            );

            $this->set_sortable_columns( 	array(
                                                'title'     => array('title',false),     //true means it's already sorted
                                                'email'    => array('email',false),
                                                'scribblar_username'    => array('scribblar_username',false)
                                            )
                                    );
            parent::__construct( array(
                                'singular'  => 'user',     //singular name of the listed records
                                'plural'    => 'users',    //plural name of the listed records
                                'ajax'      => false        //does this table support ajax?
                )
            );
        }

        function column_default($item, $column_name){
            switch($column_name){
                case 'user_id':
                //case 'scribblar_id':
                case 'email':
				case 'scribblar_role_name':
                    return $item[$column_name];
				case 'scribblar_username':
					if (isset($item['scribblar_id']) && !empty($item['scribblar_id'])) {
						return sprintf('<em title="%1$s" alt="%1$s">%2$s</em>', $item['scribblar_id'], $item['scribblar_username']);
					}else{
						return $item[$column_name];
					}
					
                case 'wp_user':
                    if ( isset( $item['user_link'] ) && !empty( $item['user_link'] ) ){
                        return sprintf(__('<a href="%1$s">Yes</a>', 'scribblar'), $item['user_link']);
                    }else{
                        return sprintf( __('<a href="%1$s">Copy from Scribblar</a>', 'scribblar'), '?page=copy-user-from-scribblar&user_id='.$item['scribblar_id'] );
                    }
                    return $item['post_link'];
                    break;
				case 'delete_from_scribblar':
					return sprintf( __('<a href="%1$s">Delete from Scribblar</a>', 'scribblar'), '?page=delete-user-from-scribblar&user_id='.$item['scribblar_id'] );
					break;
                default:
                    return print_r($item,true); //Show the whole array for troubleshooting purposes
            }
        }
    }
}
