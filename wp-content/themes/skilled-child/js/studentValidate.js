/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
var currentYear = new Date().getFullYear();
var todaysdate = new Date();
jQuery( "#user_dob" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: "1920:"+currentYear,
    defaultDate: "01/01/1991",
    maxDate: todaysdate
    });
    
     jQuery( "#history_student_from_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate: todaysdate
    });
    
    jQuery( "#history_student_to_date" ).datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate: todaysdate
    });
    
    function getCurrentTimezone(){
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
    
    
   jQuery("#student_registration").validate({   
        ignore: [],
        rules: {
            user_fname: "required",
            user_lname: "required",
            user_email: {
                required: true,
                email: true
            },
            user_pass: "required",
            confpassword: {
                required : true,
                equalTo: "#user_pass"
            },
            user_dob : "required",
            user_grade : "required",
            user_gender: "required",
            user_presentadd1: "required",
            user_country_1: "required",
            user_state_1: "required",
            user_zipcode1: "required",
            user_city_1: "required",
            user_address_phone1: {
                required : true,
                telvalidate: true
            },
            user_permanentadd1: "required",
            user_country_2: "required",
            user_state_2: "required",
            user_zipcode2: "required",
            user_city_2: "required",
            user_address_phone2: {
                required : true,
                telvalidate: true
            },
            guardian_name: "required",
            guardian_relation: "required",
            guardian_email_address: {
                required: true,
                email: true
            },
            guardian_contact_num: {
                required : true,
                telvalidate: true
            },
            guardian_billingadd1: "required",
            user_country_3: "required",
            user_state_3: "required",
            guardian_zipcode3: "required",
            user_city_3: "required",
            guardian_billing_phone: {
                telvalidate: true
            },
        },
        messages: {
            user_fname: "Enter your First name",
            user_lname: "Enter your Last name",            
            user_email: "Enter a valid email address",
            user_pass: "Enter your Password",
            confpassword: {
                required : "Re-enter your password",
                equalTo: "Passwords do not match"
            },
            user_dob: "Select DOB",
            user_grade : "Select your grade",
            user_gender: "Select your gender",
            user_presentadd1: "Enter your present Address",
            user_country_1: "Select Country",
            user_state_1: "Select State",
            user_zipcode1: "Enter Zip Code",
            user_city_1: "Select City",
            user_address_phone1: {
                required : "Enter Contact No",
            },
            user_permanentadd1: "Enter your Permanent Address",
            user_country_2: "Select Country",
            user_state_2: "Select State",
            user_zipcode2: "Enter Zip Code",
            user_city_2: "Select City",
            user_address_phone2: {
                required : "Enter Contact No",
            },
            guardian_name: "Enter Name",
            guardian_email_address : "Enter a valid email address",
            guardian_contact_num: {
                required : "Enter Contact No",
            },
            user_country_3: "Select Country",
            user_state_3: "Select State",
            guardian_zipcode3: "Enter Zip Code",
            user_city_3: "Select City",
            guardian_billing_phone: {
                required : "Enter Contact No",
            },
        },
        submitHandler: function(form) {
//            jQuery("#NRIC_error").hide();
//            var country = jQuery("#user_country_1 :selected").text();
//            var tutor_NRIC = jQuery("#NRIC_code").val();
            var Timezone;
//            if(country == "Singapore" && tutor_NRIC == ""){
//                jQuery("#NRIC_error").show();
//                location.hash = "NRIC_code";
//            }else{
                Timezone = getCurrentTimezone();
                jQuery("#timezone").val(Timezone);
                form.submit();
//            }
        }
    });
    
    jQuery.validator.addMethod("telvalidate", function(value, element, params) {
        return jQuery("#"+element.id).intlTelInput("isValidNumber");
    }, jQuery.validator.format("Enter valid contact number"));
    

//      jQuery("#tbl_history").validate({
//         rules: {
//             history_from_date: "required",
//             history_to_date: "required"
//         },
//         messages: {
//             history_from_date: "Select From Date",
//             history_to_date: "Select To Date"
//         }
//      });


      jQuery("#frm_reset_pass").validate({
         rules: {
             new_pass: "required",
             confirm_pass: {
                required : true,
                equalTo: "#new_pass"
            },
         },
         messages: {
             new_pass: "Enter Password",
             confirm_pass: {
                required : "Enter Password",
                equalTo: "Passwords do not match"
            },
         }
      });

jQuery(document).on( 'change', '#contact-remember-me', contact_remember_me);
jQuery(document).on( 'change', '#guardian-remember-me', guardian_remember_me);
function contact_remember_me(){
    var fields = ["user_permanentadd1", "user_permanentadd2", "user_country_2", "user_state_2", "user_zipcode2", "user_city_2", "user_address_phone2"];
  if(jQuery(this).is(':checked')){
      var user_city1txt = jQuery("#user_city_1 :selected").text();
      var user_state1txt=jQuery("#user_state_1 :selected").text();
      jQuery("#div_user_state2").html('<input id="user_state_2" name="user_state_2" class="form-control" placeholder="Enter State Name" type="text">');
      jQuery("#div_user_city2").html('<input class="form-control" id="user_city_2" name="user_city_2" placeholder="Enter City Name" type="text">');
      jQuery("#user_permanentadd1").val(jQuery("#user_presentadd1").val());
      jQuery("#user_permanentadd2").val(jQuery("#user_presentadd2").val());
      jQuery("#user_country_2").val(jQuery("#user_country_1").val());
      jQuery("#user_zipcode2").val(jQuery("#user_zipcode1").val());
      
      if(user_city1txt != "")
          jQuery("#user_city_2").val(jQuery("#user_city_1 :selected").text());
      else
          jQuery("#user_city_2").val(jQuery("#user_city_1").val());
      
      if(user_state1txt != "")
          jQuery("#user_state_2").val(jQuery("#user_state_1 :selected").text());
      else
          jQuery("#user_state_2").val(jQuery("#user_state_1").val());
      
      
      jQuery("#user_address_phone2").val(jQuery("#user_address_phone1").val());
      disableuserfields(fields, 1);
      jQuery("#user_address_phone2").intlTelInput("setCountry", jQuery("#user_country_1").val());
      
  }else{     
    jQuery.each(fields, function( index, value ) {
        jQuery("#"+value).val("");
    });
    disableuserfields(fields, 0);
  }
}

function guardian_remember_me(){
    var fields = ["guardian_billingadd1", "guardian_billingadd2", "user_country_3", "user_state_3", "guardian_zipcode3", "user_city_3", "guardian_billing_phone"];
    if(jQuery(this).is(':checked')){
          var user_city1txt = jQuery("#user_city_1 :selected").text();
          var user_state1txt=jQuery("#user_state_1 :selected").text();
          jQuery("#div_user_state3").html('<input id="user_state_3" name="user_state_3" class="form-control" placeholder="Enter State Name" type="text">');
          jQuery("#div_user_city3").html('<input class="form-control" id="user_city_3" name="user_city_3" placeholder="Enter City Name" type="text">');
          jQuery("#guardian_billingadd1").val(jQuery("#user_presentadd1").val());
          jQuery("#guardian_billingadd2").val(jQuery("#user_presentadd2").val());
          jQuery("#user_country_3").val(jQuery("#user_country_1").val());
          jQuery("#guardian_zipcode3").val(jQuery("#user_zipcode1").val());

          if(user_city1txt != "")
              jQuery("#user_city_3").val(jQuery("#user_city_1 :selected").text());
          else
              jQuery("#user_city_3").val(jQuery("#user_city_1").val());

          if(user_state1txt != "")
              jQuery("#user_state_3").val(jQuery("#user_state_1 :selected").text());
          else
              jQuery("#user_state_3").val(jQuery("#user_state_1").val());


          jQuery("#guardian_billing_phone").val(jQuery("#user_address_phone1").val());
          disableuserfields(fields, 1);
          jQuery("#guardian_billing_phone").intlTelInput("setCountry", jQuery("#user_country_1").val());

      }else{
          jQuery.each(fields, function( index, value ) {
            jQuery("#"+value).val("");
          });
          disableuserfields(fields, 0);
      }
}

    function disableuserfields(fields, bool){
        jQuery.each(fields, function( index, value ) {
            jQuery("#"+value).prop("readonly",bool);
        });
    }

    
    jQuery(document).on( 'change', '#user_country_1', getallstates);
    jQuery(document).on( 'change', '#user_country_2', getallstates);
    jQuery(document).on( 'change', '#user_country_3', getallstates);
//    jQuery(document).on( 'change', '#user_country_4', getallstates);
    function getallstates(){
        var selected_country_code = jQuery(this).val();
        var arr = this.id.split("_");
        
        var i = arr[2];
        jQuery("#user_address_phone"+i).intlTelInput("setCountry", this.value);
        jQuery("#guardian_contact_num").intlTelInput("setCountry", this.value);
        jQuery("#guardian_billing_phone").intlTelInput("setCountry", this.value);
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_selected_states",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        country_no : i
                    },
                    success:function(result){
                        jQuery(".loader").fadeOut("slow");
                        if(result !=""){
                       jQuery("#div_user_state"+i).html(result);}
                       else{
                           jQuery("#div_user_state"+i).html('<input class="form-control" id="user_state_'+i+'" name="user_state_'+i+'" placeholder="Enter State Name"/>');
                       }
                    }
                });
    }
    
    jQuery(document).on( 'change', '#user_state_1', getallcities);
    jQuery(document).on( 'change', '#user_state_2', getallcities);
    jQuery(document).on( 'change', '#user_state_3', getallcities);
//    jQuery(document).on( 'change', '#user_state_4', getallcities);
    function getallcities(){
        var selected_state_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        selected_country_code = jQuery("#user_country_"+i).val();
        jQuery(".loader").fadeIn("slow");
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_selected_cities",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        selected_state_code :selected_state_code,
                        country_no : i
                    },
                    success:function(result){
                        jQuery(".loader").fadeOut("slow");
                        if(result !=""){
                       jQuery("#div_user_city"+i).html(result);}
                       else{
                           jQuery("#div_user_city"+i).html('<input class="form-control" id="user_city_'+i+'" name="user_city_'+i+'" placeholder="Enter City Name"/>');
                       }
                    }
                });
    }
    
//     window.addDashes = function addDashes(f) {
//        var r = /(\D+)/g,
//            npa = '',
//            nxx = '',
//            last4 = '';
//        f.value = f.value.replace(r, '');
//        npa = f.value.substr(0, 3);
//        nxx = f.value.substr(3, 3);
//        last4 = f.value.substr(6, 4);
//        f.value = npa + '-' + nxx + '-' + last4;
//    }
       
    jQuery("#user_country_1").change(function(e){
        
        var tutor_NRIC = jQuery("#NRIC_code").val();
        if(e.target.value == "SG" && tutor_NRIC ==  ""){
            jQuery("#NRIC_code").focus();
            alert("NRIC is Mandatory for Singapore Resident.");
            jQuery("#NRIC_code").rules("add",{required: true});
        }else{
            jQuery("#NRIC_code").rules("remove","required");
        }
    });
    
});

function addAcademicBlock(){
    var academic_count = parseInt(jQuery("#hiddenAcademic").val());
    var rowCount = academic_count + 1;
    var prev_school_name = jQuery("#school_name_"+academic_count).val();
     
     if(prev_school_name == "")
     {
         jQuery("#span_error").show();
     }
     else{
         jQuery("#span_error").hide();
         jQuery("#academic_divs").append("<div class='clearfix' id='academic_div_"+rowCount+"'><div class=''><div class='form-group'>\n\
        <label for='exampleInputName2'>Name of Institution</label><p class='field-para'><input type='text' class='form-control' id='school_name_"+rowCount+"' name='school_name["+rowCount+"]' placeholder='Name of Institution'></p></div><span id='action_"+rowCount+"' class='add-more'><a href='javascript:void(0);' onclick='addAcademicBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>\n\
        </div>");
        jQuery("#hiddenAcademic").val(parseInt(rowCount));
        jQuery("#action_"+academic_count).html("<a href='javascript:void(0);' onclick='removeAcademic("+academic_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
}

function removeAcademic(count){
    jQuery("#academic_div_"+count).remove();
}

function show_all_data(){
    jQuery("#view_all_data_div1").toggle();
    jQuery("#view_all_data_div2").toggle();
    jQuery("#view_all_data_div3").toggle();
    jQuery(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
}
