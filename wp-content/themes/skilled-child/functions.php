<?php
// put custom code here
define("Upload_File_Size", 50);
$site_url= get_site_url();
define("SITE_URL", $site_url);
/**
 * Proper way to enqueue scripts and styles.
 */
function wpdocs_theme_name_scripts() {
// Register the script
    wp_register_script( 'jquery-validation-js', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js' );
    wp_register_script( 'student-validate-js', get_stylesheet_directory_uri() . '/js/studentValidate.js' );
    wp_register_script( 'tutor-validate-js', get_stylesheet_directory_uri() . '/js/tutorValidate.js' );
    wp_register_script( 'ui-datepicker-js', get_stylesheet_directory_uri() . '/js/jquery-ui.js' );
    wp_register_script( 'format-extension-js', get_stylesheet_directory_uri() . '/js/additional-methods.min.js' );
    wp_register_script( 'ui-timepicker-js', get_stylesheet_directory_uri() . '/js/jquery-ui-timepicker-addon.js' );
    
    wp_enqueue_style( 'ui-datepicker-css', get_stylesheet_directory_uri() .'/css/jquery-ui.css');
    wp_enqueue_style( 'responsive-css', get_stylesheet_directory_uri() .'/css/responsive.css');
    wp_enqueue_style( 'ui-timepicker-css', get_stylesheet_directory_uri() .'/css/jquery-ui-timepicker-addon.css');
    wp_enqueue_script( 'jquery-validation-js');
    wp_enqueue_script( 'format-extension-js');
    wp_enqueue_script( 'student-validate-js');
    wp_enqueue_script( 'tutor-validate-js');
    wp_enqueue_script( 'ui-datepicker-js');
     wp_enqueue_script( 'ui-timepicker-js');
    
    
    $translation_array = array( 'siteUrl' => get_site_url() );
    
    wp_localize_script( 'student-validate-js', 'Urls', $translation_array );
    
    wp_localize_script( 'tutor-validate-js', 'Urls', $translation_array );
    
//    echo get_stylesheet_directory_uri();
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

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


add_action( 'wp_ajax_get_selected_cities', 'get_selected_cities' );
add_action( 'wp_ajax_nopriv_get_selected_cities', 'get_selected_cities' );
function get_selected_cities(){
    if (isset($_POST["selected_country_code"]) && isset($_POST["selected_state_code"])) { 
        $selected_country_code = $_POST["selected_country_code"];
        $selected_state_code = $_POST["selected_state_code"];
        $country_no = $_POST["country_no"];
        $selected_cities = $GLOBALS['wc_city_select']->get_cities($selected_country_code);
        foreach ($selected_cities as $key => $value) {
//            echo "key: ".$key." and state code: ".$selected_state_code;
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

add_action( 'wp_ajax_display_upload_files', 'display_upload_files' );
add_action( 'wp_ajax_nopriv_display_upload_files', 'display_upload_files' );
function display_upload_files(){
        //File Upload code
//        $files = $_FILES["documents"]; 
//    echo "<pre>";
    $count = $_POST['count'] ;
//    print_r($_FILES['documents_'.$count]);
        if(isset($_FILES['documents_'.$count])){
        $files = $_FILES['documents_'.$count];
        }
//        else{
//            $files = $_FILES['documents'];
//        }
//    print_r($files);
        foreach ($files['name'] as $key => $value) {            
                if ($files['name'][$key]) { 
                    $file[$x] = array( 
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key], 
                        'tmp_name' => $files['tmp_name'][$key], 
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    ); 
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
            
//            $doc_key = $_POST['count'];
//            foreach ($arr_docs as $value) {
//                echo "<div id='doc_div_".$doc_key."'>";
//                echo "<a href='".$value."' target='_blank' id='link_".$doc_key."'>".$value."</a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc(".$doc_key.")'>X</a><br/>";
//                echo "<input type='hidden' id='old_uploaded_docs' name='old_uploaded_docs[]' value='".$value."'>";
//                echo "</div>";
//                $doc_key ++;
//            };
            $data['result'] = $arr_docs;
            echo json_encode($data);
            exit;
}




add_action( 'wp_ajax_display_selected_video', 'display_selected_video' );
add_action( 'wp_ajax_nopriv_display_selected_video', 'display_selected_video' );
function display_selected_video(){
    $id = $_POST['id'];
//    print_r($_FILES[$id]);die;
//    if(!isset($_FILES['documents2'])){
        $size = $_FILES[$id]['size'];
//    }else{
//        $size = $_FILES['documents2']['size'];
//    }
    $filesize = number_format($size / 1048576, 2);
    if($filesize < Upload_File_Size){
//        if(!isset($_FILES['documents2'])){
            $file = $_FILES[$id];
//        }else{
//            $file = $_FILES['documents2'];
//        }
    
    if(!$file[error]){
               if ( ! function_exists( 'wp_handle_upload' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }

               $upload_overrides = array( 'test_form' => false );
               $movefile = wp_handle_upload( $file, $upload_overrides );
                if ( $movefile && ! isset( $movefile['error'] ) ) {
                    $target_file = $movefile["url"];
                    $type = $movefile["type"];
                } else {
                    /**
                     * Error generated by _wp_handle_upload()
                     */
                    echo $movefile['error'];
                }
    }
    // Prepare an array of post data for the attachment
    $attachment = array(
            'guid'           => $target_file, 
            'post_mime_type' => $type,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $name ),
            'post_content'   => '',
            'post_status'    => 'inherit'
    );
    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $target_file );
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    
    echo "<input type='hidden' name='video_url' name='video_url' value='".$target_file."'>";
    echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="480"]');
    }else{
        echo "<span style='color:red;'>File size exceeds the maximum upload file size</span>";
    }
    die;
}

//To add cities for corresponding country and state
//add_filter( 'wc_city_select_cities', 'my_cities' );
//function my_cities( $cities ) {
//    $cities['IN'] = array(
//        'GJ' => array(
//            'Gandhinagar',
//            'Surat'
//        ),
//        'MH' => array(
//            'Mumbai',
//            'Pune'
//        )
//    );
//    return $cities;
//}


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

//Code for verification

// we need this to handle all the getty hacks i made
function my_init(){
        // check whether we get the activation message
        if(isset($_GET['p'])){
                $data = unserialize(base64_decode($_GET['p']));
                $code = get_user_meta($data['id'], 'activationcode', true);

                // check whether the code given is the same as ours
                if($code == $data['code']){
                        if($data['role'] == 'student'){
                            // update the db on the activation process
                            update_user_meta($data['id'], 'is_activated', 1);
//                            wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'inkfool' )  );
                            wc_add_notice( sprintf( __( "Your account has been activated!", "inkfool" ) ) ,'success' );
                        }
                        if($data['role'] == 'tutor'){
                            wc_add_notice( sprintf( __( "Thanks for confirming your email. You will be able to login to the system once your application is approved by the admin. We will inform you as soon as that happens.", "inkfool" ) ) ,'success' );
                        }
                }else{
                        wc_add_notice( sprintf( __( "Activation fails, please contact our administrator.", "inkfool" ) ) ,'Error' );
                }
        }
        if(isset($_GET['q'])){
                wc_add_notice( sprintf( __( "Your account has to be activated before you can login. Please check your email.", "inkfool" ) ) ,'Error' );
        }
        if(isset($_GET['u'])){
                my_user_register($_GET['u']);
                wc_add_notice( sprintf( __( "Your activation email has been resend. Please check your email.", "inkfool" ) ) ,'success' );
//                wp_redirect(SITE_URL."/my-account/");
        }
//        wp_redirect(SITE_URL."/my-account/");
}
// hooks handler
add_action( 'init', 'my_init' );

// this is just to prevent the user log in automatically after register
function wc_registration_redirect( $redirect_to ) {
        wp_logout();
        wp_redirect( '/my-account/?q=');
        exit;
}

add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');


// when user login, we will check whether this guy email is verify
function myplugin_auth_login( $userdata ) {
        if($userdata->roles[0] == "student"){
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
        
        if($userdata->roles[0] == "tutor"){
            $isActivated = get_user_meta($userdata->ID, 'is_activated',true);
        if ( !$isActivated ) {
                return new WP_Error(
                                'inkfool_confirmation_error',
                                __( 'Your account has to be activated before you can login. Please wait for admin approval.', 'inkfool' )
                                );
        }else{
            return $userdata;
        }
        }
 }

add_filter('wp_authenticate_user', 'myplugin_auth_login',10,2);


function get_user_role() { // returns current user's role
	global $current_user;
	$user_roles = $current_user->roles;
	return $user_role; // return translate_user_role( $user_role );
}

// when a user register we need to send them an email to verify their account
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
        
        if($user_info->roles[0] == 'student' || $user_info->roles[0] == 'tutor'){
        // create the url
        $url = get_site_url(). '/my-account/?p=' .base64_encode( serialize($string));
        // basically we will edit here to make this nicer
        $html = 'Hi,<br/><br/>Please click the following link to verify your email address for HighQ <br/><br/> <a href="'.$url.'">'.$url.'</a><br/> <br/>Thanks,<br/>Team HighQ';
        // send an email out to user
        wc_mail($user_info->user_email, __('Please activate your account'), $html);
        }
}
add_action('user_register', 'my_user_register',10,2);


add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
 
function my_show_extra_profile_fields( $user ) {
    if($user->roles[0] == 'tutor'){
        $options = esc_attr( get_the_author_meta( 'is_activated', $user->ID ) );
        $current_user_meta = get_user_meta($user->ID);
//            print_r($current_user_meta);
            $target_file = $current_user_meta[tutor_video_url][0];
            $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
            $tutor_institute = isset($current_user_meta[tutor_institute][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_institute][0])) : "";
            $tutor_year_passing = isset($current_user_meta[tutor_year_passing][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_year_passing][0])) : "";
            $uploaded_docs = isset($current_user_meta[uploaded_docs][0]) ? array_values(maybe_unserialize($current_user_meta[uploaded_docs][0])):"";
            $language_known = isset($current_user_meta[language_known][0]) ? array_values(maybe_unserialize($current_user_meta[language_known][0])):"";
            $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])):"";
            $tutor_level = isset($current_user_meta[tutor_level][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_level][0])):"";
            $tutor_grade = isset($current_user_meta[tutor_grade][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_grade][0])):"";
    ?>
<h2>Tutor Information</h2>
    <table class="form-table">
        <tr>
            <th><label for="is_activated">User Activation</label></th>
            <td>
                <input id="old_is_activated" name="old_is_activated" value="<?php echo $options;?>" type="hidden">
                <select name="is_activated" id="is_activated">
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
    echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="480"]');?>
            </td>
        </tr>
        <tr>
            <th><label for="tutor_docs">Educational Information</label></th>
                <?php foreach ($tutor_qualification as $key => $value) {
                    echo "<td>";
                    echo $value.": ".$tutor_institute[$key]." - ".$tutor_year_passing[$key];
                    foreach ($uploaded_docs[$key] as $index => $value1) {
                       echo "<a href='".$value1."'>Document</a>";
                    }
                    echo "</td>";
                }?>
        </tr>
        <tr>
            <th><label for="tutor_docs">Language Proficiency</label></th>
                <?php foreach ($language_known as $key => $value) {
                    echo "<td>";
                    echo $value;
                    echo "</td>";
                }?>
        </tr>
        <tr>
            <th><label for="tutor_docs">Subjects Taught</label></th>
                <?php foreach ($subs_can_teach as $key => $value) {
                    echo "<td>";
                    echo $value.": ".$tutor_grade[$key].", ".$tutor_level[$key];
                    echo "</td>";
                }?>
        </tr>
        <tr>
            <th><label for="tutor_docs">About Tutor</label></th>
                <?php $tutor_description = $current_user_meta[tutor_description][0];
                    echo "<td>";
                    echo $tutor_description;
                    echo "</td>";
                ?>
        </tr>
        <tr>
            <th><label for="tutor_docs">Tutor Hourly Rate</label></th>
                <?php $hourly_rate = $current_user_meta[hourly_rate][0];
                    $currency = $current_user_meta[currency][0];
                    echo "<td>";
                    echo $hourly_rate." ".$currency;
                    echo "</td>";
                ?>
        </tr>
    </table>
    <?php
    }
}
    
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
 
function my_save_extra_profile_fields( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
//   
    $is_activated = esc_attr( get_the_author_meta( 'is_activated', $user_id) );
    $user_info = get_userdata($user_id);

        if(isset($_POST['is_activated']) && $_POST['is_activated'] == 1 && $_POST['is_activated'] != $is_activated){
        // create the url
        $url = get_site_url(). '/my-account';
//        // basically we will edit here to make this nicer
        $html = 'Hi,<br/><br/>Your application has been approved by the admin. Please use the below link to login to the system.<br/><br/> <a href="'.$url.'">'.$url.'</a><br/> <br/>Thanks,<br/>Team HighQ';
//        // send an email out to user
        wc_mail($user_info->user_email, __('Account Activation'), $html);
    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
        
        }
        $bool = update_user_meta($user_id , 'is_activated', $_POST['is_activated'] );
}
 

//Custom Tab Account  Page
function my_custom_endpoints() {
    add_rewrite_endpoint( 'my-account-details', EP_ROOT | EP_PAGES );
//    add_rewrite_endpoint( 'my-account-editdetails',  EP_PAGES );
}
add_action( 'init', 'my_custom_endpoints' );


function add_query_vars( $vars ) {
 $vars[] = 'my-account-details';
// $vars[] = 'my-account-editdetails';
 return $vars;
 }
add_filter( 'query_vars', 'add_query_vars' , 0 );


function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'my_custom_flush_rewrite_rules' );

/*
 * Change the order of the endpoints that appear in My Account Page - WooCommerce 2.6
 * The first item in the array is the custom endpoint URL - ie http://mydomain.com/my-account/my-custom-endpoint
 * Alongside it are the names of the list item Menu name that corresponds to the URL, change these to suit
 */
function wpb_woo_my_account_order() {
 $myorder = array(
 'my-account-details' => __( 'My Account', 'woocommerce' ),
// 'my-account-editdetails' => __( 'My Account Edit', 'woocommerce' ),
 'edit-account' => __( 'Change My Details', 'woocommerce' ),
// 'dashboard' => __( 'Dashboard', 'woocommerce' ),
// 'orders' => __( 'Orders', 'woocommerce' ),
// 'downloads' => __( 'Download MP4s', 'woocommerce' ),
// 'edit-address' => __( 'Addresses', 'woocommerce' ),
 'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
 'customer-logout' => __( 'Logout', 'woocommerce' ),
 );
 return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );

function my_custom_endpoint_content() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-account-details.php';
//     include 'wp-content/plugins/student_tutor_registration/templates/my-account-editdetails.php';
}

add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );

//function edit_account_page() {
//     include 'wp-content/plugins/student_tutor_registration/templates/my-account-editdetails.php';
//}
//
//add_action( 'woocommerce_account_my-account-editdetails_endpoint', 'edit_account_page' );
add_action( 'wp_ajax_remove_doc', 'remove_doc' );
add_action( 'wp_ajax_nopriv_remove_doc', 'remove_doc' );

function remove_doc(){
    if (isset($_POST["doc_url"]) && isset($_POST["doc_url"]) != '') { 
//        $bool = unlink($_POST["doc_url"]);
        
        $base = dirname(dirname(dirname(__FILE__)));
        echo $base;
        $bool = unlink("\wp-content\uploads\2017\02\invoice-17876.pdf");
        
        var_dump($bool);
        die;
    }
    die;
}