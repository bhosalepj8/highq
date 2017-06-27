<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}


if(!class_exists('Password_Changed_Email')):

    class WP_Dynamic_Email extends WC_Email {
        /**
         * Constructor
         */
        function __construct() {
            
            $this->id = 'wp_dynamic_emails';
            $this->title = 'Dynamic Emails Using Woocommerce';
            $this->description= __( 'We are sending all dynamic emails using this common template (Please Do not disable).', 'woocommerce' );
            $this->template_base = WC_STR_DIR.'/templates/';
            parent::__construct();
        }
        
        function set_args($args){
            $this->heading = __( $args['heading'] , 'woocommerce' );
            $this->subject      = __( $args['subject'] , 'woocommerce' );
            $this->template_html = $args['template_html'];
            $this->recipient = $args['recipient'];
//            $this->template_plain = 'emails/plain/cancel-request-order.php';
        }

        /**
         * trigger function.
         *
         * @access public
         * @return void
         */
        function trigger($params) {

            if ( !empty($params) ) {
                $this->data = $params;
            }
            
//            echo $this->get_content();
//            die;
            if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
                return;
            }
            
            $this->send($this->get_recipient(),$this->get_subject(),$this->get_content(),$this->get_headers(),$this->get_attachments() );
        }

        /**
         * get_content_html function.
         *
         * @access public
         * @return string
         */
        function get_content_html() {

            return wc_get_template_html(
                $this->template_html,
                array(
                'data' =>  $this->data,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => true,
                'plain_text'=>false,
                'email' => $this),
                $this->template_base,
                $this->template_base);

        }

        /**
         * get_content_plain function.
         *
         * @access public
         * @return string
         */
//        function get_content_plain() {
//
//            return wc_get_template_html(
//                $this->template_plain,
//                array(
//                'order' => $this->object,
//                'email_heading' => $this->get_heading(),
//                'sent_to_admin' => false,
//                'plain_text'=>true,
//                'email' => $this),
//                $this->template_base,
//                $this->template_base);
//
//        }

        function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'         => __( 'Enable/Disable', 'woocommerce' ),
                    'type'          => 'checkbox',
                    'label'         => __( 'Enable this email notification', 'woocommerce' ),
                    'default'       => 'yes'
                ),
//                'recipient' => array(
//                    'title'         => __( 'Recipient(s)', 'wc-cancel-order' ),
//                    'type'          => 'text',
//                    'description'   => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'wc-cancel-order' ), esc_attr( get_option('admin_email') ) ),
//                    'placeholder'   => '',
//                    'default'       => esc_attr( get_option('admin_email') ),
//                    'desc_tip'      => true
//                ),
//                'subject' => array(
//                    'title'         => __( 'Subject', 'wc-cancel-order' ),
//                    'type'          => 'text',
//                    'description'   => sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'wc-cancel-order' ), $this->subject ),
//                    'placeholder'   => '',
//                    'default'       => '',
//                    'desc_tip'      => true
//                ),
//                'heading' => array(
//                    'title'         => __( 'Email Heading', 'wc-cancel-order' ),
//                    'type'          => 'text',
//                    'description'   => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'wc-cancel-order' ), $this->heading ),
//                    'placeholder'   => '',
//                    'default'       => '',
//                    'desc_tip'      => true
//                ),
                'email_type' => array(
                    'title'         => __( 'Email type', 'woocommerce' ),
                    'type'          => 'select',
                    'description'   => __( 'Choose which format of email to send.', 'woocommerce' ),
                    'default'       => 'html',
                    'class'         => 'email_type wc-enhanced-select',
                    'options'       => 'html',
                    'desc_tip'      => true
                )
            );
        }

    }

endif;