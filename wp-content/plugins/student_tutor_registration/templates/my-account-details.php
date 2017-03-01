<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user_id = get_current_user_id();
$arr_userdata = get_userdata( $user_id );
//$user_role = $arr_userdata->roles[0];
//echo $user_role;
 $arr_usermeta = get_user_meta( $user_id);
// echo "<pre>";
//  print_r($arr_userdata->roles);
  $fullname = $arr_usermeta['first_name'][0]." ".$arr_usermeta['last_name'][0];
  $user_email = $arr_userdata->user_email;
 ?>
<!--<h3 class="pippin_header"><?php // _e('My Account'); ?></h3>-->

                    <div class="student-registration student-account">
                    <article>
                        <!--
                        <form class="form-inline" name="student_details" id="student_details" enctype="multipart/form-data" action="" method="post" >
                        <div class="box-one">
                          <div class="box-heading">
                            <h4>My Details</h4>
                          </div>
                          <div class="filling-form">        
                                <div>
                                    <div class="clearfix">
                                        <div class="col-md-10">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Name</label>
                                            <input type="text" class="form-control" id="user_fullname" placeholder="Enter Your First Name" name="user_fullname" value="<?php echo $fullname;?>">
                                          </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a href="<?php echo get_site_url();?><?php echo $arr_userdata->roles[0] == 'tutor'? '/tutor-account-edit/' : '/student-account-edit/';?>">EDIT</a>
                                        </div>
                                        
                                    </div>
                                    <div class="clearfix">
                                    <div class="col-md-10 mar-top-10 email-box">
                                     <div class="form-group">
                                        <label for="exampleInputName2">Email</label>
                                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter Your email" value="<?php echo $user_email;?>">
                                      </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="<?php echo get_site_url();?><?php echo $arr_userdata->roles[0] == 'tutor'? '/tutor-view-data/' : '/student-view-data/';?>">View all +</a>
                                    </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        
                        </form>-->
                        <?php if($arr_userdata->roles[0] == 'student'){
                            echo do_shortcode('[edit_user_form role="student" viewmode="1"]');
                            echo do_shortcode('[my_account role="student"]');
                            
                        }
                        if($arr_userdata->roles[0] == 'tutor'){
                            echo do_shortcode('[my_account role="tutor"]');
                            
                        }
                        ?>
                        </article> 
                    </div>
  
