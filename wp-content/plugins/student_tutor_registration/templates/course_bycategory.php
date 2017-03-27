<?php function courses_list_by_category($category, $type){
 ob_start(); 
 $site_url= get_site_url();
 //Get All Courses List
 $paged = 1; 
 $posts_per_page = 6;
 $offset = ($paged - 1)*$posts_per_page;
 
//$term = get_term_by( 'id', $category, 'product_cat' );
//$cat_name = $term->name;
 
//   global $wpdb;
////    add_filter( 'posts_where', 'posts_where_statement' );
//     $querystr = "SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.*
//	FROM $wpdb->posts 
//	LEFT JOIN $wpdb->term_relationships 
//	ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) 
//	INNER JOIN $wpdb->postmeta 
//	ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) 
//	INNER JOIN $wpdb->postmeta AS mt1 
//	ON ( $wpdb->posts.ID = mt1.post_id ) 
//	INNER JOIN $wpdb->postmeta AS mt2 
//	ON ( $wpdb->posts.ID = mt2.post_id ) 
//	INNER JOIN $wpdb->postmeta AS mt3 
//	ON ( $wpdb->posts.ID = mt3.post_id ) 
//	INNER JOIN $wpdb->postmeta AS mt4 
//	ON ( $wpdb->posts.ID = mt4.post_id ) 
//	INNER JOIN $wpdb->postmeta AS mt5 
//	ON ( $wpdb->posts.ID = mt5.post_id ) 
//	WHERE 1=1 AND
//	( $wpdb->term_relationships.term_taxonomy_id IN ($category) ) 
//	AND ( ( $wpdb->postmeta.meta_key = 'tutoring_type' AND $wpdb->postmeta.meta_value = '$type') 
//	AND ( mt1.meta_key = 'wpcf-course-status' AND mt1.meta_value = 'Approved' )
//	AND ($wpdb->posts.post_type = 'product')
//	AND ($wpdb->posts.post_status = 'publish'))
//	GROUP BY $wpdb->posts.ID ORDER BY $wpdb->posts.post_date DESC LIMIT $offset, $posts_per_page";
////   
//    $loop = $wpdb->get_results($querystr, OBJECT);
    /* Determine the total of results found to calculate the max_num_pages
     for next_posts_link navigation */
//    $sql_posts_total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
//    $max_num_pages = ceil($sql_posts_total / $posts_per_page);
//    echo $querystr;

     $args = array(
                'post_type' => 'product',
//                's'=> '1on1',
                'post_status' => 'publish',
//                'product_tag' 	 => 'Curriculum 3' ,
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
                ),
                'posts_per_page' => 1,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                add_filter( 'posts_groupby', 'my_posts_groupby' );
                $loop = new WP_Query( $args );

    $tutorpost = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
    $id = $tutorpost->ID;
    $post_meta = get_post_custom($id);
    $Grade = $post_meta[Grade];
    $subjects = $post_meta[subjects];
    $Curriculum = $post_meta[Curriculum];
    
 ?>
<div class="woocommerce">
<div class="loader"></div>
<form id="course_filter" name="course_filter" action="" method="POST" class="filter-box">
    <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
    <div class="course-search">
    <h5 class="text-center"><?php _e( 'Courses', 'woocommerce' ); ?> : <?php echo $category;?></h5>
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Courses&hellip;', 'placeholder', 'woocommerce' ); ?>" name="s" id="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" onkeypress="search_coursesproducts(event)"/>
    </div>
    <h4>Refine Your Search</h4>
    <div class="form-inline clearfix">
    <div class="col-md-2 curriculum-select">
     <div class="form-group">
        <p class="field-para">
            <select class="form-control" id="curriculum" name="curriculum">
                <option value="">-Select Curriculum-</option>
                <?php 
                    $arr = explode("|", $Curriculum[0]);
                    foreach ($arr as $value) {
                        echo '<option value="'.$value.'">'.$value.'</option>';
                    } 
                ?>
            </select>
        </p>
      </div>
    </div>
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             <select class="form-control" id="subject" name="subject">
                <option value="">-Select Subject-</option>
                 <?php 
                    $arr = explode("|", $subjects[0]);
                    foreach ($arr as $value) {
                        echo '<option value="'.$value.'">'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
            <select class="form-control" id="grade" name="grade">
                <option value="">-Select Grade-</option>
                <?php 
                     $arr = explode("|", $Grade[0]);
                    foreach ($arr as $value) {
                        echo '<option value="'.$value.'">'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             <input id="refine_from_date" class="form-control" name="from_date" type="text" placeholder="Date"/>
         </p>
      </div>
      </div>  
       <div class="col-md-1">
       	<div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time"/>
         </p>
     </div>
    </div>
    
    <div class="col-md-2">
     <div class="form-group">
         <!-- <p class="field-para">
             $0<input id="price" type="range" min="0" max="1000" value="" name="price" onchange="pricefilter()"/> $1000
         </p> -->
         
         <p class="field-para range-slider">
             <small>0</small> <input class="range-slider__range" id="price" type="range" min="0" max="1000" value="100" name="price" onchange="pricefilter()"/><small>1000</small>
         	<span class="range-slider__value" id="result">0</span>
         </p>

     </div>
    </div>
        <input type="hidden" name="category" value="<?php echo $category;?>">
        <input type="hidden" name="type" value="<?php echo $type;?>">
        <!--<input type="hidden" name="paged" id="paged" value="1">-->
    <div class="col-md-1">
     <div class="form-group">
         <p class="field-para">
             <button type="button" class="btn btn-primary btn-sm" id="btn_search" name="btn_search" value="btn_search" onclick="get_refined_courses()">
            <span class="glyphicon glyphicon-menu-ok"></span>
               Refine
            </button>
         </p>
     </div>
    </div>
        
    
        
   </div>
</form>
<ul class="products exam-prep-results">
    <?php      
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        $course_videos = maybe_unserialize($product_meta[video_url]);
        $course_video = maybe_unserialize($course_videos[0]);
        global $product;
        ?>
             <li class="col-md-4 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a></h3>

                        <?php // if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <!--<h3><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></h3>-->
                        <span> <strong>Curriculum:</strong> <?php echo $product_meta[curriculum][0];?></span>
                        <br/>
                        <span> <strong>Subject:</strong> <?php
                            $subjects = maybe_unserialize($product_meta[subject][0]);
                            if(is_array($subjects)){
                                foreach ($subjects as $key => $value) {
                                    echo $value.",";
                                }
                            }else{
                                echo $subjects;
                            }
                        ?></span><br/>
                        <span> <strong>Grade:</strong> <?php echo $product_meta[grade][0];?></span><br/>
                        <span> <strong>Rating:</strong> <?php ;?></span><?php if ( $rating_html = $product->get_rating_html ) : ?>
                                <?php echo $rating_html; ?>
                        <?php endif; ?><br/>
                        <!--<span> Hourly Rate: <?php echo $current_user_meta[hourly_rate][0];?></span><br/>-->
                        <span> <strong>Price:</strong> <span class="price"><?php $_product = wc_get_product( $loop->post->ID );
                        echo $_product->get_price();
                        ?></span></span><br/>
                        <span><strong> Qualification:</strong> <?php 
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
                        ?></span>
                        <div>
                            <span class="pull-right"><?php 
                            foreach ($course_video as $key => $value) {
                            if(!empty($value)){
                            ?>
                            <a class='glyphicon glyphicon-facetime-video' onclick='view_tutor_video(<?php echo $loop->post->ID;?>)'></a>
                            <div id="<?php echo $loop->post->ID;?>_video" title="Course Video" class="dialog">
                                <?php echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="580"]');?>
                            </div>
                            <?php }}?></span>
                       
                    <?php // woocommerce_template_loop_add_to_cart( $post, $product ); 
//                    echo $post->ID;
//                    print_r($_product);
                    $from_date = array_values(maybe_unserialize($product_meta[from_date]));
                    $count = count($from_date);
                    ?>
                    <button type="button" class="btn btn-primary btn-sm" id="btn_search" name="btn_viewtutor" value="btn_viewtutor" onclick="get_view_tutor(<?php echo $loop->post->ID;?>)">
                    <span class="glyphicon glyphicon-menu-ok"></span>
                       View Tutor
                    </button>
                    <div id="<?php echo $loop->post->ID;?>" title="<?php echo $product->get_title(); ?>" class="dialog">
                            <div class="tutor-profile"><?php echo get_avatar( $user_id, 96);?></div><br/>
                            <div class="tutor-info"> <h3 class="course-title"><a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($user_id);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></a></h3></div><br/>
                            <span> <strong>Rating:</strong> </span><br/>
                            <span> <strong>Qualification of Tutor:</strong> <?php 
                                    foreach ($tutor_qualification as $key => $value) {
                                            echo $value.",";
                                        }
                                ?></span><br/>
                            <span> <strong>No. of Sessions:</strong> <?php echo $count;?></span><br/>
                            <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                            <p> <?php echo $current_user_meta[tutor_description][0];?></p>
                    </div>
                            
                    </div>
             </li>
             
            <?php 
            endwhile;  
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'tutor');
            }
            ?>
        <?php // else:  ?>
        <!--<p class="error"><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>-->
    <?php endif; ?>
    </ul>

</div>
<?php 
    return ob_get_clean();
}