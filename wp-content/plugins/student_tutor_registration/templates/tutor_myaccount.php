<?php function myaccount_tutor_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 $Grade = '';
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
//            print_r($current_user);
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
//            function search_distinct() {
//                    return "DISTINCT";
//            }
//            add_filter('posts_distinct', 'search_distinct');
		$products = new WP_Query( $args1 );
        }
 ?>

<section class="clearfix">
            	<div class="one-on-tutoring">
                	 <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#new-course" aria-controls="home" role="tab" data-toggle="tab">New Course</a></li>
                        <li role="presentation"><a href="#one-on-tutor" aria-controls="profile" role="tab" data-toggle="tab">1 on 1 Tutoring</a></li>
                     </ul>
                     
         <div class="tab-content">
             <div role="tabpanel" class="tab-pane fade active in" id="new-course">
                 <form class="form-inline" name="tutor_myaccount" id="tutor_myaccount" enctype="multipart/form-data" action="" method="post" >
                    <div class="box-one">
                              <div class="box-heading">
                              </div>
                              <div class="filling-form">        
                                    <div>
                                        <div class="form-inline clearfix">
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
                                        <div class="form-inline clearfix">
                                        <div class="col-md-8 course-details">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Detail</label>
                                            <p class="field-para"><textarea class="form-control" id="course_detail" name="course_detail" placeholder="Course Detail" >
                                            </textarea></p>
                                          </div>
                                        </div>
                                       </div>

                                        <div class="form-inline clearfix">
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
                                                    <option value="1" >1</option>
                                                    <option value="2">2</option>
                                                </select>
                                                </p>
                                              </div>
                                            </div>
                                        </div>

                                        <div class="clearfix">
                                            <div class="col-md-8 upload-course">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Course Video<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                    <input type="file" name="course_video" id="course_video" onchange="upload_video('course_video','tutor_myaccount')"/>
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
                                            <div class="col-md-8 upload-course">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Course Material<span style="color:red;">*</span></label>
                                                <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                                                <p class="field-para">
                                                    <input type="file" name="course_material_1[]" id="course_material_1" onchange="upload_course_material(1)"/>
                                                </p>
                                                <div id='documents_display_div_1'></div>
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

                                        <div id="div_date_time">    
                                        <input id="date_time_count" name="date_time_count" type="hidden" value="1" />
                                        <div class='error' id="spantime_error" style="display: none;">Please fill below fields first</div>
                                        <div id="date_time_div_1" class="form-inline clearfix">
                                            <div class="col-md-8 upload-course">
                                                <div class="form-group"><label for="exampleInputName2">Date & Time<span style="color: red;">*</span></label>
                                                    <p class="field-para date-time"><input id="from_date_1" class="form-control from_date" name="from_date[]" type="text" placeholder="Date"/>
                                                    <input id="from_time_1" class="form-control from_time" name="from_time[]" type="text" placeholder="Time"/>
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
         </div>
             
          <div role="tabpanel" class="tab-pane fade" id="one-on-tutor">
            <form class="form-inline" name="tutor_myaccount_1on1" id="tutor_myaccount_1on1" enctype="multipart/form-data" action="" method="post" >
                    <div class="one-on-form">
                 <div class="box-one clearfix">
                <div class="form-inline clearfix">
                <div class="col-md-3">
                    <div class="form-group">
                            <label>Vertical</label>
                        <p class="field-para">
                            <select class="form-control" id="1on1_cat" name="1on1_cat">
                                <?php foreach ( $product_categories as $product_category ) {
                                    if($product_category->taxonomy == 'product_cat')
                                    echo '<option value="'.$product_category->slug.'" >'.$product_category->name.'</option>';
                                 }?>
                            </select>
                        </p>
                    </div>
                    </div>
                <div class="col-md-3">
                    <div class="form-group">
                    <label>Curriculum</label>
                        <p class="field-para">
                            <select class="form-control" id="1on1_curriculum" name="1on1_curriculum">
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
                <div class="col-md-3">
                    <div class="form-group">
                            <label>Grade</label>
                        <p class="field-para">
                        <select class="form-control" id="1on1_grade" name="1on1_grade">
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
                     <label>Subject</label>
                     <div id="subject_div_1" class="clearfix">
                    <div class="col-md-4 subject">
                    <div class="form-group">
                        <p class="field-para">
                            <select class="form-control" id="1on1_subject_1" name="1on1_subject[]">
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
                    <span id="subject_action_1" class="add-more">
                    <a href="javascript:void(0);" onclick="addSubjectsBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                    <span class="glyphicon glyphicon-plus"></span>
                    </a>
                    </span>
                </div>
                 </div>
                </div>
                 </div>


                 <div class="box-one clearfix">
                 <div class="form-inline clearfix">
                    <div class="col-md-6 choose-file">
                    <div class="form-group">
                            <label>Reference Video</label>
                        <p class="field-para">
                            <input type="file" name="reference_video" id="reference_video" onchange="upload_video('reference_video','tutor_myaccount_1on1')"/>
                            <img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader2" name="img-loader2" style="display: none;" class="loader-gif"/>
                        </p>
                        </div>
                        <div id="upload_video_div"></div>
                    </div>
                    
                     
                   <div id="div_material">    
                    <input id="material_count" name="material_count" type="hidden" value="1" />
                    <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>  
                    <div id="course_material_div_1" class="clearfix">
                   <div class="col-md-6 choose-file">
                    <div class="form-group">
                        <label>Material</label>
                        <input type="hidden" id="1on1_doc_count" name="1on1_doc_count" value="0"/>
                        <p class="field-para">
                        <input type="file" name="1on1_material_1[]" id="1on1_material_1" onchange="upload_course_material(1)"/>
                        </p>
                        <div id='documents_display_div_1'></div>
                        </div>
                      
                     </div>
                        <span id="material_action_1" class="add-more">
                        <a href="javascript:void(0);" onclick="addQualificationBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                      </span>
                    </div>
                   </div>
                      </div>
                     </div>

                  <div class="box-one clearfix">
                  <div id="div_1on1_date_time">    
                    <input id="1on1_date_time_count" name="1on1_date_time_count" type="hidden" value="1" />
                    <div class='error' id="spantime_error" style="display: none;">Please fill below fields first</div>
                 <div class="form-inline clearfix" id="1on1_date_time_div_1" >    
                     <div class="col-md-6 date-time">
                            <label>Date & Time</label>
                        <p class="field-para">
                            <input id="1on1_from_date_1" class="form-control from_date" name="1on1_from_date[]" type="text" placeholder="Date"/>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input id="1on1_from_time_1" class="form-control from_time" name="1on1_from_time[]" type="text" placeholder="Time"/>
                        </p>
                     </div>
                    <span id="date_action_1" class="add-more">
                        <a href="javascript:void(0);" onclick="addQualificationBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </span>
                  </div>   
                    <button type="submit" class="btn btn-primary btn-sm pull-right">
                        <span class="glyphicon glyphicon-menu-ok"></span>
                        Add Session
                    </button>
                  </div>
                  </div>
                  </div><!--one-on-form ends here-->
            </form>
          </div>
        </div>
    </div><!--one-on-tutoring ends here-->


    <div class="box-one clearfix">
            <div class="box-heading">
                            <h4>History</h4>
                          </div>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <div class="col-md-12 date-time">
                                <label>From</label>
                            <p class="field-para">
                                <input id="history_from_date" class="form-control" name="history_from_date" type="text" onchange="">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <input id="history_to_date" class="form-control" name="history_to_date" type="text" onchange="">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <select class="select">
                                    <!--<optgroup>-->
                                        <option value="">-Status-</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Pending">Pending</option>
                                    <!--</optgroup>-->
                                </select>
                                <a class="" href="">MTD</a> &nbsp; <a class="" href="">YTD</a>
                            </p>
                         </div>
                         <br/>
<!--                         <div class="col-md-8">
                                <label>Total Amount Received from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $200/-
                             </p>
                         </div>

                         <br/>
                         <div class="col-md-8">
                                <label>Total Amount Pending from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $75/-
                             </p>
                         </div>-->
          <div class="col-md-12">
            <table class="table table-bordered">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name Of Course</th>
              <th>No of Student</th>
              <th>Total Amount($)</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">03-02-2017</th>
              <td>Mathematics</td>
              <td>1</td>
              <td>21</td>
              <td>Paid</td>
            </tr>
          </tbody>
        </table>
          </div>
            </div>
        </div>
  </div> 
</section>
<?php 
return ob_get_clean();
}
