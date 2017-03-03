<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user_id = get_current_user_id();
$arr_userdata = get_userdata( $user_id );
$arr_usermeta = get_user_meta( $user_id);
$fullname = $arr_usermeta['first_name'][0]." ".$arr_usermeta['last_name'][0];
$user_email = $arr_userdata->user_email;
 ?>
                    
                    <article>
                        <?php if($arr_userdata->roles[0] == 'student'){
                        	//echo '<div class="student-registration ">';
                            echo do_shortcode('[edit_user_form role="student" viewmode="1"]');
                            echo do_shortcode('[my_account role="student"]');
                            //echo '</div>';
                        }?>
                   
                        <?php if($arr_userdata->roles[0] == 'tutor'){
                            echo do_shortcode('[edit_user_form role="tutor" viewmode="1"]');
                            echo do_shortcode('[my_account role="tutor"]');
                            
                        }
                        ?>
                     </article> 
                    
                        
  
