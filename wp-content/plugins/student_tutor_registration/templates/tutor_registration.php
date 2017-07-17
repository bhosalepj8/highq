<?php function tutor_registration_form_fields(){
ob_start(); 
$site_url= get_site_url();
?>
<div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php _e('Tutor Registration'); ?></h3>
<?php  wc_print_notices();?>
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
                <div class="form-group"><label for="exampleInputName2">Alternate Email</label>
               <p class="field-para"> <input id="tutor_email_2" class="form-control" name="tutor_email_2" type="email" placeholder="Alternate email" /></p></div>
            </div>

            <div class="col-md-4  ">
                <div class="form-group"><label for="exampleInputName2">Password<span style="color: red;">*</span></label>
                <p class="field-para"> <input id="tutor_password" class="form-control" name="tutor_password" type="password" placeholder="Password" data-toggle="tooltip" title="Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number" class="tooltip-bottom"/></p></div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><label for="exampleInputName2">Confirm Password<span style="color: red;">*</span></label>
                 <p class="field-para"><input id="tutor_confpassword" class="form-control" name="tutor_confpassword" type="password" placeholder="Confirm Password" data-toggle="tooltip" title="Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number" class="tooltip-bottom"/></p></div>
            </div>
        </div>
        <div class="form-inline clearfix">
            <div class="col-md-4   dob">
                <div class="form-group"><label for="exampleInputName2">Date of Birth<span style="color: red;">*</span></label>
                 <p class="field-para"><input id="dob_date" class="form-control" name="dob_date" type="text" placeholder="Date of Birth" /></p></div>
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
                      <label for="exampleInputName2">State</label>
                      <div id="div_tutor_state1" class="state-div">
                          <p class="field-para"> <input class="form-control" id="tutor_state_1" name="tutor_state_1" placeholder="Enter State Name"></p>
                       </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputName2">City</label>
                          <div id="div_tutor_city1" class="city-div">
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
                <div class="col-md-4">
                    <div class="form-group"><label for="exampleInputName2">Contact No.<span style="color: red;">*</span></label>
                        <p class="field-para"> 
                            <input id="tutor_phone" type="tel" class="form-control" name="tutor_phone">
                            <input type="hidden" id="contact_num_1" name="contact_num_1" value=""/>
                        </p>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>

    <div class="box-one"><div class="box-heading"><h4>List Of Documents</h4></div>
        <div class="filling-form educational-section" id="div_educational">
        <div id="educationalDiv0">
        <input id="educational_count" name="educational_count" type="hidden" value="1" />
        <div class='error' id="span_eduerror" style="display: none;">Please fill below fields first</div>

        <div id="educational_div_1" class="clearfix">
        <div class="form-inline clearfix">
            <div class="col-md-3">
                <label for="exampleInputName2">Document Type</label>
                <p class="field-para">
                <!--<input type="text" class="form-control" id="tutor_qualification_1" name="tutor_qualification[]" placeholder="Enter Qualification">-->
                <select id="tutor_qualification_1" class="form-control" name="tutor_qualification[]">
                    <option value="">select document type</option>
                    <?php $value = get_post_meta( get_the_ID(),'upload_documents_list',true);
                    $arr = explode("|", $value);
                    foreach ($arr as $value) {
                        echo '<option value="'.$value.'">'.$value.'</option>';
                    } ?>
                </select>
                </p>
            </div>
            <div class="col-md-3">
                <label for="exampleInputName2">Name of Document</label>
                <p class="field-para"><input type="text" class="form-control" id="tutor_institute_1" name="tutor_institute[]" placeholder="Enter Institute"></p>
            </div>
            <div class="col-md-2">
                <div class="form-group"><label for="exampleInputName2">Document Expiration Year(if applicable)</label>
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
            <div class="form-group">
                <label for="exampleInputFile">Upload Documents Copy</label>
                <input type="hidden" id="doc_count" name="doc_count" value="0"/>
                <p class="field-para"><input id="documents_1" class="display-inline" name="documents_1" type="file" onchange="upload_files(tutor_registration,1)" />
                <br/><small>(Supported File Formats: docx|rtf|doc|pdf)</small>
                <span id='documents_display_div_1'>

                </span>
                </p>
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
    </div>
    </div>

    <div class="box-one"><div class="box-heading"><h4>Subjects & Experience</h4></div>
    <div class="filling-form language-box">
        <div id="subjectsdiv0">                  
        <div class="form-inline clearfix" id="div_languages">
            <input id="language_count" name="language_count" type="hidden" value="1" />
            <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
            <div id="language_div_1" class="clearfix">
            <div class="col-md-6 languages">
                <div class="form-group"><label for="exampleInputName2">Language Proficiency</label>
                <p class="field-para"><input id="language_known_1" class="form-control" name="language_known[1]" placeholder="Enter Language name">
                <span id="lang_action_1" class="add-more">
                <a href="javascript:void(0);" onclick="addLanguageBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
                </span></p>
                </div>
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
                <select id="subjects_1" class="form-control" name="subjects[1]" onchange="add_other_subjects(1)">
                    <option value="">Select Subject</option>
                    <?php $value = get_post_meta( get_the_ID(),'subjects',true);
                        $arr = explode("|", $value);
                        foreach ($arr as $value) {
                            echo '<option value="'.$value.'">'.$value.'</option>';
                        }  ?>
                </select>
                </p>
                <div class="form-group" id="new_subject_titlediv_1" style="display: none;">
                    <label for="exampleInputName2">New Subject Title</label>
                    <p class="field-para"><input type="text" id="new_subject_title_1" name="new_subject_title[1]"/></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 grade">
            <div class="form-group"><label for="exampleInputName2">Grade</label>
            <p class="field-para">   <select id="grade_1" class="form-control" name="grade[1]">
                <option value="">Select Grade</option>
                <?php 
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
                <?php   $value = get_post_meta( get_the_ID(),'Level',true);
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
        </span></div></div></div>
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
            Please upload a sample video tutorial here.(Maximum 50MB)<br/>
            <div class="form-group">
                <input id="tutor_video" class="display-inline" name="tutor_video" type="file" onchange="upload_video('tutor_video','tutor_registration')"/>
                (Supported File Formats: mp4|ogv|webm|mov|wmv)
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
            <div class="form-inline clearfix">
                <div class="col-md-4">
                    <div class="form-group"><label for="exampleInputName2">Please specify your hourly rate<span style="color:red;">*</span></label>
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
    <div class="text-right mar-top-bottom-10">
        <input type="hidden" name="tutor-register-nonce" id="tutor-register-nonce" value="<?php echo wp_create_nonce('tutor-register-nonce'); ?>"/>
        <input type="hidden" id="timezone" name="timezone" value="">
        <input type="hidden" name="edit_mode" id="edit_mode" value="0"/>
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
    var telInput = jQuery("#tutor_phone");
    // initialise plugin
    telInput.intlTelInput({
      initialCountry: "auto",
      geoIpLookup: function(callback) {
        jQuery.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
      utilsScript: Urls.stylesheet_url+"/js/utils.js"
    });
</script>
<?php 
return ob_get_clean();
}
