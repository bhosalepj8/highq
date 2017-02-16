/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var site_url = '<?php get_site_url(); ?>'; 
jQuery(document).ready(function(){
var currentYear = new Date().getFullYear();
jQuery( "#user_dob" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: "1980:"+currentYear,
    defaultDate: "01/01/1991"
    });

   jQuery("#student_registration").validate({   
        ignore: [],
        rules: {
            user_fname: "required",
            user_lname: "required",
            user_email: {
                required: true,
                email: true
            },
            NRIC_code: "required",
            user_pass: "required",
            confpassword: {
                required : true,
                equalTo: "#user_pass"
            },
            user_dob : "required",
//            user_ethinicity : "required",
            user_grade : "required",
            user_gender: "required",
            user_presentadd1: "required",
//            user_presentadd2: "required",
            user_country_1: "required",
            user_state_1: "required",
            user_zipcode1: "required",
            user_city_1: "required",
            user_address_phone1: {
                required : true,
//                number: true,
                phoneUS: true
            },
            user_permanentadd1: "required",
//            user_permanentadd2: "required",
            user_country_2: "required",
            user_state_2: "required",
            user_zipcode2: "required",
            user_city_2: "required",
            user_address_phone2: {
                required : true,
//                number: true,
                phoneUS: true
            },
            guardian_name: "required",
//            guardian_age: "required",
            guardian_relation: "required",
//            guardian_gender : "required",
            guardian_email_address: {
                required: true,
                email: true
            },
            guardian_contact_num: {
                required : true,
//                number: true,
                phoneUS: true
            },
            guardian_billingadd1: "required",
//            guardian_billingadd2: "required",
            user_country_3: "required",
            user_state_3: "required",
            guardian_zipcode3: "required",
            user_city_3: "required",
            guardian_billing_phone: {
//                required : true,
                phoneUS: true
            },
            guardian_shippingadd1: "required",
//            guardian_shippingadd2: "required",
            user_country_4: "required",
            user_state_4: "required",
            guardian_zipcode4: "required",
            user_city_4: "required",
            guardian_shipping_phone: {
                required : true,
//                number: true,
                phoneUS: true
            },
//            school_name_1: "required",
//            subject_studied_1: "required",
        },
        messages: {
            user_fname: "Please enter your first name",
            user_lname: "Please enter your last name",            
            user_email: "Please enter a valid email address",
            NRIC_code: "Please enter your NRIC number",
            user_pass: "Please enter your password",
            confpassword: {
                required : "Please re-enter your password",
                equalTo: "Passwords do not match"
            },
            user_dob: "Please select DOB",
//            user_ethinicity : "Please enter ethnicity",
            user_grade : "Please select your grade",
            user_gender: "Please select your gender",
            user_country_1: "Please select Country",
            user_state_1: "Please select State",
            user_zipcode1: "Please enter Zip Code",
            user_city_1: "Please select City",
            user_address_phone1: {
                phoneUS: "Please enter valid number"
            },
            user_country_2: "Please select Country",
            user_state_2: "Please select State",
            user_zipcode2: "Please enter Zip Code",
            user_city_2: "Please select City",
            user_address_phone2: {
                phoneUS: "Please enter valid number"
            },
            guardian_name: "Please enter Name",
//            guardian_age: "Please enter Age",
//            guardian_gender : "Please select Gender",
            guardian_email_address : "Please enter a valid email address",
            guardian_contact_num: {
                phoneUS: "Please enter valid number"
            },
            user_country_3: "Please select Country",
            user_state_3: "Please select State",
            guardian_zipcode3: "Please enter Zip Code",
            user_city_3: "Please select City",
            guardian_billing_phone: {
                phoneUS: "Please enter valid number"
            },
            user_country_4: "Please select Country",
            user_state_4: "Please select State",
            guardian_zipcode4: "Please enter Zip Code",
            user_city_4: "Please select City",
            guardian_shipping_phone: {
                phoneUS: "Please enter valid number"
            }
        }
//        submitHandler: function(form) {
//            jQuery("#loadingimage").show();
//            jQuery.ajax({
//             type: "POST",
//             url: "http://172.16.0.76/highq/wp-student-registration.php",
//             data: jQuery(form).serialize(),
//             success: function(data) {
//                 jQuery("#loadingimage").hide();
//                 if(data == 1) {
//                     window.location.href = 'http://172.16.0.76/highq/register-success/';
//                 } else {
//                     jQuery("#message").html("There is an error in your request, please contact administrator.");
//                 }
//             }
//             });
//             return true;
//        }
    });

jQuery( "#contact-remember-me" ).change(function() {
  if(jQuery(this).is(':checked')){
      var user_city1txt = jQuery("#user_city_1 :selected").text();
      jQuery("#div_user_state2").html('<input id="user_state_2" name="user_state_2" class="form-control" placeholder="Enter State Name" type="text">');
      jQuery("#div_user_city2").html('<input class="form-control" id="user_city_2" name="user_city_2" placeholder="Enter City Name" type="text">');
      jQuery("#user_permanentadd1").val(jQuery("#user_presentadd1").val());
      jQuery("#user_permanentadd2").val(jQuery("#user_presentadd2").val());
      jQuery("#user_country_2").val(jQuery("#user_country_1").val());
      jQuery("#user_state_2").val(jQuery("#user_state_1 :selected").text());
      jQuery("#user_zipcode2").val(jQuery("#user_zipcode1").val());
      
      if(user_city1txt != "")
          jQuery("#user_city_2").val(jQuery("#user_city_1 :selected").text());
      else
          jQuery("#user_city_2").val(jQuery("#user_city_1").val());
      jQuery("#user_address_phone2").val(jQuery("#user_address_phone1").val());
      
  }else{
      jQuery("#user_permanentadd1").val("");
      jQuery("#user_permanentadd2").val("");
      jQuery("#user_country_2").val("");
      jQuery("#user_state_2").val("");
      jQuery("#user_zipcode2").val("");
      jQuery("#user_city_2").val("");
      jQuery("#user_address_phone2").val("");
  }
});

jQuery( "#billing-remember-me" ).change(function() {
  if(jQuery(this).is(':checked')){
      var user_city3txt = jQuery("#user_city_3 :selected").text();
      jQuery("#div_user_state4").html('<input id="user_state_4" name="user_state_4" class="form-control" placeholder="Enter State Name" type="text">');
      jQuery("#div_user_city4").html('<input class="form-control" id="user_city_4" name="user_city_4" placeholder="Enter City Name" type="text">');
      jQuery("#guardian_shippingadd1").val(jQuery("#guardian_billingadd1").val());
      jQuery("#guardian_shippingadd2").val(jQuery("#guardian_billingadd2").val());
      jQuery("#user_country_4").val(jQuery("#user_country_3").val());
      jQuery("#user_state_4").val(jQuery("#user_state_3 :selected").text());
      jQuery("#guardian_zipcode4").val(jQuery("#guardian_zipcode3").val());
      if(user_city3txt != "")
          jQuery("#user_city_4").val(jQuery("#user_city_3 :selected").text());
      else
          jQuery("#user_city_4").val(jQuery("#user_city_3").val());
      
      
      jQuery("#guardian_shipping_phone").val(jQuery("#guardian_billing_phone").val());
      
  }else{
      jQuery("#guardian_shippingadd1").val("");
      jQuery("#guardian_shippingadd2").val("");
      jQuery("#user_country_4").val("");
      jQuery("#user_state_4").val("");
      jQuery("#guardian_zipcode4").val("");
      jQuery("#user_city_4").val("");
      jQuery("#guardian_shipping_phone").val("");
  }
});

    jQuery(document).on( 'change', '#user_country_1', getallstates);
    jQuery(document).on( 'change', '#user_country_2', getallstates);
    jQuery(document).on( 'change', '#user_country_3', getallstates);
    jQuery(document).on( 'change', '#user_country_4', getallstates);
    function getallstates(){
        var selected_country_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        console.log(selected_country_code);
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_selected_states",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        country_no : i
                    },
                    success:function(result){
                        if(result !=""){
                       jQuery("#div_user_state"+i).html(result);}
                       else{
                           jQuery("#div_user_state"+i).html('<input class="form-control" id="user_state_"'+i+' name="user_state_"'+i+' placeholder="Enter State Name"/>');
                       }
                    }
                });
    }
    
    jQuery(document).on( 'change', '#user_state_1', getallcities);
    jQuery(document).on( 'change', '#user_state_2', getallcities);
    jQuery(document).on( 'change', '#user_state_3', getallcities);
    jQuery(document).on( 'change', '#user_state_4', getallcities);
    function getallcities(){
        var selected_state_code = jQuery(this).val();
        var arr = this.id.split("_");
        var i = arr[2];
        selected_country_code = jQuery("#user_country_"+i).val();
        console.log(selected_state_code);
        jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_selected_cities",
                    type: "POST",
                    data: {
                        selected_country_code : selected_country_code,
                        selected_state_code :selected_state_code,
                        country_no : i
                    },
                    success:function(result){
                        if(result !=""){
                       jQuery("#div_user_city"+i).html(result);}
                       else{
                           jQuery("#div_user_city"+i).html('<input class="form-control" id="user_city_'+i+'" name="user_city_'+i+'" placeholder="Enter City Name"/>');
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



function addAcademicBlock(){
    var academic_count = parseInt(jQuery("#hiddenAcademic").val());
    var rowCount = academic_count + 1;
    var prev_school_name = jQuery("#school_name_"+academic_count).val();
    var prev_subjecttxt = jQuery("#subject_studied_"+academic_count).val(); 
     
     if(prev_school_name == "" || prev_subjecttxt == "")
     {
         jQuery("#span_error").show();
     }
     else{
         jQuery("#span_error").hide();
         jQuery("#academic_divs").append("<div class='clearfix' id='academic_div_"+rowCount+"'><div class='col-md-4 mar-top-10'><div class='form-group'>\n\
        <label for='exampleInputName2'>School Name</label><input type='text' class='form-control' id='school_name_"+rowCount+"' name='school_name["+rowCount+"]' placeholder='Enter Your High School Name'></div></div>\n\
        <div class='col-md-4'><div class='form-group'><label for='exampleInputName2'>Subject Studied </label><input type='text' class='form-control' id='subject_studied_"+rowCount+"' name='subject_studied["+rowCount+"]' placeholder='Subject Studied'></div></div>\n\
        <span id='action_"+rowCount+"'><a href='javascript:void(0);' onclick='addAcademicBlock()' data-toggle='tooltip' title='add another' class='tooltip-bottom'><span class='glyphicon glyphicon-plus'></span></a></span></div>");
        jQuery("#hiddenAcademic").val(parseInt(rowCount));
        jQuery("#action_"+academic_count).html("<a href='javascript:void(0);' onclick='removeAcademic("+academic_count+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>");
    }
//    jQuery("#school_name_"+rowCount).rules("add",{required: true});
//    jQuery("#subject_studied_"+rowCount).rules("add",{required: true});
//<a href='javascript:void(0);' onclick='removeAcademic("+rowCount+")' data-toggle='tooltip' title='remove' class='tooltip-bottom'><strong>X</strong></a>
//    jQuery("#span_error").hide();
}

function removeAcademic(count){
    jQuery("#academic_div_"+count).remove();
//    var academic_count = parseInt(jQuery("#hiddenAcademic").val());
//    var rowCount = academic_count - 1;
//    jQuery("#hiddenAcademic").val(parseInt(rowCount));
}

