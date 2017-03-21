<?php function tutor_public_profile_page($user_id){
 ob_start(); 
 $site_url= get_site_url();
 $user_id = base64_decode($user_id);
// echo $user_id;
 $current_user_meta = get_user_meta($user_id);
// print_r($current_user_meta);
 $tutor_profile_pic = maybe_unserialize($current_user_meta[basic_user_avatar][0]);
 $tutor_qualification = isset($current_user_meta[tutor_qualification][0]) ? array_values(maybe_unserialize($current_user_meta[tutor_qualification][0])) : "";
 $subs_can_teach = isset($current_user_meta[subs_can_teach][0]) ? array_values(maybe_unserialize($current_user_meta[subs_can_teach][0])) : "";
 $hourly_rate = $current_user_meta[hourly_rate][0];
 $content = isset($current_user_meta[tutor_description][0])? $current_user_meta[tutor_description][0] : "";
 ?>
 <div class="woocommerce">
<div class="loader"></div>
<h3 class="pippin_header"><?php _e('Tutor Profile');?></h3>
<section class="clearfix">
    <div class="tutor-registration">
    <article>
        <div class="box-one">
            <div class="filling-form">
                <div class="form-inline clearfix">
                    <div class="col-md-2">
                        <p class="field-para">
                            <img src="<?php echo $tutor_profile_pic[96];?>">
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h3><?php echo $current_user_meta[first_name][0]." ".$current_user_meta[last_name][0];?></h3>
                        <span> <strong>Rating:</strong> <?php ?></span><br/>
                        <span> <strong>Qualification of Tutor:</strong> <?php 
                            foreach ($tutor_qualification as $key => $value) {
                                    echo $value.",";
                                }
                        ?></span><br/>
                        <span> <strong>Subjects:</strong> <?php
//                            $subjects = maybe_unserialize($product_meta[subject][0]);
//                            if(is_array($subjects)){
//                                foreach ($subjects as $key => $value) {
//                                    echo $value.",";
//                                }
//                            }else{
//                                echo $subjects;
//                            }
                        ?></span><br/>
                        <span> <strong>Hourly Rate:</strong> <?php echo $current_user_meta[hourly_rate][0];?></span><br/>
                    </div>
                    <div class="col-md-4">
                        <?php $target_file = $current_user_meta[tutor_video_url][0]; 
                        echo do_shortcode('[videojs_video url="'.$target_file.'" webm="'.$target_file.'" ogv="'.$target_file.'" width="580"]');?>
                    </div>
                </div>
                <div class="form-inline clearfix">
                    <div class="col-md-10">
                        <p> <?php echo $content;?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-one">
            <div class="box-heading">
                    <h4>1 On 1 Tutor Availability</h4>
                    <span class="">
                            <h4>Price/Session: <?php echo "$".$current_user_meta[hourly_rate][0];?></h4>
                    </span>
            </div>
            <div class="filling-form">
                
            </div>
        </div>
    </article>
 </div>
</section>
 </div>
 
 <?php 
    
    return ob_get_clean();
}

