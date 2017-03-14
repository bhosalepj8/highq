<?php function courses_list_by_category($category, $type){
 ob_start(); 
 $site_url= get_site_url();
  
  
//  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
//  elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
//  else { $paged = 1; }

  $paged = 1;
  $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $category,'paged' => $paged,
      'meta_query' => array(
          'relation' => 'AND',
          array(
              'key' => 'tutoring_type',
              'value' => $type,
              ),
          array(
                'key'   => 'wpcf-course-status',
                'value' =>'Approved',
              ),
          )
        ,'order'=> 'DESC', 'orderby' => 'date');

  
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
<form id="course_filter" name="course_filter" action="" method="POST">
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
        
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time"/>
         </p>
     </div>
    </div>
    
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             from $0<input id="price" type="range" min="0" max="1000" value="" name="price" onchange="pricefilter()"/> to $1000
         </p>
         <p id="result"></p>
     </div>
    </div>
        <input type="hidden" name="category" value="<?php echo $category;?>">
        <input type="hidden" name="type" value="<?php echo $type;?>">
        <!--<input type="hidden" name="paged" id="paged" value="1">-->
    <div class="col-md-2">
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

<ul class="products">
    <?php      
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
        $current_user_meta = get_user_meta($user_id);
        global $product;
        ?>
             <li class="product">    
                 <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <h3><?php echo $product->get_title(); ?></h3>
                 </a>

                        <?php // if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <!--<h3><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></h3>-->
                        <span> Curriculum: <?php echo $product_meta[curriculum][0];?></span><br/>
                        <span> Subject: <?php
                            $subjects = maybe_unserialize($product_meta[subject][0]);
                            if(is_array($subjects)){
                                foreach ($subjects as $key => $value) {
                                    echo $value.",";
                                }
                            }else{
                                echo $subjects;
                            }
                        ?></span><br/>
                        <span> Grade: <?php echo $product_meta[grade][0];?></span><br/>
                        <span> Rating: <?php ;?></span><?php if ( $rating_html = $product->get_rating_html ) : ?>
                                <?php echo $rating_html; ?>
                        <?php endif; ?><br/>
                        <!--<span> Hourly Rate: <?php echo $current_user_meta[hourly_rate][0];?></span><br/>-->
                        <span> Price: <span class="price"><?php $_product = wc_get_product( $loop->post->ID );
                        echo $_product->get_price();
                        ?></span></span><br/>
                        <span> Qualification: <?php 
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
                        ?></span><br/><br/>
                    <?php woocommerce_template_loop_add_to_cart( $post, $product ); ?>
             </li>
            <?php 
            endwhile;
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