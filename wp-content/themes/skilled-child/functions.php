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
    $id = $_POST['id'] ;
//    echo $id;
//    print_r($_FILES[$id]);die;
//    print_r($_FILES['documents_'.$count]);
//        if(isset($_FILES['documents_'.$count])){
        $files = $_FILES[$id];
//        }
//        else{
//            $files = $_FILES['documents'];
//        }
//    print_r($files);die;
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
                    if(!empty($uploaded_docs[$key])){
                    foreach ($uploaded_docs[$key] as $index => $value1) {
                       echo "<a href='".$value1."'>Document</a>";
                    }
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
 'edit-account' => __( 'Change My Password', 'woocommerce' ),
// 'dashboard' => __( 'Dashboard', 'woocommerce' ),
// 'orders' => __( 'Orders', 'woocommerce' ),
// 'downloads' => __( 'Download MP4s', 'woocommerce' ),
// 'edit-address' => __( 'Addresses', 'woocommerce' ),
// 'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
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

//Get Order table History
function get_order_table_history(){
    $order_status = $_POST['order_status']!="" ? $_POST['order_status'] : wc_get_order_statuses();

    $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'post_type'   => wc_get_order_types(),
        'post_status' => $order_status,
        'date_query' => array(
            'after' => date('Y-m-d', strtotime($_POST['history_from_date'])),
            'before' => date('Y-m-d', strtotime($_POST['history_to_date'])),
            'inclusive' => true,
        ),
    ) );
    
    foreach ($customer_orders as $key => $value) {
        $order = wc_get_order($value->ID);
        $items = $order->get_items();
        $status = wc_get_order_status_name($order->post->post_status);
        if(in_array($status, wc_get_order_statuses()))
        {
       
        foreach ($items as $key => $value) {
            $order_meta = maybe_unserialize($value[ld_woo_product_data]);
            if(get_current_user_id() == $order_meta[id_of_tutor]){
            $post_status[] = $status;
            $order_date[] = $order->order_date;
            $product_name[] = $value[name];
            $line_total[] = $value[line_total];
            $product_id[] = $value[product_id];
            $order_item_meta[] = $order_meta;
        }}
        }
    }
    
    $data['result'] = array('product_id'=>$product_id,
                  'product_name'=>$product_name,
                  'line_total'=>$line_total,
                  'post_status'=>$post_status,
                  'order_date'=>$order_date,
                  'order_item_meta'=>$order_item_meta);
    echo json_encode($data);
    die;
}

add_action( 'wp_ajax_get_order_table_history', 'get_order_table_history' );
add_action( 'wp_ajax_nopriv_get_order_table_history', 'get_order_table_history' );

function get_studentorder_table_history(){
    $order_status = $_POST['order_status']!="" ? $_POST['order_status'] : wc_get_order_statuses();
//    print_r(wc_get_order_statuses());
    $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
//        'post_status' => $order_status,
        'post_status' => 'wc-completed',
        'date_query' => array(
            'after' => date('Y-m-d', strtotime($_POST['history_from_date'])),
            'before' => date('Y-m-d', strtotime($_POST['history_to_date'])),
            'inclusive' => true,
        ),
    ) );
    
//    print_r($customer_orders);die;
    foreach ($customer_orders as $key => $value) {
        $order = wc_get_order($value->ID);
        $status = wc_get_order_status_name($order->post->post_status);
        if(in_array($status, wc_get_order_statuses()))
        {
        $items = $order->get_items();
//        print_r($items);
        foreach ($items as $key => $value) {
            $post_status[] = $status;
            $order_date[] = $order->order_date;
            $product_name[] = $value[name];
            $line_total[] = $value[line_total];
            $product_id[] = $value[product_id];
            $order_item_meta[] = maybe_unserialize($value[ld_woo_product_data]);
        }
        }
    }

    
    $data['result'] = array('product_id'=>$product_id,
                  'product_name'=>$product_name,
                  'line_total'=>$line_total,
                  'post_status'=>$post_status,
                  'order_date'=>$order_date,
                  'order_item_meta'=>$order_item_meta);
    echo json_encode($data);
    die;
}

add_action( 'wp_ajax_get_studentorder_table_history', 'get_studentorder_table_history' );
add_action( 'wp_ajax_nopriv_get_studentorder_table_history', 'get_studentorder_table_history' );

//Function to Save Product Metadata when add to cart
add_action( 'woocommerce_add_to_cart', 'ld_woo_set_item_data'); 
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
function ld_woo_set_item_data( $cart_item_key, $key, $value ) {
	$data = (array)WC()->session->get( '_ld_woo_product_data' );
        
	if ( empty( $data[$cart_item_key] ) ) {
		$data[$cart_item_key] = array();
	}
        $post_meta_data = get_post_meta($_POST['product_id']);
        foreach ($post_meta_data as $key => $value) {
            $data[$cart_item_key][$key] = $value[0];
        };
//	print_r($curriculum);
	WC()->session->set( '_ld_woo_product_data', $data );
}
function ld_woo_remove_item_data( $cart_item_key = null, $key = null ) {
	$data = (array)WC()->session->get( '_ld_woo_product_data' );
	// If no item is specified, delete *all* item data. This happens when we clear the cart (eg, completed checkout)
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
        return __( 'Book Course', 'woocommerce' );
}

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
function woo_archive_custom_cart_button_text() {
        $pagename = get_query_var('pagename');
        if($pagename == "tutors")
            return __( 'Book Session', 'woocommerce' );
        else
            return __( 'Book Course', 'woocommerce' );
}

// numbered pagination
function pagination($pages = '', $range = 4, $paged = 1, $page_type='')
{  
     $showitems = ($range * 2)+1;  
 
//     global $paged;
//     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     
     if($page_type == 'course'){
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(1)'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".($paged - 1).")'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='javascript:;' class=\"inactive\" onclick='get_next_page_course(".$i.")'>".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".($paged + 1).")'>Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".$pages.")'>Last &raquo;</a>";
         echo "</div>\n";
     }
     }
     if($page_type == 'tutor'){
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(1)'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".($paged - 1).")'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='javascript:;' class=\"inactive\" onclick='get_next_page_course(".$i.")'>".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".($paged + 1).")'>Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='get_next_page_course(".$pages.")'>Last &raquo;</a>";
         echo "</div>\n";
     }
     }
     
}

//Function to filter courses
function get_refined_courses(){
//    print_r($_POST);
    foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
//        echo $$key;
    }
    
  $curriculumarr = array();
  $subjectarr = array();
  $gradearr = array();
  $result_txt = '<h2>Result For: ';
  if($curriculum){
      $curriculumarr = array(
                                'key' => 'curriculum',
                                'value' => $curriculum,
                        );
      $result_txt .= $curriculum." ";
  }
  if($subject){
      $subjectarr =    array(
                                'key' => 'subject',
                                'value' => $subject,
                        );
      $result_txt .= $subject ." ";
  }
  if($grade){
      $gradearr     =   array(
                                'key' => 'grade',
                                'value' => $grade,
                        );
      $result_txt .= $grade;
  }
  if($price){
      $pricearr     =   array(
                                'key' => '_price',
                                'value' => $price,
                                'compare' => '<=',
                                'type'    => 'NUMERIC'
                        );
      $result_txt .= "$".$price;
  }
  if($from_time){
      $result_txt .= $from_time;
  }
  
  $result_txt .= "</h2>";
//  echo $price;
//   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
//  elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
//  else { $paged = 1; }
  
  
  $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $category,'paged' => $paged,
      'meta_query' => array(
          'relation' => 'AND',
          array(
              'key' => 'tutoring_type',
              'value' => $type,
              ),
          array(
                'key'   => 'wpcf-course-status',
                'value' =>'Approved',
              ),
          array(
                        'relation' => 'AND',
                        
                        $curriculumarr,
                        $subjectarr,
                        $gradearr,
                        $pricearr
              ),
          )
        ,'order'=> 'DESC', 'orderby' => 'date');

  
    $loop = new WP_Query( $args );
    echo $result_txt;
//    print_r($loop->request);
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post();
        $product_meta = get_post_meta($loop->post->ID);
        
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        
        $timearr = array_values(array_filter(maybe_unserialize($product_meta[from_time][0])));
        $bool = check_time($timearr,$from_time);
        global $product;
        if($bool){
             echo '<li class="product">';    
             echo '<a href="'.get_permalink( $loop->post->ID ).'" title="'.esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID).'">
                     <h3>'.$product->get_title().'</h3></a>';
             echo '<span> Curriculum: '.$product_meta[curriculum][0].'</span><br/>';
             echo '<span> Subject:';
                $subjects = maybe_unserialize($product_meta[subject][0]);
                if(is_array($subjects)){
                    foreach ($subjects as $key => $value) {
                        echo $value.",";
                    }
                }else{
                    echo $subjects;
                }
                echo '</span><br/>';
                echo '<span> Grade:'.$product_meta[grade][0].'</span><br/>';
                echo '<span> Rating: </span><br/>';
                $_product = wc_get_product( $loop->post->ID );
                echo '<span> Price: <span class="price">'.$_product->get_price().'</span></span><br/>';
                echo '<span> Qualification: ';
                $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
                echo '</span><br/><br/>';
                woocommerce_template_loop_add_to_cart( $post, $product );
                echo '</li><br/>';
             }
            
            endwhile;
             if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'course');
                }
                ?>
            <?php else:
                echo '<p>'._e( 'Sorry, no posts matched your criteria.' ).'</p>';
            endif;
    die;
}
add_action( 'wp_ajax_get_refined_courses', 'get_refined_courses' );
add_action( 'wp_ajax_nopriv_get_refined_courses', 'get_refined_courses' );

function get_refined_tutors(){
//    print_r($_POST);die;
        foreach ($_POST as $key => $value) {
        $$key = (isset($value) && !empty($value)) ? $value : "";
//        echo $$key;
    }
    
  $curriculumarr = array();
  $subjectarr = array();
  $gradearr = array();
  $result_txt = '<h2>Result For: ';
  if($curriculum){
      $curriculumarr = array(
                                'key' => 'curriculum',
                                'value' => $curriculum,
                        );
      $result_txt .= $curriculum." ";
  }
  if($subject){
      $subjectarr =    array(
                                'key' => 'subject',
                                'value' => $subject,
                        );
      $result_txt .= $subject ." ";
  }
  if($grade){
      $gradearr     =   array(
                                'key' => 'grade',
                                'value' => $grade,
                        );
      $result_txt .= $grade;
  }
  if($price){
      $pricearr     =   array(
                                'key' => '_price',
                                'value' => $price,
                                'compare' => '<=',
                                'type'    => 'NUMERIC'
                        );
      $result_txt .= "$".$price;
  }
  if($from_time){
      $result_txt .= $from_time;
  }
  
  $result_txt .= "</h2>";
//  echo $price;
//   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
//  elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
//  else { $paged = 1; }
  
  
  $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $category,'paged' => $paged,
      'meta_query' => array(
          'relation' => 'AND',
          array(
              'key' => 'tutoring_type',
              'value' => $type,
              ),
          array(
                'key'   => 'wpcf-course-status',
                'value' =>'Approved',
              ),
          array(
                        'relation' => 'AND',
                        
                        $curriculumarr,
                        $subjectarr,
                        $gradearr,
                        $pricearr
              ),
          )
        ,'order'=> 'DESC', 'orderby' => 'date');

  
    $loop = new WP_Query( $args );
    echo $result_txt;
//    print_r($loop->request);
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post();
        $product_meta = get_post_meta($loop->post->ID);
        
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        
        $timearr = array_values(array_filter(maybe_unserialize($product_meta[from_time][0])));
        $bool = check_time($timearr,$from_time);
        global $product;
        if($bool){
             echo '<li class="product">';    
             echo '<a title="'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'">
                     <h3>'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</h3></a>';
             echo '<span> Curriculum: '.$product_meta[curriculum][0].'</span><br/>';
             echo '<span> Subject:';
                $subjects = maybe_unserialize($product_meta[subject][0]);
                if(is_array($subjects)){
                    foreach ($subjects as $key => $value) {
                        echo $value.",";
                    }
                }else{
                    echo $subjects;
                }
                echo '</span><br/>';
                echo '<span> Grade:'.$product_meta[grade][0].'</span><br/>';
                echo '<span> Rating: </span><br/>';
                echo '<span> Hourly Rate: <span class="price">'.$current_user_meta[hourly_rate][0].'</span></span><br/>';
                echo '<span> Country: ';
                $Country_code  = isset($current_user_meta[billing_country][0]) ? $current_user_meta[billing_country][0] : "";
                echo WC()->countries->countries[ $Country_code ];
                echo '</span><br/><br/>';
//                woocommerce_template_loop_add_to_cart( $post, $product );
                echo '</li><br/>';
             }
            
            endwhile;
             if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'tutor');
                }
                ?>
            <?php else:
                echo '<p>'._e( 'Sorry, no posts matched your criteria.' ).'</p>';
            endif;
    die;
}

add_action( 'wp_ajax_get_refined_tutors', 'get_refined_tutors' );
add_action( 'wp_ajax_nopriv_get_refined_tutors', 'get_refined_tutors' );

function check_time($timearr,$from_time){
        foreach ($timearr as $key => $value) {
            if(strtotime($value) >= strtotime($from_time)){
                return true;
            }else{
                return false;
            }
        }
    }