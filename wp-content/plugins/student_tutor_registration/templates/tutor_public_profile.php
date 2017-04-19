<?php function tutor_public_profile_page($user_id){
 ob_start(); 
 $site_url= get_site_url();
 $user_id = base64_decode($user_id);
 if ( is_user_logged_in() ) {
 //Get Logged in user timezone
    $logged_in_user_id = get_current_user_id();
    $logged_in_user_meta = get_user_meta($logged_in_user_id);
    $timezone = $logged_in_user_meta[timezone][0];
 }
 $current_user_meta = get_user_meta($user_id);
// print_r($current_user_meta);
 $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
 $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])) : "";
 $hourly_rate = $current_user_meta[hourly_rate][0];
 $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
 $format = "Y-m-d";
 $todays_date = date($format);
 $subarr = array();
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
                        )
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );
//echo $the_query->request;
//die;
     if ( $the_query->have_posts() ) :
     while ( $the_query->have_posts() ) : $the_query->the_post();
     $product_meta = get_post_meta($the_query->post->ID);
     global $product;
     if(!in_array($product_meta [subject][0], $subarr)){
     $subarr[]= $product_meta [subject][0];
     }
     endwhile;
     endif;
     
     wc_print_notices();
   ?>
 <div id="wrapper" class="woocommerce">
    <div class="container" style="font-family:lato;">
    <div class="loader"></div>
    <!--<h3 class="pippin_header"><?php _e('Tutor Profile');?></h3>-->
    	
<section class="clearfix">
    <div class="tutor-detail-box clearfix">
    <!--<article>-->
        <?php 
     if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $user_meta = get_user_meta($logged_in_user_id);
        $user_role = $current_user->roles[0];
        if($user_role == 'student' && $user_meta['free_session'][0]){
     ?>
        <div class="box-one">
            <div class="filling-form">
                <div class="form-inline clearfix">
                    <div class="col-md-10">
                        <h3>You are eligible to attend a free session</h3>
                        Please choose a session using the FREE SESSION button
                    </div>
                    <div class="col-md-2">
                        <p class="field-para">
                        <button type="button" class="btn btn-primary btn-sm" onclick="get_freesession_popup()">
                            <span class="glyphicon glyphicon-menu-ok"></span>
                            Free Session
                        </button>
                        <div id="book_free_session" title="Free Session" class="dialog">
                            <select id="session_dates" name="session_dates" onchange="get_time_by_sessiondate()">
                                <option value="">-Select Session Date-</option>
                               <?php if ( $the_query->have_posts() ) : ?>
                                <!-- the loop -->
                                <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                                 $product_meta = get_post_meta($the_query->post->ID);
//                                 $from_time[] = $product_meta[from_time][0];
                             ?>
                                <option value="<?php echo $product_meta[from_date][0];?>" >
                                    <?php echo $product_meta[from_date][0];?>
                                </option>
                                <?php endwhile; ?>
                                <!-- end of the loop -->
                                <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                            </select>
                            <div id="session_time_div"></div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="add_freeproduct(<?php echo $user_id;?>)">
                                    <span class="glyphicon glyphicon-menu-ok"></span>
                                    Book Session
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php }}?>
        
        <div class="col-md-6">
                    <div class="col-md-4 tutor-picture">
                        <?php echo get_avatar( $user_id, 150);?>
                    </div>
                    
                    <div class="col-md-8 tutor-info">
                    	<h2><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></h2>
                         <p class="single-session">
                                <span class="clearfix"><strong>Rating:</strong>  </span>
                                <span class="clearfix"><strong>Qualification of Tutor:</strong> <?php 
                                    foreach ($tutor_qualification as $key => $value) {
                                            echo $value.",";
                                        }
                                ?> </span>
                                <span class="clearfix"><strong>Subjects:</strong> <?php
                                foreach ($subarr as $key => $value) {
                                            echo $value.",";
                                        }
                                ?></span>
                                <span class="clearfix"><strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span>
                            </p>
                       </div>
                       <div class="col-md-12 tutor-desciption">
                            <p><?php echo $content;?></p>
                       </div>
                 </div>
                <div class="col-md-6">
                    <div class="col-md-12 course-video-box">
                        <p class="col-md-12">
                            <?php $target_file = $current_user_meta[tutor_video_url][0]; 
                        echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="580"]');?>
                        </p>
<!--                    <p class="col-md-12 text-right buttons-para">
                        <button class="btn-default" value="">Subscribe</button>
                        <br/>
                        <button class="btn-primary" value="">Trial Session</button>
                    </p>-->
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>"/>
                    </div>
                </div>
    </div>
    
        <div class="session-tutor-detail clearfix">
                <div class="col-md-8 session-info">
                    <h3>1 on 1 Tuition Availability Calendar</h3>
                    <div class="col-md-12">
                        <div id="cal_datepicker"></div>
                    </div>
                </div>
                <div class="col-md-4 tutor-detail" >
                    <!--<h3>Courses Availability Calendar</h3>-->
                    <div class="col-md-12">
                        <div id="sessions_div"></div>
                    </div>
                </div>
         </div><!--session-detail ends here-->
    
    
        <ul id="related_tutors">
        <?php 
         $paged = 1; 
         $posts_per_page = posts_per_page;
         $offset = ($paged - 1)*$posts_per_page;
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
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC'
        );
        $loop = new WP_Query( $args1 );
//        echo $loop->request;
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $dateobj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        if(is_user_logged_in()){
            $dateobj->setTimezone(new DateTimeZone($timezone)); 
        }
        global $product;
        ?>
            <li class="col-md-4 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a></h3>
                <span><strong><?php echo $product_meta[curriculum][0]." | ".$product_meta[subject][0]." | ".$product_meta[grade][0];?></strong></span><br/>
                <span><strong>Start Date & Time:</strong> <?php echo $dateobj->format('d/m/Y h:i A T');?></span><br/>
                <span> <strong>Seats Available:</strong> <?php echo $product->get_stock_quantity();?></span><br/>
                <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
            </li>
        
        <?php
         endwhile; 
         if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_related_courses');
            }
         endif;
        ?>
        </ul>
    <!--</article>-->
 </div>
</section>
    </div>
 </div>
 
 <?php 
    
    return ob_get_clean();
}

