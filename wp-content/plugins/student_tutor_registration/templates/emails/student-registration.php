<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->user_name)?></p>

        <p><?php _e("Thank you for registering with Highq.  Once you have activated your account and logged in, you will be able to:",'woocommerce'); ?></p>
        
        <p><?php _e('<strong>SEARCH</strong>','woocommerce')?></p>
        
        <p><?php _e('Find the perfect course or tutor. Whether you need homework help, a catch up for class, or exam prep we have you covered.','woocommerce'); ?></p>
        
        <p><?php _e('<strong>MATCH</strong>','woocommerce')?></p>
        
        <p><?php _e('Once you have put in your requirements, our system will provide you with the best tutors and courses within a few seconds.','woocommerce'); ?></p>
        
        <p><?php _e('<strong>SCHEDULE</strong>','woocommerce')?></p>
        
        <p><?php _e('Look at the tutor’s availability and/ or the course dates and book a session or a course.','woocommerce'); ?></p>
        
        <p><?php _e('<strong>LEARN</strong>','woocommerce')?></p>
        
        <p><?php _e('On the appointed day and time, login 10 mins before the session and enter the virtual classroom.  Check your system requirements and make sure everything is working well before the session commences.  Use our state-of-the-art virtual classroom which is equipped with an interactive whiteboard, audio/video chat, screen sharing, ability to upload documents much more, to communicate with your tutor.','woocommerce'); ?></p>
        
        <p><?php _e('We look forward to seeing you at the sessions.','woocommerce'); ?></p>
        
        <p><?php printf( __( 'Please click on the link below to activate your account and join our community of <strong>“Successful Learners!”</strong><br><a href="%s">Activation Link</a>'),$data->activation_link)?></p>
               
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
