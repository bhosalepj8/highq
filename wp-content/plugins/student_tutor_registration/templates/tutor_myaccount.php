<?php function myaccount_tutor_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 $Grade = '';
 if ( is_user_logged_in() ) {  
            $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
            $id = $post->ID;
            $post_meta = get_post_custom($id);
            $Grade = $post_meta[Grade];
            $subjects = $post_meta[subjects];
            $Curriculum = $post_meta[Curriculum];
            $no_of_student = $post_meta[no_of_student];
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

                            ),
			);
                add_filter( 'posts_groupby', 'course_groupby' );
		$products = new WP_Query( $args1 );
                }
 ?>
 <div class="woocommerce">
<div class="loader"></div>
<section class="clearfix">
	<div class="tutor-registration">
            	<div class="one-on-tutoring">
                    <ul class="nav nav-tabs" role="tablist" id="course_types">
                        <li role="presentation" class="active"><a href="#new-course" aria-controls="home" role="tab" data-toggle="tab" id="course">New Course</a></li>
                        <li role="presentation"><a href="#one-on-tutor" aria-controls="profile" role="tab" data-toggle="tab" id="10n1">1 on 1 Tutoring</a></li>
                     </ul>
                     
         <div class="tab-content">
             <div role="tabpanel" class="tab-pane fade active in" id="new-course">
                 <form class="form-inline" name="tutor_myaccount" id="tutor_myaccount" enctype="multipart/form-data" action="" method="post" >
                    <div class="new-course-form">
                    <div class="box-one">
                              <div class="box-heading">
                              </div>
                              <div class="filling-form">        
                                    <div>
                                        <div class="form-inline clearfix">
                                            <div class="col-md-6 new-course-title">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Course Title<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                    <select class="form-control" id="course_title" name="course_title" onchange="show_course_title()">
                                                    <option value="">-Select Course-</option>
                                                    <?php // $arr = array();
                                                    while ( $products->have_posts() ) {
                                                    $products->the_post();
                                                    ?>
                                                        <option value="<?php the_title(); ?>">
                                                                <?php the_title(); ?>
                                                        </option>
                                                    <?php }
                                                    ?>
                                                        <option value="add_new"> Add New</option>
                                                </select>
                                                </p>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" id="new_course_titlediv" style="display: none;">
                                                    <label for="exampleInputName2">New Course Title<span style="color:red;">*</span></label>
                                                    <p class="field-para"><input type="text" id="new_course_title" name="new_course_title"/></p>
                                                    <br/>(New Course added will require Admin approval.)
                                                </div>
                                            </div>          

                                        </div>
                                        <div class="form-inline clearfix">
                                        <div class="col-md-8 course-details">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Detail<span style="color:red;">*</span></label>
                                            <p class="field-para"><textarea class="form-control" id="course_detail" name="course_detail" placeholder="Course Detail" ></textarea></p>
                                          </div>
                                        </div>
                                       </div>

                                        <div class="form-inline clearfix">
                                            <div class="col-md-4 vertical">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Vertical<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                    <select class="form-control" id="course_cat" name="course_cat">
                                                        <option value="">-Course Type-</option>
                                                        <?php foreach ( $product_categories as $product_category ) {
                                                            if($product_category->taxonomy == 'product_cat' && ($product_category->slug == "academic-course" || $product_category->slug == "nutritional-courses" ||$product_category->slug == "self-study" ||$product_category->slug == "success-coaching"))
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
                                            
                                            <div class="col-md-4">
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
                                            <div class="form-inline clearfix">   
                                            <div class="col-md-4">
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
                                        
                                            <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="exampleInputName2">No of Student<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                <select class="form-control" id="no_of_student" name="no_of_student">
                                                    <option value="">-Select-</option>
                                                     <?php 
                                                        $arr = explode("|", $no_of_student[0]);
                                                        for($i=$arr[0];$i<=$arr[1];$i++) {
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        } 
                                                    ?>
                                                </select>
                                                </p>
                                              </div>
                                            </div>
                                        </div>

                                        <div class="form-inline clearfix">
                                            <div class="col-md-8 upload-course">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Course Video</label>
                                                <p class="field-para">
                                                    <input type="file" name="course_video" id="course_video" onchange="upload_video('course_video','tutor_myaccount')"/>
                                                    <!--<img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader2" name="img-loader2" style="display: none;" class="loader-gif"/>-->
                                                    (Supported File Formats: mp4|ogv|webm|mov|wmv)
                                                </p>
                                              </div>
                                            <div id="upload_video_div"></div>
                                            </div>
                                        </div>
                                    <div id="div_material" class="form-inline clearfix">    
                                        <input id="material_count" name="material_count" type="hidden" value="1" />
                                        <div class='error' id="course_span_error" style="display: none;">Please fill below fields first</div>
                                        (Supported File Formats: docx|rtf|doc|pdf)
                                        <div id="documents_div_1" class="clearfix">
                                        <div class="clearfix">
                                            <div class="col-md-8 upload-course">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Course Material</label>
                                                <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                                                <p class="field-para">
                                                    <input type="file" name="documents_1" id="documents_1" onchange="upload_files(tutor_myaccount,1)"/>
                                                </p>
                                                <div id='documents_display_div_1' class="add-more-data"></div>
                                                <!--<img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader1" name="img-loader1" style="display: none;" class="loader-gif"/>-->
                                              </div>
                                               <span id="course_action_1" class="add-more">
                                                <a href="javascript:void(0);" onclick="addCourseBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </a>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                        <div id="div_date_time" class="form-inline clearfix">    
                                        <input id="date_time_count" name="date_time_count" type="hidden" value="1" />
                                        <div class='error' id="spantime_error" style="display: none;">Please fill below fields first</div>
                                        <div class='error' id="date_spantime_error"></div>
                                        <div id="date_time_div_1">
                                            <div class="col-md-12 date-time">
                                                <div class="form-group"><label for="exampleInputName2">Date , Time & Session Topic<span style="color:red;">*</span></label>
                                                    <p class="field-para date-time"><input id="from_date_1" class="form-control from_date" name="from_date[]" type="text" placeholder="Date"/>
                                                        <!--<span class="glyphicon glyphicon-calendar"></span>-->
                                                        <input id="from_time_1" class="form-control from_time" name="from_time[]" type="text" placeholder="Time"/>
                                                        <input type="text" id="session_topic_1" name="session_topic[]" class="session_topic form-control" placeholder="Session Topic"/>
                                                    </p>
                                                </div>
                                                <span id="date_time_action_1" class="add-more">
                                                <a href="javascript:void(0);" onclick="addDateTimeBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </a>
                                            </span>
                                            </div>
                                        </div>
                                        </div>                                
                                    </div>
                                    <div class="text-left mar-top-bottom-10 add-session">
                                        <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                                        <input type="hidden" name="tutor-account-nonce" id="tutor-account-nonce" value="<?php echo wp_create_nonce('tutor-account-nonce'); ?>"/>
                                        <input type="hidden" name="tutoring_type" id="tutoring_type" value="Course">
                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
                                        <input type="hidden" name="edit_mode" id="edit_mode" value="0"/>
                                        <input type="hidden" name="product_id" id="product_id" value=""/>
                                        <button type="submit" class="btn btn-primary btn-sm" id="btn_addsession" name="btn_addsession" value="add_session">
                                        <span class="glyphicon glyphicon-menu-ok"></span>
                                            Add Session
                                        </button>
                                    </div>
                                </div>
                    </div>
                    </div>
            </form>
         </div>
             
          <div role="tabpanel" class="tab-pane fade" id="one-on-tutor">
            <form class="form-inline" name="tutor_myaccount_1on1" id="tutor_myaccount_1on1" enctype="multipart/form-data" action="" method="post" >
                    <div class="one-on-form">
                 <div class="box-one clearfix">
                <div class="form-inline clearfix">
                <div class="col-md-4">
                    <div class="form-group">
                            <label>Vertical<span style="color:red;">*</span></label>
                        <p class="field-para">
                            <select class="form-control" id="cat_1on1" name="cat_1on1">
                                <option value="">-Course Type-</option>
                                <?php foreach ( $product_categories as $product_category ) {
                                    if($product_category->taxonomy == 'product_cat' && ($product_category->slug == "academic-course" || $product_category->slug == "nutritional-courses" ||$product_category->slug == "self-study" ||$product_category->slug == "success-coaching"))
                                    echo '<option value="'.$product_category->slug.'" >'.$product_category->name.'</option>';
                                 }?>
                            </select>
                        </p>
                    </div>
                    </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label>Curriculum<span style="color:red;">*</span></label>
                        <p class="field-para">
                            <select class="form-control" id="curriculum_1on1" name="curriculum_1on1">
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
                <div class="col-md-4">
                    <div class="form-group">
                            <label>Grade<span style="color:red;">*</span></label>
                        <p class="field-para">
                        <select class="form-control" id="grade_1on1" name="grade_1on1">
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
                 </div>
                 </div>
                        
                <div class="box-one clearfix" id="sunject_1on1_div">
                 <input id="subject_count" name="subject_count" type="hidden" value="1" />
                <div class='error' id="spansubject_error" style="display: none;">Please fill below fields first</div>
                 
                
                 <div class="form-inline clearfix">
                    <div id="subject_div_1" class="clearfix">
                    <div class="col-md-4 subject">
                    <div class="form-group">
                    	 <label>Subject<span style="color:red;">*</span></label>
                        <p class="field-para">
                            <select class="form-control" id="subject_1on1_1" name="subject_1on1">
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
<!--                    <span id="subject_action_1" class="add-more">
                    <a href="javascript:void(0);" onclick="addSubjectsBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                    <span class="glyphicon glyphicon-plus"></span>
                    </a>
                    </span>-->
                </div>
                 </div>
                </div>
                 </div>


                 <div class="box-one clearfix">
                 <div class="form-inline clearfix">
                    <div class="col-md-6 choose-file">
                    
                    <div class="form-group">
                            <label>Reference Video
                            </label>
                        <p class="field-para">
                            <input type="file" name="reference_video" id="reference_video" onchange="upload_video('reference_video','tutor_myaccount_1on1')"/>
                            <!--<img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader2" name="img-loader2" style="display: none;" class="loader-gif"/>-->
                            <small class="clearfix">(Supported File Formats: mp4|ogv|webm|mov|wmv)</small>
                        </p>
                        </div>
                        <div id="upload_video_div"></div>
                    </div>
                    
                     
                   <div id="1on1_div_material" class="col-md-6 choose-file"> 
                    <input id="1on1_material_count" name="1on1_material_count" type="hidden" value="1" />
                    <div class='error' id="1on1_span_error" style="display: none;">Please fill below fields first</div>  
                    
                    <div id="1on1_material_div_1" class="clearfix">
                    <div class="form-group">
                        <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                         <label>Material</label>
                        <p class="field-para">
                        <input type="file" name="documents_1" id="documents_1" onchange="upload_files(tutor_myaccount_1on1,1)"/>
                         <small class="clearfix">(Supported File Formats: docx | rtf | doc | pdf)</small>
                        </p>
                        <span id="material_action_1" class="add-more">
                            <a href="javascript:void(0);" onclick="addMaterialBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span>
                        <div id='documents_display_div_1' class="add-more-data"></div>
                        <!--<img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader1" name="img-loader1" style="display: none;" class="loader-gif"/>-->
                        </div>
                    
                    </div>
                   </div>
                     
                      </div>
                     </div>

                  <div class="box-one clearfix">
                  <div id="div_1on1_date_time" class="form-inline  clearfix">    
                    <input id="1on1_date_time_count" name="1on1_date_time_count" type="hidden" value="1" />
                    <div class='error' id="date_spantime_error_1on1"></div>
                    <div class='error' id="spandatetime_error" style="display: none;">Please fill below fields first</div>
                 <div class="col-md-12 date-time" id="1on1_date_time_div_1" >    
                     <div class="form-group">
                            <label>Date , Time & Session Topic<span style="color:red;">*</span></label>
                        <p class="field-para">
                            <input id="from_1on1date_1" class="form-control from_date" name="from_1on1date[]" type="text" placeholder="Date"/>
                            <!--<span class="glyphicon glyphicon-calendar"></span>-->
                            <input id="from_1on1time_1" class="form-control from_time" name="from_1on1time[]" type="text" placeholder="Time"/>
                            <input type="text" id="session_1on1topic_1" name="session_1on1topic[]" class="session_topic form-control" placeholder="Session Topic"/>
                        </p>
                     </div>
                    <span id="date_action_1" class="add-more">
                        <a href="javascript:void(0);" onclick="add1on1DateTimeBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </span>
                  </div>   
                  </div>
                  <div class="form-inline  clearfix">
                    <div class="text-left mar-top-bottom-10 add-session">
                        <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                        <input type="hidden" name="tutor-account-nonce" id="tutor-account-nonce" value="<?php echo wp_create_nonce('tutor-account-nonce'); ?>"/>
                        <input type="hidden" name="tutoring_type" id="tutoring_type" value="1on1">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
                        <input type="hidden" name="edit_mode" id="edit_mode" value="0"/>
                        <input type="hidden" name="product_id" id="product_id" value=""/>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_addsession" name="btn_addsession" value="add_session">
                        <span class="glyphicon glyphicon-menu-ok"></span>
                            Add Session
                        </button>
                    </div>
                  </div>
                  </div>
                  </div><!--one-on-form ends here-->
            </form>
          </div>
        </div>
    </div><!--one-on-tutoring ends here-->

    
    <?php session_history_table($user_id); ?>
     
  </div>
</section>
 </div>
<?php 
return ob_get_clean();
}
?>
