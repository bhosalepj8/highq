<?php function edit_tutor_form_fields($viewmode){
 ob_start(); 
 $site_url= get_site_url();
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
//            print_r($current_user_meta);
            
//            add_filter( 'tiny_mce_before_init', function( $args ) {
//                echo "====>".$viewmode;
//                if ($viewmode)
//                     $args['readonly'] = 1;
//                return $args;
//            } );
        }
//        print_r(get_woocommerce_currencies());
 ?>
<h3 class="pippin_header"><?php isset($viewmode)?_e('My Account > View All'):_e('My Account > Edit Information');?></h3>

        <?php 
        // show any error messages after form submission
        $message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        echo $message .'<br/>';
//                print_r($_SESSION);
        unset($_SESSION['error']);
//                session_destroy(); 
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
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   email-box">
                            <div class="form-group"><label for="exampleInputName2">Email<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_email_1" class="form-control" name="tutor_email_1" type="email" placeholder="Can not be changed later" value="<?php echo $current_user->user_email;?>" readonly=""/></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Alternate Email<span style="color: red;">*</span></label>
                           <p class="field-para"> <input id="tutor_email_2" class="form-control" name="tutor_email_2" type="email" placeholder="Enter Your email" value="<?php echo $current_user_meta[tutor_alternateemail][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                        </div>
                    </div>
<!--                    <div class="form-inline clearfix">
                        <div class="col-md-4  ">
                            <div class="form-group"><label for="exampleInputName2">Password<span style="color: red;">*</span></label>
                            <p class="field-para"> <input id="tutor_password" class="form-control" name="tutor_password" type="password" placeholder="Password" /></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Confirm Password<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_confpassword" class="form-control" name="tutor_confpassword" type="password" placeholder="Confirm Password" /></p></div>
                        </div>
                    </div>-->
                    <div class="form-inline clearfix">
                        <div class="col-md-4   dob">
                            <div class="form-group"><label for="exampleInputName2">Date of Birth<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="dob_date" class="form-control" name="dob_date" type="text" placeholder="Date of Birth" value="<?php echo $current_user_meta[user_dob][0];?>" <?php echo isset($viewmode)? "disabled" : "";?>/></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Phone/Mobile<span style="color: red;">*</span></label>
                            <!--<input id="tutor_phone" class="form-control" name="tutor_phone" type="text" placeholder="Enter Mobile/Phone No" /></div>-->
                                 <p class="field-para"> <input id="tutor_phone" class="form-control" maxlength="15" name="tutor_phone" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[billing_phone][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p>
                        </div>
                    </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   nric">
                            <div class="form-group"><label for="exampleInputName2">NRIC</label>
                             <p class="field-para"><input id="tutor_NRIC" class="form-control" name="tutor_NRIC" type="text" placeholder="Enter NRIC code" value="<?php echo $current_user_meta[tutor_NRIC][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-8   address">
                            <div class="form-group"><label for="exampleInputName2">Address 1<span style="color: red;">*</span></label>
                             <p class="field-para"><input id="tutor_address1" class="form-control" name="tutor_address1" type="text" placeholder="Enter Address 1" value="<?php echo $current_user_meta[billing_address_1][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-8   address">
                            <div class="form-group"><label for="exampleInputName2">Address 2</label>
                             <p class="field-para"><input id="tutor_address2" class="form-control" name="tutor_address2" type="text" placeholder="Enter Address 2" value="<?php echo $current_user_meta[billing_address_2][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   country">
                            <div class="form-group"><label for="exampleInputName2">Country<span style="color: red;">*</span></label>
                            <!--<input id="country" class="form-control" name="country" type="text" placeholder="Enter Country" /></div>-->
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
                            <div class="col-md-4  ">
                                <div class="form-group">
                                  <label for="exampleInputName2">State<span style="color:red;">*</span></label>
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
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputName2">City<span style="color:red;">*</span></label>
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
                                                <p class="field-para">   <input type ="text" id="tutor_city_1" name="tutor_city_1" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[billing_city][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
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
                        </div>
                </div>
                </div>
                </div>
               
            <div class="box-one">
            <div class="box-heading">
            <h4>Educational Information</h4>
            </div>
                <div class="filling-form">
                    <div id="educationalDiv0">
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <label for="exampleInputName2">Highest Qualification<span style="color:red;">*</span></label>
                             <p class="field-para">
                                 <input type="text" class="form-control" id="tutor_qualification" name="tutor_qualification" placeholder="Enter Highest Qualification" value="<?php echo $current_user_meta[tutor_qualification][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>>
                             </p>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Year Of Passing<span style="color: red;">*</span></label>
                             <p class="field-para"><select id="tutor_year_passing" class="form-control" name="tutor_year_passing" <?php echo isset($viewmode)? "disabled" : "";?>>
                                <option value="">select year</option>
                                <?php // echo get_the_ID();
                                                        $value = get_post_meta( get_the_ID(),'Year_of_passing',true);
                                                        $arr = explode("|", $value);
                                                        foreach ($arr as $value) {
                                                            $attr = $current_user_meta[tutor_year_passing][0] == $value ? "selected='selected'" : "";
//                                                            echo $attr;
                                                            echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                                                        } ?>
                            </select>
                            </p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">List of Documents<span style="color: red;">*</span></label>
                               <div class="document-list">
                                <p class="field-para">
                                    <?php // echo get_the_ID();
                                        $value = get_post_meta( get_the_ID(),'List_of_documents',true);
                                        $arr = explode("|", $value);
                                        $tutor_docs = maybe_unserialize($current_user_meta[tutor_documents][0]);
                                        foreach ($arr as $key => $value) {
                                            $attr = in_array($value , $tutor_docs) ? "checked='checked'" : "";
                                            echo '<input type="checkbox" name="chk_tutor_documents[]" id="chk_tutor_documents" value="'.$value.'" '.$attr.'> '.$value.'<br/>';
                                        } ?>
                               
                            	</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mar-top-20 choose-file">
                            <div class="form-group"><label for="exampleInputFile">Upload Documents Copy</label>
                                
                                 <p class="field-para">
                                     <input id="documents" class="display-inline" name="new_documents[]" type="file" multiple/>
                                 </p>
                                 <img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader1" name="img-loader1" style="display: none;"/>
                                 <?php 
                                    $uploaded_docs = maybe_unserialize($current_user_meta[uploaded_docs][0]);
                                    $count = count($uploaded_docs);?>
                                    <div id='documents_display_div'>
                                    <input type="hidden" id="doc_count" value="<?php echo $count;?>">
                                    <?php
                                    foreach ($uploaded_docs as $key => $value) {
                                        echo "<div id='doc_div_".$key."'>";
                                        echo "<a href='".$value."' target='_blank' id='link_".$key."'>".$value."</a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc(".$key.")'>X</a><br/>";
                                        echo "<input type='hidden' id='old_uploaded_docs' name='old_uploaded_docs[]' value='".$value."'>";
                                        echo "</div>";
                                    }
                                 ?>
                                    </div>
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
                    $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
                    $editor_id = 'tutor_yourself';
                    $settings = array( 'textarea_rows' => get_option('default_post_edit_rows', 10) );
                    wp_editor( $content, $editor_id, $settings);
                    ?>
                </div>
                </div>
            </div>
            <div class="box-one">
            <div class="box-heading">
            <h4>Nationality & Subjects</h4>
            </div>
            <div class="filling-form">
                <div id="subjectsdiv0">
                    <div class="form-inline clearfix">
                    <div class="col-md-4">
                        <div class="form-group"><label for="exampleInputName2">Nationality</label>
                           <p class="field-para">  <input id="tutor_nationality" class="form-control" name="tutor_nationality" placeholder="Enter your Nationality" value="<?php echo $current_user_meta[tutor_nationality][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                        </div>
                    </div>
                    <div class="col-md-4 country">
                        <div class="form-group"><label for="exampleInputName2">Country<span style="color: red;">*</span></label>
                            <!--<input id="country" class="form-control" name="country" type="text" placeholder="Enter Country" /></div>-->
                            <?php $Country_code2 = $current_user_meta[shipping_country][0]? $current_user_meta[shipping_country][0] : "" ;?>
                                <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');
                                                    woocommerce_form_field('tutor_country_2', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries,
                                                    ),$Country_code2);
                                                ?>
                            </div>
                          </div>
                         
                    
                           <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                <div id="div_tutor_state2" class="state-div">
                                    <?php $countries_obj   = new WC_Countries();
                                                $selected_country_code = $Country_code2;
                                                $state_code2 = $current_user_meta[billing_state][0]? $current_user_meta[shipping_state][0] : "";
                                                $default_county_states = $countries_obj->get_states($selected_country_code);
                                                if($default_county_states){
                                                woocommerce_form_field('tutor_state_2'.$country_no, array(
                                                                        'type'       => 'select',
                                                                        'class'      => array( 'chzn-drop' ),
                                                                        'placeholder'    => __('Enter something'),
                                                                        'options'    => $default_county_states,

                                                                        ),$state_code2);
                                                }  else {
                                                ?>
                                  <p class="field-para"><input class="form-control" id="tutor_state_2" name="tutor_state_2" placeholder="Enter State Name" value="<?php echo $current_user_meta[shipping_state][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                                                <?php }?>
                                </div>
                            </div>
                           </div>
                            <div class="col-md-4">
	                            <div class="form-group"><label for="exampleInputName2">Zip</label>
                                 <p class="field-para"><input id="tutor_zip" class="form-control" name="tutor_zip" placeholder="Enter Zip Code" value="<?php echo $current_user_meta[shipping_postcode][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
	                            </div>
                    		</div>
                    		</div>
                    
                    <div class="form-inline clearfix" id="div_languages">

                        <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                        <?php $language_known = array_values(maybe_unserialize($current_user_meta[language_known][0]));
                            $count = count($language_known);
                            $count = $count - 1;
                        ?>
                            <input id="language_count" name="language_count" type="hidden" value="<?php echo $count;?>" />
                        <?php
                             foreach ($language_known as $index => $value) {
                                 $lang = explode("-", $value);
                                 $rws = explode(",",$lang[1]);
//                                 $count = count($language_known);
                        ?>
                        <div id="language_div_<?php echo $index;?>" class="clearfix">
                        <div class="col-md-6 languages">
                            <div class="form-group"><label for="exampleInputName2">Language known</label>
                             <p class="field-para">
                                 <input id="language_known_<?php echo $index;?>" class="form-control" name="language_known[<?php echo $index;?>]" placeholder="Enter Language name" value="<?php echo $lang[0];?>" <?php echo isset($viewmode)? "readonly" : "";?>></p>
                            </div>
                            <div class="form-group">
                                <!--<label for="exampleInputName2">List of Documents<span style="color: red;">*</span></label>-->
                                <input type="checkbox" name="chk_lang_read[<?php echo $index;?>]" id="chk_lang_read_<?php echo $index;?>" value="read" <?php echo $rws[0] == "read" ? "checked='checked'" : "";?>> Read
                                <input type="checkbox" name="chk_lang_write[<?php echo $index;?>]" id="chk_lang_write_<?php echo $index;?>" value="write" <?php echo $rws[1] == "write" ? "checked='checked'" : "";?>> Write
                                <input type="checkbox" name="chk_lang_speak[<?php echo $index;?>]" id="chk_lang_speak_<?php echo $index;?>" value="speak" <?php echo $rws[2] == "speak" ? "checked='checked'" : "";?>> Speak
                            </div>
                            <?php if($index != $count){?>
                                <span id="action_<?php echo $index;?>"><a href='javascript:void(0);' <?php echo isset($viewmode)? "readonly" : "onclick='removeLanguageBlock($index)'";?> data-toggle='tooltip' title='remove' class='tooltip-bottom'>
                                        <strong>X</strong></a>
                                </span>
                                </div></div>
                            <?php }else{?>
                                <span id="action_<?php echo $index;?>"><a href="javascript:void(0);" <?php echo isset($viewmode)? "readonly" : "onclick='addLanguageBlock()'";?> data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                                </a></span>
                                </div></div>
                              <?php }}?>
                        </div>
                    </div>
                <div class="clearfix"></div>
                    <div class="form-inline clearfix" id="div_subjects">
                    
                    <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                    <?php $subs_can_teach = array_values(maybe_unserialize($current_user_meta[subs_can_teach][0]));
                            $count = count($subs_can_teach);
                            $count = $count - 1;
                            ?>
                            <input id="subject_count" name="subject_count" type="hidden" value="<?php echo $count;?>" />
                            <?php foreach ($subs_can_teach as $index => $value) {
                                 $sub = explode("-", $value);
                            ?>
                    <div id="subjects_div_<?php echo $index;?>" class="clearfix">
                    <div class="col-md-4">
                        <div class="form-group"><label for="exampleInputName2">Subjects can Teach</label>
                          <p class="field-para">
                              <input id="subjects_<?php echo $index;?>" class="form-control" name="subjects[<?php echo $index;?>]" placeholder="Enter Subject" value="<?php echo $sub[0];?>" <?php echo isset($viewmode)? "readonly" : "";?>>
                          </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="exampleInputName2">Level</label>
                          <p class="field-para">   <select id="grade_<?php echo $index;?>" class="form-control" name="grade[<?php echo $index;?>]" <?php echo isset($viewmode)? "disabled" : "";?>>
                                <option value="">Select Level</option>
                                <option value="Level 1" <?php echo $sub[1] == "Level 1" ? "selected='selected'" : "";?>>Level 1</option>
                                <option value="Level 2" <?php echo $sub[1] == "Level 2" ? "selected='selected'" : "";?>>Level 2</option>
                                <option value="Level 3" <?php echo $sub[1] == "Level 3" ? "selected='selected'" : "";?>>Level 3</option>
                            </select>
                           </p>
                        </div>
                        <?php 
                        if($index != $count){?>
                                <span id="sub_action_<?php echo $index;?>"><a href='javascript:void(0);' <?php echo isset($viewmode)? "readonly" : "onclick='removeSubjectBlock($index)'";?> data-toggle='tooltip' title='remove' class='tooltip-bottom'>
                                        <strong>X</strong></a>
                                </span>
                                </div></div>
                            <?php }else{?>
                                <span id="sub_action_<?php echo $index;?>"><a href="javascript:void(0);" <?php echo isset($viewmode)? "readonly" : "onclick='addSubjectBlock()'";?> data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                <span class="glyphicon glyphicon-plus"></span>
                                </a></span>
                                </div></div>
                              <?php }}?>
                </div>
            </div>
            </div>
            <div class="box-one">
                <div class="box-heading">
                    <h4>Video Upload</h4>
                </div>
                <div class="filling-form">
                <div>
                    Please upload a sample video tutorial here. (minimum 1min duration)
                    <div class="form-group  "><label for="exampleInputFile">File input</label>
                    <input id="documents2" class="display-inline" name="new_documents2" type="file" />
                    <img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader2" name="img-loader2" style="display: none;"/>
                    </div>
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
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Please specify your hourly rate</label>
                            <p class="field-para"> <input id="hourly_rate" class="form-control" name="hourly_rate" type="text" placeholder="Enter hourly rate" value="<?php echo $current_user_meta[hourly_rate][0];?>" <?php echo isset($viewmode)? "readonly" : "";?>/></p></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><select id="currency" class="form-control" name="currency" <?php echo isset($viewmode)? "disabled" : "";?>>
                              <p class="field-para"> <option value="">Select Currency</option>
                                <option value="INR" <?php echo $current_user_meta[currency][0] == "INR" ? "selected='selected'" : "";?>>INR</option>
                                <option value="SGD" <?php echo $current_user_meta[currency][0] == "SGD" ? "selected='selected'" : "";?>>SGD</option>
                            </select></p></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            <?php if(!$viewmode){?>
            <div class="text-right mar-top-bottom-10">
                <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                <input type="hidden" name="tutor-register-nonce" id="tutor-register-nonce" value="<?php echo wp_create_nonce('tutor-register-nonce'); ?>"/>
                <input type="hidden" name="edit_mode" id="edit_mode" value="1"/>
                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                <button type="submit" class="btn btn-primary btn-sm" id="btn_submit" name="btn_submit" value="Register">
                <span class="glyphicon glyphicon-menu-ok"></span>
                    Update
                </button>
            </div>
            <?php }?>
            </div>
            </form>
        </article>
        </div>
        </section>

<script>
var viewmode = '<?php echo $viewmode; ?>'; 
jQuery(document).ready(function(){
    if(viewmode){
        for(i=1;i<5;i++){
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