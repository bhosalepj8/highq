<?php function myaccount_tutor_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 $Grade = '';
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
            
            
            $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
            $id = $post->ID;
            $post_meta = get_post_custom($id);
            $Grade = $post_meta[Grade];
            $subjects = $post_meta[subjects];
            $Curriculum = $post_meta[Curriculum];
            $args = array(
                'number'     => $number,
                'orderby'    => 'slug',
                'hide_empty' => $hide_empty,
                'include'    => $ids,
                'order'      => 'ASC' // not required because it's the default value
            );
            $taxanomy = array('product_cat');
            $product_categories = get_terms( $taxanomy , $args );
//            print_r($product_categories);
            $args1 = array(
			'post_type' => 'product',
                        'meta_key'   => 'wpcf-course-status',
                        'meta_value' =>'Approved',
			);
            function search_distinct() {
                    return "DISTINCT";
            }
            add_filter('posts_distinct', 'search_distinct');
		$products = new WP_Query( $args1 );
//                echo "<pre>";
//                print_r($products);
        }
//        print_r(get_woocommerce_currencies());
 ?>

<section class="clearfix">
    <article>
        <form class="form-inline" name="tutor_myaccount" id="tutor_myaccount" enctype="multipart/form-data" action="" method="post" >
                <div class="box-one">
                          <div class="box-heading">
                            <h4>New Course</h4>
                          </div>
                          <div class="filling-form">        
                                <div>
                                    <div class="clearfix">
                                        <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Title</label>
                                            <p class="field-para">
                                                <select class="form-control" id="course_title" name="course_title" onchange="show_course_title()">
                                                <option value="">-Select Course-</option>
                                                <?php $arr = array();
                                                while ( $products->have_posts() ) {
                                                $products->the_post();
                                                if(!in_array(get_the_title(), $arr)){
                                                ?>
                                                    <option value="<?php the_title(); ?>">
                                                            <?php the_title(); ?>
                                                    </option>
                                                <?php $arr[] = get_the_title();
                                                }}
                                                ?>
                                                    <option value="add_new"> Add New</option>
                                            </select>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="new_course_titlediv" style="display: none;">
                                                <label for="exampleInputName2">New Course Title</label>
                                                <p class="field-para"><input type="text" id="new_course_title" name="new_course_title"/></p>
                                            </div>
                                        </div>          
                                        
                                    </div>
                                    <div class="clearfix">
                                    <div class="col-md-8 mar-top-10 email-box">
                                     <div class="form-group">
                                        <label for="exampleInputName2">Course Detail</label>
                                        
                                        <textarea class="form-control" id="course_detail" name="course_detail" placeholder="Course Detail" >
                                            <?php // the_excerpt();?>
                                        </textarea>
                                      </div>
                                    </div>
                                   </div>
                                    
                                    <div class="clearfix">
                                        <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Vertical<span style="color:red;">*</span></label>
                                            <p class="field-para">
                                                <select class="form-control" id="course_cat" name="course_cat">
                                                    <?php foreach ( $product_categories as $product_category ) {
                                                        if($product_category->taxonomy == 'product_cat')
                                                        echo '<option value="'.$product_category->slug.'" >'.$product_category->name.'</option>';
                                                     }?>
                                                </select>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Subject<span style="color:red;">*</span></label>
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
                                        <div class="col-md-4 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Curriculum<span style="color:red;">*</span></label>
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
                                    </div>
                                    
                                    <div class="clearfix">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Grade<span style="color:red;">*</span></label>
                                            <p class="field-para">
                                            <select class="form-control" id="grade" name="grade">
                                                <option value="">-Select Grade-</option>
                                                <?php 
                                                     $arr = explode("|", $Grade[0]);
//                                                     print_r($arr);
                                                    foreach ($arr as $value) {
                                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                                    } 
                                                ?>
                                            </select>
                                            </p>
                                          </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">No of Student<span style="color:red;">*</span></label>
                                            <p class="field-para">
                                            <select class="form-control" id="no_of_student" name="no_of_student">
                                                <option value="">-Select-</option>
                                                <option value="1" >1</option>
                                                <option value="2">2</option>
                                            </select>
                                            </p>
                                          </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix">
                                        <div class="col-md-8 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Video<span style="color:red;">*</span></label>
                                            <p class="field-para">
                                                <input type="file" name="course_video" id="course_video"/>
                                                <img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader2" name="img-loader2" style="display: none;" class="loader-gif"/>
                                            </p>
                                          </div>
                                        <div id="upload_video_div"></div>
                                        </div>
                                    </div>
                                <div id="div_material">    
                                    <input id="material_count" name="material_count" type="hidden" value="1" />
                                    <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                                    <div id="course_material_div_1" class="clearfix">
                                    <div class="clearfix">
                                        <div class="col-md-8">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Material<span style="color:red;">*</span></label>
                                            <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                                            <p class="field-para">
                                                <input type="file" name="course_material_1[]" id="course_material_1" onchange="upload_course_material(1)"/>
                                            </p>
                                            <div id='documents_display_div_1'></div>
                                          </div>
                                        </div>
                                        <span id="course_action_1" class="add-more">
                                            <a href="javascript:void(0);" onclick="addCourseBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                        </span>
                                    </div>
                                    </div>
                                </div>
                                    
                                    <div id="div_date_time">    
                                    <input id="date_time_count" name="date_time_count" type="hidden" value="1" />
                                    <div class='error' id="spantime_error" style="display: none;">Please fill below fields first</div>
                                    <div id="date_time_div_1" class="form-inline clearfix">
                                        <div class="col-md-8">
                                            <div class="form-group"><label for="exampleInputName2">Date & Time<span style="color: red;">*</span></label>
                                                <p class="field-para"><input id="from_date_1" class="form-control from_date" name="from_date[]" type="text" placeholder="Date"/>
                                                    <input id="from_time_1" class="form-control from_time" name="from_time[]" type="text" placeholder="Time"/>
                                             </p>
                                            </div>
                                        </div>
<!--                                        <div class="col-md-4">
                                            <div class="form-group">-->
<!--                                                <label for="exampleInputName2">Days Of Week<span style="color: red;">*</span></label>
                                                <p class="field-para">
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="sunday"> Sunday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="monday"> Monday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="tuesday"> Tuesday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="wednesday"> Wednesday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="thursday"> Thursday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="friday"> Friday<br/>
                                                    <input type="checkbox" id="days_of_week" name="days_of_week[]" value="saturday"> Saturday<br/>
                                                </p>-->
<!--                                            </div>
                                        </div>-->
                                        <span id="date_time_action_1" class="add-more">
                                            <a href="javascript:void(0);" onclick="addDateTimeBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                        </span>
                                    </div>
                                    </div>
<!--                                    <div class="form-inline clearfix">
                                        <div class="col-md-8">
                                            <p class="field-para">
                                                <input type="checkbox" id="repeat_session" name="repeat_session" value="repeat_session"> Repeat Session
                                                <input type="radio" id="rd_endafter" name="rd_endafter" value="rd_endafter"> End After
                                                <select class="form-control" id="no_of_sessions" name="no_of_sessions">
                                                    <option value="">-Select-</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select> Sessions
                                            </p>
                                        </div>
                                        <div class="col-md-8">
                                            <p class="field-para">
                                                <input type="radio" id="rd_endby" name="rd_endby" value="rd_endby"> End By
                                                <input id="end_date" class="form-control" name="end_date" type="text"/>
                                            </p>
                                        </div>
                                    </div>-->
                                    
                                </div>
                                <div class="text-right mar-top-bottom-10">
                                    <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                                    <input type="hidden" name="tutor-account-nonce" id="tutor-account-nonce" value="<?php echo wp_create_nonce('tutor-account-nonce'); ?>"/>
                                    <input type="hidden" name="tutoring_type" id="tutoring_type" value="Course">
                                    <button type="submit" class="btn btn-primary btn-sm" id="btn_addsession" name="btn_addsession" value="add_session">
                                    <span class="glyphicon glyphicon-menu-ok"></span>
                                        Add Session
                                    </button>
                                </div>
                            </div>
                </div>
        </form>
        </article>
</section>

<?php 
return ob_get_clean();
}
