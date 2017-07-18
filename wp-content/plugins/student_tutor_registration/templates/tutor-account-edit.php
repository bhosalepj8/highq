<?php function edit_tutor_form_fields($viewmode){
 ob_start(); 
 $site_url= get_site_url();
 if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $current_user_meta = get_user_meta($user_id);
        $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
        $id = $post->ID;
        $post_meta = get_post_custom($id);
        $Year_of_passing = $post_meta[Year_of_passing][0];
        $upload_documents_list = $post_meta[upload_documents_list][0];
        $Grade = $post_meta[Grade][0];
        $subjects = $post_meta[subjects][0];
        $Curriculum = $post_meta[Curriculum][0];
        $Level = $post_meta[Level][0];
        $currencies = $post_meta[currency][0];
        $is_approved = $current_user_meta[is_approved][0];
    }
    $myaccount = "<a href='$site_url/my-account/'>My account</a>";
    wc_print_notices();
if($viewmode){?>
<style>
    .wp-editor-container {
        pointer-events: none;
    }
</style>
<?php }?>
        
<div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php isset($viewmode)? "":_e($myaccount.' > Edit Information');?></h3>       
<section class="clearfix <?php echo isset($viewmode)? "myaccount_view" : "myaccount_edit"?>">
<div class="tutor-registration">
<article>
    <form class="form-inline" id="tutor_registration" name="tutor_registration"  enctype="multipart/form-data" action="" method="post">
    <div class="box-one">
    <div class="box-heading">
        <h4>
        <?php if($viewmode){?>
            Personal Information
            <span class="pull-right viewall-link">
                <h4><a href="javascript:void(0);" onclick="show_all_data()">
                    <i class="more-less glyphicon glyphicon-plus"></i>
                    </a>
                </h4>
            </span>
            <span class="pull-right edit-link">
                <h4><a href="<?php echo get_site_url();?><?php echo $current_user->roles[0] == 'tutor'? '/tutor-account-edit/' : '/student-account-edit/';?>">EDIT
                <i class="more-less glyphicon glyphicon-pencil"></i>
                </a>
            </span>
          <?php }?>
          </h4>
    </div>
    <div class="filling-form">
        <div class="form-inline clearfix">
            <div class="col-md-4">
                <div class="form-group"><label for="exampleInputName2">First Name<span style="color: red;">*</span></label>
                 <p class="field-para">
                     <input id="tutor_firstname" class="form-control" name="tutor_firstname" type="text" placeholder="Enter Your First Name" value="<?php echo $current_user_meta[first_name][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/>
                 </p>
                 </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><label for="exampleInputName2">Last Name<span style="color: red;">*</span></label>
                 <p class="field-para">
                     <input id="tutor_lastname" class="form-control" name="tutor_lastname" type="text" placeholder="Enter Your Last Name" value="<?php echo $current_user_meta[last_name][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/>
                 </p></div>
            </div>

            <div class="col-md-4 email-box">
                <div class="form-group"><label for="exampleInputName2">Email<span style="color: red;">*</span></label>
                 <p class="field-para"><input id="tutor_email_1" class="form-control" name="tutor_email_1" type="email" placeholder="Can not be changed later" value="<?php echo $current_user->user_email;?>" readonly=""/></p></div>
            </div>
         </div>
        <div id="view_all_data_div1" style="<?php echo isset($viewmode) ? 'display: none;' : ''?>">
        <div class="form-inline clearfix">
            <div class="col-md-4">
                <div class="form-group"><label for="exampleInputName2">Alternate Email</label>
               <p class="field-para"> <input id="tutor_email_2" class="form-control" name="tutor_email_2" type="email" placeholder="Alternate email" value="<?php echo $current_user_meta[tutor_alternateemail][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
            </div>
            <div class="col-md-4   dob">
                <div class="form-group"><label for="exampleInputName2">Date of Birth<span style="color: red;">*</span></label>
                 <p class="field-para"><input id="dob_date" class="form-control" name="dob_date" type="text" placeholder="Date of Birth" value="<?php echo $current_user_meta[user_dob][0];?>" <?php echo isset($viewmode)? "disabled" : "";?>/></p></div>
            </div>
            <div class="col-md-4   nric">
                <div class="form-group"><label for="exampleInputName2">NRIC<small>(Mandatory for Singapore Resident)</small> </label>
                 <p class="field-para"><input id="tutor_NRIC" class="form-control" name="tutor_NRIC" type="text" placeholder="Enter NRIC code" value="<?php echo $current_user_meta[tutor_NRIC][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
            </div>
        </div>
        <div class="form-inline clearfix">
            <div class="col-md-6 shipping-address">
                <div class="form-group"><label for="exampleInputName2">Address 1<span style="color: red;">*</span></label>
                 <p class="field-para"><input id="tutor_address1" class="form-control" name="tutor_address1" type="text" placeholder="Enter Address 1" value="<?php echo $current_user_meta[billing_address_1][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
            </div>
            <div class="col-md-6 shipping-address">
                <div class="form-group"><label for="exampleInputName2">Address 2</label>
                 <p class="field-para"><input id="tutor_address2" class="form-control" name="tutor_address2" type="text" placeholder="Enter Address 2" value="<?php echo $current_user_meta[billing_address_2][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
            </div>
        </div>
        <div class="form-inline clearfix">
            <div class="col-md-4   country">
                <div class="form-group"><label for="exampleInputName2">Country<span style="color: red;">*</span></label>
                <?php $Country_code1 = $current_user_meta[billing_country][0]? $current_user_meta[billing_country][0] : "" ;?>
                <?php global $woocommerce;
                    $countries_obj   = new WC_Countries();
                    $countries   = $countries_obj->__get('countries');
                    woocommerce_form_field('tutor_country_1', array(
                    'type'       => 'select',
                    'class'      => array( 'chzn-drop' ),
                    'placeholder'    => __('Enter something'),
                    'options'    => $countries,
                    ),$Country_code1);
                ?>
                </div>
                </div>
                <div class="col-md-4  state">
                    <div class="form-group">
                      <label for="exampleInputName2">State</label>
                      <div id="div_tutor_state1" class="state-div">
                      <?php $countries_obj   = new WC_Countries();
                        $selected_country_code = $Country_code1;
                        $state_code1 = $current_user_meta[billing_state][0]? $current_user_meta[billing_state][0] : "";
                        $default_county_states = $countries_obj->get_states($selected_country_code);
                        if($default_county_states){
                        woocommerce_form_field('tutor_state_1'.$country_no, array(
                                                'type'       => 'select',
                                                'class'      => array( 'chzn-drop' ),
                                                'placeholder'    => __('Enter something'),
                                                'options'    => $default_county_states,

                                                ),$state_code1);
                        }  else {
                        ?>
                      <p class="field-para"> <input class="form-control" id="tutor_state_1" name="tutor_state_1" placeholder="Enter State Name" value="<?php echo $current_user_meta[billing_state][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                      <?php }?>
                       </div>
                    </div>
                  </div>
                  <div class="col-md-4 city">
                    <div class="form-group">
                        <label for="exampleInputName2">City</label>
                        <div id="div_tutor_city1" class="city-div">
                        <?php 
                            $selected_cities = $GLOBALS['wc_city_select']->get_cities($Country_code1);
                            if($selected_cities && array_key_exists($state_code1, $selected_cities)){
                              $attr_disabled =  isset($viewmode)? "disabled" : "";
                            foreach ($selected_cities as $key => $value) {
                                if($key == $state_code1){
                                echo '<select class="form-control" id="tutor_city_1" name="tutor_city_1" "'.$attr_disabled.'" ><option value="">--select city--</option>';
                                foreach ($value as $city) {
                                    $attr = $current_user_meta[billing_city][0] == $city ? "selected='selected'" : "";
                                    echo '<option value="'.$city.'" '.$attr.'>'.$city.'</option>';                                                
                                }
                                echo '</select>';
                                }
                            }
                            }else{?>
                        <p class="field-para"><input type ="text" id="tutor_city_1" name="tutor_city_1" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[billing_city][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                        <?php }?>
                        </div>
                    </div>
                  </div>
        </div>
        <div class="form-inline clearfix">
          <div class="col-md-4 zip">
            <div class="form-group">
               <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
               <p class="field-para">
                   <input type="text" class="form-control" id="tutor_zipcode1" name="tutor_zipcode1" placeholder="Enter zip code" value="<?php echo $current_user_meta[billing_postcode][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>>
               </p>
            </div>
          </div>
            <div class="col-md-4">
                <div class="form-group"><label for="exampleInputName2">Contact No.<span style="color: red;">*</span></label>
                <p class="field-para"> <input id="tutor_phone" class="form-control" name="tutor_phone"  type="tel" value="<?php echo $current_user_meta[billing_phone][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/>
                <input type="hidden" id="contact_num_1" name="contact_num_1" value="<?php echo $current_user_meta[contact_num_1][0];?>"/>
                </p>
            </div>
            </div>
        </div>
        <?php if($viewmode){?>
        <div class="form-inline clearfix">
            <h4>Your Avatar</h4>
            <?php echo get_wp_user_avatar( $user_id, 'medium');?>
        </div>
        <?php }?>
        </div>
    </div>
    </div>

    <div id="view_all_data_div2" style="<?php echo isset($viewmode) ? 'display: none;' : ''?>">    
    <div class="box-one">
    <div class="box-heading">
    <h4>List Of Documents</h4>
    </div>
        <div class="filling-form educational-section" id="div_educational">
            <div id="educationalDiv0">
            <?php $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
            $tutor_institute = isset($current_user_meta[tutor_institute][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_institute][0])) : "";
            $tutor_year_passing = isset($current_user_meta[tutor_year_passing][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_year_passing][0])) : "";
            $uploaded_docs = isset($current_user_meta[uploaded_docs][0]) ? maybe_unserialize($current_user_meta[uploaded_docs][0]):"";
//            print_r($uploaded_docs);
            $arrcount = count($tutor_qualification);
            $count = $arrcount - 1;
            $i=$doc_count=0;
            ?>
            <div class='error' id="span_eduerror" style="display: none;">Please fill below fields first</div>
            <?php if($count >=0 ){
            echo '<input id="educational_count" name="educational_count" type="hidden" value="'.$count.'" />';
            foreach ($tutor_qualification as $key => $value) {?>
            <div id="educational_div_<?php echo $key;?>" class="clearfix">
            <div class="form-inline clearfix">
                <div class="col-md-3">
                    <label for="exampleInputName2">Document Type</label>
                    <p class="field-para">
                    <!--<input type="text" class="form-control" id="tutor_qualification_<?php // echo $key;?>" name="tutor_qualification[]" placeholder="Enter Qualification" value="<?php // echo $value;?>" >-->
                    <select id="tutor_qualification_<?php echo $key;?>" class="form-control" name="tutor_qualification[]" <?php echo isset($viewmode)? "disabled" : "";?>>
                        <option value="">select document type</option>
                        <?php 
                        $arr = explode("|", $upload_documents_list);
                        foreach ($arr as $doc) {
                            $attr = ($value == $doc) ? "selected='selected'" : "";
                            echo '<option value="'.$doc.'" '.$attr.'>'.$doc.'</option>';
                        } ?>
                    </select>
                    </p>
                </div>
                <div class="col-md-3">
                    <label for="exampleInputName2">Name of Document</label>
                     <p class="field-para"><input type="text" class="form-control" id="tutor_institute_<?php echo $key;?>" name="tutor_institute[]" placeholder="Enter Institute" value="<?php echo $tutor_institute[$key];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                </div>
                    <div class="col-md-2 completion-year">
                    <div class="form-group"><label for="exampleInputName2">Document Expiration Year(if applicable)</label>
                     <p class="field-para">
                        <select id="tutor_year_passing_<?php echo $key;?>" class="form-control" name="tutor_year_passing[]" <?php echo isset($viewmode)? "disabled" : "";?>>
                        <option value="">select year</option>
                        <?php 
                        $arr = explode("|", $Year_of_passing);
                        foreach ($arr as $value) {
                            $attr = ($tutor_year_passing[$key] == $value) ? "selected='selected'" : "";
                            echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                        } ?>
                    </select>
                    </p>
                    </div>
                    </div>
                <div class="col-md-3 choose-file">
                    <div class="form-group">
                    <?php $arr_multiple=$uploaded_docs[$key];
                        if($viewmode){?>
                        <label for="exampleInputFile">Uploaded Documents</label>
                        <?php }else{
                        ?>
                        <label for="exampleInputFile">Upload Documents Copy</label><br/>
                        <p class="field-para"><input id="documents_<?php echo $key;?>" class="display-inline" name="documents_<?php echo $key;?>" type="file" onchange="upload_files(tutor_registration,<?php echo $key;?>)"/>
                        <small class="clearfix">(Supported File Formats: docx|rtf|doc|pdf)</small>
                        </p>
                    <?php }?>
                    </div>
                    <div id='documents_display_div_<?php echo $key;?>'>
                        <?php $x = 0;
                         if(!empty($arr_multiple)){
                         foreach ($arr_multiple as $index => $value) {
                             if($value != ""){
                             $doc_count +=1;
                         ?>
                        <div id="doc_div_<?php echo $i;?>" class="uploaded-files"><a href="<?php echo $value;?>" target="_blank" id="link_<?php echo $i;?>" class="doc-file"><span class='glyphicon glyphicon-file'></span></a>&nbsp;
                            <?php if(!$viewmode){?>
                            <a onclick='remove_doc(tutor_registration,<?php echo $i;?>)' href="javascript:void(0);">X</a>
                            <?php }?>
                        <input type='hidden' name='old_uploaded_docs[<?php echo $key;?>][<?php echo $x;?>]' value='<?php echo $value;?>'>
                        </div>
                        <?php $i++; $x++;
                        }}}?>
                    </div>
                </div>
                <?php 
                if(!$viewmode){
                if($key != $count){?>
                    <span id="edu_action_<?php echo $key;?>"class="add-more"><a href='javascript:void(0);' onclick='removeQualificationBlock(<?php echo $key;?>)' data-toggle='tooltip' title='remove' class='tooltip-bottom'>
                            <strong>X</strong></a>
                    </span>
                    <?php }else{?>
                        <span id="edu_action_<?php echo $key;?>" class="add-more"><a href="javascript:void(0);" onclick='addQualificationBlock()' data-toggle="tooltip" title="add another" class="tooltip-bottom">
                        <span class="glyphicon glyphicon-plus"></span>
                        </a></span>
                    <?php }}?>
                        </div></div>
                    <?php }?>
                      <input type="hidden" id="doc_count" name="doc_count" value="<?php echo $doc_count;?>"/>
            <?php }else{ if(!$viewmode){?>
            <input id="educational_count" name="educational_count" type="hidden" value="0" />
            <div id="educational_div_0" class="clearfix">
            <div class="form-inline clearfix">
                <div class="col-md-3">
                    <label for="exampleInputName2">Document Type</label>
                     <p class="field-para">
                        <select id="tutor_qualification_1" class="form-control" name="tutor_qualification[]">
                            <option value="">select document type</option>
                            <?php 
                            $arr = explode("|", $upload_documents_list);
                            foreach ($arr as $value) {
                                echo '<option value="'.$value.'">'.$value.'</option>';
                            } ?>
                        </select>
                     </p>
                </div>
                <div class="col-md-3">
                    <label for="exampleInputName2">Name of Document</label>
                     <p class="field-para"><input type="text" class="form-control" id="tutor_institute_0" name="tutor_institute[]" placeholder="Enter Institute"></p>
                </div>
                <div class="col-md-2">
                    <div class="form-group"><label for="exampleInputName2">Document Expiration Year(if applicable)</label>
                     <p class="field-para">
                         <select id="tutor_year_passing_0" class="form-control" name="tutor_year_passing[]">
                        <option value="">select year</option>
                        <?php  $arr = explode("|", $Year_of_passing);
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
                        <p class="field-para"><input id="documents_0" class="display-inline" name="documents_0" type="file" onchange="upload_files(tutor_registration,0)" />
                        <br/><small>(Supported File Formats: docx|rtf|doc|pdf)</small>
                        <span id='documents_display_div_0'></span>
                        </p>
                        <span id="edu_action_0" class="add-more">
                            <a href="javascript:void(0);" onclick="addQualificationBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span>          
                    </div>
                </div>
            </div>
            </div>
            <?php } }?>
        </div>
    </div>
    </div>

    <div class="box-one">
    <div class="box-heading">
    <h4>Subjects & Experience</h4>
    </div>
    <div class="filling-form">
        <div id="subjectsdiv0">  
        <?php $language_known = isset($current_user_meta[language_known][0]) ? array_values(maybe_unserialize($current_user_meta[language_known][0])):"";
            $count = count($language_known) - 1;
        ?>
        <div class="form-inline clearfix" id="div_languages">
            <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
            <?php if($count > 0){
            echo '<input id="language_count" name="language_count" type="hidden" value="'.$count.'" />';
            foreach ($language_known as $index => $value) {?>
            <div id="language_div_<?php echo $index;?>" class="form-inline clearfix">
            <div class="col-md-6 languages">
                <div class="form-group"><label for="exampleInputName2">Language Proficiency</label>
                 <p class="field-para">
                    <input id="language_known_<?php echo $index;?>" class="form-control" name="language_known[<?php echo $index;?>]" placeholder="Enter Language name" value="<?php echo $value;?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                </div>
            <?php if(!$viewmode){
                if($index != $count){?>
                <span id="lang_action_<?php echo $index;?>" class="add-more"><a href='javascript:void(0);' onclick='removeLanguageBlock(<?php echo $index;?>)' data-toggle='tooltip' title='remove' class='tooltip-bottom'>
                    <strong>X</strong></a>
                </span>
            <?php }else{?>
                <span id="lang_action_<?php echo $index;?>" class="add-more"><a href="javascript:void(0);" onclick='addLanguageBlock()' data-toggle="tooltip" title="add another" class="tooltip-bottom">
                <span class="glyphicon glyphicon-plus"></span>
                </a></span>
                <?php }}?>
                </div></div>
                <?php }}else{ if(!$viewmode){?>
                <input id="language_count" name="language_count" type="hidden" value="0" />
                <div id="language_div_0" class="clearfix">
                    <div class="col-md-6 languages">
                        <div class="form-group"><label for="exampleInputName2">Language Proficiency</label>
                        <p class="field-para"><input id="language_known_0" class="form-control" name="language_known[0]" placeholder="Enter Language name">
                        <span id="lang_action_0" class="add-more">
                            <a href="javascript:void(0);" onclick="addLanguageBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </span></p>
                        </div>
                    </div>
                </div>
                <?php }}?>
            </div>

        <div class="clearfix"></div>
        <div class="form-inline clearfix" id="div_subjects">
        <?php $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])) : "";
        $tutor_grade = isset($current_user_meta[tutor_grade][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_grade][0])) : "";
        $tutor_level = isset($current_user_meta[tutor_level][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_level][0])) : "";
        $new_subject_title = isset($current_user_meta[new_subject_title][0]) ? array_values(maybe_unserialize($current_user_meta[new_subject_title][0])) : "";
        $count = count($subs_can_teach) - 1;
        ?> 
        <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
        <?php 
        if($count > 0){
        echo '<input id="subject_count" name="subject_count" type="hidden" value="'.$count.'"/>';
        foreach ($subs_can_teach as $index => $value) {?>
        <div id="subjects_div_<?php echo $index;?>" class=" subjects clearfix">
        <div class="col-md-4">
            <div class="form-group"><label for="exampleInputName2">Subject Taught</label>
                <p class="field-para">
                <select id="subjects_<?php echo $index;?>" class="form-control" name="subjects[<?php echo $index;?>]" <?php echo isset($viewmode)? "disabled" : "";?> onchange="add_other_subjects(<?php echo $index;?>)">
                <option value="">Select Subject</option>
                <?php   $arr = explode("|", $subjects);
                    foreach ($arr as $value1) {
                        $attr = ($subs_can_teach[$index] == $value1) ? "selected='selected'" : "";
                        echo '<option value="'.$value1.'" '.$attr.'>'.$value1.'</option>';
                    }  ?>
                </select>
                <div class="form-group" id="new_subject_titlediv_<?php echo $index;?>" style="<?php echo ($value == 'Other') ? "" : "display: none;";?>">
                    <label for="exampleInputName2">New Subject Title</label>
                    <p class="field-para"><input type="text" id="new_subject_title_<?php echo $index;?>" name="new_subject_title[<?php echo $index;?>]" value="<?php echo ($value == 'Other') ? $new_subject_title[$index] : '';?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p>
                </div>
              </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label for="exampleInputName2">Grade</label>
            <p class="field-para">   
                <select id="grade_<?php echo $index;?>" class="form-control" name="grade[<?php echo $index;?>]" <?php echo isset($viewmode)? "disabled" : "";?>>
                <option value="">Select Grade</option>
                <?php   $arr = explode("|", $Grade);
                    foreach ($arr as $value) {
                        $attr = ($tutor_grade[$index] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    }  ?>
                </select>
           </p>
        </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label for="exampleInputName2">Level</label>
                <p class="field-para">
                  <select id="level_<?php echo $index;?>" class="form-control" name="level[<?php echo $index;?>]" <?php echo isset($viewmode)? "disabled" : "";?>>
                    <option value="">Select Level</option>
                    <?php  $arr = explode("|", $Level);
                            foreach ($arr as $value) {
                                $attr = ($tutor_level[$index] == $value) ? "selected='selected'" : "";
                                echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                            }  ?>
                </select>
                </p>
            </div>
            <?php 
            if(!$viewmode){
            if($index != $count){?>
            <span id="sub_action_<?php echo $index;?>" class="add-more"><a href='javascript:void(0);' onclick='removeSubjectBlock(<?php echo $index;?>)' data-toggle='tooltip' title='remove' class='tooltip-bottom'>
                    <strong>X</strong></a>
            </span>
        <?php }else{?>
            <span id="sub_action_<?php echo $index;?>" class="add-more"><a href="javascript:void(0);" onclick='addSubjectBlock()' data-toggle="tooltip" title="add another" class="tooltip-bottom">
            <span class="glyphicon glyphicon-plus"></span>
            </a></span>
            <?php }}?>
            </div></div>
        <?php }}else{ if(!$viewmode){?>
            <input id="subject_count" name="subject_count" type="hidden" value="0" />
            <div id="subjects_div_0" class="clearfix">
            <div class="col-md-4 subjects">
                <div class="form-group"><label for="exampleInputName2">Subjects Taught</label>
                  <p class="field-para">
                        <select id="subjects_0" class="form-control" name="subjects[0]" onchange="add_other_subjects(0)">
                            <option value="">Select Subject</option>
                            <?php $arr = explode("|", $subjects);
                                foreach ($arr as $value1) {
                                    echo '<option value="'.$value1.'">'.$value1.'</option>';
                                }  ?>
                        </select>
                  </p>
                    <div class="form-group" id="new_subject_titlediv_0" style="display: none;">
                        <label for="exampleInputName2">New Subject Title</label>
                        <p class="field-para"><input type="text" id="new_subject_title_0" name="new_subject_title[0]"/></p>
                    </div>
                </div>

            </div>
            <div class="col-md-4 grade">
                <div class="form-group"><label for="exampleInputName2">Grade</label>
                <p class="field-para">   
                <select id="grade_0" class="form-control" name="grade[0]">
                    <option value="">Select Grade</option>
                    <?php $arr = explode("|", $Grade);
                    foreach ($arr as $value) {
                        $attr = ($tutor_grade[$index] == $value) ? "selected='selected'" : "";
                        echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                    }  ?>
                </select>
               </p>
            </div>
            </div>
            <div class="col-md-4 level">
                <div class="form-group"><label for="exampleInputName2">Level</label>
                  <p class="field-para">
                    <select id="level_0" class="form-control" name="level[0]">
                        <option value="">Select Level</option>
                        <?php $arr = explode("|", $Level);
                            foreach ($arr as $value) {
                                $attr = ($tutor_level[$index] == $value) ? "selected='selected'" : "";
                                echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                            }  ?>
                    </select>
                   </p>
                </div>
                 <span id="sub_action_0" class="add-more">
                    <a href="javascript:void(0);" onclick="addSubjectBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                    <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </span>
            </div>
            </div>
        <?php }}?>
        </div>
        </div>
    </div>
    </div>

    <div class="box-one"><div class="box-heading"><h4>Brief Description About Tutor</h4></div>
    <div class="filling-form">
        <?php
        $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
        $editor_id = 'tutor_yourself';
        $settings = array( 'textarea_rows' => get_option('default_post_edit_rows', 10));
        wp_editor( $content, $editor_id, $settings);
        ?>
    </div></div>

    <div class="box-one"><div class="box-heading"><h4>Video Upload</h4></div>
        <div class="filling-form">
        <div class="video-upload">
            <?php if(!$viewmode){?>
            Please upload a sample video tutorial here.(Maximum 50MB)<br/>
            <div class="form-group  ">
            <input id="documents2" class="display-inline" name="documents2" type="file" onchange="upload_video('documents2','tutor_registration')"/>
            <small class="clearfix">(Supported File Formats: mp4|ogv|webm|mov|wmv)</small>
            </div>
            <?php }?>
            <input type="hidden" name="old_video_url" id="old_video_url" value="<?php echo $current_user_meta[tutor_video_url][0];?>">
            <div id="upload_video_div">
                <?php $target_file = $current_user_meta[tutor_video_url][0];
                echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="480"]');?>
            </div>
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
                <div class="col-md-4 hourly-rate">
                    <div class="form-group"><label for="exampleInputName2">Please specify your hourly rate<span style="color:red;">*</span></label>
                    <p class="field-para"> <input id="hourly_rate" class="form-control" name="hourly_rate" type="text" placeholder="Enter hourly rate" value="<?php echo $current_user_meta[hourly_rate][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                </div>
                <div class="col-md-4 currency">
                    <div class="form-group">
                    <label></label>	
                    <select id="currency" class="form-control" name="currency" <?php echo isset($viewmode)? "disabled" : "";?>>
                      <p class="field-para"> <option value="">Select Currency</option>
                        <?php echo get_the_ID();
                                $currency = $current_user_meta[currency][0];
                                $arr = explode("|", $currencies);
                                foreach ($arr as $value) {
                                    $attr = ($currency == $value) ? "selected='selected'" : "";
                                    echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                                }  ?>
                    </select></p></div>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
    <div class="text-right mar-top-bottom-10">
    <?php if(!$viewmode){?>
        <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
        <input type="hidden" name="tutor-register-nonce" id="tutor-register-nonce" value="<?php echo wp_create_nonce('tutor-register-nonce'); ?>"/>
        <input type="hidden" name="edit_mode" id="edit_mode" value="1"/>
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        <button type="submit" class="btn btn-primary btn-sm" id="btn_submit" name="btn_submit" value="Register">
        <span class="glyphicon glyphicon-menu-ok"></span>
            Update
        </button>
        <input type="button" class="cancel-btn" onclick="location.href = '<?php echo $site_url;?>/my-account/';" id="btn_cancel" value="Cancel">
    <?php }?>

    </div>
    </form>
</article>
</div>
</section>
</div>
<script>
var viewmode = '<?php echo $viewmode; ?>'; 
var is_approved = '<?php echo $is_approved; ?>';
var telInput = jQuery("#tutor_phone");
telInput.intlTelInput({
    utilsScript: Urls.stylesheet_url+"/js/utils.js"
});
jQuery(document).ready(function(){
    var date = new Date();
    if(viewmode && is_approved){
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    jQuery("#session_from_date").datepicker( "setDate", date );
    jQuery("#session_to_date").datepicker( "setDate", lastDay );
    get_session_details();
    }
    var educational_count = parseInt(jQuery("#educational_count").val());
    jQuery("#tutor_phone").intlTelInput("setCountry", jQuery("#contact_num_1").val());
    for(j=0; j <= educational_count; j++){
        jQuery("#documents_"+j).rules("add",{extension: "docx|rtf|doc|pdf"});
        jQuery("#tutor_qualification_"+j).rules("add",{required: true});
        jQuery("#tutor_institute_"+j).rules("add",{required: true});
        jQuery("#tutor_year_passing_"+j).rules("add",{required: true});
    }
    if(viewmode){
        for(i=1;i<3;i++){
            jQuery("#tutor_country_"+i).prop("disabled",1);
            jQuery("#tutor_state_"+i).prop("disabled",1);
            jQuery("#tutor_city_"+i).prop("disabled",1);
        }
    }
});

</script>

<?php 
return ob_get_clean();
}
