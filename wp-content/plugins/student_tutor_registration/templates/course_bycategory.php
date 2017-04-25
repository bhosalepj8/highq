<?php function courses_list_by_category($category, $type){
 ob_start(); 
 $site_url= get_site_url();
 //Get All Courses List
 $paged = 1; 
 $posts_per_page = posts_per_page;
 $offset = ($paged - 1)*$posts_per_page;
 $todays_date = date("Y-m-d");
$term = get_term_by( 'slug', $category, 'product_cat' );
$cat_name = $term->name;
//print_r($cat_name);
//    print_r($_SESSION);
//    session_unset();
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
                        array(
                                'key'     => 'from_date',
                                'value'   => $todays_date,
                                'compare'   => '>=',
                                'type'      => 'DATE'
                        ),
                ),
                'posts_per_page' => $posts_per_page,'paged' => $paged,'orderby' => 'from_date','order'   => 'ASC');
                $loop = new WP_Query( $args );
//                echo $loop->request;
    $tutorpost = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
    $id = $tutorpost->ID;
    $post_meta = get_post_custom($id);
    $Grade = $post_meta[Grade];
    $subjects = $post_meta[subjects];
    $Curriculum = $post_meta[Curriculum];

    //Get Logged in user timezone
    $timezone = get_current_user_timezone();
 ?>
<div class="woocommerce">
<div class="loader"></div>
<form id="course_filter" name="course_filter" action="" method="GET" class="filter-box">
    <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
    <div class="course-search">
    <h5 class="text-center"><?php _e( 'Courses', 'woocommerce' ); ?> : <?php echo $cat_name;?></h5>
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Courses&hellip;', 'placeholder', 'woocommerce' ); ?>" name="s" id="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" onkeypress="search_coursesproducts(event)" value="<?php echo isset($_SESSION['course_search']['s'])? $_SESSION['course_search']['s']: "" ;?>"/>
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
                        $attr = ($_SESSION['course_search']['curriculum'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'"'.$attr.'>'.$value.'</option>';
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
                        $attr = ($_SESSION['course_search']['subject'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'"'.$attr.'>'.$value.'</option>';
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
                        $attr = ($_SESSION['course_search']['grade'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'"'.$attr.'>'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2">
     <div class="form-group">
         <p class="field-para">
             <input id="refine_from_date" class="form-control" name="from_date" type="text" placeholder="Date" value="<?php echo isset($_SESSION['course_search']['from_date'])? $_SESSION['course_search']['from_date']: "" ;?>"/>
         </p>
      </div>
      </div>  
       <div class="col-md-1">
       	<div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time" value="<?php echo isset($_SESSION['course_search']['from_time'])? $_SESSION['course_search']['from_time']: "" ;?>"/>
         </p>
     </div>
    </div>
    
    <div class="col-md-2">
     <div class="form-group">
          <p class="field-para range-slider">
             $ <small>0</small> <input class="range-slider__range" id="price" type="range" min="0" max="1000" name="price" onchange="pricefilter()" value="<?php echo ($_SESSION['course_search']['price'] > 0)? $_SESSION['course_search']['price']: 0 ;?>"/><small>1000</small>
         	<span class="range-slider__value" id="result">0</span>
         </p>

     </div>
    </div>
        <input type="hidden" name="category" value="<?php echo $category;?>">
        <input type="hidden" name="type" value="<?php echo $type;?>">
    <div class="col-md-1">
     <div class="form-group">
         <p class="field-para">
             <button type="button" class="btn btn-primary btn-sm" id="btn_search" name="btn_search" value="btn_search" onclick="get_refined_courses()">
            <span class="glyphicon glyphicon-menu-ok"></span>
               Search
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
        $subjects = maybe_unserialize($product_meta[subject][0]);
        $course_videos = maybe_unserialize($product_meta[video_url]);
        $course_video = maybe_unserialize($course_videos[0]);
        $from_date = array_values(maybe_unserialize($product_meta[from_date]));
        $from_time = array_values(maybe_unserialize($product_meta[from_time]));
        $no_of_classes = count($from_date);
        $format = "Y-m-d H:i";
        $datetime_obj = DateTime::createFromFormat($format, $from_date[0]." ".$from_time[0],new DateTimeZone('UTC'));
        global $product;
        
        ?>
             <li class="col-md-4 result-box">    
                 <h3 class="course-title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                     <?php echo $product->get_title(); ?>
                 </a>
                 <span class="pull-right"><?php 
                            foreach ($course_video as $key => $value) {
                            if(!empty($value)){
                            ?>
                            <a class='glyphicon glyphicon-facetime-video' onclick='view_tutor_video(<?php echo $loop->post->ID;?>)'></a>
                            <div id="<?php echo $loop->post->ID;?>_video" title="Course Video" class="dialog">
                                <?php echo do_shortcode('[videojs_video url="'.$value.'" webm="'.$value.'" ogv="'.$value.'" width="580"]');?>
                            </div>
                            <?php }}?></span>
                 
                 </h3>
                        <span><strong><?php echo $product_meta[curriculum][0]." | ".$subjects." | ".$product_meta[grade][0];?></strong></span><br/>
                        <span> <strong>No of Classes/hours:</strong> <?php echo $no_of_classes;?></span><br/>
                        <span><strong>Start Date & Time:</strong>
                        <span class="highlight"><?php if(is_user_logged_in()){
                            $datetime_obj->setTimezone(new DateTimeZone($timezone)); 
                            $date = $datetime_obj->format('d/m/Y h:i A T');
                         echo $date."<br/>";
                        }else{$date = $datetime_obj->format('d/m/Y h:i A T');
                         echo $date."<br/>";   
                         echo '<small class="clearfix">(Login to check session Date & Time in your Timezone)</small>';
                        }?></span>
                        </span>
                        
                        <span><strong>Taught online by:</strong> <a onclick="get_view_tutor(<?php echo $loop->post->ID;?>)" class="highlight"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></a> </span><br/>
                        <span> <strong>Price:</strong> <span class="price"> <?php $_product = wc_get_product( $loop->post->ID );
                        echo $_product->get_price();
                        ?></span></span>
                        <span class="col-md-offset-4"> <strong>Seats Available:</strong> <?php echo $product->get_stock_quantity();?></span>

                    
                    <div id="<?php echo $loop->post->ID;?>" title="<?php echo $product->get_title(); ?>" class="dialog profile-inshort">
                            <div class="tutor-profile col-md-3"><?php echo get_avatar( $user_id, 96);?></div>
                            <div class="tutor-info col-md-9"> 
                            	<h3 class="course-title"><a href="<?php echo get_permalink( get_page_by_path( 'tutors/tutor-public-profile' ) ). "?".base64_encode($user_id);?>" title="<?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?>"><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0]; ?></a></h3>
                            
                            <span> <strong>Rating:</strong> </span><br/>
                            <span> <strong>Qualification of Tutor:</strong> <?php 
                                    foreach ($tutor_qualification as $key => $value) {
                                            echo $value.",";
                                        }
                                ?></span><br/>
                            <span> <strong>No. of Sessions:</strong> <?php echo $no_of_classes;?></span><br/>
                            <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                            <p> <?php echo $current_user_meta[tutor_description][0];?></p>
                    </div><br/>
                    </div>
                  <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
             </li>
             
            <?php 
            endwhile;  
            if (function_exists("pagination")) {
                pagination($loop->max_num_pages,4,$paged,'get_next_page_course');
            }
            ?>
    <?php endif; ?>
    </ul>

</div>
<?php 
    return ob_get_clean();
    
}

if($_SESSION[course_search][s] != "" || $_SESSION[course_search][curriculum] != "" || $_SESSION[course_search][subject] != ""|| $_SESSION[course_search][grade] != "" || $_SESSION[course_search][from_date] != "" || $_SESSION[course_search][from_time] != "" || $_SESSION[course_search][price] > 0){?>
<script type="text/javascript">
    jQuery(document).ready(function (){
        pricefilter();
        get_refined_courses(<?php echo $_SESSION[course_search][paged];?>);
    });
</script>
<?php }?>