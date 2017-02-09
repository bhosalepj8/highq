<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "<h4>My Account</h4>";
$user_id = get_current_user_id();
$user = get_userdata( $user_id );

 $fname = get_user_meta( $user_id, 'first_name', true);
//  print_r( $all_meta_for_user );
 echo $fname;