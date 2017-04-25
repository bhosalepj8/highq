<?php function tutor_registration_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 ?>
<div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php _e('Tutor Registration'); ?></h3>

        <?php 
        // show any error messages after form submission
        $message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
//        echo $message .'<br/>';
//                print_r($_SESSION);
        unset($_SESSION['error']);
//                session_destroy(); 
            wc_print_notices();
        ?>
	
        <section class="clearfix">
        <div class="tutor-registration">
        <article>
            <form class="form-inline" id="tutor_registration" name="tutor_registration"  enctype="multipart/form-data" action="" method="post">
           
                <div class="box-one">
                <div class="box-heading">
                    <h4>Personal Information</h4>
                </div>
                <div class="filling-form">
                    <div >
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">First Name<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_firstname" class="form-control" name="tutor_firstname" type="text" placeholder="Enter Your First Name" /></p>
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Last Name<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_lastname" class="form-control" name="tutor_lastname" type="text" placeholder="Enter Your Last Name" /></p></div>
                        </div>
                    
                        <div class="col-md-4   email-box">
                            <div class="form-group"><label for="exampleInputName2">Email<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_email_1" class="form-control" name="tutor_email_1" type="email" placeholder="Can not be changed later" /></p></div>
                        </div>
                        </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Alternate Email<span style="color: red;">*</span></label>
                           <p class="field-para"> <input id="tutor_email_2" class="form-control" name="tutor_email_2" type="email" placeholder="Alternate email" /></p></div>
                        </div>
                    
                        <div class="col-md-4  ">
                            <div class="form-group"><label for="exampleInputName2">Password<span style="color: red;">*</span></label>
                            <p class="field-para"> <input id="tutor_password" class="form-control" name="tutor_password" type="password" placeholder="Password" /></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Confirm Password<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_confpassword" class="form-control" name="tutor_confpassword" type="password" placeholder="Confirm Password" /></p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   dob">
                            <div class="form-group"><label for="exampleInputName2">Date of Birth<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="dob_date" class="form-control" name="dob_date" type="text" placeholder="Date of Birth" /></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Phone/Mobile<span style="color: red;">*</span></label>
                            <!--<input id="tutor_phone" class="form-control" name="tutor_phone" type="text" placeholder="Enter Mobile/Phone No" /></div>-->
                                 <p class="field-para"> <input id="tutor_phone" class="form-control" maxlength="15" name="tutor_phone" size="20" onKeyup='addDashes(this)' placeholder="Enter Mobile/Phone No" /></p>
                        </div>
                    </div>
                    
                        <div class="col-md-4   nric">
                            <div class="form-group"><label for="exampleInputName2">NRIC<small>(Mandatory for Singapore Resident)</small></label>
                             <p class="field-para"><input id="tutor_NRIC" class="form-control" name="tutor_NRIC" type="text" placeholder="Enter NRIC code" />
                                 <label for="tutor_NRIC" class="error" style="display: none;" id="NRIC_error">Enter NRIC code</label>
                             </p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-6 shipping-address">
                            <div class="form-group"><label for="exampleInputName2">Address 1<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_address1" class="form-control" name="tutor_address1" type="text" placeholder="Enter Address 1" /></p></div>
                        </div>
                   
                        <div class="col-md-6 shipping-address">
                            <div class="form-group"><label for="exampleInputName2">Address 2</label>
                             <p class="field-para"><input id="tutor_address2" class="form-control" name="tutor_address2" type="text" placeholder="Enter Address 2" /></p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   country">
                            <div class="form-group"><label for="exampleInputName2">Country<span style="color: red;">*</span></label>
                            <!--<input id="country" class="form-control" name="country" type="text" placeholder="Enter Country" /></div>-->
                                <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');
                                                    woocommerce_form_field('tutor_country_1', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries,
                                                    )
                                                    );
                                                ?>
                            </div>
                            </div>
                            <div class="col-md-4  ">
                                <div class="form-group">
                                  <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                  <div id="div_tutor_state1" class="state-div">
<!--                                                <select class="form-control" id="user_state1" name="user_state1">
                                        <option value="">--select state--</option>
                                    </select>-->
                                      <p class="field-para"> <input class="form-control" id="tutor_state_1" name="tutor_state_1" placeholder="Enter State Name"></p>
                                   </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputName2">City<span style="color:red;">*</span></label>
                                              <div id="div_tutor_city1" class="city-div">
<!--                                                <select class="form-control" id="user_city1" name="user_city1">
                                                    <option value="">--select city--</option>
                                                </select>-->
                                                <p class="field-para">   <input type ="text" id="tutor_city_1" name="tutor_city_1" class="form-control" placeholder="Enter City Name"></p>
                                              </div>
                                </div>
                              </div>
                    </div>
                        <div class="form-inline clearfix">
                                          <div class="col-md-4 zip">
                                            <div class="form-group">
                                               <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                               <p class="field-para"><input type="text" class="form-control" id="tutor_zipcode1" name="tutor_zipcode1" placeholder="Enter zip code"></p>
                                            </div>
                                          </div>
                        </div>
                </div>
                </div>
                </div>
               
            <div class="box-one">
            <div class="box-heading">
            <h4>Educational Information</h4>
            </div>
                <div class="filling-form educational-section" id="div_educational">
                    <div id="educationalDiv0">
                    <input id="educational_count" name="educational_count" type="hidden" value="1" />
                    <div class='error' id="span_eduerror" style="display: none;">Please fill below fields first</div>
                    
                    <div id="educational_div_1" class="clearfix">
                    <div class="form-inline clearfix">
                        <div class="col-md-3">
                            <label for="exampleInputName2">Qualification</label>
                             <p class="field-para"><input type="text" class="form-control" id="tutor_qualification_1" name="tutor_qualification[]" placeholder="Enter Qualification"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputName2">Name of Institute</label>
                             <p class="field-para"><input type="text" class="form-control" id="tutor_institute_1" name="tutor_institute[]" placeholder="Enter Institute"></p>
                        </div>
                        
                    
                                <div class="col-md-2">
                                    <div class="form-group"><label for="exampleInputName2">Year of Completion</label>
                                     <p class="field-para">
                                         <select id="tutor_year_passing_1" class="form-control" name="tutor_year_passing[]">
                                        <option value="">select year</option>
                                        <?php // echo get_the_ID();
                                                                $value = get_post_meta( get_the_ID(),'Year_of_passing',true);
                                                                $arr = explode("|", $value);
                                                                foreach ($arr as $value) {
                                                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                                                } ?>
                                    </select>
                                    </p>
                                    </div>
                                </div>
                        <div class="col-md-3 choose-file">
                            (Supported File Formats: docx|rtf|doc|pdf)
                            <div class="form-group">
                                <label for="exampleInputFile">Upload Documents Copy</label>
                                <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                                <p class="field-para"><input id="documents_1" class="display-inline" name="documents_1" type="file" onchange="upload_files(tutor_registration,1)" />
                                </p></div>
                                <div id='documents_display_div_1'>
                                    
                                </div>
                                 <!--<img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader1" name="img-loader1" style="display: none;" class="loader-gif"/>-->
                        </div>
                        <span id="edu_action_1" class="add-more">
                            <a href="javascript:void(0);" onclick="addQualificationBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span>
                    </div>
                    </div>
                </div>
            </div>
            </div>
                
            <div class="box-one">
            <div class="box-heading">
            <h4>Subjects & Experience</h4>
            </div>
            <div class="filling-form language-box">
                <div id="subjectsdiv0">                  
                    <div class="form-inline clearfix" id="div_languages">
                        <input id="language_count" name="language_count" type="hidden" value="1" />
                        <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                        <div id="language_div_1" class="clearfix">
                        <div class="col-md-6 languages">
                            <div class="form-group"><label for="exampleInputName2">Language Proficiency</label>
                             <p class="field-para"><input id="language_known_1" class="form-control" name="language_known[1]" placeholder="Enter Language name"></p>
                            </div>
                        <span id="lang_action_1" class="add-more">
                            <a href="javascript:void(0);" onclick="addLanguageBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span>
                        </div>
                        </div>
                    </div>

                <div class="clearfix"></div>
                    <div class="form-inline clearfix" id="div_subjects">
                    <input id="subject_count" name="subject_count" type="hidden" value="1" />
                    <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                    <div id="subjects_div_1" class="clearfix">
                    <div class="col-md-4 subjects">
                        <div class="form-group"><label for="exampleInputName2">Subjects Taught</label>
                          <p class="field-para">
                              <!--<input id="subjects_1" class="form-control" name="subjects[1]" placeholder="Enter Subject">-->
                                <select id="subjects_1" class="form-control" name="subjects[1]">
                                    <option value="">Select Subject</option>
                                    <?php echo get_the_ID();
                                                $value = get_post_meta( get_the_ID(),'subjects',true);
                                                $arr = explode("|", $value);
                                                foreach ($arr as $value) {
                                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                                }  ?>
                                </select>
                          </p>
                        </div>
                        
                    </div>
                    <div class="col-md-4 grade">
                        <div class="form-group"><label for="exampleInputName2">Grade</label>
                      <p class="field-para">   <select id="grade_1" class="form-control" name="grade[1]">
                            <option value="">Select Grade</option>
                            <?php echo get_the_ID();
                                        $value = get_post_meta( get_the_ID(),'Grade',true);
                                        $arr = explode("|", $value);
                                        foreach ($arr as $value) {
                                            echo '<option value="'.$value.'">'.$value.'</option>';
                                        }  ?>
                        </select>
                       </p>
                    </div>
                    </div>
                    <div class="col-md-4 level">
                        <div class="form-group"><label for="exampleInputName2">Level</label>
                          <p class="field-para">
                              <select id="level_1" class="form-control" name="level[1]">
                                <option value="">Select Level</option>
                                <?php echo get_the_ID();
                                        $value = get_post_meta( get_the_ID(),'Level',true);
                                        $arr = explode("|", $value);
                                        foreach ($arr as $value) {
                                            echo '<option value="'.$value.'">'.$value.'</option>';
                                        }  ?>
                            </select>
                           </p>
                        </div>
                         <span id="sub_action_1" class="add-more">
                            <a href="javascript:void(0);" onclick="addSubjectBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                            <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span>
                    </div>
                    </div>
                    
                    </div>
                </div>
            </div>
            </div>   
                
                
                
            <div class="box-one">
                <div class="box-heading"><h4>Brief Description About Tutor</h4>
                </div>
                <div class="filling-form">
                <div>
                    <?php
                    $content = '';
                    $editor_id = 'tutor_yourself';
                    $settings = array( 'textarea_rows' => get_option('default_post_edit_rows', 10) );
                    wp_editor( $content, $editor_id, $settings);
                    ?>
                </div>
                </div>
            </div>
            
            <div class="box-one">
                <div class="box-heading">
                    <h4>Video Upload</h4>
                </div>
                <div class="filling-form">
                <div class="video-upload">
                    Please upload a sample video tutorial here. (Maximum 1min duration)<br/>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input id="documents2" class="display-inline" name="documents2" type="file" onchange="upload_video('documents2','tutor_registration')"/>
                        (Supported File Formats: mp4|ogv|webm)
                    </div>
                    <div id="upload_video_div" class="upload_video_div"></div>
                </div>
                </div>
            </div>
            <div class="box-one">
                <div class="box-heading">
                    <h4>Hourly Rate</h4>
                </div>
                <div class="filling-form">
                    <div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Please specify your hourly rate</label>
                            <p class="field-para"> <input id="hourly_rate" class="form-control" name="hourly_rate" type="text" placeholder="Enter hourly rate" /></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><select id="currency" class="form-control" name="currency">
                              <p class="field-para"> <option value="">Select Currency</option>
                                <?php echo get_the_ID();
                                        $value = get_post_meta( get_the_ID(),'currency',true);
                                        $arr = explode("|", $value);
                                        foreach ($arr as $value) {
                                            echo '<option value="'.$value.'">'.$value.'</option>';
                                        }  ?>
                            </select></p></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>               
            <div class="text-right mar-top-bottom-10">
                <!--<span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>-->
                <input type="hidden" name="tutor-register-nonce" id="tutor-register-nonce" value="<?php echo wp_create_nonce('tutor-register-nonce'); ?>"/>
                <input type="hidden" id="timezone" name="timezone" value="">
                <button type="submit" class="btn btn-primary btn-sm" id="btn_submit" name="btn_submit" value="Register">
                <span class="glyphicon glyphicon-menu-ok"></span>
                    Register</button>
            </div>
            </form>
        </article>
        </div>
        </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#documents2").rules("add",{required: true});
    });
</script>
<?php 
return ob_get_clean();
}
