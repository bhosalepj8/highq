<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">




             <div ng-app = "mainApp" ng-controller = "studentController">
            <form name = "studentForm"  novalidate>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name = "email" type = "email" ng-model = "signup.email"  class="form-control"  placeholder="Enter email" required >
                 <span style = "color:red" ng-show = "studentForm.email.$dirty && studentForm.email.$invalid">
                                    <span ng-show = "studentForm.email.$error.required">Email is required.</span>
                                    <span ng-show = "studentForm.email.$error.email">Invalid email address.</span>
                          </span>
              </div>
             <div class="form-group" ng-class="{'has-error': studentForm.password.$invalid}">
                  <label for="exampleInputPass">Password</label>
                   <input class="form-control" name="password" type="password" 
                     placeholder="Password" ng-model="signup.password" maxlength="20" minlength="8"   required  />
                   <span style = "color:red" ng-show = "studentForm.password.$dirty && studentForm.password.$invalid">
                                    <span ng-show = "studentForm.password.$error.required">Password is required.</span>
                                    <span ng-show = "studentForm.password.$error.password">Invalid password.</span>
                                      <span ng-show = "studentForm.password.$error.maxlength">Invalid input length.</span>
                                     <span ng-show = "studentForm.password.$error.minlength">Invalid input length.</span>
                          </span>
              </div>


              <div class="form-group">
                <label for="exampleInputName">Name</label>
               
                   <input class="form-control" name="name" type="text" 
                     placeholder="Name" required ng-model="signup.name" required  />
                   <span style = "color:red" ng-show = "studentForm.name.$dirty && studentForm.name.$invalid">
                                    <span ng-show = "studentForm.name.$error.required">name is required.</span>
                                    <span ng-show = "studentForm.name.$error.name">Invalid name.</span>

                          </span>
                
              </div>


              <div class="form-group">
                <label for="exampleAddress">Address</label>
                <textarea class="form-control" ng-model="singup.Address" rows="2"></textarea>
              </div>

            <div class="form-group">
             <label for="exampleAddress">Country</label>
              <select class="form-control" ng-model="singup.country"  ng-options="country.name for country in countries track by country.code">
                 <option value="">-- Select a Country --</option>
              </select>
            

            </div>

             
              <div class="form-group">
                <label for="exampleInputZipcode">Zipcode</label>
               
                   <input class="form-control" name="zipcode" type="number" 
                     placeholder="Zipcode" required ng-model="signup.zipcode" required  maxlength="10" minlength="5"  />
                   <span style = "color:red" ng-show = "studentForm.zipcode.$dirty && studentForm.zipcode.$invalid">
                                    <span ng-show = "studentForm.zipcode.$error.required">ZipCode is required.</span>
                                    <span ng-show = "studentForm.zipcode.$error.text">Invalid ZipCode.</span>
                                      <span ng-show = "studentForm.zipcode.$error.maxlength">Invalid input length.</span>
                                     <span ng-show = "studentForm.zipcode.$error.minlength">Invalid input length.</span>
                          </span>
                
              </div>

             
              <div class="form-group">
                <label for="exampleInputMobile">Mobile</label>
               
                   <input class="form-control" name="mobile" type="number" 
                     placeholder="Mobile" required ng-model="signup.mobile" required  maxlength="10" minlength="10"  />
                   <span style = "color:red" ng-show = "studentForm.mobile.$dirty && studentForm.mobile.$invalid">
                                    <span ng-show = "studentForm.mobile.$error.required">Mobile is required.</span>
                                    <span ng-show = "studentForm.mobile.$error.number">Invalid Mobile.</span>
                                      <span ng-show = "studentForm.mobile.$error.maxlength">Invalid input length.</span>
                                     <span ng-show = "studentForm.mobile.$error.minlength">Invalid input length.</span>
                          </span>
                
              </div>

            <div class="form-group">
             <label for="exampleAge">Age</label>
            <select  class="form-control" ng-model="signup.age" ng-options="o as o for o in ageList"></select>
            </div>

              <div class="form-group" ng-show="signup.age<18" >
                <label for="exampleInputParentName">Parent Name</label>
               
                   <input class="form-control" name="parentname" type="text" 
                     placeholder="Parent Name" required ng-model="signup.parentname" required  />
                   <span style = "color:red" ng-show = "studentForm.parentname.$dirty && studentForm.parentname.$invalid">
                                    <span ng-show = "studentForm.parentname.$error.required">Parent Name is required.</span>
                                    <span ng-show = "studentForm.parentname.$error.text">Invalid Parent name.</span>
                          </span>
                
              </div>

              <div class="form-group" ng-show="signup.age<18"  >
                <label for="exampleInputEmail1">Parent Email address</label>
                <input name = "parentemail" type = "email" ng-model = "signup.parentemail"  class="form-control"  placeholder="Enter  Parent email" required >
                 <span style = "color:red" ng-show = "studentForm.parentemail.$dirty && studentForm.parentemail.$invalid">
                                    <span ng-show = "studentForm.parentemail.$error.required">Parent Email is required.</span>
                                    <span ng-show = "studentForm.parentemail.$error.email">Invalid Parent email address.</span>
                
                          </span>
              </div>

              <div class="form-group"  ng-show="signup.age<18"  >
                <label for="exampleInputParentMobile">Mobile</label>
               
                   <input class="form-control" name="parentmobile" type="number" 
                     placeholder="Parent Mobile" required ng-model="signup.parentmobile" required  maxlength="10" minlength="10"  />
                   <span style = "color:red" ng-show = "studentForm.parentmobile.$dirty && studentForm.parentmobile.$invalid">
                                    <span ng-show = "studentForm.parentmobile.$error.required">Parent Mobile is required.</span>
                                    <span ng-show = "studentForm.parentmobile.$error.number">Invalid Parent Mobile.</span>
                                      <span ng-show = "studentForm.parentmobile.$error.maxlength">Invalid input length.</span>
                                     <span ng-show = "studentForm.parentmobile.$error.minlength">Invalid input length.</span>
                          </span>

                <p ng-show="studentForm.parentmobile.$error.maxlength" class="help-block">Invalid Parent Mobile.</p>
                
              </div>



              <div class="form-group"   ng-show="singup.country.code==='SG' && signup.age<18"    >
                <label for="exampleInputParentNRIC">Parent NRIC</label>
               
                   <input class="form-control" name="signup.parentNRIC" type="text" 
                     placeholder="Parent NRIC" required ng-model="signup.parentNRIC" required    />
                   <span style = "color:red" ng-show = "studentForm.parentNRIC.$dirty && studentForm.parentNRIC.$invalid">
                                    <span ng-show = "studentForm.parentNRIC.$error.required">Parent NRIC is required.</span>
                                   <span ng-show = "studentForm.parentNRIC.$error.text">Invalid Parent NRIC.</span>
                          </span>
                
              </div>

              <div class="form-group"   ng-show="singup.country.code==='SG'"      >
                <label for="exampleInputstudNRIC">Student NRIC</label>
               
                   <input class="form-control" name="studNRIC" type="text" 
                     placeholder="Student NRIC" required ng-model="signup.studNRIC" required    />
                   <span style = "color:red" ng-show = "studentForm.studNRIC.$dirty && studentForm.studNRIC.$invalid">
                                    <span ng-show = "studentForm.studNRIC.$error.required">Student NRIC is required.</span>
                                   <span ng-show = "studentForm.studNRIC.$error.text">Invalid Student NRIC.</span>
                          </span>
                
              </div>



               <div class="checkbox" >
               <label>
                        <input type="checkbox" name="promotionalemail" ng-model="signup.promotionalemail"  > Do you want to receive promotional email
                
                  </label>
               </div>
             
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="termscond" ng-model="signup.termscond" > Terms & Conditions
                </label>
              </div>
             <div class="form-group">
              <!--<button type="button" ng-click = "reset()" class="btn btn-primary" >Cancel</button>-->
              <button type="button" ng-click="submit(signup)" class="btn btn-primary">Submit</button>
            </div> <!-- <pre>{{signup | json}}</pre> -->
            </form>
            </div>


       </div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

