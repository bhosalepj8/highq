<?php function tutor_public_profile_page($user_id){
 ob_start(); 
 $site_url= get_site_url();
 $user_id = base64_decode($user_id);
// if ( is_user_logged_in() ) {
 //Get Logged in user timezone
//    $logged_in_user_id = get_current_user_id();
//    $logged_in_user_meta = get_user_meta($logged_in_user_id);
    $timezone = get_current_user_timezone();
// }
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
    <div class="container">
    <div class="loader"></div>
    <?php wc_print_notice('<p>Confused about the session? Use our <a href="'.get_site_url().'/my-account/my-inbox/?fepaction=newmessage" class="search-btn"> messaging system</a> to ask a question?</p>','notice');?>
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
                    <div class="col-md-4 col-xs-3 tutor-picture">
                        <?php echo get_avatar( $user_id, 150);?>
                    </div>
                    
                    <div class="col-md-8 col-xs-9 tutor-info">
                    	<h2><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></h2>
                         <p class="single-session">
                                <span class="clearfix"><strong>Rating:</strong>  </span>
                                <span class="clearfix"><strong>Qualification of Tutor:</strong> <?php 
                                     echo implode(", ", $tutor_qualification);
                                ?> </span>
                                <span class="clearfix"><strong>Subjects:</strong> <?php
                                        if(is_array($subarr)){
                                            echo implode(", ", $subarr);
                                        }else{
                                            echo $subjects;
                                        }
                                ?></span>
                                <span class="clearfix"><strong>Hourly Rate:</strong> <?php echo get_woocommerce_currency_symbol().$current_user_meta[hourly_rate][0];?></span>
                            </p>
                       </div>
                       <div class="col-md-12 col-xs-12 tutor-desciption">
                            <p><?php echo $content;?></p>
                       </div>
                 </div>
                <div class="col-md-6 col-xs-12">
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
                <div class="col-md-7 session-info">
                    <h3 class="col-md-8">1 on 1 Tution Availability Calendar</h3>
                    <ul class="col-md-4 calender-info">
                    	<li class="no-schedule">
                        <span></span> 
                        No Schedule</li>
                        <li class="available"><span></span> Available</li>
                        <li class="unavailable"><span></span> Unavailable</li>
                    </ul>
                    <div class="col-md-12">
                        <div id="cal_datepicker"></div>
                    </div>
                </div>
                <div class="col-md-5 tutor-detail" >
                    <!--<h3>Courses Availability Calendar</h3>-->
                    <div class="col-md-12">
                        <div id="sessions_div"></div>
                    </div>
                </div>
         </div><!--session-detail ends here-->
    
         
        <ul id="related_tutors" class="products exam-prep-results profilepage-result">
        <?php 
         $paged = 1; 
         $posts_per_page = posts_per_page;
//         $offset = ($paged - 1)*$posts_per_page;
         
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
                'paged' => $paged,'orderby' => 'from_date','order'   => 'DESC'
        );
        $loop = new WP_Query( $args1 );
//        echo $loop->request;
        if ( $loop->have_posts() ) :
        echo "<h3>Other courses taught by this tutor</h3>";
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $course_videos = maybe_unserialize($product_meta[video_url]);
        $course_video = maybe_unserialize($course_videos[0]);
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $timezone = get_current_user_timezone();
        $datetime_obj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        global $product;
        $_product = wc_get_product( $loop->post->ID );
        ?>
            <li class="col-md-4 col-xs-6 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" class=" product-title">
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
                                  </button>
								  </h5> 
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
                <span> <strong>No of Classes/hours: </strong><?php echo $no_of_classes;?></span><br/>
                <span><strong>Start Date & Time:</strong><span class="highlight"> <?php if(is_user_logged_in()){
                            $otherTZ  = new DateTimeZone($timezone);
                            $datetime_obj->setTimezone($otherTZ); 
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;
                        }else{
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                            echo $date;  
                            echo '<small class="clearfix">(Login to check session Date & Time in your Timezone)</small>';
                        }?></span></span><br/>
                        
                <span> <strong>Price:</strong> <span class="price"><?php echo get_woocommerce_currency_symbol().$_product->get_price();?></span></span>
                <span class="col-md-offset-3"> <strong>Seats Available: </strong><?php echo $product->get_stock_quantity();?></span>
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

