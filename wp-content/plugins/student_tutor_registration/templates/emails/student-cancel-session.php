<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
        
        <p><?php printf( __( 'Dear %s,'),$data->student_name)?></p>

        <p><?php printf( __( 'We notice that you have cancelled your session/ course to be held on %s with %s.'),$data->session_datetime,$data->tutor_name)?></p>
        
        <p><?php printf( __( 'If you would like to re-schedule the session with the same tutor, please check your tutor’s availability on the portal and <a href="%s" target="_blank" class="">re-book</a> your session.'),$data->tutor_public_profile)?></p>
        
        <p><?php _e("If you want to search for a different course or different tutor for a 1 on1 tutoring session, Click on:",'woocommerce'); ?></p>
        
        <p><a href="<?php echo get_site_url()?>/courses/academic-courses/" target="_blank">Courses/Exam-Prep</a>&nbsp;or&nbsp;<a href="<?php echo get_site_url()?>/tutors/academic-courses/" target="_blank">1on1 Tutoring</a></p>
        
        <p><?php _e('We look forward to meeting you at your next session and working with you towards becoming a <b>“Successful Learner!“</b>','woocommerce'); ?></p>
        
        <p><?php _e("Have a great day!",'woocommerce'); ?></p>
        
        <p><?php _e("The Highq Team<br>Learning Effectively; Growing Confidently",'woocommerce'); ?></p>

<?php


do_action( 'woocommerce_email_footer', $email );
