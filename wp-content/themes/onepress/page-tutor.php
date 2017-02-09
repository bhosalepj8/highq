 <?php
/**
 * Template Name: Tutor Page
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

get_header();
 ?>

            <section class="clearfix">
                    <div class="tutor-registration">
                        <h3>Tutor Registration</h3>

                    <article>
                        <div class="panel-group" id="accordion">
                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Personal Information
                                 <span class="glyphicon glyphicon-minus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse in">        
                                <div class="panel-body">
                                    <form class="form-inline">
                                    <div class="clearfix">
                                        <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">First Name</label>
                                            <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter Your First Name">
                                          </div><!-- form-group ends here -->
                                        </div>

                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Last Name</label>
                                            <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter Your Last Name">
                                          </div><!-- form-group ends here -->
                                        </div>
                                        </div>
                                        <div class="clearfix">
                                        <div class="col-md-8 mar-top-10 email-box">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Email</label>
                                            <input type="email" class="form-control" id="exampleInputName2" placeholder="Enter Your email">

                                            <a href="#">
                                              <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                          </div><!-- form-group ends here -->
                                        </div>
                                       </div> 

                                       <div class="clearfix">
                                        <div class="col-md-4 mar-top-10 dob">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Date of Birth</label>
                                            <input type="date" class="form-control" id="exampleInputDOB1" placeholder="Date of Birth">
                                          </div><!-- form-group ends here -->
                                        </div>

                                        <div class="col-md-8 mar-top-10 phone">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Phone</label>
                                            <input type="phone" class="form-control" id="exampleInputName2" placeholder="Enter Your Last Name">
                                           </div><!-- form-group ends here -->

                                           <a href="#">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                                </a>
                                        </div>
                                       </div> 

                                       <div class="clearfix">
                                          <div class="col-md-4 mar-top-10 address">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Address</label>
                                              <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter Address">
                                            </div><!-- form-group ends here -->
                                          </div>


                                          <div class="col-md-4 mar-top-10 country">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Country</label>
                                              <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter Country">
                                            </div><!-- form-group ends here -->
                                          </div>


                                          <div class="col-md-4 mar-top-10 zip">
                                            <div class="form-group">
                                              <label for="exampleInputName2">Zip code</label>
                                              <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter zip code">
                                            </div><!-- form-group ends here -->
                                          </div>
                                        </div>
                                    </form>
                                </div><!-- panel-body ends here -->
                            </div>
                        </div>
                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Educational Information
                                <span class="glyphicon glyphicon-plus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="form-inline">
                                    <div class="clearfix">

                                      <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Subject</label>
                                            
                                            <select class="form-control">
                                                <option>Mathematics</option>
                                                <option>Science</option>
                                                <option>Geogrophy</option>
                                            </select>
                                          </div><!-- form-group ends here -->
                                        </div>


                                        <div class="col-md-4">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Qualification</label>
                                            
                                            <select class="form-control">
                                                <option>Diploma</option>
                                                <option>Bachelor Degree</option>
                                                <option>Masters Degree</option>
                                            </select>

                                          </div><!-- form-group ends here -->
                                        </div>

                                        
                                        <a href="#" class="mar-top-10">
                                          <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                        </div>
                                        <div class="clearfix">
                                        
                                    </div>

                                    <div class="clearfix">
                                    <div class="col-md-6 mar-top-20 choose-file">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Certificate</label>
                                                <input type="file" id="exampleInputFile"  class="display-inline">
                                              </div>
                                        </div>
                                    </div>
                                    </form>
                            </div><!-- panel-body second collapse ends here -->
                          </div>
                        </div>
                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">About Tutor
                                <span class="glyphicon glyphicon-plus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="form-inline">
                                <textarea class="form-control" rows="3" placeholder="Please provide brief information about yourself."></textarea>
                                </form>
                            </div><!-- panel-body ends here -->
                          </div>
                        </div>


                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Subjects
                                <span class="glyphicon glyphicon-plus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="form-inline">
                                    <div class="clearfix">
                                        
                                    </div>

                                    <div class="clearfix">

                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="exampleInputName2">Subject</label>
                                            <select class="form-control">
                                                <option>Mathematics</option>
                                                <option>Science</option>
                                                <option>Geogrophy</option>
                                            </select>
                                          </div><!-- form-group ends here -->
                                    </div>

                                    <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="exampleInputName2">Language</label>
                                        <select class="form-control">
                                                <option>English</option>
                                                <option>Chinese</option>
                                                <option>Spanish</option>
												<option>Hindi</option>
                                            </select>
                                      </div><!-- form-group ends here -->
                                    </div>

                                     <div class="col-md-2">
                                          <div class="form-group">
                                            <label for="exampleInputName2">Grade</label>
                                            
                                            <select class="form-control">
                                                <option>Grade 1</option>
                                                <option>Grade 2</option>
                                                <option>Grade 3</option>
                                            </select>
                                          </div><!-- form-group ends here -->
                                        </div>
                                  <a href="#" class="mar-top-10">
                                    <span class="glyphicon glyphicon-plus"></span>
                                  </a>

                                  </div>
                                </form>
                            </div><!-- panel-body ends here -->
                          </div>
                        </div>

                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Video Upload
                                <span class="glyphicon glyphicon-plus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="form-inline">
                                <p>Please upload a sample video tutorial here. (minimum 1min duration)</p>

                                <div class="form-group mar-top-10">
                                                <label for="exampleInputFile">File input</label>
                                                <input type="file" id="exampleInputFile"  class="display-inline">
                                              </div>
                          
                                <!-- <div class="embed-responsive embed-responsive-16by9">
                                  <iframe class="embed-responsive-item" src="..."></iframe>
                                </div> -->
                                </form>
                            </div><!-- panel-body ends here -->
                          </div>
                        </div>

                        <div class="panel panel-default box-one">
                          <div class="panel-heading box-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Hourly Rate
                                <span class="glyphicon glyphicon-plus"></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse6" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="form-inline">
                                <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputName2">Hourly Charge</label>
                                  <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter hourly charge">
                                </div><!-- form-group ends here -->
                              </div>

                                <div class="col-md-2">
                                          <div class="form-group">
                                            <select class="form-control">
                                                <option>Select Currency</option>
                                                <option>INR</option>
                                                <option>SGD</option>
                                            </select>
                                          </div><!-- form-group ends here -->
                                        </div>
                                </form>
                            </div><!-- panel-body ends here -->
                          </div>
                        </div>

                      </div>
                        </div> 
                        <div class="text-right mar-top-bottom-10">
                            <button type="button" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-menu-ok"></span>
                                Save</button>
                        </div>
  
                        </article><!-- personal information ends here -->
                    </div>
            </section><!-- mid section ends here -->


            <?php get_footer(); ?>