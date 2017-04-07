/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var site_url = '<?php get_site_url(); ?>'; 
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
                phoneUS: true
            },
            user_permanentadd1: "required",
            user_country_2: "required",
            user_state_2: "required",
            user_zipcode2: "required",
            user_city_2: "required",
            user_address_phone2: {
                required : true,
                phoneUS: true
            },
            guardian_name: "required",
            guardian_relation: "required",
            guardian_email_address: {
                required: true,
                email: true
            },
            guardian_contact_num: {
                required : true,
                phoneUS: true
            },
            guardian_billingadd1: "required",
            user_country_3: "required",
            user_state_3: "required",
            guardian_zipcode3: "required",
            user_city_3: "required",
            guardian_billing_phone: {
                phoneUS: true
            },
            guardian_shippingadd1: "required",
            user_country_4: "required",
            user_state_4: "required",
            guardian_zipcode4: "required",
            user_city_4: "required",
            guardian_shipping_phone: {
                phoneUS: true
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
                phoneUS: "Enter valid number"
            },
            user_permanentadd1: "Enter your Permanent Address",
            user_country_2: "Select Country",
            user_state_2: "Select State",
            user_zipcode2: "Enter Zip Code",
            user_city_2: "Select City",
            user_address_phone2: {
                required : "Enter Contact No",
                phoneUS: "Enter valid number"
            },
            guardian_name: "Enter Name",
            guardian_email_address : "Enter a valid email address",
            guardian_contact_num: {
                required : "Enter Contact No",
                phoneUS: "Enter valid number"
            },
            user_country_3: "Select Country",
            user_state_3: "Select State",
            guardian_zipcode3: "Enter Zip Code",
            user_city_3: "Select City",
            guardian_billing_phone: {
                required : "Enter Contact No",
                phoneUS: "Enter valid number"
            },
            user_country_4: "Select Country",
            user_state_4: "Select State",
            guardian_zipcode4: "Enter Zip Code",
            user_city_4: "Select City",
            guardian_shipping_phone: {
                phoneUS: "Enter valid number"
            }
        },
        submitHandler: function(form) {
            jQuery(".loader").fadeIn("slow");
            jQuery("#NRIC_error").hide();
            var zipcode = jQuery("#user_zipcode1").val();
            var country = jQuery("#user_country_1 :selected").text();
            var tutor_NRIC = jQuery("#NRIC_code").val();
            var address = zipcode+","+country;
            var Timezone;
            if(country == "Singapore" && tutor_NRIC == ""){
                jQuery("#NRIC_error").show();
            }else{
                jQuery.ajax({ 
                url: "http://maps.googleapis.com/maps/api/geocode/json",
                type: "GET",
                async: false,
                data:{
                    address: address
                },
                success:function result(data){
                 var lat_log = data.results[0].geometry.location;
                 var lat = lat_log.lat;
                 var lng = lat_log.lng;
                 jQuery.ajax({ 
                    url:"https://maps.googleapis.com/maps/api/timezone/json",
                    type: "GET",
                    async: false,
                    data:{ 
                        location: lat+","+lng,
                        timestamp:"1331161200",
                        key: "AIzaSyDZl-oXXb4JJ54RriwDmYEId1JCzad0ccI"
                    },
                    success:function result(result){
                        Timezone = result.timeZoneId;
                        jQuery("#timezone").val(Timezone);
                        form.submit();
                    }
                });               
                }
                });
            }
            jQuery(".loader").fadeOut("slow");
        }
    });
    
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

jQuery( "#contact-remember-me" ).change(function() {
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
      disableuserfields(1);
      
  }else{
      jQuery("#user_permanentadd1").val("");
      jQuery("#user_permanentadd2").val("");
      jQuery("#user_country_2").val("");
      jQuery("#user_state_2").val("");
      jQuery("#user_zipcode2").val("");
      jQuery("#user_city_2").val("");
      jQuery("#user_address_phone2").val("");
      disableuserfields(0);
  }
});

function disableuserfields($bool){
            jQuery("#user_permanentadd1").prop("readonly",$bool);
            jQuery("#user_permanentadd2").prop("readonly",$bool);
            jQuery("#user_country_2").prop("readonly",$bool);
            jQuery("#user_state_2").prop("readonly",$bool);
            jQuery("#user_zipcode2").prop("readonly",$bool);
            jQuery("#user_city_2").prop("readonly",$bool);
            jQuery("#user_address_phone2").prop("readonly",$bool);
        }

    
    jQuery(document).on( 'change', '#user_country_1', getallstates);
    jQuery(document).on( 'change', '#user_country_2', getallstates);
    jQuery(document).on( 'change', '#user_country_3', getallstates);
//    jQuery(document).on( 'change', '#user_country_4', getallstates);
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
}

function get_order_student_details(){
    var history_from_date = jQuery("#history_from_date").val();
    var history_to_date = jQuery("#history_to_date").val();
    if(history_from_date != "" && history_to_date != ""){
    jQuery("#tbl_history .error").hide();
    var order_status = jQuery("#order_status").val();
    var completedtotal=pendingtotal=0;
    jQuery.ajax({
                    url: Urls.siteUrl+"/wp-admin/admin-ajax.php?action=get_studentorder_table_history",
                    type: "POST",
                    data: {
                        history_from_date : history_from_date,
                        history_to_date :history_to_date,
                        order_status : order_status
                    },
                    success:function(response){
                       var total=0;
                       jQuery("#history_table").html("");
                       jQuery("#div_total_amt").html("");
                       var result = JSON.parse(response);
                       var obj = result.result;
                       if(obj.line_total != null){
                       var count = obj.line_total.length;
                       for(var i=0; i<count; i++){
                           jQuery("#history_table").append('<tr id="'+obj.product_id[i]+'"><th scope="row">'+obj.order_date[i]+'</th><td>'+obj.product_name[i]+'</td><td>'+obj.order_item_meta[i].name_of_tutor+'</td><td>'+obj.line_total[i]+'</td><td>'+obj.post_status[i]+'</td></tr>');
//                           debugger;
                           if(obj.post_status[i] == "Completed"){
                           completedtotal += parseFloat(obj.line_total[i]);
                           }else{
                           pendingtotal += parseFloat(obj.line_total[i]);
                           }
                       }
                       jQuery("#div_total_amt").append('<label>Total Amount Received from</label><p class="field-para" ><span>'+history_from_date+'</span> to <span>'+history_to_date+'</span> - $'+completedtotal+'</p><br/>')
                       jQuery("#div_total_amt").append('<label>Total Amount Pending from</label><p class="field-para" ><span>'+history_from_date+'</span> to <span>'+history_to_date+'</span> - $'+pendingtotal+'</p>')
                        }else{
                            jQuery("#history_table").append('No results found for your search');
                        }
                    }
                });
            }else{
                jQuery("#tbl_history .error").show();
            }
}
