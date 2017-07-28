<?php
// put custom code here
define("Upload_File_Size", 50);
define("posts_per_page", 6);
$site_url= get_site_url();
define("SITE_URL", $site_url);
define("SCRIBBLAR_API_KEY", 'D7203DAF-97A6-1849-713000C0CC50A15D');
define('ConvertCurrency_API', 'https://svcs.sandbox.paypal.com/AdaptivePayments/ConvertCurrency');

/**
 * Proper way to enqueue scripts and styles.
 */
function wpdocs_theme_name_scripts() {
// Register the scriptget_refined_courses
    wp_register_script( 'jquery-validation-js', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js' );
    wp_register_script( 'student-validate-js', get_stylesheet_directory_uri() . '/js/studentValidate.js' );
    wp_register_script( 'tutor-validate-js', get_stylesheet_directory_uri() . '/js/tutorValidate.js' );
    wp_register_script( 'ui-datepicker-js', get_stylesheet_directory_uri() . '/js/jquery-ui.js' );
    wp_register_script( 'format-extension-js', get_stylesheet_directory_uri() . '/js/additional-methods.min.js' );
    wp_register_script( 'ui-timepicker-js', get_stylesheet_directory_uri() . '/js/jquery-ui-timepicker-addon.js' );
    wp_register_script( 'datatable-js', get_stylesheet_directory_uri() . '/js/jquery.dataTables.min.js' );
    wp_register_script( 'bootstrap-datatable', get_stylesheet_directory_uri() . '/js/dataTables.bootstrap.min.js' );
    wp_register_script( 'scribblar-js', get_stylesheet_directory_uri() . '/js/includes.js' );
    wp_register_script( 'telephone-js', get_stylesheet_directory_uri() . '/js/intlTelInput.js' );
//    wp_register_script( 'star-js', get_stylesheet_directory_uri() . '/js/star-rating.js' );
    
    wp_enqueue_style( 'ui-datepicker-css', get_stylesheet_directory_uri() .'/css/jquery-ui.css');
    wp_enqueue_style( 'responsive-css', get_stylesheet_directory_uri() .'/css/responsive.css');
    wp_enqueue_style( 'ui-timepicker-css', get_stylesheet_directory_uri() .'/css/jquery-ui-timepicker-addon.css');
    wp_enqueue_style( 'datatable-css', get_stylesheet_directory_uri() .'/css/dataTables.bootstrap.min.css');
    wp_enqueue_style( 'scribblar-css', get_stylesheet_directory_uri() .'/css/scribblar.css');
    wp_enqueue_style( 'telephone-css', get_stylesheet_directory_uri() .'/css/intlTelInput.css');
//    wp_enqueue_style( 'star-css', get_stylesheet_directory_uri() .'/css/star-rating.css');
    
    wp_enqueue_script( 'jquery-validation-js');
    wp_enqueue_script( 'format-extension-js');
    wp_enqueue_script( 'student-validate-js');
    wp_enqueue_script( 'tutor-validate-js');
    wp_enqueue_script( 'ui-datepicker-js');
    wp_enqueue_script( 'ui-timepicker-js');
    wp_enqueue_script( 'datatable-js');
    wp_enqueue_script( 'bootstrap-datatable');
    wp_enqueue_script( 'scribblar-js');
    wp_enqueue_script( 'telephone-js');
//    wp_enqueue_script( 'star-js');
    
    $translation_array = array( 'siteUrl' => get_site_url(), 'SCRIBBLAR_API_KEY' => SCRIBBLAR_API_KEY , 'stylesheet_url' => get_stylesheet_directory_uri(), 'current_user_id' => get_current_user_id());
    wp_localize_script( 'student-validate-js', 'Urls', $translation_array );
    wp_localize_script( 'tutor-validate-js', 'Urls', $translation_array );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

//Get states from Seleted Country
add_action( 'wp_ajax_get_selected_states', 'get_selected_states' );
add_action( 'wp_ajax_nopriv_get_selected_states', 'get_selected_states' );
function get_selected_states(){
    if (isset($_POST["selected_country_code"]) && isset($_POST["selected_country_code"]) != '') { 
        global $woocommerce;
        $countries_obj   = new WC_Countries();
        $selected_country_code = $_POST["selected_country_code"];
        $country_no = $_POST['country_no'];
        $default_county_states = $countries_obj->get_states($selected_country_code);
        woocommerce_form_field('user_state_'.$country_no, array(
            'type'       => 'select',
            'class'      => array( 'chzn-drop' ),
            'placeholder'    => __('Enter something'),
            'options'    => $default_county_states
            )
            );
        die;
    }
}

//Get cities from Seleted States
add_action( 'wp_ajax_get_selected_cities', 'get_selected_cities' );
add_action( 'wp_ajax_nopriv_get_selected_cities', 'get_selected_cities' );
function get_selected_cities(){
    if (isset($_POST["selected_country_code"]) && isset($_POST["selected_state_code"])) { 
        $selected_country_code = $_POST["selected_country_code"];
        $selected_state_code = $_POST["selected_state_code"];
        $country_no = $_POST["country_no"];
        $selected_cities = $GLOBALS['wc_city_select']->get_cities($selected_country_code);
        foreach ($selected_cities as $key => $value) {
            if($key == $selected_state_code){
            echo '<select class="form-control" id="user_city_'.$country_no.'" name="user_city_'.$country_no.'"><option value="">--select city--</option>';
            foreach ($value as $city) {
                echo '<option value="'.$city.'">'.$city.'</option>';                                                
            }
            echo '</select>';
            }
        }
        die;
    }
}

//Display all states
add_action( 'wp_ajax_get_all_states', 'get_all_states' );
add_action( 'wp_ajax_nopriv_get_all_states', 'get_all_states' );
function get_all_states(){
    if (isset($_POST["selected_country_code"]) && isset($_POST["selected_country_code"]) != '') { 
        global $woocommerce;
        $countries_obj   = new WC_Countries();
        $selected_country_code = $_POST["selected_country_code"];
        $country_no = $_POST['country_no'];
        $default_county_states = $countries_obj->get_states($selected_country_code);
        woocommerce_form_field('tutor_state_'.$country_no, array(
            'type'       => 'select',
            'class'      => array( 'chzn-drop' ),
            'placeholder'    => __('Enter something'),
            'options'    => $default_county_states
            )
            );
        die;
    }
}

//Display All cities
add_action( 'wp_ajax_get_all_cities', 'get_all_cities' );
add_action( 'wp_ajax_nopriv_get_all_cities', 'get_all_cities' );
function get_all_cities(){
    if (isset($_POST["selected_country_code"]) && isset($_POST["selected_state_code"])) { 
        $selected_country_code = $_POST["selected_country_code"];
        $selected_state_code = $_POST["selected_state_code"];
        $country_no = $_POST["country_no"];
        $selected_cities = $GLOBALS['wc_city_select']->get_cities($selected_country_code);
        foreach ($selected_cities as $key => $value) {
            if($key == $selected_state_code){
            echo '<select class="form-control" id="tutor_city_'.$country_no.'" name="tutor_city_'.$country_no.'"><option value="">--select city--</option>';
            foreach ($value as $city) {
                echo '<option value="'.$city.'">'.$city.'</option>';                                                
            }
            echo '</select>';
            }
        }
        die;
    }
}

//File Upload code
add_action( 'wp_ajax_display_upload_files', 'display_upload_files' );
add_action( 'wp_ajax_nopriv_display_upload_files', 'display_upload_files' );
function display_upload_files(){
        $id = $_POST['id'] ;
        $files = $_FILES[$id];
            $arr_docs = array();
                if(!$files[error][0]){
                   if ( ! function_exists( 'wp_handle_upload' ) ) {
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    }

                   $upload_overrides = array( 'test_form' => false );
                   $movefile = wp_handle_upload( $files, $upload_overrides );
                    if ( $movefile && ! isset( $movefile['error'] ) ) {
                        array_push($arr_docs,$movefile["url"]);
                    } else {
                        /**
                         * Error generated by _wp_handle_upload()
                         */
                        $_SESSION['error'] = $movefile['error'];
                    }
                }
            $data['result'] = $arr_docs;
            echo json_encode($data);
            exit;
}

//Video Upload Code
add_action( 'wp_ajax_display_selected_video', 'display_selected_video' );
add_action( 'wp_ajax_nopriv_display_selected_video', 'display_selected_video' );
function display_selected_video(){
    $id = $_POST['id'];
    $size = $_FILES[$id]['size'];
    $filesize = number_format($size / 1048576, 2);
    if($filesize <= Upload_File_Size){
    $file = $_FILES[$id];
//    print_r($file);
    if(!$file[error]){
       if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
        }

       $upload_overrides = array( 'test_form' => false );
       $movefile = wp_handle_upload( $file, $upload_overrides );
//       print_r($movefile);
        if ( $movefile && ! isset( $movefile['error'] ) ) {
            $target_file = $movefile["url"];
            $type = $movefile["type"];
            if($type != 'video/mp4'){
                $upload_dir = wp_upload_dir();
                $rand_file_name = rand().".mp4";
                //exec("ffmpeg -i ".$movefile['file']." -c:v libx264 ".$upload_dir['path']."/".$rand_file_name);
                exec(get_stylesheet_directory()."/ffmpeg/ffmpeg.exe -i ".$movefile['file']." -c:v libx264 ".$upload_dir['path']."/".$rand_file_name);
                $target_file = $upload_dir['url']."/".$rand_file_name;
                unlink($movefile['file']);
            }
        } else {
            /**
             * Error generated by _wp_handle_upload()
             */
            echo "<span style='color:red;'>".$movefile['error']."</span>";
        }
    }
    // Prepare an array of post data for the attachment
//    $attachment = array(
//            'guid'           => $target_file, 
//            'post_mime_type' => $type,
//            'post_title'     => preg_replace( '/\.[^.]+$/', '', $name ),
//            'post_content'   => '',
//            'post_status'    => 'inherit'
//    );
//    // Insert the attachment.
//    $attach_id = wp_insert_attachment( $attachment, $target_file );
//    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
//    require_once( ABSPATH . 'wp-admin/includes/image.php' );
//    require_once( ABSPATH . 'wp-admin/includes/file.php' );
//    require_once( ABSPATH . 'wp-admin/includes/media.php' );
//	
//    // Generate the metadata for the attachment, and update the database record.
//    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
//    wp_update_attachment_metadata( $attach_id, $attach_data );
//    echo $target_file;
    if(!empty($target_file)){
    echo "<input type='hidden' name='video_url' name='video_url' value='".$target_file."'>";
    echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="480"]');}
    }else{
        echo "<span style='color:red;'>File size exceeds the maximum upload file size</span>";
    }
    die;
}

function my_handle_attachment($file_handler,$post_id,$set_thu=false) {
// check to make sure its a successful upload
if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

$attach_id = media_handle_upload( $file_handler, $post_id );
if ( is_numeric( $attach_id ) ) {
update_post_meta( $post_id, '_my_file_upload', $attach_id );
}
}

//Code for verification after registration of user
add_action( 'init', 'my_init' );
// we need this to handle all the getty hacks i made
function my_init(){
        // check whether we get the activation message
    global $wpdb;
    do_action( 'woocommerce_set_cart_cookies',  true );
        if(isset($_GET['p'])){
                $data = unserialize(base64_decode($_GET['p']));
                $code = get_user_meta($data['id'], 'activationcode', true);
                $userdata = get_userdata($data['id']);   
//                var_dump($code == $data['code']);die;
//                print_r($userdata);die;
                // check whether the code given is the same as ours
                if($code == $data['code']){
                        if($data['role'] == 'student'){
                            // update the db on the activation process
                            update_user_meta($data['id'], 'is_activated', 1);
//                            wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'inkfool' )  );
                            wc_add_notice( sprintf( __( "Your account has been activated!", "inkfool" ) ) ,'success' );
                        }
                        if($data['role'] == 'tutor'){
                            //newly added
                            update_user_meta($data['id'], 'is_activated', 1);
                            //Email to Tutor after review of documentation 
                            $mails = WC()->mailer()->get_emails();
                            $args = array(
                                'heading'=>'Upload Your Documents',
                                'subject'=>'Upload Your Documents',
                                'template_html'=>'emails/tutor-review-documentation.php',
                                'recipient'=> $userdata->user_email);
                            $params = (object)array(
                                'tutor_name'=> $userdata->display_name,
                                'login_link'=> SITE_URL."/my-account/",
                            );
                            $mails['WP_Dynamic_Email']->set_args($args);
                            $mails['WP_Dynamic_Email']->trigger($params);
                            
                            wc_add_notice( sprintf( __( "Thanks for confirming your email. You will be able to add courses & 1on1 Tutoring sessions to the system once your application is approved by the admin. We will inform you as soon as that happens.", "inkfool" ) ) ,'success' );
                        }
                        update_user_meta($data['id'], 'activationcode', '');
                }else{
                        wc_add_notice( sprintf( __( "Activation fails, please contact our administrator.", "inkfool" ) ) ,'error' );
                }
                wp_redirect(SITE_URL."/my-account/");
                exit;
        }
        if(isset($_GET['q'])){
                wc_add_notice( sprintf( __( "Your account has to be activated before you can login. Please check your email.", "inkfool" ) ) ,'Error' );
                wp_redirect(SITE_URL."/my-account/");
                exit;
        }
        if(isset($_GET['u'])){
                my_user_register($_GET['u']);
                wc_add_notice( sprintf( __( "Your activation email has been resend. Please check your email.", "inkfool" ) ) ,'success' );
                wp_redirect(SITE_URL."/my-account/");
                exit;
        }
}


// this is just to prevent the user log in automatically after register
add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
function wc_registration_redirect( $redirect_to ) {
        wp_logout();
        wp_redirect( '/my-account/?q=');
        exit;
}

// when user login, we will check whether this guy email is verify
add_filter('wp_authenticate_user', 'myplugin_auth_login',1,2);
function myplugin_auth_login( $userdata ) {
        if($userdata->roles[0] == "student" || $userdata->roles[0] == "tutor"){
            $isActivated = get_user_meta($userdata->ID, 'is_activated',true);
        if ( !$isActivated ) {
                return new WP_Error(
                                'inkfool_confirmation_error',
                                __( 'Your account has to be activated before you can login. You can resend by clicking <a href="'.SITE_URL.'/my-account/?u='.$userdata->ID.'">here</a>', 'inkfool' )
                                );
        }else{
            return $userdata;
        }}
        
        if($userdata->roles[0] == "administrator"){
            return $userdata; 
        }
        
//        if($userdata->roles[0] == "tutor"){
//            $isActivated = get_user_meta($userdata->ID, 'is_activated',true);
//            
//        if ( !$isActivated ) {
//                return new WP_Error(
//                                'inkfool_confirmation_error',
//                                __( 'Your account has to be activated before you can login.You can resend by clicking <a href="'.SITE_URL.'/my-account/?u='.$userdata->ID.'">here</a>', 'inkfool' )
//                                );
//        }else{
//            return $userdata;
//        }
//        }
 }

function get_user_role() { // returns current user's role
	global $current_user;
	$user_roles = $current_user->roles;
	return $user_role; // return translate_user_role( $user_role );
}

// when a user register we need to send them an email to verify their account
add_action('user_register', 'my_user_register',10,2);
function my_user_register($user_id) {
        // get user data
        $user_info = get_userdata($user_id);
        // create md5 code to verify later
        $code = md5(time());
        //user role
        $user_role = $user_info->roles[0];
        // make it into a code to send it to user via email
        $string = array('id'=>$user_id, 'code'=>$code, 'role'=>$user_role);
        // create the activation code and activation status
        update_user_meta($user_id, 'is_activated', 0);
        update_user_meta($user_id, 'activationcode', $code);
        global $wpdb;
        do_action( 'woocommerce_set_cart_cookies',  true );
        
        if($user_info->roles[0] == 'student'){
            //Send mail to student after registration
            $args = array(
                'heading'=>'Account Activation for HighQ',
                'subject'=>'Please activate your account',
                'template_html'=>'emails/student-registration.php',
                'recipient'=> $user_info->user_email);
        }
        if($user_info->roles[0] == 'tutor'){
            update_user_meta($user_id, 'is_approved', 0);
            //Send mail to tutor after registration
            $args = array(
                'heading'=>'Account Activation for HighQ',
                'subject'=>'Please activate your account',
                'template_html'=>'emails/tutor-registration.php',
                'recipient'=> $user_info->user_email);
        }
        $mails = WC()->mailer()->get_emails();
        $url = get_site_url(). '/my-account/?p=' .base64_encode( serialize($string));
        $params = (object)array(
            'user_name'=> $user_info->display_name,
            'activation_link'=> $url,
        );
        $mails['WP_Dynamic_Email']->set_args($args);
        $mails['WP_Dynamic_Email']->trigger($params);
}


//Display User Information at Backend
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
function my_show_extra_profile_fields( $user ) {
    $options = esc_attr( get_the_author_meta( 'is_approved', $user->ID ) );
    $current_user_meta = get_user_meta($user->ID);
    if($user->roles[0] == 'tutor'){
        $vars = array('tutor_qualification','tutor_institute','tutor_year_passing','uploaded_docs','language_known','subs_can_teach','tutor_level','tutor_grade','new_subject_title');
        foreach ($vars as $key => $value) {
            $$value = isset($current_user_meta[$value][0]) ? array_values(maybe_unserialize($current_user_meta[$value][0])) : "";
        }
        $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
        $id = $post->ID;
        $post_meta = get_post_custom($id);
        $Grade = $post_meta[Grade][0];
        $subjects = $post_meta[subjects][0];
        $Level = $post_meta[Level][0];
    ?>
<h2>Tutor Information</h2>
    <table class="form-table">
        <tr>
            <th><label for="is_approved">User Activation</label></th>
            <td>
                <input id="old_is_approved" name="old_is_approved" value="<?php echo $options;?>" type="hidden">
                <select name="is_approved" id="is_approved">
                    <option value="">Select Status</option>
                    <option value="1" <?php if($options==1) echo 'selected="selected"'; ?>>Approve</option>
                    <option value="0" <?php if($options==0) echo 'selected="selected"'; ?>>Reject</option>
                </select>
                <span class="description">(Approve will verify user.)</span>
            </td>
        </tr>
        
        <tr>
        <th><label for="tutor_video">Tutor Uploaded Video</label></th>
        <td>
            <?php 
            echo do_shortcode('[videojs_video url="'.$current_user_meta[tutor_video_url][0].'" webm="'.$current_user_meta[tutor_video_url][0].'" ogv="'.$current_user_meta[tutor_video_url][0].'" width="480"]');?>
        </td>
        </tr>
        <tr>
            <?php if(!empty($tutor_qualification)){?>
            <th><label for="tutor_docs">Educational Information</label></th>
                <?php foreach ($tutor_qualification as $key => $value) {
                    echo "<td>";
                    echo $value.": ".$tutor_institute[$key]." - ".$tutor_year_passing[$key];
                    if(!empty($uploaded_docs[$key])){
                    foreach ($uploaded_docs[$key] as $index => $value1) {
                       echo "<a href='".$value1."'>Document</a>";
                    }}
                    echo "</td>";
            }}?>
        </tr>
        <tr>
            <?php if(!empty($language_known)){?>
            <th><label for="tutor_docs">Language Proficiency</label></th>
                <?php foreach ($language_known as $key => $value) {
                    echo "<td>";
                    echo $value;
                    echo "</td>";
            }}?>
        </tr>
        <tr>
            <?php if(!empty($subs_can_teach)){?>
            <th><label for="tutor_docs">Subjects Taught</label></th>
            <td><table border='1'><tr><th>Subject</th><th>Grade</th><th>Level</th>
                <?php foreach ($subs_can_teach as $key => $sub) {
                    echo "<tr><td><select id='subjects_$key' class='form-control' name='subjects[$key]'>";
                    $arr = explode("|", $subjects);
                    foreach ($arr as $value) {
                        $attr = ($sub == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    }
                    echo '</select>';
                    if($sub == 'Other'){
                        echo $new_subject_title[$key];
                    }
                    echo "</td><td><select id='grade_$key' class='form-control' name='grade[$key]'>";
                    $arr1 = explode("|", $Grade);
                    foreach ($arr1 as $value1) {
                        $attr1 = ($tutor_grade[$key] == $value1) ? "selected='selected'" : "";
                        echo '<option value="'.$value1.'" '.$attr1.'>'.$value1.'</option>';
                    } 
                    echo "</select></td><td><select id='level_$key' class='form-control' name='level[$key]'>";
                    $arr2 = explode("|", $Level);
                    foreach ($arr2 as $value2) {
                        $attr2 = ($tutor_level[$key] == $value2) ? "selected='selected'" : "";
                        echo '<option value="'.$value2.'" '.$attr2.'>'.$value2.'</option>';
                    } 
                    echo "</select></td></tr>";
                }?>
            </tr></table></td>
            <?php }?>
        </tr>
        <tr>
            <?php 
            $tutor_description = $current_user_meta[tutor_description][0];
            if(!empty($tutor_description)){?>
            <th><label for="tutor_docs">About Tutor</label></th>
                <?php 
                    echo "<td>";
                    echo "<span>".$tutor_description."</span>";
                    echo "</td>";
            }?>
        </tr>
        <tr>
            <th><label for="tutor_docs">Tutor Hourly Rate</label></th>
                <?php $hourly_rate = $current_user_meta[hourly_rate][0];
                    if(!empty($hourly_rate)){
                    echo "<td>";
                    echo wc_price($hourly_rate);
                    echo "</td>";}
                ?>
        </tr>
        <tr>
            <th><label for="tutor_docs">Wallet Balance</label></th>
                <?php $_uw_balance = $current_user_meta[_uw_balance][0];
                    echo "<td>";
                    echo $_uw_balance ? wc_price($_uw_balance) : '0';
                    echo "</td>";
                ?>
        </tr>
    </table>
    <?php
    }
    if($user->roles[0] == 'student'){?>
        <table class="form-table">
        <tr>
            <th><label for="wallet_balance">Wallet Balance</label></th>
                <?php $_uw_balance = $current_user_meta[_uw_balance][0];
                    echo "<td>";
                    echo $_uw_balance ? wc_price($_uw_balance) : '0';
                    echo "</td>";
                ?>
        </tr>
        </table>
    <?php }
}

//Save Approved user functionality
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
//    $subjects = array_values(array_filter($_POST['subjects']));
//    $grade = array_values(array_filter($_POST['grade']));
//    $level = array_values(array_filter($_POST['level']));
//    update_user_meta($user_id, 'subs_can_teach', $subjects);
//    update_user_meta($user_id, 'tutor_grade', $grade);
//    update_user_meta($user_id, 'tutor_level', $level);
//    print_r($_POST);die;
    $is_approved = esc_attr( get_the_author_meta( 'is_approved', $user_id) );
    $user_info = get_userdata($user_id);
    $user_meta = get_user_meta($user_id);
        if(isset($_POST['is_approved']) && $_POST['is_approved'] == 1 && $_POST['is_approved'] != $is_approved){
            
        // Send email to Tutor after Admin approval
        $url = get_site_url(). '/my-account/';
        $mails = WC()->mailer()->get_emails();
        $args = array(
            'heading'=>'Your Application Has Been Approved By Admin',
            'subject'=>'Application Approved By Admin',
            'template_html'=>'emails/tutor-admin-approval.php',
            'recipient'=> $user_info->user_email);

        $params = (object)array(
            'tutor_name'=> $user_info->display_name,
        );
        $mails['WP_Dynamic_Email']->set_args($args);
        $mails['WP_Dynamic_Email']->trigger($params);
                            
        //Api For Creating User on scribblar
        $uri = 'https://api.scribblar.com/v1/';
        $body = array(
            'api_key'=> SCRIBBLAR_API_KEY,
            'email'=>$user_info->user_email,
            'firstname'=>$user_meta[first_name][0],
            'lastname'=>$user_meta[last_name][0],
            'roleid'=>100,
            'username'=>$user_info->user_email,
            'function'=>'users.add',
        );

        $args = array(
            'body' => $body,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array()
        );

    $response = wp_remote_post( $uri, $args );
    
    $body = wp_remote_retrieve_body( $response );
    $xml = simplexml_load_string($response[body]);
    $result = $xml->result;
    $roomowner_id = (string)$result->userid;
    $roomowner_username = (string)$result->username;
    
    if(!empty($roomowner_id)){
    //Api For Creating Room
        $roombody = array(
            'api_key'=> SCRIBBLAR_API_KEY,
            'roomname'=> 'HighQ - '.$user_meta[first_name][0]." ".$user_meta[last_name][0],
//            'password'=>'leo_123',allowguests=0&roomvideo=1&clearassets=1&allowlock=1&locked=0
            'roomowner'=> $roomowner_id,
            'allowguests'=> 0,
            'roomvideo'=> 1,
            'clearassets'=> 1,
            'function'=>'rooms.add',
            'allowlock'=> 1,
            'locked'=> 0
        );

        $roomargs = array(
            'body' => $roombody,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'cookies' => array()
        );

    $roomresponse = wp_remote_post( $uri, $roomargs );
    $roomxml = simplexml_load_string($roomresponse[body]);
    $roomresult = $roomxml->result;
    $roomid = (string)$roomresult->roomid;

    add_user_meta($user_id, '_scribblar_user_id', $roomowner_id);
    add_user_meta($user_id, '_scribblar_username', $roomowner_username);
//    add_user_meta($user_id, 'roomid', $roomid);
    }
    }
    $bool = update_user_meta($user_id ,'is_approved', $_POST['is_approved'] );
}
 
//add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );
//Custom Tab Account  Page
add_action( 'init', 'my_custom_endpoints' );
function my_custom_endpoints() {
//    add_rewrite_endpoint( 'my-account-details', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-inbox',  EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-orders',  EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-wallet',  EP_ROOT | EP_PAGES );
}

add_filter( 'query_vars', 'add_query_vars' , 0 );
function add_query_vars( $vars ) {
// $vars[] = 'my-account-details';
 $vars[] = 'my-inbox';
 $vars[] = 'my-orders';
 $vars[] = 'my-wallet';
 return $vars;
 }

add_action( 'after_switch_theme', 'my_custom_flush_rewrite_rules' );
function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}
/*
 * Change the order of the endpoints that appear in My Account Page - WooCommerce 2.6
 * The first item in the array is the custom endpoint URL - ie http://mydomain.com/my-account/my-custom-endpoint
 * Alongside it are the names of the list item Menu name that corresponds to the URL, change these to suit
 */
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );
function wpb_woo_my_account_order() {
$current_user = wp_get_current_user();
$user_role = $current_user->roles[0];
if($user_role == 'student'){
 $myorder = array(
// 'my-account-details' => __( 'My Account', 'woocommerce' ),
 'my-inbox' => __( 'My Inbox', 'woocommerce' ),
 'edit-account' => __( 'Account Settings', 'woocommerce' ),
 'my-orders' => __( 'My Orders', 'woocommerce' ),
 'my-wallet' => __( 'My Wallet', 'woocommerce' ),
// 'dashboard' => __( 'My Account', 'woocommerce' ),
// 'orders' => __( 'Orders', 'woocommerce' ),
// 'downloads' => __( 'Download MP4s', 'woocommerce' ),
// 'edit-address' => __( 'Addresses', 'woocommerce' ),
// 'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
 'customer-logout' => __( 'Log Out', 'woocommerce' ),
 );
}
if($user_role == 'tutor'){
    $myorder = array(
    // 'my-account-details' => __( 'My Account', 'woocommerce' ),
     'my-inbox' => __( 'My Inbox', 'woocommerce' ),
     'edit-account' => __( 'Account Settings', 'woocommerce' ),
     'my-orders' => __( 'My Orders', 'woocommerce' ),
    // 'dashboard' => __( 'My Account', 'woocommerce' ),
    // 'orders' => __( 'Orders', 'woocommerce' ),
    // 'downloads' => __( 'Download MP4s', 'woocommerce' ),
    // 'edit-address' => __( 'Addresses', 'woocommerce' ),
    // 'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
     'customer-logout' => __( 'Log Out', 'woocommerce' ),
     );
}
 return $myorder;
}

add_action( 'woocommerce_account_my-inbox_endpoint', 'inbox_page' );
function inbox_page() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-inbox.php';
}

add_action( 'woocommerce_account_my-orders_endpoint', 'orders_page' );
function orders_page() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-orders.php';
}

add_action( 'woocommerce_account_my-wallet_endpoint', 'my_wallet' );
function my_wallet() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-wallet.php';
}

//add_action( 'wp_ajax_remove_doc', 'remove_doc' );
//add_action( 'wp_ajax_nopriv_remove_doc', 'remove_doc' );
//function remove_doc(){
//    if (isset($_POST["doc_url"]) && isset($_POST["doc_url"]) != '') { 
//        $base = dirname(dirname(dirname(__FILE__)));
//        echo $base;
//        $bool = unlink("\wp-content\uploads\2017\02\invoice-17876.pdf");
//        
//        var_dump($bool);
//        die;
//    }
//    die;
//}

//Get Order table History
add_action( 'wp_ajax_get_order_table_history', 'get_order_table_history' );
add_action( 'wp_ajax_nopriv_get_order_table_history', 'get_order_table_history' );
function get_order_table_history(){
    $order_status = $_POST['order_status'];
    
    if(is_array($order_status)){
    $order_statuses = implode("','", array_filter($order_status));
    }else{
        $order_statuses = $order_status;
    }
    
//    var_dump($_POST['order_status']);
    date_default_timezone_set('UTC');
    $objDateTime = new DateTime('NOW');
    $history_from_date = date('Y-m-d', strtotime($_POST['history_from_date']));
    $history_to_date = date('Y-m-d', strtotime($_POST['history_to_date']));
//    $objDateTime = DateTime::createFromFormat('Y-m-d', '2017-04-26');
    if(!empty($order_statuses)){
        $string = "WHERE o.post_status IN ( '$order_statuses' )";
    }
    
    global $wpdb;
    $user_id = get_current_user_id();
    //Get all student list who had ordered this tutor products
    $customer_orders = $wpdb->get_results( $wpdb->prepare(
				"SELECT o.ID as order_id, oi.order_item_id , oim.* FROM
				{$wpdb->prefix}woocommerce_order_itemmeta oim
				INNER JOIN {$wpdb->prefix}woocommerce_order_items oi
				ON oim.order_item_id = oi.order_item_id
				INNER JOIN $wpdb->posts o
				ON oi.order_id = o.ID AND (CAST(o.post_date AS DATE) >= %s AND CAST(o.post_date AS DATE) <= %s)
                                INNER JOIN $wpdb->posts o1
                                ON oim.meta_key = '_product_id' 
                                AND oim.meta_value = o1.ID AND o1.post_author = %d
				$string
				ORDER BY o.ID DESC",
                                $history_from_date,
                                $history_to_date,
                                $user_id
			));
//    echo $wpdb->last_query;
    foreach ($customer_orders as $key => $orders) {
        $product_name = [];
        $line_total = 0;
        $order = wc_get_order($orders->order_id);
        $items = $order->get_items();
        $status = wc_get_order_status_name($order->post->post_status);
        
        foreach ($items as $key => $value) {
            $order_meta = maybe_unserialize($value[ld_woo_product_data]);
            $product_name[] = $value[name];
            $line_total += $value[line_total];
            $from_date = array_values(maybe_unserialize(get_post_meta($value[product_id],"from_date")));
            $from_time = array_values(maybe_unserialize(get_post_meta($value[product_id],"from_time")));
            foreach ($from_date as $key1 => $value1){
                $objDateTime1 = DateTime::createFromFormat('Y-m-d H:i', $value1." ".$from_time[$key1], new DateTimeZone('UTC'));
                $interval = $objDateTime1->diff($objDateTime);
                if($objDateTime1 > $objDateTime && $interval->d >= 2 && ($status == "Completed")){
                    $action = 1;
                }else{
                    $action = 0;
        }
            }
        }
            $datetime_obj = DateTime::createFromFormat('Y-m-d H:i:s', $order->order_date);
          
            $post_status[] = $status;
            $order_date[] = $datetime_obj->format('d/M/Y H:i:s');
            $product_names[$orders->order_id] = $product_name;
            $line_totals[] = $line_total;
            $product_id[] = $value[product_id];
            $order_item_meta[] = $order_meta;
            $order_id[] = $orders->order_id;
            $actions[]= $action;
    }
    $data['result'] = array('product_id'=>$product_id,
                  'product_name'=>$product_names,
                  'line_total'=>$line_totals,
                  'post_status'=>$post_status,
                  'order_date'=>$order_date,
                  'order_id' => $order_id,
                  'Action'=>$actions, 
                  'order_item_meta'=>$order_item_meta);
    echo json_encode($data);
    die;
}

//Get Student Order table History
add_action( 'wp_ajax_get_studentorder_table_history', 'get_studentorder_table_history' );
add_action( 'wp_ajax_nopriv_get_studentorder_table_history', 'get_studentorder_table_history' );
function get_studentorder_table_history(){
    $order_status = $_POST['order_status']!="" ? $_POST['order_status'] : wc_get_order_statuses();
    date_default_timezone_set('UTC');
    $objDateTime = new DateTime('NOW');
    
    $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => $order_status,
        'date_query' => array(
            'after' => date('Y-m-d', strtotime($_POST['history_from_date'])),
            'before' => date('Y-m-d', strtotime($_POST['history_to_date'])),
            'inclusive' => true,
        ),
    ) );
    foreach ($customer_orders as $key => $orders) {
        $product_name = [];
        $line_total = 0;
        $order = wc_get_order($orders->ID);
        $items = $order->get_items();
        $status = wc_get_order_status_name($order->post->post_status);
        if(in_array($status, wc_get_order_statuses()))
        {
        foreach ($items as $key => $value) {
            $order_meta = maybe_unserialize($value[ld_woo_product_data]);
//            if(get_current_user_id() == $order_meta[id_of_tutor]){
            $from_date = array_values(maybe_unserialize(get_post_meta($value[product_id],"from_date")));
            $from_time = array_values(maybe_unserialize(get_post_meta($value[product_id],"from_time")));
            foreach ($from_date as $key1 => $value1){
                $objDateTime1 = DateTime::createFromFormat('Y-m-d H:i', $value1." ".$from_time[$key1], new DateTimeZone('UTC'));
                $interval = $objDateTime1->diff($objDateTime);
//                print_r($objDateTime1);
                if($objDateTime1 > $objDateTime && $interval->d >= 2 && ($status == "Pending Payment" || $status == "Processing" || $status == "Completed" || $status == "On Hold")){
//                       $action = wp_nonce_url(admin_url('admin-ajax.php?action=mark_order_as_cancell_request&order_id=' . $orders->ID), 'woocommerce-mark-order-cancell-request-myaccount');
                    $action = 1;
                }else{
                    $action = 0;
                }
            }
            $product_name[] = $value[name];
            $line_total += $value[line_total];
        }
        }
            $datetime_obj = DateTime::createFromFormat('Y-m-d H:i:s', $order->order_date);
            $post_status[] = $status;
            $order_date[] = $datetime_obj->format('d/M/Y H:i:s');
            $product_names[$orders->ID] = $product_name;
            $line_totals[] = $line_total;
            $product_id[] = $value[product_id];
            $order_item_meta[] = $order_meta;
            $order_id[] = $orders->ID;
            $actions[]= $action;
    }
    $data['result'] = array('product_id'=>$product_id,
                  'product_name'=>$product_names,
                  'line_total'=>$line_totals,
                  'post_status'=>$post_status,
                  'order_date'=>$order_date,
                  'order_id' => $order_id,
                  'Action'=>$actions, 
                  'order_item_meta'=>$order_item_meta);
    echo json_encode($data);
    die;
}

//Function to Save Product Metadata when add to cart
add_action( 'woocommerce_add_to_cart', 'ld_woo_set_item_data'); 
function ld_woo_set_item_data( $cart_item_key, $key = '', $value= '' ) {
	$data = (array)WC()->session->get( '_ld_woo_product_data' );
	if ( empty( $data[$cart_item_key] ) ) {
		$data[$cart_item_key] = array();
	}
        $_product = wc_get_product($_POST['product_id']);
        $post_meta_data = get_post_meta($_POST['product_id']);
        foreach ($post_meta_data as $key => $value) {
            $data[$cart_item_key][$key] = $value[0];
        };
	WC()->session->set( '_ld_woo_product_data', $data );
}

function ld_woo_get_item_data( $cart_item_key, $key = null, $default = null ) {
	$data = (array)WC()->session->get( '_ld_woo_product_data' );
	if ( empty( $data[$cart_item_key] ) ) {
            $data[$cart_item_key] = array();
	}
	// If no key specified, return an array of all results.
	if ( $key == null ) {
            return $data[$cart_item_key] ? $data[$cart_item_key] : $default;
	}else{
            return empty( $data[$cart_item_key][$key] ) ? $default : $data[$cart_item_key][$key];
	}
}

function ld_woo_remove_item_data( $cart_item_key = null, $key = null ) {
	$data = (array)WC()->session->get( '_ld_woo_product_data' );
	if ( $cart_item_key == null ) {
		WC()->session->set( '_ld_woo_product_data', array() );
		return;
	}
	// If item is specified, but no data exists, just return
	if ( !isset( $data[$cart_item_key] ) ) {
		return;
	}
	if ( $key == null ) {
		// No key specified, delete this item data entirely
		unset( $data[$cart_item_key] );
	}else{
		if ( isset( $data[$cart_item_key][$key] ) ) {
			unset( $data[$cart_item_key][$key] );
		}
	}
	WC()->session->set( '_ld_woo_product_data', $data );
}

add_filter( 'woocommerce_before_cart_item_quantity_zero', 'ld_woo_remove_item_data', 10, 1 );
add_filter( 'woocommerce_cart_emptied', 'ld_woo_remove_item_data', 10, 1 );
function ld_woo_convert_item_session_to_order_meta( $item_id, $values, $cart_item_key ) {
	// Occurs during checkout, item data is automatically converted to order item metadata, stored under the "_ld_woo_product_data"
	$cart_item_data = ld_woo_get_item_data( $cart_item_key );
	// Add the array of all meta data to "_ld_woo_product_data". These are hidden, and cannot be seen or changed in the admin.
	if ( !empty( $cart_item_data ) ) {
		wc_add_order_item_meta( $item_id, '_ld_woo_product_data', $cart_item_data );
	}
}
add_action( 'woocommerce_add_order_item_meta', 'ld_woo_convert_item_session_to_order_meta', 10, 3 );

//Change woocommerce add to cart button Text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
    global $product;
    $request_uri = $_SERVER[REQUEST_URI];
    $url = explode("/", $request_uri);
    if($url[2] == "product")
        return __( 'Book Sessions', 'woocommerce' );
    else
        return __( 'Book Course', 'woocommerce' );  
    
    if( has_term( 'credit', 'product_cat', $product->ID) )
		return __( 'Buy Now', 'woocommerce' );
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
function woo_archive_custom_cart_button_text() {
        $request_uri = $_SERVER[REQUEST_URI];
        $url = explode("/", $request_uri);
        if($url[2] == "product")
            return __( 'Book Sessions', 'woocommerce' );
        else
            return __( 'Book Course', 'woocommerce' );
}

// numbered pagination
function pagination($pages = '', $range = 4, $paged = 1, $fun_name)
{  
     $showitems = ($range * 2)+1;  
 
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }   
     $num = 1;

     if(1 != $pages)
     {
         echo "<div class=\"pagination col-md-12\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".$num.")"."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".($paged - $num).")"."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='javascript:;' class=\"inactive\" onclick='".$fun_name."(".$i.")"."'>".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".($paged + $num).")"."'>Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".$pages.")"."'>Last &raquo;</a>";
         echo "</div>\n";
     }     
}

//Function to filter courses - course search Page
function get_refined_courses(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
    
 global $wpdb;
 $posts_per_page = posts_per_page;
 $offset = ($paged - 1)*$posts_per_page;
 $curriculumarr = $subjectarr = $gradearr = $pricearr = $sarr = $from_datearr = $from_timearr = '';
  $result_txt = '';
  
  if($search){
      $strings = explode(" ", $search);
      $strings = array_filter($strings);
      $sarr = array();
      if(count($strings) <= 1){
          $sarr = array ('value'=> $strings[0],
                         'compare'=>'LIKE'
                    );
      }else{
      $sarr['relation'] =  "OR";
      foreach ($strings as $key => $value) {
      $sarr[]= array (  'value'=> $value,
                         'compare'=>'LIKE'
                    );
      }}
      $result_txt .= $search." ";
  }
  if($curriculum){
      $curriculumarr =  array(
                                'key'     => 'curriculum',
                                'value'   => $curriculum,
                        );
      $result_txt .= $curriculum." ";
  }
  if($subject){
      $subjectarr = array(
                                'key'     => 'subject',
                                'value'   => $subject,
                        );
      $result_txt .= $subject ." ";
  }
  if($grade){
      $gradearr = array(
                                'key'     => 'grade',
                                'value'   => $grade,
                        );
      $result_txt .= $grade." ";
  }
  if($price){
      $pricearr = array(
                                'key'     => '_price',
                                'value'   => $price,
                                'compare'   => '<=',
                                'type'      => 'NUMERIC'
                        );
      $result_txt .= "$".$price." ";
  }
  if($from_date){
      $datetime_obj = DateTime::createFromFormat('d/m/Y', $from_date);
      $date = $datetime_obj->format('Y-m-d');
      $from_date = date('Y-m-d', strtotime($date));
      $to_date = date('Y-m-d', strtotime($from_date." +2 month"));
      
       $from_datearr = array(
                                'key'     => 'from_date',
                                'value'   => array($from_date,$to_date),
                                'compare'   => 'BETWEEN',
                                'type'      => 'DATE'
                        );
      $result_txt .= $from_date." ";
  }  
  if($from_time){
      $from_timearr = array(
                                'key'     => 'from_time',
                                'value'   => $from_time,
                                'compare'   => '>=',
                                'type'      => 'TIME'
                        );
      $result_txt .= $from_time;
  }  
  $todays_date = date("Y-m-d");

  echo ($result_txt != "") ? "<h2>Result For:".$result_txt."</h2>" : "";
  
  $args = array(
                'post_type' => 'product',
//                's'=> $s,
                'post_status' => 'publish',
//                'product_tag' 	 => $s ,
                'product_cat' => $category,
                'meta_query' => array(
                    'relation' => 'AND',
                        array(
                                'key'     => 'wpcf-course-status',
                                'value'   => 'Approved',
                        ),
                        array(
                                'key'     => 'tutoring_type',
                                'value'   => $type,
                        ),
                        array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        ),
                        $curriculumarr,
                        $subjectarr,
                        $gradearr,
                        $pricearr,
                        $from_datearr,
                        $from_timearr,
                        $sarr,
                ),
                'posts_per_page' => $posts_per_page,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                $loop = new WP_Query( $args );
                $count = 1;
//                echo $loop->request;
        if ( $loop->have_posts() ) :
        $currency_rate = get_current_exchange_rates();
        $currency = get_user_meta(get_current_user_id(),'currency');
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $loop->post->post_author;
        $current_user_meta = get_user_meta($user_id);
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $course_video = maybe_unserialize($product_meta[video_url][0]);
        $tutor_qualification = isset($current_user_meta[tutor_qualifications][0]) ? $current_user_meta[tutor_qualifications][0] : "";
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $timezone = get_current_user_timezone();
        $datetime_obj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        global $product;
             echo '<li class="col-md-4 result-box">';    
             echo '<h3 class="course-title"><a class="product-title" href="'.get_permalink( $loop->post->ID ).'" title="'.esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID).'">
                     '.$product->get_title().'</a>';
             echo '<span class="pull-right">';
                foreach ($course_video as $key => $value) {
                            if(!empty($value)){
                                echo '<a class="glyphicon glyphicon-facetime-video" data-toggle="modal" data-target="#'.$loop->post->ID.'tutorvideoModal"></a>';
                                echo '<div class="modal fade mymodal" id="'.$loop->post->ID.'tutorvideoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Tutor Video
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="pauseCurrentVideo('.$loop->post->ID.')">
                                        <span aria-hidden="true">&times;</span>
                                      </button></h5>
                                    </div>
                                    <div class="modal-body clearfix">';
                                    echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="580"]');
                                    echo '</div>
                                  </div>
                                </div>
                              </div>';
                            }
                }
                echo '</span></h3>';
                echo '<span> <strong>'.$product_meta[curriculum][0].' | '.$subjects.' | '.$product_meta[grade][0].'</strong></span><br/>';
                echo '<span> <strong>No of Classes/hours: </strong>'.$no_of_classes.'</span><br/>';
                echo '<span><strong>Start Date & Time: </strong><span class="highlight">';
                        if(is_user_logged_in()){
                            $otherTZ  = new DateTimeZone($timezone);
                            $datetime_obj->setTimezone($otherTZ); 
                            $date = $datetime_obj->format('d/M/Y h:i A T');
                            echo $date;
                        }else{
                            $date = $datetime_obj->format('d/M/Y h:i A T');
                            echo $date;  
                            echo '<small class="clearfix">(Login to check session Date & Time in your Timezone)</small>';
                        }
                echo '</span></span><br>';
                echo '<span><strong>Taught online by: </strong><a data-toggle="modal" data-target="#'.$loop->post->ID.'tutorinfoModal" class="highlight">'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</a></span><br/>';
                $_product = wc_get_product( $loop->post->ID );
                echo '<span> <strong>Price: </strong><span class="price">'.wc_price($_product->get_price());
                echo isset($currency_rate) ? ' (approx '.floatval($_product->get_price() * $currency_rate).' '.$currency[0].' )' : '';
                echo '</span></span><br>';
                echo '<span> <strong>Seats Available: </strong>'.$product->get_stock_quantity().'</span>';
                echo '<input type="hidden" id="post_id_'.$count.'" class="post_ids" value="'.$loop->post->ID.'">';
                echo '<div>';
                woocommerce_template_loop_add_to_cart( $loop->post, $product );
                echo '</div>';
                echo '<div class="modal fade " id="'.$loop->post->ID.'tutorinfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">'.$product->get_title().'
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button></h5>
                            </div>
                            <div class="modal-body clearfix">';
                                    echo '<div class="tutor-profile col-md-3">'.get_wp_user_avatar( $user_id, 'medium').'</div>';
                                    echo '<div class="tutor-info col-md-9"> <h3 class="course-title"><a href="'.get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($user_id).'" title="'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'">'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</a></h3>';
//                                    echo '<span> <strong>Rating:</strong> </span><br/>';
                                    echo '<span> <strong>Qualification of Tutor: </strong>';
                                    echo $tutor_qualification;
                                    echo '</span><br/>';
                                    echo '<span> <strong>No. of Sessions: </strong>'.$no_of_classes.'</span><br/>';
                                    echo '<span> <strong>Hourly Rate: </strong>'.wc_price($current_user_meta[hourly_rate][0]);
                                    echo isset($currency_rate) ? ' (approx '.floatval($current_user_meta[hourly_rate][0] * $currency_rate).' '.$currency[0].' )' : '';
                                    echo '</span><br/>';
                                    echo '<p>'.$current_user_meta[tutor_description][0].'</p>';
                                    echo '</div>';
                            echo '</div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                </li>';
            $count +=1;
         endwhile;  
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_course');
            }
                ?>
            <?php else:
                echo '<p class="error">'._e( 'Sorry, no Courses matched your criteria.' ).'</p>';
            endif;
    die;
}

//Tutor Search Page
add_action( 'wp_ajax_get_refined_courses', 'get_refined_courses' );
add_action( 'wp_ajax_nopriv_get_refined_courses', 'get_refined_courses' );
function get_refined_tutors(){
        foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
//        $_SESSION['tutor_search'][$key] = (isset($value) && !empty($value)) ? $value : "";
    }
 global $wpdb;
 $posts_per_page = posts_per_page;
 $offset = ($paged - 1)*$posts_per_page;
 $curriculumarr = $subjectarr = $gradearr = $pricearr = $sarr = $from_datearr = $from_timearr = '';
 $arr = array();
  $result_txt = '';
  if($search){
      $strings = explode(" ", $search);
      $strings = array_filter($strings);
      $sarr = array();
      if(count($strings) <= 1){
          $sarr = array (  'value'=> $strings[0],
                         'compare'=>'LIKE'
                    );
      }else{
      $sarr['relation'] =  "OR";
      foreach ($strings as $key => $value) {
      $sarr[]= array (  'value'=> $value,
                         'compare'=>'LIKE'
                    );
      }}
      $result_txt .= $search." ";
      
  }
  if($curriculum){
      $curriculumarr =  array(
                                'key'     => 'curriculum',
                                'value'   => $curriculum,
                        );
      $result_txt .= $curriculum." ";
  }
  if($subject){
      $subjectarr = array(
                                'key'     => 'subject',
                                'value'   => $subject,
                        );
      $result_txt .= $subject ." ";
  }
  if($grade){
      $gradearr = array(
                                'key'     => 'grade',
                                'value'   => $grade,
                        );
      $result_txt .= $grade." ";
  }
  if($price){
      $pricearr = array(
                                'key'     => '_price',
                                'value'   => $price,
                                'compare'   => '<=',
                                'type'      => 'NUMERIC'
                        );
      $result_txt .= "$".$price." ";
  }
  if($from_date){
      $datetime_obj = DateTime::createFromFormat('d/m/Y', $from_date);
      $date = $datetime_obj->format('Y-m-d');
      $from_date = date('Y-m-d', strtotime($date));
      $to_date = date('Y-m-d', strtotime($from_date." +2 month"));
      $from_datearr = array(
                                'key'     => 'from_date',
                                'value'   => array($from_date,$to_date),
                                'compare'   => 'BETWEEN',
                                'type'      => 'DATE'
                        );
      $result_txt .= $from_date." ";
  }
  if($from_time){
      $from_timearr = array(
                                'key'     => 'from_time',
                                'value'   => $from_time,
                                'compare'   => '>=',
                                'type'      => 'TIME'
                        );
      $result_txt .= $from_time;
  }
  $todays_date = date("Y-m-d");
  
  echo ($result_txt != "") ? "<h2>Result For:".$result_txt."</h2>" : "";
 
    $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
//                array(
//                    'meta_value'=>$s,
//                    'meta_compare'=>'LIKE'
//                ),
                'product_cat' => $category,
                'meta_query' => array(
                    'relation' => 'AND',
                        array(
                                'key'     => 'wpcf-course-status',
                                'value'   => 'Approved',
                        ),
                        array(
                                'key'     => 'tutoring_type',
                                'value'   => $type,
                        ),
                        array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        ),
                        $curriculumarr,
                        $subjectarr,
                        $gradearr,
                        $pricearr,
                        $from_datearr,
                        $from_timearr,
                        $sarr
                ),
                'posts_per_page' => $posts_per_page,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                add_filter( 'posts_groupby', 'my_posts_groupby' );
                $loop = new WP_Query( $args );
                $count = 1;
//                echo $loop->request;
    if ( $loop->have_posts() ) :
        $currency_rate = get_current_exchange_rates();
        $currency = get_user_meta(get_current_user_id(),'currency');
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $loop->post->post_author;
        $current_user_meta = get_user_meta($user_id);
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $tutor_video = $current_user_meta[tutor_video_url][0];
        global $product;
//            if($product->get_stock_quantity() >= 1 ){
             echo '<li class="col-md-4 result-box">';    
             echo '<div class="col-md-4 col-xs-4 tutor-profile">'.get_wp_user_avatar( $user_id, 'medium').'</div>';
             echo '<div class="col-md-8 col-xs-8 tutor-info"><h3 class="course-title"><a title="'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'" href="'.get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ).'?'.base64_encode($user_id).'" class="product-title">
                     '.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</a>';
					  echo !empty($tutor_video) ? '<span class="pull-right"><a class="glyphicon glyphicon-facetime-video" data-toggle="modal" data-target="#'.$loop->post->ID.'tutorvideoModal"></a></span></h3>' : '</h3>';
             echo '<span><strong>'.$product_meta[curriculum][0].' | '.$subjects.' | '.$product_meta[grade][0].'</strong></span><br/>';
             echo '<span><strong> Qualification: </strong>'; 
             echo  isset($current_user_meta[tutor_qualifications][0]) ? $current_user_meta[tutor_qualifications][0] : "";
             echo '</span><br/>';
                echo '<span> <strong>Hourly Rate: </strong><span class="price">'.wc_price($current_user_meta[hourly_rate][0]);
                echo isset($currency_rate) ? ' (approx '.floatval($current_user_meta[hourly_rate][0] * $currency_rate).' '.$currency[0].' )' : '';
                echo '</span></span><br/>';
                echo '<span> <strong>Country: </strong>';
                $Country_code  = isset($current_user_meta[billing_country][0]) ? $current_user_meta[billing_country][0] : "";
                echo WC()->countries->countries[ $Country_code ];
                echo '</span>';
                echo '<input type="hidden" id="post_id_'.$count.'" class="post_ids" value="'.$loop->post->ID.'">';
                echo '<span class="pull-right">';
                            if(!empty($tutor_video)){
                                echo '<div class="modal fade mymodal" id="'.$loop->post->ID.'tutorvideoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Tutor Video
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="pauseCurrentVideo('.$loop->post->ID.')">
                                        <span aria-hidden="true">&times;</span>
                                      </button></h5>
                                    </div>
                                    <div class="modal-body clearfix">';
                                    echo do_shortcode('[videojs_video url="'.$tutor_video.'" webm="'.$tutor_video.'" ogv="'.$tutor_video.'" width="580"]');
                                    echo '</div>
                                  </div>
                                </div>
                              </div>';
                            }
                echo '</span>';               
//                woocommerce_template_loop_add_to_cart( $loop->post, $product );
                echo '</li>';
                $count +=1;
//            }
            endwhile;
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_tutor');
            }
                ?>
            <?php else:
                echo '<p class="error">'._e( 'Sorry, no Tutors matched your criteria.' ).'</p>';
            endif;
    die;
}
add_action( 'wp_ajax_get_refined_tutors', 'get_refined_tutors' );
add_action( 'wp_ajax_nopriv_get_refined_tutors', 'get_refined_tutors' );

//Tutor 1on1 Availalbility
function get_tutor_availability(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
    $subfilter = $date_query = '';
    if($from_date && $to_date){
        $datetime_obj1 = DateTime::createFromFormat('d/m/Y', $from_date, new DateTimeZone('UTC'));
        $datetime_obj2 = DateTime::createFromFormat('d/m/Y', $to_date, new DateTimeZone('UTC'));
        $from_date = $datetime_obj1->format('Y-m-d');
        $to_date = $datetime_obj2->format('Y-m-d');
        }
        $date_query = array(
            'key'     => 'from_date',
            'value'   => array( $from_date, $to_date ),
            'type'    => 'DATE',
            'compare' => 'BETWEEN',
        );
    $todays_date = date("Y-m-d");
    if(isset($subject) && !empty($subject)){
        $subfilter = array(
			'key'     => 'subject',
			'value'   => $subject,
		);
    }
        $args = array(
        'post_type' => 'product',
        'author' => $user_id,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
                array(
			'key'     => 'tutoring_type',
			'value'   => '1on1',
		),
                array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        ),
                $subfilter,
                $date_query,
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );
//echo $the_query->request;
        if ( $the_query->have_posts() ) : 
        while ( $the_query->have_posts() ) : $the_query->the_post();
         $product_meta = get_post_meta($the_query->post->ID);
         global $product;
         $format = "Y-m-d H:i";
         $datetime_obj = DateTime::createFromFormat($format, $product_meta[from_date][0]." ".$product_meta[from_time][0],new DateTimeZone('UTC'));
         if(is_user_logged_in()){
            $datetime_obj->setTimezone(new DateTimeZone($timezone));
         }
        ?>
        <p class="field-para">
             Session Date & Time: <?php echo $datetime_obj->format('d/m/Y h:i A T');?><br/>
        </p>
        <?php woocommerce_template_loop_add_to_cart( $the_query->post, $product ); ?>
        <br/>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); 
        else :?>
        <p><?php _e( 'Sorry, no Sessions matched your criteria.' ); ?></p>
        <?php endif;
    die;
}
add_action( 'wp_ajax_get_tutor_availability', 'get_tutor_availability' );
add_action( 'wp_ajax_nopriv_get_tutor_availability', 'get_tutor_availability' );

/**
 * Show Product Data on Product Page
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'display_product_details', 11 );
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
function display_product_details() {
    //Get Logged in user timezone
    $logged_in_user_id = get_current_user_id();
    $logged_in_user_meta = get_user_meta($logged_in_user_id);
    $timezone = $logged_in_user_meta[timezone][0];
    $billing_email = $logged_in_user_meta['billing_email'][0];
    global $product;
    $product_meta = get_post_meta($product->id);
    $from_date = array_values(maybe_unserialize($product_meta[from_date]));
    $from_time = array_values(maybe_unserialize($product_meta[from_time]));
    $session_topic = array_values(maybe_unserialize($product_meta[session_topic]));
    $currency_rate = get_current_exchange_rates();
    $currency = get_user_meta(get_current_user_id(),'currency');
    $video_url = array_values(maybe_unserialize($product_meta[video_url][0]));
    $waiting_list = array_values(maybe_unserialize($product_meta[_waiting_list][0]));
    $no_of_students = $product_meta[total_sales][0];
    $downloadable_files = array_values(maybe_unserialize($product_meta[downloadable_files][0]));
    ?>
    <section class="clearfix woocommerce">
    <div class="loader"></div>
    <div class="course-detail clearfix ">
    <div class="col-md-8 course-info">
    <?php echo "<h3 class='clearfix'><strong class='col-md-12 col-xs-12'>".$product->post->post_title."</strong></h3>"; 
    if($product_meta[tutoring_type][0] == "Course"){
    echo "<p class='clearfix'><strong class='col-md-3'>Course Description: </strong>";
    echo "<span class='col-md-9 col-xs-12'>".$product->post->post_content."</span></p>";  
    }
    echo '<p class="col-md-12 availability-content"><span class=""><strong>No. of Students Attending: </strong>'.$no_of_students.'</span>';
    echo '<span class=""><strong>No of Spaces/ Seats Available: </strong>'.$product->get_stock_quantity().'</span></p>';  
    echo '<div class="col-md-12 col-xs-12 session-info"><ul class="col-md-12 session-list">';
    foreach ($from_date as $key => $value) {
        $format = "Y-m-d H:i";
        $datetime_obj = DateTime::createFromFormat($format, $value." ".$from_time[$key],new DateTimeZone('UTC'));
        echo '<li>';
        if(is_user_logged_in()){
            $datetime_obj->setTimezone(new DateTimeZone($timezone)); 
            $day = $datetime_obj->format('l');
            $date = $datetime_obj->format('d/M/Y');
            $time = $datetime_obj->format('h:i A T');
        }else{
            $day = $datetime_obj->format('l');
            $date = $datetime_obj->format('d/M/Y');
            $time = $datetime_obj->format('h:i A T');
        }
        echo "<h5>Session ".($key+1)."</h5><p class='single-session'>";
        echo "<span><strong>Day: </strong>".$day."</span><span><strong>Date: </strong>".$date."</span><span><strong>Time: </strong>".$time."</span><span><strong>Topic: </strong>".$session_topic[$key]."</span></p></li>";
    }
    echo "</ul></div>";?>
    </div> 
    <div class="col-md-4 price-box text-right">
        <?php 
        
        echo "<h3><span><strong>Price:</strong>".wc_price($product->price)."</span></h3><p>";
        echo isset($currency_rate) ? ' (approx '.floatval($product->price * $currency_rate).' '.$currency[0].' )' : '';
//        woocommerce condition based add to cart button
            if( wc_customer_bought_product( $billing_email, $logged_in_user_id, $product->id ) ){
                echo '<p style="color:red;">Product already purchased!</p>';
            }else{
                woocommerce_simple_add_to_cart();
            }
            
        if(is_user_logged_in() && ($product->get_stock_quantity() == 0)){
            if (array_search($billing_email, $waiting_list)) {
               echo '<button type="button" class="btn btn-primary btn-sm" id="btn_waitlist" name="btn_waitlist" value="0" onclick="add_to_waitlist('.$product->id.','.$logged_in_user_id.')"><span class="glyphicon glyphicon-menu-ok"></span>Leave Wait List</button>';
            }else{
            echo '<button type="button" class="btn btn-primary btn-sm" id="btn_waitlist" name="btn_waitlist" value="1" onclick="add_to_waitlist('.$product->id.','.$logged_in_user_id.')"><span class="glyphicon glyphicon-menu-ok"></span>Add To Wait List</button>';
            }
        }
        echo '</p>';
        ?>
    </div> 
      
    <?php
    if($product_meta[tutoring_type][0] == "Course"){
    echo "<div class='col-md-4 course-video-box'>";
    if($video_url[0]){
    echo "<h3>Course Intro Video</h3>";
    echo do_shortcode('[videojs_video url="'.$video_url[0].'" webm="'.$video_url[0].'" ogv="'.$video_url[0].'" width="580"]');
    }
     if(!empty($downloadable_files)){
     echo "<div class='clearfix'><h4>Download Course Materials</h4>";
     foreach ($downloadable_files as $value) {
         echo "<a href='".$value."' target='_blank' class='doc-file'><span class='glyphicon glyphicon-file'></span></a>";
     }
     echo '</div>';
     }
     echo '</div>';
    }else{
       
    }?>
    </div> 
<?php }

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product_summary', 'display_tutor_details', 11 );
function display_tutor_details(){
    global $product;
    $current_user_meta = get_user_meta($product->post->post_author);
    $post_title = $product->post->post_title;
    $product_meta = get_post_meta($product->id);
    $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
    $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
    $currency_rate = get_current_exchange_rates();
    $currency = get_user_meta(get_current_user_id(),'currency');
    ?>
<div class="session-tutor-detail clearfix">
                    <div class="col-md-8 col-xs-12 tutor-detail">
                        <input type="hidden" id="product_id" value="<?php echo $product->id;?>"/>
                    	<h3><?php echo $product_meta[tutoring_type][0] == "Course"? "This course is being taught by":"This session is being taught by";?></h3>
                    	<div class="col-md-2 col-xs-2">
                            <a href=""><?php echo get_avatar( $product->post->post_author, 96);?></a>
                        </div>
                        <div class="col-md-10 col-xs-10">
                        <h4 class="col-md-12">
                            <a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($product->post->post_author);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></a></h4>
                        <p class="single-session">
                        <span class="col-md-12 col-xs-12"><strong>Qualification of Tutor: </strong><?php 
                                echo implode(", ", $tutor_qualification);
                        ?></span>
                        <span class="col-md-12 col-xs-12"><strong>Subjects: </strong><?php
                                $subjects = maybe_unserialize($product_meta[subject][0]);
                                if(is_array($subjects)){
                                    echo implode(", ", $subjects);
                                }else{
                                    echo $subjects;
                                }
                        ?></span>
                            <span class="col-md-12 col-xs-12"><strong>Hourly Rate: </strong><?php echo wc_price($current_user_meta[hourly_rate][0]);echo isset($currency_rate) ? ' (approx '.floatval($current_user_meta[hourly_rate][0] * $currency_rate).' '.$currency[0].')' : '';?></span>
                        <span class="col-md-12 col-xs-12"><input type="button" onclick="location.href = '<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($product->post->post_author);?>'" id="btn_1on1" value="1on1 Availability"></span>
                        </p>
                    </div>
                    
<!--                    <div class="col-md-5 col-xs-12 tutor-intro-video">
                    </div>for tutor video-->
                        
                <?php // $target_file = $current_user_meta[tutor_video_url][0]; 
//                echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="580"]');?>
            </div>
            <?php 
             if($product_meta[tutoring_type][0] == "Course"){
                get_related_tutor_list();
             }?>
        </div>
</section>
<!--        </div>container ends here
    </div>wrapper ends here-->
<?php
}


add_action( 'wp_ajax_get_related_tutor_list', 'get_related_tutor_list' );
add_action( 'wp_ajax_nopriv_get_related_tutor_list', 'get_related_tutor_list' );
function get_related_tutor_list(){
    $paged = ($_POST['paged']) ? $_POST['paged'] : 1;
    global $product;
    if(empty($product)){
    $product_id = $_POST['product_id'];
    $_pf = new WC_Product_Factory();
    $product = $_pf->get_product($product_id);
    }
    $current_user_meta = get_user_meta($product->post->post_author);
    $post_title = $product->post->post_title;
    $product_meta = get_post_meta($product_id);
    if(is_array($product_meta[from_date][0])){
    $from_date = array_values(maybe_unserialize($product_meta[from_date][0]));
    $date = str_replace('/', '-', $from_date[0]);
    $from_date = date('Y-m-d', strtotime($date));
    $to_date = date('Y-m-d', strtotime($from_date." +2 month"));}    
    $currency_rate = get_current_exchange_rates();
    $currency = get_user_meta(get_current_user_id(),'currency');
     ?>
        <div class="col-md-4 col-xs-12">
                <h3><?php _e('Related Tutors');?></h3>
                <?php 
                $args = array(
                'post_type' => 'product',
                'title'=> $post_title,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                        array(
                                'key'     => 'wpcf-course-status',
                                'value'   => 'Approved',
                        ),
                        array(
                                'key'     => 'tutoring_type',
                                'value'   => 'Course',
                        ),

                ),
                'post__not_in' => array($product->id),
                'author__not_in'=>array($product->post->post_author),
                'date_query' => array(
                    array(
                            'after'     => $from_date,
                            'before'    => $to_date,
                            'inclusive' => true,
                    ),),
                'orderby' => 'from_date',
                'order'   => 'ASC',
                'posts_per_page' => 2, 'paged' => $paged);
        add_filter( 'posts_groupby', 'my_posts_groupby' );
        $the_query = new WP_Query( $args );
//        echo $the_query->request;
        // The Loop
        if ( $the_query->have_posts() ) {
                echo '<ul class="related-tutors">';
                while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $product_meta = get_post_meta($the_query->post->ID);
                        global $product;
                        $current_user_meta = get_user_meta($the_query->post->post_author);
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
                        $count = count($from_date);
                        ?>
                        <li class="col-xs-12 col-sm-6 col-md-12">
                            <div class="col-md-3 col-xs-3">
                                <a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($the_query->post->post_author);?>"><?php echo get_avatar( $the_query->post->post_author, 96);?></a>
                            </div>
                            <div class="col-md-9 col-xs-9">
                                <h4><a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($the_query->post->post_author);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></a></h4>
                                <p class="single-session">
                                    <span class="clearfix"><strong>Qualification of Tutor: </strong><?php 
                                            echo implode(", ", $tutor_qualification);
                                        ?></span>
                                    <span class="clearfix"><strong>Spaces Left: </strong><?php echo $product->get_stock_quantity();?></span>
                                    <span class="clearfix"><strong>No. of Sessions: </strong><?php echo $count;?></span>
                                    <span class="clearfix"><strong>Hourly Rate: </strong><?php echo wc_price($current_user_meta[hourly_rate][0]);echo isset($currency_rate) ? ' (approx '.floatval($current_user_meta[hourly_rate][0] * $currency_rate).' '.$currency[0].')' : '';?></span>
                                    <!--<span class="col-md-12"> <button class="btn-primary"> Waiting List</button> <button class="btn-default col-md-offset-1"> Sign Up</button></span>-->
                                </p>
                            </div>
                        </li>
                        <?php 
                }
                echo '</ul>';
                /* Restore original Post Data */
                if (function_exists("pagination")) {
                    pagination($the_query->max_num_pages,4,$paged,'get_display_tutor_details');
                }
        } else {
                echo "No Related Tutors Found";
        }?>
        </div>      
<?php  
}

// determine if customer has bought product if so display message
//add_action( 'woocommerce_before_single_product', 'condition_based_add_to_cart_button', 11 );
//function condition_based_add_to_cart_button(){
//    // if product is already in global space
//    global $product;
//    // or fetch product attributes by ID
//    if( empty( $product->id ) ){
//            $wc_pf = new WC_Product_Factory();
//            $product = $wc_pf->get_product($id);
//    }
//    
//    $current_user = wp_get_current_user();
//    if( wc_customer_bought_product( $current_user->email, $current_user->ID, $product->id ) ){
//            remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
//            add_action( 'woocommerce_single_product_summary', 'display_product_purchased', 11 );
//    }
//}

//function display_product_purchased(){
//    echo '<p style="color:red;">Product already purchased!</p>';
//}

function my_posts_groupby($groupby) {
    global $wpdb;
//    echo $groupby;
    $groupby = "{$wpdb->posts}.post_author";
    return $groupby;
}
function course_groupby($groupby) {
    global $wpdb;
//    echo $groupby;
    $groupby = "{$wpdb->posts}.post_title";
    return $groupby;
}


//Add Free product Data
function add_freeproduct(){   
    //check if product already in cart
        if( is_user_logged_in()){
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
            $user_role = $current_user->roles[0];
        if ( $user_role == 'student' && WC()->cart->get_cart_contents_count() == 0 && $current_user_meta['free_session'][0]) {
                foreach ($_POST as $key => $value) {
                    update_post_meta($_POST['product_id'], $key , $value);
                }
                WC()->cart->add_to_cart( $_POST['product_id'] ,1,'','',$_POST);
                wc_add_notice( sprintf( __( "Free Session has been added to your cart. <a href='".get_site_url()."/cart/'>View Cart</a>") ) ,'success' );
            }
            else{
                wc_add_notice( sprintf( __( "Only one Free Session is allowed in cart") ) ,'error' );
            }
        }
        echo 1;          
    die;
}
add_action( 'wp_ajax_add_freeproduct', 'add_freeproduct' );
add_action( 'wp_ajax_nopriv_add_freeproduct', 'add_freeproduct' );

//Dyanamic Order Item meta for Free Product
add_action( 'woocommerce_after_order_itemmeta', 'add_order_item_meta' );
add_action( 'woocommerce_after_order_itemmeta', 'add_order_item_meta' );
function add_order_item_meta(){
    global $post;
    $order = wc_get_order( $post->ID );
    $items = $order->get_items(); 
    foreach ( $items as $item ) {
    $item_id = $item['product_id']; // <= Here is your product ID
    $data = get_post_meta( $item_id);
    if($item_id == 1129){
//    $product_data = unserialize($item[_ld_woo_product_data]);
        $data = get_post_meta( $item_id); 
        echo 'Tutor Name: '.$data['name_of_tutor'][0]."<br/>";
        echo 'Session Date: '.$data['session_date'][0]."<br/>";
        echo 'Session Time: '.$data['session_time'][0]."<br/>";
    }
    }
}

//On Date select Get all time slots available for tutor.
add_action( 'wp_ajax_get_time_by_sessiondate', 'get_time_by_sessiondate' );
add_action( 'wp_ajax_nopriv_get_time_by_sessiondate', 'get_time_by_sessiondate' );
function  get_time_by_sessiondate(){
    $session_date = $_POST['session_date'];
    if($session_date){
        $date = str_replace('/', '-', $session_date);
        $session_date = date('Y-m-d', strtotime($date));
        $date_query = array(
			'key'     => 'from_date',
			'value'   => $session_date,
			'type'    => 'DATE',
			'compare' => '=',
		);
    }
    
    $args = array(
        'post_type' => 'product',
        'author' => $user_id,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
                array(
			'key'     => 'tutoring_type',
			'value'   => '1on1',
		),
                $date_query,
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );?>
    <p class="field-para">
        Session Time:
 <?php if ( $the_query->have_posts() ) : 
        while ( $the_query->have_posts() ) : $the_query->the_post();
         $product_meta = get_post_meta($the_query->post->ID);
         global $product;
         echo '<input type="radio" name="session_time" value="'.$product_meta[from_time][0].'">'.$product_meta[from_time][0].'<br>';
         endwhile; ?>
        <?php wp_reset_postdata(); 
        else :?>
        <p><?php _e( 'Sorry, no Time Available for Selected Date.' ); ?></p>
        <?php endif;?>
        </p>
   <?php die;
}

//Update free session user meta after order Complete
add_action( 'woocommerce_payment_complete', 'highq_woocommerce_payment_complete', 10, 1 );
function highq_woocommerce_payment_complete( $order_id ) {
    $order = new WC_Order( $order_id );
    $user_id = (int)$order->user_id;
    $items = $order->get_items();
    foreach ($items as $item) {
        if ($item['product_id']==1129) {
          update_user_meta( $user_id, 'free_session', 0);
          error_log("value of free_session for $user_id is 0");
        }
            
    }
    return $order_id;
}

//Validation for session Date & Time while adding Course
add_action( 'wp_ajax_check_user_sessiontimedate', 'check_user_sessiontimedate' );
add_action( 'wp_ajax_nopriv_check_user_sessiontimedate', 'check_user_sessiontimedate' );
function check_user_sessiontimedate(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
//    print_r($_POST);
    $session_dates = array_values(array_filter($session_dates));
    $session_times = array_values(array_filter($session_times));
    $otherTZ  = new DateTimeZone('UTC');
    $timezone = get_current_user_timezone();
    foreach ($session_dates as $key => $value) {
        $format = "d/m/Y H:i";
        $datetime_obj = DateTime::createFromFormat($format, $value." ".$session_times[$key],new DateTimeZone($timezone));
        $datetime_obj->setTimezone(new DateTimeZone('UTC'));
        $session_dates[$key] = $datetime_obj->format('Y-m-d');
        $dates[$key] =  $datetime_obj->format('Y-m-d H:i');
    }  
        $bool =1;
        $datetimearr = $dates;

        if(count(array_unique($datetimearr)) == count($dates)){
        foreach ($datetimearr as $key => $value) {
            $from_time = strtotime($value);
            $to_time = strtotime("+1 hour",$from_time);
//            echo $value;
            foreach ($dates as $date) {
                $date = strtotime($date);
                if($date>$from_time && $date<$to_time){
                    $bool = 0;
                }
                }
        }}else{
            $bool = 0;
        }
        
        if($_POST['edit_mode'] == 1){
              $post_notin_arr = array($_POST['product_id']);
        }
        
//        echo "unique=>".$bool;
        $date_query = array(
                                'key'     => 'from_date',
                                'value'   => $session_dates,
                                'compare'   => 'IN',
                                'type'      => 'DATE'
                        );

        $args = array(
        'post_type' => 'product',
        'author' => $user_id,
        'post__not_in' => $post_notin_arr,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
//                array(
//			'key'     => 'tutoring_type',
//			'value'   => $tutoring_type,
//		),
                $date_query,
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );
//echo $the_query->request;
$boolarr = array();
$format = 'Y-m-d H:i';
    if ( $the_query->have_posts()) : 
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $from_date = get_post_meta($the_query->post->ID,'from_date');
            $from_time = get_post_meta($the_query->post->ID,'from_time');
            foreach ($session_dates as $key => $value) {
                if(in_array($value, $from_date)){
                    foreach ($from_date as $key1 => $value1) {
                    $date = DateTime::createFromFormat($format, $value." ".$session_times[$key],new DateTimeZone($timezone));
                    $date->setTimezone($otherTZ);
                    $checked_date = strtotime($date->format($format));
                    
                    $datetime_obj1 = DateTime::createFromFormat($format, $from_date[$key1]." ".$from_time[$key1],$otherTZ);
                    $datetime1 = strtotime($datetime_obj1->format($format));
                    $datetime2 = strtotime("+1 hour",$datetime1);
                    if($checked_date >=$datetime1 && $checked_date < $datetime2){
                        $boolarr[]=0;
                    }  else {
                        $boolarr[]=1;
                    }}
                }
            }
        endwhile;

        if(in_array(0,$boolarr) ){
            $return=0;
        }else{
            $return=1;
        }
    else :
        $return=1;
    endif;
    
    if($return && $bool)
        echo 1; 
    else
        echo 0;
    
    die;
}

//Remove product from cart for perticular user if already purchased
add_action('woocommerce_before_cart', 'after_login_wp', 10, 2);
function after_login_wp( $user_login='' , $user ='') {
    // your code
    global $woocommerce;
    if ( is_user_logged_in() ) { 
    // get user attributes
    $current_user = wp_get_current_user();
    //Get Cart Data
    $items = WC()->cart->get_cart();
    foreach($items as $item => $values) { 
            $_product = $values['data']->post; 
            // or fetch product attributes by ID
            if($current_user->roles[0] == 'tutor'){
                if(!empty( $_product->ID ) ){;
                    wc_add_notice( sprintf( __( "Tutor cannot purchase course/session") ) ,'error' );
                    remove_product_from_cart($_product->ID);
                    wp_redirect(get_site_url()."/cart/"); exit;
                }
            }
            elseif ($current_user->roles[0] == 'student') {
            if(!empty( $_product->ID ) ){
                $wc_pf = new WC_Product_Factory();
                $product = $wc_pf->get_product($_product->ID);
                $term = wp_get_post_terms($_product->ID, 'product_cat');
                 // determine if customer has bought product
//                var_dump(wc_customer_bought_product( $current_user->email, $current_user->ID, $product->id ));
                if( wc_customer_bought_product( $current_user->email, $current_user->ID, $product->id ) && ($term[0]->slug != 'credit')){
                        wc_add_notice( sprintf( __( "You have already purchased ".$product->post->post_title." .") ) ,'error' );
                        remove_product_from_cart($product->id);
                        wp_redirect(get_site_url()."/cart/"); exit;
                }
            }
            }
    }
    }
}

/**
 * Removes a specific product from the cart
 * @param $product_id Product ID to be removed from the cart
 */
function remove_product_from_cart( $product_id ) {
    global $woocommerce;
     $prod_unique_id = WC()->cart->generate_cart_id( $product_id );
     $bool = WC()->cart->remove_cart_item($prod_unique_id);
     return $bool;
}

//Related Courses on Tutor public profile page
add_action( 'wp_ajax_get_refined_relatedtutors', 'get_refined_relatedtutors' );
add_action( 'wp_ajax_nopriv_get_refined_relatedtutors', 'get_refined_relatedtutors' );
function get_refined_relatedtutors(){
    $format = "Y-m-d";
    $todays_date = date($format);
    $paged = $_POST['paged'];
    $user_id = $_POST['user_id'];
        $args1 = array(
                'post_type' => 'product',
                'author' => $user_id,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                        array(
                                'key'     => 'wpcf-course-status',
                                'value'   => 'Approved',
                        ),
                        array(
                                'key'     => 'tutoring_type',
                                'value'   => 'Course',
                        ),
                        array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
//                                'value'   => '2017-03-03',
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        )
                ),
                'orderby' => 'from_date',
                'order'   => 'ASC',
                'posts_per_page' => posts_per_page,
                'paged' => $paged,'orderby' => 'from_date','order'   => 'DESC'
        );
        $loop = new WP_Query( $args1 );
//        echo $loop->request;
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $course_video = maybe_unserialize($product_meta[video_url][0]);
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $timezone = get_current_user_timezone();
        $datetime_obj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        global $product;
        $_product = wc_get_product( $loop->post->ID );
        ?>
            <li class="col-md-4 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a>
                 <span class="pull-right">
                <?php foreach ($course_video as $key => $value) {
                        if(!empty($value)){
                            echo '<a class="glyphicon glyphicon-facetime-video" data-toggle="modal" data-target="#'.$loop->post->ID.'tutorvideoModal"></a>';
                            echo '<div class="modal fade" id="'.$loop->post->ID.'tutorvideoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Tutor Video
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="pauseCurrentVideo('.$loop->post->ID.')">
                                    <span aria-hidden="true">&times;</span>
                                  </button></h5>
                                </div>
                                <div class="modal-body clearfix">';
                                echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="580"]');
                                echo '</div>
                              </div>
                            </div>
                          </div>';
                        }
                }
                ?>
                </span></h3>
                <span><strong><?php echo $product_meta[curriculum][0]." | ".$product_meta[subject][0]." | ".$product_meta[grade][0];?></strong></span><br/>
                <span> <strong>No of Classes/hours:</strong><?php echo $no_of_classes;?></span><br/>
                <span><strong>Start Date & Time:</strong><span class="highlight"> <?php if(is_user_logged_in()){
                            $otherTZ  = new DateTimeZone($timezone);
                            $datetime_obj->setTimezone($otherTZ); 
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;
                        }else{
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;  
                            echo '<small class="clearfix">(Login to check session Date & Time in your Timezone)</small>';
                            }?></span></span><br>
                        
                        <span> <strong>Price:</strong> <span class="price"><?php echo wc_price($_product->get_price());echo isset($currency_rate) ? ' (approx '.floatval($product->get_price() * $currency_rate).' '.$currency[0].')' : '';?></span></span>
                <span class="col-md-offset-3"> <strong>Seats Available: </strong><?php echo $product->get_stock_quantity();?></span>
                <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
            </li>
        
        <?php
         endwhile; 
         if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_related_courses');
            }
         endif;
         die;
}

//Hook to set user timezone after Login
function set_user_timezone($user_login, $user) {
         $user_id = $user->ID;
         $current_user_meta = get_user_meta($user_id);
//         define("zip_code", $current_user_meta[billing_postcode][0]);
        $wallet_balance = get_user_meta($user_id,'_uw_balance',true);
        $mails = WC()->mailer()->get_emails();
        if($user->roles[0] == 'student' && $wallet_balance <= 25){
            // send an email to user for wallet Top Up
            $wallet_page_url = get_site_url().'/my-account/my-wallet/';
            $args = array(
                'heading'=>'Wallet Top-up Reminder',
                'subject'=>'Wallet Top-up Reminder',
                'template_html'=>'emails/wallet-topup-reminder.php',
                'recipient'=> $user_login);

            $params = (object)array(
                'student_name'=> $user->display_name,
                'my_wallet_page'=> $wallet_page_url
            );
            $mails['WP_Dynamic_Email']->set_args($args);
            $mails['WP_Dynamic_Email']->trigger($params);
                            
            wc_add_notice('<p>Please <a href="'.$wallet_page_url.'" class="search-btn" target="_blank">top-up</a> your Wallet. Your current wallet balance is'.wc_price($wallet_balance).'</p>','notice');
        }
        if($user->roles[0] == 'tutor'){
            $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
            $is_approved = $current_user_meta['is_approved'][0];
            $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
            $id = $post->ID;
            $post_meta = get_post_custom($id);
            $upload_documents_list = explode('|',$post_meta[upload_documents_list][0]);
            $remaining_docs_list = array_diff($upload_documents_list, $tutor_qualification);
            //Email to Tutor if documentation uploaded is not complete($uploaded_docs_count != $tutor_qualification_count)
            if(!$is_approved && !empty($remaining_docs_list)){
                $args = array(
                    'heading'=>'Upload Your Documents',
                    'subject'=>'Upload Your Documents',
                    'template_html'=>'emails/tutor-upload-remaining-documents.php',
                    'recipient'=> $user_login);
                $params = (object)array(
                    'tutor_name'=> $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0],
                    'tutor_edit_link'=> SITE_URL."/tutor-account-edit/",
                    'remaining_docs_list'=>array_values($remaining_docs_list),
                );
                $mails['WP_Dynamic_Email']->set_args($args);
                $mails['WP_Dynamic_Email']->trigger($params);
                $remianing_docs = implode(', ', $remaining_docs_list);
                wc_add_notice('<p>The following documents are pending upload from your end: <b>'.$remianing_docs.'</b>.</p>','notice');
                wc_add_notice('<p>After admin approval you will be able to add courses and 1on1 Tutoring sessions.</p>','notice');
            }
        }
         
}
add_action('wp_login', 'set_user_timezone', 10, 2);

//Get all availability dates for tutor
add_action( 'wp_ajax_get_availability_dates', 'get_tutor_availability_dates' );
add_action( 'wp_ajax_nopriv_get_availability_dates', 'get_tutor_availability_dates' );
function get_tutor_availability_dates(){
    $todays_date = date('Y-m-d');
    $user_id = $_POST['user_id'];
    $args = array(
        'post_type' => 'product',
        'author' => $user_id,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
                array(
			'key'     => 'tutoring_type',
			'value'   => '1on1',
		),
                array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        ),
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );

$eventDates = array();
$instockarray = array();
if ( $the_query->have_posts() ) :
     while ( $the_query->have_posts() ) : $the_query->the_post();
     $product_meta = get_post_meta($the_query->post->ID);
     global $product;
     if($product_meta['_stock_status'][0] == "instock"){
            $eventDates[]=$product_meta[from_date][0];
     }
     endwhile;
     endif;
     
     if ( $the_query->have_posts() ) :
     while ( $the_query->have_posts() ) : $the_query->the_post();
     $product_meta = get_post_meta($the_query->post->ID);
     global $product;
      if($product_meta['_stock_status'][0] == "outofstock" && !in_array($product_meta[from_date][0], $eventDates)){
            $outofstockDates[]=$product_meta[from_date][0];
      }
     endwhile;
     endif;
     
    $data['result']['eventDates'] = $eventDates;
    $data['result']['outofstockDates'] = $outofstockDates;
    echo json_encode($data);
    die;
}

//Get all sessions by date for tutor
add_action( 'wp_ajax_get_sessions_bydate', 'get_sessions_bydate' );
add_action( 'wp_ajax_nopriv_get_sessions_bydate', 'get_sessions_bydate' );
function get_sessions_bydate(){
    $date = $_POST['date'];
    $user_id = $_POST['user_id'];
    $args = array(
        'post_type' => 'product',
        'author' => $user_id,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
                array(
			'key'     => 'tutoring_type',
			'value'   => '1on1',
		),
                array(
                                'key'     => 'from_date',
                                'value'   => $date,
                                'compare'   => '=',
                                'type'      => 'DATE'
                        ),
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );
//echo $the_query->request;
$eventDates = array();
    echo '<form action="" id="tutor_availabilty" name="tutor_availabilty" method="post">';
if ( $the_query->have_posts() ) :
     while ( $the_query->have_posts() ) : $the_query->the_post();
     $product_meta = get_post_meta($the_query->post->ID);
     $from_date = array_values(maybe_unserialize($product_meta[from_date]));
     $from_time = array_values(maybe_unserialize($product_meta[from_time]));
     $session_topic = array_values(maybe_unserialize($product_meta[session_topic]));
     $stock_arr[] = $product_meta['_stock_status'][0];
     $format = "Y-m-d H:i";
    $dateobj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
    if(is_user_logged_in()){
        //Get Logged in user timezone
        $timezone = get_current_user_timezone();
        $dateobj->setTimezone(new DateTimeZone($timezone)); 
    }
     global $product;
     if($product_meta['_stock_status'][0] == "instock"){
     ?> <input type="checkbox" name="tutor_session[]" value="<?php echo $the_query->post->ID;?>"> <?php echo $dateobj->format('l')." ".$dateobj->format('d/M/Y')." ".$dateobj->format('h:i A T')." - ".$session_topic[0];?><br>
     <?php }else{ 
         echo $dateobj->format('l')." ".$dateobj->format('d/M/Y')." ".$dateobj->format('h:i A T')." - ".$session_topic[0]."<br>";
     } 
     endwhile;
     endif;
      echo '<input type="hidden" name="tutor-session-nonce" id="tutor-session-nonce" value="'.wp_create_nonce('tutor-session-nonce').'"/>';
      if(in_array('instock', $stock_arr)){
      echo '<input type="submit" id="add_session_to_cart" name="add_session_to_cart" value="Book Sessions"  class="btn btn-primary btn-sm"/>';}
      echo '</form>';
    die;
}

function session_history_table($user_id){
    ?>
     <div class="box-one history clearfix">
            <div class="box-heading">
                            <h4><?php _e('My Upcoming Sessions'); ?></h4>
                          </div>
                        <?php $order_status = wc_get_order_statuses();?>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <form id="tbl_sessionhistory" name="tbl_sessionhistory" action="" method="post">
                                    <span class="error" style="display:none;" id="dateerror">Please select From Date & To Date</span>
                                <div class="col-md-12 date-time upcoming-sessions">
                                
                                    <p class="field-para">
                                    	<strong>From</strong>
                                        <input id="session_from_date" class="form-control" name="session_from_date" type="text" onchange="" placeholder="Session From Date">
                                     </p>   
                                      <p class="field-para">  
                                        <strong>To</strong>
                                        <input id="session_to_date" class="form-control" name="session_to_date" type="text" onchange="" placeholder="Session To Date">
                                        <input type="hidden" value="<?php echo $user_id;?>" id="user_id" name="user_id">
                                    </p>
                                     <span class="mar-top-bottom-10 submit-history">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="get_session_details()">
                                            <span class="glyphicon glyphicon-menu-ok"></span>
                                            Submit</button>
                                    </span>
                                 </div>
                                </form>
                                <br/>
                                <div class="col-md-8" id="div_total_amt">
                                       
                                </div>
                               
          <div class="col-md-12 table-content table-responsive">
              <table class="table table-bordered" id="tbl_upcoming_sessions">
          <thead>
            <tr>
              <th>Session Date & Time</th>
              <th>Name Of Course</th>
              <th>Students Attending</th>
              <th>Total no of Sessions</th>
              <th>Sessions Completed</th>
              <th>Status/Action</th>
            </tr>
          </thead>
          <tbody id="session_history_table">
            
          </tbody>
        </table>
          </div>
            </div>
        </div>
  </div>
<?php }


//Get Session table History for tutor
add_action( 'wp_ajax_get_session_table_history', 'get_session_table_history' );
add_action( 'wp_ajax_nopriv_get_session_table_history', 'get_session_table_history' );
function get_session_table_history(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
        $objDateTime = new DateTime('NOW');
        $todays_date = $objDateTime->format('Y-m-d');
        $datetime_obj1 = DateTime::createFromFormat('d-m-Y', $session_from_date, new DateTimeZone('UTC'));
        $datetime_obj2 = DateTime::createFromFormat('d-m-Y', $session_to_date, new DateTimeZone('UTC'));
        $session_from_date = $datetime_obj1->format('Y-m-d');
        $session_to_date = $datetime_obj2->format('Y-m-d');
        $timezone = get_current_user_timezone();
        $user_id = get_current_user_id();
        $roomid = get_user_meta(get_current_user_id(),'roomid');
        $roomlink = get_roomlink_by_roomid($roomid);
        $args = array(
            'post_type' => 'product',
            'author' => $user_id,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                    array(
                            'key'     => 'wpcf-course-status',
                            'value'   => 'Approved',
                    ),
                    array(
                            'key'     => 'from_date',
                            'value'   => $todays_date,
                            'compare'   => '>=',
                            'type'      => 'DATE'
                            ),
                    array(
                            'key'     => 'from_date',
                            'value'   => array($session_from_date,$session_to_date),
                            'compare'   => 'BETWEEN',
                            'type'      => 'DATE'
                            )
            ),
            'orderby' => 'from_date',
            'order'   => 'ASC',
            'posts_per_page' => -1,
    );
    
    
$the_query = new WP_Query( $args );
//echo $the_query->request;
    if ( $the_query->have_posts() ) :
     while ( $the_query->have_posts() ) : $the_query->the_post();
     $product_meta = get_post_meta($the_query->post->ID);
     $total_no_of_sessions = count($product_meta[from_date]);
     $from_date = $product_meta[from_date];
     $from_time = $product_meta[from_time];

     $attended_sessions = 0;
     $live_sessions = [];
     global $product;
     
            $product_id[] = $the_query->post->ID;
            $name_of_course[] = $the_query->post->post_title;
            $name_of_tutor[] = $product_meta[name_of_tutor][0];
            $total_no_of_sessions_arr[$the_query->post->ID] = $total_no_of_sessions;
            foreach ( $from_date as $key => $value) {
                $datetime_obj3 = DateTime::createFromFormat('Y-m-d H:i', $value." ".$from_time[$key], new DateTimeZone('UTC'));
                $objDateTime1 = DateTime::createFromFormat('Y-m-d H:i', $value." ".$from_time[$key], new DateTimeZone('UTC'));
                $objDateTime1->modify( '+1 hour' );
                $date1 = strtotime($datetime_obj3->format('Y-m-d H:i'));
                $date2 = strtotime($objDateTime->format('Y-m-d H:i'));
                $date3 = strtotime($objDateTime1->format('Y-m-d H:i'));
//                echo $datetime_obj3->format('Y-m-d H:i')." and ".$objDateTime->format('Y-m-d H:i')." and ".$objDateTime1->format('Y-m-d H:i')."\n";               
//                var_dump($date1 < $date2 && $date2 < $date3);
                if($date1 < $date2){
                    if($date1 < $date2 && $date2 < $date3){
                        $live_sessions[$key] = 1;
                    }else{
                        $attended_sessions = $attended_sessions + 1;
                    }
                }else{
                    $live_sessions[$key] = $date1;
                }
                $datetime_obj3->setTimezone(new DateTimeZone($timezone));
                $from_date_arr[$the_query->post->ID][] = $datetime_obj3->format('d/M/Y H:i A');
            }
            $attended_sessions_arr[$the_query->post->ID] = $attended_sessions;
            $live_sessions_arr[$the_query->post->ID] = $live_sessions;
            $product_price[$the_query->post->ID] = $product_meta[_price][0];
    endwhile;
    endif; 
//    print_r($live_sessions_arr);
    
    global $wpdb;
    $order_statuses = array_map( 'esc_sql', (array) get_option( 'wpcl_order_status_select', array('wc-completed') ) );
    $order_statuses_string = "'" . implode( "', '", $order_statuses ) . "'";
    
    foreach ($live_sessions_arr as $key1 => $value1) {
                $item_sales = $wpdb->get_results( $wpdb->prepare(
				"SELECT o.ID as order_id, oi.order_item_id FROM
				{$wpdb->prefix}woocommerce_order_itemmeta oim
				INNER JOIN {$wpdb->prefix}woocommerce_order_items oi
				ON oim.order_item_id = oi.order_item_id
				INNER JOIN $wpdb->posts o
				ON oi.order_id = o.ID
				WHERE oim.meta_key = %s
				AND oim.meta_value IN ( $key1 )
				AND o.post_status IN ( $order_statuses_string )
				ORDER BY o.ID DESC",
				'_product_id'
			));
//                    echo $wpdb->last_query;
//                                print_r($item_sales);
                    if(!empty($item_sales)){
                        foreach( $item_sales as $sale ) {
                            $order = wc_get_order( $sale->order_id );
                            $students_attending[$key1] .= $order->billing_first_name." ".$order->billing_last_name."\n";
                        }
                    
                    $strtotimedate = min($value1);
                    $date = new DateTime();
                    $currentdate = new DateTime();
                    $currentdate->format('Y-m-d H:i');
                    $date->setTimestamp($strtotimedate);
                    $date->format('Y-m-d H:i');
                    $interval = $currentdate->diff($date);
//                    print_r($value1);
                    if(in_array(1, $value1)){
                        $live_session_txt[$key1] = '<a target="_blank" href="'.$roomlink.'" class="btn btn-primary btn-sm" >Class is Live Now</a>';
                    }else{
                    if($total_no_of_sessions_arr[$key1] != $attended_sessions_arr[$key1]){
                        $txt = "Next Session in:".$interval->format('%R');
                        if($interval->y){
                           $txt .= $interval->format('%y years ');
                        }if($interval->m){
                            $txt .= $interval->format('%m months ');
                        }if($interval->days){
                            $txt .= $interval->format('%a days ');
                        }
                        $txt .= $interval->format('%H:%I:%S');
                        if($interval->days > 2 && $attended_sessions_arr[$key1] == 0){
                            $live_session_txt[$key1] = "<a id='".$key1."_cancel_session' class='btn btn-primary btn-sm' onclick='refund_using_tutor_wallet(".$sale->order_id.",".$product_price[$key1].",".$key1.")'>Cancel Session</a>";
                        }
                            $live_session_txt[$key1] .= "<a class='btn btn-primary btn-sm'>".$txt."</a>";  
                        
                    }else{
                        $live_session_txt[$key1] = '<a class="btn btn-primary btn-sm">Completed</a>';
                    }}
                    }else{
                        $students_attending[$key1] = '';
                        $live_session_txt[$key1] = "<a href='#course_types' onclick='edit_session_data($key1)' class='btn btn-primary btn-sm'>Edit</a>"; 
                    }
    }
    
    $data['result'] = array('product_id'=>$product_id,
                  'from_date'=>$from_date_arr,
                  'name_of_course'=>$name_of_course,
                  'students_attending'=>$students_attending,
                  'total_no_of_sessions'=>$total_no_of_sessions_arr,
                  'attended_sessions'=>$attended_sessions_arr,
                  'session_status'=>$live_session_txt,
                  );
    echo json_encode($data);
    die;
}

//Get Session table History for student
add_action( 'wp_ajax_get_studentsession_table_history', 'get_studentsession_table_history' );
add_action( 'wp_ajax_nopriv_get_studentsession_table_history', 'get_studentsession_table_history' );
function get_studentsession_table_history(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
        $objDateTime = new DateTime('NOW');
//        $objDateTime = DateTime::createFromFormat('Y-m-d H:i','2017-04-12 11:30',new DateTimeZone('UTC'));
        $datetime_obj1 = DateTime::createFromFormat('d-m-Y', $session_from_date, new DateTimeZone('UTC'));
        $datetime_obj2 = DateTime::createFromFormat('d-m-Y', $session_to_date, new DateTimeZone('UTC'));
        $session_from_datetime = $datetime_obj1->format('Y-m-d H:i');
        $session_to_datetime = $datetime_obj2->format('Y-m-d H:i');
        $order_status = 'wc-completed';
        $timezone = get_current_user_timezone();

        $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => $order_status
    ) );
    
    foreach ($customer_orders as $orders) {
        $order = wc_get_order($orders->ID);
        $items = $order->get_items();
        $status = wc_get_order_status_name($order->post->post_status);
        if(in_array($status, wc_get_order_statuses()))
        {
        foreach ($items as $item) {
            $args = array(
                    'post_type'  => 'product',
                    'post_status' => 'publish',
                    'p' => $item[product_id],
                    'meta_query' => array(
                        array(
                                        'key'     => 'from_date',
                                        'value'   => array($datetime_obj1->format('Y-m-d'),$datetime_obj2->format('Y-m-d')),
                                        'compare'   => 'BETWEEN',
                                        'type'      => 'DATE'
                        )
                    ),
            );
            $query = new WP_Query( $args );
//            echo $query->request;
            $product_data = $query->posts;
            
            if(!empty($product_data)){
            $product_meta = get_post_meta($product_data[0]->ID);  
            $tutor_meta = get_userdata( $product_data[0]->post_author );
            
            //Get Room Link
            $id_of_tutor = $product_meta[id_of_tutor][0];
            $roomid = get_user_meta($id_of_tutor,'roomid');
            $roomlink = get_roomlink_by_roomid($room_id);
            
            $total_no_of_sessions = count($product_meta[from_date]);
            $from_date = $product_meta[from_date];
            $from_time = $product_meta[from_time];
            $attended_sessions = 0;
            $live_sessions = [];
            foreach ( $from_date as $key => $value) {
                $datetime_obj3 = DateTime::createFromFormat('Y-m-d H:i', $value." ".$from_time[$key], new DateTimeZone('UTC'));
                $objDateTime1 = DateTime::createFromFormat('Y-m-d H:i', $value." ".$from_time[$key], new DateTimeZone('UTC'));
                $objDateTime1->modify( '+1 hour' );
                $date1 = strtotime($datetime_obj3->format('Y-m-d H:i'));
                $date2 = strtotime($objDateTime->format('Y-m-d H:i'));
                $date3 = strtotime($objDateTime1->format('Y-m-d H:i'));
//                echo $datetime_obj3->format('Y-m-d H:i')." and ".$objDateTime->format('Y-m-d H:i')." and ".$objDateTime1->format('Y-m-d H:i');               
//                        var_dump($date1 < $date2 && $date2 < $date3);
                if($date1 < $date2){
                    if($date1 < $date2 && $date2 < $date3){
                        $live_sessions[$key] = 1;
                    }else{
                        $attended_sessions = $attended_sessions + 1;
                    }
                }else{
                    $live_sessions[$key] = $date1;
                }
                $datetime_obj3->setTimezone(new DateTimeZone($timezone));
                $from_date_arr[$item[product_id]][] = $datetime_obj3->format('d/M/Y H:i A');
            }
//            echo $item[product_id]."\n";  
            $product_id[] = $item[product_id];
            $order_id[$item[product_id]] = $orders->ID; 
            $product_price[$item[product_id]] = $product_meta[_price][0];
            $name_of_course[] = $item[name];
            $name_of_tutor[] = $tutor_meta->display_name;
            $total_no_of_sessions_arr[$item[product_id]] = $total_no_of_sessions;
            $attended_sessions_arr[$item[product_id]] = $attended_sessions;
            $live_sessions_arr[$item[product_id]] = $live_sessions;
            }
        }
        }
    }
    
    foreach ($live_sessions_arr as $key1 => $value1) {
         if(!empty($value1)){
                if(in_array(1, $value1)){
                    $live_session_txt[$key1] = '<a target="_blank" href="'.$roomlink.'" class="btn btn-primary btn-sm" >Class is Live Now</a>';
                }else{
                    if ($attended_sessions_arr[$key1] != $total_no_of_sessions_arr[$key1]) {
                    $strtotimedate = min($value1);
                    $date = new DateTime();
                    $currentdate = new DateTime();
                    $currentdate->format('Y-m-d H:i');
                    $date->setTimestamp($strtotimedate);
                    $date->format('Y-m-d H:i');
                    $interval = $currentdate->diff($date);
                    $txt = "Next Session in:".$interval->format('%R');
                        
                    if($interval->y){
                       $txt .= $interval->format('%y years ');
                    }if($interval->m){
                        $txt .= $interval->format('%m months ');
                    }if($interval->days){
                        $txt .= $interval->format('%a days ');
                    }
                    $txt .= $interval->format('%H:%I:%S');
                    $live_session_txt[$key1] = "<a class='btn btn-primary btn-sm'>".$txt."</a>";
                    if($interval->days >= 2 && $attended_sessions_arr[$key1] == 0){
                    $live_session_txt[$key1] .= "<a id='".$key1."_cancel_session' class='btn btn-primary btn-sm' onclick='refund_using_wallet(".$order_id[$key1].",".$product_price[$key1].",".$key1.")'>Cancel Session</a>";
                    }
                }
            }
            }
            else{
                if ($attended_sessions_arr[$key1] == $total_no_of_sessions_arr[$key1]) {
                    $live_session_txt[$key1] = '<a class="btn btn-primary btn-sm" >Completed</a>';
                }
            }
    }
    
    $data['result'] = array('product_id'=>$product_id,
                  'from_date'=>$from_date_arr,
                  'name_of_course'=>$name_of_course,
                  'name_of_tutor'=>$name_of_tutor,
                  'total_no_of_sessions'=>$total_no_of_sessions_arr,
                  'attended_sessions'=>$attended_sessions_arr,
                  'session_status'=>$live_session_txt,
                  );
        
    echo json_encode($data);
    die;
}

//Change in stock text to custom
add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2); 
function custom_get_availability( $availability, $_product ) {
    //change text "In Stock' to 'SPECIAL ORDER'
    $stock = $_product->stock;
    if ( $_product->is_in_stock() ) $availability['availability'] = $stock.__(' Seats Available', 'woocommerce');
  
    //change text "Out of Stock' to 'SOLD OUT'
    if ( !$_product->is_in_stock() ) $availability['availability'] = __('No Seats Available', 'woocommerce');
        return $availability;
    }

//Get Current Session Timezone
function get_current_user_timezone(){
    if ( is_user_logged_in() ) {
    //Get Logged in user timezone
    $logged_in_user_id = get_current_user_id();
    $logged_in_user_meta = get_user_meta($logged_in_user_id);
    $timezone = $logged_in_user_meta[timezone][0];
    return $timezone;
 }
}

//Get Product Date by id
add_action( 'wp_ajax_get_product_data', 'get_product_data' );
add_action( 'wp_ajax_nopriv_get_product_data', 'get_product_data' );
function get_product_data(){
    $_pf = new WC_Product_Factory();
    $product_id = $_POST['product_id'];
    $product_meta = get_post_meta($product_id);
    $_product = $_pf->get_product($product_id);
    $timezone = get_current_user_timezone();
//    print_r($_product);
    $session_from_date=[];
    $session_from_time = [];
    $from_date = $product_meta[from_date];
    $from_time = $product_meta[from_time];
    foreach ($from_date as $key => $value) {
        $datetime_obj = DateTime::createFromFormat('Y-m-d H:i', $from_date[$key]." ".$from_time[$key],new DateTimeZone('UTC'));
        $datetime_obj->setTimezone(new DateTimeZone($timezone));
        $session_from_date[] = $datetime_obj->format('Y-m-d');
        $session_from_time[] = $datetime_obj->format('H:i');
    }

    $video_url = array_values(maybe_unserialize($product_meta[video_url][0]));
    $downloadable_files = array_values(maybe_unserialize($product_meta[downloadable_files][0]));
    $terms = get_the_terms( $product_id, 'product_cat' );
    foreach ($terms as $term) {
        $product_cat_slug = $term->slug;
        break;
    }
    if($video_url[0])

    $video_html = do_shortcode('[videojs_video url="'.$video_url[0].'" webm="'.$video_url[0].'" ogv="'.$video_url[0].'" width="480"]');
        
    $product_meta['video_html'] = $video_html;
    $product_meta['downloadable_files'] = $downloadable_files;
    $product_meta['from_date'] = $session_from_date;
    $product_meta['from_time'] = $session_from_time;
    $product_meta['video_url'] = $video_url[0];
    $product_meta['product_cat_slug'] = $product_cat_slug;
    $data['result'] = $product_meta;
        
    echo json_encode($data);
    
    die;
}

//Make virtual product order as complete
add_filter( 'woocommerce_payment_complete_order_status', 'virtual_order_payment_complete_order_status', 10, 2 );
 
function virtual_order_payment_complete_order_status( $order_status, $order_id ) {
  $order = new WC_Order( $order_id );
//  error_log(print_r($order),true);
// if ( 'processing' == $order_status && ( 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) ) {
 if ( 'processing' == $order_status ) {
    $virtual_order = null;
    if ( count( $order->get_items() ) > 0 ) {
      foreach( $order->get_items() as $item ) {
        if ( 'line_item' == $item['type'] ) {
          $_product = $order->get_product_from_item( $item );
          if ( ! $_product->is_virtual() ) {
            // once we've found one non-virtual product we know we're done, break out of the loop
            $virtual_order = false;
            break;
          } else {
            $virtual_order = true;
          }
        }
      }
    }
    // virtual order, mark as completed
    if ( $virtual_order ) {
      return 'completed';
    }
  }
  // non-virtual order, return original status
  return $order_status;
}

//Add User to product Wishlist
add_action( 'wp_ajax_add_user_to_productwaitlist', 'add_user_to_productwaitlist' );
add_action( 'wp_ajax_nopriv_add_user_to_productwaitlist', 'add_user_to_productwaitlist' );
function add_user_to_productwaitlist(){
    $current_user = wp_get_current_user();
    $product_id = $_POST[product_id];
    $user_id = $_POST[user_id];
    $val_btn_waitlist = $_POST[val_btn_waitlist];
    $arr_wait_list = get_post_meta($product_id, "_waiting_list");
    $arr_wait_listed = maybe_unserialize(array_values(array_filter($arr_wait_list[0])));
    
    if($val_btn_waitlist == 1){
        if(empty($arr_wait_listed)){
            $arr_wait_listed[] = $current_user->user_email;
            update_post_meta($product_id, '_waiting_list', $arr_wait_listed); 
        }else{
            if (($key = array_search($current_user->user_email, $arr_wait_listed)) === false) {
            $arr_wait_listed[] = $current_user->user_email;
            update_post_meta($product_id, '_waiting_list', $arr_wait_listed);
            }
        }
    }elseif ($val_btn_waitlist == 0) {
        if (($key = array_search($current_user->user_email, $arr_wait_listed)) !== false) {
            unset($arr_wait_listed[$key]);
            $arr_wait_listed = array_values(array_filter($arr_wait_listed));
            update_post_meta($product_id, '_waiting_list', $arr_wait_listed);
        }
    }
    die;
}

add_action( 'wp_ajax_change_cancelorder_status_request', 'change_cancelorder_status_request' );
add_action( 'wp_ajax_nopriv_change_cancelorder_status_request', 'change_cancelorder_status_request' );
function change_cancelorder_status_request(){
    $order_id = $_POST['order_id'];
    $order = new WC_Order($order_id);
    if (!empty($order)) {
        $order->update_status('cancel-request');
    }
    die;
}

function highq_woocommerce_order_status_completed( $order_id ) {
    $order = new WC_Order( $order_id );
//    print_r($order);die;
    foreach( $order->get_items() as $item ) {
        $product_meta = get_post_meta($item[product_id],'_waiting_list');
        $arr_wait_listed = $product_meta[0];
        if (($key = array_search($order->billing_email, $arr_wait_listed)) !== false) {
            //unset($arr_wait_listed[$key]);
            $arr_wait_listed = array_values(array_filter($arr_wait_listed));
            update_post_meta($item[product_id], '_waiting_list', $arr_wait_listed);
        }
      }
}
add_action( 'woocommerce_order_status_completed', 'highq_woocommerce_order_status_completed', 10, 1 );

function get_roomlink_by_roomid($room_id){
    $args = array(
                            'post_type'  => 'room',
                            'meta_key'   => '_room_id',
                            'meta_value' => $roomid[0],
                            'post_status' => 'publish'
                        );
                        $query = new WP_Query( $args );
                        $roomlink = $query->post->guid;
                        return $roomlink;
}

remove_action('wpua_before_avatar', 'wpua_do_before_avatar');
remove_action('wpua_after_avatar', 'wpua_do_after_avatar');
function my_before_avatar() {
  echo '<div id="my-avatar">';
  echo "Update Your Avatar<br/>";
}
add_action('wpua_before_avatar', 'my_before_avatar');

function my_after_avatar() {
  echo '</div>';
}

// Hook in
//add_filter( 'woocommerce_checkout_fields' , 'set_input_attrs' );
//// Our hooked in function - $fields is passed via the filter!
//function set_input_attrs( $fields ) {
//       $fields['billing']['billing_state']['label'] = 'State';
//
//       return $fields;
// }
 add_filter( 'woocommerce_default_address_fields' , 'set_input_attrs' );
function set_input_attrs( $address_fields ) {
    $address_fields['state']['label'] = 'State';
    $address_fields['city']['required'] = false;
     return $address_fields;
}
  
function woocommerce_return_to_shop() {
	return get_site_url()."/courses/academic-courses/";
}
add_filter( 'woocommerce_return_to_shop_redirect', 'woocommerce_return_to_shop' );

function print_reset_password(){
    $login=$_GET['login'];
    $key= $_GET['key'];
    $user =check_password_reset_key($key, $login);
    $errors=$user->errors;
    global $wpdb;
    do_action( 'woocommerce_set_cart_cookies',  true );
    if(empty($errors)){
      $user_id = $user->data->ID;
      if(isset($_POST['btn_restpass'])){
        if(isset($_POST['confirm_pass']) && $_POST['confirm_pass']!=""){
            wp_set_password( $_POST['confirm_pass'], $user_id );
            $user_info = get_userdata($user_id);

            $mails = WC()->mailer()->get_emails();
            $args = array(
                'heading'=>'Your Password Has Been Changed',
                'subject'=>'Password change Activity',
                'template_html'=>'emails/password-changed.php',
                'recipient'=> $user_info->user_login);
            $params = (object)array(
                'username'=> $user_info->user_login,
                'password'=> $_POST['confirm_pass']
            );

            $mails['WP_Dynamic_Email']->set_args($args);
            $mails['WP_Dynamic_Email']->trigger($params);
                        
            wc_add_notice("Your password has been changed successfully",'success' );
            wp_redirect(get_site_url()."/my-account/"); exit;
        }}
    }else{
        foreach ($errors as $key => $value) {
            wc_add_notice($value[0] ,'error' );
            wp_redirect(get_site_url()."/my-account/"); exit;
        }
    }
        echo "<form id='frm_reset_pass' name='frm_reset_pass' action='' method='post' class='woocommerce-ResetPassword lost_reset_password'>";
        echo "<h2>Enter a new password below.</h2>";
        echo "<p class='woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first'>";
        echo "<label for='user_reset_pass'>New Password<span style='color: red;'>*</span></label> ";
	echo "<p class='field-para'><input type='password' id='new_pass' name='new_pass' class='form-control tooltip-bottom' data-toggle='tooltip' title='Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number'></p>";
        echo "<label for='user_confirm_pass'>Confirm Password<span style='color: red;'>*</span></label> ";
	echo "<p class='field-para'><input type='password' id='confirm_pass' name='confirm_pass' class='form-control tooltip-bottom' data-toggle='tooltip' title='Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number'></p>";
        echo "<div class='clear'></div>";
        echo "<p class='woocommerce-FormRow form-row'>";
        echo "<input type='submit' id='btn_restpass' name='btn_restpass' value='SAVE' class='woocommerce-Button button'></p></form>";
}
add_shortcode('resetpassword', 'print_reset_password');

function wc_remove_password_strength() {
 if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
 wp_dequeue_script( 'wc-password-strength-meter' );
 }
}
add_action( 'wp_print_scripts', 'wc_remove_password_strength', 100 );

function payment_gateway_disable( $available_gateways ) {
global $woocommerce;
    if(isset( $available_gateways['paypal'] ) && !check_cat_in_cart()){
        unset( $available_gateways['paypal'] );
    }else{
        unset( $available_gateways['wpuw'] );
    }
return $available_gateways;
}

add_filter( 'woocommerce_available_payment_gateways', 'payment_gateway_disable' );
function check_cat_in_cart() {
    //Check to see if user has credit product in cart
    global $woocommerce;
    $cat_in_cart = false;
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
        $_product = $values['data'];
        $terms = get_the_terms( $_product->id, 'product_cat' );
        // second level loop search, in case some items have several categories
        foreach ($terms as $term) {
            $_category = $term->slug;
            if (( $_category === 'credit' )) {
                //category is in cart!
                $cat_in_cart = true;
                
            }
        }        
    }
    return $cat_in_cart;
}

function condition_for_wallet_deposit_button(){
    //Check to see if user has product in cart
    global $woocommerce;
    $credit_count = 0;
    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
        $_product = $values['data'];
        $terms = get_the_terms( $_product->id, 'product_cat' );
        // second level loop search, in case some items have several categories
        foreach ($terms as $term) {
            $_category = $term->slug;
            if (( $_category === 'credit' )) {
                //category is in cart!
                $credit_count += 1;
            }
        }        
    }
    return ($woocommerce->cart->cart_contents_count - $credit_count);
}


//function tutor_carousel_list($attr){
//    $args = array(
//        'role' => 'tutor',
//        'meta_query' => array(
//                        'key'     => 'wpcf-course-status',
//                        'value'   => 'Approved',
//                ),
//        'orderby' => 'ID',
//        'order' => 'ASc',
//        'offset' => $attr['lino'],
//        'number' => 1,
//      );
//       $users = get_users($args);
//       
//        echo '<div class="carousel"><ul class="list-unstyled">';
//        foreach ($users as $user) {
//            echo '<li class="">';
//            echo '<a target="_blank" href="'.get_site_url().'/tutors/tutor-public-profile/?'.  base64_encode($user->id).'">'.get_wp_user_avatar( $user->id, 'medium').'</a>';
//            echo '<p><a target="_blank" href="'.get_site_url().'/tutors/tutor-public-profile/?'.  base64_encode($user->id).'" class="tutor-name">'.$user->display_name.'</a><br/>';
//            echo '</p></li>';
//        }
//        echo '</ul></div>';
//}
//add_shortcode('tutor_carousel', 'tutor_carousel_list');

//Cancel Student Session using wallet
add_action( 'wp_ajax_change_user_wallet', 'change_user_wallet' );
add_action( 'wp_ajax_nopriv_change_user_wallet', 'change_user_wallet' );
function change_user_wallet(){
    global $woocommerce;
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
     $order = wc_get_order($order_id);
     $items = $order->get_items();
     $remaining_products = [];
     $address = array(
            'first_name' => $order->billing_first_name,
            'last_name'  => $order->billing_last_name,
            'company'    => '',
            'email'      => $order->billing_email,
            'phone'      => $order->billing_phone,
            'address_1'  => $order->billing_address_1,
            'address_2'  => $order->billing_address_2, 
            'city'       => $order->billing_city,
            'state'      => $order->billing_state,
            'postcode'   => $order->billing_postcode,
            'country'    => $order->billing_country
        );
     $customer_id = $order->customer_id;
     foreach ($items as $item) {
        if($item['product_id'] == $product_id){
        $product = wc_get_product( $product_id );
        $tutors_id = $product->post->post_author;
        $tutor_balance = floatval(get_user_meta($tutors_id,'_uw_balance', true));
        $tutor_updated_balance = $tutor_balance - $product->price;
        update_user_meta($tutors_id, '_uw_balance', $tutor_updated_balance);
        $current_user_balance = floatval(get_user_meta($user,'_uw_balance', true));
        $credit_amount = floatval($credit_amount);
        $new_balance = $current_user_balance+$credit_amount;
        /** update student wallet */
        update_user_meta($user, '_uw_balance', $new_balance);
        
        $product_meta = get_post_meta($product_id);
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $datetime_obj = DateTime::createFromFormat('Y-m-d H:i', $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        $datetime_obj->setTimezone(new DateTimeZone(get_user_meta($user,'timezone',true)));
        //Send mail to student after session cancel
        $mails = WC()->mailer()->get_emails();
            $args = array(
                'heading'=>'Your Session Has Been Cancelled',
                'subject'=>'Session Cancelled',
                'template_html'=>'emails/student-cancel-session.php',
                'recipient'=> $order->billing_email);
            
            $params = (object)array(
                'student_name'=> $order->billing_first_name." ".$order->billing_last_name,
                'session_datetime'=> $datetime_obj->format('d/M/Y H:i:s A T'),
                'tutor_name'=>  get_user_meta($tutors_id,'first_name',true).' '.get_user_meta($tutors_id,'last_name',true),
                'tutor_public_profile'=> get_site_url().'/tutors/tutor-public-profile/?'. base64_encode($tutors_id),
            );
            $mails['WP_Dynamic_Email']->set_args($args);
            $mails['WP_Dynamic_Email']->trigger($params);
            
        }else{
            $remaining_products[] = $item['product_id'];
        } 
    }
    
    if (!empty($order)) {
        $order->update_status('refunded');
    }
    
    if(!empty($remaining_products)){
    $args = array('customer_id'=>$customer_id);
    $order_new = wc_create_order($args);
    $order_new->set_address( $address, 'billing' );
        foreach ($remaining_products as $key => $value) {
            $order_new->add_product( get_product($value), 1 );
            wc_update_product_stock( $value, 1, 'decrease' );
        }
        $order_new->set_payment_method('wpuw');
        update_post_meta($order_new, '_payment_method_title', 'User Wallet');
        $order_new->calculate_totals();
        $order_new->update_status("completed");
        $order_new->save();
    }
    echo 1;
    die;
}

//Cancel Tutor Session using Wallet
add_action( 'wp_ajax_change_user_tutor_wallet', 'change_user_tutor_wallet' );
add_action( 'wp_ajax_nopriv_change_user_tutor_wallet', 'change_user_tutor_wallet' );
function change_user_tutor_wallet(){
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
    }
    global $wpdb;
    $credit_amount = floatval($credit_amount);
    $order_statuses = array_map( 'esc_sql', (array) get_option( 'wpcl_order_status_select', array('wc-completed') ) );
    $order_statuses_string = "'" . implode( "', '", $order_statuses ) . "'";
    $item_sales = $wpdb->get_results( $wpdb->prepare(
				"SELECT o.ID as order_id, oi.order_item_id FROM
				{$wpdb->prefix}woocommerce_order_itemmeta oim
				INNER JOIN {$wpdb->prefix}woocommerce_order_items oi
				ON oim.order_item_id = oi.order_item_id
				INNER JOIN $wpdb->posts o
				ON oi.order_id = o.ID
				WHERE oim.meta_key = %s
				AND oim.meta_value IN ( $product_id )
				AND o.post_status IN ( $order_statuses_string )
				ORDER BY o.ID DESC",
				'_product_id'
			));
        if(!empty($item_sales)){
                foreach( $item_sales as $sale ) {
                    $order = wc_get_order( $sale->order_id );
                    $items = $order->get_items();
                    $remaining_products = [];
                    $address = array(
                            'first_name' => $order->billing_first_name,
                            'last_name'  => $order->billing_last_name,
                            'company'    => '',
                            'email'      => $order->billing_email,
                            'phone'      => $order->billing_phone,
                            'address_1'  => $order->billing_address_1,
                            'address_2'  => $order->billing_address_2, 
                            'city'       => $order->billing_city,
                            'state'      => $order->billing_state,
                            'postcode'   => $order->billing_postcode,
                            'country'    => $order->billing_country
                        );
                    $customer_id = $order->customer_id;
                    foreach ($items as $item) {
                        if($item['product_id'] == $product_id){
                            $current_user_balance = floatval(get_user_meta($user,'_uw_balance', true));
                            $student_balance = floatval(get_user_meta($customer_id,'_uw_balance', true));
                            $tutor_updated_balance = $current_user_balance-$credit_amount;
                            $student_updated_balance = $student_balance+$credit_amount;
//                            echo 'tutor_updated_balance'.$tutor_updated_balance.' & student_updated_balance '.$student_updated_balance;
                            update_user_meta($user, '_uw_balance', $tutor_updated_balance);
                            update_user_meta($customer_id, '_uw_balance', $student_updated_balance);
                        }else{
                            $remaining_products[] = $item['product_id'];
                        } 
                    }
                    if (!empty($order)) {
                        $order->update_status('refunded');
                    }
//                    print_r($remaining_products);
                    if(!empty($remaining_products)){
                        $args = array('customer_id'=>$customer_id);
                        $order_new = wc_create_order($args);
                        $order_new->set_address( $address, 'billing' );
                        foreach ($remaining_products as $key => $value) {
                            $order_new->add_product( get_product($value), 1 );
                            wc_update_product_stock( $value, 1, 'decrease' );
                        }
                        $order_new->set_payment_method('wpuw');
                        update_post_meta($order_new, '_payment_method_title', 'User Wallet');
                        $order_new->calculate_totals();
                        $order_new->update_status("completed");  
                        $order_new->save();
                    }
                }
        }
    
    echo 1;
    die;
}

add_action( 'wp_ajax_check_user_email_exists', 'check_user_email_exists' );
add_action( 'wp_ajax_nopriv_check_user_email_exists', 'check_user_email_exists' );
function check_user_email_exists(){
    $email_id = $_POST['email_id'];
    if(email_exists($email_id)){
        echo TRUE;
    }else{
        echo FALSE;
    }
    die;
}

// Add users table header columns
add_filter( 'manage_users_columns', 'get_users_wallet_columns' );
function get_users_wallet_columns( $defaults ) {
    $defaults['wallet-balance'] = __( 'Wallet Balance', 'gtp_translate' );
    return $defaults;
}

// Add users table lead purchase column content
add_action( 'manage_users_custom_column', 'show_users_wallet_columns', 10, 3 );
function show_users_wallet_columns( $value, $column_name, $user_id ) {
    $user_meta = get_user_meta( $user_id );
    switch( $column_name ) {
        case 'wallet-balance' : 
            return $user_meta[_uw_balance][0] ? $user_meta[_uw_balance][0] : 0;
            break;
    }
}

add_action( 'woocommerce_order_status_completed_to_refunded', 'wc_cancel_restore_order_stock', 10, 1 );
function wc_cancel_restore_order_stock( $order_id ) {

        $order = wc_get_order( $order_id );
        if ( ! get_option('woocommerce_manage_stock') == 'yes' && ! sizeof( $order->get_items() ) > 0 ) {
            return;
        }
        foreach ( $order->get_items() as $item ) {
            if ( $item['product_id'] > 0 ) {
                $_product = $order->get_product_from_item( $item );

                if ( $_product && $_product->exists() && $_product->managing_stock() ) {
                    $old_stock = $_product->stock;
                    //Punam Code Added for Send Wait List Mails
                    $arr_waiting_list = get_post_meta($_product->id,'_waiting_list');
                    $arr_waiting_list = $arr_waiting_list[0];
                    if($old_stock >= 0 &&  !empty($arr_waiting_list[$old_stock])){
                        $to = $arr_waiting_list[$old_stock];
                        $user = get_user_by( 'email', $to);
//                        $subject = "".$_product->post->post_title." is Instock Now.";
//                        $message = "Hello,<br/><br/>";
//                        $message.= "<strong>".$_product->post->post_title."</strong> you had requested has seats available now. <br/><br/>Please click on below link to book your seats:<br/><br/>";
//                        $message.= "<a href='".$_product->post->guid."'>".$_product->post->guid."</a>";
//                        $message.= "<br/><br/>Thanks,<br/>Team HighQ";
//                        $headers = array('Content-Type: text/html; charset=UTF-8');
//                        wp_mail( $to, $subject, $message, $headers );
                        $mails = WC()->mailer()->get_emails();
                            $args = array(
                                'heading'=>"".$_product->post->post_title." is Instock Now.",
                                'subject'=>"".$_product->post->post_title." is Instock Now.",
                                'template_html'=>'emails/waiting-list-notification.php',
                                'recipient'=> $to);

                            $params = (object)array(
                                'user_name'=> $user->display_name,
                                'course_name'=> $_product->post->post_title,
                                'course_detail_page'=> $_product->post->guid
                            );
                            $mails['WP_Dynamic_Email']->set_args($args);
                            $mails['WP_Dynamic_Email']->trigger($params);
                    }
                    
                    $qty = apply_filters( 'woocommerce_order_item_quantity', $item['qty'], $this, $item );
                    $new_quantity = $_product->increase_stock( $qty );
                    $order->add_order_note( sprintf( __( 'Item #%s stock incremented from %s to %s.', 'wc-cancel-order' ), $item['product_id'], $old_stock, $new_quantity) );
                    $order->send_stock_notifications( $_product, $new_quantity, $item['qty'] );
                }
            }
        }
    }
    
    function get_current_exchange_rates(){
        $uri = ConvertCurrency_API;
        $allowed_currencies = array('SGD','GBP','INR');
        $headers = array(
            'X-PAYPAL-SECURITY-USERID' => 'bhosalepj8_api1.gmail.com',
            'X-PAYPAL-SECURITY-PASSWORD' => 'V2GNN3T7KQFQLBLQ',
            'X-PAYPAL-SECURITY-SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31A9jeGjAkMJzvW9WaPtqz.iqasowI',
            'X-PAYPAL-REQUEST-DATA-FORMAT' =>'JSON',
            'X-PAYPAL-RESPONSE-DATA-FORMAT' =>'JSON',
            'X-PAYPAL-APPLICATION-ID'=>  'APP-80W284485P519543T',
        );
        
        $params = array(
            'requestEnvelope'=>array(
                'errorLanguage'=>'en_US'
            ),
            'baseAmountList'=>array(
                'currency'=>array(
                    'code'=>'USD',
                    'amount'=>'100.00',
                )
            ),
            'convertToCurrencyList'=>array(
                'currencyCode'=> $allowed_currencies
            )
        );

        $args = array(
            'body' => json_encode($params),
            'timeout' => '500',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers,
            'cookies' => array()
        );

    $response = wp_remote_post( $uri, $args );
    
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode($body);
    if($data->responseEnvelope->ack = 'Success'){
        $currencyList = $data->estimatedAmountTable->currencyConversionList[0]->currencyList->currency;
        foreach ($currencyList as $key => $value) {
           $rates[$value->code] = floatval($value->amount/100);
        }
    }
    
    if(is_user_logged_in()){
        $currency = get_user_meta(get_current_user_id(),'currency');
        if(array_key_exists($currency[0], $rates))
        {
            $currency_rate = $rates[$currency[0]];
        }else{
            if(in_array($currency[0], $allowed_currencies)) $currency_rate = currencyConverter('USD', $currency[0]);
        }
    }
    return $currency_rate;
}

add_action('woocommerce_checkout_init','disable_billing_shipping');
function disable_billing_shipping($checkout){
$checkout->checkout_fields['shipping']=array();
return $checkout;
}

function currencyConverter($from_Currency,$to_Currency,$amount) {
$from_Currency = urlencode($from_Currency);
$to_Currency = urlencode($to_Currency);
$encode_amount = 100;
$get = file_get_contents("https://www.google.com/finance/converter?a=$encode_amount&from=$from_Currency&to=$to_Currency");
$get = explode("<span class=bld>",$get);
$get = explode("</span>",$get[1]);
$converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);
$converted_currency = floatval($converted_currency / 100);
return $converted_currency;
}

add_action('woocommerce_email_session_details','emails_session_details');
function emails_session_details($order, $sent_to_admin, $plain_text, $email){
   $items = $order->items;
   if($order->payment_method == 'paypal'){
       echo '<table width="800" border="1px" cellpadding="0" cellspacing="0" style="border:0 solid #44545E;padding:0.5em;">
            <tr style="border-right:0">
            	<th style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Amount of Package:</strong></th><td style="padding:0.5em; text-align:center;border-right: 0;">'.$order->get_formatted_order_total().'</td>
            </tr>';
        echo '<tr>
            	<th style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Payment by:</strong></th><td style="padding:0.5em; text-align:center;border-right: 0;">'.$order->payment_method_title.'</td>
            </tr>
        </table>';
   }else{
    $customer_timezone = get_user_meta($order->customer_id,'timezone',true);
    echo '<table width="800" border="1px" cellpadding="0" cellspacing="0" style="border:0 solid #44545E;padding:0.5em;">
        <tr style="border-right:0">
            <td style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Date of Session</strong></td>
            <td style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Time of Session</strong></td>
            <td style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Type of Session</strong></td>
            <td style="padding:0.5em; text-align:center;border-bottom: 0;"><strong>Subject / Course</strong></td>
            <td style="padding:0.5em; text-align:center;border-right: 1px solid #44545E;border-bottom: 0;"><strong>Name of Tutor</strong></td>
        </tr>';
    foreach ($items as $key => $item) {   
        $product = $item->get_product();
        $product_meta = get_post_meta($product->id);
        $from_date = $product_meta[from_date];
        $from_time = $product_meta[from_time];
        $tutoring_type = $product_meta[tutoring_type][0];
        $tutor = get_userdata($product->post->post_author);
        $datetime_obj =  DateTime::createFromFormat('Y-m-d H:i',$from_date[0]." ".$from_time[0]);
        $datetime_obj->setTimezone(new DateTimeZone($customer_timezone));
        $tutoring_type == '1on1'? '1 on 1 Tutoring' : 'Course';
        echo '<tr>';
        echo '<td style="padding:0.5em; text-align:center;border-right: 0;">'.$datetime_obj->format('d/M/Y').'</td>';
        echo '<td style="padding:0.5em; text-align:center;border-right: 0;">'.$datetime_obj->format('H:i A T').'</td>';
        echo '<td style="padding:0.5em; text-align:center;border-right: 0;">'.$tutoring_type.'</td>';
        echo '<td style="padding:0.5em; text-align:center;border-right: 0;">'.$product_meta[subject][0].'</td>';
        echo '<td style="padding:0.5em; text-align:center;">'.$tutor->display_name.'</td>';
        echo "</tr>";
    }
    echo "</table>";
   }
}

add_filter('woocommerce_email_subject_customer_completed_order', 'change_admin_email_subject', 1, 2);
add_filter('woocommerce_email_heading_customer_completed_order', 'change_admin_email_heading', 1, 2);
add_filter('woocommerce_email_subject_customer_refunded_order', 'change_admin_email_subject', 1, 2);
add_filter('woocommerce_email_heading_customer_refunded_order', 'change_admin_email_heading', 1, 2);
add_filter('woocommerce_email_subject_customer_processing_order', 'change_admin_email_subject', 1, 2);
add_filter('woocommerce_email_heading_customer_processing_order', 'change_admin_email_heading', 1, 2);
add_filter('woocommerce_email_subject_customer_on-hold_order', 'change_admin_email_subject', 1, 2);
add_filter('woocommerce_email_heading_customer_on-hold_order', 'change_admin_email_heading', 1, 2);
function change_admin_email_subject( $subject, $order ) {
    global $woocommerce;
    if ( $order->status == 'completed' && $order->payment_method == 'wpuw' ) {
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $subject = sprintf( 'Your %s session from %s is booked', $blogname, wc_format_datetime($order->get_date_created()) );
    }
    if ( $order->status == 'refunded' && $order->payment_method == 'wpuw' ) {
        $subject = sprintf( 'Your session price has been refunded');
    }
    if ( $order->status == 'processing' && $order->payment_method == 'wpuw' ) {
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $subject = sprintf( 'Your %s session from %s', $blogname, wc_format_datetime($order->get_date_created()) );
    }
    if ( $order->status == 'on-hold' && $order->payment_method == 'wpuw' ) {
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $subject = sprintf( 'Your %s session from %s', $blogname, wc_format_datetime($order->get_date_created()) );
    }
    return $subject;
}

function change_admin_email_heading( $heading, $order ){
    global $woocommerce;
    if ( $order->status == 'completed' && $order->payment_method == 'wpuw' ) {
        $heading = sprintf( 'Your session is booked');
    }
    if ( $order->status == 'refunded' &&  $order->payment_method == 'wpuw' ) {
        $heading = sprintf( 'Your session is refunded');
    }
    if ( $order->status == 'processing' && $order->payment_method == 'wpuw' ) {
        $heading = sprintf( 'Your session is in processing');
    }
    if ( $order->status == 'on-hold' && $order->payment_method == 'wpuw' ) {
        $heading = sprintf( 'Your session booking is on-hold');
    }
    return $heading;
}
function tutor_carousel_list(){      
    $args = array(
        'role' => 'tutor',
        'meta_query' => array(
                        'key'     => 'wpcf-course-status',
                        'value'   => 'Approved',
                ),
        'orderby' => 'ID',
        'order' => 'ASc',
        'offset' => 0,
        'number' => 12,
      );
       $users = get_users($args);
//       echo "<pre>";
//       print_r($users);
        echo '<div class="col-md-12">
                <div id="Carousel" class="carousel slide">
                <ol class="carousel-indicators">
                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel" data-slide-to="1"></li>
                    <li data-target="#Carousel" data-slide-to="2"></li>
                </ol>
                 
                <div class="carousel-inner">';
        $key = 0;
        for($i=0; $i < 3; $i++) {
            $active = ($key == 0) ? 'active' : '';
            echo'<div class="item '.$active.'">
                    <div class="row">';
                    for($j = 0; $j < 4; $j++){
                    echo '<div class="col-md-3"><a target="_blank" href="'.get_site_url().'/tutors/tutor-public-profile/?'.  base64_encode($users[$key]->id).'" class="thumbnail">'.get_wp_user_avatar( $users[$key]->id, 'medium').''.$users[$key]->display_name.'</a></div>';
                    $key++;
                    }
                    echo '</div>
                </div>';
        }
        echo '</div>
                  <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                  <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                </div></div>';    
    ?>
<?php
}
add_shortcode('tutor_carousel', 'tutor_carousel_list');