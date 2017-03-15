<?php function courses_list_by_category($category, $type){
 ob_start(); 
 $site_url= get_site_url();
 //Get All Courses List
 $paged = 1; 
 $posts_per_page = 6;
 $offset = ($paged - 1)*$post_per_page;
 
   global $wpdb;
//    add_filter( 'posts_where', 'posts_where_statement' );
     $querystr = "SELECT $wpdb->posts.*
	FROM $wpdb->posts 
	LEFT JOIN $wpdb->term_relationships 
	ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) 
	INNER JOIN $wpdb->postmeta 
	ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) 
	INNER JOIN $wpdb->postmeta AS mt1 
	ON ( $wpdb->posts.ID = mt1.post_id ) 
	INNER JOIN $wpdb->postmeta AS mt2 
	ON ( $wpdb->posts.ID = mt2.post_id ) 
	INNER JOIN $wpdb->postmeta AS mt3 
	ON ( $wpdb->posts.ID = mt3.post_id ) 
	INNER JOIN $wpdb->postmeta AS mt4 
	ON ( $wpdb->posts.ID = mt4.post_id ) 
	INNER JOIN $wpdb->postmeta AS mt5 
	ON ( $wpdb->posts.ID = mt5.post_id ) 
	WHERE 1=1 AND
	( $wpdb->term_relationships.term_taxonomy_id IN ($category) ) 
	AND ( ( $wpdb->postmeta.meta_key = 'tutoring_type' AND $wpdb->postmeta.meta_value = '$type') 
	AND ( mt1.meta_key = 'wpcf-course-status' AND mt1.meta_value = 'Approved' )
	AND ($wpdb->posts.post_type = 'product')
	AND ($wpdb->posts.post_status = 'publish'))
	GROUP BY $wpdb->posts.ID ORDER BY $wpdb->posts.post_date DESC LIMIT $offset, $posts_per_page";
  
    $loop = $wpdb->get_results($querystr, OBJECT);
//    echo $querystr;
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
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" name="s" id="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" onkeypress="search_coursesproducts(event)"/>
    
    <h4>Refine Your Search</h4>
    <div class="form-inline clearfix">
    <div class="col-md-2">
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
        
    <div class="col-md-1">
     <div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time"/>
         </p>
     </div>
    </div>
    
    <div class="col-md-4">
     <div class="form-group">
         <!-- <p class="field-para">
             $0<input id="price" type="range" min="0" max="1000" value="" name="price" onchange="pricefilter()"/> $1000
         </p> -->
         
         <p class="field-para range-slider">
             <input class="range-slider__range" id="price" type="range" min="0" max="1000" value="100" name="price" onchange="pricefilter()"/>
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
        if ($loop) :
        global $post;
        foreach ($loop as $post): 
        setup_postdata($post); 
        $product_meta = get_post_meta($post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        global $product;
        ?>
             <li class="col-md-4">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $post->post_title : $post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a></h3>

                        <?php // if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <!--<h3><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></h3>-->
                        <span> <strong>Curriculum:</strong> <?php echo $product_meta[curriculum][0];?></span><br/>
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
                        <span> <strong>Price:</strong> <span class="price"><?php $_product = wc_get_product( $post->ID );
                        echo $_product->get_price();
                        ?></span></span><br/>
                        <span><strong> Qualification:</strong> <?php 
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
                        ?></span><br/><br/>
                    <?php woocommerce_template_loop_add_to_cart( $post, $product ); ?>
             </li>
            <?php 
            endforeach;
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'course');
            }
            ?>
        <?php else:  ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
    </ul>

</div>
<?php 
    return ob_get_clean();
}