/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
    var currentYear = new Date().getFullYear();
    var todaysdate = new Date();
    jQuery( "#dob_date" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: "1920:"+currentYear,
    defaultDate: "01/01/1991",
    maxDate: todaysdate
    });

    jQuery( ".from_date" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    minDate: todaysdate
    });
    
    jQuery( ".from_time" ).timepicker();
    
    jQuery( "#history_from_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate: todaysdate
    });
    
    jQuery( "#history_to_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate: todaysdate
    });
    
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
                phoneUS: true
            },
            tutor_address1: "required",
            tutor_state_1 : "required",
            tutor_zipcode1: "required",
            tutor_city_1 : "required",
            tutor_qualification: "required",
            tutor_year_passing: "required",
            "chk_tutor_documents[]": "required",
            "documents_1[]":{
            extension: "docx|rtf|doc|pdf"
            },
            tutor_nationality: "required",
            tutor_state_2: "required",
            tutor_zip: "required",
            documents2:{
            extension: "mp4|ogv|webm"
            },
            hourly_rate: "required",
            currency: "required"
        },
        messages: {
            tutor_firstname: "Enter First name",
            tutor_lastname: "Enter Last name",
            tutor_email_1: "Enter a valid email address",
            tutor_email_2: "Enter a valid email address",
            tutor_password: "Enter your password",
            tutor_confpassword: {
                required : "Re-enter your password",
                equalTo: "Password do not match"
            },
            dob_date : "Select DOB",
            tutor_phone: {
                required : "Enter Contact No",
                phoneUS: "Enter valid number"
            },
            tutor_state_1 : "Select State",
            tutor_zipcode1: "Enter Zip Code",
            tutor_city_1 : "Select City",
            "documents_1[]":{
            extension: "Select valid input file format"
            },
            tutor_qualification: "Enter your qualification",
            tutor_year_passing: "Select passing year",
            "chk_tutor_documents[]": "Please check documents you have",
            tutor_nationality: "Enter nationality",
            tutor_state_2: "Select state",
            tutor_zip: "Enter zip code",
            documents2:{
            extension: "Select valid input file format"
            },
            hourly_rate: "Enter hourly rate",
            currency: "Select currency"
        }
    });
    
    jQuery("#tutor_myaccount").validate({
        rules: {
             course_title: "required",
             course_detail: "required",
             subject: "required",
             curriculum: "required",
             tutoring_type: "required",
             grade: "required",
             no_of_student: "required",
             course_video:{
            extension: "mp4|ogv|webm"
            },
            "course_material[]":{
            extension: "docx|rtf|doc|pdf"
            },
            from_date: "required",
            from_time: "required",
            "days_of_week[]": "required",
                    
        },
        messages:{
            course_title: "Select Course",
            course_detail: "Enter Course Information",
            subject: "Select Subject",
            curriculum: "Select Curriculum",
            tutoring_type: "Select Type",
            grade:"Select Grade",
            no_of_student: "Select no of students",
            course_video:{
            extension: "Select valid input file format"
            },
            "course_material[]":{
            extension: "Select valid input file format"
            },
            from_date: "Select Date",
            from_time: "Select Time",
            "days_of_week[]": "required",
        }
    });
    
    jQuery("#tutor_myaccount_1on1").validate({
        rules: {
             cat_1on1: "required",
             curriculum_1on1: "required",
             grade_1on1: "required",
             "subject_1on1[]":{
                 required:true,
             },
             reference_video:{
            extension: "mp4|ogv|webm"
            },
            "documents_1[]":{
            extension: "docx|rtf|doc|pdf"
            },
            "from_1on1date[]": "required",
            "from_1on1time[]": "required"
        },
        messages:{
             cat_1on1: "Select Course type",
             curriculum_1on1: "Select Curriculum",
             grade_1on1: "Select Grade",
             "subject_1on1[]":{
                 required:"Select Subject",
             },
             reference_video:{
            extension: "Select valid input file format"
            },
            "documents_1[]":{
            extension: "Select valid input file format"
            },
            "from_1on1date[]": "Select Date",
            "from_1on1time[]": "Select Time"
        }
    });
    
    jQuery(document).on( 'change', '#tutor_country_1', getalltutorstates);
    jQuery(document).on( 'change', '#tutor_country_2', getalltutorstates);
    function getalltutorstates(){
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
    function getalltutorcities(){
        var selected_state_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        selected_country_code = jQuery("#tutor_country_"+i).val();
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

function upload_video(id,form_id){
        jQuery("#"+form_id+" #upload_video_div").html("");
//        var id= event.target.id;
        if(jQuery("#"+id).valid()){
        jQuery("#img-loader2").show();
        jQuery("#"+form_id).ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=display_selected_video",
            type: 'post',
            data:{
                id : id
            },
            success:function result(response){
                jQuery("#img-loader2").hide();
                jQuery("#"+form_id+" #upload_video_div").html(response);
                var video_js_id = jQuery("#"+form_id+" .video-js").attr('id');
                videojs(video_js_id, {}, function(){
                    // Player (this) is initialized and ready.
                });
            }
        });}
    }

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
        <label for='exampleInputName2'>Language Proficiency</label> <input type='text' class='form-control' id='language_known_"+rowCount+"' name='language_known["+rowCount+"]' placeholder='Enter Language Name'></div>\n\
        <span id='lang_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addLanguageBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#language_count").val(parseInt(rowCount));
        jQuery("#lang_action_"+language_count).html("<a href='javascript:void(0);' onclick='removeLanguageBlock("+language_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
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
        <label for='exampleInputName2'>Subject Taught</label><select id='subjects_"+rowCount+"' class='form-control' name='subjects["+rowCount+"]'></select></div></div>\n\
        <div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Grade</label><select id='grade_"+rowCount+"' class='form-control' name='grade["+rowCount+"]'>\n\
        </select></div></div><div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Level</label><select id='level_"+rowCount+"' class='form-control' name='level["+rowCount+"]'>\n\
        </select></div><span id='sub_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addSubjectBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#subjects_"+subject_count+" option").clone().appendTo('#subjects_'+rowCount);
        jQuery("#grade_"+subject_count+" option").clone().appendTo('#grade_'+rowCount);
        jQuery("#level_"+subject_count+" option").clone().appendTo('#level_'+rowCount);
        jQuery("#grade_"+subject_count).rules("add",{required: true});
        jQuery("#level_"+subject_count).rules("add",{required: true});
        jQuery("#subjects_"+subject_count).rules("add",{required: true});
        jQuery("#subject_count").val(parseInt(rowCount));
        jQuery("#sub_action_"+subject_count).html("<a href='javascript:void(0);' onclick='removeSubjectBlock("+subject_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

//funcion to remove subject block
function removeSubjectBlock(count){
    jQuery("#subjects_div_"+count).remove();
}

function remove_doc(form,doc_no){
    form_id = form.id;
//    var url = jQuery("#link_"+doc_no).attr("href");
//    jQuery.ajax({
//                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=remove_doc",
//                    type: "POST",
//                    data: {
//                        doc_url : url
//                    },
//                    success:function(result){
                       jQuery("#"+form_id+" #doc_div_"+doc_no).remove();
//                    }
//                });
}


//Function to add Language Block
function addQualificationBlock(){
    var educational_count = parseInt(jQuery("#educational_count").val());
   
    var rowCount = educational_count + 1;
    var tutor_qualification = jQuery("#tutor_qualification_"+educational_count).val();
    var tutor_institute = jQuery("#tutor_institute_"+educational_count).val();
    var tutor_year_passing = jQuery("#tutor_year_passing_"+educational_count).val();
    var documents = jQuery("#documents_"+educational_count).val();
     if(tutor_qualification == "" || tutor_institute =="" || tutor_year_passing == "" )
     {
         jQuery("#span_eduerror").show();
     }
     else{
         jQuery("#span_eduerror").hide();
         jQuery("#div_educational").append("<div class='clearfix' id='educational_div_"+rowCount+"'><div class='form-inline clearfix'><div class='col-md-3'>\n\
            <label for='exampleInputName2'>Qualification</label> <input type='text' class='form-control' id='tutor_qualification_"+rowCount+"' name='tutor_qualification["+rowCount+"]' placeholder='Enter Qualification'></div><div class='col-md-3'>\n\
            <label for='exampleInputName2'>Name of Institute</label> <input type='text' class='form-control' id='tutor_institute_"+rowCount+"' name='tutor_institute["+rowCount+"]' placeholder='Institute'></div><div class='col-md-2'>\n\
            <label for='exampleInputName2'>Year of Completion</label><select id='tutor_year_passing_"+rowCount+"' class='form-control' name='tutor_year_passing[]'></select></div><div class='col-md-3 choose-file'>\n\
            <label for='exampleInputFile'>Upload Documents Copy</label><input id='documents_"+rowCount+"' class='display-inline' name='documents_"+rowCount+"[]' type='file' onchange='upload_files(tutor_registration,"+rowCount+")' multiple/><div id='documents_display_div_"+rowCount+"'></div></div>\n\
            <span id='edu_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addQualificationBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div></div>");
        jQuery("#tutor_year_passing_"+educational_count+" option").clone().appendTo('#tutor_year_passing_'+rowCount);
        jQuery("#educational_count").val(parseInt(rowCount));
        jQuery("#tutor_year_passing_"+educational_count).rules("add",{required: true});
        jQuery("#tutor_qualification_"+educational_count).rules("add",{required: true});
        jQuery("#tutor_institute_"+educational_count).rules("add",{required: true});
        jQuery("#documents_"+educational_count).rules("add",{extension: "docx|rtf|doc|pdf"});
        jQuery("#edu_action_"+educational_count).html("<a href='javascript:void(0);' onclick='removeQualificationBlock("+educational_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeQualificationBlock(count){
    jQuery("#educational_div_"+count).remove();
}

function addCourseBlock(){
    var material_count = parseInt(jQuery("#material_count").val());
    var rowCount = material_count + 1;
    var course_material = jQuery("#course_material_"+material_count).val();
     if(course_material == "")
     {
         jQuery("#span_error").show();
     }
     else{
        jQuery("#span_error").hide();
        jQuery("#div_material").append("<div class='clearfix' id='course_material_div_"+rowCount+"'><div class='clearfix'><div class='col-md-8 upload-course'><div class='form-group'>\n\
            <label for='exampleInputName2'>Course Material</label><p class='field-para'><input type='file' name='documents_"+rowCount+"[]' id='documents_"+rowCount+"' onchange='upload_files(tutor_myaccount,"+rowCount+")'/></p><div id='documents_display_div_"+rowCount+"'></div></div>\n\
            <span id='course_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addCourseBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div></div>");
        jQuery("#material_count").val(parseInt(rowCount));
        jQuery("#course_action_"+material_count).html("<a href='javascript:void(0);' onclick='removeCourseBlock("+material_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeCourseBlock(count){
    jQuery("#course_material_div_"+count).remove();
}

function addDateTimeBlock(){
    var date_time_count = parseInt(jQuery("#date_time_count").val());
    var rowCount = date_time_count + 1;
    var from_date = jQuery("#from_date_"+date_time_count).val();
    var from_time = jQuery("#from_time_"+date_time_count).val();
    
     if(from_date == "" || from_time == "")
     {
         jQuery("#spantime_error").show();
     }
     else{
        jQuery("#spantime_error").hide();
        jQuery("#div_date_time").append("<div class='clearfix' id='date_time_div_"+rowCount+"'><div class='col-md-8 date-time'><div class='form-group'>\n\
            <label for='exampleInputName2'>Date & Time</label><p class='field-para'><input id='from_date_"+rowCount+"' class='form-control from_date' name='from_date[]' type='text' placeholder='Date'/> <span class='glyphicon glyphicon-calendar'></span> <input id='from_time_"+rowCount+"' class='form-control from_time' name='from_time[]' type='text' placeholder='Time'/></p></div>\n\
            <span id='date_time_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addDateTimeBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div></div>");
        jQuery("#date_time_count").val(parseInt(rowCount));
        jQuery("#date_time_action_"+date_time_count).html("<a href='javascript:void(0);' onclick='removeDateTimeBlock("+date_time_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
        setDate();
    }
}

function removeDateTimeBlock(count){
    jQuery("#date_time_div_"+count).remove();
}

function setDate(){
    var todaysdate = new Date();
    jQuery( ".from_date" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    minDate: todaysdate
    });
    jQuery( ".from_time" ).timepicker();
    }
    
function upload_files(form_id, key){
       form_id = form_id.id;
        var count = jQuery("#"+form_id+" #doc_count").val();
       
        if(jQuery("#"+form_id+" #documents_"+key).valid()){
            jQuery("#"+form_id+" #img-loader1").show();
        jQuery("#"+form_id).ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=display_upload_files",
            type: 'post',
            dataType:"json",
            data:{
                id:'documents_'+key
            },
            success:function result(response){
                var res = JSON.stringify(response);
                var result = JSON.parse(res);
                var obj = result.result;
                jQuery("#"+form_id+" #img-loader1").hide();
                var row = [];
                obj.forEach(function(element) {
                    row.push(element);
                    jQuery("#"+form_id+" #documents_display_div_"+key).append("<div id='doc_div_"+count+"' class='uploaded-files'><a href='"+element+"' target='_blank' id='link_"+count+"'>Doc</a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc("+form_id+","+count+")'>X</a><br/>\n\
                   <input type='hidden' name='old_uploaded_docs["+key+"]["+count+"]' value='"+row+"'></div>");
                    count++;
                    
                });
//                 jQuery("#"+form_id+" #doc_div_"+key).append("");
                jQuery("#"+form_id+" #doc_count").val(count);
//                jQuery("#documents_"+key).val("");
            }
        });}
    }
    
//function upload_course_material(key){
//        var count = jQuery("#doc_count").val();
//        if(jQuery("#course_material_"+key).valid()){
//            jQuery("#img-loader1").show();
//        jQuery("#tutor_myaccount").ajaxSubmit({
//            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=display_upload_files",
//            type: 'post',
//            dataType:"json",
//            data:{
//                id:'course_material_'+key
//            },
//            success:function result(response){
//                var res = JSON.stringify(response);
//                var result = JSON.parse(res);
//                var obj = result.result;
//                jQuery("#img-loader1").hide();
//                var row = [];
//                obj.forEach(function(element) {
//                    jQuery("#documents_display_div_"+key).append("<div id='doc_div_"+count+"' class='uploaded-files'><a href='"+element+"' target='_blank' id='link_"+count+"'>Doc</a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc("+count+")'>X</a><br/>\n\
//                   </div>");
//                    count++;
//                    row.push(element);
//                });
//                 jQuery("#documents_display_div_"+key).append("<input type='hidden'  name='old_uploaded_docs["+key+"]["+count+"]' value='"+row+"'>");
//                jQuery("#doc_count").val(count);
//            }
//        });}
//    }
    
    function show_course_title(){
        var val = jQuery("#course_title").val();
        if(val!="" && val == "add_new"){
            jQuery("#new_course_titlediv").show();
        }else{
            jQuery("#new_course_titlediv").hide();
        }
    }
    
    //Function to add Language Block
function addSubjectsBlock(){
    var subject_count = parseInt(jQuery("#subject_count").val());
    var rowCount = subject_count + 1;
    var sub_1on1 = jQuery("#subject_1on1_"+subject_count).val();
     if(sub_1on1 == "")
     {
         jQuery("#spansubject_error").show();
     }
     else{
         jQuery("#spansubject_error").hide();
         jQuery("#sunject_1on1_div").append("<div class='clearfix' id='subject_div_"+rowCount+"'><div class='col-md-4 subject'><div class='form-group'>\n\
        <label for='exampleInputName2'></label><select class='form-control' id='subject_1on1_"+rowCount+"' name='subject_1on1[]'></select></div>\n\
        <span id='subject_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addSubjectsBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div></div>");
        jQuery("#subject_1on1_"+subject_count+" option").clone().appendTo('#subject_1on1_'+rowCount);
        jQuery("#subject_count").val(parseInt(rowCount));
        jQuery("#subject_action_"+subject_count).html("<a href='javascript:void(0);' onclick='removeSubjectsBlock("+subject_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

//Function to remove Language Block
function removeSubjectsBlock(count){
    jQuery("#subject_div_"+count).remove();
}

//Tutor myaccount add material
function addMaterialBlock(){
    var material_count = parseInt(jQuery("#1on1_material_count").val());
    var rowCount = material_count + 1;
    var form_id = "tutor_myaccount_1on1";
    var course_material = jQuery("#1on1_material_"+material_count).val();
     if(course_material == "")
     {
         jQuery("#1on1_span_error").show();
     }
     else{
        jQuery("#1on1_span_error").hide();
        jQuery("#1on1_div_material").append("<div class='clearfix' id='1on1_material_div_"+rowCount+"'><div><div class='form-group'>\n\
            <label for='exampleInputName2'>Material</label><p class='field-para'><input type='file' name='documents_"+rowCount+"[]' id='documents_"+rowCount+"' onchange='upload_files("+form_id+","+rowCount+")'/></p><div id='documents_display_div_"+rowCount+"'></div></div>\n\
            <span id='material_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addMaterialBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#1on1_material_count").val(parseInt(rowCount));
        jQuery("#material_action_"+material_count).html("<a href='javascript:void(0);' onclick='removeMaterialBlock("+material_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeMaterialBlock(count){
    jQuery("#1on1_material_div_"+count).remove();
}

function add1on1DateTimeBlock(){
    var date_time_count = parseInt(jQuery("#1on1_date_time_count").val());
    var rowCount = date_time_count + 1;
    var from_date = jQuery("#from_1on1date_"+date_time_count).val();
    var from_time = jQuery("#1on1_from_time_"+date_time_count).val();
    
     if(from_date == "" || from_time == "")
     {
         jQuery("#spandatetime_error").show();
     }
     else{
        jQuery("#spandatetime_error").hide();
        jQuery("#div_1on1_date_time").append("<div class='form-inline clearfix' id='1on1_date_time_div_"+rowCount+"'><div class='col-md-6'>\n\
            <label for='exampleInputName2'>Date & Time</label><p class='field-para'><input id='from_1on1date_"+rowCount+"' class='form-control from_date' name='from_1on1date[]' type='text' placeholder='Date'/><span class='glyphicon glyphicon-calendar'></span><input id='from_1on1time_"+rowCount+"' class='form-control from_time' name='from_1on1time[]' type='text' placeholder='Time'/></p></div>\n\
            <span id='date_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='add1on1DateTimeBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#1on1_date_time_count").val(parseInt(rowCount));
        jQuery("#date_action_"+date_time_count).html("<a href='javascript:void(0);' onclick='remove10n1DateTimeBlock("+date_time_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
        setDate();
    }
}

function remove10n1DateTimeBlock(count){
    jQuery("#1on1_date_time_div_"+count).remove();
}

//Call to function to get order details
function get_order_details(){
    var history_from_date = jQuery("#history_from_date").val();
    var history_to_date = jQuery("#history_to_date").val();
    var order_status = jQuery("#order_status").val();
    jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_order_table_history",
                    type: "POST",
                    data: {
                        history_from_date : history_from_date,
                        history_to_date :history_to_date,
                        order_status : order_status
                    },
                    success:function(result){
                       
                    }
                });
}