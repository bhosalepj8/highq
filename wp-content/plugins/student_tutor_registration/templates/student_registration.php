<?php // registration form fields
function student_registration_form_fields() {
        ob_start(); 
        $site_url= get_site_url();
        $post = get_page_by_path( 'tutor-registration', OBJECT, 'page' );
            $id = $post->ID;
            $post_meta = get_post_custom($id);
            $currencies = $post_meta[currency][0];
        ?>
<div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php _e('Student Registration'); ?></h3>
		<?php 
		// show any error messages after form submission
                wc_print_notices();
                ?>
               
                <section class="clearfix">
                    <div class="student-registration">
                    <article>
                    <form class="form-inline" name="student_registration" id="student_registration" enctype="multipart/form-data" action="" method="post" >
                        <div>
                        <div class="box-one">
                          <div class="box-heading">
                            <h4>Personal Information</h4>
                          </div>
                          <div class="filling-form">        
                                <div>
                                    <div class="clearfix">
                                        <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">First Name<span style="color:red;">*</span></label>
                                            <p class="field-para"><input type="text" class="form-control" id="user_fname" placeholder="Enter Your First Name" name="user_fname" ></p>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Last Name<span style="color:red;">*</span></label>
                                            <p class="field-para"><input type="text" class="form-control" id="user_lname" name="user_lname" placeholder="Enter Your Last Name"></p>
                                          </div>
                                        </div>
                                        
                                       
                                        <div class="col-md-4 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Email<span style="color:red;">*</span></label>
                                            <p class="field-para"><input type="email" class="form-control" id="user_email" name="user_email" placeholder="Can not be changed later"></p>
                                          </div>
                                        </div>
                                        </div>
                                        <div class="clearfix">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">NRIC<small>(Mandatory for Singapore Resident)</small></label>
                                            <p class="field-para"><input type="text" class="form-control" id="NRIC_code" name="NRIC_code" placeholder="Enter NRIC Number" >
                                            <label for="tutor_NRIC" class="error" style="display: none;" id="NRIC_error">Enter NRIC code</label>
                                            </p>
                                           </div>
                                        </div>
                                      
                                       
                                            <div class="col-md-4 dob">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Password<span style="color:red;">*</span></label>
                                                <p class="field-para"><input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password" data-toggle="tooltip" title="Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number" class="tooltip-bottom"></p>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Confirm Password<span style="color:red;">*</span></label>
                                               <p class="field-para"> <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Confirm Password" data-toggle="tooltip" title="Min 8 chars. Atleast 1 Uppercase,1 Lowercase and 1 Number" class="tooltip-bottom"></p>
                                              </div>
                                            </div>
                                       </div>
                                       <div class="clearfix">
                                        <div class="col-md-4 dob">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Date of Birth<span style="color:red;">*</span></label>
                                            <p class="field-para"><input type="text" class="form-control" id="user_dob" name="user_dob" placeholder="Date of Birth" readonly="readonly"></p>
                                          </div>
                                        </div>
                                        <div class="col-md-4 grade">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Grade<span style="color:red;">*</span></label>
                                               <p class="field-para"> <select class="form-control" id="user_grade" name="user_grade">
                                                  <option value="">-Select Grade-</option>
                                                   <?php // echo get_the_ID();
                                                        $value = get_post_meta( get_the_ID(),'Grade',true);
                                                        $arr = explode("|", $value);
                                                        foreach ($arr as $value) {
                                                            echo '<option value="'.$value.'">'.$value.'</option>';
                                                        } ?>
                                                </select>
                                                </p>
                                            </div>
                                          </div>
<!--                                          <div class="col-md-4 gender">
                                            <div class="form-group">
                                            <label for="exampleInputName2">Gender<span style="color:red;">*</span></label>
                                            <p class="field-para">
                                            <select class="form-control" id="user_gender" name="user_gender">
                                                <option value="">-Select Gender-</option>
                                                <option value="Male" >Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            </p>
                                          </div>
                                          </div>-->
                                        </div>   
                                    
                                        <div class="clearfix" id="academic_divs">
                                        <input id="hiddenAcademic" name="hiddenAcademic" type="hidden" value="1" />
                                        <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                                            <div class="clearfix" id="academic_div_1"> 
                                            <div class="col-md-4">
                                                 <div class="form-group">
                                                    <label for="exampleInputName2">Name of Institution</label>
                                                    <p class="field-para"><input type="text" class="form-control" id="school_name_1" name="school_name[1]" placeholder="Name of Institution"></p>
                                                  </div>
                                                  <span id="action_1" class="add-more"><a href="javascript:void(0);" onclick="addAcademicBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a></span> 
                                            <br/>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="box-one">
                          <div class="box-heading">
                            <h4>Contact Details</h4>
                              
                          </div>
                            <input type="hidden" name="hiddeneducation" id="hiddeneducation" value="0" />
                            <div class="filling-form">
                            <div id="educationalDiv0">                                 
                                    <div class="form-inline clearfix">
                                          <div class="col-md-6 shipping-address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Present Address 1<span style="color:red;">*</span></label>
                                              <p class="field-para"><input type="text" class="form-control" id="user_presentadd1" name="user_presentadd1" placeholder="Enter Address" ></p>
                                            </div>
                                          </div>
                                          <div class="col-md-6 shipping-address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Present Address 2</label>
                                              <p class="field-para"><input type="text" class="form-control" id="user_presentadd2" name="user_presentadd2" placeholder="Enter Address"></p>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
                                               <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');
                                                    woocommerce_form_field('user_country_1', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries,
                                                    )
                                                    );
                                                ?>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State</label>
                                              <div id="div_user_state1" class="state-div">
                                                <p class="field-para"><input class="form-control" id="user_state_1" name="user_state_1" placeholder="Enter State Name"></p>
                                               </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City</label>
                                              <div id="div_user_city1" class="city-div">
                                                 <p class="field-para"> <input type ="text" id="user_city_1" name="user_city_1" class="form-control" placeholder="Enter City Name"></p>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 zip">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <p class="field-para"><input type="text" class="form-control" id="user_zipcode1" name="user_zipcode1" placeholder="Enter zip code" ></p>
                                            </div>
                                          </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Contact No.<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                    <!--<input id="user_address_phone1" class="form-control" maxlength="15" name="user_address_phone1" size="20" onKeyup='addDashes(this)' placeholder="Enter Contact No" />-->
                                                    <input id="user_address_phone1" type="tel" class="form-control phone" name="user_address_phone1">
<!--                                                    <span id="svalid-msg" class="hide" style="color:green">✓ Valid</span>
                                                    <span id="serror-msg" class="hide" style="color:red">Invalid number</span>-->
                                                </p>
                                              </div>
                                          </div>
                                          
<!--                                          <div class="clearfix">
                                            <div class="col-md-8 check">
                                             <div class="checkbox">
                                                 <label><input type="checkbox" id="contact-remember-me" name="contact-remember-me" value="contact-remember-me"> Permanent Address (same as present address)</label>
                                              </div>
                                            </div>
                                            </div>
                                            <br/>
                                          <div class="form-inline clearfix">
                                          <div class="col-md-6 shipping-address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Permanent Address 1<span style="color:red;">*</span></label>
                                              <p class="field-para"><input type="text" class="form-control" id="user_permanentadd1" name="user_permanentadd1" placeholder="Enter Address" ></p>
                                            </div>
                                          </div>
                                          <div class="col-md-6 shipping-address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Permanent Address 2</label>
                                             <p class="field-para"> <input type="text" class="form-control" id="user_permanentadd2" name="user_permanentadd2" placeholder="Enter Address" ></p>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
                                              <?php // global $woocommerce;
//                                                    $countries_obj   = new WC_Countries();
//                                                    $countries   = $countries_obj->__get('countries');
//
//                                                    woocommerce_form_field('user_country_2', array(
//                                                    'type'       => 'select',
//                                                    'class'      => array( 'chzn-drop' ),
//                                                    'placeholder'    => __('Enter something'),
//                                                    'options'    => $countries
//                                                    )
//                                                    );
                                                ?>
                                            </div>
                                          </div>
                                          <div class="col-md-4 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State</label>
                                              <div id="div_user_state2" class="state-div">
                                               <p class="field-para"><input type ="text" id="user_state_2" name="user_state_2" class="form-control" placeholder="Enter State Name"></p>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City</label>
                                              <div id="div_user_city2" class="city-div">
                                             <p class="field-para"> <input type ="text" id="user_city_2" name="user_city_2" class="form-control" placeholder="Enter City Name"></p>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 zip">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <p class="field-para"><input type="text" class="form-control" id="user_zipcode2" name="user_zipcode2" placeholder="Enter zip code"></p>
                                            </div>
                                          </div>
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Contact No.<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="user_address_phone2" name="user_address_phone2" placeholder="Phone Number">
                                                <p class="field-para">
                                                    <input id="user_address_phone2" class="form-control" maxlength="15" name="user_address_phone2" size="20" onKeyup='addDashes(this)' placeholder="Enter Contact No"/>
                                                    <input id="user_address_phone2" type="tel" class="form-control phone" name="user_address_phone2">
                                                </p>
                                              </div>
                                          </div>
                                        </div>-->
                            </div> 
                          </div>
                        </div>
                        </div>
  
                        <div class="box-one">
                          <div class="box-heading">
                            <h4>Parent/Guardian Details</h4>
                          </div>
                          <div class="filling-form">
                            <div class="clearfix">
                                            <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Name<span style="color:red;">*</span></label>
                                                <p class="field-para"><input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Enter Parent/Guardian Name"></p>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Age</label>
                                                <p class="field-para"><input type="text" class="form-control" id="guardian_age" name="guardian_age" placeholder="Age"></p>
                                              </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Relationship<span style="color:red;">*</span></label>
                                                <p class="field-para"><input type="text" class="form-control" id="guardian_relation" name="guardian_relation" placeholder="Relationship"></p>
                                              </div>
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="col-md-4 gender">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Gender</label>
                                               <p class="field-para"> <select class="form-control" id="guardian_gender" name="guardian_gender">
                                                <option value="">-Select Gender-</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select> </p> </div>
                                            </div>
                                            <div class="col-md-4 email-box">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Email<span style="color:red;">*</span></label>
                                                <p class="field-para"><input type="text" class="form-control" id="guardian_email_address" name="guardian_email_address" placeholder="Email Address"></p>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Contact No.<span style="color:red;">*</span></label>
                                                <p class="field-para">
                                                    <!--<input id="guardian_contact_num" class="form-control" maxlength="15" name="guardian_contact_num" size="20" onKeyup='addDashes(this)' placeholder="Enter Contact No" />-->
                                                    <input id="guardian_contact_num" type="tel" class="form-control phone" name="guardian_contact_num">
                                                </p>
                                              </div>
                                            </div>
                                       </div>
                          </div>
                        </div>

                        <div class="box-one">
                          <div class="box-heading">
                            <h4>Parent/Guardian Billing Information</h4>
                          </div>
                          <div class="filling-form">
                            <div id="educationalDiv0">                                 
                            <div class="form-inline clearfix">
                                <div class="clearfix">
                                    <div class="col-md-8 check">
                                     <div class="checkbox">
                                         <label><input type="checkbox" id="guardian-remember-me" name="guardian-remember-me" value="guardian-remember-me"> Billing Address (same as present address)</label>
                                      </div>
                                    </div>
                                    </div>
                                    <br/>
                                  <div class="col-md-6 shipping-address">
                                    <div class="form-group">
                                      <label for="exampleInputName2">Billing Address 1<span style="color:red;">*</span></label>
                                      <p class="field-para"><input type="text" class="form-control" id="guardian_billingadd1" name="guardian_billingadd1" placeholder="Enter Address" name="email"></p>
                                    </div>
                                  </div>
                                  <div class="col-md-6 shipping-address">
                                    <div class="form-group">
                                      <label for="exampleInputName2">Billing Address 2</label>
                                      <p class="field-para"><input type="text" class="form-control" id="guardian_billingadd2" name="guardian_billingadd2" placeholder="Enter Address" name="email"></p>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-inline clearfix">
                                  <div class="col-md-4 address">
                                    <div class="form-group">
                                      <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
                                      <?php global $woocommerce;
                                            $countries_obj   = new WC_Countries();
                                            $countries   = $countries_obj->__get('countries');

                                            woocommerce_form_field('user_country_3', array(
                                            'type'       => 'select',
                                            'class'      => array( 'chzn-drop' ),
                                            'placeholder'    => __('Enter something'),
                                            'options'    => $countries
                                            )
                                            );
                                        ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 address">
                                    <div class="form-group">
                                      <label for="exampleInputName2">State</label>
                                      <div id="div_user_state3" class="state-div" >
                                         <p class="field-para"> <input class="form-control" id="user_state_3" name="user_state_3" placeholder="Enter State Name"></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputName2">City</label>
                                      <div id="div_user_city3" class="city-div">
                                      <p class="field-para"><input type ="text" id="user_city_3" name="user_city_3" class="form-control" placeholder="Enter City Name"></p>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-inline clearfix">
                                  <div class="col-md-4 zip">
                                    <div class="form-group">
                                      <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                     <p class="field-para"> <input type="text" class="form-control" id="guardian_zipcode3" name="guardian_zipcode3" placeholder="Enter zip code"></p>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputName2">Contact No.</label>
                                        <p class="field-para">
                                            <!--<input id="guardian_billing_phone" class="form-control" maxlength="15" name="guardian_billing_phone" size="20" onKeyup='addDashes(this)' placeholder="Enter Contact No" />-->
                                            <input id="guardian_billing_phone" type="tel" class="form-control phone" name="guardian_billing_phone">
                                        </p>
                                      </div>
                                  </div>
                            </div>
                            <div class="form-inline clearfix">
                                <div class="col-md-4">
                                    <div class="form-group"><label for="exampleInputName2">Default Currency<span style="color:red;">*</span></label>
                                    <div class="form-group"><select id="currency" class="form-control" name="currency">
                                      <p class="field-para"> <option value="">Select Currency</option>
                                        <?php   $arr = explode("|", $currencies);
                                                foreach ($arr as $value) {
                                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                                }  ?>
                                    </select></p></div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        </div>
                      </div>

                        <div class="text-right mar-top-bottom-10">
                            <input type="hidden" id="timezone" name="timezone" value="">
                            <input type="hidden" name="student_register_nonce" value="<?php echo wp_create_nonce('student-register-nonce'); ?>"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-menu-ok"></span>
                                Register</button>
                        </div>
                               </form>
                        </article> 
                    </div>
            </section>
</div>
<script type="text/javascript">
    var telInput = jQuery("#user_address_phone1");
    var telInput1 = jQuery("#user_address_phone2");
    var telInput2 = jQuery("#guardian_contact_num");
    var telInput3 = jQuery("#guardian_billing_phone");

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
        telInput1.intlTelInput({
          initialCountry: "auto",
          geoIpLookup: function(callback) {
            jQuery.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          utilsScript: Urls.stylesheet_url+"/js/utils.js"
        });
        telInput2.intlTelInput({
          initialCountry: "auto",
          geoIpLookup: function(callback) {
            jQuery.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          utilsScript: Urls.stylesheet_url+"/js/utils.js"
        });
        telInput3.intlTelInput({
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
}?>
