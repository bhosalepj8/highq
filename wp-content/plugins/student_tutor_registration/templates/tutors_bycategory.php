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
 $todays_date = date("Y-m-d");
 
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

<form id="tutor_filter" name="tutor_filter" action="" method="GET" autocomplete="on">
    <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
    <div class="course-search">	
    <h5 class="text-center"><?php _e( 'Tutors', 'woocommerce' ); ?> : <?php echo $cat_name;?></h5>
    <input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Tutors&hellip;', 'placeholder', 'woocommerce' ); ?>" name="search" id="search" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" onkeypress="search_tutorsproducts(event)" value="<?php echo isset($_GET['search'])? $_GET['search']: "" ;?>"/>
    </div>
    <h4>Refine Your Search</h4>
    <div class="form-inline filter-box clearfix">
    <div class="col-md-2 col-sm-4 curriculum-select">
     <div class="form-group">
        <p class="field-para">
            <select class="form-control" id="curriculum" name="curriculum">
                <option value="">-Select Curriculum-</option>
                <?php 
                    $arr = explode("|", $Curriculum[0]);
                    foreach ($arr as $value) {
                        $attr = ($_GET['curriculum'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    } 
                ?>
            </select>
        </p>
      </div>
    </div>
    <div class="col-md-2 col-sm-4">
     <div class="form-group">
         <p class="field-para">
             <select class="form-control" id="subject" name="subject">
                <option value="">-Select Subject-</option>
                 <?php 
                    $arr = explode("|", $subjects[0]);
                    foreach ($arr as $value) {
                        $attr = ($_GET['subject'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2 col-sm-4">
     <div class="form-group">
         <p class="field-para">
            <select class="form-control" id="grade" name="grade">
                <option value="">-Select Grade-</option>
                <?php 
                     $arr = explode("|", $Grade[0]);
                    foreach ($arr as $value) {
                        $attr = ($_GET['grade'] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    } 
                ?>
            </select>
         </p>
     </div>
    </div>
        
    <div class="col-md-2 col-sm-4">
     <div class="form-group">
         <p class="field-para">
             <input id="refine_from_date" class="form-control" name="from_date" type="text" placeholder="Date" value="<?php echo isset($_GET['from_date'])? $_GET['from_date']: "" ;?>"/>
         </p>
       </div>
    </div>
      <div class="col-md-1 col-sm-4">
     <div class="form-group">
         <p class="field-para">
             <input id="from_time" class="form-control from_time" name="from_time" type="text" placeholder="Time" value="<?php echo isset($_GET['from_time'])? $_GET['from_time']: "" ;?>" readonly=""/>
         </p>
     </div>
    </div>
    
    <div class="col-md-2 col-sm-4">
     <div class="form-group">
         <p class="field-para range-slider">
             $ <small>0</small> <input class="range-slider__range" id="price" type="range" min="0" max="1000" name="price" onchange="pricefilter()" value="<?php echo ($_GET['price'] > 0)? $_GET['price']: 0 ;?>"/> <small>1000</small>
         	<span class="range-slider__value" id="result">0</span>
         </p>
     </div>
    </div>
        <input type="hidden" name="category" value="<?php echo $category;?>">
        <input type="hidden" name="type" value="<?php echo $type;?>">
    <div class="col-md-1 col-sm-4 submit-box">
     <div class="form-group">
         <p class="field-para">
            <button type="submit" class="btn btn-primary btn-sm" id="btn_search" name="btn_search" value="btn_search">
            <span class="glyphicon glyphicon-menu-ok"></span>
               Search
            </button>
            <a class="btn btn-primary btn-sm" id="btn_reset_fields" onclick="reset_search_form_fields()">RESET</a>
         </p>
     </div>
    </div>

   </div>
</form>

<ul class="products oneonone-results">
    
</ul>
</div>


<?php //if($_GET[s] != "" || $_GET[curriculum] != "" || $_GET[subject] != ""|| $_GET[grade] != "" || $_GET[from_date] != "" || $_GET[from_time] != "" || $_GET[price] > 0){?>
<script type="text/javascript">
    jQuery(document).ready(function (){
        pricefilter();
        get_refined_tutors(<?php echo $_GET[paged];?>);
    });
</script>
<?php 
//}
    return ob_get_clean();
}