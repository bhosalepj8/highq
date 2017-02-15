<?php // registration form fields
function edit_student_form_fields() {
        ob_start(); 
        $site_url= get_site_url();
        if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
//            echo "<pre>";
            print_r($current_user_meta);
//        foreach ($current_user_meta as $key => $value) {
//           echo "key: ".$key." and ".$value; 
//        }
        }
        ?>

<h3 class="pippin_header"><?php _e('My Account > Edit Information');?></h3>
 
		<?php 
		// show any error messages after form submission
                $message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
		echo $message .'<br/>';
//                print_r($_SESSION);
                unset($_SESSION['error']);
//                session_destroy(); 
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
                                            <input type="text" class="form-control" id="user_fname" placeholder="Enter Your First Name" name="user_fname" value="<?php echo $current_user_meta[first_name][0];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Last Name<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="user_lname" name="user_lname" placeholder="Enter Your Last Name" value="<?php echo $current_user_meta[last_name][0];?>">
                                          </div>
                                        </div>
                                        </div>
                                        <div class="clearfix">
                                        <div class="col-md-4 mar-top-10 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Email<span style="color:red;">*</span></label>
                                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter Your email" value="<?php echo $current_user->user_email;?>" disabled="">
                                          </div>
                                        </div>
                                        <div class="col-md-8 mar-top-10 phone">
                                          <div class="form-group">
                                            <label for="exampleInputName2">NRIC<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="NRIC_code" name="NRIC_code" placeholder="Enter NRIC Number" value="<?php echo $current_user_meta[NRIC_code][0];?>">
                                           </div>
                                        </div>
                                       </div>
<!--                                        <div class="clearfix">
                                            <div class="col-md-4 mar-top-10 dob">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Password<span style="color:red;">*</span></label>
                                                <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password" >
                                              </div>
                                            </div>
                                            <div class="col-md-8 mar-top-10 phone">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Confirm Password<span style="color:red;">*</span></label>
                                                <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Confirm Password">
                                              </div>
                                                
                                            </div>
                                       </div>-->
                                       <div class="clearfix">
                                        <div class="col-md-4 mar-top-10 dob">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Date of Birth<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="user_dob" name="user_dob" placeholder="Date of Birth" readonly="readonly" value="<?php echo $current_user_meta[user_dob][0];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-8 mar-top-10 phone">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Ethnicity</label>
                                            <input type="text" class="form-control" id="user_ethinicity" name="user_ethinicity" placeholder="Enter Your Ethnicity" value="<?php echo $current_user_meta[user_ethinicity][0];?>">
                                           </div>
                                           
                                        </div>
                                       </div> 
                                       <div class="clearfix">
                                          <div class="col-md-4 mar-top-10 grade">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Grade<span style="color:red;">*</span></label>
                                                <select class="form-control" id="user_grade" name="user_grade">
                                                  <option value="">-Select Grade-</option>
                                                   <?php // echo get_the_ID();
                                                        $value = get_post_meta( get_the_ID(),'Grade',true);
                                                        $arr = explode("|", $value);
                                                        foreach ($arr as $value) {
                                                            $attr = $current_user_meta[user_grade][0] == $value ? "selected='selected'" : "";
//                                                            echo $attr;
                                                            echo '<option value="'.$value.'" '.$attr.'>'.$value.'</option>';
                                                        } ?>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 gender">
                                            <div class="form-group">
                                            <label for="exampleInputName2">Gender<span style="color:red;">*</span></label>
                                            
                                            <select class="form-control" id="user_gender" name="user_gender">
                                                <option value="">-Select Gender-</option>
                                                <option value="Male" <?php echo $current_user_meta[user_gender][0] == "Male" ? "selected='selected'" : "";?>>Male</option>
                                                <option value="Female" <?php echo $current_user_meta[user_gender][0] == "Female" ? "selected='selected'" : "";?>>Female</option>
                                            </select>
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
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Present Address 1<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_presentadd1" name="user_presentadd1" placeholder="Enter Address" value="<?php echo $current_user_meta[billing_address_1][0];?>">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Present Address 2<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_presentadd2" name="user_presentadd2" placeholder="Enter Address" value="<?php echo $current_user_meta[billing_address_2][0];?>">
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
                                              <?php $Country_code1 = $current_user_meta[billing_country][0]? $current_user_meta[billing_country][0] : "" ;?>
                                               <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');
                                                    woocommerce_form_field('user_country_1', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries,
                                                    ),$Country_code1 );
                                                ?>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                              <div id="div_user_state1" class="state-div">
                                                  <?php $countries_obj   = new WC_Countries();
                                                    $selected_country_code = $Country_code1;
                                                    $state_code1 = $current_user_meta[billing_state][0]? $current_user_meta[billing_state][0] : "";
                                                    $default_county_states = $countries_obj->get_states($selected_country_code);
                                                    woocommerce_form_field('user_state_1'.$country_no, array(
                                                                            'type'       => 'select',
                                                                            'class'      => array( 'chzn-drop' ),
                                                                            'placeholder'    => __('Enter something'),
                                                                            'options'    => $default_county_states
                                                                            ),$state_code1);
                                                    ?>
                                                  <!--<input class="form-control" id="user_state_1" name="user_state_1" placeholder="Enter State Name" value="<?php echo $current_user_meta[billing_state][0];?>">-->
                                               </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 zip">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City<span style="color:red;">*</span></label>
                                              <div id="div_user_city1" class="city-div">
                                                  <?php 
//                                                    $selected_country_code = $Country_code1;
//                                                    $selected_state_code = $state_code1;
                                                    $selected_cities = $GLOBALS['wc_city_select']->get_cities($Country_code1);
                                                    foreach ($selected_cities as $key => $value) {
                                            //            echo "key: ".$key." and state code: ".$selected_state_code;
                                                        if($key == $state_code1){
                                                        echo '<select class="form-control" id="user_city_1" name="user_city_1"><option value="">--select city--</option>';
                                                        foreach ($value as $city) {
                                                            $attr = $current_user_meta[billing_city][0] == $city ? "selected='selected'" : "";
                                                            echo '<option value="'.$city.'" '.$attr.'>'.$city.'</option>';                                                
                                                        }
                                                        echo '</select>';
                                                        }
                                                    }
                                                  ?>
                                                  <!--<input type ="text" id="user_city_1" name="user_city_1" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[billing_city][0];?>">-->
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_zipcode1" name="user_zipcode1" placeholder="Enter zip code" value="<?php echo $current_user_meta[billing_postcode][0];?>">
                                            </div>
                                          </div>
                                            <div class="col-md-8 mar-top-10 phone">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Present Address Contact No<span style="color:red;">*</span></label>
                                                <!--<input type="text" class="form-control" id="user_address_phone1" name="user_address_phone1" placeholder="Phone Number">-->
                                                <input id="user_address_phone1" class="form-control" maxlength="15" name="user_address_phone1" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[billing_phone][0];?>"/>
                                              </div>
                                          </div>
                                          
                                          <div class="clearfix">
                                            <div class="col-md-8 mar-top-10 check">
                                             <div class="checkbox">
                                                 <label><input type="checkbox" id="contact-remember-me" name="contact-remember-me" value="contact-remember-me" <?php echo $current_user_meta[contact_remember_me][0]? "checked" : "";?>> Present Address (same as permanent address)</label>
                                              </div>
                                            </div>
                                            </div>
                                            
                                          <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Permanent Address 1<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_permanentadd1" name="user_permanentadd1" placeholder="Enter Address" value="<?php echo $current_user_meta[shipping_address_1][0];?>">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Permanent Address 2<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_permanentadd2" name="user_permanentadd2" placeholder="Enter Address" value="<?php echo $current_user_meta[shipping_address_2][0];?>">
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
                                              <?php $Country_code2 = $current_user_meta[shipping_country][0]? $current_user_meta[shipping_country][0] : "" ;
                                                    global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');

                                                    woocommerce_form_field('user_country_2', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
//                                                    'label'      => __('Country'),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries
                                                    ),$Country_code2);
                                                ?>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                              <div id="div_user_state2" class="state-div">
                                                  <?php $countries_obj   = new WC_Countries();
//                                                    $selected_country_code = $Country_code2;
                                                    $state_code2 = $current_user_meta[shipping_state][0]? $current_user_meta[shipping_state][0] : "";
                                                    $default_county_states = $countries_obj->get_states($Country_code2);
                                                    woocommerce_form_field('user_state_2'.$country_no, array(
                                                                            'type'       => 'select',
                                                                            'class'      => array( 'chzn-drop' ),
                                                                            'placeholder'    => __('Enter something'),
                                                                            'options'    => $default_county_states
                                                                            ),$state_code2);
                                                    ?>
                                                  <!--<input type ="text" id="user_state_2" name="user_state_2" class="form-control" placeholder="Enter State Name" value="<?php echo $current_user_meta[shipping_state][0];?>">-->
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 zip">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City<span style="color:red;">*</span></label>
                                              <div id="div_user_city2" class="city-div">
                                                 <?php 
//                                                    $selected_country_code = $Country_code1;
//                                                    $selected_state_code = $state_code2;
                                                    $selected_cities = $GLOBALS['wc_city_select']->get_cities($Country_code2);
                                                    foreach ($selected_cities as $key => $value) {
                                            //            echo "key: ".$key." and state code: ".$selected_state_code;
                                                        if($key == $state_code2){
                                                        echo '<select class="form-control" id="user_city_2" name="user_city_2"><option value="">--select city--</option>';
                                                        foreach ($value as $city) {
                                                            $attr = $current_user_meta[billing_city][0] == $city ? "selected='selected'" : "";
                                                            echo '<option value="'.$city.'" '.$attr.'>'.$city.'</option>';                                                
                                                        }
                                                        echo '</select>';
                                                        }
                                                    }
                                                  ?>  
                                              <!--<input type ="text" id="user_city_2" name="user_city_2" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[shipping_city][0];?>">-->
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="user_zipcode2" name="user_zipcode2" placeholder="Enter zip code" value="<?php echo $current_user_meta[shipping_postcode][0];?>">
                                            </div>
                                          </div>
                                            <div class="col-md-8 mar-top-10 phone">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Permanent Address Contact No<span style="color:red;">*</span></label>
                                                <!--<input type="text" class="form-control" id="user_address_phone2" name="user_address_phone2" placeholder="Phone Number">-->
                                                <input id="user_address_phone2" class="form-control" maxlength="15" name="user_address_phone2" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[shipping_phone][0];?>"/>
                                              </div>
                                          </div>
                                        </div>
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
                                            <div class="col-md-4 mar-top-10 dob">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Name</label>
                                                <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Enter Parent/Guardian Name" value="<?php echo $current_user_meta[guardian_name][0];?>">
                                              </div>
                                            </div>
                                            <div class="col-md-4 mar-top-10 phone">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Age</label>
                                                <input type="text" class="form-control" id="guardian_age" name="guardian_age" placeholder="Age" value="<?php echo $current_user_meta[guardian_age][0];?>">
                                              </div>
                                                
                                            </div>
                                            <div class="col-md-4 mar-top-10 phone">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Relation</label>
                                                <input type="text" class="form-control" id="guardian_relation" name="guardian_relation" placeholder="Relation" value="<?php echo $current_user_meta[guardian_relation][0];?>">
                                              </div>
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div class="col-md-4 mar-top-10 gender">
                                             <div class="form-group">
                                                <label for="exampleInputName2">Gender</label>
                                                <select class="form-control" id="guardian_gender" name="guardian_gender">
                                                <option value="">-Select Gender-</option>
                                                <option <?php echo $current_user_meta[guardian_gender][0] == "Male" ? "selected='selected'" : "";?>>Male</option>
                                                <option <?php echo $current_user_meta[guardian_gender][0] == "Female" ? "selected='selected'" : "";?>>Female</option>
                                            </select>  </div>
                                            </div>
                                            <div class="col-md-4 mar-top-10 phone">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Email</label>
                                                <input type="text" class="form-control" id="guardian_email_address" name="guardian_email_address" placeholder="Email Address" value="<?php echo $current_user_meta[guardian_email_address][0];?>">
                                              </div>
                                            </div>
                                            <div class="col-md-4 mar-top-10 phone">
                                              <div class="form-group">
                                                <label for="exampleInputName2">Contact Number</label>
                                                <!--<input type="text" class="form-control" id="guardian_contact_num" name="guardian_contact_num" placeholder="Contact Number">-->
                                                <input id="guardian_contact_num" class="form-control" maxlength="15" name="guardian_contact_num" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[guardian_contact_num][0];?>"/>
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
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Billing Address 1<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="guardian_billingadd1" name="guardian_billingadd1" placeholder="Enter Address" value="<?php echo $current_user_meta[guardian_billingadd1][0];?>">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Billing Address 2</label>
                                              <input type="text" class="form-control" id="guardian_billingadd2" name="guardian_billingadd2" placeholder="Enter Address" value="<?php echo $current_user_meta[guardian_billingadd2][0];?>">
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
<!--                                                <select class="form-control" id="guardian_country3" name="guardian_country3">
                                                    <option value="">--select country--</option>
                                                    <option value="India">India</option>
                                                    <option value="Chin">Chin</option>
                                                </select>-->
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
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                              <div id="div_user_state3" class="state-div" >
<!--                                                <select class="form-control" id="user_state3" name="user_state3">
                                                    <option value="">--select state--</option>
                                                    <option value="MH">Maharashtra</option>
                                                    <option value="UP">Uttar Pradesh</option>
                                                    <option value="KT">Karnataka</option>
                                                    <option value="ADH">Andhrapradesh</option>
                                                </select>-->
                                                  <input class="form-control" id="user_state_3" name="user_state_3" placeholder="Enter State Name" value="<?php echo $current_user_meta[guardian_state3][0];?>">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 zip">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City<span style="color:red;">*</span></label>
                                              <div id="div_user_city3" class="city-div">
<!--                                                <select class="form-control" id="guardian_city3" name="guardian_city3">
                                                    <option value="">--select city--</option>
                                                </select>-->
                                              <input type ="text" id="user_city_3" name="user_city_3" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[guardian_city3][0];?>">
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="guardian_zipcode3" name="guardian_zipcode3" placeholder="Enter zip code" value="<?php echo $current_user_meta[guardian_zipcode3][0];?>">
                                            </div>
                                          </div>
                                            <div class="col-md-8 mar-top-10 phone">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Billing Address Contact No</label>
                                                <!--<input type="text" class="form-control" id="guardian_billing_phone" name="guardian_billing_phone" placeholder="Phone Number">-->
                                                <input id="guardian_billing_phone" class="form-control" maxlength="15" name="guardian_billing_phone" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[guardian_billing_phone][0];?>"/>
                                              </div>
                                          </div>
                                          
                                          <div class="clearfix">
                                            <div class="col-md-8 mar-top-10 check">
                                             <div class="checkbox">
                                                 <label><input  type="checkbox" id="billing-remember-me" name="billing-remember-me"> Shipping Address (same as Billing address)</label>
                                              </div>
                                            </div>
                                            </div>
                                            
                                          <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Shipping Address 1<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="guardian_shippingadd1" name="guardian_shippingadd1" placeholder="Enter Address" value="<?php echo $current_user_meta[guardian_shippingadd1][0];?>">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Shipping Address 2</label>
                                              <input type="text" class="form-control" id="guardian_shippingadd2" name="guardian_shippingadd2" placeholder="Enter Address" value="<?php echo $current_user_meta[guardian_shippingadd2][0];?>">
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country<span style="color:red;">*</span></label>
<!--                                                <select class="form-control" id="guardian_country4" name="guardian_country4">
                                                    <option value="">--select country--</option>
                                                    <option value="India">India</option>
                                                    <option value="Chin">Chin</option>
                                                </select>-->
                                                <?php global $woocommerce;
                                                    $countries_obj   = new WC_Countries();
                                                    $countries   = $countries_obj->__get('countries');

                                                    woocommerce_form_field('user_country_4', array(
                                                    'type'       => 'select',
                                                    'class'      => array( 'chzn-drop' ),
                                                    'placeholder'    => __('Enter something'),
                                                    'options'    => $countries
                                                    )
                                                    );
                                                ?>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">State<span style="color:red;">*</span></label>
                                              <div id="div_user_state4" class="state-div">
<!--                                                <select class="form-control" id="user_state4" name="user_state4">
                                                    <option value="">--select state--</option>
                                                </select>-->
                                                  <input class="form-control" id="user_state_4" name="user_state_4" placeholder="Enter State Name" value="<?php echo $current_user_meta[guardian_state4][0];?>">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4 mar-top-10 zip">
                                            <div class="form-group">
                                                <label for="exampleInputName2">City<span style="color:red;">*</span></label>
                                                <div id="div_user_city4" class="city-div">
                                                 <input type ="text" id="user_city_4" name="user_city_4" class="form-control" placeholder="Enter City Name" value="<?php echo $current_user_meta[guardian_city4][0];?>">
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="form-inline clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code<span style="color:red;">*</span></label>
                                              <input type="text" class="form-control" id="guardian_zipcode4" name="guardian_zipcode4" placeholder="Enter zip code" value="<?php echo $current_user_meta[guardian_zipcode4][0];?>">
                                            </div>
                                          </div>
                                            <div class="col-md-8 mar-top-10 phone">
                                            <div class="form-group">
                                                <label for="exampleInputName2">Shipping Address Contact No<span style="color:red;">*</span></label>
                                                <!--<input type="text" class="form-control" id="guardian_shipping_phone" name="guardian_shipping_phone" placeholder="Phone Number">-->
                                                <input id="guardian_shipping_phone" class="form-control" maxlength="15" name="guardian_shipping_phone" size="25" onKeyup='addDashes(this)' value="<?php echo $current_user_meta[guardian_shipping_phone][0];?>"/>
                                              </div>
                                          </div>
                                        </div>
                            </div> 
                          </div>
                        </div>
                        </div>

                        <div class="box-one">
                          <div class="box-heading">
                            <h4>Academic Background</h4>
                          </div>
                          
                            <div class="filling-form" id="academic_divs">
                            <input id="hiddenAcademic" name="hiddenAcademic" type="hidden" value="1" />
                            <div class='error' id="span_error" style="display: none;">Please fill below fields first</div>
                                <?php $school_name = $current_user_meta[school_name][0];?>
                                    <div class="clearfix" id="academic_div_1"> 
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">School Name</label>
                                            <input type="text" class="form-control" id="school_name_1" name="school_name[1]" placeholder="Enter School Name">
                                          </div> 
                                    </div>
                                    <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Subject Studied </label>
                                            <input type="text" class="form-control" id="subject_studied_1" name="subject_studied[1]" placeholder="Subject Studied">
                                          </div> 
                                    </div>
                                    <span id="action_1"><a href="javascript:void(0);" onclick="addAcademicBlock()" data-toggle="tooltip" title="add another" class="tooltip-bottom">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </a></span>
                                    </div>
                                    
                            </div>
                        </div>

                      </div>
                        <?php // Custom function to display the Billing Address form to registration page
//                        do_action('register_form');   
                        
                        ?>
                        <div class="text-right mar-top-bottom-10">
                            <span id="loadingimage" style="display:none;"><img src="<?php echo $site_url;?>/wp-content/themes/skilled-child/loader.png" alt="Loading..." /></span>
                            <input type="hidden" name="student_register_nonce" value="<?php echo wp_create_nonce('student-register-nonce'); ?>"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-menu-ok"></span>
                                Register</button>
                        </div>
                               </form>
                        </article> 
                    </div>
            </section>
<?php 
return ob_get_clean();
}