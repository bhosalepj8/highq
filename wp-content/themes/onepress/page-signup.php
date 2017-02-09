 

 <?php
/**
 * Template Name: Signup
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress


 */

get_header(); ?>
  <div id="content" class="site-content">

    <div class="page-header">
      <div class="container">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      </div>
    </div>

    <?php echo onepress_breadcrumb(); ?>

    <div id="content-inside" class="container right-sidebar">
      <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

             <div ng-app = "mainApp" ng-controller = "studentController">

            <form name = "signupForm" ng-controller="studentController" novalidate ng-submit="submitForm(signupForm.$valid)" >






              <div class="form-group"   >
                <label for="exampleInputEmail1">Email address *</label>
                <input name = "email" type = "email" ng-model = "signup.email"   class="form-control"  placeholder="Enter email" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/"   required >
                <div style = "color:red" ng-messages="signupForm.email.$dirty && signupForm.email.$error" role="alert">
                  <div ng-message="required">Please enter a valid email</div>
                  <div ng-message="email">This field must be a valid email address.</div>
                   <div ng-message="pattern">This field must be a valid email address.</div> 
                </div>
              </div>
              <div class="form-group" >
                  <label for="exampleInputPass">Password *</label>
                   <input class="form-control" name="password" type="password" 
                     placeholder="Password" ng-model="signup.password"  minlength="8" maxlength="20" 
                        ng-pattern="/(?=.*[a-zA-Z])(?=.*[0-1])/"  required  />
                   <div style = "color:red" ng-messages = "signupForm.password.$dirty && signupForm.password.$error">
                                    <div ng-message = "required">Password is required.</div>
                                    <div ng-message = "password">Invalid password.</div>
                                      <div ng-message = "maxlength">Passwords must be between 8 and 20 characters.</div>
                                     <div ng-message = "minlength">Passwords must be between 8 and 20 characters.</div>
                                     <div ng-message = "pattern">Must contain one letter and one number</div>
                          </div>
              </div>
               <div class="form-group" >
                              <label for="exampleInputPass">Confirm Password *</label>
                      <input class="form-control" type="password" name="confirmpass" placeholder="Cornfirm password" valid-password-c ng-model="signup.confirmpass" required="true">
                      <div style = "color:red" ng-messages="signupForm.confirmpass.$dirty &&  signupForm.confirmpass.$error">
                          
                          <div ng-message="required">Please Enter Confirm Password</div>
                          <div ng-message="noMatch">Passwords do not match.</div>

             
      
                          
                      </div> 
            </div> 




              <div class="form-group">
                <label for="exampleInputName">Name *</label>
               
                   <input class="form-control" name="name" type="text" 
                     placeholder="Name" required ng-model="signup.name" required minlength="4" ng-pattern="/^[a-zA-Z\s]*$/"  />
                   <div style = "color:red" ng-messages = "signupForm.name.$dirty && signupForm.name.$error">
                                    <div ng-message = "required">name is required.</div>
                                    <div ng-message = "pattern">Must be Alphabetic only</div>
                                    <div ng-message = "minlength">Name lenth is too short.</div>
                          </div>
                
              </div>


              

            <div class="form-group">
             <label for="exampleAddress">Country *</label>
              <select class="form-control" name="country" ng-model="singup.country"  ng-options="country.name for country in countries track by country.code" required="true">
                 <option value="">-- Select Country --</option>
              </select>

            <div style = "color:red" ng-messages = "signupForm.country.$dirty && signupForm.country.$error">
                                    <div ng-message = "required">Please select country.</div>

                          </div>

            </div>

            <div class="form-group">
                <label for="exampleAddress">Address</label>
                <textarea class="form-control" name="address" ng-model="singup.Address" rows="2"></textarea>
              </div>


               <div class="form-group">
                <label for="exampleInputName">City </label>               
                   <input class="form-control" name="city" type="text" 
                     placeholder="City" required ng-model="signup.city" required />
                  <!--  <div style = "color:red" ng-messages = "signupForm.city.$dirty && signupForm.city.$error">
                                    <div ng-message = "required">Pleease enter city</div>                                    
                          </div> -->
                
              </div>


        
              <div class="form-group">
                <label for="exampleInputZipcode">Zipcode </label>
               
                   <input class="form-control" name="zipcode" type="text" 
                     placeholder="Zipcode" required ng-model="signup.zipcode"   maxlength="11" minlength="5" ng-pattern="/^[0-9-]*$/"  />
                   <div style = "color:red" ng-messages = "signupForm.zipcode.$dirty && signupForm.zipcode.$error">
                                    <!-- <div ng-message = "required">ZipCode is required.</div> -->
                                   <!--  <div ng-message = "number">Invalid ZipCode.</div> -->
                                    <div ng-message = "pattern">Invalid ZipCode.</div>
                                      <div ng-message = "maxlength">Invalid input length.</div>
                                     <div ng-message = "minlength">Invalid input length.</div>
                          </div>
                
              </div>

                 
              <div class="form-group">
                <label for="exampleInputMobile">Mobile *</label>
               
                   <input class="form-control" name="mobile" type="number" 
                     placeholder="Mobile" required ng-model="signup.mobile" required  maxlength="10" minlength="10"  />
                   <div style = "color:red" ng-messages = "signupForm.mobile.$dirty && signupForm.mobile.$error">
                                    <div ng-message = "required">Please enter Mobile number.</div>
                                    <div ng-message = "number">Must be numeric</div>
                                      <div ng-message = "maxlength">Invalid mobile number</div>
                                     <div ng-message = "minlength">Mobile number is short</div>
                          </div>
                
              </div>

            <div class="form-group">
             <label for="exampleAge">Age *</label>
            <select  class="form-control" name="age" ng-model="signup.age" ng-options="o as o for o in ageList" required="true">

                <option value="">-- Select Age --</option>
              </select>

            <div style = "color:red" ng-messages = "signupForm.age.$dirty && signupForm.age.$error">
                                    <div ng-message = "required">Please select age.</div>

                          </div>

            </div>

              <div class="form-group" ng-show="signup.age<18" >
                <label for="exampleInputParentName">Parent Name *</label>
               
                   <input class="form-control" name="parentname" type="text" 
                     placeholder="Parent Name" required ng-model="signup.parentname" ng-pattern="/^[a-zA-Z\s]*$/" required  />
                   <div style = "color:red" ng-messages = "signupForm.parentname.$dirty && signupForm.parentname.$error">
                                    <div ng-message = "required">Parent Name is required.</div>
                                    <div ng-message = "pattern">Must be Alphabetic only</div>
                                    <div ng-message = "text">Invalid Parent name.</div>
                          </div>
                
              </div>

              <div class="form-group" ng-show="signup.age<18"  >
                <label for="exampleInputEmail1">Parent Email address *</label>
                <input name = "parentemail" type = "email" ng-model = "signup.parentemail"  class="form-control"  placeholder="Enter  Parent email" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" required >
                 <div style = "color:red" ng-messages = "signupForm.parentemail.$dirty && signupForm.parentemail.$error">
                                    <div ng-message="required">Please enter a valid email</div>
                                  <div ng-message="email">This field must be a valid email address.</div>
                                   <div ng-message="pattern">This field must be a valid email address.</div> 
                
                          </div>
              </div>

              <div class="form-group"  ng-show="signup.age<18"  >
                <label for="exampleInputParentMobile">Mobile *</label>
               
                   <input class="form-control" name="parentmobile" type="number" 
                     placeholder="Parent Mobile" required ng-model="signup.parentmobile" required  maxlength="10" minlength="10"  />
                   <div style = "color:red" ng-messages = "signupForm.parentmobile.$dirty && signupForm.parentmobile.$error">
                                    <div ng-message = "required">Please enter Parent Mobile number</div>
                                    <div ng-message = "number">Invalid Parent Mobile.</div>
                                      <div ng-message = "maxlength">Invalid mobile number</div>
                                     <div ng-message = "minlength">mobile number is short</div>
                          </div>
                
                
              </div>



              <div class="form-group"   ng-show="singup.country.code==='SG' && signup.age<18"    >
                <label for="exampleInputParentNRIC">Parent NRIC *</label>
               
                   <input class="form-control" name="parentNRIC" type="text" 
                     placeholder="Parent NRIC" required ng-model="signup.parentNRIC" required    />
                   <div style = "color:red" ng-messages = "signupForm.parentNRIC.$dirty && signupForm.parentNRIC.$error">
                                    <div ng-message = "required">Please enter Parent NRIC</div>
                                   <div ng-message = "text">Invalid Parent NRIC.</div>
                          </div>
                
              </div>
 
              <div class="form-group"   ng-show="singup.country.code==='SG'"  >
                <label for="exampleInputstudNRIC">Student NRIC *</label>
               
                   <input class="form-control" name="studNRIC" type="text" 
                     placeholder="Student NRIC" required ng-model="signup.studNRIC" required    />
                   <div style = "color:red" ng-messages = "signupForm.studNRIC.$dirty && signupForm.studNRIC.$error">
                                    <div ng-message = "required">Please enter Student NRIC</div>
                                   <div ng-message = "text">Invalid Student NRIC.</div>
                          </div>
                
              </div>



               <div class="checkbox" >
               <label>
                        <input type="checkbox" name="promotionalemail" ng-model="signup.promotionalemail"  > Do you want to receive promotional email
                
                  </label>
               </div>
             
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="termscond" ng-model="signup.termscond" required="true" > Terms & Conditions * 
                </label>
                <div style = "color:red" ng-messages = "signupForm.termscond.$dirty && signupForm.termscond.$error">
                        <div ng-message = "required">Please Accept Terms & Conditions
                 </div></div>
                                   

              </div> 
             <div class="form-group">
              <!--<button type="button" ng-click = "reset()" class="btn btn-primary" >Cancel</button>-->
              <button type="submit" ng-click="submit(signup)"
              ng-disabled="signupForm.email.$dirty && signupForm.email.$invalid && 
              signupForm.name.$dirty && signupForm.name.$invalid ||
              signupForm.Address.$dirty && signupForm.Address.$invalid ||
               signupForm.country.$dirty && signupForm.country.$invalid ||
               signupForm.zipcode.$dirty && signupForm.zipcode.$invalid ||
               signupForm.mobile.$dirty && signupForm.mobile.$invalid ||
               signupForm.age.$dirty && signupForm.age.$invalid ||
               signupForm.termscond.$dirty && signupForm.termscond.$invalid
              "  class="btn btn-primary"  >Submit</button>
              <img id="mySpinner" src="img/loader.gif" ng-show="loading" />
            </div> 
             <pre>{{signup | json}}</pre> 
            </form>
            </div>


        </main><!-- #main -->
      </div><!-- #primary -->

      <?php //get_sidebar(); ?>

    </div><!--#content-inside -->
  </div><!-- #content -->

<!-- 
    signupForm.password.$dirty && signupForm.password.$invalid ||
               signupForm.name.$dirty && signupForm.name.$invalid ||
               signupForm.Address.$dirty && signupForm.Address.$invalid ||
               signupForm.country.$dirty && signupForm.country.$invalid ||
               signupForm.zipcode.$dirty && signupForm.zipcode.$invalid ||
               signupForm.mobile.$dirty && signupForm.mobile.$invalid ||
               signupForm.age.$dirty && signupForm.age.$invalid 
               
  signupForm.parentname.$dirty && signupForm.parentname.$invalid ||
               signupForm.parentemail.$dirty && signupForm.parentemail.$invalid ||
               signupForm.parentmobile.$dirty && signupForm.parentmobile.$invalid ||
               signupForm.parentNRIC.$dirty && signupForm.parentNRIC.$invalid ||
               signupForm.studNRIC.$dirty && signupForm.studNRIC.$invalid ||
               signupForm.promotionalemail.$dirty && signupForm.promotionalemail.$invalid ||
               signupForm.termscond.$dirty && signupForm.termscond.$invalid
 -->
<?php get_footer(); ?>


