/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
    jQuery('#Carousel').carousel({
        interval: 5000
    });
    
    pricefilter();
    jQuery("#result").html("");
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
    
    jQuery( ".from_time" ).timepicker({
        addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
    });
    
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
    jQuery( "#refine_from_date" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    });
    jQuery( "#session_from_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    minDate: todaysdate
    });
    
    jQuery( "#session_to_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    minDate: todaysdate
    });
    
    //Calender Datepicker
    var eventDates = [];
    var outofstockDates = [];
    var currenthref = location.href;
//            if(currenthref.split('/')[5] == "tutor-public-profile"){
            if(currenthref.split('/')[4] == "tutor-public-profile"){
            var user_id = jQuery("#user_id").val();
            jQuery.ajax({ 
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_availability_dates",
            type: "POST",
            dataType:"json",
            async: false,
            data:{
                user_id: user_id
            },
            success:function result(response){
                var res = JSON.stringify(response);
                var result = JSON.parse(res);
                var obj = result.result;
                eventDates = obj.eventDates;
                outofstockDates = obj.outofstockDates;
            }
            });
            }
     
    jQuery("#cal_datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: todaysdate,
        beforeShowDay: available,
        onSelect: get_data_by_date,
    });   
    
    function available(date){
        month   = date.getMonth() < 10 ? '0' + (date.getMonth()+1) : (date.getMonth()+1);
        datetxt   = date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate();
        var checkdate = date.getFullYear()+"-"+month+"-"+datetxt;
        if (eventDates && jQuery.inArray(checkdate,eventDates) >= 0) {
             return [true, "calevent"];
        }
        else if (outofstockDates && jQuery.inArray(checkdate,outofstockDates) >= 0) {
             return [true, "outofevent"];
        }       
        else {
             return [true, '', ''];
        }
    }
    
    function get_data_by_date(date){
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({ 
        url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_sessions_bydate",
        type: "POST",
        async: false,
        data:{
            user_id: user_id,
            date: date
        },
        success:function result(response){
                jQuery("#sessions_div").html(response);
                jQuery(".loader").fadeOut("slow");
        }
        });
    }
    
    function gettutorTimezone(){
        var offset = (new Date()).getTimezoneOffset();
        var timezones = {
            '-12': 'Pacific/Kwajalein',
            '-11': 'Pacific/Samoa',
            '-10': 'Pacific/Honolulu',
            '-9': 'America/Juneau',
            '-8': 'America/Los_Angeles',
            '-7': 'America/Denver',
            '-6': 'America/Mexico_City',
            '-5': 'America/New_York',
            '-4': 'America/Caracas',
            '-3.5': 'America/St_Johns',
            '-3': 'America/Argentina/Buenos_Aires',
            '-2': 'Atlantic/Azores',
            '-1': 'Atlantic/Azores',
            '0': 'Europe/London',
            '1': 'Europe/Paris',
            '2': 'Europe/Helsinki',
            '3': 'Europe/Moscow',
            '3.5': 'Asia/Tehran',
            '4': 'Asia/Baku',
            '4.5': 'Asia/Kabul',
            '5': 'Asia/Karachi',
            '5.5': 'Asia/Calcutta',
            '6': 'Asia/Colombo',
            '7': 'Asia/Bangkok',
            '8': 'Asia/Singapore',
            '9': 'Asia/Tokyo',
            '9.5': 'Australia/Darwin',
            '10': 'Pacific/Guam',
            '11': 'Asia/Magadan',
            '12': 'Asia/Kamchatka' 
        };


        var myTimezone = timezones[-offset / 60];
        return  myTimezone;
     }
    
     jQuery("#tutor_registration").validate({   
        rules: {
            tutor_firstname: {
                required: true,
                nameVal: true
            },
            tutor_lastname: {
                required: true,
                nameVal: true
            },
            tutor_email_1: {
                required: true,
                email: true
            },
            tutor_email_2: {
                email: true,
            },
            tutor_password: {
                required : true,
                paswdval : true,
            },
            tutor_confpassword: {
                required : true,
                paswdval : true,
                equalTo: "#tutor_password"
            },
            dob_date : "required",
            tutor_phone: {
                required : true,
                telvalidate: true,
            },
            tutor_address1: "required",
            tutor_gender : "required",
            tutor_zipcode1: "required",
            tutor_qualification: "required",
            tutor_qualifications: "required",
            tutor_year_passing: "required",
            "chk_tutor_documents[]": "required",
            documents_1:{
            extension: "docx|rtf|doc|pdf"
            },
            tutor_nationality: "required",
            tutor_state_2: "required",
            tutor_zip: "required",
            tutor_video:{
            extension: "mp4|ogv|webm|mov|wmv"
            },
            hourly_rate:{
                required : true,
                digits: true
            },
            currency: "required"
        },
        messages: {
            tutor_firstname: {
                required: "Enter First name",
            },
            tutor_lastname: {
                required: "Enter Last name",
            },
            tutor_email_1: "Enter a valid email address",
            tutor_email_2: "Enter a valid email address",
            tutor_password: {
                required : "Enter your password"
            },
            tutor_confpassword: {
                required : "Re-enter your password",
                equalTo: "Password do not match"
            },
            dob_date : "Select DOB",
            tutor_phone: {
                required : "Enter Contact No",
            },
            tutor_gender : "Select Gender",
            tutor_zipcode1: "Enter Zip Code",
            documents_1:{
            extension: "Select valid input file format"
            },
            tutor_qualification: "Enter your qualification",
            tutor_year_passing: "Select passing year",
            "chk_tutor_documents[]": "Please check documents you have",
            tutor_nationality: "Enter nationality",
            tutor_state_2: "Select state",
            tutor_zip: "Enter zip code",
            tutor_video:{
            extension: "Select valid input file format"
            },
            hourly_rate:{
                required : "Enter hourly rate",
                digits: "Plese enter digits only"
            },
            currency: "Select currency"
        },
        submitHandler: function(form) {
            var country = jQuery("#tutor_phone").intlTelInput("getSelectedCountryData");
            jQuery("#contact_num_1").val(country.iso2);
            var Timezone;
            Timezone = gettutorTimezone();
            jQuery("#timezone").val(Timezone);
            if(jQuery("#edit_mode").val() != "1"){
            jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=check_user_email_exists",
            type: 'post',
            async:false,
            data:{
                email_id: jQuery("#tutor_email_1").val()
            },
            success:function result(response){
               if(!response){
                   jQuery(".loader").fadeIn("slow");
                    form.submit();
               }else{
                   alert("Email Already Exists");
                   jQuery("#tutor_email_1").focus();
               }}
            });
            }else{
                jQuery(".loader").fadeIn("slow");
                form.submit();
            }
        }
    });
    
    jQuery.validator.addMethod("telvalidate", function(value , element, field) {
        var re = /^[\d\s+-]+$/;
        var bool = re.test(value);
        if(bool){
        return jQuery("#"+element.id).intlTelInput("isValidNumber");
        }else{
            return bool;
        }
    }, jQuery.validator.format("Enter valid contact number"));
    
    jQuery.validator.addMethod("paswdval", function(value , element) {
        if(value != ""){
        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
        return re.test(value);
        }else{
            return true;
        }   
    }, jQuery.validator.format("Min 8 chars. Atleast 1 Uppercase, 1 Lowercase and 1 Number"));
    
    jQuery.validator.addMethod("nameVal", function(value , element) {
        var re = /^[a-zA-Z ]+$/;
        return re.test(value);
    }, jQuery.validator.format("Only letters are allowed"));
    
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
            extension: "mp4|ogv|webm|mov|wmv"
            },
            documents_1:{
            extension: "docx|rtf|doc|pdf"
            },
            "from_date[]": "required",
            "from_time[]": "required",
            "session_topic[]": "required",
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
            documents_1:{
            extension: "Select valid input file format"
            },
            "from_date[]": "Select Date",
            "from_time[]": "Select Time",
            "session_topic[]": "Enter Topic"
        },
        submitHandler: function(form) {
            jQuery("#date_spantime_error").html("");
            var datessend = [],timesend=[];
            user_id = jQuery("#user_id").val();
            var dates = jQuery("#"+form.id+" .from_date");
            var times = jQuery("#"+form.id+" .from_time");
            
            for(var i = 0; i < dates.length; i++){
                datessend.push(jQuery(dates[i]).val());
                timesend.push(jQuery(times[i]).val());
            }
            
            var response;
            var edit_mode = jQuery("#"+form.id+" #edit_mode").val();
            var product_id = jQuery("#"+form.id+" #product_id").val();
            
            jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=check_user_sessiontimedate",
            type: 'post',
            async:false,
            data:{
                session_dates: datessend,
                session_times: timesend,
                user_id: user_id,
                edit_mode: edit_mode,
                product_id: product_id
            },
            success:function result(result){
               response = parseInt(result);
            }
            });
            if(response){
               jQuery("#"+form.id+" #btn_addsession").prop('disabled', true);
               jQuery(".loader").fadeIn("slow");
               form.submit();
            }else{
                jQuery("#date_spantime_error").html("You already have a session on the selected Date & Time.");
                return false;
            }
        }
    });
    
    jQuery("#tutor_myaccount_1on1").validate({
        rules: {
             cat_1on1: "required",
             curriculum_1on1: "required",
             grade_1on1: "required",
             subject_1on1:{
                 required:true,
             },
             reference_video:{
            extension: "mp4|ogv|webm|mov|wmv"
            },
            documents_1:{
            extension: "docx|rtf|doc|pdf"
            },
            "from_1on1date[]": "required",
            "from_1on1time[]": "required",
            "session_1on1topic[]": "required"
        },
        messages:{
             cat_1on1: "Select Course type",
             curriculum_1on1: "Select Curriculum",
             grade_1on1: "Select Grade",
             subject_1on1:{
                 required:"Select Subject",
             },
             reference_video:{
            extension: "Select valid input file format"
            },
            documents_1:{
            extension: "Select valid input file format"
            },
            "from_1on1date[]": "Select Date",
            "from_1on1time[]": "Select Time",
            "session_1on1topic[]": "Enter Topic"
        },
        submitHandler: function(form) {
            jQuery("#date_spantime_error_1on1").html("");
            
            var datessend = [],timesend=[];
            user_id = jQuery("#user_id").val();
            var dates = jQuery("#"+form.id+" .from_date");
            var times = jQuery("#"+form.id+" .from_time");
             for(var i = 0; i < dates.length; i++){
                datessend.push(jQuery(dates[i]).val());
                timesend.push(jQuery(times[i]).val());
            }
            var response;
            var edit_mode = jQuery("#"+form.id+" #edit_mode").val();
            var product_id = jQuery("#"+form.id+" #product_id").val();
            
            jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=check_user_sessiontimedate",
            type: 'post',
            async:false,
            data:{
                session_dates: datessend,
                session_times: timesend,
                user_id: user_id,
                edit_mode: edit_mode,
                product_id: product_id
                
            },
            success:function result(result){
               response = parseInt(result);
            }
            });
               if(response){
                   jQuery("#"+form.id+" #btn_addsession").prop('disabled', true);
                   jQuery(".loader").fadeIn("slow");
                   form.submit();
               }else{
                    jQuery("#date_spantime_error_1on1").html("You already have a session on the selected Date & Time.");
                    return false;
                }
        }
    });
    
    
    jQuery(document).on( 'change', '#tutor_country_1', getalltutorstates);
    jQuery(document).on( 'change', '#tutor_country_2', getalltutorstates);
    function getalltutorstates(){
        var selected_country_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
//        console.log(selected_country_code);
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_all_states",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        country_no : i
                    },
                    success:function(result){
                        jQuery(".loader").fadeOut("slow");
                        if(result !=""){
                       jQuery("#div_tutor_state"+i).html(result);}
                       else{
                           jQuery("#div_tutor_state"+i).html('<input class="form-control" id="tutor_state_1" name="tutor_state_1" placeholder="Enter State Name"/>');
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
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_all_cities",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        selected_state_code :selected_state_code,
                        country_no : i
                    },
                    success:function(result){
                        jQuery(".loader").fadeOut("slow");
                        if(result !=""){
                       jQuery("#div_tutor_city"+i).html(result);}
                       else{
                           jQuery("#div_tutor_city"+i).html('<input class="form-control" id="tutor_city_1" name="tutor_city_1" placeholder="Enter City Name"/>');
                       }
                    }
                });
    }
        
        jQuery("#tutor_country_1").change(function(e){
            jQuery("#tutor_phone").intlTelInput("setCountry", e.target.value);
            var tutor_NRIC = jQuery("#tutor_NRIC").val();
            if(e.target.value == "SG" && tutor_NRIC ==  ""){
                jQuery("#tutor_NRIC").focus();
                alert("NRIC is Mandatory for Singapore Resident.");
                jQuery("#tutor_NRIC").rules("add",{required: true});
            }else{
                jQuery("#tutor_NRIC").rules("remove","required");
            }
        });    
});

function upload_video(id,form_id){
        jQuery("#"+form_id+" #upload_video_div").html("");
//        var id= event.target.id;
        if(jQuery("#"+id).valid()){
        jQuery(".loader").fadeIn("slow");
        jQuery("#"+form_id).ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=display_selected_video",
            type: 'post',
            data:{
                id : id
            },
            success:function result(response){
               jQuery(".loader").fadeOut("slow");
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
        <label for='exampleInputName2'>Language Proficiency</label><p class='field-para'><input type='text' class='form-control' id='language_known_"+rowCount+"' name='language_known["+rowCount+"]' placeholder='Enter Language Name'><span id='lang_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addLanguageBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></p></div>\n\
        </div>");
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
     if(prev_subjects_teach == "" || jQuery("#grade_"+subject_count).val() == "" || jQuery("#level_"+subject_count).val() == "")
     {
         jQuery("#span_error").show();
     }
     else{
         jQuery("#span_error").hide();
         jQuery("#div_subjects").append("<div class='clearfix' id='subjects_div_"+rowCount+"'><div class='col-md-4 mar-top-10'><div class='form-group'>\n\
        <label for='exampleInputName2'>Subject Taught</label><p class='field-para'><select id='subjects_"+rowCount+"' class='form-control' name='subjects["+rowCount+"]' onchange='add_other_subjects("+rowCount+")'></select></p>\n\
        <div class='form-group' id='new_subject_titlediv_"+rowCount+"' style='display: none;'><label for='exampleInputName2'>New Subject Title</label><p class='field-para'><input type='text' id='new_subject_title_"+rowCount+"' name='new_subject_title["+rowCount+"]'/></p></div></div></div>\n\
        <div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Grade</label><p class='field-para'><select id='grade_"+rowCount+"' class='form-control' name='grade["+rowCount+"]'>\n\
        </select></p></div></div><div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Level</label><p class='field-para'><select id='level_"+rowCount+"' class='form-control' name='level["+rowCount+"]'>\n\
        </select></p></div><span id='sub_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addSubjectBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#subjects_"+subject_count+" option").clone().removeAttr("selected").appendTo('#subjects_'+rowCount);
        jQuery("#grade_"+subject_count+" option").clone().removeAttr("selected").appendTo('#grade_'+rowCount);
        jQuery("#level_"+subject_count+" option").clone().removeAttr("selected").appendTo('#level_'+rowCount);
        jQuery('#subjects_'+rowCount).val("");jQuery('#grade_'+rowCount).val("");jQuery('#level_'+rowCount).val("");
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
     if(tutor_qualification == "" || jQuery("#tutor_institute_"+educational_count).val() =="" || jQuery("#tutor_year_passing_"+educational_count).val() == "" )
     //|| jQuery("#documents_display_div_"+educational_count).children().length == 0
     {
         jQuery("#span_eduerror").show();
     }
     else{
         jQuery("#span_eduerror").hide();
         jQuery("#div_educational").append("<div class='clearfix' id='educational_div_"+rowCount+"'><div class='form-inline clearfix'><div class='col-md-3'>\n\
            <label for='exampleInputName2'>Document Type</label><p class='field-para'><select id='tutor_qualification_"+rowCount+"' class='form-control' name='tutor_qualification[]'></select></p></div><div class='col-md-3'>\n\
            <label for='exampleInputName2'>Name of Document</label><p class='field-para'><input type='text' class='form-control' id='tutor_institute_"+rowCount+"' name='tutor_institute["+rowCount+"]' placeholder='Institute'></p></div><div class='col-md-2'>\n\
            <label for='exampleInputName2'>Document Expiration Year(if applicable)</label><p class='field-para'><select id='tutor_year_passing_"+rowCount+"' class='form-control' name='tutor_year_passing[]'></select></p></div><div class='col-md-3 choose-file'>\n\
            <label for='exampleInputFile'>Upload Documents Copy</label><p class='field-para'><input id='documents_"+rowCount+"' class='display-inline' name='documents_"+rowCount+"' type='file' onchange='upload_files(tutor_registration,"+rowCount+")' /><small class='clearfix'>(Supported File Formats: docx|rtf|doc|pdf)</small></p><div id='documents_display_div_"+rowCount+"'></div></div>\n\
            <span id='edu_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addQualificationBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div></div>");
        jQuery("#tutor_year_passing_"+educational_count+" option").clone().removeAttr("selected").appendTo('#tutor_year_passing_'+rowCount);
        jQuery("#tutor_qualification_"+educational_count+" option").clone().removeAttr("selected").appendTo('#tutor_qualification_'+rowCount);
//        var selectedval = jQuery("#tutor_qualification_"+educational_count+" option:selected").val();
//        jQuery("#tutor_qualification_"+rowCount+" option[value='"+selectedval+"']").remove();
        jQuery('#tutor_year_passing_'+rowCount).val("");
        jQuery("#educational_count").val(parseInt(rowCount));
        jQuery("#tutor_year_passing_"+educational_count).rules("add",{required: true});
        jQuery("#tutor_qualification_"+educational_count).rules("add",{required: true});
        jQuery("#tutor_institute_"+educational_count).rules("add",{required: true});
        jQuery("#documents_"+rowCount).rules("add",{extension: "docx|rtf|doc|pdf"});
        jQuery("#edu_action_"+educational_count).html("<a href='javascript:void(0);' onclick='removeQualificationBlock("+educational_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeQualificationBlock(count){
    jQuery("#educational_div_"+count).remove();
}

function addCourseBlock(){
    var material_count = parseInt(jQuery("#material_count").val());
    var rowCount = material_count + 1;
    var course_material = jQuery("#documents_"+material_count).val();
     if(course_material == "")
     {
         jQuery("#course_span_error").show();
     }
     else{
        jQuery("#course_span_error").hide();
        jQuery("#div_material").append("<div class='clearfix' id='documents_div_"+rowCount+"'><div class='clearfix'><div class='col-md-8 upload-course'><div class='form-group'>\n\
            <label for='exampleInputName2'>Course Material</label><p class='field-para'><input type='file' name='documents_"+rowCount+"' id='documents_"+rowCount+"' onchange='upload_files(tutor_myaccount,"+rowCount+")'/></p> <div id='documents_display_div_"+rowCount+"' class='add-more-data'></div></div> <span id='course_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addCourseBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span>\n\
            </div></div>");
        jQuery("#documents_"+material_count).rules("add",{extension: "docx|rtf|doc|pdf"});
//        jQuery("#from_date_"+material_count).rules("add",{required: true});
        jQuery("#material_count").val(parseInt(rowCount));
        jQuery("#course_action_"+material_count).html("<a href='javascript:void(0);' onclick='removeCourseBlock("+material_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeCourseBlock(count){
    jQuery("#documents_div_"+count).remove();
}

function addDateTimeBlock(){
    var date_time_count = parseInt(jQuery("#date_time_count").val());
    var rowCount = date_time_count + 1;
    var from_date = jQuery("#from_date_"+date_time_count).val();
    var from_time = jQuery("#from_time_"+date_time_count).val();
    var session_topic = jQuery("#session_topic_"+date_time_count).val();
    
     if(from_date == "" || from_time == "" || session_topic == "")
     {
         jQuery("#spantime_error").show();
     }
     else{
        jQuery("#spantime_error").hide();
        jQuery("#div_date_time").append("<div class='clearfix' id='date_time_div_"+rowCount+"'><div class='col-md-12 date-time'><div class='form-group'>\n\
            <label for='exampleInputName2'>Date , Time & Session Topic</label><p class='field-para'><input id='from_date_"+rowCount+"' class='form-control from_date' name='from_date[]' type='text' placeholder='Date'/> <input id='from_time_"+rowCount+"' class='form-control from_time' name='from_time[]' type='text' placeholder='Time'/> <input type='text' id='session_topic_"+rowCount+"' name='session_topic[]' class='form-control' placeholder='Session Topic'/><span id='date_time_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addDateTimeBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></p></div>\n\
            </div></div>");
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
    minDate: todaysdate,
    });
    jQuery( ".from_time" ).timepicker({
        addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
    });
    }
    
function upload_files(form_id, key){
       form_id = form_id.id;
        var count = jQuery("#"+form_id+" #doc_count").val();
        
        if(jQuery("#"+form_id+" #documents_"+key).valid()){
           jQuery(".loader").fadeIn("slow");
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
                jQuery(".loader").fadeOut("slow");
                var row = [];
                obj.forEach(function(element) {
                    row.push(element);
                    jQuery("#"+form_id+" #documents_display_div_"+key).append("<div id='doc_div_"+count+"' class='uploaded-files'><a href='"+element+"' target='_blank' id='link_"+count+"' class='doc-file'><span class='glyphicon glyphicon-file'></span></a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc("+form_id+","+count+")'>X</a><br/>\n\
                   <input type='hidden' name='old_uploaded_docs["+key+"]["+count+"]' value='"+row+"'></div>");
                    count++;
                });
                jQuery("#"+form_id+" #doc_count").val(count);
            }
        });}
    }

    
    function show_course_title(){
        var val = jQuery("#course_title").val();
        if(val!="" && val == "add_new"){
            jQuery("#new_course_titlediv").show();
        }else{
            jQuery("#new_course_titlediv").hide();
        }
    }
    
    function add_other_subjects(sel){
        var val = jQuery.trim(jQuery("#subjects_"+sel).val());
        if(val!="" && val == "Other"){
            jQuery("#new_subject_titlediv_"+sel).show();
        }else{
            jQuery("#new_subject_titlediv_"+sel).hide();
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
        jQuery("#subject_1on1_"+subject_count+" option").clone().removeAttr("selected").appendTo('#subject_1on1_'+rowCount);
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
    var course_material = jQuery("#documents_"+material_count).val();
     if(course_material == "")
     {
         jQuery("#1on1_span_error").show();
     }
     else{
        jQuery("#1on1_span_error").hide();
        jQuery("#1on1_div_material").append("<div class='clearfix' id='1on1_material_div_"+rowCount+"'><div><div class='form-group'>\n\
            <label for='exampleInputName2'>Material</label><p class='field-para'><input type='file' name='documents_"+rowCount+"' id='documents_"+rowCount+"' onchange='upload_files("+form_id+","+rowCount+")'/></p><span id='material_action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addMaterialBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span>\n\
            <div id='documents_display_div_"+rowCount+"'></div></div></div>");
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
    var session_topic = jQuery("#session_1on1topic_"+date_time_count).val();
    
     if(from_date == "" || from_time == "" || session_topic == "")
     {
         jQuery("#spandatetime_error").show();
     }
     else{
        jQuery("#spandatetime_error").hide();
        jQuery("#div_1on1_date_time").append("<div class='col-md-12 date-time' id='1on1_date_time_div_"+rowCount+"'><div class='form-group'>\n\
            <label>Date , Time & Session Topic</label><p class='field-para'><input id='from_1on1date_"+rowCount+"' class='form-control from_date' name='from_1on1date[]' type='text' placeholder='Date'/><input id='from_1on1time_"+rowCount+"' class='form-control from_time' name='from_1on1time[]' type='text' placeholder='Time'/><input type='text' id='session_1on1topic_"+rowCount+"' name='session_1on1topic[]' class='form-control' placeholder='Session Topic'/></p></div>\n\
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
    var callurl;
    var history_from_date = jQuery("#history_from_date").val();
    var history_to_date = jQuery("#history_to_date").val();
    var order_status = jQuery("#order_status").val();
    if(order_status == "" ){
        var order_status = [];
        jQuery("#order_status option").each(function()
        {
            order_status.push(jQuery(this).val());
        });
    }
    var table = jQuery("#my_orders_list").DataTable();
    table.clear().draw();
    var role = jQuery("#user_role").val();
    if(role == "student"){
        callurl = Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_studentorder_table_history";
    }else{
        callurl = Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_order_table_history";
    }
     jQuery(".loader").fadeIn("slow");
    if(history_from_date != "" && history_to_date != ""){
    jQuery("#dateerror").hide();
    var completedtotal=pendingtotal=0;
    jQuery.ajax({
                    url: callurl,
                    type: "POST",
                    data: {
                        history_from_date : history_from_date,
                        history_to_date :history_to_date,
                        order_status : order_status
                    },
                    success:function(response){

                       jQuery(".loader").fadeOut("slow");
                       jQuery("#history_table").html("");
                       jQuery("#div_total_amt").html("");
                       var result = JSON.parse(response);
                       var obj = result.result;
                       if(obj.line_total != null){
                       var count = obj.line_total.length;
                       for(var i=0; i<count; i++){
//                           jQuery("#history_table").append('<tr id="'+obj.product_id[i]+'"><th scope="row">'+obj.order_date[i]+'</th><td>'+obj.product_name[i]+'</td><td>'+obj.line_total[i]+'</td><td>'+obj.post_status[i]+'</td></tr>');
//                           debugger;
                           var btn_cancel_requesthtml = "";
                           order_id = obj.order_id[i];
                           if(obj.post_status[i] == "Completed"){
                           completedtotal += parseFloat(obj.line_total[i]);
                           }else{
                           pendingtotal += parseFloat(obj.line_total[i]);
                           }
                           if(role == "student"){
                                btn_cancel_requesthtml = "<a class='btn btn-primary btn-sm' target='_blank' href='"+Urls.siteUrl+"/my-account/view-order/"+order_id+"'>View</a>";
//                                if(obj.Action[i] != 0)
//                                {   
//                                    btn_cancel_requesthtml += "<a class='btn btn-primary btn-sm cancelled' onclick='refund_using_wallet("+order_id+","+obj.line_total[i]+")'>Send Cancel Request</a>";
//                                }
                            }
//                            if(role == "tutor"){
//                                if(obj.Action[i] != 0)
//                                { 
//                                btn_cancel_requesthtml = "<a class='btn btn-primary btn-sm cancelled' onclick='refund_using_tutor_wallet("+order_id+","+obj.line_total[i]+")'>Send Cancel Request</a>";
//                                }
//                            }
                            
                           table.row.add( [obj.order_date[i],obj.product_name[order_id],obj.line_total[i],obj.post_status[i],btn_cancel_requesthtml] ).draw();
                       }
//                       jQuery("#div_total_amt").append('<label>Total Amount Received from</label><p class="field-para" ><span>'+history_from_date+'</span> to <span>'+history_to_date+'</span> - $'+completedtotal+'</p><br/>')
//                       jQuery("#div_total_amt").append('<label>Total Amount Pending from</label><p class="field-para" ><span>'+history_from_date+'</span> to <span>'+history_to_date+'</span> - $'+pendingtotal+'</p>')
                        }
                        else{
                            jQuery("#history_table").append('No results found for your search');
                        }
                    }
                });
        }else{
            jQuery("#dateerror").show();
        }
}

function change_cancelorder_status_request(order_id){
     jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=change_cancelorder_status_request",
                    type: "POST",
                    data: {
                        order_id : order_id,
                    },
                    success:function(response){
                        get_order_details();
                    }
                });
}

//Call to function to get Session details
function get_session_details(){
    var session_from_date = jQuery("#session_from_date").val();
    var session_to_date = jQuery("#session_to_date").val();
    var table = jQuery('#tbl_upcoming_sessions').DataTable();
    table.clear().draw();
    if(session_from_date != "" && session_to_date != ""){
    jQuery("#dateerror").hide();
//    jQuery(".loader").fadeIn("slow");
    jQuery("#tbl_sessionhistory").ajaxSubmit({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_session_table_history",
                    type: "POST",
                    success:function(response){
                        var total=0;
//                       jQuery(".loader").fadeOut("slow");
                       jQuery("#session_history_table").html("");
                       var result = JSON.parse(response);
                       var obj = result.result;
                       if(obj.product_id.length != 0){
                       var count = obj.product_id.length;
                       for(var i=0; i<count; i++){
                           var sessiondate = '';
                           var product_id = obj.product_id[i];
                           jQuery.each( obj.from_date[product_id], function( key , value ) {
                               sessiondate+=value+"<br/>";
                           });
                           table.row.add( [sessiondate,obj.name_of_course[i],obj.students_attending[product_id],obj.total_no_of_sessions[product_id],obj.attended_sessions[product_id],obj.session_status[product_id]] ).draw();
                        }
                        }else{
                            jQuery("#session_history_table").append('No results found for your search');
                        }
                    }
                });
        }else{
            jQuery("#dateerror").show();
        }
}

//Call to function to get Session details
function get_studentsession_details(){
    var session_from_date = jQuery("#session_from_date").val();
    var session_to_date = jQuery("#session_to_date").val();
    var table = jQuery("#tbl_student_sessions").DataTable();
    table.clear().draw();
    if(session_from_date != "" && session_to_date != ""){
    jQuery("#dateerror").hide();
//    jQuery(".loader").fadeIn("slow");
    jQuery("#tbl_sessionhistory").ajaxSubmit({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_studentsession_table_history",
                    type: "POST",
                    success:function(response){
                        var total=0;
//                       jQuery(".loader").fadeOut("slow");
                       jQuery("#session_history_table").html("");
                       var result = JSON.parse(response);
                       var obj = result.result;
                       if(obj.product_id != null){
                       var count = obj.product_id.length;
                       for(var i=0; i<count; i++){
                           var sessiondate = '';
                           var product_id = obj.product_id[i];
                           jQuery.each( obj.from_date[product_id], function( key , value ) {
                               sessiondate+=value+"<br/>";
                           });
                           table.row.add( [sessiondate,obj.name_of_course[i],obj.name_of_tutor[i],obj.total_no_of_sessions[product_id],obj.attended_sessions[product_id],obj.session_status[product_id]] ).draw();
                        }
                        }else{
                            jQuery("#session_history_table").append('No results found for your search');
                        }
                    }
                });
        }else{
            jQuery("#dateerror").show();
        }
}

function change_MTD(){
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    jQuery("#history_from_date").datepicker("setDate",firstDay);
    jQuery("#history_to_date").datepicker("setDate",date);
}
function change_YTD(){
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, 0, 1);
    jQuery("#history_from_date").datepicker("setDate",firstDay);
    jQuery("#history_to_date").datepicker("setDate",date);
}

function pricefilter(){
    jQuery("#result").html("$"+jQuery("#price").val());
}

function get_refined_courses(page_id){
        if(page_id == null)page_id = 1;
        jQuery(".loader").fadeIn("slow");

        jQuery("#course_filter").ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_refined_courses",
            type: 'post',
            data:{
                paged:page_id
            },
            success:function result(response){
               jQuery(".products").html("");
               jQuery(".loader").fadeOut("slow");
               jQuery(".products").html(response);
               var count = jQuery(".post_ids").length;
               if(count){
                for(i=1;i<=count;i++){
                    post_id = jQuery("#post_id_"+i).val();
                    video_js_id = jQuery("#"+post_id+"tutorvideoModal video").attr('id');
                    if(video_js_id != null){
                    var myPlayer = videojs(video_js_id);
                    jQuery("#"+post_id+"tutorvideoModal").on('hide.bs.modal', function (e) {
                    if(!myPlayer.paused()){
                        myPlayer.pause();
                    }
                  });}
                }
                }
            }
        });
}

function get_refined_tutors(page_id){
    if(page_id == null)page_id = 1;
        jQuery(".loader").fadeIn("slow");
        jQuery("#tutor_filter").ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_refined_tutors",
            type: 'post',
            data:{
                paged:page_id
            },
            success:function result(response){
               jQuery(".products").html("");
               jQuery(".loader").fadeOut("slow");
               jQuery(".products").html(response);
               var count = jQuery(".post_ids").length;
               if(count){
                for(i=1;i<=count;i++){
                    post_id = jQuery("#post_id_"+i).val();
                    video_js_id = jQuery("#"+post_id+"tutorvideoModal video").attr('id');
                    if(video_js_id != null){
                    var myPlayer = videojs(video_js_id);
                    jQuery("#"+post_id+"tutorvideoModal").on('hide.bs.modal', function (e) {
                    if(!myPlayer.paused()){
                        myPlayer.pause();
                    }
                    });}
                }}
            }
        });
}

function get_next_page_course(page_id){
    get_refined_courses(page_id);
}

function get_next_page_tutor(page_id){
    get_refined_tutors(page_id);
}

function search_tutorsproducts(e){
    if(e.which == 13) {
        get_refined_tutors();
    }
}

function search_coursesproducts(e){
    if(e.which == 13) {
        get_refined_courses();
    }
}

function get_tutor_availability(){
    jQuery(".loader").fadeIn("slow");
    subject = jQuery("#subject").val();
        jQuery("#tbl_availability").ajaxSubmit({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_tutor_availability",
            type: 'post',
            data:{
                subject: subject
            },
            success:function result(response){
               jQuery("#sessions_listing").html("");
               jQuery(".loader").fadeOut("slow");
               jQuery("#sessions_listing").html(response);
            }
        });
}

function get_freesession_popup(){
    jQuery( "#book_free_session").dialog( "open" );
}

function add_freeproduct(user_id){
    jQuery(".loader").fadeIn("slow");
    date = jQuery("#session_dates").val();
    time = jQuery('input[name=session_time]:checked').val();
    name_of_tutor = jQuery("#user_name").text();
    jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=add_freeproduct",
                    type: "POST",
                    data: {
                        session_date : date,
                        id_of_tutor : user_id,
                        product_id: '1129',
                        name_of_tutor: name_of_tutor,
                        session_time: time
                    },
                    success:function(result){
                       jQuery(".loader").fadeOut("slow");
                       if(result)
                           location.reload();
                    }
                });
}

function  get_time_by_sessiondate(){
    session_dates = jQuery("#session_dates").val();
    jQuery(".loader").fadeIn("slow");
    subject = jQuery("#subject").val();
        jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_time_by_sessiondate",
            type: 'post',
            data:{
                session_date: session_dates
            },
            success:function result(response){
               jQuery("#session_time_div").html("");
               jQuery(".loader").fadeOut("slow");
               jQuery("#session_time_div").html(response);
            }
        });
}

function get_next_page_related_courses(page_id){
    if(page_id == null)page_id = 1;
        var user_id = jQuery("#user_id").val();
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_refined_relatedtutors",
            type: 'post',
            data:{
                paged:page_id,
                user_id:user_id
            },
            success:function result(response){
               jQuery("#related_tutors").html("");
               jQuery(".loader").fadeOut("slow");
               jQuery("#related_tutors").html(response);
            }
        });
}

function edit_session_data(product_id){
        reset_form_fields();
        jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_product_data",
            type: 'post',
            data:{
                product_id:product_id
            },
            success:function result(response){
             var result = JSON.parse(response);
             var obj = result.result;
             
             if(obj.tutoring_type == "1on1"){
                 var count = jQuery("#tutor_myaccount_1on1 #doc_count").val();
                 jQuery("#10n1").tab('show');
                 jQuery("#cat_1on1").val(obj.product_cat_slug);
                 jQuery("#curriculum_1on1").val(obj.curriculum);
                 jQuery("#grade_1on1").val(obj.grade);
                 jQuery("#subject_1on1_1").val(obj.subject);
                 jQuery("#upload_video_div").val(obj.video_url);
                 
                 if(obj.video_html){
                 jQuery("#tutor_myaccount_1on1 #upload_video_div").html(obj.video_html);
                 var video_js_id = jQuery("#tutor_myaccount_1on1 .video-js").attr('id');
                    videojs(video_js_id, {}, function(){
                        // Player (this) is initialized and ready.
                    });
                }
                 jQuery.each( obj.from_date, function( key, value ) {
                     if(key)add1on1DateTimeBlock();
                     var d=new Date(value);
                     jQuery("#from_1on1date_"+(key+1)).datepicker( "setDate", d);
                     jQuery("#from_1on1time_"+(key+1)).val(obj.from_time[key]);
                     jQuery("#session_1on1topic_"+(key+1)).val(obj.session_topic[key]);
                 });
                 jQuery.each( obj.downloadable_files, function( key, element ) {
                    jQuery("#tutor_myaccount_1on1 #documents_display_div_1").append("<div id='doc_div_"+count+"' class='uploaded-files'><a href='"+element+"' target='_blank' id='link_"+count+"' class='doc-file'><span class='glyphicon glyphicon-file' class='doc-file'></span></a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc(tutor_myaccount,"+count+")'>X</a><br/>\n\
                    <input type='hidden' name='old_uploaded_docs["+count+"]["+key+"]' value='"+element+"'></div>");
                     count++;
                 });
                 jQuery("#tutor_myaccount_1on1 #doc_count").val(count);
                 jQuery("#tutor_myaccount_1on1 #product_id").val(product_id);
                 jQuery("#tutor_myaccount_1on1 #edit_mode").val(1);
                 jQuery("#tutor_myaccount_1on1 #btn_addsession").text("Update Session");
                 jQuery("#tutor_myaccount_1on1 #btn_addsession").after('<input type="button" class="cancel-btn" id="btn_cancel" name="btn_cancel" value="Cancel" onclick="reset_form_fields()">');
             }else if(obj.tutoring_type == "Course"){
                 var count = jQuery("#tutor_myaccount #doc_count").val();
                 jQuery("#course").tab('show');
                 jQuery("#course_title").val(obj.name_of_course);
                 jQuery("#course_detail").val(obj.course_description);
                 jQuery("#course_cat").val(obj.product_cat_slug);
                 jQuery("#subject").val(obj.subject);
                 jQuery("#curriculum").val(obj.curriculum);
                 jQuery("#grade").val(obj.grade);
                 jQuery("#no_of_student").val(obj.no_of_students);
                 
                 if(obj.video_html){
                 jQuery("#tutor_myaccount #upload_video_div").html(obj.video_html);
                 var video_js_id = jQuery("#tutor_myaccount .video-js").attr('id');
                    videojs(video_js_id, {}, function(){
                        // Player (this) is initialized and ready.
                    });
                }
                 jQuery.each( obj.from_date, function( key, value ) {
                     if(key)addDateTimeBlock();
                     var d=new Date(value);
                     jQuery("#from_date_"+(key+1)).datepicker( "setDate", d);
                     jQuery("#from_time_"+(key+1)).val(obj.from_time[key]);
                     jQuery("#session_topic_"+(key+1)).val(obj.session_topic[key]);

                 });
                 jQuery.each( obj.downloadable_files, function( key, element ) {
                    jQuery("#tutor_myaccount #documents_display_div_1").append("<div id='doc_div_"+count+"' class='uploaded-files'><a href='"+element+"' target='_blank' id='link_"+count+"' class='doc-file'><span class='glyphicon glyphicon-file'></span></a>&nbsp;<a href='javascript:void(0);' onclick='remove_doc(tutor_myaccount,"+count+")'>X</a><br/>\n\
                    <input type='hidden' name='old_uploaded_docs["+count+"]["+key+"]' value='"+element+"'></div>");
                     count++;
                 });
                 jQuery("#tutor_myaccount #doc_count").val(count);
                 jQuery("#tutor_myaccount #edit_mode").val(1);
                 jQuery("#tutor_myaccount #product_id").val(product_id);
                 jQuery("#tutor_myaccount #btn_addsession").text("Update Session");
                 jQuery("#tutor_myaccount #btn_addsession").after('<input type="button" class="cancel-btn" id="btn_cancel" name="btn_cancel" value="Cancel" onclick="reset_form_fields()">');
             }
            }
        });
}

//Reset NEw Course & 1on1 form fields
function reset_form_fields(){
    jQuery('#tutor_myaccount').resetForm();
    jQuery('#tutor_myaccount_1on1').resetForm();
    jQuery("#tutor_myaccount #upload_video_div").html("");
    jQuery("#tutor_myaccount_1on1 #upload_video_div").html("");
    jQuery("#tutor_myaccount_1on1 #btn_addsession").text("Add Session");
    jQuery("#tutor_myaccount_1on1 #btn_cancel").remove();
    
    jQuery("#tutor_myaccount #btn_addsession").text("Add Session");
    jQuery("#tutor_myaccount #btn_cancel").remove();
    jQuery("#tutor_myaccount #documents_display_div_1").html("");
    jQuery("#tutor_myaccount_1on1 #documents_display_div_1").html("");
    jQuery("#tutor_myaccount #doc_count").val(0);
    jQuery("#tutor_myaccount_1on1 #doc_count").val(0);
    
    var date_time_count = parseInt(jQuery("#tutor_myaccount #date_time_count").val());
    var date_time_count1on1 = parseInt(jQuery("#tutor_myaccount_1on1 #1on1_date_time_count").val());
    
    for(var i = 2; i <= date_time_count; i++){
        jQuery("#date_time_div_"+i).remove();
    }
    jQuery("#tutor_myaccount #date_time_count").val(1);
    for(var i = 2; i <= date_time_count1on1; i++){
        jQuery("#1on1_date_time_div_"+i).remove();
    }
    jQuery("#tutor_myaccount #date_time_count").val(1);
    jQuery("#tutor_myaccount_1on1 #1on1_date_time_count").val(1);
    jQuery("#tutor_myaccount_1on1 #date_action_1").remove();
}

function get_display_tutor_details(page_id){
    var product_id = jQuery("#product_id").val();
    jQuery(".loader").fadeIn("slow");
    if(page_id == null)page_id = 1;
        jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_related_tutor_list",
            type: 'post',
            data:{
                paged:page_id,
                product_id:product_id
            },
            success:function result(response){
               response = response.replace(/\b0+/g, '');
               jQuery(".session-tutor-detail .col-md-4").replaceWith( response );
               jQuery(".loader").fadeOut("slow");
            }
            });
}

//Add User To Wait List
function add_to_waitlist(product_id, user_id){
    var val_btn_waitlist = jQuery("#btn_waitlist").val();
        
        jQuery.ajax({
            url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=add_user_to_productwaitlist",
            type: 'post',
            data:{
                user_id: user_id,
                product_id: product_id,
                val_btn_waitlist: val_btn_waitlist,
            },
            success:function result(response){
                if(val_btn_waitlist == 1){
                    jQuery("#btn_waitlist").val(0); 
                    jQuery("#btn_waitlist").text("Leave Wait List");
                }else{
                    jQuery("#btn_waitlist").val(1); 
                    jQuery("#btn_waitlist").text("Add to Wait List");
                }
            }
            });
}
function pauseCurrentVideo(post_id){
    video_js_id = jQuery("#"+post_id+"tutorvideoModal video").attr('id');
    var myPlayer = videojs(video_js_id);
    if(!myPlayer.paused()){
        myPlayer.pause();
    }
}

function prevent_wallet_deposit(){
    alert("First Clear your cart & then add money to wallet");
}

function refund_using_wallet(order_id, credit_amount, product_id){
    var cancel_session = confirm("Do you want to cancel this session?");
    if(cancel_session == true){
        jQuery("#"+product_id+"_cancel_session").attr("disabled",'true');
        jQuery(".loader").fadeIn("slow");
        var url = Urls.siteUrl+"/wp-admin/admin-ajax.php?action=change_user_wallet";
        jQuery.post(url,
        { user: Urls.current_user_id , credit_amount: credit_amount, order_id: order_id , product_id: product_id}, 
        function(response) {
            if(response) get_studentsession_details();
        });
    }
}

function refund_using_tutor_wallet(order_id, credit_amount , product_id){
    var cancel_session = confirm("Do you want to cancel this session?\n(The students who have prebooked will be notified accordingly)");
    if(cancel_session == true){
        jQuery("#"+product_id+"_cancel_session").attr("disabled",'true');
        jQuery(".loader").fadeIn("slow");
        var url = Urls.siteUrl+"/wp-admin/admin-ajax.php?action=change_user_tutor_wallet";
        jQuery.post(url,
        { user: Urls.current_user_id , order_id: order_id , credit_amount: credit_amount, product_id: product_id}, 
        function(response) {
            if(response) get_session_details();
        });
    }
}

function reset_search_form_fields(){
    jQuery("#course_filter").resetForm();
    jQuery("#tutor_filter").resetForm();
    jQuery("#curriculum").val("");
    jQuery("#subject").val("");
    jQuery("#grade").val("");
    jQuery("#price").val(0);
    jQuery("#result").html("$0");
}

