<?php
// put custom code here
define("Upload_File_Size", 50);
define("posts_per_page", 6);
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
//        print_r($files);
//        $Upload_File = array();
//        foreach ($files['name'] as $key => $value) {            
//                if ($files['name'][$key]) { 
//                    $file[$x] = array( 
//                        'name' => $files['name'][$key],
//                        'type' => $files['type'][$key], 
//                        'tmp_name' => $files['tmp_name'][$key], 
//                        'error' => $files['error'][$key],
//                        'size' => $files['size'][$key]
//                    ); 
//                    $Upload_File[] = $file; 
//                    $x++;
//                } 
//            } 
//            print_r($Upload_File);
        
//            die;
            $arr_docs = array();
//            foreach ($files as $key => $value) {
                if(!$files[error]){
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
//            }
            
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

//Video Upload Code
add_action( 'wp_ajax_display_selected_video', 'display_selected_video' );
add_action( 'wp_ajax_nopriv_display_selected_video', 'display_selected_video' );
function display_selected_video(){
    $id = $_POST['id'];
    $size = $_FILES[$id]['size'];
    $filesize = number_format($size / 1048576, 2);
    if($filesize < Upload_File_Size){
            $file = $_FILES[$id];
            
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

//Code for verification after registration of user
add_action( 'init', 'my_init' );
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
                wp_redirect(SITE_URL."/my-account/");
        }
//        wp_redirect(SITE_URL."/my-account/");
}


// this is just to prevent the user log in automatically after register
add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
function wc_registration_redirect( $redirect_to ) {
        wp_logout();
        wp_redirect( '/my-account/?q=');
        exit;
}

// when user login, we will check whether this guy email is verify
add_filter('wp_authenticate_user', 'myplugin_auth_login',10,2);
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
        
        if($user_info->roles[0] == 'student' || $user_info->roles[0] == 'tutor'){
        // create the url
        $url = get_site_url(). '/my-account/?p=' .base64_encode( serialize($string));
        // basically we will edit here to make this nicer
        $html = 'Hi,<br/><br/>Please click the following link to verify your email address for HighQ <br/><br/> <a href="'.$url.'">'.$url.'</a><br/> <br/>Thanks,<br/>Team HighQ';
        // send an email out to user
        wc_mail($user_info->user_email, __('Please activate your account'), $html);
        }
}


//Display User Information at Backend
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

//Save Approved user functionality
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
 
//add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );
//Custom Tab Account  Page
add_action( 'init', 'my_custom_endpoints' );
function my_custom_endpoints() {
    add_rewrite_endpoint( 'my-account-details', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-inbox',  EP_ROOT | EP_PAGES );
}

add_filter( 'query_vars', 'add_query_vars' , 0 );
function add_query_vars( $vars ) {
 $vars[] = 'my-account-details';
 $vars[] = 'my-inbox';
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
 $myorder = array(
 'my-account-details' => __( 'My Account', 'woocommerce' ),
 'my-inbox' => __( 'My Inbox', 'woocommerce' ),
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

add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );
function my_custom_endpoint_content() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-account-details.php';
     
}

add_action( 'woocommerce_account_my-inbox_endpoint', 'inbox_page' );
function inbox_page() {
     include 'wp-content/plugins/student_tutor_registration/templates/my-inbox.php';
}

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
add_action( 'wp_ajax_get_order_table_history', 'get_order_table_history' );
add_action( 'wp_ajax_nopriv_get_order_table_history', 'get_order_table_history' );
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
//                print_r($value);
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

//Get Student Order table History
add_action( 'wp_ajax_get_studentorder_table_history', 'get_studentorder_table_history' );
add_action( 'wp_ajax_nopriv_get_studentorder_table_history', 'get_studentorder_table_history' );
function get_studentorder_table_history(){
    $order_status = $_POST['order_status']!="" ? $_POST['order_status'] : wc_get_order_statuses();
    $customer_orders = get_posts( array(
        'numberposts' => - 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
//        'post_status' => $order_status,
        'post_status' => $order_status,
        'date_query' => array(
            'after' => date('Y-m-d', strtotime($_POST['history_from_date'])),
            'before' => date('Y-m-d', strtotime($_POST['history_to_date'])),
            'inclusive' => true,
        ),
    ) );
    
    foreach ($customer_orders as $key => $value) {
        $order = wc_get_order($value->ID);
        $status = wc_get_order_status_name($order->post->post_status);
        if(in_array($status, wc_get_order_statuses()))
        {
        $items = $order->get_items();
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
//add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
        $request_uri = $_SERVER[REQUEST_URI];
        $url = explode("/", $request_uri);
       
        if($url[2] == "tutors")
         return __( 'Book Session', 'woocommerce' );
        else
          return __( 'Book Course', 'woocommerce' );
}

//add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
function woo_archive_custom_cart_button_text() {
        $request_uri = $_SERVER[REQUEST_URI];
        $url = explode("/", $request_uri);
       
        if($url[2] == "tutors")
         return __( 'Book Session', 'woocommerce' );
        else
          return __( 'Book Course', 'woocommerce' );
}

// numbered pagination
function pagination($pages = '', $range = 4, $paged = 1, $fun_name)
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
     $num = 1;

     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".$num.")"."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".$paged - $num.")"."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='javascript:;' class=\"inactive\" onclick='".$fun_name."(".$i.")"."'>".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href='javascript:;' onclick='".$fun_name."(".$paged + $num.")"."'>Next &rsaquo;</a>";  
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
  $result_txt = '<h2>Result For: ';
  if($s){
      $strings = explode(" ", $s);
      $sarr = array();
      if(count($strings) <= 1){
          $sarr = array (  'value'=> $strings[0],
                         'compare'=>'LIKE'
                    );
      }else{
      $sarr[] =  "'relation' => 'OR'";
      foreach ($strings as $key => $value) {
      $sarr[]= array (  'value'=> $value,
                         'compare'=>'LIKE'
                    );
      }}
      $result_txt .= $s." ";
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

  $result_txt .= "</h2>";

  echo $result_txt;
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
                        $curriculumarr,
                        $subjectarr,
                        $gradearr,
                        $pricearr,
                        $from_datearr,
                        $from_timearr,
                        $sarr
                ),
                'posts_per_page' => $posts_per_page,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                $loop = new WP_Query( $args );
                $count = 1;
//                echo $loop->request;
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $course_videos = maybe_unserialize($product_meta[video_url]);
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $course_video = maybe_unserialize($course_videos[0]);
//        print_r($product_meta);die;
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $timezone = $product_meta[timezone][0];
        $datetime_obj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        global $product;
             echo '<li class="col-md-4 result-box">';    
             echo '<h3 class="course-title"><a href="'.get_permalink( $loop->post->ID ).'" title="'.esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID).'">
                     '.$product->get_title().'</a></h3>';
             echo '<span> <strong>'.$product_meta[curriculum][0].' | '.$subjects.' | '.$product_meta[grade][0].'</strong></span><br/>';
//             echo '<span> <strong>Subject:</strong>';
//                
//                if(is_array($subjects)){
//                    foreach ($subjects as $key => $value) {
//                        echo $value.",";
//                    }
//                }else{
//                    echo $subjects;
//                }
//                echo '</span><br/>';
//                echo '<span> <strong>Grade:</strong>'.$product_meta[grade][0].'</span><br/>';
//                echo '<span> <strong>Rating:</strong> </span><br/>';
//                echo '<span> <strong> Qualification:</strong> ';
//                $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
//                        foreach ($tutor_qualification as $key => $value) {
//                            echo $value.", ";
//                        }
//                echo '</span>';
                echo '<span> <strong>No of Classes/hours:</strong>'.$no_of_classes.'</span><br/>';
                echo '<span><strong>Start Date:</strong>';
                        if(is_user_logged_in()){
                            $otherTZ  = new DateTimeZone($timezone);
                            $datetime_obj->setTimezone($otherTZ); 
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;
                        }else{
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;   
                        }
                echo '</span><br/>';
                echo '<span><strong>Name of Tutor:</strong>'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</span><br/>';
                $_product = wc_get_product( $loop->post->ID );
                echo '<span> <strong>Price:</strong> <span class="price">'.$_product->get_price().'</span></span><br/>';
                echo '<span> <strong>Seats Available:</strong>'.$product->get_stock_quantity().'</span><br/>';
                echo '<input type="hidden" id="post_id_'.$count.'" class="post_ids" value="'.$loop->post->ID.'">';
                echo '<div><span class="pull-right">';
                foreach ($course_video as $key => $value) {
                            if(!empty($value)){
                                echo "<a class='glyphicon glyphicon-facetime-video' onclick='view_tutor_video(".$loop->post->ID.")'></a>";
                                echo '<div id="'.$loop->post->ID.'_video" title="Course Video" class="dialog">';
                                echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="580"]');
                                echo '</div>';
                            }
                }
                echo '</span>';
                echo '<button type="button" class="btn btn-primary btn-sm" id="btn_search" name="btn_viewtutor" value="btn_viewtutor" onclick="get_view_tutor('.$loop->post->ID.')">';
                echo '<span class="glyphicon glyphicon-menu-ok"></span>View Tutor</button>';
                echo '<div id="'.$loop->post->ID.'" title="'.$product->get_title().'" class="dialog">';
                echo '<div class="tutor-profile">'.get_avatar( $user_id, 96).'</div><br/>';
                echo '<div class="tutor-info"> <h3 class="course-title"><a href="'.get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($user_id).'" title="'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'">'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</a></h3></div><br/>';
                echo '<span> <strong>Rating:</strong> </span><br/>';
                echo '<span> <strong>Qualification of Tutor:</strong>';
                foreach ($tutor_qualification as $key => $value) {
                    echo $value.",";
                }
                echo '</span><br/>';
                echo '<span> <strong>No. of Sessions:</strong>'.$no_of_classes.'</span><br/>';
                echo '<span> <strong>Hourly Rate:</strong>'.$current_user_meta[hourly_rate][0].'</span><br/>';
                echo '<p>'.$current_user_meta[tutor_description][0].'</p></div>';
                echo '</li>';
            
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
    }
  global $wpdb;
 $posts_per_page = posts_per_page;
 $offset = ($paged - 1)*$posts_per_page;
 $curriculumarr = $subjectarr = $gradearr = $pricearr = $sarr = $from_datearr = $from_timearr = '';
 $arr = array();
  $result_txt = '<h2>Result For: ';
  if($s){
      $strings = explode(" ", $s);
      $sarr = array();
      if(count($strings) <= 1){
          $sarr = array (  'value'=> $strings[0],
                         'compare'=>'LIKE'
                    );
      }else{
      $sarr[] =  "'relation' => 'OR'";
      foreach ($strings as $key => $value) {
      $sarr[]= array (  'value'=> $value,
                         'compare'=>'LIKE'
                    );
      }}
      $result_txt .= $s." ";
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
  
  $result_txt .= "</h2>";
  echo $result_txt;
    $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                array(
                    'meta_value'=>$s,
                    'meta_compare'=>'LIKE'
                ),
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
                echo $loop->request;
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $tutor_video = $current_user_meta[tutor_video_url][0];
        global $product;
        
             echo '<li class="col-md-4 result-box">';    
             echo '<div class="tutor-profile">'.get_avatar( $user_id, 96).'</div>';
             echo '<div class="tutor-info"><h3 class="course-title"><a title="'.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'" href="'.get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ).'?'.base64_encode($user_id).'">
                     '.$current_user_meta[first_name][0]." ".$current_user_meta[last_name][0].'</a></h3>';
             echo '<span><strong> Qualification:</strong>'; 
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
             echo '</span>';
//             echo '<span> <strong>Curriculum:</strong> '.$product_meta[curriculum][0].'</span>';
//             echo '<span> <strong>Subject:</strong>';
//                
//                if(is_array($subjects)){
//                    foreach ($subjects as $key => $value) {
//                        echo $value.",";
//                    }
//                }else{
//                    echo $subjects;
//                }
//                echo '</span><br/>';
//                echo '<span> <strong>Grade:</strong>'.$product_meta[grade][0].'</span><br/>';
//                echo '<span> <strong>Rating:</strong> </span><br/>';
             echo '<span> <strong>'.$product_meta[curriculum][0].' | '.$subjects.' | '.$product_meta[grade][0].'</strong></span><br/>';
                echo '<span> <strong>Hourly Rate:</strong> <span class="price">'.$current_user_meta[hourly_rate][0].'</span></span><br/>';
                echo '<span> <strong>Country:</strong>';
                $Country_code  = isset($current_user_meta[billing_country][0]) ? $current_user_meta[billing_country][0] : "";
                echo WC()->countries->countries[ $Country_code ];
                echo '</span>';
                echo '<input type="hidden" id="post_id_'.$count.'" class="post_ids" value="'.$loop->post->ID.'">';
                echo '<div><span class="pull-right"><a class="glyphicon glyphicon-facetime-video" onclick="view_tutor_video('.$loop->post->ID.')"></a>';
                echo '<div id="'.$loop->post->ID.'_video" title="Tutor Video" class="dialog">';
                echo do_shortcode('[videojs_video url="'.$tutor_video.'" webm="'.$tutor_video.'" ogv="'.$tutor_video.'" width="580"]');
                echo '</div></span></div>';
//                woocommerce_template_loop_add_to_cart( $loop->post, $product );
                echo '</li>';
                $count +=1;
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
//    echo $from_date." and ".$to_date;die;  
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
add_action( 'woocommerce_single_product_summary', 'display_product_details', 11 );
function display_product_details() {
    //Get Logged in user timezone
    $logged_in_user_id = get_current_user_id();
    $logged_in_user_meta = get_user_meta($logged_in_user_id);
    $timezone = $logged_in_user_meta[timezone][0];
    
    global $product;
    $product_meta = get_post_meta($product->id);
    if($product_meta[tutoring_type][0] == "Course"){
    $from_date = array_values(maybe_unserialize($product_meta[from_date]));
    $from_time = array_values(maybe_unserialize($product_meta[from_time]));
    $video_url = array_values(maybe_unserialize($product_meta[video_url][0]));
//    print_r($product_meta);
    $no_of_students = $product_meta[total_sales][0];
    $downloadable_files = array_values(maybe_unserialize($product_meta[downloadable_files][0]));
//    $units_sold = get_post_meta( $product->id, 'total_sales', true );
    echo '<p>' . sprintf( __( 'No. of Students Attending: %s', 'woocommerce' ), $no_of_students ) . '</p>';
    echo "Description:<br/>";
    echo $product->post->post_content."<br/><br/>";    
    foreach ($from_date as $key => $value) {
        $format = "Y-m-d H:i";
        $datetime_obj = DateTime::createFromFormat($format, $value." ".$from_time[$key],new DateTimeZone('UTC'));
        
        if(is_user_logged_in()){
            $datetime_obj->setTimezone(new DateTimeZone($timezone)); 
            $day = $datetime_obj->format('l');
            $date = $datetime_obj->format('d/m/Y');
            $time = $datetime_obj->format('h:i A T');
        }else{
            $day = $datetime_obj->format('l');
            $date = $datetime_obj->format('d/m/Y');
            $time = $datetime_obj->format('h:i A T');
        }
        echo "Session ".($key+1)."<br/>";
        echo "Day ".$day." Date ".$date." Time ".$time."<br/><br/>";
    }
    
    if($video_url[0]){
    echo "Course Video<br/>";
    echo do_shortcode('[videojs_video url="'.$video_url[0].'" webm="'.$video_url[0].'" ogv="'.$video_url[0].'" width="580"]');
    echo "<br/>";
    }
     if(!empty($downloadable_files)){
     echo "Download Course Material<br/>";
     foreach ($downloadable_files as $value) {
         echo "<a href='".$value."' target='_blank'>Doc</a><br/>";
     }}
    }else{
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
//        print_r($from_date);
        $timezone = $product_meta[timezone][0];
        
        foreach ($from_date as $key => $value) {
        $format = "Y-m-d H:i";
        $datetime_obj = DateTime::createFromFormat($format, $value." ".$from_time[$key]);
        
        if(is_user_logged_in()){
            $datetime_obj->setTimezone(new DateTimeZone($timezone)); 
            $day = $datetime_obj->format('l');
            $date = $datetime_obj->format('d/m/Y');
            $time = $datetime_obj->format('h:i A T');
        }else{
            $date = $datetime_obj->format('d/m/Y h:i A T');
        }
        echo "Session ".($key+1)."<br/>";
        echo "Day ".$day." Date ".$date." Time ".$time."<br/><br/>";
    }
    }
}

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
    if(is_array($product_meta[from_date][0])){
    $from_date = array_values(maybe_unserialize($product_meta[from_date][0]));
    $date = str_replace('/', '-', $from_date[0]);
    $from_date = date('Y-m-d', strtotime($date));
    $to_date = date('Y-m-d', strtotime($from_date." +2 month"));}
    $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
    $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])) : "";
    $hourly_rate = $current_user_meta[hourly_rate][0];
    $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
    ?><h3 class="pippin_header"><?php _e('Tutor Profile');?></h3>
<section class="clearfix">
    <div class="tutor-registration">
    <article>
        <div class="box-one">
            <div class="filling-form">
                <div class="form-inline clearfix">
                    <div class="col-md-2">
                        <p class="field-para">
                            <?php echo get_avatar( $product->post->post_author, 96);?>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h3><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></h3>
                        <span> <strong>Rating:</strong> <?php ?></span><br/>
                        <span> <strong>Qualification of Tutor:</strong> <?php 
                            foreach ($tutor_qualification as $key => $value) {
                                    echo $value.",";
                                }
                        ?></span><br/>
                        <span> <strong>Subjects:</strong> <?php
                                $subjects = maybe_unserialize($product_meta[subject][0]);
                                if(is_array($subjects)){
                                    foreach ($subjects as $key => $value) {
                                        echo $value.",";
                                    }
                                }else{
                                    echo $subjects;
                                }
                        ?></span><br/>
                        <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                    </div>
                    
                    <div class="col-md-4">
                        <?php $target_file = $current_user_meta[tutor_video_url][0]; 
                        echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="580"]');?>
                    </div>
                </div>
                <div class="form-inline clearfix">
                    <div class="col-md-10">
                        <p> <?php echo $content;?></p>
                    </div>
                </div>
            </div>
             <input type="button" onclick="location.href = '<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($product->post->post_author);?>'" id="btn_1on1" value="1on1 Availability">
        </div>
        </article>
        <?php if($product_meta[tutoring_type][0] == "Course"){?>
        <h3 class="pippin_header"><?php _e('Related Tutors');?></h3>
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
                'post__not_in' => array($product->post->ID),
                'date_query' => array(
                    array(
                            'after'     => $from_date,
                            'before'    => $to_date,
                            'inclusive' => true,
                    ),),
                'orderby' => 'from_date',
                'order'   => 'ASC',
                'posts_per_page' => -1,
        );
        add_filter( 'posts_groupby', 'my_posts_groupby' );
        $the_query = new WP_Query( $args );
        //echo $the_query->request;
        // The Loop
        if ( $the_query->have_posts() ) {
                echo '<ul>';
                while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $product_meta = get_post_meta($the_query->post->ID);
                        global $product;
                        $current_user_meta = get_user_meta($the_query->post->post_author);
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
                        $count = count($from_date);
                        ?>
                        <li class="col-md-4 result-box">
                        <div class="tutor-profile"><?php echo get_avatar( $the_query->post->post_author, 96);?></div>
                        <h3><a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($the_query->post->post_author);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></a></h3>
                        <span> <strong>Qualification of Tutor:</strong> <?php 
                                    foreach ($tutor_qualification as $key => $value) {
                                            echo $value.",";
                                        }
                                ?></span><br/>
                        <span> <strong>No. of Sessions:</strong> <?php echo $count;?></span><br/>
                        <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                        </li>
                        <?php 
                }
                echo '</ul>';
                /* Restore original Post Data */
                wp_reset_postdata();
        } else {
                echo "No Related Tutors Found";
        }
        }
        ?>
 </div>
</section>
<?php
}

// determine if customer has bought product if so display message
add_action( 'woocommerce_before_single_product', 'condition_based_add_to_cart_button', 11 );
function condition_based_add_to_cart_button(){
    // if product is already in global space
    global $product;
    // or fetch product attributes by ID
    if( empty( $product->id ) ){
            $wc_pf = new WC_Product_Factory();
            $product = $wc_pf->get_product($id);
    }
    $current_user = wp_get_current_user();
    if( wc_customer_bought_product( $current_user->email, $current_user->ID, $product->id ) ){
            remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
            add_action( 'woocommerce_single_product_summary', 'display_product_purchased', 11 );
    }
}

function display_product_purchased(){
    echo '<p style="color:#77a464;">Product already purchased!</p>';
}

function my_posts_groupby($groupby) {
    global $wpdb;
//    echo $groupby;
    $groupby = "{$wpdb->posts}.post_author";
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
                wc_add_notice( sprintf( __( "Free Session has been added to your cart. <a>View Cart</a>") ) ,'success' );
            }
            else{
                wc_add_notice( sprintf( __( "Only one Free Session is allowed in cart") ) ,'error' );
            }
        }
        echo 1;
//wp_redirect(get_site_url()."/tutors/tutor-public-profile/?".base64_encode($_POST[user_id])); exit;
           
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
    $current_user_meta = get_user_meta($user_id);
    $timezone = $current_user_meta[timezone][0];
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
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
		array(
			'key'     => 'wpcf-course-status',
			'value'   => 'Approved',
		),
                array(
			'key'     => 'tutoring_type',
			'value'   => $tutoring_type,
		),
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
//echo "===>".$bool;
    if ( $the_query->have_posts()) : 
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $from_date = get_post_meta($the_query->post->ID,'from_date');
            $from_time = get_post_meta($the_query->post->ID,'from_time');
//            print_r($session_dates);
            foreach ($session_dates as $key => $value) {
                if(in_array($value, $from_date)){
                    foreach ($from_date as $key1 => $value1) {
                    $date = DateTime::createFromFormat($format, $value." ".$session_times[$key],new DateTimeZone($timezone));
                    $date->setTimezone($otherTZ);
                    $checked_date = strtotime($date->format($format));
                    
                    $datetime_obj1 = DateTime::createFromFormat($format, $from_date[$key1]." ".$from_time[$key1],$otherTZ);
                    $datetime1 = strtotime($datetime_obj1->format($format));
                    
                    $datetime2 = strtotime("+1 hour",$datetime1);
                    
                    if($checked_date >=$datetime1 && $checked_date <= $datetime2){
                        $boolarr[]=0;
                    }  else {
                        $boolarr[]=1;
                    }}
                }
            }
        endwhile;
//        echo "in post=>".$return;
        if(in_array(0,$boolarr) ){
            $return=0;
        }else{
            $return=1;
        }
    else :
        $return=1;
//    echo "Not in post=>".$return;
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
    if ( is_user_logged_in() ) { 
    // get user attributes
    $current_user = wp_get_current_user();
        
    //Get Cart Data
    $items = WC()->cart->get_cart();
    foreach($items as $item => $values) { 
            $_product = $values['data']->post; 
            // or fetch product attributes by ID
            if(!empty( $_product->ID ) ){
                    $wc_pf = new WC_Product_Factory();
                    $product = $wc_pf->get_product($_product->ID);
                     // determine if customer has bought product
                    if( wc_customer_bought_product( $current_user->email, $current_user->ID, $product->id ) ){
                            wc_add_notice( sprintf( __( "You have already purchased ".$product->post->post_title." .") ) ,'error' );
                            remove_product_from_cart($product->id);
                            wp_redirect(get_site_url()."/cart/"); exit;
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
     $prod_unique_id = WC()->cart->generate_cart_id( $product_id );
     $bool = WC()->cart->remove_cart_item($prod_unique_id);
     return $bool;
}

//Related Courses on Tutor public profile page
add_action( 'wp_ajax_get_refined_relatedtutors', 'get_refined_relatedtutors' );
add_action( 'wp_ajax_nopriv_get_refined_relatedtutors', 'get_refined_relatedtutors' );
function get_refined_relatedtutors(){
    $paged = $_POST['paged'];
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
//                                'value'   => $todays_date,
                                'value'   => '2017-03-03',
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        )
                ),
                'orderby' => 'from_date',
                'order'   => 'ASC',
                'posts_per_page' => posts_per_page,
                'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC'
        );
        $loop = new WP_Query( $args1 );
        
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $no_of_classes = count($from_date);
        $format = "Y-m-d";
        $dateobj = DateTime::createFromFormat($format, $from_date[0]);
        global $product;
        ?>
            <li class="col-md-4 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a></h3>
                <span><strong><?php echo $product_meta[curriculum][0]." | ".$product_meta[subject][0]." | ".$product_meta[grade][0];?></strong></span><br/>
                <span><strong>Start Date & Time:</strong> <?php echo $dateobj->format('d/m/Y')." ".$from_time[0];?></span><br/>
                <span> <strong>Seats Available:</strong> <?php echo $product->get_stock_quantity();?></span><br/>
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
//function set_user_timezone($user_login, $user) {
//         $user_id = $user->ID;
//         $current_user_meta = get_user_meta($user_id);
//         define("zip_code", $current_user_meta[billing_postcode][0]);
//}
//add_action('wp_login', 'set_user_timezone', 10, 2);