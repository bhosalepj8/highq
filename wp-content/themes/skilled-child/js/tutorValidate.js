/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
    var currentYear = new Date().getFullYear();
    jQuery( "#dob_date" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: "1980:"+currentYear,
    defaultDate: "01/01/1991"
    });
//    
//    jQuery.validator.setDefaults({
//        debug: true,
//        success: "valid"
//    });

    
     jQuery("#tutor_registration").validate({   
        ignore: [],
        rules: {
            tutor_firstname: "required",
            tutor_lastname: "required",
            tutor_email_1: {
                required: true,
                email: true
            },
            tutor_email_2: {
                required: true,
                email: true,
            },
            tutor_password: "required",
            tutor_confpassword: {
                required : true,
                equalTo: "#tutor_password"
            },
            dob_date : "required",
            tutor_phone: {
                required : true,
//                number: true,
                phoneUS: true
            },
//            tutor_NRIC : "required",
            tutor_address1: "required",
            tutor_state_1 : "required",
            tutor_zipcode1: "required",
            tutor_city_1 : "required",
            tutor_qualification: "required",
            tutor_year_passing: "required",
            "chk_tutor_documents[]": "required",
            "documents[]":{
            required:true,
            extension: "docx|rtf|doc|pdf"
            },
////            tutor_yourself: "required",
            tutor_nationality: "required",
            tutor_state_2: "required",
            tutor_zip: "required",
            documents2:{
            required:true,
            extension: "mp4|ogv|webm"
            },
            hourly_rate: "required",
            currency: "required"
        },
        messages: {
            tutor_firstname: "Please enter your first name",
            tutor_lastname: "Please enter your last name",
            tutor_email_1: "Please enter a valid email address",
            tutor_email_2: "Please enter a valid email address",
            tutor_password: "Please enter your password",
            tutor_confpassword: {
                required : "Please re-enter your password",
                equalTo: "Password not matched with old one"
            },
            dob_date : "Please select DOB",
            tutor_phone: {
                phoneUS: "Please enter valid number"
            },
//            tutor_NRIC : "Please enter your NRIC number",
            tutor_state_1 : "Please select State",
            tutor_zipcode1: "Please enter Zip Code",
            tutor_city_1 : "Please select City",
            tutor_qualification: "Enter your qualification",
            tutor_year_passing: "Please select passing year",
            "chk_tutor_documents[]": "Please check documents you have",
            "documents[]":{
            required:"Select document to upload",
            extension: "Select valied input file format"
            },
////            tutor_yourself: "Enter information about yourself", 
            tutor_nationality: "Please enter nationality",
            tutor_state_2: "Please enter state",
            tutor_zip: "please enter zip code",
            documents2:{
            required:"Please upload video",
            extension: "Select valied input file format"
            },
            hourly_rate: "Please enter hourly rate",
            currency: "Please select currency"
        }
    });
    
    jQuery(document).on( 'change', '#documents2', upload_video);
    
    function upload_video(event){
        jQuery("#upload_video_div").html("");
        
        if(jQuery("#documents2").valid()){
            jQuery("#img-loader").show();
        jQuery("#tutor_registration").ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=display_selected_video",
            type: 'post',
//            dataaction:"display_selected_video",
            success:function result(response){
                jQuery("#img-loader").hide();
                jQuery("#upload_video_div").html(response);
                var video_js_id = jQuery(".video-js").attr('id');
                videojs(video_js_id, {}, function(){
                    // Player (this) is initialized and ready.
                });
                
            }
        });}
    }
    
    jQuery(document).on( 'change', '#tutor_country_1', getalltutorstates);
    jQuery(document).on( 'change', '#tutor_country_2', getalltutorstates);
    function getalltutorstates(){
//        debugger;
        var selected_country_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        console.log(selected_country_code);
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_all_states",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        country_no : i
                    },
                    success:function(result){
                        if(result !=""){
                       jQuery("#div_tutor_state"+i).html(result);}
                       else{
                           jQuery("#div_tutor_state"+i).html('<input class="form-control" id="tutor_state1" name="tutor_state1" placeholder="Enter State Name"/>');
                       }
                    }
                });
    }
    jQuery(document).on( 'change', '#tutor_state_1', getalltutorcities);
//    jQuery(document).on( 'change', '#tutor_state_2', getalltutorcities);

    function getalltutorcities(){
        var selected_state_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        selected_country_code = jQuery("#tutor_country_"+i).val();
        console.log(selected_state_code);
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_all_cities",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        selected_state_code :selected_state_code,
                        country_no : i
                    },
                    success:function(result){
                        if(result !=""){
                       jQuery("#div_tutor_city"+i).html(result);}
                       else{
                           jQuery("#div_tutor_city"+i).html('<input class="form-control" id="tutor_city_1" name="tutor_city_1" placeholder="Enter City Name"/>');
                       }
                    }
                });
    }
    window.addDashes = function addDashes(f) {
    var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    f.value = f.value.replace(r, '');
    npa = f.value.substr(0, 3);
    nxx = f.value.substr(3, 3);
    last4 = f.value.substr(6, 4);
    f.value = npa + '-' + nxx + '-' + last4;
}
});

//Function to add Language Block
function addLanguageBlock(){
    var language_count = parseInt(jQuery("#language_count").val());
    var rowCount = language_count + 1;
    var language_known = jQuery("#language_known_"+language_count).val();
     
     if(language_known == "")
     {
         jQuery("#span_error").show();
     }
     else{
         jQuery("#span_error").hide();
         jQuery("#div_languages").append("<div class='clearfix additional-language' id='language_div_"+rowCount+"'><div class='col-md-6 mar-top-10 languages'><div class='form-group'>\n\
        <label for='exampleInputName2'>Language known</label> <input type='text' class='form-control' id='language_known_"+rowCount+"' name='language_known["+rowCount+"]' placeholder='Language Known'></div>\n\
        <div class='form-group'> <input name='chk_lang_read["+rowCount+"]' id='chk_lang_read_"+rowCount+"' value='read' type='checkbox'> Read <input name='chk_lang_write["+rowCount+"]' id='chk_lang_write_"+rowCount+"' value='write' type='checkbox'> Write \n\
        <input name='chk_lang_speak["+rowCount+"]' id='chk_lang_speak_"+rowCount+"' value='speak' type='checkbox'> Speak </div></div>\n\
        <span id='action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addLanguageBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#language_count").val(parseInt(rowCount));
        jQuery("#action_"+language_count).html("<a href='javascript:void(0);' onclick='removeLanguageBlock("+language_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

//Function to remove Language Block
function removeLanguageBlock(count){
    jQuery("#language_div_"+count).remove();
}

//funcion to add subject block
function addSubjectBlock(){
    var subject_count = parseInt(jQuery("#subject_count").val());
    var rowCount = subject_count + 1;
    var prev_subjects_teach = jQuery("#subjects_"+subject_count).val();
     if(prev_subjects_teach == "")
     {
         jQuery("#span_error").show();
     }
     else{
         jQuery("#span_error").hide();
         jQuery("#div_subjects").append("<div class='clearfix' id='subjects_div_"+rowCount+"'><div class='col-md-4 mar-top-10'><div class='form-group'>\n\
        <label for='exampleInputName2'>Subjects can teach</label><input id='subjects_"+rowCount+"' class='form-control' name='subjects["+rowCount+"]'></div></div>\n\
        <div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Level</label><select id='grade_"+rowCount+"' class='form-control' name='grade["+rowCount+"]'>\n\
        <option>Select Level</option><option>Level 1</option><option>Level 2</option><option>Level 3</option></select></div></div>\n\
        <span id='sub_action_"+rowCount+"'><a href='javascript:void(0);' onclick='addSubjectBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#subject_count").val(parseInt(rowCount));
        jQuery("#sub_action_"+subject_count).html("<a href='javascript:void(0);' onclick='removeSubjectBlock("+subject_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

//funcion to remove subject block
function removeSubjectBlock(count){
    jQuery("#subjects_div_"+count).remove();
}