<?php function tutor_registration_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 ?>
<h3 class="pippin_header"><?php _e('Tutor Registration'); ?></h3>

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
            <div>
                <div class="box-one">
                <div class="box-heading">
                    <h4>Personal Information</h4>
                </div>
                <div class="filling-form">
                    <div >
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">First Name<span style="color: red;">*</span></label>
                            <input id="tutor_firstname" class="form-control" name="tutor_firstname" type="text" placeholder="Enter Your First Name" /></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Last Name<span style="color: red;">*</span></label>
                            <input id="tutor_lastname" class="form-control" name="tutor_lastname" type="text" placeholder="Enter Your Last Name" /></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   email-box">
                            <div class="form-group"><label for="exampleInputName2">Email<span style="color: red;">*</span></label>
                            <input id="tutor_email_1" class="form-control" name="tutor_email_1" type="email" placeholder="Enter Your email" /></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Alternate Email<span style="color: red;">*</span></label>
                            <input id="tutor_email_2" class="form-control" name="tutor_email_2" type="email" placeholder="Enter Your email" /></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4  ">
                            <div class="form-group"><label for="exampleInputName2">Password<span style="color: red;">*</span></label>
                            <input id="tutor_password" class="form-control" name="tutor_password" type="password" placeholder="Password" /></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Confirm Password<span style="color: red;">*</span></label>
                            <input id="tutor_confpassword" class="form-control" name="tutor_confpassword" type="password" placeholder="Confirm Password" /></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   dob">
                            <div class="form-group"><label for="exampleInputName2">Date of Birth<span style="color: red;">*</span></label>
                            <input id="dob_date" class="form-control" name="dob_date" type="text" placeholder="Date of Birth" /></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Phone/Mobile<span style="color: red;">*</span></label>
                            <!--<input id="tutor_phone" class="form-control" name="tutor_phone" type="text" placeholder="Enter Mobile/Phone No" /></div>-->
                                 <input id="tutor_phone" class="form-control" maxlength="15" name="tutor_phone" size="25" onKeyup='addDashes(this)' />
                        </div>
                    </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4   nric">
                            <div class="form-group"><label for="exampleInputName2">NRIC</label>
                            <input id="tutor_NRIC" class="form-control" name="tutor_NRIC" type="text" placeholder="Enter NRIC code" /></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-8   address">
                            <div class="form-group"><label for="exampleInputName2">Address 1<span style="color: red;">*</span></label>
                            <input id="tutor_address1" class="form-control" name="tutor_address1" type="text" placeholder="Enter Address 1" /></div>
                        </div>
                    </div>
                    <div class="form-inline clearfix">
                        <div class="col-md-8   address">
                            <div class="form-group"><label for="exampleInputName2">Address 2</label>
                            <input id="tutor_address2" class="form-control" name="tutor_address2" type="text" placeholder="Enter Address 2" /></div>
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
                                      <input class="form-control" id="tutor_state_1" name="tutor_state_1" placeholder="Enter State Name">
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
                                                  <input type ="text" id="tutor_city_1" name="tutor_city_1" class="form-control" placeholder="Enter City Name">
                                              </div>
                                </div>
                              </div>
                    </div>
                        <div class="form-inline clearfix">
                                          <div class="col-md-4 zip">
                                            <div class="form-group">
                                               <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="tutor_zipcode1" name="tutor_zipcode1" placeholder="Enter zip code">
                                            </div>
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
                            <input type="text" class="form-control" id="tutor_qualification" name="tutor_qualification" placeholder="Enter Highest Qualification">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">Year Of Passing<span style="color: red;">*</span></label>
                            <select id="tutor_year_passing" class="form-control" name="tutor_year_passing">
                                <option value="">select year</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-inline clearfix">
                        <div class="col-md-4">
                            <div class="form-group"><label for="exampleInputName2">List of Documents<span style="color: red;">*</span></label>
                               <div class="document-list">
                                <input type="checkbox" name="chk_tutor_documents[]" id="chk_tutor_documents" value="SSC_certificate"> SSC Certificates<br/>
                                <input type="checkbox" name="chk_tutor_documents[]" id="chk_tutor_documents" value="HSC_certificate"> HSC Certificates<br/>
                                <input type="checkbox" name="chk_tutor_documents[]" id="chk_tutor_documents" value="Diploma"> Diploma<br/>
                            	</div>
                            </div>
                        </div>
                        <div class="col-md-4 mar-top-20 choose-file">
                            <div class="form-group"><label for="exampleInputFile">Upload Documents Copy</label>
                                <input id="documents" class="display-inline" name="documents[]" type="file" multiple/></div>
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
//                    $settings = array( 'textarea_name' => 'tutor_yourself' );
                    wp_editor( $content, $editor_id , $settings);
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
                            <input id="tutor_nationality" class="form-control" name="tutor_nationality" placeholder="Enter your Nationality">
                        </div>
                    </div>
                    <div class="col-md-4 country">
                        <div class="form-group"><label for="exampleInputName2">Country<span style="color: red;">*</span></label>
                            <!--<input id="country" class="form-control" name="country" type="text" placeholder="Enter Country" /></div>-->
                                <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');
                                                    woocommerce_form_field('tutor_country_2', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries,
                                                    )
                                                    );
                                                ?>
                            </div>
                          </div>
                         
                    </div>
                    
                     <div class="form-inline clearfix">
                           <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                <div id="div_tutor_state2" class="state-div">
                                    <input class="form-control" id="tutor_state_2" name="tutor_state_2" placeholder="Enter State Name">
                                </div>
                            </div>
                           </div>
                            <div class="col-md-4">
	                            <div class="form-group"><label for="exampleInputName2">Zip</label>
                                        <input id="tutor_zip" class="form-control" name="tutor_zip" placeholder="Enter Zip Code">
	                            </div>
                    		</div>
                    		</div>
                    
                    <div class="form-inline clearfix" id="div_languages">
                        <input id="language_count" name="language_count" type="hidden" value="1" />
                        <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                        <div id="language_div_1" class="clearfix">
                        <div class="col-md-6 languages">
                            <div class="form-group"><label for="exampleInputName2">Language known</label>
                                <input id="language_known_1" class="form-control" name="language_known[1]" placeholder="Enter Language name">
                            </div>
                        
                        
                            <div class="form-group">
                                <!--<label for="exampleInputName2">List of Documents<span style="color: red;">*</span></label>-->
                                <input type="checkbox" name="chk_lang_read[1]" id="chk_lang_read_1" value="read"> Read
                                <input type="checkbox" name="chk_lang_write[1]" id="chk_lang_write_1" value="write"> Write
                                <input type="checkbox" name="chk_lang_speak[1]" id="chk_lang_speak_1" value="speak"> Speak
                            </div>
                        <span id="action_1" class="add-more">
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
                    <div class="col-md-4">
                        <div class="form-group"><label for="exampleInputName2">Subjects can Teach</label>
                            <input id="subjects_1" class="form-control" name="subjects[1]" placeholder="Enter Subject">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label for="exampleInputName2">Level</label>
                            <select id="grade_1" class="form-control" name="grade[1]">
                                <option value="">Select Level</option>
                                <option value="Level 1">Level 1</option>
                                <option value="Level 2">Level 2</option>
                                <option value="Level 3">Level 3</option>
                            </select>
                        </div>
                    </div>
                        <span id="sub_action_1">
                            <a href="javascript:void(0);" onclick="addSubjectBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
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
                    <h4>Video Upload</h4>
                </div>
                <div class="filling-form">
                <div>
                    Please upload a sample video tutorial here. (minimum 1min duration)
                    <div class="form-group  "><label for="exampleInputFile">File input</label>
                    <input id="documents2" class="display-inline" name="documents2" type="file" />
                    <img src="<?php echo $site_url;?>/wp-content/uploads/2017/02/loader.gif" id="img-loader" name="img-loader" style="display: none;"/>
                    </div>
                    <div id="upload_video_div"></div>
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
                            <input id="hourly_rate" class="form-control" name="hourly_rate" type="text" placeholder="Enter hourly rate" /></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"><select id="currency" class="form-control" name="currency">
                                <option value="">Select Currency</option>
                                <option value="INR">INR</option>
                                <option value="SGD">SGD</option>
                            </select></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
                
            <div class="text-right mar-top-bottom-10">
                <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                <input type="hidden" name="tutor-register-nonce" id="tutor-register-nonce" value="<?php echo wp_create_nonce('tutor-register-nonce'); ?>"/>
                <button type="submit" class="btn btn-primary btn-sm" id="btn_submit" name="btn_submit" value="Register">
                <span class="glyphicon glyphicon-menu-ok"></span>
                    Register</button>
            </div>
            </div>
            </form>
        </article>
        </div>
        </section>
<?php 
return ob_get_clean();
}
