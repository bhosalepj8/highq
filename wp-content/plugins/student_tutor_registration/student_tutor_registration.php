<?php
/*
Plugin Name: Student & Tutor Registration
Description: Provides simple front end registration forms
Version: 1.0
Author: Punam Bhosale
*/
session_start();
$site_url= get_site_url();

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
    require_once dirname( __FILE__ ) .'/templates/student_registration.php';
    require_once dirname( __FILE__ ) .'/templates/tutor_registration.php';

	// only show the registration form to non-logged-in members
	if(!is_user_logged_in()) {
    
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
        }
        else{
            wc_add_notice( sprintf( __( "You are already Registered.", "inkfool" ) ) ,'error' );
            wp_redirect(get_site_url()."/my-account/"); exit;
            die;
        }
}
add_shortcode('register_form', 'student_registration_form');

// used for tracking error messages
function errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// register a new Student
function student_add_new_member() {
    $site_url= get_site_url();
  	if (wp_verify_nonce($_POST['student_register_nonce'], 'student-register-nonce')) {
//            if(!username_exists( $_POST["user_fname"] ) && !email_exists( $_POST["user_email"] )){
//                if($_POST["user_country_1"] == "SG" && $_POST["user_country_1"] ){
//        print_r($_POST);die;
                $contact_remember_me = isset($_POST['contact-remember-me'])? true : false;
                $school_name = array_filter($_POST['school_name']);
               
		$user_login		= $_POST["user_fname"];	
		$user_email		= $_POST["user_email"];
		$user_fname             = $_POST["user_fname"];
		$user_lname	 	= $_POST["user_lname"];
		$user_pass		= $_POST["confpassword"];
                $user_dob               = $_POST["user_dob"];
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
                $billing_phone          = $_POST["user_address_phone1"];
                $user_address_phone2        = $_POST["user_address_phone2"];
                if($contact_remember_me){
                    $user_state2            = $user_state1;
                    $user_city2             = $user_city1;
                }
                else{
                    $user_state2            = $_POST["user_state_2"];
                    $user_city2             = $_POST["user_city_2"];
                }
                

                $user_zipcode2          = $_POST["user_zipcode2"];               
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
                $timezone = $_POST['timezone'];
                //array to save or update data
                $arr_user_meta = array('user_dob'		=> $user_dob,
                                        'user_gender'		=> $user_gender,
                                        'user_grade'		=> $user_grade,
                                        'NRIC_code'		=> $NRIC_code,
                                        
                                        //Billing address
                                        'billing_first_name'    => $user_fname,
                                        'billing_last_name'     => $user_lname,
                                        'billing_address_1'	=> $user_presentadd1,
                                        'billing_address_2'	=> $user_presentadd2,
                                        'billing_country'	=> $user_country1,
                                        'billing_state'		=> $user_state1,
                                        'billing_postcode'	=> $user_zipcode1,
                                        'billing_city'		=> $user_city1,
                                        'billing_phone'         => $billing_phone,
                                        'billing_email'         => $user_email,
                                        'user_permanentadd1'	=> $user_permanentadd1,
                                        'user_permanentadd2'	=> $user_permanentadd2,
                                        'user_country2'         => $user_country2,
                                        '$user_state2'          => $user_state2,
                                        'user_zipcode2'         => $user_zipcode2,
                                        'user_city2'		=> $user_city2,
                                        'shipping_phone'        => $user_address_phone2,
                                        'timezone'          => $timezone,
                                        //Shipping address
//                                        'shipping_first_name'    =>$user_fname,
//                                        'shipping_last_name'     =>$user_lname,
//                                        'shipping_address_1'	=> $user_permanentadd1,
//                                        'shipping_address_2'	=> $user_permanentadd2,
//                                        'shipping_country'	=> $user_country2,
//                                        'shipping_state'	=> $user_state2,
//                                        'shipping_postcode'	=> $user_zipcode2,
//                                        'shipping_city'		=> $user_city2,
//                                        'shipping_phone'         => $shipping_phone,
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
                                        'guardian_billing_phone'=> $guardian_billing_phone,
                                        'school_name'           => $school_name,
                                        'contact_remember_me'   => $contact_remember_me,
                                        'billing_remember_me'  =>$billing_remember_me
                                        );
                
                        // Update user data
                        if(isset($_POST['edit_mode']) && $_POST['edit_mode'] == 1){
                            $arr_user_data = array(
                                        'ID' => $_POST['user_id'],
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
                                        );
//                            save_old_history($_POST['user_id']);
                            $user_id = wp_update_user($arr_user_data);

                            if ( is_wp_error( $user_id ) ) {
                                // There was an error, probably that user doesn't exist.
                                wc_add_notice( sprintf( __( $user_id->get_error_message(), "inkfool" ) ) ,'error' );
                                wp_redirect($site_url."/my-account/my-account-details/"); exit;
                                die;
                            } else {
                                    foreach ($arr_user_meta as $key => $value) {
                                        update_user_meta( $user_id, $key, $value);
                                    }
                                    global $wpdb;
                                    if($user_id && !is_wp_error( $user_id )) {
                                        wc_add_notice( sprintf( __( " Your account has been updated.", "inkfool" ) ) ,'success' );
                                        wp_redirect($site_url."/my-account/my-account-details/"); exit;
                                        die;
                                    }
                                }	
                        }else{
                            // Insert user data
                            $arr_user_data = array(
					'user_login'		=> $user_email,
                                        'user_pass'		=> $user_pass,
                                        'user_email'		=> $user_email,
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
					'role'			=> 'student'
                                        );
                        $new_user_id = wp_insert_user($arr_user_data);
                        if(is_wp_error( $new_user_id ) ){
                            wc_add_notice( sprintf( __( $new_user_id->get_error_message(), "inkfool" ) ) ,'error' );
                            wp_redirect($site_url."/student-registration/"); exit;
                            die;
                        }else{
                                    foreach ($arr_user_meta as $key => $value) {
                                        add_user_meta( $new_user_id, $key, $value);
                                    }
                                    add_user_meta( $new_user_id, 'free_session', 1);
                                    if($new_user_id && !is_wp_error( $new_user_id )) {
                                            // send an email to the admin alerting them of the registration
            //				wp_new_user_notification($new_user_id,'both');

                                            // log the new user in
            //				wp_setcookie($user_login, $user_pass, true);
            //				wp_set_current_user($new_user_id, $user_login);	
            //				do_action('wp_login', $user_login);
                                            // send the newly created user to the home page after logging them in
                                            global $wpdb;
                                            do_action( 'woocommerce_set_cart_cookies',  true );
                                            wc_add_notice( sprintf( __( "Thank you for your registration!Please check your email.", "inkfool" ) ) ,'success' );
                                            wp_redirect($site_url."/my-account/"); exit;
                                            die;
                                    }                        
                            }
                            die;
                            }
//        }else{
//        global $wpdb;
//        do_action( 'woocommerce_set_cart_cookies',  true );
//        wc_add_notice( sprintf( __( "Please Enter NRIC code for Singapore City.", "inkfool" ) ) ,'error' );
//        wp_redirect($site_url."/student-registration/"); exit;
//        die;
//    }
        
    }
}
add_action('init', 'student_add_new_member');


//Register New Tutor

function tutor_add_new_member(){
    $site_url= get_site_url();
//      var_dump(wp_verify_nonce($_POST['tutor-register-nonce'], 'tutor-register-nonce') && isset($_POST['btn_submit']));
    if (wp_verify_nonce($_POST['tutor-register-nonce'], 'tutor-register-nonce') && isset($_POST['btn_submit'])) {
//        if(!username_exists( $_POST["user_fname"] ) && !email_exists( $_POST["tutor_email_1"] )){
//            if($_POST["tutor_country_1"] == "SG" && $_POST['tutor_NRIC']!=""){
    
            $language_known = array_filter($_POST['language_known']);
            $language_known = implode(",",$language_known);
            $user_login		= $_POST["tutor_firstname"];	
            $user_email		= $_POST["tutor_email_1"];
            $user_fname         = $_POST["tutor_firstname"];
            $user_lname	 	= $_POST["tutor_lastname"];
            $user_pass		= $_POST["tutor_confpassword"];
            $user_dob           = $_POST["dob_date"];
            $tutor_phone        = $_POST["tutor_phone"];
            $tutor_alternateemail   = $_POST["tutor_email_2"];
            $tutor_NRIC             = $_POST["tutor_NRIC"];
            $tutor_address1         = $_POST["tutor_address1"];
            $tutor_address2         = $_POST["tutor_address2"];
            $tutor_country_1        = $_POST["tutor_country_1"];
            $tutor_state_1          = $_POST["tutor_state_1"];
            $tutor_zipcode1         = $_POST["tutor_zipcode1"];
            $tutor_city             = $_POST["tutor_city_1"];
            $tutor_qualification    = array_values(array_filter($_POST["tutor_qualification"]));
            $tutor_institute        = array_values(array_filter($_POST["tutor_institute"]));
            $tutor_year_passing     = array_values(array_filter($_POST["tutor_year_passing"]));
            $tutor_yourself         = $_POST["tutor_yourself"];
            $hourly_rate            = $_POST["hourly_rate"];
            $currency               = $_POST["currency"];
            if(isset($_POST['video_url']) && $_POST['video_url']!=""){
                $video_url              = $_POST["video_url"];
            }else{
                $video_url              = $_POST["old_video_url"];
            }
            
            $language_known = array_filter($_POST['language_known']);
            $subjects = array_values(array_filter($_POST['subjects']));
            $grade = array_values(array_filter($_POST['grade']));
            $level = array_values(array_filter($_POST['level']));
            $timezone = $_POST['timezone'];
//            $arr_docs = array_values(array_values(array_filter($_POST["old_uploaded_docs"])));
            $uploaded_docs = [];
            $arr_docs = $_POST["old_uploaded_docs"];
            foreach ($_POST["tutor_qualification"] as $key => $value) {
                if(empty($arr_docs[$key])){
                   $uploaded_docs[] = "";
                }
                else{
                    $uploaded_docs[] = $arr_docs[$key];
                }
            }
//            print_r($uploaded_docs);
//            die;
            $arr_tutor_meta = array('user_dob'	=> $user_dob,
                                        'tutor_alternateemail'		=> $tutor_alternateemail,
                                        'tutor_NRIC'		=> $tutor_NRIC,
                                        'tutor_qualification'	=> $tutor_qualification,
                                        'tutor_institute'      =>$tutor_institute,
                                        'tutor_year_passing'	=> $tutor_year_passing,
                                        'tutor_description'	=> $tutor_yourself,
                                        'tutor_video_url'       =>$video_url,
                                        'hourly_rate'       => $hourly_rate,
                                        'currency'              => $currency,
                                        'timezone'          => $timezone,
                                        'billing_first_name'    => $user_fname,
                                        'billing_last_name'     => $user_lname,
                                        'billing_address_1'	=> $tutor_address1,
                                        'billing_address_2'	=> $tutor_address2,
                                        'billing_country'	=> $tutor_country_1,
                                        'billing_state'		=> $tutor_state_1,
                                        'billing_postcode'	=> $tutor_zipcode1,
                                        'billing_city'		=> $tutor_city,
                                        'billing_phone'         => $tutor_phone,
                                        'billing_email'         => $user_email,
                                        'language_known'        => $language_known,
                                        'subs_can_teach'        => $subjects,
                                        'tutor_grade'           => $grade,
                                        'tutor_level'           => $level,
                                        'uploaded_docs'         => $uploaded_docs
                                        );
                             
                            // Update user data
                        if(isset($_POST['edit_mode']) && $_POST['edit_mode'] == 1){
                            $arr_user_data = array(
                                        'ID' => $_POST['user_id'],
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
                                        );
//                            save_old_history($_POST['user_id']);
                            $tutor_id = wp_update_user($arr_user_data);
                            
                            if ( is_wp_error( $tutor_id ) ) {
                                // There was an error, probably that user doesn't exist.
                                wc_add_notice( sprintf( __( $tutor_id->get_error_message(), "inkfool" ) ) ,'error' );
                                wp_redirect($site_url."/my-account/my-account-details/"); exit;
                                die;
                            } else {
                                    foreach ($arr_tutor_meta as $key => $value) {
                                        update_user_meta( $tutor_id, $key, $value);
                                    }
                                    global $wpdb;
                                    if($tutor_id && !is_wp_error( $tutor_id )) {
                                        wc_add_notice( sprintf( __( " Your account has been updated.", "inkfool" ) ) ,'success' );
                                        wp_redirect($site_url."/my-account/my-account-details/"); exit;
                                        die;
                                    }
                                }	
                        }else{
                            // Insert user data
                            $arr_user_data = array(
					'user_login'		=> $user_email,
                                        'user_pass'		=> $user_pass,
                                        'user_email'		=> $user_email,
                                        'first_name'		=> $user_fname,
                                        'last_name'		=> $user_lname,
                                        'user_registered'       => date('Y-m-d H:i:s'),
					'role'			=> 'tutor'
                                        );
            
                        $new_tutor_id = wp_insert_user($arr_user_data);
                        if(is_wp_error( $new_tutor_id )){
                            wc_add_notice( sprintf( __( $new_tutor_id->get_error_message(), "inkfool" ) ) ,'error' );
                            wp_redirect($site_url."/my-account/"); exit;
                            die;
                        }else{
                            foreach ($arr_tutor_meta as $key => $value) {
                            add_user_meta( $new_tutor_id, $key, $value);
                            }
                            //Login User and move to Account page
                            global $wpdb;

                            if($new_tutor_id && !is_wp_error( $new_tutor_id )) {
                                    global $wpdb;
                                    do_action( 'woocommerce_set_cart_cookies',  true );
                                    wc_add_notice( sprintf( __( "Thank you for your registration!Please check your email.", "inkfool" ) ) ,'success' );
                                    wp_redirect($site_url."/my-account/"); exit;
                                    die;
                            }
                        }
                    }
//    }else{
//        global $wpdb;
//        do_action( 'woocommerce_set_cart_cookies',  true );
//        wc_add_notice( sprintf( __( "Please Enter NRIC code for Singapore City.", "inkfool" ) ) ,'error' );
//        wp_redirect($site_url."/tutor-registration/"); exit;
//        die;
//    }
}
}

add_action('init', 'tutor_add_new_member');

function save_old_history($id){
    $current_user_meta = get_user_meta($id);
    $current_user_meta = serialize($current_user_meta);
    $date = new DateTime();
    require_once('/wp-config.php');
    global $wpdb;
    $wpdb->insert( 'wp_user_history_meta', array( 'user_id' => $id, 'user_data' =>  $current_user_meta, 'updated_date' => date('Y-m-d H:i:s')), array( '%d', '%s' , '%s' ) );
}

//Student/Tutor Edit Form & View Data
function edit_user_registration_form($attr){
        require_once dirname( __FILE__ ) .'/templates/student-account-edit.php';
        require_once dirname( __FILE__ ) .'/templates/tutor-account-edit.php';
        if(is_user_logged_in()) {
            if($attr['role'] == 'student'){
			$output = edit_student_form_fields($attr['viewmode']);
            }
            if($attr['role'] == 'tutor'){
			$output = edit_tutor_form_fields($attr['viewmode']);
            }
            return $output;
        }
        else{
            wc_add_notice( sprintf( __( "Please Log In to Continue", "inkfool" ) ) ,'error' );
            wp_redirect(get_site_url()."/my-account/"); exit;
            die;
        }
}
add_shortcode('edit_user_form', 'edit_user_registration_form');

//Student/Tutor My account
function user_my_account($attr){
        require_once dirname( __FILE__ ) .'/templates/student_myaccount.php';
        require_once dirname( __FILE__ ) .'/templates/tutor_myaccount.php';
        if(is_user_logged_in()) {
            if($attr['role'] == 'student'){
			$output = myaccount_student_form_fields();
            }
            if($attr['role'] == 'tutor'){
                $output = myaccount_tutor_form_fields();
            }
            return $output;
        }
}
add_shortcode('my_account', 'user_my_account');

function tutor_add_course(){
    
     if (wp_verify_nonce($_POST['tutor-account-nonce'], 'tutor-account-nonce') && isset($_POST['btn_addsession'])) {
         $tutoring_type = $_POST['tutoring_type'];
         $current_user = wp_get_current_user();
         $user_id = $current_user->ID;
         $current_user_meta = get_user_meta($user_id);
         $name = $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];
         $timezone = $current_user_meta[timezone][0];
         
//         echo $name;
//         print_r($current_user_meta);
         if($tutoring_type == "Course"){
         $from_date = array_values(array_filter($_POST['from_date']));
         $from_time = maybe_unserialize(array_values(array_filter($_POST['from_time'])));
         $session_count = count($from_date);
         $hourly_rate = $current_user_meta[hourly_rate][0];
         $price = $hourly_rate * $session_count;
         $curriculum=$_POST['curriculum'];
         $subject = $_POST['subject'];
         $grade = $_POST['grade'];
         $course_cat = $_POST['course_cat'];
         $post_title = (isset($_POST['new_course_title']) && $_POST['new_course_title']!="")? $_POST['new_course_title'] : $_POST['course_title'];
         $coursestatus = (isset($_POST['new_course_title']) && $_POST['new_course_title']!="")? "Rejected" : "Approved";
         $course_detail = isset($_POST['course_detail'])? $_POST['course_detail'] : "";
         $no_of_students = $_POST['no_of_student'];
         wc_add_notice( sprintf( __( "Your course has been added successfully. New course added will require admin approval.", "inkfool" ) ) ,'success' );
         }
         if($tutoring_type == "1on1"){
         $from_date = array_values(array_filter($_POST['from_1on1date']));
         $from_time = array_values(array_filter($_POST['from_1on1time']));
         $hourly_rate = $current_user_meta[hourly_rate][0];
         $price = $hourly_rate;
         $curriculum=$_POST['curriculum_1on1'];
         $subject = $_POST['subject_1on1'];
         $grade = $_POST['grade_1on1'];
         $course_cat = $_POST['cat_1on1'];
         $post_title = "1On1 Tutoring";
         $coursestatus = "Approved";
         $course_detail = "";
         $no_of_students = 1;
         
         }
         
         $downloadable_files = array();
         foreach ($_POST['old_uploaded_docs'] as $key => $docs) {
             foreach($docs as $doc){
                 $index = md5($doc);
                 $downloadable_files[$index]=$doc;
             }
         }
         $video_index = md5($_POST['video_url']);
         $video_url[$video_index] = $_POST['video_url'];

         // Create post object
        $my_post = array(
          'post_title'    => wp_strip_all_tags( $post_title ),
          'post_content'  => $course_detail,
          'post_status'   => 'publish',
          'post_author'   => $user_id,
          'post_type' => "product",
        );

       
        if($tutoring_type == "Course"){
        // Insert the product into the database
        $post_id = wp_insert_post( $my_post, $wp_error );
        
        wp_set_object_terms( $post_id, $course_cat, 'product_cat' );
        wp_set_object_terms($post_id, 'simple', 'product_type');
        add_post_meta($post_id, 'name_of_course', $post_title);
        add_post_meta($post_id, 'course_description', $course_detail);
        add_post_meta( $post_id, 'id_of_tutor', $current_user->ID);
        add_post_meta( $post_id, 'name_of_tutor', $name);
        add_post_meta($post_id, 'curriculum', $curriculum); 
        add_post_meta($post_id, 'subject', $subject); 
        add_post_meta($post_id, 'grade', $grade); 
//        add_post_meta($post_id, 'timezone', $timezone); 
        foreach ($from_date as $key => $value) {
            //Change user timezone into UTC
               $datetime_obj =  DateTime::createFromFormat('d/m/Y H:i',$value." ".$from_time[$key],new DateTimeZone($timezone));
               $otherTZ  = new DateTimeZone('UTC');
               $datetime_obj->setTimezone($otherTZ); 
               $date = $datetime_obj->format('Y-m-d');
               $time = $datetime_obj->format('H:i');
        add_post_meta($post_id, 'from_date', $date); 
        add_post_meta($post_id, 'from_time', $time); 
        }
        add_post_meta( $post_id, 'downloadable_files', $downloadable_files);
        add_post_meta( $post_id, 'video_url', $video_url);
        add_post_meta( $post_id, 'tutoring_type', $tutoring_type);
        add_post_meta( $post_id, 'no_of_students', $no_of_students);
        
        update_post_meta( $post_id, '_visibility', 'visible' );
        update_post_meta( $post_id, 'wpcf-course-status', $coursestatus);
        update_post_meta( $post_id, '_stock_status', 'instock');
        update_post_meta( $post_id, 'total_sales', '0');
        update_post_meta( $post_id, '_regular_price', $price);
        update_post_meta( $post_id, '_sale_price', $price);
//        update_post_meta( $post_id, '_purchase_note', "" );
        update_post_meta( $post_id, '_featured', "no" );
//        update_post_meta( $post_id, '_weight', "" );
//        update_post_meta( $post_id, '_length', "" );
//        update_post_meta( $post_id, '_width', "" );
//        update_post_meta( $post_id, '_height', "" );
//        update_post_meta($post_id, '_sku', "");
//        update_post_meta( $post_id, '_product_attributes', array());
        update_post_meta( $post_id, '_price', $price );
        update_post_meta( $post_id, '_sold_individually', "yes" );
        update_post_meta( $post_id, '_manage_stock', "yes" );
        update_post_meta( $post_id, '_backorders', "no" );
        update_post_meta( $post_id, '_stock', $no_of_students );
        }
        if($tutoring_type == "1on1"){
            $rand = rand();
            foreach ($from_date as $key => $value) {
            // Insert the product into the database
                $post_id = wp_insert_post( $my_post, $wp_error );
                $datetime_obj =  DateTime::createFromFormat('d/m/Y H:i',$value." ".$from_time[$key],new DateTimeZone($timezone));
                $otherTZ  = new DateTimeZone('UTC');
                $datetime_obj->setTimezone($otherTZ); 
                $date = $datetime_obj->format('Y-m-d');
                $time = $datetime_obj->format('H:i');
                wp_set_object_terms( $post_id, $course_cat, 'product_cat' );
                wp_set_object_terms($post_id, 'simple', 'product_type');
                add_post_meta($post_id, 'name_of_course', $post_title);
                add_post_meta($post_id, 'course_description', $course_detail);
                add_post_meta( $post_id, 'id_of_tutor', $current_user->ID);
                add_post_meta( $post_id, 'name_of_tutor', $name);
                add_post_meta($post_id, 'curriculum', $curriculum); 
                add_post_meta($post_id, 'subject', $subject); 
                add_post_meta($post_id, 'grade', $grade); 
                add_post_meta($post_id, 'from_date', $date); 
                add_post_meta($post_id, 'from_time', $time);
//                add_post_meta($post_id, 'timezone', $timezone); 
                 
                add_post_meta( $post_id, 'downloadable_files', $downloadable_files);
                add_post_meta( $post_id, 'video_url', $video_url);
                add_post_meta( $post_id, 'tutoring_type', $tutoring_type);
                add_post_meta( $post_id, 'no_of_students', $no_of_students);
                add_post_meta($post_id, 'random_no', $rand);
                
                update_post_meta( $post_id, '_visibility', 'visible' );
                update_post_meta( $post_id, 'wpcf-course-status', $coursestatus);
                update_post_meta( $post_id, '_stock_status', 'instock');
                update_post_meta( $post_id, 'total_sales', '0');
                update_post_meta( $post_id, '_regular_price', $price);
                update_post_meta( $post_id, '_sale_price', $price);
//                update_post_meta( $post_id, '_purchase_note', "" );
                update_post_meta( $post_id, '_featured', "no" );
//                update_post_meta( $post_id, '_weight', "" );
//                update_post_meta( $post_id, '_length', "" );
//                update_post_meta( $post_id, '_width', "" );
//                update_post_meta( $post_id, '_height', "" );
//                update_post_meta($post_id, '_sku', "");
//                update_post_meta( $post_id, '_product_attributes', array());
                update_post_meta( $post_id, '_price', $price );
                update_post_meta( $post_id, '_sold_individually', "yes" );
                update_post_meta( $post_id, '_manage_stock', "yes" );
                update_post_meta( $post_id, '_backorders', "no" );
                update_post_meta( $post_id, '_stock', $no_of_students );
            }
            wc_add_notice( sprintf( __( "1On1-Tutoring Course session has been added successfully.", "inkfool" ) ) ,'success' );
        }
        
        
        /* Fire our meta box setup function on the post editor screen. */
        do_action( 'load-post.php');
        do_action( 'load-post-new.php');
        
        
            wp_redirect(get_site_url()."/my-account/my-account-details/"); exit;
            die;
        
     }
}

add_action('init', 'tutor_add_course');



add_action( 'load-post.php', 'product_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'product_post_meta_boxes_setup' );
/* Meta box setup function. */
function product_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'product_add_post_meta_boxes' );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function product_add_post_meta_boxes() {

  add_meta_box(
    'product-post-class',      // Unique ID
    esc_html__( 'Course Data', 'example' ),    // Title
    'product_post_class_meta_box',   // Callback function
    'product',         // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );
}

/* Display the post meta box. */
function product_post_class_meta_box( $object, $box ) { ?>
<?php
  $post_meta_data = get_post_meta($object->ID);
//  print_r($post_meta_data);
  $from_time = maybe_unserialize($post_meta_data[from_time]);
  ?>
  <p>
     <h4><?php _e( "Tutoring Type", 'example' ); ?>: <label><?php echo esc_attr($post_meta_data[tutoring_type][0]);?></label></h4>
     <h4><?php _e( "Curriculum", 'example' ); ?>: <label><?php echo esc_attr($post_meta_data[curriculum][0]);?></label></h4>
     <h4><?php _e( "Subject", 'example' ); ?>: <label>
         <?php 
           $subject = maybe_unserialize($post_meta_data[subject][0]);
           if(is_array($subject)){
               foreach ($subject as $key => $value) {
                   echo "<br/>Subject ".($key+1).": ".$value."<br/>";
               }
           }else{
               echo $subject;
           }
         ?></label></h4>
     <h4><?php _e( "Grade", 'example' ); ?>: <label><?php echo esc_attr($post_meta_data[grade][0]);?></label></h4>
     <h4><?php _e( "Course Sessions", 'example' ); ?>: <label><br/>
         <?php 
         if(is_array($post_meta_data[from_date])){
//             print_r($post_meta_data[from_date]);
            
             
         foreach(maybe_unserialize($post_meta_data[from_date]) as $key => $value){
            $datetime_obj =  DateTime::createFromFormat('Y-m-d H:i',$value." ".$from_time[$key],new DateTimeZone('UTC'));
            $otherTZ  = new DateTimeZone('Asia/Singapore');
            $datetime_obj->setTimezone($otherTZ); 
            $date = $datetime_obj->format('Y-m-d h:i A T');
            echo "Session ".($key+1).": Date & Time ".$date."<br/>";
         }}
         ?></label></h4>
     <h4><?php _e( "Course Material", 'example' ); ?>: <label>
         <?php 
         foreach(maybe_unserialize($post_meta_data[downloadable_files][0]) as $value){
             echo '<a href="'.$value.'" target="_blank">Doc</a>  ';
         }
         ?></label></h4>
     <h4><?php _e( "Course Video", 'example' ); ?>: <label>
         <?php 
         foreach(maybe_unserialize($post_meta_data[video_url][0]) as $value){
             echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="480"]');
         }
         
         ?></label></h4>
  </p>
<?php }

//Function to get order details

function get_customer_total_order() {
    $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_order_statuses() ),
        'date_query' => array(
            'after' => date('Y-m-d', strtotime('-10 days')),
            'before' => date('Y-m-d', strtotime('today')) 
        )
    ) );
//    print_r(array_keys( wc_get_order_statuses() ));
    
    $total = 0;
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order );
        $total += $order->get_total();
    }

    return $total;
}


function  search_tutors_list($attr){
    require_once dirname( __FILE__ ) .'/templates/tutors_bycategory.php';
            $output = tutors_list_by_category($attr['category'],$attr['type']);
        return $output;
}

add_shortcode('search_tutors', 'search_tutors_list');

function  search_courses_list($attr){
    require_once dirname( __FILE__ ) .'/templates/course_bycategory.php';
            $output = courses_list_by_category($attr['category'],$attr['type']);
        return $output;
}

add_shortcode('search_courses', 'search_courses_list');

function  tutor_public_profile(){
    $request_uri= $_SERVER[REQUEST_URI];
    $pieces = explode("?", $request_uri);
    $user_id = $pieces[1];
    
    require_once dirname( __FILE__ ) .'/templates/tutor_public_profile.php';
            $output = tutor_public_profile_page($user_id);
        return $output;
}

add_shortcode('tutor_public_profile', 'tutor_public_profile');

function tutor_add_session_to_cart(){
    if (wp_verify_nonce($_POST['tutor-session-nonce'], 'tutor-session-nonce') && isset($_POST['add_session_to_cart'])) {
//        print_r($_POST);
         foreach ($_POST['tutor_session'] as $key => $value) {
//            $product_meta = get_post_meta($value);
             $cart_item_key = WC()->cart->add_to_cart( $value ,1,'','',$value);
        }
        if($cart_item_key)    
        wc_add_notice( sprintf( __( "Session has been added to your cart. <a href='".get_site_url()."/cart/'>View Cart</a>") ) ,'success' );
    }
}

add_action('init', 'tutor_add_session_to_cart');
