<?php function myaccount_student_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
//            print_r($current_user_meta);

        }
//        print_r(get_woocommerce_currencies());
 ?>
<section class="clearfix">
    <article>
        <form class="form-inline" name="student_myaccount" id="student_myaccount" enctype="multipart/form-data" action="" method="post" >
                <div class="box-one">
                          <div class="box-heading">
                            <h4>New Course</h4>
                          </div>
                          <div class="filling-form">        
                                <div>
                                    <div class="clearfix">
                                        <div class="col-md-8">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Course Title</label>
                                            <p class="field-para">
                                            <select class="form-control" id="course_title" name="course_title">
                                                <option value="">-Select Course-</option>
                                                <option value="Course 1" >Course 1</option>
                                                <option value="Course 2">Course 2</option>
                                            </select>
                                            </p>
                                          </div>
                                        </div>
                                                                                
                                    </div>
                                    <div class="clearfix">
                                    <div class="col-md-8 mar-top-10 email-box">
                                     <div class="form-group">
                                        <label for="exampleInputName2">Course Detail</label>
                                        <textarea class="form-control" id="course_detail" name="course_detail" placeholder="Course Detail">
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
                                                    <option value="Academic Course" >Academic Course</option>
                                                    <option value="Nutritional Courses">Nutritional Courses</option>
                                                    <option value="Self Study" >Self Study</option>
                                                    <option value="Success Coaching">Success Coaching</option>
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
                                                <option value="Subject 1" >Subject 1</option>
                                                <option value="Subject 2">Subject 2</option>
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
                                                <option value="Curriculum 1" >Curriculum 1</option>
                                                <option value="Curriculum 2">Curriculum 2</option>
                                            </select>
                                            </p>
                                          </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                </div>
        </form>
        </article>
</section>


<?php 
return ob_get_clean();
}
