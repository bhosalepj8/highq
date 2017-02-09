<?php
/*
Plugin Name: Student & Tutor Registration
Plugin URI: https://pippinsplugins.com/creating-custom-front-end-registration-and-login-forms
Description: Provides simple front end registration forms
Version: 1.0
Author: Punam Bhosale
*/
session_start();
$site_url= get_site_url();
//echo $site_url;

function add_roles_on_plugin_activation() {
       add_role( 'student', __( 'Student'), array( 'read' => true, // Allows a user to read
        'create_posts' => false, // Allows user to create new posts
        'edit_posts' => false, // Allows user to edit their own posts
        ) );
       add_role( 'tutor', __( 'Tutor'), array( 'read' => true, // Allows a user to read
        'create_posts' => false, // Allows user to create new posts
        'edit_posts' => false, // Allows user to edit their own posts
        ) );
       
   }
   register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );
//   include_once dirname( __FILE__ ) . '/custom_endpoint.php';
//   register_activation_hook( __FILE__, array( 'My_Custom_My_Account_Endpoint', 'install' ) );
// user registration login form
   

function student_registration_form($attr) {
	 //echo dirname( __FILE__ ) .'\templates\tutor_registration.php';die;
    require_once dirname( __FILE__ ) .'/templates/student_registration.php';
    require_once dirname( __FILE__ ) .'/templates/tutor_registration.php';
    
	// only show the registration form to non-logged-in members
//	if(!is_user_logged_in()) {
//    print_r($attr['role']);
		global $pippin_load_css;
 
		// set this to true so the CSS is loaded
		$pippin_load_css = true;
 
		// check to make sure user registration is enabled
		$registration_enabled = get_option('users_can_register');
 
		// only show the registration form if allowed
		if($registration_enabled) {
                        if($attr['role'] == 'student'){
			$output = student_registration_form_fields();
                        }
                        elseif ($attr['role'] == 'tutor'){
                        $output = tutor_registration_form_fields();
                        }
		} else {
			$output = __('User registration is not enabled');
		}
		return $output;
//	}
}
add_shortcode('register_form', 'student_registration_form');

// used for tracking error messages
function errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// registration form fields
//function student_registration_form_fields() {
//        ob_start(); 
//        
//        return ob_get_clean();
//}

// register a new Student
function student_add_new_member() {
    $site_url= get_site_url();
  	if (wp_verify_nonce($_POST['student_register_nonce'], 'student-register-nonce')) {
//            var_dump(email_exists($_POST["user_email"]));
            if(!username_exists( $_POST["user_fname"] ) && !email_exists( $_POST["user_email"] )){
//                print_r($_POST);
                $school_name = array_filter($_POST['school_name']);
                $school_name = implode(",",$school_name);
                $subject_studied = array_filter($_POST['subject_studied']);
                $subject_studied = implode(",",$subject_studied);
                
		$user_login		= $_POST["user_fname"];	
		$user_email		= $_POST["user_email"];
		$user_fname             = $_POST["user_fname"];
		$user_lname	 	= $_POST["user_lname"];
		$user_pass		= $_POST["confpassword"];
                $user_dob               = $_POST["user_dob"];
                $user_ethinicity        = $_POST["user_ethinicity"];
                $user_gender            = $_POST["user_gender"];
                $user_grade             = $_POST["user_grade"];
                $NRIC_code              = $_POST["NRIC_code"];
                $user_presentadd1       = $_POST["user_presentadd1"];
                $user_presentadd2       = $_POST["user_presentadd2"];
                $user_country1          = $_POST["user_country_1"];
                $user_state1            = $_POST["user_state_1"];
                $user_zipcode1          = $_POST["user_zipcode1"];
                $user_city1             = $_POST["user_city_1"];
                $user_permanentadd1     = $_POST["user_permanentadd1"];
                $user_permanentadd2     = $_POST["user_permanentadd2"];
                $user_country2          = $_POST["user_country_2"];
                $user_state2            = $_POST["user_state_2"];
                $user_zipcode2          = $_POST["user_zipcode2"];
                $user_city2             = $_POST["user_city_2"];
                $user_address_phone2    = $_POST["user_address_phone2"];
                $guardian_name          = $_POST["guardian_name"];
                $guardian_age           = $_POST["guardian_age"];
                $guardian_relation      = $_POST["guardian_relation"];
                $guardian_gender        = $_POST["guardian_gender"];
                $guardian_email_address = $_POST["guardian_email_address"];
                $guardian_contact_num   = $_POST["guardian_contact_num"];
                $guardian_billingadd1   = $_POST["guardian_billingadd1"];
                $guardian_billingadd2   = $_POST["guardian_billingadd2"];
                $guardian_country3      = $_POST["user_country_3"];
                $guardian_state3        = $_POST["user_state_3"];
                $guardian_zipcode3      = $_POST["guardian_zipcode3"];
                $guardian_city3         = $_POST["user_city_3"];
                $guardian_billing_phone = $_POST["guardian_billing_phone"];
                $guardian_shippingadd1  = $_POST["guardian_shippingadd1"];
                $guardian_shippingadd2  = $_POST["guardian_shippingadd2"];
                $guardian_country4      = $_POST["user_country_4"];
                $guardian_state4        = $_POST["user_state_4"];
                $guardian_city4         = $_POST["user_city_4"];
                $guardian_shipping_phone= $_POST["guardian_shipping_phone"];
                

                        $new_user_id = wp_insert_user(array(
					'user_login'		=> $user_fname,
                                        'user_pass'		=> $user_pass,
                                        'user_email'		=> $user_email,
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
					'role'			=> 'student'
                                        )
                                        );
                        if(!empty($new_user_id->errors)){
                            $_SESSION['error'] = $new_user_id->get_error_message();
                        }else{
//                            echo "in else";die;
                        $arr_user_meta = array('user_dob'		=> $user_dob,
                                        'user_ethinicity'	=> $user_ethinicity,
                                        'user_gender'		=> $user_gender,
                                        'user_grade'		=> $user_grade,
                                        'NRIC_code'		=> $NRIC_code,
                                        
                                        //Billing address
                                        'billing_first_name'    => $user_fname,
                                        'billing_last_name'     => $user_lname,
                                        'billing_address_1'	=> $user_presentadd1,
                                        'billing_address_2'	=> $user_presentadd2.",".$user_state1,
                                        'billing_country'	=> $user_country1,
                                        'billing_state'		=> $user_state1,
                                        'billing_postcode'	=> $user_zipcode1,
                                        'billing_city'		=> $user_city1,
                                        'billing_phone'         => $guardian_billing_phone,
                                        'billing_email'         => $user_email,
                                        //Shipping address
                                        'shipping_first_name'    =>$user_fname,
                                        'shipping_last_name'     =>$user_lname,
                                        'shipping_address_1'	=> $user_permanentadd1,
                                        'shipping_address_2'	=> $user_permanentadd2.",".$user_state2,
                                        'shipping_country'	=> $user_country2,
                                        'shipping_state'	=> $user_state2,
                                        'shipping_postcode'	=> $user_zipcode2,
                                        'shipping_city'		=> $user_city2,
                                        //Guardian data
                                        'guardian_name'		=> $guardian_name,
                                        'guardian_age'		=> $guardian_age,
                                        'guardian_relation'	=> $guardian_relation,
                                        'guardian_gender'	=> $guardian_gender,
                                        'guardian_email_address'=> $guardian_email_address,
                                        'guardian_contact_num'	=> $guardian_contact_num,
                                        'guardian_billingadd1'	=> $guardian_billingadd1,
                                        'guardian_billingadd2'	=> $guardian_billingadd2,
                                        'guardian_country3'	=> $guardian_country3,
                                        'guardian_state3'	=> $guardian_state3,
                                        'guardian_zipcode3'	=> $guardian_zipcode3,
                                        'guardian_city3'	=> $guardian_city3,
                                        'guardian_shipping_phone'=> $user_address_phone2,
                                        'guardian_shippingadd1'	=> $guardian_shippingadd1,
                                        'guardian_shippingadd2'	=> $guardian_shippingadd2,
                                        'guardian_country4'	=> $guardian_country4,
                                        'guardian_state4'	=> $guardian_state4,
                                        'guardian_city4'	=> $guardian_city4,
                                        'guardian_shipping_phone' => $guardian_shipping_phone,
                                        'school_name'           => $school_name,
                                        'subject_studied'       => $subject_studied
                                        );
					
//                                    print_r($new_user_id);
                                    foreach ($arr_user_meta as $key => $value) {
//                                        echo "user id: ".$new_user_id." key: ".$key." value ".$value;
                                        add_user_meta( $new_user_id, $key, $value);
                                    }
                                    
                        global $wpdb;
//                        var_dump(empty($new_user_id->errors));die;
			if($new_user_id && empty($new_user_id->errors)) {
				// send an email to the admin alerting them of the registration
				wp_new_user_notification($new_user_id);
 
				// log the new user in
				wp_setcookie($user_login, $user_pass, true);
				wp_set_current_user($new_user_id, $user_login);	
				do_action('wp_login', $user_login);
 
				// send the newly created user to the home page after logging them in
				wp_redirect($site_url."/my-account/"); exit;
                                die;
			}
                        $meta = get_user_meta( $new_user_id );
//                        print_r($meta);
                        }
            }else{
    //            echo "in else";die;
                $_SESSION['error'] = "Sorry! UserName / Email is already exists";
            }
}
}
add_action('init', 'student_add_new_member');


//Register New Tutor

function tutor_add_new_member(){
    $site_url= get_site_url();
    if (wp_verify_nonce($_POST['tutor-register-nonce'], 'tutor-register-nonce') && isset($_POST['btn_submit'])) {
//        var_dump(!username_exists( $_POST["user_fname"] ) && !email_exists( $_POST["tutor_email_1"] ));die;
        if(!username_exists( $_POST["user_fname"] ) && !email_exists( $_POST["tutor_email_1"] )){
            
            if(!empty($_FILES['documents']['name'][0]))
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }

            $files = $_FILES['documents'];

            $upload_overrides = array( 'test_form' => false );

            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

            if ( $movefile && ! isset( $movefile['error'] ) ) {
                echo "File is valid, and was successfully uploaded.\n";
                var_dump( $movefile );
            } else {
                /**
                 * Error generated by _wp_handle_upload()
                 * @see _wp_handle_upload() in wp-admin/includes/file.php
                 */
                echo $movefile['error'];
            }
            
            
            $language_known = array_filter($_POST['language_known']);
            $language_known = implode(",",$language_known);
            
            $user_login		= $_POST["tutor_firstname"];	
            $user_email		= $_POST["tutor_email_1"];
            $user_fname         = $_POST["tutor_firstname"];
            $user_lname	 	= $_POST["tutor_lastname"];
            $user_pass		= $_POST["tutor_confpassword"];
            $user_dob           = $_POST["dob_date"];
            $tutor_phone        = $_POST["tutor_phone"];
            $tutor_alternateemail            = $_POST["tutor_email_2"];
            $tutor_NRIC             = $_POST["tutor_NRIC"];
            $tutor_address1         = $_POST["tutor_address1"];
            $tutor_address2         = $_POST["tutor_address2"];
            $tutor_country_1        = $_POST["tutor_country_1"];
            $tutor_state_1          = $_POST["tutor_state_1"];
            $tutor_zipcode1         = $_POST["tutor_zipcode1"];
            $tutor_city             = $_POST["tutor_city_1"];
            $tutor_qualification    = $_POST["tutor_qualification"];
            $tutor_year_passing     = $_POST["tutor_year_passing"];
            $tutor_yourself         = $_POST["tutor_yourself"];
            $tutor_nationality      = $_POST["tutor_nationality"];
            $tutor_country_2        = $_POST["tutor_country_2"];
            $tutor_state_2          = $_POST["tutor_state_2"];
            $tutor_zip              = $_POST["tutor_zip"];
            $hourly_rate            = $_POST["hourly_rate"];
            $currency               = $_POST["currency"];
            $video_url              = $_POST["video_url"];
            
            $language_known = array_filter($_POST['language_known']);
            $chk_lang_read = $_POST['chk_lang_read'];
            $chk_lang_write = $_POST['chk_lang_write'];
            $chk_lang_speak = $_POST['chk_lang_speak'];
            
            $i = 1;
            foreach ($language_known as $key => $value) {
                $arr_lang[$i] = $language_known[$key]."-".$chk_lang_read[$key].",".$chk_lang_write[$key].",".$chk_lang_speak[$key];
                $i++;
            }
            
            $subjects = array_filter($_POST['subjects']);
            $grade = $_POST['grade'];
            
            $j = 1;
            foreach ($subjects as $key => $value) {
                $arr_sub[$j] = $subjects[$key]."-".$grade[$key];
                $j++;
            }
            
            $new_tutor_id = wp_insert_user(array(
					'user_login'		=> $user_fname,
                                        'user_pass'		=> $user_pass,
                                        'user_email'		=> $user_email,
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
					'role'			=> 'tutor'
                                        )
                                        );
                        if(!empty($new_tutor_id->errors)){
                            $_SESSION['error'] = $new_tutor_id->get_error_message();
                        }else{
//                            echo "in else";die;
                        $arr_tutor_meta = array('user_dob'	=> $user_dob,
                                        'tutor_alternateemail'		=> $tutor_alternateemail,
                                        'tutor_NRIC'		=> $tutor_NRIC,
                                        'tutor_qualification'		=> $tutor_qualification,
                                        'tutor_year_passing'		=> $tutor_year_passing,
                                        'tutor_description'	=> $tutor_yourself,
                                        'tutor_nationality'	=> $tutor_nationality,
                                        'tutor_video_url'       =>$video_url,
                                        'hourly_rate'=> $hourly_rate,
                                        'currency'	=> $currency,
                            
                                        //Billing address
                                        'billing_first_name'    => $user_fname,
                                        'billing_last_name'     => $user_lname,
                                        'billing_address_1'	=> $tutor_address1,
//                                        'billing_address_2'	=> $tutor_address2.",".$tutor_state_1,
                                        'billing_address_2'	=> $tutor_address2,
                                        'billing_country'	=> $tutor_country_1,
                                        'billing_state'		=> $tutor_state_1,
                                        'billing_postcode'	=> $tutor_zipcode1,
                                        'billing_city'		=> $tutor_city,
                                        'billing_phone'         => $tutor_phone,
                                        'billing_email'         => $user_email,
                                        //Shipping address
                                        'shipping_first_name'    =>$user_fname,
                                        'shipping_last_name'     =>$user_lname,
                                        'shipping_address_1'	=> $tutor_address1,
                                        'shipping_address_2'	=> $tutor_address2,
                                        'shipping_country'	=> $tutor_country_2,
                                        'shipping_state'	=> $tutor_state_2,
                                        'shipping_postcode'	=> $tutor_zip,
                                        'shipping_city'		=> $tutor_city,
                                        'language_known'        => $arr_lang,
                                        'subs_can_teach'        => $arr_sub
                                        );
					
                    foreach ($arr_tutor_meta as $key => $value) {
//                                        echo "user id: ".$new_tutor_id." key: ".$key." value ".$value;
                        add_user_meta( $new_tutor_id, $key, $value);
                    }
                    
                    //File Upload code
                    $files = $_FILES["documents"];  
                    foreach ($files['name'] as $key => $value) {            
                            if ($files['name'][$key]) { 
                                $file[$x] = array( 
                                    'name' => $files['name'][$key],
                                    'type' => $files['type'][$key], 
                                    'tmp_name' => $files['tmp_name'][$key], 
                                    'error' => $files['error'][$key],
                                    'size' => $files['size'][$key]
                                ); 
            //                    $_FILES = array ("my_file_upload" => $file); 
                                $_FILES = $file; 
                                $x++;
                            } 
                        } 
                        
                        $arr_docs = array();
                        foreach ($_FILES as $key => $value) {
                            if(!$value[error]){
                               if ( ! function_exists( 'wp_handle_upload' ) ) {
                                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                                }

                               $upload_overrides = array( 'test_form' => false );
                               $movefile = wp_handle_upload( $value, $upload_overrides );
                                if ( $movefile && ! isset( $movefile['error'] ) ) {
                                    array_push($arr_docs,$movefile["url"]);
                                } else {
                                    /**
                                     * Error generated by _wp_handle_upload()
                                     */
                                    $_SESSION['error'] = $movefile['error'];
                                }
                            }
                        }
                        add_user_meta( $new_tutor_id, "uploaded_docs", $arr_docs);           
                            
                        //Login User and move to Account page
                        global $wpdb;
                           
			if($new_tutor_id && empty($new_tutor_id->errors)) {
				// send an email to the admin alerting them of the registration
				wp_new_user_notification($new_tutor_id,'both');
                                
				// log the new user in
				wp_setcookie($user_login, $user_pass, true);
				wp_set_current_user($new_tutor_id, $user_login);	
				do_action('wp_login', $user_login);
 
				// send the newly created user to the home page after logging them in
				wp_redirect($site_url."/my-account/"); exit;
                                die;
			}
//                        $meta = get_user_meta( $new_tutor_id );
//                        print_r($meta);
                        }
        }else{
            $_SESSION['error'] = "Sorry! UserName / Email is already exists";
        }
        
    }
}

add_action('init', 'tutor_add_new_member');