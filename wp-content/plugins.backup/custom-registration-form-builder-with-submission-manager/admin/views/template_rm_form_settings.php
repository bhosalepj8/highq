<?php
/*
 * This page shows the form settings page
 * It consissts of different icons with the link to specific form settings.
 */
?>
<link rel="stylesheet" type="text/css" href="<?php echo RM_BASE_URL . 'admin/css/'; ?>style_rm_form_dashboard.css">
<pre class="rm-pre-wrapper-for-script-tags"><script src="<?php echo RM_BASE_URL . 'admin/js/'; ?>script_rm_form_dashboard.js"></script></pre>
<pre class='rm-pre-wrapper-for-script-tags'><script>
    //Takes value of various status variables (form_id, timeline_range) and reloads page with those parameteres updated.
    function rm_refresh_stats(){
    var form_id = jQuery('#rm_form_dropdown').val();
    var trange = jQuery('#rm_stat_timerange').val();
    if(typeof trange == 'undefined')
        trange = <?php echo $data->timerange; ?>;
    window.location = '?page=rm_form_sett_manage&rm_form_id=' + '<?php echo $data->form_id; ?>' + '&rm_tr='+trange;
}
</script></pre>
<div class="rm-form-configuration-wrapper">
    <div class="rm-grid-top dbfl">
        <div class="rm-grid-title difl"><?php echo $data->form->get_form_name(); ?></div>
        <span class="rm-grid-button difl"><a class="rm_fd_link" href="?page=rm_form_sett_general"><?php echo RM_UI_Strings::get('FD_LABEL_ADD_NEW'); ?></a></span>
        <span class="rm-grid-button difr" onclick="jQuery(this).hide();jQuery('#rm_form_toggle').show()"><?php echo RM_UI_Strings::get('FD_LABEL_SWITCH_FORM'); ?></span>
        <!--    Forms toggle-->
        <span class="rm-grid-button difr" id="rm_form_toggle" style="display: none">
            <select onchange="rm_fd_switch_form(jQuery(this).val(), <?php echo $data->timerange; ?>)">
                <?php
                echo "<option value=''>" . RM_UI_Strings::get('FD_FORM_TOGGLE_PH') . "</option>";
                foreach ($data->all_forms as $form_id => $form_name):
                    echo "<option value='$form_id'>$form_name</option>";
                endforeach;
                ?>
            </select>
        </span>
        <div class="dbfl"><?php echo RM_UI_Strings::get('NO_EMBED_CODE'); ?> </div>
    </div>
    <div class="rm-grid difl"> 
        
                <!--  -->
            <div class="rm-grid-section dbfl">
                <div class="rm-grid-section-title dbfl rm-box-title"><?php echo RM_UI_Strings::get('LABEL_SUBS_OVER_TIME'); ?></div>
                <div class="rm-timerange-toggle rm-timerange-dashboard">
                <?php echo RM_UI_Strings::get('LABEL_SELECT_TIMERANGE'); ?>
                    <select id="rm_stat_timerange" onchange="rm_refresh_stats()">
                    <?php $trs = array(7,30,60,90); 

                    foreach($trs as $tr)
                    {
                        echo "<option value=$tr";
                        if($data->timerange == $tr)
                            echo " selected";
                        printf(">".RM_UI_Strings::get("STAT_TIME_RANGES")."</option>",$tr);
                    }
                    ?>

                </select>
                </div>
                <div class="rm-box-graph" id="rm_subs_over_time_chart_div">
                </div>
            </div>
        
        <!-- dummy spacer -->
        <div class="rm-grid-spacer"> </div>
        <!--    -->
        
        <div class="rm-grid-section dbfl">
            <div class="rm-grid-section-title dbfl">
                <?php echo RM_UI_Strings::get('FD_BASIC_DASHBOARD'); ?> <span class="rm-query-ask">?</span>
                <div class="difr rm-grid-section-title-button"><span class="rm-grid-button"><a target="_blank" href="https://registrationmagic.com/comparison/" class="rm_fd_link">upgrade</a></span></div>
                <div style="display:none" class="rm-query-answer">Standard Edition dashboard offers you all the features to get starting with building registration system on your site. For more powerful options consider upgrading to <a href="http://registrationmagic.com/?download_id=19544&edd_action=add_to_cart">Gold</a> or <a href="http://registrationmagic.com/?download_id=317&edd_action=add_to_cart">Silver Bundle</a></div>
            </div>
            <div class="rm-grid-icon difl">
                <a href="?page=rm_submission_manage&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">   
                    <div class="rm-grid-icon-area dbfl">
                        <div class="rm-grid-icon-badge"><?php echo $data->sub_count; ?></div>
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-inbox.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_INBOX'); ?></div>
                </a>
            </div> 

            <div class="rm-grid-icon difl">
                <a href="?page=rm_analytics_show_form&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">   
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-analytics.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('TITLE_FORM_STAT_PAGE'); ?></div>
                </a>
            </div> 

            <div class="rm-grid-icon difl"> 
                <a href="?page=rm_form_sett_view&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">   
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-view.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('FD_LABEL_DESIGN'); ?></div>
                </a>
            </div> 
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_field_manage&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <div class="rm-grid-icon-badge"><?php echo $data->field_count; ?></div>
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-custom-fields.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('FD_LABEL_FORM_FIELDS'); ?></div>
                </a>
            </div>
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_invitations_manage&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>email-users.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('TITLE_INVITES'); ?></div>
                </a>
            </div> 
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_form_sett_general&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-settings.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_GEN_SETT'); ?></div>
                </a>
            </div>
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_form_sett_accounts&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-accounts.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_ACC_SETT'); ?></div>
                </a>
            </div> 
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_form_sett_post_sub&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>post-submission.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_PST_SUB_SETT'); ?></div>
                </a>
            </div> 
            
             <div class="rm-grid-icon difl">
                <a href="?page=rm_form_sett_autoresponder&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>auto-responder.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_AUTO_RESP_SETT'); ?></div>
                </a>
            </div> 
            
            <div class="rm-grid-icon difl">
                <a href="?page=rm_form_sett_limits&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">    
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>form-limits.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_LIM_SETT'); ?></div>
                </a>
            </div>
            
            <div class="rm-grid-icon difl">  
                <a href="?page=rm_form_sett_mailchimp&rm_form_id=<?php echo $data->form_id; ?>" class="rm_fd_link">  
                    <div class="rm-grid-icon-area dbfl">
                        <img class="rm-grid-icon dibfl" src="<?php echo RM_IMG_URL; ?>mailchimp.png">
                    </div>
                    <div class="rm-grid-icon-label dbfl"><?php echo RM_UI_Strings::get('LABEL_F_MC_SETT'); ?></div>
                </a>
            </div> 
        </div>
        
    </div>
    <div class="rm-grid-sidebar-1 difl">
        <div class="rm-grid-section-cards dbfl">        
            <?php
            if($data->sub_count == 0):
                ?>
            <div class="rm-grid-sidebar-card dbfl">
                <div class='rmnotice-container'><div class="rmnotice-container"><div class="rm-counter-box">0</div><div class="rm-counter-label"><?php echo RM_UI_Strings::get('LABEL_REGISTRATIONS'); ?></div></div></div>  
</div>
                <?php
            endif;
            foreach ($data->latest_subs as $submission):
                ?>
                <div class="rm-grid-sidebar-card dbfl">
                    <a href="?page=rm_submission_view&rm_submission_id=<?php echo $submission->id; ?>" class="fd_sub_link">
                    <?php echo $submission->is_read? '' : "<div class='rm-grid-user-badge'>". RM_UI_Strings::get('FD_BADGE_NEW')."!</div>"; ?>
                    <div class="rm-grid-card-profile-image dbfl">
                        <img class="fd_img" src="<?php echo $submission->user_avatar; ?>">
                    </div>
                    <div class="rm-grid-card-content difl">
                        <div class="dbfl"><?php echo $submission->user_name; ?></div>
                        <div class="rm-grid-card-content-subtext dbfl"><?php echo $submission->submitted_on ?></div></div>
                    </a>
                </div>
                <?php
            endforeach;
            ?>
            <div class="rm-grid-quick-tasks dbfl">
                <div class="rm-grid-sidebar-row dbfl">
                    <div class="rm-grid-sidebar-row-label difl">
                        <a class="<?php echo $data->sub_count ? '' : 'rm_deactivated'?>" href="?page=rm_submission_manage&rm_form_id=<?php echo $data->form_id; ?>"><?php echo RM_UI_Strings::get('FD_LABEL_VIEW_ALL'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rm-grid-section-cards dbfl"> 

            <div class="rm-grid-sidebar-card dbfl">
                <div class='rmnotice-container'><div class="rmnotice-container"><div class="rm-counter-box">0</div><div class="rm-counter-label"><?php echo RM_UI_Strings::get('TITLE_ATTACHMENT_PAGE'); ?></div></div></div>  
            </div>

            <div class="rm-grid-quick-tasks dbfl">
                <div class="rm-grid-sidebar-row dbfl">
                    <div class="rm-grid-sidebar-row-label difl">
                        <a class="rm_deactivated" href="javascript:void(0)"><?php echo RM_UI_Strings::get('FD_LABEL_VIEW_ALL'); ?></a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="rm-grid-sidebar-2 difl">
        <div class="rm-grid-section dbfl">
            <div class="rm-grid-section-title dbfl">
                <?php echo RM_UI_Strings::get('FD_LABEL_STATUS'); ?>
                <span class="rm-grid-section-toggle rm-collapsible"></span>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>shortcode.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_LABEL_FORM_SHORTCODE'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><span id="rmformshortcode">[RM_Form id='<?php echo $data->form->get_form_id(); ?>']</span><a href="javascript:void(0)" onclick="rm_copy_to_clipboard(document.getElementById('rmformshortcode'))"><?php echo RM_UI_Strings::get('FD_LABEL_COPY'); ?></a>
                    <div style="display:none" id="rm_msg_copied_to_clipboard">Copied to clipboard</div><div style="display:none" id="rm_msg_not_copied_to_clipboard">Could not be copied. Please try manually.</div></div>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>visiblity.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_LABEL_FORM_VISIBILITY'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->form_access; ?><a href="?page=rm_form_sett_access_control&rm_form_id=<?php echo $data->form_id; ?>"><?php echo RM_UI_Strings::get('LABEL_EDIT'); ?></a></div>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>event.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_LABEL_FORM_CREATED_ON'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo RM_Utilities::localize_time($data->form->get_created_on()); ?></div>
            </div>

            <div class="rm-grid-quick-tasks dbfl">
                <div class="rm-grid-sidebar-row dbfl">
                    <div class="rm-grid-sidebar-row-label difl">
                        <a href="javascript:void(0)" onclick="jQuery.rm_do_action_with_alert('<?php echo RM_UI_Strings::get('ALERT_DELETE_FORM'); ?>', 'rm_fd_action_form', 'rm_form_remove')"><?php echo RM_UI_Strings::get('LABEL_DELETE'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rm-grid-section dbfl">
            <div class="rm-grid-section-title dbfl">
                <?php echo RM_UI_Strings::get('FD_LABEL_CONTENT'); ?>
                <span class="rm-grid-section-toggle rm-collapsible"></span>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>pages.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_FORM_PAGES'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo 1; ?></div>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>field.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_LABEL_F_FIELDS'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->field_count; ?><a href="?page=rm_field_manage&rm_form_id=<?php echo $data->form->get_form_id(); ?>"><?php echo RM_UI_Strings::get('LABEL_ADD'); ?></a></div>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>submit.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_FORM_SUBMIT_BTN_LABEL'); ?>:</div>
               <div class="rm-grid-sidebar-row-value difl"><div id="rm-submit-label"><?php echo $data->form_options->form_submit_btn_label ? : 'Submit'; ?></div><a href='javascript:;' onclick='edit_label()' ><?php echo RM_UI_Strings::get('LABEL_FIELD_ICON_CHANGE'); ?></a></div>
                <div id="rm-submit-label-textbox" style="display:none"><input type="text" id="submit_label_textbox"/><div><input type="button" value ="Save" onclick="save_submit_label()"><input type="button" value ="Cancel" onclick="cancel_edit_label()"></div></div> </div>
            <div class="rm-grid-quick-tasks dbfl">
                <div class="rm-grid-sidebar-row dbfl">
                    <div class="rm-grid-sidebar-row-label difl">
                        <a href="javascript:void(0)" onclick="jQuery.rm_do_action('rm_fd_action_form', 'rm_form_duplicate')"><?php echo RM_UI_Strings::get('LABEL_DUPLICATE'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="rm-grid-section dbfl">
            <div class="rm-grid-section-title dbfl">
                <?php echo RM_UI_Strings::get('FD_LABEL_STATS'); ?>
                <span class="rm-grid-section-toggle rm-collapsible"></span>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>visitors.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_LABEL_VISITORS'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->visitors_count . ' in last 30 days'; ?></div>
            </div>
            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>submissions.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('LABEL_REGISTRATIONS'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->sub_count; ?><a href="javascript:void(0)" class="rm_deactivated"><?php echo RM_UI_Strings::get('FD_DOWNLOAD_REGISTRATIONS'); ?></a></div>
            </div>

            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>conversion.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('LABEL_CONVERSION'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->conversion_rate; ?>%</div>
            </div>

            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>avgtime.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_AVG_TIME'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><?php echo $data->avg_time; ?></div>
            </div>


            <div class="rm-grid-quick-tasks dbfl">
                <div class="rm-grid-sidebar-row dbfl">
                    <div class="rm-grid-sidebar-row-label difl">
                        <a href="javascript:void(0)" onclick="jQuery.rm_do_action_with_alert('You are going to delete all stats for selected form. Do you want to proceed?', 'rm_fd_action_form', 'rm_analytics_reset')"><?php echo RM_UI_Strings::get('LABEL_RESET'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rm-grid-section dbfl">
            <div class="rm-grid-section-title dbfl">
                <?php echo RM_UI_Strings::get('FD_LABEL_QCK_TOGGLE'); ?>
                <span class="rm-grid-section-toggle rm-collapsible"></span>
            </div>

             <?php if($data->form_options->form_email_subject && $data->form_options->form_email_content)
                  {
                        $deactivation_class = '';
                        $tooltip = '';
                  }else{
                        $deactivation_class = 'rm_transparent_deactivated';
                        $tooltip = 'title="'.sprintf(RM_UI_Strings::get('FD_TOGGLE_TOOLTIP'),admin_url('admin.php?page=rm_form_sett_autoresponder&rm_form_id='.$data->form_id)).'"';
                  }
                
             ?>
            <div   <?php echo $tooltip; ?> class="rm-grid-sidebar-row dbfl <?php echo $deactivation_class; ?>">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>auto-responder.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl" ><?php echo RM_UI_Strings::get('FD_AUTORESPONDER'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl<?php echo ($data->form_options->form_email_subject && $data->form_options->form_email_content) ? '' : ' rm_deactivated' ?>"><div class="rm-grid-sidebar-row-value difl"><div class="switch">
                            <input id="rm-toggle-1"  class="rm-toggle rm-toggle-round-flat" onchange="rm_fd_quick_toggle(this, <?php echo $data->form_id; ?>)" name="form_should_send_email" type="checkbox"<?php echo $data->form->get_form_should_send_email() == 1 ? ' checked' : '' ?>>
                            <label for="rm-toggle-1"></label>
                        </div></div></div>
            </div>

            <div class="rm-grid-sidebar-row dbfl">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>form-accounts.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('FD_WP_REG'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl"><div class="rm-grid-sidebar-row-value difl"><div class="switch">
                            <input id="rm-toggle-2" class="rm-toggle rm-toggle-round-flat" onchange="rm_fd_quick_toggle(this, <?php echo $data->form_id; ?>)" name="form_type" type="checkbox"<?php echo $data->form->get_form_type() == 1 ? ' checked' : '' ?>>
                            <label for="rm-toggle-2"></label>
                        </div></div></div>
            </div>

          <?php if($data->form_options->form_expired_by)
                  {
                        $deactivation_class = '';
                        $tooltip = '';
                  }else{
                        $deactivation_class = 'rm_transparent_deactivated';
                        $tooltip = 'title="'.sprintf(RM_UI_Strings::get('FD_TOGGLE_TOOLTIP'),admin_url('admin.php?page=rm_form_sett_limits&rm_form_id='.$data->form_id)).'"';
                  }
                
             ?>
            <div <?php echo $tooltip;?> class="rm-grid-sidebar-row dbfl <?php echo $deactivation_class; ?>">
                <div class="rm-grid-sidebar-row-icon difl">
                    <img src="<?php echo RM_IMG_URL; ?>form-limits.png">
                </div>
                <div class="rm-grid-sidebar-row-label difl"><?php echo RM_UI_Strings::get('LABEL_EXPIRY'); ?>:</div>
                <div class="rm-grid-sidebar-row-value difl<?php echo ($data->form_options->form_expired_by) ? '' : ' rm_deactivated' ?>"><div class="rm-grid-sidebar-row-value difl"><div class="switch">
                            <input id="rm-toggle-5" class="rm-toggle rm-toggle-round-flat" onchange="rm_fd_quick_toggle(this, <?php echo $data->form_id; ?>)" name="form_should_auto_expire" type="checkbox"<?php echo $data->form->get_form_should_auto_expire() == 1 ? ' checked' : '' ?>>
                            <label for="rm-toggle-5"></label>
                        </div></div></div>
            </div>

        </div>

    </div>

    <!-- action form to execute rm_slug_actions -->
    <form style="display:none" method="post" action="" id="rm_fd_action_form">
        <input type="hidden" name="rm_slug" value="" id="rm_slug_input_field">
        <input type="hidden" name="req_source" value="form_dashboard">
        <input type="hidden" name="rm_interval" value="all">
        <input type="number" name="form_id" value="<?php echo $data->form_id; ?>">
        <input type="number" name="rm_selected" value="<?php echo $data->form_id; ?>">
    </form

    <!--    Forms toggle-->
    <div id="rm_form_toggle" style="display: none">
        <select onchange="rm_fd_switch_form()">
            <?php
            foreach ($data->all_forms as $form_id => $form_name):
                echo "<option value='$form_id'>$form_name</option>";
            endforeach;
            ?>
        </select>
    </div>
</div>
<?php
            wp_enqueue_script('jquery-ui-tooltip',array('jquery'));
?>
<pre class='rm-pre-wrapper-for-script-tags'><script>
    function edit_label(){
        jQuery('#rm-submit-label-textbox').show();
    }
    
    function cancel_edit_label(){
        jQuery('#submit_label_textbox').val('');
        jQuery('#rm-submit-label-textbox').hide();
    }
    
    function save_submit_label(){
        
       var label= jQuery('#submit_label_textbox').val();
        if(label == '')
       {
           jQuery('#submit_label_textbox').focus();
           return 0;
       }
        var data = {
			'action': 'rm_save_submit_label',
			'label': label,
			'form_id':<?php echo $data->form_id ;?>
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
                    console.log(response);
                       if(response== 'changed')
                       {
                           jQuery('#rm-submit-label').html(label);
                           jQuery('#rm-submit-label-textbox').hide();
                       }
                       else
                       {
                           alert('Could not Change.Please try again.');
                           location.reload(); 
                       }
                      
		});
    }
    jQuery(function () { 
    jQuery(document).tooltip({
        content: function () {
            return jQuery(this).prop('title');
        },
        show: null, 
        close: function (event, ui) {
            ui.tooltip.hover(

            function () {
                jQuery(this).stop(true).fadeTo(400, 1);
            },

            function () {
                jQuery(this).fadeOut("400", function () {
                   jQuery(this).remove();
                })
            });
        }
    });
});

</script></pre>

<?php
/* * ****************************************************************
 * *************     Chart drawing - Line Chart        **************
 * **************************************************************** */
$data_string = '';
foreach ($data->day_wise_stat as $date => $per_day) {
    
        $formatted_name = $date;
        $data_string .= ", ['$formatted_name', " . $per_day->visits . ", $per_day->submissions]";
    
}
$data_string = substr($data_string, 2);
?>

<pre class='rm-pre-wrapper-for-script-tags'><script>

    function drawTimewiseStat()
    {
        var data = google.visualization.arrayToDataTable([
            ['<?php echo RM_UI_Strings::get('LABEL_DATE'); ?>',
             '<?php echo RM_UI_Strings::get('LABEL_VISITS'); ?>',
             '<?php echo RM_UI_Strings::get('LABEL_SUBMISSIONS'); ?>'],
<?php echo $data_string; ?>
        ]);

        var options = {
            chartArea: {width: '90%'},
            height: 500,
            fontName: 'Titillium Web',
            hAxis: {
                title: '',
                minValue: 0,
                slantedText: false,
                maxAlternation: 1,
                maxTextLines: 1
            },
            vAxis: {
                title: '',
                viewWindow: {min: 0},
                minValue: 4,
            },
            legend: {position: 'top', maxLines: 3},
            colors: ['#8eb2cc', '#e2a1c4'],
            
        };
        
        var chart = new google.visualization.LineChart(document.getElementById('rm_subs_over_time_chart_div'));
        chart.draw(data, options);
    }
</script></pre>
