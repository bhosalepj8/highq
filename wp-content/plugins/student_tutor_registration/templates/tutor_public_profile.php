<?php function tutor_public_profile_page($user_id){
 ob_start(); 
 $site_url= get_site_url();
 $user_id = base64_decode($user_id);
 
 $current_user_meta = get_user_meta($user_id);
// print_r($current_user_meta);
 $tutor_profile_pic = maybe_unserialize($current_user_meta[basic_user_avatar][0]);
 $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
 $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])) : "";
 $hourly_rate = $current_user_meta[hourly_rate][0];
 $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
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
	),
        'orderby' => 'from_date',
	'order'   => 'ASC',
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args );
//print_r($query->request);
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
   ?>
 <div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php _e('Tutor Profile');?></h3>
<section class="clearfix">
    <div class="tutor-registration">
    <article>
        <div class="box-one">
            <div class="filling-form">
                <div class="form-inline clearfix">
                    <div class="col-md-2">
                        <p class="field-para">
                            <img src="<?php echo $tutor_profile_pic[96];?>">
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
                                foreach ($subarr as $key => $value) {
                                    echo $value.",";
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
        </div>
        <div class="box-one">
            
            <div class="box-heading">
                    <h4>1 On 1 Tutor Availability</h4>
                    <span class="">
                            <h4>Price/Session: <?php echo "$".$current_user_meta[hourly_rate][0];?></h4>
                    </span>
            </div>
            
            <div class="filling-form">
                <form id="tbl_availability" name="tbl_availability" action="" method="post">
                <div class="form-group form-inline clearfix">
                    <label>View Availability</label>
                    <p class="field-para">
                        From <input id="from_date" class="form-control from_date" name="from_date" type="text" onchange="" placeholder="Select From Date">
                        <span class="glyphicon glyphicon-calendar"></span> 
                        To <input id="to_date" class="form-control from_date" name="to_date" type="text" onchange="" placeholder="Select To Date">
                    </p>
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
                    <span class="pull-right submit-history">
                        <button type="button" class="btn btn-primary btn-sm" onclick="get_tutor_availability()">
                            <span class="glyphicon glyphicon-menu-ok"></span>
                            Submit</button>
                    </span>
                    </div>
                </form>
                <div class="form-inline clearfix">
                    <p class="field-para">
                       
                        <select id="subject" name="subject">
                            <option value="">Select Subject</option>
                            <?php foreach ($subarr as $key => $value) {
                                         echo '<option value="'.$value.'">'.$value.'</option>';
                                     }?>
                        </select>
                    </p>
                    <div id="sessions_listing">
                        <?php if ( $the_query->have_posts() ) : ?>
                                <!-- the loop -->
                                <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                                 $product_meta = get_post_meta($the_query->post->ID);
                                 global $product;
                                 $subarr[]= $product_meta [subject][0];
                             ?>
                                
                                 <p class="field-para">
                                    Session Date: <?php echo $product_meta[from_date][0];?>   Time:<?php echo $product_meta[from_time][0];?><br/>
                                </p>
                                <?php woocommerce_template_loop_add_to_cart( $the_query->post, $product ); ?>
                                <br/>
                                <?php endwhile; ?>
                                <!-- end of the loop -->
                                <?php wp_reset_postdata(); ?>
                        <?php else : ?>
                                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </article>
 </div>
</section>
 </div>
 
 <?php 
    
    return ob_get_clean();
}

