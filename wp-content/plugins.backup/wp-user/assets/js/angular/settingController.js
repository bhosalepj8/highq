
listApp.controller('settingController', function ($scope, $http, apiUrl,wpuserLang,translationService) {
    //i18n
    $scope.selectedLanguage = wpuserLang;
    //Run translation if selected language changes
    $scope.translate = function(){
       translationService.getTranslation($scope, $scope.selectedLanguage);
   };
    $scope.translate();

    $scope.get_setting_general = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_disable_signup = data['wp_user_disable_signup'];
            $scope.wp_user_disable_admin_bar = data['wp_user_disable_admin_bar'];
            


        });
    }
    $scope.update_setting_general = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_disable_signup': $scope.wp_user_disable_signup,
                    'wp_user_disable_admin_bar': $scope.wp_user_disable_admin_bar,
                   


                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("General setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

    $scope.get_setting_general_term = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_show_term_data = data['wp_user_show_term_data'];
            $scope.wp_user_tern_and_condition = data['wp_user_tern_and_condition'];
        });
    }
    $scope.update_setting_general_term = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_show_term_data': $scope.wp_user_show_term_data,
                    'wp_user_tern_and_condition': $scope.wp_user_tern_and_condition,
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Term and Condition setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
    
    $scope.get_setting_general_appearance = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_appearance_skin = data['wp_user_appearance_skin'];
            $scope.wp_user_appearance_icon = data['wp_user_appearance_icon'];
            $scope.wp_user_disable_admin_bar = data['wp_user_disable_admin_bar'];
            $scope.wp_user_appearance_custom_css = data['wp_user_appearance_custom_css'];
            $scope.wp_user_language = data['wp_user_language'];
            
        });
    }
    
     $scope.update_setting_general_appearance = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_appearance_skin': $scope.wp_user_appearance_skin,
                    'wp_user_appearance_icon': $scope.wp_user_appearance_icon,
                    'wp_user_disable_admin_bar': $scope.wp_user_disable_admin_bar,
                    'wp_user_appearance_custom_css': $scope.wp_user_appearance_custom_css,
                    'wp_user_language': $scope.wp_user_language
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Appearance setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
    
     $scope.get_setting_page = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_page=data['wp_user_page'];
            $scope.wp_user_page_title=data['wp_user_page_title'];
            
            
        });
    }
    
     $scope.update_setting_page = function () {

        $http.post(apiUrl + '?action=wpuser_updatePageSetting',
                {
                    'wp_user_page_title': $scope.wp_user_page_title                    
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    $scope.wp_user_page=data['wp_user_page'];
                    toastr["success"]("Pages have been rebuilt successfully.", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

   $scope.get_setting_security_login = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_login_limit_enable = data['wp_user_login_limit_enable'];
            $scope.wp_user_login_limit = data['wp_user_login_limit'];
            $scope.wp_user_login_limit_admin_notify = data['wp_user_login_limit_admin_notify'];            
             $scope.wp_user_login_limit_time = data['wp_user_login_limit_time'];
        });
    }
    
     $scope.update_setting_security_login = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_login_limit_enable': $scope.wp_user_login_limit_enable,
                    'wp_user_login_limit': $scope.wp_user_login_limit,
                    'wp_user_login_limit_admin_notify': $scope.wp_user_login_limit_admin_notify,
                    'wp_user_login_limit_time': $scope.wp_user_login_limit_time
                    
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Limit Login Attempts setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
$scope.get_setting_security_password = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_login_limit_password_enable = data['wp_user_login_limit_password_enable'];
            $scope.wp_user_login_limit_password = data['wp_user_login_limit_password']; 
            $scope.wp_user_login_password_valid_message = data['wp_user_login_password_valid_message'];  
        });
    }

$scope.update_setting_security_password = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_login_limit_password_enable': $scope.wp_user_login_limit_password_enable,
                    'wp_user_login_limit_password': $scope.wp_user_login_limit_password,
                    'wp_user_login_password_valid_message': $scope.wp_user_login_password_valid_message
                    
                    
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
    
    $scope.get_setting_security_reCAPTCHA = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_security_reCaptcha_enable = data['wp_user_security_reCaptcha_enable'];
            $scope.wp_user_security_reCaptcha_secretkey = data['wp_user_security_reCaptcha_secretkey'];           
        });
    }

$scope.update_setting_security_reCAPTCHA = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_security_reCaptcha_enable': $scope.wp_user_security_reCaptcha_enable,
                    'wp_user_security_reCaptcha_secretkey': $scope.wp_user_security_reCaptcha_secretkey
                    
                    
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
    
    $scope.get_setting_email = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_user_email_name = data['wp_user_email_name'];
            $scope.wp_user_email_id = data['wp_user_email_id'];
             $scope.wp_user_email_admin_register_enable = data['wp_user_email_admin_register_enable'];
            $scope.wp_user_email_admin_register_subject = data['wp_user_email_admin_register_subject'];
             $scope.wp_user_email_admin_register_content = data['wp_user_email_admin_register_content'];
              $scope.wp_user_email_user_register_enable = data['wp_user_email_user_register_enable'];
            $scope.wp_user_email_user_register_subject = data['wp_user_email_user_register_subject'];
             $scope.wp_user_email_user_register_content = data['wp_user_email_user_register_content'];
              $scope.wp_user_email_user_forgot_subject = data['wp_user_email_user_forgot_subject'];
             $scope.wp_user_email_user_forgot_content = data['wp_user_email_user_forgot_content'];
            
        });
    }
    $scope.update_setting_email = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_user_email_name': $scope.wp_user_email_name,
                    'wp_user_email_id': $scope.wp_user_email_id,
                    'wp_user_email_admin_register_enable': $scope.wp_user_email_admin_register_enable,
                    'wp_user_email_admin_register_subject': $scope.wp_user_email_admin_register_subject,
                     'wp_user_email_admin_register_content': $scope.wp_user_email_admin_register_content,
                     'wp_user_email_user_register_enable': $scope.wp_user_email_user_register_enable,
                    'wp_user_email_user_register_subject': $scope.wp_user_email_user_register_subject,
                     'wp_user_email_user_register_content': $scope.wp_user_email_user_register_content,   
                      'wp_user_email_user_forgot_subject': $scope.wp_user_email_user_forgot_subject,
                     'wp_user_email_user_forgot_content': $scope.wp_user_email_user_forgot_content   
                   

                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Email setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
    


});
