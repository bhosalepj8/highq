<?php function tutors_list_by_category($category, $type){
 ob_start(); 
 $site_url= get_site_url();
 //Get All Tutors List
 $paged = 1; 
 $posts_per_page = posts_per_page;
 $offset = ($paged - 1)*$posts_per_page;
 $arr_rand = array();
 $term = get_term_by( 'slug', $category, 'product_cat' );
 $cat_name = $term->name;
 
 
     $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
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
                'posts_per_page' => $posts_per_page,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                add_filter( 'posts_groupby', 'my_posts_groupby' );
                $loop = new WP_Query( $args );
//    echo $loop->request;
    $tutorpost = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
    $id = $tutorpost->ID;
    $post_meta = get_post_custom($id);
    $Grade = $post_meta[Grade];
    $subjects = $post_meta[subjects];
    $Curriculum = $post_meta[Curriculum];
 ?>
<div class="woocommerce">
<div class="loader"></div>

<form id="tutor_filter" name="tutor_filter" action="" method="POST" autocomplete="on">
    <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
    <div class="course-search">	
    <h5 class="text-center"><?php _e( 'Tutors', 'woocommerce' ); ?> : <?php echo $cat_name;?></h5>
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Tutors&hellip;', 'placeholder', 'woocommerce' ); ?>" name="s" id="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" onkeypress="search_tutorsproducts(event)" value="<?php echo isset($_SESSION['tutor_search']['s'])? $_SESSION['tutor_search']['s']: "" ;?>"/>
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
                        $attr = ($_SESSION['tutor_search']['curriculum'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
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
                        $attr = ($_SESSION['tutor_search']['subject'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
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
                        $attr = ($_SESSION['tutor_search']['grade'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             <input id="refine_from_date" class="form-control" name="from_date" type="text" placeholder="Date" value="<?php echo isset($_SESSION['tutor_search']['from_date'])? $_SESSION['tutor_search']['from_date']: "" ;?>"/>
         </p>
       </div>
    </div>
      <div class="col-md-1">
     <div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time" value="<?php echo isset($_SESSION['tutor_search']['from_time'])? $_SESSION['tutor_search']['from_time']: "" ;?>"/>
         </p>
     </div>
    </div>
    
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para range-slider">
             $ <small>0</small> <input class="range-slider__range" id="price" type="range" min="0" max="1000" name="price" onchange="pricefilter()" value="<?php echo isset($_SESSION['tutor_search']['price'])? $_SESSION['tutor_search']['price']: "" ;?>"/> <small>1000</small>
         	<span class="range-slider__value" id="result">0</span>
         </p>
     </div>
    </div>
        <input type="hidden" name="category" value="<?php echo $category;?>">
        <input type="hidden" name="type" value="<?php echo $type;?>">
    <div class="col-md-1">
     <div class="form-group">
         <p class="field-para">
             <button type="button" class="btn btn-primary btn-sm" id="btn_search" name="btn_search" value="btn_search" onclick="get_refined_tutors()">
            <span class="glyphicon glyphicon-menu-ok"></span>
               Search
            </button>
         </p>
     </div>
    </div>

   </div>
</form>

<ul class="products oneonone-results">
    <?php      
        if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post(); 
        $product_meta = get_post_meta($loop->post->ID);
        $user_id = $product_meta[id_of_tutor][0];
//        echo $user_id;
        $current_user_meta = get_user_meta($user_id);
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $timearr = maybe_unserialize($product_meta[from_time][0]);
        $tutor_video = $current_user_meta[tutor_video_url][0];
//        echo $tutor_video;die;
        
        ?>
             <li class="col-md-4 result-box">    
                        <div class="tutor-profile"><?php echo get_avatar( $user_id, 96);?></div>
                        <div class="tutor-info"> <h3 class="course-title"><a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($user_id);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></a></h3>
                        <span><strong> Qualification:</strong> <?php 
                        $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
                        foreach ($tutor_qualification as $key => $value) {
                            echo $value.", ";
                        }
                        ?></span><br/>
                        <span><strong><?php echo $product_meta[curriculum][0]." | ".$subjects." | ".$product_meta[grade][0];?></strong></span><br/>
                        <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                        <span> <strong>Country:</strong> <?php 
                        $Country_code  = isset($current_user_meta[billing_country][0]) ? $current_user_meta[billing_country][0] : "";
                        echo WC()->countries->countries[ $Country_code ];
                        ?></span>
                       <div>
                        <span class="pull-right">
                            <a class='glyphicon glyphicon-facetime-video' onclick='view_tutor_video(<?php echo $loop->post->ID;?>)'></a>
                            <div id="<?php echo $loop->post->ID;?>_video" title="Tutor Video" class="dialog">
                                <?php echo do_shortcode('[videojs_video url="'.$tutor_video.'" webm="'.$tutor_video.'" ogv="'.$tutor_video.'" width="580"]');?>
                            </div>
                        </span>
                     <?php // woocommerce_template_loop_add_to_cart( $post, $product ); ?>
                     </div>
                     </div>
             </li>
            <?php
            endwhile;  
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_tutor');
            }
        ?>
    <?php endif; ?>
    </ul>
</div>
<?php 
    return ob_get_clean();
}

if($_SESSION[tutor_search][s] != "" || $_SESSION[tutor_search][curriculum] != "" || $_SESSION[tutor_search][subject] != ""|| $_SESSION[tutor_search][grade] != "" || $_SESSION[tutor_search][from_date] != "" || $_SESSION[tutor_search][from_time] != "" || $_SESSION[tutor_search][price] > 0){?>
<script type="text/javascript">
    jQuery(document).ready(function (){
        pricefilter();
        get_refined_tutors(<?php echo $_SESSION[tutor_search][paged];?>);
    });
</script>
<?php }?>