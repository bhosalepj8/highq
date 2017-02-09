<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($data);die;
?>

<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $form = new RM_PFBC_Form("form_sett_general");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));
        
        
        
        


        if (isset($data->model->form_id)) {
            $form->addElement(new Element_HTML('<div class="rmheader">' . $data->model->form_name . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmsettingtitle">' . RM_UI_Strings::get('LABEL_F_GLOBAL_OVERRIDE_SETT') . '</div>'));
            $form->addElement(new Element_Hidden("form_id", $data->model->form_id));
        } else {
            $form->addElement(new Element_HTML('<div class="rmheader">' . RM_UI_Strings::get("TITLE_NEW_FORM_PAGE") . '</div>'));
        }
        $form->addElement(new Element_HTML('<div class="rmnotice rm-invite-field-row"><b>' . RM_UI_Strings::get("GLOBAL_OVERRIDES_NOTE") . '</b></div>     
'));
         $form->addElement(new Element_Radio("<b>" . RM_UI_Strings::get('LABEL_SHOW_PROG_BAR') . ":</b>", "display_progress_bar", array('yes'=>RM_UI_Strings::get('LABEL_YES'),'no'=>RM_UI_Strings::get('LABEL_NO'),'default'=>RM_UI_Strings::get('LABEL_DEFAULT')), array("id"=>"id_form_actrl_date_type","class"=>"rm_deactivated","readonly"=>"readonly","disabled"=>"disabled", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
       $form->addElement(new Element_Radio("<b>" . RM_UI_Strings::get('LABEL_ENABLE_CAPTCHA') . "</b>", "enable_captcha", array('no'=>RM_UI_Strings::get('LABEL_NO'),'default'=>RM_UI_Strings::get('LABEL_DEFAULT')), array("id"=>"id_rm_enable_captcha_cb","value" => "","class"=>"rm_deactivated","readonly"=>"readonly","disabled"=>"disabled", "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
        $form->addElement(new Element_Number(RM_UI_Strings::get('LABEL_SUB_LIMIT_ANTISPAM'), "sub_limit_antispam", array("value" => "","class"=>"rm_deactivated","readonly"=>"readonly","disabled"=>"disabled", "step" => 1, "min" => 0, "longDesc" => RM_UI_Strings::get('MSG_BUY_PRO_BOTH_INLINE'))));
      
        if(!isset($data->model->form_id))
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; Cancel', 'javascript:void(0)', array('class' => 'cancel', 'onClick' => 'window.history.back();')));
        else
            $form->addElement (new Element_HTMLL ('&#8592; &nbsp; Cancel', '?page=rm_form_sett_manage&rm_form_id='.$data->model->form_id, array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE'), "submit", array("id" => "rm_submit_btn", "class" => "rm_btn", "name" => "submit", "onClick" => "jQuery.prevent_field_add(event,'This is a required field.')")));
        $form->render();
        ?>
    </div>
</div>

<?php
