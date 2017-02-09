<?php
// put custom code here

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
    wp_enqueue_style( 'ui-datepicker-css', get_stylesheet_directory_uri() .'/css/jquery-ui.css');
    
    wp_enqueue_script( 'jquery-validation-js');
    wp_enqueue_script( 'format-extension-js');
    wp_enqueue_script( 'student-validate-js');
    wp_enqueue_script( 'tutor-validate-js');
    wp_enqueue_script( 'ui-datepicker-js');
    
    
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
//        print_r($selected_cities);
        foreach ($selected_cities as $key => $value) {
//            echo "key: ".$key." and state code: ".$selected_state_code;
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


add_action( 'wp_ajax_display_selected_video', 'display_selected_video' );
add_action( 'wp_ajax_nopriv_display_selected_video', 'display_selected_video' );
function display_selected_video(){
//    $tmp_name = $_FILES['documents2']['tmp_name'];
//    $name = $_FILES['documents2']['name'];
//    $type = $_FILES['documents2']['type'];
//    $error = $_FILES['documents2']['error'];
//    $size = $_FILES['documents2']['size'];
    
    $file = $_FILES['documents2'];
    if(!$file[error]){
               if ( ! function_exists( 'wp_handle_upload' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }

               $upload_overrides = array( 'test_form' => false );
               $movefile = wp_handle_upload( $file, $upload_overrides );
                if ( $movefile && ! isset( $movefile['error'] ) ) {
                    var_dump($movefile["url"]);
                    $target_file = $movefile["url"];
                    $type = $movefile["type"];
                } else {
                    /**
                     * Error generated by _wp_handle_upload()
                     */
                    echo $movefile['error'];
                }
    }
//     die;                       
    // Get the path to the upload directory.
//    $wp_upload_dir = wp_upload_dir();
//    $target_dir = $wp_upload_dir['path'];
//    $target_file = $target_dir."/".$name;
//    echo "target dir: ".$target_dir." nad target file ".$target_file;
//    if(move_uploaded_file($tmp_name, $target_file)){
//    // $filename should be the path to a file in the upload directory.
//    $filename = $target_file;
//    echo $wp_upload_dir['url'] . '/' .  $name;
    // Prepare an array of post data for the attachment
    $attachment = array(
            'guid'           => $target_file, 
            'post_mime_type' => $type,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $name ),
            'post_content'   => '',
            'post_status'    => 'inherit'
    );
//    echo "attachment";print_r($attachment);
    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $target_file );
//    echo "Attached Id: ".$attach_id;
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    
    echo "<input type='hidden' name='video_url' name='video_url' value='".$target_file."'>";
//    set_post_thumbnail( $parent_post_id, $attach_id );
    echo do_shortcode('[videojs_video url="'.$target_file.'" width="480"]');
//    }
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

//Custom Tab Account  Page
function my_custom_endpoints() {
    add_rewrite_endpoint( 'my-account-details', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'my_custom_endpoints' );


function add_query_vars( $vars ) {
 $vars[] = 'my-account-details';
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
// 'edit-account' => __( 'Change My Details', 'woocommerce' ),
// 'dashboard' => __( 'Dashboard', 'woocommerce' ),
 'orders' => __( 'Orders', 'woocommerce' ),
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
}

add_action( 'woocommerce_account_my-account-details_endpoint', 'my_custom_endpoint_content' );

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