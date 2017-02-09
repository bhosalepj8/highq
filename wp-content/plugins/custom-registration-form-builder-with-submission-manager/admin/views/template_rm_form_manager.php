<?php

/**
 * @internal Template File [Form Manager]
 *
 * This file renders the form manager page of the plugin which shows all the forms
 * to manage delete edit or manage
 */

global $rm_env_requirements;
global $regmagic_errors;
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
 
 <?php if (($rm_env_requirements & RM_REQ_EXT_CURL) && $data->newsletter_sub_link){ ?>
 <div class="rm-newsletter-banner" id="rm_newsletter_sub"><?php echo $data->newsletter_sub_link;?><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/close-rm.png'; ?>" onclick="jQuery('#rm_newsletter_sub').hide()"></div>
 <?php } ?>
 
 <?php
 //Check errors
 RM_Utilities::fatal_errors();
 foreach($regmagic_errors as $err)
 {
    //Display only non - fatal errors
    if($err->should_cont)
        echo '<div class="shortcode_notification ext_na_error_notice"><p class="rm-notice-para">'.$err->msg.'</p></div>';
 }
 ?>
<div class="rmagic rmbasic">
 

    <!--  Operations bar Starts  -->
    <form name="rm_form_manager" id="rm_form_manager_operartionbar" class="rm_static_forms" method="post" action="">
        <input type="hidden" name="rm_slug" value="" id="rm_slug_input_field">
        <div class="operationsbar">
            <div class="rmtitle"><?php echo RM_UI_Strings::get('TITLE_FORM_MANAGER');?></div>
            <div class="icons">
                <a href="?page=rm_options_general"><img alt="" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/general-settings.png'; ?>"></a>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="admin.php?page=rm_form_sett_general"><?php echo RM_UI_Strings::get('LABEL_ADD_NEW');?></a></li>
                    <li onclick="jQuery.rm_do_action('rm_form_manager_operartionbar','rm_form_duplicate')"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get('LABEL_DUPLICATE'); ?></a></li>
                    <li onclick="jQuery.rm_do_action_with_alert('<?php echo RM_UI_Strings::get('ALERT_DELETE_FORM'); ?>','rm_form_manager_operartionbar','rm_form_remove')"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get('LABEL_REMOVE'); ?></a></li>
                    <li onclick="jQuery.rm_do_action('rm_form_manager_operartionbar','rm_form_export')"><a href="javascript:void(0)"><?php echo RM_UI_Strings::get('LABEL_EXPORT_ALL'); ?></a></li>
                     <li><a href="admin.php?page=rm_form_import"><?php echo RM_UI_Strings::get('LABEL_IMPORT'); ?></a></li>
                    
                    <li class="rm-form-toggle">Sort by<select onchange="rm_sort_forms(this,'<?php echo $data->curr_page;?>')">
                            <option value=null><?php echo RM_UI_Strings::get('LABEL_SELECT'); ?></option>
                            <option value="form_name"><?php echo RM_UI_Strings::get('LABEL_NAME'); ?></option>
                            <option value="form_id"><?php echo RM_UI_Strings::get('FIELD_TYPE_DATE'); ?></option>
                            <option value="form_submissions"><?php echo RM_UI_Strings::get('LABEL_SUBMISSIONS'); ?></option>
                        </select></li>
                </ul>
            </div>
        </div>
        <input type="hidden" name="rm_selected" value="">
        <input type="hidden" name="req_source" value="form_manager">
    </form>

    <!--  *****Operations bar Ends****  -->

    <!--  ****Content area Starts****  -->

    <div class="rmagic-cards">

        <div class="rmcard">
            <?php
            $form = new RM_PFBC_Form("rm_form_quick_add");
            $form->configure(array(
                "prevent" => array("bootstrap", "jQuery"),
                "action" => ""
            ));
            $form->addElement(new Element_HTML('<div class="rm-new-form">'));
            $form->addElement(new Element_Hidden("rm_slug",'rm_form_quick_add'));
            $form->addElement(new Element_Textbox('', "form_name", array("id" => "rm_form_name", "required" => 1)));
            $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_CREATE_FORM'), "submit", array("id" => "rm_submit_btn", "onClick" => "jQuery.prevent_quick_add_form(event)", "class" => "rm_btn", "name" => "submit")));
            $form->addElement(new Element_HTML('</div>'));
            $form->render();
            ?></div>
        <div id="login_form" class="rmcard">

                    <div class="cardtitle">
                        <input class="rm_checkbox" type="checkbox" disabled="disabled"><?php echo 'Login Form' ?></div>                       
                    <div class="rm-form-shortcode"><b>[RM_Login]</b></div>

                </div>
        <?php
        if (is_array($data->data) || is_object($data->data))
            foreach ($data->data as $entry)
            {
                if($entry->expiry_details->state == 'not_expired' && $entry->expiry_details->criteria != 'date')
                   $subcount_display = $entry->expiry_details->remaining_subs;// $subcount_display = $entry->count.'/'.$entry->expiry_details->sub_limit;
                else
                    $subcount_display = null;//$entry->count;
                
                ?>

                <div id="<?php echo $entry->form_id; ?>" class="rmcard">
<div class='unread-box'><a href="?page=rm_submission_manage&rm_form_id=<?php echo $entry->form_id; ?>&rm_interval=<?php echo $data->submission_type; ?>"><?php echo $entry->count; ?></a></div>
                    <div class="cardtitle">
                        <input class="rm_checkbox" type="checkbox" name="rm_selected_forms[]" value="<?php echo $entry->form_id; ?>"><span class="rm_form_name" ><?php echo $entry->form_name; ?></span></div>
                    <div class="rm-last-submission">
                          <b><?php echo RM_UI_Strings::get('LABEL_REGISTRATIONS');
                          if($subcount_display)
                              echo " ($subcount_display Left)";
                              ?></b></div>
                            
                    <?php
                    if ($entry->count > 0)
                    {
                        foreach ($entry->submissions as $submission)
                        {
                            ?>
                            <div class="rm-last-submission">

                                <?php
                                echo $submission->gravatar . ' ' . RM_Utilities::localize_time($submission->submitted_on);
                                ?>
                            </div>
                            <?php
                        }
                    } else
                        echo '<div class="rm-last-submission"></div>';
                    ?>
                    <?php
                    if($entry->expiry_details->state == 'expired')
                        echo "<div class='rm-form-expiry-info'>".RM_UI_Strings::get('LABEL_FORM_EXPIRED')."</div>";
                    else if($entry->expiry_details->state == 'not_expired' && $entry->expiry_details->criteria != 'subs')
                    {
                        if($entry->expiry_details->remaining_days < 26)
                           echo "<div class='rm-form-expiry-info'>".sprintf(RM_UI_Strings::get('LABEL_FORM_EXPIRES_IN'),$entry->expiry_details->remaining_days)."</div>";
                        else
                        {
                           $exp_date = date('d M Y', strtotime($entry->expiry_details->date_limit));
                           echo "<div class='rm-form-expiry-info'>".RM_UI_Strings::get('LABEL_FORM_EXPIRES_ON')." {$exp_date}</div>";
                        }
                    }
                     
                    ?><div class="rm-form-shortcode">
                        <?php if($data->def_form_id == $entry->form_id) { ?>
                    <i class="material-icons rm_def_form_star" onclick="make_me_a_star(this)" id="rm-star_<?php echo $entry->form_id; ?>">&#xe838</i>
                        <?php } else { ?>
                    <i class="material-icons rm_not_def_form_star" onclick="make_me_a_star(this)" id="rm-star_<?php echo $entry->form_id; ?>">&#xe838</i>
                        <?php } ?>
                    <b>[RM_Form id='<?php echo $entry->form_id; ?>']</b></div>
                    <div class="rm-form-embedcode"  onclick="rm_open_dial(<?php echo $entry->form_id; ?>)"><?php echo RM_UI_Strings::get('MSG_GET_EMBED'); ?></div>
                    <div class="rm-form-links">
                        <div class="rm-form-row"><a href="admin.php?page=rm_form_sett_manage&rm_form_id=<?php echo $entry->form_id; ?>"><?php echo RM_UI_Strings::get('SETTINGS'); ?></a></div>
                        <div class="rm-form-row"><a href="admin.php?page=rm_field_manage&rm_form_id=<?php echo $entry->form_id; ?>"><?php echo RM_UI_Strings::get('LABEL_FIELDS'); ?></a></div>
                    </div>
                    <div style="display:none" class="rm_form_card_settings_dialog" id="rm_settings_dailog_<?php echo $entry->form_id; ?>"><ul class="rm_form_settings_list"><a href="?page=rm_form_sett_general&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_GEN_SETT'); ?></li></a><a href="?page=rm_form_sett_view&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_VIEW_SETT'); ?></li></a><a href="?page=rm_form_sett_accounts&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_ACC_SETT'); ?></li></a><a href="?page=rm_form_sett_post_sub&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_PST_SUB_SETT'); ?></li></a><a href="?page=rm_form_sett_autoresponder&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_AUTO_RESP_SETT'); ?></li></a><a href="?page=rm_form_sett_limits&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_LIM_SETT'); ?></li></a><a href="?page=rm_form_sett_mailchimp&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_MC_SETT'); ?></li></a><a href="?page=rm_form_sett_access_control&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_ACTRL_SETT'); ?></li></a><a href="?page=rm_form_sett_aweber&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_AWEBER_OPTION'); ?></li></a><a href="?page=rm_form_sett_ccontact&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_CONSTANT_CONTACT_OPTION'); ?></li></a><a href="?page=rm_field_manage&rm_form_id=<?php echo $entry->form_id; ?>"><li><?php echo RM_UI_Strings::get('LABEL_F_FIELDS'); ?></li></a></ul></div>
                </div>
                <?php
            } else
            echo "<h4>" . RM_UI_Strings::get('LABEL_NO_FORMS') . "</h4>";
        ?>
    </div>
    <?php if ($data->total_pages > 1): ?>
        <ul class="rmpagination">
            <?php if ($data->curr_page > 1): ?>
                <li><a href="?page=<?php echo $data->rm_slug ?>&rm_reqpage=<?php echo $data->curr_page - 1;
        if ($data->sort_by) echo'&rm_sortby=' . $data->sort_by;if (!$data->descending) echo'&rm_descending=' . $data->descending; ?>">«</a></li>
                <?php
            endif;
            for ($i = 1; $i <= $data->total_pages; $i++):
                if ($i != $data->curr_page):
                    ?>
                    <li><a href="?page=<?php echo $data->rm_slug ?>&rm_reqpage=<?php echo $i;
            if ($data->sort_by) echo'&rm_sortby=' . $data->sort_by;if (!$data->descending) echo'&rm_descending=' . $data->descending; ?>"><?php echo $i; ?></a></li>
                <?php else:
                    ?>
                    <li><a class="active" href="?page=<?php echo $data->rm_slug ?>&rm_reqpage=<?php echo $i;
            if ($data->sort_by) echo'&rm_sortby=' . $data->sort_by;if (!$data->descending) echo'&rm_descending=' . $data->descending; ?>"><?php echo $i; ?></a></li> <?php
                endif;
            endfor;
            ?>
            <?php if ($data->curr_page < $data->total_pages): ?>
                <li><a href="?page=<?php echo $data->rm_slug ?>&rm_reqpage=<?php echo $data->curr_page + 1;
        if ($data->sort_by) echo'&rm_sortby=' . $data->sort_by;if (!$data->descending) echo'&rm_descending=' . $data->descending; ?>">»</a></li>
            <?php endif;
        ?>
        </ul>
   
<?php endif;
   $current_user = wp_get_current_user();
if($data->review_popup_flag=='show')
{
    $opt=new RM_Options;

?>
    
<div id="rm-rate-popup-wrap">
	<div class="rm-rate-popup">

		<div class="rm-pop-up-head">
        	<h1>Congratulations, <span class="rm-user-name"><?php echo  $current_user->user_nicename?>!</span></h1>
            <p class="rm-user-milestone"><?php echo $data->review_message;?> </p>
                </div>
        
        <div class="rm-pop-up-rating">
        	<p class="rm-pop-up-title">How would you rate <span class="rm-registration-magic">RegistrationMagic?</span></p>
        	<div class="rm-pop-up-rate-stars">
	           <div  class="rateit  bigstars" data-rateit-starwidth="48" data-rateit-starheight="48" id="rm_rateit_banner" data-rateit-resetable="false" data-rateit-min="0" data-rateit-max="5" data-rateit-value="0" data-rateit-ispreset="true">
                    </div>
           	</div>
            <div class="rm-pop-up-skip">
            	<a href=""  onclick="handle_review_banner_click('skip','null')">Skip</a>
            </div>
        </div>    
    </div>
</div>
        
   
    <div class="feedback_message" id="feedback_message" style="display:none">
         <div id="rm-rate-popup-wrap">
	<div class="rm-rate-popup">

		<div class="rm-pop-up-head">
        	<h1>Congratulations, <span class="rm-user-name"><?php echo  $current_user->user_nicename?>!</span></h1>
            <p class="rm-user-milestone"><?php echo $data->review_message;?> </p>
                </div>
        
        <div class="rm-pop-up-rating">
            <p class="rm-pop-up--wordpress-message">Please let us know how we can improve by taking out few minutes to <a href=""   onclick="handle_review_banner_click('feedback','null')">Fill this form</a></p>
                <p class="rm-pop-up--wordpress-sub-message">(This is really important to us.)</p>
        	
                 <div class="rm-pop-up-skip">
            	<a href=""  onclick="handle_review_banner_click('skip','null')">Skip</a>
            </div>
        </div>    
    </div>
</div>
    </div>
    <div class="wordpress_review" id="wordpress_review" style="display:none">
            <div id="rm-rate-popup-wrap">
	<div class="rm-rate-popup">

		<div class="rm-pop-up-head">
        	<h1>Congratulations, <span class="rm-user-name"><?php echo  $current_user->user_nicename?>!</span></h1>
            <p class="rm-user-milestone"><?php echo $data->review_message;?> </p>
                </div>
        
        <div class="rm-pop-up-rating">
        	<p class="rm-pop-up--wordpress-message">Would you like to rate us on WordPress.org</p>
                <p class="rm-pop-up--wordpress-sub-message">(This is really important to us.)</p>
        	<div class="rm-popup-anchors">
                
                <a onclick="handle_review_banner_click('wordpress','null')" href="" id="review_anchor"> Review</a> 
                <a onclick="handle_review_banner_click('remind','null')" href="" id="remind_anchor" > Remind me later</a>
                </div>
           
        </div>    
    </div>
</div>
      </div>
     <pre class='rm-pre-wrapper-for-script-tags'><script>
    jQuery(document).ready(function(){
     jQuery('#rm-rate-popup-wrap').addClass('rm-hop');
     jQuery('#rm-rate-popup-wrap').siblings().addClass('rm-blur');
      });</script></pre>
<?php
;}
elseif($data->review_popup_flag=='remind')
{
    ?> <div class="wordpress_review" id="wordpress_review">
            <div id="rm-rate-popup-wrap">
	<div class="rm-rate-popup">

		<div class="rm-pop-up-head">
        	<h1>Congratulations, <span class="rm-user-name"><?php echo  $current_user->user_nicename?>!</span></h1>
            <p class="rm-user-milestone"><?php echo $data->review_message;?> </p>
                </div>
        
        <div class="rm-pop-up-rating">
        	<p class="rm-pop-up--wordpress-message">Would you like to rate us on WordPress.org</p>
                <p class="rm-pop-up--wordpress-sub-message">(This is really important to us.)</p>
        	<div class="rm-popup-anchors">
                
                <a onclick="handle_review_banner_click('wordpress','null')" href=""id="review_anchor"> Review</a> 
                <a onclick="handle_review_banner_click('remind','null')" href="" id="remind_anchor" href="" > Remind me later</a>
                </div>
           
        </div>    
    </div>
</div>
      </div>
     <pre class='rm-pre-wrapper-for-script-tags'><script>
    jQuery(document).ready(function(){
     jQuery('#wordpress_review').addClass('rm-hop');
     jQuery('#wordpress_review').siblings().addClass('rm-blur');
      });</script></pre>
    <?php
}
elseif($data->review_popup_flag=='feedback')
{
    ?>   <div class="feedback_message" id="feedback_message">
         <div id="rm-rate-popup-wrap">
	<div class="rm-rate-popup">

		<div class="rm-pop-up-head">
        	<h1>Congratulations, <span class="rm-user-name"><?php echo  $current_user->user_nicename?>!</span></h1>
            <p class="rm-user-milestone"><?php echo $data->review_message;?> </p>
                </div>
        
        <div class="rm-pop-up-rating">
            <p class="rm-pop-up--wordpress-message">Please let us know how we can improve by taking out few minutes to <a href=""   onclick="handle_review_banner_click('feedback','null')">fill this form</a></p>
                <p class="rm-pop-up--wordpress-sub-message">(This is really important to us.)</p>
            <div class="rm-pop-up-skip">
            	<a href=""  onclick="handle_review_banner_click('skip','null')" >Skip</a>
            </div>
        </div>    
    </div>
</div>
    </div>
    <pre class='rm-pre-wrapper-for-script-tags'><script>
    jQuery(document).ready(function(){
     jQuery('#feedback_message').addClass('rm-hop');
     jQuery('#feedback_message').siblings().addClass('rm-blur');
      });</script></pre>
    <?php
}
?>
        <div id="rm_embed_code_dialog" style="display:none"><textarea readonly="readonly" id="rm_embed_code" onclick="jQuery(this).focus().select()"></textarea><img class="rm-close" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/close-rm.png'; ?>" onclick="jQuery('#rm_embed_code_dialog').fadeOut()"></div>
        
</div>
 <div class="rm-side-banner">

            <div class="rm-sidebaner-section-title dbfl"><img src="<?php echo RM_IMG_URL; ?>icon.png"><span>Want More?</span></div>

            <div class="rm-sidebanner-image">
                <img src="<?php echo RM_IMG_URL; ?>Layer 1.png" />
            </div>

            <div class="sidebanner-content-wrapper">
                <div class="sidebanner-text-content">
                    <p>While Standard Edition is pretty powerful system in its own right, there's more from where it's coming from. RegistrationMagic's Silver and Gold upgrades are crammed to the top with features, great new options and comes with top class support. It takes less than <b>5 minutes</b> to upgrade and all your stuff is <b>transferred automatically</b></p>			
                </div>
                <div class="rm-sidebanner-buttons">
                    <div class="rm-sidebanner-button silver">
                        <a href="http://registrationmagic.com/?download_id=317&edd_action=add_to_cart">GET SILVER</a>				
                    </div>

                    <div class="rm-sidebanner-button gold">
                        <a href="http://registrationmagic.com/?download_id=19544&edd_action=add_to_cart">GET GOLD</a>
                    </div>			
                </div>

                <div class="rm-sidebanner-compare">

                    <div class="rm-sidebanner-compare-l">
                        <a href="https://registrationmagic.com/comparison/">Compare</a>
                    </div>

                    <div class="rm-sidebanner-compare-r">
                        <a href="https://registrationmagic.com/help-support/">Questions?</a>				
                    </div>			

                </div>

                <div class="rm-sidebanner-icons">
                    <img src="<?php echo RM_IMG_URL; ?>icon-pack.png">
                </div>

            </div> <!-- sidebanner-content-wrapper -->
        </div>
  <pre class="rm-pre-wrapper-for-script-tags"><script type="text/javascript">
   
    function rm_open_dial(form_id){
        jQuery('textarea#rm_embed_code').html('<?php echo RM_UI_Strings::get('MSG_BUY_PRO_GOLD_EMBED'); ?>');
        jQuery('#rm_embed_code_dialog').fadeIn(100);
    }
    jQuery(document).mouseup(function (e) {
        var container = jQuery("#rm_embed_code_dialog,.rm_form_card_settings_dialog");
        if (!container.is(e.target) // if the target of the click isn't the container... 
                && container.has(e.target).length === 0) // ... nor a descendant of the container 
        {
            container.hide();
        }
    });
    
    function make_me_a_star(e){
        var form_id = jQuery(e).attr('id').slice(8);
        if(typeof form_id != 'undefined' && !jQuery(e).hasClass('rm_def_form_star')){
        var data = {
			'action': 'set_default_form',
			'rm_def_form_id': form_id
		};

        jQuery.post(ajaxurl, data, function(response) {
                        var old_form = jQuery('.rm_def_form_star');
			old_form.removeClass('rm_def_form_star');
                        old_form.addClass('rm_not_def_form_star');
                        
                        var curr_form = jQuery('#rm-star_'+form_id);
                        curr_form.removeClass('rm_not_def_form_star');
                        curr_form.addClass('rm_def_form_star');
		});
            }
    }
    
    function rm_show_form_sett_dialog(form_id){
        jQuery("#rm_settings_dailog_"+form_id).show();
    }
      
jQuery("#rm_rateit_banner").bind('rated', function (event, value) { 
        if(value<=3)
        {
            
             jQuery("#rm-rate-popup-wrap").fadeOut();  
             jQuery("#wordpress_review").fadeOut(100);  
             jQuery("#feedback_message").fadeIn(100);  
             jQuery('#feedback_message').removeClass('rm-blur');
             jQuery('#feedback_message').addClass('rm-hop');
             handle_review_banner_click('rating',value);
        }
        else
        {
             jQuery("#rm-rate-popup-wrap").fadeOut();  
             jQuery("#feedback_message").fadeOut();  
             jQuery("#wordpress_review").fadeIn(100);
             jQuery('#wordpress_review').removeClass('rm-blur');
             jQuery('#wordpress_review').addClass('rm-hop');
             handle_review_banner_click('rating',value);
        }
    
    
    });
  </script></pre>




