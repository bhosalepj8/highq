<?php function myaccount_student_form_fields(){
 ob_start(); 
 $site_url= get_site_url();
 if ( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;
            $current_user_meta = get_user_meta($user_id);
//            print_r($current_user_meta);

        }
//        print_r(get_woocommerce_currencies());
 ?>

<section class="student-registration clearfix">
                    <div class="box-one history clearfix">
            <div class="box-heading">
                            <h4>History</h4>
                          </div>
                        <div class="history-table">
                                <div class="form-inline clearfix">
                                <div class="col-md-12 date-time">
                                <label>From</label>
                            <p class="field-para">
                                <input id="history_tutor_from_date" class="form-control" name="history_tutor_from_date" type="text" onchange="" placeholder="Select From Date">
                                 <span class="glyphicon glyphicon-calendar"></span> 
                                <input id="history_tutor_to_date" class="form-control" name="history_tutor_to_date" type="text" onchange="" placeholder="Select From Date">
                                 <span class="glyphicon glyphicon-calendar"></span> 
                                <select class="select">
                                        <!--<optgroup>-->
                                        <option>-Status-</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Pending">Pending</option>
                                    <!--</optgroup>-->
                                </select>
                                <a class="" href="">MTD</a> &nbsp; <a class="" href="">YTD</a>
                            </p>
                         </div>
                         <br/>
<!--                         <div class="col-md-8">
                                <label>Total Amount Received from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $200/-
                             </p>
                         </div>

                         <br/>
                         <div class="col-md-8">
                                <label>Total Amount Pending from</label>
                             <p class="field-para">
                                <span>00/00/0000</span> to <span>00/00/0000</span> - $75/-
                             </p>
                         </div>-->
          <div class="col-md-12">
                <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Name Of Course</th>
                    <th>No of Student</th>
                    <th>Total Amount($)</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">03-02-2017</th>
                    <td>Mathematics</td>
                    <td>1</td>
                    <td>21</td>
                    <td>Paid</td>
                  </tr>
                </tbody>
              </table>
                          </div>
                            </div>
                        </div>
                  </div> 
            </section>

<?php 
return ob_get_clean();
}
